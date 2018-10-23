        OpenLayers.ProxyHost = "/cgi-bin/proxy.cgi?url=";
Ext.BLANK_IMAGE_URL = 'libs/img/s.gif';
var model, tree, nodo, map, toolbar, queryEventHandler, req, ventanaXY;
var map, layer, running = false;
OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {defaultHandlerOptions: {'single': true, 'delay': 100}});
Ext.onReady(function()
{
    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
//Ext.MessageBox.show({title: 'Secretar&iacute;a de Energ&iacute;a.',msg: 'Bienvenidos al visor SIG',animateTarget: 'center',icon : Ext.MessageBox.INFO});(function(){Ext.MessageBox.hide();}).defer(6000);
    Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
    var mask = new Ext.LoadMask(Ext.getBody(), {msg: "Cargando..."});
    graticule = new OpenLayers.Control.Graticule({autoActivate: false, numPoints: 2, labelled: true});
    leye = [
        'http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=%2Fvar%2Fwww%2Fhtml%2Fvisor%2Fgeofiles%2Fmap%2Fmapase.map&LAYER=',
        '&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1'
    ];
    leyes = [
        'http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=%2Fvar%2Fwww%2Fhtml%2Fvisor%2Fgeofiles%2Fmap%2Fmapase_s.map&LAYER=',
        '&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1'
    ];

    var options =
            {theme: null,
                projection: ("EPSG:900913"),
                displayProjection: new OpenLayers.Projection("EPSG:4326"),
                units: 'm',
                maxResolution: 'auto',
                minZoomLevel: 4,
                maxExtent: new OpenLayers.Bounds(-2.003750834E7, -2.003750834E7, 2.003750834E7, 2.003750834E7),
                restrictedExtent: new OpenLayers.Bounds(-12024461.791444, -7797799.876144, -2064411.259556, -2377497.327356),
                numZoomLevels: 16,
                controls: [
                    graticule,
                    new OpenLayers.Control.ScaleLine(('Escala')),
                    new OpenLayers.Control.Navigation({'zoomWheelEnabled': true}), new OpenLayers.Control.Navigation(),
                    new OpenLayers.Control.ZoomBox({alwaysZoom: true}),
                    new OpenLayers.Control.PanZoomBar()], allOverlays: false};


    map = new OpenLayers.Map('map', options);

    var GoogleMapsAR = new OpenLayers.Layer.OSM("GoogleMapsAR", ["https://mts1.google.com/vt/lyrs=m&hl=es&gl=AR&src=app&rlbl=1&x=${x}&y=${y}&z=${z}"], {
        "attribution": "Map data &copy;2014 Google, Inav/Geosistemas SRL",
        "tileOptions": {
            "crossOriginKeyword": null
        },
        numZoomLevels: 20,
        sphericalMercator: true,
    });

    map.addLayer(GoogleMapsAR);


    var markers = new OpenLayers.Layer.Markers("Markers");
    var loadingpanel = new OpenLayers.Control.LoadingPanel();
    map.addControl(loadingpanel);
    map.addLayer(markers);
    var size = new OpenLayers.Size(39, 39);
    var offset = new OpenLayers.Pixel(-(size.w / 2), -size.h);
    var icon = new OpenLayers.Icon('libs/OpenLayer/img/marker.png', size, offset);
    var pixel = new OpenLayers.Pixel(1, 1);
    var keyboardnav;
    keyboardnav = new OpenLayers.Control.KeyboardDefaults();
    map.addControl(keyboardnav);


    var sM = new OpenLayers.StyleMap({"default": new OpenLayers.Style(null, {rules: [new OpenLayers.Rule({symbolizer: Ext.apply({"Polygon": {strokeWidth: 2, strokeOpacity: 1, strokeColor: "#666666", fillColor: "white", fillOpacity: 0.3, strokeDashstyle: "dash"}}, this.symbolizers)})]})});

    polygonLayer = new OpenLayers.Layer.Vector("Buffer", {styleMap: sM});


    OpenLayers.Layer.base_osm = OpenLayers.Class(OpenLayers.Layer.XYZ, {name: "base_osm", sphericalMercator: true, url: ' http://otile1.mqcdn.com/tiles/1.0.0/osm/${z}/${x}/${y}.png', clone: function(obj) {
            if (obj === null) {
                obj = new OpenLayers.Layer.OSM(this.name, this.url, this.getOptions());
            }
            obj = OpenLayers.Layer.XYZ.prototype.clone.apply(this, [obj]);
            return obj;
        }, CLASS_NAME: "OpenLayers.Layer.base_osm"});


    var apiKey = "AiWPfo3I7iq-SPNbUb2yksk5rciUuL_MZySXzXjZnxRLKSm38f5QVMFddTh5K2VS";

    var base_analisis = new OpenLayers.Layer.WMS.Untiled("base_analisis", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: 'varios_poligono_mundo', format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', opacity: 0.6, buffer: 1, visibility: false});

    var base_bing_aereo = new OpenLayers.Layer.Bing({name: "base_bing_aereo", key: apiKey, type: "Aerial"});

    /*
     var base_bing_calles = new OpenLayers.Layer.Bing({ name: "base_bing_calles", key: apiKey,type: "Road" });
     var base_bing_hibrido = new OpenLayers.Layer.Bing({ name: "base_bing_hibrido", key: apiKey,type: "AerialWithLabels"});
     var base_google_calles = new OpenLayers.Layer.Google("base_google_calles",{'sphericalMercator': true, visibility: false}); 
     var base_google_fisico = new OpenLayers.Layer.Google("base_google_fisico",{type: google.maps.MapTypeId.TERRAIN,'sphericalMercator': true, visibility: false}); 
     var base_google_hibrido = new OpenLayers.Layer.Google("base_google_hibrido",{type: google.maps.MapTypeId.HYBRID,'sphericalMercator': true, visibility: false } );
     var base_google_satelital = new OpenLayers.Layer.Google("base_google_satelital",{type: google.maps.MapTypeId.SATELLITE,'sphericalMercator': true, visibility: false }  ); 
     */





    var capaargenmap = new OpenLayers.Layer.WMS("capaargenmap", "http://wms.ign.gob.ar/geoserver/gwc/service/wms", {layers: "capabaseargenmap", transparent: true}, {opacity: 1, singleTile: false, isBaseLayer: true});

    var base_mapnik = new OpenLayers.Layer.OSM("base_mapnik");
    var base_osm = new OpenLayers.Layer.base_osm();


////////////////weather//////////////////
    stations = new OpenLayers.Layer.XYZ(
            "stations",
            "http://${s}.tile.openweathermap.org/map/precipitation/${z}/${x}/${y}.png",
            {
                numZoomLevels: 16,
                isBaseLayer: false,
                opacity: 0.6,
                sphericalMercator: true
            }
    );

    stations2 = new OpenLayers.Layer.Vector.OWMStations("stations2", {units: 'metric', opacity: 0.5});


    stations3 = new OpenLayers.Layer.Vector.OWMWeather("stations3", {units: 'metric', opacity: 0.5});

    stations4 = new OpenLayers.Layer.XYZ(
            "stations4",
            "http://${s}.tile.openweathermap.org/map/clouds/${z}/${x}/${y}.png",
            {
                numZoomLevels: 19,
                isBaseLayer: false,
                opacity: 0.7,
                sphericalMercator: true

            }
    );
    stations5 = new OpenLayers.Layer.XYZ(
            "stations5",
            "http://${s}.tile.openweathermap.org/map/pressure_cntr/${z}/${x}/${y}.png",
            {
                numZoomLevels: 16,
                isBaseLayer: false,
                opacity: 0.4,
                sphericalMercator: true

            }
    );




//////////

    var fondomarino = new OpenLayers.Layer.XYZ("fondomarino",
            "http://server.arcgisonline.com/ArcGIS/rest/services/Ocean_Basemap/MapServer/tile/${z}/${y}/${x}",
            {numZoomLevels: 16,
                isBaseLayer: false,
                opacity: 1, sphericalMercator: true});



    var fondomarino2 = new OpenLayers.Layer.WMS("fondomarino2", "http://www.mapserver.isa.org.jm/ArcGIS/rest/services/Maps/global2/MapServer/export?transparent=true&dpi=96&bboxSR=3857&imageSR=3857&f=image&format=png8", {numZoomLevels: 16,
        isBaseLayer: true,
        transparent: true,
        opacity: 1, sphericalMercator: true});

    /*
     map.addLayer(fondomarino);	
     map.addLayer(fondomarino2);
     
     map.addLayers([stations,stations2,stations3,stations4,stations5]);
     stations.setVisibility(false);
     stations2.setVisibility(false);
     stations3.setVisibility(false);
     stations4.setVisibility(false);
     stations5.setVisibility(false);
     */

////////////////weather////////////////// 




//malvinas over

    /*
     var malvinasover = new OpenLayers.Layer.WMS("malvinasover","http://ide.minplan.gob.ar/ide-minplan/geoServices/wms?LAYERS=IdemPlan%3Amin_islas_malvinas6&TRANSPARENT=TRUE&FORMAT=image%2Fpng&TILED=true&SERVICE=WMS&VERSION=1.1.1&REQUEST=GetMap&STYLES=&SRS=EPSG%3A900913", {	numZoomLevels: 16, 
     isBaseLayer: false,
     transparent:true,
     opacity: 1,sphericalMercator: true});
     
     map.addLayer(malvinasover);
     malvinasover.setVisibility(false);
     */


//malvinas over




    var analisis_distancia_a_terminalesdesp_merge = new OpenLayers.Layer.WMS.Untiled("analisis_distancia_a_terminalesdesp_merge", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "analisis_distancia_a_terminalesdesp_merge", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var distrocomahue_eett = new OpenLayers.Layer.WMS.Untiled("distrocomahue_eett", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "distrocomahue_eett", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var distrocomahue_red_at = new OpenLayers.Layer.WMS.Untiled("distrocomahue_red_at", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "distrocomahue_red_at", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var distrocuyo_estaciones_transformadoras = new OpenLayers.Layer.WMS.Untiled("distrocuyo_estaciones_transformadoras", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "distrocuyo_estaciones_transformadoras", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var distrocuyo_lineas_tension = new OpenLayers.Layer.WMS.Untiled("distrocuyo_lineas_tension", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "distrocuyo_lineas_tension", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var electrica_centrales_generacion_parques_eolicos = new OpenLayers.Layer.WMS.Untiled("electrica_centrales_generacion_parques_eolicos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "electrica_centrales_generacion_parques_eolicos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var electrica_centrales_generacion_parques_solares = new OpenLayers.Layer.WMS.Untiled("electrica_centrales_generacion_parques_solares", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "electrica_centrales_generacion_parques_solares", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var electrica_generacion_visor_vi_centrales = new OpenLayers.Layer.WMS.Untiled("electrica_generacion_visor_vi_centrales", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "electrica_generacion_visor_vi_centrales", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var electrica_generacion_visor_vi_centrales_eolicas = new OpenLayers.Layer.WMS.Untiled("electrica_generacion_visor_vi_centrales_eolicas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "electrica_generacion_visor_vi_centrales_eolicas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var electrica_generacion_visor_vi_centrales_hidraulicas = new OpenLayers.Layer.WMS.Untiled("electrica_generacion_visor_vi_centrales_hidraulicas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "electrica_generacion_visor_vi_centrales_hidraulicas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var electrica_generacion_visor_vi_centrales_nucleares = new OpenLayers.Layer.WMS.Untiled("electrica_generacion_visor_vi_centrales_nucleares", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "electrica_generacion_visor_vi_centrales_nucleares", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var electrica_generacion_visor_vi_centrales_proyectadas = new OpenLayers.Layer.WMS.Untiled("electrica_generacion_visor_vi_centrales_proyectadas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "electrica_generacion_visor_vi_centrales_proyectadas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var electrica_generacion_visor_vi_centrales_solares = new OpenLayers.Layer.WMS.Untiled("electrica_generacion_visor_vi_centrales_solares", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "electrica_generacion_visor_vi_centrales_solares", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var electrica_generacion_visor_vi_centrales_termicas = new OpenLayers.Layer.WMS.Untiled("electrica_generacion_visor_vi_centrales_termicas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "electrica_generacion_visor_vi_centrales_termicas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var electrica_transporte_eett = new OpenLayers.Layer.WMS.Untiled("electrica_transporte_eett", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "electrica_transporte_eett", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var electrica_transporte_lineas = new OpenLayers.Layer.WMS.Untiled("electrica_transporte_lineas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "electrica_transporte_lineas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var empresas_coop_electricas_bara_georref = new OpenLayers.Layer.WMS.Untiled("empresas_coop_electricas_bara_georref", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "empresas_coop_electricas_bara_georref", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var enargas_gasoductos = new OpenLayers.Layer.WMS.Untiled("enargas_gasoductos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "enargas_gasoductos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var enargas_plantas_compresoras = new OpenLayers.Layer.WMS.Untiled("enargas_plantas_compresoras", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "enargas_plantas_compresoras", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var glp_vi_visor_bocas_productores = new OpenLayers.Layer.WMS.Untiled("glp_vi_visor_bocas_productores", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "glp_vi_visor_bocas_productores", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var glp_vi_visor_depositos = new OpenLayers.Layer.WMS.Untiled("glp_vi_visor_depositos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "glp_vi_visor_depositos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var glp_vi_visor_plantas_fraccionadoras = new OpenLayers.Layer.WMS.Untiled("glp_vi_visor_plantas_fraccionadoras", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "glp_vi_visor_plantas_fraccionadoras", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var hidrocarburos_cuencas_productivas = new OpenLayers.Layer.WMS.Untiled("hidrocarburos_cuencas_productivas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "hidrocarburos_cuencas_productivas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var hidrocarburos_cuencas_sedimentarias = new OpenLayers.Layer.WMS.Untiled("hidrocarburos_cuencas_sedimentarias", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "hidrocarburos_cuencas_sedimentarias", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var hidrocarburos_ley23966 = new OpenLayers.Layer.WMS.Untiled("hidrocarburos_ley23966", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "hidrocarburos_ley23966", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var hidrocarburos_pozos_visor = new OpenLayers.Layer.WMS.Untiled("hidrocarburos_pozos_visor", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "hidrocarburos_pozos_visor", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var hidrocarburos_transporte_vi_visor_jpductos = new OpenLayers.Layer.WMS.Untiled("hidrocarburos_transporte_vi_visor_jpductos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "hidrocarburos_transporte_vi_visor_jpductos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var hidrocarburos_transporte_vi_visor_oleoductos = new OpenLayers.Layer.WMS.Untiled("hidrocarburos_transporte_vi_visor_oleoductos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "hidrocarburos_transporte_vi_visor_oleoductos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var hidrocarburos_transporte_vi_visor_poliductos = new OpenLayers.Layer.WMS.Untiled("hidrocarburos_transporte_vi_visor_poliductos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "hidrocarburos_transporte_vi_visor_poliductos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var hidrocarburos_transporte_vi_visor_propanoductos = new OpenLayers.Layer.WMS.Untiled("hidrocarburos_transporte_vi_visor_propanoductos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "hidrocarburos_transporte_vi_visor_propanoductos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var hidrocarburos_yacimientos_profundidad = new OpenLayers.Layer.WMS.Untiled("hidrocarburos_yacimientos_profundidad", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "hidrocarburos_yacimientos_profundidad", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var hidrografia_naval_curvas_de_nivel = new OpenLayers.Layer.WMS.Untiled("hidrografia_naval_curvas_de_nivel", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "hidrografia_naval_curvas_de_nivel", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var hidrografia_naval_isobatas = new OpenLayers.Layer.WMS.Untiled("hidrografia_naval_isobatas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "hidrografia_naval_isobatas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var hidrografia_naval_tope_de_mareas = new OpenLayers.Layer.WMS.Untiled("hidrografia_naval_tope_de_mareas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "hidrografia_naval_tope_de_mareas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var ign_curvas_nivel = new OpenLayers.Layer.WMS.Untiled("ign_curvas_nivel", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "ign_curvas_nivel", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var ign_departamentos = new OpenLayers.Layer.WMS.Untiled("ign_departamentos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "ign_departamentos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var ign_minas_canteras = new OpenLayers.Layer.WMS.Untiled("ign_minas_canteras", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "ign_minas_canteras", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var ign_provincias = new OpenLayers.Layer.WMS.Untiled("ign_provincias", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "ign_provincias", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var ministerio_educacion_parques_nacionales_poligonos = new OpenLayers.Layer.WMS.Untiled("ministerio_educacion_parques_nacionales_poligonos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "ministerio_educacion_parques_nacionales_poligonos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var ministerio_educacion_parquesprov_pol = new OpenLayers.Layer.WMS.Untiled("ministerio_educacion_parquesprov_pol", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "ministerio_educacion_parquesprov_pol", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_aeroplantas_ypf = new OpenLayers.Layer.WMS.Untiled("padron_eess_aeroplantas_ypf", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_aeroplantas_ypf", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_agip = new OpenLayers.Layer.WMS.Untiled("padron_eess_agip", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_agip", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_agira = new OpenLayers.Layer.WMS.Untiled("padron_eess_agira", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_agira", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_aspro = new OpenLayers.Layer.WMS.Untiled("padron_eess_aspro", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_aspro", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_dapsa = new OpenLayers.Layer.WMS.Untiled("padron_eess_dapsa", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_dapsa", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_dist_esso = new OpenLayers.Layer.WMS.Untiled("padron_eess_dist_esso", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_dist_esso", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_dist_oil = new OpenLayers.Layer.WMS.Untiled("padron_eess_dist_oil", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_dist_oil", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_dist_pdvesa = new OpenLayers.Layer.WMS.Untiled("padron_eess_dist_pdvesa", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_dist_pdvesa", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_dist_petrobras = new OpenLayers.Layer.WMS.Untiled("padron_eess_dist_petrobras", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_dist_petrobras", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_dist_shell = new OpenLayers.Layer.WMS.Untiled("padron_eess_dist_shell", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_dist_shell", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_dist_sinmarca = new OpenLayers.Layer.WMS.Untiled("padron_eess_dist_sinmarca", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_dist_sinmarca", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_dist_ypf = new OpenLayers.Layer.WMS.Untiled("padron_eess_dist_ypf", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_dist_ypf", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_esso = new OpenLayers.Layer.WMS.Untiled("padron_eess_esso", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_esso", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_oil = new OpenLayers.Layer.WMS.Untiled("padron_eess_oil", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_oil", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_pdvsur = new OpenLayers.Layer.WMS.Untiled("padron_eess_pdvsur", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_pdvsur", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_petrobras = new OpenLayers.Layer.WMS.Untiled("padron_eess_petrobras", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_petrobras", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_petroleradelplata = new OpenLayers.Layer.WMS.Untiled("padron_eess_petroleradelplata", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_petroleradelplata", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_refinor = new OpenLayers.Layer.WMS.Untiled("padron_eess_refinor", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_refinor", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_rhasa = new OpenLayers.Layer.WMS.Untiled("padron_eess_rhasa", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_rhasa", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_shell = new OpenLayers.Layer.WMS.Untiled("padron_eess_shell", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_shell", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_sinmarca = new OpenLayers.Layer.WMS.Untiled("padron_eess_sinmarca", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_sinmarca", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_sol = new OpenLayers.Layer.WMS.Untiled("padron_eess_sol", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_sol", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_terminales_despacho = new OpenLayers.Layer.WMS.Untiled("padron_eess_terminales_despacho", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_terminales_despacho", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var padron_eess_ypf = new OpenLayers.Layer.WMS.Untiled("padron_eess_ypf", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "padron_eess_ypf", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var permer_cant_escuelas_depto = new OpenLayers.Layer.WMS.Untiled("permer_cant_escuelas_depto", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "permer_cant_escuelas_depto", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var petroquimicas_plantas = new OpenLayers.Layer.WMS.Untiled("petroquimicas_plantas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "petroquimicas_plantas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var planosbase_concesiones_explotacion = new OpenLayers.Layer.WMS.Untiled("planosbase_concesiones_explotacion", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "planosbase_concesiones_explotacion", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var planosbase_ductos = new OpenLayers.Layer.WMS.Untiled("planosbase_ductos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "planosbase_ductos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var planosbase_lineas_sismicas = new OpenLayers.Layer.WMS.Untiled("planosbase_lineas_sismicas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "planosbase_lineas_sismicas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var planosbase_lotes_explotacion = new OpenLayers.Layer.WMS.Untiled("planosbase_lotes_explotacion", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "planosbase_lotes_explotacion", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var planosbase_permisos_exploracion = new OpenLayers.Layer.WMS.Untiled("planosbase_permisos_exploracion", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "planosbase_permisos_exploracion", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var planosbase_puntos_caracteristicos = new OpenLayers.Layer.WMS.Untiled("planosbase_puntos_caracteristicos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "planosbase_puntos_caracteristicos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var planosbase_puntos_venteo_declarados = new OpenLayers.Layer.WMS.Untiled("planosbase_puntos_venteo_declarados", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "planosbase_puntos_venteo_declarados", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var planosbase_sismica3d = new OpenLayers.Layer.WMS.Untiled("planosbase_sismica3d", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "planosbase_sismica3d", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var planosbase_yacimientos = new OpenLayers.Layer.WMS.Untiled("planosbase_yacimientos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "planosbase_yacimientos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var pronuree_deptos_lamparas_res = new OpenLayers.Layer.WMS.Untiled("pronuree_deptos_lamparas_res", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "pronuree_deptos_lamparas_res", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var pronuree_deptos_luminarias = new OpenLayers.Layer.WMS.Untiled("pronuree_deptos_luminarias", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "pronuree_deptos_luminarias", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var puertos_gnl = new OpenLayers.Layer.WMS.Untiled("puertos_gnl", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "puertos_gnl", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var recursoshidricos_atlas2002_cuencas_hidricas = new OpenLayers.Layer.WMS.Untiled("recursoshidricos_atlas2002_cuencas_hidricas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "recursoshidricos_atlas2002_cuencas_hidricas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var recursoshidricos_atlas2002_evaporacion = new OpenLayers.Layer.WMS.Untiled("recursoshidricos_atlas2002_evaporacion", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "recursoshidricos_atlas2002_evaporacion", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var recursoshidricos_atlas2002_isohietas = new OpenLayers.Layer.WMS.Untiled("recursoshidricos_atlas2002_isohietas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "recursoshidricos_atlas2002_isohietas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var recursoshidricos_atlas2002_isotermas = new OpenLayers.Layer.WMS.Untiled("recursoshidricos_atlas2002_isotermas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "recursoshidricos_atlas2002_isotermas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var recursoshidricos_atlas2010_cuencas_bsas = new OpenLayers.Layer.WMS.Untiled("recursoshidricos_atlas2010_cuencas_bsas", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "recursoshidricos_atlas2010_cuencas_bsas", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var refinerias = new OpenLayers.Layer.WMS.Untiled("refinerias", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "refinerias", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var renovables_bioenergia_balance_biomasa = new OpenLayers.Layer.WMS.Untiled("renovables_bioenergia_balance_biomasa", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "renovables_bioenergia_balance_biomasa", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var renovables_bioenergia_bkgmd_c_biomasa = new OpenLayers.Layer.WMS.Untiled("renovables_bioenergia_bkgmd_c_biomasa", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "renovables_bioenergia_bkgmd_c_biomasa", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var renovables_bioenergia_centrales_biomasa = new OpenLayers.Layer.WMS.Untiled("renovables_bioenergia_centrales_biomasa", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "renovables_bioenergia_centrales_biomasa", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var renovables_bioenergia_consumo_biomasa = new OpenLayers.Layer.WMS.Untiled("renovables_bioenergia_consumo_biomasa", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "renovables_bioenergia_consumo_biomasa", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var renovables_bioenergia_int_bal_f5_5_biomasa = new OpenLayers.Layer.WMS.Untiled("renovables_bioenergia_int_bal_f5_5_biomasa", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "renovables_bioenergia_int_bal_f5_5_biomasa", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var renovables_bioenergia_oferta_biomasa = new OpenLayers.Layer.WMS.Untiled("renovables_bioenergia_oferta_biomasa", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "renovables_bioenergia_oferta_biomasa", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var renovables_geotermica_puntos_interes = new OpenLayers.Layer.WMS.Untiled("renovables_geotermica_puntos_interes", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "renovables_geotermica_puntos_interes", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var renovables_hidroelectrica_pahs = new OpenLayers.Layer.WMS.Untiled("renovables_hidroelectrica_pahs", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "renovables_hidroelectrica_pahs", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var renovables_hidroelectrica_ppah = new OpenLayers.Layer.WMS.Untiled("renovables_hidroelectrica_ppah", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "renovables_hidroelectrica_ppah", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var renovables_plantas_biocombustible = new OpenLayers.Layer.WMS.Untiled("renovables_plantas_biocombustible", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "renovables_plantas_biocombustible", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var segemar_sismos = new OpenLayers.Layer.WMS.Untiled("segemar_sismos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "segemar_sismos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var segemar_yacimientos = new OpenLayers.Layer.WMS.Untiled("segemar_yacimientos", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "segemar_yacimientos", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var sensoresremotos_globalcover2009arg = new OpenLayers.Layer.WMS.Untiled("sensoresremotos_globalcover2009arg", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "sensoresremotos_globalcover2009arg", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.9, visibility: false});
    var sensoresremotos_informes = new OpenLayers.Layer.WMS.Untiled("sensoresremotos_informes", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "sensoresremotos_informes", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var sensoresremotos_modis_treecover = new OpenLayers.Layer.WMS.Untiled("sensoresremotos_modis_treecover", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "sensoresremotos_modis_treecover", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.9, visibility: false});
    var sensoresremotos_mosaico_pan_landsat8 = new OpenLayers.Layer.WMS.Untiled("sensoresremotos_mosaico_pan_landsat8", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "sensoresremotos_mosaico_pan_landsat8", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.9, visibility: false});
    var sensoresremotos_mosaico_rgb_landsat8 = new OpenLayers.Layer.WMS.Untiled("sensoresremotos_mosaico_rgb_landsat8", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "sensoresremotos_mosaico_rgb_landsat8", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.9, visibility: false});
    var sensoresremotos_mos_rgb_conces_actuali_landsat_8 = new OpenLayers.Layer.WMS.Untiled("sensoresremotos_mos_rgb_conces_actuali_landsat_8", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "sensoresremotos_mos_rgb_conces_actuali_landsat_8", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.9, visibility: false});
    var sensoresremotos_venteos_detectados = new OpenLayers.Layer.WMS.Untiled("sensoresremotos_venteos_detectados", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "sensoresremotos_venteos_detectados", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var sig_electrico_concesiones_distribuidoras = new OpenLayers.Layer.WMS.Untiled("sig_electrico_concesiones_distribuidoras", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "sig_electrico_concesiones_distribuidoras", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var transba_estaciones_transformadoras = new OpenLayers.Layer.WMS.Untiled("transba_estaciones_transformadoras", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "transba_estaciones_transformadoras", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var transba_lineas_tension = new OpenLayers.Layer.WMS.Untiled("transba_lineas_tension", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "transba_lineas_tension", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var transener_estaciones_transformadoras = new OpenLayers.Layer.WMS.Untiled("transener_estaciones_transformadoras", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "transener_estaciones_transformadoras", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var transener_estructuras = new OpenLayers.Layer.WMS.Untiled("transener_estructuras", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "transener_estructuras", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var transener_lineas_tension = new OpenLayers.Layer.WMS.Untiled("transener_lineas_tension", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "transener_lineas_tension", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var transnea_estaciones_transformadoras = new OpenLayers.Layer.WMS.Untiled("transnea_estaciones_transformadoras", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "transnea_estaciones_transformadoras", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var transnea_lineas_tension = new OpenLayers.Layer.WMS.Untiled("transnea_lineas_tension", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "transnea_lineas_tension", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var transnoa_estaciones_transformadoras = new OpenLayers.Layer.WMS.Untiled("transnoa_estaciones_transformadoras", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "transnoa_estaciones_transformadoras", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var transnoa_lineas_tension = new OpenLayers.Layer.WMS.Untiled("transnoa_lineas_tension", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "transnoa_lineas_tension", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var transpa_estaciones_transformadoras = new OpenLayers.Layer.WMS.Untiled("transpa_estaciones_transformadoras", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "transpa_estaciones_transformadoras", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var transpa_lineas_tension = new OpenLayers.Layer.WMS.Untiled("transpa_lineas_tension", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "transpa_lineas_tension", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var universidad_sj_bosco_pozos_abandonados = new OpenLayers.Layer.WMS.Untiled("universidad_sj_bosco_pozos_abandonados", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "universidad_sj_bosco_pozos_abandonados", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});
    var vi_r318_visor_instalaciones = new OpenLayers.Layer.WMS.Untiled("vi_r318_visor_instalaciones", "http://sig.se.gob.ar/cgi-bin/mapserv6", {map: '/var/www/html/visor/geofiles/map/mapase.map', layers: "vi_r318_visor_instalaciones", format: 'image/png', transparent: true, singleTile: true}, {isBaseLayer: false, transitionEffect: 'resize', buffer: 1, opacity: 0.8, visibility: false});


    map.addControl(new OpenLayers.Control.Attribution());
    OpenLayers.Feature.prototype.popupClass = OpenLayers.Popup.FramedCloud;

//mapas base
    map.addLayers([
//base_google_satelital,
        base_analisis,
        base_bing_aereo,
//base_bing_calles, base_bing_hibrido, 
//base_google_calles,
//base_google_fisico, base_google_hibrido,

//base_mapnik,base_osm,
        polygonLayer
                , capaargenmap]);

//layers usuario
    map.addLayers([
        analisis_distancia_a_terminalesdesp_merge, distrocomahue_eett, distrocomahue_red_at, distrocuyo_estaciones_transformadoras, distrocuyo_lineas_tension, electrica_centrales_generacion_parques_eolicos, electrica_centrales_generacion_parques_solares, electrica_generacion_visor_vi_centrales, electrica_generacion_visor_vi_centrales_eolicas, electrica_generacion_visor_vi_centrales_hidraulicas, electrica_generacion_visor_vi_centrales_nucleares, electrica_generacion_visor_vi_centrales_proyectadas, electrica_generacion_visor_vi_centrales_solares, electrica_generacion_visor_vi_centrales_termicas, electrica_transporte_eett, electrica_transporte_lineas, empresas_coop_electricas_bara_georref, enargas_gasoductos, enargas_plantas_compresoras, glp_vi_visor_bocas_productores, glp_vi_visor_depositos, glp_vi_visor_plantas_fraccionadoras, hidrocarburos_cuencas_productivas, hidrocarburos_cuencas_sedimentarias, hidrocarburos_ley23966, hidrocarburos_pozos_visor, hidrocarburos_transporte_vi_visor_jpductos, hidrocarburos_transporte_vi_visor_oleoductos, hidrocarburos_transporte_vi_visor_poliductos, hidrocarburos_transporte_vi_visor_propanoductos, hidrocarburos_yacimientos_profundidad, hidrografia_naval_curvas_de_nivel, hidrografia_naval_isobatas, hidrografia_naval_tope_de_mareas, ign_curvas_nivel, ign_departamentos, ign_minas_canteras, ign_provincias, ministerio_educacion_parques_nacionales_poligonos, ministerio_educacion_parquesprov_pol, padron_eess_aeroplantas_ypf, padron_eess_agip, padron_eess_agira, padron_eess_aspro, padron_eess_dapsa, padron_eess_dist_esso, padron_eess_dist_oil, padron_eess_dist_pdvesa, padron_eess_dist_petrobras, padron_eess_dist_shell, padron_eess_dist_sinmarca, padron_eess_dist_ypf, padron_eess_esso, padron_eess_oil, padron_eess_pdvsur, padron_eess_petrobras, padron_eess_petroleradelplata, padron_eess_refinor, padron_eess_rhasa, padron_eess_shell, padron_eess_sinmarca, padron_eess_sol, padron_eess_terminales_despacho, padron_eess_ypf, permer_cant_escuelas_depto, petroquimicas_plantas, planosbase_concesiones_explotacion, planosbase_ductos, planosbase_lineas_sismicas, planosbase_lotes_explotacion, planosbase_permisos_exploracion, planosbase_puntos_caracteristicos, planosbase_puntos_venteo_declarados, planosbase_sismica3d, planosbase_yacimientos, pronuree_deptos_lamparas_res, pronuree_deptos_luminarias, puertos_gnl, recursoshidricos_atlas2002_cuencas_hidricas, recursoshidricos_atlas2002_evaporacion, recursoshidricos_atlas2002_isohietas, recursoshidricos_atlas2002_isotermas, recursoshidricos_atlas2010_cuencas_bsas, refinerias, renovables_bioenergia_balance_biomasa, renovables_bioenergia_bkgmd_c_biomasa, renovables_bioenergia_centrales_biomasa, renovables_bioenergia_consumo_biomasa, renovables_bioenergia_int_bal_f5_5_biomasa, renovables_bioenergia_oferta_biomasa, renovables_geotermica_puntos_interes, renovables_hidroelectrica_pahs, renovables_hidroelectrica_ppah, renovables_plantas_biocombustible, segemar_sismos, segemar_yacimientos, sensoresremotos_globalcover2009arg, sensoresremotos_informes, sensoresremotos_modis_treecover, sensoresremotos_mosaico_pan_landsat8, sensoresremotos_mosaico_rgb_landsat8, sensoresremotos_mos_rgb_conces_actuali_landsat_8, sensoresremotos_venteos_detectados, sig_electrico_concesiones_distribuidoras, transba_estaciones_transformadoras, transba_lineas_tension, transener_estaciones_transformadoras, transener_estructuras, transener_lineas_tension, transnea_estaciones_transformadoras, transnea_lineas_tension, transnoa_estaciones_transformadoras, transnoa_lineas_tension, transpa_estaciones_transformadoras, transpa_lineas_tension, universidad_sj_bosco_pozos_abandonados, vi_r318_visor_instalaciones]);



//Stylemap
    var sM = new OpenLayers.StyleMap({"default": new OpenLayers.Style(null, {rules: [new OpenLayers.Rule({symbolizer: Ext.apply({"Polygon": {strokeWidth: 2, strokeOpacity: 1, strokeColor: "#666666", fillColor: "white", fillOpacity: 0.3, strokeDashstyle: "dash"}}, this.symbolizers)})]})});


    var polyOptions = {
        handlerOptions: {
            sides: 40,
            freehand: true,
            style: {
                strokeWidth: 2, strokeOpacity: 1, strokeColor: "#666666", fillColor: "blue", fillOpacity: 0.3, strokeDashstyle: "dash"
            }
        }
    };

    polygonControl = new OpenLayers.Control.DrawFeature(polygonLayer, OpenLayers.Handler.RegularPolygon, polyOptions);

    map.addControl(polygonControl);

    var polyTrazoOptions = {
        handlerOptions: {
            style: {
                strokeWidth: 2, strokeOpacity: 1, strokeColor: "#666666", fillColor: "blue", fillOpacity: 0.3, strokeDashstyle: "dash"
            }
        }
    };

    polygoncontroltrazo = new OpenLayers.Control.DrawFeature(polygonLayer, OpenLayers.Handler.Polygon, polyTrazoOptions);
    map.addControl(polygoncontroltrazo);
    Ext.util.CSS.refreshCache();
    gridbus = new Ext.Window({id: 'grid', title: "Info grid", width: 210, scripts: true, loadScripts: true, height: 320, layout: 'fit', closable: false, constrain: true, shadow: false, buttonAlign: 'center', resizable: true,
        items: [grid_buscador],
        buttons: [
            {text: 'Cerrar',
                handler: function() {
                    polygonLayer.destroyFeatures();
                    polygonLayer.redraw();
                    store_data_busqueda.removeAll();
                    var layers = map.getLayersByName('Centro');
                    for (var layerIndex = 0; layerIndex < layers.length; layerIndex++) {
                        map.removeLayer(layers[layerIndex]);
                    }
                    var layers = map.getLayersByName('Busca');
                    for (var layerIndex = 0; layerIndex < layers.length; layerIndex++) {
                        map.removeLayer(layers[layerIndex]);
                    }
                    gridbus.hide();
                }}

        ]
    });
    polygonLayer.events.register("beforefeatureadded", "Buffer", function(evt) {

        polygonLayer.destroyFeatures();
        polygonLayer.redraw();

    });
    polygonLayer.events.register("featureadded", "Buffer", function(evt) {


        geom = polygonLayer.features[0].geometry;
        capas = "";
        var cont = 0;
        for (var i = 0; i < map.layers.length; i++)
        {

            if (map.layers[i].visibility === true) {
                if (cont <= 0) {
                    capas += map.layers[i].name;
                    cont++;
                }
                else {
                    capas += "," + map.layers[i].name;
                }
            }
        }

        store_data_busqueda.removeAll();
        store_data_busqueda.clearData();
        store_data_busqueda.setBaseParam('GEOM', geom);
        store_data_busqueda.setBaseParam('CAPAS', capas);
        store_data_busqueda.setBaseParam('PARAM_X', '');
        store_data_busqueda.setBaseParam('PARAM_Y', '');
        store_data_busqueda.setBaseParam('BB', '');
        store_data_busqueda.setBaseParam('CENTRO', polygonLayer.features[0].geometry.getCentroid());
        var layers = map.getLayersByName('Centro');


        for (var layerIndex = 0; layerIndex < layers.length; layerIndex++) {
            map.removeLayer(layers[layerIndex]);
        }

        var wkt = new OpenLayers.Format.WKT();

        var str2 = polygonLayer.features[0].geometry.getCentroid();

//alert(str2);
//features=wkt.read(str2);

        var styleMap = new OpenLayers.StyleMap(OpenLayers.Util.applyDefaults({fillColor: "", fillOpacity: 0.0, strokeColor: "", label: "", fontSize: "1px"}, OpenLayers.Feature.Vector.style["default"]));
        var thrvec = new OpenLayers.Layer.Vector('Centro', {styleMap: styleMap});
        map.addLayers([thrvec]);
        thrvec.addFeatures(str2);
        store_data_busqueda.load();
        gridbus.show();

    });
    control = new OpenLayers.Control({
        title: 'Dibujar poligono',
        type: OpenLayers.Control.TYPE_TOOL
    });
    OpenLayers.Util.extend(control, {
        draw: function() {
            this.box = new OpenLayers.Handler.Box(control,
                    {"done": this.notice},
            {keyMask: OpenLayers.Handler.MOD_SHIFT});
            this.box.activate();
        },
        notice: function(bounds) {
            var ll = map.getLonLatFromPixel(new OpenLayers.Pixel(bounds.left, bounds.bottom));
            var ur = map.getLonLatFromPixel(new OpenLayers.Pixel(bounds.right, bounds.top));
            bb = ll.lon.toFixed(4) + " " + ll.lat.toFixed(4) + ", " + ur.lon.toFixed(4) + " " + ur.lat.toFixed(4);
            ll_lon = ll.lon.toFixed(4);
            ll_lat = ll.lat.toFixed(4);
            ur_lon = ur.lon.toFixed(4);
            ur_lat = ur.lat.toFixed(4);
            pto1a = ll.lon.toFixed(4) - ur.lon.toFixed(4);
            pto1b = pto1a / 2;
            punto1 = Number(pto1b) + Number(ur.lon.toFixed(4));
            pto2a = ll.lat.toFixed(4) - ur.lat.toFixed(4);
            pto2b = pto2a / 2;
            punto2 = Number(pto2b) + Number(ur.lat.toFixed(4));
            centrobox = "POINT(" + punto1 + " " + punto2 + ")";
            var capas = "";
            var cont = 0;
            for (var i = 0; i < map.layers.length; i++)
            {
                if (map.layers[i].visibility === true) {
                    if (cont <= 0) {
                        capas += map.layers[i].name;
                        cont++;
                    }
                    else {
                        capas += "," + map.layers[i].name;
                    }
                }
            }
            polygonLayer.destroyFeatures();
            store_data_busqueda.removeAll();
            store_data_busqueda.clearData();
            store_data_busqueda.setBaseParam('GEOM', '');
            store_data_busqueda.setBaseParam('CAPAS', capas);
            store_data_busqueda.setBaseParam('PARAM_X', '');
            store_data_busqueda.setBaseParam('PARAM_Y', '');
            store_data_busqueda.setBaseParam('BB', bb);
            store_data_busqueda.setBaseParam('CENTRO', centrobox);
            store_data_busqueda.load();
            var layers = map.getLayersByName('Centro');
            for (var layerIndex = 0; layerIndex < layers.length; layerIndex++) {
                map.removeLayer(layers[layerIndex]);
            }
            gridbus.show();
        }});
    map.addControl(control);
    var click = new OpenLayers.Control.Click();
    map.addControl(click);
    click.activate();
    map.zoomToMaxExtent();
    map.zoomToScale(20000000);
    var scaleStore = new GeoExt.data.ScaleStore({map: map});
    OpenLayers.Feature.prototype.popupClass = OpenLayers.Popup.FramedCloud;
    var zoomSelector = new Ext.form.ComboBox
            ({store: scaleStore,
                emptyText: "Zoom Level",
                tpl: '<tpl for="."><div class="x-combo-list-item">1 : {[parseInt(values.scale)]}</div></tpl>',
                editable: false,
                triggerAction: 'all',
                mode: 'local'});
    zoomSelector.on('select', function(combo, record, index) {
        map.zoomTo(record.data.level);
    }, this);
    map.events.register('zoomend', this, function() {
        var scale = scaleStore.queryBy(function(record) {
            return this.map.getZoom() == record.data.level;
        });
        if (scale.length > 0) {
            scale = scale.items[0];
            zoomSelector.setValue("1 : " + parseInt(scale.data.scale, 10));
        }
        else {
            if (!zoomSelector.rendered)
                return;
            zoomSelector.clearValue();
        }
    });
    var click = new OpenLayers.Control.Click();
    map.addControl(click);
    click.activate();
    map.setCenter(new OpenLayers.LonLat(-6672709.6617845, -4803954.2326759));
    function toggleLoadingPanel() {
        map.getControlsByClass('OpenLayers.Control.LoadingPanel')[0].toggle();
    }
    var addNewLayerNodeToTree = function(newName) {
        var newNode = new Ext.tree.TreeNode({text: newName, layerNames: [map.layers[map.layers.length - 1].name], checked: map.layers[map.layers.length - 1].getVisibility()});
        layerTree = tree;
        layerTree.getRootNode().appendChild(newNode, layerTree.getRootNode().firstChild.nextSibling);
        newNode = null;
    };
    function openTree(node) {
        if (node.isExpanded()) {
            node.collapse();
            for (i = 0; i < node.childNodes.length; i++) {
                node.childNodes[i].collapse();
            }
        } else {
            node.expand();
            for (i = 0; i < node.childNodes.length; i++) {
                node.childNodes[i].expand();
            }
        }
    }
    var addElementtoTree = function() {
        var l = tree.map.layers[tree.map.layers.length - 1];
        var className = '';
        if (l.isBaseLayer || !l.displayInLayerSwitcher) {
            className = 'x-hidden';
        }
        var node = new Ext.tree.TreeNode({
            text: l.name,
            checked: l.getVisibility(),
            cls: className,
            layerName: l.name,
            leaf: true
        });
        tree.getRootNode().appendChild(node, tree.getRootNode().firstChild);
    };
    Ext.tree.TreeNodeUI.prototype.renderElements = function(n, a, targetNode, bulkRender) {
        this.indentMarkup = n.parentNode ? n.parentNode.ui.getChildIndent() : '';
        var cb = typeof a.checked == 'boolean';
        var href = a.href ? a.href : Ext.isGecko ? "" : "#";
        var setMetaInfoLink = "false";
        if (setMetaInfoLink === "true") {
            var metaInfoLinkHTML = "<strong class='terrestris-tree-meta-info-holder' onclick='openLayerMetaInformationFile(\"" + n.text + "\");'>Info...</strong>";
        } else {
            var metaInfoLinkHTML = "";
        }
        var spanLegendHTML = (a.checked) ? '<span class="x-tree-node-indent terrestris-legend-addon-visible">' : '<span class="x-tree-node-indent terrestris-legend-addon-invisible">';
        var useImgUrl;
        var useIconUrl;
        var useIconCls;
        if (a.iconUrl && typeof a.iconUrl !== 'undefined') {
            useImgUrl = a.iconUrl;
            useIconUrl = (a.icon) ? a.icon : this.emptyIcon;
            useIconCls = '';
        }
        else {
            if (a.icon && typeof a.icon !== 'undefined') {
                useImgUrl = a.icon;
                useIconUrl = this.emptyIcon;
                useIconCls = 'x-tree-node-leaf';
            }
            else {
                useImgUrl = this.emptyIcon;
                useIconUrl = this.emptyIcon;
                useIconCls = 'x-tree-node-leaf';
            }
        }
        if (a.children && a.children.length > 0) {
            useImgUrl = this.emptyIcon;
        }
        var imgLegendHTML = (a.checked) ? '<img src="' + useImgUrl + '" class="terrestris-legend-addon-visible" unselectable="on" />' : '<img src="' + useImgUrl + '" class="terrestris-legend-addon-invisible" unselectable="on" />';
        var buf = ['<li class="x-tree-node"><div ext:tree-node-id="', n.id, '" class="x-tree-node-el x-tree-node-leaf x-unselectable ', a.cls, '" unselectable="on">', '<span class="x-tree-node-indent">', this.indentMarkup, "</span>", '<img src="', this.emptyIcon, '" class="x-tree-ec-icon x-tree-elbow" />', '<img src="', useIconUrl, '" class="x-tree-node-icon ', useIconCls, '" unselectable="on" />', cb ? ('<input class="x-tree-node-cb" type="checkbox" ' + (a.checked ? 'checked="checked" />' : '/>')) : '', '<a hidefocus="on" class="x-tree-node-anchor" href="', href, '" tabIndex="1" ', a.hrefTarget ? ' target="' + a.hrefTarget + '"' : "", '><span unselectable="on">', n.text, "</span>", metaInfoLinkHTML, '<br />', spanLegendHTML, this.indentMarkup, "</span>", imgLegendHTML, "</a></div>", '<ul class="x-tree-node-ct" style="display:none;"></ul>', "</li>"].join('');
        var nel;
        if (bulkRender !== true && n.nextSibling && (nel = n.nextSibling.ui.getEl())) {
            this.wrap = Ext.DomHelper.insertHtml("beforeBegin", nel, buf);
        } else {
            this.wrap = Ext.DomHelper.insertHtml("beforeEnd", targetNode, buf);
        }
        this.elNode = this.wrap.childNodes[0];
        this.ctNode = this.wrap.childNodes[1];
        var cs = this.elNode.childNodes;
        this.indentNode = cs[0];
        this.ecNode = cs[1];
        this.iconNode = cs[2];
        var index = 3;
        if (cb) {
            this.checkbox = cs[3];
            this.checkbox.defaultChecked = this.checkbox.checked;
            index++;
        }
        this.anchor = cs[index];
        this.textNode = cs[index].firstChild;
    };
    Ext.tree.TreeNodeUI.prototype.onCheckChange = function() {
        var checked = this.checkbox.checked;
        if (checked) {
            Ext.get(this.elNode).select('.terrestris-legend-addon-invisible').removeClass('terrestris-legend-addon-invisible').addClass('terrestris-legend-addon-visible');
        } else {
            Ext.get(this.elNode).select('.terrestris-legend-addon-visible').removeClass('terrestris-legend-addon-visible').addClass('terrestris-legend-addon-invisible');
        }
        if (this.node && this.node.childNodes && this.node.childNodes.length > 0) {
            for (var currentChildIdx in this.node.childNodes) {
                if (typeof this.node.childNodes[currentChildIdx] !== 'function') {
                    if (this.node.childNodes[currentChildIdx].rendered === false) {
                    } else {
                        if (checked) {
                            Ext.get(this.node.childNodes[currentChildIdx].ui.anchor).select('.terrestris-legend-addon-invisible').removeClass('terrestris-legend-addon-invisible').addClass('terrestris-legend-addon-visible');
                        }
                        else {
                            Ext.get(this.node.childNodes[currentChildIdx].ui.anchor).select('.terrestris-legend-addon-visible').removeClass('terrestris-legend-addon-visible').addClass('terrestris-legend-addon-invisible');
                        }
                    }
                }
            }
        }
        this.checkbox.defaultChecked = checked;
        this.node.attributes.checked = checked;
        this.fireEvent('checkchange', this.node, checked);
        openTree(this.node);
    };
    mapfish.widgets.LayerTree.prototype._extractOLModel = function LT__extractOLModel() {
        var layers = [];
        var layersArray = this.map.layers.slice();
        if (!this.ascending) {
            layersArray.reverse();
        }
        for (var i = 0; i < layersArray.length; i++) {
            var l = layersArray[i];
            var wmsChildren = [];
            if (l instanceof OpenLayers.Layer.WMS || l instanceof OpenLayers.Layer.WMS.Untiled || l instanceof OpenLayers.Layer.MapServer) {
                var sublayers = l.params.LAYERS || l.params.layers;
                if (sublayers instanceof Array) {
                    for (var j = 0; j < sublayers.length; j++) {
                        var w = sublayers[j];
                        var iconUrl;
                        if (this.showWmsLegend) {
                            iconUrl = mapfish.Util.getIconUrl(l.url, {layer: w});
                        }
                        var title = this.lookupLayerTitle[w] || w;
                        var wmsChild = {text: title, checked: l.getVisibility(), icon: iconUrl, layerName: l.name + this.separator + w, children: [], cls: "cf-wms-node"};
                        if (this.ascending) {
                            wmsChildren.push(wmsChild);
                        } else {
                            wmsChildren.unshift(wmsChild);
                        }
                    }
                } else {
                    var iconUrl = mapfish.Util.getIconUrl(l.url, {layer: sublayers}) || '';
                }
            }
            var info = {text: l.name, checked: l.getVisibility(), layerName: (wmsChildren.length > 0 ? null : l.name), children: wmsChildren, iconUrl: iconUrl};
            if (!l.displayInLayerSwitcher) {
                info.uiProvider = function() {
                };
                info.hidden = true;
                info.uiProvider.prototype = {render: function() {
                    }, renderIndent: function() {
                    }, updateExpandIcon: function() {
                    }};
            }
            layers.push(info);
        }
        return layers;
    };

//tree


    var model =
            [
                {text: "Bases", leaf: false, expanded: false, cls: 'theme-thema1 regio-level0',
                    children:
                            [
//{text:" Google Sat&eacute;lite",layerName:"base_google_satelital",checked:false,cls: 'theme-thema1_1 regio-level1'},

//GoogleMapsAR
                                {text: " Google Calle", layerName: "GoogleMapsAR", checked: true, cls: 'theme-thema1_1 regio-level1'},
                                {text: " ArgenMap - IGN ", layerName: "capaargenmap", checked: true, cls: 'theme-thema1_1 regio-level1'},
                                {text: " Bing aereo", layerName: "base_bing_aereo", checked: false, cls: 'theme-thema1_1 regio-level1'},
                                {text: " Capa de an�lisis", layerName: "base_analisis", checked: false, cls: 'theme-thema1_1 regio-level1'},
                                /* basemaps eliminados
                                 
                                 {text:" Google Calles",layerNames:["base_google_calles","malvinasover"],checked:true,cls: 'theme-thema1_1 regio-level1'},
                                 {text:" Google F&iacute;sico",layerName:"base_google_fisico",checked:false,cls: 'theme-thema1_1 regio-level1'},
                                 {text:" Google H&iacute;brido",layerName:"base_google_hibrido",checked:false,cls: 'theme-thema1_1 regio-level1'},
                                 {text:" Bing ruta",layerName:"base_bing_calles",checked:false,cls: 'theme-thema1_1 regio-level1'},
                                 {text:" Bing hibrido",layerName:"base_bing_hibrido",checked:false,cls: 'theme-thema1_1 regio-level1'},
                                 {text:" OpenStreetMap",layerName:"base_mapnik",checked:false,cls: 'theme-thema1_1 regio-level1'},
                                 {text:" MapQuest",layerName:"base_osm",checked:false,cls: 'theme-thema1_1 regio-level1'},
                                 {text:" Fondo marino (NOAA) ",layerNames:["base_mapnik","fondomarino","fondomarino2"],checked:false,cls: 'theme-thema1_1 regio-level1'}, 
                                 */

//totem 


                                {text: "Mosaico Landsat 8 (RGB)", layerName: "sensoresremotos_mosaico_rgb_landsat8", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=sensoresremotos_mosaico_rgb_landsat8&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema1_1 regio-level1"},
                                {text: "Mosaico Landsat 8 (Pancrom�tico)", layerName: "sensoresremotos_mosaico_pan_landsat8", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=sensoresremotos_mosaico_pan_landsat8&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema1_1 regio-level1"},
                                {text: "Mosaico Landsat 8 RGB (s�lo concesiones)", layerName: "sensoresremotos_mos_rgb_conces_actuali_landsat_8", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=sensoresremotos_mos_rgb_conces_actuali_landsat_8&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema1_1 regio-level1"},
//{text:"Global Cover 2009 - Argentina",layerName:"sensoresremotos_globalcover2009arg",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=sensoresremotos_globalcover2009arg&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema1_1 regio-level1"},
                                {text: "Provincias", layerName: "ign_provincias", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=ign_provincias&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema1_1 regio-level1"},
                                {text: "Departamentos", layerName: "ign_departamentos", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=ign_departamentos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema1_1 regio-level1"},
                                {text: "Parques Provinciales Protegidos", layerName: "ministerio_educacion_parquesprov_pol", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=ministerio_educacion_parquesprov_pol&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema1_1 regio-level1"},
                                {text: "Parques Nacionales Protegidos", layerName: "ministerio_educacion_parques_nacionales_poligonos", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=ministerio_educacion_parques_nacionales_poligonos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema1_1 regio-level1"}



                            ]
                }
                ,
//resto de arbol




                {
                    text: "Energ&iacute;a", leaf: false, expanded: false, cls: 'theme-thema2 regio-level0', children: [
                        {text: " El&eacute;ctrica", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children: [
                                {text: "Generaci&oacute;n", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1',
                                    children: [
                                        {text: "Renovables", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', checked: false, children: [
//{text:"Centrales Generadoras ",layerName:"electrica_generacion_visor_vi_centrales",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=electrica_generacion_visor_vi_centrales&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"},
//{text:"Centrales Generadoras Proyectadas",layerName:"electrica_generacion_visor_vi_centrales_proyectadas",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=electrica_generacion_visor_vi_centrales_proyectadas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"}//linea maldita : no usar
                                                {text: "Centrales Solares", layerName: "electrica_generacion_visor_vi_centrales_solares", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=electrica_generacion_visor_vi_centrales_solares&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                {text: "Centrales Hidroel�ctricas", layerName: "electrica_generacion_visor_vi_centrales_hidraulicas", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=electrica_generacion_visor_vi_centrales_hidraulicas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                {text: "Centrales E�licas", layerName: "electrica_generacion_visor_vi_centrales_eolicas", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=electrica_generacion_visor_vi_centrales_eolicas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                {text: "Centrales Biom�sicas", layerName: "renovables_bioenergia_centrales_biomasa", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=renovables_bioenergia_centrales_biomasa&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                {text: "Aprovechamientos Hidroelectricos Construidos", layerName: "renovables_hidroelectrica_pahs", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=renovables_hidroelectrica_pahs&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                {text: "Aprovechamientos Hidroel�ctricos Proyectados", layerName: "renovables_hidroelectrica_ppah", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=renovables_hidroelectrica_ppah&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]},
                                        {text: "No Renovables", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', checked: false, children: [
                                                {text: "Centrales Nucleares", layerName: "electrica_generacion_visor_vi_centrales_nucleares", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=electrica_generacion_visor_vi_centrales_nucleares&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                {text: "Centrales T�rmicas", layerName: "electrica_generacion_visor_vi_centrales_termicas", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=electrica_generacion_visor_vi_centrales_termicas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]},
                                    ]},
                                {text: "Transporte", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children: [
                                        {text: "L�neas El�ctricas de Alta Tensi�n", layerName: "electrica_transporte_lineas", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=electrica_transporte_lineas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                        {text: "Estaciones Transformadoras de Alta Tensi�n", layerName: "electrica_transporte_eett", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=electrica_transporte_eett&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}//{text: "Transener",leaf: false,expanded: false,cls: 'theme-thema2_1 regio-level1',children:[
//{text:"Transener - Lineas Alta Tension",layerName:"transener_lineas_tension",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=transener_lineas_tension&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"},
//{text:"Transener - Estaciones Transformadoras",layerName:"transener_estaciones_transformadoras",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=transener_estaciones_transformadoras&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"},
//{text:"Transener - Estructuras",layerName:"transener_estructuras",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=transener_estructuras&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"}//]},
//{text: "Transnoa",leaf: false,expanded: false,cls: 'theme-thema2_1 regio-level1',children:[
//{text:"Transnoa - Lineas Alta Tension",layerName:"transnoa_lineas_tension",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=transnoa_lineas_tension&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"},
//{text:"Transnoa - Estaciones Transformadoras",layerName:"transnoa_estaciones_transformadoras",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=transnoa_estaciones_transformadoras&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"}//]},
//{text: "Transpa",leaf: false,expanded: false,cls: 'theme-thema2_1 regio-level1',children:[
//{text:"Transpa - Lineas Alta Tension",layerName:"transpa_lineas_tension",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=transpa_lineas_tension&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"},
//{text:"Transpa - Estaciones Transformadoras",layerName:"transpa_estaciones_transformadoras",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=transpa_estaciones_transformadoras&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"}//]},
//{text: "Transba",leaf: false,expanded: false,cls: 'theme-thema2_1 regio-level1',children:[
//{text:"Transba - Lineas Alta Tension",layerName:"transba_lineas_tension",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=transba_lineas_tension&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"},
//{text:"Transba - Estaciones Transformadoras",layerName:"transba_estaciones_transformadoras",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=transba_estaciones_transformadoras&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"}//]},
//{text: "Distrocuyo",leaf: false,expanded: false,cls: 'theme-thema2_1 regio-level1',children:[
//{text:"Distrocuyo - Lineas Alta Tension",layerName:"distrocuyo_lineas_tension",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=distrocuyo_lineas_tension&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"},
//{text:"Distrocuyo - Estaciones Transformadoras",layerName:"distrocuyo_estaciones_transformadoras",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=distrocuyo_estaciones_transformadoras&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"}//]},
//{text: "Transnea",leaf: false,expanded: false,cls: 'theme-thema2_1 regio-level1',children:[
//{text:"Transnea - Lineas Alta Tension",layerName:"transnea_lineas_tension",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=transnea_lineas_tension&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"},
//{text:"Transnea - Estaciones Transformadoras",layerName:"transnea_estaciones_transformadoras",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=transnea_estaciones_transformadoras&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"}//]},
//{text: "Distro-Comahue",leaf: false,expanded: false,cls: 'theme-thema2_1 regio-level1',children:[
//{text:"Distro-Comahue - Lineas Alta Tension",layerName:"distrocomahue_red_at",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=distrocomahue_red_at&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"},
//{text:"Distro-Comahue - Estaciones Transformadoras",layerName:"distrocomahue_eett",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=distrocomahue_eett&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"}]}
                                    ] //transporte
                                },
                                {text: "Distribuci&oacute;n", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children: [
                                        {text: "Concesiones Distribuidoras Electricas", layerName: "sig_electrico_concesiones_distribuidoras", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=sig_electrico_concesiones_distribuidoras&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                        {text: "Cooperativas de Distribuci�n El�ctrica", layerName: "empresas_coop_electricas_bara_georref", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=empresas_coop_electricas_bara_georref&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]},
                                {text: "PRONUREE", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children:
                                            [
                                                {text: "LFC Residenciales Repartidas", layerName: "pronuree_deptos_lamparas_res", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=pronuree_deptos_lamparas_res&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                {text: "Luminarias Repartidas", layerName: "pronuree_deptos_luminarias", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=pronuree_deptos_luminarias&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]},
                                {text: "Permer - Cantidad de Escuelas por Depto", layerName: "permer_cant_escuelas_depto", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=permer_cant_escuelas_depto&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                            ]},
                        {text: " Renovables", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children: [
//{text: " PERMER",leaf: false,expanded: false,cls: 'theme-thema2_1 regio-level1',children:
//[
//{text:"Permer - Cantidad de Escuelas por Depto",layerName:"permer_cant_escuelas_depto",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=permer_cant_escuelas_depto&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"}//]
//},




//{text:"Parques Solares",layerName:"electrica_centrales_generacion_parques_solares",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=electrica_centrales_generacion_parques_solares&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"},

                                {text: " Energ&iacute;a geot�rmica", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children:
                                            [
                                                {text: "Puntos de Inter�s Geot�rmico", layerName: "renovables_geotermica_puntos_interes", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=renovables_geotermica_puntos_interes&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]
                                },
//{text: " Energ&iacute;a e�lica",leaf: false,expanded: false,cls: 'theme-thema2_1 regio-level1',children:[
//{text:"Parques Eolicos",layerName:"electrica_centrales_generacion_parques_eolicos",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=electrica_centrales_generacion_parques_eolicos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"}//]},
//{text: " Energ&iacute;a hidroel&eacute;ctrica",leaf: false,expanded: false,cls: 'theme-thema2_1 regio-level1',children:[
//{text:"Aprovechamientos Hidroelectricos Construidos",layerName:"renovables_hidroelectrica_pahs",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=renovables_hidroelectrica_pahs&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"},
//theme-thema2_1 regio-level1"}//]},
                                {text: " Bioenerg&iacute;a", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children: [
//{text:"Modis TreeCover 2010",layerName:"sensoresremotos_modis_treecover",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=sensoresremotos_modis_treecover&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"},
//{text:"Modis TreeCover 2010",layerName:"sensoresremotos_modis_treecover",checked: false, leaf:true, cls: "theme-thema2_1 regio-level1"},
                                        {text: "Modis TreeCover 2010", layerName: "sensoresremotos_modis_treecover", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=sensoresremotos_modis_treecover&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                        {text: "Global Cover 2009 - Argentina", layerName: "sensoresremotos_globalcover2009arg", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=sensoresremotos_globalcover2009arg&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                        {text: "Plantas Biocombustibles", layerName: "renovables_plantas_biocombustible", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=renovables_plantas_biocombustible&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                        {text: "WISDOM - Informaci&oacute;n Biom�sica", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children: [
                                                {text: "Biomasa Accesible y Disponible Comercial", layerName: "renovables_bioenergia_bkgmd_c_biomasa", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=renovables_bioenergia_bkgmd_c_biomasa&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                {text: "Biomasa Balance ", layerName: "renovables_bioenergia_int_bal_f5_5_biomasa", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=renovables_bioenergia_int_bal_f5_5_biomasa&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                {text: "Informaci&oacute;n por Departamento", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children: [
                                                        {text: "Biomasa Oferta por Depto", layerName: "renovables_bioenergia_oferta_biomasa", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=renovables_bioenergia_oferta_biomasa&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Biomasa Consumo por Depto", layerName: "renovables_bioenergia_consumo_biomasa", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=renovables_bioenergia_consumo_biomasa&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Biomasa Balance por Depto", layerName: "renovables_bioenergia_balance_biomasa", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=renovables_bioenergia_balance_biomasa&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]},
                                            ]}
                                    ]
                                }
                            ]},
                        ,
                                {text: " Hidrocarburos", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children:
                                            [
                                                {text: " Exploraci�n", leaf: false, checked: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children: [
                                                        {text: "Cuencas Sedimentarias", layerName: "hidrocarburos_cuencas_sedimentarias", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=hidrocarburos_cuencas_sedimentarias&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Permisos de Exploracion", layerName: "planosbase_permisos_exploracion", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=planosbase_permisos_exploracion&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
//theme-thema2_1 regio-level1"},
                                                        {text: "Sismica 3d", layerName: "planosbase_sismica3d", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=planosbase_sismica3d&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Lineas Sismicas", layerName: "planosbase_lineas_sismicas", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=planosbase_lineas_sismicas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]},
                                                {text: " Producci�n", leaf: false, checked: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children: [
                                                        {text: "Cuencas Productivas", layerName: "hidrocarburos_cuencas_productivas", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=hidrocarburos_cuencas_productivas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Concesiones de Explotacion", layerName: "planosbase_concesiones_explotacion", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=planosbase_concesiones_explotacion&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Lotes de Explotacion", layerName: "planosbase_lotes_explotacion", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=planosbase_lotes_explotacion&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Yacimientos", layerName: "planosbase_yacimientos", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=planosbase_yacimientos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Yacimientos segun Profundidad Promedio", layerName: "hidrocarburos_yacimientos_profundidad", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=hidrocarburos_yacimientos_profundidad&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Pozos de Petroleo y Gas", layerName: "hidrocarburos_pozos_visor", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=hidrocarburos_pozos_visor&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Puntos de Venteo Declarados", layerName: "planosbase_puntos_venteo_declarados", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=planosbase_puntos_venteo_declarados&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Puntos de Venteos Detectados", layerName: "sensoresremotos_venteos_detectados", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=sensoresremotos_venteos_detectados&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Pozos Abandonados ", layerName: "universidad_sj_bosco_pozos_abandonados", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=universidad_sj_bosco_pozos_abandonados&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Productores de Glp", layerName: "glp_vi_visor_bocas_productores", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=glp_vi_visor_bocas_productores&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]},
                                                {text: " Transporte", leaf: false, checked: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children: [
                                                        {text: " Ductos Troncales", leaf: false, checked: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children: [
//theme-thema2_1 regio-level1"},
                                                                {text: "Poliductos", layerName: "hidrocarburos_transporte_vi_visor_poliductos", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=hidrocarburos_transporte_vi_visor_poliductos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                {text: "Oleoductos", layerName: "hidrocarburos_transporte_vi_visor_oleoductos", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=hidrocarburos_transporte_vi_visor_oleoductos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                {text: "Propanoductos", layerName: "hidrocarburos_transporte_vi_visor_propanoductos", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=hidrocarburos_transporte_vi_visor_propanoductos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                {text: "JP Ducto", layerName: "hidrocarburos_transporte_vi_visor_jpductos", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=hidrocarburos_transporte_vi_visor_jpductos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                {text: "Gasoductos Troncales (Enargas)", layerName: "enargas_gasoductos", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=enargas_gasoductos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]},
                                                        {text: " Ductos de Yacimientos", leaf: false, checked: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children: [
                                                                {text: "Ductos RES. 319/93", layerName: "planosbase_ductos", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=planosbase_ductos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]}
                                                    ]},
                                                {text: " Instalaciones", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', checked: false, children: [
                                                        {text: "Plantas Compresoras de Gas (Enargas)", layerName: "enargas_plantas_compresoras", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=enargas_plantas_compresoras&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Instalaciones RES. 319/93 (P. Caracter�sticos)", layerName: "planosbase_puntos_caracteristicos", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=planosbase_puntos_caracteristicos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Instalaciones RES. 318", layerName: "vi_r318_visor_instalaciones", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=vi_r318_visor_instalaciones&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Puertos Regasificadores de GNL", layerName: "puertos_gnl", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=puertos_gnl&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]},
                                                {text: " Refinaci�n", leaf: false, expanded: false, cls: 'theme-thema2_1 regio-level1', checked: false, children: [
                                                        {text: "Petroqu�micas", layerName: "petroquimicas_plantas", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=petroquimicas_plantas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                        {text: "Refinerias de Hidrocarburos", layerName: "refinerias", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=refinerias&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]},
                                                {text: " Comercializaci�n", leaf: false, checked: false, expanded: false, cls: 'theme-thema2_1 regio-level1', children: [
                                                        {text: " Glp", leaf: false, checked: false, expanded: false, check: false, cls: 'theme-thema2_1 regio-level1', children: [
                                                                {text: "Depositos Glp", layerName: "glp_vi_visor_depositos", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=glp_vi_visor_depositos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                {text: "Plantas Fraccionadoras Glp", layerName: "glp_vi_visor_plantas_fraccionadoras", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=glp_vi_visor_plantas_fraccionadoras&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]},
                                                        {text: " Combustibles liquidos y GNC", leaf: false, checked: false, expanded: false, check: false, cls: 'theme-thema2_1 regio-level1', children: [
                                                                {text: "Ley 23966", layerName: "hidrocarburos_ley23966", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=hidrocarburos_ley23966&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}, {text: " Terminales de Despacho", leaf: true, expanded: false, check: true, cls: 'theme-thema2_1 regio-level1', children: [
                                                                        {text: "Terminales de Despacho", layerName: "padron_eess_terminales_despacho", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_terminales_despacho&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Terminales de Despacho - Radios de influencia", layerName: "analisis_distancia_a_terminalesdesp_merge", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=analisis_distancia_a_terminalesdesp_merge&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]},
                                                                {text: " Aeroplantas", leaf: true, expanded: false, check: false, cls: 'theme-thema2_1 regio-level1', children: [
                                                                        {text: "Ypf - Aeroplantas", layerName: "padron_eess_aeroplantas_ypf", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_aeroplantas_ypf&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]},
                                                                {text: " Estaciones de Servicio", leaf: true, checked: false, expanded: false, check: true, cls: 'theme-thema2_1 regio-level1', children: [
//totem
                                                                        {text: "Agip - Estaciones de Servicio", layerName: "padron_eess_agip", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_agip&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Agira - Estaciones de Servicio", layerName: "padron_eess_agira", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_agira&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Aspro - Estaciones de Servicio", layerName: "padron_eess_aspro", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_aspro&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Dapsa - Estaciones de Servicio", layerName: "padron_eess_dapsa", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_dapsa&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Esso - Estaciones de Servicio", layerName: "padron_eess_esso", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_esso&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Oil - Estaciones de Servicio", layerName: "padron_eess_oil", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_oil&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Petrobras - Estaciones de Servicio", layerName: "padron_eess_petrobras", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_petrobras&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Petrolera del Plata - Estaciones de Servicio", layerName: "padron_eess_petroleradelplata", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_petroleradelplata&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "PDVsur - Estaciones de Servicio", layerName: "padron_eess_pdvsur", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_pdvsur&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Refinor - Estaciones de Servicio", layerName: "padron_eess_refinor", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_refinor&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Rhasa - Estaciones de Servicio", layerName: "padron_eess_rhasa", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_rhasa&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Shell - Estaciones de Servicio", layerName: "padron_eess_shell", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_shell&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Sin Marca - Estaciones de Servicio", layerName: "padron_eess_sinmarca", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_sinmarca&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Sol - Estaciones de Servicio", layerName: "padron_eess_sol", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_sol&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Ypf - Estaciones de Servicio", layerName: "padron_eess_ypf", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_ypf&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}]}



                                                                , {text: " Distribuidores - Otros", leaf: true, checked: false, expanded: false, check: true, cls: 'theme-thema2_1 regio-level1', children: [
                                                                        {text: "Esso - Distribuidores", layerName: "padron_eess_dist_esso", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_dist_esso&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Oil - Distribuidores", layerName: "padron_eess_dist_oil", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_dist_oil&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Pdvsa - Distribuidores", layerName: "padron_eess_dist_pdvesa", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_dist_pdvesa&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Petrobras - Distribuidores", layerName: "padron_eess_dist_petrobras", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_dist_petrobras&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Shell - Distribuidores", layerName: "padron_eess_dist_shell", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_dist_shell&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Sin Marca - Distribuidores", layerName: "padron_eess_dist_sinmarca", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_dist_sinmarca&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"},
                                                                        {text: "Ypf - Distribuidores", layerName: "padron_eess_dist_ypf", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=padron_eess_dist_ypf&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema2_1 regio-level1"}
                                                                    ]}
                                                            ]}
                                                    ]}
                                            ]
                                }
                    ]
                },
                {text: "Geolog&iacute;a - Climatolog&iacute;a", leaf: false, expanded: false, cls: 'regio-level0 thema3', children:
                            [
                                {text: "Cuencas H�dricas (SRH Atlas 2002)", layerName: "recursoshidricos_atlas2002_cuencas_hidricas", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=recursoshidricos_atlas2002_cuencas_hidricas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema3_1 regio-level1"},
                                {text: "Cuencas Buenos Aires  (SRH Atlas 2010)", layerName: "recursoshidricos_atlas2010_cuencas_bsas", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=recursoshidricos_atlas2010_cuencas_bsas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema3_1 regio-level1"},
                                {text: "Isohietas", layerName: "recursoshidricos_atlas2002_isohietas", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=recursoshidricos_atlas2002_isohietas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema3_1 regio-level1"},
                                {text: "Isol�neas de Evaporaci�n", layerName: "recursoshidricos_atlas2002_evaporacion", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=recursoshidricos_atlas2002_evaporacion&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema3_1 regio-level1"},
                                {text: "Isotermas", layerName: "recursoshidricos_atlas2002_isotermas", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=recursoshidricos_atlas2002_isotermas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema3_1 regio-level1"},
                                {text: "Curvas de Nivel (IGN)", layerName: "ign_curvas_nivel", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=ign_curvas_nivel&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema3_1 regio-level1"},
                                {text: "Sismos Hist�ricos", layerName: "segemar_sismos", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=segemar_sismos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema3_1 regio-level1"},
                                {text: "Yacimientos", layerName: "segemar_yacimientos", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=segemar_yacimientos&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema3_1 regio-level1"},
                                {text: "Minas y Canteras (IGN)", layerName: "ign_minas_canteras", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=ign_minas_canteras&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema3_1 regio-level1"},
//{text:"Puntos de Inter�s Geot�rmico",layerName:"renovables_geotermica_puntos_interes",icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=renovables_geotermica_puntos_interes&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1",checked: false, leaf:true, cls: "theme-thema3_1 regio-level1"},
                                {text: "Curvas de Nivel (Hidrograf�a Naval)", layerName: "hidrografia_naval_curvas_de_nivel", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=hidrografia_naval_curvas_de_nivel&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema3_1 regio-level1"},
                                {text: "Tope de mareas (Hidrograf�a naval)", layerName: "hidrografia_naval_tope_de_mareas", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=hidrografia_naval_tope_de_mareas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema3_1 regio-level1"},
                                {text: "Isobatas (Hidrograf�a Naval)", layerName: "hidrografia_naval_isobatas", icon: "http://sig.se.gob.ar/cgi-bin/mapserv6?MAP=/var/www/html/visor/geofiles/map/mapase.map&LAYER=hidrografia_naval_isobatas&REQUEST=getlegendgraphic&VERSION=1.1.1&FORMAT=image/png&SERVICE=WMS&SCALE=1", checked: false, leaf: true, cls: "theme-thema3_1 regio-level1"},
                                /*
                                 {text:" Meteorolog�a - Todo<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Presi�n, Precipitaci�n, Nubes, Temperatura)",layerNames:['base_mapnik','stations5','stations4','stations3','stations','stations2'],checked:false,cls: 'theme-thema3_1 regio-level1'},
                                 */





                                /*
                                 {text:" Meteorolog�a - Precipitaci�n<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Presi�n, Precipitaci�n, Nubes, Temperatura)",layerNames:['base_mapnik','stations'],checked:false,cls: 'theme-thema3_1 regio-level1'},
                                 
                                 
                                 {text:" Meteorolog�a - Nubes",layerNames:['base_mapnik','stations4'],checked:false,cls: 'theme-thema3_1 regio-level1'},
                                 
                                 {text:" Meteorolog�a - Centros de presi�n",layerNames:['base_mapnik','stations5'],checked:false,cls: 'theme-thema3_1 regio-level1'},
                                 
                                 
                                 
                                 {text:" Meteorolog�a - Temperatura<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Presi�n, Precipitaci�n, Nubes, Temperatura)",layerNames:['base_mapnik','stations3'],checked:false,cls: 'theme-thema3_1 regio-level1'},
                                 
                                 {text:" Meteorolog�a - Aeropuertos<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Presi�n, Precipitaci�n, Nubes, Temperatura)",layerNames:['base_mapnik','stations2'],checked:false,cls: 'theme-thema3_1 regio-level1'}*/

                            ]
                }







            ];







//fintree

    createToolbar();
    var ctrl;
    Ext.form.Field.prototype.msgTarget = 'side';
    var dataStore = new Ext.data.Store({
        url: 'includes/buscador.php',
        reader: new Ext.data.JsonReader({
            totalProperty: 'total',
            root: 'data'},
        [{name: 'NOMBRE', mapping: 'NOMBRE'},
            {name: 'DESC', mapping: 'DESC'},
            {name: 'TABLA', mapping: 'TABLA'},
            {name: 'LON', mapping: 'LON'},
            {name: 'LAT', mapping: 'LAT'}])});

    var nom_columna = '';

    var grid_demo = new Ext.grid.GridPanel({
        id: 'grid_demo',
        loadMask: true,
        border: false,
        height: 450,
        width: 630,
        frame: true,
        resizable: false,
        labelAlign: 'top',
        store: dataStore,
        columns: [{header: "Nombre", width: 100, dataIndex: 'NOMBRE', sortable: true, align: 'left'},
            {id: 'desc', header: "Desc", dataIndex: 'DESC', sortable: true, align: 'left'},
            {header: "Tabla", width: 60, dataIndex: 'TABLA', sortable: true, align: 'left'}],
        autoExpandColumn: 'desc',
        bbar: new Ext.PagingToolbar({
            store: dataStore,
            displayInfo: true,
            displayMessage: "Displaying Products {0} - {1} of {2}",
            pageSize: 500
        }),
        stripeRows: false,
        tbar: [{
                xtype: 'splitbutton',
                text: 'Seleccione un filtro',
                iconCls: 'view_icono',
                menu: [
                    {text: 'Pozos',
                        checked: false,
                        group: 'filtro',
                        handler: function() {
                            nom_columna = 'POZO';
                            Ext.getCmp('nombre_columna').setText('POZO');
                        }},
                    {text: 'Est. Servicios',
                        checked: false,
                        group: 'filtro',
                        handler: function() {
                            nom_columna = 'EESS';
                            Ext.getCmp('nombre_columna').setText('EESS');
                        }},
                    {text: 'Inst. Res. 318',
                        checked: false,
                        group: 'filtro',
                        handler: function() {
                            nom_columna = 'RES318';
                            Ext.getCmp('nombre_columna').setText('RES318');
                        }},
                    {text: 'Concesiones explota.',
                        checked: false,
                        group: 'filtro',
                        handler: function() {
                            nom_columna = 'CONCEX';
                            Ext.getCmp('nombre_columna').setText('CONCEX');
                        }},
                    {text: 'Lotes explota.',
                        checked: false,
                        group: 'filtro',
                        handler: function() {
                            nom_columna = 'LOTEX';
                            Ext.getCmp('nombre_columna').setText('LOTEX');
                        }},
                    {text: 'Permisos explora.',
                        checked: false,
                        group: 'filtro',
                        handler: function() {
                            nom_columna = 'PERMEX';
                            Ext.getCmp('nombre_columna').setText('PERMEX');
                        }},
                    {text: 'Yacimientos',
                        checked: false,
                        group: 'filtro',
                        handler: function() {
                            nom_columna = 'YACI';
                            Ext.getCmp('nombre_columna').setText('YACI');
                        }},
                    {text: 'P. Venteo',
                        checked: false,
                        group: 'filtro',
                        handler: function() {
                            nom_columna = 'VENT';
                            Ext.getCmp('nombre_columna').setText('VENT');
                        }},
                    {text: 'P. Venteo Detectado',
                        checked: false,
                        group: 'filtro',
                        handler: function() {
                            nom_columna = 'VENT_DT';
                            Ext.getCmp('nombre_columna').setText('VENT_DT');
                        }},
                    {text: 'Centrales Electricas',
                        checked: false,
                        group: 'filtro',
                        handler: function() {
                            nom_columna = 'CENTELEC';
                            Ext.getCmp('nombre_columna').setText('CENTELEC');
                        }},
                    {text: 'Puntos Caract.',
                        checked: false,
                        group: 'filtro',
                        handler: function() {
                            nom_columna = 'PCARACT';
                            Ext.getCmp('nombre_columna').setText('PCARACT');
                        }},
                    {text: 'Ductos',
                        checked: false,
                        group: 'filtro',
                        handler: function() {
                            nom_columna = 'DUCTOS';
                            Ext.getCmp('nombre_columna').setText('DUCTOS');
                        }},
                    {text: 'Planos Base',
                        checked: true,
                        group: 'filtro',
                        handler: function() {
                            nom_columna = 'PLANOSBASE';
                            Ext.getCmp('nombre_columna').setText('PLANOSBASE');
                        }}
                ]},
            {xtype: 'displayfield', value: '&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;'},
            {xtype: 'tbtext', id: 'nombre_columna', width: 45},
            {xtype: 'displayfield', value: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'},
            {xtype: 'exportbutton', store: dataStore}]
    });

    dataStore.on(
            'beforeload',
            function() {
                dataStore.baseParams = {columna: nom_columna, texto_a_buscar: Ext.getCmp('texto_field').getValue().trim()};
            });
    var marcadores = new OpenLayers.Layer.Markers("Markers");
    map.addLayer(markers);

    var size = new OpenLayers.Size(39, 39);
    var offset = new OpenLayers.Pixel(-(size.w / 2), -size.h);
    var icon = new OpenLayers.Icon('images/regroup.png', size, offset);
    Ext.util.CSS.refreshCache();

    var windowbusca = new Ext.Window({
        animateTarget: 'windowbusca',
        id: 'windowbusca',
        renderTo: document.body,
        iconCls: 'key',
        bodyStyle: 'padding:5px',
        title: "buscador",
        height: 545,
        width: 655,
        constrain: true,
        shadow: false,
        draggable: true,
        closable: false,
        resizable: false,
        frame: true,
        items: [{xtype: 'compositefield', combineErrors: true,
                items: [
                    {xtype: 'textfield', id: 'texto_field', readOnly: false, emptyText: 'Ingrese un texto y elija un filtro...', width: 300},
                    {xtype: 'tbbutton', text: 'Buscar', icon: 'images/Search.gif',
                        handler: function() {
                            if (nom_columna.trim() === '')
                            {
                                Ext.Msg.show({
                                    title: 'Filtro',
                                    msg: 'Debe Seleccionar un filtro.',
                                    closable: false,
                                    buttons: Ext.Msg.OK,
                                    icon: Ext.MessageBox.ERROR});
                                return;
                            }
                            if (Ext.getCmp('texto_field').getValue().trim() === '')
                            {
                                Ext.Msg.show({
                                    title: 'Texto',
                                    msg: 'Debe ingresar un texto a buscar.',
                                    closable: false,
                                    buttons: Ext.Msg.OK,
                                    icon: Ext.MessageBox.ERROR
                                });
                                return;
                            }
                            dataStore.removeAll();
                            dataStore.load({baseParams: {start: 0, limit: 500}});
                        }}]},
            grid_demo],
        buttonAlign: 'center',
        buttons: [{
                text: 'Salir',
                icon: 'images/Forward.gif',
                handler: function()
                {
                    var layers = map.getLayersBy("visibility", true);
                    var regsel = grid_demo.getSelectionModel().getSelected();
                    var coordgeo = new OpenLayers.LonLat();
                    var coorddestino = coordgeo.transform(new OpenLayers.Projection('EPSG:4326'), new OpenLayers.Projection('EPSG:900913'));
                    marquita = new OpenLayers.Marker(coorddestino, icon);
                    marcadores.removeMarker(marquita);
                    marquita.setOpacity(0);
                    dataStore.removeAll();
                    windowbusca.hide();
                }}]});

    windowbusca.hide();

    grid_demo.on('rowclick', function(grid, rowIndex, e) {
        var regsel = grid_demo.getSelectionModel().getSelected();
        var coordgeo = new OpenLayers.LonLat(regsel.get('LON'), regsel.get('LAT'));
        var coorddestino = coordgeo.transform(new OpenLayers.Projection('EPSG:4326'), new OpenLayers.Projection('EPSG:900913'));
        map.panTo(coorddestino);
        marquita = new OpenLayers.Marker(coorddestino, icon);
        marquita.setOpacity(1);
        marcadores.addMarker(marquita);
        markers.addMarker(new OpenLayers.Marker(coorddestino, icon));
    });

    map.addControl(new OpenLayers.Control.MousePosition({
        displayClass: "void",
        div: $('mouseposition'),
        prefix: '<b>longitud:</b> ',
        separator: '&nbsp; <b>latitud:</b> '}));

    var viewport = new Ext.Viewport({
        layout: 'border',
        items: [
            {
                region: 'center',
                xtype: 'mapcomponent',
                tbar: [toolbar],
                bbar: [{xtype: 'button', text: ''}, zoomSelector],
                map: map,
                AnimCollapse: false
            },
            new Ext.BoxComponent({
                region: 'north',
                el: 'north',
                height: 70
            }),
            {
                region: 'west',
                showWmsLegend: true,
                width: 380,
                minSize: 175,
                maxSize: 500,
                collapsible: true,
                AnimCollapse: true,
                shadow: false,
                constrain: true,
                resizable: true,
                margins: '0 5 0 0',
                defaults: {},
                layout: 'border',
                items: [
                    {region: 'center',
                        html: '<div id="tree" style="height:90%;"></div>',
                        autoScroll: true,
                        listeners: {'bodyresize': {fn: function() {
                                    var cmp = Ext.getCmp('tree-component');
                                    if (cmp && cmp.body && cmp.body.dom && cmp.body.dom.children && cmp.body.dom.children[0]) {
                                        var ul = cmp.body.dom.children[0];
                                        var w = this.getInnerWidth();
                                        var criticalWidth = 350;
                                        if (w < criticalWidth) {
                                            ul.style.width = criticalWidth + 'px';
                                        }
                                        else
                                        {
                                            ul.style.width = w + 'px';
                                        }
                                    }
                                }},
                            'afterrender': {fn: function() {
                                    var cmp = Ext.getCmp('tree-component');
                                    if (cmp && cmp.body && cmp.body.dom && cmp.body.dom.children && cmp.body.dom.children[0]) {
                                        var ul = cmp.body.dom.children[0];
                                        var w = this.getInnerWidth();
                                        var criticalWidth = 350;
                                        if (w < criticalWidth) {
                                            ul.style.width = criticalWidth + 'px';
                                        }
                                        else {
                                            ul.style.width = w + 'px';
                                        }
                                    }
                                }}}
                    },
                    {
                        region: 'south',
                        id: 'statusBar',
                        border: false,
                        bodyStyle: 'text-align:left;padding:0px;',
                        height: 27,
                        margins: '5 0 0 0',
                        frame: true,
                        contentEl: 'position'}
                ]}

        ]});

    tree = new mapfish.widgets.LayerTree({
        map: map,
        el: $('tree'),
        enableDD: true,
        model: model,
        lines: false,
        plugins:
                [mapfish.widgets.LayerTree.createContextualMenuPlugin(['opacitySlide', 'zoomToExtent'])],
        listeners:
                {
                    click: function(nodox, e)
                    {
                        nodo = nodox;
                        if (nodox.attributes.checked !== undefined)
                        {
                        }
                    }}
    });
    tree.render();


    queryEventHandler = new OpenLayers.Handler.Click({'map': map}, {'click': function(e) {
            doIdentify(e);
        }});
    initializeToolbar();
    Ext.get('loading').fadeOut({remove: true});
});
function addSeparator(toolbar) {
    toolbar.add(new Ext.Toolbar.Spacer());
    toolbar.add(new Ext.Toolbar.Separator());
    toolbar.add(new Ext.Toolbar.Spacer());
}
var createToolbar = function()
{
    toolbar = new mapfish.widgets.toolbar.Toolbar({map: map, configurable: false});
    toolbar.autoHeight = false;

    toolbar.height = 30;
};
var initializeToolbar = function() {
    toolbar.add(
            new GeoExt.Action(
                    {xtype: 'tbbutton',
                        cls: 'x-btn-text-icon',
                        icon: 'images/logos2.png',
                        tooltip: 'Acerca del visor',
                        text: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Informaci&oacute;n',
                        menu: [{text: 'Secretar&iacute;a de Energ&iacute;a', handler: acercade, icon: 'libs/ext-3.3.0/resources/images/default/tree/questions_ico.png'},
                            {
                                icon: 'images/ftp_icon.gif',
                                text: 'Catalogo de Metadatos',
                                handler: function() {
                                    window.open('http://ide.se.gov.ar/geonetwork/srv/es/main.home', '_blank');
                                }
                            }]}));
    addSeparator(toolbar);
    toolbar.addControl(
            new OpenLayers.Control.ZoomToMaxExtent({
                map: map,
                title: 'Zoom a la m�xima extensi�n del mapa'
            }), {
        iconCls: 'zoomfull',
        toggleGroup: 'map'
    }
    );



    addSeparator(toolbar);
    toolbar.addControl(new OpenLayers.Control.ZoomBox({title: 'Acercamiento: hacer click en el mapa y arrastrar para crear un rect�ngulo'}), {iconCls: 'zoomin', toggleGroup: 'map'});
    toolbar.addControl(new OpenLayers.Control.ZoomBox({out: true, title: 'Alejamiento: hacer click en el mapa y arrastrar para crear un rect�ngulo'}), {iconCls: 'zoomout', toggleGroup: 'map'});
    function off_polys()
    {
        polygoncontroltrazo.deactivate();
        polygonControl.deactivate();
    }
    toolbar.addControl(new OpenLayers.Control.DragPan({isDefault: true, title: 'Desplazamiento: mantener el click izquierdo del mouse para desplazarse sobre el mapa'}), {iconCls: 'pan', toggleGroup: 'map'});
    addSeparator(toolbar);
    nav = new OpenLayers.Control.NavigationHistory();
    map.addControl(nav);
    nav.activate();
    toolbar.add(
            new Ext.Toolbar.Button({
                iconCls: 'back',
                tooltip: 'Vista anterior',
                handler: nav.previous.trigger
            })
            );
    toolbar.add(new Ext.Toolbar.Button({
        iconCls: 'next',
        tooltip: 'Vista siguiente',
        handler: nav.next.trigger
    })
            );
    addSeparator(toolbar);
    function gms2gd() {
        var xg = Ext.getCmp('ir_lon_g').getValue();
        var xm = Ext.getCmp('ir_lon_m').getValue();
        var xs = Ext.getCmp('ir_lon_s').getValue();
        var lalalon = (xg + xm / 60 + xs / 3600) * -1;
        Ext.getCmp('ir_lon').setValue(lalalon.toFixed(7));
        var yg = Ext.getCmp('ir_lat_g').getValue();
        var ym = Ext.getCmp('ir_lat_m').getValue();
        var ys = Ext.getCmp('ir_lat_s').getValue();
        var lalalat = (yg + ym / 60 + ys / 3600) * -1;
        Ext.getCmp('ir_lat').setValue(lalalat.toFixed(7));
    }
    function gd2gms() {
        var lon = Ext.getCmp('ir_lon').getValue() * -1;
        var lat = Ext.getCmp('ir_lat').getValue() * -1;
        var gx = parseInt(lon);
        var mx = Math.floor((lon - gx) * 60);
        var sx = parseFloat((lon - mx / 60 - gx) * 3600);
        var gy = parseInt(lat);
        var my = Math.floor((lat - gy) * 60);
        var sy = parseFloat((lat - my / 60 - gy) * 3600);
        Ext.getCmp('ir_lon_g').setValue(gx);
        Ext.getCmp('ir_lon_m').setValue(mx);
        Ext.getCmp('ir_lon_s').setValue(sx.toFixed(2));
        Ext.getCmp('ir_lat_g').setValue(gy);
        Ext.getCmp('ir_lat_m').setValue(my);
        Ext.getCmp('ir_lat_s').setValue(sy.toFixed(2));
    }
    var ir_lon = new Ext.form.NumberField({
        id: 'ir_lon',
        fieldLabel: 'Longitud',
        height: 20,
        width: 150,
        readOnly: false,
        enableKeyEvents: true,
        allowBlank: false,
        allowNegative: true,
        allowDecimals: true,
        decimalPrecision: 7,
        listeners: {change: gd2gms},
        blankText: 'Ingrese un valor entre -75 y -52',
        minValue: -75,
        maxValue: -52,
        value: -58.370109
    });
    var ir_lat = new Ext.form.NumberField({
        id: 'ir_lat',
        fieldLabel: 'Latitud',
        height: 20,
        width: 150,
        readOnly: false,
        enableKeyEvents: true,
        allowBlank: false,
        allowNegative: true,
        allowDecimals: true,
        decimalPrecision: 7,
        listeners: {change: gd2gms},
        blankText: 'Ingrese un valor entre -57 y -21',
        minValue: -57,
        maxValue: -21,
        value: -34.609588
    });
    var ir_lon_g = new Ext.form.NumberField({
        id: 'ir_lon_g',
        height: 20,
        width: 50,
        readOnly: false,
        enableKeyEvents: true,
        allowBlank: false,
        allowNegative: false,
        allowDecimals: false,
        listeners: {change: gms2gd},
        blankText: 'Ingrese un valor entre 0 y 60',
        minValue: 52,
        maxValue: 75,
        value: 58
    });
    var ir_lon_m = new Ext.form.NumberField({
        id: 'ir_lon_m',
        height: 20,
        width: 50,
        readOnly: false,
        enableKeyEvents: true,
        allowBlank: false,
        allowNegative: false,
        allowDecimals: true,
        decimalPrecision: 5,
        listeners: {change: gms2gd},
        blankText: 'Ingrese un valor entre 0 y 60',
        minValue: 0,
        maxValue: 60,
        value: 40
    });
    var ir_lon_s = new Ext.form.NumberField({
        id: 'ir_lon_s',
        height: 20,
        width: 50,
        readOnly: false,
        enableKeyEvents: true,
        allowBlank: true,
        allowDecimals: true,
        allowNegative: false,
        listeners: {change: gms2gd},
        blankText: 'Ingrese un valor entre 0 y 60',
        minValue: 0,
        maxValue: 60,
        value: 9
    });
    var ir_lat_g = new Ext.form.NumberField({
        id: 'ir_lat_g',
        height: 20,
        width: 50,
        readOnly: false,
        enableKeyEvents: true,
        allowBlank: false,
        allowNegative: false,
        allowDecimals: false,
        listeners: {change: gms2gd},
        blankText: 'Ingrese un valor entre 0 y 60',
        minValue: 21,
        maxValue: 56,
        value: 34
    });
    var ir_lat_m = new Ext.form.NumberField({
        id: 'ir_lat_m',
        height: 20,
        width: 50,
        readOnly: false,
        enableKeyEvents: true,
        allowBlank: false,
        allowNegative: false,
        allowDecimals: true,
        decimalPrecision: 5,
        listeners: {change: gms2gd},
        blankText: 'Ingrese un valor entre 0 y 60',
        minValue: 0,
        maxValue: 60,
        value: 36
    });
    var ir_lat_s = new Ext.form.NumberField({
        id: 'ir_lat_s',
        height: 20,
        width: 50,
        readOnly: false,
        enableKeyEvents: true,
        allowBlank: true,
        allowDecimals: true,
        allowNegative: false,
        listeners: {change: gms2gd},
        blankText: 'Ingrese un valor entre 0 y 60',
        minValue: 0,
        maxValue: 60,
        value: 29
    });

    size = new OpenLayers.Size(21, 25);
    offset = new OpenLayers.Pixel(-(size.w / 2), -size.h);
    markers = new OpenLayers.Layer.Markers("Markers");

    var irCoord = new Ext.Button({
        id: 'irCoord',
        text: 'IR',
        handler: function() {
            if (elegirEscala.getValue() === '') {
                Ext.Msg.alert('', 'Debe elegir una escala.');
            } else {

                map.setCenter(
                        new OpenLayers.LonLat(ir_lon.getValue(), ir_lat.getValue()).transform(new OpenLayers.Projection('EPSG:4326'), new OpenLayers.Projection('EPSG:900913')),
                        map.getZoomForResolution(OpenLayers.Util.getResolutionFromScale(elegirEscala.getValue(), map.getUnits()))
                        );

                map.addLayer(markers);


                var coordir = new OpenLayers.LonLat(ir_lon.getValue(), ir_lat.getValue()).transform(new OpenLayers.Projection('EPSG:4326'), new OpenLayers.Projection('EPSG:900913'));
                var iconir = new OpenLayers.Icon('images/regroup.png', size, offset);
                marquita = new OpenLayers.Marker(coordir, iconir);
                markers.removeMarker(marquita);
                markers.addMarker(marquita);
                marquita.setOpacity(1);
            }
        }
    });

    var SalirXY = new Ext.Button({
        text: 'Salir',
        icon: 'images/Forward.gif',
        handler: function()
        {
            if (typeof marquita === 'undefined') {
                ventanaXY.hide();
            } else {
                markers.removeMarker(marquita);
                marquita.setOpacity(0);
                ventanaXY.hide();
            }

        }
    });
    var elegirEscala = new Ext.form.ComboBox({
        store: new Ext.data.SimpleStore({
            fields: ['texto', 'valor'],
            data: [
                ['Cerca', 13542],
                ['Medio', 108336],
                ['Lejos', 1733376]
            ]
        }),
        id: 'elegirEscala',
        mode: 'local',
        selectOnFocus: true,
        forceSelection: true,
        triggerAction: 'all',
        labelSeparator: '',
        editable: false,
        valueField: 'valor',
        displayField: 'texto'
    });
    Ext.getCmp('elegirEscala').setValue('Cerca');

    var fomularioXY = new Ext.form.FormPanel({
        width: 250,
        frame: true,
        labelAlign: 'left',
        labelWidth: 55,
        items: [
            {html: '<br><b>Grados decimales</b>'},
            ir_lon,
            ir_lat,
            {html: '<br><b>Grados  minutos  segundos</b>'},
            {
                layout: 'column',
                items: [
                    {
                        columnWidth: 0.25,
                        html: '<span style="font-size:12px">Lon W :</span>'
                    },
                    {
                        columnWidth: 0.25,
                        items: ir_lon_g
                    },
                    {
                        columnWidth: 0.25,
                        items: ir_lon_m
                    },
                    {
                        columnWidth: 0.25,
                        items: ir_lon_s
                    }
                ]
            },
            {
                layout: 'column',
                items: [
                    {
                        columnWidth: 0.25,
                        html: '<span style="font-size:12px">Lat S :</span>'
                    },
                    {
                        columnWidth: 0.25,
                        items: ir_lat_g
                    },
                    {
                        columnWidth: 0.25,
                        items: ir_lat_m
                    },
                    {
                        columnWidth: 0.25,
                        items: ir_lat_s
                    }
                ]
            },
            {html: '<br><b>Nivel de acercamiento</b>'},
            elegirEscala

        ],
        buttons: [irCoord, SalirXY]
    });
    ventanaXY = new Ext.Window({
        title: 'Ir a coordenadas - WGS84',
        width: 260,
        height: 270,
        layout: 'fit',
        closable: false,
        resizable: false,
        constrain: true,
        shadow: true,
        closeAction: 'hide', items: [fomularioXY]});
    var gotoxybut = new Ext.Toolbar.Button({
        icon: 'images/toolbar_latlong.gif',
        tooltip: 'Ir a coordenadas',
        handler: function() {
            if (ventanaXY.isVisible()) {
                ventanaXY.hide();
            }
            else
            {
                ventanaXY.show();
            }
        }});
    toolbar.add(gotoxybut);
    addSeparator(toolbar);
    toolbar.add(new Ext.Toolbar.Button({
        tooltip: 'buscador',
        handler: ventana_busca,
        icon: 'images/Search.gif'
    }));
    function ventana_busca()
    {
        var markers = new OpenLayers.Layer.Markers("Markers");
        Ext.getCmp('windowbusca').show();
    }
    addSeparator(toolbar);




    featureInfo = new OpenLayers.Control(
            {title: 'Informaci&oacute;n: click en el mapa y obtener info',
                type: OpenLayers.Control.TYPE_TOOL}
    );


    featureInfo.events.remove("activate");
    featureInfo.events.remove("deactivate");
    featureInfo.events.register("activate", featureInfo, function() {
        toggleQueryMode();
    });
    featureInfo.events.register("deactivate", featureInfo, function() {
        toggleQueryMode();
    });
    toolbar.addControl(featureInfo, {iconCls: 'identify', toggleGroup: 'map', handler: despoly});

    toolbar.addControl(control, {
        tooltip: 'Dibujar poligono y obtener info',
        icon: 'images/poligono.png',
        iconCls: 'buffer',
        toggleGroup: 'map',
        handler: polytrazo});

    toolbar.addControl(polygonControl, {tooltip: 'Dibujar Buffer y obtener info',
        icon: 'images/icon_radar.png',
        iconCls: 'buffer',
        toggleGroup: 'map',
        handler: poly});




    function acercade()
    {
        acercad = new Ext.Panel({
            width: 100,
            height: 100, html: '<B>Sobre los datos energ�ticos:</B><br>Los datos relacionados con el mercado energ�tico contenidos en el presente sitio son provistos por las empresas del sector en car�cter de declaraci�n jurada.<br>Dicha informaci�n debe considerarse como provisional, dado que algunas empresas no han remitido la totalidad de datos solicitados por Secretar�a de Energ�a.<br>En la medida que se reciba la informaci�n geogr�fica faltante, ser� incluida en el sitio.<br><br><B>Sobre los datos de otros organismos:</B><br>La informaci�n complementaria contenida en el presente sitio es provista por otros organismos.<br>Para esos casos los datos ser�n responsabilidad del organismo que las ha elaborado.<br><br><br>Secretar&iacute;a de Energia<br>Tecnolog&iacute;a de la Informaci&oacute;n.<br><A HREF="http://www.energia.gob.ar" TARGET=\'_blank\' >http://www.energia.gob.ar</A><br>energia@minplan.gob.ar'});


        var acerca = new Ext.Window({
            id: 'acerca',
            title: "Aviso Importante",
            width: 400,
            scripts: true,
            loadScripts: true,
            constrain: true,
            shadow: false,
            height: 350,
            layout: 'fit',
            closable: false,
            buttonAlign: 'center',
            resizable: false,
            items: [acercad],
            buttons: [{
                    text: 'Cerrar',
                    handler: function()
                    {
                        acerca.close();
                        acercade.destroy();
                    }}]});


        acerca.show();
    }


    contpol = 1;
    function poly() {
        polygoncontroltrazo.deactivate();
        polygonControl.activate();
        if ((contpol % 2) !== 0) {
            contpol++;
        }
        else {
            contpol++;
        }
    }
    function polytrazo() {
        polygonControl.deactivate();
        polygoncontroltrazo.activate();
        if ((contpol % 2) !== 0) {
            contpol++;
        }
        else {
            contpol++;
        }
    }
    function despoly() {
        polygoncontroltrazo.deactivate();
        polygonControl.deactivate();
        if ((contpol % 2) === 0) {
            polygonControl.deactivate();
            contpol++;
        }
    }
    function ventana_capas()
    {
        Ext.getCmp('capas').show();
    }
    function activas()
    {
    }
    addSeparator(toolbar);
    var graticuleButton = new Ext.Toolbar.Button({
        icon: 'images/graticule.gif',
        enableToggle: false,
        tooltip: 'Red de meridianos/paralelos',
        handler: function() {
            (graticule.active) ? graticule.deactivate() : graticule.activate();
            return false;
        }
    });
    toolbar.add(graticuleButton);

    addSeparator(toolbar);

    medirDistancia = new OpenLayers.Control.Measure(
            OpenLayers.Handler.Path, opcionesMedicion
            );
    medirDistancia.title = 'Medir distancia';
    map.addControl(medirDistancia);
    toolbar.addControl(medirDistancia, {icon: "images/linea.png", toggleGroup: 'map'});


    medirArea = new OpenLayers.Control.Measure(
            OpenLayers.Handler.Polygon, opcionesMedicion
            );
    medirArea.title = 'Medir superficie';
    map.addControl(medirArea);
    toolbar.addControl(medirArea, {iconCls: 'medirarea', icon: "images/area.png", toggleGroup: 'map'});

    toolbar.activate();
};
function toggleQueryMode()
{
    if (featureInfo.active)
    {
        queryEventHandler.activate();
        map.getControlsByClass('OpenLayers.Control.Navigation')[0].deactivate();
    }
    else
    {
        queryEventHandler.deactivate();
    }
}
function doIdentify(evt)
{
    polygonControl.deactivate();
    polygoncontroltrazo.deactivate();
    polygonLayer.destroyFeatures();
    store_data_busqueda.removeAll();
    store_data_busqueda.clearData();
    var capas = "";
    var cont = 0;
    for (var i = 0; i < map.layers.length; i++)
    {
        if (map.layers[i].visibility === true) {
            if (cont <= 0) {
                capas += map.layers[i].name;
                cont++;
            }
            else {
                capas += "," + map.layers[i].name;
            }
        }
    }
    var lonlat = map.getLonLatFromPixel(evt.xy);
    var x = lonlat.lon.toFixed(5);
    var y = lonlat.lat.toFixed(5);
    store_data_busqueda.setBaseParam('GEOM', '');
    store_data_busqueda.setBaseParam('BB', '');
    store_data_busqueda.setBaseParam('PARAM_X', x);
    store_data_busqueda.setBaseParam('PARAM_Y', y);
    store_data_busqueda.setBaseParam('CAPAS', capas);
    store_data_busqueda.load();
    gridbus.show();
    if (nodo && nodo.attributes.layerNames && nodo.attributes.layerNames[0])
    {
        activeLayer = map.getLayersByName(nodo.attributes.layerNames[0])[0];
        var url = activeLayer.getFullRequestString({
            lonlat: map.getLonLatFromPixel(evt.xy).transform(new OpenLayers.Projection('EPSG:900913'), new OpenLayers.Projection('EPSG:4326')),
            REQUEST: "GetFeatureInfo",
            EXCEPTIONS: "application/vnd.ogc.se_xml",
            BBOX: map.getExtent().toBBOX(),
            X: evt.xy.x,
            Y: evt.xy.y,
            INFO_FORMAT: 'text/html',
            QUERY_LAYERS: activeLayer.params.LAYERS,
            WIDTH: map.size.w,
            HEIGHT: map.size.h});
        box = map.getExtent().toBBOX().split(",");
        xminimo = box[0];
        yminimo = box[1];
        xmaximo = box[2];
        ymaximo = box[3];
        lonlat = map.getLonLatFromPixel(evt.xy);
        lactivo = activeLayer.params.LAYERS;
        url = url.split("%3D");
    }
}





function loadXMLDoc(url)
{
    longitud = url[1];
    longitud = longitud.split("%2");
    longitud = longitud[0];
    latitud = url[2];
    temp = lonlat.toString().split(',');
    t1 = temp[0];
    lon1 = t1.split("=");
    lon = lon1[1];
    t2 = temp[1];
    lat2 = t2.split("=");
    lat = lat2[1];
    var markers = new OpenLayers.Layer.Markers("Markers");
    var size = new OpenLayers.Size(39, 39);
    var offset = new OpenLayers.Pixel(-(size.w / 2), -size.h);
    var icon = new OpenLayers.Icon('OpenLayer/img/marker.png', size, offset);
    function buildWindow()
    {
        if (Ext.getCmp('myWindow') && Ext.getCmp('myWindow').rendered)
        {
            Ext.getCmp('myWindow').close();
        }
        Ext.util.CSS.refreshCache();
        if (typeof (lactivo) != 'undefined') {
            Ext.util.CSS.refreshCache();
            var winpick = new Ext.Window({
                id: 'Info',
                title: "Informaci�n",
                width: 210,
                height: 300,
                constrain: true,
                scripts: true,
                closable: false,
                loadScripts: true,
                layout: 'fit',
                keys: [
                    {key: [Ext.EventObject.ESC], handler: function() {
                            win.close();
                            keyboardnav.activate();
                            markers.clearMarkers();
                            var layers = map.getLayersByName('Seleccion');
                            for (var layerIndex = 0; layerIndex < layers.length; layerIndex++)
                            {
                                map.removeLayer(layers[layerIndex]);
                            }
                        }}],
                autoLoad: {url: con_url2, scripts: true, loadScripts: true},
                resizable: false,
                buttons: [
                    {
                        text: 'Cerrar',
                        height: 18,
                        width: 50,
                        handler: function() {
                            winpick.close();
                            markers.clearMarkers();
                            var layers = map.getLayersByName('Seleccion');
                            for (var layerIndex = 0; layerIndex < layers.length; layerIndex++)
                            {
                                map.removeLayer(layers[layerIndex]);
                            }
                        }}]});
            winpick.show();
        }
        else {
        }
    }
    Ext.onReady(buildWindow);




    req = false;
    if (window.XMLHttpRequest && !(window.ActiveXObject))
    {
        try {
            req = new XMLHttpRequest();
        } catch (e) {
            req = false;
        }
    }
    else if (window.ActiveXObject)
    {
        try {
            req = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                req = false;
            }
        }
    }
    if (req)
    {
        req.onreadystatechange = processReqChange;
        req.open("GET", url, true);
        req.send("");
    }
}
function osm_getTileURL(bounds) {
    var res = this.map.getResolution();
    var x = Math.round((bounds.left - this.maxExtent.left) / (res * this.tileSize.w));
    var y = Math.round((this.maxExtent.top - bounds.top) / (res * this.tileSize.h));
    var z = this.map.getZoom();
    var limit = Math.pow(2, z);
    if (y < 0 || y >= limit) {
        return OpenLayers.Util.getImagesLocation() + "404.png";
    } else {
        x = ((x % limit) + limit) % limit;
        return this.url + z + "/" + x + "/" + y + "." + this.type;
    }
}
function processReqChange()
{
    if (req.readyState == 4)
    {
        if (req.status == 200)
        {
            var infoPanel = Ext.getCmp('south-panel');
        }
        else
        {
        }
    }
}
