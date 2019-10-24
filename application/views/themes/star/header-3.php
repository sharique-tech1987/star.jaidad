<?php get_head();?>
<div class="page-wrapper">

    <?php if(get_option('site_loader') == 'On') { ?>
    <!-- Preloader -->
    <div class="preloader"></div>
    <?php } ?>
    <!-- Main Header-->
    <header class="main-header header-style-three">
        <!--Header Top-->
        <div class="header-top">
            <div class="auto-container">
                <div class="inner-container clearfix">
                    <div class="top-left">
                        <div class="text"><?php echo get_option('tag_line');?></div>
                    </div>
                    <div class="top-right clearfix">
                        <ul class="clearfix">
                            <?php
                            $customer_login = _session('customer_login');
                            if($customer_login == 0){ ?>
                                <li><a title="login" href="<?php echo site_url('customer/login');?>">Login</a></li>
                                <li><a title="Registration" href="<?php echo site_url('customer/registration');?>">Register</a></li>
                            <?php } ?>
                            <?php if($customer_login > 0){ ?>
                                <li class="my_accnt"><a href="<?php echo site_url('customer/account');?>">Account</a></li>
                                <!--<li><a href="<?php /*echo site_url('customer/wishlist');*/?>">Wish List</a></li>-->
                                <li class="o-menu--divide-top log_out"><a href="<?php echo site_url('customer/logout');?>">Logout</a></li>
                            <?php } ?>
                        </ul>
                        <!--<div class="btn-box">
                            <a href="<?php /*echo site_url('property/add');*/?>" class="theme-btn btn-style-two">Add Property</a>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Top -->

        <!-- Header Upper -->
        <div class="header-upper">
            <div class="auto-container">
                <div class="clearfix">

                    <div class="logo-outer">
                        <div class="logo">
                            <a href="<?php echo site_url();?>" title="<?php echo $site_title = get_option('site_title');?>">
                                <img src="<?php echo _img(ADMIN_ASSETS_DIR . 'img/' . get_option('logo'), 0,50);?>" alt="<?php echo $site_title;?>" title="<?php echo $site_title;?>">
                            </a>
                        </div>
                    </div>

                    <div class="upper-right clearfix">

                        <!--Info Box-->
                        <div class="upper-column info-box">
                            <div class="icon-box"><span class="la la-envelope-o"></span></div>
                            <ul>
                                <li><span>Email:</span></li>
                                <li><a href="mailto:<?php echo get_option('contact_email');?>"><?php echo get_option('contact_email');?></a></li>
                            </ul>

                        </div>

                        <!--Info Box-->
                        <div class="upper-column info-box">
                            <div class="icon-box"><span class="la la-phone"></span></div>
                            <ul>
                                <li><span>Phone:</span></li>
                                <li><a href="tel:<?php echo get_option('phone_number');?>"><?php echo get_option('phone_number');?></a></li>
                            </ul>
                        </div>

                        <!--Info Box-->
                        <div class="upper-column info-box">
                            <div class="icon-box"><span class="la la-home"></span></div>
                            <ul>
                                <li><span>Address:</span></li>
                                <li><?php echo get_option('address');?></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Upper -->


        <!-- Header Lower -->
        <div class="header-lower">
            <div class="auto-container">
                <div class="main-box clearfix">
                    <div class="nav-outer clearfix">
                        <!-- Main Menu -->
                        <nav class="main-menu navbar-expand-md navbar-dark">
                            <div class="navbar-header">
                                <!-- Toggle Button -->
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="icon flaticon-menu"></span>
                                </button>
                            </div>

                            <div class="collapse navbar-collapse clearfix" id="navbarSupportedContent">
                                <ul class="navigation clearfix">
                                    <?php
                                    $main_nav_config = array(
                                        'parent_li_start' => "<li class='dropdown {active_class}'><a id='menu-{id}' class='menu-item-{id} menu-type-{menu_type}' href='#' data-description='{title}'><span>{title}</span></a>",// <span class='glyphicon glyphicon-chevron-down'></span>
                                        'child_li_start' => "<li class='-menu-item li-menu-{id} {active_class}'><a id='menu-{id}' class='menu-item-{id} menu-type-{menu_type}' href='{href}' data-description='{title}'><span>{title}</span></a>",
                                        'child_li_end' => '</li>',
                                        //'child_ul_start' => '',
                                        'active_class' => 'current',
                                        //'call_func' => 'parse_menu_items',
                                    );
                                    $main_nav_config['default_active'] = getUri(1);
                                    echo get_nav(1, $main_nav_config);
                                    ?>
                                </ul>
                            </div>
                        </nav><!-- Main Menu End-->

                        <!-- Main Menu End-->
                        <div class="outer-box">
                            <div class="btn-box">
                                <a href="<?php echo site_url('property/add');?>" class="theme-btn btn-style-four">Add Property</a>
                            </div>

                            <!--Search Box-->
                            <div class="search-box-outer">
                                <div class="dropdown">
                                    <button class="search-box-btn dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="la la-search"></span></button>
                                    <ul class="dropdown-menu pull-right search-panel" aria-labelledby="dropdownMenu3">
                                        <li class="panel-outer">
                                            <div class="form-container">
                                                <form method="post" action="http://expert-themes.com/html/willies/blog.html">
                                                    <div class="form-group">
                                                        <input type="search" name="field-name" value="" placeholder="Search Here" required>
                                                        <button type="submit" class="search-btn"><span class="la la-search"></span></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Header Lower-->

        <!-- Sticky Header  -->
        <div class="sticky-header">
            <div class="auto-container clearfix">
                <!--Logo-->
                <div class="logo pull-left">
                    <a href="<?php echo site_url();?>" title="<?php echo $site_title = get_option('site_title');?>"><img src="<?php echo _img(ADMIN_ASSETS_DIR . 'img/' . get_option('logo'), 0,50);?>" alt="<?php echo $site_title;?>" title="<?php echo $site_title;?>"></a>
                </div>
                <!--Right Col-->
                <div class="pull-right">
                    <!-- Main Menu -->
                    <nav class="main-menu">
                        <div class="navbar-collapse show collapse clearfix">
                            <ul class="navigation clearfix">
                                <?php
                                $main_nav_config = array(
                                    'parent_li_start' => "<li class='dropdown {active_class}'><a id='menu-{id}' class='menu-item-{id} menu-type-{menu_type}' href='#' data-description='{title}'><span>{title}</span></a>",// <span class='glyphicon glyphicon-chevron-down'></span>
                                    'child_li_start' => "<li class='-menu-item li-menu-{id} {active_class}'><a id='menu-{id}' class='menu-item-{id} menu-type-{menu_type}' href='{href}' data-description='{title}'><span>{title}</span></a>",
                                    'child_li_end' => '</li>',
                                    //'child_ul_start' => '',
                                    'active_class' => 'current',
                                    //'call_func' => 'parse_menu_items',
                                );
                                $main_nav_config['default_active'] = getUri(1);
                                echo get_nav(1, $main_nav_config);
                                ?>
                            </ul>
                        </div>
                    </nav><!-- Main Menu End-->
                </div>
            </div>
        </div><!-- End Sticky Menu -->
    </header>

