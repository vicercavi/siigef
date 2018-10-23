var _post = null;
$(document).on('ready', function() {
    $('#form1').validator().on('submit', function(e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...

        } else {
            // everything looks good!
//        guardarUsuaponderacionica($("#nombre").val(),$("#apellidos").val(),$("#dni").val(),$("#direccion").val(),
//                $("#telefono").val(),$("#institucion").val(),$("#cargo").val(),
//                $("#correo").val(),$("#usuaponderacionica").val(),$("#contrasena").val(),$("#confirmarContrasena").val());
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
        $.post(_root_ + 'calidaddeagua/ponderacionica/_paginacion_' + nombrelista + '/' + datos,
                {
                    pagina: pagina,
                    palabra: $("#palabra").val(),
                    idvariable: $("#buscarVariable").val(),
                    idica: $("#buscarIca").val()

                }, function(data) {
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }

    $("body").on('click', "#buscar", function() {
        buscar($("#palabra").val(), $("#buscarVariable").val(), $("#buscarIca").val());
    });
    $("body").on('change', "#buscar", function() {
        buscar($("#palabra").val(), $("#buscarVariable").val(), $("#buscarIca").val());
    });
    $("body").on('click', '.estado-ponderacionica', function() {
        cambiar_estado($(this).attr("idponderacionica"), $(this).attr("estado"));
    });
    $("body").on('click', '.eliminar-ponderacionica', function() {
        eliminar($(this).attr("idponderacionica"));
    });
});

function buscar(palabra, idvariable, idica) {
    $.post(_root_ + 'calidaddeagua/ponderacionica/_buscarPonderacionIca',
            {
                palabra: palabra,
                idvariable: idvariable,
                idica: idica
            }, function(data) {
        $("#listaregistros").html('');
        $("#listaregistros").html(data);
    });
}
function cambiar_estado(id, estado) {
    $("#cargando").show();
    if (_post && _post.readyState != 4) {
        _post.abort();
    }

    _post = $.post(_root_ + 'calidaddeagua/ponderacionica/_cambiarEstadoPonderacionIca',
            {
                pagina: $(".pagination .active span").html(),
                idponderacionica: id,
                estado: estado,
                palabra: $("#palabra").val(),
                idvariable: $("#buscarVariable").val(),
                idica: $("#buscarIca").val()
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

    _post = $.post(_root_ + 'calidaddeagua/ponderacionica/_eliminarPonderacionIca',
            {
                pagina: $(".pagination .active span").html(),
                idponderacionica: id,
                palabra: $("#palabra").val(),
                idvariable: $("#buscarVariable").val(),
                idica: $("#buscarIca").val()
            },
    function(data) {//cuando llamo a la funcion _cambiarEstado me 
        $("#cargando").hide();
        $("#listaregistros").html('');
        $("#listaregistros").html(data);
    });
}