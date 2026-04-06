<!-- Sidebar  -->

<!-- < dashboard side bar -->
<div class="dashboard_profile">
    <div class="dashboard_profile__details">
        <div class="sidebar-menu">
            <span class="sidebar-menu__close"><i class="las la-times"></i></span>
            <div class="logo-wrapper px-3">
                <a href="<?php echo e(route('home')); ?>" class="normal-logo" id="normal-logo"> <img
                        src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png')); ?>" alt="logo-image"></a>
            </div>
            <ul class="sidebar-menu-list">
                <li class="sidebar-menu-list__item">
                    <a href="<?php echo e(route('instructor.home')); ?>"
                        class="sidebar-menu-list__link <?php echo e(Route::is('instructor.home') ? 'active' : ''); ?>">
                        <span class="icon"><i class="fa-solid fa-house"></i></span>
                        <span class="text"><?php echo app('translator')->get('Dashboard'); ?></span>
                    </a>
                </li>
                <li
                    class="sidebar-menu-list__item has-dropdown <?php echo e(isActiveRoute('instructor.course.index') || isActiveRoute('instructor.lesson.lessons') || isActiveRoute('instructor.group.all') || isActiveRoute('instructor.lesson.create') ? 'active' : ''); ?>">
                    <a href="javascript:void(0)"
                        class="sidebar-menu-list__link <?php echo e(isActiveRoute('instructor.course.index') || isActiveRoute('instructor.lesson.lessons') || isActiveRoute('instructor.group.all') || isActiveRoute('instructor.lesson.create') ? 'active' : ''); ?>">
                        <span class="icon"><i class="fa-solid fa-building"></i></span>
                        <span class="text"><?php echo app('translator')->get('My Course'); ?></span>
                    </a>
                    <div
                        class="sidebar-submenu <?php echo e(isActiveRoute('instructor.course.index') || isActiveRoute('instructor.lesson.lessons') || isActiveRoute('instructor.group.all') || isActiveRoute('instructor.lesson.create') ? 'd-block' : ''); ?>">
                        <ul class="sidebar-submenu-list ">

                            <li class="sidebar-submenu-list__item ">
                                <a href="<?php echo e(route('instructor.course.index')); ?>" 
                                    class="sidebar-submenu-list__link"><?php echo app('translator')->get('Courses'); ?></a>
                            </li>


                            <li class="sidebar-submenu-list__item">
                                <a href="<?php echo e(route('instructor.lesson.create')); ?>"
                                    class="sidebar-submenu-list__link"><?php echo app('translator')->get('Add Lesson'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="sidebar-menu-list__item has-dropdown <?php echo e(isActiveRoute('instructor.quiz.create') || isActiveRoute('instructor.quiz.index') || isActiveRoute('instructor.quiz.participants') ? 'active' : ''); ?>">
                    <a href="javascript:void(0)"
                        class="sidebar-menu-list__link <?php echo e(isActiveRoute('instructor.quiz.create') || isActiveRoute('instructor.quiz.index') || isActiveRoute('instructor.quiz.participants') ? 'active' : ''); ?>">
                        <span class="icon"><i class="fa-solid fa-newspaper"></i></span>
                        <span class="text"><?php echo app('translator')->get('Quizzes'); ?></span>
                    </a>
                    <div
                        class="sidebar-submenu <?php echo e(isActiveRoute('instructor.quiz.create') || isActiveRoute('instructor.quiz.index') || isActiveRoute('instructor.quiz.participants') ? 'd-block' : ''); ?>">
                        <ul class="sidebar-submenu-list">
                            <li class="sidebar-submenu-list__item ">
                                <a href="<?php echo e(route('instructor.quiz.create')); ?>"
                                    class="sidebar-submenu-list__link"><?php echo app('translator')->get('Add New'); ?></a>
                            </li>
                            <li class="sidebar-submenu-list__item">
                                <a href="<?php echo e(route('instructor.quiz.index')); ?>"
                                    class="sidebar-submenu-list__link"><?php echo app('translator')->get('List'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="sidebar-menu-list__item has-dropdown <?php echo e(isActiveRoute('instructor.kyc.form') || isActiveRoute('instructor.kyc.data') ? 'active' : ''); ?> ">
                    <a href="javascript:void(0)"
                        class="sidebar-menu-list__link <?php echo e(isActiveRoute('instructor.kyc.form') || isActiveRoute('instructor.kyc.data') ? 'active' : ''); ?>">
                        <span class="icon"><i class="fa-solid fa-address-card"></i></span>
                        <span class="text"><?php echo app('translator')->get('KYC'); ?></span>
                    </a>
                    <div
                        class="sidebar-submenu <?php echo e(isActiveRoute('instructor.kyc.form') || isActiveRoute('instructor.kyc.data') ? 'd-block' : ''); ?> ">
                        <ul class="sidebar-submenu-list">
                            <li class="sidebar-submenu-list__item active">
                                <a href="<?php echo e(route('instructor.kyc.form')); ?>"
                                    class="sidebar-submenu-list__link"><?php echo app('translator')->get('KYC form'); ?></a>
                            </li>

                            <li class="sidebar-submenu-list__item">
                                <a href="<?php echo e(route('instructor.kyc.data')); ?>"
                                    class="sidebar-submenu-list__link"><?php echo app('translator')->get('KYC Data'); ?></a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-list__item">
                    <a href="<?php echo e(route('instructor.quiz.certificate.all')); ?>"
                        class="sidebar-menu-list__link <?php echo e(isActiveRoute('instructor.quiz.certificate.all') ? 'active' : ''); ?>">
                        <span class="icon"><i class="fa-solid fa-graduation-cap"></i></span>
                        <span class="text"><?php echo app('translator')->get('Quiz Certificates'); ?></span>
                    </a>
                </li>


                <li class="sidebar-menu-list__item">
                    <a href="<?php echo e(route('instructor.zoom.credential')); ?>"
                        class="sidebar-menu-list__link <?php echo e(isActiveRoute('instructor.zoom.credential') ? 'active' : ''); ?>">
                        <span class="icon"><i class="fa-solid fa-key"></i></span>
                        <span class="text"><?php echo app('translator')->get('Zoom Credentials'); ?></span>
                    </a>
                </li>

                <li
                    class="sidebar-menu-list__item has-dropdown <?php echo e(isActiveRoute('instructor.withdraw') || isActiveRoute('instructor.withdraw.history') ? 'active' : ''); ?>">
                    <a href="javascript:void(0)"
                        class="sidebar-menu-list__link <?php echo e(isActiveRoute('instructor.withdraw') || isActiveRoute('instructor.withdraw.history') ? 'active' : ''); ?>">
                        <span class="icon"><i class="fa-solid fa-wallet"></i></span>
                        <span class="text"><?php echo app('translator')->get('Withdraw'); ?></span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(isActiveRoute('instructor.withdraw') ? 'd-block' : ''); ?>">
                        <ul class="sidebar-submenu-list">
                            <li class="sidebar-submenu-list__item">
                                <a href="<?php echo e(route('instructor.withdraw')); ?>"
                                    class="sidebar-submenu-list__link"><?php echo app('translator')->get('Withdraw Money'); ?></a>
                            </li>
                            <li class="sidebar-submenu-list__item">
                                <a href="<?php echo e(route('instructor.withdraw.history')); ?>"
                                    class="sidebar-submenu-list__link "><?php echo app('translator')->get('Withdraw History'); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="sidebar-menu-list__item has-dropdown <?php echo e(isActiveRoute('instructor.profile.setting') || isActiveRoute('instructor.change.password') || isActiveRoute('instructor.twofactor') ? 'active' : ''); ?>">
                    <a href="javascript:void(0)"
                        class="sidebar-menu-list__link <?php echo e(isActiveRoute('instructor.profile.setting') || isActiveRoute('instructor.change.password') || isActiveRoute('instructor.twofactor') ? 'active' : ''); ?>">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>
                        <span class="text"><?php echo app('translator')->get('Account'); ?></span>
                    </a>
                    <div
                        class="sidebar-submenu <?php echo e(isActiveRoute('instructor.profile.setting') || isActiveRoute('instructor.change.password') || isActiveRoute('instructor.twofactor') ? 'd-block' : ''); ?>">
                        <ul class="sidebar-submenu-list">
                            <li class="sidebar-submenu-list__item">
                                <a href="<?php echo e(route('instructor.profile.setting')); ?>"
                                    class="sidebar-submenu-list__link"><?php echo app('translator')->get('Profile Setting'); ?></a>
                            </li>
                            <li class="sidebar-submenu-list__item">
                                <a href="<?php echo e(route('instructor.change.password')); ?>"
                                    class="sidebar-submenu-list__link"><?php echo app('translator')->get('Change Password'); ?> </a>
                            </li>
                            <li class="sidebar-submenu-list__item">
                                <a href="<?php echo e(route('instructor.twofactor')); ?>"
                                    class="sidebar-submenu-list__link"><?php echo app('translator')->get('2Fa Security'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="sidebar-menu-list__item">
                    <a href="<?php echo e(route('instructor.transactions')); ?>"
                        class="sidebar-menu-list__link <?php echo e(Route::is('instructor.transactions') ? 'active' : ''); ?>">
                        <span class="icon"><i class="fa-solid fa-money-bill"></i></span>
                        <span class="text"><?php echo app('translator')->get('Transactions'); ?></span>
                    </a>
                </li>


                <li class="sidebar-menu-list__item ">
                    <a href="<?php echo e(route('instructor.ticket')); ?>"
                        class="sidebar-menu-list__link <?php echo e(isActiveRoute('instructor.ticket') || isActiveRoute('instructor.ticket.store') || isActiveRoute('instructor.ticket.view') || isActiveRoute('instructor.ticket.reply') ? 'active' : ''); ?>">
                        <span class="icon"><i class="fa-solid fa-headset"></i></span>
                        <span class="text"><?php echo app('translator')->get('Support Ticket'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-list__item">
                    <a href="<?php echo e(route('instructor.logout')); ?>" class="sidebar-menu-list__link">
                        <span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                        <span class="text"><?php echo app('translator')->get('Log Out'); ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- dashboard side bar /> -->
<?php /**PATH C:\xampp\htdocs\team-hifsa-skilset\application\resources\views\presets\default\components\instructor\sidebar.blade.php ENDPATH**/ ?>