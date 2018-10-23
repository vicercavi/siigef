$(document).on('change', 'input', function() {

    if ($(this).attr("type") == "checkbox") {
        var tipo = $(this).attr("id").split('_')[1];
         if (tipo == "especie") {
            CargarPuntosEspecie();
        }
        
    }
});

$(document).ready(function() {
    $('body').on('click', '.pagina', function() {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    var paginacion = function(pagina, nombrelista, datos) {
        var pagina = 'pagina=' + pagina;

        $.post(_root_ + 'biodiversidad/_paginacion_' + nombrelista + '/' + datos, pagina, function(data) {
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }
   

    

});
