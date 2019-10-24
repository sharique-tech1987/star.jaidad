<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +92-332-3103324
 * S: developer.adnan
 */
?>
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" id="projects" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
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
            <label class="col-lg-2 control-label"><?php echo __('Logo');?>:</label>
            <div class="col-lg-6">
                <input disabled type="hidden" name="logo--rm" value="<?php echo $row->logo;?>">
                <label class="custom-file">
                    <input type="file" name="logo" id="logo" class="form-control custom-file-input" placeholder="<?php echo __('Logo');?>" value="<?php echo ($row->logo);?>" />
                    <span class="custom-file-label"></span>
                </label>
                <span class="m-form__help">"jpg, png, bmp, gif" file extension's</span> </div>
            <?php
            if (!empty($row->logo)) {
                $thumb_url = asset_url("front/{$this->table}/" . $row->logo);
                $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/' . $row->id . '/logo');
                echo thumb_box($thumb_url, $delete_img_url);
            }
            ?>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label">
                <?php echo __('Country');?>:</label>
            <div class="col-lg-6">
                <select name="country" id="country" class="form-control m-select2">
                    <option value="">Select Country</option>
                    <?php
                    $row->country_code = ($row->country_code == '' ? 'PK' : $row->country_code);
                    echo selectBox("SELECT countryCode, countryName FROM countries", ($row->country_code));?>
                </select>
            </div>
        </div>
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
        <!--<div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php /*echo __('Short Description');*/?>:</label>
            <div class="col-lg-10">
                <textarea name="short_description" id="short_description" placeholder="<?php /*echo __('Short Description');*/?>" class="simple_editor form-control" cols="30" rows="5"><?php /*echo $row->short_description;*/?></textarea>
            </div>
        </div>-->
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('Description');?>:</label>
            <div class="col-lg-10">
                <textarea name="description" id="description" placeholder="<?php echo __('Description');?>" class="simple_editor form-control" cols="30" rows="5"><?php echo $row->description;?></textarea>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('Price');?>:</label>
            <div class="col-lg-6">
                <div class="input-group">
                    <input type="text" name="price_from" id="price_from" class="form-control" placeholder="<?php echo __('Price From');?>" value="<?php echo htmlentities($row->price_from);?>" />
                    <div class="input-group-append"><span class="input-group-text">-</span></div>
                    <input type="text" name="price_to" id="price_to" class="form-control" placeholder="<?php echo __('Price To');?>" value="<?php echo htmlentities($row->price_to);?>" />
                </div>
            </div>
        </div>
        <!--<div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php /*echo __('Price To');*/?>:</label>
            <div class="col-lg-6">
                <div class="input-group">
                    <input type="text" name="price_to" id="price_to" class="form-control" placeholder="<?php /*echo __('Price To');*/?>" value="<?php /*echo htmlentities($row->price_to);*/?>" />
                    <div class="input-group-append"><span class="input-group-text">PKR</span></div>
                </div>
            </div>
        </div>-->
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('Developer');?>:</label>
            <div class="col-lg-6">
                <select name="developer_id" id="developer_id" class="form-control">
                    <option value="">Select Developer</option>
                    <?php echo selectBox("SELECT id, first_name FROM users", ($row->developer_id));?>
                </select>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-lg-12 text-left"><?php echo __('Amenities');?>:</label>
            <div class="col-lg-12">
                <div class="row ">
                    <?php
                    $ci =& get_instance();
                    $ci->load->model(ADMIN_DIR . 'm_amenities');
                    $amenities = $ci->m_amenities->amenities($row->id, '', 'Project');
                    //echo '<pre>'; print_r($amenities); echo '</pre>';

                    if (count($amenities) > 0) {
                        foreach ($amenities as $amenity) {
                            ?>
                            <div class="col-lg-4">
                                <br>
                                <div class="input-group m-input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <?php if(!empty($amenity->icon)) { ?>
                                                <img src="<?php echo _img(asset_url('front/amenities/' . $amenity->icon), 28, 28);?>" alt="<?php echo $amenity->icon;?>" class="img-fluid">&nbsp;
                                            <?php } else { ?>
                                                <i style="font-size: 30px; color: black; padding-right: 10px;" class=""></i>
                                            <?php } ?>
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
            <label class="col-lg-2 control-label"><?php echo __('Project Floor Plans');?>:</label>
            <div class="col-lg-10">

                <?php
                $floor_plans_files = json_decode($row->floor_plans);
                if (count($floor_plans_files) > 0){
                    echo '<div class="form-group m-form__group row">';
                    foreach ($floor_plans_files as $k => $file) {
                        $file_dir = asset_dir("front/{$this->table}/{$file}");
                        //$thumb_file = _img(file_icon($file_dir, true), 400, 400);
                        $image = file_icon($file_dir, true);
                        $thumb_file = base_url(_Image::open($image)->zoomCrop(200, 200));
                        ?>
                        <div class="col-lg-2 img-row">
                            <div class="block">
                                <div class="thumbnail thumbnail-boxed">
                                    <div class="thumb">
                                        <img src="<?php echo $thumb_file;?>" alt=" <?php echo $file;?>" class="img-responsive">
                                        <div class="thumb-options">
                                                <span>
                                        <a rel="group" title="<?php echo $file;?>" href="<?php echo base_url($file_dir);?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill lightbox"><i class="flaticon-visible"></i></a>
                                        <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" remove-el="parent.img-row" data-rm-name="floor_plans_remove[]" data-rm-value="<?php echo $file;?>"><i class="la la-trash"></i></a>
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
                        <h3 class="m-dropzone__msg-title">Drop floor plans here or click to upload.</h3>
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
                        /* Update: ./application/models/m_projects.php  $config['allowed_types'] = 'gif|jpg|jpeg|png';*/
                        thumbnailWidth: 150,
                        thumbnailHeight: 150,
                        success: function(file, response) {
                            var json = JSON.parse(response);
                            //console.log(json);
                            if (json.error) {
                                toastr.error(json.error.filename + '' + json.error.message);
                            } else {
                                var previewEl = file.previewElement;

                                $('.dz-image img', previewEl).attr('src', json.result.thumb_url);
                                $('.dz-image', previewEl).append('<input type="hidden" name="floor_plans[]" value="' + json.result.filename + '">');
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

        <?php /*
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('Payment Plans');?>:</label>
            <div class="col-lg-10">

                <?php
                $payment_plans_files = json_decode($row->payment_plans);
                if (count($payment_plans_files) > 0){
                    echo '<div class="form-group m-form__group row">';
                    foreach ($payment_plans_files as $k => $file) {
                        $file_dir = asset_dir("front/{$this->table}/{$file}");
                        //$thumb_file = _img(file_icon($file_dir, true), 400, 400);
                        $image = file_icon($file_dir, true);
                        $thumb_file = base_url(_Image::open($image)->zoomCrop(200, 200));
                        ?>
                        <div class="col-lg-2 img-row">
                            <div class="block">
                                <div class="thumbnail thumbnail-boxed">
                                    <div class="thumb">
                                        <img src="<?php echo $thumb_file;?>" alt=" <?php echo $file;?>" class="img-responsive">
                                        <div class="thumb-options">
                                                <span>
                                        <a rel="group" title="<?php echo $file;?>" href="<?php echo base_url($file_dir);?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill lightbox"><i class="flaticon-visible"></i></a>
                                        <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" remove-el="parent.img-row" data-rm-name="payment_plans_remove[]" data-rm-value="<?php echo $file;?>"><i class="la la-trash"></i></a>
                                    </span>
                                        </div>
                                    </div>
                                    <div class="img-input-fields">
                                        <input type="hidden" class="form-control" name="payment_plans[]" value="<?php echo $file;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    echo '</div>';
                }
                ?>
                <div class="m-dropzone dropzone m-dropzone--success" action="<?php echo admin_url($this->_route . '/file_upload');?>" id="m-payment-plans-dropzone">
                    <div class="m-dropzone__msg dz-message needsclick">
                        <h3 class="m-dropzone__msg-title">Drop floor plans here or click to upload.</h3>
                        <span class="m-dropzone__msg-desc">Only "gif|jpg|jpeg|png" files extension's are allowed for upload</span>
                    </div>
                </div>

                <script>
                    Dropzone.options.mPaymentPlansDropzone = {
                        paramName: "file",
                        //maxFiles:10,
                        //maxFilesize: 10, // MB
                        addRemoveLinks: !0,
                        acceptedFiles: ".gif,.jpg,.jpeg,.png",
                        thumbnailWidth: 150,
                        thumbnailHeight: 150,
                        success: function(file, response) {
                            var json = JSON.parse(response);
                            //console.log(json);
                            if (json.error) {
                                toastr.error(json.error.filename + '' + json.error.message);
                            } else {
                                var previewEl = file.previewElement;

                                $('.dz-image img', previewEl).attr('src', json.result.thumb_url);
                                $('.dz-image', previewEl).append('<input type="hidden" name="payment_plans[]" value="' + json.result.filename + '">');
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
        */?>

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('Project Map');?>:</label>
            <div class="col-lg-10">

                <?php
                $project_map_files = json_decode($row->project_map);
                if (count($project_map_files) > 0){
                    echo '<div class="form-group m-form__group row">';
                    foreach ($project_map_files as $k => $file) {
                        $file_dir = asset_dir("front/{$this->table}/{$file}");
                        //$thumb_file = _img(file_icon($file_dir, true), 400, 400);
                        $image = file_icon($file_dir, true);
                        $thumb_file = base_url(_Image::open($image)->zoomCrop(200, 200));
                        ?>
                        <div class="col-lg-2 img-row">
                            <div class="block">
                                <div class="thumbnail thumbnail-boxed">
                                    <div class="thumb">
                                        <img src="<?php echo $thumb_file;?>" alt=" <?php echo $file;?>" class="img-responsive">
                                        <div class="thumb-options">
                                            <span>
                                                <a rel="group" title="<?php echo $file;?>" href="<?php echo base_url($file_dir);?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill lightbox"><i class="flaticon-visible"></i></a>
                                                <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" remove-el="parent.img-row" data-rm-name="project_map_remove[]" data-rm-value="<?php echo $file;?>"><i class="la la-trash"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="img-input-fields">
                                        <input type="hidden" class="form-control" name="project_map[]" value="<?php echo $file;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    echo '</div>';
                }
                ?>
                <div class="m-dropzone dropzone m-dropzone--success" action="<?php echo admin_url($this->_route . '/file_upload');?>" id="m-project-map-dropzone">
                    <div class="m-dropzone__msg dz-message needsclick">
                        <h3 class="m-dropzone__msg-title">Drop project_map here or click to upload.</h3>
                        <span class="m-dropzone__msg-desc">Only "gif|jpg|jpeg|png" files extension's are allowed for upload</span>
                    </div>
                </div>

                <script>
                    Dropzone.options.mProjectMapDropzone = {
                        paramName: "file",
                        //maxFiles:10,
                        //maxFilesize: 10, // MB
                        addRemoveLinks: !0,
                        acceptedFiles: ".gif,.jpg,.jpeg,.png",
                        /* Update: ./application/models/m_projects.php  $config['allowed_types'] = 'gif|jpg|jpeg|png';*/
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
                                console.log($('.dz-image', previewEl));
                                $('.dz-image', previewEl).append('<input type="hidden" name="project_map[]" value="' + json.result.filename + '">');
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
    <?php /*
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('Videos');?>:</label>
            <div class="col-lg-10">

                <?php
                $videos = json_decode($row->videos);
                if (count($videos) > 0){
                    echo '<div class="form-group m-form__group row">';
                    foreach ($videos as $k => $file) {
                        $file_dir = asset_dir("front/{$this->table}/{$file}");
                        $thumb_file = _img(file_icon($file_dir, true), 400, 400);
                        ?>
                        <div class="col-lg-2 img-row">
                            <div class="block">
                                <div class="thumbnail thumbnail-boxed">
                                    <div class="thumb">
                                        <img src="<?php echo $thumb_file;?>" alt=" <?php echo $file;?>" class="img-responsive">
                                        <div class="thumb-options">
                                            <span>
                                                <a rel="group" title="<?php echo $file;?>" href="<?php echo base_url($file_dir);?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill lightbox"><i class="flaticon-visible"></i></a>
                                                <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" remove-el="parent.img-row" data-rm-name="videos_remove[]" data-rm-value="<?php echo $file;?>"><i class="la la-trash"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="img-input-fields">
                                        <input type="hidden" class="form-control" name="videos[]" value="<?php echo $file;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
 */?>

        <div class="form-group m-form__group row sortable-ordering">
            <div class="col-sm-12"><h4>Project images</h4></div>
            <?php
            if (count($files) > 0){
                foreach ($files as $k => $file) {
                    /*$image = checkAltImg("assets/front/projects/{$file->filename}");
                    $thumb_file = base_url(_Image::open($image)->zoomCrop(200, 200));*/
                    $thumb_file = _img(file_icon(asset_dir("front/{$this->table}/{$file->filename}"), true), 200, 200, IMG_NA, 'zoomCrop');
                    ?>
                    <div class="col-lg-2 img-row sortable-row">
                        <div class="block">
                            <div class="thumbnail thumbnail-boxed">
                                <div class="thumb">
                                    <img src="<?php echo ($thumb_file);?>" alt="<?php echo $file->title;?>" class="img-responsive">
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
                                    <input type="hidden" disabled placeholder="ordering" class="form-control" name="files_data[ordering][]" value="<?php echo $file->ordering;?>">

                                    <label for="" class="badge badge-danger">Title:</label>
                                    <input type="text" placeholder="Title" class="form-control" name="files_data[title][]" value="<?php echo $file->title;?>">
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
                //maxFilesize: 10, // MB
                addRemoveLinks: !0,
                acceptedFiles: ".jpg,.jpeg,.gif,.png,.bmp",
                /* Update: ./application/models/m_projects.php -> $config['allowed_types'] = 'gif|jpg|jpeg|png';*/
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
    $("form#projects").validate({
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
            'price_from': {
                number: true,
            },
            'price_to': {
                number: true,
            },
        },
        /*messages: {
        'title' : {required: 'Title is required',},'city_id' : {required: 'City is required',},'area_id' : {required: 'Area is required',},'price_from' : {decimal: 'Price From is valid decimal',},'price_to' : {decimal: 'Price To is valid decimal',},    },*/
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