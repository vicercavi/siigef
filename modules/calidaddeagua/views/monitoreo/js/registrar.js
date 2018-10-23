
$(document).ready(function () {
	
		$('#Mca_Fecha').datepicker({
                    format: "dd/mm/yyyy"
                });

		var validator = $("#registrarcalidaddeagua").bootstrapValidator({
			feedbackIcons: {
				valid: "glyphicon glyphicon-ok",
				invalid: "glyphicon glyphicon-remove", 
				validating: "glyphicon glyphicon-refresh"
			}, 
			fields : {
				Idi_IdIdioma :{
					validators : {
						notEmpty : {
							message : "El campo es requerido"
						}
					}
				},
				Cue_IdCuenca :{
					validators : {
						notEmpty : {
							message : "El campo es requerido"
						}
					}
				}, 
				Suc_IdSubCuenca : {
					validators: {
						notEmpty : {
							message : "El campo es requerido"
						}
					}
				}, 
				Rio_IdRio : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				},
				Esm_Nombre : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				},
				Esm_Longitud : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				},
				Esm_Latitud : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				},
				Var_Nombre : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				},
				Mca_Valor : {
					validators: {
						notEmpty : {
							message: "El campo es requerido"
						}
					}
				},
								
				Pai_IdPais : {
					validators : {
						greaterThan : {
							value: 1,
							message: "Debe seleccionar un pais"
						}
					}
				}
			}
		});
		
	});