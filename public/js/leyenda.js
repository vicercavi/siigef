/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {

    $('#btleyenda').click(function() {
        mostrarLeyenda();
    });
    $('.ocultar-leyenda').click(function() {
        $("#cont-leyenda").toggle(function() {
            /* if($(this).css('display')=='none'){                          
             $('#btleyenda').hide();// .removeClass('btocultar-leyenda');                            
             }else{                                                      
             $('#btleyenda').addClass('btocultar-leyenda');
             }*/
        });
        $('#btleyenda').show();
    });

    $('.btCerrarLeyenda').click(function() {
        //get collapse content selector
        var collapse_content_selector = $(this).attr('href');
        $(collapse_content_selector).toggle(function() {
            /* if($(this).css('display')=='none'){                          
             $('#btleyenda').hide();// .removeClass('btocultar-leyenda');                            
             }else{                                                      
             $('#btleyenda').addClass('btocultar-leyenda');
             }*/
        });
    });

});

function mostrarLeyenda() {
    $('#btleyenda').hide();
    $("#cont-leyenda").show(function() {
        /* if($(this).css('display')=='none'){                          
         $('#btleyenda').hide();// .removeClass('btocultar-leyenda');                            
         }else{                                                      
         $('#btleyenda').addClass('btocultar-leyenda');
         }*/
    });
}

function limpiarLeyenda(){
    $("#item-leyenda").html("");
}