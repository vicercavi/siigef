/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function filtroEstacion(spais,scuenca,srio) {
    $("#cargando").show();
    if (_post && _post.readyState != 4) {
        _post.abort();
    }
    _post = $.post(_root_ + 'calidaddeagua/monitoreo/_filtroEstacion',
            {               
                nombre: $("#tb_nombre_filter").val(),
                pais:spais,
                rio:srio,
                cuenca:scuenca                
            },
    function (data) {
        $("#cargando").hide();
        $("#estacion_lista_estacion").html('');
        $("#estacion_lista_estacion").html(data);
    });
}