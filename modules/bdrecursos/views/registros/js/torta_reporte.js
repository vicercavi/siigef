 function chart (div,graf_title,graf_data) {
    $('#container'+div).highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: graf_title
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false                  
                },
                    showInLegend: true
            }
        },
        series: [{
            name: 'total',
            colorByPoint: true,
            data: graf_data
        }]
    });
}