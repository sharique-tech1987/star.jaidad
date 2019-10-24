<?php
include dirname(__FILE__) . "/includes/head.php";
?>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--singin m-login--2 m-login-2--skin-1" id="m_login">
        <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <a href="<?php echo admin_url();?>">
                        <img src="<?php echo asset_url('img/' . get_option('admin_logo'), true); ?>">
                    </a>
                </div>
                <div class="m-login__signin">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            <?php echo __('Sign in to');?> <?php echo get_option('admin_title');?>
                        </h3>
                    </div>
                    <form class="m-login__form m-form" action="<?php echo admin_url('login/do_login');?>" method="post">
                        <?php echo show_validation_errors(); ?>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="<?php echo __('Username');?>" name="username" id="username" autocomplete="off">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="<?php echo __('Password');?>" name="password">
                        </div>
                        <div class="row m-login__form-sub">
                            <div class="col m--align-left m-login__form-left">
                                <label class="m-checkbox  m-checkbox--light">
                                    <input type="checkbox" name="remember">
                                    <?php echo __('Remember me');?>
                                    <span></span>
                                </label>
                            </div>
                            <div class="col m--align-right m-login__form-right">
                                <a href="javascript:;" id="m_login_forget_password" class="m-link">
                                    <?php echo __('Forget Password');?>
                                </a>
                            </div>
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
                                <?php echo __('Sign In');?>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="m-login__forget-password">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            <?php echo __('Forgotten Password');?>
                        </h3>
                        <div class="m-login__desc">
                            <?php echo __('Enter your email');?>
                        </div>
                    </div>
                    <form class="m-login__form m-form" action="<?php echo admin_url('login/forgot');?>" method="post">
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="<?php echo __('Email');?>" name="email" id="m_email" autocomplete="off">
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_forget_password_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                <?php echo __('Request');?>
                            </button>
                            &nbsp;&nbsp;
                            <button id="m_login_forget_password_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                                <?php echo __('Cancel');?>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="<?php echo asset_url('default/base/scripts.bundle.js', true);?>" type="text/javascript"></script>
<script src="<?php echo asset_url('snippets/pages/user/login.js', true);?>" type="text/javascript"></script>

</body>
</html>
