<script src="<?php echo asset_url('app/js/echarts.min.js', true); ?>"></script>
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
<div class="row">
    <?php if (user_do_action('student_statistics', 'dashboard')) { ?>
    <div class="col-xl-6">
        <div class="m-portlet" style="height: 420px;">
            <div class="m-portlet__body p-1">
                <div id="class-chart" style="width: 100%;height:400px;"></div>
            </div>
        </div>

        <script>
            var classChart = echarts.init(document.getElementById('class-chart'));
            classChart.setOption(basic_option);
            classChart.showLoading();
            $(document).ready(function () {
                $.getJSON('<?php echo admin_url('profile/AJAX/chart/class_students');?>').done(function (data) {
                    console.log(data);
                    classChart.hideLoading();
                    classChart.setOption({
                        title: {
                            text: data.text,
                            subtext: data.subtext
                        },
                        legend: {
                            data: data.legend_data
                        },
                        series: [{
                            name: 'Class',
                            type: 'pie',
                            roseType: 'area',
                            data: data.series_data_pie,
                            itemStyle: {
                                emphasis: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }]
                    });
                });
            });

            //legendselectchanged
            /*myChart.on('click', function (params) {
                console.log(params);
            });*/
        </script>
    </div>
    <?php } ?>
    <?php if (user_do_action('user_statistics', 'dashboard')) { ?>
    <div class="col-lg-6">
        <div class="m-portlet" style="height: 420px;">
            <div class="m-portlet__body p-1">
                <div id="users-chart" style="width: 100%;height:400px;"></div>
            </div>

            <script>
                var usersChart = echarts.init(document.getElementById('users-chart'));
                usersChart.setOption(basic_option);
                usersChart.showLoading();
                $(document).ready(function () {
                    $.getJSON('<?php echo admin_url('profile/AJAX/chart/users');?>').done(function (data) {
                        console.log(data);
                        usersChart.hideLoading();
                        usersChart.setOption({
                            title: {
                                text: data.text,
                                subtext: data.subtext
                            },
                            legend: {
                                data: data.legend_data
                            },
                            series: [{
                                name: 'User',
                                type: 'pie',
                                roseType: 'area',
                                data: data.series_data_pie,
                                itemStyle: {
                                    emphasis: {
                                        shadowBlur: 10,
                                        shadowOffsetX: 0,
                                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                                    }
                                }
                            }]
                        });
                    });
                });
            </script>
        </div>
    </div>
    <?php } ?>

    <?php if (user_do_action('properties_status_statistics', 'dashboard')) { ?>
        <div class="col-lg-6">
            <div class="m-portlet" style="height: 420px;">
                <div class="m-portlet__body p-1">
                    <div id="properties-status-chart" style="width: 100%;height:400px;"></div>
                </div>

                <script>
                    var propertiesStatusChart = echarts.init(document.getElementById('properties-status-chart'));
                    propertiesStatusChart.setOption(basic_option);
                    propertiesStatusChart.showLoading();
                    $(document).ready(function () {
                        $.getJSON('<?php echo admin_url('profile/AJAX/chart/properties-status-count');?>').done(function (data) {
                            console.log(data);
                            propertiesStatusChart.hideLoading();
                            propertiesStatusChart.setOption({
                                title: {
                                    text: data.text,
                                    subtext: data.subtext
                                },
                                legend: {
                                    data: data.legend_data
                                },
                                series: [{
                                    name: 'Properties Status',
                                    type: 'pie',
                                    roseType: 'area',
                                    data: data.series_data_pie,
                                    itemStyle: {
                                        emphasis: {
                                            shadowBlur: 10,
                                            shadowOffsetX: 0,
                                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                                        }
                                    }
                                }]
                            });
                        });
                    });
                </script>
            </div>
        </div>
    <?php } ?>
    <?php if (user_do_action('income_expense', 'dashboard')) { ?>
        <div class="col-lg-6">
            <div class="m-portlet" style="height: 420px;">
                <div class="m-portlet__body p-1">
                    <div id="income-expense-pie-chart" style="width: 100%;height:400px;"></div>
                </div>

                <script>
                    var incomeExpensePieChart = echarts.init(document.getElementById('income-expense-pie-chart'));
                    incomeExpensePieChart.setOption(basic_option);
                    incomeExpensePieChart.showLoading();
                    $(document).ready(function () {
                        $.getJSON('<?php echo admin_url('profile/AJAX/chart/income-pie');?>').done(function (data) {
                            console.log(data);
                            incomeExpensePieChart.hideLoading();
                            incomeExpensePieChart.setOption({
                                title: {
                                    text: data.text,
                                    subtext: data.subtext
                                },
                                legend: {
                                    data: data.legend_data
                                },
                                series: [{
                                    name: 'Statistics',
                                    type: 'pie',
                                    //roseType: 'radius',
                                    radius : '58%',
                                    center: ['50%', '50%'],
                                    //color: ['#c0f95f','#f00b07', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'],
                                    data: data.series_data_pie,
                                    itemStyle: {
                                        emphasis: {
                                            shadowBlur: 10,
                                            shadowOffsetX: 0,
                                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                                        }
                                    }
                                }]
                            });
                        });
                    });
                </script>
            </div>
        </div>
    <?php } ?>
    <?php if (user_do_action('income_expense', 'dashboard')) { ?>
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
</div>
