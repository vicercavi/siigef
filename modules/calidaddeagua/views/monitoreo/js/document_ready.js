_post = null;

$(document).ready(function () {
    

    $('body').on('click', '.pagina', function () {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    
    /*var paginacion = function (pagina, nombrelista, datos) {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        var pagina = 'pagina=' + pagina;
        
        $.post(_root_ + 'calidaddeagua/monitoreo/_paginacion_' + nombrelista + '/' + datos, pagina, function (data) {
            $("#cargando").hide();           
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    };*/

    var paginacion = function(pagina, nombrelista, datos) {
        $("#cargando").show();

        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        _post = $.post(_root_ + 'calidaddeagua/monitoreo/_paginacion_' + nombrelista + '/' + datos,
                {
                    pagina: pagina,
                    nombre: $("#tb_nombre_filter").val(),
                    id_variable: $("#id_variable").val()
                    
                }, function(data) {
            $("#cargando").hide();
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }

    $("body").on('click', "#bt_buscar_variable", function() {
           $("#cargando").show();
         if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'calidaddeagua/monitoreo/_buscarVariable',
                {                 
                    nombre: $("#tb_nombre_filter").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#lista_variable").html('');
            $("#lista_variable").html(data);
        });
    });

    $("body").on('click', "#bt_buscar_estacion", function() {
           $("#cargando").show();
         if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'calidaddeagua/monitoreo/_buscarEstacion',
                {                 
                    nombre: $("#tb_nombre_filter").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#lista_estacion").html('');
            $("#lista_estacion").html(data);
        });
    });

    /*("body").on('change', "#Pai_IdPais", function() {
       
    });*/

    $("body").on('click', "#bt_buscar_filter", function () {
        filtroEstacion($("#sl_pais_estacion_filtro").val(),$("#sl_cuenca_estacion_filtro").val(),$("#sl_rio_estacion_filtro").val());
    });
    $("body").on('keypress', "#tb_nombre_filter", function (e) {
        if (e.which == 13) {
            // Acciones a realizar, por ej: enviar formulario.
            filtroEstacion($("#sl_pais_estacion_filtro").val(),$("#sl_cuenca_estacion_filtro").val(),$("#sl_rio_estacion_filtro").val());
        }
    });
    $("body").on('change', "#sl_pais_estacion_filtro", function () {
        filtroEstacion($("#sl_pais_estacion_filtro").val(),0,0);
    });
     $("body").on('change', "#sl_cuenca_estacion_filtro", function () {
        filtroEstacion($("#sl_pais_estacion_filtro").val(),$("#sl_cuenca_estacion_filtro").val(),0);
    });
    $("body").on('change', "#sl_rio_estacion_filtro", function () {
        filtroEstacion($("#sl_pais_estacion_filtro").val(),$("#sl_cuenca_estacion_filtro").val(),$("#sl_rio_estacion_filtro").val());
    });
   
}
)