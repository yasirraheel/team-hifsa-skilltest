
<?php $__env->startSection('content'); ?>
    <!-- body-wrapper-start -->
    <div class="row justify-content-center mx-lg-0">
        <div class="col-lg-12 justify-content-center">
            <div class="base--card">
                <div class="text-end">
                    <a href="<?php echo e(route('instructor.ticket')); ?>" class="btn btn--base btn-sm mb-2"><?php echo app('translator')->get('My Support Ticket'); ?></a>
                </div>
                <div class="dashboard-card-wrap mt-0">
                    <form action="<?php echo e(route('instructor.ticket.store')); ?>" method="post" enctype="multipart/form-data"
                        onsubmit="return submitUserForm();">
                        <?php echo csrf_field(); ?>
                        <div class="row gy-4">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="full_name" class="form--label"><?php echo app('translator')->get('Full Name'); ?></label>
                                    <div class="input--group">
                                        <input type="text" class="form--control" id="full_name" placeholder="Full Name"
                                            name="name" value="<?php echo e(@$user->firstname . ' ' . @$user->lastname); ?>" required
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email_adress" class="form--label"><?php echo app('translator')->get('Email'); ?></label>
                                    <div class="input--group">
                                        <input type="email" class="form--control" id="email_adress" placeholder="Email"
                                            name="email" value="<?php echo e(@$user->email); ?>" required readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="subject" class="form--label"><?php echo app('translator')->get('Subject'); ?></label>
                                    <div class="input--group">
                                        <input type="text" class="form--control" id="subject" placeholder="Subject"
                                            name="subject" value="<?php echo e(old('subject')); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="Priority" class="form--label"><?php echo app('translator')->get('Priority'); ?></label>
                                    <div class="input--group">
                                        <select id="Priority" name="priority" class="form--control form-select select" required>
                                            <option value="" selected><?php echo app('translator')->get('Select an option'); ?></option>
                                            <option value="1"><?php echo app('translator')->get('Low'); ?></option>
                                            <option value="2"><?php echo app('translator')->get('Medium'); ?></option>
                                            <option value="3"><?php echo app('translator')->get('High'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputMessage" class="form--label"><?php echo app('translator')->get('Message'); ?></label>
                                    <div class="input--group textarea">
                                        <textarea name="message" id="inputMessage" rows="6" class="form--control" required><?php echo e(old('message')); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 text-end">
                                <button type="button" class="btn btn--base btn--sm ms-2 addFile">
                                    <i class="fa fa-plus"></i> <?php echo app('translator')->get('Add New'); ?>
                                </button>
                            </div>
                            <div class="col-lg-12">
                                <div class="attachment_wrapper mb-4">
                                    <div class="form-group profile mb-15">
                                        <p class="ticket-attachments-message text-muted my-3"> <?php echo app('translator')->get('Allowed File Extensions'); ?>: <span
                                                class="text-danger">.<?php echo app('translator')->get('jpg'); ?>, .<?php echo app('translator')->get('jpeg'); ?>,
                                                .<?php echo app('translator')->get('png'); ?>, .<?php echo app('translator')->get('pdf'); ?>, .<?php echo app('translator')->get('doc'); ?>,
                                                .<?php echo app('translator')->get('docx'); ?></span> </p>
                                        <div class="single-input form-group mt-3 mb-1">
                                            <input class="form--control" type="file" name="attachments[]"
                                                id="inputAttachments">
                                        </div>
                                        <div id="fileUploadsContainer"></div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button class="btn btn--base w-100" type="submit"
                                        id="recaptcha">&nbsp;<?php echo app('translator')->get('Submit'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control form--control" required />
                        <button class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'instructor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\support\create.blade.php ENDPATH**/ ?>