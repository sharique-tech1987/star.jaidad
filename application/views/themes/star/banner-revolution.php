<!-- Banner
================================================== -->
<?php
$ci =& get_instance();
$ci->load->model([ADMIN_DIR . 'm_projects', ADMIN_DIR . 'm_properties']);

$banner_indicator = '';
$banner_item = '';
$_banners = $this->cms->get_banners("type IN('Static')");
//echo '<pre>';print_r($this->db->last_query());echo '</pre>';
if (count($_banners) > 0) {
    ?>
<section class="main-slider">
    <div class="rev_slider_wrapper fullwidthbanner-container"  id="rev_slider_one_wrapper" data-source="gallery">
        <div class="rev_slider fullwidthabanner" id="rev_slider_one" data-version="5.4.1">
            <ul>
            <?php
            foreach ($_banners as $i => $banner) {
                ?>
                <?php if (!empty($banner->link)) { echo '<a href="' . $banner->link . '">'; } ?>

                <li data-description="Slide Description" data-easein="default" data-easeout="default" data-fsmasterspeed="1500" data-fsslotamount="7" data-fstransition="fade" data-hideafterloop="0" data-hideslideonmobile="off" data-index="rs-1689" data-masterspeed="default" data-param1="" data-param10="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-rotate="0" data-saveperformance="off" data-slotamount="default"
                    data-thumb="<?php echo asset_url('front/banner_management/' . $banner->image); ?>"
                    data-title="Slide Title" data-transition="parallaxvertical">

                    <?php if (!empty($banner->link)) { echo '<a href="' . $banner->link . '">'; } ?>
                    <img alt="" class="rev-slidebg" data-bgfit="cover" data-bgparallax="10" data-bgposition="center center"
                         data-bgrepeat="no-repeat" data-kenburns="on" data-duration="10000" data-ease="Linear.easeNone"
                         data-scalestart="100" data-scaleend="120"
                         src="<?php echo asset_url('front/banner_management/' . $banner->image); ?>">

                    <?php if (!empty($banner->link)) { echo '</a>'; } ?>

                    <?php
                    if(in_array($banner->type, ['Project', 'Property'])) {

                        switch ($banner->type){
                            case 'Project':
                                $_row = $ci->m_projects->row();
                                $_url = site_url("project/{$_row->id}");
                                $_price = number_format($_row->price_from) . ' - ' . number_format($_row->price_to);
                                break;
                            case 'Property':
                                $_row = $ci->m_properties->row();
                                $_url = site_url("property/{$_row->id}");
                                $_price = number_format($_row->price);
                                break;
                        }
                    ?>
                    <div class="tp-caption"
                         data-paddingbottom="[0,0,0,0]"
                         data-paddingleft="[0,0,0,0]"
                         data-paddingright="[0,0,0,0]"
                         data-paddingtop="[0,0,0,0]"
                         data-responsive_offset="on"
                         data-type="text"
                         data-height="none"
                         data-whitespace="nowrap"
                         data-width="auto"
                         data-text-align="center"
                         data-hoffset="['10','50','0','0']"
                         data-voffset="['-20','-20','-20','-20']"
                         data-x="['right','right','center','center']"
                         data-y="['middle','middle','middle','middle']"
                         data-frames='[{"delay":1500,"speed":1000,"frame":"0","from":"x:50px;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"x:50px;opacity:0;","ease":"Power3.easeInOut"}]'>
                        <div class="content-box">
                            <div class="inner-box">
                                <div class="title-box">
                                    <!--<h3><?php /*echo substr($_row->title, 0, 40);*/?></h3>-->
                                    <h3><?php echo substr($banner->title, 0, 40);?></h3>
                                    <p><?php echo $_row->full_address;?></p>
                                </div>
                                <ul class="info-list">
                                    <li><span><?php echo number_format($_row->area);?></span>Area <?php echo $_row->area_unit;?></li>
                                    <li><span><?php echo number_format($_row->bedrooms);?></span>Bed Room's</li>
                                    <li><span><?php echo number_format($_row->bathrooms);?></span>Bath Room's</li>
                                </ul>
                                <div class="price"><?php echo $_price;?></div>
                                <div class="btn-box"><a href="<?php echo $_url;?>" class="theme-btn btn-style-one">View Detail</a></div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </li>
                <?
            }
            ?>
            </ul>
        </div>
    </div>
</section>
<?php } ?>
<!--End Main Slider-->