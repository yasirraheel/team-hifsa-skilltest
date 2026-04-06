
<?php $__env->startSection('panel'); ?>
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body px-4">
                    <form method="post" action="<?php echo e(route('admin.ad.update',$ad->id)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Name'); ?> </label>
                                    <input type="text" class="form-control" name="name" placeholder="<?php echo app('translator')->get('Name'); ?>"
                                         value="<?php echo e($ad->name); ?>" required />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Image'); ?> </label>
                                    <input type="file" class="form-control" name="image" />
                                </div>
                            </div>

                         
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Link'); ?> </label>
                                    <input type="text" class="form-control" name="link" value="<?php echo e($ad->link); ?>" required />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Width'); ?> </label>
                                    <input type="text" class="form-control" placeholder="<?php echo app('translator')->get('Widht'); ?>"
                                        name="width" value="<?php echo e($ad->width); ?>" required readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Height'); ?> </label>
                                    <input type="text" class="form-control" placeholder="<?php echo app('translator')->get('Height'); ?>"
                                        name="height" value="<?php echo e($ad->height); ?>" required  readonly />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <img src="<?php echo e(getImage(getFilePath('ads') . '/' . @$ad->image)); ?>" alt="<?php echo app('translator')->get('adImage'); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-end">
                                <button type="submit" class="btn btn--primary btn-global"><?php echo app('translator')->get('Update'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\ad\edit.blade.php ENDPATH**/ ?>