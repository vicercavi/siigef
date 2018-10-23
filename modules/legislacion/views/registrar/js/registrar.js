$(document).ready(function () 
{
	/*('#Mal_FechaPublicacion').datepicker({
                format: "dd/mm/yyyy"
            });
	$('#Mal_FechaRevision').datepicker({
                format: "dd/mm/yyyy"
            });*/
	
	$('#registrarlegislacion').validator().on('submit', function(e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...

        } else {
            // everything looks good!
//        guardarUsuario($("#nombre").val(),$("#apellidos").val(),$("#dni").val(),$("#direccion").val(),
//                $("#telefono").val(),$("#institucion").val(),$("#cargo").val(),
//                $("#correo").val(),$("#usuario").val(),$("#contrasena").val(),$("#confirmarContrasena").val());
        }
    });	
	
	$("body").on('click', "#Idi_IdIdioma", function () {
	gestionIdiomas($('input:radio[id=Idi_IdIdioma]:checked').val());
    });
});


function gestionIdiomas(idIdioma) 
{
	$("#cargando").show();
	$.post(_root_ + 'legislacion/registrar/gestion_idiomas/' +
            
                idIdioma
            , function (data) {
		$("#cargando").hide();
        $("#gestion_idiomas").html('');
        $("#gestion_idiomas").html(data);
//        $('form').validator();
    });
}