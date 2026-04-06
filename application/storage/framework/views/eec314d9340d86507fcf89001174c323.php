<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.report.login.history') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.report.login.history')); ?>"><?php echo app('translator')->get('User'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.instructor.report.login.history') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.instructor.report.login.history')); ?>"><?php echo app('translator')->get('Instructor'); ?>
                </a>
            </li>

        </ul>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\components\tabs\activities.blade.php ENDPATH**/ ?>