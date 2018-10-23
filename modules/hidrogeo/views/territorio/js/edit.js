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
    $("body").on('change', "#selPais", function() {
        filtroEditar($("#selPais").val(), 0);
    });
    $("body").on('change', "#selDenominacion", function() {
        filtroEditar($("#selPais").val(), $("#selDenominacion").val());
    });
});
function filtroEditar(idpais, iddenominacion) {
    $("#cargando").show();
    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    _post = $.post(_root_ + 'hidrogeo/territorio/_filtroEditar',
            {
                idpais: idpais,
                iddenominacion: iddenominacion,
                nombre:$("#nombre").val(),
                siglas:$("#siglas").val(),
                estado:$("#selEstado").val()
            },
    function(data) {
        $("#cargando").hide();
        $("#editarregistro").html('');
        $("#editarregistro").html(data);
    });
}