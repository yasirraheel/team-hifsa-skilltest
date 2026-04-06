
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-4">
                    <form action="<?php echo e(route('admin.quiz.update', $quiz->id)); ?>" method="POST" enctype="multipart/form-data">
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
                                                        style="background-image: url(<?php echo e(getImage(getFilePath('quiz_image') . '/' . @$quiz->image)); ?>);">
                                                        <button type="button" class="remove-image"><i
                                                                class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="avatar-edit">
                                                    <input type="file" class="profilePicUpload" name="image"
                                                        id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                    <small class="pt-4 text-danger mb-4"><?php echo app('translator')->get('image size'); ?>
                                                        <?php echo e(getFileSize('quiz_image')); ?></small>
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
                                            <input class="form-control" type="text" name="name" value="<?php echo e($quiz->name ??old('name')); ?>"
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
                                                            <?php echo e($item->id == @$quiz->course_id ? 'selected' : ''); ?>>
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
                                        <input class="form-control" type="number" name="time" value="<?php echo e(@$quiz->time ?? old('time')); ?>"
                                            placeholder="Quiz Time" min="0" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2"><?php echo app('translator')->get('Pass Mark'); ?> </label>
                                        <input class="form-control" type="number" name="pass_mark" value="<?php echo e(@$quiz->pass_mark ?? old('pass_mark')); ?>"
                                            placeholder="Pass Mark" min="0">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="mb-2"><?php echo app('translator')->get('Total Qusetion'); ?> </label>
                                        <input class="form-control" type="number" name="total_question" value="<?php echo e(@$quiz->total_question ?? old('total_question')); ?>"
                                            placeholder="How many Qusetion Included" min="0">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class=" mb-2"><?php echo app('translator')->get('Active Quiz'); ?></label>
                                        <select class="form--control form-select" name="active_quiz" id="active_quiz"
                                            required>
                                            <option value=""><?php echo app('translator')->get('Select One'); ?></option>
                                            <option value="1" <?php echo e(@$quiz->active_quiz == 1 ? 'selected' : ''); ?>><?php echo app('translator')->get('Active'); ?></option>
                                            <option value="0" <?php echo e(@$quiz->active_quiz == 0 ? 'selected' : ''); ?>><?php echo app('translator')->get('Pending'); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class=" mb-2"><?php echo app('translator')->get('Description'); ?></label>
                                        <textarea class="form-control trumEdit" name="description"><?php echo __($quiz->description) ?></textarea>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                                value="add"><?php echo app('translator')->get('Update'); ?></button>
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


<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\quiz\edit.blade.php ENDPATH**/ ?>