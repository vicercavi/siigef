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
        $.post(_root_ + 'hidrogeo/estadodepartamento/_paginacion_' + nombrelista + '/' + datos,
        {
            pagina: pagina,
            palabra:$("#palabra").val(), 
            idpais:$("#buscarPais").val()
            
        }, function(data) {
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }
    
    $("body").on('click', "#buscar", function() {
        buscar($("#palabra").val(), $("#buscarPais").val());
    });
    $("body").on('change', "#buscar", function() {
        buscar($("#palabra").val(), $("#buscarPais").val());
    });
    $("body").on('click', '.estado-estadodepartamento', function() {
        cambiar_estado($(this).attr("idestadodepartamento"),$(this).attr("estado"));
    });
    $("body").on('click', '.eliminar-estadodepartamento', function() {
        eliminar($(this).attr("idestadodepartamento"));
    });
});

function buscar(palabra, idpais) {
    $.post(_root_ + 'hidrogeo/estadodepartamento/_buscarEstadoDepartamento',
            {
                palabra: palabra,
                idpais: idpais
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
        
        _post = $.post(_root_ + 'hidrogeo/estadodepartamento/_cambiarEstadoEstadoDepartamento',
                {
                    pagina: $(".pagination .active span").html(),
                    idestadodepartamento: id,
                    estado: estado,
                    palabra: $("#palabra").val(),
                    idpais: $("#buscarPais").val()
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
        
        _post = $.post(_root_ + 'hidrogeo/estadodepartamento/_eliminarEstadoDepartamento',
                {
                    pagina: $(".pagination .active span").html(),
                    idestadodepartamento: id,
                    palabra: $("#palabra").val(),
                    idpais: $("#buscarPais").val()
                },
        function(data) {//cuando llamo a la funcion _cambiarEstado me 
            $("#cargando").hide();
            $("#listaregistros").html('');
            $("#listaregistros").html(data);
        });
}