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

	<!-- Open Graph -->
	<meta property="og:title" content="<?php echo $this->template->meta('og:title');?>" />
	<meta property="og:description" content="<?php echo $this->template->meta('og:description');?>" />
	<meta property="og:type" content="<?php echo $this->template->meta('og:type');?>" />
	<meta property="og:url" content="<?php echo $this->template->meta('og:url');?>" />
	<meta property="og:image" content="<?php echo $this->template->meta('og:image');?>" />
	<meta property="og:image:type" content="<?php echo $this->template->meta('og:image:type');?>" />
	<meta property="og:image:width" content="<?php echo $this->template->meta('og:image:width');?>" />
	<meta property="og:image:height" content="<?php echo $this->template->meta('og:image:height');?>" />

	<!-- Twitter Card -->
	<meta name="twitter:card" content="<?php echo $this->template->meta('twitter:card');?>" />
	<meta name="twitter:title" content="<?php echo $this->template->meta('twitter:title');?>" /><!--gmail:developer.adnan-->
	<meta name="twitter:description" content="<?php echo $this->template->meta('twitter:description');?>" />
	<meta name="twitter:image:src" content="<?php echo $this->template->meta('twitter:image:src');?>" />
	<meta name="twitter:image:width" content="<?php echo $this->template->meta('twitter:image:width');?>" />
	<meta name="twitter:image:height" content="<?php echo $this->template->meta('twitter:image:height');?>" />
	<meta name="twitter:site" content="<?php echo $this->template->meta('twitter:site');?>" />
	<meta name="twitter:creator" content="<?php echo $this->template->meta('twitter:creator');?>" />

    <script type="text/javascript">
        var site_url = '<?php echo site_url();?>';
        var base_url = '<?php echo base_url();?>';
        var asset_url = '<?php echo asset_url();?>';
        var media_url = '<?php echo media_url();?>';
    </script>

    <link rel="shortcut icon" href="<?php echo _img(asset_url('img/' . get_option('favicon'), true), 16, 16); ?>" type="image/x-icon"/>
    <link rel="icon" href="<?php echo _img(asset_url('img/' . get_option('favicon'), true), 16, 16); ?>" type="image/x-icon"/>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo media_url('css/site-style.css'); ?>"/>

    <!-- Separate Files-->
    <link rel="stylesheet" href="<?php echo media_url('css/animate.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo media_url('css/custom2.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo media_url('css/custom.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo media_url('css/select2.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo media_url('css/dev.css'); ?>"/>

    <!-- Javascript-->
    <script src="<?php echo media_url('js/head.js'); ?>"></script>

    <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5cd150c784760c0019807b7a&product=inline-share-buttons' async='async'></script>
</head>
<body>
