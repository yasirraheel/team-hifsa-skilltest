
<?php $__env->startSection('content'); ?>
    <div class="profile-wrap ms-3">
        <div class="row justify-content-center">
            <div class="col-12 justify-content-center">
                <div class="base--card">
                    <div class="course-card">
                        <div class="card mb-3">
                           
                            <div class="col-md-12 d-flex justify-content-between">
                                <div class="thumb">
                                    <img src="<?php echo e(getImage(getFilePath('quiz_image') . '/' . @$quiz->image, getFileSize('quiz_image'))); ?>"
                                        class="img-fluid" alt="image">
                                </div>
                                <div class="time">
                                    <h5><?php echo app('translator')->get('Time'); ?> <?php echo e(__(getDurationForHumans(@$quiz->time))); ?>

                                        <?php echo app('translator')->get('Minute'); ?></h5>
                                    <h5><?php echo app('translator')->get('Pass Mark'); ?> <?php echo e(@$quiz->pass_mark); ?> </h5>
                                    <h5><?php echo app('translator')->get('Course Name'); ?> <?php echo e(@$quiz->course->name); ?> </h5>
                                    <h5><?php echo app('translator')->get('Active Quiz'); ?>:
                                        <?php if(@$quiz->active_quiz == 1): ?>
                                            <?php echo app('translator')->get('Active'); ?>
                                        <?php else: ?>
                                            <?php echo app('translator')->get('Closed'); ?>
                                        <?php endif; ?>

                                    </h5>
                                </div>
                            </div>

                            <div class="col-md-8 mt-md-0 my-lg-auto mt-4 my-auto">
                                <div class="content">
                                    <div>
                                        <h5 class="mt-3"><?php echo e(__(@$quiz->name)); ?></h5>
                                        <div class="wyg"><?php echo __(@$quiz->description) ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="javascript:void(0)" onclick="videoModal(this)" data-url="<?php echo e(route('user.quiz.start', @$quiz->id)); ?>" class="btn btn--base"><?php echo app('translator')->get('Start'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel"><?php echo app('translator')->get('Confirmation Alert'); ?></h5>
                    <button type="button" class="btn-close btn " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="GET" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <p><?php echo app('translator')->get('Are you sure? You want to start this Quiz?'); ?></p>
                        <input type="text" hidden name="fileName" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base" data-bs-dismiss="modal"
                            data-modal="1"><?php echo app('translator')->get('Yes'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .course-card {
            overflow: hidden;
        }

        .course-card .card {
            padding: 15px;
        }

        .course-card .card .content {
            padding-left: 12px;
        }

        .course-card .thumb img {
            height: 300px;
            border-radius: 10px;

        }

        .wyg h1,
        h2,
        h3,
        h4 {
            color: #383838;
        }

        .wyg strong {
            color: #383838
        }

        .wyg p {
            color: #666666
        }

        .wyg ul {
            margin-left: 40px
        }

        .wyg ul li {
            list-style-type: disc;
            color: #666666
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        function videoModal(object) {
            var videoModal = $('#videoModal');
            var url = $(object).data('url');
            videoModal.find('form').attr('action', url);
            videoModal.modal('show');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\user\quiz\details.blade.php ENDPATH**/ ?>