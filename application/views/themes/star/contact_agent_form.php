<?php
$member_id = _session(FRONT_SESSION_ID);
if($member_id > 0){
    $member = get_member($member_id);
}
?>
<div>
    <p><?php echo $agent->full_name;?></p>
    <?php if(!empty($agent->phone)) { ?>
    <p class="text-center"><a class="theme-btn btn-style-one btn-lg btn-block show-number" href="#"><i class="fa fa-phone"></i> Show Phone Number</a></p>
    <?php } ?>
</div>
<div class="alert-box"></div>
<form method="post" class="message-form" action="<?php echo site_url("property/contact/{$row->id}/");?>">
    <input type="hidden" name="property_id" value="<?php echo $row->id;?>">
    <input type="hidden" name="agent_id" value="<?php echo $agent->id;?>">
    <div class="form-group">
        <input type="text" name="full_name" id="full_name" value="<?php echo $member->full_name;?>" placeholder="Your Name">
    </div>
    <div class="form-group">
        <input type="text" name="email" id="email" value="<?php echo $member->username;?>" placeholder="Email Address">
    </div>
    <div class="form-group">
        <input type="text" name="phone" id="phone" data-inputmask="'mask': '+999999999999'" value="<?php echo $member->phone;?>" placeholder="Phone No.">
    </div>
    <div class="form-group">
<!--        <textarea name="message" id="message" class="form-control" rows="5" placeholder="Massage">I would like to inquire about your property ID - (--><?php //echo $row->id;?><!--). Please contact me at your earliest convenience.</textarea>-->
        <textarea name="message" id="message" class="form-control" rows="5" placeholder="Type Message Here" ></textarea>
    </div>
    <div class="form-group">
        <button class="theme-btn btn-style-one" type="submit" name="submit-form">Submit now</button>
        <input type="reset" id="reset" style="display: none;" value="Reset">
    </div>
</form>
<script>
    var form = $("form.message-form");

    form.validate({
        // define validation rules
        rules: {
            'full_name': {
                required: true,
            },
            'email': {
                required: true,
                email: true,
            },
            'phone': {
                required: true,
                phone: true,
            },
            'message': {
                required: true,
            },
        },
        messages: {
            'full_name': {required: 'Name is required',},
            'email': {required: 'Email is required',},
            'phone': {required: 'Phone is required', phone: 'Enter valid phone number',},
            'message': {required: 'Message is required'},
        },
        //display error alert on form submit
        invalidHandler: function(event, validator) {
            validator.errorList[0].element.focus();
            $(validator.errorList[0].element).css('border', '1px solid red');
        },

        submitHandler: function(form) {
            //form.submit();
            let _form = $('form.message-form');
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: '<?php echo site_url('inbox/ajax/send_msg/');?>',
                data: _form.serialize(),
            }).done(function(json) {
                console.log(json);
                $('.alert-box').html(json.message);
                _form.find('#reset').trigger('click');
            }).fail(function() {
                $('.alert-box').html('Some error occurred!');
            });

        }

    });


    $(document).ready(function () {

        $(document).on('click', '.show-number', function (e) {
            let _this = $(this);
            e.preventDefault();
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: '<?php echo site_url('property/ajax/show_number/');?>',
                data: {id: '<?php echo $row->id;?>'},
            }).done(function(json) {
                console.log(json);
                _this.html(json.phone).attr('href', 'tel:' + json.phone).removeClass('show-number');
            }) .fail(function() {

            });
        });



    });
</script>