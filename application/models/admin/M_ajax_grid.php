<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class M_AJAX_grid
 * @property Admin_template $admin_template
 */
class M_ajax_grid extends CI_Model
{

    var $limit = 25;

    var $cookie = true;
    var $web_storage = true;
    var $paging = true;
    var $filtering = true;
    var $sorting = true;
    var $theme = '';
    var $wrapper_class = '';
    var $scroll = true;
    var $footer = true;

    var $page_size_select = array('25' => '25', '50' => '50', '100' => '100', 'all' => 'All');

    var $search_filter_column = 'filter';
    var $search_filter_options = array(
        '%-%' => 'Contain',
        '%!-%' => 'Not Contain',
        '-%' => 'Start With',
        '%-' => 'End With',
        '=' => 'Equal',
        '!=' => 'Not Equal',
        '>' => 'Greater Then',
        '>=' => 'Greater Then Equal',
        '<' => 'Less Then',
        '=<' => 'Less Then Equal',
    );

    var $columns = array();
    var $rows = array();
    var $total_rows = 0;

    var $db_error = '';


    function __construct()
    {
        parent::__construct();
    }


    function init($query){

        $result = $this->db->query($query);
        if(!$result){
            $data['status'] = false;
            $this->db_error = $this->db->error()['message'];
        }


        $list_fields = $result->list_fields();
        foreach ($list_fields as $field) {
            array_push($this->columns, $field);
        }

        $this->rows = $result->result_array();
        $this->total_rows = $this->db->found_rows();
    }
    /**
     * @return Admin_template
     */
    public function data()
    {
        $data = ['status' => true];

        if($this->total_rows){
            $JSON['status'] = true;
            $JSON['data'] = $this->rows;
            $JSON['total'] = $this->total_rows;
        } else {
            $JSON['status'] = false;
            $JSON['message'] = $this->db_error;
        }

        return $JSON;
    }


    function columns($columns){

        foreach ($columns as $column => $attr) {
            $this->columns[$column] = $column[key($column)];
        }

    }

    private function get_columns(){
        $JSON = [];
        foreach ($this->columns as $column => $attr) {
            $_FIELD = [];
            $_FIELD['field'] = $column;
            $_FIELD['title'] = ucwords(str_replace('_', ' ', $column));
            $_FIELD['sortable'] = $this->sorting;
            $_FIELD['filterable'] = $this->filtering;

            $_FIELD = array_merge($_FIELD, $attr);
            array_push($JSON, $_FIELD);
        }

        return $JSON;
    }


    function script(){
        ?>
        <script>

            //== Class definition
            var RemoteAjaxDemo = function() {
                var ajax_grid = function() {
                    var datatable = $('.m_datatable').mDatatable({
                        data: {
                            type: 'remote',
                            source: {
                                read: {
                                    method: 'GET',
                                    url: '<?php echo admin_url($this->_route);?>',
                                    map: function(raw) {
                                        // sample data mapping
                                        var dataSet = raw;
                                        if (typeof raw.data !== 'undefined') {
                                            dataSet = raw.data;
                                        }
                                        return dataSet;
                                    },
                                },
                            },
                            pageSize: <?php echo intval($this->limit);?>,
                            saveState: {
                                cookie: <?php echo $this->cookie;?>,
                                webstorage: <?php echo $this->web_storage;?>,
                            },
                            serverPaging: <?php echo $this->paging;?>,
                            serverFiltering: <?php echo $this->filtering;?>,
                            serverSorting: <?php echo $this->sorting;?>,
                        },

                        // layout definition
                        layout: {
                            theme: '<?php echo $this->theme;?>', // datatable theme
                            class: '<?php echo $this->wrapper_class;?>', // custom wrapper class
                            scroll: <?php echo $this->scroll;?>, // enable/disable datatable scroll both horizontal and vertical when needed.
                            footer: <?php echo $this->footer;?> // display/hide footer
                        },

                        // column sorting
                        sortable: <?php echo $this->sorting;?>,

                        pagination: <?php echo $this->paging;?>,

                        toolbar: {
                            items: {
                                pagination: {
                                    pageSizeSelect: [<?php echo join(',', $this->page_size_select);?>],
                                },
                            },
                        },

                        search: {
                            input: $('#generalSearch'),
                        },

                        // columns definition
                        columns: [<?php echo json_encode($this->get_columns());?>],
                    });

                    var query = datatable.getDataSourceQuery();

                    $('#m_form_status').on('change', function() {
                        // shortcode to datatable.getDataSourceParam('query');
                        var query = datatable.getDataSourceQuery();
                        query.Status = $(this).val().toLowerCase();
                        // shortcode to datatable.setDataSourceParam('query', query);
                        datatable.setDataSourceQuery(query);
                        datatable.load();
                    }).val(typeof query.Status !== 'undefined' ? query.Status : '');

                    $('#m_form_type').on('change', function() {
                        // shortcode to datatable.getDataSourceParam('query');
                        var query = datatable.getDataSourceQuery();
                        query.Type = $(this).val().toLowerCase();
                        // shortcode to datatable.setDataSourceParam('query', query);
                        datatable.setDataSourceQuery(query);
                        datatable.load();
                    }).val(typeof query.Type !== 'undefined' ? query.Type : '');

                    $('#m_form_status, #m_form_type').selectpicker();

                };

                return {
                    // public functions
                    init: function() {
                        ajax_grid();
                    },
                };
            }();

            jQuery(document).ready(function() {
                RemoteAjaxDemo.init();
            });
        </script>
        <?php
    }

}