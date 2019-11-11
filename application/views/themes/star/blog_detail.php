<?php get_header(get_option('header')); ?>
<?php
$res = $this->db->query("SELECT blog_tags.type FROM blog_tags_rel 
LEFT JOIN blog_tags ON(blog_tags_rel.tag_id = blog_tags.id)
WHERE blog_tags_rel.blog_id='{$row->id}'");
$row->tags = $res->result();
?>
<div id="wrapper-content" class="clearfix ">
    <section class="page-title page-title-large property-single-page-title page-title-background" style="padding-top:70px;padding-bottom:70px">
        <div class="page-title-background" style="background-image: url(http://localhost/star_m/assets/star/images/properties-2-1920x204.jpg)"></div>
        <div class="container">
            <div class="page-title-inner">
                <div class="property-info-header property-info-action">
                    <div class="property-main-info">
                        <div class="property-heading">
                            <h4>Blog</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="primary-content" class="pd-top-100 pd-bottom-100 sm-pd-top-50 sm-pd-bottom-0">
        <div class="container clearfix">
            <div class="row">
                <div id="primary-content" class="pd-top-100 pd-bottom-100 archive-wrap archive-large-image">
                    <div class="container clearfix">
                        <div class="row">
                            <div class="col-md-9 archive-inner">
                                <div class="blog-wrap clearfix">
                                    <article id="post-3523" class="post-large-image clearfix post-3523 post type-post status-publish format-standard has-post-thumbnail hentry category-apartment category-real-estates tag-apartment tag-villa">
                                        <div class="entry-content-wrap clearfix">
                                            <?php
                                            $image = checkAltImg("assets/front/blog_posts/{$row->image}");
                                            if(!empty(get_option('wm_logo'))) {
                                                $wm_img = ADMIN_ASSETS_DIR . 'img/' . get_option('wm_logo');
                                                $img_url = base_url(_Image::wm($image, 870, 490, $wm_img));
                                            } else {
                                                $img_url = base_url(_Image::open($image)->zoomCrop(870, 490));
                                            }
                                            ?>
                                            <div class="entry-thumb-wrap">
                                                <div class="entry-thumbnail">
                                                    <a href="#" title="We are Offering the Best Real Estate Deals" class="entry-thumbnail-overlay">
                                                        <img src="<?php echo $img_url ?>" alt="<?php echo $row->title ?>" class="img-responsive"> </a>
                                                    <a data-thumb-src="<?php echo $img_url ?>" data-gallery-id="1701687358" data-rel="lightGallery" href="http://themes.g5plus.net/benaa/wp-content/uploads/2018/01/properties-1.jpg" class="zoomGallery">
                                                        <i class="fa fa-expand"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="entry-post-meta">
<!--                                                <div class="entry-meta-author">-->
<!--                                                    <span>By </span><a href="#">admin</a>-->
<!--                                                </div>-->
                                                <div class="entry-meta-date">
                                                    <?php
                                                    $post_created = strtotime($row->created);
                                                    ?>
                                                    <a href="#"><?php echo date('F d, Y',$post_created); ?></a>
                                                </div>
                                            </div>
                                            <div class="entry-content-inner">
                                                <div class="entry-info-post clearfix">
                                                    <h4 class="entry-post-title">
                                                        <?php echo $row->title ?>
                                                    </h4>
                                                    <div class="sj-blog-description">
                                                        <?php echo $row->description ?>
                                                    </div>

                                                    <div class="entry-excerpt">
                                                        <label>Categories: </label>
                                                        <a href="#"> <?php echo $row->Category ?> </a>

                                                        <label>Tags: </label>
                                                        <?php
                                                        if(count($row->tags)) {
                                                            $tag_str = '';
                                                            foreach ($row->tags as $tag) {
                                                                $tag_str .= "<span><a href='#'>" . $tag->type . "</span></a>" . ",";
                                                            }
                                                            $tag_str = rtrim($tag_str, ", ");
                                                            ?>
                                                            <span>
                                                                <?php echo $tag_str ?>
                                                            </span>
                                                            <?php
                                                        }?>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            <div class="sidebar-mobile-canvas-icon" title="Click to show Canvas Sidebar">
                                <i class="fa fa-sliders"></i>
                            </div>
                            <div class="wrapper-sticky" style="display: block; height: 1134px; width: 25%; margin: auto; position: relative; float: left; left: auto; right: auto; top: auto; bottom: auto; vertical-align: top;">
                                <div class="primary-sidebar sidebar col-md-3 sidebar-mobile-canvas gf-sticky" style="left: 0px; width: 300px; position: absolute; top: 0px;">
                                    <aside id="search-2" class="widget widget_search">
                                        <h4 class="widget-title"><span>Search</span></h4>
                                        <form role="search" class="search-form" method="get" id="searchform" action="http://themes.g5plus.net/benaa/">
                                            <input type="text" value="" name="s" id="s" placeholder="ENTER YOUR  KEYWORD">
                                            <button type="submit">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </form>
                                    </aside>
                                    <aside id="recent-posts-2" class="widget widget_recent_entries">
                                        <h4 class="widget-title">
                                            <span>Recent Posts</span>
                                        </h4>
                                        <ul>
                                            <li>
                                                <a href="#">We are Offering the Best Real Estate Deals</a>
                                            </li>
                                            <li>
                                                <a href="#">Recent Trends in Story Telling 2017</a>
                                            </li>
                                            <li>
                                                <a href="#">Construction You Can Count On</a>
                                            </li>
                                            <li>
                                                <a href="#">Project Luxury Villa in Rego Park</a>
                                            </li>
                                            <li>
                                                <a href="#">Boutique Space Greenville at 2017</a>
                                            </li>
                                        </ul>
                                    </aside>
                                    <aside id="categories-2" class="widget widget_categories">
                                        <h4 class="widget-title">
                                            <span>Categories</span>
                                        </h4>
                                        <ul>
                                            <li class="cat-item cat-item-2">
                                                <a href="#">Apartment (6)</a>
                                            </li>
                                            <li class="cat-item cat-item-3">
                                                <a href="#">Clients (1)</a>
                                            </li>
                                            <li class="cat-item cat-item-4">
                                                <a href="#">Green (3)</a>
                                            </li>
                                            <li class="cat-item cat-item-5">
                                                <a href="#">Mountain (1)</a>
                                            </li>
                                            <li class="cat-item cat-item-6">
                                                <a href="#">Real Estates (7)</a>
                                            </li>
                                            <li class="cat-item cat-item-7">
                                                <a href="#">Villa (7)</a>
                                            </li>
                                        </ul>
                                    </aside>
                                    <aside id="tag_cloud-2" class="widget widget_tag_cloud">
                                        <h4 class="widget-title"><span>Tags</span></h4>
                                        <div class="tagcloud">
                                            <a href="#" class="tag-cloud-link tag-link-8 tag-link-position-1" style="font-size: 8pt;" aria-label="agency (1 item)">agency</a>
                                            <a href="#" class="tag-cloud-link tag-link-9 tag-link-position-2" style="font-size: 8pt;" aria-label="agent (1 item)">agent</a>
                                            <a href="#" class="tag-cloud-link tag-link-10 tag-link-position-3" style="font-size: 8pt;" aria-label="Apartment (1 item)">Apartment</a>
                                            <a href="#" class="tag-cloud-link tag-link-11 tag-link-position-4" style="font-size: 18.181818181818pt;" aria-label="Building (4 items)">Building</a>
                                            <a href="#" class="tag-cloud-link tag-link-12 tag-link-position-5" style="font-size: 22pt;" aria-label="Building Construction (6 items)">Building Construction</a>
                                            <a href="#" class="tag-cloud-link tag-link-13 tag-link-position-6" style="font-size: 18.181818181818pt;" aria-label="Construction (4 items)">Construction</a>
                                            <a href="#" class="tag-cloud-link tag-link-14 tag-link-position-7" style="font-size: 8pt;" aria-label="Home (1 item)">Home</a>
                                            <a href="#" class="tag-cloud-link tag-link-15 tag-link-position-8" style="font-size: 12.581818181818pt;" aria-label="homes (2 items)">homes</a>
                                            <a href="#" class="tag-cloud-link tag-link-16 tag-link-position-9" style="font-size: 8pt;" aria-label="house (1 item)">house</a>
                                            <a href="#" class="tag-cloud-link tag-link-17 tag-link-position-10" style="font-size: 8pt;" aria-label="listing (1 item)">listing</a>
                                            <a href="#" class="tag-cloud-link tag-link-18 tag-link-position-11" style="font-size: 8pt;" aria-label="property (1 item)">property</a>
                                            <a href="#" class="tag-cloud-link tag-link-19 tag-link-position-12" style="font-size: 8pt;" aria-label="realtor (1 item)">realtor</a>
                                            <a href="#" class="tag-cloud-link tag-link-20 tag-link-position-13" style="font-size: 18.181818181818pt;" aria-label="villa (4 items)">villa</a>
                                        </div>
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<?php get_footer(); ?>