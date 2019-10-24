<!-- Banner
================================================== -->
<?php
$ci =& get_instance();
$ci->load->model([ADMIN_DIR . 'm_projects', ADMIN_DIR . 'm_properties']);

$banner_indicator = '';
$banner_item = '';
$_banners = $this->cms->get_banners("type IN('Static')");
//echo '<pre>'; print_r($ci->db->last_query()); echo '</pre>';

if(count($_banners) > 0){
    foreach ($_banners as $i => $banner) {
        $banner_indicator .= '<li data-target="#bootstrap-touch-slider" data-slide-to="' . $i . '" class="' . ($i == 0 ? 'active' : '') . '"></li>';

        //$banner_item .= '<div class="item ' . ($i == 0 ? 'active' : '') . '">';
        $banner_item .= '<div class="slide-item item1 item-background" data-background="'.asset_url('front/banner_management/' . $banner->image).'">';
        if (!empty($banner->link)) {
            $banner_item .= '<a href="' . $banner->link . '">';
        }
        $banner_item .= '<div class="slide-img"><img src="'.asset_url('front/banner_management/' . $banner->image).'" alt="'.$banner->title.'"></div>';

        $banner_item .= '<div class="slide-content">'.do_shortcode($banner->description).'</div>';
        if(!empty($banner->link)) {
            $banner_item .= '</a>';
        }
        $banner_item .= '</div>';
    }

    ?>
    <div class="main-slideshow slideshow3 ">
        <div class="owl-carousel nav-style1 owl-background banner-carousel" data-autoplay="true" data-nav="true" data-dots="false" data-loop="true" data-slidespeed="800" data-margin="0"  data-responsive = '{"0":{"items":1}, "640":{"items":1}, "768":{"items":1}, "1024":{"items":1}, "1200":{"items":1}}' data-height="400">
            <?php echo $banner_item;?>
        </div>
    </div>

<?php } ?>