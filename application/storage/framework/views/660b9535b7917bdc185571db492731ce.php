
<?php $__env->startSection('panel'); ?>
<div class="notify__area">
    <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <a class="notify__item <?php if($notification->read_status == 0): ?> unread--notification <?php endif; ?>"
        href="<?php echo e(route('admin.notification.read',$notification->id)); ?>">
        <div class="notify__thumb bg--primary">
            <img
                src="<?php echo e(getImage(getFilePath('userProfile').'/'.@$notification->user->image,getFileSize('userProfile'))); ?>">
        </div>
        <div class="notify__content">
            <h6 class="title"><?php echo e(__($notification->title)); ?></h6>
            <span class="date"><i class="las la-clock"></i> <?php echo e($notification->created_at->diffForHumans()); ?></span>
        </div>
    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="card">
        <div class="card-body">
            <h3 class="text-center"><?php echo e(__($emptyMessage)); ?></h3>
        </div>
    </div>
    <?php endif; ?>
    <div class="mt-3">
        <?php echo e(paginateLinks($notifications)); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('breadcrumb-plugins'); ?>
<a href="<?php echo e(route('admin.notifications.readAll')); ?>" class="btn btn--primary"><?php echo app('translator')->get('Mark All as Read'); ?></a>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views/admin/notifications.blade.php ENDPATH**/ ?>