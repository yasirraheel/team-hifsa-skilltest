

<?php $__env->startSection('panel'); ?>
<div class="row">

    <div class="col-xl-12">
        <div class="card">
            <form action="<?php echo e(route('admin.subscriber.send.email')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="fw-bold"><?php echo app('translator')->get('Subject'); ?></label>
                            <input type="text" class="form-control" name="subject" required
                                value="<?php echo e(old('subject')); ?>" />
                        </div>
                        <div class="form-group col-md-12">
                            <label class="fw-bold"><?php echo app('translator')->get('Body'); ?></label>
                            <textarea name="body" rows="10" class="form-control trumEdit"><?php echo e(old('body')); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-end">
                            <button type="submit" class="btn btn--primary btn-global"><?php echo app('translator')->get('Send Email'); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
<a href="<?php echo e(route('admin.subscriber.index')); ?>" class="btn btn-sm btn--primary"><i class="las la-undo"></i>
    <?php echo app('translator')->get('Back'); ?></a>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\subscriber\send_email.blade.php ENDPATH**/ ?>