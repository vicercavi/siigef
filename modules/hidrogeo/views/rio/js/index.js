var _post = null;
$(document).on('ready', function() {
    $('#form1').validator().on('submit', function(e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...

        } else {
            // everything looks good!
//        guardarUsuario($("#nombre").val(),$("#apellidos").val(),$("#dni").val(),$("#direccion").val(),
//                $("#telefono").val(),$("#institucion").val(),$("#cargo").val(),
//                $("#correo").val(),$("#usuario").val(),$("#contrasena").val(),$("#confirmarContrasena").val());
        }
    });
    $('#form2').validator().on('submit', function(e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            // everything looks good!
            //   guardarRol($("#nuevoRol").val());
        }
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
        $.post(_root_ + 'hidrogeo/rio/_paginacion_' + nombrelista + '/' + datos,
        {
            pagina: pagina,
            palabra:$("#palabra").val(), 
            idpais:$("#buscarPais").val(), 
            idtipo_agua:$("#buscarTipoAgua").val()
            
        }, function(data) {
            $("#cargando").hide();
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }

     $("body").on('click', "#buscar", function() {
        buscar($("#palabra").val(), $("#buscarPais").val(), $("#buscarTipoAgua").val());
    });
    $("body").on('change', "#buscar", function() {
        buscar($("#palabra").val(), $("#buscarPais").val(), $("#buscarTipoAgua").val());
    });
    $("body").on('click', '.estado-rio', function() {
        cambiar_estado($(this).attr("idrio"),$(this).attr("estado"));
    });
    $("body").on('click', '.eliminar_rio', function() {
        eliminar($(this).attr("id"));
    });

    $('#confirm-delete').on('show.bs.modal', function (e) 
    {        
        $(this).find('.danger').attr('id', $(e.relatedTarget).data('id'));
        $('.nombre-es').html($(e.relatedTarget).data('nombre'));
    });
});

function buscar(palabra, idpais, idtipo_agua) 
{
    $.post(_root_ + 'hidrogeo/rio/_buscarRio',
            {
                palabra: palabra,
                idpais: idpais,
                idtipo_agua: idtipo_agua
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
        
        _post = $.post(_root_ + 'hidrogeo/rio/_cambiarEstadoRio',
                {
                    pagina: $(".pagination .active span").html(),
                    idrio: id,
                    estado: estado,
                    palabra: $("#palabra").val(),
                    idpais: $("#buscarPais").val(),
                    idtipo_agua: $("#buscarTipoAgua").val()
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
        
        _post = $.post(_root_ + 'hidrogeo/rio/_eliminarRio',
                {
                    pagina: $(".pagination .active span").html(),
                    idrio: id,
                    palabra: $("#palabra").val(),
                    idpais: $("#buscarPais").val(),
                    idtipo_agua: $("#buscarTipoAgua").val()
                },
        function(data) {//cuando llamo a la funcion _cambiarEstado me 
            $("#cargando").hide();
            $("#listaregistros").html('');
            $("#listaregistros").html(data);
        });
}



