$(document).on('ready', function() {
    $('body').on('click', '.pagina', function() {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
	var paginacion = function(pagina){
        $("#cargando").show();
		var pagina = 'pagina=' + pagina;
		
        $.post(_root_ + 'bdrecursos/pagina_resultado/', pagina , function(data){
			$("#cargando").hide();
            $('#resultados').html('');
            $('#resultados').html(data);
        });
		
    }		
});