
<?php $__env->startSection('content'); ?>
    <!-- body-wrapper-start -->
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="base--card">
                <form action="#" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row gy-3 justify-content-center">
                        <div class="col-sm-12">
                            <label for="old-password" class="form--label"><?php echo app('translator')->get('Old Password'); ?>
                            </label>
                            <div class="input-group">
                                <input id="old-password" type="password" class="form-control form--control"
                                    name="current_password" required value="Password">
                                <div class="password-show-hide toggle-password-change fas fa-eye-slash"
                                    data-target="old-password"> </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="new-password" class="form--label"><?php echo app('translator')->get('New Password'); ?>
                            </label>
                            <div class="input-group">
                                <input id="new-password" type="password" class="form-control form--control" name="password"
                                    required autocomplete="current-password">
                                <div class="password-show-hide toggle-password-change fas fa-eye-slash"
                                    data-target="new-password"> </div>
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
                        </div>
                        <div class="col-sm-12">
                            <label for="again-your-password" class="form--label"><?php echo app('translator')->get('Confirm Password'); ?>
                            </label>
                            <div class="input-group">
                                <input id="again-your-password" type="password" class="form-control form--control"
                                    name="password_confirmation" required>
                                <div class="password-show-hide toggle-password-change fas fa-eye-slash"
                                    data-target="again-your-password"> </div>
                            </div>
                        </div>
                        <div class="col-sm-12 justify-content-end d-flex">
                            <button type="submit" class="btn btn--base w-100">
                                <?php echo app('translator')->get('Update'); ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End  body-wrapper-start -->
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

<?php echo $__env->make($activeTemplate . 'instructor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\password.blade.php ENDPATH**/ ?>