<?php $__empty_1 = true; $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $lessonIndex = ($lessonStartIndex ?? 1) + $key;
    ?>
    <li class="list-group-item lesson-row d-flex flex-column align-items-stretch"
        data-lesson-id="<?php echo e($item->id); ?>">
        <div class="d-flex align-items-center lesson-head w-100"
            onclick="lessonPreview(event, this, <?php echo e(@$course->id); ?>, <?php echo e($item->id); ?>)">
            <i class="fa-regular fa-circle-play pre-i me-2 flex-shrink-0" aria-hidden="true"></i>
            <span class="lesson-title text-truncate"><?php echo e(__($item->title)); ?></span>
        </div>
        <div class="lesson-actions lesson-actions-bar mt-2 w-100">
            <div class="d-flex align-items-center gap-2 flex-nowrap lesson-actions-meta">
            <?php if($item->value == 0): ?>
                <p class="mb-0 text-nowrap lesson-tier"><?php echo app('translator')->get('Free'); ?> <i class="fa-solid fa-lock-open"></i></p>
            <?php else: ?>
                <p class="mb-0 text-nowrap lesson-tier"><?php echo app('translator')->get('Premium'); ?> <i class="fa-solid fa-lock"></i></p>
            <?php endif; ?>
            <?php if(!empty($isEnrolled) && in_array($item->id, $completedLessonIds ?? [])): ?>
                <span class="lesson-completed flex-shrink-0" role="img" aria-label="<?php echo app('translator')->get('Completed'); ?>">
                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                </span>
            <?php endif; ?>
            <span class="text-muted small ms-auto flex-shrink-0" style="font-size: 0.85rem;"><?php echo e($lessonIndex); ?>/<?php echo e($totalLessonsCount ?? '?'); ?></span>
            </div>
            <?php if(!empty($isEnrolled) && in_array($item->id, $completedLessonIds ?? [])): ?>
                <button type="button" class="btn btn-sm btn--base-3 outline lesson-uncomplete-btn flex-shrink-0" data-lesson-id="<?php echo e($item->id); ?>" data-course-id="<?php echo e($course->id); ?>" title="<?php echo app('translator')->get('Undo completion'); ?>">
                    <?php echo app('translator')->get('Undo'); ?>
                </button>
            <?php elseif(!empty($isEnrolled)): ?>
                <button type="button" class="btn btn-sm btn--base lesson-mark-complete-btn flex-shrink-0" data-lesson-id="<?php echo e($item->id); ?>" data-course-id="<?php echo e($course->id); ?>" data-default-html="<?php echo e(e(__('Mark Completed'))); ?>">
                    <?php echo app('translator')->get('Mark Completed'); ?>
                </button>
            <?php endif; ?>
        </div>

        <?php if(!empty($isEnrolled)): ?>
            <div class="lesson-notes mt-3">
                <h6 class="mb-2"><?php echo app('translator')->get('Lesson Notes'); ?></h6>
                <div id="lesson-notes-<?php echo e($item->id); ?>" class="lesson-notes-list">
                    <?php if(isset($lessonNotes[$item->id]) && count($lessonNotes[$item->id])): ?>
                        <?php $__currentLoopData = $lessonNotes[$item->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="note-card mb-2 p-2 rounded border" id="note-<?php echo e($note->id); ?>">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted"><?php echo e(showDateTime($note->created_at)); ?></small>
                                    <div class="note-actions gap-1 d-flex">
                                        <button type="button" class="btn btn-sm btn--base outline lesson-note-edit-btn" data-note-id="<?php echo e($note->id); ?>" data-lesson-id="<?php echo e($item->id); ?>" title="<?php echo app('translator')->get('Edit note'); ?>">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn--danger lesson-note-delete-btn" data-note-id="<?php echo e($note->id); ?>" title="<?php echo app('translator')->get('Delete note'); ?>">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="note-content"><?php echo $note->content; ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="text-muted small"><?php echo app('translator')->get('No notes yet for this lesson'); ?></div>
                    <?php endif; ?>
                </div>

                <button type="button" class="btn btn--base btn--sm mt-2 lesson-note-toggle-btn" data-lesson-id="<?php echo e($item->id); ?>" data-course-id="<?php echo e($course->id); ?>"><?php echo app('translator')->get('Add Note'); ?></button>

                <div id="lesson-note-wrap-<?php echo e($item->id); ?>" class="lesson-note-editor-wrap mt-2 d-none">
                    <textarea id="lesson-note-editor-<?php echo e($item->id); ?>" class="form--control trumEdit" data-lesson-id="<?php echo e($item->id); ?>" data-course-id="<?php echo e($course->id); ?>" placeholder="<?php echo app('translator')->get('Write your note'); ?>"></textarea>
                    <div class="mt-2 gap-2 d-flex">
                        <button type="button" class="btn btn--base btn--sm lesson-note-add-btn" data-lesson-id="<?php echo e($item->id); ?>" data-course-id="<?php echo e($course->id); ?>"><?php echo app('translator')->get('Save Note'); ?></button>
                        <button type="button" class="btn btn--base outline btn--sm lesson-note-cancel-add-btn" data-lesson-id="<?php echo e($item->id); ?>"><?php echo app('translator')->get('Cancel'); ?></button>
                    </div>
                    <div class="lesson-note-status text-success mt-2 d-none" id="lesson-note-status-<?php echo e($item->id); ?>"></div>
                    <div class="lesson-note-error text-danger mt-2 d-none" id="lesson-note-error-<?php echo e($item->id); ?>"></div>
                </div>
            </div>
        <?php endif; ?>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
        <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage ?? 'No lessons found')); ?></td>
    </tr>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views/presets/default/components/lesson_item.blade.php ENDPATH**/ ?>