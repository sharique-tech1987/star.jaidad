<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +92-332-3103324
 * S: developer.adnan
 */
?>
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data"
      id="area" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
        <?php
        $form_buttons = ['save', 'back'];
        include __DIR__ . "/../includes/module_header.php"; ?>

        <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">
        <div class="m-portlet__body">

            <div class="form-group m-form__group row">
                <input type="hidden" name="country_code" value="PK">
                <label class="col-lg-2 control-label required"><?php echo __('City');?>:</label>
                <div class="col-lg-6">
                    <select name="city_id" id="city_id" class="form-control m-select2">
                        <option value="">Select City</option>
                        <?php echo selectBox("SELECT id, city FROM cities", ($row->city_id));?>
                    </select>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <label class="col-lg-2 control-label required"><?php echo __('Parent Area');?>:</label>
                <div class="col-lg-6">
                    <!--<input type="text" name="area_id" id="area_id" class="form-control" placeholder="<?php /*echo __('Area');*/?>" value="<?php /*echo htmlentities($row->area_id);*/?>" />-->
                    <select name="parent_id" id="parent_id" class="form-control m-select2-ajax" data-url="<?php echo site_url('property/ajax/search_area');?>" data-data_ele="#city_id">
                        <option value="">Select Area</option>
                        <?php echo selectBox("SELECT id, area FROM area WHERE city_id='{$row->city_id}' AND id='{$row->parent_id}'", ($row->parent_id));?>
                    </select>
                    <script>
                        $(document).ready(function () {
                            $(document).on('change', '#city_id', function (e) {
                                $('#parent_id').val(null).trigger('change');
                            });
                        });
                    </script>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <label class="col-lg-2 control-label required"><?php echo __('Area'); ?>:</label>
                <div class="col-lg-6">
                    <input type="text" name="area" id="area" class="form-control" placeholder="<?php echo __('Area'); ?>" value="<?php echo htmlentities($row->area); ?>"/>
                </div>
            </div>

        </div>

        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <input type="submit" class="btn btn-success m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit');?>">
                        <input type="button" next-url="<?php echo admin_url($this->_route . '/form');?>" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit & New');?>">
                        <button type="reset" class="btn btn-metal m-btn m-btn--icon m-btn--pill m-btn--air"><?php echo __('Cancel');?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
<?php include __DIR__ . "/../includes/module_footer.php";?>
<script>
    
    $( "form#area" ).validate({
    // define validation rules
    rules: {
            'area': {
            required: true,
        },
        },
    /*messages: {
    'area' : {required: 'Area is required',},    },*/
    //display error alert on form submit
    invalidHandler: function(event, validator) {
        validator.errorList[0].element.focus();

        /*var alert = $('#_msg');
        alert.removeClass('m--hide').show();
        mUtil.scrollTo(alert, -200);*/
        //mUtil.scrollTo(validator.errorList[0].element, -200);
    },

    submitHandler: function(form) {
        form.submit();
    }

});
</script>