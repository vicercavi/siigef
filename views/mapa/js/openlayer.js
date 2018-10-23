var map;
var marker;
var markers=[];
var layers = [];

var vectorLayer = new ol.layer.Vector({
  source: new ol.source.GeoJSON({      
    url: '../../public/output.json'
  })  
});



//inicializa OPen Layer
function CargarOL(){


 map=new ol.Map({
    target: 'map',
    layers:[ new ol.layer.Tile({source: new ol.source.OSM()}),vectorLayer ] ,
    view: new ol.View({
       center: ol.proj.transform([-60.261483124999984,-9.042127712029426],'EPSG:4326','EPSG:3857'),
      zoom: 4
    })
  });
  
$("#gmap").hide();
$("#olmap").hide();

}

function clearMarkers() {
  //setAllMap(null);
}

// Para Eliminar los Puntos
function deleteMarkers() {
  clearMarkers();
  markers = [];
} 

function addOverlayGestor(url,urlb,id){
    var layer=getLayerImagen(url,urlb)
    layers.push([id,layer]);
    map.addLayer(layer);
}
function removeOverlayGestor(id){ 
    var indice=-1;
    for (i = 0; i < layers.length; i++) {
        if(layers[i][0]=id){
            indice=i;
            break;
        }
    }
    map.removeLayer(layers[indice][1]);
    layers = jQuery.grep(layers, function(value) {
        return value[0] != id;
      });
}

function  getLayerImagen(url,urlb){    
   var spli1=url.split("&");
   var layerval;
   var styleval;
    for (i = 0; i < spli1.length; i++) {
        if(spli1[i].indexOf("LAYERS")>=0){
            layerval=spli1[i].split("=")[1];
        }else if (spli1[i].indexOf("STYLES")>=0){
            styleval=spli1[i].split("=")[1];
        }
    }
    
   var layer =  new ol.layer.Image({  
    source: new ol.source.ImageWMS({
      url: urlb,
      params: {'LAYERS': layerval,'STYLES':styleval}
    })
  });
    return layer;  
}


$(document).ready(function() {
    CargarOL();
});

var iconFeatures=[];

var iconFeature = new ol.Feature({
  geometry: new ol.geom.Point([0, 0]),
  name: 'Null Island',
  population: 4000,
  rainfall: 500
});

var iconFeature1 = new ol.Feature({
  geometry: new ol.geom.Point(ol.proj.transform([-73.1234, 45.678], 'EPSG:4326',     
  'EPSG:3857')),
  name: 'Null Island Two',
  population: 4001,
  rainfall: 501
});

iconFeatures.push(iconFeature);


var vectorSource = new ol.source.Vector({
  features: iconFeatures //add an array of features
});

var iconStyle = new ol.style.Style({
  image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
    anchor: [0.5, 46],
    anchorXUnits: 'fraction',
    anchorYUnits: 'pixels',
    opacity: 0.75,
    src: '../../public/img/location.png'
  }))
});


var vectorLayer = new ol.layer.Vector({
  source: vectorSource,
  style: iconStyle
});


//integarar GOOGLE MAPS 
