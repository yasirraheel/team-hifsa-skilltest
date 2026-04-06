

<?php $__env->startSection('panel'); ?>
    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('User'); ?></th>
                                    <th><?php echo app('translator')->get('Login at'); ?></th>
                                    <th><?php echo app('translator')->get('IP'); ?></th>
                                    <th><?php echo app('translator')->get('Browser and OS'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $loginLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <a
                                                href="<?php echo e(route('admin.users.detail', $log->user_id)); ?>"><?php echo e(@$log->user->fullname); ?></a>
                                        </td>

                                        <td>
                                            <?php echo e(showDateTime($log->created_at)); ?>

                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                <a
                                                    href="<?php echo e(route('admin.report.login.ipHistory', [$log->user_ip])); ?>"><?php echo e($log->user_ip); ?></a>
                                            </span>
                                        </td>

                                        <td>
                                            <?php echo e(__($log->browser)); ?>, <?php echo e(__($log->os)); ?>

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
                <?php if($loginLogs->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($loginLogs)); ?>

                    </div>
                <?php endif; ?>
            </div><!-- card end -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\instructors\logins.blade.php ENDPATH**/ ?>