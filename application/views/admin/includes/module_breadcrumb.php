<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">

            <h3 class="m-subheader__title m-subheader__title--separator">
                <img src="<?php echo _img(ADMIN_ASSETS_DIR . 'uploads/icons/' . $this->_info->icon, 32, 32);?>" alt="">&nbsp;
                <?php echo __($this->_info->module_title); ?>
            </h3>

            <?php echo $this->breadcrumb->display();?>
        </div>
    </div>
</div>