<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +92-332-3103324
 * S: developer.adnan
 */
?>
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" id="booking" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>

    <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">
    <div class="m-portlet__body">

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Property');?>:</label>
            <div class="col-lg-6">
                <select name="property_id" id="property_id" class="form-control m-select2">
                    <option value="">Select Property</option>
                    <?php echo selectBox("SELECT project_properties.id , project_properties.title FROM projects INNER JOIN project_properties ON (projects.id = project_properties.project_id)", ($row->property_id));?>
                </select>
            </div>

            <label class="col-lg-1 control-label"><?php echo __('Floor');?>:</label>
            <div class="col-lg-2">
                <input type="text" name="floor" id="floor" class="form-control m_touchspin" data-m_min="0" placeholder="<?php echo __('Floor');?>" value="<?php echo htmlentities($row->floor);?>" />
            </div>

        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Member');?>:</label>
            <div class="col-lg-6">
                <select name="member_id" id="member_id" class="form-control m-select2">
                    <option value="">Select Member</option>
                    <?php echo selectBox("SELECT id, email FROM users WHERE user_type_id=" . get_option('client_type_id'), ($row->member_id));?>
                </select>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('Booking Date');?>:</label>
            <div class="col-lg-6">
                <input type="text" name="booking_date" id="booking_date" class="form-control datepicker" placeholder="<?php echo __('Booking Date');?>" value="<?php echo htmlentities($row->booking_date);?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label">
                <?php echo __('Status');?>:</label>
            <div class="col-lg-6">
                <select name="status" id="status" class="form-control m_selectpicker">
                    <option value="">Select Status</option>
                    <?php echo selectBox(get_enum_values('booking', 'status'), ($row->status));?>
                </select>
            </div>
        </div>

    </div>

    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <input type="submit" class="btn btn-success m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit');?>">
                    <input type="button" next-url="<?php echo admin_url($this->_route . '/form');?>" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit & New');?>">
                    <button type="reset" class="btn btn-metal m-btn m-btn--icon m-btn--pill m-btn--air">
                        <?php echo __('Cancel');?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end::Form-->
<?php include __DIR__ . "/../includes/module_footer.php";?>
<script>
    $("form#booking").validate({
        // define validation rules
        rules: {
            'property_id': {
                required: true,
            },
            'member_id': {
                required: true,
            },
        },
        /*messages: {
        'property_id' : {required: 'Property is required',},'member_id' : {required: 'Member is required',},    },*/
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