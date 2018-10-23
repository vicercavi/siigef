/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('ready', function(){
    $("body").on('click','.pagina', function(){
        paginacion($(this).attr("pagina"));
    });
	    
    var paginacion = function(pagina){
                var pagina = 'pagina=' + pagina;
                var nombre = '&nombre=' + $("#nombre").val();
                var variables = '&variables=' +  $("#variable").val();
                var pais = '&pais=' +  $("#pais").val();
                var idRecurso = '&idRecurso=' + $("#idRecurso").val();                
                var registros = '&registros=' + $("#registrosCantidad").val();
                var metodo = 'buscarporpalabras';
                var as = '#resultadosbusqueda';

        if($("#variable").val()!='')
        {
            metodo = 'buscarportipodocumento';
            as = '#lista_registros';
        }  
        if($("#pais").val()!='')
        {
            metodo = 'buscarporpais';
            as = '#resultadosbusqueda';
        } 
        
        $.post(_root_ + 'dublincore/index/' + metodo, pagina + nombre + variables + pais + idRecurso + registros, function(data){
            $(as).html('');
            $(as).html(data);
        });	
    }   
    
    $("#btnBuscar").click(function(){
        document.getElementById('variable').value  = '';
        document.getElementById('pais').value  = '';
        paginacion();
    });	    
    $("#selectCantidad").change(function(){
        document.getElementById('registrosCantidad').value  = document.getElementById('selectCantidad').options[document.getElementById('selectCantidad').selectedIndex].value;
        paginacion(this);
        
    });
    
    $("body").on('click',"#ul_tipo_documentos li",function() {
        actualizarportipo(this);
    });
	
    var actualizarportipo = function(li){
        document.getElementById('variable').value  =  $(li).find("span.tipos_doc").text();
        paginacion();
    }	
    
    $("body").on('click','.pais', function() {
        actulizarporpais(this);
    });    
	
    var  actulizarporpais= function(li){
        document.getElementById('pais').value  =  $(li).attr("pais");
        paginacion();
    }
    
    $("body").on('click',".metadata", function() {
        actulizar(this);
    });
  
    var  actulizar= function(span){
        var as = '#buscardocumentos';
        var registros = '&registros=' +  $(span).attr("metadata");
        $.post(_root_ + 'dublincore/index/metadata/', registros , function(data){
        $(as).html('');
        $(as).html(data);
        });
    }
		
});

