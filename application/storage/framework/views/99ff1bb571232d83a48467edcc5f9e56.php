
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="body-area">
                 
                    <form action="<?php echo e(route('instructor.kyc.submit')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php if (isset($component)) { $__componentOriginala5cb17c527dfd01d4b592d168c5b6246 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala5cb17c527dfd01d4b592d168c5b6246 = $attributes; } ?>
<?php $component = App\View\Components\CustomForm::resolve(['identifier' => 'act','identifierValue' => 'instructor_kyc'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('custom-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\CustomForm::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala5cb17c527dfd01d4b592d168c5b6246)): ?>
<?php $attributes = $__attributesOriginala5cb17c527dfd01d4b592d168c5b6246; ?>
<?php unset($__attributesOriginala5cb17c527dfd01d4b592d168c5b6246); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala5cb17c527dfd01d4b592d168c5b6246)): ?>
<?php $component = $__componentOriginala5cb17c527dfd01d4b592d168c5b6246; ?>
<?php unset($__componentOriginala5cb17c527dfd01d4b592d168c5b6246); ?>
<?php endif; ?>
                        <div class="row justify-content-end text-end">
                            <div class="form-group">
                                <button type="submit" class="btn btn--base"><?php echo app('translator')->get('Submit'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'instructor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\kyc\form.blade.php ENDPATH**/ ?>