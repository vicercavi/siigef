$(document).on('ready', function() {
    $('#Mal_FechaPublicacion').datepicker({
        format: "dd/mm/yyyy"
    });
    $('#Mal_FechaRevision').datepicker({
        format: "dd/mm/yyyy"
    });
    
	$("body").on('click', ".idioma_s", function () {
        var id = $(this).attr("id");
        var idIdioma = $("#hd_" + id).val();
        gestionIdiomas($("#Mal_IdMatrizLegal").val(), $("#Idi_IdIdiomaOriginal").val(), idIdioma);
    }); 	
});
function gestionIdiomas(idLegal, idIdiomaOriginal, idIdioma) {
   $("#cargando").show();
    $.post(_root_ + 'legislacion/editar/gestion_idiomas',
            {
                idIdioma: idIdioma,
                idLegal: idLegal,
                idIdiomaOriginal: idIdiomaOriginal
            }, function (data) {
        $("#cargando").hide();
		$("#gestion_idiomas").html('');
        $("#gestion_idiomas").html(data);
//        $('form').validator();
    });
}