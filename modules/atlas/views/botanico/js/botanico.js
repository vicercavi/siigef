$(document).on('ready', function() {
    $('body').on('click', '.pagina', function() {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    var paginacion = function(pagina){
		$("#cargando").show();
                var pagina = 'pagina=' + pagina;
                var palabra = '&palabra=' + $("#nombre").val();
        $.post(_root_ + 'atlas/botanico/buscarporpalabras', pagina + palabra, function(data){
            $("#cargando").hide();
			$('#resultadosbusqueda').html('');
            $('#resultadosbusqueda').html(data);
			$('[data-toggle="tooltip"]').tooltip();
        });	
    }
	$("body").on('click','#btnBuscar',function(){
		paginacion();
    });   
});
