<?php
if(count($rows) > 0) { ?>
    <div class="area-list">
        <div class="sec-title">
            <h2><?php
              if(!empty($attr['area'])){
                  //echo "{$attr['area']} Area List";
                  echo "Area List";
              } else if(!empty($attr['city'])){
                  //echo "{$attr['city']} Area List";
                  echo "Popular Area List";
              } else{
                  echo "Popular Area List";
              }
            ?></h2>
            <div class="t_line"></div>
            <div class="t_line2"></div>
        </div>
    <ul class="area_ul">
    <?php
    foreach ($rows as $row) {

        $__area = url_title($row->area, '_');
        $url = site_url('properties/' . url_title($row->city, '_') . "/{$__area}-{$row->id}");
        ?>
        <li class="col-md-3 area_li area-<?php echo $row->id;?>">
            <a title="<?php echo $row->area;?>" href="<?php echo $url;?>"><?php echo $row->area;?> (<?php echo number_format($row->total_properties);?>)</a>
        </li>
    <?php } ?>
    </ul>
        <p>&nbsp;</p>
    </div>
<?php } else { ?>
    <div style="margin-top: 50px;"></div>
<?php } ?>
