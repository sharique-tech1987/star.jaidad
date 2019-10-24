<?php get_header('member'); ?>

<?php
define('MEMBER_FORM_URI', 4);
$_action = (getUri(MEMBER_FORM_URI));
$__id = getUri(MEMBER_FORM_URI + 1);

$_url = current_url();
$ci = &get_instance();
$ci->load->model(ADMIN_DIR . 'm_booking');

if (in_array($_action, ['save']) && $my_profile) {

    if ($__id > 0) {
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
} elseif (in_array($_action, ['delete']) && $my_profile) {

    if (delete_rows($ci->m_users->table, "id='{$__id}' AND member_id='{$row->id}'")) {
        set_notification('Record has been successfully deleted!', 'success');
    } else {
        set_notification('Some error occurred!');
    }
    redirectBack();
}
?>
<style>
    .table thead th {
        border: none;
    }

    @media (min-width: 992px), (max-height: 700px) {
        .modal-lg {
            max-width: 1100px;
        }
    }

</style>

<div class="dashboard">
    <div class="container-fluid">
        <div class="content-area">
            <div class="dashboard-content">
                <div class="dashboard-header clearfix">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 breadcrumb_member_cust "><h4>My Bookings</h4></div>
                        <div class="col-md-6 col-sm-12 breadcrumb_member_cust">
                            <?php include "breadcrumb.php"; ?>
                        </div>
                    </div>
                </div>
                <?php echo show_validation_errors(); ?>
                <div class="row">
                    <div class="column col-lg-12">
                        <div class="properties-box">
                            <div class="title"><h3>My Bookings</h3></div>
                            <div class="inner-container">
                                <style>
                                    .table-responsive {
                                        display: table;
                                    }
                                </style>
                                <?php
                                $where = " AND booking.member_id='{$row->id}'";
                                $query = "SELECT booking.id
, projects.title AS project
, project_properties.title AS property
, booking.booking_date
, booking.status
, CONCAT('<a data-toggle=\"modal\" style=\"cursor: pointer;\" data-target=\"#payment_schedule_modal\" data-href=\"" . site_url('project/ajax/booking/') . "', project_properties.id, '/', booking.id,'\"><i class=\"la la-eye-slash\"></i></a>') AS detail
FROM booking
LEFT JOIN project_properties ON(project_properties.id = booking.property_id)
LEFT JOIN projects ON(projects.id = project_properties.project_id)
LEFT JOIN users AS members ON(members.id = booking.member_id)
LEFT JOIN users ON(users.id = booking.created_by) 
WHERE 1 {$where}";
                                $query .= getFindQuery($query);


                                $grid = new Grid();
                                $grid->id_field = $this->id_field;
                                $grid->is_front = true;
                                $grid->show_validation_errors = false;
                                $grid->show_paging_bar = false;
                                $grid->sorting = false;

                                $grid->status_column_data = $status_column_data;
                                $grid->custom_func = ['status' => 'status_field'];

                                $grid->init($query);

                                $grid->dt_column(['id' => ['title' => 'ID', 'width' => '20', 'align' => 'center', 'th_align' => 'center', 'hide' => true]]);
                                $grid->dt_column(['status' => ['overflow' => 'initial', 'align' => 'center', 'th_align' => 'center', 'filter_value' => '=', 'input_options' => ['options' => $grid->status_column_data, 'class' => '', 'onchange' => true]]]);
                                $grid->dt_column(['ordering' => ['width' => '90', 'align' => 'center', 'th_align' => 'center']]);
                                $grid->dt_column(['created' => ['input_options' => ['class' => 'm_datepicker']]]);

                                echo $grid->showGrid();
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>


<div class="modal modal-payment_schedule_modal fade" id="payment_schedule_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<script>
    $(function () {
        $(document).ready(function () {
            $('#payment_schedule_modal').on('shown.bs.modal', function (event) {
                var modal = $(this);
                var button = $(event.relatedTarget); // Button that triggered the modal
                var url = button.data('href');
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: url,
                    complete: function (data) {
                        var json = $.parseJSON(data.responseText);
                        console.log(json);
                        modal.find('.modal-title').html(json.row.title);
                        modal.find('.modal-content').html(json.html);
                    }
                });
            })
        });
    });
</script>
