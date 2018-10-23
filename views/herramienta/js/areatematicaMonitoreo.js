/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function ConstruirUrlCapa() {
    var urlcompleto = $("#urlbase").val() + '';
    urlcompleto += '&REQUEST=GetMap';
    urlcompleto += '&SERVICE=WMS';
    urlcompleto += '&VERSION=1.1.1';
    urlcompleto += '&LAYERS=' + $("#cmb_layer option:selected").val();
    urlcompleto += '&STYLES=' + $("#tb_stile").val();
    urlcompleto += '&FORMAT=' + $("#cmb_format option:selected").val();
    urlcompleto += '&BGCOLOR=' + $("#tb_BGCOLOR").val();
    urlcompleto += '&TRANSPARENT=' + $("#cmb_transparencia option:selected").val()
    urlcompleto += '&SRS=' + $("#tb_srs").val();
    urlcompleto += '&WIDTH=' + $("#tb_ancho").val();
    urlcompleto += '&HEIGHT=' + $("#tb_alto").val();

    return urlcompleto;
}

function puntos(pais, parametros) {
    $("#cargando").show();
    var beaches;
    var jsonStringPais = JSON.stringify(pais);
    var jsonStringParam = JSON.stringify(parametros);

    if (_post && _post.readyState != 4) {
        _post.abort();
    }

    _post = $.post(_root_ + 'calidaddeagua/monitoreo/_puntosPorPais',
            {pais: jsonStringPais, parametro: jsonStringParam}, function(dato, status, xhr) {
        $("#cargando").hide();
        beaches = construirpuntos(JSON.parse(dato));
        // beaches = construirpuntos(dato, parametros);
        setMarkers(map, beaches);
    }).always(function() {
        $("#cargando").hide();
    });
}
function puntosMonitoreo(parametros) {
    $("#cargando").show();
    var beaches;
    var jsonStringParam = JSON.stringify(parametros);

    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    starBitacora();
    _post = $.post(_root_ + 'calidaddeagua/monitoreo/_puntosPorVariable',
            {parametro: jsonStringParam}, function(dato, status, xhr) {
        $("#cargando").hide();
        endBitacora(1, "_puntosPorVariable", jsonStringParam)
        beaches = construirpuntos(JSON.parse(dato));
        // beaches = construirpuntos(dato, parametros);
        setMarkers(map, beaches);
    });
}


function construirpuntos(datos) {
    var beaches = []

    $.each(datos, function(posicion, punto) {
        var idvariables = [];
        $.each(punto.variables, function(posicion2, param) {
            idvariables.push(param.Var_IdVariable);
        });
                beaches.push({
            idestacion: punto.Esm_IdEstacionMonitoreo,
            idvariable: idvariables,
            nombre: punto.Esm_Nombre,
            fecha:punto.Mca_Fecha,
            lat: punto.Esm_Latitud,
            lng: punto.Esm_Longitud,
            icon: "estacion",
            referencia: "monitoreo-ca",
            zindex: posicion
        });
        });
    return beaches;
}

/*Contruir UL de Parametros y Capas*/
function LimpiarListParametros() {
      
     $('#div_lita_tematica').html('');

}
function LimpiarListCapas() {       
     $('#div_lista_capas').html('');
}
/*Para las Consultas A la Bd de las Dimenciones*/

function CargarDatosPaisSeleccionados() {
    deleteMarkers();
    removeOverlay();
    limpiarLeyenda();
    var selected = [];

    $('#ul_pais input:checkbox:checked').each(function() {
        selected.push($(this).val());
    });

    //if (selected.length !== 0)
    CargarDatosporPais(selected);
    //else {
    //alert('Debes seleccionar al menos una opción.'); 
    //  LimpiarListParametros();
    LimpiarListCapas();
    // }
}

function CargarPuntosMonitoreo() {
    deleteMarkers();
    var selectedpais = [];
    $('#ul_pais input:checkbox:checked').each(function() {
        selectedpais.push($(this).val());
    });

    var selectedparam = [];
    $('.ul_parametros input:checkbox:checked').each(function() {
        selectedparam.push($(this).val());
    });

    if (selectedparam.length > 0)
        puntos(selectedpais, selectedparam);
    else {
        _post.abort();
        $("#cargando").hide();
        // alert('Debes seleccionar al menos una opción.');
    }

}

function CargarPuntosMonitoreo2() {
    deleteMarkers();

    var selectedparam = [];
    $('.ul_tabular input:checkbox:checked').each(function() {
        if (typeof($(this).attr("recurso")) !== "undefined") {
             selectedparam.push([$(this).val(), $(this).attr("recurso"), $(this).attr("columna")]);
        }
       
    });

    if (selectedparam.length > 0)
        puntosMonitoreo(selectedparam);
    else {
        _post.abort();
        $("#cargando").hide();
        // alert('Debes seleccionar al menos una opción.');
    }

}

function  cargarInfoWindowM(marker) {
    var jsonStringvariables = JSON.stringify(marker.idDatosM[1]);
    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    _post = $.post(_root_ + 'calidaddeagua/monitoreo/_perfilEstacion',
            {idestacion: marker.idDatosM[0], idvariables: jsonStringvariables}, function(dato, status, xhr) {
        $("#html_marker").html(dato);

        $('[data-toggle="popover"]').popover({html: true});

    });
}

function print_esatcion() {
    //  $("#content_estacion").printArea();
    w = window.open(' ', 'popimpr');
    w.document.write($('#content_estacion').html());
    w.print();
    w.close();
}


