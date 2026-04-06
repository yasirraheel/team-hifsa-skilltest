
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-xl-4">
                    <div class="row gy-2 pb-2 gx-2">
                        <div class="col-sm-6 col-xl-12">
                            <a href="<?php echo e(route('admin.report.transaction')); ?>?search=<?php echo e($user->username); ?>">
                                <div class="card prod-p-card background-pattern">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-0">
                                            <div class="col">
                                                <h6 class="m-b-5"><?php echo app('translator')->get('Balance'); ?></h6>
                                                <h3 class="m-b-0"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($user->balance)); ?>

                                                </h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="dashboard-widget__icon las la-money-bill-wave-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    
                        <div class="col-sm-6 col-xl-12">
                            <a href="<?php echo e(route('admin.withdraw.log')); ?>?search=<?php echo e($user->username); ?>">
                                <div class="card prod-p-card background-pattern-white">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-0">
                                            <div class="col">
                                                <h6 class="m-b-5"><?php echo app('translator')->get('Withdrawals'); ?></h6>
                                                <h3 class="m-b-0">
                                                    <?php echo e($general->cur_sym); ?><?php echo e(showAmount($totalWithdrawals)); ?></h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="dashboard-widget__icon las fa-wallet"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-xl-12">
                            <a href="<?php echo e(route('admin.report.transaction')); ?>?search=<?php echo e($user->username); ?>">
                                <div class="card prod-p-card background-pattern">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-0">
                                            <div class="col">
                                                <h6 class="m-b-5"><?php echo app('translator')->get('Transactions'); ?></h6>
                                                <h3 class="m-b-0"><?php echo e($totalTransaction); ?></h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="dashboard-widget__icon las la-exchange-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card p-2">
                            <ul class="d-flex flex-wrap gap-1">
                             
                                <li class="flex-grow-1 flex-shrink-0">
                                    <a class="d-block btn bg--primary"
                                        href="<?php echo e(route('admin.instructors.login', $user->id)); ?>" target="_blank">
                                        <i class="las la-sign-in-alt"></i> <?php echo app('translator')->get('Login as instructor'); ?>
                                    </a>
                                </li>
                                <li class="flex-grow-1 flex-shrink-0">
                                    <a class="d-block btn bg--primary"
                                        href="<?php echo e(route('admin.instructors.notification.log', $user->id)); ?>">
                                        <i class="las la-bell"></i> <?php echo app('translator')->get('Notifiactions'); ?>
                                    </a>
                                </li>
                                <li class="flex-grow-1 flex-shrink-0">
                                    <a class="d-block btn bg--primary"
                                        href="<?php echo e(route('admin.report.login.history')); ?>?search=<?php echo e($user->username); ?>">
                                        <i class="las la-list-alt"></i> <?php echo app('translator')->get('Login History'); ?>
                                    </a>
                                </li>
                                <li class="flex-grow-1 flex-shrink-0">
                                    <?php if($user->status == 1): ?>
                                        <a class="d-block btn bg--primary" class="userStatus" data-bs-toggle="modal"
                                            data-bs-target="#userStatusModal" href="javascript:void(0)">
                                            <i class="las la-ban"></i> <?php echo app('translator')->get('Ban Instructor'); ?>
                                        </a>
                                    <?php else: ?>
                                        <a class="userStatus bg--primary" data-bs-toggle="modal"
                                            data-bs-target="#userStatusModal" href="javascript:void(0)">
                                            <i class="las la-undo"></i> <?php echo app('translator')->get('Unban Instructor'); ?>
                                        </a>
                                    <?php endif; ?>
                                </li>
                                <li class="flex-grow-1 flex-shrink-0">
                                    <a class="d-block btn bg--primary"
                                        href="<?php echo e(route('admin.instructors.notification.single', $user->id)); ?>">
                                        <i class="las la-paper-plane"></i> <?php echo app('translator')->get('Send Email'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-header">
                            <h5 class="card-title mb-0"><?php echo app('translator')->get('Information of'); ?> <?php echo e($user->fullname); ?></h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.instructors.update', [$user->id])); ?>" method="POST"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group  col-xl-3 col-md-6 col-12">
                                        <label><?php echo app('translator')->get('Email Verification'); ?> </label>
                                        <label class="switch m-0">
                                            <input type="checkbox" class="toggle-switch" name="ev"
                                                <?php echo e($user->ev ? 'checked' : null); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="form-group  col-xl-3 col-md-6 col-12">
                                        <label><?php echo app('translator')->get('Mobile Verification'); ?> </label>
                                        <label class="switch m-0">
                                            <input type="checkbox" class="toggle-switch" name="sv"
                                                <?php echo e($user->sv ? 'checked' : null); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="form-group  col-xl-3 col-md-6 col-12">
                                        <label><?php echo app('translator')->get('2FA Verification'); ?> </label>
                                        <label class="switch m-0">
                                            <input type="checkbox" class="toggle-switch" name="ts"
                                                <?php echo e($user->ts ? 'checked' : null); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="form-group  col-xl-3 col-md-6 col-12">
                                        <label><?php echo app('translator')->get('KYC'); ?> </label>
                                        <label class="switch m-0">
                                            <input type="checkbox" class="toggle-switch" name="kv"
                                                <?php echo e($user->kv ? 'checked' : null); ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label><?php echo app('translator')->get('First Name'); ?></label>
                                            <input class="form-control" type="text" name="firstname" required
                                                value="<?php echo e($user->firstname); ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"><?php echo app('translator')->get('Last Name'); ?></label>
                                            <input class="form-control" type="text" name="lastname" required
                                                value="<?php echo e($user->lastname); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Email'); ?> </label>
                                            <input class="form-control" type="email" name="email"
                                                value="<?php echo e($user->email); ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('Mobile Number'); ?> </label>
                                            <div class="input-group ">
                                                <span class="input-group-text mobile-code"></span>
                                                <input type="number" name="mobile" value="<?php echo e(old('mobile')); ?>"
                                                    id="mobile" class="form-control checkUser" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="form-group ">
                                            <label><?php echo app('translator')->get('Address'); ?></label>
                                            <input class="form-control" type="text" name="address"
                                                value="<?php echo e(@$user->address->address); ?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group">
                                            <label><?php echo app('translator')->get('City'); ?></label>
                                            <input class="form-control" type="text" name="city"
                                                value="<?php echo e(@$user->address->city); ?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group ">
                                            <label><?php echo app('translator')->get('State'); ?></label>
                                            <input class="form-control" type="text" name="state"
                                                value="<?php echo e(@$user->address->state); ?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group ">
                                            <label><?php echo app('translator')->get('Zip/Postal'); ?></label>
                                            <input class="form-control" type="text" name="zip"
                                                value="<?php echo e(@$user->address->zip); ?>">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group ">
                                            <label><?php echo app('translator')->get('Country'); ?></label>
                                            <select name="country" class="form-control">
                                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option data-mobile_code="<?php echo e($country->dial_code); ?>"
                                                        value="<?php echo e($key); ?>"><?php echo e(__($country->country)); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="form-group  text-end mb-0">
                                            <button type="submit" class="btn btn--primary btn-global"><?php echo app('translator')->get('Save'); ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span><?php echo app('translator')->get('Balance'); ?></span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.instructors.add.sub.balance', $user->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="act">
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Amount'); ?></label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control"
                                    placeholder="<?php echo app('translator')->get('Please provide positive amount'); ?>" required>
                                <div class="input-group-text"><?php echo e(__($general->cur_text)); ?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Remark'); ?></label>
                            <textarea class="form-control" placeholder="<?php echo app('translator')->get('Remark'); ?>" name="remark" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary btn-global"><?php echo app('translator')->get('Save'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="userStatusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?php if($user->status == 1): ?>
                            <span><?php echo app('translator')->get('Ban User'); ?></span>
                        <?php else: ?>
                            <span><?php echo app('translator')->get('Unban User'); ?></span>
                        <?php endif; ?>
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.instructors.status', $user->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <?php if($user->status == 1): ?>
                            <h6 class="mb-2"><?php echo app('translator')->get('If you ban this user he/she won\'t able to access his/her
                                                    dashboard.'); ?></h6>
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Reason'); ?></label>
                                <textarea class="form-control" name="reason" rows="4" required></textarea>
                            </div>
                        <?php else: ?>
                            <p><span><?php echo app('translator')->get('Ban reason was'); ?>:</span></p>
                            <p><?php echo e($user->ban_reason); ?></p>
                            <h4 class="text-center mt-3"><?php echo app('translator')->get('Are you sure to unban this user?'); ?></h4>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <?php if($user->status == 1): ?>
                            <button type="submit" class="btn btn--primary btn-global"><?php echo app('translator')->get('Save'); ?></button>
                        <?php else: ?>
                            <button type="button" class="btn btn--dark"
                                data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                            <button type="submit" class="btn btn--primary"><?php echo app('translator')->get('Yes'); ?></button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict"
            $('.bal-btn').on('click', function() {
                var act = $(this).data('act');
                $('#addSubModal').find('input[name=act]').val(act);
                if (act == 'add') {
                    $('.type').text('Add');
                } else {
                    $('.type').text('Subtract');
                }
            });
            let mobileElement = $('.mobile-code');
            $('select[name=country]').change(function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

            $('select[name=country]').val('<?php echo e(@$user->country_code); ?>');
            let dialCode = $('select[name=country] :selected').data('mobile_code');
            let mobileNumber = `<?php echo e($user->mobile); ?>`;
            mobileNumber = mobileNumber.replace(dialCode, '');
            $('input[name=mobile]').val(mobileNumber);
            mobileElement.text(`+${dialCode}`);

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\admin\instructors\detail.blade.php ENDPATH**/ ?>