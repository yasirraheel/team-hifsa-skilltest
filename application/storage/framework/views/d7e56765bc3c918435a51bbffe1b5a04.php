

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-deposit text-center">
                    <div class="card-header card-header-bg">
                        <h3><?php echo app('translator')->get('Payment Preview'); ?></h3>
                    </div>
                    <div class="card-body card-body-deposit text-center">
                        <h4 class="my-2"> <?php echo app('translator')->get('PLEASE SEND EXACTLY'); ?> <span class="text-success"> <?php echo e($data->amount); ?></span> <?php echo e(__($data->currency)); ?></h4>
                        <h5 class="mb-2"><?php echo app('translator')->get('TO'); ?> <span class="text-success"> <?php echo e($data->sendto); ?></span></h5>
                        <img src="<?php echo e($data->img); ?>" alt="<?php echo app('translator')->get('Image'); ?>">
                        <h4 class="text-white bold my-4"><?php echo app('translator')->get('SCAN TO SEND'); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\user\payment\crypto.blade.php ENDPATH**/ ?>