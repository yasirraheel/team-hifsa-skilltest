@forelse($lessons as $key => $item)
    @php
        $lessonIndex = $lessonOrderMap[$item->id] ?? (($lessonStartIndex ?? 1) + $key);
    @endphp
    <li class="list-group-item lesson-row d-flex flex-column align-items-stretch"
        data-lesson-id="{{ $item->id }}"
        data-completed="{{ !empty($isEnrolled) && in_array($item->id, $completedLessonIds ?? []) ? 1 : 0 }}">
        <div class="d-flex align-items-center lesson-head w-100"
            onclick="lessonPreview(event, this, {{ @$course->id }}, {{ $item->id }})">
            <i class="fa-regular fa-circle-play pre-i me-2 flex-shrink-0" aria-hidden="true"></i>
            <span class="lesson-title text-truncate">{{ __($item->title) }}</span>
        </div>
        <div class="lesson-actions lesson-actions-bar mt-2 w-100">
            <div class="d-flex align-items-center gap-2 flex-nowrap lesson-actions-meta">
            @if ($item->value == 0)
                <p class="mb-0 text-nowrap lesson-tier">@lang('Free') <i class="fa-solid fa-lock-open"></i></p>
            @else
                <p class="mb-0 text-nowrap lesson-tier">@lang('Premium') <i class="fa-solid fa-lock"></i></p>
            @endif
            @if (!empty($isEnrolled) && in_array($item->id, $completedLessonIds ?? []))
                <span class="lesson-completed flex-shrink-0" role="img" aria-label="@lang('Completed')">
                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                </span>
            @endif
            <span class="text-muted small ms-auto flex-shrink-0" style="font-size: 0.85rem;">{{ $lessonIndex }}/{{ $totalLessonsCount ?? '?' }}</span>
            </div>
            @if (!empty($isEnrolled) && in_array($item->id, $completedLessonIds ?? []))
                <button type="button" class="btn btn-sm btn--base outline lesson-uncomplete-btn flex-shrink-0" data-lesson-id="{{ $item->id }}" data-course-id="{{ $course->id }}" title="@lang('Undo completion')">
                    @lang('Undo')
                </button>
            @elseif (!empty($isEnrolled))
                <button type="button" class="btn btn-sm btn--base lesson-mark-complete-btn flex-shrink-0" data-lesson-id="{{ $item->id }}" data-course-id="{{ $course->id }}" data-default-html="{{ e(__('Mark Completed')) }}">
                    @lang('Mark Completed')
                </button>
            @endif
        </div>

        @if (!empty($isEnrolled))
            <div class="lesson-notes mt-3">
                <h6 class="mb-2">@lang('Lesson Notes')</h6>
                <div id="lesson-notes-{{ $item->id }}" class="lesson-notes-list">
                    @if(isset($lessonNotes[$item->id]) && count($lessonNotes[$item->id]))
                        @foreach($lessonNotes[$item->id] as $note)
                            <div class="note-card mb-2 p-2 rounded border" id="note-{{ $note->id }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">{{ showDateTime($note->created_at) }}</small>
                                    <div class="note-actions gap-1 d-flex">
                                        <button type="button" class="btn btn-sm btn--base outline lesson-note-edit-btn" data-note-id="{{ $note->id }}" data-lesson-id="{{ $item->id }}" title="@lang('Edit note')">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn--danger lesson-note-delete-btn" data-note-id="{{ $note->id }}" title="@lang('Delete note')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="note-content">{!! $note->content !!}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-muted small">@lang('No notes yet for this lesson')</div>
                    @endif
                </div>

                <button type="button" class="btn btn--base btn--sm mt-2 lesson-note-toggle-btn" data-lesson-id="{{ $item->id }}" data-course-id="{{ $course->id }}">@lang('Add Note')</button>

                <div id="lesson-note-wrap-{{ $item->id }}" class="lesson-note-editor-wrap mt-2 d-none">
                    <textarea id="lesson-note-editor-{{ $item->id }}" class="form--control trumEdit" data-lesson-id="{{ $item->id }}" data-course-id="{{ $course->id }}" placeholder="@lang('Write your note')"></textarea>
                    <div class="mt-2 gap-2 d-flex">
                        <button type="button" class="btn btn--base btn--sm lesson-note-add-btn" data-lesson-id="{{ $item->id }}" data-course-id="{{ $course->id }}">@lang('Save Note')</button>
                        <button type="button" class="btn btn--base outline btn--sm lesson-note-cancel-add-btn" data-lesson-id="{{ $item->id }}">@lang('Cancel')</button>
                    </div>
                    <div class="lesson-note-status text-success mt-2 d-none" id="lesson-note-status-{{ $item->id }}"></div>
                    <div class="lesson-note-error text-danger mt-2 d-none" id="lesson-note-error-{{ $item->id }}"></div>
                </div>
            </div>
        @endif
    </li>
@empty
    <tr>
        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage ?? 'No lessons found') }}</td>
    </tr>
@endforelse
