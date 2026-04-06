
<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('Name'); ?></th>
                                <th><?php echo app('translator')->get('Code'); ?></th>
                                <th><?php echo app('translator')->get('Default'); ?></th>
                                <th><?php echo app('translator')->get('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(__($item->name)); ?></td>
                                <td><strong><?php echo e(__($item->code)); ?></strong></td>
                                <td>
                                    <?php if($item->is_default == 1): ?>
                                    <span
                                        class="text--small badge font-weight-normal badge--success"><?php echo app('translator')->get('Default'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="button--group">
                                        <a title="<?php echo app('translator')->get('Translate'); ?>" href="<?php echo e(route('admin.language.key', $item->id)); ?>"
                                            class="btn btn-sm btn--success">
                                            <i class="la la-language"></i>
                                        </a>
                                        <a title="<?php echo app('translator')->get('Edit'); ?>" href="javascript:void(0)"
                                            class="btn btn-sm btn--primary ms-1 editBtn"
                                            data-url="<?php echo e(route('admin.language.manage.update', $item->id)); ?>"
                                            data-lang="<?php echo e(json_encode($item->only('name', 'text_align', 'is_default'))); ?>">
                                            <i class="la la-pen"></i>
                                        </a>
                                        <?php if($item->id != 1): ?>
                                        <button title="<?php echo app('translator')->get('Edit'); ?>" class="btn btn-sm btn--danger confirmationBtn"
                                            data-question="<?php echo app('translator')->get('Are you sure to remove this language from this system?'); ?>"
                                            data-action="<?php echo e(route('admin.language.manage.delete', $item->id)); ?>">
                                            <i class="la la-trash"></i>
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
        </div><!-- card end -->
    </div>
</div>




<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="createModalLabel"> <?php echo app('translator')->get('Add New Language'); ?></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="las la-times"></i></button>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo e(route('admin.language.manage.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row form-group">
                        <label><?php echo app('translator')->get('Language Name'); ?></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="<?php echo e(old('name')); ?>" name="name" required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label><?php echo app('translator')->get('Language Code'); ?></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="<?php echo e(old('code')); ?>" name="code" required>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label><?php echo app('translator')->get('Default Language'); ?></label>
                        <div class="col-sm-12">
                            <select name="is_default" id="setDefault" class="form-control">
                                <option value="1">Default</option>
                                <option value="0">Not Default</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                        value="add"><?php echo app('translator')->get('Save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel"><?php echo app('translator')->get('Edit Language'); ?></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="las la-times"></i></button>
            </div>
            <form method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-body">

                    <div class="form-group">
                        <label><?php echo app('translator')->get('Language Name'); ?></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" value="<?php echo e(old('name')); ?>" name="name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?php echo app('translator')->get('Default Language'); ?></label>
                        <div class="col-sm-12">
                            <select name="is_default" id="setDefault" class="form-control">
                                <option value="1">Default</option>
                                <option value="0">Not Default</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary btn-global" id="btn-save"
                        value="add"><?php echo app('translator')->get('Save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

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
<?php $__env->stopSection(); ?>


<?php $__env->startPush('breadcrumb-plugins'); ?>
<a class="btn btn-sm btn--primary" data-bs-toggle="modal" data-bs-target="#createModal"><i
        class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?></a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>
    (function ($) {
        "use strict";
        $('.editBtn').on('click', function () {
            var modal = $('#editModal');
            var url = $(this).data('url');
            var lang = $(this).data('lang');

            modal.find('form').attr('action', url);
            modal.find('input[name=name]').val(lang.name);
            modal.find('select[name=text_align]').val(lang.text_align);
            if (lang.is_default == 1) {
                console.log("default");
                modal.find('.modal-body #setDefault').val(1);
            } else {
                modal.find('.modal-body #setDefault').val(0);
            }
            modal.modal('show');
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\language\lang.blade.php ENDPATH**/ ?>