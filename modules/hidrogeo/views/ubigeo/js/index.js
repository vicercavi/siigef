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
        $.post(_root_ + 'hidrogeo/ubigeo/_paginacion_' + nombrelista + '/' + datos,
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
        filtroNuevo($("#selPais").val(), 0, 0, 0, 0);
    });
    $("body").on('change', "#selTerritorio1", function() {
        filtroNuevo($("#selPais").val(), $("#selTerritorio1").val(), 0, 0, 0);
    });
    $("body").on('change', "#selTerritorio2", function() {
        filtroNuevo($("#selPais").val(), $("#selTerritorio1").val(), $("#selTerritorio2").val(), 0, 0);
    });
     $("body").on('change', "#selTerritorio3", function() {
        filtroNuevo($("#selPais").val(), $("#selTerritorio1").val(), $("#selTerritorio2").val(), $("#selTerritorio3").val(), 0);
    });
    $("body").on('change', "#selTerritorio4", function() {
        filtroNuevo($("#selPais").val(), $("#selTerritorio1").val(), $("#selTerritorio2").val(), $("#selTerritorio3").val(),$("#selTerritorio4").val());
    });

    $("body").on('click', "#buscar", function() {
       
        buscar($("#buscarPais").val(), $("#palabra").val());        

    });

    $("body").on('click', '.estado-ubigeo', function() {
        cambiar_estado($(this).attr("idubigeo"), $(this).attr("estado"));
    });
    $("body").on('click', '.eliminar-ubigeo', function() {
        eliminar($(this).attr("idubigeo"));
    });
});
function filtroNuevo(idpais, idterritorio1,idterritorio2,idterritorio3,idterritorio4) {
    $("#cargando").show();
    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    _post = $.post(_root_ + 'hidrogeo/ubigeo/_filtroNuevo',
            {
                idpais: idpais,
                idterritorio1:idterritorio1,
                idterritorio2:idterritorio2,
                idterritorio3:idterritorio3,
                idterritorio4:idterritorio4
            },
    function(data) {
        $("#cargando").hide();
        $("#nuevoregistro").html('');
        $("#nuevoregistro").html(data);
    });
}

function buscar(idpais,palabra) {

    $.post(_root_ + 'hidrogeo/ubigeo/_buscarUbigeo',
            {
                idpais: idpais,
                palabra: palabra
                
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

    _post = $.post(_root_ + 'hidrogeo/ubigeo/_cambiarEstadoUbigeo',
            {
                pagina: $(".pagination .active span").html(),
                idubigeo: id,
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

    _post = $.post(_root_ + 'hidrogeo/ubigeo/_eliminarUbigeo',
            {
                pagina: $(".pagination .active span").html(),
                idubigeo: id,
                palabra: $("#palabra").val(),
                idpais: $("#buscarPais").val()
            },
    function(data) {//cuando llamo a la funcion _cambiarEstado me 
        $("#cargando").hide();
        $("#listaregistros").html('');
        $("#listaregistros").html(data);
    });
}