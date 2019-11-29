<div id="wrapper-content" class="clearfix ">
    <div class="page-top-section">
        <section class="page-title page-title-large page-title-background" style="padding-top:70px;padding-bottom:70px">
            <div class="page-title-background"
                 <?php
                 $banner_img_url = '';
                 if(empty($page->thumbnail)){
                     $banner_img_url = asset_url('front/pages/new_cover.jpg' );
                 }else{
                     $banner_img_url = asset_url('front/pages/' . $page->thumbnail);
                 }
                 ?>
                 style="background-image: url(<?php echo $banner_img_url; ?>)"></div>
            <div class="container">
                <div class="page-title-inner">
                    <div class="page-title-main-info">
                        <h4><?php echo $page->title; ?></h4>
                    </div>
                    <?php include "breadcrumb.php"; ?>
                </div>
            </div>
        </section>
        <?php include __DIR__ . "/../news_ticker.php";
        ?>
    </div>