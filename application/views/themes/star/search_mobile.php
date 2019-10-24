<style>
    .col-sm-2, .col-sm-3 {
        padding-left: 5px;
        padding-right: 5px;
    }


    .pd-top-100 {
        padding-top: 40px !important;
    }

    .area_unit-c .dropdown.show {
        display: inline-block !important;
    }
</style>
<?php
$purpose = (getVar('purpose'));
$purpose = (!empty($purpose) ? $purpose : 'Sale');
$city_id = intval(getVar('city_id'));
$area_ids = getVar('area_ids');
$area_unit = getVar('area_unit');
if (empty($_COOKIE['area_unit'])) {
    $_COOKIE['area_unit'] = 'Square Feet';
}
if (empty($area_unit)) {
    //$area_unit = $this->input->cookies('area_unit');
    $area_unit = $_COOKIE['area_unit'];
}
$type_id = intval(getVar('type_id'));
$price = getVar('price');
$area = getVar('area');
$bedrooms = getVar('bedrooms');
$bathrooms = getVar('bathrooms');

if (!($_COOKIE['_price'])) {
    $_COOKIE['_price'] = $this->db->query("SELECT MIN(price) AS `min` ,  MAX(price) AS `max` FROM `properties` WHERE `purpose`='{$purpose}'")->row_array();
}
if (!($_COOKIE['_area'])) {
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
                    <div data-href="<?php echo site_url('properties'); ?>"
                         class="-search-properties-form search-form-mobile">

                        <div class="mb-lgoo">
                            <a href="JavaScript:Void(0);" class="toggle-icon close-btn"><i class="fa fa-close"></i></a>
                            <a href="https://starjaidad.com/">
                                <img class="mbl-logo" style="text-align:center;" src="https://starjaidad.com/assets/cache/images/e/9/6/7/f/e967f674023dd38eaab055474c95647e6b315040-starjaidad3.png"/>
                            </a>
                        </div>
                        <div class="form-search">

                            <div class="col-xs-12 form-grp src-frm pop-dismiss">
                                <label class="search_label">Purpose</label>
                                <select class="search-field form-control select2" name="purpose" id="purpose_property">
                                    <?php
                                    $_purpose = get_enum_values('properties', 'purpose');
                                    $_purpose['Sale'] = 'Buy';
                                    echo selectBox($_purpose, $purpose); ?>
                                </select>
                            </div>
                            <div class="col-xs-12 form-grp src-frm pop-dismiss">
                                <label class="search_label">City</label>
                                <select class="ere-property-city-ajax search-field form-control select2" name="city_id"
                                        id="search_city_id2">
                                    <?php echo selectBox("SELECT id, city FROM cities WHERE status='Active'", $city_id); ?>
                                </select>
                                <br>
                            </div>
                            <div class="col-xs-12 form-grp area-form-input src-frm pop-dismiss">
                                <label class="search_label">Location</label>
                                <select class="search-field form-control select2-tags-area search_area_id" id="m_search_area_id" name="area_ids[]" multiple style="width: 100%">
                                    <?php
                                    if (count($area_ids) > 0 && is_array($area_ids))
                                        echo selectBox("SELECT id, area FROM area WHERE status='Active' AND city_id='{$city_id}' AND id IN(" . join(',', array_map("intval", $area_ids)) . ")", ($area_ids)); ?>
                                </select>
                            </div>
                            <div class=" col-xs-12 form-grp src-frm pop-dismiss">
                                <label class="search_label">Property Type</label>
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
                                    $this->multilevels->query = "SELECT * FROM `property_types` WHERE status='Active' ORDER BY ordering ASC";
                                    echo $multiLevelComponents = $this->multilevels->build();
                                    ?>
                                </select>
                            </div>
                            <div class="col-xs-12 form-grp src-frm" style="position: static;">
                                <label class="search_label">Price</label>
                                <?php $price = getVar('price');
                                $_price = [];
                                $_price['min'] = (!empty($price['min']) ? $price['min'] : $_COOKIE['_price']['min']);
                                $_price['max'] = (!empty($price['max']) ? $price['max'] : $_COOKIE['_price']['max']);
                                ?>

                                <div class=" no-padding no-border no-margin price-row slider-parent">
                                    <div class="col-sm-10 no-padding">
                                        <div class="price-popover">
                                            <div class="col-xs-6 col-sm-6 col-no-padding">
                                                <input type="number" name="price[min]" min="0"
                                                       value="<?php echo($_price['min'] == $_COOKIE['_price']['min'] ? '' : $_price['min']); ?>"
                                                       class="min-input-request form-control search-field"
                                                       placeholder="Price Min" autocomplete="off">
                                                <span class="fa fa-angle-down drop-angle"></span>
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-no-padding">
                                                <input type="number" name="price[max]" min="0"
                                                       value="<?php echo($_price['max'] == $_COOKIE['_price']['max'] ? '' : $_price['max']); ?>"
                                                       class="max-input-request form-control search-field text-right"
                                                       placeholder="Price Max" autocomplete="off">
                                                <span class="fa fa-angle-down drop-angle"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 slider-div">
                                            <div class="ere-sliderbar-price-wrap">
                                                <div class="ere-sliderbar-price my-sliderbar-filter"
                                                     data-min-default="<?php echo $_COOKIE['_price']['min']; ?>"
                                                     data-max-default="<?php echo $_COOKIE['_price']['max']; ?>"
                                                     data-min="<?php echo $_price['min']; ?>"
                                                     data-max="<?php echo $_price['max']; ?>">
                                                    <div class="sidebar-filter ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2 no-padding text-center pop-dismiss">
                                        <a href="javascript: void(0);"><b>Price in<span
                                                        class="slider-unit">PKR</span></b></a>
                                    </div>
                                </div>

                                <div style="position: absolute;" class="dropdown selection-box" data-in=".price-row"
                                     id="drop-price">
                                    <ul class="dropdown-menu -show" aria-labelledby="dLabel">
                                        <li>
                                            <?php
                                            $sale_price = json_decode(get_option('sale_price'));
                                            $rent_price = json_decode(get_option('rent_price'));
                                            ?>
                                            <div class="row">
                                                <div class="col-xs-6" data-input="min">
                                                    <div id="price_top"></div>
                                                    <a href="#" aria-label="" data-int="0" data-purpose="Sale"
                                                       class="btn btn-sm btn-block btn-default sale-price-btn btn-set-value">Min</a>
                                                    <a href="#" aria-label="" data-int="0" data-purpose="Rent"
                                                       class="btn btn-sm btn-block btn-default rent-price-btn btn-set-value">Min</a>
                                                    <?php
                                                    foreach ($sale_price as $i => $item) {
                                                        if (!empty($item) && ($i + 1) < count($sale_price)) {
                                                            ?><a href="#" aria-label="<?php echo $item; ?>"
                                                                 data-int="<?php echo number_to_int($item); ?>"
                                                                 data-purpose="Sale"
                                                                 class="btn btn-sm btn-block btn-gray sale-price-btn btn-set-value"><?php echo $item; ?></a><?php
                                                        }
                                                    }
                                                    foreach ($rent_price as $i => $item) {
                                                        if (!empty($item) && ($i + 1) < count($rent_price)) {
                                                            ?><a href="#" aria-label="<?php echo $item; ?>"
                                                                 data-int="<?php echo number_to_int($item); ?>"
                                                                 data-purpose="Rent"
                                                                 class="btn btn-sm btn-block btn-gray rent-price-btn btn-set-value"><?php echo $item; ?></a><?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-xs-6" data-input="max">
                                                    <a href="#" aria-label="" data-int="99999999999999999999999999"
                                                       data-purpose="Sale"
                                                       class="btn btn-sm btn-block btn-default sale-price-btn btn-set-value">Max</a>
                                                    <a href="#" aria-label="" data-int="99999999999999999999999999"
                                                       data-purpose="Rent"
                                                       class="btn btn-sm btn-block btn-default rent-price-btn btn-set-value">Max</a>

                                                    <?php
                                                    foreach ($sale_price as $i => $item) {
                                                        if (!empty($item) && $i > -1) {
                                                            ?><a href="#" aria-label="<?php echo $item; ?>"
                                                                 data-int="<?php echo number_to_int($item); ?>"
                                                                 data-purpose="Sale"
                                                                 class="btn btn-sm btn-block btn-gray sale-price-btn btn-set-value"><?php echo $item; ?></a><?php
                                                        }
                                                    }
                                                    foreach ($rent_price as $i => $item) {
                                                        if (!empty($item) && $i > -1) {
                                                            ?><a href="#" aria-label="<?php echo $item; ?>"
                                                                 data-int="<?php echo number_to_int($item); ?>"
                                                                 data-purpose="Rent"
                                                                 class="btn btn-sm btn-block btn-gray rent-price-btn btn-set-value"><?php echo $item; ?></a><?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                </div>

                            </div>
                            <div class=" col-xs-12 form-grp src-frm -pop-dismiss" style="border-radius: 0; position: static;">
                                <?php $area_units = get_enum_values('properties', 'area_unit');
                                if (empty($area_unit)) {
                                    $unit_keys = array_keys($area_units);
                                    $area_unit = $unit_keys[0];
                                }
                                ?>
                                <script>
                                    $(document).ready(function () {
                                        $(document).on('click', '.area_unit-menu li', function (e) {
                                            e.preventDefault();
                                            let area_unit = $(this).find('a').text();
                                            $('#area_unit').val(area_unit);
                                            $('.area_unit-show').html(area_unit);
                                            $.cookie('area_unit', area_unit);
                                        });
                                    });
                                </script>
                                <input type="hidden" name="area_unit" id="area_unit" value="<?php echo $area_unit; ?>">

                                <?php
                                $_area = [];
                                $_area['min'] = (!empty($area['min']) ? $area['min'] : $_COOKIE['_area']['min']);
                                $_area['max'] = (!empty($area['max']) ? $area['max'] : $_COOKIE['_area']['max']);
                                ?>
                                <div class="row no-padding no-border no-margin area-row slider-parent"
                                     style="border-radius: 0;">
									<label class="search_label">Area</label>
                                    <div class="col-sm-10 no-padding">
                                        <div class="area-popover">
                                            <div class="col-sm-6 col-no-padding">
                                                <input type="number" name="area[min]" min="0"
                                                       value="<?php echo($_area['min'] == $_COOKIE['_area']['min'] ? '' : $_area['min']); ?>"
                                                       class="min-input-request form-control search-field"
                                                       placeholder="Area Min" autocomplete="off">
                                                <span class="fa fa-angle-down drop-angle"></span>
                                            </div>
                                            <div class="col-sm-6 col-no-padding">
                                                <input type="number" name="area[max]" min="0"
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

                                    <div class="col-xs-12 col-no-padding text-center open_unit_popup pop-dismiss">
                                        <a href="#" class="open_unit_popup" data-toggle="modal" data-target="#myModal"><b>Change Area <b class="unit_popup"><?php echo short_area_unit($area_unit); ?></b></b></a>
                                    </div>
                                </div>


                                <div style="position: absolute;: ab" class="dropdown selection-box" data-in=".area-row"
                                     id="drop-area">
                                    <ul class="dropdown-menu -show" aria-labelledby="dLabel">
                                        <li>
                                            <a href="javascript: void(0);"
                                               class="btn btn-block btn-gray open_unit_popup">Change Area Unit</a>
                                            <div id="area_top"></div>
                                            <?php
                                            $area_units = get_enum_values('properties', 'area_unit');
                                            foreach ($area_units as $area_unit) {
                                                $short_name_unit = url_title($area_unit, '_');
                                                $unit_breakup = json_decode(get_option($short_name_unit . '_unit'));
                                                ?>
                                                <div class="row <?php echo $short_name_unit; ?> unit-div"
                                                     style="display: <?php echo($_COOKIE['area_unit'] == $area_unit ? '' : 'none') ?>;">
                                                    <div class="col-xs-6" data-input="min">
                                                        <a href="#area_top" aria-label="" data-int="0" data-purpose
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
                                                    <div class="col-xs-6" data-input="max">
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

                            <div class="col-xs-12 form-grp src-frm pop-dismiss">
                                </hr>
                                <label class="search_label">Room(s)</label>
                                <select class="search-field form-control select2" name="bedrooms" style="margin-left: 1px;">
                                    <option value="">Room(s)</option>
                                    <?php
                                    foreach (range(1, 10) as $item) {
                                        echo '<option ' . _selectbox($bedrooms, $item) . ' value="' . $item . '">' . ($item == 10 ? "10+" : $item) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xs-12 form-grp src-frm pop-dismiss submit-search-form">

                                <div class="advanced-wrap clearfix">
                                    <div class="enable-other-advanced">
                                        <a href="javascript:void(0)" class="btn-other-advanced"><i class="fa fa-gear"></i></a>
                                    </div>
                                </div>
                                <button type="submit" class="ere-advanced-search-btn"><i class="fa fa-search"></i>
                                    Search
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


</div>

<?php if($thisFile=='search_mobile'){?>
<style>

    [class^='select2'] {
        border-radius: 16px !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background: #92C800;
        color:white

    }


</style>
<?php } ?>

<script>
    $(function () {
        $(document).ready(function () {

            $("#mbl-srch").click(function () {
                $(".onmobile").show(0);
                $(".header-mobile, .hide-mini-search ,.main-footer-wrapper").hide(0);
            });

            $(".close-btn").click(function () {
                $(".onmobile").hide(0);
                $(".header-mobile, .hide-mini-search ,.main-footer-wrapper").show(0);
            });

            $('[name=purpose]').on('select2:open', function (e) {
                $('.select2-container--open').find('.select2-search').remove();
            });

        });
    });
</script>


