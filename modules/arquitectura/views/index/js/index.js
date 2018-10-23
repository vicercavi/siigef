$(document).on('ready', function () {
   // $('form').validator();
    $('#form1').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
      // handle the invalid form...
    } else {
      // everything looks good!
//        guardarEdicionPagina($("#nombre").val(), $("#descripcion").val(), $("#orden").val(),
//                $("#tipoPagina").val(), $("#url").val(), $("#idPadre").val(), $("input[name='idiomaRadio']:checked").val());
//        buscar($("#palabra").val(), $("#buscarTipo").val(), $("#idPadre").val());
    }
    });
    $('#form2').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
      // handle the invalid form...
    } else {
      // everything looks good!
//        guardarEdicionPagina($("#nombreEditar").val(), $("#descripcionEditar").val(), $("#ordenEditar").val(),
//                $("#tipoEditar").val(), $("#urlEditar").val(), $("#idPadre").val(), $("#idiomaTradu").val(),
//                $("#idIdiomaOriginal").val(), $("#idPadre").val());
//        buscar($("#palabra").val(), $("#buscarTipo").val(), $("#idPadre").val());
    }
    });

    $('body').on('click', '.pagina', function () {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    var paginacion = function (pagina, nombrelista, datos) {
        var pagina = 'pagina=' + pagina;

        $.post(_root_ + 'arquitectura/index/_paginacion_' + nombrelista + '/' + datos, pagina, function (data) {
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    };

    $("body").on('click', ".idioma_s", function () {
        var id = $(this).attr("id");
        var idIdioma = $("#hd_" + id).val();
        gestionIdiomas($("#idPadreIdiomas").val(), $("#idIdiomaOriginal").val(), idIdioma);
        buscar($("#palabra").val(), $("#buscarTipo").val(), $("#idPadreIdiomas").val(),idIdioma);
        
    }); 
    
    $('textarea#editor1').ckeditor();

    $("body").on('click', "#guardarContenido", function () {
        guardarContenido($('#editor1').val(), $("#idPadreIdiomas").val(), $("#idiomaTradu").val(),
                $("#idIdiomaOriginal").val());
        buscar($("#palabra").val(), $("#buscarTipo").val(), $("#idPadreIdiomas").val());
    });
    $("body").on('change', "#tipoPagina", function () {
        if($("#tipoPagina").val()==0 || $("#tipoPagina").val()==""){     
            document.form2.url.disabled = true;
        }
        if($("#tipoPagina").val()==1){     
            document.form2.url.disabled = false;
        }
    });    
    $("body").on('click', "#buscar", function () {
        buscar($("#palabra").val(), $("#buscarTipo").val(), $("#idPadre").val(), $("#idIdiomaEditar").val());
    });
    $("body").on('change', "#buscarTipo", function () {
        buscar($("#palabra").val(), $("#buscarTipo").val(), $("#idPadre").val(), $("#idIdiomaEditar").val());
    });
    $("body").on('click', '.cambiarEstadoPagina', function() {
        cambiarEstado($(this).attr("Pag_IdPagina"),$(this).attr("Pag_Estado"));
        buscar($("#palabra").val(), $("#buscarTipo").val(), $("#idPadre").val(), $("#idIdiomaEditar").val(), $(".pagination .active span").html());
    });    
});

function buscar(nombre, tipo, idPadre, idIdioma, pagina) {
    $("#cargando").show();
    $.post(_root_ + 'arquitectura/index/_buscarPagina/' + idPadre,
            {
                pagina: pagina,
                palabra: nombre,
                tipo: tipo,
                idIdioma:idIdioma
            }, function (data) {
        $("#listaregistros").html('');
        $("#cargando").hide();
        $("#listaregistros").html(data);
    });
} 
function guardarEdicionPagina(nombre, descripcion, orden, tipo, url, idPadre, idIdioma, idIdiomaOriginal, editar) {
    $("#cargando").show();
    $.post(_root_ + 'arquitectura/index/registrarPagina/' + idPadre,
            {
                nombre_: nombre,
                descripcion_: descripcion,
                orden_: orden,
                tipo_: tipo,
                url_: url,
                editar_: editar,
                idIdioma_: idIdioma,
                idIdiomaOriginal_: idIdiomaOriginal
            }, function (data) {
        if (editar > 0) {
            $("#nueva_arquitectura").html('');
            $("#cargando").hide();
            $("#nueva_arquitectura").html(data);
        } else {
            $("#nueva_arquitectura_hijo").html('');
            $("#cargando").hide();
            $("#nueva_arquitectura_hijo").html(data);
        }

    });
}
function guardarContenido(editor1, idPadre, idIdioma, idIdiomaOriginal) {
    $("#cargando").show();
    $.post(_root_ + 'arquitectura/index/registrarContenido/',
            {
                padre: idPadre,
                editor1: editor1,
                idIdioma_: idIdioma,
                idIdiomaOriginal_: idIdiomaOriginal
            }, function (data) {
        $("#nuevo_contenido").html('');
        $("#cargando").hide();
        $("#nuevo_contenido").html(data);
    });
}
function cambiarEstado(Pag_IdPagina, Pag_Estado) {
    $("#cargando").show();
    $.post(_root_ + 'arquitectura/index/_cambiarEstado',
            {
                Pag_Estado: Pag_Estado,
                Pag_IdPagina: Pag_IdPagina
            }, function (data) {
        $("#listaregistros").html('');
        $("#cargando").hide();
        $("#listaregistros").html(data);
    });
} 
function gestionIdiomas(padre, idIdiomaOriginal, idIdioma) {
    $("#cargando").show();
    $.post(_root_ + 'arquitectura/index/gestion_idiomas',
            {
                idIdioma: idIdioma,
                padre: padre,
                idIdiomaOriginal: idIdiomaOriginal
            }, function (data) {
        $("#gestion_idiomas").html('');
        $("#cargando").hide();
        $("#gestion_idiomas").html(data);
        $('textarea#editor1').ckeditor();
        $('form').validator();
    });
}