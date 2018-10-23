/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function mensaje(resultado) {

    var error = "<div class='alert  alert-error '><a class='close' data-dismiss='alert'>x</a><label></label></div>"
    var ok = "<div class='alert alert-success '><a class='close' data-dismiss='alert'>x</a><label></label></div>"
    $("#_mensaje").removeClass("hide");
    
    if ($.isArray(resultado) && (!$.isEmptyObject(resultado))) {
        $.each(resultado, function(key, value) {

            if ($.isArray(value) && (!$.isEmptyObject(value))) {
                if (value[0] == "error") {
                    var div=$(error)              
                    div.find('label').html(value[1]);
                    $("#_mensaje").append(div);
                } else if (value[0] == "ok") {
                    var div=$(ok)              
                    div.find('label').html(value[1]);
                     $("#_mensaje").append(div);
                }
            } else {
                var div=$(error)           
                if (value == "") {
                     div.find('label').html("Ocurrio un error vuelva a intentarlo luego: Error: " + value);
                } else {
                     div.find('label').html(resultado);
                }
                 $("#_mensaje").append(div);
            }
        });
    } else {
        $("#_mensaje").html(error);
        if (resultado == "") {
            $("#_mensaje").find('div').find('label').html("Ocurrio un error vuelva a intentarlo luego: Error: " + resultado);
        } else {
            $("#_mensaje").find('div').find('label').html(resultado);
        }
    }


}

function limpiarmensaje() {
    $("#_mensaje").html("");
}
