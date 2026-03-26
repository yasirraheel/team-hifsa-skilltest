<?php $__env->startSection('panel'); ?>
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-body px-4">
                <form action="" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-2">
                                <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                    <label class="required"> <?php echo app('translator')->get('Site Title'); ?></label>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <input class="form-control" type="text" name="site_name" required
                                        value="<?php echo e($general->site_name); ?>">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                    <label class="required"><?php echo app('translator')->get('Currency'); ?></label>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <input class="form-control" type="text" name="cur_text" required
                                        value="<?php echo e($general->cur_text); ?>">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                    <label class="required"><?php echo app('translator')->get('Currency Symbol'); ?></label>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <input class="form-control" type="text" name="cur_sym" required
                                        value="<?php echo e($general->cur_sym); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-2">
                                <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                    <label> <?php echo app('translator')->get('Timezone'); ?></label>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <select class="select2-basic" name="timezone">
                                        <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="'<?php echo e(@$timezone); ?>'"><?php echo e(__($timezone)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                    <label> <?php echo app('translator')->get('Site Base Color'); ?></label>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-text p-0 border-0">
                                            <input type='text' class="form-control colorPicker"
                                                value="<?php echo e($general->base_color); ?>" />
                                        </span>
                                        <input type="text" class="form-control colorCode" name="base_color"
                                            value="<?php echo e($general->base_color); ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-3 col-xs-4 d-flex align-items-center">
                                    <label> <?php echo app('translator')->get('Site Secondary Color'); ?></label>
                                </div>
                                <div class="col-md-9 col-xs-12">
                                    <div class="input-group">
                                        <span class="input-group-text p-0 border-0">
                                            <input type='text' class="form-control colorPicker"
                                                value="<?php echo e($general->secondary_color); ?>" />
                                        </span>
                                        <input type="text" class="form-control colorCode" name="secondary_color"
                                            value="<?php echo e($general->secondary_color); ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2 col-sm-6 mb-4">
                            <label class="fw-bold"><?php echo app('translator')->get('User Registration'); ?></label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="registration" <?php echo e($general->registration ?
                                'checked' : null); ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-2 col-sm-6 mb-4">
                            <label class="fw-bold"><?php echo app('translator')->get('Email Verification'); ?></label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="ev" <?php echo e($general->ev ?
                                'checked' : null); ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-2 col-sm-6 mb-4">
                            <label class="fw-bold"><?php echo app('translator')->get('Email Notification'); ?></label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="en" <?php echo e($general->en ?
                                'checked' : null); ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-2 col-sm-6 mb-4">
                            <label class="fw-bold"><?php echo app('translator')->get('Mobile Verification'); ?></label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="sv" <?php echo e($general->sv ?
                                'checked' : null); ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-2 col-sm-6 mb-4">
                            <label class="fw-bold"><?php echo app('translator')->get('SMS Notification'); ?></label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="sn" <?php echo e($general->sn ?
                                'checked' : null); ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group col-md-2 col-sm-6 mb-4">
                            <label class="fw-bold"><?php echo app('translator')->get('Terms & Condition'); ?></label>
                            <label class="switch m-0">
                                <input type="checkbox" class="toggle-switch" name="agree" <?php echo e($general->agree ?
                                'checked' : null); ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-end">
                            <button type="submit" class="btn btn--primary btn-global"><?php echo app('translator')->get('Save'); ?></button>
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
                <h5 class="card-title"><?php echo app('translator')->get('Queue & Cron Job Setup'); ?></h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> <?php echo app('translator')->get('Important: Setup Required for Bulk Lesson Imports'); ?></h6>
                    <p><?php echo app('translator')->get('Bulk lesson imports from YouTube now run in the background. Set up a cron job to process the queue:'); ?></p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6><?php echo app('translator')->get('Option 1: Cron Job (Recommended)'); ?></h6>
                        <div class="bg-light p-3 rounded mb-3">
                            <code class="text-dark">
                                */5 * * * * cd <?php echo e(base_path()); ?> && /usr/local/bin/php artisan queue:run-worker --max-jobs=5 --sleep=10
                            </code>
                        </div>
                        <p class="text-muted small">
                            <?php echo app('translator')->get('This runs every 5 minutes, processes up to 5 jobs, sleeps 10 seconds between each job.'); ?>
                        </p>
                    </div>

                    <div class="col-md-6">
                        <h6><?php echo app('translator')->get('Option 2: Web Cron (for shared hosting)'); ?></h6>
                        <div class="bg-light p-3 rounded mb-3">
                            <code class="text-dark">
                                <?php echo e(url('queue_worker.php')); ?>?token=YOUR_SECRET_TOKEN
                            </code>
                        </div>
                        <p class="text-muted small">
                            <?php echo app('translator')->get('Set up a web cron service to call this URL every 5-10 minutes.'); ?>
                        </p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <h6><?php echo app('translator')->get('Testing & Monitoring'); ?></h6>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-outline-primary w-100 mb-2" onclick="testQueue()">
                                    <i class="fas fa-play"></i> <?php echo app('translator')->get('Test Queue'); ?>
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-outline-info w-100 mb-2" onclick="showQueueStatus()">
                                    <i class="fas fa-eye"></i> <?php echo app('translator')->get('Queue Status'); ?>
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-outline-warning w-100 mb-2" onclick="showFailedJobs()">
                                    <i class="fas fa-exclamation-triangle"></i> <?php echo app('translator')->get('Failed Jobs'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <details>
                        <summary class="text-primary cursor-pointer">
                            <strong><?php echo app('translator')->get('Show Detailed Setup Instructions'); ?></strong>
                        </summary>
                        <div class="mt-3 p-3 bg-light rounded">
                            <h6><?php echo app('translator')->get('Cron Job Setup Steps:'); ?></h6>
                            <ol>
                                <li><?php echo app('translator')->get('Log into your hosting control panel (cPanel/Plesk)'); ?></li>
                                <li><?php echo app('translator')->get('Navigate to Cron Jobs section'); ?></li>
                                <li><?php echo app('translator')->get('Add new cron job with the command above'); ?></li>
                                <li><?php echo app('translator')->get('Set timing to */5 * * * * (every 5 minutes)'); ?></li>
                                <li><?php echo app('translator')->get('Save and test by running a bulk import'); ?></li>
                            </ol>

                            <h6 class="mt-3"><?php echo app('translator')->get('Alternative Commands:'); ?></h6>
                            <ul>
                                <li><code>*/10 * * * *</code> - <?php echo app('translator')->get('Every 10 minutes (lighter load)'); ?></li>
                                <li><code>0,30 * * * *</code> - <?php echo app('translator')->get('Every 30 minutes at 0 and 30 minutes'); ?></li>
                                <li><code>*/2 * * * *</code> - <?php echo app('translator')->get('Every 2 minutes (heavier load)'); ?></li>
                            </ul>

                            <div class="alert alert-warning mt-3">
                                <strong><?php echo app('translator')->get('Note:'); ?></strong> <?php echo app('translator')->get('Adjust frequency based on your hosting limits. Monitor resource usage.'); ?>
                            </div>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-lib'); ?>
<script src="<?php echo e(asset('assets/admin/js/spectrum.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-lib'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/spectrum.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
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

        $('select[name=timezone]').val("'<?php echo e(config('app.timezone')); ?>'").select2();
        $('.select2-basic').select2({
            dropdownParent: $('.card-body')
        });

        // Queue testing functions
        window.testQueue = function() {
            Swal.fire({
                title: '<?php echo app('translator')->get("Confirm Queue Test"); ?>',
                text: '<?php echo app('translator')->get("This will process one queue job. Continue?"); ?>',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<?php echo app('translator')->get("Yes, test it!"); ?>',
                cancelButtonText: '<?php echo app('translator')->get("Cancel"); ?>'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo e(route("admin.test.queue")); ?>',
                        method: 'POST',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: '<?php echo app('translator')->get("Success"); ?>',
                                text: response.message || '<?php echo app('translator')->get("Queue test completed"); ?>',
                                icon: 'success',
                                confirmButtonText: '<?php echo app('translator')->get("OK"); ?>'
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: '<?php echo app('translator')->get("Error"); ?>',
                                text: '<?php echo app('translator')->get("Error:"); ?> ' + (xhr.responseJSON?.message || xhr.statusText),
                                icon: 'error',
                                confirmButtonText: '<?php echo app('translator')->get("OK"); ?>'
                            });
                        }
                    });
                }
            });
        };

        window.showQueueStatus = function() {
            $.ajax({
                url: '<?php echo e(route("admin.queue.status")); ?>',
                method: 'GET',
                success: function(response) {
                    Swal.fire({
                        title: '<?php echo app('translator')->get("Queue Status"); ?>',
                        html: '<?php echo app('translator')->get("Pending jobs:"); ?> ' + (response.pending || 0) + '<br><?php echo app('translator')->get("Failed jobs:"); ?> ' + (response.failed || 0),
                        icon: 'info',
                        confirmButtonText: '<?php echo app('translator')->get("OK"); ?>'
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: '<?php echo app('translator')->get("Error"); ?>',
                        text: '<?php echo app('translator')->get("Error getting queue status:"); ?> ' + xhr.statusText,
                        icon: 'error',
                        confirmButtonText: '<?php echo app('translator')->get("OK"); ?>'
                    });
                }
            });
        };

        window.showFailedJobs = function() {
            $.ajax({
                url: '<?php echo e(route("admin.queue.failed")); ?>',
                method: 'GET',
                success: function(response) {
                    if (response.jobs && response.jobs.length > 0) {
                        let message = '<div class="text-left">';
                        response.jobs.forEach(function(job, index) {
                            message += '<strong>' + (index + 1) + '.</strong> ' + job.display_name + '<br><small class="text-muted">' + job.failed_at + '</small><br><br>';
                        });
                        message += '</div>';
                        Swal.fire({
                            title: '<?php echo app('translator')->get("Failed Jobs"); ?>',
                            html: message,
                            icon: 'warning',
                            confirmButtonText: '<?php echo app('translator')->get("OK"); ?>',
                            width: '600px'
                        });
                    } else {
                        Swal.fire({
                            title: '<?php echo app('translator')->get("No Failed Jobs"); ?>',
                            text: '<?php echo app('translator')->get("No failed jobs found"); ?>',
                            icon: 'success',
                            confirmButtonText: '<?php echo app('translator')->get("OK"); ?>'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: '<?php echo app('translator')->get("Error"); ?>',
                        text: '<?php echo app('translator')->get("Error getting failed jobs:"); ?> ' + xhr.statusText,
                        icon: 'error',
                        confirmButtonText: '<?php echo app('translator')->get("OK"); ?>'
                    });
                }
            });
        };
    })(jQuery);

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views/admin/setting/general.blade.php ENDPATH**/ ?>