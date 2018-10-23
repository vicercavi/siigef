var map;
var prueba;
var marker;
var markers = [];
var layers = [];
var layer;
var kml_layers =[];
var kml_layer;
var json_features=[];
var Pcenter = new google.maps.LatLng(-9.042127712029426, -60.261483124999984);
//Define OSM as base layer in addition to the default Google layers
var osmMapType = new google.maps.ImageMapType({
    getTileUrl: function (coord, zoom) {
        return "http://tile.openstreetmap.org/" +
                zoom + "/" + coord.x + "/" + coord.y + ".png";
    },
    tileSize: new google.maps.Size(256, 256),
    isPng: true,
    alt: "OpenStreetMap",
    name: "OSM",
    maxZoom: 15,
    minZoom: 4
});
//Para azulejos

//Define custom WMS tiled layer
var SLPLayer;
//SetCapaWMS(0);  

google.maps.event.addDomListener(window, 'load', initialize);
function initialize() {
    var mapOptions = {
        zoom: 4,
        center: Pcenter,
        mapTypeId: 'OSM',
        minZoom: 4,
        maxZoom: 17,
        mapTypeControlOptions: {
            mapTypeIds: ['OSM', 'Watercolor', google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE, google.maps.MapTypeId.HYBRID, google.maps.MapTypeId.TERRAIN],
            style: google.maps.MapTypeControlStyle.SMALL,
            position: google.maps.ControlPosition.LEFT_BOTTOM
        }
        , scaleControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL
        },
        navigationControlOptions: {style: google.maps.NavigationControlStyle.ZOOM_PAN}

    };
    map = new google.maps.Map(document.getElementById('map'),
            mapOptions);
    map.mapTypes.set('OSM', osmMapType);
    map.mapTypes.set("Watercolor", new google.maps.StamenMapType("watercolor"));
    map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
    
    //Cargar Capas al Iniciar Google
    try {
        if (typeof CargarEHPredeterminado === 'function') {
            //Es seguro ejecutar la función
            CargarEHPredeterminado();
        }
        if (typeof load_capa_gestor_google === 'function') {
            //Es seguro ejecutar la función
            //Carga capas de kml o json o rss en agregar capa
            load_capa_gestor_google();
        }
        if (typeof load_data_maps === 'function') {
            //Es seguro ejecutar la función
            //Carga capas de kml o json o rss en agregar capa
            load_data_maps();
        }

    } catch (e) {
    }
    $(".map").attr("class", "map map2")
    
    
   

}


function  SetCapaWMS(layer) {

    SLPLayer = getNewMapTypes_WMS(urlbase, layer);
}
function AddWMS(_urlbase, layer, id, titulo) {
    var NewMap = getNewMapTypes_WMS(_urlbase, layer, id, titulo);
    layers.push([id, NewMap]);
    map.overlayMapTypes.push(NewMap);
}
function Transparencia(layer, opacity) {
    var indice = -1;
    for (i = 0; i < layers.length; i++) {
        if (layers[i][0] == layer) {
            indice = i;
            break;
        }
    }

    layers[indice][1].opacity = opacity;
    map.overlayMapTypes.setAt(indice, layers[indice][1]);
}
function RemoveWMS(id) {
    var indice = -1;
    for (i = 0; i < layers.length; i++) {
        if (layers[i][0] == id) {
            indice = i;
            break;
        }
    }
    map.overlayMapTypes.removeAt(indice);
    layers.splice(indice, 1);
    // layers = jQuery.grep(layers, function(value) {
    //   return value[0] != id;
    // });
}
function RemoveKML(id) {
    var indice = -1;
    for (i = 0; i < kml_layers.length; i++) {
        if (kml_layers[i][0] == id) {
            indice = i;
            break;
        }
    }
    kml_layers[i][1].setMap(null);    
    kml_layers.splice(indice, 1);
    // layers = jQuery.grep(layers, function(value) {
    //   return value[0] != id;
    // });
}
function RemoveJSON(id) {
   remove_recurso_geojson(id);
}

function getLeyenda(_urlbase, layer) {

    var url = _urlbase;
    url += "&REQUEST=GetLegendGraphic"; //WMS operation
    url += "&SERVICE=WMS"; //WMS service
    url += "&VERSION=1.1.0"; //WMS version  
    url += "&LAYER=" + layer; //WMS layers                       
    url += "&FORMAT=image/png"; //WMS format image/png 
    // url += "&WIDTH=256";         //tile size in google
    //url += "&HEIGHT=256";
    return  url;
}
function getNewMapTypes_WMS_Gestor(_urlcompleto, nombre, titulo) {
    
    var ImageMapType= new google.maps.ImageMapType({
        getTileUrl: function (coord, zoom) {
            var proj = map.getProjection();
            var zfactor = Math.pow(2, zoom);
            // get Long Lat coordinates
            var top = proj.fromPointToLatLng(new google.maps.Point(coord.x * 256 / zfactor, coord.y * 256 / zfactor));
            var bot = proj.fromPointToLatLng(new google.maps.Point((coord.x + 1) * 256 / zfactor, (coord.y + 1) * 256 / zfactor));
            //corrections for the slight shift of the SLP (mapserver)
            var deltaX = 0.0013;
            var deltaY = 0.00058;
            //create the Bounding box string
            var bbox = (top.lng() + deltaX) + "," +
                    (bot.lat() + deltaY) + "," +
                    (bot.lng() + deltaX) + "," +
                    (top.lat() + deltaY);
            //base WMS URL
            var url = _urlcompleto;
            url += "&EXCEPTIONS=application/vnd.ogc.se_inimage"; //set estilo
            url += "&BBOX=" + bbox;
            return url; // return URL for the tile

        },
        tileSize: new google.maps.Size(256, 256),
        isPng: true,
        alt: titulo,
        name: nombre,
    });
  $("#cargando").show();
    ImageMapType.addListener("tilesloaded", function (event) {
        $("#cargando").hide();
    });
  
    return ImageMapType;
    
}
function getNewMapTypes_WMS(_urlbase, layer, nombre, titulo) {
    var ImageMapType= new google.maps.ImageMapType({
        getTileUrl: function (coord, zoom) {
            var proj = map.getProjection();
            var zfactor = Math.pow(2, zoom);
            // get Long Lat coordinates
            var top = proj.fromPointToLatLng(new google.maps.Point(coord.x * 256 / zfactor, coord.y * 256 / zfactor));
            var bot = proj.fromPointToLatLng(new google.maps.Point((coord.x + 1) * 256 / zfactor, (coord.y + 1) * 256 / zfactor));
            //corrections for the slight shift of the SLP (mapserver)
            var deltaX = 0.0013;
            var deltaY = 0.00058;
            //create the Bounding box string
            var bbox = (top.lng() + deltaX) + "," +
                    (bot.lat() + deltaY) + "," +
                    (bot.lng() + deltaX) + "," +
                    (top.lat() + deltaY);
            //base WMS URL
            var url = _urlbase;
            url += "&REQUEST=GetMap"; //WMS operation
            url += "&SERVICE=WMS"; //WMS service
            url += "&VERSION=1.1.0"; //WMS version  
            url += "&LAYERS=" + layer; //WMS layers                       
            url += "&FORMAT=image/png8"; //WMS format
            url += "&BGCOLOR=0xFFFFFF";
            url += "&TRANSPARENT=TRUE";
            url += "&SRS=EPSG:4326"; //set WGS84 
            url += "&STYLES="; //set estilo
            url += "&EXCEPTIONS=application/vnd.ogc.se_inimage"; //set estilo
            url += "&BBOX=" + bbox; // set bounding box
            url += "&WIDTH=256"; //tile size in google
            url += "&HEIGHT=256";
            return url; // return URL for the tile

        },
        tileSize: new google.maps.Size(256, 256),
        isPng: true,
        alt: titulo,
        name: nombre
    });
    $("#cargando").show();
    ImageMapType.addListener("tilesloaded", function (event) {
        $("#cargando").hide();
    });
 
    return ImageMapType;
    
    
}
function addOverlay() {
    map.overlayMapTypes.push(SLPLayer);
}
function addOverlayGestor(urlcompleto, nombre, titulo) {
    SLPLayer = getNewMapTypes_WMS_Gestor(urlcompleto, nombre, titulo)
    layers.push([urlcompleto, SLPLayer]);
    map.overlayMapTypes.push(SLPLayer);
}
// [START region_removal]
function removerCapas() {
   removeOverlay();
   remove_all_feature_json();
   deleteKmls();
}
function removeOverlay(){
    map.overlayMapTypes.clear();
    layers = [];
}


function posicion1() {
    var myLatlng = new google.maps.LatLng(-3.7484231, -73.2670069);
    marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        title: "Hello World!"
    });
}

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


/*Para los Puntos*/
function setAllMap(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}
// Para Ocultar puntos
function clearMarkers() {
    setAllMap(null);
}
// Para Mostrar los ´Puntos Ocultos
function showMarkers() {
    setAllMap(map);
}
// Para Eliminar los Puntos
function deleteMarkers() {
    clearMarkers();
    markers = [];
    map.setZoom(4);
}
function setMarkers(map, locations) {

    var image = {
        url: 'images/beachflag.png',
        size: new google.maps.Size(20, 32),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(0, 32)
    };
   
    var infowindow = new google.maps.InfoWindow({
        content: 'Sin datos'
    });
    for (var i = 0; i < locations.length; i++) {
        var beach = locations[i];
        var myLatLng = new google.maps.LatLng(beach['lat'].trim(), beach['lng'].trim());

        var icono = {path: google.maps.SymbolPath.CIRCLE,
            scale: 5, //tamaño
            strokeColor: '#181717', //color del borde
            strokeWeight: 2, //grosor del borde
            fillColor: '#DC4848', //color de relleno
            fillOpacity: 1// opacidad del relleno
        };
         var shape = {
        coords: [1, 1, 1, 23, 10, 23, 15, 13,15,45,45,1],
        type: 'poly'
        };
        var icono = {
            url: _root_ +'public/img/rsz_1icon_investigacion_opinion_publica.png',
            size: new google.maps.Size(43, 45),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(0, 45)
        };       
        if ($.trim((beach.icon).toLowerCase()) == "animalia") {
            icono = {path: google.maps.SymbolPath.CIRCLE,
		//url: _root_ +'public/img/animalia.png',
                scale: 5, //tamaño
                strokeColor: '#181717', //color del borde
                strokeWeight: 2, //grosor del borde
                fillColor: '#DC4848', //color de relleno
                fillOpacity: 1// opacidad del relleno
            };
              var shape = {
                coords: [1, 1, 1, 20, 18, 20, 18, 1],
                type: 'poly'
            };
        } else if ($.trim((beach.icon).toLowerCase()) == "plantae") {
            icono = {path: google.maps.SymbolPath.CIRCLE,
		//url: _root_ +'public/img/plantae.png',
                scale: 5, //tamaño
                strokeColor: '#181717', //color del borde
                strokeWeight: 2, //grosor del borde
                fillColor: '#6DB35A', //color de relleno
                fillOpacity: 1// opacidad del relleno
            };
              var shape = {
        coords: [1, 1, 1, 20, 18, 20, 18, 1],
        type: 'poly'
    };
        } else if ($.trim((beach.icon).toLowerCase()) == "estacion") {
            icono = { path: google.maps.SymbolPath.CIRCLE,
		//url: _root_ +'public/img/location2.png',
                scale: 5, //tamaño
                strokeColor: '#181717', //color del borde
                strokeWeight: 2, //grosor del borde
                fillColor: '#DC4848', //color de relleno
                fillOpacity: 1// opacidad del relleno
            };
              var shape = {
        coords: [1, 1, 1, 20, 18, 20, 18, 1],
        type: 'poly'
    };
        }

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            //icon: _root_ + 'public/img/' + icono + '.png',
            icon: icono,
            shape: shape,
            title: beach['nombre'],
            // zIndex: beach["zindex"],
            html: beach['html'],
            referencia: beach.referencia,
            idDatosM: [beach.idestacion, beach.idvariable],
            idDatoD: beach.iddarwin,
            idDatosG: beach.filtro,
            tabla: beach.tabla,
            fecha: beach.fecha,
            lat: beach.lat,
            lng: beach.lng,
            columna: beach.columna,
            recurso: beach.recurso

        });
        google.maps.event.addListener(marker, 'click', function () {
            map.setCenter(new google.maps.LatLng(map.getCenter().lat(), this.position.lng()));
            var html = "<div id='html_marker'><img style='-webkit-user-select: none' src='http://www.hotelbahiarosario.com.ar/carga.gif'></div>";
            infowindow.setContent(html);
            infowindow.open(map, this);
            if (this.referencia == "monitoreo-ca") {
                cargarInfoWindowM(this);
            } else if (this.referencia == "darwin") {
                cargarInfoWindowD(this);
            } else if (this.referencia == "estandar-ge") {
                cargarInfoWindowEG(this);
            }


        });

        markers.push(marker);

        if ($.trim((beach.icon).toLowerCase()) == "estacion") {
            //animateMarkerTimeLine(marker);     
        }
    }
}
/*Para KML GEOXML#*/
function load_kml_geoxml3(kml) {
    var myParser = new geoXML3.parser({map: map});
    myParser.parse(_root_+'public/kml/temp/' + kml);
}
function verkml(urlcompleto) {
    var myParser = new geoXML3.parser({map: map});
    myParser.parse(urlcompleto);
}

/*Para KML Google Maps Api#*/
function add_kml_google(id, url_kml) {

    var kml_layer = new google.maps.KmlLayer({
        url: url_kml,
        suppressInfoWindows: false,
        map: map
    });
    var temp_kmls=[id,kml_layer];
    $("#cargando").show();
    google.maps.event.addListener(kml_layer, 'status_changed', function () {
        $("#cargando").hide();
        console.log('KML load: ' + kml_layer.getStatus());
        if (kml_layer.getStatus() != 'OK') {
            mensaje([['error','[' + kml_layer.getStatus() + '] Google Maps could not load the layer. Please try again later.']])
            
        } else {
            kml_layers.push(temp_kmls);            
        }
    });
    google.maps.event.addListener(kml_layer, 'metadata_changed', function () {
        if (typeof cargar_metada_kml === 'function') {
            //Es seguro ejecutar la función
            //Carga capas de kml o json o rss en agregar capa
            cargar_metada_kml(kml_layer.metadata);
        }
    });
  
}
function deleteKmls() {
        clearkmls();        
        kml_layers = [];        
}
function kml_setAllMap(map) {
    for (var i = 0; i < kml_layers.length; i++) {
        kml_layers[i][1].setMap(map);
    }
}
function clearkmls() {
    kml_setAllMap(null);
}
function showKmls() {
    kml_setAllMap(map);
}
/*Para geoJSon Google Maps Api#*/
function load_GeoJson_google(id,url) {
    
      var infowindow = new google.maps.InfoWindow({
        content: 'Sin datos'
    });
      $("#cargando").show();
    map.data.loadGeoJson(url);
    json_features[id]=[];
    //map.data.loadGeoJson("https://raw.githubusercontent.com/smartchicago/chicago-atlas/master/db/import/zipcodes.geojson");
     map.data.addListener('addfeature', function (event) { 
         json_features[id].push(event.feature); 
         $("#cargando").hide();
    });
    
    map.data.addListener('click', function (event) {
        //show an infowindow on click   
       
        var div='<div> <table  class="table table-striped  table-bordered">';
        div=div+'<tr><th>Feature id:</th><td>'+ event.feature.getId()+'</td>';
         event.feature.forEachProperty(function(val,key){ 
            div=div+'<tr><th>'+key+':</th><td>'+JSON.stringify(val)+'</td>';             
        });
        div=div+'</table></div>';
        infowindow.setContent(div);
        var anchor = new google.maps.MVCObject();
        anchor.set("position", event.latLng);
        infowindow.open(map, anchor);
    });
}
function remove_feature_json(feature){
     map.data.remove(feature);
     
}
function remove_recurso_geojson(id){
     json_features[id].forEach(function (item) {
        remove_feature_json(item);
    });  
    json_features.splice(id,1);
     
}
function remove_all_feature_json(){
    json_features.forEach(function (item) {
        item.forEach(
                function (item2){
                    remove_feature_json(item2);
                });        
    });
    json_features=[];
}



function CapasDefecto() {
    var url = "http://200.60.174.200/ArcGIS/services/CIIFEN_BIOGEOFIS/areadeestudio/MapServer/WMSServer?";
    var nombre = "2";
    AddWMS(url, nombre, "cb_layerWMS_2960");
}
function AgregarControlMap(controlposition, divName) {//controlposition="TOP_LEFT,LEFT_TOP"; divName="etiquetahtml" 
    // var newDiv = new MakeControl(divName, "dsfd");

    map.controls[controlposition].push(divName);
}
function animateMarkerTimeLine(marker) {
    var fillColor = "#DC4848";
    window.setInterval(function () {

        var icon = marker.get('icon');
        if (icon.fillColor == fillColor)
            icon.fillColor = "#4B9429";
        else
            icon.fillColor = fillColor;
        marker.set('icon', icon);
    }, 1000);
}

function UrlExists(url) {
  var http = new XMLHttpRequest();
  http.open('HEAD', url, false);
  http.send();
  console.log(http.status);  
}