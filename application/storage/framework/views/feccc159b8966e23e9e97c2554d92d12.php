
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-4">
                    <form action="<?php echo e(route('admin.quiz.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview"
                                                    style="background-image: url(<?php echo e(getImage(getFilePath('course_image') . '/' . @$course->image)); ?>);">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" class="profilePicUpload" name="image"
                                                        id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                        <small class="pt-4"><?php echo app('translator')->get('Recommend image size'); ?>
                                                            <?php echo e(getFileSize('course_image')); ?></small>
                                                    <label for="profilePicUpload1"
                                                        class="btn btn--primary"><?php echo app('translator')->get('Upload'); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2"><?php echo app('translator')->get('Name'); ?> </label>
                                            <input class="form-control" type="text" name="name" value=""
                                                placeholder="Enter a Name" required>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label class="mb-2"><?php echo app('translator')->get('Course Name'); ?> </label>
                                                <select class="form--control form-select" name="course_id" id="course_id"
                                                    required>
                                                    <option value="0"><?php echo app('translator')->get('Select One'); ?></option>
                                                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($item->id); ?>"
                                                            <?php echo e($item->id == @$course->id ? 'selected' : ''); ?>>
                                                            <?php echo e(__($item->name)); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2"><?php echo app('translator')->get('Time'); ?> <span>(<?php echo app('translator')->get('Minutes'); ?>)</span></label>
                                        <input class="form-control" type="number" name="time" value=""
                                            placeholder="Quiz Time" min="0" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2"><?php echo app('translator')->get('Pass Mark'); ?> </label>
                                        <input class="form-control" type="number" name="pass_mark" value=""
                                            placeholder="Pass Mark" min="0">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2"><?php echo app('translator')->get('Total Qusetion'); ?> </label>
                                        <input class="form-control" type="number" name="total_question" value=""
                                            placeholder="Total Qusetion" min="0">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class=" mb-2"><?php echo app('translator')->get('Active Quiz'); ?></label>
                                        <select class="form--control form-select" name="active_quiz" id="active_quiz" required>
                                            <option value=""><?php echo app('translator')->get('Select One'); ?></option>
                                            <option value="1"><?php echo app('translator')->get('Active'); ?></option>
                                            <option value="0"><?php echo app('translator')->get('Pending'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class=" mb-2"><?php echo app('translator')->get('Description'); ?></label>
                                        <textarea class="form-control trumEdit" name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                                value="add"><?php echo app('translator')->get('Save'); ?></button>
                        </div>
                    </form>
                </div>
            </div><!-- card end -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .ck.ck-content.ck-editor__editable.ck-rounded-corners.ck-editor__editable_inline {
            height: 200px;
        }
    </style>
<?php $__env->stopPush(); ?>



<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 20) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="row elements">
                        <div class="col-sm-12 my-3">
                            <div class="file-upload input-group">
                                <input type="text" name="course_outline[]" id="inputCourseOutline" class="form-control form--control "
                                    placeholder="Course Outline" required />  
                                    <button class="input-group-text btn--danger remove-btn border-0"><i class="las la-times"></i></button>                                          
                            </div>
                        </div>
                    </div>
                `)

            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.elements').remove();
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\quiz\create.blade.php ENDPATH**/ ?>