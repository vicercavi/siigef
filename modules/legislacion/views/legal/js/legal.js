$(document).on('ready', function() {
    $('body').on('click', '.pagina', function() {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
	var paginacion = function(pagina){
        $("#cargando").show();
		var pagina = 'pagina=' + pagina;
		var palabra = '&palabra=' + $("#palabra").val();
		var tipo ='&tipo=' + $("#tipo").val();
		var pais ='&pais=' + $("#pais").val();
		var metodo = $("#metodo").val();		
		
        $.post(_root_ + 'legislacion/legal/'+metodo, pagina+palabra+tipo+pais , function(data){
			$("#cargando").hide();
            $('#resultados').html('');
            $('#resultados').html(data);
			$('[data-toggle="tooltip"]').tooltip();
        });
    }

    
   
	$("body").on('click','#btnEnviar',function(){

		//document.getElementById('query').value =  '';
		//document.getElementById('metodo').value  = 'buscarporpalabras';
		//paginacion();
		
		var palabra=$("#palabra").val();
		var tipo = $("#tipo").val();
		var pais = $("#pais").val();
		
		buscarLegislacion(palabra,tipo,pais);

    });

	$("body").on('click','#menulegislaciones li' ,function() {
        actulizarportipo(this);
    });
		
	
	var  actulizarportipo= function(li){
		//document.getElementById('query').value =  $(li).find("span.tipolegislacion").text();
		//document.getElementById('metodo').value  = 'buscarportipolegislacion';
        //paginacion();
       
		var palabra=$("#palabra").val();
		var tipo =  $(li).find("span.tipolegislacion").text();
		var pais = $("#pais").val();

		buscarLegislacion(palabra,tipo,pais);

	}
	
	
	$("body").on('click',".pais",function() {
        actulizarporpais(this);
    });
	
	
	var  actulizarporpais= function(li){
		//document.getElementById('query').value =  $(li).attr("pais");
		//document.getElementById('metodo').value  = 'buscarporpais';
        //paginacion();
        var palabra=$("#palabra").val();
		var tipo = $("#tipo").val()
		var pais =  $(li).attr("pais");

		buscarLegislacion(palabra,tipo,pais);
		
	}
	
});
function tecla_enter_legalizacion(evento)
{    
    var iAscii;
    if (evento.keyCode){
        iAscii = evento.keyCode;
    }  
    if (iAscii == 13) 
    {
    	var palabra=$("#palabra").val();
		var tipo = $("#tipo").val();
		var pais = $("#pais").val();
		
		buscarLegislacion(palabra,tipo,pais);
        evento.preventDefault();
    }	   
}
function buscarLegislacion(palabra,tipo,pais){
	var url = _root_ + 'legislacion/legal';
	var palabra=palabra;
	var tipo = tipo;
	var pais = pais;

	if(pais!="%"){
		document.location.href = url+"/index"+((palabra!="")?"/"+palabra:"/all") + ((tipo!="%")?"/"+tipo:"/all") +"/"+pais;
	}else if (tipo!="%"){
		document.location.href = url+"/index"+((palabra!="")?"/"+palabra:"/all") +"/"+tipo; 			
	}else if(palabra!="" && palabra !="all"){
		document.location.href = url+"/index/"+palabra;
	}else{
		document.location.href = url;
	}
}

