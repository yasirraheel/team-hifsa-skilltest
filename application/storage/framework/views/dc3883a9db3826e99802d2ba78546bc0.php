
<?php $__env->startSection('panel'); ?>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card b-radius--10">
                <div class="card-body">
                    <?php if($user->kyc_data): ?>
                        <ul class="list-group">
                            <?php $__currentLoopData = $user->kyc_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!$val->value) continue; ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e(__($val->name)); ?>

                                    <span>
                                        <?php if($val->type == 'checkbox'): ?>
                                            <?php echo e(implode(',', $val->value)); ?>

                                        <?php elseif($val->type == 'file'): ?>
                                            <?php if($val->value): ?>
                                                <a href="<?php echo e(route('admin.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value))); ?>"
                                                    class="me-3"><i class="fa fa-file"></i> <?php echo app('translator')->get('Attachment'); ?> </a>
                                            <?php else: ?>
                                                <?php echo app('translator')->get('No File'); ?>
                                            <?php endif; ?>
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

                    <?php if($user->kv == 2): ?>
                        <div class="d-flex flex-wrap justify-content-end mt-3">
                            <button class="btn btn--danger me-3 confirmationBtn" data-question="<?php echo app('translator')->get('Are you sure to reject this documents?'); ?>"
                                data-action="<?php echo e(route('admin.users.kyc.reject', $user->id)); ?>"><i
                                    class="las la-ban"></i><?php echo app('translator')->get('Reject'); ?></button>
                            <button class="btn btn--success confirmationBtn" data-question="<?php echo app('translator')->get('Are you sure to approve this documents?'); ?>"
                                data-action="<?php echo e(route('admin.users.kyc.approve', $user->id)); ?>"><i
                                    class="las la-check"></i><?php echo app('translator')->get('Approve'); ?></button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalbd5922df145d522b37bf664b524be380 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd5922df145d522b37bf664b524be380 = $attributes; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ConfirmationModal::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $attributes = $__attributesOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__attributesOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $component = $__componentOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__componentOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\users\kyc_detail.blade.php ENDPATH**/ ?>