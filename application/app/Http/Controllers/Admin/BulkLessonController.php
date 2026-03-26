<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Jobs\ProcessBulkLessonImport;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BulkLessonController extends Controller
{
    public function create()
    {
        $pageTitle = 'Add Bulk Lessons';
        $courses = Course::adminCourseCategories()->get();
        return view('admin.lessons.bulk', compact('pageTitle', 'courses'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'course_id' => 'required|numeric',
            'level' => 'required|in:1,2,3',
            'value' => 'required|in:0,1',
            'youtube_url' => 'required|string',
            'description' => 'nullable|string',
            'import_comments' => 'nullable|in:0,1',
            'comments_limit' => 'nullable|integer|min:0|max:100',
        ]);

        $apiKey = env('YOUTUBE_API_KEY');
        if (!$apiKey) {
            $notify[] = ['error', 'Missing YOUTUBE_API_KEY in .env'];
            return back()->withNotify($notify);
        }

        $runId = (string) Str::uuid();

        // Dispatch job to process bulk import asynchronously
        ProcessBulkLessonImport::dispatch(
            $request->all(),
            auth('admin')->id(),
            $runId
        );

        $notify[] = ['success', 'Bulk lesson import has been queued for processing. You will receive updates via logs. Run ID: ' . $runId];
        return back()->withNotify($notify);
    }

    private function detectYouTubeSource(string $url): ?array
    {
        $url = trim($url);
        if ($url === '') return null;

        $parts = parse_url($url);
        if (!$parts || empty($parts['host'])) return null;

        $host = strtolower($parts['host']);
        $path = $parts['path'] ?? '';
        $query = [];
        parse_str($parts['query'] ?? '', $query);

        if (isset($query['list']) && is_string($query['list']) && $query['list'] !== '') {
            return ['type' => 'playlist', 'playlist_id' => $query['list']];
        }

        if (Str::contains($host, 'youtu.be')) {
            $videoId = trim($path, '/');
            if ($videoId !== '') {
                return ['type' => 'video', 'video_id' => $videoId];
            }
        }

        if (Str::contains($host, 'youtube.com')) {
            if (Str::startsWith($path, '/watch') && !empty($query['v'])) {
                return ['type' => 'video', 'video_id' => $query['v']];
            }
            if (preg_match('~^/(shorts|embed)/([^/?]+)~', $path, $m)) {
                return ['type' => 'video', 'video_id' => $m[2]];
            }
            if (Str::startsWith($path, '/playlist') && !empty($query['list'])) {
                return ['type' => 'playlist', 'playlist_id' => $query['list']];
            }
            if (preg_match('~^/channel/([^/?]+)~', $path, $m)) {
                return ['type' => 'channel', 'channel_id' => $m[1]];
            }
            if (preg_match('~^/@([^/?]+)~', $path, $m)) {
                return ['type' => 'channel_handle', 'handle' => $m[1]];
            }
            if (preg_match('~^/user/([^/?]+)~', $path, $m)) {
                return ['type' => 'channel_user', 'username' => $m[1]];
            }
            if (preg_match('~^/c/([^/?]+)~', $path, $m)) {
                return ['type' => 'channel_custom', 'query' => $m[1]];
            }
        }

        return null;
    }

    private function fetchVideoById(string $videoId, string $apiKey, string $runId): ?array
    {
        $resp = $this->youtubeGet('https://www.googleapis.com/youtube/v3/videos', [
            'part' => 'snippet',
            'id' => $videoId,
            'key' => $apiKey,
        ], $runId, ['op' => 'videos', 'video_id' => $videoId]);

        if (!$resp['ok']) return null;
        $json = $resp['json'];
        $item = $json['items'][0] ?? null;
        if (!$item) return null;

        $snippet = $item['snippet'] ?? [];
        $title = $snippet['title'] ?? $videoId;
        $description = $snippet['description'] ?? '';
        $thumb = $this->pickBestThumbnailUrl($snippet['thumbnails'] ?? []);

        return [
            'video_id' => $videoId,
            'title' => $title,
            'description' => $description,
            'thumbnail' => $thumb,
            'url' => 'https://www.youtube.com/watch?v=' . $videoId,
        ];
    }

    private function importFromPlaylist(string $playlistId, Request $request, \HTMLPurifier $purifier, string $apiKey, bool $importComments, int $commentsLimit, string $runId): array
    {
        $pageToken = null;
        $created = 0;
        $failed = 0;
        $stoppedEarly = false;
        $stopReason = null;

        do {
            $params = [
                'part' => 'snippet',
                'playlistId' => $playlistId,
                'maxResults' => 50,
                'key' => $apiKey,
            ];
            if ($pageToken) $params['pageToken'] = $pageToken;

            $resp = $this->youtubeGet('https://www.googleapis.com/youtube/v3/playlistItems', $params, $runId, [
                'op' => 'playlistItems',
                'playlist_id' => $playlistId,
                'page_token' => $pageToken,
            ]);
            if (!$resp['ok']) {
                $stoppedEarly = true;
                $stopReason = $resp['error'] ?: 'YouTube API request failed';
                break;
            }

            $json = $resp['json'];
            foreach (($json['items'] ?? []) as $item) {
                $snippet = $item['snippet'] ?? [];
                $resourceId = $snippet['resourceId'] ?? [];
                $videoId = $resourceId['videoId'] ?? null;
                if (!$videoId) continue;

                $video = [
                    'video_id' => $videoId,
                    'title' => $snippet['title'] ?? $videoId,
                    'description' => $snippet['description'] ?? '',
                    'thumbnail' => $this->pickBestThumbnailUrl($snippet['thumbnails'] ?? []),
                    'url' => 'https://www.youtube.com/watch?v=' . $videoId,
                ];

                $ok = $this->createLessonFromVideo($video, $request, $purifier, $apiKey, $importComments, $commentsLimit, $runId);
                $ok ? $created++ : $failed++;
            }

            $pageToken = $json['nextPageToken'] ?? null;
        } while ($pageToken);

        return [
            'created' => $created,
            'failed' => $failed,
            'stopped_early' => $stoppedEarly,
            'stop_reason' => $stopReason,
        ];
    }

    private function importFromChannel(string $channelId, Request $request, \HTMLPurifier $purifier, string $apiKey, bool $importComments, int $commentsLimit, string $runId): array
    {
        $resp = $this->youtubeGet('https://www.googleapis.com/youtube/v3/channels', [
            'part' => 'contentDetails',
            'id' => $channelId,
            'key' => $apiKey,
        ], $runId, ['op' => 'channels.contentDetails', 'channel_id' => $channelId]);
        if (!$resp['ok']) {
            return [
                'created' => 0,
                'failed' => 0,
                'stopped_early' => true,
                'stop_reason' => $resp['error'] ?: 'YouTube API request failed',
            ];
        }

        $json = $resp['json'];
        $item = $json['items'][0] ?? null;
        $uploads = $item['contentDetails']['relatedPlaylists']['uploads'] ?? null;
        if (!$uploads) {
            return [
                'created' => 0,
                'failed' => 0,
                'stopped_early' => true,
                'stop_reason' => 'Unable to find uploads playlist for channel',
            ];
        }

        return $this->importFromPlaylist($uploads, $request, $purifier, $apiKey, $importComments, $commentsLimit, $runId);
    }

    private function resolveChannelIdFromSource(array $source, string $apiKey, string $runId): ?string
    {
        if (($source['type'] ?? null) === 'channel_handle' && !empty($source['handle'])) {
            $handle = (string) $source['handle'];
            $resp = $this->youtubeGet('https://www.googleapis.com/youtube/v3/channels', [
                'part' => 'id',
                'forHandle' => $handle,
                'key' => $apiKey,
            ], $runId, ['op' => 'channels.forHandle', 'handle' => $handle]);
            if ($resp['ok']) {
                $json = $resp['json'];
                $id = $json['items'][0]['id'] ?? null;
                if ($id) return $id;
            }

            return $this->searchChannelId($handle, $apiKey, $runId);
        }

        if (($source['type'] ?? null) === 'channel_user' && !empty($source['username'])) {
            $username = (string) $source['username'];
            $resp = $this->youtubeGet('https://www.googleapis.com/youtube/v3/channels', [
                'part' => 'id',
                'forUsername' => $username,
                'key' => $apiKey,
            ], $runId, ['op' => 'channels.forUsername', 'username' => $username]);
            if ($resp['ok']) {
                $json = $resp['json'];
                $id = $json['items'][0]['id'] ?? null;
                if ($id) return $id;
            }

            return $this->searchChannelId($username, $apiKey, $runId);
        }

        if (($source['type'] ?? null) === 'channel_custom' && !empty($source['query'])) {
            return $this->searchChannelId((string) $source['query'], $apiKey, $runId);
        }

        return null;
    }

    private function searchChannelId(string $query, string $apiKey, string $runId): ?string
    {
        $resp = $this->youtubeGet('https://www.googleapis.com/youtube/v3/search', [
            'part' => 'snippet',
            'type' => 'channel',
            'maxResults' => 1,
            'q' => $query,
            'key' => $apiKey,
        ], $runId, ['op' => 'search.channel', 'q' => $query]);
        if (!$resp['ok']) return null;
        $json = $resp['json'];
        return $json['items'][0]['id']['channelId'] ?? null;
    }

    private function pickBestThumbnailUrl(array $thumbnails): ?string
    {
        foreach (['maxres', 'standard', 'high', 'medium', 'default'] as $key) {
            if (!empty($thumbnails[$key]['url'])) {
                return $thumbnails[$key]['url'];
            }
        }
        return null;
    }

    private function downloadThumbnail(string $url, string $runId): ?string
    {
        $resp = $this->youtubeGet($url, [], $runId, ['op' => 'thumbnail'], true);
        if (!$resp['ok']) return null;

        $dir = getFilePath('lesson_image');
        if (!file_exists($dir)) {
            fileManager()->makeDirectory($dir);
        }

        $filename = uniqid() . time() . '.jpg';
        $path = $dir . '/' . $filename;
        file_put_contents($path, $resp['body']);
        return $filename;
    }

    private function fetchVideoComments(string $videoId, string $apiKey, int $limit, string $runId): array
    {
        $comments = [];
        $pageToken = null;

        while (count($comments) < $limit) {
            $maxResults = min(100, $limit - count($comments));
            $params = [
                'part' => 'snippet',
                'videoId' => $videoId,
                'maxResults' => $maxResults,
                'textFormat' => 'plainText',
                'key' => $apiKey,
            ];
            if ($pageToken) $params['pageToken'] = $pageToken;

            $resp = $this->youtubeGet('https://www.googleapis.com/youtube/v3/commentThreads', $params, $runId, [
                'op' => 'commentThreads',
                'video_id' => $videoId,
                'page_token' => $pageToken,
            ]);
            if (!$resp['ok']) break;

            $json = $resp['json'];
            foreach (($json['items'] ?? []) as $item) {
                $top = $item['snippet']['topLevelComment']['snippet'] ?? null;
                if (!$top) continue;
                $comments[] = [
                    'author' => $top['authorDisplayName'] ?? null,
                    'text' => $top['textDisplay'] ?? null,
                    'likeCount' => $top['likeCount'] ?? null,
                    'publishedAt' => $top['publishedAt'] ?? null,
                ];
                if (count($comments) >= $limit) break;
            }

            $pageToken = $json['nextPageToken'] ?? null;
            if (!$pageToken) break;
        }

        return $comments;
    }

    private function createLessonFromVideo(array $video, Request $request, \HTMLPurifier $purifier, string $apiKey, bool $importComments, int $commentsLimit, string $runId): bool
    {
        $videoId = $video['video_id'] ?? null;
        try {
            $lesson = new Lesson();
            $lesson->title = (string) ($video['title'] ?? $videoId ?? 'Untitled');
            $lesson->owner_id = auth('admin')->id();
            $lesson->owner_type = 1;
            $lesson->course_id = $request->course_id;
            $lesson->preview_video = 2;
            $lesson->video_url = $video['url'] ?? null;
            $lesson->level = $request->level;
            $lesson->value = $request->value;
            $lesson->upload_video = null;

            $description = $request->description;
            if (!is_string($description) || trim($description) === '') {
                $description = $video['description'] ?? '';
            }
            $lesson->description = $purifier->purify($description);
            $lesson->status = 1;

            $lesson->youtube_video_id = $videoId;
            $lesson->youtube_title = $video['title'] ?? null;

            $thumbnailUrl = $video['thumbnail'] ?? null;
            if ($thumbnailUrl) {
                $thumbnailFile = $this->downloadThumbnail($thumbnailUrl, $runId);
                if ($thumbnailFile) {
                    $lesson->image = $thumbnailFile;
                    $lesson->youtube_thumbnail = $thumbnailFile;
                }
            }

            if ($importComments && $commentsLimit > 0 && !empty($videoId)) {
                $comments = $this->fetchVideoComments($videoId, $apiKey, $commentsLimit, $runId);
                $lesson->youtube_comments = json_encode($comments);
            } else {
                $lesson->youtube_comments = json_encode([]);
            }

            $lesson->save();

            if (($lesson->id ?? null) && (($lesson->id % 20) === 0)) {
                Log::info('bulk_lessons.youtube_import.progress', [
                    'run_id' => $runId,
                    'last_lesson_id' => $lesson->id,
                    'video_id' => $videoId,
                ]);
            }

            return true;
        } catch (\Throwable $e) {
            Log::warning('bulk_lessons.youtube_import.video_failed', [
                'run_id' => $runId,
                'video_id' => $videoId,
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }

    private function youtubeGet(string $url, array $params, string $runId, array $context = [], bool $rawBody = false): array
    {
        $safeParams = $params;
        if (isset($safeParams['key'])) {
            unset($safeParams['key']);
        }

        try {
            $client = Http::retry(2, 500)->timeout(30);
            $resp = $client->get($url, $params);
            if (!$resp->ok()) {
                $error = null;
                $json = null;
                try {
                    $json = $resp->json();
                    $error = $json['error']['message'] ?? null;
                } catch (\Throwable $e) {
                }

                Log::warning('bulk_lessons.youtube_import.http_error', [
                    'run_id' => $runId,
                    'url' => $url,
                    'params' => $safeParams,
                    'context' => $context,
                    'status' => $resp->status(),
                    'error' => $error,
                ]);

                return [
                    'ok' => false,
                    'status' => $resp->status(),
                    'error' => $error ?: 'Request failed',
                    'json' => $json,
                    'body' => $rawBody ? $resp->body() : null,
                ];
            }

            return [
                'ok' => true,
                'status' => $resp->status(),
                'error' => null,
                'json' => $rawBody ? null : $resp->json(),
                'body' => $rawBody ? $resp->body() : null,
            ];
        } catch (\Throwable $e) {
            Log::error('bulk_lessons.youtube_import.http_exception', [
                'run_id' => $runId,
                'url' => $url,
                'params' => $safeParams,
                'context' => $context,
                'message' => $e->getMessage(),
            ]);
            return [
                'ok' => false,
                'status' => null,
                'error' => $e->getMessage(),
                'json' => null,
                'body' => null,
            ];
        }
    }
}
