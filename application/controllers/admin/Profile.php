<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class profile * @property M_Modules $m_modules
 * @property M_cpanel $m_cpanel
 * @property M_users $m_users
 * @property M_users $module
 * @property M_sms_holidays $m_sms_holidays
 * @property M_sms_events $m_sms_events
 */
class Profile extends CI_Controller
{
    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $_info;
    var $_route;
    var $AJAX_grid = false;
    var $where = '';

    /**
     * *****************************************************************************************************************
     * @method m_profile __construct
     * @model M_profile | m_profile 
     * *****************************************************************************************************************
     */
    function __construct()
    {
        parent::__construct();

        //TODO:: Check Login & Module -> profile
        $this->m_cpanel->checkLogin();

        //TODO:: Module Name
        $this->module_name = 'users';//getUri(2);

        $this->module = 'm_' . $this->module_name;
        $this->load->model(ADMIN_DIR . $this->module);
        $this->module = $this->{$this->module};

        $this->table = $this->module->table;
        $this->id_field = $this->module->id_field;

        $this->_route = $this->router->class;
        $this->_info = getModuleDetail('users');

        $this->where = "";

        if (AJAX_GRID && $this->AJAX_grid) {
            $this->AJAX_grid = true;
        }
        //TODO:: Module Language
        load_lang($this->module_name, true);
    }


    /**
     * *****************************************************************************************************************
     * @method profile index | Grid | listing
     * *****************************************************************************************************************
     */
    public function index()
    {
        /** -------- Breadcrumb */
        $this->breadcrumb->add_item(__('Edit Profile'), admin_url($this->_route));

        $id = _session(ADMIN_SESSION_ID);
        $data = [];

        if ($id > 0) {
            $where = $this->where;
            $row = $data['row'] = $this->module->row($id, $where);
            if ($row->{$this->id_field} == 0) {
                $this->admin_template->not_found();
            }
        }

        $this->admin_template->load($this->module_name . '/edit_profile', $data);
    }


    /**
     * *****************************************************************************************************************
     * @method profile update
     * *****************************************************************************************************************
     */
    public function update()
    {
        $id = _session(ADMIN_SESSION_ID);

        if ($this->module->validate($id) && $id > 0) {
            if ($this->module->update($id)) {
                $user = $this->module->row($id);
                $logged_in_string = $user->username . '|' . $user->password;
                set_cookie('logged_in', $logged_in_string, time() + 60 * 60 * 24 * 30);

                set_notification(__('Record has been updated'), 'success');
            } else {
                set_notification(__('Some error occurred'), 'error');
            }

            redirect(admin_url('profile'));
        } else {

            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/edit_profile', $data);
        }
    }



    /**
     * *****************************************************************************************************************
     * @method profile AJAX actions
     * *****************************************************************************************************************
     */
    function AJAX($action, $id)
    {
        $JSON = [];
        switch ($action) {
            case 'delete_img':
                $field = getUri(6);
                $del_img = array($field => ASSETS_DIR . "front/{$this->table}/");
                $JSON['status'] = delete_rows($this->table, "$this->id_field='{$id}'", false, '', key($del_img), $del_img);
                $JSON['message'] = ucwords($field) . ' has been deleted!';
                break;
            case 'ordering':
                $ordering = getVar('ordering');
                $JSON['status'] = save($this->table, ['ordering' => $ordering[$id]], "id='{$id}'");
                $JSON['message'] = 'updated!';
                break;
            case 'validate':
                $field = array_keys($_GET)[0];
                $value = getVar($field);
                $WHERE = "AND `{$field}`='{$value}'";
                if($id > 0){ $WHERE .= " AND {$this->table}.`{$this->id_field}` != '{$id}'"; }

                $row = $this->module->row(0, $WHERE);
                if($row->id > 0){
                    exit('false');
                }
                exit('true');
                break;
            case 'properties_projects':
                $type = getVar('type');
                $options = '<option value="">- Select '.$type.' -</option>';
                if($type == 'Projects'){
                    $SQL = "SELECT id,title FROM projects WHERE 1 ";
                } else{
                    $SQL = "SELECT id,title FROM properties WHERE 1 ";
                }
                $options .=  selectBox($SQL, '');
                exit($options);
                break;
            case 'vehicles_checkbox':
                $campus_id = getVar('campus_id');
                $vehicle_ids = [];
                if($id > 0){
                    $vehicle_ids = singleColArray("SELECT vehicle_id FROM sms_vehicle_route_rel WHERE route_id='{$id}'", 'vehicle_id');
                }
                $vehicle = _vehicles_list($campus_id);
                if (count($vehicle) > 0) {
                    echo '<div class="m-checkbox-list search-block-v">';
                    foreach ($vehicle as $v_id => $vehicle) {
                        ?>
                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                            <input type="checkbox" <?php echo _checkbox($vehicle_ids, $v_id)?> name="vehicle_ids[]" id="vehicle_ids" value="<?php echo $v_id;?>"> <?php echo $vehicle;?>
                            <span></span>
                        </label>
                        <?php
                    }
                    echo '</div>';
                }
                exit;
                break;
            case 'drivers':
                $q = getVar('q');
                $campus_id = getVar('campus_id');
                $user_type_id = get_option('driver_type_id');
                $where = " AND TRIM(CONCAT(IFNULL(LOWER(users.first_name), ''), ' ', IFNULL(LOWER(users.last_name), ''), ' - ', sms_staff_rel.cnic)) LIKE '%{$q}%'";
                $where .= " AND users.user_type_id='{$user_type_id}'";
                //if($campus_id > 0)
                {
                    //$where .= " AND campus_id='{$campus_id}'";
                }
                $results = _staff_list($where);
                //echo '<pre>'; print_r($this->db->last_query()); echo '</pre>';
                $JSON['results'] = [];
                foreach ($results as $id => $text) {
                    array_push($JSON['results'], ['id' => $id, 'text' => $text]);
                }
                break;
            case 'holidays':
                $this->load->model(ADMIN_DIR . 'm_sms_holidays');

                $campus_id = getVar('campus_id');
                $start = date('Y-m-d', getVar('start'));
                $end =  date('Y-m-d', getVar('end'));
                $where = '';
                $where .= "AND date_from BETWEEN '{$start}' AND '{$end}' AND date_to BETWEEN '{$start}' AND '{$end}'";

                $rows = $this->m_sms_holidays->rows($where);

                $full_calendar = [];
                if (count($rows) > 0) {
                    foreach ($rows as $row) {
                        $data = [
                            'id' => $row->id,
                            'title' => $row->title,
                            'description' => $row->note,
                            'className' => 'm-fc-event--light m-fc-event--solid-primary',
                            'start' => $row->date_from,
                            'end' => $row->date_to,
                        ];
                        array_push($full_calendar, $data);
                    }
                }
                $period = new DatePeriod(
                    new DateTime($start),
                    new DateInterval('P1D'),
                    new DateTime($end)
                );

                $weekend = unserialize(get_option('weekend'));
                foreach ($period as $key => $value) {
                    $day_name = $value->format('l');
                    $day = $value->format('d');
                    if(in_array($day_name, $weekend)){
                        $data = [
                            'id' => $day,
                            'title' => 'Weekend',
                            'description' => $day_name . ' holiday',
                            'eventBackgroundColor' => '#ededed',
                            //'className' => 'm-fc-event--danger m-fc-event--solid-warning',
                            'start' => $value->format('Y-m-d'),
                            'end' => $value->format('Y-m-d'),
                        ];
                        array_push($full_calendar, $data);
                    }
                }

                /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
                | Events
                *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
                $this->load->model(ADMIN_DIR . 'm_sms_events');
                $where = '';
                $where .= "AND from_date BETWEEN '{$start}' AND '{$end}' AND end_date BETWEEN '{$start}' AND '{$end}'";
                $rows = $this->m_sms_events->rows($where);

                //$full_calendar = [];
                if (count($rows) > 0) {
                    foreach ($rows as $row) {
                        $data = [
                            'id' => $row->id,
                            'title' => $row->title,
                            'description' => '<h6>' . $row->title . '</h6>' . __('Venue') . ': ' . $row->venue,
                            'className' => 'm-fc-event--danger m-fc-event--solid-warning',
                            'start' => $row->from_date,
                            'end' => $row->end_date,
                        ];
                        //if(in_array(user_info('id'), $row->user_type_id))
                        {
                            array_push($full_calendar, $data);
                        }
                    }
                }

                $JSON = $full_calendar;
                break;

            case 'chart':
                $_type =  getUri(5);
                switch ($_type) {
                    case 'class_students':
                        $SQL = "SELECT COUNT(users.id) AS total, classes.class FROM users
                                INNER JOIN classes ON (classes.id = users.data->>'$.class')
                                GROUP BY users.data->>'$.class'";

                        $ch_rows = $this->db->query($SQL)->result();
                        $chart_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $chart_data['legend_data'][] = $ch_row->class;
                                $chart_data['series_data_pie'][] = ['value' => $ch_row->total, 'name' => $ch_row->class];
                            }
                        }
                        $JSON = $chart_data;
                        $JSON['text'] = __('Student Statistics');
                        $JSON['subtext'] = __('Class Statistics');
                    break;
                    case 'users':
                        $user_type[] = get_option('admin_user_type');

                        $ch_rows = _count_users(0, 0, " AND user_types.id NOT IN(" . join(',', $user_type) . ")");

                        $chart_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $chart_data['legend_data'][] = $ch_row->user_type;
                                $chart_data['series_data_pie'][] = ['value' => $ch_row->total, 'name' => $ch_row->user_type];
                            }
                        }
                        $JSON = $chart_data;
                        $JSON['text'] = __('User Statistics');
                        $JSON['subtext'] = __('');
                    break;
                    case 'income-expense':
                        $where = '';
                        $SQL = "SELECT `type` , SUM(amount) AS total
                                FROM acc_transactions 
                                WHERE 1 {$where} GROUP BY `type`";

                        $ch_rows = $this->db->query($SQL)->result();
                        $chart_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $chart_data['legend_data'][] = $ch_row->type;
                                $chart_data['series_data_pie'][] = ['value' => $ch_row->total, 'name' => $ch_row->type];
                            }
                        }
                        $JSON = $chart_data;
                        $JSON['text'] = __('Income & Expense');
                        $JSON['subtext'] = __('');

                        break;
                    case 'income-expense-yearly':
                        $where = '';
                        $year = date('Y');
                        $sub_title = __('Year') . ' ' . $year;
                        //$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $SQL = "SELECT `type`
                                , SUM(amount) AS total
                                , MONTH(`date`) AS `month`
                                FROM acc_transactions 
                                WHERE 1 {$where}
                                AND YEAR(`date`) ='{$year}'
                                GROUP BY `type`, `month`";

                        $ch_rows = $this->db->query($SQL)->result();

                        $ch_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $ch_data[$ch_row->month][$ch_row->type] = $ch_row->total;
                            }
                        }

                        $chart_data = [];
                        for ($i = 1; $i <= 12; $i++) {
                            $ch_row = $ch_data[$i];
                            $d_i = (strlen($i) == 1 ? '0' . $i : $i);
                            $month_name = date('F', strtotime("01-{$d_i}-{$year}"));
                            $chart_data['legend_data'][] = $month_name;
                            $chart_data['Income'][] = ['value' => intval($ch_row['Income']), 'name' => $month_name];
                            $chart_data['Expense'][] = ['value' => intval($ch_row['Expense']), 'name' => $month_name];
                        }

                        $JSON = $chart_data;
                        //echo '<pre>'; print_r($JSON); echo '</pre>';
                        $JSON['text'] = __('Income & Expense');
                        $JSON['subtext'] = __($sub_title);
                    break;
                    case 'income-expense-monthly':
                        $where = '';
                        $month = date('m');
                        if(!empty($month)){
                            $where .= " AND MONTH(`date`) ='{$month}' ";
                        }
                        $year = date('Y');
                        $sub_title = date('F Y', strtotime("01-{$month}-{$year}"));
                        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $SQL = "SELECT `type`
                                , SUM(amount) AS total
                                , DAY(`date`) AS `day`
                                FROM acc_transactions 
                                WHERE 1 {$where}
                                AND YEAR(`date`) ='{$year}'
                                GROUP BY `type`, `day`";

                        $ch_rows = $this->db->query($SQL)->result();

                        $ch_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $ch_data[$ch_row->day][$ch_row->type] = $ch_row->total;
                            }
                        }

                        $chart_data = [];
                        for ($i = 1; $i <= $days; $i++) {
                            $ch_row = $ch_data[$i];

                            $chart_data['legend_data'][] = $i;
                            $chart_data['Income'][] = ['value' => intval($ch_row['Income']), 'name' => $i];
                            $chart_data['Expense'][] = ['value' => intval($ch_row['Expense']), 'name' => $i];
                        }

                        $JSON = $chart_data;
                        //echo '<pre>'; print_r($JSON); echo '</pre>';
                        $JSON['text'] = __('Income & Expense');
                        $JSON['subtext'] = __($sub_title);
                    break;

                    case 'income-yearly':
                        $where = '';
                        $year = date('Y');
                        $sub_title = __('Year') . ' ' . $year;
                        //$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $SQL = "SELECT SUM(amount) AS total , MONTH(`created`) AS `month`
                                FROM income 
                                WHERE 1 {$where} AND YEAR(`created`) ='{$year}'
                                GROUP BY `month`";

                        $ch_rows = $this->db->query($SQL)->result();

                        $ch_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $ch_data[$ch_row->month] = $ch_row->total;
                            }
                        }

                        $chart_data = [];
                        for ($i = 1; $i <= 12; $i++) {
                            $ch_row = $ch_data[$i];
                            $d_i = (strlen($i) == 1 ? '0' . $i : $i);
                            $month_name = date('F', strtotime("01-{$d_i}-{$year}"));
                            $chart_data['legend_data'][] = $month_name;
                            $chart_data['Income'][] = ['value' => intval($ch_row), 'name' => $month_name];
                        }

                        $JSON = $chart_data;
                        //echo '<pre>'; print_r($JSON); echo '</pre>';
                        $JSON['text'] = __('Income');
                        $JSON['subtext'] = __($sub_title);
                        break;

                    case 'search-property-types':
                        $where = '';
                        $year = date('Y');
                        $month = date('m');
                        $SQL = "SELECT q_params
                                FROM search_queries
                                WHERE 1  {$where}
                                AND MONTH(`created`) ='{$month}'
                                AND YEAR(`created`) ='{$year}'";
                        $ch_rows = $this->db->query($SQL)->result();
                        $ch_rows = result_to_json($ch_rows, 'q_params');

                        $property_rows = array();
                        $PROPERTY_TYPE_SQL = "SELECT * FROM `property_types` WHERE status='Active' ORDER BY ordering ASC";
                        $property_type_rows = $this->db->query($PROPERTY_TYPE_SQL)->result();
                        foreach ($property_type_rows as $property_type_row) {
                            $obj = new stdClass();
                            $obj->property_type = $property_type_row->type;
                            $obj->property_count = 0;
                            $property_rows[$property_type_row->id] = $obj;
                        }
                        foreach ($ch_rows as $ch_row) {
                            if(!empty($ch_row->type_id) ) {
                                if (array_key_exists($ch_row->type_id, $property_rows)) {
                                    $obj = $property_rows[$ch_row->type_id];
                                    $obj->property_count = $obj->property_count + 1;
                                    $property_rows[$ch_row->type_id] = $obj;
                                }
                            }
                        }
                        $chart_data = [];
                        if (count($property_rows) > 0) {
                            foreach ($property_rows as $key => $ch_row) {
                                $chart_data['legend_data'][] = $ch_row->property_type;
                                $chart_data['property_type_data_pie'][] = ['value' => $ch_row->property_count, 'name' => $ch_row->property_type];
                            }
                        }
                        $JSON = $chart_data;
                        $JSON['text'] = __('Search By Property Types');
                        $JSON['subtext'] = __('');

                        break;

                    case 'search-city':
                        $where = '';
                        $year = date('Y');
                        $month = date('m');
                        $SQL = "SELECT cities.city
                                , count(q_params->>'$.city_id') city_count
                                FROM search_queries
                                INNER JOIN
                                cities ON(cities.id=q_params->>'$.city_id')
                                WHERE 1 
                                AND q_params->>'$.city_id' > 0
                                AND MONTH(`created`) ='{$month}'
                                AND YEAR(`created`) ='{$year}'
                                GROUP BY q_params->>'$.city_id'
                                ORDER BY city_count DESC
                                LIMIT 0,5";

                        $ch_rows = $this->db->query($SQL)->result();
                        $chart_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $chart_data['legend_data'][] = $ch_row->city;
                                $chart_data['cities_data_pie'][] = ['value' => $ch_row->city_count, 'name' => $ch_row->city];
                            }
                        }
                        $JSON = $chart_data;
                        $JSON['text'] = __('Top 5 Search Cities');
                        $JSON['subtext'] = __('');

                        break;

                    case 'search-purpose':
                        $where = '';
                        $year = date('Y');
                        $month = date('m');
                        $SQL = "SELECT q_params
                                FROM search_queries
                                WHERE 1  {$where}
                                AND MONTH(`created`) ='{$month}'
                                AND YEAR(`created`) ='{$year}'";
                        $ch_rows = $this->db->query($SQL)->result();
                        $ch_rows = result_to_json($ch_rows, 'q_params');
                        $property_rows = array();
                        foreach ($ch_rows as $ch_row) {
                            if(array_key_exists($ch_row->purpose,$property_rows)){
                                $obj = $property_rows[$ch_row->purpose];
                                $obj->purpose_count = $obj->purpose_count + 1;
                                $property_rows[$ch_row->purpose] = $obj;
                            }else{
                                $obj = new stdClass();
                                $obj->purpose = $ch_row->purpose;
                                $obj->purpose_count = 1;
                                $property_rows[$ch_row->purpose] = $obj;
                            }
                        }
                        $chart_data = [];
                        if (count($property_rows) > 0) {
                            foreach ($property_rows as $key => $ch_row) {
                                $chart_data['legend_data'][] = $ch_row->purpose;
                                $chart_data['series_data_pie'][] = ['value' => $ch_row->purpose_count, 'name' => $ch_row->purpose];
                            }
                        }
                        $JSON = $chart_data;
                        $JSON['text'] = __('Search By Purpose');
                        $JSON['subtext'] = __('');

                        break;
                    case 'income-pie':
                        $where = '';
                        $SQL = "SELECT income_head, SUM(amount) AS total
                                FROM income 
                                WHERE 1 {$where} GROUP BY income_head";

                        $ch_rows = $this->db->query($SQL)->result();
                        $up_chart_rows = [];
                        $chart_data = [];
                        if (count($ch_rows) > 0) {
                            foreach ($ch_rows as $ch_row) {
                                $ch_row->income_head = preg_replace('/\s\#\d+/', '', $ch_row->income_head);
                                if(is_array($up_chart_rows[$ch_row->income_head])){
                                    $up_chart_rows[$ch_row->income_head]['total'] += $ch_row->total;

                                } else{
                                    $up_chart_rows[$ch_row->income_head]['total'] = $ch_row->total;
                                    $up_chart_rows[$ch_row->income_head]['name'] = $ch_row->income_head;
                                }
                                //$chart_data['legend_data'][] = date('M', strtotime("01-{$ch_row->income_head}-" . date('Y')));
                            }

                            foreach ($up_chart_rows as $ch_row) {
                                $chart_data['legend_data'][] = $ch_row['name'];
                                $chart_data['series_data_pie'][] = ['value' => $ch_row['total'], 'name' => $ch_row['name']];
                            }
                            /*foreach ($ch_rows as $ch_row) {
                                $chart_data['legend_data'][] = $ch_row->income_head;
                                $chart_data['series_data_pie'][] = ['value' => $ch_row->total, 'name' => $ch_row->income_head];
                            }*/
                        }
                        $JSON = $chart_data;
                        $JSON['text'] = __('Income');
                        $JSON['subtext'] = __('');

                        break;
                }

                break;
        }

        echo json_encode($JSON);
    }

}

/* End of file profile.php */
/* Location: ./application/controllers/admin/profile.php */