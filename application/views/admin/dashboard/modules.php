<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="m_portlet_tools">
    <div class="m-portlet__head">
        <div class="m-portlet__head-progress"><!-- here can place a progress bar--></div>
        <div class="m-portlet__head-wrapper">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon"><i class="flaticon-squares-3"></i></span>
                    <h3 class="m-portlet__head-text">
                        <?php echo __('Modules');?>
                    </h3>
                </div>
            </div>
        <?php echo portlet_actions();?>
        </div>
    </div>
    <div class="m-portlet__body search-container" style="height: 510px; overflow-y: scroll;">

        <div class="m-input-icon  m-input-icon--right">
            <input id="search" class="form-control m-input m-input--air search-input" type="text" placeholder="Search module..." find-block=".dashboard-components" find-in="[class*=module-li]" autocomplete="off">
            <span class="m-input-icon__icon m-input-icon__icon--right"><span><i class="la la-search"></i></span></span>
        </div>
        <br>
        <div class="clearfix"></div>
        <ul class="dashboard-components">
            <?php foreach ($modules as $module) {
                if (!in_array($module->module, array('#', 'javascript:;', 'javascript: void(0);'))) {
                    ?>
                    <li class="module-li">
                        <a href="<?= site_url(ADMIN_DIR . $module->module); ?>">
                            <?php echo $module->icon; ?>
                            <div class="module-title" title="<?php echo $module->module_title; ?>"><?php echo $module->module_title; ?></div>
                        </a>
                    </li>
                    <?php
                }
            } ?>

            <li>
                <a href="<?php echo admin_url('login/logout') ; ?>">
                    <img src="<?php echo _img('assets/admin/uploads/icons/locked.png', 64,64)?>" alt="Logout">
                    <div class="module-title">Logout</div>
                </a>
            </li>
        </ul>
    </div>
</div>

<p>&nbsp;</p>


