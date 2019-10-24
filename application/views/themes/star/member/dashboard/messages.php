<?php get_header('member');?>

<?php
define('MEMBER_FORM_URI', 4);
$_action = (getUri(MEMBER_FORM_URI));
$__id = getUri(MEMBER_FORM_URI + 1);

$_url = current_url();
$ci = & get_instance();
$ci->load->model(ADMIN_DIR . 'm_booking');

?>

<style>
    .inbox-container{
        margin: 80px 0 0 0;
    }
</style>
<?php echo include __DIR__ . "/../../inbox/index.php";?>

<?php include __DIR__ . "/../../footer_js.php"?>

