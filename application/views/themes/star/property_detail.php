<?php get_header(get_option('header')); ?>
<?php
if(empty($_COOKIE['area_unit'])){
    //$_COOKIE['area_unit'] = 'Marla';
    $_COOKIE['area_unit'] = $row->area_unit;
}
?>

<div id="wrapper-content" class="clearfix ">
    <section class="page-title page-title-large property-single-page-title page-title-background" style="padding-top:70px;padding-bottom:70px">
        <div class="page-title-background" style="background-image: url(<?php echo media_url('images/properties-2-1920x204.jpg'); ?>)"></div>
        <div class="container">
            <div class="page-title-inner">
                <div class="property-info-header property-info-action">
                    <div class="property-main-info">
                        <div class="property-status">
                            <span style="background-color: ">For <?php echo strtoupper($row->purpose);?></span>
                        </div>
                        <div class="property-location" title="">
                            <i class="fa fa-map-marker accent-color"></i>
                            <a target="_blank" href="https://maps.google.com/?q=<?php echo urlencode($row->full_address);?>">
                                <span><?php echo $row->full_address;?></span></a>
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
                                    <p class="property-info-value">
                                        <?php
                                        $_area_unit = area_conversion(floatval($row->area), $row->area_unit, $_COOKIE['area_unit']);
                                        echo number_format($_area_unit, (end(explode('.', number_format($_area_unit, 2))) > 0 ? 2 : 0));?> <?php echo short_area_unit($_COOKIE['area_unit']);?>
                                    </p>
                                    <p class="property-info-title">Size</p>
                                </div>
                            </div>

                            <?php if($row->bedrooms > 0) { ?>
                            <div class="property-bedrooms">
                                <span class="fa fa-hotel accent-color"></span>
                                <div class="content-property-info">
                                    <p class="property-info-value"><?php echo number_format($row->bedrooms);?></p>
                                    <p class="property-info-title">Bedrooms</p>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($row->bathrooms > 0) { ?>
                            <div class="property-bathrooms">
                                <span class="fa fa-bath accent-color"></span>
                                <div class="content-property-info">
                                    <p class="property-info-value"><?php echo number_format($row->bathrooms);?></p>
                                    <p class="property-info-title">Bathrooms</p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="property-price-action">
                            <span class="property-price">
                            <span class="property-price-prefix">Price </span> <?php echo short_number($row->price);?> </span>
                            <div class="property-action">
                                <div class="property-action-inner clearfix">
                                    &nbsp;
                                    <!--<a href="<?php /*echo site_url("member/wishlist/add/{$row->id}");*/?>" class="property-favorite" data-toggle="tooltip" title=""></i></a>
                                    <a class="compare-property" href="<?php /*echo site_url("property/{$row->id}");*/?>" data-toggle="tooltip" title=""></i></a>
                                    <a href="javascript:void(0)" id="property-print" data-toggle="tooltip" data-original-title=""></i></a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="primary-content" class="pd-top-100 pd-bottom-100 sm-pd-top-50 sm-pd-bottom-0">
            <div class="container clearfix">
                <div class="row">
                    <div class="col-md-9 single-property-inner">
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
                                                <a target="_blank" href="https://maps.google.com/?q=<?php echo urlencode($row->full_address);?>">
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
                                                        <p class="property-info-value"><?php echo number_format($row->area);?> <?php echo $row->area_unit;?>
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

                                                $image = checkAltImg("assets/front/properties/{$image->filename}");
                                                if(!empty(get_option('wm_logo'))) {
                                                    $wm_img = ADMIN_ASSETS_DIR . 'img/' . get_option('wm_logo');
                                                    $full_img_url = base_url(_Image::wm($image, null, null, $wm_img));

                                                    $img_url = base_url(_Image::wm($image, 770, 470, $wm_img));
                                                } else {
                                                    $full_img_url = $image;
                                                    $img_url = base_url(_Image::open($image)->resize(770, 470));
                                                }

                                            ?>
                                            <div class="property-gallery-item ere-light-gallery">
                                                <img src="<?php echo ($img_url); ?>" alt="<?php echo $image->title; ?>">
                                                <a data-thumb-src="<?php echo ($img_url); ?>" data-rel="ere_light_gallery" href="<?php echo ($full_img_url); ?>" data-gallery-id="ere_gallery-506773365" class="zoomGallery"><i class="fa fa-expand"></i></a>
                                            </div>
                                            <?php } ?>
                                            </div>

                                            <div class="single-property-image-thumb owl-carousel manual ere-carousel-manual">
                                            <?php foreach ($images as $image) {
                                                $image = checkAltImg("assets/front/properties/{$image->filename}");
                                                if(!empty(get_option('wm_logo'))) {
                                                    $wm_img = ADMIN_ASSETS_DIR . 'img/' . get_option('wm_logo');
                                                    $img_url = base_url(_Image::wm($image, 170, 120, $wm_img));
                                                } else {
                                                    $img_url = base_url(_Image::open($image)->zoomCrop(170, 120));
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

                                    <div class="single-property-element property-info-tabs property-tab">
                                        <div class="ere-property-element">
                                            <ul id="ere-features-tabs" class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#ere-overview">Essential Information</a></li>
                                                <?php
                                                $row->videos = json_decode($row->videos);
                                                if(!empty($row->videos[0])){
                                                ?>
                                                <li><a data-toggle="tab" href="#ere-features">Video</a></li>
                                                <?php } ?>
                                                <!--<li><a data-toggle="tab" href="#ere-video">Virtual Tour</a></li>-->
                                            </ul>

                                            <div class="tab-content">
                                                <div id="ere-overview" class="tab-pane fade in active">
                                                    <div class="row">
                                                        <div class="col-md-3 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> Price: <?php echo short_number($row->price);?></div>
                                                        <div class="col-md-3 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> For: <?php echo strtoupper($row->purpose);?></div>
                                                        <div class="col-md-3 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> Property Type: <?php echo $row->type;?></div>
                                                        <div class="col-md-3 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> Area: <?php echo number_format($row->area);?> <?php echo $row->area_unit;?></div>
                                                        <!--<div class="col-md-3 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> Country: <?php /*echo $row->country;*/?></div>-->
                                                        <div class="col-md-3 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> City: <?php echo $row->city;?></div>
                                                        <?php if($row->bedrooms > 0) { ?>
                                                        <div class="col-md-3 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> Bedrooms: <?php echo number_format($row->bedrooms);?></div>
                                                        <?php } if($row->bathrooms > 0) { ?>
                                                        <div class="col-md-3 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> Bathrooms: <?php echo number_format($row->bathrooms);?></div>
                                                        <?php } if($amenities['kitchens']->value > 0) { ?>
                                                        <div class="col-md-3 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> Kitchen: <?php echo number_format(intval($amenities['kitchens']->value));?></div>
                                                        <?php } if($amenities['garages']->value > 0) { ?>
                                                        <div class="col-md-3 col-xs-6 col-mb-12 property-feature-wrap"><i class="fa fa-check-square-o"></i> Garages: <?php echo number_format(intval($amenities['garages']->value));?></div>
                                                        <?php }  ?>
                                                    </div>
                                                </div>
                                                <?php if(!empty($row->videos[0])){ ?>
                                                <div id="ere-features" class="tab-pane fade">
                                                    <div class="video video-has-thumb">
                                                        <div class="entry-thumb-wrap">
                                                            <div class="embed-responsive embed-responsive-16by9 embed-responsive-full">
                                                                <iframe width="500" height="281"
                                                                        src="https://www.youtube.com/embed/<?php echo get_youtube_id($row->videos[0]);?>"
                                                                        frameborder="0"
                                                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                                        allowfullscreen></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                               <!-- <div id="ere-video" class="tab-pane fade">
                                                    <iframe width="100%" height="500" src="https://my.matterport.com/show/?m=wWcGxjuUuSb&amp;utm_source=hit-content-embed" frameborder="0" allowfullscreen="" allowvr=""></iframe>
                                                </div>-->
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            /*jQuery(document).ready(function($) {
                                                $('#ere-features-tabs').tabCollapse();
                                            });*/
                                        </script>
                                    </div>

                                    <?php
                                    $_amenities = [];
                                    if (count($amenities) > 0) {
                                        foreach ($amenities as $k => $amenity) {
                                            if(!empty($amenity->value)){
                                                $_amenities[$amenity->group_title][$k] = $amenity;
                                            }
                                        }
                                    }

                                    if (count($_amenities) > 0) { ?>
                                    <div class="single-property-element property-location">
                                        <div class="ere-heading-style2">
                                            <h2>Home Amenities</h2>
                                        </div>
                                        <div class="ere-property-element">
                                            <div class="property-address">
                                                <?php
                                                ob_start();
                                                include __DIR__ . "/include/amenities.php";

                                                $amenities_html = ob_get_clean();
                                                ?>
                                                <!-- Property Features -->
                                                <div class="property-features">
                                                    <ul class="list-style-one">
                                                        <?php echo $amenities_html; ?>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div class="single-property-element property-google-map-directions ere-google-map-directions">
                                        <div class="ere-heading-style2">
                                            <h2>Location</h2>
                                        </div>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- sidebar -->
                    <div class="primary-sidebar sidebar col-md-3 sidebar-mobile-canvas -gf-sticky">
                        <aside id="ere_widget_search_form-2" class="widget ere_widget ere_widget_search_form">
                            <h4 class="widget-title"><span>Contact Agent</span></h4>
                            <div class="ere-property-advanced-search clearfix dropdown color-dark ">
                                <div class="form-search-wrap">
                                    <div class="form-search-inner">
                                        <div class="-ere-search-content">

                                            <div class="agent-form">
                                                <?php include "contact_agent_form.php"; ?>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </aside>



                            <?php
                            $g_area_id = $row->area_id;
                            include "include/area_reviews.php";?>


                        <aside id="g5plus-recent-properties-2" class="widget widget-recent-properties">
                            <h4 class="widget-title"><span>Recent Properties</span></h4>
                            <div class="g5-recent-properties">
                                <?php include "include/property_recent.php"?>
                            </div>
                        </aside>
                        <aside id="ere_widget_top_agents-2" class="widget ere_widget ere_widget_top_agents">
                            <?php include "include/top_agents.php";?>
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