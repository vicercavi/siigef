$(document).ready(function () {
		
		var validator = $("#registrarpecari").bootstrapValidator({
			feedbackIcons: {
				valid: "glyphicon glyphicon-ok",
				invalid: "glyphicon glyphicon-remove", 
				validating: "glyphicon glyphicon-refresh"
			}, 
			fields : {
				Proveedor :{					
					validators : {
						notEmpty : {
							message : "El campo es requerido"
						}
					}
				},
				archivos :{					
					validators : {
						notEmpty : {
							message : "El campo es requerido"
						}
					}
				}
			}
		});
		
	});