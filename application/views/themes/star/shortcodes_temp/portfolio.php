<?php
$file_path = 'assets/front/portfolio/';
$_items = $this->db->order_by('ordering ASC, id ASC')->get_where('portfolio', array('status' => 'Active'))->result();
$items = $_items;
if(count($items) > 0){
    ?>
<div class="container-fluid">
    <div class="row margin-top-30">
        <div class="col-md-12 no-padding-left no-padding-right">

            <!-- Portfolio Wrap -->
            <div class="portfolio-wrap">
                <!-- Portfolio Filter -->
                <div id="filters-container" class="cbp-l-filters-text text-center pink-accent-color">
                    <div data-filter="*" class="cbp-filter-item-active cbp-filter-item">ALL</div>
                    <?php
                    $_filter = [];
                    foreach ($items as $item) {
                        $technology = explode(',', $item->technology);
                        foreach ($technology as $_tech) {
                            $_tech = trim($_tech);
                            $__tech = url_title($_tech, '-', true);
                            if(!in_array($__tech, $_filter)){
                                array_push($_filter, $__tech)
                                ?><div data-filter=".<?php echo $__tech?>" class="cbp-filter-item"><?php echo ucwords($_tech);?></div><?php
                            }
                        }
                    } ?>
                </div>

                <div id="portfolio-container" class="cbp" data-layoutmode="grid" data-gaphorizontal="10" data-gapvertical="10" data-captionanimation="fadeIn" data-animationtype="fadeOutTop" data-large-desktop="3" data-medium-desktop="3" data-tablet="2">
                    <?php foreach ($items as $item) {
                        $_technology = (str_replace([' '],[''],$item->technology));
                        $_technology = strtolower(str_replace(',',' ', $_technology));
                        ?>
                        <div class="cbp-item <?php echo $_technology;?>">
                            <a href="<?php echo base_url($file_path . $item->image); ?>" class="cbp-caption cbp-lightbox" data-title="<?php echo $item->title;?>">
                                <div class="cbp-caption-defaultWrap">
                                    <img src="<?php echo _img($file_path . $item->image, 414, 276); ?>" alt="<?php echo $item->title;?>">
                                </div>
                                <div class="cbp-caption-activeWrap dark-bg-color">
                                    <div class="cbp-l-caption-alignCenter">
                                        <div class="cbp-l-caption-body">
                                            <div class="cbp-l-caption-title font-size-14-500"><?php echo $item->title;?></div>
                                            <div class="cbp-l-caption-desc font-size-11-400"><?php echo $item->tag_line;?></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</div>
    <?php
}
?>