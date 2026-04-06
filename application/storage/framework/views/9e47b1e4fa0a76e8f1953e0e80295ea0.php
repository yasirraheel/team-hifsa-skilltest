

<?php $__env->startSection('panel'); ?>
<div class="row gy-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body ">
                <h6 class="card-title  mb-4">
                    <div class="row">
                        <div class="col-sm-8 col-md-6">
                            <?php echo $ticket->statusBadge; ?>
                            [<?php echo app('translator')->get('Ticket#'); ?><?php echo e($ticket->ticket); ?>] <?php echo e($ticket->subject); ?>

                        </div>
                        <div class="col-sm-4  col-md-6 text-sm-end mt-sm-0 mt-3">
                            <?php if($ticket->status != 3): ?>
                            <button class="btn btn--danger btn-sm" type="button" data-bs-toggle="modal"
                                data-bs-target="#DelModal"><?php echo app('translator')->get('Close Ticket'); ?>
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </h6>
                <form action="<?php echo e(route('admin.ticket.reply', $ticket->id)); ?>" enctype="multipart/form-data"
                    method="post" class="form-horizontal">
                    <?php echo csrf_field(); ?>


                    <div class="row ">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" name="message" rows="5" required
                                    id="inputMessage"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row form-group">
                                <div class="col-12 mb-2">
                                    <span><?php echo app('translator')->get('Maximum upload size:'); ?> <?php echo e(ini_get('upload_max_filesize')); ?></span>
                                </div>
                                <div class="col-9">
                                    <div class="file-upload-wrapper" data-text="<?php echo app('translator')->get('Select your file!'); ?>">
                                        <input type="file" name="attachments[]" id="inputAttachments"
                                            class="file-upload-field" />
                                    </div>
                                </div>
                                <div class="col-3">
                                    <button type="button" class="btn btn--white extraTicketAttachment ms-0"><i
                                            class="fa fa-plus"></i></button>
                                </div>
                                <div class="col-12">
                                    <div id="fileUploadsContainer"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 offset-md-3">
                            <button class="btn btn--primary mt-4 float-end" type="submit" name="replayTicket"
                                value="1"><?php echo app('translator')->get('Reply'); ?>
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title border-bottom pb-2 w-100"><?php echo app('translator')->get('Ticket Replies'); ?></h4>
                <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($message->admin_id == 0): ?>
                <div class="row user-reply float-end">
                    <div class="col">
                        <p class="text-muted fw-bold my-3"><span class="text--primary">
                                <?php if($ticket->user_id != null): ?>
                                <a href="<?php echo e(route('admin.users.detail', $ticket->user_id)); ?>">&#64;<?php echo e($ticket->name); ?></a>
                                <?php else: ?>
                                <?php echo e($ticket->name); ?>

                                <?php endif; ?></span> <?php echo app('translator')->get('replied on'); ?> <?php echo e(showDateTime($message->created_at, 'l, dS F Y @
                            H:i')); ?>

                        </p>
                        <p><?php echo e($message->message); ?></p>
                        <?php if($message->attachments->count() > 0): ?>
                        <div class="my-3">
                            <?php $__currentLoopData = $message->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('admin.ticket.download',encrypt($image->id))); ?>" class="me-2"><i
                                    class="fa fa-file"></i> <?php echo app('translator')->get('Attachment'); ?> <?php echo e(++$k); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php endif; ?>
                        <button class="btn btn-danger btn-sm my-3 confirmationBtn float-end"
                            data-question="<?php echo app('translator')->get('Are you sure to delete this message?'); ?>"
                            data-action="<?php echo e(route('admin.ticket.delete',$message->id)); ?>"><i
                                class="la la-trash"></i></button>
                    </div>
                </div>
                <?php else: ?>
                <div class="row admin-reply">
                    <div class="col">
                        <p class="text-muted fw-bold my-3">
                            <span class="text--primary"><?php echo e(@$message->admin->name); ?></span> <?php echo app('translator')->get('replied on'); ?>
                            <?php echo e(showDateTime($message->created_at,'l, dS
                            F Y @ H:i')); ?>

                        </p>
                        <p><?php echo e($message->message); ?></p>
                        <?php if($message->attachments->count() > 0): ?>
                        <div class="my-3">
                            <?php $__currentLoopData = $message->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('admin.ticket.download',encrypt($image->id))); ?>" class="me-2"><i
                                    class="fa fa-file"></i> <?php echo app('translator')->get('Attachment'); ?> <?php echo e(++$k); ?> </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php endif; ?>
                        <button class="btn btn-danger btn-sm my-3 confirmationBtn float-end"
                            data-question="<?php echo app('translator')->get('Are you sure to delete this message?'); ?>"
                            data-action="<?php echo e(route('admin.ticket.delete',$message->id)); ?>"><i
                                class="la la-trash"></i></button>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <?php echo app('translator')->get('Close Support Ticket!'); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo app('translator')->get('Are you want to close this support ticket?'); ?></p>
            </div>
            <div class="modal-footer">
                <form method="post" action="<?php echo e(route('admin.ticket.close', $ticket->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="replayTicket" value="2">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal"> <?php echo app('translator')->get('No'); ?> </button>
                    <button type="submit" class="btn btn--primary"> <?php echo app('translator')->get('Yes'); ?> </button>
                </form>
            </div>
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
<a href="<?php echo e(route('admin.ticket')); ?>" class="btn btn-sm btn--primary"><?php echo app('translator')->get('Back'); ?>
</a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>
    "use strict";
    (function ($) {
        $('.delete-message').on('click', function (e) {
            $('.message_id').val($(this).data('id'));
        })
        var fileAdded = 0;
        $('.extraTicketAttachment').on('click', function () {
            if (fileAdded >= 4) {
                notify('error', 'You\'ve added maximum number of file');
                return false;
            }
            fileAdded++;
            $("#fileUploadsContainer").append(`
                    <div class="row">
                        <div class="col-9 mb-3">
                            <div class="file-upload-wrapper" data-text="<?php echo app('translator')->get('Select your file!'); ?>"><input type="file" name="attachments[]" id="inputAttachments" class="file-upload-field"/></div>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn text--danger extraTicketAttachmentDelete"><i class="la la-times ms-0"></i></button>
                        </div>
                    </div>
                `)
        });

        $(document).on('click', '.extraTicketAttachmentDelete', function () {
            fileAdded--;
            $(this).closest('.row').remove();
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\support\reply.blade.php ENDPATH**/ ?>