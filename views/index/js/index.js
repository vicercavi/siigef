$(document).on('ready', function () {

    if (!!($('#attachments').attr('title'))) {
        $("#cargando").show();
        var palabra = 'palabra=' + $('#attachments').attr('title');
        $.post(_root_ + 'dublincore/documentos/embed_dublincore', palabra, function (data) {
            $("#attachments").html(''); 
            $("#cargando").hide();
            $("#attachments").html(data);
            $('[data-toggle="tooltip"]').tooltip();
        });
    };

    $('body').on('click', '.pagina', function () {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    var paginacion = function (pagina, nombrelista, datos) {
        $("#cargando").show();
        var pagina = 'pagina=' + pagina;

        $.post(_root_ + 'index/index/_paginacion_' + nombrelista + '/' + datos, pagina, function (data) {
            $("#" + nombrelista).html(''); 
            $("#cargando").hide();
            $("#" + nombrelista).html(data);
            $('.tool_titulo').tooltip();
        });
    };

    $("body").on('click',".pais",function() {
        actulizarporpais(this);
    });
    var  actulizarporpais= function(li){
        /*document.getElementById('query').value =  $(li).attr("pais");
        document.getElementById('metodo').value  = 'buscarporpais';
        paginacion();*/
        buscarPaisGeneral($("#textBuscar2").val(),"filtrotipogeneral",$(li).attr("pais"));               
    } 
});
function tecla_enter2(evento)
{    
    var iAscii;
    if (evento.keyCode){
        iAscii = evento.keyCode;
    }  
    if (iAscii == 13) 
    {
        buscarPalabraGeneral('textBuscar2','filtrotipogeneral','filtropaisgeneral');
        evento.preventDefault();
    }
   
}

function buscarPalabraGeneral(palabra, tipo, pais) { 
    var palabra = $('#'+palabra).val();      
    var tipo = $('#'+tipo).val(); 
    var pais = $('#'+pais).val(); 
    if(!palabra){palabra='all'}    
    if(!tipo){tipo='all'}
    if(!pais){pais='all'}

    document.location.href = _root_ + 'index/buscarPalabra/' + palabra + '/' + tipo + '/' + pais
}
function buscarPaisGeneral(palabra, tipo, pais) { 
    var palabra = palabra;         
    var tipo = $('#'+tipo).val(); 
    var pais = pais; 
    if(!palabra){palabra='all'}    
    if(!tipo){tipo='all'}
    if(!pais){pais='all'}

    document.location.href = _root_ + 'index/buscarPalabra/' + palabra + '/' + tipo + '/' + pais
    
}
