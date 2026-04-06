
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card custom--card">
                    <div class="card-header">
                        <h5 class="card-title"><?php echo app('translator')->get('KYC Form'); ?></h5>
                    </div>
                    <div class="card-body">
                        <?php if($user->kyc_data): ?>
                        <ul class="list-group">
                          <?php $__currentLoopData = $user->kyc_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php if(!$val->value) continue; ?>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo e(__($val->name)); ?>

                            <span>
                                <?php if($val->type == 'checkbox'): ?>
                                    <?php echo e(implode(',',$val->value)); ?>

                                <?php elseif($val->type == 'file'): ?>
                                    <a href="<?php echo e(route('user.attachment.download',encrypt(getFilePath('verify').'/'.$val->value))); ?>" class="me-3"><i class="fa fa-file"></i>  <?php echo app('translator')->get('Attachment'); ?> </a>
                                <?php else: ?>
                                <p><?php echo e(__($val->value)); ?></p>
                                <?php endif; ?>
                            </span>
                          </li>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php else: ?>
                        <h5 class="text-center"><?php echo app('translator')->get('KYC data not found'); ?></h5>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\user\kyc\info.blade.php ENDPATH**/ ?>