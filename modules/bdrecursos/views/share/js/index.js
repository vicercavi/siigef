var _post = null;
var inicio = 0; 
$(document).on('ready', function () 
{
   // $('form').validator();
    $("#listaRecurso *").prop('disabled',true);
    $("#bt_generar_rss").prop('disabled',true);
    
    $("body").on('change', "#sl_estandar", function() {
        $("#listaRecurso *").prop('disabled',false);
        $("#bt_generar_rss").prop('disabled',false);
        filtroRecurso();
    });

    var filtroRecurso = function() {
        $("#cargando").show();
        
        _post = $.post(_root_ + 'bdrecursos/share/_filtroRecursoXEstandar',
                {
                   id_estandar: $("#sl_estandar").val() 
                },
        function(data) {
            $("#cargando").hide();
            $("#lista_recurso").html('');
            $("#lista_recurso").html(data);
        });
    }
});

