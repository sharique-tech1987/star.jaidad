<html lang="en" >
<head>
    <meta charset="utf-8" />
    <title>Dashboard | <?php echo get_option('admin_title'); ?></title>
    <meta name="description" content="<?php echo get_option('admin_title'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script type="text/javascript">
        var site_url = '<?php echo site_url();?>';
        var base_url = '<?php echo base_url();?>';
        var asset_url = '<?php echo asset_url();?>';
        var media_url = '<?php echo media_url();?>';
    </script>

    <script src="<?php echo asset_url('vendors/base/vendors.bundle.js', true);?>" type="text/javascript"></script>
    <script src="<?php echo asset_url('app/js/bootbox.min.js', true);?>" type="text/javascript"></script>
    <script src="<?php echo asset_url('app/js/numeral.min.js', true);?>" type="text/javascript"></script>
    <script src="<?php echo asset_url('app/js/print.js', true);?>" type="text/javascript"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <link href="<?php echo asset_url('vendors/custom/fullcalendar/fullcalendar.bundle.css', true);?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url('vendors/base/vendors.bundle.css', true);?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url('default/base/style.bundle.css', true);?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url('app/css/dropify.min.css', true);?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url('fancybox/jquery.fancybox.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url('custom.css', true);?>" rel="stylesheet" type="text/css" />

    <link rel="shortcut icon" href="<?php echo asset_url('img/' . get_option('admin_logo'), true); ?>" />
</head>