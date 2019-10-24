<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>

        <div class="m-portlet__body">

            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label">
                    <?php echo __('Image');?>
                </label>
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
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required"><?php echo __('Title');?></label>
                <div class="col-lg-6">
                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="<?php echo ($row->title);?>" />
                </div>
            </div>
            <style>
                button[data-id="type"]{width: 120px !important;}
            </style>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label"><?php echo __('Banner Type');?></label>
                <div class="col-lg-10">
                    <div class="input-group">
                        <div class="input-group-append">
                        <span class="input-group-text" style="padding: 0; background: none; border: none; width: 100%">
                            <select name="type" id="type" class="form-control m_selectpicker" load-select="#rel_id">
                                <?php echo selectBox(get_enum_values($this->table, 'type'), ($row->type));?>
                            </select>
                        </span>
                        </div>

                        <select name="rel_id" id="rel_id" class="form-control m-select2" style="width: 80%;" load-url="<?php echo admin_url('profile/AJAX/properties_projects');?>">
                            <option value="">Select Property</option>
                            <?php echo selectBox("SELECT id, title FROM properties", ($row->rel_id));?>
                        </select>
                    </div>
                </div>

            </div>

            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label"><?php echo __('Link');?></label>
                <div class="col-lg-6">
                    <input type="text" name="link" id="link" class="form-control" placeholder="Link" value="<?php echo ($row->link);?>" />
                </div>
            </div>
            <!--<div class="form-group m-form__group row">
                <label class="col-sm-2 control-label"> <?php /*echo __('Description');*/?> </label>
                <div class="col-lg-10">
                    <textarea name="description" id="description" class="form-control" placeholder="Description" cols="30" rows="10"><?php /*echo $row->description;*/?></textarea>
                </div>
            </div>-->
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label">
                    <?php echo __('Ordering');?>
                </label>
                <div class="col-lg-2">
                    <input type="text" name="ordering" id="ordering" class="form-control" placeholder="Ordering" value="<?php echo ($row->ordering);?>" />
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
    $("form").validate({
        // define validation rules
        rules: {
            'title': {
                required: true,
            },
        },
        /*messages: {
        'title' : {required: 'Title is required',},    },*/
        //display error alert on form submit
        invalidHandler: function(event, validator) {
            validator.errorList[0].element.focus();
        },

        submitHandler: function(form) {
            form.submit();
        }
    });

    $(document).on('change', '#type', function (e) {
        e.preventDefault();
        var _this = $(this);
        if($.inArray(_this.val(), ['Static', 'Popup']) === -1){
            $('#link').closest('.form-group').hide();
            $('.select2-container').show();
        }else {
            $('#link').closest('.form-group').show();
            $('.select2-container').hide();
        }
    });
    setTimeout(function () {
        $('#type').trigger('change');
    }, 1000)
</script>
