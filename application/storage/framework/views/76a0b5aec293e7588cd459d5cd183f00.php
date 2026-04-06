
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo app('translator')->get('Stripe Storefront'); ?></h5>
                </div>
                <div class="card-body p-5">
                    <form action="<?php echo e($data->url); ?>" method="<?php echo e($data->method); ?>">
                        <ul class="list-group text-center">
                            <li class="list-group-item d-flex justify-content-between">
                                <?php echo app('translator')->get('You have to pay '); ?>:
                                <strong><?php echo e(showAmount($deposit->final_amo)); ?> <?php echo e(__($deposit->method_currency)); ?></strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <?php echo app('translator')->get('You will get '); ?>:
                                <strong><?php echo e(showAmount($deposit->amount)); ?>  <?php echo e(__($general->cur_text)); ?></strong>
                            </li>
                        </ul>
                         <script src="<?php echo e($data->src); ?>"
                            class="stripe-button"
                            <?php $__currentLoopData = $data->val; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            data-<?php echo e($key); ?>="<?php echo e($value); ?>"
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        >
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function ($) {
            "use strict";
            $('button[type="submit"]').addClass("btn btn--base w-100 mt-3");
            $('button[type="submit"]').text("Pay Now");
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\user\payment\StripeJs.blade.php ENDPATH**/ ?>