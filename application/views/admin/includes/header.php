<header class="m-grid__item    m-header "  data-minimize-offset="200" data-minimize-mobile-offset="200" >
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="<?php echo site_url();?>" target="_blank" class="m-brand__logo-wrapper">
                            <img src="<?php echo asset_url('img/' . get_option('admin_logo'), true); ?>">
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
                            <span></span>
                        </a>

                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>

                        <?php
                        /**
                         * top_bar_menus
                         *
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                         */ ?>

                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

                <?php
                /**
                 * TODO::top_bar_menus  -- Top Un-comment
                 */
                //include "block/top_bar_menus.php";
                ?>

                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <?php
                            /**
                             * TODO::mini_search
                             */
                            // include "block/mini_search.php";
                            ?>


                            <?php
                            /**
                             * TODO::Alerts
                             */
                            include "block/alerts.php";
                            ?>

                            <?php
                            /**
                             * TODO::Alerts
                             */
                            include "block/top_modules.php";
                            ?>

                            <?php
                            /**
                             * TODO::Alerts
                             */
                            include "block/user_menu.php";
                            ?>



                            <li id="m_quick_sidebar_toggle" class="m-nav__item">
                                <a target="_blank" href="<?php echo site_url();?>" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-nav__link-icon">
                                        <i class="flaticon-grid-menu"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>