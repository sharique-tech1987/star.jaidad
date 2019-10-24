<?php
define('MEMBER_FORM_URI', 4);
$_action = (getUri(MEMBER_FORM_URI));
$__id = getUri(MEMBER_FORM_URI + 1);

$_url = current_url();
$ci = & get_instance();
$ci->load->model(ADMIN_DIR . 'm_users');

if(in_array($_action, ['save']) && $my_profile){

    if($__id > 0){
        if ($ci->m_users->update($__id)) {
            set_notification('Record has been successfully updated!', 'success');
        } else {
            set_notification('Some error occurred!');
        }
    } else {
        $_db_data['member_id'] = $row->id;
        if ($ci->m_users->insert($_db_data)) {
            set_notification('Record has been successfully inserted!', 'success');
        } else {
            set_notification('Some error occurred!');
        }
    }
    redirectBack();
} elseif(in_array($_action, ['delete']) && $my_profile){

    if (delete_rows($ci->m_users->table, "id='{$__id}' AND member_id='{$row->id}'")) {
        set_notification('Record has been successfully deleted!', 'success');
    } else {
        set_notification('Some error occurred!');
    }
    redirectBack();
}
?>

<?php include __DIR__ . "/../profile_left.php"; ?>
    <div class="managing-committee">
        <div class="panel panel-default">
            <div class="panel-heading">Staff
                <?php if($my_profile && !$_action) { ?>
                    <a href="<?php echo $_url . '/form/';?>" class="btn btn-success pull-right"><i class="fa fa-plus-square"></i> Add Staff</a>
                <?php } ?>
            </div>
            <div class="panel-body">
                <?php
                switch ($_action){
                    default: ?>
                        <!--
                        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
                        | Staffs
                        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
                        -->
                        <?php
                        $rows = $ci->m_users->rows("AND users.id='{$row->id}'");
                        if (count($rows) > 0) {
                            echo '<ul class="committee-list member-list">';
                            foreach ($rows as $item) {
                                ?>
                                <li class="">

                                    <div class="hover ehover1" style="width: 200px; height: 200px; margin: 15px;">
                                        <?php


                                        $pdf = pathinfo($item->photo, PATHINFO_EXTENSION);
                                        if($pdf == "pdf"){?>
                                            <img src="<?php echo _img("assets/admin/img/file_icons/pdf.png", 300, 300); ?>"
                                                 alt="<?php echo $item->name; ?>" class="img-thumbnail">
                                        <?php }else{?>
                                            <img src="<?php echo _img("assets/front/users/{$item->photo}", 300, 300); ?>"
                                                 alt="<?php echo $item->name; ?>" class="img-thumbnail">
                                        <?php }
                                        ?>


                                        <img src="<?php echo _img("assets/front/users/{$item->photo}", 300, 300); ?>" alt="<?php echo $item->name; ?>" class="img-thumbnail">
                                        <div class="overlay">
                                            <a data-fancybox="" data-type="iframe" href="<?php echo asset_url("front/customer_members/{$item->photo}"); ?>" class="info"><i class="fa fa-eye"></i></a>
                                            <?php if($my_profile) { ?>
                                                <a href="<?php echo $_url . '/form/' . $item->id;?>" title="Edit" class="info"><i class="fa fa-edit"></i></a>
                                                <a onclick="if(!confirm('Want to delete?')){return false};" href="<?php echo $_url . '/delete/' . $item->id;?>" title="Delete" class="info"><i class="fa fa-trash"></i></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <h6><?php echo $item->name; ?></h6>

                                </li>
                                <?php
                            }
                            echo '</ul>';
                        }
                        ?>

                        <?php if($my_profile) { ?>
                            <div class="text-center clearfix">
                                <hr>
                                <a href="<?php echo $_url . '/form/';?>" class="btn btn-success "><i class="fa fa-plus-square"></i> Add Member</a>
                            </div>
                        <?php } ?>
                        <?php break;
                    case 'view':
                        $data['row'] = $ci->m_users->row($__id, "AND member_id='{$row->id}'");
                        $data['row']->photo = "assets/front/customer_members/" . $data['row']->photo;
                        echo $this->load->view(get_template_directory(true) . 'committee_member/popup_detail', $data, true);
                        break;
                    case 'form':
                        if($__id > 0){
                            $i_row = $ci->m_users->row($__id, "AND member_id='{$row->id}'");
                        }
                        ?>
                        <!--
                        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
                        | FORM
                        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
                        -->
                        <form id="validate" class="-form-horizontal validate inner-form" action="<?php echo str_replace('/form', "/save/{$i_row->id}", $_url) . '';?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo ($i_row->id);?>" class="form-control" placeholder="ID">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label required">Name <span class="mandatory">*</span></label>
                                        <div class="">
                                            <input type="text" name="name" id="name" class="form-control validate[required]" placeholder="Name" value="<?php echo ($i_row->name);?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label">Attachment: </label>
                                        <div class="">
                                            <input disabled type="hidden" name="photo--rm" value="<?php echo $i_row->photo;?>">
                                            <div class="js">
                                                <input type="file" name="photo" id="photo" class="inputfile inputfile-6" placeholder="Photo" value="<?php echo ($i_row->photo);?>" />
                                                <label for="company_logo"><span>&nbsp;</span> <strong>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
                                                        Choose a file…</strong>
                                                </label>
                                            </div>
                                            <span class="m-form__help">"jpg, png, bmp, gif" file extension's</span>
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($i_row->photo)) {
                                        $thumb_url = asset_url("front/customer_members/" . $i_row->photo);
                                        //$delete_img_url = admin_url($this->module_route . '/AJAX/delete_img/' . $i_row->id . '/' . $i_row->photo);
                                        echo thumb_box($thumb_url);
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="text-center">
                                <a class="btn btn-default" href="<?php echo substr($_url, 0, strpos($_url, '/form'));?>">Close</a>
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </form>
                        <?php break;
                }
                ?>

            </div>
        </div>
    </div>

<?php include __DIR__ . "/../profile_footer.php"; ?>