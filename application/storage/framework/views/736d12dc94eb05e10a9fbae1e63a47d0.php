
<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center mx-lg-0">
        <div class="col-lg-12 justify-content-center">
            <div class="base--card">
                <div class="col-lg-12">
                    <form action="<?php echo e(route('instructor.quiz.update', $quiz->id)); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview"
                                                    style="background-image: url(<?php echo e(getImage(getFilePath('quiz_image') . '/' . @$quiz->image)); ?>);">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit mb-3">
                                                <input type="file" class="profilePicUpload" name="image"
                                                    id="profilePicUpload1" accept=".png, .jpg, .jpeg">

                                                <label for="profilePicUpload1"
                                                    class="btn btn--primary"><?php echo app('translator')->get('Upload'); ?></label>
                                                <small class="pt-4"><?php echo app('translator')->get('Recommend image size'); ?>
                                                    <?php echo e(getFileSize('quiz_image')); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-xl-8">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label class="mb-2"><?php echo app('translator')->get('Name'); ?> </label>
                                            <input class="form--control" name="name" value="<?php echo e($quiz->name ??old('name')); ?>"
                                                placeholder="Enter a title" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label class="mb-2"><?php echo app('translator')->get('Course Name'); ?> </label>
                                            <select class="form--control form-select" name="course_id" id="course_id"
                                                required>
                                                <option value="0"><?php echo app('translator')->get('Select One'); ?></option>
                                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($item->id); ?>"
                                                        <?php echo e($item->id == @$quiz->course_id ? 'selected' : ''); ?>>
                                                        <?php echo e(__($item->name)); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2"><?php echo app('translator')->get('Time'); ?> <span>(<?php echo app('translator')->get('Minutes'); ?>)</span></label>
                                    <input type="number" class="form--control" name="time"
                                        value="<?php echo e(@$quiz->time ?? old('time')); ?>" placeholder="Time" required>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2"><?php echo app('translator')->get('Pass Mark'); ?></label>
                                    <input type="number" class="form--control" name="pass_mark"
                                        value="<?php echo e(@$quiz->pass_mark ?? old('pass_mark')); ?>" placeholder="Pass Mark"
                                        required>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2"><?php echo app('translator')->get('Total Qusetion'); ?></label>
                                    <input type="number" class="form--control" name="total_question"
                                        value="<?php echo e(@$quiz->total_question ?? old('total_question')); ?>"
                                        placeholder="How many Qusetion Included" required>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class=" mb-2"><?php echo app('translator')->get('Active Quiz'); ?></label>
                                    <select class="form--control form-select" name="active_quiz" id="active_quiz" required>
                                        <option value=""><?php echo app('translator')->get('Select One'); ?></option>
                                        <option value="1" <?php echo e(@$quiz->active_quiz == 1 ? 'selected' : ''); ?>>
                                            <?php echo app('translator')->get('Active'); ?></option>
                                        <option value="0" <?php echo e(@$quiz->active_quiz == 0 ? 'selected' : ''); ?>>
                                            <?php echo app('translator')->get('Pending'); ?></option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12 mt-3">
                            <div class="form-group mb-3">
                                <label class=" mb-2"><?php echo app('translator')->get('Description'); ?></label>
                                <textarea class="form--control trumEdit" name="description"><?php echo __($quiz->description) ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn--base" id="btn-save"
                                value="add"><?php echo app('translator')->get('Update'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/common/js/ckeditor.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .image-upload .thumb .profilePicPreview {
            width: 100%;
            height: 210px;
            display: block;
            border-radius: 10px;
            background-size: cover !important;
            background-position: top;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
        }

        @media (max-width:1500px) {
            .image-upload .thumb .profilePicPreview {
                height: 152px;
            }
        }

        .image-upload .thumb .profilePicPreview.logoPicPrev {
            background-size: contain !important;
            background-position: center;
        }

        .image-upload .thumb .profilePicUpload {
            font-size: 0;
            display: none;
        }

        .image-upload .thumb .avatar-edit label {
            text-align: center;
            line-height: 32px;
            font-size: 18px;
            cursor: pointer;
            padding: 2px 25px;
            width: 100%;
            border-radius: 5px;
            box-shadow: 0 5px 10px 0 rgb(0 0 0 / 16%);
            transition: all 0.3s;
            margin-top: 6px;
        }

        .image-upload .thumb .profilePicPreview .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            text-align: center;
            width: 34px;
            height: 34px;
            font-size: 23px;
            border-radius: 50%;
            background-color: hsl(var(--base));
            color: #ffffff;
            display: none;
            opacity: .8;
        }

        .image-upload .thumb .profilePicPreview .remove-image:hover {
            opacity: 1;
        }

        .image-upload .thumb .profilePicPreview.has-image .remove-image {
            display: block;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        // image preview
        function proPicURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = $(input).parents('.thumb').find('.profilePicPreview');
                    $(preview).css('background-image', 'url(' + e.target.result + ')');
                    $(preview).addClass('has-image');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".profilePicUpload").on('change', function() {
            proPicURL(this);
        });

        $(".remove-image").on('click', function() {
            $(this).parents(".profilePicPreview").css('background-image', 'none');
            $(this).parents(".profilePicPreview").removeClass('has-image');
            $(this).parents(".thumb").find('input[type=file]').val('');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'instructor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\quiz\edit.blade.php ENDPATH**/ ?>