
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-4">
                    <form action="<?php echo e(route('admin.course.update', $course->id)); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('put'); ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview"
                                                        style="background-image: url(<?php echo e(getImage(getFilePath('course_image') . '/' . @$course->image)); ?>);">
                                                        <button type="button" class="remove-image"><i
                                                                class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" class="profilePicUpload" name="image"
                                                        id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                    <small class="pt-4 text-danger mb-4"><?php echo app('translator')->get('image size'); ?>
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
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label class="mb-2"><?php echo app('translator')->get('Name'); ?> </label>
                                                <input class="form-control" name="name"
                                                    value="<?php echo e($course->name ?? old('name')); ?>" placeholder="Enter a name"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label class="mb-2"><?php echo app('translator')->get('Category'); ?> </label>
                                                <select class="form--control form-select" name="category_id" id="category"
                                                    required>
                                                    <option value="0"><?php echo app('translator')->get('Select One'); ?></option>
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($item->id); ?>"
                                                            <?php echo e($item->id == @$course->category_id ? 'selected' : ''); ?>>
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
                                        <label class="mb-2"><?php echo app('translator')->get('Price'); ?> </label>
                                        <input class="form-control" type="number" name="price"
                                            value="<?php echo e($course->price ?? old('price')); ?>" placeholder="Enter a price"
                                            min="0" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2"><?php echo app('translator')->get('Discount'); ?> </label>
                                        <input class="form-control" type="number" name="discount"
                                            value="<?php echo e($course->discount ?? old('discount')); ?>"
                                            placeholder="Enter a discount" min="0">
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class=" mb-2"><?php echo app('translator')->get('Status'); ?></label>
                                        <select class="form--control form-select" name="status" id="category" required>
                                            <option value=""><?php echo app('translator')->get('Select One'); ?></option>
                                            <option value="1"<?php echo e($course->status == 1 ? 'selected' : ''); ?>>
                                                <?php echo app('translator')->get('Active'); ?></option>
                                            <option value="0"<?php echo e($course->status == 0 ? 'selected' : ''); ?>>
                                                <?php echo app('translator')->get('Pending'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="text-end">
                                            <button type="button" class="btn btn-success btn--sm addFile">
                                                <i class="fa fa-plus"></i> <?php echo app('translator')->get('Add New'); ?>
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="file-upload">
                                                    <label class="form-label"><?php echo app('translator')->get('Course Outline'); ?></label>
                                                    <input type="text" name="course_outline[]" id="inputCourseOutline"
                                                        class="form-control form--control mb-2" required
                                                        placeholder="Course Outline"
                                                        value="<?php echo e($course->course_outline[0]); ?>" />
                                                </div>
                                            </div>

                                        </div>
                                        <div id="fileUploadsContainer">
                                            <?php
                                                $outlines = $course->course_outline;
                                                unset($outlines[0]);
                                            ?>
                                            <?php $__currentLoopData = $outlines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="row elements">
                                                    <div class="col-sm-12 my-3">
                                                        <div class="file-upload input-group">
                                                            <input type="text" name="course_outline[]"
                                                                id="inputCourseOutline"
                                                                class="form-control form--control"
                                                                placeholder="Hostel Facilaties" value="<?php echo e($item); ?>"
                                                                required />
                                                            <button
                                                                class="input-group-text btn--danger remove-btn border-0"><i
                                                                    class="las la-times"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class=" mb-2"><?php echo app('translator')->get("What you'll Learn"); ?></label>
                                        <textarea class="form-control trumEdit" name="learn_description"><?php echo e(__($course->learn_description)); ?></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class=" mb-2"><?php echo app('translator')->get('Course Curriculum'); ?></label>
                                        <textarea class="form-control trumEdit" name="curriculum"><?php echo e(__($course->curriculum)); ?></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class=" mb-2"><?php echo app('translator')->get('Description'); ?></label>
                                        <textarea class="form-control trumEdit" name="description"><?php echo e(__($course->description)); ?></textarea>
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

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views/admin/courses/edit.blade.php ENDPATH**/ ?>