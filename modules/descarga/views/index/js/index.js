$(document).on('ready', function () {
    $('body').on('click', '.pagina', function () {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    var paginacion = function (pagina, nombrelista, datos) {
        var pagina = 'pagina=' + pagina;

        $.post(_root_ + 'descarga/index/_paginacion_' + nombrelista + '/' + datos, pagina, function (data) {
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
    $.post(_root_ + 'descarga/index/BuscarDescarga',
            {
                iano: iano,
                imes: imes
            }, function (data) {
        $("#divListarDescarga").html('');
        $("#divListarDescarga").html(data);
    });
}

function PaginasMasVisitadas(iano, imes, titulo) {
    $.post(_root_ + 'descarga/index/c_DescargasMasFrecuentes',
            {
                iano: iano,
                imes: imes,
                titulo: titulo
            }, function (data) {
        $("#js_PaginasMasVisitadas").html('');
        $("#js_PaginasMasVisitadas").html(data);
    });
}/*
//$(function () { $('table').databar(); });
$("#export").click(function(){
  $("#tableexcel").table2excel({
    // exclude CSS class
    exclude: ".noExl",
    name: "Excel Document Name"
  });
});
*/
function fun_Descarga(cat_Descarga, dat_Descarga, titulo) {
    var chart_Descarga = new Highcharts.Chart({
        chart: {
            renderTo: 'c_PaginasMasVisitadas',
            type: 'column',
            backgroundColor: "#FFFFFF",
            borderColor: "#4572A7"
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: cat_Descarga,
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
                data: dat_Descarga,
                name: titulo
            }]
        , exporting: {
            enabled: true,
            filename: "SII GEF OTCA (Documentos mas descargados)"
        }
    });
}
