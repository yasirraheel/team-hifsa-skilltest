@extends('admin.layouts.app')

@section('panel')
    <div class="row">
    
        <div class="col-md-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="lesson-table-toolbar">
                        <div class="lesson-table-toolbar__left">
                            <button type="button" class="btn btn-sm lesson-copy-btn" id="copySelectedYoutubeLinks" disabled>
                                <i class="fa-solid fa-copy"></i> @lang('Copy Selected YT Links')
                            </button>
                            <button type="button" class="btn btn-sm lesson-download-btn" id="openSelectedDownsubLinks" disabled>
                                <i class="fa-solid fa-download"></i> @lang('Downsub Selected')
                            </button>
                            <span class="lesson-selection-count">
                                <span id="selectedLessonCount">0</span> @lang('Selected')
                            </span>
                        </div>
                        <p class="lesson-table-toolbar__note mb-0">
                            @lang('Select lessons on this page to copy stored YouTube links or open Downsub in bulk.')
                        </p>
                    </div>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table lesson-table">
                            <thead>
                                <tr>
                                    <th class="lesson-title-heading">
                                        <span class="lesson-title-heading__inner">
                                            <input type="checkbox" class="form-check-input lesson-select-all lesson-title-select"
                                                id="lessonSelectAll">
                                            <span>@lang('Title')</span>
                                        </span>
                                    </th>
                                    <th class="lesson-category-heading">@lang('Category')</th>
                                    <th class="text-center lesson-created-heading">@lang('Created at')</th>
                                    <th class="text-center lesson-status-heading">@lang('Status')</th>
                                    <th class="text-center lesson-action-heading">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lessons as $item)
                                    <tr>
                                        <td class="lesson-title-cell">
                                            <span class="lesson-title-content">
                                                <input type="checkbox" class="form-check-input lesson-select-item lesson-title-select"
                                                    value="{{ $item->id }}" data-video-url="{{ $item->video_url ?? '' }}">
                                                <span class="lesson-title-index">{{ $lessons->firstItem() + $loop->index }}.</span>
                                                <span class="lesson-title-text">
                                                    <span class="d-block">{{ __(@$item->title) }}</span>
                                                    <span class="lesson-activity-flags">
                                                        <span class="lesson-copy-flag d-none" data-copy-flag="{{ $item->id }}">
                                                            @lang('Copied recently')
                                                        </span>
                                                        <span class="lesson-download-flag d-none" data-download-flag="{{ $item->id }}">
                                                            @lang('Downloaded recently')
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </td>
                                        <td class="lesson-category-cell">
                                            <span class="lesson-category-text" title="{{ __(@$item->course_category?->name) }}">
                                                {{ __(@$item->course_category?->name) }}
                                            </span>
                                        </td>


                                        <td class="text-center lesson-created-cell">
                                            {{ showDateTime($item->created_at) }} <br>
                                            {{ diffForHumans($item->created_at) }}
                                        </td>


                                        <td class="text-center lesson-status-cell">
                                            @if ($item->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Pending')</span>
                                            @endif
                                        </td>


                                        <td class="text-center lesson-action-cell">
                                            <div class="button--group text-center lesson-action-buttons">
                                                @if ($item->video_url)
                                                    <button type="button" class="btn btn-sm lesson-copy-single lesson-action-btn"
                                                        data-lesson-id="{{ $item->id }}"
                                                        data-video-url="{{ $item->video_url }}"
                                                        title="@lang('Copy YT URL')">
                                                        <i class="fa-solid fa-copy"></i>
                                                    </button>
                                                    <a class="btn btn-sm lesson-download-single lesson-action-btn"
                                                        data-lesson-id="{{ $item->id }}"
                                                        data-video-url="{{ $item->video_url }}"
                                                        href="https://downsub.com/?url={{ urlencode($item->video_url) }}"
                                                        target="_blank" rel="noopener noreferrer"
                                                        title="@lang('Open Downsub')">
                                                        <i class="fa-solid fa-download"></i>
                                                    </a>
                                                @endif
                                                <a class="btn btn-sm btn--primary lesson-action-btn"
                                                    href="{{ route('admin.lesson.edit', $item->id) }}">
                                                    <i class="fa-solid fa-pen"></i></a>
                                                <a class="btn btn-sm btn--danger lesson-action-btn" href="javascript:void(0)"
                                                    data-url="{{ route('admin.lesson.delete', @$item->id) }}"
                                                    onclick="lessonDeleteModal(this)">
                                                    <i class="fa-solid fa-trash"></i></a>
                                                @if ($item->preview_video == 3)
                                                    @php
                                                        $zoomData = @$item->zoom_data;
                                                    @endphp
                                                    <a class="btn btn--success btn-sm lesson-action-btn"
                                                        href="{{ @$zoomData->data?->start_url }}"
                                                        title="@lang('Open live class')">
                                                        <i class="fa-solid fa-video"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    @if ($lessons->hasPages())
                        <div class="card-footer text-end">
                            {{ $lessons->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">@lang('Alert')</h5>
                    <button type="button" class="btn-close btn btn--danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Are you sure? You want delete this course?')</p>
                        <input type="text" hidden name="fileName" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-modal="0"
                            data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary" data-bs-dismiss="modal"
                            data-modal="1">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <div class="lesson-page-actions">
        <a class="btn btn-sm btn--primary create_course_category lesson-page-actions__add"
            href="{{ route('admin.lesson.create') }}"><i class="las la-plus"></i>@lang('Add New')</a>
        <form method="GET" class="lesson-page-actions__filters">
            <div class="input-group lesson-page-actions__search">
                <input type="text" name="search" class="form-control bg--white search-color" placeholder="@lang('Search by Lesson Title')"
                    value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
            <div class="lesson-page-actions__sort">
                <select name="sort" class="form-control bg--white search-color" onchange="this.form.submit()">
                    <option value="newest" {{ ($sort ?? 'newest') == 'newest' ? 'selected' : '' }}>@lang('Newest')</option>
                    <option value="oldest" {{ ($sort ?? 'newest') == 'oldest' ? 'selected' : '' }}>@lang('Oldest')</option>
                </select>
            </div>
        </form>
    </div>
@endpush

@push('style')
    <style>
        .lesson-page-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            align-items: flex-start;
            gap: 16px;
        }

        .lesson-page-actions__add {
            flex: 0 0 auto;
            white-space: nowrap;
            min-height: 44px;
            display: inline-flex;
            align-items: center;
        }

        .lesson-page-actions__filters {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
            max-width: 420px;
        }

        .lesson-page-actions__search,
        .lesson-page-actions__sort {
            width: 100%;
        }

        .lesson-page-actions__sort .form-control,
        .lesson-page-actions__search .form-control,
        .lesson-page-actions__search .input-group-text {
            height: 50px;
        }

        .lesson-title-heading,
        .lesson-title-cell,
        .lesson-title-text,
        .lesson-title-text span {
            text-align: left !important;
            direction: ltr;
        }

        .lesson-table {
            table-layout: fixed;
            width: 100%;
        }

        .lesson-title-heading {
            width: 42%;
        }

        .lesson-title-heading__inner {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .lesson-category-heading {
            width: 14%;
            text-align: left !important;
        }

        .lesson-created-heading {
            width: 140px;
        }

        .lesson-status-heading {
            width: 90px;
        }

        .lesson-action-heading {
            width: 205px;
        }

        .lesson-title-content {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .lesson-title-select {
            flex: 0 0 auto;
            margin-top: 3px;
        }

        .lesson-title-index {
            flex: 0 0 auto;
            min-width: 20px;
            color: #7d8da6;
            font-weight: 600;
        }

        .lesson-title-text {
            flex: 1 1 auto;
            min-width: 0;
        }

        .lesson-title-text > .d-block {
            word-break: break-word;
            line-height: 1.45;
        }

        .lesson-category-cell {
            text-align: left !important;
            padding-left: 0.5rem !important;
        }

        .lesson-category-text {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 13px;
        }

        .lesson-activity-flags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 6px;
        }

        .lesson-copy-flag,
        .lesson-download-flag {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .lesson-copy-flag {
            background: rgba(27, 191, 114, 0.12);
            color: #1bbf72;
        }

        .lesson-download-flag {
            background: rgba(12, 170, 173, 0.12);
            color: #0caaad;
        }

        .lesson-table-toolbar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 24px 24px 16px;
        }

        .lesson-table-toolbar__left {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }

        .lesson-copy-btn {
            background: rgba(12, 170, 173, 0.08);
            border: 1px solid rgba(12, 170, 173, 0.2);
            color: #0caaad;
            min-height: 42px;
            padding: 0.625rem 1rem;
            white-space: nowrap;
        }

        .lesson-copy-btn:hover,
        .lesson-copy-btn:focus {
            background: #0caaad;
            border-color: #0caaad;
            color: #fff;
        }

        .lesson-copy-btn:disabled {
            background: rgba(12, 170, 173, 0.08);
            border-color: rgba(12, 170, 173, 0.12);
            color: #7d8da6;
            opacity: 1;
            cursor: not-allowed;
        }

        .lesson-download-btn {
            background: rgba(29, 78, 216, 0.08);
            border: 1px solid rgba(29, 78, 216, 0.18);
            color: #1d4ed8;
            min-height: 42px;
            padding: 0.625rem 1rem;
            white-space: nowrap;
        }

        .lesson-download-btn:hover,
        .lesson-download-btn:focus {
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #fff;
        }

        .lesson-download-btn:disabled {
            background: rgba(29, 78, 216, 0.08);
            border-color: rgba(29, 78, 216, 0.12);
            color: #7d8da6;
            opacity: 1;
            cursor: not-allowed;
        }

        .lesson-copy-single {
            background: #f4f6fb;
            border: 1px solid #d9e1ef;
            color: #51688f;
        }

        .lesson-copy-single:hover,
        .lesson-copy-single:focus {
            background: #0caaad;
            border-color: #0caaad;
            color: #fff;
        }

        .lesson-copy-single.is-copied {
            background: #1bbf72;
            border-color: #1bbf72;
            color: #fff;
        }

        .lesson-download-single {
            background: rgba(12, 170, 173, 0.08);
            border: 1px solid rgba(12, 170, 173, 0.18);
            color: #0caaad;
        }

        .lesson-download-single:hover,
        .lesson-download-single:focus {
            background: #0caaad;
            border-color: #0caaad;
            color: #fff;
        }

        .lesson-download-single.is-downloaded {
            background: #0caaad;
            border-color: #0caaad;
            color: #fff;
        }

        .lesson-created-cell {
            font-size: 13px;
            line-height: 1.45;
            white-space: nowrap;
        }

        .lesson-action-cell {
            white-space: nowrap;
        }

        .lesson-action-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
        }

        .lesson-action-btn {
            min-width: 34px;
            padding: 0.34rem 0.5rem;
            margin: 0 !important;
        }

        .lesson-selection-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0.625rem 1rem;
            border-radius: 6px;
            background: #f3f5ff;
            color: #51688f;
            font-weight: 600;
            white-space: nowrap;
        }

        .lesson-table-toolbar__note {
            color: #7d8da6;
            font-size: 0.9375rem;
            text-align: right;
        }

        @media (max-width: 991px) {
            .lesson-page-actions {
                justify-content: flex-start;
            }

            .lesson-page-actions__filters {
                width: 100%;
            }

            .lesson-table-toolbar {
                padding: 20px 16px 14px;
            }

            .lesson-table-toolbar__note {
                text-align: left;
            }
        }
    </style>
@endpush


@push('script')
    <script>
        (function($) {
            "use strict";

            const copiedStateStorageKey = 'adminLessonCopiedYoutubeLinks';
            const downloadedStateStorageKey = 'adminLessonDownloadedYoutubeLinks';
            const copiedStateTtl = 24 * 60 * 60 * 1000;
            const copySuccessText = @json(__('YouTube link(s) copied'));
            const singleCopySuccessText = @json(__('YouTube URL copied'));
            const copyEmptyText = @json(__('No stored YouTube links found in the selected lessons'));
            const copyErrorText = @json(__('Unable to copy YouTube links right now'));
            const copyButtonLabel = @json(__('Copy YT URL'));
            const copiedButtonLabel = @json(__('Copied recently'));
            const downloadButtonLabel = @json(__('Open Downsub'));
            const downloadedButtonLabel = @json(__('Downloaded recently'));
            const bulkDownloadSuccessText = @json(__('Downsub link(s) opened'));

            function lessonDeleteModal(object) {
                var videoModal = $('#videoModal');
                var url = $(object).data('url');
                videoModal.find('form').attr('action', url);
                videoModal.modal('show');
            }

            function getSelectedLessonItems() {
                return $('.lesson-select-item:checked');
            }

            function getLessonVideoUrl(element) {
                return ($(element).data('video-url') || '').toString().trim();
            }

            function getSelectedLessonVideoUrls() {
                return [...new Set(getSelectedLessonItems().map(function() {
                    return getLessonVideoUrl(this);
                }).get().filter(Boolean))];
            }

            function buildDownsubUrl(videoUrl) {
                return `https://downsub.com/?url=${encodeURIComponent(videoUrl)}`;
            }

            function openUrlInNewTab(url) {
                const link = document.createElement('a');
                link.href = url;
                link.target = '_blank';
                link.rel = 'noopener noreferrer';
                link.style.display = 'none';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }

            function syncLessonSelectionState() {
                const selectAll = $('#lessonSelectAll');
                const lessonItems = $('.lesson-select-item');
                const selectedItems = getSelectedLessonItems();
                const selectedCount = selectedItems.length;

                $('#selectedLessonCount').text(selectedCount);
                $('#copySelectedYoutubeLinks').prop('disabled', selectedCount === 0);
                $('#openSelectedDownsubLinks').prop('disabled', selectedCount === 0);

                if (!lessonItems.length) {
                    selectAll.prop({
                        checked: false,
                        indeterminate: false
                    });
                    return;
                }

                selectAll.prop('checked', selectedCount === lessonItems.length);
                selectAll.prop('indeterminate', selectedCount > 0 && selectedCount < lessonItems.length);
            }

            function copyTextToClipboard(text) {
                if (navigator.clipboard && window.isSecureContext) {
                    return navigator.clipboard.writeText(text);
                }

                return new Promise(function(resolve, reject) {
                    const textArea = document.createElement('textarea');
                    textArea.value = text;
                    textArea.style.position = 'fixed';
                    textArea.style.left = '-9999px';
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();

                    try {
                        document.execCommand('copy');
                        resolve();
                    } catch (error) {
                        reject(error);
                    } finally {
                        document.body.removeChild(textArea);
                    }
                });
            }

            function getLessonStateMap(storageKey) {
                try {
                    const savedValue = localStorage.getItem(storageKey);
                    const parsedValue = savedValue ? JSON.parse(savedValue) : {};
                    return parsedValue && typeof parsedValue === 'object' ? parsedValue : {};
                } catch (error) {
                    return {};
                }
            }

            function saveLessonStateMap(storageKey, stateMap) {
                try {
                    localStorage.setItem(storageKey, JSON.stringify(stateMap));
                } catch (error) {
                }
            }

            function pruneLessonStateMap(storageKey) {
                const stateMap = getLessonStateMap(storageKey);
                const now = Date.now();
                const activeEntries = {};

                Object.keys(stateMap).forEach(function(key) {
                    if ((now - Number(stateMap[key])) < copiedStateTtl) {
                        activeEntries[key] = stateMap[key];
                    }
                });

                saveLessonStateMap(storageKey, activeEntries);
                return activeEntries;
            }

            function markLessonAsCopied(lessonId) {
                const copiedMap = pruneLessonStateMap(copiedStateStorageKey);
                copiedMap[String(lessonId)] = Date.now();
                saveLessonStateMap(copiedStateStorageKey, copiedMap);
                syncLessonActivitySignals();
            }

            function markLessonAsDownloaded(lessonId) {
                const downloadedMap = pruneLessonStateMap(downloadedStateStorageKey);
                downloadedMap[String(lessonId)] = Date.now();
                saveLessonStateMap(downloadedStateStorageKey, downloadedMap);
                syncLessonActivitySignals();
            }

            function syncLessonActivitySignals() {
                const copiedMap = pruneLessonStateMap(copiedStateStorageKey);
                const downloadedMap = pruneLessonStateMap(downloadedStateStorageKey);

                $('.lesson-copy-single').each(function() {
                    const button = $(this);
                    const lessonId = String(button.data('lesson-id'));
                    const isCopied = !!copiedMap[lessonId];
                    const icon = button.find('i');

                    button.toggleClass('is-copied', isCopied);
                    button.attr('title', isCopied ? copiedButtonLabel : copyButtonLabel);
                    icon.toggleClass('fa-copy', !isCopied);
                    icon.toggleClass('fa-check', isCopied);
                });

                $('.lesson-download-single').each(function() {
                    const button = $(this);
                    const lessonId = String(button.data('lesson-id'));
                    const isDownloaded = !!downloadedMap[lessonId];
                    const icon = button.find('i');

                    button.toggleClass('is-downloaded', isDownloaded);
                    button.attr('title', isDownloaded ? downloadedButtonLabel : downloadButtonLabel);
                    icon.toggleClass('fa-download', !isDownloaded);
                    icon.toggleClass('fa-check', isDownloaded);
                });

                $('[data-copy-flag]').each(function() {
                    const flag = $(this);
                    flag.toggleClass('d-none', !copiedMap[String(flag.data('copy-flag'))]);
                });

                $('[data-download-flag]').each(function() {
                    const flag = $(this);
                    flag.toggleClass('d-none', !downloadedMap[String(flag.data('download-flag'))]);
                });
            }

            window.lessonDeleteModal = lessonDeleteModal;

            $('#lessonSelectAll').on('change', function() {
                $('.lesson-select-item').prop('checked', $(this).is(':checked'));
                syncLessonSelectionState();
            });

            $(document).on('change', '.lesson-select-item', function() {
                syncLessonSelectionState();
            });

            $('#copySelectedYoutubeLinks').on('click', function() {
                const urls = getSelectedLessonVideoUrls();

                if (!urls.length) {
                    Toast.fire({
                        icon: 'error',
                        title: copyEmptyText
                    });
                    return;
                }

                copyTextToClipboard(urls.join('\n')).then(function() {
                    getSelectedLessonItems().each(function() {
                        if (($(this).data('video-url') || '').toString().trim()) {
                            markLessonAsCopied($(this).val());
                        }
                    });

                    Toast.fire({
                        icon: 'success',
                        title: `${urls.length} ${copySuccessText}`
                    });
                }).catch(function() {
                    Toast.fire({
                        icon: 'error',
                        title: copyErrorText
                    });
                });
            });

            $('#openSelectedDownsubLinks').on('click', function() {
                const selectedItems = getSelectedLessonItems().filter(function() {
                    return !!getLessonVideoUrl(this);
                });
                const urls = [...new Set(selectedItems.map(function() {
                    return getLessonVideoUrl(this);
                }).get())];

                if (!urls.length) {
                    Toast.fire({
                        icon: 'error',
                        title: copyEmptyText
                    });
                    return;
                }

                urls.forEach(function(url) {
                    openUrlInNewTab(buildDownsubUrl(url));
                });

                selectedItems.each(function() {
                    markLessonAsDownloaded($(this).val());
                });

                Toast.fire({
                    icon: 'success',
                    title: `${urls.length} ${bulkDownloadSuccessText}`
                });
            });

            $(document).on('click', '.lesson-copy-single', function() {
                const button = $(this);
                const lessonId = button.data('lesson-id');
                const videoUrl = getLessonVideoUrl(button);

                if (!videoUrl) {
                    Toast.fire({
                        icon: 'error',
                        title: copyEmptyText
                    });
                    return;
                }

                copyTextToClipboard(videoUrl).then(function() {
                    markLessonAsCopied(lessonId);
                    Toast.fire({
                        icon: 'success',
                        title: singleCopySuccessText
                    });
                }).catch(function() {
                    Toast.fire({
                        icon: 'error',
                        title: copyErrorText
                    });
                });
            });

            $(document).on('click', '.lesson-download-single', function() {
                markLessonAsDownloaded($(this).data('lesson-id'));
            });

            syncLessonSelectionState();
            syncLessonActivitySignals();
        })(jQuery);
    </script>
@endpush
