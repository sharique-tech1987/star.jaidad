<article id="post-<?php echo $row->id?>" class="post-large-image clearfix post-<?php echo $row->id?> post type-post status-publish format-standard has-post-thumbnail hentry category-apartment category-real-estates tag-apartment tag-villa">
    <?php
        $url = site_url("blog/" . friendly_url($row->title,'-',true,$row->id));
    ?>
    <div class="entry-content-wrap clearfix">
        <div class="entry-thumb-wrap">
            <div class="entry-thumbnail">
                <a href="#" title="We are Offering the Best Real Estate Deals" class="entry-thumbnail-overlay">
                    <img src="http://themes.g5plus.net/benaa/wp-content/uploads/2018/01/properties-1.jpg" alt="We are Offering the Best Real Estate Deals" class="img-responsive"> </a>
                <a data-thumb-src="http://themes.g5plus.net/benaa/wp-content/uploads/2018/01/properties-1-340x340.jpg" data-gallery-id="1701687358" data-rel="lightGallery" href="http://themes.g5plus.net/benaa/wp-content/uploads/2018/01/properties-1.jpg" class="zoomGallery">
                    <i class="fa fa-expand"></i>
                </a>
            </div>
        </div>
        <div class="entry-post-meta">
            <div class="entry-meta-author">
                <span>By </span><a href="#">admin</a>
            </div>
            <div class="entry-meta-date">
                <?php
                    $post_created = strtotime($row->created);
                ?>
                <a href="#"><?php echo date('F d,  Y',$post_created); ?></a>
            </div>
        </div>
        <div class="entry-content-inner">
            <div class="entry-info-post clearfix">
                <h4 class="entry-post-title">
                    <a title="<?php echo $row->title ?>" href="<?php echo $url; ?>"><?php echo $row->title ?></a></h4>
                <div class="entry-excerpt">
                    <?php
                    $final_except = '';
                    if(empty($row->excerpt)){
                        $description_without_tags = strip_tags($row->description);
                        $final_except = substr($description_without_tags, 0, 200);
                    }else{
                        $final_except = $row->excerpt;
                    }
                    // Print Final Except
                    echo $final_except;
                    ?>
                </div>
            </div>
        </div>
    </div>
</article>