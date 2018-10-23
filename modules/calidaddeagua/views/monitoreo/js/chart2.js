$(function () {
    
    $('#container_chart2').highcharts({
        title: {
            text: '',
            x: -50, //center
        },
        subtitle: {
            text: '',
            x: -50
        },
        xAxis: {
            categories: cat_fechas
        },
        yAxis: {
            title: {
                text: 'Valores'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: series
    });
});

