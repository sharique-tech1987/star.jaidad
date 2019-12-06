<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +92-332-3103324
 * S: developer.adnan
 */
?>
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" id="properties" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>

    <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">
    <div class="m-portlet__body">

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Title');?>:</label>
            <div class="col-lg-10">
                <input type="text" name="title" id="title" class="form-control" placeholder="<?php echo __('Title');?>" value="<?php echo htmlentities($row->title);?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Purpose');?>:</label>
            <div class="col-lg-6">
                <select name="purpose" id="purpose" class="form-control m_selectpicker">
                    <option value="">Select Purpose</option>
                    <?php echo selectBox(get_enum_values('properties', 'purpose'), ($row->purpose));?>
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
        <!--<div class="form-group m-form__group row">
            <label class="col-lg-2 control-label">
                <?php /*echo __('Country');*/?>:</label>
            <div class="col-lg-6">
                <select name="country_code" id="country_code" class="form-control m-select2">
                    <option value="">Select Country</option>
                    <?php
/*                    $row->country_code = ($row->country_code == '' ? 'PK' : $row->country_code);
                    echo selectBox("SELECT countryCode, countryName FROM countries", ($row->country_code));*/?>
                </select>
            </div>
        </div>-->
        <div class="form-group m-form__group row">
            <input type="hidden" name="country_code" value="PK">
            <label class="col-lg-2 control-label required"><?php echo __('City');?>:</label>
            <div class="col-lg-6">
                <select name="city_id" id="city_id" class="form-control m-select2">
                    <option value="">Select City</option>
                    <?php echo selectBox("SELECT id, city FROM cities", ($row->city_id));?>
                </select>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Area');?>:</label>
            <div class="col-lg-6">
                <!--<input type="text" name="area_id" id="area_id" class="form-control" placeholder="<?php /*echo __('Area');*/?>" value="<?php /*echo htmlentities($row->area_id);*/?>" />-->
                <select name="area_id" id="area_id" class="form-control m-select2-ajax" data-url="<?php echo site_url('property/ajax/search_area');?>" data-data_ele="#city_id">
                    <option value="">Select Area</option>
                    <?php echo selectBox("SELECT id, area FROM area WHERE city_id='{$row->city_id}' AND id='{$row->area_id}'", ($row->area_id));?>
                </select>
                <script>
                    $(document).ready(function () {
                        $(document).on('change', '#city_id', function (e) {
                            $('#area_id').val(null).trigger('change');
                        });
                    });
                </script>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('New Area');?>:</label>
            <div class="col-lg-6">
                <input type="text" name="location" id="location" class="form-control" placeholder="<?php echo __('Location');?>" value="" />
                <div class="help-block color-dark" style="color: #ff4344;">Note: Type new area if not exist</div>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('Description');?>:</label>
            <div class="col-lg-10">
                <textarea name="description" id="description" placeholder="<?php echo __('Description');?>" class="-simple_editor form-control" cols="30" rows="5"><?php echo $row->description;?></textarea>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label">
                <?php echo __('Tags');?>
            </label>
            <div class="col-lg-10">
                <?php
                $tag_ids = singleColArray("SELECT tag_id FROM property_tags_rel WHERE property_id='{$row->id}'", 'tag_id');
                ?>
                <select name="tag_ids[]" id="tag_ids" class="form-control m_select2-tags" multiple>
                    <!--<select name="area_id" id="area_id" class="form-control m-select2" load-url="<?php /*echo site_url('property/ajax/city_area');*/?>">-->
                    <option value="">- Select -</option>
                    <?php //echo selectBox("SELECT id, type FROM  blog_tags", $tag_ids)?>
                    <?php echo selectBox("SELECT id, type FROM  property_tags", $tag_ids)?>
                </select>

            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Price');?>:</label>
            <div class="col-lg-6">
                <input type="text" name="price" id="price" class="form-control" placeholder="<?php echo __('Price');?>" value="<?php echo htmlentities($row->price);?>" />
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
        <!--<div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php /*echo __('Status');*/?>:</label>
            <div class="col-lg-6">
                <select name="status" id="status" class="form-control m_selectpicker">
                    <option value="">Select Status</option>
                    <?php /*echo selectBox(get_enum_values('properties', 'status'), ($row->status));*/?>
                </select>
            </div>
        </div>-->

        <div class="form-group m-form__group row">
            <label class="col-lg-12 text-left"><?php echo __('Amenities');?>:</label>
            <div class="col-lg-12">
                <div class="row ">
                <?php
                $ci =& get_instance();
                $ci->load->model(ADMIN_DIR . 'm_amenities');
                $amenities = $ci->m_amenities->amenities($row->id);
                //echo '<pre>'; print_r($amenities); echo '</pre>';
                if (count($amenities) > 0) {
                    foreach ($amenities as $amenity) {
                        ?>
                        <div class="col-lg-4">
                            <br>
                            <div class="input-group m-input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <!--<i style="font-size: 30px; color: black; padding-right: 10px;" class="<?php /*echo $amenity->icon;*/?>"></i>-->
                                        <img src="<?php echo _img(asset_url('front/amenities/' . $amenity->icon), 28, 28);?>" alt="<?php echo $amenity->icon;?>" class="img-fluid">&nbsp;
                                        <?php echo $amenity->title;?>
                                    </span>
                                </div>

                                <?php if($amenity->input == 'Text'){ ?>
                                    <input type="text" name="amenities[<?php echo $amenity->id;?>]" id="amenities" class="form-control" placeholder="<?php echo __($amenity->title);?>" value="<?php echo htmlentities($amenity->value);?>" />
                                <?php } else if($amenity->input == 'Yes / No'){ ?>
                                    <div> &nbsp;
                                        <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                                        <label>
                                            <input type="checkbox" name="amenities[<?php echo $amenity->id;?>]" id="show_on_menu" value="Yes" <?php echo _checkbox($amenity->value, 'Yes');?>/>
                                            <span></span>
                                        </label>
                                    </span> &nbsp;
                                    </div>
                                <?php } ?>

                                <?php if(!empty($amenity->icon)) { ?>
                                <!--<div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="icon-show"><i class="<?php /*echo $amenity->icon;*/?>"></i></span>
                                    </span>
                                </div>-->
                                <?php } ?>
                            </div>

                        </div>
                        <?php
                    }
                }
                ?>
                </div>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <?php
            if (count($files) > 0){
                foreach ($files as $k => $file) {
                    $thumb_file = _img(file_icon(asset_dir("front/{$this->table}/{$file->filename}"), true), 200, 200);
                    ?>
                    <div class="col-lg-2 img-row">
                        <div class="block">
                            <div class="thumbnail thumbnail-boxed">
                                <div class="thumb">
                                    <img src="<?php echo $thumb_file;?>" alt="<?php echo $file->title;?>" class="img-responsive">
                                    <div class="thumb-options">
                                        <span>
                                            <a rel="group" title="<?php echo $file->title;?>" href="<?php echo asset_url("front/{$this->table}/{$file->filename}");?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill lightbox"><i class="flaticon-visible"></i></a>
                                            <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" remove-el="parent.img-row" data-rm-name="files_remove[]" data-rm-value="<?php echo $file->id;?>"><i class="la la-trash"></i></a>
                                        </span>
                                    </div>
                                </div>
                                <div class="img-input-fields">
                                    <input type="hidden" class="form-control" name="files[]" value="<?php echo $file->filename;?>">

                                    <input type="hidden" class="form-control" name="files_data[id][]" value="<?php echo $file->id;?>">

                                    <label for="" class="badge badge-danger">Title:</label>
                                    <input type="text" placeholder="Title" class="form-control" name="files_data[title][]" value="<?php echo $file->title;?>">

                                    <label for="" class="badge badge-danger">Order:</label>
                                    <input type="text" placeholder="ordering" class="form-control" name="files_data[ordering][]" value="<?php echo $file->ordering;?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>

            <div class="col-sm-12">
                <div class="m-dropzone dropzone m-dropzone--success" action="<?php echo admin_url($this->_route . '/file_upload');?>" id="m-dropzone">
                    <div class="m-dropzone__msg dz-message needsclick">
                        <h3 class="m-dropzone__msg-title">Drop files here or click to upload.</h3>
                        <span class="m-dropzone__msg-desc">Only "jpg|jpeg|gif|png|bmp" files extension's are allowed for upload</span>
                    </div>
                </div>
            </div>
        </div>
        <script>
            Dropzone.options.mDropzone = {
                paramName: "file",
                //maxFiles:10,
                maxFilesize: 5, // MB
                addRemoveLinks: !0,
                acceptedFiles: ".jpg,.jpeg,.gif,.png,.bmp",
                /* Update: ./application/models/m_properties.php -> $config['allowed_types'] = 'gif|jpg|jpeg|png';*/
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
                        $('.dz-image', previewEl).append('<input type="hidden" name="files[]" value="' + json.result.filename + '">');
                        $('.dz-filename', previewEl).append('<input type="text" placeholder="title" class="form-control" name="files_data[title][]" value="' + json.result.title + '">');
                    }
                },
                accept: function(e, o) {
                    "justinbieber.jpg" == e.name ? o("Naha, you don't.") : o()
                }
            }
        </script>

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
    $("form#properties").validate({
        // define validation rules
        rules: {
            'title': {
                required: true,
            },
            'city_id': {
                required: true,
            },
            'area_id': {
                required: true,
            },
            'price': {
                required: true,
                number: true,
            },
            'area': {
                required: true,
            },
            'bedrooms': {
                required: true,
                digits: true,
            },
            'bathrooms': {
                digits: true,
            },
        },
        /*messages: {
        'title' : {required: 'Title is required',},'city_id' : {required: 'City is required',},'area_id' : {required: 'Area is required',},'price' : {required: 'Price is required',number: 'Price is valid numeric',},'area' : {required: 'Area is required',},'bedrooms' : {required: 'Bedrooms is required',integer: 'Bedrooms is valid integer',},'bathrooms' : {integer: 'Bathrooms is valid integer',},    },*/
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