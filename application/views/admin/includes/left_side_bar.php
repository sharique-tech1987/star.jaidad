<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">

            <!--<li class="m-menu__item <?php /*echo (in_array(getUri(2), array('', 'dashboard')) ? 'm-menu__item--active' : '');*/?>" aria-haspopup="true" >
                <a  href="<?php /*echo admin_url('dashboard');*/?>" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                <?php /*echo __('Dashboard');*/?>
                            </span>
                        </span>
                    </span>
                </a>
            </li>-->
            <?php
            $this->multilevels->id_Column = 'id';
            $this->multilevels->title_Column = 'module_title';
            $this->multilevels->link_Column = 'module';
            $this->multilevels->type = 'menu';
            $this->multilevels->level_spacing = 5;
            $this->multilevels->selected = $row->parent_id;
            $this->multilevels->has_child_html = '<i class="m-menu__ver-arrow la la-angle-right"></i>';

            $this->multilevels->parent_li_start = '<li class="m-menu__item  m-menu__item--submenu {active_class}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                                                    <a  href="{href}" class="m-menu__link m-menu__toggle" title="{title}">
                                                        <i class="m-menu__link-icon">{icon}</i>
                                                        <span class="m-menu__link-text">{title}</span>
                                                        {has_child}
                                                    </a>';

            $this->multilevels->parent_li_end =         '</li>';


            $this->multilevels->child_ul_start = '<div class="m-menu__submenu">
                                                    <span class="m-menu__arrow"></span>
                                                    <ul class="m-menu__subnav">';

            $this->multilevels->child_ul_end = '</ul></div>';

            $this->multilevels->child_li_start = '<li class="m-menu__item {active_class}" aria-haspopup="true" >
                            <a  href="{href}" class="m-menu__link " title="{title}">
                                <i class="m-menu__link-icon">{icon}</i>
                                <span class="m-menu__link-text">{title}</span>
                            </a>';

            $this->multilevels->child_li_end =         '</li>';


            $this->multilevels->active_class = 'm-menu__item--active';
            $this->multilevels->active_link = getUri(2);

            $this->multilevels->url = admin_url();

            $this->multilevels->query = "SELECT *,
                IF(FIND_IN_SET(SUBSTRING_INDEX(icon, '.', -1), 'png,jpg,jpeg') > 0, 
                CONCAT('<img width=\"26\" height=\"26\" src=\"" . asset_url('uploads/icons', true) . "/', icon , '\" alt=\"',module_title,'\">'), 
                CONCAT('<i class=\"m-menu__link-icon',icon,'\"></i>')) as icon
                FROM `modules` WHERE `status`='1' AND `show_on_menu`=1 AND id IN (SELECT `module_id` FROM `user_type_module_rel` WHERE user_type_id='" . intval($this->session->userdata('user_type')) . "') ORDER BY ordering ASC";
            echo $multiLevelComponents = $this->multilevels->build();
            ?>

            <li class="m-menu__item " aria-haspopup="true">
                <a href="<?php echo admin_url('login/logout');?>" class="m-menu__link " title="<?php echo __('Logout');?>">
                    <i class="m-menu__link-icon"><img width="26" height="26" src="<?php echo asset_url('uploads/icons/locked.png', true);?>" alt="<?php echo __('Logout');?>"></i>
                    <span class="m-menu__link-text"><?php echo __('Logout');?></span>
                </a>
            </li>

        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>