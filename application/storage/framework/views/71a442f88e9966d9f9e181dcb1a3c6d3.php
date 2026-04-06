
<?php $__env->startSection('content'); ?>
    <div class="row mx-lg-0">
        <div class="col-lg-12">
            <div class="tbl-wrap">
                <div class="d-flex gap-3 flex-row justify-content-between align-items-center mb-3">
                    <div></div>
                    <form method="GET" autocomplete="off">
                        <div class="search-box w-100">
                            <input type="text" class="form--control" name="search" placeholder="<?php echo app('translator')->get('Search...'); ?>"
                                value="<?php echo e(request()->search); ?>">
                            <button type="submit" class="search-box__button"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-area m-0">
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th class="text-center"><?php echo app('translator')->get('SI'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Course Name'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Quiz Name'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Student Name'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Pass Mark'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Created At'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $quizCertificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo e($loop->iteration); ?>

                                </td>

                                <td class="text-center">
                                    <span><?php echo e(__(@$item->course?->name)); ?></span>
                                </td>

                                <td class="text-center">
                                    <span><?php echo e(__(@$item->quiz?->name)); ?></span>
                                </td>

                                <td class="text-center">
                                    <span><?php echo e(__(@$item->user?->fullname ?? @$item->user?->username)); ?></span>
                                </td>

                                <td class="text-center">
                                    <?php echo e(@$item->quiz?->pass_mark); ?>

                                </td>

                                <td class="text-center">
                                    <?php echo e(showDateTime(@$item->created_at, 'D, M d, Y')); ?>

                                </td>

                                <td>
                                    <a class="btn btn--base btn--sm" title="Course-Details"
                                        href="<?php echo e(route('course.details', [slug(@$item->course?->name), @$item->course?->id])); ?>">
                                        <i class="fa-solid fa-eye"></i></a>

                                </td>
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
    </div>
    <?php if($quizCertificates->hasPages()): ?>
        <div class="card-footer text-end">
            <?php echo e($quizCertificates->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'instructor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\certificate\index.blade.php ENDPATH**/ ?>