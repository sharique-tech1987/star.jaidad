<style>

    .tree-module input[type=checkbox]{
        margin-left: 200px;
        position: absolute;
        display: none;
    }
    .jstree-default .jstree-icon {
        color: #000000;
    }
</style>
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post"
      enctype="multipart/form-data"
      id="user_types" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>

    <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id; ?>">

    <!--begin::Form-->

        <div class="m-portlet__body">

            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required"><?php echo __('User Type');?></label>
                <div class="col-lg-6">
                    <input type="text" name="user_type" id="user_type" class="form-control" placeholder="User Type" value="<?php echo ($row->user_type);?>"/>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required"><?php echo __('Login'); ?></label>
                <div class="col-lg-6">
                    <select name="login" id="login" class="form-control m_selectpicker">
                        <?php echo selectBox(get_enum_values('user_types', 'login'), ($row->login)); ?>
                    </select>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required"><?php echo __('User Type');?></label>
                <div class="col-lg-10">
                    <div id="tree-module" class="tree-module">
                        <?php
                        $check_sql = "SELECT id, parent_id, module, module_title, `actions` FROM modules where `status`='1' order by ordering";
                        $result = $this->db->query($check_sql);

                        $menu = array(
                            'items' => array(),
                            'parents' => array()
                        );
                        foreach ($result->result_array() as $items) {
                            $menu['items'][$items['id']] = $items;
                            $menu['parents'][$items['parent_id']][] = $items['id'];

                        }
                        function buildModuleCheckBox($parent, $menu, $modules, $selected_action)
                        {

                            $html = "";
                            if (isset($menu['parents'][$parent])) {
                                $html .= "<ul>\n";

                                foreach ($menu['parents'][$parent] as $itemId) {
                                    if (!isset($menu['parents'][$itemId])) {
                                        $actions = '';
                                        $actions_ar = explode('|', str_replace(',', '|', ($menu['items'][$itemId]['actions'])));


                                        if (count($actions_ar) > 0) {
                                            $actions .= '<ul class="module_action">';
                                            foreach ($actions_ar as $act) {

                                                if ($act != '') {
                                                    $actions .= '<li data-jstree=\'{ "icon" : "fa fa-code-fork" '. (in_array($act, $selected_action[$menu['items'][$itemId]['id']]) ? ', "selected":true  ' : '') .'}\'>';
                                                    $actions .= "<input class='' type='checkbox'
    " . (in_array($act, $selected_action[$menu['items'][$itemId]['id']]) ? ' checked ' : '') . "
    name='actions[" . $menu['items'][$itemId]['id'] . "][]' id='a' value='" . $act . "' title='" . ucwords(str_replace('_', ' ', $act)) . "'> " . ucwords(str_replace('_', ' ', $act)) . " </li>";
                                                }
                                            }
                                            $actions .= '</ul>';

                                        }
                                        $html .= '<li data-jstree=\'{ '.((in_array($menu['items'][$itemId]['id'], $modules)) ? '"opened": true, "selected":true ' : '').' }\'>';
                                        //$html .= '<li>';
                                        $html .= "\n
                                            <input type='checkbox'
                                                                            " . ((in_array($menu['items'][$itemId]['id'], $modules)) ? 'checked' : '') . "
                                                                            name='modules[]' value='" . $menu['items'][$itemId]['id'] . "' class=' multi_checkbox '>
                                                                            " . $menu['items'][$itemId]['module_title'] . $actions . "
                                                                            </li>";
                                    }
                                    if (isset($menu['parents'][$itemId])) {


                                        $html .= '<li data-jstree=\'{ '.((in_array($menu['items'][$itemId]['id'], $modules)) ? '"opened": true, "selected":true ' : '').' }\'>';
    //$html .= '<li>';

                                        $html .= "<input " . ((in_array($menu['items'][$itemId]['id'], $modules)) ? 'checked' : '') . "
    type='checkbox' name='modules[]' value='" . $menu['items'][$itemId]['id'] . "' class=' multi_checkbox '>
    " . $menu['items'][$itemId]['module_title'];


                                        $html .= buildModuleCheckBox($itemId, $menu, $modules, $selected_action);
                                        $html .= "\n</li>";
                                    }
                                }
                                $html .= "\n</ul>";
                            }
                            return $html;
                        }


                        echo buildModuleCheckBox(0, $menu, $modules, $selected_action);

                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <input type="submit" class="btn btn-success m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit');?>">
                        <input type="button" next-url="<?php echo admin_url($this->_route . '/form');?>" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit & New');?>">
                        <button type="reset" class="btn btn-metal m-btn m-btn--icon m-btn--pill m-btn--air"><?php echo __('Cancel');?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
<?php include __DIR__ . "/../includes/module_footer.php";?>
<script type="text/javascript">
    (function ($) {

        var tree = $("#tree-module").jstree({
            'plugins' : ["checkbox"],
            'checkbox' : {"three_state": false}
        });

        tree.on("changed.jstree", function (e, data) {
            console.log(data);
            if(data.node) {
                $('#' + data.node.id + '_anchor').find('input:checkbox').prop('checked', data.node.state.selected);
            }
            /*if (data.action == 'deselect_node') {
                tree.jstree("close_node", "#" + data.node.id);
            }
            else {
                tree.jstree("open_node", "#" + data.node.id);
            }*/
        });

        /*$(document).ready(function () {
            $('.tree-form').on('submit', function (e) {
                $('.jstree input[type=checkbox]', this).each(function () {
                    $(this).prop('checked', false).removeAttr('checked');
                });
                $('.jstree-undetermined', this).each(function () {
                    $(this).parent().find('input').prop('checked', true);
                });
                $('.jstree-clicked', this).each(function () {
                    $(this).find('input').prop('checked', true);
                });
            });
        });*/
    })(jQuery)
</script>
<script>

    $("#user_types").validate({
        // define validation rules
        rules: {
            'user_type': {
                required: true,
                remote: '<?php echo admin_url($this->_route . '/AJAX/validate/' . $row->id)?>',
            },
            'login': {
                required: true,
            },
        },
        messages: {
            'user_type': {required: 'User Type is required',remote: 'This User Type is already exist',},
            'login': {required: 'Login is required',},
        },
        //display error alert on form submit
        invalidHandler: function (event, validator) {
            /*var alert = $('#_msg');
            alert.removeClass('m--hide').show();
            mApp.scrollTo(alert, -200);*/
            mUtil.scrollTo(validator.errorList[0].element, -200);
        },

        submitHandler: function (form) {
            form.submit();
        }

    });
</script>