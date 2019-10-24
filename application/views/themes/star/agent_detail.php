<?php
$page->title = $agent->title = $agent->full_name;
?>
<?php get_header(get_option('header')); ?>


<div id="wrapper-content" class="clearfix ">
    <section class="page-title page-title-large property-single-page-title page-title-background" style="padding-top:70px;padding-bottom:70px">
        <div class="page-title-background" style="background-image: url(<?php echo media_url('images/properties-2-1920x204.jpg'); ?>)"></div>
        <div class="container">
            <div class="page-title-inner">
                <div class="property-info-header property-info-action">
                    <div class="property-main-info">
                        <div class="property-location" title="">
                            <i class="fa fa-map-marker accent-color"></i>
                            <a target="_blank" href="https://maps.google.com/?q=<?php echo urldecode($agent->full_address);?>"><span><?php echo $agent->full_address;?></span></a>
                        </div>
                        <div class="property-heading">
                            <h4><?php echo $agent->title;?></h4>
                        </div>
                    </div>
                    <div class="property-bottom-info">
                        <div class="property-info">
                            <div class="property-area">
                                <span class="fa -fa-hotel accent-color"><img src="<?php echo _img(media_url('images/sale-property.png'), 42, 42);?>" alt="Sale"></span>
                                <div class="content-property-info">
                                    <p class="property-info-value"><?php echo number_format($agent->sale_properties);?>
                                    </p>
                                    <p class="property-info-title">Sale</p>
                                </div>
                            </div>
                            <div class="property-bedrooms">
                                <span class="fa -fa-hotel accent-color"><img src="<?php echo _img(media_url('images/rent-property.png'), 42, 42);?>" alt="Rent"></span>
                                <div class="content-property-info">
                                    <p class="property-info-value"><?php echo number_format($agent->rent_properties);?></p>
                                    <p class="property-info-title">Rent</p>
                                </div>
                            </div>
                            <div class="property-bathrooms">
                                <span class="fa -fa-hotel accent-color"><img src="<?php echo _img(media_url('images/projects-property.png'), 42, 42);?>" alt="Projects"></span>
                                <div class="content-property-info">
                                    <p class="property-info-value"><?php echo number_format($agent->projects);?></p>
                                    <p class="property-info-title">Project's</p>
                                </div>
                            </div>
                        </div>
                        <!--<div class="property-price-action">
                            <span class="property-price">
                            <span class="property-price-prefix">Phone </span> <?php /*echo $agent->phone;*/?> </span>
                        </div>-->
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


                                <?php if(!empty(strip_tags($agent->description))) { ?>
                                    <div class="single-property-element property-description">
                                        <div class="ere-heading-style2">
                                            <h2>Description</h2>
                                        </div>
                                        <div class="ere-property-element">
                                            <p><?php echo $agent->description;?></p>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php
                                $socials = json_decode($row->social_network, true);
                                if(count($socials) > 0) { ?>
                                    <div class="single-property-element property-description">
                                        <div class="ere-heading-style2">
                                            <h2>Social Link's</h2>
                                        </div>
                                        <div class="ere-property-element">
                                            <div class="agent-social">
                                                <?php
                                                foreach ($socials as $social => $social_link) {
                                                    if(!empty($social_link)) {
                                                        echo '<a target="_blank" href="' . $social_link . '"><i class="fa fa-' . $social . '"></i></a>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if(count($agent_areas) > 0){ ?>
                                <div class="single-property-element property-google-map-directions ere-google-map-directions">
                                    <div class="ere-heading-style2">
                                        <h2>Deals in Area's</h2>
                                    </div>
                                    <div class="ere-property-element">
                                        <ul class="agent_areas">
                                        <?php
                                        foreach ($agent_areas as $agent_area) {
                                            echo "<li><a href='".site_url("properties?purpose=Sale&city_id={$agent_area->city_id}&area_ids%5B%5D={$agent_area->id}")."'>{$agent_area->area}, {$agent_area->city}</a></li>";
                                        }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                                <?php } ?>

                                <?php include "include/agent_properties.php";?>

                                <div class="single-property-element property-google-map-directions ere-google-map-directions">
                                    <div class="ere-heading-style2">
                                        <h2>Location</h2>
                                    </div>
                                    <div class="ere-property-element">
                                        <?php
                                        $latLng = getLatLng($agent->full_address. ' Pakistan');
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
                <div class="primary-sidebar sidebar col-md-3 sidebar-mobile-canvas -gf-sticky -hidden-sm -hidden-xs">

                    <aside id="ere_widget_search_form-2" class="widget ere_widget ere_widget_search_form">
                        <h4 class="widget-title"><span>Contact Agent</span></h4>
                        <div class="ere-property-advanced-search clearfix dropdown color-dark ">
                            <div class="form-search-wrap">
                                <div class="form-search-inner">
                                    <div class="ere-search-content">
                                        <div data-href="" class="search-properties-form">
                                            <div class="form-search">
                                                <div class="agent-form">
                                                    <?php include "contact_agent_form.php"; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!--<aside id="g5plus-recent-properties-2" class="widget widget-recent-properties">
                        <h4 class="widget-title"><span>Recent Properties</span></h4>
                        <div class="g5-recent-properties">
                            <?php /*include "include/property_recent.php"*/?>
                        </div>
                    </aside>-->
                    <aside id="ere_widget_top_agents-2" class="widget ere_widget ere_widget_top_agents">
                        <?php include "include/top_agents.php";?>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="vc_row-full-width vc_clearfix"></div>
<?php get_footer(); ?>
<!--Google Map APi Key-->
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo get_option('gmap_key');?>"></script>
<script src="<?php echo media_url('js/map-script.js'); ?>"></script>
<!--End Google Map APi-->