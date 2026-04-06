
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive--sm">
                        <table class="table align-items-center table--light">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Short Code'); ?></th>
                                    <th><?php echo app('translator')->get('Description'); ?></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php $__empty_1 = true; $__currentLoopData = $template->shortcodes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shortcode => $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <th><span class="short-codes"><?php echo "{{ ". $shortcode ." }}" ?></span></th>
                                        <td><?php echo e(__($key)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="100%" class="text-muted text-center"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- card end -->

        </div>
    </div>

    <form action="<?php echo e(route('admin.certificate.update', $template->id)); ?>" method="post">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header bg--primary">
                        <h5 class="card-title text-white"><?php echo app('translator')->get('Certificate Template'); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Template'); ?> <span class="text-danger">*</span></label>
                                    <textarea name="template" rows="10" class="form-control" id="summernote" placeholder="<?php echo app('translator')->get('Your message using short-codes'); ?>"><?php echo e($template->template); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="form-group text-end">
            <button type="submit" class="btn btn--primary btn-global mt-4"><?php echo app('translator')->get('Save'); ?></button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <a href="<?php echo e(route('admin.setting.notification.templates')); ?>" class="btn btn-sm btn--primary"><i
            class="las la-undo"></i> <?php echo app('translator')->get('Back'); ?> </a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/summernote-lite.min.css')); ?>">
    <style>
        .note-editable{
            height: 100% !important;
        }
    </style>
     
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/admin/js/summernote-lite.min.js')); ?>"></script>
    <script>
        $('#summernote').summernote({
            placeholder: 'Hello stand alone ui',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\certificate\edit.blade.php ENDPATH**/ ?>