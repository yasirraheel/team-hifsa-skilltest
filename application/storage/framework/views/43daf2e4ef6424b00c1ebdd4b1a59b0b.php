
<?php $__env->startSection('panel'); ?>
<div class="row mb-none-30">
  <div class="col-lg-12">
    <div class="card">
      <form action="" method="post">
        <?php echo csrf_field(); ?>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label><?php echo app('translator')->get('Status'); ?></label>
                <label class="switch m-0">
                  <input type="checkbox" class="toggle-switch" name="status" <?php echo e(@$cookie->data_values->status ?
                  'checked' : null); ?>>
                  <span class="slider round"></span>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label><?php echo app('translator')->get('Short Description'); ?></label>
            <textarea class="form-control" rows="5" required
              name="short_desc"><?php echo e(@$cookie->data_values->short_desc); ?></textarea>
          </div>
          <div class="form-group">
            <label><?php echo app('translator')->get('Description'); ?></label>
            <textarea class="form-control trumEdit" rows="10"
              name="description"><?php echo @$cookie->data_values->description ?></textarea>
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
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\setting\cookie.blade.php ENDPATH**/ ?>