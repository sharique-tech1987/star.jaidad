<?php
$_amenities = [];
if (count($amenities) > 0) {
    foreach ($amenities as $k => $amenity) {
        if(!empty($amenity->value)){
            $_amenities[$amenity->group_title][$k] = $amenity;
        }
    }


    foreach ($_amenities as $group_title => $_amenity) {
        if($group_title == 'Nearby Locations and Other Facilities') continue;
        if(count($_amenity) == 0) continue;
        echo '<h5 class="amenities-heading">'.$group_title.'</h5>';
        echo '<div class="list-style-one row">';
        foreach ($_amenity as $amenity) {
            if (!empty($amenity->value)) {
                ?>
                <div class="col-md-4 col-xs-6 col-mb-12 property-feature-wrap am-<?php echo $amenity->code; ?>">
                    <?php if(!empty($amenity->icon)) { ?>
                        &nbsp;<img src="<?php echo _img(asset_url('front/amenities/' . $amenity->icon), 28, 28);?>" alt="<?php echo $amenity->icon;?>" class="img-fluid">&nbsp;
                    <?php } else { ?>
                        <i class="fa fa-check-square-o" style="color: #000000"></i>
                    <?php } ?>

                    <?php echo $amenity->title; ?><?php if($amenity->input == 'Text'){echo ': ' . $amenity->value;} ?>
                </div>
                <?php
            }
        }
        echo '</div>';
    }
}
?>

