<?php
$sale_price =  json_decode(get_option('sale_price'));
$rent_price =  json_decode(get_option('rent_price'));
if(count($sale_price) == 0){
    $sale_price[] = null;
}
if(count($rent_price) == 0){
    $rent_price[] = null;
}
?>
<div class="tab-pane fade" id="price-setting">

    <div class="sale-repeater">
        <div class="panel-heading border-bottom">
            <h6 class="panel-title" style="display: inline;"><i class="icon-map2"></i>Sale Price Breakup</h6>
            <div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide pull-right">
                <span>
                    <i class="la la-plus"></i>
                    <span>Add</span>
                </span>
            </div>
        </div>
        <br>

        <div class="form-group m-form__group row" data-repeater-list="setting[sale_price]">
            <?php
            foreach ($sale_price as $n => $item) {
                ?>
                <div class="col-sm-2" data-repeater-item>
                    <input type="text" name="" class="form-control" value="<?php echo $item;?>">
                    <br>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <div class="rent-repeater">
        <div class="panel-heading border-bottom">
            <h6 class="panel-title" style="display: inline;"><i class="icon-map2"></i>Rent Price Breakup</h6>
            <div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide pull-right">
                <span>
                    <i class="la la-plus"></i>
                    <span>Add</span>
                </span>
            </div>
        </div>
        <br>

        <div class="form-group m-form__group row" data-repeater-list="setting[rent_price]">
            <?php
            foreach ($rent_price as $n => $item) {
                ?>
                <div class="col-sm-2" data-repeater-item>
                    <input type="text" name="" class="form-control" value="<?php echo $item;?>">
                    <br>
                </div>
                <?php
            }
            ?>
        </div>
    </div>



    <hr class="sm">
    <div class="panel-heading border-bottom">
        <h6 class="panel-title"><i class="icon-flag3"></i>Area Breakup's</h6>
    </div>
    <br>

    <div class="row">

    <?php
    $area_units = get_enum_values('properties', 'area_unit');
    foreach ($area_units as $area_unit) {
        $short_name_unit = url_title($area_unit, '_');

        $unit_breakup =  json_decode(get_option($short_name_unit . '_unit'));
        if(count($unit_breakup) == 0){
            $unit_breakup[] = null;
        }
        ?>
        <div class="col-lg-2">
            <div class="<?php echo $short_name_unit;?>-unit-repeater">
                <div class="panel-heading border-bottom">
                    <h6 class="panel-title" style="display: inline;"><i class="icon-map2"></i><?php echo $area_unit;?></h6>
                    <div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide pull-right">
                    <span>
                        <i class="la la-plus"></i>
                        <span>Add</span>
                    </span>
                    </div>
                </div>
                <br>

                <div class="form-group m-form__group row" data-repeater-list="setting[<?php echo $short_name_unit;?>_unit]">
                    <?php
                    foreach ($unit_breakup as $n => $item) {
                        ?>
                        <div class="col-sm-12" data-repeater-item>
                            <input type="text" name="" class="form-control" value="<?php echo $item;?>">
                            <br>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.<?php echo $short_name_unit;?>-unit-repeater').repeater({
                    show: function () {
                        $(this).slideDown();
                        $('.<?php echo $short_name_unit;?>-unit-repeater').find('input').prop('name', 'setting[<?php echo $short_name_unit;?>_unit][]');
                    },
                    hide: function (deleteElement) {
                        if(confirm('Are you sure you want to delete this element?')) {
                            $(this).slideUp(deleteElement);
                        }
                    }
                });

                $('.<?php echo $short_name_unit;?>-unit-repeater').find('input').prop('name', 'setting[<?php echo $short_name_unit;?>_unit][]');
            });
        </script>
        <?php
    }
    ?>

    </div>
</div>

<script>
    $(document).ready(function () {
        $('.sale-repeater').repeater({
            //initEmpty: true,
            show: function () {
                $(this).slideDown();
                $('.sale-repeater').find('input').prop('name', 'setting[sale_price][]');
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });
        $('.sale-repeater').find('input').prop('name', 'setting[sale_price][]');

        $('.rent-repeater').repeater({
            show: function () {
                $(this).slideDown();
                $('.rent-repeater').find('input').prop('name', 'setting[rent_price][]');
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });
        $('.rent-repeater').find('input').prop('name', 'setting[rent_price][]');
    });
</script>