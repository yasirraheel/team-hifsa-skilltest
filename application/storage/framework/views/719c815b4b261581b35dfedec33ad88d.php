
<?php $__env->startSection('content'); ?>
    <section class="account py-120">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="verification-code-wrapper base--card mt-5">
                    <div class="verification-area">
                        <h5 class="pb-3 text-center border-bottom"><?php echo app('translator')->get('2FA Verification'); ?></h5>
                        <form action="<?php echo e(route('user.go2fa.verify')); ?>" method="POST" class="submit-form">
                            <?php echo csrf_field(); ?>
                            <?php echo $__env->make($activeTemplate . 'components.verification_code', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="form--group">
                                <button type="submit" class="btn btn--base w-100"><?php echo app('translator')->get('Save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $('#code').on('input change', function() {
                var xx = document.getElementById('code').value;
                $(this).val(function(index, value) {
                    value = value.substr(0, 7);
                    return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
                });

            });
        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\user\auth\authorization\2fa.blade.php ENDPATH**/ ?>