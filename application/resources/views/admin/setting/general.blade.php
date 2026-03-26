@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-body px-4">
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-2">
                                <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                    <label class="required"> @lang('Site Title')</label>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <input class="form-control" type="text" name="site_name" required
                                        value="{{$general->site_name}}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                    <label class="required">@lang('Currency')</label>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <input class="form-control" type="text" name="cur_text" required
                                        value="{{$general->cur_text}}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                    <label class="required">@lang('Currency Symbol')</label>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <input class="form-control" type="text" name="cur_sym" required
                                        value="{{$general->cur_sym}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-2">
                                <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                    <label> @lang('Timezone')</label>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <select class="select2-basic" name="timezone">
                                        @foreach($timezones as $timezone)
                                        <option value="'{{ @$timezone }}'">{{ __($timezone) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                    <label> @lang('Site Base Color')</label>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-text p-0 border-0">
                                            <input type='text' class="form-control colorPicker"
                                                value="{{$general->base_color}}" />
                                        </span>
                                        <input type="text" class="form-control colorCode" name="base_color"
                                            value="{{ $general->base_color }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                    <label> @lang('Site Secondary Color')</label>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-text p-0 border-0">
                                            <input type='text' class="form-control colorPicker"
                                                value="{{$general->secondary_color}}" />
                                        </span>
                                        <input type="text" class="form-control colorCode" name="secondary_color"
                                            value="{{ $general->secondary_color }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2 col-sm-6 mb-4">
                            <label class="fw-bold">@lang('User Registration')</label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="registration" {{
                                    $general->registration ?
                                'checked' : null }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-2 col-sm-6 mb-4">
                            <label class="fw-bold">@lang('Email Verification')</label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="ev" {{ $general->ev ?
                                'checked' : null }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-2 col-sm-6 mb-4">
                            <label class="fw-bold">@lang('Email Notification')</label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="en" {{ $general->en ?
                                'checked' : null }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-2 col-sm-6 mb-4">
                            <label class="fw-bold">@lang('Mobile Verification')</label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="sv" {{ $general->sv ?
                                'checked' : null }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-2 col-sm-6 mb-4">
                            <label class="fw-bold">@lang('SMS Notification')</label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="sn" {{ $general->sn ?
                                'checked' : null }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-2 col-sm-6 mb-4">
                            <label class="fw-bold">@lang('Terms & Condition')</label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="agree" {{ $general->agree ?
                                'checked' : null }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-end">
                            <button type="submit" class="btn btn--primary btn-global">@lang('Save')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Cron Job Setup Instructions -->
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">@lang('Queue & Cron Job Setup')</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> @lang('Important: Setup Required for Bulk Lesson Imports')</h6>
                    <p>@lang('Bulk lesson imports from YouTube now run in the background. Set up a cron job to process the queue:')</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6>@lang('Option 1: Cron Job (Recommended)')</h6>
                        <div class="bg-light p-3 rounded mb-3">
                            <code class="text-dark">
                                */5 * * * * cd {{ base_path() }} && /usr/local/bin/php artisan queue:run-worker --max-jobs=5 --sleep=10
                            </code>
                        </div>
                        <p class="text-muted small">
                            @lang('This runs every 5 minutes, processes up to 5 jobs, sleeps 10 seconds between each job.')
                        </p>
                    </div>

                    <div class="col-md-6">
                        <h6>@lang('Option 2: Web Cron (for shared hosting)')</h6>
                        <div class="bg-light p-3 rounded mb-3">
                            <code class="text-dark">
                                {{ url('queue_worker.php') }}?token=YOUR_SECRET_TOKEN
                            </code>
                        </div>
                        <p class="text-muted small">
                            @lang('Set up a web cron service to call this URL every 5-10 minutes.')
                        </p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <h6>@lang('Testing & Monitoring')</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-outline-primary w-100 mb-2" onclick="testQueue()">
                                    <i class="fas fa-play"></i> @lang('Test Queue')
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-outline-info w-100 mb-2" onclick="showQueueStatus()">
                                    <i class="fas fa-eye"></i> @lang('Queue Status')
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-outline-warning w-100 mb-2" onclick="showFailedJobs()">
                                    <i class="fas fa-exclamation-triangle"></i> @lang('Failed Jobs')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <details>
                        <summary class="text-primary cursor-pointer">
                            <strong>@lang('Show Detailed Setup Instructions')</strong>
                        </summary>
                        <div class="mt-3 p-3 bg-light rounded">
                            <h6>@lang('Cron Job Setup Steps:')</h6>
                            <ol>
                                <li>@lang('Log into your hosting control panel (cPanel/Plesk)')</li>
                                <li>@lang('Navigate to Cron Jobs section')</li>
                                <li>@lang('Add new cron job with the command above')</li>
                                <li>@lang('Set timing to */5 * * * * (every 5 minutes)')</li>
                                <li>@lang('Save and test by running a bulk import')</li>
                            </ol>

                            <h6 class="mt-3">@lang('Alternative Commands:')</h6>
                            <ul>
                                <li><code>*/10 * * * *</code> - @lang('Every 10 minutes (lighter load)')</li>
                                <li><code>0,30 * * * *</code> - @lang('Every 30 minutes at 0 and 30 minutes')</li>
                                <li><code>*/2 * * * *</code> - @lang('Every 2 minutes (heavier load)')</li>
                            </ul>

                            <div class="alert alert-warning mt-3">
                                <strong>@lang('Note:')</strong> @lang('Adjust frequency based on your hosting limits. Monitor resource usage.')
                            </div>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-lib')
<script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
<link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush

@push('script')
<script>
    (function ($) {
        "use strict";
        $('.colorPicker').spectrum({
            color: $(this).data('color'),
            change: function (color) {
                $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
            }
        });

        $('.colorCode').on('input', function () {
            var clr = $(this).val();
            $(this).parents('.input-group').find('.colorPicker').spectrum({
                color: clr,
            });
        });

        $('select[name=timezone]').val("'{{ config('app.timezone') }}'").select2();
        $('.select2-basic').select2({
            dropdownParent: $('.card-body')
        });

        // Queue testing functions
        window.testQueue = function() {
            Swal.fire({
                title: '@lang("Confirm Queue Test")',
                text: '@lang("This will process one queue job. Continue?")',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '@lang("Yes, test it!")',
                cancelButtonText: '@lang("Cancel")'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("admin.test.queue") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: '@lang("Success")',
                                text: response.message || '@lang("Queue test completed")',
                                icon: 'success',
                                confirmButtonText: '@lang("OK")'
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: '@lang("Error")',
                                text: '@lang("Error:") ' + (xhr.responseJSON?.message || xhr.statusText),
                                icon: 'error',
                                confirmButtonText: '@lang("OK")'
                            });
                        }
                    });
                }
            });
        };

        window.showQueueStatus = function() {
            $.ajax({
                url: '{{ route("admin.queue.status") }}',
                method: 'GET',
                success: function(response) {
                    Swal.fire({
                        title: '@lang("Queue Status")',
                        html: '@lang("Pending jobs:") ' + (response.pending || 0) + '<br>@lang("Failed jobs:") ' + (response.failed || 0),
                        icon: 'info',
                        confirmButtonText: '@lang("OK")'
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: '@lang("Error")',
                        text: '@lang("Error getting queue status:") ' + xhr.statusText,
                        icon: 'error',
                        confirmButtonText: '@lang("OK")'
                    });
                }
            });
        };

        window.showFailedJobs = function() {
            $.ajax({
                url: '{{ route("admin.queue.failed") }}',
                method: 'GET',
                success: function(response) {
                    if (response.jobs && response.jobs.length > 0) {
                        let message = '<div class="text-left">';
                        response.jobs.forEach(function(job, index) {
                            message += '<strong>' + (index + 1) + '.</strong> ' + job.display_name + '<br><small class="text-muted">' + job.failed_at + '</small><br><br>';
                        });
                        message += '</div>';
                        Swal.fire({
                            title: '@lang("Failed Jobs")',
                            html: message,
                            icon: 'warning',
                            confirmButtonText: '@lang("OK")',
                            width: '600px'
                        });
                    } else {
                        Swal.fire({
                            title: '@lang("No Failed Jobs")',
                            text: '@lang("No failed jobs found")',
                            icon: 'success',
                            confirmButtonText: '@lang("OK")'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: '@lang("Error")',
                        text: '@lang("Error getting failed jobs:") ' + xhr.statusText,
                        icon: 'error',
                        confirmButtonText: '@lang("OK")'
                    });
                }
            });
        };
    })(jQuery);

</script>
@endpush
