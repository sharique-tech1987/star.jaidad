<?php get_header(get_option('header')); ?>

<?php
/*
 * ---------------------------------------------------------------------------------------------------------
 *  Cache
 * ---------------------------------------------------------------------------------------------------------
 */
$cache_file = 'top_banner';
if (!${$cache_file} = $this->cache->file->get($cache_file)) {
	ob_start();
	?>
	<div class="slider-main"><?php include("include/top_banner.php");?></div>
	<?php
	${$cache_file} = ob_get_clean();
	$this->cache->file->save($cache_file, ${$cache_file}, (60 * 60 * 60));
}
echo ${$cache_file};
?>

<div class="hide-mini-search">
	<?php include "news_ticker.php";?>
	<div id="wrapper-content" class="clearfix pop-dismiss">
		<div id="primary-content" class="page-wrap">
			<div class="container clearfix">
				<div class="page-inner">
					<article id="post-9" class="pro-jects pages post-9 page type-page status-publish hentry">
						<div class="entry-content clearfix">
							<div class="entry-content-inner clearfix">
								<?php echo $this->cms->get_block('index-ad-1');?>

								<div class="trnd_proj">
									<?php
									/*
									 * ---------------------------------------------------------------------------------------------------------
									 *  Cache
									 * ---------------------------------------------------------------------------------------------------------
									 */
									$cache_file = 'hot_projects';
									if (!${$cache_file} = $this->cache->file->get($cache_file)) {
										ob_start();
										?>
										<?php include("include/{$cache_file}.php");?>
										<?php
										${$cache_file} = ob_get_clean();
										$this->cache->file->save($cache_file, ${$cache_file}, (60 * 60 * 60));
									}
									echo ${$cache_file};
									?>
									<?php
									/*
									 * ---------------------------------------------------------------------------------------------------------
									 *  Cache
									 * ---------------------------------------------------------------------------------------------------------
									 */
									$cache_file = 'advertisement';
									if (!${$cache_file} = $this->cache->file->get($cache_file)) {
										ob_start();
										?>
										<div class="slider-main sj-ads"><?php include("include/{$cache_file}.php");?></div>
										<?php
										${$cache_file} = ob_get_clean();
										$this->cache->file->save($cache_file, ${$cache_file}, (60 * 60 * 60));
									}
									echo ${$cache_file};
									?>

								</div>
								<?php //include('include/buy_sell.php');?>

								<?php
								/*
								 * ---------------------------------------------------------------------------------------------------------
								 *  Cache
								 * ---------------------------------------------------------------------------------------------------------
								 */
								$cache_file = 'recent_properties';
								if (!${$cache_file} = $this->cache->file->get($cache_file)) {
									ob_start();
									?>
									<div class="-hot_proj"> <?php include("include/{$cache_file}.php");?></div>
									<?php
									${$cache_file} = ob_get_clean();
									$this->cache->file->save($cache_file, ${$cache_file}, (60 * 60 * 60));
								}
								echo ${$cache_file};
								?>

								<?php
								/*
								 * ---------------------------------------------------------------------------------------------------------
								 *  Cache
								 * ---------------------------------------------------------------------------------------------------------
								 */
								$cache_file = 'brand_logos';
								if (!${$cache_file} = $this->cache->file->get($cache_file)) {
									ob_start();
									?>
									<div class="brnd_logo"><?php include("include/{$cache_file}.php");?></div>
									<?php
									${$cache_file} = ob_get_clean();
									$this->cache->file->save($cache_file, ${$cache_file}, (60 * 60 * 60));
								}
								echo ${$cache_file};
								?>

								<?php
								/*
								 * ---------------------------------------------------------------------------------------------------------
								 *  Cache
								 * ---------------------------------------------------------------------------------------------------------
								 */
								$cache_file = 'popular_cities';
								if (!${$cache_file} = $this->cache->file->get($cache_file)) {
									ob_start();
									?>
									<div class="pop_cityproj"><?php include("{$cache_file}.php");?></div>
									<?php
									${$cache_file} = ob_get_clean();
									$this->cache->file->save($cache_file, ${$cache_file}, (60 * 60 * 60));
								}
								echo ${$cache_file};
								?>

								<?php
								/**
								 * Pages Content
								 */
								echo do_shortcode(stripslashes($page->content)); ?>

								<?php //include('include/our_services.php');?>
								<?php// include('include/agents.php');?>
								<?php// include('include/brand_logos.php');?>
							</div>
						</div>
					</article>
				</div>
			</div>
		</div>
	</div>
	<?php get_footer();?>
</div>
<?php include "popup_modal.php";?>
