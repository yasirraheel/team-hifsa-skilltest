@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="mx-lg-0">
        <div class="row gy-4">
            <div class="col-xl-8">
                <div class="base-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <h6 class="mb-0" id="questionProgress">@lang('Question') 1 / {{ $questions->count() }}</h6>
                        <h6 class="mb-0 text--base" id="headline">@lang('Time Remaining :')</h6>
                    </div>

                    @forelse ($questions as $item)
                        @php
                            $options = $item->options ?? [];
                            $optionIndexes = array_keys($options);
                            shuffle($optionIndexes);
                            $correctAnswers = method_exists($item, 'normalizedCorrectAnswers') ? $item->normalizedCorrectAnswers() : [(int) $item->correct_answer];
                            $requiredCount = count($correctAnswers);
                            $isMulti = $requiredCount > 1;
                        @endphp

                        <div class="question-panel {{ $loop->first ? '' : 'd-none' }}" data-question-index="{{ $loop->index }}"
                            data-question-id="{{ $item->id }}" data-correct-answers='@json($correctAnswers)'
                            data-explanation="{{ e($item->explanation ?? '') }}">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <p class="category fw-bold mb-2">
                                    Q{{ $loop->iteration }}. {{ __(@$item->question) }}
                                </p>
                                <button type="button" class="btn btn--sm btn-outline--base toggle-flag-btn"
                                    data-question-id="{{ $item->id }}">
                                    @lang('Flag')
                                </button>
                            </div>

                            <p class="text-muted mb-3">
                                @if ($isMulti)
                                    @lang('Select') {{ $requiredCount }} @lang('answers for this question.')
                                @else
                                    @lang('Select one answer for this question.')
                                @endif
                            </p>

                            @if (!empty($item->image))
                                <div class="thumb-wrap mb-3">
                                    <img src="{{ getImage(getFilePath('quiz_question_image') . '/' . $item->image) }}" alt="question-image">
                                </div>
                            @endif

                            <div class="option-list">
                                @foreach ($optionIndexes as $index)
                                    @php $inputId = 'q' . $item->id . '_opt' . $index; @endphp
                                    @php $choiceLetter = chr(65 + $loop->index); @endphp
                                    <div class="form-check question-option">
                                        <input class="form-check-input option-input" type="{{ $isMulti ? 'checkbox' : 'radio' }}"
                                            value="{{ $index }}" id="{{ $inputId }}"
                                            name="answer_{{ $item->id }}{{ $isMulti ? '[]' : '' }}"
                                            data-quiz_id="{{ $quiz->id }}" data-question_id="{{ $item->id }}"
                                            data-selection-type="{{ $isMulti ? 'multiple' : 'single' }}"
                                            onchange="submitAnswer(this)">
                                        <label class="form-check-label" for="{{ $inputId }}">
                                            <span class="option-letter">{{ $choiceLetter }}.</span>
                                            <span class="option-text">{{ $options[$index] }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-3">
                                <button type="button" class="btn btn--sm btn-outline--dark show-answer-btn">
                                    @lang('Show Answer')
                                </button>
                                <div class="answer-explanation d-none mt-2"></div>
                            </div>
                        </div>
                    @empty
                        <h5 class="text-muted text-center text--base">@lang('No data found')</h5>
                    @endforelse

                    @if ($questions->count())
                        <div class="d-flex justify-content-between align-items-center mt-4 gap-2">
                            <button type="button" class="btn btn--base" id="prevQuestionBtn">@lang('Previous')</button>
                            <button type="button" class="btn btn--base" id="nextQuestionBtn">@lang('Next')</button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-xl-4">
                <div class="base-card p-3 p-md-4 sticky-quiz-sidebar">
                    <h6 class="mb-3">@lang('Quiz Navigator')</h6>
                    <p class="mb-2">@lang('Attempted'): <span id="attemptedCount">0</span></p>
                    <p class="mb-2">@lang('Unattempted'): <span id="unattemptedCount">{{ $questions->count() }}</span></p>
                    <p class="mb-3">@lang('Flagged'): <span id="flaggedCount">0</span></p>

                    <div class="d-flex gap-2 flex-wrap mb-3">
                        <button type="button" class="btn btn--sm btn-outline--base" id="jumpUnansweredBtn">@lang('First Unattempted')</button>
                        <button type="button" class="btn btn--sm btn-outline--dark" id="jumpFlaggedBtn">@lang('First Flagged')</button>
                    </div>

                    <div class="question-nav-grid mb-3" id="questionNavGrid">
                        @foreach ($questions as $item)
                            <button type="button" class="question-nav-btn"
                                data-nav-index="{{ $loop->index }}"
                                data-question-id="{{ $item->id }}">
                                {{ $loop->iteration }}
                            </button>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn--base w-100" id="submitQuizBtn">@lang('Submit Quiz')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="quizSubmitConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirm Submission')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">@lang('Do you want to submit this quiz now?')</p>
                    <p class="mb-1">@lang('Unattempted'): <strong id="confirmUnattemptedCount">0</strong></p>
                    <p class="mb-0">@lang('Flagged'): <strong id="confirmFlaggedCount">0</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Cancel')</button>
                    <button type="button" class="btn btn--base" id="confirmSubmitQuizBtn">@lang('Submit')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .question-nav-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 8px;
        }

        .question-nav-btn {
            border: 1px solid #d6d9de;
            background: #fff;
            border-radius: 6px;
            padding: 6px 0;
            font-size: 13px;
        }

        .question-nav-btn.current {
            border-color: #0d6efd;
            color: #0d6efd;
            font-weight: 700;
        }

        .question-nav-btn.attempted {
            background: #e9f9ef;
            border-color: #a6d8b7;
        }

        .question-nav-btn.flagged {
            background: #fff5dd;
            border-color: #f0cf7e;
        }

        .sticky-quiz-sidebar {
            position: sticky;
            top: 90px;
        }

        .option-list {
            display: grid;
            gap: 10px;
        }

        .question-option {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin: 0;
            padding: 14px 12px;
            border: 1.5px solid #d7dee7;
            border-radius: 10px;
            transition: .2s ease;
            background: #fff;
            overflow: hidden;
        }

        .question-option.selected {
            border-color: #2b7de9;
            background: #f4f9ff;
        }

        .question-option.revealed-correct {
            border-color: #1ca34a !important;
            background: #f1fbf4 !important;
        }

        .question-option.revealed-correct .option-letter,
        .question-option.revealed-correct .option-text {
            color: #14903d;
            font-weight: 700;
        }

        .answer-explanation {
            border: 1px solid #d7e5f7;
            background: #f5f9ff;
            color: #23374d;
            border-radius: 10px;
            padding: 10px 12px;
            line-height: 1.45;
            font-size: 14px;
        }

        .question-option .option-input {
            appearance: none;
            -webkit-appearance: none;
            width: 22px;
            height: 22px;
            flex: 0 0 22px;
            margin: 1px 0 0;
            margin-left: 0;
            float: none;
            border: 2px solid #90a1b5;
            background: #fff;
            cursor: pointer;
            position: relative;
        }

        .question-option .option-input[type="radio"] {
            border-radius: 50%;
        }

        .question-option .option-input[type="checkbox"] {
            border-radius: 6px;
        }

        .question-option .option-input:checked {
            border-color: #1f9f47;
            background: #1f9f47;
        }

        .question-option .option-input[type="radio"]:checked::after {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #fff;
            position: absolute;
            top: 5px;
            left: 5px;
        }

        .question-option .option-input[type="checkbox"]:checked::after {
            content: "";
            width: 10px;
            height: 6px;
            border-left: 2px solid #fff;
            border-bottom: 2px solid #fff;
            transform: rotate(-45deg);
            position: absolute;
            top: 5px;
            left: 4px;
        }

        .question-option .form-check-label {
            display: flex;
            align-items: baseline;
            gap: 8px;
            width: 100%;
            margin: 0;
            cursor: pointer;
            word-break: break-word;
        }

        .option-letter {
            font-weight: 700;
            color: #3c4d5f;
            min-width: 26px;
        }

        .option-text {
            color: #1f2d3d;
            line-height: 1.45;
        }

        .toggle-flag-btn,
        .show-answer-btn,
        #jumpUnansweredBtn,
        #jumpFlaggedBtn,
        #prevQuestionBtn,
        #nextQuestionBtn,
        #submitQuizBtn {
            white-space: nowrap;
            line-height: 1;
            border-radius: 8px;
        }

        .toggle-flag-btn {
            min-width: 92px;
            padding: 10px 12px;
        }

        #prevQuestionBtn,
        #nextQuestionBtn {
            min-width: 128px;
            padding: 11px 16px;
            background: hsl(var(--base));
            border-color: hsl(var(--base));
            color: #fff;
        }

        #prevQuestionBtn:hover,
        #nextQuestionBtn:hover,
        #prevQuestionBtn:focus,
        #nextQuestionBtn:focus,
        #prevQuestionBtn:active,
        #nextQuestionBtn:active {
            background: hsl(var(--base));
            border-color: hsl(var(--base));
            color: #fff;
        }

        #prevQuestionBtn:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        .toggle-flag-btn.btn-outline--base,
        .toggle-flag-btn.btn-outline--base:hover,
        .toggle-flag-btn.btn-outline--base:focus,
        .toggle-flag-btn.btn-outline--base:active,
        .toggle-flag-btn.btn-outline--base:focus-visible {
            background: #fff7e8 !important;
            border-color: #f4a51c !important;
            color: #8a5800 !important;
        }

        .toggle-flag-btn.btn-warning,
        .toggle-flag-btn.btn-warning:hover,
        .toggle-flag-btn.btn-warning:focus,
        .toggle-flag-btn.btn-warning:active,
        .toggle-flag-btn.btn-warning:focus-visible {
            background: #e59200 !important;
            border-color: #e59200 !important;
            color: #ffffff !important;
        }

        .show-answer-btn.btn-outline--dark,
        .show-answer-btn.btn-outline--dark:hover,
        .show-answer-btn.btn-outline--dark:focus,
        .show-answer-btn.btn-outline--dark:active,
        .show-answer-btn.btn-outline--dark:focus-visible {
            background: #fff7e8 !important;
            border-color: #f4a51c !important;
            color: #8a5800 !important;
        }

        .btn:focus,
        .btn:active:focus,
        .btn:focus-visible,
        .question-nav-btn:focus,
        .question-nav-btn:focus-visible {
            box-shadow: 0 0 0 .2rem rgba(255, 153, 0, .2) !important;
            outline: none !important;
        }

        .btn:active {
            transform: none;
        }

        @media (max-width: 1199px) {
            .sticky-quiz-sidebar {
                position: static;
                top: auto;
            }
        }

        @media (max-width: 767px) {
            .question-nav-grid {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }

            #prevQuestionBtn,
            #nextQuestionBtn {
                min-width: 0;
                width: 48%;
            }

            .toggle-flag-btn {
                min-width: 80px;
                font-size: 13px;
                padding: 9px 10px;
            }

            .question-option {
                padding: 12px 10px;
            }

            #headline {
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {
            .question-nav-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            .option-letter {
                min-width: 22px;
            }
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            const quizId = "{{ $quiz->id }}";
            const submitUrl = "{{ route('user.quiz.status', $existQuizStatus->id) }}";
            const totalQuestions = {{ $questions->count() }};
            const textFlag = @json(__('Flag'));
            const textUnflag = @json(__('Unflag'));
            const textShowAnswer = @json(__('Show Answer'));
            const textHideAnswer = @json(__('Hide Answer'));
            const textQuestion = @json(__('Question'));
            const textExplanation = @json(__('Explanation'));
            const textNext = @json(__('Next'));
            const textLastQuestion = @json(__('Last Question'));
            const textUnattempted = @json(__('Unattempted'));
            const textFlagged = @json(__('Flagged'));
            const submitModalEl = document.getElementById('quizSubmitConfirmModal');
            const submitModal = (typeof bootstrap !== 'undefined' && submitModalEl) ? new bootstrap.Modal(submitModalEl) : null;
            const panels = $('.question-panel');
            const navButtons = $('.question-nav-btn');
            let currentIndex = 0;

            const flagStorageKey = `quiz_flags_${quizId}`;
            let flagged = new Set(JSON.parse(localStorage.getItem(flagStorageKey) || '[]').map(Number));

            function persistFlags() {
                localStorage.setItem(flagStorageKey, JSON.stringify(Array.from(flagged)));
            }

            function getPanel(index) {
                return panels.eq(index);
            }

            function getCheckedValues($panel) {
                return $panel.find('.option-input:checked').map(function() {
                    return parseInt($(this).val(), 10);
                }).get();
            }

            function getCorrectAnswers($panel) {
                const raw = $panel.attr('data-correct-answers');
                try {
                    const parsed = JSON.parse(raw || '[]');
                    return Array.isArray(parsed) ? parsed.map(Number) : [];
                } catch (e) {
                    return [];
                }
            }

            function applyCheckedValues($panel, values) {
                const selected = new Set((values || []).map(Number));
                $panel.find('.option-input').each(function() {
                    $(this).prop('checked', selected.has(parseInt($(this).val(), 10)));
                });
            }

            function renderOptionSelection($panel) {
                $panel.find('.question-option').removeClass('selected');
                $panel.find('.option-input:checked').each(function() {
                    $(this).closest('.question-option').addClass('selected');
                });
            }

            function clearRevealStyles($panel) {
                $panel.find('.question-option').removeClass('revealed-correct');
            }

            function persistPanelSelection($panel) {
                const quiz_id = $panel.find('.option-input').first().data('quiz_id');
                const question_id = $panel.find('.option-input').first().data('question_id');
                const user_answer = getCheckedValues($panel);

                $.ajax({
                    type: "post",
                    url: "{{ route('user.quiz.answer') }}",
                    data: {
                        quiz_id: quiz_id,
                        question_id: question_id,
                        user_answer: user_answer,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        renderNavigator();
                        renderStats();
                    }
                });
            }

            function questionIdByIndex(index) {
                return parseInt(getPanel(index).data('question-id'), 10);
            }

            function isAttempted(index) {
                return getPanel(index).find('.option-input:checked').length > 0;
            }

            function renderStats() {
                let attempted = 0;
                panels.each(function(i) {
                    if (isAttempted(i)) attempted++;
                });
                $('#attemptedCount').text(attempted);
                $('#unattemptedCount').text(totalQuestions - attempted);
                $('#flaggedCount').text(flagged.size);
            }

            function renderNavigator() {
                navButtons.each(function() {
                    const idx = parseInt($(this).data('nav-index'), 10);
                    const qid = parseInt($(this).data('question-id'), 10);
                    $(this).toggleClass('current', idx === currentIndex);
                    $(this).toggleClass('attempted', isAttempted(idx));
                    $(this).toggleClass('flagged', flagged.has(qid));
                });
            }

            function renderFlagButton(index) {
                const panel = getPanel(index);
                const qid = questionIdByIndex(index);
                const btn = panel.find('.toggle-flag-btn');
                if (flagged.has(qid)) {
                    btn.text(textUnflag);
                    btn.removeClass('btn-outline--base').addClass('btn-warning');
                } else {
                    btn.text(textFlag);
                    btn.removeClass('btn-warning').addClass('btn-outline--base');
                }
            }

            function showQuestion(index) {
                if (index < 0 || index >= totalQuestions) return;
                currentIndex = index;
                panels.addClass('d-none');
                const panel = getPanel(currentIndex).removeClass('d-none');

                $('#questionProgress').text(`${textQuestion} ${currentIndex + 1} / ${totalQuestions}`);
                $('#prevQuestionBtn').prop('disabled', currentIndex === 0);
                $('#nextQuestionBtn').text(currentIndex === totalQuestions - 1 ? textLastQuestion : textNext);

                renderFlagButton(currentIndex);
                renderNavigator();
                renderStats();
                clearRevealStyles(panel);
                panel.data('answer-revealed', false);
                panel.find('.show-answer-btn').text(textShowAnswer);
                panel.find('.answer-explanation').addClass('d-none').text('');
                renderOptionSelection(panel);
            }

            window.submitAnswer = function(object) {
                const $panel = $(object).closest('.question-panel');
                renderOptionSelection($panel);
                persistPanelSelection($panel);
            }

            $('#prevQuestionBtn').on('click', function() {
                showQuestion(currentIndex - 1);
            });

            $('#nextQuestionBtn').on('click', function() {
                if (currentIndex < totalQuestions - 1) {
                    showQuestion(currentIndex + 1);
                }
            });

            navButtons.on('click', function() {
                showQuestion(parseInt($(this).data('nav-index'), 10));
            });

            $(document).on('click', '.toggle-flag-btn', function() {
                const qid = questionIdByIndex(currentIndex);
                if (flagged.has(qid)) {
                    flagged.delete(qid);
                } else {
                    flagged.add(qid);
                }
                persistFlags();
                renderFlagButton(currentIndex);
                renderNavigator();
                renderStats();
            });

            $(document).on('click', '.show-answer-btn', function() {
                const panel = getPanel(currentIndex);
                const isRevealed = !!panel.data('answer-revealed');

                if (!isRevealed) {
                    panel.data('saved-selection', JSON.stringify(getCheckedValues(panel)));
                    applyCheckedValues(panel, getCorrectAnswers(panel));
                    clearRevealStyles(panel);
                    panel.find('.option-input:checked').each(function() {
                        $(this).closest('.question-option').addClass('revealed-correct');
                    });
                    const explanation = (panel.attr('data-explanation') || '').trim();
                    if (explanation.length) {
                        panel.find('.answer-explanation')
                            .removeClass('d-none')
                            .text(`${textExplanation}: ${explanation}`);
                    } else {
                        panel.find('.answer-explanation').addClass('d-none').text('');
                    }
                    panel.data('answer-revealed', true);
                    $(this).text(textHideAnswer);
                } else {
                    const previous = JSON.parse(panel.data('saved-selection') || '[]');
                    applyCheckedValues(panel, previous);
                    clearRevealStyles(panel);
                    panel.find('.answer-explanation').addClass('d-none').text('');
                    panel.data('answer-revealed', false);
                    $(this).text(textShowAnswer);
                }

                renderOptionSelection(panel);
                persistPanelSelection(panel);
            });

            $('#jumpUnansweredBtn').on('click', function() {
                let target = -1;
                for (let i = 0; i < totalQuestions; i++) {
                    if (!isAttempted(i)) {
                        target = i;
                        break;
                    }
                }
                if (target >= 0) showQuestion(target);
            });

            $('#jumpFlaggedBtn').on('click', function() {
                let target = -1;
                for (let i = 0; i < totalQuestions; i++) {
                    const qid = questionIdByIndex(i);
                    if (flagged.has(qid)) {
                        target = i;
                        break;
                    }
                }
                if (target >= 0) showQuestion(target);
            });

            $('#submitQuizBtn').on('click', function() {
                let attempted = 0;
                panels.each(function(i) {
                    if (isAttempted(i)) attempted++;
                });
                const unattempted = totalQuestions - attempted;
                $('#confirmUnattemptedCount').text(unattempted);
                $('#confirmFlaggedCount').text(flagged.size);
                if (submitModal) {
                    submitModal.show();
                } else {
                    localStorage.removeItem(`{{ $quiz->id }}`);
                    window.location.href = submitUrl;
                }
            });

            $('#confirmSubmitQuizBtn').on('click', function() {
                localStorage.removeItem(`{{ $quiz->id }}`);
                window.location.href = submitUrl;
            });

            // Timer
            var end;
            var now = moment();
            var storedEndTime = localStorage.getItem("{{ $quiz->id }}");
            if (storedEndTime) {
                end = moment(storedEndTime);
            } else {
                end = moment().add("{{ $quiz->time }}", 'minute');
                localStorage.setItem("{{ $quiz->id }}", end);
            }

            function updateExpiredIn() {
                var duration = moment.duration(end.diff(now));
                if (duration.asMilliseconds() <= 0) {
                    clearInterval(intervalID);
                    $('#headline').text("Time's up!");
                    localStorage.removeItem("{{ $quiz->id }}");
                    window.location.href = submitUrl;
                    return;
                }
                var days = Math.floor(duration.asDays());
                var hours = Math.floor(duration.asHours()) - days * 24;
                var minutes = Math.floor(duration.asMinutes()) - days * 24 * 60 - hours * 60;
                var seconds = Math.floor(duration.asSeconds()) - days * 24 * 60 * 60 - hours * 60 * 60 - minutes * 60;
                $('#headline').text(days + ' days ' + hours + ' hours ' + minutes + ' minutes ' + seconds + ' seconds');
            }

            var intervalID = setInterval(function() {
                now = moment();
                updateExpiredIn();
            }, 1000);

            updateExpiredIn();
            showQuestion(0);
        })(jQuery);
    </script>
@endpush


