
<?php $__env->startSection('content'); ?>
<section class="account py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 d-flex justify-content-center">
                    <div class="account-form base--card mt-5">
                        <div class="verification-code-wrapper">
                            <div class="verification-area">
                                <h3 class="pb-3 border-bottom"><?php echo app('translator')->get('Verify Email Address'); ?></h3>
                                <form action="<?php echo e(route('instructor.password.verify.code')); ?>" method="POST" class="submit-form">
                                    <?php echo csrf_field(); ?>
                                    <p class="verification-text"><?php echo app('translator')->get('A 6 digit verification code sent to your email address'); ?>: <?php echo e(showEmailAddress($email)); ?></p>
                                    <input type="hidden" name="email" value="<?php echo e($email); ?>">
                                    <?php echo $__env->make($activeTemplate . 'components.verification_code', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn--base w-100"><?php echo app('translator')->get('Save'); ?></button>
                                    </div>
                                    <div class="form-group">
                                        <?php echo app('translator')->get('Please check including your Junk/Spam Folder. if not found, you can'); ?>
                                        <a href="<?php echo e(route('instructor.password.request')); ?>" class="text--base"><?php echo app('translator')->get('Try to send again'); ?></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\auth\passwords\code_verify.blade.php ENDPATH**/ ?>