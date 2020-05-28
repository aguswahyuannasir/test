/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Column and Waterfall charts
 *
 *  Demo JS code for echarts_columns_waterfalls.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsColumnsWaterfalls = function () {


    //
    // Setup module components
    //

    // Column and waterfall charts
    var _columnsWaterfallsExamples = function () {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define elements
        var columns_change_waterfall_element = document.getElementById('columns_change_waterfall');
        var get_one = document.getElementById('get_one').innerHTML;
        var get_two = document.getElementById('get_two').innerHTML;
        var get_three = document.getElementById('get_three').innerHTML;
        var get_four = document.getElementById('get_four').innerHTML;
        var get_five = document.getElementById('get_five').innerHTML;
        var get_six = document.getElementById('get_six').innerHTML;
        var get_seven = document.getElementById('get_seven').innerHTML;
        var get_eight = document.getElementById('get_eight').innerHTML;
        var get_nine = document.getElementById('get_nine').innerHTML;
        var get_ten = document.getElementById('get_ten').innerHTML;
        var get_eleven = document.getElementById('get_eleven').innerHTML;
        var get_twelve = document.getElementById('get_twelve').innerHTML;

        var theMonths = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        var today = new Date();
        var aMonth = today.getMonth();
        var i;
        var datas = [];

        for (i = 0; i < 12; i++) {
            var the_months = theMonths[aMonth]
            datas.push(the_months)
            aMonth--;
            if (aMonth < 0) {
                aMonth = 11;
            }

        }

        var data = datas.reverse();

        //
        // Charts configuration
        //



        // Change waterfall
        if (columns_change_waterfall_element) {

            // Initialize chart
            var columns_change_waterfall = echarts.init(columns_change_waterfall_element);


            //
            // Chart config
            //

            // Options
            columns_change_waterfall.setOption({

                // Define colors
                color: ['#2196f3'],

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Chart animation duration
                animationDuration: 750,

                // Setup grid
                grid: {
                    left: '2%',
                    right: '2%',
                    bottom: '15%',
                    containLabel: true
                },

                // Add legend
                legend: {
                    data: ['Income'],
                    itemHeight: 8,
                    itemGap: 20,
                    textStyle: {
                        padding: [0, 5]
                    }
                },

                // Tooltip
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    },
                    axisPointer: {
                        type: 'shadow',
                        shadowStyle: {
                            color: 'rgba(0,0,0,0.025)'
                        }
                    },
                    formatter: function (params) {
                        var tar;
                        if (params[1].value != '-') {
                            tar = params[1];
                        } else {
                            tar = params[0];
                        }
                        return tar.name + '<br/>' + tar.seriesName + ': ' + tar.value;
                    }
                },

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    data: data,

                    axisTick: {
                        alignWithLabel: true
                    },
                    axisLabel: {
                        rotate: 45,
                        interval: 0
                    }
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: '#eee'
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.015)']
                        }
                    }
                }],

                // Add series
                series: [{
                        name: 'Amount',
                        type: 'bar',
                        stack: 'Total',
                        barWidth: '60%',
                        itemStyle: {
                            normal: {
                                barBorderColor: 'rgba(100,200,200,0)',
                                color: 'rgba(0,0,0,0)'
                            },
                            emphasis: {
                                barBorderColor: 'rgba(0,0,0,0)',
                                color: 'rgba(0,0,0,0)'
                            }
                        },
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                    },
                    {
                        name: 'Amount',
                        type: 'bar',
                        stack: 'Total',
                        barWidth: '20%',
                        data: [get_one, get_two, '-', '-', '-', '-', '-', '-', '-', '-', get_eleven, get_twelve]
                    }
                ]
            });
        }

    };


    //
    // Return objects assigned to module
    //

    return {
        init: function () {
            _columnsWaterfallsExamples();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function () {
    EchartsColumnsWaterfalls.init();
});