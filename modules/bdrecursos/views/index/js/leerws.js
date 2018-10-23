
$(document).ready(function() {

    $('body').on('click', '.bt_invocar', function() {
        //  var padre = this.parentElement;
        var padre = this.parentElement;
        $(padre).find(".parametro");
        invocarWS($(this).attr("metodo"), $(padre).find(".parametro"));
    });
});

function invocarWS(funcion, parametros) {
    var params = [];
    $(parametros).each(function(index) {
        params.push([$(this).attr("id"), $(this).val()]);
    });
    $("#cargando").show();
    $.post(_root_ + 'bdrecursos/_invocarWS',
            {ifuncion: funcion,
                iparametros: JSON.stringify(params),
                urlws:$("#hd_url_ws").val(),
                idrecurso:$("#hd_idrecurso").val()
            }, function(data, status, xhr) {
        $("#cargando").hide();
        $("#resultado_ws").html(data);
    });

}
