
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
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
                                        <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                        <td class="text-center"><?php echo e(__(@$item->course?->name)); ?></td>
                                        <td class="text-center"><?php echo e(__(@$item->quiz?->name)); ?></td>
                                        <td class="text-center"><?php echo e(__(@$item->user?->fullname ?? @$item->user?->username)); ?>

                                        </td>
                                        <td class="text-center"><?php echo e(@$item->quiz?->pass_mark); ?></td>
                                        <td class="text-center"> <?php echo e(showDateTime(@$item->created_at, 'D, M d, Y')); ?></td>


                                        <td class="text-center">

                                            <a title="<?php echo app('translator')->get('User Profile'); ?>"
                                                href="<?php echo e(route('admin.users.detail', @$item->user->id)); ?>"
                                                class="btn btn-sm btn--primary">
                                                <i class="lar la-user"></i></i>
                                            </a>
                                            <a href="<?php echo e(route('course.details', [slug(@$item->course?->name), @$item->course?->id])); ?>"
                                                title="<?php echo app('translator')->get('Edit'); ?>" class="btn btn-sm btn--primary me-2">
                                                <i class="la la-eye"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%"><?php echo e(__(@$emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div><!-- card end -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\certificate\all.blade.php ENDPATH**/ ?>