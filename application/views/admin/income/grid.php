<?php
/**
* Adnan Bashir
* E: developer.adnan@gmail.com
* P: +92-332-3103324
* S: developer.adnan
*/

$form_buttons = ['new', 'delete', 'import', 'export'];
$status_column_data = get_enum_values($this->table, 'status');
$cheque_status_column_data = get_enum_values($this->table, 'cheque_status');

include __DIR__ . "/../includes/module_header.php"; ?>
<div class="m-portlet__body p-1">

    <script src="<?php echo asset_url('app/js/echarts.min.js', true); ?>"></script>
    <?php //if (user_do_action('income_expense', 'dashboard'))
    { ?>
        <script>
            var basic_option = {
                title: {
                    x: 'center'
                },
                tooltip: {
                    trigger: 'item',
                    extraCssText: 'border-radius: 2px;font-family: Poppins; font-size: 12px;',
                    formatter: function (params, ticket, callback) {
                        //console.log(params);
                        return params.data.name + ' : ' + numeral(params.data.value).format('0,0');
                    }
                    //formatter: "{a} <br/>{b} : {c}"
                },
                legend: {
                    x: 'center',
                    y: 'bottom',
                },
                toolbox: {
                    show: true,
                    feature: {
                        mark: {show: true},
                        dataView: {
                            show: false,
                            readOnly: false,
                            title: 'Data View',
                            lang: ['Data View', 'Cancel', 'Reset']
                        },
                        magicType: {
                            show: true, title: {
                                line: 'Line',
                                bar: 'Bar',
                                stack: 'Stack',
                                tiled: 'Tiled',
                                force: 'Force',
                                chord: 'Chord',
                                pie: 'Pie',
                                funnel: 'Funnel'
                            },
                            type: ['pie']
                            //type: ['pie,', 'line', 'bar', 'stack', 'tiled']
                        },
                        restore: {show: true, title: 'Reset'},
                        saveAsImage: {
                            show: true, title: 'Save as Image',
                            type: 'png',
                            lang: ['Click to Save']
                        }
                    }
                },
                color: ['#f00b07', '#2f4554', '#0975a8', '#d48265', '#91c7ae', '#749f83', '#ca8622', '#bda29a', '#6e7074', '#546570', '#c4ccd3'],
                calculable: true,

            };
        </script>
        <div class="col-xl-12">
            <div class="m-portlet" style="height: 420px;">
                <div class="m-portlet__body p-1">
                    <div id="income-expense-chart" style="width: 100%;height:400px;"></div>
                </div>

                <script>
                    var ieChart = echarts.init(document.getElementById('income-expense-chart'));
                    ieChart.setOption(basic_option);
                    ieChart.setOption({
                        toolbox: {
                            /*left: 'center',
                            top: 25,*/
                            itemSize: 20,
                            feature: {
                                magicType: {
                                    type: ['line', 'bar', 'stack', 'tiled']
                                },
                            }
                        }
                    });

                    ieChart.showLoading();
                    $(document).ready(function () {
                        $.getJSON('<?php echo admin_url('profile/AJAX/chart/income-yearly');?>').done(function (data) {
                            console.log(data);
                            ieChart.hideLoading();
                            ieChart.setOption({
                                title: {
                                    text: data.text,
                                    subtext: data.subtext
                                },
                                tooltip: {
                                    formatter: function (params, ticket, callback) {
                                        //console.log(params);
                                        return  params.seriesName + '<br>' + params.data.name + ' : ' + numeral(params.data.value).format('0,0');
                                    }
                                },
                                xAxis : [
                                    {
                                        type : 'category',
                                        boundaryGap : false,
                                        data : data.legend_data
                                    }
                                ],
                                yAxis : [
                                    {
                                        type : 'value'
                                    }
                                ],
                                series : [
                                    {
                                        name:'Income',
                                        type:'line',
                                        smooth:true,
                                        itemStyle: {
                                            normal: {
                                                areaStyle: { type: 'default' }
                                            }
                                        },
                                        markPoint : {
                                            data : [
                                                { type : 'max', name: 'Maximum' }
                                            ],
                                            label : {
                                                normal : {
                                                    position : 'top',
                                                    textStyle : {
                                                        //color : ib_graph_secondary_color
                                                    }
                                                }
                                            }
                                        },
                                        markLine : {
                                            data : [
                                                { type : 'average', name : 'Average' }
                                            ]
                                        },
                                        data:data.Income
                                    }
                                ]
                            });
                        });
                    });
                </script>
            </div>
        </div>

    <?php } ?>

    <?php
    if ($this->AJAX_grid) {
        echo $record_selection;
        echo '<div class="m_datatable" id="ajax_data"></div>';
        echo $grid_script;
    } else {
        $grid = new Grid();
        $grid->id_field = $this->id_field;

        $grid->grid_buttons = ['edit', 'view', 'duplicate', 'delete', 'status' => ['status' => 'status']];

        $grid->status_column_data = ['status' => '', 'cheque_status' => $cheque_status_column_data];
        $grid->custom_func = ['status' => 'status_options', 'cheque_status' => 'status_options', 'ordering' => 'ordering_input'];

        $grid->init($query);

        $grid->dt_column(['id' => ['title' => 'ID', 'width' => '20', 'align' => 'center', 'th_align' => 'center', 'hide' => true]]);
        $grid->dt_column(['status' => ['overflow' => 'initial', 'align' => 'center', 'th_align' => 'center', 'filter_value' => '=', 'input_options' => ['options' => $grid->cheque_status_column_data, 'class' => '', 'onchange' => true]]]);
        $grid->dt_column(['cheque_status' => ['overflow' => 'initial', 'align' => 'center', 'th_align' => 'center', 'filter_value' => '=', 'input_options' => ['options' => $grid->status_column_data, 'class' => '', 'onchange' => true]]]);
        $grid->dt_column(['ordering' => ['width' => '90', 'align' => 'center', 'th_align' => 'center']]);
        $grid->dt_column(['created' => ['input_options' => ['class' => 'm_datepicker']]]);
        
        echo $grid->showGrid();
    }
    ?>
</div>
<?php include __DIR__ . "/../includes/module_footer.php"; ?>
