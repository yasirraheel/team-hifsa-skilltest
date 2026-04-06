
<?php $__env->startSection('content'); ?>
    <div class="row mx-lg-0">
        <div class="col-lg-12">
            <div class="row w-100 pb-4">
                <div class="col-lg-12">
                    
                    <div class="tbl-wrap d-flex gap-3 flex-row justify-content-between align-items-center">
                        <div>
                            <a class="btn btn--base me-4 create_group" data-bs-toggle="modal"
                                data-bs-target="#createModal"><i class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?></a>
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
            </div>

            <div class="table-area m-0">
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th class="text-center"><?php echo app('translator')->get('SI'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Name'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Course'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Created at'); ?></th>
                            <th class="text-center"><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo e($loop->iteration); ?>

                                </td>
                                <td>
                                    <span>
                                        <?php echo e(__(@$item->name)); ?></span>
                                </td>
                                <td class="text-center">
                                    <span>
                                        <?php echo e(__(@$item->course?->name)); ?></span>
                                </td>

                                <td class="text-center">
                                    <?php echo e(showDateTime($item->created_at)); ?> <br>
                                    <?php echo e(diffForHumans($item->created_at)); ?>

                                </td>

                                <td>
                                    <div class="update_group">
                                        <button title="<?php echo app('translator')->get('Edit'); ?>" href="javascript:void(0)"
                                            class="btn btn--base btn--sm" data-data="<?php echo e(json_encode($item)); ?>"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal"
                                            data-url="<?php echo e(route('instructor.group.update', $item->id)); ?>">
                                            <i class="la la-pen"></i>
                                        </button>
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
    <?php if($groups->hasPages()): ?>
        <div class="card-footer text-end">
            <?php echo e($groups->links()); ?>

        </div>
    <?php endif; ?>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('Add Course Category'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="<?php echo e(route('instructor.group.store')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label class="mb-2"><?php echo app('translator')->get('Title'); ?> </label>
                                                <input class="form--control" name="name" value=""
                                                    placeholder="Enter a title" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label class="mb-2"><?php echo app('translator')->get('Course'); ?> </label>
                                                <select class="form--control form-select" name="course_id" id="course"
                                                    required>
                                                    <option value="0" selected><?php echo app('translator')->get('Select One'); ?></option>
                                                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($item->id); ?>"
                                                            <?php echo e($item->id == @$group->course_id ? 'selected' : ''); ?>>
                                                            <?php echo e(__($item->name)); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grp-btn-wrap mt-4 justify-content-end d-flex">
                                        <button type="button" class="btn btn--danger btn--sm me-2"
                                            data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                                        <button class="btn btn--base btn--sm" type="submit"><?php echo app('translator')->get('Save'); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        $('.update_group').on('click', function() {
            var modal = $('#exampleModal');
            var modalTitle = modal.find('.modal-title').text('<?php echo app('translator')->get('Update Group'); ?>');
            var url = $(this).children().data('url');
            var data = $(this).children().data('data');
            modal.find('form').attr('action', url);
            modal.find('form').prepend(`<?php echo method_field('put'); ?>`);
            modal.find('input[name="name"]').val(data.name);
            modal.find('select[name="course_id"]').val(data.course_id);
            modal.find('form').find('button[type="submit"]').text('<?php echo app('translator')->get('Update'); ?>');
            modal.modal('show');

        });

        $('.create_group').on('click', function() {
            var modal = $('#exampleModal');
            var modalTitle = modal.find('.modal-title').text('<?php echo app('translator')->get('Create Group'); ?>');
            var url = "<?php echo e(route('instructor.group.store')); ?>";
            modal.find('form').attr('action', url);
            modal.find('input[name="name"]').val('');
            modal.find('select[name="course_id"]').val(0);
            modal.find('form').find('button[type="submit"]').text('<?php echo app('translator')->get('Save'); ?>');
            modal.modal('show');
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make($activeTemplate . 'instructor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\groups\log.blade.php ENDPATH**/ ?>