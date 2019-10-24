<?php
$head_opt = ['sticky_head' => false, 'title' => true];
include __DIR__ . "/../includes/module_header.php"; ?>
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
    .menu-items li.placeholder{ border: 1px dashed #ededed; background-color: #DFCFBE; margin: 5px 0; }
    .link-wrapper{ margin: 10px 0;}
    .menu-items li .menu-type{ margin: 0 10px; text-transform: capitalize }
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
                        <a class="nav-link <?php if ($menu_id == $selected_menu) echo 'active'; ?>" href="<?php echo admin_url($this->_route . '?m=' . $menu_id); ?>"><?php echo $menu_title; ?></a>
                    </li>
                <?php } ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="m_tabs_1_1" role="tabpanel">
                    <ol class="html-menu" style="display: none;">
                        <?php
                        $item = [];
                        $item['menu_type'] = 'custom';
                        $this->load->view(ADMIN_DIR . $this->module_name . '/menu_items', array('item' => $item));

                        $item['menu_type'] = 'page';
                        $this->load->view(ADMIN_DIR . $this->module_name . '/menu_items', array('item' => $item));?>

                    </ol>

                    <?php if (count($menu_items) == 0) { ?>
                        <div id="menu-msg" class="alert alert-danger">No items in this menu</div>
                    <?php } else { ?>

                        <div class="m-input-icon  m-input-icon--right">
                            <input id="search" class="form-control m-input m-input--air search-input" type="text" placeholder="Search Menu..." find-block=".menu-items" find-in=".item" autocomplete="off">
                            <span class="m-input-icon__icon m-input-icon__icon--right"><span><i class="la la-search"></i></span></span>
                        </div>
                        <hr>
                        <?php } ?>
                        <ol class="menu-items menu-group-link">
                            <?php
                            foreach ($menu_items as $item) {
                                $this->load->view(ADMIN_DIR . $this->module_name . '/menu_items', array('item' => $item));
                            }
                            ?>
                        </ol>


                    <div id="menu-actions" class="form-actions text-center" style="display: block;">
                        <br>
                        <div class="m-btn-group m-btn-group--pill btn-group ">
                            <?php
                            /*if(count($menu_items) > 0)*/
                            {
                                echo '<button type="button" id="menu-save" class="m-btn btn btn-primary">Save Menu</button>';
                            }if($delete_menu){
                                echo '<button type="button" id="menu-delete" class="m-btn btn btn-danger">Delete Menu</button>';
                            }
                            ?>
                        </div>
                    </div>
                    <br>

                </div>
            </div>
        </div>
    </div>
</div>

<!--end::Form-->
<?php include __DIR__ . "/../includes/module_footer.php";?>
<?php include __DIR__ . "/../includes/icons.php";?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo asset_url('vendors/custom/js/nested-sortable.js', true);?>"></script>

<script type="text/javascript">
    $(function () {
        $(document).ready(function () {
            // Menu Sorting

            $('.menu-items').nestedSortable({
                forcePlaceholderSize: true,
                placeholder: 'placeholder',
                items: 'li',
                handle: 'div.m-portlet__head',
                //maxLevels: 8
            });


            $(document).on('keyup', '.menu-items .menu-title', function () {
                $(this).closest('.item').find('.menu-label').text($(this).val());
            });

            // Confirm Delete
            $("#menu-delete").click(function () {
                bootbox.confirm('Are you sure, you want to delete?', function (status) {
                    if (status == true) {
                        window.location = '<?php echo admin_url($this->_route . '/delete/' . $selected_menu); ?>';
                    }
                });
            });

            //Save menu
            $('#menu-save').click(function () {
                $('#menu-save').attr('disbaled', 'disbaled').text('Saving...');
                var items = getMenuItems($('.menu-items > li'));
                console.log(items);
                $.post('<?php echo admin_url($this->_route . '/add/' . $selected_menu); ?>', {items: items}, function () {
                    $('#menu-save').removeAttr('disbaled').text('Save Menu');
                    bootbox.alert('Menu saved successfully!');
                });
            });
        });
    });

    function getMenuItems(obj) {
        var $menu_item, $sub_items, item_id, item_title, item_type, menu_link, params, sub_items = [], items = [];

        obj.each(function () {
            $menu_item = $(this).find('> .item');

            item_id = $('[name="id"]', $menu_item).val();
            item_title = $('[name="menu_title"]', $menu_item).val();
            item_type = $('[name="menu_type"]', $menu_item).val();
            menu_link = $('[name="menu_link"]', $menu_item).val();

            /*params = $menu_item.find('.m-portlet__body').eq(0)[0];
            params = $(params).find('[name^=params]').serialize();*/

            $sub_items = $('ol > li', $menu_item.closest('li'));

            if ($sub_items.length > 0) {
                console.log($menu_item, '-main');
                sub_items = getMenuItems($sub_items);
            } else {
                sub_items = [];
            }

            items.push({
                item_id: item_id,
                item_title: item_title,
                item_type: item_type,
                menu_link: menu_link,
                params: params,
                sub_items: sub_items
            });
        });

        return items;
    }
</script>