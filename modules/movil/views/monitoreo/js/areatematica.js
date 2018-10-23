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


function insertarcapawms() {
    $.post(_root_ + 'mapa/_insertarCapaWms',
            {idjerarquia: $("#cb_jerarquia option:selected").val(),
                idpais: $("#cb_pais option:selected").val(),
                urlbase: $("#lb_urlbase").html(),
                urlcapa: ConstruirUrlCapa(),
                version: $("#lb_version").html(),
                fuente: $("#tb_fuente").val(),
                nombre: $("#tb_nombrecapa").val(),
                descripcion: $("#tb_descripcion").val(),
                leyenda: 'sin datos'}, function(dato) {
        //insertarcapawms(datos)
    });

}

function prueba() {

    var arreglo = {"1": "34", "2": "2"};
    var jsonString = JSON.stringify(arreglo);
    $.post(_root_ + 'mapa/_pruebaarray',
            {arreglo: jsonString}, function(dato) {
        //insertarcapawms(datos)
    });
}

function puntos(pais, parametros) {
    $("#cargando").show();
    var beaches;
    var jsonStringPais = JSON.stringify(pais);
    var jsonStringParam = JSON.stringify(parametros);
    $.post(_root_ + 'mapa/_puntosPorPais',
            {pais: jsonStringPais, parametro: jsonStringParam}, function(dato) {
        $("#cargando").hide();
        // beaches=construirpuntos(JSON.parse(dato));
        beaches = construirpuntos(dato, parametros);
        setMarkers(map, beaches);
    });


}

function CargarDatosporPais(datos) {
    $("#cargando").show();
    var jsonString = JSON.stringify(datos);
    $.post(_root_ + 'mapa/_parametrosCompletoPorPais',
            {pais: jsonString}, function(dato) {
        $("#cargando").hide();
        //construirUlParam(JSON.parse(dato));
        //construirUlParam(dato);        
         $("#div_lita_variables").html("");
        $("#div_lita_variables").html(dato);
    });


    $.post(_root_ + 'mapa/_capasCompletoPorPais',
            {pais: jsonString}, function(dato) {
        //construirUlCapas(JSON.parse(dato));
        //construirUlCapas(dato);
        $("#div_lita_tematica").html("");
        $("#div_lita_tematica").html(dato);
    });


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
    var selected = [];
    
    $('#ul_pais input:checkbox:checked').each(function() {        
            selected.push($(this).val());        
    });

    if (selected.length !== 0)
        CargarDatosporPais(selected);
    else {
        //alert('Debes seleccionar al menos una opción.'); 
        LimpiarListParametros();
        LimpiarListCapas();
    }
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

    if (selectedparam.length>0)
        puntos(selectedpais, selectedparam);
    else
        alert('Debes seleccionar al menos una opción.');

}

function print_esatcion() {
    //  $("#content_estacion").printArea();
    w = window.open(' ', 'popimpr');
    w.document.write($('#content_estacion').html());
    w.print();
    w.close();
}

