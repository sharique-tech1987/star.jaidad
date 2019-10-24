//== Class Definition
var SnippetLogin = function() {

    var login = $('#m_login');

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="m-alert m-alert--outline alert alert-' + type + ' alert-dismissible" role="alert">\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
			<span></span>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
        alert.addClass('fadeIn animated');
        alert.find('span').html(msg);
    }

    //== Private Functions

    var displaySignUpForm = function() {
        login.removeClass('m-login--forget-password');
        login.removeClass('m-login--signin');

        login.addClass('m-login--signup');
        login.find('.m-login__signup').addClass('flipInX animated');
    }

    var displaySignInForm = function() {
        login.removeClass('m-login--forget-password');
        login.removeClass('m-login--signup');

        login.addClass('m-login--signin');
        login.find('.m-login__signin').addClass('flipInX animated');
    }

    var displayForgetPasswordForm = function() {
        login.removeClass('m-login--signin');
        login.removeClass('m-login--signup');

        login.addClass('m-login--forget-password');
        login.find('.m-login__forget-password').addClass('flipInX animated');
    }

    var handleFormSwitch = function() {
        $('#m_login_forget_password').click(function(e) {
            e.preventDefault();
            displayForgetPasswordForm();
        });

        $('#m_login_forget_password_cancel').click(function(e) {
            e.preventDefault();
            displaySignInForm();
        });

        $('#m_login_signup').click(function(e) {
            e.preventDefault();
            displaySignUpForm();
        });

        $('#m_login_signup_cancel').click(function(e) {
            e.preventDefault();
            displaySignInForm();
        });

    }


    var handleSignInFormSubmit = function() {
        $('#username').focus();
        $('#m_login_signin_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');
            var form_url = form.prop('action');

            form.validate({
                rules: {
                    username: {
                        required: true,
                        //email: true
                    },
                    password: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            form.ajaxSubmit({
                url: form_url,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                    if(response.status){
                        window.location = response.redirect;
                        return;
                    }
                	// similate 2s delay
                	setTimeout(function() {
	                    btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
	                    showErrorMsg(form, (!response.status ? 'danger' : 'success'), response.response);
                    }, 2000);
                }
            });
        });


    }

    var handleSignUpFormSubmit = function() {
        $('#m_login_signup_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');
            var form_url = form.prop('action');

            form.validate({
                rules: {
                    first_name: {
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: site_url + '/students/AJAX/validate',
                    },
                    password: {
                        required: true
                    },
                    rpassword: {
                        required: true,
                        equalTo: "#password"
                    },
                    agree: {
                        required: true
                    }
                },
                messages: {
                    'email': {/*required: 'Username is required', */remote: 'This email is already exist',},
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            form.ajaxSubmit({
                url: form_url,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                	// similate 2s delay
                    if(response.status && response.redirect){
                        window.location = response.redirect;
                        return;
                    }
                    // similate 2s delay
                    setTimeout(function() {
                        btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                        if(response.status){
                            form.clearForm();
                            form.validate().resetForm();

                            displaySignInForm();
                            var signInForm = login.find('.m-login__signin form');
                            signInForm.clearForm();
                            signInForm.validate().resetForm();
                            showErrorMsg(signInForm, (!response.status ? 'danger' : 'success'), response.response);
                        }else{
                            showErrorMsg(form, (!response.status ? 'danger' : 'success'), response.response);
                        }
                    }, 2000);


                }
            });
        });
    }

    var handleForgetPasswordFormSubmit = function() {
        $('#m_email').focus();
        $('#m_login_forget_password_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');
            var form_url = form.prop('action');

            form.validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            form.ajaxSubmit({
                url: form_url,
                dataType: 'json',
                success: function(response, status, xhr, $form) {
                	// similate 2s delay
                	setTimeout(function() {
                		btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false); // remove 
	                    form.clearForm(); // clear form
	                    form.validate().resetForm(); // reset validation states

	                    // display signup form
	                    displaySignInForm();
	                    var signInForm = login.find('.m-login__signin form');
	                    signInForm.clearForm();
	                    signInForm.validate().resetForm();

                        showErrorMsg(signInForm, (!response.status ? 'danger' : 'success'), response.response);
                	}, 2000);
                }
            });
        });
    }

    //== Public Functions
    return {
        // public functions
        init: function() {
            displaySignInForm();
            handleFormSwitch();
            handleSignInFormSubmit();
            handleSignUpFormSubmit();
            handleForgetPasswordFormSubmit();
        }
    };
}();

//== Class Initialization
jQuery(document).ready(function() {
    SnippetLogin.init();
});