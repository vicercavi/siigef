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
    map.minZoom=3;
    map.zoom=3;
}