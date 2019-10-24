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
                            <?php echo __('Reset Your Password');?> <?php echo get_option('admin_title');?>
                        </h3>
                    </div>
                    <form class="m-login__form m-form" action="" method="post">
                        <?php echo show_validation_errors(); ?>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="password" placeholder="<?php echo __('Enter New Password');?>" name="newpass" id="newpass" autocomplete="off">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="password" placeholder="<?php echo __('Confirm password');?>" name="confpass" id="confpass" autocomplete="off">
                        </div>
                        <div class="m-login__form-action">
                            <button id="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
                                <?php echo __('Reset Password');?>
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="<?php echo asset_url('default/base/scripts.bundle.js', true);?>" type="text/javascript"></script>
<script>
    $(function () {
        $("form.m-login__form").validate({
            // define validation rules
            rules: {
                'newpass': {
                    required: true,
                    minlength: 6,
                    maxlength: 12,
                },
                'confpass': {
                    required: true,
                    equalTo: "#newpass",
                },
            },
            messages: {
                /*'newpass': {required: 'New pass is required'},
                'confpass': {required: 'Confirm pass is required', equalTo: ''},*/
            },
            //display error alert on form submit
            invalidHandler: function(event, validator) {
                validator.errorList[0].element.focus();
            },

            submitHandler: function(form) {
                form.submit();
            }

        });
    });
</script>

</body>
</html>
