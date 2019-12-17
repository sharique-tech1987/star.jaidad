<?php
$NAV = [];
$member_id = _session(FRONT_SESSION_ID);
if($member_id > 0) {
    $member = get_member($member_id);
//    $NAV += [$member->full_name => []];
}
$NAV += [
    'Dashboard' => ['url' => site_url('member/account/home/' . $member_id), 'icon' => ('Home.png')],
    'My Messages' => ['url' => site_url('member/account/messages/' . $member_id), 'icon' => ('News-Events.png')],
    'My Bookings' => ['url' => site_url('member/account/booking/' . $member_id), 'icon' => ('invoice.png')],
    'My Properties' => ['url' => site_url('member/account/properties/' . $member_id), 'icon' => ('property.png')],
    'Favorite Properties' => ['url' => site_url('member/account/wishlist/' . $member_id), 'icon' => ('property.png')],
    'Submit Property' => ['url' => site_url('property/add'), 'icon' => ('Edit-Profile.png')],
    'Edit Profile' => ['url' => site_url('member/account/?edit=edit'), 'icon' => ('Edit-Profile.png')],
    'Become an Agent' => ['url' => site_url('member/become_agent'), 'icon' => ('Edit-Profile.png')],
    'Logout' => ['url' => site_url('login/logout'), 'icon' => ('logout.png')],
];

/*if(!empty($member->social)){
    unset($NAV['Edit Profile']);
}*/
if($member->user_type_id == get_option('agent_type_id') || $member->become_agent == 1) {
    unset($NAV['Become an Agent']);
}
?>
<?php get_head();?>
<body class="page-template-default page-<?php echo $page->friendly_url;?> page-<?php echo (empty($page->friendly_url) ? 'index' : 'inner');?> page page-id-<?php echo $page->id;?> benaa-class chrome property-template-default single single-property postid-768 benaa-class unknown has-sidebar wpb-js-composer js-comp-ver-5.6 vc_responsive" data-responsive="991" data-header="header-1">
<?php if(get_option('site_loader') == 'On') { ?>
    <!-- Preloader -->
<style>

	/*section {*/
	/*	width: 30%;*/
	/*	display: inline-block;*/
	/*	text-align: center;*/
	/*	min-height: 215px;*/
	/*	vertical-align: top;*/
	/*	margin: 1%;*/
	/*	background: #080915;*/
	/*	border-radius: 5px;*/
	/*	box-shadow: 0px 0px 30px 1px #103136 inset;*/
	/*}*/
	/*.loader-2 .loader-star {*/
	/*	position: static;*/
	/*	width: 60px;*/
	/*	height: 60px;*/
	/*	-webkit-transform: scale(0.7);*/
	/*	-ms-transform: scale(0.7);*/
	/*	transform: scale(0.7);*/
	/*	-webkit-animation: loader-2-star 1s ease alternate infinite;*/
	/*	animation: loader-2-star 1s ease alternate infinite;*/
	/*}*/

	/*.loader-2 .loader-circles {*/
	/*	width: 8px;*/
	/*	height: 8px;*/
	/*	background:#f70404;*/
	/*	border-radius: 50%;*/
	/*	position: absolute;*/
	/*	left: calc(50% - 4px);*/
	/*	top: calc(50% - 4px);*/
	/*	-webkit-transition: all 1s ease;*/
	/*	-o-transition: all 1s ease;*/
	/*	transition: all 1s ease;*/
	/*	-webkit-animation: loader-2-circles 1s ease-in-out alternate infinite;*/
	/*	animation: loader-2-circles 1s ease-in-out alternate infinite;*/
	/*}*/
	/*@-webkit-keyframes loader-2-circles {*/
	/*	0% {*/
	/*		-webkit-box-shadow: 0 0 0 #f70404;*/
	/*		box-shadow: 0 0 0 #f70404;*/
	/*		opacity: 1;*/
	/*		-webkit-transform: rotate(0deg);*/
	/*		transform: rotate(0deg);*/
	/*	}*/
	/*	50% {*/
	/*		-webkit-box-shadow: 24px -22px #f70404, 30px -15px 0 -3px #f70404, 31px 0px #f70404, 29px 9px 0 -3px #f70404, 24px 23px #f70404, 17px 30px 0 -3px #f70404, 0px 33px #f70404, -10px 28px 0 -3px #f70404, -24px 22px #f70404, -29px 14px 0 -3px #f70404, -31px -3px #f70404, -30px -11px 0 -3px #f70404, -20px -25px #f70404, -12px -30px 0 -3px #f70404, 5px -29px #f70404, 13px -25px 0 -3px #f70404;*/
	/*		box-shadow: 24px -22px #f70404, 30px -15px 0 -3px #f70404, 31px 0px #f70404, 29px 9px 0 -3px #f70404, 24px 23px #f70404, 17px 30px 0 -3px #f70404, 0px 33px #f70404, -10px 28px 0 -3px #f70404, -24px 22px #f70404, -29px 14px 0 -3px #f70404, -31px -3px #f70404, -30px -11px 0 -3px #f70404, -20px -25px #f70404, -12px -30px 0 -3px #f70404, 5px -29px #f70404, 13px -25px 0 -3px #f70404;*/
	/*		-webkit-transform: rotate(180deg);*/
	/*		transform: rotate(180deg);*/
	/*	}*/
	/*	100% {*/
	/*		opacity: 0;*/
	/*		-webkit-transform: rotate(360deg);*/
	/*		transform: rotate(360deg);*/
	/*		-webkit-box-shadow: 25px -22px #f70404, 15px -22px 0 -3px #f70404,, 31px 2px #f70404, 21px 2px 0 -3px #f70404,, 23px 25px #f70404, 13px 25px 0 -3px #f70404, 0px 33px #f70404, -10px 33px 0 -3px #f70404, -26px 24px #f70404, -19px 17px 0 -3px #f70404, -32px 0px #f70404, -23px 0px 0 -3px #f70404, -25px -23px #f70404, -16px -23px 0 -3px #f70404, 0px -31px #f70404, -2px -23px 0 -3px #f70404;*/
	/*		box-shadow: 25px -22px #f70404, 15px -22px 0 -3px #f70404, 31px 2px #f70404, 21px 2px 0 -3px #f70404, 23px 25px #f70404, 13px 25px 0 -3px #f70404, 0px 33px #f70404, -10px 33px 0 -3px #f70404, -26px 24px #f70404, -19px 17px 0 -3px #f70404, -32px 0px #f70404, -23px 0px 0 -3px #f70404, -25px -23px #f70404, -16px -23px 0 -3px #f70404, 0px -31px #f70404, -2px -23px 0 -3px #f70404;*/
	/*	}*/
	/*}*/

	/*@keyframes loader-2-circles {*/
	/*	0% {*/
	/*		-webkit-box-shadow: 0 0 0 #f70404;*/
	/*		box-shadow: 0 0 0 #f70404;*/
	/*		opacity: 1;*/
	/*		-webkit-transform: rotate(0deg);*/
	/*		transform: rotate(0deg);*/
	/*	}*/
	/*	50% {*/
	/*		-webkit-box-shadow: 24px -22px #f70404, 30px -15px 0 -3px #f70404, 31px 0px #f70404, 29px 9px 0 -3px #f70404, 24px 23px #f70404, 17px 30px 0 -3px #f70404, 0px 33px #f70404, -10px 28px 0 -3px #f70404, -24px 22px #f70404, -29px 14px 0 -3px #f70404, -31px -3px #e11a2b, -30px -11px 0 -3px #f70404, -20px -25px #f70404, -12px -30px 0 -3px #f70404, 5px -29px #f70404, 13px -25px 0 -3px #f70404;*/
	/*		box-shadow: 24px -22px #f70404, 30px -15px 0 -3px #f70404, 31px 0px #f70404, 29px 9px 0 -3px #f70404, 24px 23px #f70404, 17px 30px 0 -3px #f70404, 0px 33px #f70404, -10px 28px 0 -3px #f70404, -24px 22px #f70404, -29px 14px 0 -3px #f70404, -31px -3px #f70404, -30px -11px 0 -3px #f70404, -20px -25px #f70404, -12px -30px 0 -3px #f70404, 5px -29px #f70404, 13px -25px 0 -3px #f70404;*/
	/*		-webkit-transform: rotate(180deg);*/
	/*		transform: rotate(180deg);*/
	/*	}*/
	/*	100% {*/
	/*		opacity: 0;*/
	/*		-webkit-transform: rotate(360deg);*/
	/*		transform: rotate(360deg);*/
	/*		-webkit-box-shadow: 25px -22px #f70404, 15px -22px 0 -3px #f70404, 31px 2px #f70404, 21px 2px 0 -3px #f70404, 23px 25px #f70404, 13px 25px 0 -3px #f70404, 0px 33px #f70404, -10px 33px 0 -3px #f70404, -26px 24px #f70404, -19px 17px 0 -3px #f70404, -32px 0px #f70404, -23px 0px 0 -3px #f70404, -25px -23px #f70404, -16px -23px 0 -3px #f70404, 0px -31px #f70404, -2px -23px 0 -3px #f70404;*/
	/*		box-shadow: 25px -22px #f70404, 15px -22px 0 -3px #f70404, 31px 2px #f70404, 21px 2px 0 -3px #f70404, 23px 25px #f70404, 13px 25px 0 -3px #f70404, 0px 33px #f70404, -10px 33px 0 -3px #f70404, -26px 24px #f70404, -19px 17px 0 -3px #f70404, -32px 0px #f70404, -23px 0px 0 -3px #f70404, -25px -23px #f70404, -16px -23px 0 -3px #f70404, 0px -31px #f70404, -2px -23px 0 -3px #f70404;*/
	/*	}*/
	/*}*/

	/*@-webkit-keyframes loader-2-star {*/
	/*	0% {*/
	/*		-webkit-transform: scale(0) rotate(0deg);*/
	/*		transform: scale(0) rotate(0deg);*/
	/*	}*/
	/*	100% {*/
	/*		-webkit-transform: scale(0.7) rotate(360deg);*/
	/*		transform: scale(0.7) rotate(360deg);*/
	/*	}*/
	/*}*/
	/*@keyframes loader-2-star {*/
	/*	0% {*/
	/*		-webkit-transform: scale(0) rotate(0deg);*/
	/*		transform: scale(0) rotate(0deg);*/
	/*	}*/
	/*	100% {*/
	/*		-webkit-transform: scale(0.7) rotate(360deg);*/
	/*		transform: scale(0.7) rotate(360deg);*/
	/*	}*/
	/*}*/

	.loader-9 .star1 {
		-webkit-animation: stars-pulse 1s ease-in-out infinite;
		animation: stars-pulse 1s ease-in-out infinite;
		left: 0;
	}

	.loader-9 .star2 {
		-webkit-animation: stars-pulse 1s 0.2s ease-in-out infinite;
		animation: stars-pulse 1s 0.2s ease-in-out infinite;
		left: 25px;
	}

	.loader-9 .star3 {
		-webkit-animation: stars-pulse 1s 0.4s ease-in-out infinite;
		animation: stars-pulse 1s 0.4s ease-in-out infinite;
		left: 50px;
	}
	@-webkit-keyframes stars-pulse {
		0%,
		100% {
			-webkit-transform: scale(1);
			transform: scale(1);
			opacity: 1;
		}
		80% {
			-webkit-transform: scale(0);
			transform: scale(0);
			opacity: 0;
		}
	}

	@keyframes stars-pulse {
		0%,
		100% {
			-webkit-transform: scale(1);
			transform: scale(1);
			opacity: 1;
		}
		80% {
			-webkit-transform: scale(0);
			transform: scale(0);
			opacity: 0;
		}
	}

</style>



    <section class="wrapper"><div class="spinner"><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div></section>
  
  <section class="site_loader wrapper dark">
      <div class="spinner">
<!--          <img src="--><?php //echo _img(ADMIN_ASSETS_DIR . 'img/' . get_option('logo'), 185,75);?><!--" alt="--><?php //echo $site_title;?><!--" title="--><?php //echo $site_title;?><!--">-->
      </div></section>

<section class="site_loader wrapper dark ">
<!--        <div class="loader loader-12 spinner">-->
<!--	loader2-->
<!--				<div class="loader loader-2">-->
<!--					<svg class="loader-star" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">-->
<!--						<polygon points="29.8 0.3 22.8 21.8 0 21.8 18.5 35.2 11.5 56.7 29.8 43.4 48.2 56.7 41.2 35.1 59.6 21.8 36.8 21.8 " fill="#f70404" />-->
<!--					</svg>-->
<!--					<div class="loader-circles"></div>-->
<!--				</div>-->

		<div class="loader loader-9">
			<svg class="loader-star star1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="23.172px" height="23.346px" viewBox="0 0 23.172 23.346" xml:space="preserve">
            <polygon fill="#f1050e" points="11.586,0 8.864,8.9 0,8.9 7.193,14.447 4.471,23.346 11.586,17.84 18.739,23.346 16.77,14.985 23.172,8.9 14.306,8.9" />
         </svg>
			<svg class="loader-star star2" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="23.172px" height="23.346px" viewBox="0 0 23.172 23.346" xml:space="preserve">
            <polygon fill="#f1050e" points="11.586,0 8.864,8.9 0,8.9 7.193,14.447 4.471,23.346 11.586,17.84 18.739,23.346 16.77,14.985 23.172,8.9 14.306,8.9  " />
         </svg>
			<svg class="loader-star star3" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="23.172px" height="23.346px" viewBox="0 0 23.172 23.346" xml:space="preserve">
            <polygon fill="#f1050e" points="11.586,0 8.864,8.9 0,8.9 7.193,14.447 4.471,23.346 11.586,17.84 18.739,23.346 16.77,14.985 23.172,8.9 14.306,8.9  " />
         </svg>
		</div>

<!--            <svg class="loader-star star1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="35px" height="35px" viewBox="0 0 23.172 23.346" xml:space="preserve">-->
<!--<polygon points="11.586,0 8.864,8.9 0,8.9 7.193,14.447 4.471,23.346 11.586,17.84 18.739,23.346 16.77,14.985 23.172,8.9 14.306,8.9"></polygon>-->
<!--</svg>-->
<!--<svg class="loader-star star2" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="35px" height="35px" viewBox="0 0 23.172 23.346" xml:space="preserve">-->
<!--<polygon points="11.586,0 8.864,8.9 0,8.9 7.193,14.447 4.471,23.346 11.586,17.84 18.739,23.346 16.77,14.985 23.172,8.9 14.306,8.9"></polygon>-->
<!--</svg>-->
<!--<svg class="loader-star star3" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="35px" height="35px" viewBox="0 0 23.172 23.346" xml:space="preserve">-->
<!--<polygon points="11.586,0 8.864,8.9 0,8.9 7.193,14.447 4.471,23.346 11.586,17.84 18.739,23.346 16.77,14.985 23.172,8.9 14.306,8.9"></polygon>-->
<!--</svg>-->
<!--<svg class="loader-star star4" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="35px" height="35px" viewBox="0 0 23.172 23.346" xml:space="preserve">-->
<!--<polygon points="11.586,0 8.864,8.9 0,8.9 7.193,14.447 4.471,23.346 11.586,17.84 18.739,23.346 16.77,14.985 23.172,8.9 14.306,8.9"></polygon>-->
<!--</svg>-->
<!--<svg class="loader-star star5" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="35px" height="35px" viewBox="0 0 23.172 23.346" xml:space="preserve">-->
<!--<polygon points="11.586,0 8.864,8.9 0,8.9 7.193,14.447 4.471,23.346 11.586,17.84 18.739,23.346 16.77,14.985 23.172,8.9 14.306,8.9"></polygon>-->
<!--</svg>-->
<!--<svg class="loader-star star6" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="35px" height="35px" viewBox="0 0 23.172 23.346" xml:space="preserve">-->
<!--<polygon points="11.586,0 8.864,8.9 0,8.9 7.193,14.447 4.471,23.346 11.586,17.84 18.739,23.346 16.77,14.985 23.172,8.9 14.306,8.9"></polygon>-->
<!--</svg>-->
<!--        </div>-->
    </section>

    <?php } ?>
<div id="wrapper">
        <!--============== desktop header ==============-->
        <header class="main-header header-1 pop-dismiss">

            <!--============== top bar ==============-->
            <div class="top-bar-wrapper bar-wrapper">
                <div class="container">
                    <div class="top-bar-inner">
                        <div class="row">
                            <div class="top-bar-left bar-left col-md-4">
                                <!--============== login ==============-->
                                <aside id="ere_widget_login_menu-2" class="inline-block mg-right-20 widget ere_widget ere_widget_login_menu">
                                    <?php
                                    if($member_id == 0){ ?>
                                        <a href="javascript:void(0)" class="login-link topbar-link" data-toggle="modal" data-target="#ere_signin_modal">
                                            <i class="fa fa-user"></i><span class="hidden-xs">Login or Register</span>
                                        </a>
                                    <?php } else {
                                        $ci = & get_instance();
                                        $ci->load->model(ADMIN_DIR . 'm_users');
                                        $member = $ci->m_users->info('', FRONT_SESSION_ID);
                                        ?>
                                        <ul class="header-btn">
                                            <li class="dropdown option-box">
                                                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <img src="<?php echo _img("assets/front/users/" . $member->photo, 48,48, USER_IMG_NA);?>" alt="avatar" class="thumb img-circle"> My Account
                                                </a>
                                                <div class="dropdown-menu">
                                                    <?php
                                                    echo '<span class="dropdown-item" >'. $member->full_name .'</span>';
                                                    foreach ($NAV as $title => $item) {
                                                        echo '<a class="dropdown-item" href="'.$item['url'].'">'.$title.'</a>';
                                                    }
                                                    ?>
                                                </div>
                                            </li>
                                        </ul>
                                    <?php }  ?>

                                </aside>

                                <aside id="custom_html-2" class="widget_text inline-block widget widget_custom_html">
                                    <div class="textwidget custom-html-widget">
                                        <div class="phone mg-right-30 inline-block">
                                        <i class="fa fa-phone accent-color mg-right-10"></i> <?php echo get_option('phone_number');?></div>
                                    </div>
                                </aside>
                            </div>
                            <div class="top-bar-right bar-right col-md-8">

                                <aside id="g5plus_social_profile-2" class="inline-block mg-right-30 widget widget-social-profile">
                                    <div class="social-profiles default light icon-small">
                                        <?php
                                        $socials = json_decode(get_option('social'), true);
                                        foreach ($socials as $social => $social_link) {
                                            if(!empty($social_link)) {
                                                echo '<a target="_blank" href="' . $social_link . '"><i class="fa fa-' . $social . '"></i></a>';
                                            }
                                        }
                                        ?>
                                        <div class="clearfix"></div>
                                    </div>
                                </aside>

                                <aside id="custom_html-4" class="widget_text inline-block widget widget_custom_html">
                                    <div class="textwidget custom-html-widget">
                                        <div class="submit-property">
                                            <?php
                                            if($member_id > 0){
                                                $_href = ' href="'.site_url('property/add').'"';
                                            }else
                                                $_href = 'href="#" data-toggle="modal" data-target="#ere_signin_modal"';
                                            ?>
                                            <a <?php echo $_href;?> title="Submit Property"><i class="icon-office2"></i> Submit Property</a>
                                        </div>
                                    </div>
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--============== header menu ==============-->
            <div class="sticky-wrapper is-sticky">
                <div class="header-wrapper clearfix sticky-region">
                    <div class="container">
                        <div class="header-above-inner container-inner clearfix">
                            <div class="logo-header">
                                <a class="no-sticky" href="<?php echo site_url();?>" title="<?php echo $site_title = get_option('site_title');?>">
                                    <img src="<?php echo _img(ADMIN_ASSETS_DIR . 'img/' . get_option('logo'), 175,65);?>" alt="<?php echo $site_title;?>" title="<?php echo $site_title;?>">
                                </a>
                            </div>

                            <nav class="primary-menu">
                                <ul class="main-menu x-nav-menu x-nav-menu_primary-menu x-animate-sign-flip">
                                    <?php
                                    $main_nav_config = array(
                                        'parent_li_start' => "<li class='menu-item x-menu-item {active_class}'><a id='menu-{id}' class='x-menu-a-text menu-item-{id} menu-type-{menu_type}' href='{href}' data-description='{title}'><span class=\"x-menu-text\">{title}</span></a>",// <span class='glyphicon glyphicon-chevron-down'></span>
                                        'child_li_start' => "<li class='menu-item x-menu-item {active_class}'><a id='menu-{id}' class='x-menu-a-text menu-item-{id} menu-type-{menu_type}' href='{href}' data-description='{title}'><span class=\"x-menu-text\">{title}</span></a>",
                                        'child_li_end' => '</li>',
                                        //'child_ul_start' => '',
                                        'active_class' => 'current-menu-parent',
                                        //'call_func' => 'parse_menu_items',
                                    );
                                    $main_nav_config['default_active'] = getUri(1);
                                    echo get_nav(1, $main_nav_config);
                                    ?>

                                </ul>
                                <!--============== search ==============-->
                                <!--<div class="header-customize-wrapper header-customize-nav">
                                    <div class="header-customize-item item-search">
                                        <a href="#" class="prevent-default search-standard"><i class="icon-search2"></i></a>
                                    </div>
                                </div>-->
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!--============== mobile header ==============-->
        <header class="header-mobile header-mobile-1 pop-dismiss">
            <div class="header-mobile-wrapper">
                <div class="header-mobile-inner">
                    <div class="container header-mobile-container">
                        <div class="header-mobile-container-inner clearfix">
                            <div class="logo-mobile-wrapper">
                                <a class="" href="<?php echo site_url();?>" title="<?php echo $site_title = get_option('site_title');?>">
                                    <img src="<?php echo _img(ADMIN_ASSETS_DIR . 'img/' . get_option('logo'), 175,65);?>" alt="<?php echo $site_title;?>" title="<?php echo $site_title;?>">
                                </a>
                            </div>
                            <div class="toggle-icon-wrapper toggle-mobile-menu" data-drop-class="menu-drop-dropdown">
                                <div class="toggle-icon"><span></span></div>
                            </div>
                            <div class="mobile-login">
                                <?php
                                    if($member_id == 0){ ?>
                                    <div class="widget ere_widget ere_widget_login_menu"> <a href="javascript:void(0)" class="login-link topbar-link" data-toggle="modal" data-target="#ere_signin_modal"><i class="fa fa-user"></i><span class="hidden-xs">Login or Register</span></a></div>
                                    <?php } else {
                                        $ci = & get_instance();
                                        $ci->load->model(ADMIN_DIR . 'm_users');
                                        $member = $ci->m_users->info('', FRONT_SESSION_ID);
                                        ?>
                                        <ul class="header-btn">
                                            <div class="toggle-icon-wrapper toggle-mobile-menu" data-toogle_class=".user-menu-drop-dropdown">
                                                <span class="m-toggle-menu"><img src="<?php echo _img("assets/front/users/" . $member->photo, 48,48, USER_IMG_NA);?>" alt="avatar" class="thumb"> My Account</span>
                                            </div>
                                        </ul>
                                    <?php }  ?>

                            </div>
                        </div>

                        <?php if($member_id > 0){ ?>
                        <div class="header-mobile-nav menu-drop-dropdown">
                            <ul id="menu-primary-menu" class="nav-menu-mobile user-menu-drop-dropdown x-nav-menu x-nav-menu_primary-menu x-animate-sign-flip">
                                <?php
                                foreach ($NAV as $title => $item) {
                                    echo '<li class=\'menu-item x-menu-item\'><a class="x-menu-a-text -dropdown-item" href="'.$item['url'].'">'.$title.'</a></li>';
                                }
                                ?>
                            </ul>
                        </div>
                        <?php } ?>

                        <div class="header-mobile-nav menu-drop-dropdown">
                            <ul id="menu-primary-menu" class="nav-menu-mobile site-menu-drop-dropdown x-nav-menu x-nav-menu_primary-menu x-animate-sign-flip">
                                <?php
                                $main_nav_config = array(
                                    'parent_li_start' => "<li class='menu-item x-menu-item {active_class}'><a id='menu-{id}' class='x-menu-a-text menu-item-{id} menu-type-{menu_type}' href='{href}' data-description='{title}'><span class=\"x-menu-text\">{title}</span></a>",// <span class='glyphicon glyphicon-chevron-down'></span>
                                    'child_li_start' => "<li class='menu-item x-menu-item {active_class}'><a id='menu-{id}' class='x-menu-a-text menu-item-{id} menu-type-{menu_type}' href='{href}' data-description='{title}'><span class=\"x-menu-text\">{title}</span></a>",
                                    'child_li_end' => '</li>',
                                    //'child_ul_start' => '',
                                    'active_class' => 'current-menu-parent',
                                    //'call_func' => 'parse_menu_items',
                                );
                                $main_nav_config['default_active'] = getUri(1);
                                echo get_nav(1, $main_nav_config);
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
