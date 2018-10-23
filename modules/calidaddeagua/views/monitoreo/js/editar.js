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
    
    $("body").on('change', "#selTerritorio1", function() {
        filtroEditar($("#selPais").val(), $("#selTerritorio1").val(), 0, 0, 0);
    });
    $("body").on('change', "#selTerritorio2", function() {
        filtroEditar($("#selPais").val(), $("#selTerritorio1").val(), $("#selTerritorio2").val(), 0, 0);
    });
     $("body").on('change', "#selTerritorio3", function() {
        filtroEditar($("#selPais").val(), $("#selTerritorio1").val(), $("#selTerritorio2").val(), $("#selTerritorio3").val(), 0);
    });
    $("body").on('change', "#selTerritorio4", function() {
        filtroEditar($("#selPais").val(), $("#selTerritorio1").val(), $("#selTerritorio2").val(), $("#selTerritorio3").val(),$("#selTerritorio4").val());
    });
});
function filtroEditar(idpais, idterritorio1,idterritorio2,idterritorio3,idterritorio4) {
    $("#cargando").show();
    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    _post = $.post(_root_ + 'hidrogeo/ubigeo/_filtroEditar',
            {
                idpais: idpais,
                idterritorio1:idterritorio1,
                idterritorio2:idterritorio2,
                idterritorio3:idterritorio3,
                idterritorio4:idterritorio4
            },
    function(data) {
        $("#cargando").hide();
        $("#editaregistro").html('');
        $("#editaregistro").html(data);
    });
}