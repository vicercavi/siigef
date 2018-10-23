/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function LlamadaSimpleWMS(inputurlbase) {
    var urlbase;
    if (inputurlbase.indexOf("?") == inputurlbase.length - 1) {
       urlbase = inputurlbase;
    } else if (inputurlbase.indexOf("?") == -1) {
       urlbase = inputurlbase + "?";
    } else {
       urlbase = inputurlbase + "&";
    }
    var peticionCapabilities = urlbase + "request=GetCapabilities&service=WMS";
    
}


function respuestaCapabilities(response, io){
	var responsexml = dojox.xml.parser.parse(response);
	//console.log(responsexml);
	var x = responsexml.getElementsByTagName("WMS_Capabilities");
	if (x[0] == undefined){
		x = responsexml.getElementsByTagName("WMT_MS_Capabilities");
		if (x[0] == undefined){
			alert("El servicio WMS no se puede cargar. Versión del WMS diferente de la 1.3.0 ó 1.1.1, dirección incorrecta, o servidor de mapas caído.");
			return false;
		}
	}
	var versionWMS = x[0].getAttribute("version");

	var nodesService = responsexml.getElementsByTagName("Service");
	var nombreServicio = "WMS_" + nodesService[0].getElementsByTagName("Name")[0].childNodes[0].nodeValue;
	nombreServicio = nombreServicio.replace(/[^a-zA-Z 0-9.]+/g,'_');
	nombreServicio = nombreServicio.replace(/ /g, '_');
	dojo.byId("inputNombreServicioWMS").value = nombreServicio;
	var tituloServicio = nodesService[0].getElementsByTagName("Title")[0].childNodes[0].nodeValue;

	var esta25830 = false;
	var nodesChildLayer = responsexml.getElementsByTagName("Layer")[0].childNodes;
	for (i=0;i<nodesChildLayer.length;i++) {
		if (nodesChildLayer[i].nodeType==1) {
			if (nodesChildLayer[i].nodeName == "CRS" || nodesChildLayer[i].nodeName == "SRS") {
				var srs = nodesChildLayer[i].childNodes[0].nodeValue;
				if (srs.indexOf(" ") != -1){
					var v_srs = convierteAVector5(srs);
					for (j=0;j<v_srs.length;j++) {
						if (v_srs[j] == "EPSG:25830"){
							esta25830 = true;
							break;
						}
					}
				} else if (srs == "EPSG:25830"){
					esta25830 = true;
					break;
				}
			}
		}
	}

	if (esta25830 == false){
		alert("El servicio WMS no soporta el Sistema de Referencia del visor (EPSG:25830) y no se puede cargar la capa.");
		return false;
	}
	
	var nodesLayer = responsexml.getElementsByTagName("Layer");
	var listadoCapas;
	var contCapas = 0;
	for (var i=1; i<nodesLayer.length; i++){
		if (nodesLayer[i].getAttribute("queryable") != null){
			nombreCapa = nodesLayer[i].getElementsByTagName("Name")[0].childNodes[0].nodeValue;
			tituloCapa = nodesLayer[i].getElementsByTagName("Title")[0].childNodes[0].nodeValue;
			if (contCapas==0){
				listadoCapas = nombreCapa + "," + tituloCapa;
				capasVisibles = nombreCapa;
			} else {
				listadoCapas += ";" + nombreCapa + "," + tituloCapa;
			}
			contCapas++;
		}
	}
	
	var urlPeticionGetMap = dojo.byId("inputDireccionWMS").value;
	serWMS[nombreServicio] = new Array(tituloServicio,nombreServicio,urlPeticionGetMap,versionWMS,listadoCapas,capasVisibles);
	//Comprobamos que si devuelve error de petición (en versión 1.3.0), entonces realizar la misma petición con la versión 1.1.1
	if (versionWMS == "1.3.0") {
		
		var peticionGetMapPrueba = urlPeticionGetMap + "SERVICE=WMS&REQUEST=GetMap&FORMAT=image/png&TRANSPARENT=TRUE&STYLES=&VERSION=1.3.0&LAYERS=" + capasVisibles +  "&WIDTH=20&HEIGHT=20&CRS=EPSG:25830&BBOX=416000,416001,4472000,4472001";

		var url = esri.urlToObject(peticionGetMapPrueba);
		var requestHandle = esri.request({
			url: url.path,
			content: url.query,
			handleAs: "text",
			load: respuestaGetMapPrueba,
			error: function (){
					addWMSLayer(serWMS[nombreServicio][0], serWMS[nombreServicio][1], serWMS[nombreServicio][2], serWMS[nombreServicio][3], serWMS[nombreServicio][4], serWMS[nombreServicio][5]);
			}
		}, {useProxy:true});
	} else {
		addWMSLayer(tituloServicio, nombreServicio, urlPeticionGetMap, versionWMS, listadoCapas, capasVisibles);
	}
}

function addWMSLayer(nombreWMS, idWMS, urlWMS, versionWMS, layersWMS, visibleLayersWMS){
	var idWMSSSuf = idWMS;
	var idWMS = idWMS + "_" + contadorCapas;
	var capasWMS = convierteAVector(layersWMS);
	var vectorLayerInfos =[];
	for (var i = 0; i < capasWMS.length; i++) {
		var nombre = convierteAVector2(capasWMS[i])[0];
		var titulo = convierteAVector2(capasWMS[i])[1];
		var layerWMS = new esri.layers.WMSLayerInfo({
			name: nombre,
			title: titulo
		});
		vectorLayerInfos.push(layerWMS);
	}
    var resourceInfo = {
    	extent: new esri.geometry.Extent(xExtCVMin,yExtCVMin,xExtCVMax,yExtCVMax,{wkid: sistRefVisor}),
        layerInfos: vectorLayerInfos,
		version: versionWMS
    };
	
    var CapaWMS = new esri.layers.WMSLayer(urlWMS,{
		id:idWMS,
		resourceInfo: resourceInfo,
        visibleLayers: [visibleLayersWMS]
    });
	CapaWMS.setImageFormat("png");
	var nombreCapaWMS = nombreWMS + " (" + contadorCapas + ")";
	nomServicio[idWMS] = new Array(idWMS,idWMSSSuf,nombreCapaWMS,true,false,false);
	map.addLayer(CapaWMS);
	contadorCapas++;
	addTOC(CapaWMS);
}




