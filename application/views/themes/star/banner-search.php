<!-- Banner
================================================== -->
<?php
$ci =& get_instance();
$ci->load->model([ADMIN_DIR . 'm_projects', ADMIN_DIR . 'm_properties']);

$banner_indicator = '';
$banner_item = '';
$_banners = $this->cms->get_banners("type IN('Static')");
//echo '<pre>';print_r($this->db->last_query());echo '</pre>';
//if (count($_banners) > 0)
{
    ?>
    <section class="property-search-section-two" style="background-image: url('<?php echo asset_url('front/banner_management/' . $_banners[0]->image); ?>');">
        <div class="auto-container">
            <div class="content-box">
                <div class="title-box">
                    <h2><?php echo $_banners[0]->title;?></h2>
                    <!--<h4>We have over million properties for you</h4>-->
                </div>
                <?php include "search_form.php";?>

                <?php echo $this->cms->get_block('index-teaser');?>
            </div>
        </div>
    </section>
<?php } ?>
<!--End Main Slider-->