<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.withdraw.pending') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.withdraw.pending')); ?>"><?php echo app('translator')->get('Pending'); ?>
                    <?php if($pendingWithdrawCount): ?>
                    <span class="badge rounded-pill bg--white text-muted"><?php echo e($pendingWithdrawCount); ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.withdraw.approved') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.withdraw.approved')); ?>"><?php echo app('translator')->get('Approved'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.withdraw.rejected') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.withdraw.rejected')); ?>"><?php echo app('translator')->get('Rejected'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.withdraw.log') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.withdraw.log')); ?>"><?php echo app('translator')->get('All'); ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.withdraw.method.index') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.withdraw.method.index')); ?>"><?php echo app('translator')->get('Withdrawal Methods'); ?>
                </a>
            </li>
        </ul>
    </div>
</div><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\components\tabs\withdrawal.blade.php ENDPATH**/ ?>