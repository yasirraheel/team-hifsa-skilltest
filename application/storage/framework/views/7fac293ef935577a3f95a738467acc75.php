
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card custom--card">
                <div class="card-header">
                    <h5><?php echo app('translator')->get('Stripe Hosted'); ?></h5>
                </div>
                <div class="card-body">
                    <div class="card-wrapper mb-3"></div>
                    <form role="form" id="payment-form" method="<?php echo e($data->method); ?>" action="<?php echo e($data->url); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" value="<?php echo e($data->track); ?>" name="track">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label"><?php echo app('translator')->get('Name on Card'); ?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control form--control" name="name"
                                        value="<?php echo e(old('name')); ?>" required autocomplete="off" autofocus />
                                    <span class="input-group-text"><i class="fa fa-font"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><?php echo app('translator')->get('Card Number'); ?></label>
                                <div class="input-group">
                                    <input type="tel" class="form-control form--control" name="cardNumber"
                                        autocomplete="off" value="<?php echo e(old('cardNumber')); ?>" required autofocus />
                                    <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label class="form-label"><?php echo app('translator')->get('Expiration Date'); ?></label>
                                <input type="tel" class="form-control form--control" name="cardExpiry"
                                    value="<?php echo e(old('cardExpiry')); ?>" autocomplete="off" required />
                            </div>
                            <div class="col-md-6 ">
                                <label class="form-label"><?php echo app('translator')->get('CVC Code'); ?></label>
                                <input type="tel" class="form-control form--control" name="cardCVC"
                                    value="<?php echo e(old('cardCVC')); ?>" autocomplete="off" required />
                            </div>
                        </div>
                        <br>
                        <button class="btn btn--base w-100" type="submit"> <?php echo app('translator')->get('Save'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('assets/common/js/card.js')); ?>"></script>

<script>
    (function ($) {
        "use strict";
        var card = new Card({
            form: '#payment-form',
            container: '.card-wrapper',
            formSelectors: {
                numberInput: 'input[name="cardNumber"]',
                expiryInput: 'input[name="cardExpiry"]',
                cvcInput: 'input[name="cardCVC"]',
                nameInput: 'input[name="name"]'
            }
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\user\payment\Stripe.blade.php ENDPATH**/ ?>