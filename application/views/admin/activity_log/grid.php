<?php include __DIR__ . "/../includes/module_header.php"; ?>
<div class="m-portlet__body p-1">
    <?php
    if ($this->AJAX_grid) {
        echo $record_selection;
        echo '<div class="m_datatable" id="ajax_data"></div>';
        echo $grid_script;
    } else {

        $params = [
            'title' => 'Files',
            'href' => base_url() . '{_module}/download_file/{_id}/',
            'icon_cls' => 'la la-download',
        ];
        $this->actions_btn->add_button('my_files', $params, true);

        $params = [
            'title' => 'Comments',
            'href' => base_url() . '{_module}/comments/{_id}/{QUERY_STR}',
            'icon_cls' => 'la la-comments',
        ];
        $this->actions_btn->add_button('comments', $params, true);

        $params = [
            'title' => 'Comments',
            'href' => '#modal',
            'class' => 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill',
            'icon_cls' => 'la la-crosshairs',
        ];
        $this->actions_btn->add_button('popup', $params, true);


        $grid = new Grid();
        $grid->id_field = $this->id_field;

        $grid->grid_buttons = ['my_files', 'comments' => ['com' => 'table', 'id' => 'ids'], 'view', 'popup'];
        $grid->form_buttons = ['new', 'delete', 'print'];

        //$grid->status_column_data = get_enum_values('activity_log', 'status');
        $grid->custom_func = ['status' => 'status_field', 'ordering' => 'ordering_input'];

        $grid->init($query);

        $grid->dt_column(['id' => ['title' => 'ID', 'width' => '20', 'align' => 'center', 'th_align' => 'center', 'hide' => true]]);
        $grid->dt_column(['rel_id' => ['title' => 'Rel ID', 'width' => '30', 'align' => 'center', 'th_align' => 'center', 'hide' => false]]);
        $grid->dt_column(['status' => ['align' => 'center', 'th_align' => 'center', 'filter_value' => '=', 'input_options' => ['options' => $grid->status_column_data, 'class' => '', 'onchange' => true]]]);
        $grid->dt_column(['ordering' => ['width' => '90', 'align' => 'center', 'th_align' => 'center']]);
        $grid->dt_column(['created' => ['input_options' => ['class' => 'm_datepicker']]]);
        $grid->dt_column(['grid_actions' => ['width' => '150']]);

        echo $grid->showGrid();
    }
    ?>
</div>
<?php include __DIR__ . "/../includes/module_footer.php"; ?>
