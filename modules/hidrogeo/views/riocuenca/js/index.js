var _post = null;
$(document).on('ready', function() {
    $('#form1').validator().on('submit', function(e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...

        } else {
        }
    });
    $('#form2').validator().on('submit', function(e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
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
        $.post(_root_ + 'hidrogeo/riocuenca/_paginacion_' + nombrelista + '/' + datos,
                {
                    pagina: pagina,
                    palabra: $("#palabra").val(),
                    idcuenca: $("#buscarCuenca").val(),
                    idsubcuenca: $("#buscarSubcuenca").val() 

                }, function(data) {
            $("#cargando").hide();        
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }

    $("body").on('click', "#buscar", function() {
        buscar($("#palabra").val(), $("#buscarCuenca").val(), $("#buscarSubcuenca").val());
    });
    $("body").on('change', "#buscar", function() {
        buscar($("#palabra").val(), $("#buscarCuenca").val(), $("#buscarSubcuenca").val());
    });
    $("body").on('click', '.estado-riocuenca', function() {
        cambiar_estado($(this).attr("idriocuenca"), $(this).attr("estado"));
    });
    $("body").on('click', '.eliminar-riocuenca', function() {
        eliminar($(this).attr("idriocuenca"));
    });
    $("body").on('change', "#buscarCuenca", function () {
        filtroSubcuenca($("#buscarCuenca").val());
    });

});
//-----------------------Filtros
function filtroSubcuenca(scuenca) {
    $("#cargando").show();
    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    _post = $.post(_root_ + 'hidrogeo/riocuenca/_filtroSubcuenca',
            {               
                cuenca:scuenca                
            },
    function (data) {
        $("#cargando").hide();
        $("#lsta_subcuenca").html('');
        $("#lista_subcuenca").html(data);
    });
}
//----------------------Fin Filtros

function buscar(palabra, idcuenca, idsubcuenca) {
    $("#cargando").show();
    $.post(_root_ + 'hidrogeo/riocuenca/_buscarRiocuenca',
            {
                palabra: palabra,
                idcuenca: idcuenca,
                idsubcuenca: idsubcuenca                
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

    _post = $.post(_root_ + 'hidrogeo/riocuenca/_cambiarEstadoRiocuenca',
            {
                pagina: $(".pagination .active span").html(),
                idriocuenca: id,
                estado: estado,
                palabra: $("#palabra").val(),
                idsubcuenca: $("#buscarSubcuenca").val(),
                idcuenca: $("#buscarCuenca").val()
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

    _post = $.post(_root_ + 'hidrogeo/riocuenca/_eliminarRiocuenca',
            {
                pagina: $(".pagination .active span").html(),
                idriocuenca: id,
                palabra: $("#palabra").val(),
                idsubcuenca: $("#buscarSubcuenca").val(),
                idcuenca: $("#buscarCuenca").val()
            },
    function(data) {//cuando llamo a la funcion _cambiarEstado me 
        $("#cargando").hide();
        $("#listaregistros").html('');
        $("#listaregistros").html(data);
    });
}