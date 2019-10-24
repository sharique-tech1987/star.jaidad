<?php
$form_buttons = ['new', 'delete', 'import', 'export', 'print'];
$status_column_data = get_enum_values($this->table, 'status');
include __DIR__ . "/../includes/module_header.php"; ?>
<div class="m-portlet__body p-1">
    <?php
    if ($this->AJAX_grid) {
        echo $record_selection;
        echo '<div class="m_datatable" id="ajax_data"></div>';
        echo $grid_script;
    } else {
        $grid = new Grid();
        $grid->id_field = $this->id_field;

        $grid->grid_buttons = ['edit', 'delete', 'status' => ['status' => 'status'], 'view'];

        $grid->status_column_data = get_enum_values('email_templates', 'status');
        $grid->custom_func = ['status' => 'status_options', 'ordering' => 'ordering_input'];

        $grid->init($query);

        $grid->dt_column(['id' => ['title' => 'ID', 'width' => '20', 'align' => 'center', 'th_align' => 'center', 'hide' => true]]);
        $grid->dt_column(['status' => ['overflow' => 'initial', 'align' => 'center', 'th_align' => 'center', 'filter_value' => '=', 'input_options' => ['options' => $grid->status_column_data, 'class' => '', 'onchange' => true]]]);
        $grid->dt_column(['ordering' => ['width' => '90', 'align' => 'center', 'th_align' => 'center']]);
        $grid->dt_column(['created' => ['input_options' => ['class' => 'm_datepicker']]]);
        
        echo $grid->showGrid();
    }
    ?>
</div>
<?php include __DIR__ . "/../includes/module_footer.php"; ?>
