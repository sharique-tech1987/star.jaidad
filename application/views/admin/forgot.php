<?php
include dirname(__FILE__) . "/includes/head.php";

?>

<?php echo show_validation_errors(); ?>
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
            <button type="submit" id="m_login_forget_password_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                <?php echo __('Request');?>
            </button>
            &nbsp;&nbsp;
            <a href="<?php echo admin_url();?>" id="m_login_forget_password_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                <?php echo __('Cancel');?>
            </a>
        </div>
    </form>
</div>


<?php
include dirname(__FILE__) . "/includes/footer.php";
?>
<script type="text/javascript">
    $(function () {
        $('#email').focus();
        $("#validate").validationEngine('attach', { binded: false });
    })
</script>
