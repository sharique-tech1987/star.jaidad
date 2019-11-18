<?php get_header(get_option('header')); ?>
<?php
$res = $this->db->query("SELECT blog_tags.id, blog_tags.type FROM blog_tags_rel 
LEFT JOIN blog_tags ON(blog_tags_rel.tag_id = blog_tags.id)
WHERE blog_tags_rel.blog_id='{$row->id}'");
$row->tags = $res->result();
?>
<div id="wrapper-content" class="clearfix ">
    <section class="page-title page-title-large property-single-page-title page-title-background" style="padding-top:70px;padding-bottom:70px">
        <div class="page-title-background" style="background-image: url(<?php echo media_url('images/properties-2-1920x204.jpg'); ?>"></div>
        <div class="container">
            <div class="page-title-inner">
                <div class="property-info-header property-info-action">
                    <div class="property-main-info">
                        <div class="property-heading">
                            <h4><?php echo $row->title ?></h4>
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
                                                    <h4><?php echo date('F d, Y',$post_created); ?></h4>
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
<!--                                                        <label>Categories: </label>-->
<!--                                                        <a href="--><?php //echo site_url("blogs?cat_id=$row->category_id") ?><!--"> --><?php //echo $row->Category ?><!-- </a>-->

                                                        <label>Tags: </label>
                                                        <?php
                                                        if(count($row->tags)) {
                                                            $tag_str = '';
                                                            foreach ($row->tags as $tag) {

                                                                $tag_str .= "<span><a href='" . site_url("blogs?tag_id=$tag->id") . "'>" . $tag->type . "</span></a>" . ",";
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

                            <?php include('include/blog_right_side_bar.php'); ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<?php get_footer(); ?>