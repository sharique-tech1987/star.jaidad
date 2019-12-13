<?php get_header(get_option('header')); ?>



<?php $page->title = $row->title; ?>
<div id="wrapper-content" class="clearfix ">
    <section class="page-title page-title-large property-single-page-title page-title-background" style="padding-top:70px;padding-bottom:70px">
        <div class="page-title-background" style="background-image: url(<?php echo media_url('images/properties-2-1920x204.jpg'); ?>)"></div>
        <div class="container">
            <div class="page-title-inner">
                <div class="property-info-header property-info-action">
                    <div class="property-main-info">
                        <div class="property-location" title="">
                            <i class="fa fa-map-marker accent-color"></i>
                            <a target="_blank" href="https://maps.google.com/?q=<?php echo urlencode($row->full_address);?>">
                                <span><?php echo $row->full_address;?></span></a>
                        </div>
                        <div class="property-heading">
                            <h4><?php echo $row->title;?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="primary-content" class="pd-top-50 pd-bottom-50 sm-pd-top-50 sm-pd-bottom-50">
            <div class="container clearfix">

                <div class="prostyl">
                <div class="row">
                    <div class="col-xs-3 col-md-8">
                        <div class="pull-left">
                            <h3>
                                <img class="pull-left" src="<?php echo _img(asset_url("front/projects/{$row->logo}"), 0, 100); ?>" alt="<?php echo $row->title; ?>">
                                <div class="protile mobile_none"><?php echo $row->title; ?></div>
                            </h3>
                        </div>
                    </div>
                    <div class="col-xs-9 col-md-4">
                        <div class="pull-right">
                            <div class="title pull-right">PRICE</div>
                            <div class="clearfix"></div>
                            <div class="price">
                                <?php echo short_number($row->price_from) . ' - ' . short_number($row->price_to); ?></div>
                        </div>
                    </div>
                    </div>
                </div>


                <br><br>
                <div class="row">
                    <div class="col-md-8 single-property-inner">
                        <div id="container">
                            <div id="content" role="main">
                                <div id="property-768" class="ere-property-wrap single-property-area content-single-property post-768 property type-property status-publish has-post-thumbnail hentry property-type-apartment property-type-bar property-type-cafe property-status-for-sale property-feature-air-conditioning property-feature-electric-range property-feature-fire-alarm property-feature-tv-cable property-feature-wifi property-state-illinois property-city-chicago property-neighborhood-austin">
                                    <div class="single-property-element property-info-header property-info-action mg-bottom-50 sm-mg-bottom-30">
                                        <div class="property-main-info">
                                            <div class="property-status">
                                                <span>For <?php echo strtoupper($row->purpose);?></span>
                                            </div>
                                            <div class="property-location" title="">
                                                <i class="fa fa-map-marker accent-color"></i>
                                                <a target="_blank" href="https://maps.google.com/?q=6035%20W%20North%20Ave,%20Chicago,%20IL,%20United%20States">
                                                    <span><?php echo $row->full_address;?></span>
                                                </a>
                                            </div>
                                            <div class="property-heading">
                                                <h4><?php echo $row->title;?></h4>
                                            </div>
                                        </div>
                                        <div class="property-bottom-info">
                                            <div class="property-info">
                                                <div class="property-id">
                                                    <span class="fa fa-barcode accent-color"></span>
                                                    <div class="content-property-info">
                                                        <p class="property-info-value"><?php echo $row->id;?></p>
                                                        <p class="property-info-title">Property ID</p>
                                                    </div>
                                                </div>
                                                <div class="property-area">
                                                    <span class="fa fa-arrows accent-color"></span>
                                                    <div class="content-property-info">
                                                        <p class="property-info-value"><?php echo number_format($row->area);?> <?php echo short_area_unit($row->area_unit);?>
                                                        </p>
                                                        <p class="property-info-title">Size</p>
                                                    </div>
                                                </div>
                                                <div class="property-bedrooms">
                                                    <span class="fa fa-hotel accent-color"></span>
                                                    <div class="content-property-info">
                                                        <p class="property-info-value"><?php echo $row->bedrooms;?></p>
                                                        <p class="property-info-title"> Bedrooms</p>
                                                    </div>
                                                </div>
                                                <div class="property-bathrooms">
                                                    <span class="fa fa-bath accent-color"></span>
                                                    <div class="content-property-info">
                                                        <p class="property-info-value"><?php echo $row->bathrooms;?></p>
                                                        <p class="property-info-title">Bathroom</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="property-price-action">
                                                <span class="property-price">
                                                <span class="property-price-prefix">Price </span> <?php echo short_number($row->price);?> </span>
                                                <div class="property-action">
                                                    <div class="property-action-inner clearfix">
                                                        &nbsp;
                                                        <!--<a href="" class="property-favorite" data-toggle="tooltip" title=""></i></a>
                                                        <a href="" class="compare-property" data-toggle="tooltip" title=""><i class="fa fa-plus"></i></a>
                                                        <a href="javascript:void(0)" id="property-print" data-toggle="tooltip"></i></a>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    if (count($images) > 0) { ?>
                                        <div class="single-property-element property-gallery-wrap">
                                            <div class="ere-property-element">

                                                <div class="single-property-image-main owl-carousel manual ere-carousel-manual">
                                                    <?php
                                                    foreach ($images as $image) {
                                                        $image = checkAltImg("assets/front/projects/{$image->filename}");
                                                        if(!empty(get_option('wm_logo'))) {
                                                            $wm_img = ADMIN_ASSETS_DIR . 'img/' . get_option('wm_logo');
                                                            $full_img_url = base_url(_Image::wm($image, null, null, $wm_img));
                                                            $img_url = base_url(_Image::wm($image, 770, 470, $wm_img));
                                                        } else {
                                                            $full_img_url = base_url($image);
                                                            $img_url = base_url(_Image::open($image)->resize(770, 470));
                                                        }
                                                        ?>
                                                        <div class="property-gallery-item ere-light-gallery">
                                                            <img src="<?php echo ($img_url); ?>" alt="<?php echo $image->title; ?>">
                                                            <a data-thumb-src="<?php echo ($img_url); ?>" data-gallery-id="ere_gallery-506773365" data-rel="ere_light_gallery" href="<?php echo ($full_img_url); ?>" class="zoomGallery"><i class="fa fa-expand"></i></a>
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                                <div class="single-property-image-thumb owl-carousel manual ere-carousel-manual">
                                                    <?php foreach ($images as $image) {
                                                        $image = checkAltImg("assets/front/projects/{$image->filename}");
                                                        if(!empty(get_option('wm_logo'))) {
                                                            $wm_img = ADMIN_ASSETS_DIR . 'img/' . get_option('wm_logo');
                                                            $img_url = base_url(_Image::wm($image, 170, 120, $wm_img));
                                                        } else {
                                                            $img_url = base_url(_Image::open($image)->resize(170, 120));
                                                        }
                                                        ?>
                                                        <div class="property-gallery-item">
                                                            <img src="<?php echo ($img_url); ?>" alt="<?php echo $image->title; ?>">
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="single-property-element property-location">
                                        <div class="ere-heading-style2">
                                            <h2>Essential Information</h2>
                                        </div>
                                        <div class="ere-property-element">
                                            <div id="ere-overview" class="tab-pane fade in active">
                                                <div class="row">
                                                    <div class="col-md-4 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> Price: <?php echo short_number($row->price_from) . ' - ' . short_number($row->price_to);?></div>
                                                    <div class="col-md-4 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> Country: <?php echo $row->country;?></div>
                                                    <div class="col-md-4 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> City: <?php echo $row->city;?></div>
                                                    <div class="col-md-4 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> Location: <?php echo $row->area;?></div>
                                                    <!--<div class="col-md-4 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> Types: <?php /*echo $row->types;*/?></div>-->
                                                    <div class="col-md-4 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> Developer: <?php echo $row->developer = 'Orbit Housing';?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if(!empty(strip_tags($row->description))) { ?>
                                        <div class="single-property-element property-description">
                                            <div class="ere-heading-style2">
                                                <h2>Description</h2>
                                            </div>
                                            <div class="ere-property-element">
                                                <p><?php echo $row->description;?></p>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php
                                    if (count($amenities) > 0) { ?>
                                    <div class="single-property-element property-location">
                                        <div class="ere-heading-style2">
                                            <h2>Project Amenities</h2>
                                        </div>
                                        <div class="ere-property-element">
                                            <div class="property-address">
                                                <?php
                                                ob_start();
                                                include "include/amenities.php";

                                                $amenities_html = ob_get_clean();
                                                if (count($_amenities) > 0) {
                                                    ?>
                                                    <!-- Property Features -->
                                                    <div class="property-features">
                                                        <ul class="list-style-one">
                                                            <?php echo $amenities_html; ?>
                                                        </ul>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div class="single-property-element property-location">
                                        <div class="ere-heading-style2">
                                            <h2>Location & Map</h2>
                                            <div class="ere-property-element">
                                                <?php
                                                $latLng = getLatLng($row->full_address. ' Pakistan');
                                                ?>
                                                <div class="map-canvas"
                                                     data-zoom="12"
                                                     data-lat="<?php echo $latLng->lat; ?>"
                                                     data-lng="<?php echo $latLng->lng; ?>"
                                                     data-type="roadmap"
                                                     data-hue="#ffc400"
                                                     data-title=""
                                                     data-icon-path="<?php echo media_url('images/icons/map-marker.png'); ?>"
                                                     data-content="<img src='<?php echo base_url(_Image::open("assets/front/properties/{$images[0]->filename}")->zoomCrop(270, 170)); ?>'><br>
                                                                                                        <?php echo $row->full_address; ?><br><?php echo short_number($row->price); ?>">
                                                </div>
                                            </div>

                                            <?php
                                            $project_map_files = json_decode($row->project_map);
                                            if (count($project_map_files) > 0) {
                                                echo '<div class="row">';
                                                foreach ($project_map_files as $k => $file) {
                                                    $file_dir = asset_dir("front/projects/{$file}");
                                                    $thumb_file = _img(file_icon($file_dir, true), 400, 400);
                                                    ?>
                                                    <div class="col-lg-3 img-row">
                                                        <a href="<?php echo base_url($file_dir); ?>"
                                                                title="<?php echo $file; ?>" class="lightbox-image"
                                                                rel="project_map">
                                                            <img src="<?php echo $thumb_file; ?>"
                                                                    alt=" <?php echo $file; ?>" class="img-responsive">
                                                        </a>
                                                    </div>
                                                    <?php
                                                }
                                                echo '</div>';
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <?php if(count($floor_plans_files) && is_array($floor_plans_files)) { ?>
                                    <div class="single-property-element property-location">
                                        <div class="ere-heading-style2">
                                            <h2>Floor Plan</h2>
                                            <?php
                                            foreach ($floor_plans_files as $k => $file) {
                                                $file_dir = asset_dir("front/projects/{$file}");
                                                $thumb_file = _img(file_icon($file_dir, true), 400, 400);
                                                ?>
                                                <div class="col-lg-3 img-row">
                                                    <a href="<?php echo base_url($file_dir); ?>" title="<?php echo $file; ?>" class="lightbox-image" rel="floor_plans">
                                                        <img src="<?php echo $thumb_file; ?>" alt=" <?php echo $file; ?>" class="img-responsive">
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div class="single-property-element property-location">
                                        <div class="ere-heading-style2">
                                            <h2>Social Sharing</h2>
                                            <br>
                                            <div class="sharethis-inline-share-buttons"></div>
                                            <br>
                                        </div>
                                    </div>

                                    <?php if(count($project_properties) && is_array($project_properties)) { ?>
                                    <div class="single-property-element property-location">
                                        <div class="ere-heading-style2">
                                            <h2>Project Properties</h2>
                                            <?php
                                                $_project_properties = [];
                                                foreach ($project_properties as $k => $property) {
                                                    $_project_properties[$property->type][] = $property;
                                                }
                                                ?>
                                                <div class="nearest-places">
                                                    <?php
                                                    foreach ($_project_properties as $property_type => $_properties) {
                                                        ?>
                                                        <div class="nearest-places">
                                                            <h5><?php echo $property_type; ?></h5>
                                                            <div class="outer-box clearfix">
                                                                <?php
                                                                foreach ($_properties as $k => $property) {
                                                                    $file_dir = asset_dir("front/projects/{$property->payment_plan}");
                                                                    $thumb_file = _img(file_icon($file_dir, true), 400, 400);

                                                                    ?>
                                                                    <div class="project-properties-list">
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <h6><?php echo $property->title; ?></h6>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-4 img-row">
                                                                                <i class="icon-assembly-area"></i>
                                                                                <i class="flaticon-dimension"></i>
                                                                                <?php
                                                                                echo $property->area . ' ' . short_area_unit($property->area_unit);
                                                                                //$_area_unit = area_conversion(floatval($property->area), $property->area_unit, $_COOKIE['area_unit']);
                                                                                //echo number_format($_area_unit, (end(explode('.', number_format($_area_unit, 2))) > 0 ? 2 : 0)) . ' ' . short_area_unit($_COOKIE['area_unit']);?>
                                                                            </div>
                                                                            <div class="col-lg-2 img-row">
                                                                                <i class="icon-coin-dollar"></i>
                                                                                <?php if (!empty($property->payment_plan)) { ?>
                                                                                <a href="<?php echo base_url($file_dir); ?>"
                                                                                        title="<?php echo $file; ?>"
                                                                                        class="lightbox-image"
                                                                                        rel="payment_plans"> <?php } ?>
                                                                                    <i class="flaticon-money"></i> <?php echo short_number($property->price); ?>
                                                                                    <?php if (!empty($property->payment_plan)) { ?>
                                                                                </a><?php } ?>
                                                                            </div>

                                                                            <div class="col-lg-2">
                                                                                <?php if($property->bedrooms > 0) { ?>
                                                                                <i class="icon-bed-1"></i> Beds: <?php echo $property->bedrooms; ?>
                                                                                <?php } ?>
                                                                            </div>

                                                                            <div class="col-lg-2">
                                                                                <?php if($property->bathrooms > 0) { ?>
                                                                                <i class="icon-bathtub-1"></i> Baths:<?php echo $property->bathrooms; ?>
                                                                                <?php } ?>
                                                                            </div>

                                                                            <div class="col-lg-2">
                                                                                <a data-toggle="modal" style="cursor: pointer;" data-target="#payment_schedule_modal" data-href="<?php echo site_url("project/ajax/payment_schedule/{$property->id}"); ?>" class="theme-btn btn-style-one">Book Now</a>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                        </div>
                                    </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- sidebar -->
                    <div class="primary-sidebar sidebar col-md-4 sidebar-mobile-canvas -gf-sticky">
                        <!--<aside id="ere_widget_search_form-2" class="widget ere_widget ere_widget_search_form">
                            <h4 class="widget-title"><span>About Agent</span></h4>
                            <div class="ere-property-advanced-search clearfix dropdown color-dark ">
                                <div class="form-search-wrap">
                                    <div class="form-search-inner">
                                        <div class="ere-search-content">
                                            <div class="agent-form">
                                                <?php /*include "include/agent_box.php";*/?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </aside>-->

                        <aside id="ere_widget_search_form-2" class="widget ere_widget ere_widget_search_form">
                            <h4 class="widget-title"><span>Contact</span></h4>
                            <div class="ere-property-advanced-search clearfix dropdown color-dark ">
                                <div class="form-search-wrap">
                                    <div class="form-search-inner">
                                        <div class="ere-search-content">
                                            <div class="agent-form">
                                                <?php include "contact_agent_form.php"; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
</div>


<?php get_footer(); ?>
<script src="<?php echo media_url('plugins/ere-single-property.min7d4c.js'); ?>"></script>
<!--Google Map APi Key-->
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo get_option('gmap_key');?>"></script>
<script src="<?php echo media_url('js/map-script.js'); ?>"></script>

<!--End Google Map APi-->

<div class="modal modal-payment_schedule_modal fade" id="payment_schedule_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>


<script>
    $(function () {
        $(document).ready(function () {
            $('#payment_schedule_modal').on('shown.bs.modal', function (event) {
                //event.preventDefault();
                var modal = $(this);
                var button = $(event.relatedTarget); // Button that triggered the modal
                var url = button.data('href');
                modal.find('.modal-content').html('Loading...');
                //modal.find('.modal-body').html('');

                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: url,
                    complete: function (data) {
                        var json = $.parseJSON(data.responseText);
                        //console.log(json);

                        modal.find('.modal-title').html(json.row.title);
                        //modal.find('.modal-body').html(json.html);
                        modal.find('.modal-content').html(json.html);
                    }
                });
            })
        });
    });
</script>
