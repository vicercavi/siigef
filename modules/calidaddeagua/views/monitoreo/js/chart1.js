$(function () {
    
    $('#container_chart1').highcharts({
        title: {
            text: 'Valores recolectados por Variable',
            x: -20 //center
        },
        subtitle: {
            text: estacion,
            x: -20
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

