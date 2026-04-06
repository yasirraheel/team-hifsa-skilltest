<!doctype html>
<html lang="<?php echo e(config('app.locale')); ?>" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title> <?php echo e($general->siteName(__($pageTitle))); ?></title>

    <?php echo $__env->make('includes.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <link href="<?php echo e(asset('assets/common/css/bootstrap.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('assets/common/css/all.min.css')); ?>" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo e(asset('assets/common/css/line-awesome.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/custom.css')); ?>">

    <!-- Magnific Popup CSS-->
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/magnific-popup.css')); ?>">
    <!-- Slick CSS-->
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/slick.css')); ?>">
    <!-- Odometer CSS-->
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/odometer.css')); ?>">
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/main.css')); ?>">


    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/select2.min.css')); ?>">
    <?php echo $__env->yieldPushContent('style-lib'); ?>
    <?php echo $__env->yieldPushContent('style'); ?>

    <link rel="stylesheet"
        href="<?php echo e(asset($activeTemplateTrue . 'css/color.php')); ?>?color=<?php echo e($general->base_color); ?>&secondColor=<?php echo e($general->secondary_color); ?>">
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

    <section class="dashboard-section">
        <div class="dashboard">
            <?php echo $__env->make($activeTemplate . 'components.instructor.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!-- dashboard side bar /> -->
            <div class="dashboard-container-wrap">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="dashboard-body">
                                <!-- < dashboard header -->
                                <?php echo $__env->make($activeTemplate . 'components.instructor.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <!-- dashboard header /> -->
                                <div>
                                    <?php echo $__env->yieldContent('content'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo e(asset('assets/common/js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/common/js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- apexcharts js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/apexcharts.min.js')); ?>"></script>
    <!-- Slick js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/slick.min.js')); ?>"></script>
    <!-- Magnific Popup js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/jquery.magnific-popup.min.js')); ?>"></script>
    <!-- Odometer js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/odometer.min.js')); ?>"></script>
    <!-- Viewport js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/viewport.jquery.js')); ?>"></script>
    <!-- main js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/main.js')); ?>"></script>
    <!-- wow js -->
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/select2.min.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('script-lib'); ?>
    <?php echo $__env->make('includes.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('includes.plugins', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('script'); ?>

    <script>
        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "<?php echo e(route('home')); ?>/change/" + $(this).val();
            });

        })(jQuery);
    </script>

    <script>
        (function($) {
            "use strict";

            $('form').on('submit', function() {
                if ($(this).valid()) {
                    $(':submit', this).attr('disabled', 'disabled');
                }
            });

            var inputElements = $('[type=text],[type=password],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function(i, element) {

                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }

            });


            $('.showFilterBtn').on('click', function() {
                $('.responsive-filter-card').slideToggle();
            });


            let headings = $('.table th');
            let rows = $('.table tbody tr');
            let columns
            let dataLabel;

            $.each(rows, function(index, element) {
                columns = element.children;
                if (columns.length == headings.length) {
                    $.each(columns, function(i, td) {
                        dataLabel = headings[i].innerText;
                        $(td).attr('data-label', dataLabel)
                    });
                }
            });

            $(".trumEdit").each(function() {
                ClassicEditor
                    .create(this)
                    .then(editor => {
                        window.editor = editor;
                    });
            });

        })(jQuery);
    </script>


</body>

</html>
<?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\layouts\master.blade.php ENDPATH**/ ?>