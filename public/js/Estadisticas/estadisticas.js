var estadisticas = $(document);
var baseUrl = baseUrl;

estadisticas.ready(iniciaEstadisticas);

function iniciaEstadisticas() {
    console.log(baseUrl);
    graficar1();
    graficar2();
    graficar3();
}

function graficar1() {
    Highcharts.getJSON(
        'https://cdn.jsdelivr.net/gh/highcharts/highcharts@v7.0.0/samples/data/usdeur.json',
        function (data) {

            Highcharts.chart('container1', {
                chart: {
                    zoomType: 'x'
                },
                title: {
                    text: 'USD to EUR exchange rate over time'
                },
                subtitle: {
                    text: document.ontouchstart === undefined ?
                        'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
                },
                xAxis: {
                    type: 'datetime'
                },
                yAxis: {
                    title: {
                        text: 'Exchange rate'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: {
                                x1: 0,
                                y1: 0,
                                x2: 0,
                                y2: 1
                            },
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                            ]
                        },
                        marker: {
                            radius: 2
                        },
                        lineWidth: 1,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        threshold: null
                    }
                },

                series: [{
                    type: 'area',
                    name: 'USD to EUR',
                    data: data
                }]
            });
        }
    );
}

function graficar2() {
    Highcharts.chart('container2', {

        chart: {
            scrollablePlotArea: {
                minWidth: 700
            }
        },

        data: {
            csvURL: 'https://cdn.jsdelivr.net/gh/highcharts/highcharts@v7.0.0/samples/data/analytics.csv',
            beforeParse: function (csv) {
                return csv.replace(/\n\n/g, '\n');
            }
        },

        title: {
            text: 'Daily sessions at www.highcharts.com'
        },

        subtitle: {
            text: 'Source: Google Analytics'
        },

        xAxis: {
            tickInterval: 7 * 24 * 3600 * 1000, // one week
            tickWidth: 0,
            gridLineWidth: 1,
            labels: {
                align: 'left',
                x: 3,
                y: -3
            }
        },

        yAxis: [{ // left y axis
            title: {
                text: null
            },
            labels: {
                align: 'left',
                x: 3,
                y: 16,
                format: '{value:.,0f}'
            },
            showFirstLabel: false
        }, { // right y axis
            linkedTo: 0,
            gridLineWidth: 0,
            opposite: true,
            title: {
                text: null
            },
            labels: {
                align: 'right',
                x: -3,
                y: 16,
                format: '{value:.,0f}'
            },
            showFirstLabel: false
        }],

        legend: {
            align: 'left',
            verticalAlign: 'top',
            borderWidth: 0
        },

        tooltip: {
            shared: true,
            crosshairs: true
        },

        plotOptions: {
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function (e) {
                            hs.htmlExpand(null, {
                                pageOrigin: {
                                    x: e.pageX || e.clientX,
                                    y: e.pageY || e.clientY
                                },
                                headingText: this.series.name,
                                maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) + ':<br/> ' +
                                    this.y + ' sessions',
                                width: 200
                            });
                        }
                    }
                },
                marker: {
                    lineWidth: 1
                }
            }
        },

        series: [{
            name: 'All sessions',
            lineWidth: 4,
            marker: {
                radius: 4
            }
        }, {
            name: 'New users'
        }]
    });
}
function graficar3(){
    $.ajax({
        type: "GET",
        url: 'http://localhost:8018/api/reports?id='+report,
        headers: {
            'Authorization':'JTkC0FoVAHbj6tkccFJKvuExUND7QNOo'
        }
    }).done(function(data) {
        $('#reportTable tbody').html(fillTableReport(data));
    });
}
