

<?php $__env->startSection('panel'); ?>
    <div class="row">
    
        <div class="col-md-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                            
                                    <th><?php echo app('translator')->get('Title'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->get('Created at'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->get('Status'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->get('Live class'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $lesson; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                      

                                        <td>
                                            <span><?php echo e(__(@$item->title)); ?></span>
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
                                     
                                        <td class="text-center">
                                            <div class="button--group text-center">
                                                <a class="btn btn-sm btn--primary ms-1"
                                                    href="<?php echo e(route('course.details', [slug(@$item->course_category->name),@$item->course_category->id])); ?>">
                                                    <i class="fa-solid fa-eye"></i></a>
                                            </div>
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

                    <?php if($lesson->hasPages()): ?>
                        <div class="card-footer text-end">
                            <?php echo e($lesson->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel"><?php echo app('translator')->get('Alert'); ?></h5>
                    <button type="button" class="btn-close btn btn--danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <p><?php echo app('translator')->get('Are you sure? You want delete this course?'); ?></p>
                        <input type="text" hidden name="fileName" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-modal="0"
                            data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                        <button type="submit" class="btn btn--primary" data-bs-dismiss="modal"
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

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\lessons\instructor_index.blade.php ENDPATH**/ ?>