$(document).ready(function () {
		
$("body").on('click',"#gestion_idiomas", function () {		
		$('#Dub_FechaDocumento').datepicker({
                    format: "dd/mm/yyyy"
                });
		
		var validator = $("#registrardublin").bootstrapValidator({
			feedbackIcons: {
				valid: "glyphicon glyphicon-ok",
				invalid: "glyphicon glyphicon-remove", 
				validating: "glyphicon glyphicon-refresh"
			}, 
			fields : {
				Dub_Titulo :{
					validators : {
						notEmpty : {
							message : "El campo es requerido"
						}
					}
				}, 
				Dub_Descripcion : {
					validators: {
						notEmpty : {
							message : "El campo es requerido"
						}
					}
				}, 
				Aut_IdAutor : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				},
				Dub_Formato : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				},
				Idi_IdIdioma : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				},
				Dub_PalabraClave : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				},
				Tid_IdTipoDublin : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				},
				Ted_IdTemaDublin : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				},
				Pai_IdPais : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				}
			}
		});
		
});
		

$("body").on('click', "#Idi_IdIdioma", function () {
		gestionIdiomas($('input:radio[id=Idi_IdIdioma]:checked').val());
    });
});


function gestionIdiomas(idIdioma) {
	$("#cargando").show();
	$.post(_root_ + 'dublincore/registrar/gestion_idiomas/' +
            
                idIdioma
            , function (data) {
		$("#cargando").hide();
        $("#gestion_idiomas").html('');
        $("#gestion_idiomas").html(data);
    });
}