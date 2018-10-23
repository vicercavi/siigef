/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var Pcenter = new google.maps.LatLng(-9.042127712029426, -60.261483124999984);
google.maps.event.addDomListener(window, 'load', map_limites);

function map_limites() {
    var mapOptions = {
        zoom: 3,
        center: Pcenter,        
        minZoom: 3,
        maxZoom: 17,
        mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE, google.maps.MapTypeId.HYBRID, google.maps.MapTypeId.TERRAIN],
            style: google.maps.MapTypeControlStyle.SMALL,
            position: google.maps.ControlPosition.LEFT_BOTTOM
        }
        , scaleControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL
        },
        navigationControlOptions: {style: google.maps.NavigationControlStyle.ZOOM_PAN}

    };
    map = new google.maps.Map(document.getElementById('map_limites'),
            mapOptions);   
    map.setMapTypeId(google.maps.MapTypeId.SATELLITE);    
   
    //Limtes de Capa
    var limites_cord = [
    {lat: limites_capa[0]['lat'], lng: limites_capa[0]['lng']},
    {lat: limites_capa[1]['lat'], lng: limites_capa[1]['lng']},
    {lat: limites_capa[2]['lat'], lng: limites_capa[2]['lng']},
    {lat: limites_capa[3]['lat'], lng: limites_capa[3]['lng']},
    {lat: limites_capa[4]['lat'], lng: limites_capa[4]['lng']},
    ];

  // Construct the polygon.
  var limite_capa = new google.maps.Polygon({
    paths: limites_cord,
    strokeColor: '#F5B007',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#F5B007',
    fillOpacity: 0.35
  });
  limite_capa.setMap(map);

}
