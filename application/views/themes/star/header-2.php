<?php get_head();?>
<div class="page-wrapper">

    <?php if(get_option('site_loader') == 'On') { ?>
    <!-- Preloader -->
    <div class="preloader"></div>
    <?php } ?>
    <!-- Main Header-->
    <header class="main-header header-style-two">
        <!--Header Top-->
        <div class="header-top">
            <div class="auto-container">
                <div class="inner-container clearfix">
                    <div class="top-left">
                        <ul class="contact-list clearfix">
                            <li><i class="la la-home"></i> <?php echo get_option('address');?></li>
                            <li><i class="la la-envelope-o"></i><a href="mailto:<?php echo get_option('contact_email');?>"><?php echo get_option('contact_email');?></a></li>
                        </ul>
                    </div>
                    <div class="top-right">
                        <ul class="social-icon-one clearfix">
                            <?php
                            $socials = json_decode(get_option('social'), true);
                            foreach ($socials as $social => $social_link) {
                                if(!empty($social_link)) {
                                    echo '<li><a target="_blank" href="' . $social_link . '"><i class="la la-' . $social . '"></i></a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Top -->

        <!-- Header Lower -->
        <div class="header-lower">
            <div class="auto-container">
                <div class="main-box">
                    <div class="inner-container clearfix">
                        <div class="logo-box">
                            <div class="logo">
                                <a href="<?php echo site_url();?>" title="<?php echo $site_title = get_option('site_title');?>">
                                    <img src="<?php echo _img(ADMIN_ASSETS_DIR . 'img/' . get_option('logo'), 0,60);?>" alt="<?php echo $site_title;?>" title="<?php echo $site_title;?>">
                                </a>
                            </div>
                        </div>

                        <div class="nav-outer clearfix">
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
                            <div class="outer-box">
                                <div class="btn-box">
                                    <a href="<?php echo site_url('property/add');?>" class="theme-btn btn-style-five">Submit Property</a>
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
                    <a href="<?php echo site_url();?>" title="<?php echo $site_title = get_option('site_title');?>">
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

