@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.lesson.bulk.import') }}" method="POST" id="bulkLessonForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-info">
                                    <strong>Note:</strong> Bulk lesson import is now processed asynchronously in the background.
                                    You will be notified immediately when the import starts, and you can monitor progress in the application logs.
                                    Large imports may take several minutes to complete.
                                </div>
                            </div>
                        </div>
                                    <input class="form-control" name="youtube_url" value="{{ old('youtube_url') }}"
                                        placeholder="Paste a YouTube video / playlist / channel URL" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="form-group mb-3">
                                    <label class=" mb-2">@lang('Course')</label>
                                    <select class="form--control form-select" name="course_id" id="course" required>
                                        <option value="0">@lang('Select One')</option>
                                        @foreach ($courses as $item)
                                            <option value="{{ $item->id }}" {{ old('course_id') == $item->id ? 'selected' : '' }}>
                                                {{ __($item->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xl-6">
                                <div class="form-group mb-3">
                                    <label class=" mb-2">@lang('Selece Level')</label>
                                    <select class="form--control form-select" name="level" id="level" required>
                                        <option value="">@lang('Select One')</option>
                                        <option value="1" {{ old('level') == 1 ? 'selected' : '' }}>@lang('Beginner')</option>
                                        <option value="2" {{ old('level') == 2 ? 'selected' : '' }}>@lang('intermediate')</option>
                                        <option value="3" {{ old('level') == 3 ? 'selected' : '' }}>@lang('Advance')</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2">@lang('Select Value')</label>
                                    <select name="value" class="form--control form-select" id="value" required>
                                        <option value="">@lang('Select One')</option>
                                        <option value="0" {{ old('value') === '0' ? 'selected' : '' }}>@lang('Free')</option>
                                        <option value="1" {{ old('value') === '1' ? 'selected' : '' }}>@lang('Premium')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xl-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2">@lang('Preview Video')</label>
                                    <select class="form--control form-select" required disabled>
                                        <option selected>@lang('Import from YouTube')</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label class="mb-2">@lang('Description')</label>
                                <textarea class="form-control trumEdit" name="description">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2">@lang('Import Comments')</label>
                                    <select class="form--control form-select" name="import_comments">
                                        <option value="1" {{ old('import_comments', '1') == '1' ? 'selected' : '' }}>@lang('Yes')</option>
                                        <option value="0" {{ old('import_comments') == '0' ? 'selected' : '' }}>@lang('No')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2">@lang('Comments Limit')</label>
                                    <input class="form-control" type="number" name="comments_limit" min="0" max="100"
                                        value="{{ old('comments_limit', 20) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end text-end">
                            <div class="col-4 mt-4">
                                <button type="submit" class="btn btn-success" id="bulkLessonImportBtn">@lang('Import')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .ck.ck-content.ck-editor__editable.ck-rounded-corners.ck-editor__editable_inline {
            height: 200px;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('#bulkLessonForm').on('submit', function() {
                var btn = $('#bulkLessonImportBtn');
                btn.prop('disabled', true);
                btn.text('Importing...');
            });
        })(jQuery);
    </script>
@endpush
