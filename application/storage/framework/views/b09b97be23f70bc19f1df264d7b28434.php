<!doctype html>
<html lang="<?php echo e(config('app.locale')); ?>" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> <?php echo e($general->siteName(__($pageTitle))); ?></title>
    <?php echo $__env->make('includes.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Bootstrap CSS -->
    <link href="<?php echo e(asset('assets/common/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/common/css/all.min.css')); ?>" rel="stylesheet">
    <!-- Slick Awesome CSS-->
    <link rel="stylesheet" href="<?php echo e(asset('assets/common/css/line-awesome.min.css')); ?>">
    <!-- Slick CSS-->
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/slick.css')); ?>">
    <!-- Animate CSS-->
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/animate.min.css')); ?>">
    <!-- Odometer CSS-->
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/odometer.css')); ?>">
    <!-- Magnific Popup CSS-->
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/magnific-popup.css')); ?>">
    <!-- plyr -->
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/plyr.css')); ?>">
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/main.css')); ?>">
    <!-- Custom CSS-->
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/custom.css')); ?>">

    <?php echo $__env->yieldPushContent('style-lib'); ?>
    <?php echo $__env->yieldPushContent('style'); ?>

    <link rel="stylesheet"
        href="<?php echo e(asset($activeTemplateTrue . 'css/color.php')); ?>?color1=<?php echo e($general->base_color); ?>&color2=<?php echo e($general->secondary_color); ?>">
</head>

<body>
    <!--==================== Preloader Start ====================-->
    <div id="loading">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <span class="loader"></span>
            </div>
        </div>
    </div>
    <!--==================== Preloader End ====================-->

    <!--==================== Sidebar Overlay End ====================-->
    <div class="sidebar-overlay"></div>
    <!--==================== Sidebar Overlay End ====================-->

    <?php if(
        !Route::is('user.login') &&
            !Route::is('user.register') &&
            !Route::is('user.password.email') &&
            !Route::is('instructor.login') &&
            !Route::is('instructor.register') &&
            !Route::is('instructor.password.email')): ?>
        
        <?php echo $__env->make($activeTemplate . 'components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
    <?php endif; ?>

    <?php
        $pages = App\Models\Page::where('tempname', $activeTemplate)->get();
    ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php if(!Route::is('user.login') && !Route::is('user.register') && !Route::is('user.password.email')&& !Route::is('instructor.login') && !Route::is('instructor.register') && !Route::is('instructor.password.email')): ?>
        
        <?php echo $__env->make($activeTemplate . 'components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
    <?php endif; ?>

    
    <?php echo $__env->make($activeTemplate . 'components.cookie_popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo e(asset('assets/common/js/jquery-3.7.1.min.js')); ?>"></script>



    <!-- moment js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/moment.min.js')); ?>"></script>
    <!-- Slick js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/slick.min.js')); ?>"></script>
    <!-- Odometer js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/odometer.min.js')); ?>"></script>
    <!-- jquery appear js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/jquery.appear.min.js')); ?>"></script>
    <!-- wow js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/wow.min.js')); ?>"></script>
    <!-- Magnific Popup js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/jquery.magnific-popup.min.js')); ?>"></script>
    <!-- plyr -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/plyr.js')); ?>"></script>
    <!-- main js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/main.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/common/js/bootstrap.bundle.min.js')); ?>"></script>
    <script>
        window.initBootstrapTooltips = function(scope) {
            const root = scope || document;
            const triggers = root.querySelectorAll('[data-bs-toggle="tooltip"]');
            triggers.forEach((el) => {
                if (!bootstrap.Tooltip.getInstance(el)) {
                    new bootstrap.Tooltip(el);
                }
            });
        };
        document.addEventListener('DOMContentLoaded', function() {
            window.initBootstrapTooltips();
        });
    </script>

    <?php echo $__env->yieldPushContent('script-lib'); ?>
    <?php echo $__env->yieldPushContent('script'); ?>
    <?php echo $__env->make('includes.plugins', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('includes.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('includes.language_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if (isset($component)) { $__componentOriginalbd5922df145d522b37bf664b524be380 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd5922df145d522b37bf664b524be380 = $attributes; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ConfirmationModal::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $attributes = $__attributesOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__attributesOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $component = $__componentOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__componentOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views/presets/default/layouts/frontend.blade.php ENDPATH**/ ?>