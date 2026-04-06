
<?php $__env->startSection('content'); ?>
    <section class="account py-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-12">
                        <div class="account-form base--card mt-5">
                            <div class="verification-code-wrapper">
                                <div class="verification-area">
                                    <h3 class="pb-3 border-bottom"><?php echo app('translator')->get('Reset Password'); ?></h3>
                                    <div class="mb-4">
                                        <p><?php echo app('translator')->get('Your account is verified successfully. Now you can change your password. Please enter a strong password and don\'t share it with anyone.'); ?></p>
                                    </div>
                                    <form method="POST" action="<?php echo e(route('instructor.password.update')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="email" value="<?php echo e($email); ?>">
                                        <input type="hidden" name="token" value="<?php echo e($token); ?>">
                                        <div class="form-group mb-4">
                                            <label class="form--label"><?php echo app('translator')->get('Password'); ?></label>
                                            <input type="password" class="form-control form--control" name="password"
                                                required>
                                            <?php if($general->secure_password): ?>
                                                <div class="input-popup">
                                                    <p class="error lower"><?php echo app('translator')->get('1 small letter minimum'); ?></p>
                                                    <p class="error capital"><?php echo app('translator')->get('1 capital letter minimum'); ?></p>
                                                    <p class="error number"><?php echo app('translator')->get('1 number minimum'); ?></p>
                                                    <p class="error special"><?php echo app('translator')->get('1 special character minimum'); ?></p>
                                                    <p class="error minimum"><?php echo app('translator')->get('6 character password'); ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="form--label"><?php echo app('translator')->get('Confirm Password'); ?></label>
                                            <input type="password" class="form-control form--control"
                                                name="password_confirmation" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class=" btn btn--base w-100"> <?php echo app('translator')->get('Save'); ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/common/js/secure_password.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            <?php if($general->secure_password): ?>
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').focus(function() {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function() {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });
            <?php endif; ?>
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\auth\passwords\reset.blade.php ENDPATH**/ ?>