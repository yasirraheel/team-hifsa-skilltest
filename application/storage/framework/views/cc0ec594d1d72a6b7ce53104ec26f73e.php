
<?php $__env->startSection('content'); ?>
    <!-- body-wrapper-start -->
    <div class="row mx-lg-0 mb-3">
        <div class="col-lg-12">
            <div class="filter-wrap">
                <h6><?php echo app('translator')->get('Your Ticket'); ?></h6>
                <a href="<?php echo e(route('instructor.ticket.open')); ?>" class="btn btn--base">
                    <i class="fa-solid fa-ticket me-2"></i> <?php echo app('translator')->get('Create Ticket'); ?>
                </a>
            </div>
        </div>
    </div>
    <div class="row mx-lg-0">
        <div class="col-lg-12">
            <div class="tbl-wrap">
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th class="text-center"><?php echo app('translator')->get('SL'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Subject'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Status'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Priority'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Last Reply'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $supports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $support): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td data-label="SL" class="text-center">
                                    <span> <?php echo e($loop->iteration); ?> </span>
                                </td>
                                <td data-label="Subject" class="text-center">
                                    <a href="<?php echo e(route('instructor.ticket.view', $support->ticket)); ?>" class="fw-bold text-black">
                                        [<?php echo app('translator')->get('Ticket'); ?>#<?php echo e($support->ticket); ?>] <?php echo e(__($support->subject)); ?>

                                    </a>
                                </td>
                                <td data-label="Status" class="text-center">
                                    <span> <?php echo $support->statusBadge; ?> </span>
                                </td>
                                <td data-label="Priority" class="text-center">
                                    <?php if($support->priority == 1): ?>
                                        <span class="badge badge--danger"><?php echo app('translator')->get('Low'); ?></span>
                                    <?php elseif($support->priority == 2): ?>
                                        <span class="badge badge--success"><?php echo app('translator')->get('Medium'); ?></span>
                                    <?php elseif($support->priority == 3): ?>
                                        <span class="badge badge--primary"><?php echo app('translator')->get('High'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Last Reply" class="text-center">
                                    <?php echo e(\Carbon\Carbon::parse($support->last_reply)->diffForHumans()); ?>

                                </td>

                                <td data-label="Action" class="text-center">
                                    <a class="btn btn--sm"
                                        href="<?php echo e(route('instructor.ticket.view', $support->ticket)); ?>"><?php echo app('translator')->get('View'); ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td data-label="Subject" colspan="100%" class="text-center"><?php echo app('translator')->get('No Ticket Found'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'instructor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\support\index.blade.php ENDPATH**/ ?>