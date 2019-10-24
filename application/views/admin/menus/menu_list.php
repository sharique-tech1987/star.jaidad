<div class="m-accordion m-accordion--bordered" id="m_accordion_1" role="tablist">
<?php if ($create_menu || $set_menu) { ?>
    <?php if ($create_menu) { ?>

        <div class="m-accordion__item">
            <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_1_head" data-toggle="collapse" href="#m_accordion_1_item_1_body" aria-expanded="    false">
                <span class="m-accordion__item-icon">
                    <i class="fa flaticon-user-ok"></i>
                </span>
                <span class="m-accordion__item-title">Create Menu</span>
                <span class="m-accordion__item-mode"></span>
            </div>
            <div class="m-accordion__item-body collapse" id="m_accordion_1_item_1_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_1_head" data-parent="#m_accordion_1">
                <div class="m-accordion__item-content">

                    <form action="" method="post">
                        <div class="form-group m-form__group">
                            <input type="text" placeholder="Menu Name" name="type_name" id="menu_name" class="form-control" value="<?php echo set_value('type_name'); ?>" />
                        </div>
                        <button type="submit" name="create" class="btn btn-primary col-sm-12">Create</button>
                    </form>

                </div>
            </div>
        </div>

    <?php } ?>

    <?php
    if ($set_menu) { ?>
        <div class="m-accordion__item">
            <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_set_menu_head" data-toggle="collapse" href="#m_accordion_set_menu_body" aria-expanded="false">
                <span class="m-accordion__item-icon">
                    <i class="fa flaticon-user-ok"></i>
                </span>
                <span class="m-accordion__item-title">Theme Locations</span>
                <span class="m-accordion__item-mode"></span>
            </div>
            <div class="m-accordion__item-body collapse" id="m_accordion_set_menu_body" class=" " role="tabpanel" aria-labelledby="m_accordion_set_menu_head" data-parent="#m_accordion_1">
                <div class="m-accordion__item-content">

                    <form action="<?php echo admin_url($this->module_route . '/set-menu'); ?>" method="post" id="set-menu-form">
                        <div class="mgbt15 full-width-selectbox">
                            <label>Header Navigation</label>
                            <select name="option[header_nav]" class="form-control">
                                <option value="0">None</option>
                                <?php echo option_list($menus, $this->option->header_nav); ?>
                            </select>
                        </div>
                        <div class="mgbt15 full-width-selectbox">
                            <label>Footer Navigation</label>
                            <select name="option[footer_nav]" class="form-control">
                                <option value="0">None</option>
                                <?php echo option_list($menus, $this->option->footer_nav); ?>
                            </select>
                        </div>
                        <div>
                            <button type="button" id="set-menu" class="btn">Save</button>
                        </div>
                    </form>

                    <script type="text/javascript">
                        var $smloader, $smform;
                        $(function(){
                            $('#set-menu').click(function(){
                                $('#set-menu').attr('disabled', 'disabled').text('Saving...');
                                var $form = $('#set-menu-form');
                                $.post($form.attr('action'), $form.serialize(), function(){
                                    $('#set-menu').removeAttr('disabled').text('Save');
                                    //alert_success('Theme locations updated!');
                                    $.jGrowl('Theme locations updated!');
                                });
                            });
                        });
                    </script>

                </div>
            </div>
        </div>

    <?php } ?>

<?php } ?>
</div>
<br>
<div class="m-accordion m-accordion--bordered" id="m_accordion_2" role="tablist">
<?php
if (count($menu_types) > 0) { ?>
    <?php
    foreach ($menu_types as $i => $row) {
        if (count($row['listing']) == 0) continue;
        ?>
        <div class="m-accordion__item">
            <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_head_<?php echo $row['name']; ?>" data-toggle="collapse" href="#m_accordion_body_<?php echo $row['name']; ?>" aria-expanded="false">
                <span class="m-accordion__item-icon"><i class="fa flaticon-user-ok"></i></span>
                <span class="m-accordion__item-title"><?php echo $row['title']; ?></span>
                <span class="m-accordion__item-mode"></span>
            </div>

            <div class="m-accordion__item-body collapse search-container" id="m_accordion_body_<?php echo $row['name']; ?>" role="tabpanel" aria-labelledby="m_accordion_head_<?php echo $row['name']; ?>" data-parent="#m_accordion_2" style="">
                <div class="m-input-icon  m-input-icon--right">
                    <input id="search" class="form-control m-input m-input--air search-input" type="text" placeholder="Search page..." find-block=".m-accordion__item-content" find-in="[class*=menu-group-link]" autocomplete="off">
                    <span class="m-input-icon__icon m-input-icon__icon--right"><span><i class="la la-search"></i></span></span>
                </div>

                <div class="m-accordion__item-content">
                    <?php foreach ($row['listing'] as $item) { ?>
                    <div class="-form-group m-form__group menu-group-link">
                        <label class="m-checkbox m-checkbox--square fields-data">
                            <input type="checkbox" class="id-field" value="<?php echo $item['id']; ?>"> <?php echo $item['title']; ?>
                            <input type="hidden" class="title-field" value="<?php echo $item['title']; ?>">
                            <input type="hidden" class="alias-field" value="<?php echo $item['friendly_url']; ?>">

                            <input type="hidden" class="type-field" value="<?php echo $row['name']; ?>">
                            <input type="hidden" class="type-title" value="<?php echo $row['title']; ?>">
                            <input type="hidden" class="url-field" value="<?php echo $row['url_base']; ?>">
                            <span></span>
                        </label>
                    </div>
                    <?php } ?>


                    <div class="text-center">
                        <div class="m-btn-group m-btn-group--pill btn-group ">
                            <button type="button" class="m-btn btn btn-primary add-to-menu">Add to Menu</button>
                            <a class="select-all m-btn btn btn-info" data-check="false" href="javascript:void(0);">Select All</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
<?php } ?>


<script type="text/javascript">
    $(function(){
        // Toggle Selector

        $(document).on('click', '.select-all', function () {
            var $parent = $(this).closest('.m-accordion__item-content');
            var check = $(this).data('check');
            if(!check){
                $(this).data('check', true).html('Unselect All');
                $parent.checkboxes('check');
            }else{
                $(this).data('check', false).html('Select All');
                $parent.checkboxes('uncheck');
            }
        });

        // Selected Items Add to Menu
        $(document).on('click', '.add-to-menu', function () {
            var $parent, $label, $new_item, menu_type, url_base, id_field, title_field, alias_field, menu_type_title;

            $parent = $(this).closest('.m-accordion__item');


            menu_type = $('.type-field', $parent).val();
            menu_type_title = $('.type-title', $parent).val();
            url_base = $('.url-field', $parent).val();

            $('.id-field:checked', $parent).each(function(){
                $label = $(this).closest('.fields-data');
                id_field = $(this).val();
                title_field = $('.title-field', $label).val();
                alias_field = $('.alias-field', $label).val();

                $new_item = $('.html-menu .menu-li-' + menu_type).clone(true, true);
                _ploter_action($new_item);
                //$new_item.find('.m-portlet__body').css('display', 'block');
                $('.m-portlet', $new_item).attr('id', 'm_portlet_tools_n_' + id_field);
                $('.menu-title', $new_item).not('input').text(title_field);
                $('.menu-type', $new_item).not('input').text(menu_type);

                //$('[name=id]', $new_item).val('');
                $('[name=menu_link]', $new_item).val(id_field);
                $('[name=menu_type]', $new_item).val(menu_type);
                $('[name=menu_title]', $new_item).attr('value', title_field);
                console.log($('[name=menu_title]', $new_item).val());
                $('.menu-link', $new_item).text(title_field).attr('href', url_base + alias_field);

                $('input[name=params\\\[alt\\\]]', $new_item).attr('value', title_field);

                //$('.menu-items').prepend($new_item);
                $new_item.find('input').unbind('click blur focus mouseover mouseout mouseup mousedown');
                $('.menu-items').append($new_item);
            });
            $parent.checkboxes('uncheck');

            if ($('.menu-items li').length > 0) {
                $('#menu-actions').show();
                $('#menu-msg').hide();
            }
        });

        function _ploter_action(ploter) {
            ploter.find('[m-portlet-tool="toggle"]').click(function (e) {
                e.preventDefault();
                $(this).closest('.m-portlet').find('.m-portlet__body').slideToggle();
            });
            ploter.find('[m-portlet-tool="remove"]').click(function (e) {
                e.preventDefault();
                $(this).closest('.m-portlet').remove();
            });
        }
    });
</script>
<?php } ?>


    <style type="text/css">
        #menu-types { margin-bottom: 20px; }
        #menu-types .accordion-inner .checkbox-list { height: 192px; overflow-y: auto; }
    </style>

    <div class="m-accordion__item">
        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_custom_head" data-toggle="collapse" href="#m_accordion_custom_body" aria-expanded="false">
            <span class="m-accordion__item-icon">
                <i class="fa flaticon-user-ok"></i>
            </span>
            <span class="m-accordion__item-title">Custom Links</span>
            <span class="m-accordion__item-mode"></span>
        </div>
        <div class="m-accordion__item-body collapse" id="m_accordion_custom_body" class=" " role="tabpanel" aria-labelledby="m_accordion_custom_head" data-parent="#m_accordion_2">
            <div class="m-accordion__item-content">

                <div class="form-group m-form__group">
                    <label class="control-label">Label</label>
                    <input type="text" id="menu-custom-label" class="form-control" placeholder="Menu item">
                </div>

                <div class="form-group m-form__group">
                    <label class="control-label">URL</label>
                    <input type="text" id="menu-custom-url" class="form-control" placeholder="Enter url here">
                </div>
                <div class="txtright"><button type="button" id="menu-custom-add" class="btn btn-primary col-sm-12">Add to Menu</button></div>

                <script type="text/javascript">
                    $(function(){
                        $('#menu-custom-add').click(function(){
                            var menu_custom_url = $('#menu-custom-url').val();
                            var menu_custom_label = $('#menu-custom-label').val();
                            if (menu_custom_label != '') {
                                var $new_item = $('.menu-custom-demo').clone(true, true).appendTo('.menu-items').removeClass('menu-custom-demo');
                                $('.menu-label', $new_item).text(menu_custom_label);
                                $('.menu-title', $new_item).val(menu_custom_label);
                                $('.menu-url', $new_item).val(menu_custom_url);
                                $('#menu-custom-url').val('');
                                $('#menu-custom-label').val('');
                                $('#menu-actions').show();
                                $('#menu-msg').hide();
                            }
                        });
                    })
                </script>

            </div>
        </div>
    </div>

</div>