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
    
    IpMasFrecuentes('todos', 'todos',$("#titulo3").val());
    buscar('todos', 'todos');
    $("body").on('click', "#btn_buscar", function () {
        IpMasFrecuentes($("#iano").val(), $("#imes").val(),$("#titulo3").val());
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


function IpMasFrecuentes(iano, imes, titulo) {
    $.post(_root_ + 'visita/index/c_IpMasFrecuentes',
            {
                iano: iano,
                imes: imes,
                titulo: titulo
            }, function (data) {
        $("#js_IpMasFrecuentes").html('');
        $("#js_IpMasFrecuentes").html(data);
    });
}

function fun_IpMasFrecuentes(cat_IpMasFrecuentes, dat_IpMasFrecuentes, titulo) {
    var chart_IpMasFrecuentes = new Highcharts.Chart({
        chart: {
            renderTo: 'c_IpMasFrecuentes',
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: cat_IpMasFrecuentes
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
        credits: {
            enabled: false
        },
        series: [{
                data: dat_IpMasFrecuentes,
                name: titulo
            }]
        , exporting: {
            enabled: true
        }
    });
}
