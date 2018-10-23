var _post = null;
$(document).on('ready', function() {
    $('#form1').validator().on('submit', function(e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...

        } else {}
    });
    $('#form2').validator().on('submit', function(e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {}
    });
   
    $('body').on('click', '.pagina', function() {
        paginacion(
                $(this).attr("pagina"), //numero de pag. seleccionado--sirve para mostrar la lista en dicha pagina
                $(this).attr("nombre"), //nombre de la paginacion vinculado a la lista
                $(this).attr("parametros")
        );
    });
    var paginacion = function(pagina, nombrelista, datos) {
        $.post(_root_ + 'calidaddeagua/estadoeca/_paginacion_' + nombrelista + '/' + datos,
        {
            pagina: pagina,
            palabra:$("#palabra").val()
            
        }, function(data) {
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }
    
    $("body").on('click', "#buscar", function() {
        buscar($("#palabra").val());
    });
    $("body").on('change', "#buscar", function() {
        buscar($("#palabra").val());
    });
    $("body").on('click', '.estado-estadoeca', function() {
        cambiar_estado($(this).attr("idestadoeca"),$(this).attr("estado"));
    });
    $("body").on('click', '.eliminar-estadoeca', function() {
        eliminar($(this).attr("idestadoeca"));
    });
});

function buscar(palabra) {
    $.post(_root_ + 'calidaddeagua/estadoeca/_buscarEstadoEca',
            {
                palabra: palabra
            }, function(data) {
        $("#listaregistros").html('');
        $("#listaregistros").html(data);
    });
}
function cambiar_estado(id,estado) {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
         _post = $.post(_root_ + 'calidaddeagua/estadoeca/_cambiarEstadoEca',
                {
                    pagina: $(".pagination .active span").html(),
                    idestadoeca: id,
                    estado: estado,
                    palabra: $("#palabra").val()
                },
        function(data) {//cuando llamo a la funcion _cambiarEstado me 
            $("#cargando").hide();
            $("#listaregistros").html('');
            $("#listaregistros").html(data);
        });
}
function eliminar(id) {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
         _post = $.post(_root_ + 'calidaddeagua/estadoeca/_eliminarEstadoEca',
                {
                    pagina: $(".pagination .active span").html(),
                    idestadoeca: id,
                    palabra: $("#palabra").val(),
                },
        function(data) {//cuando llamo a la funcion _cambiarEstado me 
            $("#cargando").hide();
            $("#listaregistros").html('');
            $("#listaregistros").html(data);
        });
}