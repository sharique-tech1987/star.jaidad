<?php include __DIR__ . "/../includes/module_header.php"; ?>
<style>
.m-accordion .m-accordion__item-content{
    padding: 0.8rem 1rem !important;
}
.m-accordion .m-accordion__item{
    border-radius: 0;
}
.m-accordion .m-accordion__item .m-accordion__item-head{
    padding: 0.8rem 1.2rem;
}
.m-portlet.m-portlet--head-lg .m-portlet__head {
    height: 4rem;
    padding: 0 1.2rem;
}
.m-portlet .m-portlet__head .m-portlet__head-caption .m-portlet__head-title .m-portlet__head-text{
    font-size: 1.0rem;
    font-weight: 400;
}
.m-portlet {
    margin-bottom: 0.5rem;
}

/* tabs */
.nav-tabs .nav-link{
    border-radius: 0;
    padding: .8rem 2rem;
}
/* Menu Items */
.menu-items { margin: 0; padding: 0; }
.menu-items li{ list-style: none; margin: 0; padding: 0; }
.link-wrapper{ margin: 10px 0;}
</style>
<div class="m-portlet__body p-1">
    <div class="row">
        <div class="col-sm-3">
            <?php include "menu_list.php"; ?>
        </div>

        <div class="<?php echo ($create_menu || $set_menu) ? 'col-sm-9' : 'col-sm-9'; ?>">
            <ul class="nav nav-tabs" role="tablist">
                <?php foreach ($menus as $menu_id => $menu_title) { ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($menu_id == $selected_menu) echo 'active'; ?>" href="<?php echo admin_url($this->module_route . '?m=' . $menu_id); ?>"><?php echo $menu_title; ?></a>
                    </li>
                <?php } ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="m_tabs_1_1" role="tabpanel">
                    <ol style="display: none;">
                        <li class="menu-custom-demo">
                            <div class="panel panel-default item">
                                <div class="panel-heading">
                                    <a href="#" class="btn-link" data-panel="collapse">
                                        <h6 class="panel-title"><span class="menu-label"></span> - <small class="menu-type">Custom</small></h6>
                                    </a>
                                    <div class="panel-icons-group">
                                        <a href="#" data-panel="close" class="btn btn-link remove btn-icon"><i class="icon-remove"></i></a>
                                        <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-down9"></i></a>
                                    </div>
                                </div>

                                <div class="panel-body" style="display: none;">
                                    <input type="hidden" class="menu-id" value="0">
                                    <div class="mgbt15">
                                        <label>Navigation Label</label>
                                        <input type="text" class="form-control menu-title" placeholder="Menu item" value="<?php echo $item['menu_title']; ?>">
                                    </div>
                                    <div class="mgbt15">
                                        <label>URL</label>
                                        <input type="text" class="form-control menu-url" placeholder="Enter url here" value="<?php echo $item['menu_link']; ?>">
                                    </div>
                                    <div class="text-right">
                                        <a href="javascript:void(0);" class="remove red-link"><i class="icon-remove"></i></a>
                                    </div>
                                </div>
                            </div>
                        </li>


                        <li class="menu-item-demo">
                            <div class="panel panel-default item">
                                <div class="panel-heading">
                                    <a href="#" class="btn-link" data-panel="collapse"><h6 class="panel-title"><?php echo $item['menu_title']; ?> - <small class="menu-type"><?php echo ucwords(str_replace('_', ' ', $item['menu_type'])); ?></small></h6></a>
                                    <div class="panel-icons-group">
                                        <a href="#" data-panel="close" class="btn btn-link remove btn-icon"><i class="icon-remove"></i></a>
                                        <a href="#" data-panel="collapse" class="btn btn-link btn-icon"><i class="icon-arrow-down9"></i></a>
                                    </div>
                                </div>

                                <div class="panel-body" style="display: none;">
                                    <input type="hidden" class="menu-id" value="0">
                                    <div class="mgbt15">
                                        <label>Navigation Label</label>
                                        <input type="text" class="form-control menu-title" placeholder="Menu item" value="<?php echo $item['menu_title']; ?>">
                                    </div>
                                    <?php if ($item['menu_type'] == 'custom') { ?>
                                        <div class="mgbt15">
                                            <label>URL</label>
                                            <input type="text" class="form-control menu-url" placeholder="Enter url here" value="<?php echo $item['menu_link']; ?>">
                                        </div>
                                    <?php } else { ?>
                                        <div style="margin: 8px 0;">
                                            <span class="menu-type"><?php echo ucwords(str_replace('_', ' ', $item['menu_type'])); ?></span> :
                                            <a href="<?php echo $item['link_url']; ?>" target="_blank" class="menu-link"><?php echo $item['link_title']; ?></a>
                                            <input type="hidden" class="id-field" value="<?php echo $item['menu_link']; ?>">
                                        </div>
                                    <?php } ?>
                                    <!--<div class="text-right">
                                        <a href="javascript:void(0);" class="remove red-link"><i class="icon-remove"></i></a>
                                    </div>-->
                                </div>
                            </div>
                        </li>
                    </ol>

                    <?php if (count($menu_items) == 0) { ?>
                        <div id="menu-msg" class="alert">No items in this menu</div>
                    <?php } ?>

                    <ol class="menu-items menu-group-link">
                        <?php
                        foreach ($menu_items as $item) {
                            $this->load->view(ADMIN_DIR . $this->module_name . '/menu_items', array('item' => $item));
                        }
                        ?>
                    </ol>


                    <div id="menu-actions" class="form-actions" style="display: <?php echo count($menu_items) > 0 ? 'block' : 'none'; ?>;">
                        <div class="controls">
                            <button type="button" id="menu-save" class="btn btn-danger">Save Menu</button> &nbsp;
                            <?php if ($delete_menu) { ?>
                                <button type="button" id="menu-delete" class="btn">Delete</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--end::Form-->
<?php include __DIR__ . "/../includes/module_footer.php";?>

<script type="text/javascript" src="<?php echo asset_url('vendors/custom/js/nested-sortable.js', true);?>"></script>
<script type="text/javascript">
    $(function () {
        $(document).ready(function () {
            // Menu Sorting

            $('.menu-items').nestedSortable({
                forcePlaceholderSize: true,
                placeholder: 'placeholder',
                handle: '.m-portlet__head',
                toleranceElement: '> .item',
                maxLevels: 8,
                items: 'li'
            });


            // Menu Item Delete
            $(document).on('click', '.menu-items .remove', function (e) {
                e.preventDefault();
                var $parent = $(this).closest('li');
                //$('.navbar .navbar-inner', $parent).css('background', '#FF6359');
                $parent.fadeOut(function () {
                    $(this).remove();
                });
            });

            // Menu Label Update
            $('.menu-items .menu-title').on('keyup', function () {
                $(this).parents('.item').find('.menu-label').text($(this).val());
            });

            // Confirm Delete
            $("#menu-delete").click(function () {
                bootbox.confirm('Are you sure, you want to delete?', function (status) {
                    if (status == true) {
                        window.location = '<?php echo admin_url($this->module_route . '/delete/' . $selected_menu); ?>';
                    }
                });
            });

            //Save menu
            $('#menu-save').click(function () {
                $('#menu-save').attr('disbaled', 'disbaled').text('Saving...');
                var items = getMenuItems($('.menu-items > li'));
                $.post('<?php echo admin_url($this->module_route . '/add/' . $selected_menu); ?>', {items: items}, function () {
                    $('#menu-save').removeAttr('disbaled').text('Save Menu');
                    bootbox.alert('Menu saved successfully!');
                });
            });
        });
    });

    function getMenuItems(obj) {
        var $menu_item, $sub_items, item_id, item_title, item_type, item_link, sub_items = [], items = [];

        obj.each(function () {
            $menu_item = $('.item', this);
            item_id = $('.menu-id', $menu_item).val();
            item_title = $('.menu-title', $menu_item).val();
            item_type = $('.menu-type', $menu_item).first().text();
            item_type = item_type.toLowerCase();

            if (item_type == 'custom') {
                item_link = $('.menu-url', $menu_item).val();
            } else {
                item_link = $('.id-field', $menu_item).val();
            }

            $sub_items = $('> ol > li', this);
            if ($sub_items.length > 0) {
                sub_items = getMenuItems($sub_items);
            } else {
                sub_items = [];
            }

            items.push({
                item_id: item_id,
                item_title: item_title,
                item_type: item_type,
                item_link: item_link,
                sub_items: sub_items
            });
        });

        return items;
    }
</script>