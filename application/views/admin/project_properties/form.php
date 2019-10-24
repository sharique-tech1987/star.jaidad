<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +92-332-3103324
 * S: developer.adnan
 */
?>
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" id="project_properties" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>

    <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">
    <div class="m-portlet__body">

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required">
                <?php echo __('Project');?>:</label>
            <div class="col-lg-6">
                <select name="project_id" id="project_id" class="form-control m-select2">
                    <option value="">Select Project</option>
                    <?php echo selectBox("SELECT id, title FROM projects", ($row->project_id));?>
                </select>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Type');?>:</label>
            <div class="col-lg-6">
                <select name="type_id" id="type_id" class="form-control m_selectpicker">
                    <option value="">Select Type</option>
                    <?php
                    $this->multilevels->type = 'select';
                    $this->multilevels->id_Column = 'id';
                    $this->multilevels->title_Column = 'type';
                    $this->multilevels->link_Column = 'module';
                    $this->multilevels->type = 'select';
                    $this->multilevels->level_spacing = 7;
                    //$this->multilevels->spacing_str = '-';
                    $this->multilevels->selected = $row->type_id;
                    $this->multilevels->query = "SELECT * FROM `property_types` WHERE 1 ORDER BY ordering ASC";
                    echo $multiLevelComponents = $this->multilevels->build();
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Title');?>:</label>
            <div class="col-lg-6">
                <input type="text" name="title" id="title" class="form-control" placeholder="<?php echo __('Title');?>" value="<?php echo htmlentities($row->title);?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Area');?>:</label>
            <div class="col-lg-6">
                <div class="input-group">
                    <input type="text" name="area" id="area" class="form-control" placeholder="<?php echo __('Area');?>" value="<?php echo htmlentities($row->area);?>" />
                    <div class="input-group-append">
                        <span class="input-group-text" style="padding: 0; background: white;">
                            <select name="area_unit" id="area_unit" class="m_selectpicker">
                                <option value="">Select Area Unit</option>
                                <?php echo selectBox(get_enum_values('properties', 'area_unit'), ($row->area_unit)); ?>
                            </select>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label">
                <?php echo __('Price');?>:</label>
            <div class="col-lg-6">
                <input type="text" name="price" id="price" class="form-control" placeholder="<?php echo __('Price');?>" value="<?php echo htmlentities($row->price);?>" />
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Bedrooms');?>:</label>
            <div class="col-lg-2">
                <input type="text" name="bedrooms" id="bedrooms" class="form-control" placeholder="<?php echo __('Bedrooms');?>" value="<?php echo htmlentities($row->bedrooms);?>" />
            </div>

            <label class="col-lg-2 control-label">
                <?php echo __('Bathrooms');?>:</label>
            <div class="col-lg-2">
                <input type="text" name="bathrooms" id="bathrooms" class="form-control" placeholder="<?php echo __('Bathrooms');?>" value="<?php echo htmlentities($row->bathrooms);?>" />
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label">
                <?php echo __('Floor Plans');?>:</label>
            <div class="col-lg-10 ">
                <?php
                $files = json_decode($row->floor_plans);
                if (count($files) > 0){
                    echo '<div class="form-group m-form__group row sortable-ordering">';
                    foreach ($files as $k => $file) {
                        $file_dir = asset_dir("front/{$this->table}/{$file}");
                        $thumb_file = _img(file_icon($file_dir, true), 400, 400, IMG_NA, 'resize');//zoomCrop
                        ?>
                        <div class="col-lg-2 img-row sortable-row">
                            <div class="block">
                                <div class="thumbnail thumbnail-boxed">
                                    <div class="thumb">
                                        <img src="<?php echo $thumb_file;?>" alt=" <?php echo $file;?>" class="img-responsive">
                                        <div class="thumb-options">
                                            <span>
                                                <a rel="group" title="<?php echo $file;?>" href="<?php echo base_url($file_dir);?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent btn-outline-accent m-btn--icon m-btn--icon-only m-btn--pill lightbox"><i class="flaticon-visible"></i></a>
                                                <a href="#" class="btn m-btn m-btn--hover-danger btn-outline-danger m-btn--icon m-btn--icon-only m-btn--pill" remove-el="parent.img-row" data-rm-name="floor_plans_remove[]" data-rm-value="<?php echo $file;?>"><i class="la la-trash"></i></a>
                                                <a class="btn m-btn m-btn--hover-warning btn-outline-warning m-btn--icon m-btn--icon-only m-btn--pill sortable-move"><i class="la la-arrows"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="img-input-fields">
                                        <input type="hidden" class="form-control" name="floor_plans[]" value="<?php echo $file;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    echo '</div>';
                }
                ?>
                <div class="m-dropzone dropzone m-dropzone--success" action="<?php echo admin_url($this->_route . '/file_upload');?>" id="m-floor-plans-dropzone">
                    <div class="m-dropzone__msg dz-message needsclick">
                        <h3 class="m-dropzone__msg-title">Drop floor_plans here or click to upload.</h3>
                        <span class="m-dropzone__msg-desc">Only "gif|jpg|jpeg|png" files extension's are allowed for upload</span>
                    </div>
                </div>

                <script>
                    Dropzone.options.mFloorPlansDropzone = {
                        paramName: "file",
                        //maxFiles:10,
                        //maxFilesize: 10, // MB
                        addRemoveLinks: !0,
                        acceptedFiles: ".gif,.jpg,.jpeg,.png",
                        /* Update: ./application/models/m_project_properties.php  $config['allowed_types'] = 'gif|jpg|jpeg|png';*/
                        thumbnailWidth: 150,
                        thumbnailHeight: 150,
                        success: function(file, response) {
                            var json = JSON.parse(response);
                            console.log(json);
                            if (json.error) {
                                toastr.error(json.error.filename + '' + json.error.message);
                            } else {
                                var previewEl = file.previewElement;

                                $('.dz-image img', previewEl).attr('src', json.result.thumb_url);
                                var input = $('.dz-image', previewEl).append('<input type="hidden" name="floor_plans[]" value="' + json.result.filename + '">');
                                console.log(input);
                                //$('.dz-filename', previewEl).append('<input type="text" placeholder="title" class="form-control" name="files_data[title][]" value="' + json.result.title + '">');
                            }
                        },
                        accept: function(e, o) {
                            "justinbieber.jpg" == e.name ? o("Naha, you don't.") : o()
                        }
                    }
                </script>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('Payment Plan');?>:</label>
            <div class="col-lg-4">
                <input disabled type="hidden" name="payment_plan--rm" value="<?php echo $row->payment_plan;?>">

                <?php
                if (!empty($row->payment_plan)) {
                    $thumb_url = asset_dir("front/{$this->table}/" . $row->payment_plan);
                    $thumb_url = $thumb_file = _img(base_url(file_icon($thumb_url, true)), 200, 200);
                    $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/' . $row->id . '/payment_plan');
                }
                ?>
                <!-- <input type="file" name="payment_plan" id="payment_plan" class="dropify" data-default-file="<?php echo $thumb_url;?>" data-file_url="<?php echo $delete_img_url;?>" data-delete_url="<?php echo $delete_img_url;?>" data-allowed-file-extensions="jpg png bmp gif" /> -->

                <label class="custom-file">
                    <input type="file" name="payment_plan" id="payment_plan" class="form-control custom-file-input" placeholder="<?php echo __('Payment Plan');?>" value="<?php echo ($row->payment_plan);?>" />
                    <span class="custom-file-label"></span>
                </label>

                <span class="m-form__help">"jpg, png, bmp, gif" file extension's</span> </div>
            <?php
            if (!empty($row->payment_plan)) {
                $thumb_url = asset_url("front/{$this->table}/" . $row->payment_plan);
                $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/' . $row->id . '/payment_plan');
                echo thumb_box($thumb_url, $delete_img_url);
            }
            ?>
        </div>

        <?php include "payment_schedule_form.php";?>

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
    $("form#project_properties").validate({
        // define validation rules
        rules: {
            'project_id': {
                required: true,
            },
            'type': {
                required: true,
            },
            'area': {
                required: true,
            },
            'price': {
                number: true,
            },
        },
        /*messages: {
        'project_id' : {required: 'Project is required',},'type' : {required: 'Type is required',},'area' : {required: 'Area is required',},'price' : {decimal: 'Price is valid decimal',},    },*/
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