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
      id="income" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
        <?php
        $form_buttons = ['save', 'back'];
        include __DIR__ . "/../includes/module_header.php"; ?>

                <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">
        <input type="hidden" name="income_by" class="form-control m-select2" placeholder="Income By" value="<?php echo $row->income_by;?>">
        <input type="hidden" name="order_id" class="form-control m-select2" placeholder="Order" value="<?php echo $row->order_id;?>">
        <div class="m-portlet__body">

        <div class="form-group m-form__group row">
                        <label class="col-lg-2 control-label required"><?php echo __('Title');?>:</label>             <div class="col-lg-6">
                                                <input type="text" name="title" id="title" class="form-control" placeholder="<?php echo __('Title');?>" value="<?php echo htmlentities($row->title);?>" />
                                            </div>
        </div>
        <div class="form-group m-form__group row">
                        <label class="col-lg-2 control-label"><?php echo __('Income Head');?>:</label>             <div class="col-lg-6">
                                                <input type="text" name="income_head" id="income_head" class="form-control" placeholder="<?php echo __('Income Head');?>" value="<?php echo htmlentities($row->income_head);?>" />
                                            </div>
        </div>
        <div class="form-group m-form__group row">
                        <label class="col-lg-2 control-label"><?php echo __('Date');?>:</label>             <div class="col-lg-6">
                                                <input type="text" name="date" id="date" class="form-control datepicker" placeholder="<?php echo __('Date');?>" value="<?php echo htmlentities($row->date);?>" />
                                            </div>
        </div>
        <div class="form-group m-form__group row">
                        <label class="col-lg-2 control-label required"><?php echo __('Amount');?>:</label>             <div class="col-lg-6">
                                <div class="input-group">                <input type="text" name="amount" id="amount" class="form-control" placeholder="<?php echo __('Amount');?>" value="<?php echo htmlentities($row->amount);?>" />
                <div class="input-group-append"><span class="input-group-text">PKR</span></div></div>                            </div>
        </div>
        <div class="form-group m-form__group row">
                        <label class="col-lg-2 control-label"><?php echo __('USD Rate');?>:</label>             <div class="col-lg-6">
                                                <input type="text" name="usd_rate" id="usd_rate" class="form-control" placeholder="<?php echo __('USD Rate');?>" value="<?php echo htmlentities($row->usd_rate);?>" />
                                            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('Cheque Status');?>:</label>
                        <div class="col-lg-6">
                                                <select name="cheque_status" id="cheque_status" class="form-control m_selectpicker" >
                    <option value="">Select Cheque Status</option>
                    <?php echo selectBox(get_enum_values('income', 'cheque_status'), ($row->cheque_status));?>
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
                        <button type="reset" class="btn btn-metal m-btn m-btn--icon m-btn--pill m-btn--air"><?php echo __('Cancel');?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
<?php include __DIR__ . "/../includes/module_footer.php";?>
<script>
    
    $( "form#income" ).validate({
    // define validation rules
    rules: {
            'title': {
            required: true,
        },
            'amount': {
            required: true,
        },
        },
    /*messages: {
    'title' : {required: 'Title is required',},'amount' : {required: 'Amount is required',},    },*/
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