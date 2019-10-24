<?php
/**
* Adnan Bashir
* E: developer.adnan@gmail.com
* P: +92-332-3103324
* S: developer.adnan
*/

$form_buttons = ['new', 'delete', 'import', 'export'];
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

        $grid->grid_buttons = ['edit', 'view', 'duplicate', 'delete', 'status' => ['status' => 'status']];

        $grid->status_column_data = $status_column_data;
        $grid->custom_func = ['status' => 'status_options', 'ordering' => 'ordering_input'];

        $grid->init($query);

        $grid->dt_column(['id' => ['title' => 'ID', 'width' => '20', 'align' => 'center', 'th_align' => 'center', 'hide' => true]]);
        $grid->dt_column(['status' => ['overflow' => 'initial', 'align' => 'center', 'th_align' => 'center', 'filter_value' => '=', 'input_options' => ['options' => $grid->status_column_data, 'class' => '', 'onchange' => true]]]);
        $grid->dt_column(['ordering' => ['width' => '90', 'align' => 'center', 'th_align' => 'center']]);
        $grid->dt_column(['created' => ['input_options' => ['class' => 'm_datepicker']]]);
        $grid->dt_column(['icon' => ['align' => 'center', 'image_size' => '48x48', 'image_path' => asset_url("front/{$this->table}/")]]);
        
        echo $grid->showGrid();
    }
    ?>
</div>
<?php include __DIR__ . "/../includes/module_footer.php"; ?>
