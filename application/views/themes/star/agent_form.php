<?php
$city_id = intval(getVar('city_id'));
$area_ids = getVar('area_ids');
?>

<div class="ere-search-properties clearfix style-mini-line color-dark ">
    <form method="get" action="<?php echo site_url('agents'); ?>">
        <div class="form-search-wrap">
            <div class="form-search-inner top_css">
                <div class="ere-search-content">
                    <div data-href="<?php echo site_url('properties'); ?>" class="-search-properties-form">
                        <div class="form-search">
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 form-group">
                                    <select class="ere-property-city-ajax search-field form-control select2" name="city_id" id="search_city_id">
                                        <?php echo selectBox("SELECT id, city FROM cities WHERE status='Active'", $city_id); ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group area-form-input">
                                    <select class="search-field form-control select2-tags-area" id="search_area_id" name="area_ids[]" multiple style="width: 100%">
                                        <?php
                                        if (count($area_ids) > 0 && is_array($area_ids))
                                            echo selectBox("SELECT id, area FROM area WHERE status='Active' AND city_id='{$city_id}' AND id IN(" . join(',', array_map("intval", $area_ids)) . ")", ($area_ids)); ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 form-group submit-search-form pull-right">
                                    <div class="advanced-wrap clearfix">
                                        <div class="enable-other-advanced">
                                            <a href="javascript:void(0)" class="btn-other-advanced"><i class="fa fa-gear"></i></a>
                                        </div>
                                    </div>
                                    <button type="submit" class="ere-advanced-search-btn"><i class="fa fa-search"></i> Search </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


