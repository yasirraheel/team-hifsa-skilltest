@extends('admin.layouts.app')

@section('panel')
    <div class="row">
    
        <div class="col-md-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 px-3 pt-3">
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn--primary" id="copySelectedYoutubeLinks" disabled>
                                <i class="fa-solid fa-copy"></i> @lang('Copy Selected YT Links')
                            </button>
                            <span class="badge badge--primary">
                                <span id="selectedLessonCount">0</span> @lang('Selected')
                            </span>
                        </div>
                        <span class="text-muted small">@lang('Select lessons on this page to copy stored YouTube links.')</span>
                    </div>
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <input type="checkbox" class="form-check-input lesson-select-all"
                                            id="lessonSelectAll">
                                    </th>
                                    <th>@lang('Title')</th>
                                    <th class="text-center">@lang('Created at')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th class="text-center">@lang('Live class')</th>
                                    <th class="text-center">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lesson as $item)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input lesson-select-item"
                                                value="{{ $item->id }}" data-video-url="{{ $item->video_url ?? '' }}">
                                        </td>

                                        <td>
                                            <span>{{ __(@$item->title) }}</span>
                                        </td>
                                     
                                        <td class="text-center">
                                            {{ showDateTime($item->created_at) }} <br>
                                            {{ diffForHumans($item->created_at) }}
                                        </td>

                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Pending')</span>
                                            @endif
                                        </td>
                                 
                                        <td>
                                            @if ($item->preview_video == 3)
                                                <span class="badge badge--danger ">@lang('Live')</span>
                                            @else
                                                <span class="badge badge--success">@lang('N/A')</span>
                                            @endif
                                        </td>
                                     
                                        <td class="text-center">
                                            <div class="button--group text-center">
                                                <a class="btn btn-sm btn--primary ms-1"
                                                    href="{{ route('course.details', [slug(@$item->course_category->name),@$item->course_category->id]) }}">
                                                    <i class="fa-solid fa-eye"></i></a>
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

                    @if ($lesson->hasPages())
                        <div class="card-footer text-end">
                            {{ $lesson->links() }}
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

@push('script')
    <script>
        (function($) {
            "use strict";

            const copySuccessText = @json(__('YouTube link(s) copied'));
            const copyEmptyText = @json(__('No stored YouTube links found in the selected lessons'));
            const copyErrorText = @json(__('Unable to copy YouTube links right now'));

            function courseDeleteModal(object) {
                var videoModal = $('#videoModal');
                var url = $(object).data('url');
                videoModal.find('form').attr('action', url);
                videoModal.modal('show');
            }

            function getSelectedLessonItems() {
                return $('.lesson-select-item:checked');
            }

            function syncLessonSelectionState() {
                const selectAll = $('#lessonSelectAll');
                const lessonItems = $('.lesson-select-item');
                const selectedItems = getSelectedLessonItems();
                const selectedCount = selectedItems.length;

                $('#selectedLessonCount').text(selectedCount);
                $('#copySelectedYoutubeLinks').prop('disabled', selectedCount === 0);

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

            window.courseDeleteModal = courseDeleteModal;

            $('#lessonSelectAll').on('change', function() {
                $('.lesson-select-item').prop('checked', $(this).is(':checked'));
                syncLessonSelectionState();
            });

            $(document).on('change', '.lesson-select-item', function() {
                syncLessonSelectionState();
            });

            $('#copySelectedYoutubeLinks').on('click', function() {
                const urls = [...new Set(getSelectedLessonItems().map(function() {
                    return ($(this).data('video-url') || '').toString().trim();
                }).get().filter(Boolean))];

                if (!urls.length) {
                    Toast.fire({
                        icon: 'error',
                        title: copyEmptyText
                    });
                    return;
                }

                copyTextToClipboard(urls.join('\n')).then(function() {
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

            syncLessonSelectionState();
        })(jQuery);
    </script>
@endpush
