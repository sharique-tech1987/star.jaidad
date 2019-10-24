<?php get_head();?>
<div class="page-wrapper">

    <?php if(get_option('site_loader') == 'On') { ?>
    <!-- Preloader -->
    <div class="preloader"></div>
    <?php } ?>
    <!-- Main Header-->
    <header class="main-header header-style-one">
        <!--Header Top-->
        <div class="header-top">
            <div class="auto-container">
                <div class="inner-container clearfix">
                    <div class="top-left">
                        <ul class="contact-list clearfix">
                            <!--<li><i class="fa fa-home"></i> <?php /*echo get_option('address');*/?></li>-->
                            <li><i class="fa fa-envelope-o"></i><a href="mailto:<?php echo get_option('contact_email');?>"><?php echo get_option('contact_email');?></a></li>
                        </ul>
                    </div>
                    <div class="top-right">
                        <div class="btn-box">
                            <ul class="social-icon-one clearfix">
                            <?php
                            $member_id = _session(FRONT_SESSION_ID);
                            $NAV = [
                                'Dashboard' => ['url' => site_url('member/account/home/' . $member_id), 'icon' => ('Home.png')],
                                'My Messages' => ['url' => site_url('member/account/messages/' . $member_id), 'icon' => ('News-Events.png')],
                                'My Bookings' => ['url' => site_url('member/account/booking/' . $member_id), 'icon' => ('invoice.png')],
                                'My Properties' => ['url' => site_url('member/account/properties/' . $member_id), 'icon' => ('property.png')],
                                'Favorite Properties' => ['url' => site_url('member/account/wishlist/' . $member_id), 'icon' => ('property.png')],
                                'Submit Property' => ['url' => site_url('property/add'), 'icon' => ('Edit-Profile.png')],
                                'My Profile' => ['url' => site_url('member/account/?edit=edit'), 'icon' => ('Edit-Profile.png')],
                                'Logout' => ['url' => site_url('login/logout'), 'icon' => ('logout.png')],
                            ];

                            if($member_id == 0){ ?>
                                <li><a title="login" href="<?php echo site_url('login');?>"><i class="fa fa-sign-in"></i></a></li>
                                <!--<li class="o-menu--divide-bottom sign_up"><a title="Registration" href="<?php /*echo site_url('customer/registration');*/?>"><i class="fas fa-user-plus"></i></a></li>-->
                            <?php } ?>
                            <?php if($member_id > 0){ ?>
                                <li><a class="" title="My Account" href="<?php echo site_url('member/account');?>"><i class="fa fa-user"></i></a></li>
                                <!--<li><a href="<?php /*echo site_url('customer/wishlist');*/?>">Wish List</a></li>-->
                                <li><a class="" title="Logout" href="<?php echo site_url('login/logout');?>"><i class="fa fa-sign-out"></i></a></li>
                            <?php } ?>
                            </ul>
                            <a href="<?php echo site_url('property/add');?>" class="theme-btn btn-style-four">Submit Property</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Top -->

        <!-- Header Lower -->
        <div class="header-lower">
            <div class="main-box">
                <div class="auto-container">
                    <div class="inner-container clearfix">
                        <div class="logo-box">
                            <div class="logo">
                                <a id="logo" href="<?php echo site_url();?>" title="<?php echo $site_title = get_option('site_title');?>">
                                    <img src="<?php echo _img(ADMIN_ASSETS_DIR . 'img/' . get_option('logo'), 0,100);?>" alt="<?php echo $site_title;?>" title="<?php echo $site_title;?>">
                                </a>
                            </div>
                        </div>

                        <div class="nav-outer">
                            <!-- Main Menu -->
                            <nav class="main-menu navbar-expand-md navbar-light">
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
                            <div class="outer-box clearfix">
                                <!--Search Box-->
                                <div class="search-box-outer">
                                    <div class="dropdown">
                                        <button class="search-box-btn dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-search"></span></button>
                                        <ul class="dropdown-menu pull-right search-panel" aria-labelledby="dropdownMenu3">
                                            <li class="panel-outer">
                                                <div class="form-container">
                                                    <form method="post" action="">
                                                        <div class="form-group">
                                                            <input type="search" name="field-name" value="" placeholder="Search Here" required>
                                                            <button type="submit" class="search-btn"><span class="fa fa-search"></span></button>
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
        </div>
        <!--End Header Lower-->

        <!-- Sticky Header  -->
        <div class="sticky-header">
            <div class="auto-container clearfix">
                <!--Logo-->
                <div class="logo pull-left">
                    <a id="logo" href="<?php echo site_url();?>" title="<?php echo $site_title = get_option('site_title');?>">
                        <img src="<?php echo _img(ADMIN_ASSETS_DIR . 'img/' . get_option('logo'), 0,50);?>" alt="<?php echo $site_title;?>" title="<?php echo $site_title;?>">
                    </a>
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
    <!--End Main Header -->
