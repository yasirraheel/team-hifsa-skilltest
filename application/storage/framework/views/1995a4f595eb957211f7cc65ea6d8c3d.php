
<?php $__env->startSection('panel'); ?>
<?php echo $__env->make('admin.components.tabs.withdrawal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('Method'); ?></th>
                                <th><?php echo app('translator')->get('Currency'); ?></th>
                                <th><?php echo app('translator')->get('Charge'); ?></th>
                                <th><?php echo app('translator')->get('Withdraw Limit'); ?></th>
                                <th><?php echo app('translator')->get('Status'); ?></th>
                                <th><?php echo app('translator')->get('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(__($method->name)); ?></td>

                                <td class="fw-bold"><?php echo e(__($method->currency)); ?></td>
                                <td class="fw-bold"><?php echo e(showAmount($method->fixed_charge)); ?> <?php echo e(__($general->cur_text)); ?>

                                    <?php echo e((0 < $method->percent_charge) ? ' + '. showAmount($method->percent_charge) .' %'
                                        : ''); ?> </td>
                                <td class="fw-bold"><?php echo e($method->min_limit + 0); ?>

                                    - <?php echo e($method->max_limit + 0); ?> <?php echo e(__($general->cur_text)); ?></td>
                                <td>
                                    <?php if($method->status == 1): ?>
                                    <span
                                        class="text--small badge font-weight-normal badge--success"><?php echo app('translator')->get('Active'); ?></span>
                                    <?php else: ?>
                                    <span
                                        class="text--small badge font-weight-normal badge--warning"><?php echo app('translator')->get('Disabled'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="button--group">
                                        <a title="<?php echo app('translator')->get('Edit'); ?>"
                                            href="<?php echo e(route('admin.withdraw.method.edit', $method->id)); ?>"
                                            class="btn btn-sm btn--primary ms-1"><i class="las la-pen"></i>
                                        </a>
                                        <?php if($method->status == 1): ?>
                                        <button title="<?php echo app('translator')->get('Disable'); ?>"
                                            class="btn btn-sm btn--danger ms-1 confirmationBtn"
                                            data-question="<?php echo app('translator')->get('Are you sure to disable this method?'); ?>"
                                            data-action="<?php echo e(route('admin.withdraw.method.deactivate',$method->id)); ?>">
                                            <i class="la la-eye-slash"></i>
                                        </button>
                                        <?php else: ?>
                                        <button title="<?php echo app('translator')->get('Enable'); ?>"
                                            class="btn btn-sm btn--success ms-1 confirmationBtn"
                                            data-question="<?php echo app('translator')->get('Are you sure to enable this method?'); ?>"
                                            data-action="<?php echo e(route('admin.withdraw.method.activate',$method->id)); ?>">
                                            <i class="la la-check-circle"></i>
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                            </tr>
                            <?php endif; ?>

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
        </div><!-- card end -->
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



<?php $__env->startPush('breadcrumb-plugins'); ?>

<div class="d-flex flex-wrap justify-content-end">
    <a class="btn btn--primary h-40 me-2 d-flex align-items-center"
        href="<?php echo e(route('admin.withdraw.method.create')); ?>"><i class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?></a>
    <div class="d-inline">
        <div class="input-group justify-content-end">
            <input type="text" name="search_table" class="form-control bg--white" placeholder="<?php echo app('translator')->get('Search'); ?>...">
            <button class="btn btn--primary input-group-text"><i class="fa fa-search"></i></button>
        </div>
    </div>
</div>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\withdraw\index.blade.php ENDPATH**/ ?>