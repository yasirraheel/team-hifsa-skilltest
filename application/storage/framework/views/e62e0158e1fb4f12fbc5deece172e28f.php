
<?php $__env->startSection('content'); ?>
    <div class="mx-lg-0">
        <div class="col-lg-12">
            <div class="tbl-wrap">
                <div class="col-12 mb-3 d-flex justify-content-end">
                    <form method="GET" autocomplete="off">
                        <div class="search-box">
                            <input type="text" class="form--control" name="search" placeholder="<?php echo app('translator')->get('Search...'); ?>"
                                value="<?php echo e(request()->search); ?>">
                            <button type="submit" class="search-box__button"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
                <div>
                    <div class="title ms-3 mb-4">
                        <h4><?php echo app('translator')->get('My Courses'); ?></h4>
                    </div>
                    <div class="row gy-4 mx-lg-0 mb-5">
                        <?php $__empty_1 = true; $__currentLoopData = $enrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
                                <div class="base-card">
                                    <?php if(@$item->course->discount): ?>
                                        <span class="dis-tag">-<?php echo e(@$item->course->discount); ?>% </span>
                                    <?php endif; ?>
                                    <div class="view-cta">
                                        <a href="javascript:void(0)" class="btn btn--base"
                                            onclick="courseVieweModal(this)" data-data="<?php echo e($item); ?>" ><?php echo app('translator')->get('view'); ?></a>
                                    </div>
                                    <div class="thumb-wrap">
                                        <a href="<?php echo e(route('course.details', [slug($item->course->name), $item->course_id])); ?>" class="d-block">
                                            <img src="<?php echo e(getImage(getFilePath('course_image') . '/' . $item->course->image)); ?>"
                                                alt="...">
                                        </a>
                                    </div>
                                    <div class="content-wrap">
                                        <p class="category"><?php echo e(__(@$item->course->category->name)); ?></p>
                                        <a
                                            href="<?php echo e(route('course.details', [slug($item->course->name), $item->course_id])); ?>">
                                            <h6 class="title"><?php echo e(__(@$item->course->name)); ?></h6>
                                        </a>
                                        <ul class="product-status">
                                            <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="<?php echo e(str_replace('ago', '', diffForHumans(@$item->course->created_at))); ?>">
                                                <i class="fa-solid fa-clock"></i>
                                                <p><?php echo e(str_replace('ago', '', diffForHumans(@$item->course->created_at))); ?>

                                                </p>
                                            </li>
                                            <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="<?php echo e(__(@$item->enrollCount($item->id))); ?> <?php echo app('translator')->get('Students'); ?>">
                                                <i class="fa-solid fa-graduation-cap"></i>
                                                <p><?php echo e(__(@$item->enrollCount($item->id))); ?> <?php echo app('translator')->get('Students'); ?></p>
                                            </li>
                                            <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="<?php echo e(@$item->course->quizzes_count ?? 0); ?> <?php echo app('translator')->get('Quizzes'); ?>">
                                                <i class="fa-solid fa-list-check"></i>
                                                <p><?php echo e(@$item->course->quizzes_count ?? 0); ?> <?php echo app('translator')->get('Quizzes'); ?></p>
                                            </li>
                                            <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="<?php echo e(@$item->course->questions_count ?? 0); ?> <?php echo app('translator')->get('Questions'); ?>">
                                                <i class="fa-solid fa-circle-question"></i>
                                                <p><?php echo e(@$item->course->questions_count ?? 0); ?> <?php echo app('translator')->get('Questions'); ?></p>
                                            </li>
                                        </ul>
                                        <?php
                                            $progress = $courseProgress[$item->course_id] ?? ['completed' => 0, 'total' => 0, 'percent' => 0];
                                        ?>
                                        <div class="mt-2"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="<?php echo app('translator')->get('Completed'); ?>: <?php echo e($progress['completed']); ?>/<?php echo e($progress['total']); ?> (<?php echo e($progress['percent']); ?>%)">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small><?php echo app('translator')->get('Progress'); ?></small>
                                                <small><?php echo e($progress['percent']); ?>%</small>
                                            </div>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: <?php echo e($progress['percent']); ?>%;"
                                                    aria-valuenow="<?php echo e($progress['percent']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carn-btm">
                                        <ul class="star-wrap rating-wrap">
                                            <?php
                                                $averageRatingHtml = calculateAverageRating(
                                                    @$item->course->average_rating,
                                                );
                                                if (!empty($averageRatingHtml['ratingHtml'])) {
                                                    echo $averageRatingHtml['ratingHtml'];
                                                }
                                            ?>

                                            <li>
                                                <p> <?php echo e(@$item->course->average_rating ?? 0); ?>.0
                                                    (<?php echo e(@$item->course->review_count ?? 0); ?>)
                                                </p>
                                            </li>
                                        </ul>

                                        <div class="price-wrap">
                                            <?php if(@$item->course->discount): ?>
                                                <h6 class="price">
                                                    <?php echo e(@$general->cur_sym); ?><?php echo e(priceCalculate(@$item->course->price, @$item->course->discount)); ?>

                                                </h6>
                                            <?php elseif(@$item->course->price == 0.0): ?>
                                                <h6 class="price"><?php echo app('translator')->get('Free'); ?></h6>
                                            <?php else: ?>
                                                <h6 class="price"><?php echo e(@$item->course->price); ?></h6>
                                            <?php endif; ?>


                                            <?php if(@$item->course->discount): ?>
                                                <p class="dis-price">
                                                    <?php echo e(@$general->cur_sym); ?><?php echo e(@$item->course->price); ?>

                                                </p>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div>
                                <h5 class="text-muted text-center text--base" colspan="100%"><?php echo app('translator')->get('No data found'); ?></h5>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
    <?php if($enrolls->hasPages()): ?>
        <div class="card-footer text-end">
            <?php echo e($enrolls->links()); ?>

        </div>
    <?php endif; ?>

    <!-- Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel"><?php echo app('translator')->get('Details'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-modal="0"
                        data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\user\quiz\courses.blade.php ENDPATH**/ ?>