<?php
$ci = & get_instance();
$ci->load->model(ADMIN_DIR . 'm_short_news');
$_news = $ci->m_short_news->rows("AND short_news.status='Active'", 0, 0, 'short_news.ordering ASC');
if (count($_news) > 0){
    ?>
    <div class="ticker-main">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-xs-12">
                    <span class="heading">Latest News:</span>
                </div>
                <div class="col-md-10 col-xs-12">
                    <marquee behaviour="scroll" direction="left" width="100%" scrollamount="6" onmouseover="this.stop();" onmouseout="this.start();">
                        <?php
                        foreach ($_news as $news) {
//                            ?><!--<a target="_blank" href="--><?php //echo do_shortcode($news->link);?><!--">--><?php //echo do_shortcode($news->news);?><!--</a>-->
						<p class="newscolor"><?php echo do_shortcode($news->news);?></p>
							<?php
                        }
                        ?>
                    </marquee>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
