<?php get_header(get_option('header')); ?>
<?php
if (!is_object($page)) {
    $page = new stdClass();
    $page->show_title = true;
    $page->title = 'Reset your password';
}
?>
<div id="wrapper-content" class="clearfix ">
    <section class="page-title page-title-large page-title-large page-title-background"
             style="padding-top:70px;padding-bottom:70px">
        <div class="page-title-background"
             style="background-image: url(<?php echo asset_url('front/pages/' . $page->thumbnail); ?>)"></div>
        <div class="container">
            <div class="page-title-inner">
                <?php if ($page->show_title) { ?>
                    <div class="page-title-main-info"><h4><?php echo $page->title; ?></h4></div>
                <?php } ?>
                <?php include __DIR__ . "/../include/breadcrumb.php" ?>
            </div>
        </div>
    </section>

    <div id="primary-content" class="page-wrap">
        <div class="container clearfix">
            <div class="page-inner">
                <?php echo show_validation_errors(); ?>



                <div class="m-login__signin">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            <?php echo __('Reset Your Password');?> <?php echo get_option('site_title');?>
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
                    <p>&nbsp;</p>
                </div>


    </div>
    </div>
    </div>
</div>

<?php get_footer(); ?>

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
