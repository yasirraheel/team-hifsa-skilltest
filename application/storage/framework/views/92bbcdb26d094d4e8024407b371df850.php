
<?php $__env->startSection('content'); ?>
    <div class="row mx-lg-0">
        <div class="col-lg-12">
            <div class="tbl-wrap">
                <div class="d-flex gap-3 flex-row justify-content-between align-items-center mb-3">
                    <div>
                        <a class="btn btn--base create_course_category" href="<?php echo e(route('instructor.lesson.create')); ?>"><i
                                class="fa-solid fa-plus"></i><?php echo app('translator')->get('Add New'); ?></a>
                    </div>
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
                            <th class="text-center"><?php echo app('translator')->get('Title'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Created at'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Status'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Live class'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo e($loop->iteration); ?>

                                </td>
                            
                                <td>
                                    <span>
                                        <?php echo e(__(@$item->title)); ?></span>
                                </td>

                                <td class="text-center">
                                    <?php echo e(showDateTime($item->created_at)); ?> <br>
                                    <?php echo e(diffForHumans($item->created_at)); ?>

                                </td>

                                <td>
                                    <?php if($item->status == 1): ?>
                                        <span class="badge badge--success"><?php echo app('translator')->get('Active'); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge--danger"><?php echo app('translator')->get('Pending'); ?></span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if($item->preview_video == 3): ?>
                                        <span class="badge badge--danger "><?php echo app('translator')->get('Live'); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge--success"><?php echo app('translator')->get('N/A'); ?></span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a class="btn btn--base btn--sm"
                                        href="<?php echo e(route('instructor.lesson.edit', $item->id)); ?>">
                                        <i class="fa-solid fa-pen"></i></a>

                                    <?php if($item->preview_video == 3): ?>
                                        <?php
                                            $zoomData = @$item->zoom_data;
                                        ?>
                                        <a class="btn btn--base btn--sm" href="<?php echo e(@$zoomData->data?->start_url); ?>">
                                            <i class="fa-solid fa-video"></i></a>
                                    <?php endif; ?>

                                    <a class="btn btn--danger btn--sm" href="javascript:void(0)"
                                        data-url="<?php echo e(route('instructor.lesson.delete', @$item->id)); ?>"
                                        onclick="courseDeleteModal(this)">
                                        <i class="fa-solid fa-trash"></i></a>


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
    <?php if($lessons->hasPages()): ?>
        <div class="card-footer text-end">
            <?php echo e($lessons->links()); ?>

        </div>
    <?php endif; ?>

    <!-- Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel"><?php echo app('translator')->get('Confirmation Alert'); ?></h5>
                    <button type="button" class="btn-close btn " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <p><?php echo app('translator')->get('Are you sure? You want delete this course?'); ?></p>
                        <input type="text" hidden name="fileName" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base" data-bs-dismiss="modal"
                            data-modal="1"><?php echo app('translator')->get('Yes'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        function courseDeleteModal(object) {
            var data
            var videoModal = $('#videoModal');
            var url = $(object).data('url');
            videoModal.find('form').attr('action', url);
            videoModal.modal('show');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'instructor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\lessons\index.blade.php ENDPATH**/ ?>