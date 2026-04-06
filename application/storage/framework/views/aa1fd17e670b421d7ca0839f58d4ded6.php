
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo app('translator')->get('Voguepay'); ?></h5>
                </div>
                <div class="card-body p-5">
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
                    <button type="button" class="btn btn--base w-100 mt-3" id="btn-confirm"><?php echo app('translator')->get('Pay Now'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script src="//pay.voguepay.com/js/voguepay.js"></script>
    <script>
        "use strict";
        var closedFunction = function() {
        }
        var successFunction = function(transaction_id) {
            window.location.href = '<?php echo e(route(gatewayRedirectUrl())); ?>';
        }
        var failedFunction=function(transaction_id) {
            window.location.href = '<?php echo e(route(gatewayRedirectUrl())); ?>' ;
        }
        function pay(item, price) {
            //Initiate voguepay inline payment
            Voguepay.init({
                v_merchant_id: "<?php echo e($data->v_merchant_id); ?>",
                total: price,
                notify_url: "<?php echo e($data->notify_url); ?>",
                cur: "<?php echo e($data->cur); ?>",
                merchant_ref: "<?php echo e($data->merchant_ref); ?>",
                memo:"<?php echo e($data->memo); ?>",
                recurrent: true,
                frequency: 10,
                developer_code: '60a4ecd9bbc77',
                custom: "<?php echo e($data->custom); ?>",
                customer: {
                  name: 'Customer name',
                  country: 'Country',
                  address: 'Customer address',
                  city: 'Customer city',
                  state: 'Customer state',
                  zipcode: 'Customer zip/post code',
                  email: 'example@example.com',
                  phone: 'Customer phone'
                },
                closed:closedFunction,
                success:successFunction,
                failed:failedFunction
            });
        }
        (function ($) {
            $('#btn-confirm').on('click', function (e) {
                e.preventDefault();
                pay('Buy', <?php echo e($data->Buy); ?>);
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\user\payment\Voguepay.blade.php ENDPATH**/ ?>