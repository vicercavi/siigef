$(document).ready(function () {
		$('#Pli_FechaUltimaModificacion').datepicker({
                    format: "dd/mm/yyyy"
                });
		$('#Pli_FechaCreacion').datepicker({
                    format: "dd/mm/yyyy"
                });
		var validator = $("#editarplinian").bootstrapValidator({
			feedbackIcons: {
				valid: "glyphicon glyphicon-ok",
				invalid: "glyphicon glyphicon-remove", 
				validating: "glyphicon glyphicon-refresh"
			}, 
			fields : {
				Pli_NombreCientifico :{
					message : "Nivel Legal es requerido",
					validators : {
						notEmpty : {
							message : "El campo es requerido"
						}
					}
				}, 
				Pli_AcronimoInstitucion : {
					validators: {
						notEmpty : {
							message : "El campo es requerido"
						}
					}
				}, 
				Pli_DescripcionGeneral : {
					validators: {
						notEmpty : {
							message : "El campo es requerido"
						}
					}
				}				
			}
		});
		
	});