<div class="print-me" data-print-hide=".m-portlet__head,.m-subheader">
    <style>
        .img-left .thumb{
            float: left;
        }
        .img-right .thumb{
            float: right;
        }
        .img-right .thumb .caption{
            text-align: center;
        }
    </style>
    <?php
    $form_buttons = ['new', 'print', 'back'];
    $status_column_data = get_enum_values('users', 'status');
    include __DIR__ . "/../includes/module_header.php"; ?>
    <div class="m-portlet__body p-1">
        <p style="text-align: center;"><strong><span style="font-size: 28.0pt;"><?php echo get_option(SMS_TITLE_OP);?></span></strong></p>
        <p style="text-align: center;"><strong><span style="font-size: 22.0pt;">Teacher Data Form</span></strong></p>
        <p style="text-align: center;">&nbsp;</p>
        <?php //echo '<pre>'; print_r($row); echo '</pre>';?>
        <table class="table">
            <tr>
                <td width="50%" class="img-left">
                    <?php echo thumb_box(asset_dir("front/users/{$row->photo}"), '', '', 3)?>
                </td>
                <td align="right" class="img-right">
                    <?php echo thumb_box(asset_dir("front/users/{$row->resume}"), '', 'CV', 3)?>
                </td>
            </tr>
        </table>
        
        <table class="table">
            <tr>
                <td width="33%">Gender: <u><?php echo $row->gender;?></u></td>
                <td width="33%">Nationality: <u><?php echo $row->nationality;?></u></td>
                <td>Religion: <u><?php echo $row->religion;?></u></td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td width="50%">Name: <u><?php echo $row->full_name;?></u></td>
                <td>Father/ Husband Name: <u><?php echo $row->parent;?></u></td>
            </tr>
            <tr>
                <td>Date Of Joining: <u><?php echo mysql2date($row->joining_date);?></u></td>
                <td>Date of Birth: <u><?php echo mysql2date($row->dob);?></u></td>
            </tr>
            <tr>
                <td>CNIC Number: <u><?php echo $row->cnic;?></u></td>
                <td>Qualification: <u><?php echo $row->qualification;?></u></td>
            </tr>
            <tr>
                <td colspan="2">Current Address: <u><?php echo $row->address;?></u></td>
            </tr>
            <tr>
                <td colspan="2">Permanent Address: <u><?php echo $row->permanent_address;?></u></td>
            </tr>
            <tr>
                <td><p>Mobile Number</p>
                    <p>&nbsp;</p>
                    <p><u><?php echo $row->phone;?></u></p></td>
                <td align="right"><p>Emergency Number</p>
                    <p>&nbsp;</p>
                    <p><u><?php echo $row->emergency_number;?></u></p></td>
            </tr>
        </table>
    </div>
    <?php include __DIR__ . "/../includes/module_footer.php"; ?>
</div>
