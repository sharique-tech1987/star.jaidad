<?php get_header(get_option('header')); ?>
<!-- begin:: Page -->
<style type="text/css">
    .social-btn {
        width: 300px;
        margin: 0 auto;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .login-btn {
        font-size: 15px;
        font-weight: bold;
    }
    .or-seperator {
        margin: 20px 0 10px;
        text-align: center;
        border-top: 1px solid #ccc;
    }
    .or-seperator i {
        padding: 0 10px;
        background: #f7f7f7;
        position: relative;
        top: -11px;
        z-index: 1;
    }
    .social-btn .btn {
        margin: 10px 0;
        font-size: 15px;
        text-align: left;
        line-height: 24px;
    }
    .social-btn .btn i {
        float: left;
        margin: -2px 15px  0 5px;
        min-width: 15px;
    }
    .social-btn .fa{
        font-size: 28px;
    }


</style>
<div class="container">
    <p>&nbsp;</p>
    <?php echo show_validation_errors(); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-uppercase"><?php echo __('Sign Up');?></div>
                <div class="card-body" data-eq-height="card">
                    <form class="" id="registration" action="<?php echo site_url('login/registration');?>" method="post">
                        <input type="hidden" name="redirect" value="<?php echo getVar('redirect');?>">

                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Full name" name="first_name">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Phone" name="phone" data-inputmask="'mask': '+999999999999'">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" placeholder="Password" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <input class="form-control m-login__form-input--last" type="password" placeholder="Confirm Password" name="rpassword">
                        </div>
                        <div class="form-group">
                            <div class="col m--align-left">
                                <label class="m-checkbox m-checkbox--focus">
                                    <input type="checkbox" name="agree"> I Agree the
                                    <a href="#" class="m-link m-link--focus">terms and conditions</a>.
                                    <span></span>
                                </label>
                                <span class="m-form__help"></span>
                            </div>
                        </div>
                        <div class="m-login__form-action">
                            <button type="submit" class="theme-btn btn-style-four">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card login-div">
                <div class="card-header text-uppercase"><?php echo __('Sign in');?></div>
                <div class="card-body login-div" data-eq-height="card">
                    <form class="" id="login_other" method="post" action="<?php echo site_url('login/login');?>">
                        <input type="hidden" name="redirect" value="<?php echo getVar('redirect');?>">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="<?php echo __('Email');?>" name="email" id="email" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="form-control m-login__form-input--last" type="password" placeholder="<?php echo __('Password');?>" name="password">
                        </div>
                        <div class="form-group">
                            <div class="col m--align-left">
                                <label class="m-checkbox m-checkbox--focus">
                                    <input type="checkbox" name="remember">
                                    <?php echo __('Remember me');?>
                                    <span></span>
                                </label>
                            </div>
                            <div class="col m--align-right">
                                <a href="javascript:;" id="m_login_forget_password" class="toggle-btn m-link"><?php echo __('Forget Password ?');?></a>
                            </div>
                        </div>
                        <div class="m-login__form-action">
                            <button type="submit" class="theme-btn btn-style-four"><?php echo __('Sign In');?></button>
                        </div>
                    </form>

                    <div class="or-seperator"><i>or</i></div>

                    <div class="text-center social-btn">
                        <a href="<?php echo site_url('hauth/login/Facebook');?>" class="btn btn-primary btn-block"><i class="fa fa-facebook"></i> Sign in with <b>Facebook</b></a>
                        <!--<a href="<?php /*echo site_url('hauth/login/Twitter');*/?>" class="btn btn-info btn-block"><i class="fa fa-twitter"></i> Sign in with <b>Twitter</b></a>-->
                        <a href="<?php echo site_url('hauth/login/Google');?>" class="btn btn-danger btn-block"><i class="fa fa-google"></i> Sign in with <b>Google</b></a>
                    </div>

                </div>
            </div>

            <style>.forgot-div{display: none;}</style>
            <div class="card forgot-div">
                <div class="card-header text-uppercase"><?php echo __('Forgot Password');?></div>
                <div class="card-body" data-eq-height="card">
                    <form id="forgot" action="<?php echo site_url('login/forgot');?>">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="<?php echo __('Email');?>" name="email" id="m_email" autocomplete="off">
                        </div>
                        <div class="m-login__form-action">
                            <button type="submit" class="theme-btn btn-style-four"><?php echo __('Request');?></button>
                            <button id="m_login_forget_password_cancel" class="toggle-btn theme-btn btn-style-four"><?php echo __('Cancel');?></button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <p>&nbsp;</p>
</div>

<?php get_footer(); ?>
<script>
    $( "form#registration" ).validate({
        // define validation rules
        rules: {
            'first_name': {
                required: true,
            },'phone': {
                required: true,
            },
            'email': {
                required: true,
                email: true,
                remote: '<?php echo site_url('login/ajax/validate/' . $row->id)?>',
            },
            'user_type_id': {
                required: true,
            },
            'agree': {
                required: true,
            },
            'password': {
                required: true,
                minlength: 6,
                maxlength: 12,
            },'rpassword': {
                equalTo: '#password'
            },
        },
        messages: {
            'email': {remote: 'This email is already exist',},
        },
        //display error alert on form submit
        invalidHandler: function(event, validator) {
            validator.errorList[0].element.focus();
        },
        submitHandler: function(form) {
            form.submit();
        }

    });

    $("form#login").validate({
        rules: {
            'email': {
                required: true,
                email: true,
            },
            'password': {
                required: true,
                minlength: 6,
                maxlength: 12,
            },
        },
        messages: {
            /*'email': {email: 'Module is required'}*/
        },
        invalidHandler: function (event, validator) {
            validator.errorList[0].element.focus();
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#forgot").validate({
        rules: {
            'email': {
                required: true,
                email: true,
            }
        },
        messages: {
            /*'email': {email: 'Module is required'}*/
        },
        invalidHandler: function (event, validator) {
            validator.errorList[0].element.focus();
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(document).ready(function () {
        $(document).on('click', '.toggle-btn', function (e) {
            e.preventDefault();
            $('.login-div').slideToggle(0);
            $('.forgot-div').slideToggle(0);
        });
    });
</script>