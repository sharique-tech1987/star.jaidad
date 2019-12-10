<?php get_header('member');?>
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
<div class="hidden-xs hidden-sm visible-md hidden-lg">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
    <div class="dashboard">
        <div class="container-fluid">
            <div class="content-area">
                <div class="dashboard-content">
                    <div class="dashboard-header clearfix">
                        <div class="row">
<!--                            <div class="col-md-6 col-sm-12 breadcrumb_member_cust"><h4>Statistics</h4></div>-->
<!--                            <div class="col-md-6 col-sm-12 breadcrumb_member_cust ">-->


    <div class="col-lg-6">
        <div class="m-portlet" style="height: 420px;">
            <div class="m-portlet__body p-1">
                <div id="properties-status-chart" class="custom-status" style="width: 100%;height:400px;"></div>
            </div>

            <script>
                var propertiesStatusChart = echarts.init(document.getElementById('properties-status-chart'));
                propertiesStatusChart.setOption(basic_option);
                propertiesStatusChart.showLoading();
                $(document).ready(function () {
                    $.getJSON('<?php echo site_url('member/AJAX/chart/properties-status-count');?>').done(function (data) {
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
                                //roseType: 'area',
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


<!--                        </div>-->
                    </div></div>
            </div></div>
    </div>

<?php get_footer();?>