
<?php $__env->startSection('panel'); ?>
    <?php echo $__env->make('admin.components.tabs.withdrawal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row justify-content-center">
        <?php if(request()->routeIs('admin.withdraw.log') ||
                request()->routeIs('admin.withdraw.method') ||
                request()->routeIs('admin.users.withdrawals') ||
                request()->routeIs('admin.users.withdrawals.method')): ?>
            <div class="col-lg-12 mt-3">
                <div class="row gy-4 pb-4">
                    <div class="col-xl-4 col-sm-6">
                        <a href="<?php echo e(route('admin.withdraw.approved')); ?>">
                            <div class="card prod-p-card background-pattern-white bg--primary">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-0">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white"><?php echo app('translator')->get('Approved Withdrawals'); ?></h6>
                                            <h3 class="m-b-0 text-white">
                                                <?php echo e(__($general->cur_sym)); ?><?php echo e(showAmount($successful)); ?>

                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <a href="<?php echo e(route('admin.withdraw.pending')); ?>">
                            <div class="card prod-p-card background-pattern-white bg--white">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-0">
                                        <div class="col">
                                            <h6 class="m-b-5"><?php echo app('translator')->get('Pending Withdrawals'); ?></h6>
                                            <h3 class="m-b-0 "><?php echo e(__($general->cur_sym)); ?><?php echo e(showAmount($pending)); ?>

                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <a href="<?php echo e(route('admin.withdraw.rejected')); ?>">
                            <div class="card prod-p-card background-pattern-white bg--primary">
                                <div class="card-body">
                                    <div class="row align-items-center m-b-0">
                                        <div class="col">
                                            <h6 class="m-b-5 text-white"><?php echo app('translator')->get('Rejected Withdrawals'); ?></h6>
                                            <h3 class="m-b-0 text-white">
                                                <?php echo e(__($general->cur_sym)); ?><?php echo e(showAmount($rejected)); ?>

                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Gateway'); ?></th>
                                    <th><?php echo app('translator')->get('Created at'); ?></th>
                                    <th><?php echo app('translator')->get('User'); ?></th>
                                    <th><?php echo app('translator')->get('Amount'); ?></th>
                                    <th><?php echo app('translator')->get('Conversion'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdraw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $details = $withdraw->withdraw_information != null ? json_encode($withdraw->withdraw_information) : null;
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold"><a
                                                    href="<?php echo e(appendQuery('method', @$withdraw->method->id)); ?>">
                                                    <?php echo e(__(@$withdraw->method->name)); ?></a></span>
                                        </td>
                                        <td>
                                            <?php echo e(showDateTime($withdraw->created_at)); ?>

                                        </td>

                                        <td>
                                            <span class="fw-bold"><?php echo e($withdraw->user->fullname); ?></span>
                                        </td>


                                        <td>
                                            <strong title="<?php echo app('translator')->get('Amount after charge'); ?>">
                                                <?php echo e(showAmount($withdraw->amount - $withdraw->charge)); ?>

                                                <?php echo e(__($general->cur_text)); ?>

                                            </strong>

                                        </td>

                                        <td>
                                            <strong><?php echo e(showAmount($withdraw->final_amount)); ?>

                                                <?php echo e(__($withdraw->currency)); ?></strong>
                                        </td>

                                        <td>
                                            <?php echo $withdraw->statusBadge ?>
                                        </td>
                                        <td>
                                            <a title="<?php echo app('translator')->get('Details'); ?>"
                                                href="<?php echo e(route('admin.withdraw.details', $withdraw->id)); ?>"
                                                class="btn btn-sm btn--primary ms-1">
                                                <i class="la la-eye"></i>
                                            </a>
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
                <?php if($withdrawals->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($withdrawals)); ?>

                    </div>
                <?php endif; ?>
            </div><!-- card end -->
        </div>
    </div>
<?php $__env->stopSection(); ?>




<?php $__env->startPush('breadcrumb-plugins'); ?>
    <form action="" method="GET">
        <div class="form-inline float-sm-end ms-0 ms-xl-2 ms-lg-0">
            <div class="input-group">
                <input type="text" name="search" class="form-control bg--white" placeholder="<?php echo app('translator')->get('Trx number/Username'); ?>"
                    value="<?php echo e(request()->search); ?>">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('style'); ?>
    <style>
        .nav-tabs {
            border: 0;
        }

        .nav-tabs li a {
            border-radius: 4px !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\withdraw\withdrawals.blade.php ENDPATH**/ ?>