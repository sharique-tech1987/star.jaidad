<?php
/**
 * Developed by Adnan Bashir.
 * Email: pisces_adnan@hotmail.com
 * Autour: Adnan Bashir
 * Date: 5/26/12
 * Time: 12:16 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('get_grid_actions')) {
    /**
     * @param $rows
     * @param $id_field
     * @param array $buttons = array('view' => array('id'), 'edit' => array('id'), 'status' => array('id'), 'delete' => array('id'))
     * @param string $form_name
     * @return string
     */
    function get_grid_actions($rows, $id_field, $buttons, $module_uri = 2, $file_path = array(),$action_privilege = 'private', $site_url = '')
    {
        $CI = & get_instance();
        //$user_actions = $CI->session->userdata('actions');
        $module = getUri($module_uri);
        $user_actions = $CI->db->query("SELECT um.actions FROM users AS u INNER JOIN user_type_module_rel AS um ON (u.user_type_id = um.user_type_id) INNER JOIN modules AS m ON (m.id = um.module_id) WHERE um.user_type_id = '" . intval($CI->session->userdata('user_type')) . "' AND m.`module`='" . addslashes($module) . "'")->row()->actions;

        $user_actions = array_unique(explode('|', str_replace(array('update'), array('edit'), $user_actions))); //$user_actions[$module]

        $actions = array();
        $qstring = array();

        foreach ($buttons as $key => $button) {

            if (is_array($button)) {
                array_push($actions, $key);
                $i = -1;
                foreach ($button as $field => $fields) {
                    if (!is_int($field)) {
                        $qsval = $rows[$fields];
                        $fields = $field;
                    } else {
                        $qsval = ($rows[$fields]);
                    }

                    $i++;
                    $qstring[$key] .= (($i == 0) ? "?" : "&") . $fields . "=" . $qsval;
                }

            } else {
                array_push($actions, $button);
            }

        }

        if ($action_privilege != 'private') {
            $user_actions = $actions;
        }


        $CI =& get_instance();

        if (empty($site_url)) {
            $site_url = $CI->router->class;
            if (getUri(1) == str_replace('/', '', ADMIN_DIR)) {
                $site_url = site_url(ADMIN_DIR . $CI->router->class);
            }
        }

        if (in_array('edit', $actions)) {
            $edit = '<a
                        action="edit"
                        href="' . ($site_url . '/form/' . $rows[$id_field] . '/' . $qstring['edit']) . '"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill">
                        <i class="la la-edit"></i>
                     </a>';
        }

        if (in_array('edit_account', $actions)) {
            $edit_account = '<a
                        action="edit_account"
                        href="' . ($site_url . '/account/' . $rows['user_id'] . '/' . $rows[$id_field]. '/' . $qstring['edit_account']) . '"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-pencil"></i>
                     </a>';
        }

        if (in_array('delete', $actions)) {
            $delete = '<a
                        action="delete"
                        href="' . ($site_url . '/delete/' . $rows[$id_field] . '/' . $qstring['delete']) . '"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-trash"></i>
                     </a>';
        }


        if (in_array('duplicate', $actions)) {
            $duplicate = '<a
                        action="duplicate"
                        href="' . ($site_url . '/duplicate/' . $rows[$id_field] . '/' . $qstring['duplicate']) . '"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-copy"></i>
                     </a>';
        }


        if (in_array('banned_user', $actions)) {
            $banned_user = '<a
                        action="banned_user"
                        href="' . ($site_url . '/banned_user/' . $rows[$id_field] . '/' . $qstring['banned_user']) . '"
                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-remove-sign"></i>
                     </a>';
        }

        if (in_array('status', $actions)) {
            $status = '
                        <a
                            action="status"
                            href="' . ($site_url . '/status/' . $rows[$id_field] . '/' . $qstring['status']) . '"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill color-'.((in_array($rows['status'], array(1, 'Active', 'Approved'))) ? 'check': 'off').'"><i class="la la-'.(in_array($rows['status'], array(1, 'Active', 'Approved')) ? 'la la-plus-circle': 'minus-circle').'"></i>
                        </a>';
        }


        if (in_array('view', $actions)) {
            $view = '<a
                            action="view"
                            href="' . ($site_url . '/view/' . $rows[$id_field] . '/' . $qstring['view']) . '"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-eye"></i>
                         </a>';
        }


                if (in_array('files', $actions)) {
            $files = '<a
                            action="files"
                            href="' . ($site_url . '/files/' . $rows[$id_field] . '/' . $qstring['files']) . '"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-copy"></i>
                         </a>';
        }

        if (in_array('account', $actions)) {
            $account = '<a
                            action="account"
                            href="' . ($site_url . '/account/' . $rows[$id_field] . '/' . $qstring['files']) . '"
                            class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="la la-money"></i>
                         </a>';
        }



        if (in_array('download', $actions)) {

            $download = '
                    <a title="Download" class="grid_button ui_dialog" action="check_status" href="' . $file_path['download'] . '">
                         <img src="' . base_url() . 'images/pictos/download.png" alt=" width="16" height="16">
                    </a>
                ';
        }
        if (in_array('delete_file', $actions)) {

            $delete_file = '
                    <a title="Delete File" class="grid_button ui_dialog" action="check_status" href="' . $file_path['delete_file'] . '">
                         <img src="' . base_url() . 'images/pictos/delete_file.png" alt=" width="16" height="16">
                    </a>
                ';
        }

        /*---------------------------------------------------------------------------------------------*/
        //$user_actions = array('new', 'edit', 'delete', 'print');
        $form_btn = '';
        foreach ($buttons as $key => $button) {
            if (is_array($button)) {
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # @start Modules action Conditions
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                if ($rows['status'] == 'shipped' && $module == 'sales_orders') {
                    unset($user_actions[array_search('edit', $user_actions)]);
                }
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # @End Modules action Conditions
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                if (in_array($key, $user_actions)) {
                    $form_btn .= ${$key};
                }
            } else {
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # @start Modules action Conditions   //continue
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                if ($rows['user_type'] == 'Admin' && $button == 'account') {
                    continue;
                }

                if (!in_array($rows['type'], array('Advertiser')) && $module == 'customers') {
                    if(array_search('testimonials', $user_actions) !== false) unset($user_actions[array_search('testimonials', $user_actions)]);
                    if(array_search('pages', $user_actions) !== false) unset($user_actions[array_search('pages', $user_actions)]);
                    if(array_search('galleries', $user_actions) !== false) unset($user_actions[array_search('galleries', $user_actions)]);
                }

                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # @End Modules action Conditions
                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                //echo '<pre>';print_r($user_actions);echo '</pre>';
                //var_dump($button);


                if (in_array($button, $user_actions)) {
                    $form_btn .= ${$button};
                }
            }
        }

        return $action_btn = $form_btn;
    }
}