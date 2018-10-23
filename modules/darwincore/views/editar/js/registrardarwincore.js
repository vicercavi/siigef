$(document).ready(function () {
		$('#Dar_FechaActualizacion').datepicker({
                    format: "dd/mm/yyyy"
                });
		var validator = $("#editardarwin").bootstrapValidator({
			feedbackIcons: {
				valid: "glyphicon glyphicon-ok",
				invalid: "glyphicon glyphicon-remove", 
				validating: "glyphicon glyphicon-refresh"
			}, 
			fields : {
				Dar_CodigoInstitucion :{
					validators : {
						notEmpty : {
							message : "El campo es requerido"
						}
					}
				}, 
				Dar_NombreCientifico : {
					validators: {
						notEmpty : {
							message : "El campo es requerido"
						}
					}
				}, 
				Dar_GeneroOrganismo : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				},
				Dar_EspecieOrganismo : {
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
				Dar_Pais : {
					validators : {
						notEmpty : {							
							message: "Debe seleccionar un pais"
						}
					}
				}
			}
		});
		
	});