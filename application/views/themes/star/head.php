<html lang="en" >
<head>
    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Meta SEO -->
    <title><?php echo $this->template->site_title;?></title>
    <meta name="description" content="<?php echo $this->template->meta('description');?>">
    <meta name="keywords" content="<?php echo $this->template->meta('keywords');?>">
    <meta name="author" content="<?php echo $this->template->meta('author');?>">
    <meta name="robots" content="<?php echo get_option('robots'); ?>" />
    <link rel="canonical" href="<?php echo current_url();?>"/>

    <script type="text/javascript">
        var site_url = '<?php echo site_url();?>';
        var base_url = '<?php echo base_url();?>';
        var asset_url = '<?php echo asset_url();?>';
        var media_url = '<?php echo media_url();?>';
    </script>

    <link rel="shortcut icon" href="<?php echo _img(asset_url('img/' . get_option('favicon'), true), 16, 16); ?>" type="image/x-icon"/>
    <link rel="icon" href="<?php echo _img(asset_url('img/' . get_option('favicon'), true), 16, 16); ?>" type="image/x-icon"/>

    <!-- Stylesheets -->
    <!-- Single File-->
    <link rel="stylesheet" href="<?php echo media_url('css/site-style.css'); ?>"/>

    <!-- Separate Files-->
    <!--<link rel="stylesheet" href="<?php /*echo media_url('css/style0.css'); */?>"/>-->
    <!--<link rel="stylesheet" href="<?php /*echo media_url('css/style01.css'); */?>"/>-->
    <!--<link rel="stylesheet" href="<?php /*echo media_url('css/style02.css'); */?>"/>-->
    <!--<link rel="stylesheet" href="<?php /*echo media_url('css/style03.css'); */?>"/>-->
    <!--<link rel="stylesheet" href="<?php /*echo media_url('css/main.min.css'); */?>"/>-->
    <!--<link rel="stylesheet" href="<?php /*echo media_url('css/owl.carousel.min.css'); */?>"/>-->
    <!--<link rel="stylesheet" href="<?php /*echo media_url('css/lightgallery.min.css'); */?>"/>-->
    <!--<link rel="stylesheet" href="<?php /*echo media_url('css/listing-property-taxonomy.min7d4c.css'); */?>"/>-->
    <!--<link rel="stylesheet" href="<?php /*echo media_url('css/advanced_search.min.css'); */?>"/>-->
    <link rel="stylesheet" href="<?php echo media_url('css/animate.css'); ?>"/>

    <!--<link rel="stylesheet" href="<?php /*echo media_url('css/single-property.min.css'); */?>"/>-->
    <link rel="stylesheet" href="<?php echo media_url('css/custom2.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo media_url('css/custom.css'); ?>"/>

    <!--<link rel="stylesheet" href="<?php /*echo media_url('css/line-awesome.css'); */?>"/>-->
    <!--<link rel="stylesheet" href="<?php /*echo media_url('css/jquery.fancybox.min.css'); */?>"/>-->

    <link href="<?php echo media_url('css/select2.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo media_url('css/dev.css'); ?>"/>

    <!-- Javascript-->
    <script src="<?php echo media_url('js/head.js'); ?>"></script>

    <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5cd150c784760c0019807b7a&product=inline-share-buttons' async='async'></script>
</head>
<body>