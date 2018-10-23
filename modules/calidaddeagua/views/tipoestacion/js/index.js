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
         $.post(_root_ + 'calidaddeagua/tipoestacion/_paginacion_' + nombrelista + '/' + datos,
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
    $("body").on('click', '.estado-tipoestacion', function() {
        cambiar_estado($(this).attr("idtipoestacion"),$(this).attr("estado"));
    });
    $("body").on('click', '.eliminar-tipoestacion', function() {
        eliminar($(this).attr("idtipoestacion"));
    });
});

function buscar(palabra) {
    $.post(_root_ + 'calidaddeagua/tipoestacion/_buscarTipoEstacion',
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
        
        _post = $.post(_root_ + 'calidaddeagua/tipoestacion/_cambiarEstadoTipoEstacion',
                {
                    pagina: $(".pagination .active span").html(),
                    idtipoestacion: id,
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
        
        _post = $.post(_root_ + 'calidaddeagua/tipoestacion/_eliminarTipoEstacion',
                {
                    pagina: $(".pagination .active span").html(),
                    idtipoestacion: id,
                    palabra: $("#palabra").val(),
                },
        function(data) {//cuando llamo a la funcion _cambiarEstado me 
            $("#cargando").hide();
            $("#listaregistros").html('');
            $("#listaregistros").html(data);
        });
}