<?php
$member_id = _session(FRONT_SESSION_ID);
if($post_review->id == 0 && $member_id > 0){
    $post_review = get_member($member_id);
    $post_review->name = $post_review->full_name;
}

$city_id = $row->city_id;
$area_ids[] = $g_area_id = $area_id = $row->id;
?>
<?php get_header(get_option('header')); ?>
<div id="wrapper-content" class="clearfix ">
    <section class="page-title page-title-large page-title-large page-title-background" style="padding-top:70px;padding-bottom:70px">
        <div class="page-title-background" style="background-image: url(<?php echo asset_url('front/pages/' . $page->thumbnail); ?>)"></div>
        <div class="container">
            <div class="page-title-inner">
                <?php if ($page->show_title) { ?>
                    <div class="page-title-main-info"><h4><?php echo $page->title; ?></h4></div>
                <?php } ?>
                <?php include "include/breadcrumb.php"?>
            </div>
        </div>
    </section>

    <div id="primary-content" class="page-wrap">
        <div class="container clearfix">
            <div class="page-inner">
                <article id="post-<?php echo $page->id;?>" class="pages post-<?php echo $page->id;?> page page-<?php echo $page->friendly_url;?> status-publish hentry">
                    <br>
                    <?php echo show_validation_errors();?>
                    <div class="review-area">
                        <!--Reviews Container-->

                            <!--Reviews-->
                            <?php
                            if (count($reviews['reviews']) > 0){
                                echo '<div class="reviews-container">';
                                echo '<h4>Review(s)</h4>';
                                foreach ($reviews['reviews'] as $review) {
                                    ?>
                                    <article class="review-box">
                                        <div class="thumb-box">
                                            <figure class="thumb"><img src="<?php echo _img(asset_url("front/users/{$review->photo}"), 100, 100, USER_IMG_NA);?>" alt="<?php echo $review->full_name;?>"></figure>
                                        </div>
                                        <div class="content-box">
                                            <div class="name"><?php echo $review->full_name;?></div>
                                            <span class="date"><i class="fa fa-calendar"></i> <?php echo mysql2date($review->created);?></span>
                                            <?php echo $review->star_rating;?>
                                            <div class="text"><?php echo $review->comment;?></div>
                                        </div>
                                    </article>
                                    <?php
                                }
                                echo '</div>';
                            }
                            ?>
                            <?php
                            $config['base_url'] = generate_url('per_page');
                            $config['total_rows'] = $total_rows;
                            $config['per_page'] = $limit;
                            $config['page_query_string'] = TRUE;
                            $choice = $config["total_rows"] / $config["per_page"];
                            $config["total_links"] = ceil($choice);
                            $config["num_links"] = 6;
                            $this->pagination->initialize($config);
                            $pagination = $this->pagination->create_links();
                            ?>
                            <div class="pagination-container">
                                <?php echo $pagination;?>
                            </div>



                    </div>


                    <div class="review-comment-form">
                        <h4>Leave A Review</h4>
                        <form method="post" action="<?php echo site_url('property/area_reviews/' . $area_id);?>">
                            <input type="hidden" name="area_id" value="<?php echo $area_id;?>">
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <input type="text" name="name" value="<?php echo $post_review->name;?>" placeholder="Full Name" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                    <input type="text" name="email" value="<?php echo $post_review->email;?>" placeholder="Email Address" required>
                                </div>
                                <div class="clearfix"></div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <textarea name="comment" placeholder="Massage"><?php echo $post_review->comment;?></textarea>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-sm-offset-3 col-md-offset-0 col-lg-offset-0 text-center">
                                    <div class="rating-box">
                                        <div class="text"> Your Rating:</div>
                                        <div class="rating-types" data-field="score" data-readonly="false" data-score="0" id="rating"></div>
                                    </div>
                                    <br>
                                    <button style="margin-top: 5px;" class="theme-btn btn-style-one" type="submit" name="submit-form">Submit now</button>
                                </div>
                            </div>
                        </form>
                    </div>


                </article>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
