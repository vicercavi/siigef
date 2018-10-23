
function CargarPuntosEspecie() {
    deleteMarkers();


    var selectedespecie = [];
    $('.ul_especie input:checkbox:checked').each(function() {
        selectedespecie.push($(this).val());
    });

    if (selectedespecie.length > 0)
        puntosEspecie(selectedespecie);
    else
        alert('Debes seleccionar al menos una opción.');

}

function puntosEspecie(selectedespecie) {
    $("#cargando").show();
    var beaches;
    var jsonStringEspecie = JSON.stringify(selectedespecie);
    $.post(_root_ + 'biodiversidad/_puntosPorEspecie',
            {especie: jsonStringEspecie}, function(dato) {
        $("#cargando").hide();
         beaches=construirpuntosEspecie(JSON.parse(dato));
        setMarkers(map, beaches);
    });


}
function construirpuntosEspecie(datos) {
    var beaches = []
    var eca = '';
       $.each(datos, function(posicion, punto) {
        var valorparam = "<table class='table table-hover'><thead><tr><th>Variable</th><th>UND</th><th>Valor</th><th>Colecta</th></tr></thead><tbody>";
        
        valorparam = valorparam + "</tbody></table>";


        //para los id parametros


     
        var contentString = '<div  class="panel panel-default" style="width: 410px;">' +
                '<div id="content_estacion"><h4 class="panel-title"  style="  text-transform: uppercase;">' +
                '<a data-toggle="tooltip" data-placement="bottom" class="link-home" title="Listar todas las viariables estudiadas" href="' + _root_ + 'monitoreo/estacion/' + punto.Dar_IdDarwinCore + '" target="_blank">' + punto.Dar_NombreCientifico + '</a></h4>' +
                '<div class="div4">' +              
                '<span style="color: rgb(112, 116, 120);">Latitud ' + punto.Dar_Latitud + '</span><br>' +
                '<span style="color: rgb(112, 116, 120);">Longitud ' + punto.Dar_Longitud + '</span><br>' +
                '</div>' +
                '<div class="div6"></div>' +
                '<div class="row-fluid" style="width: 98%;padding-top: 10px;">' +
                '<div class="col-md-6" style="padding-left: 0px;">' +
                '<strong>VARIABLE SELECIONADA</strong>' +
                '</div>' +
                '<div class="col-md-6 right" >' +
              
                '</div>' +
                '<div id="bodyContent">' +
            
                '</div></div>' +                
                '</div>';

                beaches.push([punto.Dar_NombreCientifico, punto.Dar_Latitud, punto.Dar_Longitud, 0, 0,0, contentString]);
        });
    return beaches;
}




