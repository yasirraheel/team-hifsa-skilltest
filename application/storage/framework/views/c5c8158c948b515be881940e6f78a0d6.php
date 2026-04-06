
<?php $__env->startSection('panel'); ?>
<div class="row mb-none-30">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6><?php echo app('translator')->get('Warning: Please do it carefully. This might break the design.'); ?></h6>
            </div>
            <form action="" method="post">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="form-group custom-css">
                        <textarea class="customCss" rows="20" name="css"><?php echo e($file_content); ?></textarea>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn--primary btn-global"><?php echo app('translator')->get('Save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
<style>
    .customCss {
    background-color: black;
    color: white;
    font-size: 15px !important;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\setting\custom_css.blade.php ENDPATH**/ ?>