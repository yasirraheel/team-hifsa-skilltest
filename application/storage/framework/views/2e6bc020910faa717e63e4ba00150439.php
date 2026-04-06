
<?php $__env->startSection('content'); ?>
    <div class="profile-wrap">
        <div class="row justify-content-center px-3">
            <div class="col-lg-12">
                <div class="base--card mb-4">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Transaction Number'); ?></label>
                                <input type="text" name="search" value="<?php echo e(request()->search); ?>" class="form-control">
                            </div>
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Type'); ?></label>
                                <select name="type" class="form-control">
                                    <option value=""><?php echo app('translator')->get('All'); ?></option>
                                    <option value="+" <?php if(request()->type == '+'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Plus'); ?></option>
                                    <option value="-" <?php if(request()->type == '-'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Minus'); ?></option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Remark'); ?></label>
                                <select class="form-control" name="remark">
                                    <option value=""><?php echo app('translator')->get('Any'); ?></option>
                                    <?php $__currentLoopData = $remarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($remark->remark); ?>" <?php if(request()->remark == $remark->remark): echo 'selected'; endif; ?>>
                                            <?php echo e(__(keyToTitle($remark->remark))); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--base w-100 filter-btn"><i class="las la-filter"></i>
                                    <?php echo app('translator')->get('Filter'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-area m-0 mt-2">
                    <table class="table table--responsive--lg">
                        <thead>
                            <tr>
                                <th class="text-center"><?php echo app('translator')->get('Trx'); ?></th>
                                <th><?php echo app('translator')->get('Transacted'); ?></th>
                                <th><?php echo app('translator')->get('Amount'); ?></th>
                                <th><?php echo app('translator')->get('Post Balance'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Detail'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center">
                                        <strong><?php echo e($trx->trx); ?></strong>
                                    </td>

                                    <td>
                                        <?php echo e(showDateTime($trx->created_at)); ?><br><?php echo e(diffForHumans($trx->created_at)); ?>

                                    </td>

                                    <td class="budget">
                                        <span
                                            class="fw-bold <?php if($trx->trx_type == '+'): ?> text-success <?php else: ?> text-danger <?php endif; ?>">
                                            <?php echo e($trx->trx_type); ?> <?php echo e(showAmount($trx->amount)); ?> <?php echo e($general->cur_text); ?>

                                        </span>
                                    </td>

                                    <td class="budget">
                                        <?php echo e(showAmount($trx->post_balance)); ?> <?php echo e(__($general->cur_text)); ?>

                                    </td>


                                    <td><?php echo e(__($trx->details)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($transactions->hasPages()): ?>
                <div class="card-footer text-end">
                    <?php echo e($transactions->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'instructor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\transactions.blade.php ENDPATH**/ ?>