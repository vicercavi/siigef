/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$.fn.serializeObject = function () {
    var o = Object.create(null),
            elementMapper = function (element) {
                element.name = $.camelCase(element.name);
                return element;
            },
            appendToResult = function (i, element) {
                var node = o[element.name];

                if ('undefined' != typeof node && node !== null) {
                    o[element.name] = node.push ? node.push(element.value) : [node, element.value];
                } else {
                    o[element.name] = element.value;
                }
            };

    $.each($.map(this.serializeArray(), elementMapper), appendToResult);
    return o;
};

function insertarcapawms() {
    $("#cargando").show();
    limpiarmensaje();
    if ($('#hd_carga_avanzada').val() == 1) {
        // form1 = $("#panel-wms").serialize()
        // form1 = form1 + "&urlcapa=" + ConstruirUrlCapa();
        // form1 = form1 + "&leyenda2=" + getLeyenda($("#lb_urlbase").html(), $("#cmb_layer option:selected").val());
        var data = {urlcapa: ConstruirUrlCapa(), leyenda2: getLeyenda($("#lb_urlbase").html(), $("#cmb_layer option:selected").val())};
        var postData = $("#panel-wms").serializeObject();
        $.extend(postData, data);
        $.post(_root_ + 'mapa/_insertarCapaWms',
                postData, function (data, status, xhr) {
                    $("#cargando").hide();
                    mensaje(JSON.parse(data));
                });
    } else {
        var jscapas = construirCapasRegistro()//[0]=>titutlo, [1] => nombre de capa|  
        // form1 = $("#panel-wms").serialize()
        // form1 = form1 + "&capas=" + JSON.stringify(jscapas);
        // form1 = form1 + "&leyenda2=" + getLeyenda($("#lb_urlbase").html(), jscapas[0][1]);

        var data = {capas: JSON.stringify(jscapas), leyenda2: getLeyenda($("#lb_urlbase").html(), jscapas[0][1])};
        var postData = $("#panel-wms").serializeObject();
        $.extend(postData, data);
        $.post(_root_ + 'mapa/_insertarCapaWms', postData
                , function (data, status, xhr) {
                    $("#cargando").hide();
                    mensaje(JSON.parse(data));
                });
    }

}
function insertarcaparss() {
    $("#cargando").show();
    limpiarmensaje();
    var data={url_rss:$("#hd_nombrekml").val()};    
    var postData = $("#panel-wms").serializeObject();
        $.extend(postData, data);
    $.post(_root_ + 'mapa/_insertarCapaRSS',
            postData, function (data, status, xhr) {
        $("#cargando").hide();
        mensaje(JSON.parse(data));
    });
}

function insertarcapajson() {
    $("#cargando").show();
    limpiarmensaje();
    var data={url_json:$("#hd_url_json").val(),tipo_json:$("#hd_tipo_json").val()};
    var postData = $("#panel-wms").serializeObject();
        $.extend(postData, data);
    $.post(_root_ + 'mapa/_insertarCapaJSON',
            postData, function (data, status, xhr) {
        $("#cargando").hide();
        mensaje(JSON.parse(data));
    });
}
function insertarcapakml() {
    $("#cargando").show();
    limpiarmensaje();
    var data={kml:$("#hd_nombrekml").val()};
    var postData = $("#panel-wms").serializeObject();
        $.extend(postData, data);
    $.post(_root_ + 'mapa/_insertarCapaKML',
            postData, function (data, status, xhr) {
        $("#cargando").hide();
        mensaje(JSON.parse(data));
    });
}
function construirCapasRegistro() {
    var capas = [];
    $('#ul_layer li').each(function () {
        $(this).find('input:checkbox:checked').each(function () {
//cada elemento seleccionado
            capas.push([$("#sp_layeredit_" + $(this).attr("id").split('_')[2]).html(), $(this).val()]);
        });
    });
    return capas;
}



//Subir Imagenes Temporalmete
function uploadAjaxImagen(named) {
     $("#cargando").show();
    limpiarmensaje();
    _msg=new Array();
    data=new Array();  
    data[0]="error";
    data[1]="Espere! Se está procesando la imagen.";
    _msg[0]=data;

    mensaje(_msg);
    var inputFileImage = document.getElementById("fl_" + named);
    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append("archivo", file);
    var url = _root_ + "/mapa/_uploadimagentemp";
    $.ajax({
        url: url,
        type: "POST",
        contentType: false,
        data: data,
        processData: false,
        cache: false}).done(function (msg) {
            $("#cargando").hide();
        $("#hd_" + named).val(JSON.parse(msg)['msg']);
        _msg=new Array();       
        data=new Array();  
        data[0]="ok";
        data[1]="Imagen procesada: "+JSON.parse(msg)['msg'];
        _msg[0]=data;
        mensaje(_msg);      ;
        //$("#hd_" + named).val(file);
    });
    ;
}

function load_capa_gestor_google(){
    //Para Mostrar KML al momento de cargar kml / Gestor de capa - agregar nuevo kml
    if (typeof(kml_nombre) !== "undefined") {
        add_kml_google(0,_root_+'tmp/varios/'+kml_nombre);
    }
    if (typeof(url_georss) !== "undefined") {
        add_kml_google(0,url_georss);
    }
    if (typeof(url_geojson) !== "undefined") {
        load_GeoJson_google(0,url_geojson);
    }
     if (typeof(file_geojson) !== "undefined") {        
         load_GeoJson_google(0,_root_+'tmp/varios/'+file_geojson);
    }
    if(typeof(capa_wms) !== "undefined"){
        if (capa_wms['url'] != "")
        {
            addOverlayGestor(capa_wms['url'],capa_wms['urlb'], 'layerWMS', capa_wms['titulo']);
        }
        else
        {
            AddWMS(capa_wms['urlb'], capa_wms['nombre'], 'layerWMS', capa_wms['titulo']);
        }
    }
}

function cargar_metada_kml(metadata){
    //$("#h4_kml_title").html(metadata['name']);
   //$("#tb_titulocapa").val(metadata['name']);
  // $("#tb_iCap_Resumen").val(metadata['snippet']);
  // $("#tb_iCap_Descripcion").val(metadata['description']);
}



