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
    $.post(_root_ + 'calidaddeagua/monitoreo/_puntosPorPais',
            {pais: jsonStringPais, parametro: jsonStringParam}, function(dato) {
        $("#cargando").hide();
        // beaches=construirpuntos(JSON.parse(dato));
        beaches = construirpuntos(dato, parametros);
        setMarkers(map, beaches);
    });
}
function construirpuntos(datos, variables) {
    var beaches = []
    var eca = '';
    $.each(datos.estadoeca, function(posicion, estadoeca) {
        eca = eca + '<div class="estadoeca" style="background-color: ' + estadoeca.ese_color + '">' + estadoeca.ese_nombre + '</div>'
    }
    );


       $.each(datos.estacion, function(posicion, punto) {
        var valorparam = "<table class='table table-hover'><thead><tr><th>Variable</th><th>UND</th><th>Valor</th><th>Colecta</th></tr></thead><tbody>";
        $.each(punto.params, function(posicion2, param) {
            if (param.unidadMedida == undefined) {
                param.unidadMedida = "";
            }
            if (param.fecha == undefined) {
                param.fecha = "";
            }
            var eca;
            if (param.EstadoECA == null) {
                eca = '<td><div style=" text-align: center;">' + param.ParametroCantidad + '</div></td>';
            } else {
                eca = '<td> <div style="background-color: ' + param.EstadoECA + ';    text-align: center;    color: white;    font-weight: bold;  padding: 0 4px 0 4px;">' + param.ParametroCantidad + '</div></td>';
            }
            var abrevi = "";
            if (param.Var_Abreviatura) {
                abrevi = ' (' + param.Var_Abreviatura + ')';
            }
            valorparam = valorparam + '<tr><td>' + param.nombreParametro + " " + abrevi + '</td><td>' + param.unidadMedida + '</td>' + eca + '<td>' + param.fecha + '</td><td><a href="' + _root_ + 'calidaddeagua/monitoreo/variable/' + param.ParametroId + '" target="_blank" data-toggle="tooltip" data-placement="bottom" class="link-home" title="Listar todas las estaciones donde se estudió la variable" >ver</a></td></tr>';
        });

        valorparam = valorparam + "</tbody></table>";
        var idvars = ""
        $.each(variables, function(i, idvar) {
            idvars = idvars + "," + idvar;
        });

        //para los id parametros


        if (punto.nombreCuenca == null) {
            punto.nombreCuenca = "";
        }
        var contentString = '<div  class="panel panel-default" style="width: 410px;">' +
                '<div id="content_estacion"><h4 class="panel-title"  style="  text-transform: uppercase;">' +
                '<a data-toggle="tooltip" data-placement="bottom" class="link-home" title="Listar todas las viariables estudiadas" href="' + _root_ + 'calidaddeagua/monitoreo/estacion/' + punto.EstacionId + '" target="_blank"> Estación ' + punto.nombrePunto + '</a></h4>' +
                '<div class="div4">' +
                '<span style="color: rgb(112, 116, 120);">' + punto.Pais + ', Cuenca ' + punto.nombreCuenca + '</span><br>' +
                '<span style="color: rgb(112, 116, 120);">Latitud ' + punto.LatitudGM + '</span><br>' +
                '<span style="color: rgb(112, 116, 120);">Longitud ' + punto.LongitudGM + '</span><br>' +
                '</div>' +
                '<div class="div6"></div>' +
                '<div class="row-fluid" style="width: 98%;padding-top: 10px;">' +
                '<div class="col-md-6" style="padding-left: 0px;">' +
                '<strong>VARIABLE SELECIONADA</strong>' +
                '</div>' +
                '<div class="col-md-6 right" >' +
                eca +
                '</div>' +
                '<div id="bodyContent">' +
                valorparam +
                '</div></div>' +
                '<div class="row-fluid"><div style="display: inline-block;margin: 5px 10px 0 0;"><a href="' + _root_ + "calidaddeagua/monitoreo/_exportaEstacionMonitoreo/" + punto.EstacionId + "/" + idvars + '" target="_blank"><i class="icon-share"></i>Exportar</a></div></div>' +
                '</div>';

                beaches.push([punto.nombrePunto, punto.LatitudGM, punto.LongitudGM, punto.contador, punto.ParametroId, punto.ParametroCantidad, contentString]);
        });
    return beaches;
}
function CargarDatosporPais(datos) {
    $("#cargando").show();
    var jsonString = JSON.stringify(datos);
    $.post(_root_ + 'calidaddeagua/monitoreo/_parametrosCompletoPorPais',
            {pais: jsonString}, function(dato) {
        $("#cargando").hide();
        //construirUlParam(JSON.parse(dato));
        //construirUlParam(dato);        
        $("#div_lita_variables").html("");
        $("#div_lita_variables").html(dato);
    });


    $.post(_root_ + 'calidaddeagua/monitoreo/_capasCompletoPorPais',
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

