<?php
$ci = & get_instance();
$ci->load->model(ADMIN_DIR . "m_scheme_forms");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($ci->m_scheme_forms->validate()) {

        if ($id = $ci->m_scheme_forms->insert(['form_type' => '15 Lac'])) {
            set_notification(__('Thank you for showing your interest, you will be contacted soon.'), 'success');
        } else {
            set_notification(__('Some error occurred'), 'error');
        }
        redirectBack();
    } else{
        $row = array2object($_POST);
    }
    //redirectBack();
}
?>
<style>
    .icon-cancel-circle{
        display: none;
    }
</style>
<div class="container">
    <p>&nbsp;</p>
    <?php echo show_validation_errors(false);?>
    <div class="form-bg-image">
        <form class="scheme-form" role="form" method="post" enctype="multipart/form-data">
            <div class="main-input">
                <div class="form-group col-lg-6 row">
                    <label class="col-sm-2 col-lg-4" for="inputEmail3">Name of Applicant:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="name" value="<?php echo $row->name;?>" placeholder="Name of Applicant" />
                    </div>
                    <div class="col-sm-2 text-center">
<!--                        <div class="image-box upload-btn-wrapper">-->
<!--                            <label for="inputUpload" class="custom-file-upload">Upload Passport size Image</label>-->
<!--                            <img id="blah" class="photo-img img-thumbnail" src="--><?php //echo _img(media_url('images/1.png'), 170, 170, USER_IMG_NA);?><!--" alt="" width="170" height="170" />-->
<!--                            <input type="hidden" name="photo" id="photo" value="">-->
<!--                            <input type="file" name="file" class="file-upload" data-input="#photo" data-thumb=".photo-img" data-url="--><?php //echo site_url('member/ajax/upload');?><!--"/>-->
<!--                        </div>-->
                    </div>

                    <!--<input id="inputUpload" class="imgInp" name="files" type="file" />-->
                </div>
                <div class="form-group col-lg-6 row father_nma">
                    <label class="col-sm-2 col-lg-4 " for="father_name" style="padding-right: 0;">Father/Husband Name:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="father_name" value="<?php echo $row->father_name;?>" placeholder="Name of Father/Husband" />
                    </div>
                </div>
                <div class="form-group col-lg-6 row">
                    <label class="col-sm-2 col-lg-4" for="father_name">Date of Birth:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="dob" value="<?php echo $row->dob;?>" placeholder="Date of birth" />
                    </div>
                </div>
                <div class="form-group col-lg-6 row">
                    <label class="col-sm-2 col-lg-4" for="father_name">CNIC:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="cnic" value="<?php echo $row->cnic;?>" placeholder="CNIC" />
                    </div>
                </div>
                <div class="form-group col-lg-6 row">
                    <label class="col-sm-2 col-lg-4 " for="father_name">Permanent address:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="permanent_address" value="<?php echo $row->permanent_address;?>" placeholder="Permanent Address" />
                    </div>
                </div>
                <div class="form-group col-lg-6 row">
                    <label class="col-sm-2 col-lg-4" for="father_name">Telephone (Home):</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="telephone" value="<?php echo $row->telephone;?>" placeholder="Telephone" />
                    </div>
                </div>
                <div class="form-group col-lg-6 row">
                    <label class="col-sm-2 col-lg-4" for="father_name">Cell #:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control " name="cell" value="<?php echo $row->cell;?>" placeholder="Cell #" />
                    </div>
                </div>
                <div class="form-group col-lg-6 row">
                    <label class="col-sm-2 col-lg-4" for="father_name">Email:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control " name="email" value="<?php echo $row->email;?>" placeholder="Email" />
                    </div>
                </div>
            </div>


            <div class="block-gap"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="black-box">
                        <h1>Please select a city of your choice</h1>
                        <div class="row">
                            <?php
                            $_OP = ["Karachi", "Islamabad", "Lahore", 'Yazman', 'Wazirabad', 'Vehari', 'Hyderabad', 'Kohat', '	Khushab', 'Khanpur', 'Khairpur'];
                            foreach ($_OP as $key => $value) {
                                ?>
                                <div class="col-sm-4">
                                    <div class="check-box">
                                        <input type="radio" name="cities" id="city_name_<?php echo $key;?>" value="<?php echo $value;?>" <?php echo _radiobox($row->cities, $value);?>/>
                                        <label class="" for="city_name_<?php echo $key;?>"><?php echo $value;?></label>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="error-placement"></div>
                    </div>
                </div>
            </div>

            <div class="block-gap"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="black-box">
                        <h1>Housing Options (Please select one option of your choice)</h1>
                        <h5 class="text-center">Apartment</h5>
                        <div class="row">
                            <?php
                            $i = 0;
                            $_OP = ["Single bedroom apartment", "Two bedroom apartment", 'Three bedroom apartment'];
                            foreach ($_OP as $key => $value) {
                                $i++;
                                ?>
                                <div class="col-sm-4">
                                    <div class="check-box">
                                        <input type="radio" name='property_type' id="property_type-<?php echo $i;?>" value="<?php echo $value;?>" <?php echo _radiobox($row->property_type, $value);?>>
                                        <label class="" for="property_type-<?php echo $i;?>"><?php echo $value;?></label>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <h5>&nbsp;</h5>
                        <h5 class="text-center"> House</h5>
                        <div class="row">
                            <?php
                            $_OP = ["3 Marla/ 80sq.yards Home", "5 Marla/ 120sq.yards Home", '10 Marla/ 240sq.yards Home'];
                            foreach ($_OP as $key => $value) {
                                $i++;
                                ?>
                                <div class="col-sm-4">
                                    <div class="check-box">
                                        <input type="radio" name='property_type' id="property_type-<?php echo $i;?>" value="<?php echo $value;?>" <?php echo _radiobox($row->property_type, $value);?>>
                                        <label class="" for="property_type-<?php echo $i;?>"><?php echo $value;?></label>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>

                        <div class="error-placement"></div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <p>&nbsp;</p>
                    <button class="btn btn-primary" type="submit">submit</button>
                </div>
            </div>
            <div class="block-gap"></div>
            <p>&nbsp;</p>
              <p>&nbsp;</p>
        </form>
    </div>
     <p>&nbsp;</p>
</div>


<script>
    $(document).ready(function () {
        var form = $('.scheme-form');
        console.log(form);

        form.validate({
            ignore: "",
            // define validation rules
            rules: {
                'name': {
                    required: true,
                },
                'father_name': {
                    required: true,
                },
                'cnic': {
                    required: true,
                },
                'dob': {
                    required: true,
                },
                'address': {
                    required: true,
                },
                'permanent_address': {
                    required: true,
                },
                'telephone': {
                    required: true,
                    number: true,
                },
                'cell': {
                    required: true,
                    number: true,
                },
                'email': {
                    required: true,
                    email: true,
                },
                'cities': {
                    required: true,
                    minlength: 1
                },
                'property_type': {
                    required: true,
                    minlength: 1
                },
                /*'area': {
                    required: true,
                    minlength: 1

                },*/
            },
            messages: {
                /*'title': {required: 'Title is required',},
                'city_id': {required: 'City is required',},
                'area_id': {required: 'Area is required',},
                'price': {required: 'Price is required', number: 'Price is valid numeric',},
                'area': {required: 'Area is required',},*/
                'cities': {required: 'Please select a city of your choice', minlength: 'Please select a city of your choice',},
                'property_type': {required: 'Please select one option of your choice', minlength: 'Please select one option of your choice',},
                /*'area': {required: 'Please select one option of your choice', minlength: 'Please select one option of your choice',},*/
            },
            //display error alert on form submit
            invalidHandler: function(event, validator) {
                validator.errorList[0].element.focus();
            },
            errorPlacement: function(error, element) {
                let el_name = element.attr("name");
                if (el_name == "property_type" || el_name == "area"  || el_name == "cities" ) {
                    let error_place = element.closest('div.black-box').find('.error-placement');
                    if(error_place.html().length == 0)
                        error_place.append(error);
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                form.submit();
            }

        });
    });
</script>