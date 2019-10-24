<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data"
      id="developer_log" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
        <?php
        $form_buttons = ['save', 'back'];
        include __DIR__ . "/../includes/module_header.php"; ?>

                <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">
        <div class="m-portlet__body">

        <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label"><?php echo __('Datetime');?>:</label>             <div class="col-lg-6">
                                                <input type="text" name="datetime" id="datetime" class="form-control" placeholder="Datetime" value="<?php echo ($row->datetime);?>"/>
                                            </div>
        </div>
        <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label"><?php echo __('Type');?>:</label>             <div class="col-lg-6">
                                                <input type="text" name="type" id="type" class="form-control" placeholder="Type" value="<?php echo ($row->type);?>"/>
                                            </div>
        </div>
    <div class="form-group m-form__group row">
        <label class="col-sm-2 control-label"><?php echo __('Description');?>:</label>
        <div class="col-lg-10">
                        <textarea name="description" id="description" placeholder="Description" class="editor form-control" cols="30" rows="10"><?php echo $row->description;?></textarea>
                                </div>
    </div>
            <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label"><?php echo __('Table');?>:</label>             <div class="col-lg-6">
                                                <input type="text" name="table" id="table" class="form-control" placeholder="Table" value="<?php echo ($row->table);?>"/>
                                            </div>
        </div>
        <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label"><?php echo __('Table ID');?>:</label>             <div class="col-lg-6">
                                                <input type="text" name="table_id" id="table_id" class="form-control" placeholder="Table ID" value="<?php echo ($row->table_id);?>"/>
                                            </div>
        </div>
        <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label"><?php echo __('User ID');?>:</label>             <div class="col-lg-6">
                                                <input type="text" name="user_id" id="user_id" class="form-control" placeholder="User ID" value="<?php echo ($row->user_id);?>"/>
                                            </div>
        </div>
        <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label"><?php echo __('User Ip');?>:</label>             <div class="col-lg-6">
                                                <input type="text" name="user_ip" id="user_ip" class="form-control" placeholder="User Ip" value="<?php echo ($row->user_ip);?>"/>
                                            </div>
        </div>
        <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label"><?php echo __('User Agent');?>:</label>             <div class="col-lg-6">
                                                <input type="text" name="user_agent" id="user_agent" class="form-control" placeholder="User Agent" value="<?php echo ($row->user_agent);?>"/>
                                            </div>
        </div>
        <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label"><?php echo __('Current URL');?>:</label>             <div class="col-lg-6">
                                                <input type="text" name="current_URL" id="current_URL" class="form-control" placeholder="Current URL" value="<?php echo ($row->current_URL);?>"/>
                                            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-sm-2 control-label"><?php echo __('Status');?>:</label>
                        <div class="col-lg-6">
                                                <select name="status" id="status" class="form-control m_selectpicker">
                    <option value="">Select Status</option>
                    <?php echo selectBox(get_enum_values('developer_log', 'status'), ($row->status));?>
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
    
    $( "form#developer_log" ).validate({
    // define validation rules
    rules: {
        },
    /*messages: {
        },*/
    //display error alert on form submit
    invalidHandler: function(event, validator) {
        /*var alert = $('#_msg');
        alert.removeClass('m--hide').show();
        mUtil.scrollTo(alert, -200);*/
        mUtil.scrollTo(validator.errorList[0].element, -200);
    },

    submitHandler: function(form) {
        form.submit();
    }

});
</script>