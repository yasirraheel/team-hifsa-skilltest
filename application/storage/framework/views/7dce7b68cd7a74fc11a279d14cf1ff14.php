
<?php $__env->startSection('content'); ?>
    <div class="profile-wrap ms-3">
        <div class="row justify-content-center">
            <div class="col-12 justify-content-center">
                <div class="base--card">
                    <form class="register" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row gy-4">
                            <div class="col-sm-12">
                                <div class="drop-file-wrap--">
                                    <div class="dashboard_profile_wrap">
                                        <div class="profile_photo mb-2">
                                            <img id="imgPre"
                                                src="<?php echo e(getImage(getFilePath('instructorProfile') . '/' . auth('instructor')->user()?->image, getFileSize('userProfile'))); ?>"
                                                alt="instructor">
                                            <div class="photo_upload">
                                                <label for="file_upload"><i class="fas fa-image"></i></label>
                                                <input type="file" name="image" class="upload_file" id="file_upload"
                                                    onchange="profileImg(this);">
                                            </div>
                                        </div>

                                        <div class="user-info text-center">
                                            <p><span><?php echo app('translator')->get('User Name'); ?>:</span><?php echo e(auth('instructor')->user()->fullname ?? auth('instructor')->user()->username); ?>

                                            </p>
                                            <p><span><?php echo app('translator')->get('Email'); ?>:</span><?php echo e(auth('instructor')->user()->email); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="first_name" class="form--label"><?php echo app('translator')->get('First Name'); ?></label>
                                    <div class="input--group">
                                        <input type="text" class="form--control" id="first_name" placeholder="First Name"
                                            name="firstname" value="<?php echo e($user->firstname); ?>" required>

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="last_name" class="form--label"><?php echo app('translator')->get('Last Name'); ?></label>
                                    <div class="input--group">
                                        <input type="text" class="form--control" id="last_name" placeholder="Last Name"
                                            name="lastname" value="<?php echo e($user->lastname); ?>" required>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email_adress" class="form--label"><?php echo app('translator')->get('E-mail Address'); ?></label>
                                    <div class="input--group">
                                        <input type="text" class="form--control" id="email_adress"
                                            placeholder="Email Address" value="<?php echo e($user->email); ?>" readonly>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="state" class="form--label"><?php echo app('translator')->get('State'); ?></label>
                                    <div class="input--group">
                                        <input type="text" class="form--control" id="state"
                                            placeholder="Email Address" name="state" value="<?php echo e(@$user->address->state); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form--label"><?php echo app('translator')->get('Country'); ?></label>
                                    <div class="col-sm-12">
                                        <select class="form--control form-select select" name="country">
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option data-mobile_code="<?php echo e($country->dial_code); ?>"
                                                    value="<?php echo e($country->country); ?>" data-code="<?php echo e($key); ?>"
                                                    <?php echo e($user->country_code == $key ? 'selected' : ''); ?>>
                                                    <?php echo e(__($country->country)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="mobile" class="form--label "><?php echo app('translator')->get('Mobile Number'); ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text mobile-code bg--base text-white border-0">
                                        </span>
                                        <input type="hidden" name="mobile_code">
                                        <input type="hidden" name="country_code">
                                        <input type="number" class="form-control form--control checkUser left-padding"
                                            name="mobile" id="mobile" value="<?php echo e($user->mobile); ?>"
                                            placeholder="Mobile number" required>

                                    </div>
                                    <small class="text-danger mobileExist "></small>
                                </div>

                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="zip_code" class="form--label"><?php echo app('translator')->get('Zip Code'); ?></label>
                                    <div class="input--group">
                                        <input type="text" id="zip_code" class="form--control" placeholder="Zip Code"
                                            name="zip" value="<?php echo e(__(@$user->address->zip)); ?>">

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="city" class="form--label"><?php echo app('translator')->get('City'); ?></label>
                                    <div class="input--group">
                                        <input type="text" id="city" class="form--control" placeholder="City"
                                            name="city" value="<?php echo e(__(@$user->address->city)); ?>">

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="address" class="form--label"><?php echo app('translator')->get('Address'); ?></label>
                                    <div class="input--group textarea">
                                        <textarea id="address" class="form--control" placeholder="Address"><?php echo (__(@$user->address->address)) ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 text-end">
                                <button type="submit" class="btn btn--base ms-2">
                                    <?php echo app('translator')->get('Save'); ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        function profileImg(object) {
            const file = object.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#imgPre').attr('src', event.target.result);
                    var form = $(object).closest('form');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>

    <script>
        (function($) {
            "use strict";
            <?php if($mobileCode): ?>
                $(`option[data-code=<?php echo e($mobileCode); ?>]`).attr('selected', '');
            <?php endif; ?>

            $('select[name=country]').on('change', function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            <?php if($general->secure_password): ?>
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });

                $('[name=password]').focus(function() {
                    $(this).closest('.form-group').addClass('hover-input-popup');
                });

                $('[name=password]').focusout(function() {
                    $(this).closest('.form-group').removeClass('hover-input-popup');
                });
            <?php endif; ?>

            $('.checkUser').on('focusout', function(e) {
                var url = '<?php echo e(route('instructor.checkUser')); ?>';
                var value = $(this).val();
                var token = '<?php echo e(csrf_token()); ?>';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {

                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'instructor.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\instructor\profile_setting.blade.php ENDPATH**/ ?>