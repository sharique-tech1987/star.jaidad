<form id="users" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>
    <!--begin::Form-->

        <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">
        <div class="m-portlet__body">

            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required">
                    <?php echo __('First Name');?>
                </label>
                <div class="col-lg-6">
                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="<?php echo ($row->first_name);?>" />
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label">
                    <?php echo __('Last Name');?>
                </label>
                <div class="col-lg-6">
                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="<?php echo ($row->last_name);?>" />

                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label">
                    <?php echo __('Photo');?>
                </label>
                <div class="col-lg-4">
                    <input disabled type="hidden" name="photo--rm" value="<?php echo $row->photo;?>">
                    <label class="custom-file">
                        <input type="file" name="photo" id="photo" class="form-control custom-file-input" placeholder="Photo" value="<?php echo ($row->photo);?>" />
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </label>

                </div>
                <?php
                if (!empty($row->photo)) {
                    $thumb_url = _img("assets/front/{$this->table}/" . $row->photo, 200,200, USER_IMG_NA);
                    $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/' . $row->id . '/photo');
                    echo thumb_box($thumb_url, $delete_img_url);
                }
                ?>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required">
                    <?php echo __('Email');?>
                </label>
                <div class="col-lg-6">
                    <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo ($row->email);?>" />

                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required">
                    <?php echo __('Phone');?>
                </label>
                <div class="col-lg-6">
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" value="<?php echo ($row->phone);?>" />

                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label">
                    <?php echo __('Address');?>
                </label>
                <div class="col-lg-10">
                    <textarea name="address" id="address" class="form-control" placeholder="Address" cols="30" rows="3"><?php echo $row->address;?></textarea>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label">
                    <?php echo __('City');?>
                </label>
                <div class="col-lg-6">
                    <input type="text" name="city" id="city" class="form-control" placeholder="City" value="<?php echo ($row->city);?>" />

                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label">
                    <?php echo __('Country');?>
                </label>
                <div class="col-lg-6">
                    <input type="text" name="country" id="country" class="form-control" placeholder="Country" value="<?php echo ($row->country);?>" />

                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label">
                    <?php echo __('Zip Code');?>
                </label>
                <div class="col-lg-6">
                    <input type="text" name="zip_code" id="zip_code" class="form-control" placeholder="Zip Code" value="<?php echo ($row->zip_code);?>" />

                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label">
                    <?php echo __('Newsletter');?>
                </label>
                <div class="col-lg-6">
                    <div>
                        <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                    <label>
                        <input type="switch" value="1" name="newsletter" id="newsletter" value="<?php echo ($row->newsletter);?>" <?php echo _checkbox($row->newsletter, 1);?>/>
                                                <span></span>
                        </label>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required"><?php echo __('User Type');?></label>
                <div class="col-lg-6">
                    <select name="user_type_id" id="user_type_id" class="m-select2" style="width: 100%;">
                        <option value="">Select User Type</option>
                        <?php echo selectBox("SELECT * FROM user_types", ($row->user_type_id));?>
                    </select>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required">
                    <?php echo __('Username');?>
                </label>
                <div class="col-lg-6">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo ($row->username);?>" />

                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required">
                    <?php echo __('Password');?>
                </label>
                <div class="col-lg-6">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="" />

                    <?php if ($row->id > 0) {
                        echo '<span class="m-form__help m--font-danger">Note: If you would like to change the password type a new one. Otherwise leave this blank.</span>';
                    } ?>
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

    $( "form#users" ).validate({
        // define validation rules
        rules: {
            'first_name': {
                required: true,
            }
            ,'email': {
                required: true,
                email: true,
                remote: '<?php echo admin_url($this->_route . '/AJAX/validate/' . $row->id)?>',
            },
            'user_type_id': {
                required: true,
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
            'email': {/*required: 'Username is required', */remote: 'This email is already exist',},
            'phone': {/*required: 'Username is required', */remote: 'This phone is already exist',},
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
    ?>
</script>
