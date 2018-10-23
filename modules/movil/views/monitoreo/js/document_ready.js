$(document).on('change', 'input', function() {

    if ($(this).attr("type") == "checkbox") {
        var tipo = $(this).attr("id").split('_')[1];
        
        if (tipo == "pais") {
            CargarDatosPaisSeleccionados();
        }
        else if (tipo == "parametros") {
            CargarPuntosMonitoreo();
        }
        else if (tipo == "allpuntos") {
           puntos("", "");;
        }
    }
});

$(document).ready(function() {
    $('body').on('click', '.pagina', function() {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    var paginacion = function(pagina, nombrelista, datos) {
        var pagina = 'pagina=' + pagina;

        $.post(_root_ + 'monitoreo/_paginacion_' + nombrelista + '/' + datos, pagina, function(data) {
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }
    /*Patra los Check*/

    //$(".sp_asignar_capa_vm").click(function() {
    //   asignaciondecapa(this);
    // });
    $('body').on('click', '.sp_asignar_capa_vm', function() {
        asignaciondecapa(this);
    });
    var asignaciondecapa = function(objeto) {
        var idpais = $($($($(objeto).parent()).parent()).find("select")).val();
        asignarcapa($("#hd_id_jerarquia").val(), idpais, $(objeto).attr("capa"));

    };
    $('body').on('click', '.sp_quitar_capa_vm', function() {
        quitarcapa($("#hd_id_jerarquia").val(), $(this).attr("capa"));
    });
    $('body').on('click', '.sp_quitar_jerarquia_vm', function() {
        quitarcapa_jerarquia($(this).attr("jerarquia"));
    });

    

});
