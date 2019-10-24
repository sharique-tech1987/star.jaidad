<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_area');


$limit = 6;
$offset = 0;
$order = 'cities.id ASC';
$where = " AND cities.status='Active' AND cities.show_front='Yes'";

$rows = $ci->m_area->rows($where, $limit, $offset, $order);
if (count($rows) > 0){
?>
<!--Popular Places Section-->
<section class="popular-places-section">
    <div class="auto-container">
        <div class="sec-title">
            <span class="title">FIND YOUR DREAM HOUSE IN YOUR CITY</span>
            <h2>MOST POPULAR PLACES</h2>
        </div>

        <div class="masonry-items-container clearfix">
            <?php
            foreach ($rows as $row) {
                $SQL = "SELECT COUNT(id) AS total FROM `properties` WHERE city_id='{$row->id}'";
                $total = $this->db->query($SQL)->row()->total;

                $url = site_url('properties/' . url_title($row->city));

                $cls = 'medium-item';
                $size = getimagesize(FCPATH . '/assets/front/cities/' . $row->image);
                if($size[0] < 580) {
                    $cls = 'small-item';
                }
                ?>
                <!-- Portfolio Item -->
                <div class="popular-item masonry-item <?php echo $cls;?>">
                    <div class="image-box">
                        <figure class="image"><img src="<?php echo base_url('assets/front/cities/' . $row->image); ?>" alt=""></figure>
                        <div class="info-box">
                            <!--<span class="category">Apartment</span>-->
                            <h3 class="place"><a href="<?php echo $url;?>"><?php echo $row->city;?></a></h3>
                            <div class="properties"><a href="properties.html"><?php echo number_format($total);?> Properties</a></div>
                            <div class="view-all"><a href="<?php $url;?>">View All</a></div>
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