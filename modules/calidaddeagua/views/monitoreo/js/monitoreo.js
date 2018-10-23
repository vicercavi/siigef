/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function cargar_capa_defecto(){
    //Para el mapa
    var itemcapa="00";
    $("#cb_layerWMS_"+itemcapa).prop("checked", true)
    var padre = $("#cb_layerWMS_"+itemcapa).parent();
    var nombre = $(padre).find("#hd_layern_"+itemcapa).val();
    var url = $(padre).find("#hd_layer_"+itemcapa).val();
    var urlb = $(padre).find("#hd_layerb_"+itemcapa).val();

    AddWMS(urlb, nombre);
}
