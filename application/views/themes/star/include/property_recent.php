<?php
$ci = & get_instance();
$ci->load->model(ADMIN_DIR . 'm_properties');
$limit = 5;
$order = 'properties.id DESC';
$where = " AND properties.status='Active'";
if($row->id > 0){
    $where .= " AND properties.id !='{$row->id}'";
}
if($properties_area_id > 0){
    $where .= " AND properties.area_id ='{$properties_area_id}'";
}
$recent_rows = $ci->m_properties->rows($where, $limit, 0, $order);
if (count($recent_rows) > 0) {
    ?>

    <?php
    foreach ($recent_rows as $recent_row) {

        $address_ = explode(",", $recent_row->full_address);
        $path_url = $address_[0] . '-' . $recent_row->city . '-' . $recent_row->country_code . '-' . $recent_row->title;
        $url = site_url("property/" . friendly_url($path_url,'-',true,$recent_row->id));

        $image = checkAltImg("assets/front/properties/{$recent_row->image}");
        $img_url = _Image::open($image)->zoomCrop(110, 80);

        ?>
    <div class="property-item">
        <div class="clearfix">
            <div class="entry-thumb-wrap">
                <div class="entry-thumbnail">
                    <a href="<?php echo $url;?>" title="">
                        <img src="<?php echo base_url($img_url);?>" alt="<?php echo $recent_row->title;?>" class="img-responsive">
                    </a>
                </div>
            </div>
            <span class="property-status">For <?php echo ucwords($recent_row->purpose);?></span>
            <div class="entry-content-wrap">
                <span class="property-state"><?php echo $recent_row->city .', ' . $recent_row->country;?></span>
                <h6 class="entry-post-title"><a title=""><?php echo $recent_row->title;?></a>
                </h6>
                <div class="property-price">
                    <span><?php echo short_number($recent_row->price);?></span>
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>
