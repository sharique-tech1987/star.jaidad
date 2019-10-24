<?php get_header(get_option('header')); ?>

<script src="<?php echo media_url('js/jquery.steps.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo media_url("css/steps.css"); ?>">

<script src="<?php echo media_url('plugins/dropzone/dropzone.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo media_url("plugins/dropzone/dropzone.min.css"); ?>">
<?php   $thisFile = pathinfo(__FILE__, PATHINFO_FILENAME);

?>
<style>

    <?php if($thisFile =='property_form')
    {
       
    ?>
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background: #92C800;
        color: white;
    }
    [class^='select2'] {
        border-radius: 16px !important;
    }

    <?php }
     ?>

</style>


<div id="wrapper-content" class="clearfix ">
    <div class="content_wrapper clearfix">
        <div class="sections_group">
            <div class="entry-content">
                <div class="section_wrapper mcb-section-inner">

                    <?php
                    include "include/page_header.php"; ?>
                    <div class="-container">

                        <form class="" method="post" enctype="multipart/form-data" id="properties"
                              action="<?php echo site_url('property/add'); ?>">

                            <input type="hidden" name="id" class="form-control" placeholder="ID"
                                   value="<?php echo $row->id; ?>">
                            <div class="m-portlet__body">

                                <div id="wizard" class="">
                                    <h3>Property Info</h3>
                                    <fieldset>

                                        <div>
                                            <?php echo show_validation_errors(); ?>

                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-2 control-label required"><?php echo __('Title'); ?>
                                                    :</label>
                                                <div class="col-lg-10">
                                                    <input type="text" name="title" id="title" class="form-control"
                                                           placeholder="<?php echo __('Title'); ?>"
                                                           value="<?php echo htmlentities($row->title); ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-2 control-label required"><?php echo __('Purpose'); ?>
                                                    :</label>
                                                <div class="col-lg-6">
                                                    <select name="purpose" id="purpose"
                                                            class="form-control select2 m_selectpicker">
                                                        <option value="">Select Purpose</option>
                                                        <?php echo selectBox(get_enum_values('properties', 'purpose'), ($row->purpose)); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-2 control-label required"><?php echo __('Type'); ?>
                                                    :</label>
                                                <div class="col-lg-6">
                                                    <select name="type_id" id="type_id"
                                                            class="form-control select2 m_selectpicker">
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
                                                        $this->multilevels->query = "SELECT * FROM `property_types` WHERE 1 AND status='Active' ORDER BY ordering ASC";

                                                        echo $multiLevelComponents = $this->multilevels->build();

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--<div class="form-group m-form__group row">
                                            <label class="col-lg-2 control-label">
                                                <?php /*echo __('Country');*/ ?>:</label>
                                            <div class="col-lg-6">
                                                <select name="country_code" id="country_code" class="form-control m-select2">
                                                    <option value="">Select Country</option>
                                                    <?php
                                            /* $row->country_code = ($row->country_code == '' ? 'PK' : $row->country_code);
                                            echo selectBox("SELECT countryCode, countryName FROM countries", ($row->country_code));*/ ?>
                                                </select>
                                            </div>
                                        </div>-->
                                            <div class="form-group m-form__group row slct">
                                                <input type="hidden" name="country_code" value="PK">
                                                <label class="col-lg-2 control-label required"><?php echo __('City'); ?>
                                                    :</label>
                                                <div class="col-lg-6" id="city_id_div">
                                                    <select name="city_id" id="city_id" class="form-control m-select2">
                                                        <option value="">Select City</option>
                                                        <?php echo selectBox("SELECT id, city FROM cities", ($row->city_id)); ?>
                                                    </select>

                                                </div>

                                            </div>
                                            <div class="form-group m-form__group row" id="frm"
                                                 style="display: <?php echo($row->city_id > 0 ? '' : 'none') ?>;">
                                                <label class="col-lg-2 control-label required"><?php echo __('Area'); ?>
                                                    :</label>
                                                <div class="col-lg-6">
                                                    <!--<input type="text" name="area_id" id="area_id" class="form-control" placeholder="<?php /*echo __('Area');*/ ?>" value="<?php /*echo htmlentities($row->area_id);*/ ?>" />-->
                                                    <select name="area_id" id="area_id" data-add_more="1"
                                                            class="form-control m-select2-ajax"
                                                            data-url="<?php echo site_url('property/ajax/search_area'); ?>"
                                                            data-data_ele="#city_id">
                                                        <option value="">Select Area</option>
                                                        <?php echo selectBox("SELECT id, area FROM area WHERE city_id='{$row->city_id}' AND id='{$row->area_id}'", ($row->area_id)); ?>
                                                    </select>
                                                    <script>
                                                        $(document).ready(function () {
                                                            $(document).on('change', '#city_id', function (e) {
                                                                $('#area_id').val(null).trigger('change');
                                                            });
                                                        });
                                                    </script>
                                                </div>

                                                <div class="col-lg-4" id="area_add" style="display: none">
                                                    <span class="text-center newarea">OR</span>
                                                    <input type="text" name="location" id="location"
                                                           class="form-control"
                                                           placeholder="<?php echo __('New Area'); ?>"
                                                           value="<?php echo htmlentities($row->location); ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-2 control-label"><?php echo __('Description'); ?>
                                                    :</label>
                                                <div class="col-lg-10">
                                                    <textarea name="description" id="description"
                                                              placeholder="<?php echo __('Description'); ?>"
                                                              class="-simple_editor form-control descarea" cols="57"
                                                              rows="8"><?php echo $row->description; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-2 control-label required"><?php echo __('Price'); ?>
                                                    :</label>
                                                <div class="col-lg-6">
                                                    <div class="input-group">
                                                        <input type="text" name="price" id="price" class="form-control"
                                                               placeholder="<?php echo __('Price'); ?>"
                                                               value="<?php echo htmlentities($row->price); ?>"/>
                                                        <div class="input-group-append input-group-addon"
                                                             style="border: none;">PKR
                                                        </div>
                                                    </div>
                                                    <div id="short_price" class="help-block"></div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-2 control-label required"><?php echo __('Area Size'); ?>
                                                    :</label>
                                                <div class="col-lg-6">
                                                    <div class="input-group">
                                                        <input type="text" name="area" id="area" class="form-control"
                                                               placeholder="<?php echo __('Area Size'); ?>"
                                                               value="<?php echo htmlentities($row->area); ?>"/>
                                                        <div class="input-group-append input-group-addon input-group-addon-custom"
                                                             style="border: 0; padding: 0;">
                                                       <span class="input-group-text"
                                                              style="padding: 0; background: white; margin: 4px;">
                                                            <select name="area_unit" id="area_unit"
                                                                    class="m_selectpicker select2">
                                                                <option value="">Select Area Unit</option>
                                                                <?php echo selectBox(get_enum_values('properties', 'area_unit'), ($row->area_unit)); ?>
                                                            </select>
                                                       </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row bedrooms_div">
                                                <label class="col-lg-2 control-label -required"><?php echo __('Bedroom(s)'); ?>
                                                    :</label>
                                                <div class="col-lg-2">
                                                    <input type="text" name="bedrooms" id="bedrooms"
                                                           class="form-control"
                                                           placeholder="<?php echo __('Bedroom(s)'); ?>"
                                                           value="<?php echo htmlentities($row->bedrooms); ?>"/>
                                                </div>

                                                <label class="col-lg-2 control-label lb">
                                                    <?php echo __('Bathroom(s)'); ?>:</label>
                                                <div class="col-lg-2">
                                                    <input type="text" name="bathrooms" id="bathrooms"
                                                           class="form-control"
                                                           placeholder="<?php echo __('Bathroom(s)'); ?>"
                                                           value="<?php echo htmlentities($row->bathrooms); ?>"/>
                                                </div>
                                            </div>
                                            <!--<div class="form-group m-form__group row">
                                            <label class="col-lg-2 control-label"><?php /*echo __('Status');*/ ?>:</label>
                                            <div class="col-lg-6">
                                                <select name="status" id="status" class="form-control m_selectpicker">
                                                    <option value="">Select Status</option>
                                                    <?php /*echo selectBox(get_enum_values('properties', 'status'), ($row->status));*/ ?>
                                                </select>
                                            </div>
                                        </div>-->
                                        </div>
                                    </fieldset>


                                    <h3>Images/Video</h3>
                                    <fieldset>
                                        <div class="form-group m-form__group row">
                                            <?php
                                            if (count($files) > 0) {
                                                foreach ($files as $k => $file) {
                                                    $thumb_file = _img(file_icon(asset_dir("front/properties/{$file->filename}"), true), 200, 200);
                                                    ?>
                                                    <div class="col-lg-2 img-row">
                                                        <div class="block">
                                                            <div class="thumbnail thumbnail-boxed">
                                                                <div class="thumb">
                                                                    <img src="<?php echo $thumb_file; ?>"
                                                                         alt="<?php echo $file->title; ?>"
                                                                         class="img-responsive">
                                                                    <div class="thumb-options text-center">
                                                                        <span>
                                                                            <!--<a rel="group" title="<?php /*echo $file->title;*/ ?>" href="<?php /*echo asset_url("front/{$this->table}/{$file->filename}");*/ ?>" class="lightbox"><i class="la la-eye"></i></a>-->
                                                                            <a href="#" class=""
                                                                               remove-el="parent.img-row"
                                                                               data-rm-name="files_remove[]"
                                                                               data-rm-value="<?php echo $file->id; ?>"><i
                                                                                        class="la la-trash"></i></a>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="img-input-fields">
                                                                    <input type="hidden" class="form-control"
                                                                           name="files[]"
                                                                           value="<?php echo $file->filename; ?>">

                                                                    <input type="hidden" class="form-control"
                                                                           name="files_data[id][]"
                                                                           value="<?php echo $file->id; ?>">

                                                                    <label for=""
                                                                           class="badge badge-danger">Title:</label>
                                                                    <input type="text" placeholder="Title"
                                                                           class="form-control"
                                                                           name="files_data[title][]"
                                                                           value="<?php echo $file->title; ?>">

                                                                    <label for=""
                                                                           class="badge badge-danger">Order:</label>
                                                                    <input type="text" placeholder="ordering"
                                                                           class="form-control"
                                                                           name="files_data[ordering][]"
                                                                           value="<?php echo $file->ordering; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>

                                            <div class="col-sm-12">
                                                <div class="m-dropzone dropzone m-dropzone--success"
                                                     action="<?php echo site_url('property/file_upload'); ?>"
                                                     id="m-dropzone">
                                                    <div class="m-dropzone__msg dz-message needsclick">
                                                        <h3 class="m-dropzone__msg-title">Drop files here or click to
                                                            upload.</h3>
                                                        <span class="m-dropzone__msg-desc">Only "jpg|jpeg|gif|png|bmp" files extension's are allowed for upload</span>

                                                    </div>
                                                    <div class="my-dropzone-previews"></div>
                                                    <div class="text-center btn-center">
                                                        <div class="add-image">
                                                            <div>
                                                                <span class="fa fa-plus fa-3x"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            $("#m-dropzone").dropzone({
                                                paramName: "file",
                                                clickable: '.dropzone,.add-image',
                                                autoDiscover: true,
                                                previewsContainer: '.my-dropzone-previews',
                                                //maxFiles:10,
                                                maxFilesize: 5, // MB
                                                addRemoveLinks: !0,
                                                acceptedFiles: ".jpg,.jpeg,.gif,.png,.bmp",
                                                thumbnailWidth: 150,
                                                thumbnailHeight: 150,
                                                success: function (file, response) {
                                                    var json = JSON.parse(response);
                                                    console.log(json);
                                                    $('.btn-center').addClass('has-img');
                                                    if (json.error) {
                                                        toastr.error(json.error.filename + '' + json.error.message);
                                                    } else {
                                                        var previewEl = file.previewElement;

                                                        $('.dz-image img', previewEl).attr('src', json.result.thumb_url);
                                                        $('.dz-image', previewEl).append('<input type="hidden" name="files[]" value="' + json.result.filename + '">');
                                                        $('.dz-filename', previewEl).append('<input type="text" placeholder="title" class="form-control" name="files_data[title][]" value="' + json.result.title + '">');
                                                    }

                                                }
                                            });
                                        </script>

                                        <?php
                                        $row->videos = json_decode($row->videos);
                                        ?>
                                        <h3>Video (Youtube)</h3>
                                        <div class="form-group m-form__group row">
                                            <label class="col-lg-2 control-label "><?php echo __('Video'); ?>
                                                :</label>
                                            <div class="col-lg-10">
                                                <div class="-input-group">
                                                    <input type="text" name="videos[]" id="videos" class="form-control"
                                                           placeholder="<?php echo __('Youtube video URL'); ?>"
                                                           value="<?php echo htmlentities($row->videos[0]); ?>"/>
                                                    <!--<div class="input-group-append input-group-addon" style="border: none;">PKR</div>-->
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>


                                    <h3>Amenities</h3>
                                    <fieldset class="property-submit-form">
                                        <div class="form-group m-form__group row">
                                            <label class="col-lg-12 text-left"><?php echo __('Amenities'); ?>:</label>
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
                                                            <div class="form-group col-lg-4">
                                                                <!--<div class="<?php /*echo ($amenity->input == 'Text' ? '' : '');*/ ?>">-->
                                                                <div class="<?php echo($amenity->input == 'Text' ? '' : 'check-box'); ?>">
                                                                    <?php if ($amenity->input == 'Yes / No') { ?>
                                                                        <input type="checkbox"
                                                                               name="amenities[<?php echo $amenity->id; ?>]"
                                                                               id="amenities_<?php echo $amenity->id; ?>"
                                                                               value="Yes" <?php echo _checkbox($amenity->value, 'Yes'); ?>/>

                                                                    <?php } ?>
                                                                    <label for="amenities_<?php echo $amenity->id; ?>"
                                                                           class="-input-group-text">
                                                                        <!--<i style="font-size: 30px; color: black; padding-right: 10px;" class="<?php /*echo $amenity->icon;*/ ?>"></i>-->
                                                                        <?php if (!empty($amenity->icon)) { ?>
                                                                            &nbsp;<img
                                                                                    src="<?php echo _img(asset_url('front/amenities/' . $amenity->icon), 28, 28); ?>"
                                                                                    alt="<?php echo $amenity->icon; ?>"
                                                                                    class="img-fluid">&nbsp;
                                                                        <?php } else { ?>
                                                                            <i style="font-size: 15px; color: black; padding-right: 10px;"
                                                                               class=""></i>
                                                                        <?php } ?>
                                                                        <?php echo $amenity->title; ?></label>
                                                                </div>


                                                                <?php if ($amenity->input == 'Text') { ?>
                                                                    <input type="text"
                                                                           name="amenities[<?php echo $amenity->id; ?>]"
                                                                           id="amenities" class="form-control"
                                                                           placeholder="<?php echo __($amenity->title); ?>"
                                                                           value="<?php echo htmlentities($amenity->value); ?>"/>
                                                                <?php } ?>

                                                                <?php if (!empty($amenity->icon)) { ?>
                                                                    <!--<div class="input-group-append">
                                                                        <span class="input-group-text">
                                                                            <span class="icon-show"><i class="<?php /*echo $amenity->icon;*/ ?>"></i></span>
                                                                        </span>
                                                                    </div>-->
                                                                <?php } ?>
                                                            </div>

                                                            <!--</div>-->
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <?php
                                    $member_id = _session(FRONT_SESSION_ID);
                                    if ($member_id == 0) {
                                        ?>
                                        <h3>Contact Details</h3>
                                        <fieldset>
                                            <h2>Member Info</h2>


                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="member_entry"
                                                       id="inlineRadio1" checked value="Existing">
                                                <label class="form-check-label" for="inlineRadio1">Existing
                                                    Member</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="member_entry"
                                                       id="inlineRadio2" value="New">
                                                <label class="form-check-label" for="inlineRadio2">New Member
                                                    (Free)</label>
                                            </div>


                                            <div class="login-div">
                                                <div class="text-uppercase"><?php echo __('Sign in'); ?></div>
                                                <div data-eq-height="card">
                                                    <form class="" id="login" method="post"
                                                          action="<?php echo site_url('login/login'); ?>">
                                                        <input type="hidden" name="redirect"
                                                               value="<?php echo getVar('redirect'); ?>">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text"
                                                                   placeholder="<?php echo __('Email'); ?>" name="email"
                                                                   id="email" autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <input class="form-control m-login__form-input--last"
                                                                   type="password"
                                                                   placeholder="<?php echo __('Password'); ?>"
                                                                   name="password">
                                                        </div>
                                                        <!--<div class="row m-login__form-sub">
                                                <div class="col m--align-left">
                                                    <label class="m-checkbox m-checkbox--focus">
                                                        <input type="checkbox" name="remember">
                                                        <?php /*echo __('Remember me');*/ ?>
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>-->
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="registration-div">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Full name"
                                                           name="first_name">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Phone"
                                                           name="phone">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="Email"
                                                           name="email" autocomplete="off">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" type="password" placeholder="Password"
                                                           id="password" name="password">
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control m-login__form-input--last"
                                                           type="password" placeholder="Confirm Password"
                                                           name="rpassword">
                                                </div>
                                                <div class="row form-group m-login__form-sub">
                                                    <div class="col m--align-left">
                                                        <label class="m-checkbox m-checkbox--focus">
                                                            <input type="checkbox" name="agree"> I Agree the
                                                            <a href="#" class="m-link m-link--focus">terms and
                                                                conditions</a>.
                                                            <span></span>
                                                        </label>
                                                        <span class="m-form__help"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    <?php } ?>

                                </div>
                            </div>

                            <!--<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <input type="submit" class="btn btn-success m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php /*echo __('Submit');*/ ?>">
                                </div>
                            </div>
                        </div>
                    </div>-->
                        </form>


                        <script>


                            $(document).ready(function () {

                                $(document).on('click', '.add-more-option', function (e) {
                                    e.preventDefault();
                                    $('#location').val($(this).data().option);
                                    $('#area_add').show(0);
                                    $('#area_id').select2('close');
                                    $('#area_id').val(null).trigger('change');
                                    $(this).remove();

                                });
                                $('#area_id').on('select2:select', function (e) {
                                    let data = e.params.data;
                                    console.log(data);
                                });

                                $(document).on('change', '#city_id', function (e) {
                                    e.preventDefault();
                                    $('#frm').show(0);
                                    $('.select2-container').css('width', '100%');
                                    var select = $('.select2-selection__rendered').first().text();
                                    if (select == "Select City") {
                                        $('#city_id_div').find(".error").show();

                                    } else {
                                        $('#city_id_div').find(".error").hide();
                                    }

                                });


                                $(document).on('change', '[name=member_entry]', function (e) {
                                    if ($('[name=member_entry]:checked').val() == 'New') {
                                        $('#email').rules("add", {remote: '<?php echo site_url('login/ajax/validate/' . $row->id)?>'});
                                        $('.login-div').hide(0).find('input').attr('disabled', true);
                                        $('.registration-div').show(0).find('input').attr('disabled', false);
                                    } else {
                                        $('#email').rules("remove", 'remote');
                                        $('.login-div').show(0).find('input').attr('disabled', false);
                                        $('.registration-div').hide(0).find('input').attr('disabled', true);
                                    }
                                });

                                $('[name=member_entry]').trigger('change');
                            });

                            var form = $("form#properties");

                            form.validate({
                                // define validation rules
                                rules: {
                                    'title': {
                                        required: true,
                                    },
                                    'city_id': {
                                        required: true,
                                    },
                                    'purpose': {
                                        required: true,
                                    },
                                    'type_id': {
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
                                    'area_unit': {
                                        required: true,
                                    },
                                    /*'bedrooms': {
                                     required: true,
                                     digits: true,
                                     },
                                     'bathrooms': {
                                     digits: true,
                                     },*/
                                    <?php if($member_id == 0) { ?>
                                    'first_name': {
                                        required: true,
                                    }, 'phone': {
                                        required: true,
                                    },
                                    'email': {
                                        required: true,
                                        email: true,
                                        remote: '<?php echo site_url('login/ajax/validate/' . $row->id)?>',
                                    },
                                    'user_type_id': {
                                        required: true,
                                    },
                                    'agree': {
                                        required: true,
                                    },
                                    'password': {
                                        required: true,
                                        minlength: 6,
                                        maxlength: 12,
                                    }, 'rpassword': {
                                        equalTo: '#password'
                                    },
                                    <? } ?>
                                },
                                /*messages: {
                                 'title' : {required: 'Title is required',},'city_id' : {required: 'City is required',},'area_id' : {required: 'Area is required',},'price' : {required: 'Price is required',number: 'Price is valid numeric',},'area' : {required: 'Area is required',},'bedrooms' : {required: 'Bedrooms is required',integer: 'Bedrooms is valid integer',},'bathrooms' : {integer: 'Bathrooms is valid integer',},    },*/
                                //display error alert on form submit
                                invalidHandler: function (event, validator) {
                                    console.log(validator);
                                    validator.errorList[0].element.focus();
                                },
                                errorPlacement: function (error, element) {
                                    if (element.attr("name") == "city_id" || element.attr("name") == "area_id") {
                                        element.closest('div').append(error);
                                    } else if (element.attr("name") == "area" || element.attr("name") == "area_unit" || element.attr("name") == "price") {
                                        if (element.closest('.col-lg-6').find('label.error').length == 0)
                                            element.closest('.col-lg-6').append(error);
                                    } else {
                                        error.insertAfter(element);
                                    }
                                },
                                submitHandler: function (form) {
                                    form.submit();
                                }

                            });

                            $("#wizard").steps({
                                headerTag: "h3",
                                bodyTag: "fieldset",
                                transitionEffect: "fade",
                                stepsOrientation: "vertical",
                                titleTemplate: '<div class="title"><span class="step-number">#index#</span><span class="step-text">#title#</span></div>',
                                labels: {
                                    previous: 'Previous',
                                    next: 'Next',
                                    finish: 'Finish',
                                    current: ''
                                },
                                onStepChanging: function (event, currentIndex, newIndex) {

                                    if (currentIndex === 0) {
                                        if (form.find('#location').val().length > 0) {
                                            form.find('#area_id').rules("remove");
                                        } else {
                                            form.find('#area_id').rules("add", {
                                                required: true
                                            });
                                        }
                                        form.parent().parent().parent().append('<div class="footer footer-' + currentIndex + '"></div>');
                                    }
                                    if (currentIndex === 1) {
                                        form.parent().parent().parent().find('.footer').removeClass('footer-0').addClass('footer-' + currentIndex + '');
                                    }
                                    if (currentIndex === 2) {
                                        form.parent().parent().parent().find('.footer').removeClass('footer-1').addClass('footer-' + currentIndex + '');
                                    }
                                    if (currentIndex === 3) {
                                        form.parent().parent().parent().find('.footer').removeClass('footer-2').addClass('footer-' + currentIndex + '');
                                    }
                                    if (currentIndex === 4) {
                                        form.parent().parent().parent().find('.footer').removeClass('footer-3').addClass('footer-' + currentIndex + '');
                                    }
                                    console.log(currentIndex, newIndex);
                                    if (newIndex >= currentIndex) {
                                        form.validate().settings.ignore = ":disabled,:hidden";
                                        return form.valid();
                                    } else {
                                        form.validate().settings.ignore = ":disabled,:hidden,input,select,textarea";
                                        return form.valid();
                                    }
                                },


                                /*headerTag: "h2",
                                 bodyTag: "section",
                                 transitionEffect: "slideLeft",
                                 onStepChanging: function (event, currentIndex, newIndex){
                                 /!*if (currentIndex > newIndex) {
                                 return true;
                                 }*!/
                                 form.validate().settings.ignore = ":disabled,:hidden";
                                 return form.valid();
                                 },*/
                                onStepChanged: function (event, currentIndex, priorIndex) {

                                },
                                onFinishing: function (event, currentIndex) {
                                    form.validate().settings.ignore = ":disabled";
                                    return form.valid();
                                },
                                onFinished: function (event, currentIndex) {
                                    form.submit();
                                }
                            });


                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php get_footer(); ?>
    <script>
        $(document).ready(function () {
            $(document).on('input', '#price', function (e) {
                e.preventDefault();
                $('#short_price').html(numDifferentiation($(this).val()))
            });

            $('#type_id').change(function () {

                $('.bedrooms_div').show();
                if ($(this).val() == 2 || $(this).val() == 3 || $(this).val() == 8) {
                    $('.bedrooms_div').hide();

                }

            });

            $('[name=purpose]').on('select2:open', function (e) {
                $('.select2-container--open').find('.select2-search').remove();
            });

        });
    </script>
