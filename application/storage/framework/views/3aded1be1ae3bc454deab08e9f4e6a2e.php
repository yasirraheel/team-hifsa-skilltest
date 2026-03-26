<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.lesson.bulk.import')); ?>" method="POST" id="bulkLessonForm">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-info">
                                    <strong>Note:</strong> Bulk lesson import is now processed asynchronously in the background.
                                    You will be notified immediately when the import starts, and you can monitor progress in the application logs.
                                    Large imports may take several minutes to complete.
                                </div>
                            </div>
                        </div>
                                    <input class="form-control" name="youtube_url" value="<?php echo e(old('youtube_url')); ?>"
                                        placeholder="Paste a YouTube video / playlist / channel URL" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="form-group mb-3">
                                    <label class=" mb-2"><?php echo app('translator')->get('Course'); ?></label>
                                    <select class="form--control form-select" name="course_id" id="course" required>
                                        <option value="0"><?php echo app('translator')->get('Select One'); ?></option>
                                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->id); ?>" <?php echo e(old('course_id') == $item->id ? 'selected' : ''); ?>>
                                                <?php echo e(__($item->name)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xl-6">
                                <div class="form-group mb-3">
                                    <label class=" mb-2"><?php echo app('translator')->get('Selece Level'); ?></label>
                                    <select class="form--control form-select" name="level" id="level" required>
                                        <option value=""><?php echo app('translator')->get('Select One'); ?></option>
                                        <option value="1" <?php echo e(old('level') == 1 ? 'selected' : ''); ?>><?php echo app('translator')->get('Beginner'); ?></option>
                                        <option value="2" <?php echo e(old('level') == 2 ? 'selected' : ''); ?>><?php echo app('translator')->get('intermediate'); ?></option>
                                        <option value="3" <?php echo e(old('level') == 3 ? 'selected' : ''); ?>><?php echo app('translator')->get('Advance'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2"><?php echo app('translator')->get('Select Value'); ?></label>
                                    <select name="value" class="form--control form-select" id="value" required>
                                        <option value=""><?php echo app('translator')->get('Select One'); ?></option>
                                        <option value="0" <?php echo e(old('value') === '0' ? 'selected' : ''); ?>><?php echo app('translator')->get('Free'); ?></option>
                                        <option value="1" <?php echo e(old('value') === '1' ? 'selected' : ''); ?>><?php echo app('translator')->get('Premium'); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-xl-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2"><?php echo app('translator')->get('Preview Video'); ?></label>
                                    <select class="form--control form-select" required disabled>
                                        <option selected><?php echo app('translator')->get('Import from YouTube'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label class="mb-2"><?php echo app('translator')->get('Description'); ?></label>
                                <textarea class="form-control trumEdit" name="description"><?php echo e(old('description')); ?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2"><?php echo app('translator')->get('Import Comments'); ?></label>
                                    <select class="form--control form-select" name="import_comments">
                                        <option value="1" <?php echo e(old('import_comments', '1') == '1' ? 'selected' : ''); ?>><?php echo app('translator')->get('Yes'); ?></option>
                                        <option value="0" <?php echo e(old('import_comments') == '0' ? 'selected' : ''); ?>><?php echo app('translator')->get('No'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label class="mb-2"><?php echo app('translator')->get('Comments Limit'); ?></label>
                                    <input class="form-control" type="number" name="comments_limit" min="0" max="100"
                                        value="<?php echo e(old('comments_limit', 20)); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end text-end">
                            <div class="col-4 mt-4">
                                <button type="submit" class="btn btn-success" id="bulkLessonImportBtn"><?php echo app('translator')->get('Import'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
            $('#bulkLessonForm').on('submit', function() {
                var btn = $('#bulkLessonImportBtn');
                btn.prop('disabled', true);
                btn.text('Importing...');
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views/admin/lessons/bulk.blade.php ENDPATH**/ ?>