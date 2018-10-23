$(document).on('ready', function(){
	$("#seleccionar_hoja").change( function() {
		$("#cargando").show();
		var hoja = '&hoja=' + document.getElementById('hojas').value;
		var data_tabla = $("#data_tabla").val();
		
		if(data_tabla==1)
		{
			$.post(_root_ + "bdrecursos/import/_listar_ficha_variable", hoja, function(data){
        	$("#cargando").hide();
            $('#ficha_estandar').html('');
            $('#ficha_estandar').html(data);            
        });
		}
		else
		{
			$.post(_root_ + "bdrecursos/import/_listar_ficha_estandar", hoja, function(data){
        	$("#cargando").hide();
            $('#ficha_estandar').html('');
            $('#ficha_estandar').html(data);            
        });
		}
        
    });	
	
	/*var validator = $("#subir_archivo").bootstrapValidator({
			feedbackIcons: {
				valid: "glyphicon glyphicon-ok",
				invalid: "glyphicon glyphicon-remove", 
				validating: "glyphicon glyphicon-refresh"
			}, 
			fields : {
				archivo :{
					validators : {
						notEmpty : {
							message : "El campo es requerido"
						}
					}
				}
			}
		});
		*/
});
