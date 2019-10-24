<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_projects');
$ci->load->model(ADMIN_DIR . 'm_amenities');
$ci->load->model(ADMIN_DIR . 'm_project_properties');

$order = 'projects.id DESC';

$limit = 20;
$offset = 0;
if (getVar('limit') > 0) {
    $limit = intval(getVar('limit'));
}
if (getVar('per_page') > 0) {
    $offset = intval(getVar('per_page'));
}
$where = " AND projects.status='Active' ";

$rows = $ci->m_projects->rows($where, $limit, $offset, $order);
$num_rows = $ci->m_projects->num_rows;
$total_rows = $ci->m_projects->total_rows;

?>

<?php include "include/page_header.php"; ?>
<div id="wrapper-content" class="clearfix ">
    <div id="primary-content" class="pd-top-30 pd-bottom-100 page-wrap">
        <div class="container clearfix">
            <div class="col-md-9 page-inner">
                <article class="pages post-3785 page type-page status-publish hentry">
                    <div class="entry-content clearfix">
                        <div class="entry-content-inner clearfix">
                            <div class="vc_row wpb_row vc_row-fluid">
                                <div class="wpb_column vc_column_container vc_col-sm-12">
                                    <div class="vc_column-inner">
                                        <div class="wpb_wrapper">
                                            <div class="g5plus-heading style1 text-left color-dark vc_custom_1517823237063">
                                                <i class="icon-house-roof2"></i>
                                                <h2>PROJECTS LISTING</h2>
                                                <p>&nbsp;</p>
                                            </div>

                                            <div class="ere-property-wrap">
                                                <div class="ere-property clearfix property-list  col-gap-0">
                                                    <?php
                                                    if (count($rows) > 0) {
                                                        foreach ($rows as $row) {

                                                            $amenities_code = ['air-conditioning', 'kitchens'];
                                                            $amenities = $ci->m_amenities->amenities($row->id, '', 'Project', $amenities_code);
                                                            $property = $ci->m_project_properties->row(0, " AND project_id='{$row->id}'");

                                                            ?>


                                                            <div class="property-content">
                                                                <div class="property-item mg-bottom-30">
                                                                    <div class="property-inner">
                                                                        <div class="property-image ">
                                                                            <?php
                                                                            $image = checkAltImg("assets/front/projects/{$row->image}");
                                                                            if (!empty(get_option('wm_logo'))) {
                                                                                $wm_img = ADMIN_ASSETS_DIR . 'img/' . get_option('wm_logo');
                                                                                $img_url = base_url(_Image::wm($image, 370, 320, $wm_img, ['func' => 'resize']));
                                                                            } else {
                                                                                $img_url = base_url(_Image::open($image)->resize(370, 320));
                                                                            }
                                                                            $logo = checkAltImg("assets/front/projects/{$row->logo}");
                                                                            $logo_url = base_url(_Image::open($logo)->resize(70, 70));

                                                                            $path_url = $row->area . '-' . $row->city . '-' . $row->country . '-' . $row->title;
                                                                            $path_url = site_url("project/" . friendly_url($path_url, '-', true, $row->id))
                                                                            ?>
                                                                            <img src="<?php echo($img_url); ?>"
                                                                                 alt="<?php echo $row->title; ?>">
                                                                            <div class="property-action block-center">
                                                                                <div class="block-center-inner">
                                                                                    <!--<div class="property-view-gallery-wrap" data-toggle="tooltip" title="" data-original-title="View Images">
                                                                                <a href="<?php /*echo ("front/properties/{$row->image}");*/ ?>" class="lightbox-image" data-fancybox="property"><i class="fa fa-camera"></i></a>
                                                                            </div>
                                                                            <a href="<?php /*echo site_url("member/wishlist/add/{$row->id}");*/ ?>" class="property-favorite" data-toggle="tooltip" title="" data-title-not-favorite="Add to Favorite" data-title-favorited="It is my favorite" data-icon-not-favorite="fa fa-star-o" data-icon-favorited="fa fa-star" data-original-title="Add to Favorite"><i class="fa fa-star-o"></i></a>-->
                                                                                    <!--<a href="<?php /*echo site_url("project/{$row->id}");*/ ?>" class="compare-property" data-toggle="tooltip" title="" data-original-title="Compare"> <i class="fa fa-plus"></i> </a>-->
                                                                                </div>
                                                                                <a class="property-link"
                                                                                   href="<?php echo $path_url; ?>"
                                                                                   title="<?php echo $row->title; ?>"></a>


                                                                            </div>
                                                                            <div class="property-label property-featured">
                                                                                <p class="label-item"><span
                                                                                            class="property-label-bg">Featured <span
                                                                                                class="property-arrow"></span></span>
                                                                                </p>
                                                                            </div>
                                                                            <div class="property-item-content-inner">
                                                                                <div class="property-date"><i
                                                                                            class="fa fa-calendar accent-color"></i> <?php echo get_date_diff($row->created, date('Y-m-d H:i:s')); ?>
                                                                                    ago
                                                                                </div>
                                                                                <!--<div class="property-agent">
                                                                                    <a href=""> <i class="fa fa-user accent-color"></i> <span>Ghaly Marco</span> </a>
                                                                                </div>-->
                                                                            </div>
                                                                        </div>
                                                                        <div class="property-item-content ">
                                                                            <div class="property-type"><i
                                                                                        class="fa fa-tag accent-color"></i>
                                                                                <p>&nbsp;</p>
                                                                            </div>
                                                                            <div class="property-heading property-heading_custom">
                                                                                <h4 class="property-title fs-18">
                                                                                    <a href="<?php echo $path_url; ?>"><?php echo $row->title; ?></a>
                                                                                </h4>
                                                                                <img src="<?php echo $logo_url; ?>"
                                                                                     class="img-fluid img-rounded"
                                                                                     alt="<?php echo $row->title; ?>">
                                                                            </div>
                                                                            <div class="property-location">
                                                                                <i class="fa fa-map-marker accent-color"></i>
                                                                                <a target="_blank"
                                                                                   href="javascript:;"><span><?php echo $row->full_address; ?></span></a>
                                                                            </div>
                                                                            <div class="property-info">
                                                                                <div class="property-info-inner clearfix">
                                                                                    <?php if (!empty($property->area)) { ?>
                                                                                        <div class="property-area">
                                                                                            <div class="property-area-inner">
                                                                                                <i class="icon-assembly-area"></i>
                                                                                                <span class="property-info-value"><?php
                                                                                                    echo $property->area . ' ' . short_area_unit($property->area_unit);
                                                                                                    //$_area_unit = area_conversion(floatval($property->area), $property->area_unit, $_COOKIE['area_unit']);
                                                                                                    //echo number_format($_area_unit, (end(explode('.', number_format($_area_unit, 2))) > 0 ? 2 : 0)) . ' ' . $_COOKIE['area_unit'];?>
                                                                                        </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                    <?php if ($row->bedrooms > 0) { ?>
                                                                                        <div class="property-bedrooms">
                                                                                            <div class="property-bedrooms-inner">
                                                                                                <i class="icon-bed-1"></i>
                                                                                                <br><span
                                                                                                        class="property-info-value"><?php echo number_format($row->bedrooms); ?>
                                                                                                    Bedrooms</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                    <?php if ($row->bathrooms > 0) { ?>
                                                                                        <div class="property-bathrooms">
                                                                                            <div class="property-bathrooms-inner">
                                                                                                <i class="icon-bathtub-1"></i>
                                                                                                <br><span
                                                                                                        class="property-info-value"><?php echo number_format($row->bathrooms); ?>
                                                                                                    Bathrooms</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                    <?php if (intval($amenities['kitchens']->value) > 0) { ?>
                                                                                        <div class="property-garages">
                                                                                            <div class="property-garages-inner">
                                                                                                <!--<i class="icon-car-garage"></i>-->
                                                                                                <span class="fa -fa-hotel accent-color"><img
                                                                                                            src="<?php echo _img(media_url('images/kitchen.png'), 24, 24); ?>"
                                                                                                            alt="Kitchens"></span>
                                                                                                <br><span
                                                                                                        class="property-info-value"><?php echo number_format(intval($amenities['kitchens']->value)); ?>
                                                                                                    Kitchen</span></div>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="property-excerpt">
                                                                                <p class="two-line-text"><?php
                                                                                    $read_more = '';
                                                                                    if (strlen(strip_tags($row->description)) > 100) {
                                                                                        $read_more = '... <a class="" href="' . $path_url . '">Read more</a>';
                                                                                    }
                                                                                    echo substr(strip_tags($row->description), 0, 100) . $read_more; ?></p>
                                                                            </div>
                                                                            <div class="property-status-price">
                                                                                <div class="property-status">
                                                                                    <p class="status-item">
                                                                                        <a href="<?php echo $path_url; ?>"
                                                                                           style="color: #ffffff">
                                                                                            <span class="property-status-bg">More Detail </span>
                                                                                        </a>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="property-price">
                                                                                    <span> <?php echo short_number($row->price_from) . ' - ' . short_number($row->price_to); ?>
                                                                                </div>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    } ?>

                                                    <div class="clearfix"></div>
                                                    <?php
                                                    $config['base_url'] = generate_url('per_page');
                                                    $config['total_rows'] = $total_rows;
                                                    $config['per_page'] = $limit;
                                                    $config['page_query_string'] = TRUE;
                                                    $choice = $config["total_rows"] / $config["per_page"];
                                                    $config["total_links"] = ceil($choice);
                                                    $config["num_links"] = 6;

                                                    $config['attributes'] = array('class' => 'page-numbers');
                                                    $config['cur_tag_open'] = '<span class="page-numbers current">';
                                                    $config['cur_tag_close'] = '</span>';

                                                    $this->pagination->initialize($config);
                                                    $pagination = $this->pagination->create_links();
                                                    ?>
                                                    <div class="paging-navigation clearfix">
                                                        <?php echo $pagination; ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- sidebar -->
            <br>
            <div class="col-md-3 nopadding primary-sidebar sidebar sidebar-mobile-canvas hidden-sm hidden-xs side_pad">
                <div class="sidebar-widget search-properties">
                    <p class="project-listing-ad-div">
                        <?php echo $this->cms->get_block('project-listing-ad'); ?>
                    </p>
                    <p class="project-listing-ad-one-div">
                        <?php echo $this->cms->get_block('project-listing-ad-one'); ?>
                    </p>
                    <p class="project-listing-ad-two-div">
                        <?php echo $this->cms->get_block('project-listing-ad-two'); ?>
                    </p>
                    <p class="project-listing-ad-three-div">
                        <?php echo $this->cms->get_block('project-listing-ad-three'); ?>
                    </p>
                    <?php //include "recent_properties.php";?>
                    <!--search box-->
                    <!--<div class="sidebar-widget sort-by">
                        <select class="custom-select-box form-control">
                            <option>Sort By</option>
                            <option>Residential</option>
                            <option>Commercial</option>
                            <option>Industrial</option>
                            <option>Apartments</option>
                        </select>
                    </div>
                    <h6 class="rectitle nopadding">SEARCH PROJECTS</h6>
                    <div class="property-search-form style-three">
                        <?php /*include "include/left_search_box.php" */ ?>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
