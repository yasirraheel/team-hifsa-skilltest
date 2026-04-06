
<?php $__env->startSection('content'); ?>
    <section class="account py-120">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="verification-code-wrapper">
                    <div class="verification-area base--card mt-5">
                        <h5 class="pb-3 text-center border-bottom"><?php echo app('translator')->get('Verify Mobile Number'); ?></h5>
                        <form action="<?php echo e(route('instructor.verify.mobile')); ?>" method="POST" class="submit-form">
                            <?php echo csrf_field(); ?>
                            <p class="verification-text"><?php echo app('translator')->get('A 6 digit verification code sent to your mobile number'); ?> : +<?php echo e(showMobileNumber(auth()->user()->mobile)); ?>

                            </p>
                            <?php echo $__env->make($activeTemplate . 'components.verification_code', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="mb-3">
                                <button type="submit" class="btn btn--base w-100"><?php echo app('translator')->get('Save'); ?></button>
                            </div>
                            <div class="form-group">
                                <p>
                                    <?php echo app('translator')->get('If you don\'t get any code'); ?>, <a href="<?php echo e(route('instructor.send.verify.code', 'phone')); ?>"
                                        class="forget-pass"> <?php echo app('translator')->get('Try again'); ?></a>
                                </p>
                                <?php if($errors->has('resend')): ?>
                                    <br />
                                    <small class="text-danger"><?php echo e($errors->first('resend')); ?></small>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\auth\authorization\sms.blade.php ENDPATH**/ ?>