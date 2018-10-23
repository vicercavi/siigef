$(document).on('ready', function() {
    $('body').on('click', '.pagina', function() {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
	var paginacion = function(pagina){
        var pagina = 'pagina=' + pagina;
		var palabra = '&palabra=' + $("#palabra").val();
		var metodo = $("#metodo").val();
		var query = $("#query").val();
		if(query!=""){palabra = '&palabra=' +query;}
        $.post(_root_ + 'legal/'+metodo, pagina + palabra , function(data){
            $('#resultados').html('');
            $('#resultados').html(data);
        });
    }
   
	$("body").on('click','#btnEnviar',function(){
		 $("#cargando").show();
		document.getElementById('query').value =  '';
		document.getElementById('metodo').value  = 'buscarporpalabras';
		
		paginacion();
		$("#cargando").hide();
    });
	
	
	
	$("body").on('click','#menulegislaciones li' ,function() {
        actulizarportipo(this);
    });
		
	
	var  actulizarportipo= function(li){
		document.getElementById('query').value =  $(li).find("span.tipolegislacion").text();
		document.getElementById('metodo').value  = 'buscarportipolegislacion';
        paginacion();

	}
	
	
	$("body").on('click',".pais",function() {
        actulizarporpais(this);
    });
	
	
	var  actulizarporpais= function(li){
		document.getElementById('query').value =  $(li).attr("pais");
		document.getElementById('metodo').value  = 'buscarporpais';
        paginacion();
		
	}
	
	
	
	
	
		
});