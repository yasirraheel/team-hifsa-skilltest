
<?php $__env->startSection('content'); ?>
    <div class="body-wrapper">
        <div class="table-content">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="base--card mt-0">
                        <form action="<?php echo e(route('user.deposit.manual.update')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <p class="text-center mt-2"><?php echo app('translator')->get('You have requested'); ?> <b
                                            class="text-success"><?php echo e(showAmount($data['amount'])); ?>

                                            <?php echo e(__($general->cur_text)); ?></b> , <?php echo app('translator')->get('Please pay'); ?>
                                        <b class="text-success"><?php echo e(showAmount($data['final_amo']) . ' ' . $data['method_currency']); ?>

                                        </b> <?php echo app('translator')->get('for successful payment'); ?>
                                    </p>
                                    <h4 class="text-center mb-4"><?php echo app('translator')->get('Please follow the instruction below'); ?></h4>
                                    <p class="my-4 text-center"><?php echo  $data->gateway->description ?></p>
                                </div>
                                <?php if (isset($component)) { $__componentOriginala5cb17c527dfd01d4b592d168c5b6246 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala5cb17c527dfd01d4b592d168c5b6246 = $attributes; } ?>
<?php $component = App\View\Components\CustomForm::resolve(['identifier' => 'id','identifierValue' => ''.e($gateway->form_id).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
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
                                <div class="col-md-12 mt-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn--base button w-100 p-2"><?php echo app('translator')->get('Pay Now'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views/presets/default/user/payment/manual.blade.php ENDPATH**/ ?>