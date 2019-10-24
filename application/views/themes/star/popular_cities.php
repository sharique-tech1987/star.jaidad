<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_cities');


$limit = 6;
$offset = 0;
$order = 'cities.ordering, cities.id ASC';
$where = " AND cities.status='Active' AND cities.show_front='Yes'";

$rows = $ci->m_cities->rows($where, $limit, $offset, $order);
if (count($rows) > 0){
?>

<!--Popular Places Section-->
<section class=" hidden-xs hidden-sm popular-places-section">
    <div class="auto-container">
        <div class="wpb_column vc_column_container vc_col-sm-12">
                    <div class="vc_column-inner">
                        <div class="wpb_wrapper">
                            <div class="g5plus-heading style1 text-center color-dark vc_custom_1520560874567"> <i class="icon-house-roof2"></i>
                                <h2>MOST POPULAR PLACES</h2>
                                <p>FIND YOUR DREAM HOUSE IN YOUR CITY</p>
                            </div>
                        </div>
                    </div>
                </div>
        <div class="hidden-xs hidden-sm visible-md visible-lg"><br><br><br><br><br><br><br></div>
        <div class="masonry-items-container clearfix">
            <?php
            foreach ($rows as $row) {
                $SQL = "SELECT COUNT(id) AS total FROM `properties` WHERE properties.status='Active' AND city_id='{$row->id}'";
                $total = $this->db->query($SQL)->row()->total;

                $url = site_url('properties/' . url_title($row->city, '_'));

                $cls = 'medium-item';
                $size = getimagesize(FCPATH . '/assets/front/cities/' . $row->image);
                if($size[0] < 580) {
                    $cls = 'small-item';
                }
                ?>
                <!-- Portfolio Item -->
                <div class="hidden-xs hidden-sm visible-md visible-lg popular-item masonry-item <?php echo $cls;?>">
                    <div class="image-box img-hover-zoom img-hover-zoom--slowmo">
                        <figure class="image">
                            <img src="<?php echo base_url('assets/front/cities/' . $row->image); ?>" alt="<?php echo $row->city;?>">
                        </figure>
                        <div class="info-box col-xs-12 col-sm-12">
                            <!--<span class="category">Apartment</span>-->
                            <h3 class="place"><a href="<?php echo $url;?>"><?php echo $row->city;?></a></h3>
                            <div class="properties"><a href="<?php echo $url;?>"><?php echo number_format($total);?> Properties</a></div>
                            <div class="view-all"><a href="<?php echo $url;?>">View All</a></div>
                        </div>
                    </div>
                </div>

                <div class="hidden-xs hidden-sm hidden-md hidden-lg hidden-sm popular-item masonry-item">
                    <div class="image-box img-hover-zoom img-hover-zoom--slowmo">
                        <figure class="image">
                            <img src="<?php echo base_url('assets/front/cities/' . $row->image); ?>" alt="<?php echo $row->city;?>">
                        </figure>
                        <div class="info-box col-xs-12 col-sm-12">
                            <!--<span class="category">Apartment</span>-->
                            <h3 class="place"><a href="<?php echo $url;?>"><?php echo $row->city;?></a></h3>
                            <div class="properties"><a href="<?php echo $url;?>"><?php echo number_format($total);?> Properties</a></div>
                            <div class="view-all"><a href="<?php echo $url;?>">View All</a></div>
                        </div>
                    </div>
                </div>


                <?php
            }
            ?>

        <!-- Load More -->
        <!--<div class="load-more-btn text-center">
            <a href="#" class="theme-btn btn-style-two">Load More</a>
        </div>-->
    </div>
</section>
<!--Portfolio Section-->
<?php } ?>
