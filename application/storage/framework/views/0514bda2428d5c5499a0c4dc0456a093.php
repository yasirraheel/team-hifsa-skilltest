

<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <form action="<?php echo e(route('admin.gateway.manual.update', $method->code)); ?>" method="POST"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="payment-method-item">
                        <div class="row mt-4">
                            <div class="col-md-8 col-sm-12">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Name'); ?></label>
                                            <input type="text" class="form-control" name="name"
                                                value="<?php echo e($method->name); ?>" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Currency'); ?></label>
                                            <div class="input-group">
                                                <input type="text" name="currency" class="form-control border-radius-5"
                                                    value="<?php echo e(@$method->singleCurrency->currency); ?>" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Dollar Rate'); ?></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg--primary">1 <?php echo e(__($general->cur_text)); ?>

                                                    =
                                                </span>
                                                <input type="text" class="form-control" name="rate"
                                                    value="<?php echo e(getAmount(@$method->singleCurrency->rate)); ?>" required />
                                                <span class="currency_symbol input-group-text bg--primary"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card border mb-2">
                                            <h5 class="card-header"><?php echo app('translator')->get('Limit'); ?></h5>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Min'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="min_limit"
                                                            value="<?php echo e(getAmount(@$method->singleCurrency->min_amount)); ?>"
                                                            required />
                                                        <span class="input-group-text bg--primary"> <?php echo e(__($general->cur_text)); ?> </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Max'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="max_limit"
                                                            value="<?php echo e(getAmount(@$method->singleCurrency->max_amount)); ?>"
                                                            required />
                                                        <span class="input-group-text bg--primary"> <?php echo e(__($general->cur_text)); ?> </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card border">
                                            <h5 class="card-header"><?php echo app('translator')->get('Transaction Charge'); ?></h5>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Fixed'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="fixed_charge"
                                                            value="<?php echo e(getAmount(@$method->singleCurrency->fixed_charge)); ?>"
                                                            required />
                                                        <span class="input-group-text bg--primary"> <?php echo e(__($general->cur_text)); ?> </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Percentage'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="percent_charge"
                                                            value="<?php echo e(getAmount(@$method->singleCurrency->percent_charge)); ?>"
                                                            required>
                                                        <span class="input-group-text bg--primary">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="card border my-2">
                                    <h5 class="card-header"><?php echo app('translator')->get('Special Instructions'); ?> </h5>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <textarea rows="3" class="form-control trumEdit border-radius-5"
                                                name="instruction"><?php echo e($method->description); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="payment-method-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card border mt-3">
                                        <div class="card-header d-flex justify-content-between">
                                            <h5><?php echo app('translator')->get('User Input Fields'); ?></h5>
                                            <button type="button"
                                                class="btn btn-sm bg--primary float-end form-generate-btn"> <i
                                                    class="la la-fw la-plus"></i><?php echo app('translator')->get('Add New'); ?></button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row addedField">
                                                <?php if($form): ?>
                                                <?php $__currentLoopData = $form->form_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-md-4">
                                                    <div class="card border mb-3" id="<?php echo e($loop->index); ?>">
                                                        <input type="hidden" name="form_generator[is_required][]"
                                                            value="<?php echo e($formData->is_required); ?>">
                                                        <input type="hidden" name="form_generator[extensions][]"
                                                            value="<?php echo e($formData->extensions); ?>">
                                                        <input type="hidden" name="form_generator[options][]"
                                                            value="<?php echo e(implode(',',$formData->options)); ?>">
                                                        <?php
                                                        $jsonData = json_encode([
                                                        'type'=>$formData->type,
                                                        'is_required'=>$formData->is_required,
                                                        'label'=>$formData->name,
                                                        'extensions'=>explode(',',$formData->extensions) ?? 'null',
                                                        'options'=>$formData->options,
                                                        'old_id'=>'',
                                                        ]);
                                                        ?>
                                                        <div class="card-body">
                                                            <div class="form-group text-end">
                                                                <button type="button"
                                                                    class="btn btn--primary editFormData"
                                                                    data-form_item="<?php echo e($jsonData); ?>"
                                                                    data-update_id="<?php echo e($loop->index); ?>"><i
                                                                        class="las la-pen"></i></button>
                                                                <button type="button"
                                                                    class="btn btn--danger removeFormData"><i
                                                                        class="las la-times"></i></button>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><?php echo app('translator')->get('Label'); ?></label>
                                                                <input type="text" name="form_generator[form_label][]"
                                                                    class="form-control" value="<?php echo e($formData->name); ?>"
                                                                    readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label><?php echo app('translator')->get('Type'); ?></label>
                                                                <input type="text" name="form_generator[form_type][]"
                                                                    class="form-control" value="<?php echo e($formData->type); ?>"
                                                                    readonly>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn--primary btn-global"><?php echo app('translator')->get('Save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (isset($component)) { $__componentOriginal057a27a3a026068f335f0c245978414e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal057a27a3a026068f335f0c245978414e = $attributes; } ?>
<?php $component = App\View\Components\FormGenerator::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('form-generator'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\FormGenerator::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal057a27a3a026068f335f0c245978414e)): ?>
<?php $attributes = $__attributesOriginal057a27a3a026068f335f0c245978414e; ?>
<?php unset($__attributesOriginal057a27a3a026068f335f0c245978414e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal057a27a3a026068f335f0c245978414e)): ?>
<?php $component = $__componentOriginal057a27a3a026068f335f0c245978414e; ?>
<?php unset($__componentOriginal057a27a3a026068f335f0c245978414e); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
<style>
    .trumbowyg-box,
    .trumbowyg-editor {
        min-height: 239px !important;
        height: 239px;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
<script>
    "use strict"
    var formGenerator = new FormGenerator();
    formGenerator.totalField = <?php echo e($form ? count((array) $form -> form_data) : 0); ?>

</script>

<script src="<?php echo e(asset('assets/common/js/form_actions.js')); ?>"></script>
<?php $__env->stopPush(); ?>



<?php $__env->startPush('breadcrumb-plugins'); ?>
<a href="<?php echo e(route('admin.gateway.manual.index')); ?>" class="btn btn--primary">
    <?php echo app('translator')->get('Back'); ?> </a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
<style>
    .btn-sm {
        line-height: 5px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>

    (function ($) {
        "use strict";

        $('input[name=currency]').on('input', function () {
            $('.currency_symbol').text($(this).val());
        });
        $('.currency_symbol').text($('input[name=currency]').val());

        <?php if(old('currency')): ?>
            $('input[name=currency]').trigger('input');
        <?php endif; ?>
    })(jQuery);

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\gateways\manual\edit.blade.php ENDPATH**/ ?>