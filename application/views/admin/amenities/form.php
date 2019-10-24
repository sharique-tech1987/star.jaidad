<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +92-332-3103324
 * S: developer.adnan
 */
?>
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" id="amenities" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>

    <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">
    <div class="m-portlet__body">

        <div class="form-group m-form__group row">
            <div class="col-lg-6">
                <label class="control-label required"><?php echo __('Title');?>:</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="<?php echo __('Title');?>" value="<?php echo htmlentities($row->title);?>" />
            </div>
            <div class="col-lg-3">
                <label class="control-label required"><?php echo __('Code');?>:</label>
                <input type="text" name="code" id="code" class="form-control" placeholder="<?php echo __('Code');?>" value="<?php echo htmlentities($row->code);?>" />
            </div>
            <!--<div class="col-lg-3">
                <label class="control-label"><?php /*echo __('Icon');*/?>:</label>
                <div class="input-group m-input-group">
                    <input type="text" name="icon" id="icon" class="form-control icon-class" placeholder="<?php /*echo __('Icon');*/?>" value="<?php /*echo htmlentities($row->icon);*/?>" />
                    <div class="input-group-append">
                        <a class="input-group-text" data-toggle="modal" role="button"  data-toggle="modal" data-target="#icon_modal">
                            <span class="icon-show">Pick</span>
                        </a>
                    </div>
                </div>
            </div>-->

            <div class="col-lg-2">
                <label class="control-label"><?php echo __('Icon Image');?></label>
                <input disabled type="hidden" name="icon--rm" value="<?php echo $row->icon;?>">
                <label class="custom-file">
                    <input type="file" name="icon" id="icon" class="custom-file-input" placeholder="Image" value="<?php echo ($row->icon);?>" />
                    <span class="custom-file-label"></span>
                </label>
            </div>
            <?php
            if (!empty($row->icon)) {
                $thumb_url = asset_url("front/{$this->table}/" . $row->icon);
                $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/' . $row->id . '/icon');
                echo thumb_box($thumb_url, $delete_img_url, '', 1);
            }
            ?>

        </div>

        <div class="form-group m-form__group row">
            <div class="col-lg-6">
                <label class="control-label"><?php echo __('Group');?>:</label>
                <select name="group_id" id="group_id" class="form-control m-select2">
                    <option value="">Select Group</option>
                    <?php echo selectBox("SELECT id, title FROM amenities_groups", ($row->group_id));?>
                </select>
            </div>
            <div class="col-lg-3">
                <label class="control-label"><?php echo __('Input');?>:</label>
                <select name="input" id="input" class="form-control m_selectpicker">
                    <?php echo selectBox(get_enum_values($this->table, 'input'), ($row->input));?>
                </select>
            </div>
            <div class="col-lg-3">
                <label class="control-label"><?php echo __('For');?>:</label>
                <select name="for" id="for" class="form-control m_selectpicker">
                    <?php echo selectBox(get_enum_values($this->table, 'for'), ($row->for));?>
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
<?php include __DIR__ . "/../includes/icons.php";?>
<script>
    $("form#amenities").validate({
        // define validation rules
        rules: {
            'title': {
                required: true,
            },
            'code': {
                remote: '<?php echo admin_url($this->_route . '/AJAX/validate/' . $row->id)?>',
            },
        },
        /*messages: {
        'title' : {required: 'Title is required',},    },*/
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