var _post = null;
$(document).ready(function () {
	//Filtros de cuenca
	/*$("body").on('change', "#Rio_IdRio", function() {
		_post = $.post(_root_ + 'calidaddeagua/monitoreo/_getCuenca',
                {
                    id_rio:$("#Rio_IdRio").val()                    

                }, function(data) {
            $("#cargando").hide();
            $("#lista_cuenca").html('');
            $("#lista_cuenca").html(data);
        });        
    });

    $("body").on('change', "#Cue_IdCuenca", function() {

		_post = $.post(_root_ + 'calidaddeagua/monitoreo/_getSubCuenca',
                {
                    id_cuenca:$("#Cue_IdCuenca").val(),
                    id_rio:$("#Rio_IdRio").val()
                }, function(data) {
            $("#cargando").hide();
            $("#lista_sub_cuenca").html('');
            $("#lista_sub_cuenca").html(data);
        });        
    });*/

    /*$("body").on('change', "#selPais", function() {

    	filtroNuevo($("#selPais").val(), 0, 0, 0, 0);	

    	_post = $.post(_root_ + 'calidaddeagua/monitoreo/_getRio',
                {
                   id_pais:$("#selPais").val()                    

                }, function(data) {
            $("#cargando").hide();
            $("#lista_rio").html('');
            $("#lista_rio").html(data);
        }); 
   	
    });*/
    $("body").on('change', "#selTerritorio1", function() {
        filtroNuevo($("#selPais").val(), $("#selTerritorio1").val(), 0, 0, 0);
    });
    $("body").on('change', "#selTerritorio2", function() {
        filtroNuevo($("#selPais").val(), $("#selTerritorio1").val(), $("#selTerritorio2").val(), 0, 0);
    });
     $("body").on('change', "#selTerritorio3", function() {
        filtroNuevo($("#selPais").val(), $("#selTerritorio1").val(), $("#selTerritorio2").val(), $("#selTerritorio3").val(), 0);
    });
    $("body").on('change', "#selTerritorio4", function() {
        filtroNuevo($("#selPais").val(), $("#selTerritorio1").val(), $("#selTerritorio2").val(), $("#selTerritorio3").val(),$("#selTerritorio4").val());
    });
	
	function filtroNuevo(idpais, idterritorio1,idterritorio2,idterritorio3,idterritorio4) {
    $("#cargando").show();
    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    _post = $.post(_root_ + 'calidaddeagua/monitoreo/_filtroEditar',
            {
                idpais: idpais,
                idterritorio1:idterritorio1,
                idterritorio2:idterritorio2,
                idterritorio3:idterritorio3,
                idterritorio4:idterritorio4
            },
    function(data) {
        $("#cargando").hide();
        $("#lista_ubigeo").html('');
        $("#lista_ubigeo").html(data);
    });
}

		$('#Mca_Fecha').datepicker({
                    format: "dd/mm/yyyy"
                });

		var validator = $("#editarcalidaddeagua").bootstrapValidator({
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
				Mca_Fecha : {
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