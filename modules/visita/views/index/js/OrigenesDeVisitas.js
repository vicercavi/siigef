$(document).on('ready', function () {
    $('body').on('click', '.pagina', function () {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    var paginacion = function (pagina, nombrelista, datos) {
        var pagina = 'pagina=' + pagina;

        $.post(_root_ + 'visita/index/_paginacion_' + nombrelista + '/' + datos, pagina, function (data) {
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    };
    
    OrigenesDeVisitas('todos', 'todos', $("#titulo4").val());
    buscar('todos', 'todos');
    $("body").on('click', "#btn_buscar", function () {
        OrigenesDeVisitas($("#iano").val(), $("#imes").val(),$("#titulo4").val());
        buscar($("#iano").val(), $("#imes").val());
    });
});
function buscar(iano, imes) {
    $.post(_root_ + 'visita/index/BuscarVisita',
            {
                iano: iano,
                imes: imes
            }, function (data) {
        $("#divListarVisita").html('');
        $("#divListarVisita").html(data);
    });
}


function OrigenesDeVisitas(iano, imes,titulo) {
    $.post(_root_ + 'visita/index/c_OrigenesDeVisitas',
            {
                iano: iano,
                imes: imes,
                titulo:titulo
            }, function (data) {
        $("#js_OrigenesDeVisitas").html('');
        $("#js_OrigenesDeVisitas").html(data);
    });
}

function fun_OrigenesDeVisitas(cat_OrigenesDeVisitas, dat_OrigenesDeVisitas, titulo) {
    var chart_OrigenesDeVisitas = new Highcharts.Chart({
        chart: {
            renderTo: 'c_OrigenesDeVisitas',
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: cat_OrigenesDeVisitas
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        tooltip: {
            formatter: function () {
                return '' +
                        this.x + ' = ' + this.y + ' ';
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                lineColor: '#666666',
                lineWidth: 1,
                marker: {
                    lineWidth: 1,
                    lineColor: '#666666'
                }
            }
        },
        credits: {
            enabled: false
        },
        series: [{
                data: dat_OrigenesDeVisitas,
                name: titulo
            }]
        , exporting: {
            enabled: true
        }
    });
}
