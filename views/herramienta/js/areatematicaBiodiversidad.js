
function CargarPuntosEspecie() {
    deleteMarkers();


    var selectedespecie = [];
    $('.ul_tabular input:checkbox:checked').each(function () {
        selectedespecie.push([$(this).val(), $(this).attr("recurso"), $(this).attr("columna")]);
    });

    if (selectedespecie.length > 0)
        puntosEspecie(selectedespecie);
    else {
        _post.abort();
        $("#cargando").hide();
        // alert('Debes seleccionar al menos una opción.');
    }

}

function puntosEspecie(selectedespecie) {
    $("#cargando").show();
    var beaches;
    var jsonStringEspecie = JSON.stringify(selectedespecie);

    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    starBitacora();
    _post = $.post(_root_ + 'biodiversidad/_puntosPorEspecie',
            {especie: jsonStringEspecie}, function (dato, status, xhr) {
        endBitacora(5, "_puntosPorEspecie", jsonStringEspecie)
        beaches = construirpuntosEspecie(JSON.parse(dato));
        setMarkers(map, beaches);
    }).always(function () {
        $("#cargando").hide();
    });


}
function construirpuntosEspecie(datos) {
    var beaches = []
    var eca = '';
       $.each(datos, function (posicion, punto) {
        var valorparam = "<table class='table table-hover'><thead><tr><th>Variable</th><th>UND</th><th>Valor</th><th>Colecta</th></tr></thead><tbody>";

        valorparam = valorparam + "</tbody></table>";
        var contentString = '<div  class="panel panel-default" style="width: 410px;">' +
                '<div id="content_estacion"><h4 class="panel-title"  style="  text-transform: uppercase;">' +
                '<a data-toggle="tooltip" data-placement="bottom" class="link-home" title="Listar todas las viariables estudiadas" href="' + _root_ + 'calidaddeagua/monitoreo/estacion/' + punto.Dar_IdDarwinCore + '" target="_blank">' + punto.Dar_NombreCientifico + '</a></h4>' +
                '<div class="div4">' +
                '<span style="color: rgb(112, 116, 120);">Latitud ' + punto.Dar_Latitud + '</span><br>' +
                '<span style="color: rgb(112, 116, 120);">Longitud ' + punto.Dar_Longitud + '</span><br>' +
                '</div>' +
                '<div class="div6"></div>' +
                '<div class="row-fluid" style="width: 98%;padding-top: 10px;">' +
                '<div class="col-md-6" style="padding-left: 0px;">' +
                '</div>' +
                '<div class="col-md-6 right" >' +
                '</div>' +
                '<div id="bodyContent">' +
                '</div></div>' +
                '</div>';

                beaches.push(
                {
                    iddarwin: punto.Dar_IdDarwinCore,
                    nombre: punto.Dar_NombreCientifico,
                    lat: punto.Dar_Latitud,
                    lng: punto.Dar_Longitud,
                    zindex: posicion,
                    referencia: "darwin",
                    icon: punto.Dar_ReinoOrganismo,
                    html: contentString
                });
        });
    return beaches;
}

function  cargarInfoWindowD(marker) {
    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    _post = $.post(_root_ + 'biodiversidad/_perfilDarwin',
            {iddarwin: marker.idDatoD}, function (dato, status, xhr) {
        $("#html_marker").html(dato);

        $('[data-toggle="popover"]').popover({html: true});

    });
}


