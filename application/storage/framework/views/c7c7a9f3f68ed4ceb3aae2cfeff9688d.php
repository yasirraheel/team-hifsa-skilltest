
<?php $__env->startSection('content'); ?>
    <div class="profile-wrap">
        <div class="row justify-content-center px-3">
            <div class="col-12 mb-3 d-flex justify-content-end">
                <form method="GET" autocomplete="off">
                    <div class="search-box">
                        <input type="text" class="form--control" name="search" placeholder="<?php echo app('translator')->get('Search...'); ?>"
                            value="<?php echo e(request()->search); ?>">
                        <button type="submit" class="search-box__button"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="table-area m-0 mt-2">
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th class="text-center"><?php echo app('translator')->get('SI'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Name'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Questions'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Time'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Pass Mark'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Created At'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo e($loop->iteration); ?>

                                </td>

                                <td>
                                    <span><?php echo e(__(@$item->name)); ?></span>
                                </td>

                                <td>
                                    <span><?php echo e(__(@$item->questions->count())); ?></span>
                                </td>

                                <td class="text-center">
                                    <?php echo e($item->time); ?> <?php echo app('translator')->get('Minute'); ?>
                                </td>

                                <td class="text-center">
                                    <?php echo e($item->pass_mark); ?>

                                </td>

                                <td class="text-center">
                                    <?php echo e(showDateTime($item->created_at, 'D, M d, Y')); ?>

                                </td>

                                <td>
                                    <a class="btn btn--base btn--sm" title="Course Preview"
                                        href="<?php echo e(route('course.details', [slug($item->course->name), $item->course->id])); ?>">
                                        <i class="fa-solid fa-eye"></i></a>
                                    <a class="btn btn--base btn--sm" title="Quiz"
                                        href="<?php echo e(route('user.quiz.details', $item->id)); ?>">
                                        <i class="fa-solid fa-forward"></i></a>

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
        <?php if($quizzes->hasPages()): ?>
            <div class="card-footer text-end">
                <?php echo e($quizzes->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\user\quiz\list.blade.php ENDPATH**/ ?>