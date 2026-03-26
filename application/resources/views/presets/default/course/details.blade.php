@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!-- product details section -->
    <section class="product-info">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="info-wrap">
                        <div class="product-tag">
                            <p class="tag-name">{{ @$course->category->name }}</p>
                        </div>
                        <h1 class="title">{{ @$course->name }}</h1>
                        <ul class="rating-wrap">
                            @php
                                $averageRatingHtml = calculateAverageRating($course->average_rating);
                                if (!empty($averageRatingHtml['ratingHtml'])) {
                                    echo $averageRatingHtml['ratingHtml'];
                                }
                            @endphp
                            <li>
                                <p> ({{ $course->review_count }} @lang('ratings')) {{ $course->enrolls->count() }}
                                    @lang('Students')</p>
                            </li>
                        </ul>
                        <ul class="key-wrap">
                            <li>
                                <i class="fa-solid fa-clock"></i>
                                <p>{{ str_replace('ago', '', diffForHumans(@$course->created_at)) }}</p>
                            </li>
                            <li>
                                <i class="fa-solid fa-graduation-cap"></i>
                                <p>{{ $course->enrolls->count() }} @lang('Students')</p>
                            </li>

                            <li>
                                <i class="fa-solid fa-file-video"></i>
                                <p>{{ @$course->lessons->count() }} @lang('Lessons')</p>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- product details section -->
    <!-- < product details  -->
    <section class="product-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="key learn">
                        <h1 class="title">@lang("What you'll learn")</h1>
                        <div class="discription">
                            @php
                                echo __($course->learn_description);
                            @endphp
                        </div>
                    </div>
                    <div class="key curriculum">
                        <h1 class="title">@lang('Curriculum')</h1>
                        @if (!empty($isEnrolled))
                            <div class="course-progress-wrap mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="course-progress-text">
                                        @lang('Course Progress'): {{ $courseProgress['completed'] }}/{{ $courseProgress['total'] }}
                                    </span>
                                    <span class="course-progress-percent">{{ $courseProgress['percent'] }}%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $courseProgress['percent'] }}%;"
                                        aria-valuenow="{{ $courseProgress['percent'] }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="discription">
                            @php
                                echo __($course->curriculum);
                            @endphp
                        </div>

                        @if ($course->lessons->count() > 0)
                            <div class="curriculam-list">
                                <form action="{{ route('course.details', [slug($course->name), $course->id]) }}" method="GET" class="d-flex justify-content-end align-items-center flex-wrap gap-2 mb-3">
                                    <label for="lesson-sort-filter" class="me-2 mb-0">@lang('Sort Lessons')</label>
                                    <select id="lesson-sort-filter" name="lesson_sort" class="form-select w-auto lesson-sort-select" onchange="this.form.submit()">
                                        <option value="default" @selected(($lessonSort ?? 'default') === 'default')>@lang('Default')</option>
                                        <option value="completed_first" @selected(($lessonSort ?? 'default') === 'completed_first')>@lang('Completed First')</option>
                                        <option value="pending_first" @selected(($lessonSort ?? 'default') === 'pending_first')>@lang('Pending First')</option>
                                    </select>
                                </form>
                                <ul class="list-group" id="lesson-list">
                                    @include('presets.default.components.lesson_item', ['lessons' => $course->lessons->take(10), 'course' => $course, 'isEnrolled' => $isEnrolled, 'completedLessonIds' => $completedLessonIds, 'lessonNotes' => $lessonNotes])
                                </ul>
                                @php $lessonCount = $course->lessons->count(); @endphp
                                @if ($lessonCount > 10)
                                    <div class="text-center mt-4">
                                        <button type="button" class="btn btn--base" id="load-more-lessons" data-page="2" data-course-id="{{ $course->id }}" data-lesson-sort="{{ $lessonSort ?? 'default' }}">
                                            @lang('Load More Lessons')
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="key requirements">
                        <h1 class="title">@lang('Descriptions')</h1>
                        <div class="discription wyg">
                            @php
                                echo __($course->description);
                            @endphp
                        </div>
                    </div>
                    @if ($course->quizzes->count() > 0)
                        <div class="mb-4">
                            <a href="{{ route('user.quiz.courseQuiz', $course->id) }}"
                                class="btn btn--base">@lang('Quizzes')</a>
                        </div>
                    @endif
                    <div class="key rating">
                        <h1 class="title mb-4"><i class="fa-solid fa-star"></i>({{ $course->average_rating }})
                            @lang('Write a review')</h1>
                        <div class="row gy-4">
                            @forelse ($reviews as $item)
                                <div class="col-lg-6">
                                    <div class="review-card">
                                        <div class="user-info">
                                            <div class="thumb-wrap">
                                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$item->user?->image, getFileSize('userProfile')) }}"
                                                    alt="user_image">
                                            </div>
                                            <div class="user-name">
                                                <h1 class="name">{{ @$item->user?->fullname }}</h1>
                                                <div class="d-flex">
                                                    <ul class="rating-list rating-wrap">
                                                        @php
                                                            $averageRatingHtml = calculateIndividualRating(
                                                                $item->rating,
                                                            );
                                                            if (!empty($averageRatingHtml['ratingHtml'])) {
                                                                echo $averageRatingHtml['ratingHtml'];
                                                            }
                                                        @endphp
                                                        <li>
                                                            <p>({{ __($item->rating) }}.0)</p>
                                                        </li>
                                                    </ul>
                                                    <p class="mx-3">{{ diffForHumans($item->created_at) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <p class="discription">{!! $item->message !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <h5 class="text-center">@lang('No Reviews')</h5>
                            @endforelse
                            <div class="row gy-4">
                                @if ($reviews->hasPages())
                                    <div class="py-4">
                                        {{ paginateLinks($reviews) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- -----------------------------reviews----------------------------- --}}
                    <div class="review-box">
                        <form action="{{ route('user.reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="rating" id="rating" value="0">
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <div class="d-flex">
                                <div>
                                    <h5 class="title-three"> @lang('Giving Rating'):</h5>
                                </div>
                                <div class="rating-wrap rating-stars ps-2">
                                    <div>
                                        <i class="far fa-star" data-rating="1"></i>
                                        <i class="far fa-star" data-rating="2"></i>
                                        <i class="far fa-star" data-rating="3"></i>
                                        <i class="far fa-star" data-rating="4"></i>
                                        <i class="far fa-star" data-rating="5"></i>
                                    </div>
                                </div>
                            </div>

                            <textarea class="form--control" name="message" placeholder="@lang('Write Your Review')" id="message"></textarea>

                            <div class="col-sm-12 mt-4">
                                <button type="submit" class="btn btn--base button w-100">@lang('Submit Review')</button>
                            </div>
                        </form>
                    </div>
                    {{-- -----------------------------reviews end----------------------------- --}}
                </div>
                <div class="col-lg-3">
                    <div class="details-wrap">
                        <div class="details-card1">
                            <div class="thumb-wrap">
                                <img src="{{ getImage(getFilePath('course_image') . '/' . $course->image) }}"
                                    alt="..">
                            </div>
                            <div class="content-wrap">
                                @if (!empty($isEnrolled))
                                <a href="#"
                                class="btn btn--base-3">@lang('Enrolled')
                                 <i class="fa-solid fa-angles-right"></i></a>
                                @else
                                <a href="{{ route('user.enroll.enroll', $course->id) }}"
                                class="btn btn--base-3">@lang('Enroll Now')
                                @if((float) $course->price > 0)
                                    {{ $general->cur_sym . $course->price }}
                                @else
                                    @lang('Free')
                                @endif
                                <i class="fa-solid fa-angles-right"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="details-card2 mt-5">
                            <h1 class="title">@lang('This Course Includes')</h1>
                            <ul class="key-wrap">
                                @foreach ($course->course_outline as $item)
                                    <li>
                                        <i class="fa-solid fa-circle-check"></i>
                                        <p>{{ $item }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="ad-card mt-5">
                            <a href="{{ $ad->link }}">
                                <img src="{{ getImage(getFilePath('ads') . '/' . $ad->image) }}" alt="ads">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- ------------------------------------------- Modal ------------------------------------------- --}}
        <div class="modal fade modal-lg designModal" id="exampleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-body coustom-modal-body custom-video-preview">
                        <div class="modal-btn-wrap d-flex justify-content-end">
                            <button data-bs-dismiss="modal" aria-label="Close" onclick="modalClose()"><i
                                    class="fa-solid fa-xmark "></i></button>
                        </div>
                        <video id="player" playsinline controls data-poster="">
                            <source src="#" type="video/mp4">
                        </video>
                        @if (!empty($isEnrolled))
                            <div class="lesson-complete-actions mt-3 d-flex justify-content-end">
                                <button type="button" class="btn btn--base" id="markLessonCompleteBtn" data-lesson-id="" data-course-id="{{ $course->id }}" data-default-html="{{ e(__('Mark Completed')) }}">
                                    @lang('Mark Completed')
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ------------------------------------------- video url Modal ------------------------------------------- --}}
        <div class="modal fade modal-lg designModal" id="videoUrlModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-end py-1">
                        <div class="modal-btn-wrap">
                            <button data-bs-dismiss="modal" aria-label="Close" onclick="videoUrlModalClose()"><i
                                    class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>

                    <div class="modal-body coustom-modal-body custom-video-preview">

                    </div>
                </div>
            </div>
        </div>

        {{-- ------------------------------------------- Meeting Modal ------------------------------------------- --}}
        <div class="modal fade modal-lg designModal" id="meetingModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title">@lang('Meeting Info')</h5>
                        <div class="modal-btn-wrap">
                            <button data-bs-dismiss="modal" aria-label="Close" onclick="mettingModalClose()"><i
                                    class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>

                    <div class="modal-body coustom-modal-body custom-video-preview mb-2">

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product details  /> -->

@endsection


@push('script-lib')
    <script src="{{ asset('assets/common/js/ckeditor.js') }}"></script>
@endpush

@push('style')
    <style>
        .wyg h1,
        h2,
        h3,
        h4 {
            color: #383838;
        }

        .wyg strong {
            color: #383838
        }

        .wyg p {
            color: #666666
        }

        .wyg ul {
            margin-left: 40px
        }

        .wyg ul li {
            list-style-type: disc;
            color: #666666
        }

        .rating-comment-item .bottom ul {
            color: #ffc107;
        }

        .rating-wrap div {
            color: #ffc107;
        }

        .curriculam-list .lesson-row {
            gap: 0;
        }

        .curriculam-list .lesson-head {
            cursor: pointer;
            min-width: 0;
        }

        .curriculam-list .lesson-completed {
            color: var(--bs-success, #198754);
            font-size: 1.1rem;
            line-height: 1;
        }

        .curriculam-list .lesson-actions-bar {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
        }

        .curriculam-list .lesson-actions-bar .lesson-mark-complete-btn {
            white-space: nowrap;
            height: auto;
            align-self: stretch;
            display: inline-flex;
            align-items: center;
            font-size: inherit;
            line-height: 1.5;
        }

        .curriculam-list .lesson-actions-bar .lesson-uncomplete-btn {
            white-space: nowrap;
            height: auto;
            align-self: stretch;
            display: inline-flex;
            align-items: center;
            font-size: inherit;
            line-height: 1.5;
        }

        .lesson-notes {
            width: 100%;
        }

        .lesson-notes-list .note-card {
            background: var(--white);
            border: 1px solid var(--light);
            border-radius: 6px;
        }

        .lesson-notes .lesson-note-editor {
            min-height: 100px;
            max-height: 200px;
            margin-top: 0.5rem;
        }

        .lesson-notes .lesson-note-toggle-btn,
        .lesson-notes .lesson-note-add-btn {
            height: auto;
            align-self: stretch;
            display: inline-flex;
            align-items: center;
            font-size: inherit;
            line-height: 1.5;
        }

        .note-card .note-actions {
            align-items: center;
        }

        .note-card .lesson-note-edit-btn,
        .note-card .lesson-note-delete-btn {
            padding: 0.25rem 0.5rem;
        }

        .lesson-sort-select {
            min-width: 190px;
            padding-right: 2.35rem;
        }

        @media (max-width: 575.98px) {
            .curriculam-list .lesson-actions-bar {
                flex-wrap: nowrap;
            }

            .curriculam-list .lesson-tier {
                font-size: 0.8125rem;
            }

            .curriculam-list .lesson-actions-bar .lesson-mark-complete-btn,
            .curriculam-list .lesson-actions-bar .lesson-uncomplete-btn {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
                font-size: 0.75rem;
            }
        }
    </style>



    <style>
        /* Modal styles */
        .designModal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 9999;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Modal content */
        .designModal .modal-content {
            width: 100%;
        }

        /* Close button */
        .designModal .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .designModal .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Force CKEditor lists to show in this template (theme may reset list-style globally) */
        .ck-editor__editable ul,
        .ck-editor__editable ol,
        .ck-content ul,
        .ck-content ol,
        .lesson-notes .note-content ul,
        .lesson-notes .note-content ol {
            list-style-position: inside !important;
            margin-left: 1.25rem !important;
            color: #000 !important;
        }

        .ck-editor__editable ul li,
        .ck-editor__editable ol li,
        .ck-content ul li,
        .ck-content ol li,
        .lesson-notes .note-content ul li,
        .lesson-notes .note-content ol li {
            display: list-item !important;
        }

        .ck-editor__editable ul li,
        .ck-content ul li,
        .lesson-notes .note-content ul li {
            list-style-type: disc !important;
        }

        .ck-editor__editable ol li,
        .ck-content ol li,
        .lesson-notes .note-content ol li {
            list-style-type: decimal !important;
        }
    </style>
@endpush

@push('script')
    <script>
    (function ($) {
        'use strict';

        if (!$ || typeof $.fn === 'undefined') {
            console.error('[lesson.complete] jQuery not loaded; mark-complete buttons will not work.');
            return;
        }

        console.info('[lesson.complete] script loaded');

        var isEnrolled = @json(!empty($isEnrolled));
        var completedLessonIds = new Set(@json($completedLessonIds ?? []));
        var pageCourseId = @json($course->id);
        var currentCourseId = null;
        var currentLessonId = null;
        var lessonCompleteInFlight = false;
        var lessonCompleteDebug =
            (typeof window !== 'undefined') &&
            window.location &&
            (window.location.search || '').indexOf('lesson_debug=1') !== -1;
        var lessonSortDebug =
            (typeof window !== 'undefined') &&
            window.location &&
            (window.location.search || '').indexOf('lesson_sort_debug=1') !== -1;

        function lessonCompleteLog() {
            if (!lessonCompleteDebug) return;
            try {
                console.log.apply(console, arguments);
            } catch (e) {}
        }

        function lessonCompleteError() {
            try {
                console.error.apply(console, arguments);
            } catch (e) {}
        }

        function lessonSortLog() {
            if (!lessonSortDebug) return;
            try {
                console.info.apply(console, arguments);
            } catch (e) {}
        }

        var lessonSortType = 'default';

        function setLessonSortType(sortType, source) {
            var normalized = sortType;
            if (normalized !== 'completed_first' && normalized !== 'pending_first') {
                normalized = 'default';
            }

            lessonSortType = normalized;
            $('#lesson-sort-filter').val(normalized);
            $('.lesson-sort-btn').removeClass('active');
            $('.lesson-sort-btn[data-sort="' + normalized + '"]').addClass('active');
            console.log('[lesson.sort] setLessonSortType', {
                source: source || 'unknown',
                type: normalized
            });

            lessonSortLog('[lesson.sort] set type', {
                source: source || 'unknown',
                type: normalized
            });

            applyLessonSort();
        }

        function getDefaultButtonHtml(btn$) {
            var html = btn$.attr('data-default-html');
            if (html) return html;
            return btn$.text() || '';
        }

        var lessonCompleteSpinnerHtml =
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' + @json(__('Processing...'));

        var lessonMarkCompleteLabel = @json(__('Mark Completed'));
        var lessonMarkCompleteDataDefault = @json(e(__('Mark Completed')));
        var lessonUndoLabel = @json(__('Undo'));
        var lessonUndoTitle = @json(__('Undo completion'));

        function buildMarkCompleteBtn(lessonId, courseId) {
            var cid = courseId != null ? courseId : pageCourseId;
            return '<button type="button" class="btn btn-sm btn--base lesson-mark-complete-btn flex-shrink-0" data-lesson-id="' + lessonId + '" data-course-id="' + cid + '" data-default-html="' + lessonMarkCompleteDataDefault + '">' + lessonMarkCompleteLabel + '</button>';
        }

        function buildUndoBtn(lessonId, courseId) {
            var cid = courseId != null ? courseId : pageCourseId;
            return '<button type="button" class="btn btn-sm btn--base outline lesson-uncomplete-btn flex-shrink-0" data-lesson-id="' + lessonId + '" data-course-id="' + cid + '" title="' + lessonUndoTitle + '">' + lessonUndoLabel + '</button>';
        }

        var lessonCompleteListBtnToRestore$ = null;
        var lessonCompleteModalNeedsHtmlRestore = false;

        function resolveActiveCompleteButton$(triggerBtn$) {
            if (triggerBtn$ && triggerBtn$.length) {
                return triggerBtn$;
            }
            var modalBtn$ = $('#markLessonCompleteBtn');
            var exampleModal$ = $('#exampleModal');
            if (exampleModal$.length && exampleModal$.is(':visible') && modalBtn$.length) {
                return modalBtn$;
            }
            if (currentLessonId) {
                var list$ = $('.lesson-mark-complete-btn[data-lesson-id="' + currentLessonId + '"]');
                if (list$.length) {
                    return list$.first();
                }
            }
            return modalBtn$.length ? modalBtn$ : null;
        }

        function setLessonCompleteLoading(isLoading, activeBtn$) {
            lessonCompleteInFlight = !!isLoading;

            var modalBtn$ = $('#markLessonCompleteBtn');
            var activeEl = activeBtn$ && activeBtn$.length ? activeBtn$[0] : null;

            if (isLoading) {
                lessonCompleteListBtnToRestore$ = null;
                lessonCompleteModalNeedsHtmlRestore = false;

                if (!activeEl) {
                    return;
                }

                if (activeBtn$.hasClass('lesson-mark-complete-btn')) {
                    lessonCompleteListBtnToRestore$ = activeBtn$;
                }
                if (modalBtn$.length && modalBtn$[0] === activeEl) {
                    lessonCompleteModalNeedsHtmlRestore = true;
                }

                if (activeBtn$.hasClass('lesson-mark-complete-btn')) {
                    activeBtn$.prop('disabled', true);
                    activeBtn$.html(lessonCompleteSpinnerHtml);
                }

                if (modalBtn$.length) {
                    if (modalBtn$[0] === activeEl) {
                        modalBtn$.prop('disabled', true);
                        modalBtn$.html(lessonCompleteSpinnerHtml);
                    }
                }
                return;
            }

            if (lessonCompleteListBtnToRestore$ && lessonCompleteListBtnToRestore$.length) {
                lessonCompleteListBtnToRestore$.prop('disabled', false);
            }
            if (lessonCompleteListBtnToRestore$ && lessonCompleteListBtnToRestore$.length) {
                lessonCompleteListBtnToRestore$.html(getDefaultButtonHtml(lessonCompleteListBtnToRestore$));
            }
            lessonCompleteListBtnToRestore$ = null;

            if (modalBtn$.length) {
                if (lessonCompleteModalNeedsHtmlRestore) {
                    modalBtn$.prop('disabled', false);
                    modalBtn$.html(getDefaultButtonHtml(modalBtn$));
                }
                lessonCompleteModalNeedsHtmlRestore = false;
            }
            setMarkButtonState();
        }

        function setMarkButtonState() {
            if (lessonCompleteInFlight) return;

            var btn = $('#markLessonCompleteBtn');
            if (!btn.length) return;
            var lessonFromBtn = btn.attr('data-lesson-id');
            var effectiveLessonId = currentLessonId || lessonFromBtn;

            if (!isEnrolled || !effectiveLessonId) {
                btn.prop('disabled', true);
                return;
            }
            if (completedLessonIds.has(parseInt(effectiveLessonId, 10))) {
                btn.prop('disabled', true);
                btn.html(
                    '<span class="lesson-completed d-inline-flex align-items-center" role="img" aria-label="' + @json(__('Completed')) + '">' +
                    '<i class="fa-solid fa-circle-check" aria-hidden="true"></i></span>'
                );
            } else {
                btn.prop('disabled', false);
                btn.html(getDefaultButtonHtml(btn));
            }
        }

        function updateCourseProgressUI(percent, completed, total) {
            $('.course-progress-text').text(@json('Course Progress') + ': ' + completed + '/' + total);
            $('.course-progress-percent').text(percent + '%');
            $('.course-progress-wrap .progress-bar')
                .css('width', percent + '%')
                .attr('aria-valuenow', percent);
        }

        function ensureLessonOrderIndex() {
            var maxOrder = 0;
            $('#lesson-list .list-group-item').each(function() {
                var existing = parseInt($(this).attr('data-sort-order'), 10);
                if (!isNaN(existing) && existing > maxOrder) {
                    maxOrder = existing;
                }
            });

            $('#lesson-list .list-group-item').each(function() {
                var item = $(this);
                var existing = parseInt(item.attr('data-sort-order'), 10);
                if (!isNaN(existing)) return;
                maxOrder += 1;
                item.attr('data-sort-order', maxOrder);
            });
        }

        function isLessonCompleted(row) {
            var completedAttr = row.attr('data-completed');
            if (completedAttr === '1') return true;
            if (completedAttr === '0') return false;

            var lessonId = parseInt(row.attr('data-lesson-id'), 10);
            if (!isNaN(lessonId) && completedLessonIds.has(lessonId)) {
                return true;
            }
            if (row.find('.lesson-uncomplete-btn').length) {
                return true;
            }
            if (row.find('.lesson-mark-complete-btn').length) {
                return false;
            }
            return row.find('.lesson-completed').length > 0;
        }

        function applyLessonSort() {
            var list = $('#lesson-list');
            if (!list.length) return;

            ensureLessonOrderIndex();

            var sortType = lessonSortType || 'default';
            var rows = list.children('.list-group-item').get();
            console.log('[lesson.sort] applyLessonSort start', {
                sortType: sortType,
                rows: rows.length
            });
            lessonSortLog('[lesson.sort] apply start', {
                sortType: sortType,
                rows: rows.length
            });

            rows.sort(function(a, b) {
                var rowA = $(a);
                var rowB = $(b);
                var orderA = parseInt(rowA.attr('data-sort-order'), 10) || 0;
                var orderB = parseInt(rowB.attr('data-sort-order'), 10) || 0;

                if (sortType === 'completed_first' || sortType === 'pending_first') {
                    var completedA = isLessonCompleted(rowA) ? 1 : 0;
                    var completedB = isLessonCompleted(rowB) ? 1 : 0;

                    if (completedA !== completedB) {
                        if (sortType === 'completed_first') {
                            return completedB - completedA;
                        }
                        return completedA - completedB;
                    }
                }

                return orderA - orderB;
            });

            $.each(rows, function(_, row) {
                list.append(row);
            });

            var currentOrder = [];
            list.children('.list-group-item').each(function() {
                var row = $(this);
                currentOrder.push({
                    lessonId: parseInt(row.attr('data-lesson-id'), 10) || null,
                    completed: row.attr('data-completed')
                });
            });
            console.log('[lesson.sort] applyLessonSort done', currentOrder);

            if (lessonSortDebug) {
                var ordered = [];
                list.children('.list-group-item').each(function() {
                    var row = $(this);
                    ordered.push({
                        lessonId: parseInt(row.attr('data-lesson-id'), 10) || null,
                        completed: isLessonCompleted(row)
                    });
                });
                lessonSortLog('[lesson.sort] apply done', ordered);
            }
        }

        function updateLessonCompletedUI(lessonId) {
            var row = $('.curriculam-list .list-group-item[data-lesson-id="' + lessonId + '"]');
            if (!row.length) return;
            if (row.find('.lesson-completed').length) return;
            row.attr('data-completed', '1');
            var actionsMeta = row.find('.lesson-actions-meta').first();
            if (actionsMeta.length) {
                actionsMeta.append(
                    '<span class="lesson-completed flex-shrink-0" role="img" aria-label="' + @json(__('Completed')) + '">' +
                    '<i class="fa-solid fa-circle-check" aria-hidden="true"></i></span>'
                );
            } else {
                row.find('.lesson-title').after(
                    '<span class="lesson-completed ms-2 flex-shrink-0" role="img" aria-label="' + @json(__('Completed')) + '">' +
                    '<i class="fa-solid fa-circle-check" aria-hidden="true"></i></span>'
                );
            }
            row.find('.lesson-uncomplete-btn').remove();
            row.find('.lesson-mark-complete-btn').remove();
            var bar = row.find('.lesson-actions-bar').first();
            if (bar.length) {
                bar.append(buildUndoBtn(lessonId, pageCourseId));
            }
        }

        function updateLessonIncompleteUI(lessonId) {
            var row = $('.curriculam-list .list-group-item[data-lesson-id="' + lessonId + '"]');
            if (!row.length) return;
            row.attr('data-completed', '0');
            row.find('.lesson-completed').remove();
            row.find('.lesson-uncomplete-btn').remove();
            row.find('.lesson-mark-complete-btn').remove();
            var bar = row.find('.lesson-actions-bar').first();
            if (bar.length) {
                bar.append(buildMarkCompleteBtn(lessonId, pageCourseId));
            }
        }

        function resolveLessonCompleteContext() {
            var modalBtn = $('#markLessonCompleteBtn');
            var lessonFromModal = modalBtn.length ? modalBtn.attr('data-lesson-id') : null;
            var courseFromModal = modalBtn.length ? modalBtn.attr('data-course-id') : null;

            var courseId = currentCourseId || pageCourseId || (courseFromModal ? parseInt(courseFromModal, 10) : null);
            var lessonId = currentLessonId || (lessonFromModal ? parseInt(lessonFromModal, 10) : null);

            return {
                courseId: courseId,
                lessonId: lessonId
            };
        }

        function markLessonComplete(triggerBtn$) {
            if (lessonCompleteInFlight) {
                return;
            }

            var ctx = resolveLessonCompleteContext();

            currentCourseId = ctx.courseId;
            currentLessonId = ctx.lessonId;

            if (!isEnrolled || !currentCourseId || !currentLessonId) {
                console.warn('[lesson.complete] blocked: missing context', {
                    isEnrolled: isEnrolled,
                    currentCourseId: currentCourseId,
                    currentLessonId: currentLessonId
                });
                lessonCompleteLog('[lesson.complete] blocked: missing context', {
                    isEnrolled: isEnrolled,
                    currentCourseId: currentCourseId,
                    currentLessonId: currentLessonId
                });
                if (typeof Toast !== 'undefined' && Toast && typeof Toast.fire === 'function') {
                    Toast.fire({ icon: 'info', title: @json('Open a lesson first, then mark it complete.') });
                }
                return;
            }
            if (completedLessonIds.has(parseInt(currentLessonId, 10))) {
                setMarkButtonState();
                return;
            }

            lessonCompleteLog('[lesson.complete] start', {
                url: "{{ route('user.lesson.complete') }}",
                course_id: currentCourseId,
                lesson_id: currentLessonId
            });

            var activeBtn$ = resolveActiveCompleteButton$(triggerBtn$);
            setLessonCompleteLoading(true, activeBtn$);

            $.ajax({
                type: "post",
                url: "{{ route('user.lesson.complete') }}",
                data: {
                    course_id: currentCourseId,
                    lesson_id: currentLessonId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response, textStatus, xhr) {
                    lessonCompleteLog('[lesson.complete] success raw', {
                        http: xhr && xhr.status,
                        textStatus: textStatus,
                        response: response
                    });

                    if (!response || typeof response !== 'object') {
                        lessonCompleteError('[lesson.complete] unexpected response type', response);
                        setLessonCompleteLoading(false);
                        return;
                    }

                    if (response.status === 'success') {
                        completedLessonIds.add(parseInt(response.lesson_id, 10));
                        updateLessonCompletedUI(response.lesson_id);
                        updateCourseProgressUI(response.percent, response.completed, response.total);
                        setMarkButtonState();
                    } else if (response.status === 'error' && response.message) {
                        if (typeof Toast !== 'undefined' && Toast && typeof Toast.fire === 'function') {
                            Toast.fire({
                                icon: 'error',
                                title: response.message
                            });
                        } else {
                            alert(response.message);
                        }
                    } else {
                        lessonCompleteError('[lesson.complete] unexpected success payload', response);
                        if (typeof Toast !== 'undefined' && Toast && typeof Toast.fire === 'function') {
                            Toast.fire({
                                icon: 'error',
                                title: @json('Unexpected response while saving progress')
                            });
                        } else {
                            alert(@json('Unexpected response while saving progress'));
                        }
                    }

                    setLessonCompleteLoading(false);
                },
                error: function(xhr) {
                    var message = @json('Unable to mark lesson complete');
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        try {
                            var firstKey = Object.keys(xhr.responseJSON.errors)[0];
                            var firstErr = xhr.responseJSON.errors[firstKey] && xhr.responseJSON.errors[firstKey][0];
                            if (firstErr) message = firstErr;
                        } catch (e) {}
                    }

                    lessonCompleteError('[lesson.complete] error', {
                        http: xhr && xhr.status,
                        message: message,
                        responseJSON: xhr && xhr.responseJSON,
                        responseText: xhr && xhr.responseText
                    });

                    if (typeof Toast !== 'undefined' && Toast && typeof Toast.fire === 'function') {
                        Toast.fire({
                            icon: 'error',
                            title: message
                        });
                    } else {
                        alert(message);
                    }

                    setLessonCompleteLoading(false);
                },
                complete: function(xhr, textStatus) {
                    lessonCompleteLog('[lesson.complete] complete', {
                        http: xhr && xhr.status,
                        textStatus: textStatus
                    });
                }
            });
        }

        function markLessonIncomplete(triggerBtn$) {
            if (lessonCompleteInFlight) {
                return;
            }
            var $btn = triggerBtn$ && triggerBtn$.length ? triggerBtn$ : null;
            if (!$btn || !$btn.length) return;

            var lessonId = parseInt($btn.attr('data-lesson-id'), 10);
            var courseId = parseInt($btn.attr('data-course-id') || pageCourseId, 10);
            if (!lessonId || !courseId) return;

            lessonCompleteInFlight = true;
            $btn.prop('disabled', true);
            var prevHtml = $btn.html();
            $btn.html(lessonCompleteSpinnerHtml);

            $.ajax({
                type: 'post',
                url: "{{ route('user.lesson.incomplete') }}",
                data: {
                    course_id: courseId,
                    lesson_id: lessonId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (!response || typeof response !== 'object') {
                        lessonCompleteError('[lesson.incomplete] bad response', response);
                        return;
                    }
                    if (response.status === 'success') {
                        completedLessonIds.delete(parseInt(response.lesson_id, 10));
                        updateLessonIncompleteUI(response.lesson_id);
                        updateCourseProgressUI(response.percent, response.completed, response.total);
                    } else if (response.message) {
                        if (typeof Toast !== 'undefined' && Toast && typeof Toast.fire === 'function') {
                            Toast.fire({ icon: 'error', title: response.message });
                        } else {
                            alert(response.message);
                        }
                    }
                },
                error: function(xhr) {
                    var message = @json('Unable to undo lesson completion');
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    if (typeof Toast !== 'undefined' && Toast && typeof Toast.fire === 'function') {
                        Toast.fire({ icon: 'error', title: message });
                    } else {
                        alert(message);
                    }
                },
                complete: function() {
                    lessonCompleteInFlight = false;
                    setMarkButtonState();
                    var $still = $('.lesson-uncomplete-btn[data-lesson-id="' + lessonId + '"]');
                    if ($still.length) {
                        $still.prop('disabled', false);
                        $still.html(lessonUndoLabel);
                    }
                }
            });
        }

        function lessonPreview(e, object, course_id, id) {
            if (e && $(e.target).closest('.lesson-mark-complete-btn, .lesson-uncomplete-btn').length) {
                return;
            }
            currentCourseId = course_id;
            currentLessonId = id;
            $('#markLessonCompleteBtn').attr('data-lesson-id', id);
            $('#markLessonCompleteBtn').attr('data-course-id', course_id);
            setMarkButtonState();

            var uploadPath = "{{ asset(getFilePath('videoUpload')) }}";

            function openLessonTargetBlank(url) {
                if (!url) {
                    return;
                }
                window.open(url, '_blank', 'noopener,noreferrer');
            }

            $.ajax({
                url: "{{ route('lesson.preview') }}",
                type: "POST",
                data: {
                    id: id,
                    course_id: course_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status == 'success' && response.code == 1) {
                        if (response.data.upload_video != null) {
                            openLessonTargetBlank(uploadPath + '/videoUpload/' + response.data.upload_video);
                        } else if (response.data.preview_video == 3 && response.data.upload_video == null) {
                            var startUrl = response.data.zoom_data && response.data.zoom_data.data
                                ? response.data.zoom_data.data.start_url
                                : null;
                            openLessonTargetBlank(startUrl);
                        } else if (parseInt(response.data.preview_video) === 2) {
                            openLessonTargetBlank(response.data.video_url);
                        } else {
                            openLessonTargetBlank(response.data.video_url);
                        }
                    }
                    if (response.status == 'error' && response.code == 0) {
                        Toast.fire({
                            icon: response.status,
                            title: response.message
                        });
                    }
                }
            });
        }

        $(document).ready(function() {
            console.info('[lesson.complete] handlers bound', { isEnrolled: isEnrolled, pageCourseId: pageCourseId });
            console.log('[lesson.sort] document ready binding sort handlers');

            $('#markLessonCompleteBtn').on('click', function(e) {
                e.preventDefault();
                console.info('[lesson.complete] modal mark button click');
                markLessonComplete($(this));
            });

            $(document).on('click', '.lesson-mark-complete-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var $btn = $(this);
                currentCourseId = parseInt($btn.attr('data-course-id') || pageCourseId, 10);
                currentLessonId = parseInt($btn.attr('data-lesson-id'), 10);
                console.info('[lesson.complete] list mark button click', {
                    currentCourseId: currentCourseId,
                    currentLessonId: currentLessonId
                });
                markLessonComplete($btn);
            });

            $(document).on('click', '.lesson-uncomplete-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                markLessonIncomplete($(this));
            });

            var player = document.getElementById('player');
            if (player && isEnrolled) {
                player.addEventListener('ended', function() {
                    markLessonComplete(null);
                });
            }
        });

        function modalClose() {
            var modal = $('#exampleModal');
            modal.hide();
        }

        function mettingModalClose() {
            var modal = $('#meetingModal');
            modal.hide();
        }

        function videoUrlModalClose() {
            var modal = $('#videoUrlModal');
            modal.hide();
        }
        // rating set
        $(document).ready(function() {
            'use strict'
            $('.rating-stars i').on('click', function() {
                var rating = parseInt($(this).data('rating'));
                $('#rating').val(rating);
                updateStars(rating);
            });
            $('#rating').on('input', function() {
                var rating = $(this).val();
                updateStars(rating);
            });

            function updateStars(rating) {
                var stars = $('.rating-stars i');
                stars.removeClass('fas').addClass('far');
                stars.each(function(index) {
                    if (index < rating) {
                        $(this).removeClass('far').addClass('fas');
                    }
                });
            }
        });
        // end rating set

        window.lessonPreview = lessonPreview;
        window.modalClose = modalClose;
        window.mettingModalClose = mettingModalClose;
        window.videoUrlModalClose = videoUrlModalClose;
    })(jQuery);
    </script>

    <script>
        (function ($) {
            'use strict';

            var editors = {};

            function initLessonEditor(editorId) {
                if (typeof ClassicEditor === 'undefined') {
                    return Promise.resolve(null);
                }

                if (!editorId || editors[editorId]) {
                    return Promise.resolve(editors[editorId] || null);
                }

                var element = document.querySelector('#' + editorId);
                if (!element) {
                    return Promise.resolve(null);
                }

                return ClassicEditor.create(element)
                .then(function(editor) {
                    editors[editorId] = editor;
                    return editor;
                })
                .catch(function(error) {
                    console.error('Lesson note editor init failed', error);
                    return null;
                });
            }

            function initLessonEditors() {
                if (typeof ClassicEditor === 'undefined') {
                    return;
                }

                $('.trumEdit').each(function() {
                    var editorId = $(this).attr('id');
                    if (editorId && !editors[editorId]) {
                        initLessonEditor(editorId);
                    }
                });
            }

            function setStatus(lessonId, message, isError) {
                var statusEl = $('#lesson-note-status-' + lessonId);
                var errorEl = $('#lesson-note-error-' + lessonId);

                if (isError) {
                    statusEl.addClass('d-none');
                    errorEl.removeClass('d-none').text(message);
                } else {
                    errorEl.addClass('d-none');
                    statusEl.removeClass('d-none').text(message);
                }

                setTimeout(function() {
                    statusEl.addClass('d-none');
                    errorEl.addClass('d-none');
                }, 3000);
            }

            function reloadNotes(lessonId, notes) {
                var list = $('#lesson-notes-' + lessonId);
                if (!list.length) return;

                list.empty();
                if (!notes || notes.length === 0) {
                    list.html('<div class="text-muted small">' + @json(__('No notes yet for this lesson')) + '</div>');
                    return;
                }

                notes.forEach(function(note) {
                    var noteCard = $('<div>', { class: 'note-card mb-2 p-2 rounded border', id: 'note-' + note.id });
                    var header = $('<div>', { class: 'd-flex justify-content-between align-items-center mb-2' });
                    header.append($('<small>', { class: 'text-muted', text: note.created_at }));

                    var actions = $('<div>', { class: 'note-actions gap-1 d-flex' });
                    actions.append('<button type="button" class="btn btn-sm btn--base outline lesson-note-edit-btn" data-note-id="' + note.id + '" data-lesson-id="' + lessonId + '" title="' + @json(__('Edit note')) + '"><i class="fa-solid fa-pen"></i></button>');
                    actions.append('<button type="button" class="btn btn-sm btn--danger lesson-note-delete-btn" data-note-id="' + note.id + '" title="' + @json(__('Delete note')) + '"><i class="fa-solid fa-trash"></i></button>');

                    noteCard.append(header.append(actions));
                    noteCard.append($('<div>', { class: 'note-content' }).html(note.content));
                    list.append(noteCard);
                });
            }

            $(document).ready(function() {
                initLessonEditors();

                $(document).on('click', '.lesson-note-toggle-btn', function(e) {
                    e.preventDefault();
                    var btn = $(this);
                    var lessonId = btn.data('lesson-id');
                    var wrapper = $('#lesson-note-wrap-' + lessonId);
                    wrapper.removeClass('d-none');
                    btn.addClass('d-none');

                    if (!wrapper.hasClass('d-none')) {
                        var editorId = 'lesson-note-editor-' + lessonId;
                        if (!editors[editorId]) {
                            initLessonEditor(editorId);
                        }
                    }
                });

                $(document).on('click', '.lesson-note-cancel-add-btn', function(e) {
                    e.preventDefault();
                    var btn = $(this);
                    var lessonId = btn.data('lesson-id');
                    var wrapper = $('#lesson-note-wrap-' + lessonId);
                    var toggleBtn = wrapper.prev('.lesson-note-toggle-btn');

                    // Clear editor
                    var editorId = 'lesson-note-editor-' + lessonId;
                    if (editors[editorId]) {
                        editors[editorId].setData('');
                    } else {
                        $('#' + editorId).val('');
                    }

                    // Hide editor and show add note button
                    wrapper.addClass('d-none');
                    toggleBtn.removeClass('d-none');
                });

                $(document).on('click', '.lesson-note-add-btn', function(e) {
                    e.preventDefault();
                    var btn = $(this);
                    var lessonId = btn.data('lesson-id');
                    var courseId = btn.data('course-id');
                    var editorId = 'lesson-note-editor-' + lessonId;
                    var content = '';

                    if (editors[editorId]) {
                        content = editors[editorId].getData();
                    } else {
                        content = $('#' + editorId).val();
                    }

                    if (!content || !content.trim()) {
                        setStatus(lessonId, @json(__('Please enter a note')), true);
                        return;
                    }

                    btn.prop('disabled', true).text(@json(__('Saving...')));

                    $.ajax({
                        url: '{{ route('user.lesson.note.store') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            lesson_id: lessonId,
                            course_id: courseId,
                            content: content,
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                btn.text(@json(__('Add Note'))).prop('disabled', false);
                                var successMsg = '<span class="text-success small ms-2">✓ ' + @json(__('Note added')) + '</span>';
                                btn.after(successMsg);
                                btn.next('.text-success').delay(2000).fadeOut(300, function() { $(this).remove(); });

                                // Hide editor and show add note button
                                var wrapper = $('#lesson-note-wrap-' + lessonId);
                                var toggleBtn = wrapper.prev('.lesson-note-toggle-btn');
                                wrapper.addClass('d-none');
                                toggleBtn.removeClass('d-none');

                                if (response.note) {
                                    var notes = [];
                                    var existing = $('#lesson-notes-' + lessonId).data('notes');
                                    if (existing && existing.length) {
                                        notes = existing;
                                    }
                                    notes.unshift(response.note);
                                    $('#lesson-notes-' + lessonId).data('notes', notes);
                                    reloadNotes(lessonId, notes);
                                }
                                if (editors[editorId]) {
                                    editors[editorId].setData('');
                                } else {
                                    $('#' + editorId).val('');
                                }
                            } else {
                                var errorMsg = '<span class="text-danger small ms-2">✗ ' + (response.message || @json(__('Unable to save note'))) + '</span>';
                                btn.after(errorMsg);
                                btn.next('.text-danger').delay(3000).fadeOut(300, function() { $(this).remove(); });
                                btn.prop('disabled', false);
                            }
                        },
                        error: function(xhr) {
                            var message = @json(__('Unable to save note'));
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            btn.prop('disabled', false);
                            var errorMsg = '<span class="text-danger small ms-2">✗ ' + message + '</span>';
                            btn.after(errorMsg);
                            btn.next('.text-danger').delay(3000).fadeOut(300, function() { $(this).remove(); });
                        }
                    });
                });

                $(document).on('click', '.lesson-note-edit-btn', function(e) {
                    e.preventDefault();
                    var btn = $(this);
                    var noteId = btn.data('note-id');
                    var lessonId = btn.data('lesson-id');
                    var noteCard = $('#note-' + noteId);
                    var content = noteCard.find('.note-content').html();

                    var editHtml = '<div class="note-edit-form mt-2">';
                    editHtml += '<textarea id="edit-note-editor-' + noteId + '" class="form--control lesson-note-editor-edit" data-note-id="' + noteId + '" data-lesson-id="' + lessonId + '"></textarea>';
                    editHtml += '<div class="mt-2 gap-2 d-flex">';
                    editHtml += '<button type="button" class="btn btn--base btn--sm lesson-note-save-edit-btn" data-note-id="' + noteId + '" data-lesson-id="' + lessonId + '">@lang('Save')</button>';
                    editHtml += '<button type="button" class="btn btn--base outline btn--sm lesson-note-cancel-edit-btn" data-note-id="' + noteId + '">@lang('Cancel')</button>';
                    editHtml += '</div></div>';

                    noteCard.append(editHtml);
                    noteCard.find('#edit-note-editor-' + noteId).val(content);
                    btn.prop('disabled', true);
                    noteCard.find('.lesson-note-delete-btn').prop('disabled', true);

                    initLessonEditor('edit-note-editor-' + noteId)
                        .then(function(editor) {
                            if (editor) {
                                editor.setData(content);
                                editors['edit-' + noteId] = editor;
                            }
                        });
                });

                $(document).on('click', '.lesson-note-save-edit-btn', function(e) {
                    e.preventDefault();
                    var btn = $(this);
                    var noteId = btn.data('note-id');
                    var lessonId = btn.data('lesson-id');
                    var editorId = 'edit-note-editor-' + noteId;
                    var content = '';

                    if (editors['edit-' + noteId]) {
                        content = editors['edit-' + noteId].getData();
                    } else {
                        content = $('#' + editorId).val();
                    }

                    if (!content || !content.trim()) {
                        var errorMsg = '<span class="text-danger small ms-2">✗ ' + @json(__('Please enter a note')) + '</span>';
                        btn.after(errorMsg);
                        btn.next('.text-danger').delay(3000).fadeOut(300, function() { $(this).remove(); });
                        return;
                    }

                    btn.prop('disabled', true).text(@json(__('Saving...')));

                    $.ajax({
                        url: '{{ route('user.lesson.note.update', '') }}/' + noteId,
                        method: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            content: content,
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#note-' + noteId).find('.note-edit-form').remove();
                                $('#note-' + noteId).find('.note-content').html(response.note.content);
                                $('#note-' + noteId).find('.lesson-note-edit-btn').prop('disabled', false);
                                $('#note-' + noteId).find('.lesson-note-delete-btn').prop('disabled', false);
                                var successMsg = '<span class="text-success small ms-2">✓ ' + @json(__('Note updated')) + '</span>';
                                btn.after(successMsg);
                                btn.next('.text-success').delay(2000).fadeOut(300, function() { $(this).remove(); });
                                delete editors['edit-' + noteId];
                            }
                        },
                        error: function(xhr) {
                            btn.prop('disabled', false).text(@json(__('Save')));
                            var errorMsg = '<span class="text-danger small ms-2">✗ ' + (xhr.responseJSON?.message || @json(__('Unable to update note'))) + '</span>';
                            btn.after(errorMsg);
                            btn.next('.text-danger').delay(3000).fadeOut(300, function() { $(this).remove(); });
                        }
                    });
                });

                $(document).on('click', '.lesson-note-cancel-edit-btn', function(e) {
                    e.preventDefault();
                    var noteId = $(this).data('note-id');
                    $('#note-' + noteId).find('.note-edit-form').remove();
                    $('#note-' + noteId).find('.lesson-note-edit-btn').prop('disabled', false);
                    $('#note-' + noteId).find('.lesson-note-delete-btn').prop('disabled', false);
                    delete editors['edit-' + noteId];
                });

                $(document).on('click', '.lesson-note-delete-btn', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var btn = $(this);
                    var noteId = btn.data('note-id');
                    var modal = $('#confirmationModal');

                    // Store context in modal data
                    modal.data('deleteNoteId', noteId);
                    modal.data('deleteBtn', btn);

                    modal.find('.question').text(@json(__('Are you sure you want to delete this note?')));
                    modal.find('form').attr('onsubmit', 'return false;');

                    modal.modal('show');
                });

                // Handle Yes button click in modal
                $(document).on('click', '#confirmationModal .btn--success', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var modal = $('#confirmationModal');
                    var noteId = modal.data('deleteNoteId');
                    var btn = modal.data('deleteBtn');

                    if (!noteId || !btn) {
                        modal.modal('hide');
                        return false;
                    }

                    btn.prop('disabled', true);

                    $.ajax({
                        url: '{{ route('user.lesson.note.destroy', '') }}/' + noteId,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                modal.modal('hide');
                                $('#note-' + noteId).fadeOut(300, function() {
                                    $(this).remove();
                                });
                            }
                        },
                        error: function(xhr) {
                            btn.prop('disabled', false);
                            var errorMsg = '<span class="text-danger small ms-2">✗ ' + (xhr.responseJSON?.message || @json(__('Unable to delete note'))) + '</span>';
                            btn.after(errorMsg);
                            btn.next('.text-danger').delay(3000).fadeOut(300, function() { $(this).remove(); });
                            modal.modal('hide');
                        },
                        complete: function() {
                            // Clear data
                            modal.removeData('deleteNoteId');
                            modal.removeData('deleteBtn');
                        }
                    });

                    return false;
                });

                // Handle No button / modal close
                $(document).on('click', '#confirmationModal .btn--dark, #confirmationModal .close', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var modal = $('#confirmationModal');
                    modal.removeData('deleteNoteId');
                    modal.removeData('deleteBtn');
                });
            });
        })(jQuery);
    </script>

    <script>
        (function ($) {
            'use strict';
            $('.show-more').on('click', function() {
                $('.accordion-item').removeClass('d-none');
                $('.accordion-item').css('visibility', 'visible');
                $('.accordion-item').css('animation-name', 'fadeInUp');
                $(this).remove();
            });

            // Load more lessons handler
            $(document).on('click', '#load-more-lessons', function(e) {
                e.preventDefault();
                var btn = $(this);
                var page = btn.data('page');
                var courseId = btn.data('course-id');
                var lessonSort = btn.data('lesson-sort') || ($('#lesson-sort-filter').val() || 'default');

                btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> @lang("Loading...")');

                $.ajax({
                    url: '{{ route("course.load.more.lessons") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        course_id: courseId,
                        page: page,
                        lesson_sort: lessonSort,
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Only append HTML if there are lessons to show
                            if (response.html && response.html.trim() !== '') {
                                $('#lesson-list').append(response.html);

                                // Re-initialize editors for new lesson items
                                if (typeof initLessonEditors === 'function') {
                                    initLessonEditors();
                                }
                            }

                            // Update button state
                            if (response.hasMore) {
                                var nextPage = parseInt(response.page) + 1;
                                btn.data('page', nextPage);
                                btn.prop('disabled', false).html('@lang("Load More Lessons")');
                            } else {
                                btn.fadeOut(300, function() {
                                    $(this).remove();
                                });
                            }
                        }
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.message || '@lang("Unable to load lessons")');
                        btn.prop('disabled', false).html('@lang("Load More Lessons")');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
