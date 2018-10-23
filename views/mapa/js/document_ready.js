_post = null;
$(document).ready(function () {
    $('body').on('click', '.pagina', function () {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    var paginacion = function (pagina, nombrelista, datos) {
        var pagina = 'pagina=' + pagina;
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _post = $.post(_root_ + 'mapa/_paginacion_' + nombrelista + '/' + datos, pagina, function (data) {
            $("#cargando").hide();
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }
     $('body').on('click', '.leyenda', function() 
    {
        //  var padre = this.parentElement;
        var padre = (this.parentElement).parentElement;
        var url = $("#lb_urlbase").html();
        var img = "<img src='" + getLeyenda(url, $(this).attr("layer")) + "'/>"
        $("#img_layeredit_" + $(this).attr("id").split('_')[2]).html(img);
    });
    $('body').on('click', '#sp_load_capa', function () {
        var url = $("#urlbase").val();
        var capa=$('.cb_layer:checked').val();
        
        if(typeof url === 'undefined' || url === null )
            url=$("#urlbase").html();
        if(typeof capa === 'undefined' || capa === null )
            capa=$("#cmb_layer option:selected").val();
        
        if(!(typeof capa === 'undefined' || capa === null)&&!(typeof url === 'undefined' || url === null))
            $("#tb_leyendaurl").val(getLeyenda(url,capa));
        
    });
    $('body').on('click', '#bt_buscar_filter', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _post = $.post(_root_ + 'mapa/_buscarCapa', {
            busqueda: $("#tb_buscar_filter").val()
        }, function (data) {
            $("#cargando").hide();
            $("#gestorcapa_lista_capas").html('');
            $("#gestorcapa_lista_capas").html(data);
        });
    });

    $("body").on('click', '.estado-capa', function() {
        cambiar_estado($(this).attr("idcapa"),$(this).attr("estado"));
    });

    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.danger').attr('capa', $(e.relatedTarget).data('href'));

        $('.nombre-capa').html($(e.relatedTarget).data('nombre'));
    })
    $('body').on('click', '.delete', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        _post = $.post(_root_ + 'mapa/_eliminarCapa', {
            idcapa: $(this).attr("capa"),
            busqueda: $("#tb_buscar_filter").val()
        }, function (data) {
            try {
                var dato = JSON.parse(data);
                mensaje(dato);
            }
            catch (err) {
                $("#gestorcapa_lista_capas").html('');
                $("#gestorcapa_lista_capas").html(data);
                 mensaje([["ok","Operación ejecutada con éxito"]]);
            }
            $("#cargando").hide();

        });
    });
    
     
      $("#bt_guardar_wms").click(function() {
        insertarcapawms();
    });
    $("#bt_guardar_kml").click(function() {
        insertarcapakml();
    });
    $("#bt_guardar_rss").click(function() {
        insertarcaparss();
    });
    $("#bt_guardar_json").click(function() {
        insertarcapajson();
    });
    $(".tab_json").click(function(){
        $('#hd_tipo_json').val($(this).attr("tipo"));        
    });

  
}
);

function cambiar_estado(id,estado) 
{
    $("#cargando").show();
    
    if (_post && _post.readyState != 4) 
    {
        _post.abort();
    }
    
    _post = $.post(_root_ + 'mapa/_cambiarEstadoCapa',
            {
                pagina: $(".pagination .active span").html(),
                idcapa: id,
                estado: estado,
                busqueda: $("#tb_buscar_filter").val()
            },
    function(data,estaus,xrh) {//cuando llamo a la funcion _cambiarEstado me 
        $("#cargando").hide();
        $("#gestorcapa_lista_capas").html('');
        $("#gestorcapa_lista_capas").html(data);
    });
}
