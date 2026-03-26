<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-4">
                    <form action="<?php echo e(route('admin.question.update', [$question->id, $quiz->id])); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <div class="image-upload">
                                            <div class="thumb">
                                                <div class="avatar-preview">
                                                    <div class="profilePicPreview"
                                                        style="background-image: url(<?php echo e(getImage(getFilePath('quiz_question_image') . '/' . @$question->image)); ?>);">
                                                        <button type="button" class="remove-image"><i
                                                                class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" class="profilePicUpload" name="image"
                                                        id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                    <label for="profilePicUpload1"
                                                        class="btn btn--primary"><?php echo app('translator')->get('Upload'); ?></label>
                                                    <small class="pt-4"><?php echo app('translator')->get('Recommend image size'); ?>
                                                        <?php echo e(getFileSize('quiz_question_image')); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="form-group mb-3">
                                            <label class="mb-2"><?php echo app('translator')->get('Question'); ?> </label>
                                            <input class="form-control" type="text" name="question"
                                                value="<?php echo e($question->question ?? old('question')); ?>"
                                                placeholder="Enter a Question" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-2"><?php echo app('translator')->get('Mark'); ?> </label>
                                            <input class="form-control" type="number" name="mark"
                                                value="<?php echo e($question->mark ?? old('mark')); ?>"placeholder="Enter a Mark"
                                                required>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 mb-4">
                                    <div class="form-group">
                                        <div class="text-end mb-3">
                                            <button type="button" class="btn btn--primary btn--sm addFile">
                                                <i class="fa fa-plus"></i> <?php echo app('translator')->get('Add New'); ?>
                                            </button>
                                        </div>
                                        <div class="row global-card align-items-center">
                                            <div class="col-sm-10 my-3">
                                                <div class="file-upload">
                                                    <label class="form-label"><?php echo app('translator')->get('Options'); ?></label>
                                                    <input type="text" name="options[]" id="inputOptions"
                                                        class="form-control form--control mb-2" required
                                                        value="<?php echo e($question->options[0]); ?>" placeholder="Options Name" />
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="correct_answer" type="checkbox"
                                                        value="0" id="flexCheckChecked"
                                                        <?php echo e($question->correct_answer == 0 ? 'checked' : ''); ?>

                                                        onchange="checkedCheckBox(this)">
                                                    <label class="form-check-label" for="flexCheckChecked">
                                                        <?php echo app('translator')->get('Correct Answer'); ?>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        <div id="fileUploadsContainer">
                                            <?php
                                                $options = $question->options;
                                                unset($options[0]);
                                                $lastIndex = array_key_last($options);
                                            ?>
                                            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="row elements global-card mt-4 align-items-center">
                                                    <div class="col-sm-10 my-3">
                                                        <div class="file-upload input-group">
                                                            <input type="text" name="options[]" id="inputOptions"
                                                                class="form-control form--control"
                                                                placeholder="Options Name" value="<?php echo e($item); ?>"
                                                                required />
                                                            <button
                                                                class="input-group-text btn--danger remove-btn border-0"><i
                                                                    class="las la-times"></i></button>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="<?php echo e($index); ?>" id="flexCheckChecked"
                                                                <?php echo e($question->correct_answer == $index ? 'checked' : ''); ?>

                                                                name="correct_answer" onchange="checkedCheckBox(this)">
                                                            <label class="form-check-label" for="flexCheckChecked">
                                                                <?php echo app('translator')->get('Correct Answer'); ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
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
            var fileAdded = <?php echo e($lastIndex); ?>;
            $('.addFile').on('click', function() {
                if (fileAdded >= 20) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                console.log(fileAdded);
                $("#fileUploadsContainer").append(`
            <div class="row elements global-card mt-4 align-items-center">
                <div class="col-sm-10 my-3">
                    <div class="file-upload input-group">
                        <input type="text" name="options[]" id="inputOptions" class="form-control form--control"
                            placeholder="Options Name" required />
                            <button class="input-group-text btn--danger remove-btn border-0"><i class="las la-times"></i></button>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="${fileAdded}"
                            id="flexCheckChecked" name="correct_answer" onchange="checkedCheckBox(this)">
                        <label class="form-check-label" for="flexCheckChecked">
                            <?php echo app('translator')->get('Correct Answer'); ?>
                        </label>
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

    <script>
        function checkedCheckBox(object) {
            $('input[type="checkbox"]').not(object).prop('checked', false);
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views/admin/question/edit.blade.php ENDPATH**/ ?>