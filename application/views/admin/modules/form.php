<!--begin::Form-->
<style>
    .icon-show i{
        font-size: 6rem;
    }
</style>
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data"
      id="modules" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>

    <div class="m-portlet__body">

        <div class="form-group m-form__group row">
            <label class="col-sm-2 control-label required"><?php echo __('Parent Module');?></label>

            <div class="col-lg-6">
                <select name="parent_id" id="parent_id" class="form-control m-select2">
                    <option value="0" <?= ($row->parent_id == '') ? 'selected' : ''; ?>>/</option>
                    <?php
                    $this->multilevels->type = 'select';
                    $this->multilevels->id_Column = 'id';
                    $this->multilevels->title_Column = 'module_title';
                    $this->multilevels->link_Column = 'module';
                    $this->multilevels->type = 'select';
                    $this->multilevels->option_html = '<option {selected} value="{id}" data--icon="{icon}">{level}{module_title}</option>';
                    $this->multilevels->level_spacing = 6;
                    //$this->multilevels->spacing_str = '-';
                    $this->multilevels->selected = $row->parent_id;
                    $this->multilevels->query = "SELECT * FROM `modules` WHERE `status`='1' ORDER BY ordering ASC";
                    echo $multiLevelComponents = $this->multilevels->build();
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-lg-2 col-form-label required"><?php echo __('Module');?></label>

            <div class="col-lg-6">
                <input type="text" class="form-control m-input" name="module" id="module" value="<?= $row->module; ?>"/>
                <span class="m-form__help">Please enter your DB module name</span>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-lg-2 col-form-label required"><?php echo __('Module Title');?></label>

            <div class="col-lg-6">
                <input type="text" class="form-control m-input" name="module_title" id="module_title" value="<?= $row->module_title; ?>"/>
                <span class="m-form__help">Please enter your DB module title</span>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 col-form-label required"><?php echo __('Icon');?></label>

            <div class="col-sm-4">
                <label class="custom-file">
                    <input type="file" name="icon" id="icon" class="custom-file-input" value="<?= $row->icon; ?>"/>
                    <lable class="custom-file-label"></lable>
                </label>
                <input type="hidden" name="icon_class" id="icon_class" class="icon-class" value="<?= $row->icon; ?>"/>
            </div>
           <!-- <div class="col-sm-2">
                <a class="btn btn-warning change-icon m-btn--pill m-btn--air" data-toggle="modal" role="button"  data-toggle="modal" data-target="#icon_modal"><i class="la la-image"></i> Icon</a>
            </div>-->
            <?php
            if (!empty($row->icon)) {
                $thumb_url = asset_url("uploads/icons/" . $row->icon, true);
                $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/' . $row->id . '/icon');
                echo thumb_box($thumb_url, $delete_img_url);
            }
            ?>
            <div class="col-sm-2">
                <div class="icon-show" style="display: inline-block;"></div>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 col-form-label required"><?php echo __('Ordering');?></label>

            <div class="col-sm-2">
                <input type="text" class="form-control m-input" name="ordering" id="ordering" value="<?= $row->ordering; ?>"/>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-lg-2 col-form-label"><?php echo __('Show on menu');?></label>

            <div class="col-lg-6">
                <div>
                    <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                        <label>
                            <input type="checkbox" name="show_on_menu" id="show_on_menu" value="1" <?php echo _checkbox($row->show_on_menu, 1);?>/>
                            <span></span>
                        </label>
                    </span>
                </div>
                <span class="m-form__help"><?php echo __('Please tick the checkbox for showing in menu');?></span>
            </div>
        </div>


        <div class="form-group m-form__group row">
            <label class="col-lg-2 col-form-label"><?php echo __('Module Actions');?></label>

            <div class="col-lg-10">
                <input type="text" class="form-control m-input" name="actions" id="actions" value="<?= $row->actions; ?>"/>
            </div>
        </div>

    </div>

    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <input type="submit" class="btn btn-success m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit');?>">
                    <input type="submit" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit & New');?>">
                    <button type="reset" class="btn btn-metal m-btn m-btn--icon m-btn--pill m-btn--air"><?php echo __('Cancel');?></button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end::Form-->
<?php include __DIR__ . "/../includes/module_footer.php";?>
<?php /*include __DIR__ . "/../includes/icons.php";*/?>
<script>

    $("#modules").validate({
        // define validation rules
        rules: {
            'module': {
                required: true,
            },
            'parent_id': {
                required: true,
            },
            'module_title': {
                required: true,
            },
            'ordering': {
                required: true,
            },
        },
        /*messages: {
        'module' : {required: 'Module is required',},'parent_id' : {required: 'Parent ID is required',},'module_title' : {required: 'Module Title is required',},'ordering' : {required: 'Ordering is required',},    },*/
        //display error alert on form submit
        invalidHandler: function (event, validator) {
            validator.errorList[0].element.focus();
            /*var alert = $('#_msg');
            alert.removeClass('m--hide').show();
            mApp.scrollTo(alert, -200);*/
            //mUtil.scrollTo(validator.errorList[0].element, -200);
        },

        submitHandler: function (form) {
            form.submit();
        }

    });
</script>
