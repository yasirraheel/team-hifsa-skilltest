
<?php $__env->startSection('content'); ?>
    <div class="row mx-lg-0">
        <div class="col-lg-12">
            <div class="tbl-wrap">
                <div class="col-12 d-lg-flex justify-content-between align-items-center mb-3">
                    <div>
                        <a class="btn btn--base create_course_category" href="<?php echo e(route('instructor.course.create')); ?>"><i
                                class="fa-solid fa-plus"></i>
                            <?php echo app('translator')->get('Add New'); ?>
                        </a>
                    </div>
                    <div>
                        <form method="GET" autocomplete="off">
                            <div class="search-box">
                                <input type="text" class="form--control" name="search" placeholder="<?php echo app('translator')->get('Search...'); ?>"
                                    value="<?php echo e(request()->search); ?>">
                                <button type="submit" class="search-box__button"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="title ms-3 mb-4">
            <h4><?php echo app('translator')->get('My Courses'); ?></h4>
        </div>
        <div class="row gy-4 mx-lg-0 mb-5">
            <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
                    <div class="base-card">
                        <?php if($item->admin_status == 1): ?>
                            <span class="dis-tag"><?php echo app('translator')->get('Approved'); ?></span>
                        <?php else: ?>
                            <span class="dis-tag"><?php echo app('translator')->get('Pending'); ?></span>
                        <?php endif; ?>
                   
                        <div class="view-cta">
                            

                            <a class="btn btn--base btn--sm text-white" href="<?php echo e(route('instructor.course.edit', $item->id)); ?>"
                                title="<?php echo app('translator')->get('Edit'); ?>"><i class="fa-solid fa-pen"></i></a></span>
                            <a class="btn btn--base btn--sm" href="<?php echo e(route('instructor.lesson.lessons', $item->id)); ?>"
                                title="<?php echo app('translator')->get('Course list'); ?>"><i class="fa-solid fa-list-ul"></i></a></span>

                        </div>
                        <div class="thumb-wrap">
                            <img src="<?php echo e(getImage(getFilePath('course_image') . '/' . $item->image)); ?>" alt="...">
                        </div>
                        <div class="content-wrap">
                            <div class="d-flex justify-content-between">
                                <p class="category"><?php echo e(__(@$item->category->name)); ?></p>
                                <a class="btn btn--sm" href="<?php echo e(route('instructor.lesson.lessons', $item->id)); ?>"
                                    title="<?php echo app('translator')->get('Course list'); ?>"><?php echo app('translator')->get('view'); ?></a>
                            </div>
                            <a href="<?php echo e(route('course.details', [slug($item->name), $item->id])); ?>">
                                <h6 class="title"><?php echo e(__(@$item->name)); ?></h6>
                            </a>
                            <ul class="product-status">
                                <li>
                                    <i class="fa-solid fa-clock"></i>
                                    <p><?php echo e(str_replace('ago', '', diffForHumans(@$item->created_at))); ?></p>
                                </li>
                                <li>
                                    <i class="fa-solid fa-graduation-cap"></i>
                                    <p><?php echo e(__(@$item->enrolls->count())); ?> <?php echo app('translator')->get('Students'); ?></p>
                                </li>
                            </ul>
                        </div>
                        <div class="carn-btm">
                            <ul class="star-wrap rating-wrap">
                                <?php
                                    $averageRatingHtml = calculateAverageRating(@$item->average_rating);
                                    if (!empty($averageRatingHtml['ratingHtml'])) {
                                        echo $averageRatingHtml['ratingHtml'];
                                    }
                                ?>

                                <li>
                                    <p> <?php echo e(@$item->average_rating ?? 0); ?>.0
                                        (<?php echo e(@$item->review_count ?? 0); ?>)
                                    </p>
                                </li>
                            </ul>

                            <div class="price-wrap">
                                <?php if(@$item->discount): ?>
                                    <h6 class="price">
                                        <?php echo e(@$general->cur_sym); ?><?php echo e(priceCalculate(@$item->price, @$item->discount)); ?>

                                    </h6>
                                <?php elseif(@$item->price == 0.0): ?>
                                    <h6 class="price"><?php echo app('translator')->get('Free'); ?></h6>
                                <?php else: ?>
                                    <h6 class="price"><?php echo e(@$item->price); ?></h6>
                                <?php endif; ?>


                                <?php if(@$item->discount): ?>
                                    <p class="dis-price">
                                        <?php echo e(@$general->cur_sym); ?><?php echo e(@$item->price); ?>

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
    <?php if($courses->hasPages()): ?>
        <div class="card-footer text-end">
            <?php echo e($courses->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .image-upload .thumb .profilePicPreview {
            width: 100%;
            height: 210px;
            display: block;
            border-radius: 10px;
            background-size: cover !important;
            background-position: top;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
        }

        @media (max-width:1500px) {
            .image-upload .thumb .profilePicPreview {
                height: 152px;
            }
        }

        .image-upload .thumb .profilePicPreview.logoPicPrev {
            background-size: contain !important;
            background-position: center;
        }

        .image-upload .thumb .profilePicUpload {
            font-size: 0;
            display: none;
        }

        .image-upload .thumb .avatar-edit label {
            text-align: center;
            line-height: 32px;
            font-size: 18px;
            cursor: pointer;
            padding: 2px 25px;
            width: 100%;
            border-radius: 5px;
            box-shadow: 0 5px 10px 0 rgb(0 0 0 / 16%);
            transition: all 0.3s;
            margin-top: 6px;
        }

        .image-upload .thumb .profilePicPreview .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            text-align: center;
            width: 34px;
            height: 34px;
            font-size: 23px;
            border-radius: 50%;
            background-color: hsl(var(--base));
            color: #ffffff;
            display: none;
            opacity: .8;
        }

        .image-upload .thumb .profilePicPreview .remove-image:hover {
            opacity: 1;
        }

        .image-upload .thumb .profilePicPreview.has-image .remove-image {
            display: block;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'instructor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\course\index.blade.php ENDPATH**/ ?>