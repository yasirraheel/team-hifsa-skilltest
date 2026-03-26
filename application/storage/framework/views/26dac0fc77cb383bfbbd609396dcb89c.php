<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.quiz.index') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.quiz.index')); ?>"><?php echo app('translator')->get('My Quiz'); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::routeIs('admin.quiz.instructor') ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.quiz.instructor')); ?>"><?php echo app('translator')->get('Instructor Quiz'); ?>
                </a>
            </li>

        </ul>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views/admin/components/tabs/quiz.blade.php ENDPATH**/ ?>