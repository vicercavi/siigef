/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function construirpuntosg(datos,filtrot) {
    var beaches = []
    var jsonStringFiltro = JSON.stringify(filtrot);
    $.each(datos, function (posicion, punto) {
     
            beaches.push({
                idregistro: punto.esr_id,
                nombre: punto.esr_nombre,
                tabla:punto.esr_tabla,
                recurso:punto.esr_recurso,
                columna:punto.esr_columna,
                lat: punto.esr_latitud,
                lng: punto.esr_longitud,
                filtro:jsonStringFiltro,
                icon: "generico",
                referencia: "estandar-ge",
                zindex: posicion
            });
        });
    return beaches;
}

function CargarPuntosEstandarGenerico() {
    deleteMarkers();

    var selectedparam = [];
    var filtro=[];
    $('.ul_tabular input:checkbox:checked').each(function () {
        if (typeof ($(this).attr("recurso")) !== "undefined") {
            selectedparam.push([$(this).val(), $(this).attr("columna"), $(this).attr("tabla"), $(this).attr("recurso")]);
            filtro.push($(this).val());
        }
    });

    if (selectedparam.length > 0)
        puntosEstandarGenerico(selectedparam,filtro);
    else {
        _post.abort();
        $("#cargando").hide();
        // alert('Debes seleccionar al menos una opción.');
    }

}
function puntosEstandarGenerico(parametros,filtrot) {
    $("#cargando").show();
    var beaches;
    var jsonStringParam = JSON.stringify(parametros);

    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    starBitacora();
    _post = $.post(_root_ + 'estandar/registros/_puntosEstandarGenerico',
            {parametro: jsonStringParam}, function (dato, status, xhr) {
        $("#cargando").hide();
        endBitacora(1, "_puntosEstandarGenerico", jsonStringParam)
        beaches = construirpuntosg(JSON.parse(dato),filtrot);
        // beaches = construirpuntos(dato, parametros);
        setMarkers(map, beaches);
    });
}

function  cargarInfoWindowEG(marker) {
    var jsonStringvariables = JSON.stringify(marker.idDatosM[1]);
    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    _post = $.post(_root_ + 'estandar/registros/_perfilGenerico',
            {filtro: marker.idDatosG,tabla:marker.tabla,columna:marker.columna,lat:marker.lat,lng:marker.lng}, function (dato, status, xhr) {
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


