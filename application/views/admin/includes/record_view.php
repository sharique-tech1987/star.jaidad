<div class="print-me" data-print-hide=".m-portlet__head,.m-subheader">
<?php
$form_buttons = ['new', 'delete', 'import', 'export', 'print', 'back'];//$config['buttons'];//
include __DIR__ . "/../includes/module_header.php"; ?>
<div class="m-portlet__body p-1">
    <?php
    $view = new record_view();
    $view->query = $query;
    $view->row = $row;
    $view->id_field = $this->id_field;
    $view->table = $this->table;

    if (count($config)) {
        foreach ($config as $conf_key => $conf) {
            $view->{$conf_key} = $conf;
        }
    }
    echo $view->showView();
    ?>
</div>
</div>
<?php include __DIR__ . "/../includes/module_footer.php"; ?>