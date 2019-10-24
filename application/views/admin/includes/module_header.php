<?php include __DIR__ . "/module_breadcrumb.php"; ?>
<div class="m-content print-me" data-print-hide=".m-portlet__head,.m-subheader,[print='false'],[data-print='false']">
    <?php echo show_validation_errors();?>
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

        <div class="m-portlet__head <?php echo ($head_opt['sticky_head'] === false ? '' : 'sticky-head');?>">
            <div class="m-portlet__head-progress"><!-- here can place a progress bar--></div>
            <div class="m-portlet__head-wrapper">

                <?php if($head_opt['title'] === true) { ?>
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-dashboard"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            <?php echo __($this->_info->module_title); ?>
                        </h3>
                    </div>
                </div>
                <?php } ?>

                <div class="m-portlet__head-tools">
                    <?php
                    $ci =& get_instance();
                    $ci->load->library('form_btn');

                    echo $ci->form_btn->buttons($form_buttons);
                    ?>
                    <?php if(user_do_action('status') && is_array($status_column_data) && count($status_column_data) > 0) { ?>
                    <span class="grid-bluk-action">
                        <select name="status" class="form-control m-bootstrap-select m-bootstrap-select--pill m_selectpicker m--margin-right-10" title="Select status" data-width="140px">
                            <option value="">Change status</option>
                            <?php echo selectBox($status_column_data, ''); ?>
                        </select>
                        <a action="update_grid" title="Update" href="<?php echo admin_url($this->_route. '/status');?>" class="btn btn-warning m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10 m-btn--pill m-btn--air"><span><i class="la la-floppy-o"></i><span>Update</span></span></a>
                    </span>
                    <?php } ?>
                </div>
                <?php echo portlet_actions();?>
            </div>
        </div>

