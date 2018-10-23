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
    
    PaginasMasVisitadas('todos', 'todos',$("#titulo1").val());
    buscar('todos', 'todos');
    
    $("body").on('click', "#btn_buscar", function () {
        PaginasMasVisitadas($("#iano").val(), $("#imes").val(),$("#titulo1").val());
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

function PaginasMasVisitadas(iano, imes, titulo) {
    $.post(_root_ + 'visita/index/c_PaginasMasVisitadas',
            {
                iano: iano,
                imes: imes,
                titulo: titulo
            }, function (data) {
        $("#js_PaginasMasVisitadas").html('');
        $("#js_PaginasMasVisitadas").html(data);
    });
}

function fun_PaginasMasVisitadas(cat_PaginasMasVisitadas, dat_PaginasMasVisitadas, titulo) {
    var chart_PaginasMasVisitadas = new Highcharts.Chart({
        chart: {
            renderTo: 'c_PaginasMasVisitadas',
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: cat_PaginasMasVisitadas,
            /*tickmarkPlacement: 'on',
            title: {
                disabled: true
            }*/
            tickmarkPlacement: 'off',
            title: {
                enabled: true
            }
        },
        yAxis: {
            title: {
                text: ''
            }/*,
            labels: {
                formatter: function () {
                    return this.value / 1000;
                }
            }*/
        },
        tooltip: {
            formatter: function () {
                return '' +
                         this.x + ' = ' + this.y + ' ' ;
            }
        },
        credits: {
            enabled: false
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
        series: [{
                data: dat_PaginasMasVisitadas,
                name: titulo
            }]
        , exporting: {
            enabled: true
        }
    });
}
