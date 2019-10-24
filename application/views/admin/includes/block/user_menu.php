<?php
$user = user_info();
?>
<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
    <a href="#" class="m-nav__link m-dropdown__toggle">
        <span class="m-topbar__userpic">
            <img src="<?php
            $IMG = asset_dir('front/users/' . $user->photo);
            //$IMG = ADMIN_ASSETS_DIR . 'uploads/users/user4.jpg';
            echo _img($IMG ,80,80, USER_IMG_NA); ?>" class="m--img-rounded m--marginless m--img-centered" alt=""/>
        </span>
        <span class="m-topbar__username m--hide">
            <?php echo $user->full_name;?>
        </span>
    </a>
    <div class="m-dropdown__wrapper">
        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
        <div class="m-dropdown__inner">
            <div class="m-dropdown__header m--align-center" id="_user_action-bg">
                <div class="m-card-user m-card-user--skin-dark">
                    <div class="m-card-user__pic">
                        <img src="<?php echo _img($IMG,80,80, USER_IMG_NA); ?>" class="m--img-rounded m--marginless" alt=""/>
                    </div>
                    <div class="m-card-user__details">
                        <span class="m-card-user__name m--font-weight-500"><?php echo $user->full_name;?></span>
                        <span class="m-card-user__email m--font-weight-300 m-link"><?php echo $user->email;?></span>
                    </div>
                </div>
            </div>
            <div class="m-dropdown__body">
                <div class="m-dropdown__content">
                    <ul class="m-nav m-nav--skin-light">
                        <li class="m-nav__item">
                            <a href="<?php echo admin_url('profile');?>" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-profile-1"></i>
                                <span class="m-nav__link-title">
                                    <span class="m-nav__link-wrap">
                                        <span class="m-nav__link-text">
                                            <?php echo __('My Profile');?>
                                        </span>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a href="<?php echo admin_url('login/logout');?>" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-lock-1"></i>
                                <span class="m-nav__link-text">
                                    <?php echo __('Logout');?>
                                </span>
                            </a>
                        </li>
                        <?php
                        /*
                        <li class="m-nav__item">
                            <a href="header/profile.html" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-chat-1"></i>
                                <span class="m-nav__link-text">
                                    Messages
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__separator m-nav__separator--fit"></li>
                        <li class="m-nav__item">
                            <a href="header/profile.html" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-info"></i>
                                <span class="m-nav__link-text">
                                    FAQ
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a href="header/profile.html" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                <span class="m-nav__link-text">
                                    Support
                                </span>
                            </a>
                        </li>

                        <li class="m-nav__separator m-nav__separator--fit"></li>
                        <li class="m-nav__item">
                            <a href="<?php echo admin_url('login/logout');?>" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                <?php echo __('Logout');?>
                            </a>
                        </li>
                         */
                        ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</li>