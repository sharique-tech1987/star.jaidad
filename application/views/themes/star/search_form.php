<style>
    .col-sm-2, .col-sm-3 {
        padding-left:  5px;
        padding-right: 5px;
    }
    .pd-top-100 {
        padding-top: 40px !important;
    }
    .area_unit-c .dropdown.show{
        display: inline-block !important;
    }
</style>
<?php
$purpose = (getVar('purpose'));
$purpose = (!empty($purpose) ? $purpose : 'Sale');
$city_id = intval(getVar('city_id'));
$area_ids = getVar('area_ids');
$area_unit = getVar('area_unit');
if(empty($_COOKIE['area_unit'])){
    $_COOKIE['area_unit'] = 'Square Feet';
}
if(empty($area_unit)){
    //$area_unit = $this->input->cookies('area_unit');
    $area_unit = $_COOKIE['area_unit'];
}
$type_id = intval(getVar('type_id'));
$price = getVar('price');
$area = getVar('area');
$bedrooms = getVar('bedrooms');
$bathrooms = getVar('bathrooms');

if(!($_COOKIE['_price']))
{
    $_COOKIE['_price'] = $this->db->query("SELECT MIN(price) AS `min` ,  MAX(price) AS `max` FROM `properties` WHERE `purpose`='{$purpose}'")->row_array();
}
if(!($_COOKIE['_area']))
{
    $_area = $this->db->query("SELECT MIN(square_meter) AS `min` ,  MAX(square_meter) AS `max` FROM `properties`")->row_array();

    $_area['min'] = number_format(area_conversion($_area['min'], 'square meter', $_COOKIE['area_unit']), 0, '', '');
    $_area['max'] = number_format(area_conversion($_area['max'], 'square meter', $_COOKIE['area_unit']), 0, '', '');
    $_COOKIE['_area'] = $_area;
}

$thisFile = pathinfo(__FILE__, PATHINFO_FILENAME);

?>

<div class="ere-search-properties clearfix style-mini-line color-dark ">

    <form method="get" action="<?php echo site_url('properties'); ?>">
        <div class="form-search-wrap">
            <div class="form-search-inner">
                <div class="ere-search-content">
                    <div data-href="<?php echo site_url('properties'); ?>" class="-search-properties-form">
                        <div class="form-search">
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-2 form-group">
                                    <select class="search-field form-control select2 " name="purpose">
                                        <?php
                                        $_purpose = get_enum_values('properties', 'purpose');
                                        $_purpose['Sale'] = 'Buy';
                                        echo selectBox($_purpose, $purpose); ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-group">
                                    <select class="ere-property-city-ajax search-field form-control select2" name="city_id" id="search_city_id">
                                        <?php echo selectBox("SELECT id, city FROM cities WHERE status='Active'", $city_id); ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-4 col-xs-5 form-group area-form-input">
                                    <select class="search-field form-control select2-tags-area" id="search_area_id" name="area_ids[]" multiple style="width: 100%">
                                        <?php
                                        if (count($area_ids) > 0 && is_array($area_ids))
                                            echo selectBox("SELECT id, area FROM area WHERE status='Active' AND city_id='{$city_id}' AND id IN(" . join(',', array_map("intval", $area_ids)) . ")", ($area_ids)); ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-group submit-search-form pull-right">
                                    <div class="advanced-wrap clearfix">
                                        <div class="enable-other-advanced">
                                            <a href="javascript:void(0)" class="btn-other-advanced"><i class="fa fa-gear"></i></a>
                                        </div>
                                    </div>
                                    <button type="submit" class="ere-advanced-search-btn"><i class="fa fa-search"></i> Search </button>
                                </div>
                            </div>


                            <div class="advanced-search -col-xs-12 hidden-xs" style="display: -none;">
                                <div class="row">
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 hidden-xs form-group">
                                        <select class="search-field form-control select2" name="type_id">
                                            <option value="">Property Type</option>
                                            <?php
                                            $this->multilevels->type = 'select';
                                            $this->multilevels->id_Column = 'id';
                                            $this->multilevels->title_Column = 'type';
                                            $this->multilevels->link_Column = 'module';
                                            $this->multilevels->type = 'select';
                                            $this->multilevels->level_spacing = 7;
                                            //$this->multilevels->spacing_str = '-';
                                            $this->multilevels->selected = $type_id;
                                            $this->multilevels->option_html = '<option {selected} data-img="'.asset_url('front/property_types/').'{image}" value="{key}">{val}</option>';
                                            $this->multilevels->query = "SELECT * FROM `property_types` WHERE status='Active' ORDER BY ordering ASC";
                                            echo $multiLevelComponents = $this->multilevels->build();
                                            //echo selectBox($this->multilevels->query, '', '<option {selected} data-image="{image}" value="{id}">{type}</option>');
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 hidden-xs form-group" style="position: static;">

                                        <?php $price = getVar('price');
                                        $_price = [];
                                        $_price['min'] = (!empty($price['min']) ? $price['min'] : $_COOKIE['_price']['min']);
                                        $_price['max'] = (!empty($price['max']) ? $price['max'] : $_COOKIE['_price']['max']);
                                        ?>

                                        <div class="row no-padding no-border no-margin price-row slider-parent">
                                            <div class="col-sm-10 no-padding">
                                                <div class="price-popover">
                                                    <div class="col-sm-6 col-no-padding">
                                                        <input type="text" name="price[min]" value="<?php echo ($_price['min'] == $_COOKIE['_price']['min'] ? '' : $_price['min']); ?>" class="min-input-request form-control search-field" placeholder="Price Min" autocomplete="off">
                                                        <span class="fa fa-angle-down drop-angle"></span>
                                                    </div>
                                                    <div class="col-sm-6 col-no-padding">
                                                        <input type="text" name="price[max]" value="<?php echo ($_price['max'] == $_COOKIE['_price']['max'] ? '' : $_price['max']); ?>" class="max-input-request form-control search-field text-right" placeholder="Price Max" autocomplete="off">
                                                        <span class="fa fa-angle-down drop-angle"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 slider-div">
                                                    <div class="ere-sliderbar-price-wrap">
                                                        <div class="ere-sliderbar-price my-sliderbar-filter" data-min-default="<?php echo $_COOKIE['_price']['min'];?>" data-max-default="<?php echo $_COOKIE['_price']['max'];?>" data-min="<?php echo $_price['min']; ?>" data-max="<?php echo $_price['max']; ?>">
                                                            <div class="sidebar-filter ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 no-padding text-center pop-dismiss">
                                                <a href="javascript: void(0);"><b>Price<br>in<br><span class="slider-unit">PKR</span></b></a>
                                            </div>
                                        </div>

                                        <div style="position: absolute;" class="dropdown selection-box" data-in=".price-row" id="drop-price">
                                            <ul class="dropdown-menu -show" aria-labelledby="dLabel">
                                                <li>
                                                    <?php
                                                    $sale_price =  json_decode(get_option('sale_price'));
                                                    $rent_price =  json_decode(get_option('rent_price'));
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6" data-input="min">
                                                            <div id="price_top"></div>
                                                            <a href="#" aria-label="" data-int="0" data-purpose="Sale" class="btn btn-sm btn-block btn-default sale-price-btn btn-set-value">Min</a>
                                                            <a href="#" aria-label="" data-int="0" data-purpose="Rent" class="btn btn-sm btn-block btn-default rent-price-btn btn-set-value">Min</a>
                                                            <?php
                                                            foreach ($sale_price as $i => $item) {
                                                                if(!empty($item) && ($i + 1) < count($sale_price)){
                                                                    ?><a href="#" aria-label="<?php echo $item;?>" data-int="<?php echo number_to_int($item);?>" data-purpose="Sale" class="btn btn-sm btn-block btn-gray sale-price-btn btn-set-value"><?php echo $item;?></a><?php
                                                                }
                                                            }
                                                            foreach ($rent_price as $i => $item) {
                                                                if(!empty($item) && ($i + 1) < count($rent_price)){
                                                                    ?><a href="#" aria-label="<?php echo $item;?>" data-int="<?php echo number_to_int($item);?>" data-purpose="Rent" class="btn btn-sm btn-block btn-gray rent-price-btn btn-set-value"><?php echo $item;?></a><?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6" data-input="max">
                                                            <a href="#" aria-label="" data-int="99999999999999999999999999" data-purpose="Sale" class="btn btn-sm btn-block btn-default sale-price-btn btn-set-value">Max</a>
                                                            <a href="#" aria-label="" data-int="99999999999999999999999999" data-purpose="Rent" class="btn btn-sm btn-block btn-default rent-price-btn btn-set-value">Max</a>

                                                            <?php
                                                            foreach ($sale_price as $i => $item) {
                                                                if(!empty($item) && $i > -1){
                                                                    ?><a href="#" aria-label="<?php echo $item;?>" data-int="<?php echo number_to_int($item);?>" data-purpose="Sale" class="btn btn-sm btn-block btn-gray sale-price-btn btn-set-value"><?php echo $item;?></a><?php
                                                                }
                                                            }
                                                            foreach ($rent_price as $i => $item) {
                                                                if(!empty($item) && $i > -1){
                                                                    ?><a href="#" aria-label="<?php echo $item;?>" data-int="<?php echo number_to_int($item);?>" data-purpose="Rent" class="btn btn-sm btn-block btn-gray rent-price-btn btn-set-value"><?php echo $item;?></a><?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 hidden-xs form-group" style="border-radius: 0; position: static;">
                                        <?php $area_units = get_enum_values('properties', 'area_unit');
                                        if(empty($area_unit)) {
                                            $unit_keys = array_keys($area_units);
                                            $area_unit = $unit_keys[0];
                                        }
                                        ?>
                                        <script>
                                            $(document).ready(function() {
                                                $(document).on('click', '.area_unit-menu li', function(e) {
                                                    e.preventDefault();
                                                    let area_unit = $(this).find('a').text();
                                                    $('#area_unit').val(area_unit);
                                                    $('.area_unit-show').html(area_unit);
                                                    $.cookie('area_unit', area_unit);
                                                });
                                            });
                                        </script>
                                        <input type="hidden" name="area_unit" id="area_unit" value="<?php echo $area_unit;?>">

                                        <?php
                                        $_area = [];
                                        $_area['min'] = (!empty($area['min']) ? $area['min'] : $_COOKIE['_area']['min']);
                                        $_area['max'] = (!empty($area['max']) ? $area['max'] : $_COOKIE['_area']['max']);
                                        ?>
                                        <div class="row no-padding no-border no-margin area-row slider-parent" style="border-radius: 0;">
                                            <div class="col-sm-10 no-padding">
                                                <div class="area-popover">
                                                    <div class="col-sm-6 col-no-padding">
                                                        <input type="text" name="area[min]" value="<?php echo ($_area['min'] == $_COOKIE['_area']['min'] ? '' : $_area['min']); ?>" class="min-input-request form-control search-field" placeholder="Area Min" autocomplete="off">
                                                        <span class="fa fa-angle-down drop-angle"></span>
                                                    </div>
                                                    <div class="col-sm-6 col-no-padding">
                                                        <input type="text" name="area[max]"
                                                               value="<?php echo($_area['max'] == $_COOKIE['_area']['max'] ? '' : $_area['max']); ?>"
                                                               class="max-input-request form-control search-field text-right"
                                                               placeholder="Area Max" autocomplete="off">
                                                        <span class="fa fa-angle-down drop-angle"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 slider-div">
                                                    <div class="ere-sliderbar-price-wrap">
                                                        <div class="ere-sliderbar-price my-sliderbar-filter"
                                                             data-min-default="<?php echo $_COOKIE['_area']['min']; ?>"
                                                             data-max-default="<?php echo $_COOKIE['_area']['max']; ?>"
                                                             data-min="<?php echo $_area['min']; ?>"
                                                             data-max="<?php echo $_area['max']; ?>">
                                                            <div class="sidebar-filter ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-sm-2 col-no-padding text-center open_unit_popup pop-dismiss">
                                                <div>
                                                    <a href="#" class="open_unit_popup" data-toggle="modal" data-target="#myModal"><b>Change<br>Area<br><b
                                                                    class="unit_popup"><?php echo short_area_unit($area_unit); ?></b></b></a>
                                                </div>

                                            </div>

                                        </div>
                                        <div style="position: absolute;: ab" class="dropdown selection-box"
                                             data-in=".area-row" id="drop-area">
                                            <ul class="dropdown-menu -show" aria-labelledby="dLabel">
                                                <li>
                                                    <a href="javascript: void(0);"
                                                       class="btn btn-block btn-gray open_unit_popup">Change Area
                                                        Unit</a>
                                                    <div id="area_top"></div>
                                                    <?php
                                                    $area_units = get_enum_values('properties', 'area_unit');
                                                    foreach ($area_units as $area_unit) {
                                                        $short_name_unit = url_title($area_unit, '_');
                                                        $unit_breakup = json_decode(get_option($short_name_unit . '_unit'));
                                                        ?>
                                                        <div class="row <?php echo $short_name_unit; ?> unit-div"
                                                             style="display: <?php echo($_COOKIE['area_unit'] == $area_unit ? '' : 'none') ?>;">
                                                            <div class="col-md-6 col-sm-6" data-input="min">
                                                                <a href="#area_top" aria-label="" data-int="0"
                                                                   data-purpose
                                                                   class="btn btn-default btn-sm btn-block btn-set-value">Min</a>
                                                                <?php
                                                                foreach ($unit_breakup as $i => $item) {
                                                                    if (!empty($item) && ($i + 1) < count($unit_breakup)) {
                                                                        ?><a href="#" aria-label="<?php echo $item; ?>"
                                                                             data-int="<?php echo number_to_int($item); ?>"
                                                                             data-purpose
                                                                             class="btn btn-gray btn-sm btn-block btn-set-value"><?php echo $item; ?></a><?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6" data-input="max">
                                                                <a href="#area_top" aria-label=""
                                                                   data-int="99999999999999999999999999" data-purpose
                                                                   class="btn btn-default btn-sm btn-block btn-set-value">Max</a>
                                                                <?php
                                                                foreach ($unit_breakup as $i => $item) {
                                                                    if (!empty($item) && $i > -1) {
                                                                        ?><a href="#" aria-label="<?php echo $item; ?>"
                                                                             data-int="<?php echo number_to_int($item); ?>"
                                                                             data-purpose
                                                                             class="btn btn-gray btn-sm btn-block btn-set-value"><?php echo $item; ?></a><?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>


                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 hidden-xs form-group  " >
                                        <select class="search-field form-control select2" name="bedrooms" id="bedrooms"
                                                style="margin-left: 1px;">
                                            <option value="">Room(s)</option>
                                            <?php
                                            foreach (range(1, 10) as $item) {
                                                echo '<option ' . _selectbox($bedrooms, $item) . ' value="' . $item . '">' . ($item == 10 ? "10+" : $item) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


</div>

<?php if ($thisFile == 'search_form') { ?>
    <style>

        [class^='select2'] {
            border-radius: 16px !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background: #92C800;
            color: white
        }
        #select2-bedrooms-results li.select2-results__option{
            text-align: center !important;
        }


    </style>

<?php } ?>

<script>
    $(function () {
        $(document).ready(function () {


            $('.g5plus-space, .form-search > div.row, .advanced-search select,.page-title-large, .inner-container-wrap, .pop-dismiss').on('click', function () {

                //if($('#drop-price .dropdown-menu').hasClass('show'))
                $('#drop-price .dropdown-menu').removeClass('show');
                $('#drop-area .dropdown-menu').removeClass('show');
            });

            $(document).on('click', '.btn-set-value', function (e) {
                e.preventDefault();
                let _value = $(this).attr('aria-label');
                let _data = $(this).data();

                let _data_type = $(this).closest('[data-input]').data();
                let _data_in = $(this).closest('.selection-box').data('in');
                /*console.log(_data);
                 console.log(_data_type);
                 console.log(_data_in);
                 console.log(_value);*/

                $('.dropdown-menu').animate({scrollTop: 0}, 'slow');

                let reverse_type = 'min';
                if (_data_type.input == reverse_type) reverse_type = 'max';

                if ((typeof _data.purpose == 'undefined' || _data.purpose == '')) {
                    _data.purpose = '';
                    if (_data_type.input == 'min')
                        _slider.slider("values", 0, _data.int);
                    if (_data_type.input == 'max')
                        _slider.slider("values", 1, _data.int);

                } else {
                    if (_data_type.input == 'min')
                        price_slider.slider("values", 0, _data.int);
                    if (_data_type.input == 'max')
                        price_slider.slider("values", 1, _data.int);
                }

                $(this).closest('.selection-box').find('[data-input=' + reverse_type + '] a[data-purpose="' + _data.purpose + '"]').each(function () {
                    if ($(this).data('int') < _data.int && reverse_type == 'max') {
                        $(this).hide(0);
                    } else if ($(this).data('int') > _data.int && reverse_type == 'min') {
                        $(this).hide(0);
                    } else {
                        $(this).show(0);
                    }
                });


                $(_data_in).find('.' + _data_type.input + '-input-request').eq(0).prop('value', _value)
                $(_data_in).find('.' + _data_type.input + '-input-request').eq(1).prop('value', numeral(_value).value())


                var chk_min = $(_data_in).find('.min-input-request').val();
                var chk_max = $(_data_in).find('.max-input-request').val();

                if(chk_min != '' && chk_max != ''){
                    $('#drop-price .dropdown-menu, #drop-area .dropdown-menu').removeClass('show');
                }
            });

            $(document).on('click', '.price-row .drop-angle', function (e) {
                e.preventDefault();
                $('#drop-area .dropdown-menu').removeClass('show');
                $('#drop-price .dropdown-menu').addClass('show').width($('.price-row .slider-div').outerWidth());
            });

            $(document).on('focus', '.price-popover', function (e) {
                e.preventDefault();
                $('#drop-area .dropdown-menu').removeClass('show');
                $('#drop-price .dropdown-menu').removeClass('show');
                //$('#drop-price .dropdown-menu').addClass('show').width($('.price-row .slider-div').width());
            });

            $(document).on('click', '.area-row .drop-angle', function (e) {
                e.preventDefault();
                $('#drop-price .dropdown-menu').removeClass('show');
                $('#drop-area .dropdown-menu').addClass('show').width($('.area-row .slider-div').outerWidth());
            });
            $(document).on('focus', '.area-popover', function (e) {
                e.preventDefault();

                $('#drop-price .dropdown-menu').removeClass('show');
                $('#drop-area .dropdown-menu').removeClass('show');
                //$('#drop-area .dropdown-menu').addClass('show').width($('.area-row .slider-div').width());
            });

            $(document).on('input', '.min-input-request, .max-input-request', function (e) {
                e.preventDefault();

                if ($(this).val().length > 0 && $(this).attr('type') == 'text') {
                    $(this).val(numeral($(this).val()).format('0,0'));
                }

                if($(this).attr('type') == 'text') {
                    let json = {};

                    json.min = numeral($('.min-input-request').val()).value();
                    json.max = numeral($('.max-input-request').val()).value();
                    json.min = (json.min == null ? 0 : json.min);
                    json.max = (json.max == null ? max_price : json.max);
                    //console.log(json);

                    price_slider.slider("option", "values", [json.min, json.max]);
                }
            });


            //console.log($(".sidebar-filter").slider( "values" ));
            var $searchPopup = $('.area_popup_wrapper');
            $(document).on('click', '.open_unit_popup', function (e) {

                $("#myModal").modal('show');
                $("#_area_unit").select2({
                    dropdownParent: $("#myModal")
                })


            });

            $(document).on('click', '[data-dialog-close]', function (e) {
                e.preventDefault();
                $searchPopup.removeClass('in dialog--close dialog--open');
                $('body').removeClass('overflow-hidden');
            });

            let min_price = <?php echo intval($_COOKIE['_price']['min']);?>;
            let max_price = <?php echo intval($_COOKIE['_price']['max']);?>;

            let min_area = <?php echo intval($_COOKIE['_area']['min']);?>;
            let max_area = <?php echo intval($_COOKIE['_area']['max']);?>;

            $('.my-sliderbar-filter').each(function (i, v) {
                var a = $(this), t = parseInt(a.attr("data-min-default")), r = parseInt(a.attr("data-max-default")),
                    i = a.attr("data-min"), n = a.attr("data-max"), s = a.find(".sidebar-filter"), c, o;
                var p = a.closest('.slider-parent');

                s.slider({
                    min: t, max: r, range: !0, values: [i, n], slide: function (e, t) {

                        //console.log(p);
                        c = t.values[0];
                        o = t.values[1];
                        a.attr("data-min", c);
                        a.attr("data-max", o);

                        let cmin = (c == min_price || c == min_area) ? '' : numeral(c).format('0,0');
                        let cmax = (o == max_price || o == max_area) ? '' : numeral(o).format('0,0');

                        p.find("input.min-input-request").prop("value", (cmin));
                        p.find("input.max-input-request").prop("value", (cmax));

                        if (a.find("span").hasClass("not-format")) {
                            a.find("span.min-value").html(c);
                            a.find("span.max-value").html(o)
                        } else {
                            a.find("span.min-value:not(.not-format)").html(ERE.number_format(c));
                            a.find("span.max-value:not(.not-format)").html(ERE.number_format(o))
                        }
                    }, stop: function (e, t) {

                    }
                })
            });


            let purpose = $('.search-properties-form [name=purpose]').val();
            let price_slider = $('.price-row .sidebar-filter');

            $('.search-properties-form [name=purpose]').trigger('change');

            let _slider = $('.area-row .sidebar-filter');
            $(document).on('change', '#_area_unit', function (e) {
                let _area_unit = $(this).val();
                $('#drop-area .unit-div').hide(0);
                $('#drop-area .unit-div.' + _area_unit.replace(' ', '_')).show(0);
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: '<?php echo site_url('property/ajax/convert_area_unit');?>',
                    data: {
                        _area_unit: _area_unit,
                        min: <?php echo $_COOKIE['_area']['min'];?>,
                        max: <?php echo $_COOKIE['_area']['max'];?>},
                }).done(function (json) {
                    console.log(json);
                    json.min = parseFloat(json.min);
                    json.max = parseFloat(json.max);

                    min_area = json.min;
                    max_area = json.max;
                    $("[name=area\\[min\\]]").val('');
                    $("[name=area\\[max\\]]").val('');

                    $('.area-row .ere-sliderbar-filter').attr({
                        'data-min-default': json.min,
                        'data-max-default': json.max,
                        'data-min': json.min,
                        'data-max': json.max
                    });

                    _slider.slider("option", "min", json.min);
                    _slider.slider("option", "max", json.max);
                    _slider.slider("option", "values", [json.min, json.max]);

                    $('.unit_popup').html(json.short_area_unit);
                    $.cookie('area_unit', _area_unit);
                    $('[data-dialog-close]').trigger('click');

                })
                    .fail(function () {

                    });

                $('#myModal').modal('hide');
            });

            price_slider.slider("option", "step", 50000);
            $(document).on('change', '[name=purpose]', function (e) {
                let _purpose = $(this).val();
                purpose = _purpose;
                if (purpose == 'Rent') {
                    $('#drop-price [data-purpose=Rent]').show(0);
                    $('#drop-price [data-purpose=Sale]').hide(0);
                    price_slider.slider("option", "step", 5000);
                } else {
                    $('#drop-price [data-purpose=Rent]').hide(0);
                    $('#drop-price [data-purpose=Sale]').show(0);
                    price_slider.slider("option", "step", 50000);
                }

                e.preventDefault();
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: '<?php echo site_url('property/ajax/min_max_price');?>',
                    data: {purpose: _purpose},
                }).done(function (json) {
                    console.log(json);
                    min_price = //json.min;
                        max_price = json.max;

                    json.min = parseFloat(0);
                    json.max = parseFloat(json.max);


                    $("[name=price\\[min\\]]").val('');
                    $("[name=price\\[max\\]]").val('');

                    $('.price-row .my-sliderbar-filter').attr({
                        'data-min-default': json.min,
                        'data-max-default': json.max,
                        'data-min': json.min,
                        'data-max': json.max
                    });

                    price_slider.slider("option", "min", json.min);
                    price_slider.slider("option", "max", json.max);
                    price_slider.slider("option", "values", [json.min, json.max]);

                })
                    .fail(function () {

                    });
            });


            $(document).on('click', '.search-properties-form', function (e) {
                //e.preventDefault();
                if ($('.advanced-search').css('display') == 'none')
                    $('.advanced-search').slideDown();

            });


        });

        $('[name=type_id]').on('select2:open', function (e) {
            $('.select2-container--open').find('.select2-search').remove();
        });


        $('[name=purpose]').on('select2:open', function (e) {
            $('.select2-container--open').find('.select2-search').remove();
        });


        $("#_area_unit").select2({
            dropdownParent: $("#myModal")
        })


    })


</script>


