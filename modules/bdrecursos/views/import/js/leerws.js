
$(document).ready(function() {

    $('body').on('click', '.bt_invocar', function() {
        //  var padre = this.parentElement;
        var r_tabla=0;
        var padre = this.parentElement;
        $(padre).find(".parametro");
        invocarWS($(this).attr("metodo"), $(padre).find(".parametro"), r_tabla);
    });
    $('body').on('click', '.bt_invocar_2', function() {
        //  var padre = this.parentElement;
        var r_tabla=$("#r_tabla").val();
        var padre = this.parentElement;
        $(padre).find(".parametro");
        invocarWS($(this).attr("metodo"), $(padre).find(".parametro"), r_tabla);
    });
});

function invocarWS(funcion, parametros, r_tabla) {
    var params = [];
    $(parametros).each(function(index) {
        params.push([$(this).attr("id"), $(this).val()]);
    });
    $("#cargando").show();
    $.post(_root_ + 'bdrecursos/import/_invocarWS',
            {ifuncion: funcion,
                iparametros: JSON.stringify(params),
                urlws:$("#hd_url_ws").val(),
                idrecurso:$("#hd_idrecurso").val(),
                r_tabla:r_tabla
            }, function(data, status, xhr) {
        $("#cargando").hide();
        $("#resultado_ws").html(data);
    });

}
