$(document).on('ready', function () {    
    $('#form1').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
      // handle the invalid form...
      
    } else {
      // everything looks good!
//        guardarUsuario($("#nombre").val(),$("#apellidos").val(),$("#dni").val(),$("#direccion").val(),
//                $("#telefono").val(),$("#institucion").val(),$("#cargo").val(),
//                $("#correo").val(),$("#usuario").val(),$("#contrasena").val(),$("#confirmarContrasena").val());
    }
    });
    $('#form2').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
      // handle the invalid form...
    } else {
      // everything looks good!
     //   guardarRol($("#nuevoRol").val());
    }
    });
    
    $('body').on('click', '.pagina', function () {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    var paginacion = function (pagina, nombrelista, datos) {
        var pagina = 'pagina=' + pagina;

        $.post(_root_ + 'usuarios/index/_paginacion_' + nombrelista + '/' + datos, pagina, function (data) {
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }
    
    $("body").on('click', "#btn_nuevoRol", function () {
        nuevoDivRol();
    });
    $("body").on('click', "#btn_editContra", function () {
        editContraDiv($("#idusuario").val());
    });
    $("body").on('click', "#buscar", function () {
        buscar($("#palabra").val(),$("#buscarRol").val());
    });
    $("body").on('change', "#buscarRol", function () {
        buscar($("#palabra").val(),$("#buscarRol").val());
    });
    $("body").on('click', "#btn_guardarRol", function () {        
        if ($("#nuevoRol").val()) {
            rol_usuario($("#idusuario").val(),$("#nuevoRol").val());
        }else{
            guardarRol($("#nuevoRol").val());
        }
    });
});
function buscar(palabra,idrol) {
    $.post(_root_ + 'usuarios/index/_buscarUsuario',
    {
        palabra:palabra,
        idrol:idrol
    }, function (data) {
        $("#listaregistros").html('');
        $("#listaregistros").html(data);
    });
}
function guardarRol(role) {        
    $.post(_root_ + 'acl/index/nuevo_role/' + role,
    {        
        nuevoRol:role        
    }, function (data) {
        $("#nuevo_rol").html('');
        $("#nuevo_rol").html(data);
    });
}
function nuevoDivRol() {        
    $.post(_root_ + 'usuarios/index/divRol',
    {        
    }, function (data) {
        $("#agregarRol").html('');
        $("#agregarRol").html(data);
        $('form').validator();
    });
}
function editContraDiv(idusuario) {        
    $.post(_root_ + 'usuarios/index/divEditContra',
    {        
        idusuario:idusuario
    }, function (data) {
        $("#editarContrasena").html('');
        $("#editarContrasena").html(data);
        $('form').validator();
    });
}
function rol_usuario(idusuario, nuevo) {        
    $.post(_root_ + 'usuarios/index/rol/' + idusuario +'/'+ nuevo,
    {        
    }, function (data) {
        $("#rol_usuario").html('');
        $("#rol_usuario").html(data);
        $('form').validator();
    });
}