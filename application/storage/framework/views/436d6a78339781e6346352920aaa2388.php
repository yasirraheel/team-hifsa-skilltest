
<?php $__env->startSection('content'); ?>
    <section class="account py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 mt-5">
                    <div class="base--card">
                        <div class="card-body">
                            <h3 class="text-center text-danger"><?php echo app('translator')->get('You are banned'); ?></h3>
                            <p class="fw-bold mb-1"><?php echo app('translator')->get('Reason'); ?>:</p>
                            <p><?php echo e(@$user->ban_reason); ?></p>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="<?php echo e(route('home')); ?>" class=" btn btn--base fw-bold home-link mt-4"> <i class="las la-long-arrow-alt-left"></i>
                            <?php echo app('translator')->get('Go to Home'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\user\auth\authorization\ban.blade.php ENDPATH**/ ?>