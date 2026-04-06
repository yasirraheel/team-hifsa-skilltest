
<?php $__env->startSection('content'); ?>
    <div class="row mx-lg-0 gy-4">
        <?php if(!auth()->user()->ts): ?>
            <div class="col-xl-5 col-lg-5">
                <div class="base--card">
                    <div class="two-fact-wrapper">
                        <div class="two-fact-left">
                            <h5><?php echo app('translator')->get('Two Factor Authenticator'); ?></h5>
                            <div class="qr-img mb-4 mx-auto text-center">
                                <img class="mx-auto" src="<?php echo e($qrCodeUrl); ?>" alt="">
                            </div>
                            <div class="two-fact-left__content">
                                <p><?php echo app('translator')->get('Use the QR code or setup key on your Google Authenticator app to add your account.'); ?></p>
                            </div>
                            <div class="two-fact-left__bottom">
                                <div class="top">
                                    <h6><?php echo app('translator')->get('Setup Key'); ?></h6>
                                    <span><i class="fa fa-info-circle"></i></span>
                                </div>
                                <div class="bottom">
                                    
                                    <div class="input-group">
                                        <input type="text" class="form-control form--control referralURL" readonly id="key"
                                        name="key" value="<?php echo e($secret); ?>">
                                        <button type="button" class="input-group-text btn btn--base copytext"
                                            style="border-radius: 0px" id="copyBoard">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-xl-7 col-lg-7">
            <div class="profile-right-wrap">
                <div class="row gy-3">
                    <div class="col-sm-12">
                        <?php if(auth()->user()->ts): ?>
                            <div class="base--card">
                                <div class="profile-right">
                                    <h5 class="mb-4"><?php echo app('translator')->get('Disable 2FA Security'); ?></h5>
                                </div>
                                <form action="<?php echo e(route('user.twofactor.disable')); ?>" method="POST">
                                    <div class="card-body">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="key" value="<?php echo e($secret); ?>">
                                        <div class="form-group">
                                            <label class="form-label"><?php echo app('translator')->get('Google Authenticatior OTP'); ?></label>
                                            <input type="text" class="form-control form--control" name="code"
                                                required>
                                        </div>
                                        <p class="mb-2">
                                            <?php echo app('translator')->get('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.'); ?>
                                        </p>
                                        <button type="submit" class="btn btn--base w-100 mt-4"><?php echo app('translator')->get('Save'); ?></button>
                                    </div>
                                </form>
                            </div>
                        <?php else: ?>
                            <div class="base--card">
                                <div class="profile-right">
                                    <h5 class="mb-4"><?php echo app('translator')->get('Enable 2FA Security'); ?></h5>
                                </div>

                                <form action="<?php echo e(route('user.twofactor.enable')); ?>" method="POST">
                                    <div class="card-body">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="key" value="<?php echo e($secret); ?>">
                                        <div class="form-group">
                                            <label class="form-label"><?php echo app('translator')->get('Google Authenticatior OTP'); ?></label>
                                            <input type="text" class="form-control form--control" name="code"
                                                required>
                                        </div>
                                        <p class="mb-2">
                                            <?php echo app('translator')->get('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.'); ?>
                                        </p>
                                        <button type="submit" class="btn btn--base w-100 mt-4"><?php echo app('translator')->get('Save'); ?></button>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Dashboard -->
    <?php $__env->stopSection(); ?>

    <?php $__env->startPush('style'); ?>
        <style>
            .copied::after {
                background-color: #<?php echo e($general->base_color); ?>;
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('script'); ?>
        <script>
            (function($) {
                "use strict";
                $('#copyBoard').on('click', function() {
                    var copyText = document.getElementsByClassName("referralURL");
                    copyText = copyText[0];
                    copyText.select();
                    copyText.setSelectionRange(0, 99999);
                    /*For mobile devices*/
                    document.execCommand("copy");
                    copyText.blur();
                    this.classList.add('copied');
                    setTimeout(() => this.classList.remove('copied'), 1500);
                });
            })(jQuery);
        </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\user\twofactor.blade.php ENDPATH**/ ?>