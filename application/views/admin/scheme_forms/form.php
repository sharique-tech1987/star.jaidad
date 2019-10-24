<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +92-332-3103324
 * S: developer.adnan
 */
?>
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" id="scheme_forms" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>

    <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id; ?>">
    <div class="m-portlet__body">

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Form Type'); ?>:</label>
            <div class="col-lg-6">
                <input type="text" name="form_type" id="form_type" class="form-control" placeholder="<?php echo __('Form Type'); ?>" value="<?php echo htmlentities($row->form_type); ?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Name'); ?>:</label>
            <div class="col-lg-6">
                <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo __('Name'); ?>" value="<?php echo htmlentities($row->name); ?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Father Name'); ?>:</label>
            <div class="col-lg-6">
                <input type="text" name="father_name" id="father_name" class="form-control" placeholder="<?php echo __('Father Name'); ?>" value="<?php echo htmlentities($row->father_name); ?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('CNIC'); ?>:</label>
            <div class="col-lg-6">
                <input type="text" name="cnic" id="cnic" class="form-control" placeholder="<?php echo __('CNIC'); ?>" value="<?php echo htmlentities($row->cnic); ?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Date of birth'); ?>:</label>
            <div class="col-lg-6">
                <input type="text" name="dob" id="dob" class="form-control" placeholder="<?php echo __('Date of birth'); ?>" value="<?php echo htmlentities($row->dob); ?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Address'); ?>:</label>
            <div class="col-lg-10">
                    <textarea name="address" id="address" class="form-control" placeholder="<?php echo __('Address'); ?>" cols="30" rows="5"><?php echo $row->address; ?></textarea>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Permanent Address'); ?>:</label>
            <div class="col-lg-10">
                <textarea name="permanent_address" id="permanent_address" class="form-control" placeholder="<?php echo __('Permanent Address'); ?>" cols="30" rows="5"><?php echo $row->permanent_address; ?></textarea>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Telephone'); ?>:</label>
            <div class="col-lg-6">
                <input type="text" name="telephone" id="telephone" class="form-control" placeholder="<?php echo __('Telephone'); ?>" value="<?php echo htmlentities($row->telephone); ?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Cell'); ?>:</label>
            <div class="col-lg-6">
                <input type="text" name="cell" id="cell" class="form-control" placeholder="<?php echo __('Cell'); ?>" value="<?php echo htmlentities($row->cell); ?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Email'); ?>:</label>
            <div class="col-lg-6">
                <input type="text" name="email" id="email" class="form-control" placeholder="<?php echo __('Email'); ?>" value="<?php echo htmlentities($row->email); ?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Cities'); ?>:</label>
            <div class="col-lg-6">
                <label class="m-checkbox m-checkbox--solid m-checkbox--brand form-control">
                    <input type="checkbox" value="1" name="cities" id="cities" value="<?php echo($row->cities); ?>">
                    <span></span>
                </label>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Property Type'); ?>:</label>
            <div class="col-lg-6">
                <label class="m-radio m-radio--solid m-radio--brand form-control">
                    <input type="radio" name="property_type" id="property_type" value="<?php echo($row->property_type); ?>" value="1" <?php echo _radiobox($row->property_type, 1); ?>>
                    <span></span>
                </label>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Area'); ?>:</label>
            <div class="col-lg-6">
                <label class="m-radio m-radio--solid m-radio--brand form-control">
                    <input type="radio" name="area" id="area" value="<?php echo($row->area); ?>" value="1" <?php echo _radiobox($row->area, 1); ?>>
                    <span></span>
                </label>
            </div>
        </div>

    </div>

    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <input type="submit" class="btn btn-success m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit'); ?>">
                    <input type="button" next-url="<?php echo admin_url($this->_route . '/form'); ?>" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit & New'); ?>">
                    <button type="reset" class="btn btn-metal m-btn m-btn--icon m-btn--pill m-btn--air">
                        <?php echo __('Cancel'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end::Form-->
<?php include __DIR__ . "/../includes/module_footer.php"; ?>
<script>
    $("form#scheme_forms").validate({
        // define validation rules
        rules: {
            'form_type': {
                required: true,
            },
            'name': {
                required: true,
            },
            'father_name': {
                required: true,
            },
            'cnic': {
                required: true,
            },
            'dob': {
                required: true,
            },
            'address': {
                required: true,
            },
            'permanent_address': {
                required: true,
            },
            'telephone': {
                required: true,
            },
            'cell': {
                required: true,
            },
            'email': {
                required: true,
                email: true,
            },
            'cities': {
                required: true,
                minlength: 1,
            },
            'property_type': {
                required: true,
            },
            'area': {
                required: true,
            },
        },
        messages: {
            'form_type': {
                required: 'Form Type is required',
            },
            'name': {
                required: 'Name is required',
            },
            'father_name': {
                required: 'Father Name is required',
            },
            'cnic': {
                required: 'CNIC is required',
            },
            'dob': {
                required: 'Date of birth is required',
            },
            'address': {
                required: 'Address is required',
            },
            'permanent_address': {
                required: 'Permanent Address is required',
            },
            'telephone': {
                required: 'Telephone is required',
            },
            'cell': {
                required: 'Cell is required',
            },
            'email': {
                required: 'Email is required',
                email: 'Email is not valid',
            },
            'cities': {
                required: 'Cities is required',
                minlength: 'Cities must be at least 1 character\'s',
            },
            'property_type': {
                required: 'Property Type is required',
            },
            'area': {
                required: 'Area is required',
            },
        },
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