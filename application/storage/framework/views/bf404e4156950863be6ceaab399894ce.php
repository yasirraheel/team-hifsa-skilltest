
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive--sm">
                        <table class="table align-items-center table--light">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Short Code'); ?></th>
                                    <th><?php echo app('translator')->get('Description'); ?></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php $__empty_1 = true; $__currentLoopData = $template->shortcodes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shortcode => $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <th><span class="short-codes"><?php echo "{{ ". $shortcode ." }}" ?></span></th>
                                        <td><?php echo e(__($key)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="100%" class="text-muted text-center"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- card end -->

            <h6 class="mt-4 mb-2"><?php echo app('translator')->get('Default Short Codes'); ?></h6>
            <div class="card overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive--sm">
                        <table class=" table align-items-center table--light">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Short Code'); ?> </th>
                                    <th><?php echo app('translator')->get('Description'); ?></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php $__currentLoopData = $general->global_shortcodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shortCode => $codeDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><span class="short-codes">{{ <?php echo $shortCode ?> }}</span></td>
                                        <td><?php echo e(__($codeDetails)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <form action="<?php echo e(route('admin.setting.notification.template.update', $template->id)); ?>" method="post">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card mt-4">
                    <div class="card-header bg--primary">
                        <h5 class="card-title text-white"><?php echo app('translator')->get('Email Template'); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Status'); ?></label>
                                    <label class="switch m-0">
                                        <input type="checkbox" class="toggle-switch" name="email_status"
                                            <?php echo e($template->email_status ? 'checked' : null); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Subject'); ?></label>
                                    <input type="text" class="form-control form-control-lg"
                                        placeholder="<?php echo app('translator')->get('Email subject'); ?>" name="subject" value="<?php echo e($template->subj); ?>"
                                        required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Message'); ?> <span class="text-danger">*</span></label>
                                    <textarea name="email_body" rows="10" class="form-control trumEdit" placeholder="<?php echo app('translator')->get('Your message using short-codes'); ?>"><?php echo e($template->email_body); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mt-4">
                    <div class="card-header bg--primary">
                        <h5 class="card-title text-white"><?php echo app('translator')->get('SMS Template'); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Status'); ?></label>
                                    <label class="switch m-0">
                                        <input type="checkbox" class="toggle-switch" name="sms_status"
                                            <?php echo e($template->sms_status ? 'checked' : null); ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="fw-bold"><?php echo app('translator')->get('Message'); ?></label>
                                    <textarea name="sms_body" rows="10" class="form-control" placeholder="<?php echo app('translator')->get('Your message using short-codes'); ?>" required><?php echo e($template->sms_body); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-end">
            <button type="submit" class="btn btn--primary btn-global mt-4"><?php echo app('translator')->get('Save'); ?></button>
        </div>
    </form>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('breadcrumb-plugins'); ?>
    <a href="<?php echo e(route('admin.setting.notification.templates')); ?>" class="btn btn-sm btn--primary"><i
            class="las la-undo"></i> <?php echo app('translator')->get('Back'); ?> </a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script></script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\notification\edit.blade.php ENDPATH**/ ?>