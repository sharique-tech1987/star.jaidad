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
      id="clients_logo" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
        <?php
        $form_buttons = ['save', 'back'];
        include __DIR__ . "/../includes/module_header.php"; ?>

                <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">
        <div class="m-portlet__body">

        <div class="form-group m-form__group row">
                        <label class="col-lg-2 control-label required"><?php echo __('Client Name');?>:</label>             <div class="col-lg-6">
                                                <input type="text" name="client_name" id="client_name" class="form-control" placeholder="<?php echo __('Client Name');?>" value="<?php echo htmlentities($row->client_name);?>" />
                                            </div>
        </div>
    <div class="form-group m-form__group row">
        <label class="col-lg-2 control-label"><?php echo __('Logo');?>:</label>
        <div class="col-lg-6">
            <input disabled type="hidden" name="logo--rm" value="<?php echo $row->logo;?>">
                        <label class="custom-file">
                <input type="file" name="logo" id="logo" class="form-control custom-file-input" placeholder="<?php echo __('Logo');?>" value="<?php echo ($row->logo);?>" />
                <span class="custom-file-label"></span>
            </label>
                                    <span class="m-form__help">"jpg, png, bmp, gif" file extension's</span>        </div>
        <?php
        if (!empty($row->logo)) {
            $thumb_url = asset_url("front/{$this->table}/" . $row->logo);
            $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/' . $row->id . '/logo');
            echo thumb_box($thumb_url, $delete_img_url);
        }
        ?>
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
    
    $( "form#clients_logo" ).validate({
    // define validation rules
    rules: {
            'client_name': {
            required: true,
        },
        },
    /*messages: {
    'client_name' : {required: 'Client Name is required',},    },*/
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