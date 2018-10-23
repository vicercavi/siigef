/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function asignarcapa(idjerarquia, idpais, idcapa) {
    $("#cargando").show();
    limpiarmensaje();
    $.post(_root_+'mapa/_asignarcapamonitoreo',
            {jerarquia: idjerarquia,
                pais: idpais,
                capa: idcapa
            }, function(data, status, xhr) {
        $("#cargando").hide();
        mensaje(JSON.parse(data));    
        window.location.reload();
    });

}

function quitarcapa(idjerarquia, idcapa) {
    $("#cargando").show();
    limpiarmensaje();
    $.post(_root_+'mapa/_quitarcapamonitoreo',
            {jerarquia: idjerarquia,               
                capa: idcapa
            }, function(data, status, xhr) {
        $("#cargando").hide();
        mensaje(JSON.parse(data));    
        window.location.reload();
    });

}

function quitarcapa_jerarquia(idjerarquia) {
    $("#cargando").show();
    limpiarmensaje();
    $.post(_root_+'mapa/_quitar_jerarquia_monitoreo',
            {jerarquia: idjerarquia
            }, function(data, status, xhr) {
        $("#cargando").hide();
        mensaje(JSON.parse(data));
        window.location.reload();
    });

}