<?php include __DIR__ . "/../includes/module_header.php"; ?>
    <!--begin::Form-->
    <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post"
          enctype="multipart/form-data"
          action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
        <input type="hidden" name="id" class="form-control" placeholder="ID">
        <div class="m-portlet__body">

            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required"><?php echo __('Activity Datetime'); ?></label>
                <div class="col-lg-6">
                    <input type="text" name="activity_datetime" id="activity_datetime" class="form-control datepicker"
                           placeholder="Activity Datetime" value="<?php echo($row->activity_datetime); ?>"/>

                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required"><?php echo __('Activity Name'); ?></label>
                <div class="col-lg-6">
                    <input type="text" name="activity_name" id="activity_name" class="form-control"
                           placeholder="Activity Name" value="<?php echo($row->activity_name); ?>"/>

                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required"><?php echo __('Table'); ?></label>
                <div class="col-lg-6">
                    <input type="text" name="table" id="table" class="form-control" placeholder="Table"
                           value="<?php echo($row->table); ?>"/>

                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label"><?php echo __('User ID'); ?></label>
                <div class="col-lg-6">
                    <select name="user_id" id="user_id" class="form-control m-select2">
                        <option value="">Select User ID</option>
                        <?php echo selectBox("SELECT id,username FROM users", ($row->user_id)); ?>
                    </select>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label"><?php echo __('Description'); ?></label>
                <div class="col-lg-10">
                    <textarea name="description" id="description" placeholder="Description" class="editor form-control"
                              cols="30" rows="10"><?php echo $row->description; ?></textarea>
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