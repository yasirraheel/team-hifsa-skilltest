
<?php $__env->startSection('panel'); ?>
    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th class="text-center"><?php echo app('translator')->get('SI'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->get('Question'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->get('Mark'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->get('Created At'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php echo e($loop->iteration); ?>

                                        </td>

                                        <td>
                                            <span><?php echo e(__(@$item->question)); ?></span>
                                        </td>

                                        <td class="text-center">
                                            <?php echo e($item->mark); ?>

                                        </td>

                                        <td class="text-center">
                                            <?php echo e(showDateTime($item->created_at, 'D, M d, Y')); ?>

                                        </td>

                                        <td class="text-center">
                                            <a class="btn btn--danger btn-sm" href="javascript:void(0)"
                                                data-url="<?php echo e(route('admin.question.delete', [@$item->id, $quiz->id])); ?>"
                                                onclick="quizDeleteModal(this)">
                                                <i class="fa-solid fa-trash"></i></a>
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
                <?php if($questions->hasPages()): ?>
                    <div class="card-footer text-end">
                        <?php echo e($questions->links()); ?>

                    </div>
                <?php endif; ?>
            </div><!-- card end -->
        </div>
    </div>

    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel"><?php echo app('translator')->get('Confirmation Alert'); ?></h5>
                    <button type="button" class="btn-close btn " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <p><?php echo app('translator')->get('Are you sure? You want delete this Quiz?'); ?></p>
                        <input type="text" hidden name="fileName" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary" data-bs-dismiss="modal"
                            data-modal="1"><?php echo app('translator')->get('Yes'); ?></button>
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
    <div class="d-flex flex-wrap justify-content-end align-items-center">
        <form method="GET" class="form-inline">
            <div class="input-group justify-content-end">
                <input type="text" name="search" class="form-control bg--white search-color"
                    placeholder="<?php echo app('translator')->get('Search by Username'); ?>" value="<?php echo e(request()->search); ?>">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        function quizDeleteModal(object) {
            var data
            var videoModal = $('#videoModal');
            var url = $(object).data('url');
            videoModal.find('form').attr('action', url);
            videoModal.modal('show');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\question\instructor.blade.php ENDPATH**/ ?>