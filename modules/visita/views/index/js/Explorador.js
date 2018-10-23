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
    
    Explorador('todos', 'todos',$("#titulo2").val());
    buscar('todos', 'todos');
    $("body").on('click', "#btn_buscar", function () {
        Explorador($("#iano").val(), $("#imes").val(),$("#titulo2").val());
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


function Explorador(iano, imes, titulo) {
    $.post(_root_ + 'visita/index/c_Explorador',
            {
                iano: iano,
                imes: imes,
                titulo: titulo
            }, function (data) {
        $("#js_Explorador").html('');
        $("#js_Explorador").html(data);
    });
}

function fun_Explorador(cat_Explorador, dat_Explorador, titulo) {
    var chart_Explorador = new Highcharts.Chart({
        chart: {
            renderTo: 'c_Explorador',
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: cat_Explorador
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
                data: dat_Explorador,
                name: titulo
            }]
        , exporting: {
            enabled: true
        }
    });
}
