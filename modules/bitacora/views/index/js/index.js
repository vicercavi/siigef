$(document).on('ready', function () {
    $('body').on('click', '.pagina', function () {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    var paginacion = function (pagina, nombrelista, datos) {
        var pagina = 'pagina=' + pagina;

        $.post(_root_ + 'bitacora/index/_paginacion_' + nombrelista + '/' + datos, pagina, function (data) {
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }
    
    ErroresComunes('todos', 'todos',$("#titulo2").val());
    PaginaErrores('todos', 'todos',$("#titulo1").val());
    buscar('todos', 'todos');
    /*
    $("body").on('click', "#btn_buscar", function () {
        ErroresComunes($("#iano").val(), $("#imes").val(),$("#titulo2").val());
        PaginaErrores($("#iano").val(), $("#imes").val(),$("#titulo1").val());
        buscar($("#iano").val(), $("#imes").val());
    });*/
    $("body").on('change', "#iano", function () {
        ErroresComunes($("#iano").val(), $("#imes").val(),$("#titulo2").val());
        PaginaErrores($("#iano").val(), $("#imes").val(),$("#titulo1").val());
        buscar($("#iano").val(), $("#imes").val());
    });
    $("body").on('change', "#imes", function () {
        ErroresComunes($("#iano").val(), $("#imes").val(),$("#titulo2").val());
        PaginaErrores($("#iano").val(), $("#imes").val(),$("#titulo1").val());
        buscar($("#iano").val(), $("#imes").val());
    });
//    $("body").on('change', "#iano_ec", function () {
//        ErroresComunes($("#iano_ec").val(), $("#imes_ec").val());
////        PaginaErrores($("#iano_ec").val(), $("#imes_ec").val());
////        buscar($("#iano").val(), $("#imes").val());
//    });
//    $("body").on('change', "#imes_ec", function () {
//        ErroresComunes($("#iano_ec").val(), $("#imes_ec").val());
////        PaginaErrores($("#iano").val(), $("#imes").val());
////        buscar($("#iano").val(), $("#imes").val());
//    });
    
});
function buscar(iano, imes) {
    $.post(_root_ + 'bitacora/index/BuscarErrores',
            {
                iano: iano,
                imes: imes
            }, function (data) {
        $("#divListarBitacoraErrores").html('');
        $("#divListarBitacoraErrores").html(data);
    });
}
function ErroresComunes(iano, imes, titulo) {
    $.post(_root_ + 'bitacora/index/ErroresComunes',
            {
                iano: iano,
                imes: imes,
                titulo:titulo
            }, function (data) {
        $("#js_ErroresComunes").html('');
        $("#js_ErroresComunes").html(data);
    });
}
function PaginaErrores(iano, imes, titulo) {
    $.post(_root_ + 'bitacora/index/PaginaErrores',
            {
                iano: iano,
                imes: imes,
                titulo:titulo
            }, function (data) {
        $("#js_PaginaErrores").html('');
        $("#js_PaginaErrores").html(data);
    });
}

function fun_ErroresComunes(cat_ErroresComunes, dat_ErroresComunes, titulo) {
    var chart_ErroresComunes = new Highcharts.Chart({
        chart: {
            renderTo: 'c_ErroresComunes',
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: cat_ErroresComunes
        },
        yAxis: {
            title: {
                text: ''
            }
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
        series: [{
                data: dat_ErroresComunes,
                name:titulo
            }]
        , exporting: {
            enabled: true
        }
    });
}
function fun_PaginaErrores(cat_PaginaErrores, dat_PaginaErrores, titulo) {
    var chart_PaginaErrores = new Highcharts.Chart({
        chart: {
            renderTo: 'c_PaginaErrores',
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: cat_PaginaErrores
        },
        yAxis: {
            title: {
                text: ''
            }
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
        series: [{
                data: dat_PaginaErrores,
                name:titulo
            }]
        , exporting: {
            enabled: true
        }
    });
}