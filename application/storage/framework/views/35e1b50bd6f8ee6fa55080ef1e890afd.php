<?php
    $counterSectionElement = getContent('counter.element', false,4);
?>
<!-- ==================== Experience start ==================== -->
<section class="experience py-80">
    <div class="container">
        <div class="row gy-5">
            <?php $__currentLoopData = $counterSectionElement ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="counterup-item">
                        <h3><span class="odometer" data-odometer-final="<?php echo e(@$item->data_values?->counter_digit); ?>">1</span>+</h3>
                        <h5><?php echo e(__(@$item->data_values?->counter_text)); ?></h5>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<!-- ==================== Experience end ==================== -->
<?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\sections\counter.blade.php ENDPATH**/ ?>