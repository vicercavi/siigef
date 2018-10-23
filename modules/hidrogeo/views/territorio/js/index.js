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
        $.post(_root_ + 'hidrogeo/territorio/_paginacion_' + nombrelista + '/' + datos,
                {
                    pagina: pagina,
                    palabra: $("#palabra").val(),
                    idpais: $("#buscarPais").val()

                }, function(data) {
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }
    $("body").on('change', "#selPais", function() {
        filtroNuevo($("#selPais").val(), 0);
    });
    $("body").on('change', "#selDenominacion", function() {
        filtroNuevo($("#selPais").val(), $("#selDenominacion").val());
    });

    $("body").on('change', "#buscarPais", function() {
        buscar($("#palabra").val(), $("#buscarPais").val(),0);
        filtroBusqueda($("#buscarPais").val(), 0);
        
    });
    $("body").on('change', "#buscarDenominacion", function() {
        buscar($("#palabra").val(), $("#buscarPais").val(),$("#buscarDenominacion").val());
        filtroBusqueda($("#buscarPais").val(), $("#buscarDenominacion").val());
        
    });
    $("body").on('click', "#buscar", function() {
        buscar($("#palabra").val(), $("#buscarPais").val(),$("#buscarDenominacion").val());
    });
    $("body").on('change', "#buscar", function() {
        buscar($("#palabra").val(), $("#buscarPais").val(),$("#buscarDenominacion").val());
    });

    $("body").on('click', '.estado-territorio', function() {
        cambiar_estado($(this).attr("idterritorio"), $(this).attr("estado"));
    });

    $("body").on('click', '.eliminar_territorio', function() {
        eliminar($(this).attr("id"));
    });

    $('#confirm-delete').on('show.bs.modal', function (e) 
    {        
        $(this).find('.danger').attr('id', $(e.relatedTarget).data('id'));
        $('.nombre-es').html($(e.relatedTarget).data('nombre'));
    });
});
function filtroNuevo(idpais, iddenominacion) {
    $("#cargando").show();
    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    _post = $.post(_root_ + 'hidrogeo/territorio/_filtroNuevo',
            {
                idpais: idpais,
                iddenominacion: iddenominacion
            },
    function(data) {
        $("#cargando").hide();
        $("#nuevoregistro").html('');
        $("#nuevoregistro").html(data);
    });
}

function filtroBusqueda(idpais, iddenominacion) {
    $("#cargando").show();
    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    _post = $.post(_root_ + 'hidrogeo/territorio/_filtroBusqueda',
            {
                idpais: idpais,
                iddenominacion: iddenominacion
            },
    function(data) {
        $("#cargando").hide();
        $("#filtrobusqueda").html('');
        $("#filtrobusqueda").html(data);
    });
}
function buscar(palabra, idpais,iddenominacion) {
    $("#cargando").show();
    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    $.post(_root_ + 'hidrogeo/territorio/_buscarTerritorio',
            {
                palabra: palabra,
                idpais: idpais,
                iddenominacion:iddenominacion
            }, function(data) {
        $("#cargando").hide();
        $("#listaregistros").html('');
        $("#listaregistros").html(data);
    });
}
function cambiar_estado(id, estado) {
    $("#cargando").show();
    if (_post && _post.readyState != 4) {
        _post.abort();
    }

    _post = $.post(_root_ + 'hidrogeo/territorio/_cambiarEstadoTerritorio',
            {
                pagina: $(".pagination .active span").html(),
                idterritorio: id,
                estado: estado,
                palabra: $("#palabra").val(),
                idpais: $("#buscarPais").val(),
                iddenominacion: $("#buscarDenominacion").val()
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

    _post = $.post(_root_ + 'hidrogeo/territorio/_eliminarTerritorio',
            {
                pagina: $(".pagination .active span").html(),
                idterritorio: id,
                palabra: $("#palabra").val(),
                idpais: $("#buscarPais").val(),
                iddenominacion: $("#buscarDenominacion").val()
            },
    function(data) {//cuando llamo a la funcion _cambiarEstado me 
        $("#cargando").hide();
        $("#listaregistros").html('');
        $("#listaregistros").html(data);
    });
}