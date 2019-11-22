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
    <?php if (user_do_action('search_purpose', 'search_statistics')) { ?>
        <div class="col-lg-6">
            <div class="m-portlet" style="height: 420px;">
                <div class="m-portlet__body p-1">
                    <div id="search-purpose" style="width: 100%;height:400px;"></div>
                </div>

                <script>
                    var searchPurposePieChart = echarts.init(document.getElementById('search-purpose'));
                    searchPurposePieChart.setOption(basic_option);
                    searchPurposePieChart.showLoading();
                    $(document).ready(function () {
                        //income-pie        search-purpose
                        $.getJSON('<?php echo admin_url('profile/AJAX/chart/search-purpose');?>').done(function (data) {
                            console.log(data);
                            searchPurposePieChart.hideLoading();
                            searchPurposePieChart.setOption({
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

    <?php if (user_do_action('search_cities', 'search_statistics')) { ?>
        <div class="col-lg-6">
            <div class="m-portlet" style="height: 420px;">
                <div class="m-portlet__body p-1">
                    <div id="search_cities" style="width: 100%;height:400px;"></div>
                </div>

                <script>
                    var searchCitiesPieChart = echarts.init(document.getElementById('search_cities'));
                    searchCitiesPieChart.setOption(basic_option);
                    searchCitiesPieChart.showLoading();
                    $(document).ready(function () {
                        //income-pie        search-purpose
                        $.getJSON('<?php echo admin_url('profile/AJAX/chart/search-city');?>').done(function (data) {
                            console.log(data);
                            searchCitiesPieChart.hideLoading();
                            searchCitiesPieChart.setOption({
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
                                    data: data.cities_data_pie,
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

    <?php if (user_do_action('search_property_types', 'search_statistics')) { ?>
        <div class="col-lg-6">
            <div class="m-portlet" style="height: 420px;">
                <div class="m-portlet__body p-1">
                    <div id="search_property_types" style="width: 100%;height:400px;"></div>
                </div>

                <script>
                    var searchPropertyTypePieChart = echarts.init(document.getElementById('search_property_types'));
                    searchPropertyTypePieChart.setOption(basic_option);
                    searchPropertyTypePieChart.showLoading();
                    $(document).ready(function () {
                        //income-pie        search-purpose
                        $.getJSON('<?php echo admin_url('profile/AJAX/chart/search-property-types');?>').done(function (data) {
                            console.log(data);
                            searchPropertyTypePieChart.hideLoading();
                            searchPropertyTypePieChart.setOption({
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
                                    data: data.property_type_data_pie,
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
</div>
