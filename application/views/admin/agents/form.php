<form id="users" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php";

    if(!empty($row->city)){
        $row->city_id = $this->db->query("SELECT id FROM cities WHERE city='{$row->city}'")->row()->id;
    }
    ?>
    <!--begin::Form-->

    <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">
    <div class="m-portlet__body">

        <div class="form-group m-form__group row">
            <div class="col-lg-6">
                <label class="control-label required"><?php echo __('Agent Name');?></label>
                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="<?php echo ($row->first_name);?>" />
            </div>

            <div class="col-lg-6">
                <label class="control-label"><?php echo __('Company');?></label>
                <input type="text" name="company" id="company" class="form-control" placeholder="Company" value="<?php echo ($row->company);?>" />
            </div>
        </div>

        <div class="form-group m-form__group row">
            <div class="col-lg-6">
                <label class="control-label required"><?php echo __('Email');?></label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo ($row->email);?>" />
            </div>
            <div class="col-lg-6">
                <label class="control-label required"><?php echo __('Phone');?></label>
                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" value="<?php echo ($row->phone);?>" />
            </div>
        </div>

        <div class="form-group m-form__group row">
            <div class="col-lg-6">
                <label class="control-label"><?php echo __('Address');?></label>
                <textarea name="address" id="address" class="form-control" placeholder="Address" cols="30" rows="3"><?php echo $row->address;?></textarea>
            </div>
            <div class="col-lg-6">
                <label class="control-label"><?php echo __('City');?></label><br>
                <select name="city" id="city" class="form-control m-select2" load-select="#area_ids">
                    <option value="">- Select -</option>
                    <?php echo selectBox("SELECT id, city FROM cities", $row->city_id)?>
                </select>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <div class="col-lg-12">
                <?php
                $area_ids = singleColArray("SELECT area_id FROM agent_area_list WHERE agent_id='{$row->id}'", 'area_id');
                ?>
                <label class="control-label"><?php echo __("Deals in Area's");?></label><br>
                <select name="area_ids[]" id="area_ids" class="form-control m_select2-tags" multiple load-url="<?php echo site_url('property/ajax/city_area');?>">
                    <!--<select name="area_id" id="area_id" class="form-control m-select2" load-url="<?php /*echo site_url('property/ajax/city_area');*/?>">-->
                    <option value="">- Select -</option>
                    <?php echo selectBox("SELECT id, area FROM area WHERE city_id='{$row->city}'", $area_ids)?>
                </select>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-6">
                <label class="control-label"><?php echo __('Photo');?></label>
                <input disabled type="hidden" name="photo--rm" value="<?php echo $row->photo;?>">
                <label class="custom-file">
                    <input type="file" name="photo" id="photo" class="form-control custom-file-input" placeholder="Photo" value="<?php echo ($row->photo);?>" />
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </label>
                <?php
                if (!empty($row->photo)) {
                    $thumb_url = _img("assets/front/{$this->table}/" . $row->photo, 200,200, USER_IMG_NA);
                    $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/' . $row->id . '/photo');
                    echo thumb_box($thumb_url, $delete_img_url, '', 0);
                }
                ?>
            </div>
            <div class="col-lg-6">
                <label class="control-label"><?php echo __('Logo');?></label>
                <input disabled type="hidden" name="logo--rm" value="<?php echo $row->logo;?>">
                <label class="custom-file">
                    <input type="file" name="logo" id="logo" class="form-control custom-file-input" placeholder="Logo" value="<?php echo ($row->logo);?>" />
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </label>

                <label class="control-label"><?php echo __('Show Logo');?></label>
                <input type="checkbox" name="logo_status" id="logo_status" <?php echo $row->logo_status == 'Active' ? 'checked' : '' ?>>

                <?php
                if (!empty($row->logo)) {
                    $thumb_url = _img("assets/front/{$this->table}/" . $row->logo, 200,200, USER_IMG_NA);
                    $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/' . $row->id . '/logo');
                    echo thumb_box($thumb_url, $delete_img_url, '', 0);
                }
                ?>
            </div>
            <div class="col-lg-6">
                <div class="form-group m-form__group row">
                        <label class="control-label required"><?php echo __('Client Name');?></label>
                        <input type="text" name="logo_alt_name" id="logo_alt_name" class="form-control" placeholder="Client Name" value="<?php echo ($row->logo_alt_name);?>" />

                </div>
            </div>
        </div>
        <!--<div class="form-group m-form__group row">
            <label class="col-sm-2 control-label">
                <?php /*echo __('Country');*/?>
            </label>
            <div class="col-lg-6">
                <input type="text" name="country" id="country" class="form-control" placeholder="Country" value="<?php /*echo ($row->country);*/?>" />
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-sm-2 control-label">
                <?php /*echo __('Zip Code');*/?>
            </label>
            <div class="col-lg-6">
                <input type="text" name="zip_code" id="zip_code" class="form-control" placeholder="Zip Code" value="<?php /*echo ($row->zip_code);*/?>" />

            </div>
        </div>-->
        <!--<div class="form-group m-form__group row">
            <label class="col-sm-2 control-label">
                <?php /*echo __('Newsletter');*/?>
            </label>
            <div class="col-lg-6">
                <div>
                    <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                        <label>
                            <input type="switch" value="1" name="newsletter" id="newsletter" value="<?php /*echo ($row->newsletter);*/?>" <?php /*echo _checkbox($row->newsletter, 1);*/?>/>
                            <span></span>
                        </label>
                    </span>
                </div>
            </div>
        </div>-->
        <?php if(empty($row->social)) { ?>
        <div class="form-group m-form__group row">
            <div class="col-lg-6">
                <label class="control-label required"><?php echo __('Username');?></label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo ($row->username);?>" />

            </div>
            <div class="col-lg-6">
                <label class="control-label required"><?php echo __('Password');?></label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="" />

                <?php if ($row->id > 0) {
                    echo '<span class="m-form__help m--font-danger">Note: If you would like to change the password type a new one. Otherwise leave this blank.</span>';
                } ?>
            </div>
        </div>
        <?php } ?>
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

    $( "form#users" ).validate({
        // define validation rules
        rules: {
            'first_name': {
                required: true,
            },
            'email': {
                required: true,
                email: true,
            },
            'phone': {
                required: true,
                remote: '<?php echo admin_url($this->_route . '/AJAX/validate/' . $row->id)?>',
            },
            'username': {
                required: true,
                remote: '<?php echo admin_url($this->_route . '/AJAX/validate/' . $row->id)?>',
            },
            'password': {
                required: true,
            },
        },
        messages: {
            'username': {/*required: 'Username is required', */remote: 'This username is already exist',},
            /*'password': {required: 'Password is required',},
            'first_name': {required: 'First Name is required',},
            'email': {required: 'Email is required', email: 'Email is not valid',},*/
        },
        //display error alert on form submit
        invalidHandler: function(event, validator) {
            /*var alert = $('#_msg');
            alert.removeClass('m--hide').show();
            mApp.scrollTo(alert, -200);*/
            mUtil.scrollTo(validator.errorList[0].element, -200);
        },

        submitHandler: function(form) {
            form.submit();
        }

    });

    <?php
    if($row->id > 0){
        echo '$("#password").rules("remove");';
    }
    if(empty($row->social)) {
        echo '$("#username, #password").rules("remove");';
    }
    ?>
</script>
