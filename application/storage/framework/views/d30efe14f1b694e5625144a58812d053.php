<?php $__env->startSection('panel'); ?>
<div class="row">
    <?php echo $__env->make('admin.components.tabs.activities', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                    <a href="<?php echo e(route('admin.instructors.detail', $log->instructor_id)); ?>"><?php echo e(@$log->instructor->fullname); ?></a>
                                </td>


                                <td>
                                    <?php echo e(showDateTime($log->created_at)); ?>

                                </td>
                                <td>
                                    <span class="fw-bold">
                                        <a href="<?php echo e(route('admin.instructor.report.login.ipHistory',[$log->instructor_ip])); ?>"><?php echo e($log->instructor_ip); ?></a>
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



<?php $__env->startPush('breadcrumb-plugins'); ?>
<?php if(request()->routeIs('admin.instructor.report.login.history')): ?>
<form action="<?php echo e(route('admin.instructor.report.login.history')); ?>" method="GET" class="form-inline float-sm-end">
    <div class="input-group">
        <input type="text" name="search" class="form-control bg--white" placeholder="<?php echo app('translator')->get('Search Username'); ?>"
            value="<?php echo e(request()->search); ?>">
        <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
    </div>
</form>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php if(request()->routeIs('admin.instructor.report.login.ipHistory')): ?>
<?php $__env->startPush('breadcrumb-plugins'); ?>
<a href="https://www.ip2location.com/<?php echo e($ip); ?>" target="_blank" class="btn btn--primary"><?php echo app('translator')->get('Lookup IP'); ?> <?php echo e($ip); ?></a>
<?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\instructors\reports\logins.blade.php ENDPATH**/ ?>