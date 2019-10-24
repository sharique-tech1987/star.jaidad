<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +92-332-3103324
 * S: developer.adnan
 */
?>
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post"
      enctype="multipart/form-data"
      id="cities" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>

    <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id; ?>">
    <div class="m-portlet__body">

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Country'); ?>:</label>
            <div class="col-lg-6">
                <select name="country" id="country" class="m-select2">
                    <option value="">Select Country</option>
                    <?php echo selectBox("SELECT countryCode, countryName FROM countries", ($row->country)); ?>
                </select>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('City'); ?>:</label>
            <div class="col-lg-6">
                <input type="text" name="city" id="city" class="form-control" placeholder="<?php echo __('City'); ?>" value="<?php echo htmlentities($row->city); ?>"/>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Show Front'); ?>:</label>
            <div class="col-lg-6">
                <select name="show_front" id="show_front" class="form-control m_selectpicker">
                    <?php echo selectBox(get_enum_values($this->table, 'show_front'), ($row->show_front)); ?>
                </select>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-sm-2 control-label"><?php echo __('Image');?></label>
            <div class="col-lg-4">
                <input disabled type="hidden" name="image--rm" value="<?php echo $row->image;?>">
                <label class="custom-file">
                    <input type="file" name="image" id="image" class="custom-file-input" placeholder="Image" value="<?php echo ($row->image);?>" />
                    <span class="custom-file-label"></span>
                </label>
            </div>
            <?php
            if (!empty($row->image)) {
                $thumb_url = asset_url("front/{$this->table}/" . $row->image);
                $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/' . $row->id . '/image');
                echo thumb_box($thumb_url, $delete_img_url);
            }
            ?>
        </div>
    </div>

    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <input type="submit" class="btn btn-success m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit'); ?>">
                    <input type="button" next-url="<?php echo admin_url($this->_route . '/form'); ?>" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit & New'); ?>">
                    <button type="reset" class="btn btn-metal m-btn m-btn--icon m-btn--pill m-btn--air"><?php echo __('Cancel'); ?></button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end::Form-->
<?php include __DIR__ . "/../includes/module_footer.php"; ?>
<script>

    $("form#cities").validate({
        // define validation rules
        rules: {
            'country': {
                required: true,
            },
            'city': {
                required: true,
            },
        },
        /*messages: {
        'country' : {required: 'Country is required',},'city' : {required: 'City is required',},    },*/
        //display error alert on form submit
        invalidHandler: function (event, validator) {
            validator.errorList[0].element.focus();

            /*var alert = $('#_msg');
            alert.removeClass('m--hide').show();
            mUtil.scrollTo(alert, -200);*/
            //mUtil.scrollTo(validator.errorList[0].element, -200);
        },

        submitHandler: function (form) {
            form.submit();
        }

    });
</script>