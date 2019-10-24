<li class="menu-li-<?php echo $item['menu_type'];?>">
    <div class="item">
        <div class="m-portlet m-portlet--collapsed m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_<?php echo $item->id;?>">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-mark"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            <span class="menu-label menu-title"><?php echo stripslashes($item['menu_title']);?></span><span class="menu-type badge badge-primary badge-pill"><?php echo $item['menu_type'];?></span>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
                        </li>
                        <li class="m-portlet__nav-item">
                            <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-close"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <input type="hidden" name="menu_type" class="menu-type" value="<?php echo $item['menu_type'];?>">
                <input type="hidden" name="id" class="menu-id" value="<?php echo $item['id'];?>">

                <?php if($item['menu_type'] == 'custom'){ ?>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>Navigation Label</label>
                            <input type="text" name="menu_title" class="form-control menu-title" placeholder="Menu item" value="<?php echo htmlentities(stripslashes($item['menu_title']));?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>URL</label>
                            <input type="text" name="menu_link" class="form-control menu-url" placeholder="Enter url here" value="<?php echo $item['menu_link'];?>">
                        </div>
                    </div>

                    <?php include "params.php"; ?>
                    <p class="link-wrapper">URL: <a href="<?php echo $item['link_url'];?>" target="_blank" class="menu-link"><?php echo $item['link_title'];?></a></p>

                <?php } elseif($item['menu_type'] == 'page') { ?>
                    <input type="hidden" name="menu_link" class="menu-link-id" value="<?php echo $item['menu_link'];?>">

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>Navigation Label</label>
                            <input type="text" name="menu_title" class="form-control menu-title" placeholder="Menu item" value="<?php echo htmlentities(stripslashes($item['menu_title']));?>">
                        </div>
                    </div>
                    <?php include "params.php"; ?>
                    <p class="link-wrapper">Page: <a href="<?php echo $item['link_url'];?>" target="_blank" class="menu-link"><?php echo $item['link_title'];?></a></p>

                    <!--<div class="text-right"><a href="javascript:void(0);" class="la la-trash remove">&nbsp;</a></div>-->
                <?php } elseif($item['menu_type'] == 'category') {  ?>
                    <input type="hidden" name="menu_link" class="menu-link-id menu-cate-id" value="<?php echo $item['cate_link'];?>">

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label>Navigation Label</label>
                            <input type="text" name="menu_title" class="form-control menu-title" placeholder="Menu item" value="<?php echo htmlentities(stripslashes($item['menu_title']));?>">
                        </div>
                    </div>
                    <?php include "params.php"; ?>
                    <p class="link-wrapper">Category: <a href="<?php echo $item['link_url'];?>" target="_blank" class="menu-link"><?php echo $item['link_title'];?></a></p>
                <?php } ?>
            </div>
        </div>


        <?php
        if(count($item['sub_items']) > 0){
        ?>
            <ol class="menu-group-link">
                <?php
                foreach ($item['sub_items'] as $sub_item) {
                    $this->load->view(ADMIN_DIR . $this->module_name . '/menu_items', array('item' => $sub_item));
                }
                ?>
            </ol>
        <? } ?>
    </div>
</li>