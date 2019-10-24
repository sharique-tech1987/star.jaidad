<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Actions_btn
 * @property Actions_btn $actions_btn
 */
class Actions_btn
{
    var $base_url = '';

    var $module = '';
    var $user_actions = '';
    var $module_actions;

    var $status_column_data = [];

    private $buttons = [];
    private $public_buttons = [];

    //private


    function __construct()
    {
        if(empty($this->module)){
            $this->module = getUri(2);
        }
        if(empty($this->base_url)){
            $this->base_url = admin_url();
        }

        $this->init();
        $this->app_grid_buttons();
    }


    function init(){

        $ci =& get_instance();
        $user_type_id = _session('user_type');

        $SQL = "SELECT
                user_type_module_rel.actions AS user_actions
                , modules.actions
            FROM users
                INNER JOIN user_type_module_rel ON (users.user_type_id = user_type_module_rel.user_type_id)
                INNER JOIN modules ON (user_type_module_rel.module_id = modules.id)
            WHERE user_type_module_rel.user_type_id='{$user_type_id}'
            AND modules.module = '{$this->module}'";

        $row = $ci->db->query($SQL)->row();

        $this->user_actions = array_unique(explode('|', str_replace(array('update'), array('edit'), $row->user_actions)));
        $this->module_actions = array_unique(explode('|', str_replace(array('update'), array('edit'), $row->actions)));

    }

    /**
     * @param $action
     * @param array $params {_module}/form/{_id}/{QUERY_STR}
     * @param array $dropdown_attr
     */
    function add_button($action, $params = array(), $public = false){

        if ($public) {
            $this->public_buttons[] = $action;
        }

        $_params = array(
            'title' => '',
            'href' => '',
            'class' => 'm-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill',
            'icon_cls' => 'la la-edit',
            'dropdown_items' => [],
            'dropdown_items_cls' => []
        );
        $params = array_merge($_params, $params);

        $icon_cls = $params['icon_cls'];

        if(count($params['dropdown_items']) == 0) {
            $_button_HTML = "<a action='{$action}'";
            foreach ($params as $atr => $param) {
                if (in_array($atr, ['icon_cls', 'dropdown_items', 'dropdown_items_cls'])) continue;
                $_button_HTML .= $atr . "='{$param}'";
            }
            $_button_HTML .= "><i class='{$icon_cls}'></i></a>";
        } else {
            $_button_HTML = '<div class="dropdown dropup">';
            $_button_HTML .= '<a action=\'{$action}\' href="#" class="'.$params['class'].'" title="'.$params['title'].'" data-toggle="dropdown">';
            $_button_HTML .= '<i class="'.$icon_cls.'"></i>';
            $_button_HTML .= '</a>';
            $_button_HTML .= '<div class="dropdown-menu dropdown-menu-right">';
            foreach ($params['dropdown_items'] as $k => $item) {
                $href = replace_columns($params['href'], ['dropdown_item' => $item]);

                $_button_HTML .= '<a class="dropdown-item" href="'.$href.'">';
                if(isset($params['dropdown_items_cls'][$k]) && !empty($params['dropdown_items_cls'][$k])) {
                    $_button_HTML .= '<i class="' . $params['dropdown_items_cls'][$k] . '"></i>';
                }
                $_button_HTML .= $item . '</a>';

            }
            $_button_HTML .= '</div></div>';
        }

        $this->buttons[$action] = $_button_HTML;
    }

    function grid_buttons($rows, $id_field = 'id', $buttons){

        $this->module_actions = array_merge($this->user_actions, $this->public_buttons);

        $HTML = '';
        foreach ($buttons as $key => $button) {
            $rows['_module'] = $this->module;
            $rows['_id'] = $rows[$id_field];

            if(!is_array($button)){
                $__button = $button;
                if(!in_array($__button, $this->module_actions)) continue;
                $rows['QUERY_STR'] = getVar($__button);
                $HTML .= replace_columns($this->buttons[$__button], $rows);
            }else{
                $__button = $key;
                if(!in_array($__button, $this->module_actions)) continue;

                $QUERY_STR = [];
                foreach ($button as $__attr => $__tag) {
                    array_push($QUERY_STR, str_replace(['{', '}'], '', replace_columns($__attr . '={' . $__tag . '} ', $rows)));
                }
                $rows['QUERY_STR'] = '?' . join('&', $QUERY_STR);

                $HTML .= replace_columns($this->buttons[$__button], $rows);
            }
        }

        return $HTML;
    }

    function app_grid_buttons(){

        $params = [
            'title' => 'Edit',
            'href' => $this->base_url . '{_module}/form/{_id}/{QUERY_STR}',
            'icon_cls' => 'la la-edit',
        ];
        $this->add_button('edit', $params);


        $params = [
            'title' => 'Delete',
            'class' => 'btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill',
            'href' => $this->base_url . '{_module}/delete/{_id}/{QUERY_STR}',
            'icon_cls' => 'la la-trash',
        ];
        $this->add_button('delete', $params);

        $params = [
            'title' => 'Status',
            'href' => $this->base_url . '{_module}/status/{_id}/{dropdown_item}/{QUERY_STR}',
            'class' => 'btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill',
            'icon_cls' => 'la la-ellipsis-h',
            'dropdown_items' => ['Active', 'Inactive'],
            //'dropdown_items_cls' => ['la la-edit', 'la la-print'],
        ];
        $this->add_button('-status', $params);


        $params = [
            'title' => 'View',
            'href' => $this->base_url . '{_module}/view/{_id}/',
            'icon_cls' => 'la la-eye',
        ];
        $this->add_button('view', $params);

        $params = [
            'title' => 'Download',
            'href' => $this->base_url . '{_module}/download/{_id}/',
            'icon_cls' => 'la la-download',
        ];
        $this->add_button('download', $params);

        $params = [
            'title' => 'Duplicate',
            'href' => $this->base_url . '{_module}/duplicate/{_id}/',
            'icon_cls' => 'la la-copy',
        ];
        $this->add_button('duplicate', $params);
    }


}