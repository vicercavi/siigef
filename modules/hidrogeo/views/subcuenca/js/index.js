var _post = null;
$(document).on('ready', function() {
    $('#form1').validator().on('submit', function(e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...

        } else {}
    });
    $('#form2').validator().on('submit', function(e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {}
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
        $.post(_root_ + 'hidrogeo/subcuenca/_paginacion_' + nombrelista + '/' + datos,
        {
            pagina: pagina,
            palabra:$("#palabra").val()
            
        }, function(data) {
            $("#cargando").hide(); 
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }
    
    $("body").on('click', "#buscar", function() {
        buscar($("#palabra").val(),$("#buscarCuenca").val());
    });
    $("body").on('change', "#buscar", function() {
        buscar($("#palabra").val(),$("#buscarCuenca").val());
    });
    $("body").on('click', '.estado-subcuenca', function() {
        cambiar_estado($(this).attr("idsubcuenca"),$(this).attr("estado"));
    });
    $("body").on('click', '.eliminar_subcuenca', function() {
        eliminar($(this).attr("id"));
    });
});

function buscar(palabra,idcuenca) {
    $("#cargando").show();
    $.post(_root_ + 'hidrogeo/subcuenca/_buscarSubcuenca',
            {
                palabra: palabra,
                idcuenca:idcuenca
            }, function(data) {
                $("#cargando").hide();
                $("#listaregistros").html('');
                $("#listaregistros").html(data);
            });
}
function cambiar_estado(id,estado) {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'hidrogeo/subcuenca/_cambiarEstadoSubcuenca',
                {
                    pagina: $(".pagination .active span").html(),
                    idsubcuenca: id,
                    estado: estado,
                    palabra: $("#palabra").val()
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
        
        _post = $.post(_root_ + 'hidrogeo/subcuenca/_eliminarSubcuenca',
                {
                    pagina: $(".pagination .active span").html(),
                    idsubcuenca: id,
                    palabra: $("#palabra").val(),
                },
        function(data) {//cuando llamo a la funcion _cambiarEstado me 
            $("#cargando").hide();
            $("#listaregistros").html('');
            $("#listaregistros").html(data);
        });
}