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
        $("#cargando").show();
        $.post(_root_ + 'hidrogeo/tipoagua/_paginacion_' + nombrelista + '/' + datos,
        {
            pagina: pagina,
            palabra:$("#palabra").val()
            
        }, function(data) {
            $("#cargando").hide();
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
    $("body").on('click', '.estado-tipoagua', function() {
        cambiar_estado($(this).attr("idtipoagua"),$(this).attr("estado"));
    });
    $("body").on('click', '.eliminar_tipoagua', function() {
        eliminar($(this).attr("id"));
    });
    $('#confirm-delete').on('show.bs.modal', function (e) 
    {        
        $(this).find('.danger').attr('id', $(e.relatedTarget).data('id'));
        $('.nombre-es').html($(e.relatedTarget).data('nombre'));
    });
});

function buscar(palabra) {
    $("#cargando").show();

    $.post(_root_ + 'hidrogeo/tipoagua/_buscarTipoagua',
            {
                palabra: palabra
            }, function(data) {
                $("#cargando").hide();
                $("#listaregistros").html('');
                $("#listaregistros").html(data);
    });
}
function cambiar_estado(id,estado) {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'hidrogeo/tipoagua/_cambiarEstadoTipoagua',
                {
                    pagina: $(".pagination .active span").html(),
                    idtipoagua: id,
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
        
        _post = $.post(_root_ + 'hidrogeo/tipoagua/_eliminarTipoagua',
                {
                    pagina: $(".pagination .active span").html(),
                    idtipoagua: id,
                    palabra: $("#palabra").val(),
                },
        function(data) {//cuando llamo a la funcion _cambiarEstado me 
            $("#cargando").hide();
            $("#listaregistros").html('');
            $("#listaregistros").html(data);
        });
}
