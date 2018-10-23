//$(function () {
//    
//    $('#container_ica').highcharts({
//        title: {
//            text: 'Indices de Calidad de Agua',
//            x: -20 //center
//        },
//        subtitle: {
//            text: '',
//            x: -20
//        },
//        xAxis: {
//            categories: cat_fechas
//        },
//        yAxis: {
//            title: {
//                text: 'Valores'
//            },
//            plotLines: [{
//                value: 0,
//                width: 1,
//                color: '#808080'
//            }]
//        },
//        tooltip: {
//            valueSuffix: ''
//        },
//        legend: {
//            layout: 'vertical',
//            align: 'right',
//            verticalAlign: 'middle',
//            borderWidth: 0
//        },
//        series: serie_ica
//    });
//});

// Data retrieved from http://vikjavev.no/ver/index.php?spenn=2d&sluttid=16.06.2015.
$(function() {
    $('#container_ica').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Indices de Calidad de Agua'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: cat_fechas,
            labels: {
                overflow: 'justify'
            }
        },
        yAxis: {
            title: {
                text: 'Valores'
            },
            minorGridLineWidth: 0,
            gridLineWidth: 0,
            alternateGridColor: null,
            plotBands: [{// Light air
                    from: 0,
                    to: 40,
                    color: '#fc5454',
                    label: {
                        text: 'Extremadamente contaminada',
                    }
                }, {// Light breeze
                    from: 40,
                    to: 50,
                    color: '#fcfc54',
                    label: {
                        text: 'Fuertemente contaminada',
                    }
                }, {// Gentle breeze
                    from: 50,
                    to: 70,
                    color: '#54fc54',
                    label: {
                        text: 'Contaminada',
                    }
                }, {// Moderate breeze
                    from: 70,
                    to: 80,
                    color: '#00a800',
                    label: {
                        text: 'Levemente contaminada',
                        style: {
                            color: '#fbfcfc'
                        }
                    }
                }, {// Fresh breeze
                    from: 80,
                    to: 90,
                    color: '#00a8a8',
                    label: {
                        text: 'Aceptable',
                        style: {
                            color: '#fbfcfc'
                        }
                    }
                }, {// Strong breeze
                    from: 90,
                    to: 200,
                    color: '#0000a8',
                    label: {
                        text: 'Excelente',
                        style: {
                            color: '#fbfcfc'
                        }
                    }
                }]
        },
        tooltip: {
            valueSuffix: ''
        },
        plotOptions: {
            spline: {
                lineWidth: 4,
                states: {
                    hover: {
                        lineWidth: 5
                    }
                },
                marker: {
                    enabled: false
                },
            }
        },
        series: serie_ica,
        navigation: {
            menuItemStyle: {
                fontSize: '10px'
            }
        }
    });
});