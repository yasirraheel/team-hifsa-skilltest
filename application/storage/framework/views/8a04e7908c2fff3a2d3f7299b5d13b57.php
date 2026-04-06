
<?php $__env->startSection('content'); ?>
    <div class="row mx-lg-0">
        <div class="col-lg-12">
            <div class="table-area m-0">
                <table class="table table--responsive--lg">
                    <thead>
                        <tr></tr>
                            <th class="text-center"><?php echo app('translator')->get('User Name'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Number of Questions'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Pass Mark'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Mark'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Grade'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Created At'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $quizUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center">
                                    <span><?php echo e(__(@$item->user?->fullname ?? @$item->user?->username)); ?></span>
                                </td>

                                <td class="text-center">
                                    <span><?php echo e(__(@$item->quiz?->questions?->count())); ?></span>
                                </td>

                                <td class="text-center">
                                    <span><?php echo e(__(@$item->quiz?->pass_mark)); ?></span>
                                </td>

                                <td class="text-center">
                                    <span><?php echo e(@$item->correctMarking(@$item->quiz?->id, @$item->user?->id)); ?>/<?php echo e(__(@$item->quiz?->pass_mark)); ?></span>
                                </td>

                                <td class="text-center">
                                    <?php if(@$item->correctMarking(@$item->quiz?->id, @$item->user?->id) >= @$item->quiz?->pass_mark): ?>
                                        <span class="badge badge--success"><?php echo app('translator')->get('Passed'); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge--danger"><?php echo app('translator')->get('Failed'); ?></span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php echo e(showDateTime(@$item->created_at, 'D, M d, Y')); ?>

                                </td>
                                <td>
                                    <a class="btn btn--danger btn--sm" href="javascript:void(0)"
                                        data-url="<?php echo e(route('instructor.quiz.participant.delete', [$item->quiz?->id, $item->user?->id])); ?>"
                                        onclick="quizDeleteModal(this)">
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
    <?php if($quizUsers->hasPages()): ?>
        <div class="card-footer text-end">
            <?php echo e($quizUsers->links()); ?>

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
                        <p><?php echo app('translator')->get('Are you sure? You want delete this participant?'); ?></p>
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
        function quizDeleteModal(object) {
            var data
            var videoModal = $('#videoModal');
            var url = $(object).data('url');
            videoModal.find('form').attr('action', url);
            videoModal.modal('show');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'instructor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\quiz\instructor_participants.blade.php ENDPATH**/ ?>