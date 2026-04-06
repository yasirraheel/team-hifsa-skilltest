<div class="tab-content">
    <div class="tab-pane fade active show">
        <div class="row justify-content-center gy-4">
            <?php $__empty_1 = true; $__currentLoopData = $courses ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
                    <div class="base-card">
                        <?php if(@$item->discount): ?>
                            <span class="dis-tag">-<?php echo e(@$item->discount); ?>%</span>
                        <?php endif; ?>
                        <div class="thumb-wrap">
                            <a href="<?php echo e(route('course.details', [slug($item->name), $item->id])); ?>" class="d-block">
                                <img src="<?php echo e(getImage(getFilePath('course_image') . '/' . $item->image)); ?>"
                                    alt="course-image">
                            </a>
                        </div>
                        <div class="content-wrap">
                            <p class="category"><?php echo e(@$item->category?->name); ?></p>
                            <a href="<?php echo e(route('course.details', [slug($item->name), $item->id])); ?>">
                                <h6 class="title"><?php echo e(strLimit(@$item->name, 23)); ?></h6>
                            </a>
                            <ul class="product-status">
                                <li data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="<?php echo e(str_replace('ago', '', diffForHumans(@$item->created_at))); ?>">
                                    <i class="fa-solid fa-clock"></i>
                                    <p><?php echo e(str_replace('ago', '', diffForHumans(@$item->created_at))); ?>

                                    </p>
                                </li>
                                <li data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="<?php echo e($item->enrolls->count()); ?> <?php echo app('translator')->get('Students'); ?>">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                    <p><?php echo e($item->enrolls->count()); ?> <?php echo app('translator')->get('Students'); ?></p>
                                </li>
                                <li data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="<?php echo e($item->quizzes_count ?? 0); ?> <?php echo app('translator')->get('Quizzes'); ?>">
                                    <i class="fa-solid fa-list-check"></i>
                                    <p><?php echo e($item->quizzes_count ?? 0); ?> <?php echo app('translator')->get('Quizzes'); ?></p>
                                </li>
                                <li data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="<?php echo e($item->questions_count ?? 0); ?> <?php echo app('translator')->get('Questions'); ?>">
                                    <i class="fa-solid fa-circle-question"></i>
                                    <p><?php echo e($item->questions_count ?? 0); ?> <?php echo app('translator')->get('Questions'); ?></p>
                                </li>
                            </ul>
                        </div>
                        <div class="carn-btm">
                            <ul class="star-wrap rating-wrap">
                                <?php
                                    $averageRatingHtml = calculateAverageRating($item->average_rating);
                                    if (!empty($averageRatingHtml['ratingHtml'])) {
                                        echo $averageRatingHtml['ratingHtml'];
                                    }
                                    // echo showRatings($item->average_rating) 
                                ?>

                                <li>
                                    <p> <?php echo e(@$item->average_rating ?? 0); ?>.0 (<?php echo e(@$item->review_count ?? 0); ?>)</p>
                                </li>

                            </ul>
                            <div class="price-wrap">
                                <?php if(@$item->discount): ?>
                                    <h6 class="price">
                                        <?php echo e(@$general->cur_sym); ?><?php echo e(priceCalculate(@$item->price, @$item->discount)); ?>

                                    </h6>
                                    <p class="dis-price"><?php echo e(@$general->cur_sym); ?><?php echo e(@$item->price); ?></p>
                                <?php elseif(@$item->price == 0.0): ?>
                                    <h6 class="price"><?php echo app('translator')->get('Free'); ?></h6>
                                <?php else: ?>
                                    <h6 class="price"><?php echo e(@$general->cur_sym); ?><?php echo e(@$item->price); ?></h6>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <h5 class="text-center"><?php echo app('translator')->get('No Course found'); ?></h5>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views/presets/default/components/instructor/category_course.blade.php ENDPATH**/ ?>