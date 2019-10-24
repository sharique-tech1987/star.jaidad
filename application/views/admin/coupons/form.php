<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +92-332-3103324
 * S: developer.adnan
 */
?>
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" id="coupons" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>

    <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">
    <div class="m-portlet__body">

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Coupon Type');?>:</label>
            <div class="col-lg-6">
                <select name="coupon_type" id="coupon_type" class="form-control m_selectpicker">
                    <option value="">Select Coupon Type</option>
                    <?php echo selectBox(get_enum_values('coupons', 'coupon_type'), ($row->coupon_type));?>
                </select>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Coupon Name');?>:</label>
            <div class="col-lg-6">
                <input type="text" name="coupon_name" id="coupon_name" class="form-control" placeholder="<?php echo __('Coupon Name');?>" value="<?php echo htmlentities($row->coupon_name);?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Coupon Code');?>:</label>
            <div class="col-lg-6">
                <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="<?php echo __('Coupon Code');?>" value="<?php echo htmlentities($row->coupon_code);?>" />
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Discount');?>:</label>
            <div class="col-lg-6">
                <div class="input-group">
                    <input type="text" name="discount" id="discount" class="form-control" placeholder="<?php echo __('Discount');?>" value="<?php echo htmlentities($row->discount);?>" />
                    <div class="input-group-append">
                        <span class="input-group-text" style="padding: 0; background: white;width: 180px;">
                            <select name="discount_type" id="discount_type" class="form-control m_selectpicker">
                                <option value="">Select Discount Type</option>
                                <?php echo selectBox(get_enum_values('coupons', 'discount_type'), ($row->discount_type));?>
                            </select>
                        </span>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Total Amount');?>:</label>
            <div class="col-lg-6">
                <input type="text" name="total_amount" id="total_amount" class="form-control" placeholder="<?php echo __('Total Amount');?>" value="<?php echo htmlentities($row->total_amount);?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Start Date');?>:</label>
            <div class="col-lg-2">
                <input type="text" name="start_date" id="start_date" class="form-control m_datepicker" placeholder="<?php echo __('Start Date');?>" value="<?php echo htmlentities($row->start_date);?>" />
            </div>

            <label class="col-lg-2 control-label required"><?php echo __('End Date');?>:</label>
            <div class="col-lg-2">
                <input type="text" name="end_date" id="end_date" class="form-control m_datepicker" placeholder="<?php echo __('End Date');?>" value="<?php echo htmlentities($row->end_date);?>" />
            </div>
        </div>
        <!--<div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php /*echo __('Customer Type');*/?>:</label>
            <div class="col-lg-6">
                <select name="customer_type" id="customer_type" class="form-control">
                    <option value="">Select Customer Type</option>
                    <?php /*echo selectBox("SELECT * FROM user_types", ($row->customer_type));*/?>
                </select>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php /*echo __('Free Shipping');*/?>:</label>
            <div class="col-lg-6">
                <select name="free_shipping" id="free_shipping" class="form-control m_selectpicker">
                    <option value="">Select Free Shipping</option>
                    <?php /*echo selectBox(get_enum_values('coupons', 'free_shipping'), ($row->free_shipping));*/?>
                </select>
            </div>
        </div>-->
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Usage Policy');?>:</label>
            <div class="col-lg-2">
                <select name="usage_policy" id="usage_policy" class="form-control m_selectpicker">
                    <option value="">Select Usage Policy</option>
                    <?php echo selectBox(get_enum_values('coupons', 'usage_policy'), ($row->usage_policy));?>
                </select>
            </div>
            <label class="col-lg-2 control-label"><?php echo __('Usage Limit');?>:</label>
            <div class="col-lg-2">
                <input type="text" readonly disabled name="usage_limit" id="usage_limit" class="form-control" placeholder="<?php echo __('Usage Limit');?>" value="<?php echo htmlentities($row->usage_limit);?>" />
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
    $("form#coupons").validate({
        // define validation rules
        rules: {
            'coupon_type': {
                required: true,
            },
            'coupon_name': {
                required: true,
            },
            'coupon_code': {
                required: true,
            },
            'discount_type': {
                required: true,
            },
            'discount': {
                required: true,
            },
            'total_amount': {
                required: true,
            },
            'start_date': {
                required: true,
            },
            'end_date': {
                required: true,
            },
            'usage_policy': {
                required: true,
            },
        },
        /*messages: {
        'coupon_type' : {required: 'Coupon Type is required',},'coupon_name' : {required: 'Coupon Name is required',},'coupon_code' : {required: 'Coupon Code is required',},'discount_type' : {required: 'Discount Type is required',},'discount' : {required: 'Discount is required',},'total_amount' : {required: 'Total Amount is required',},'start_date' : {required: 'Start Date is required',},'end_date' : {required: 'End Date is required',},'usage_policy' : {required: 'Usage Policy is required',},    },*/
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