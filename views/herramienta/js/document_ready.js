var _post = null;
var inicio = 0;
$(document).ready(function () {
//  $('#lista-recurso').bootstrapTable();
//  $('#lista-recurso').bootstrapTable('destroy');
    $('body').on('click', '.pagina', function () {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    var paginacion = function (pagina, nombrelista, datos) {
        var pagina = 'pagina=' + pagina;
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _post = $.post(_root_ + 'herramienta/_paginacion_' + nombrelista + '/' + datos, pagina, function (data) {
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }

    $('body').on('click', '#bt_nueva_estructura', function () {
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        po_postst = $.post(_root_ + 'herramienta/_nuevaEstructura', function (data) {
            $("#nueva_estructura").html('');
            $("#nueva_estructura").html(data);
        });
    });
    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.danger').attr('her', $(e.relatedTarget).data('her'));
          $(this).find('.danger').attr('pad', $(e.relatedTarget).data('pad'));
            $(this).find('.danger').attr('est', $(e.relatedTarget).data('est'));

        $('.nombre-es').html($(e.relatedTarget).data('nombre'));
    })

    $('body').on('click', '.deletee', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        _post = $.post(_root_ + 'herramienta/_eliminarEstructura', {
            idherramienta: $(this).attr("her"),
            idpadre: $(this).attr("pad"),
            idestructura: $(this).attr("est")
        }, function (data) {
            $("#cargando").hide();
            $("#estructura_lista_estructura").html('');
            $("#estructura_lista_estructura").html(data);
        });
    });
    $('body').on('change', '#sl_estandar_recurso', function () {
        $("#cargando").show();
        var optionSelected = $(this).find("option:selected");
        var valueSelected = optionSelected.val();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _post = $.post(_root_ + 'herramienta/_listarRecursosDisponibleXEstandar', {
            idEstandar: valueSelected,
            idestructura: $("#hd_id_padre_estructura").val()
        }, function (data) {
            $("#cargando").hide();
            $("#tb_buscar_rd_filter").val("");
            $("#estructura_lista_recursos_disponibles").html('');
            $("#estructura_lista_recursos_disponibles").html(data);
        });
    });
    $('body').on('click', '.asignar_recurso', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _post = $.post(_root_ + 'herramienta/_asignarRecurso', {
            idrecurso: $(this).attr("recurso"),
            idestructura: $(this).attr("estructura")
        }, function (data) {
            $("#cargando").hide();
            $("#tb_buscar_rd_filter").val("");
            $("#tb_buscar_ra_filter").val("");
            $("#estructura_gestor_recurso").html('');
            $("#estructura_gestor_recurso").html(data);
        });
    });
    $('body').on('click', '.quitar_recurso', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _post = $.post(_root_ + 'herramienta/_quitarRecurso', {
            idrecurso: $(this).attr("recurso"),
            idestructura: $(this).attr("estructura")
        }, function (data) {
            $("#cargando").hide();
            $("#tb_buscar_rd_filter").val("");
            $("#tb_buscar_ra_filter").val("");
            $("#estructura_gestor_recurso").html('');
            $("#estructura_gestor_recurso").html(data);
        });
    });
    $('body').on('click', '#bt_buscar_filter', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _post = $.post(_root_ + 'herramienta/_buscarHerramienta', {
            busqueda: $("#tb_buscar_filter").val()
        }, function (data) {
            $("#cargando").hide();
            $("#index_lista_herramienta").html('');
            $("#index_lista_herramienta").html(data);
        });
    });
    $('body').on('click', '#bt_buscar_estructura_filter', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _post = $.post(_root_ + 'herramienta/_buscarEstructura', {
            busqueda: $("#tb_buscar_filter").val(),
            idherramienta: $("#hd_id_herramienta").val(),
            idpadre: $("#hd_id_padre_estructura").val()
        }, function (data) {
            $("#cargando").hide();
            $("#estructura_lista_estructura").html('');
            $("#estructura_lista_estructura").html(data);
        });
    });
    $('body').on('click', '#bt_buscar_rd_filter', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _post = $.post(_root_ + 'herramienta/_buscarRecursosDisponibles', {
            busqueda: $("#tb_buscar_rd_filter").val(),
            estandar: $("#sl_estandar_recurso option:selected").val(),
            idestructura: $("#hd_id_padre_estructura").val()

        }, function (data) {
            $("#cargando").hide();
            $("#estructura_lista_recursos_disponibles").html('');
            $("#estructura_lista_recursos_disponibles").html(data);
        });
    });
    $('body').on('click', '#bt_buscar_ra_filter', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _post = $.post(_root_ + 'herramienta/_buscarRecursosAsignados', {
            busqueda: $("#tb_buscar_ra_filter").val(),
            idestructura: $("#hd_id_padre_estructura").val()

        }, function (data) {
            $("#cargando").hide();
            $("#estructura_lista_recursos_asignados").html('');
            $("#estructura_lista_recursos_asignados").html(data);
        });
    });
    $('body').on('click', '.estado-herramienta', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _post = $.post(_root_ + 'herramienta/_actualizarEstadoHerramienta', {
            busqueda: $("#tb_buscar_filter").val(),
            idherramienta: $(this).attr("herramienta"),
            estado: $(this).attr("estado")
        }, function (data) {
            $("#cargando").hide();
            $("#index_lista_herramienta").html('');
            $("#index_lista_herramienta").html(data);
        });
    });
    $('body').on('click', '.estado-estructura', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _post = $.post(_root_ + 'herramienta/_actualizarEstadoEstructura', {
            pagina: $(".pagination .active span").html(),
            busqueda: $("#tb_buscar_filter").val(),
            idherramienta: $("#hd_id_herramienta").val(),
            idpadre: $("#hd_id_padre_estructura").val(),
            idestructura: $(this).attr("estructura"),
            estado: $(this).attr("estado")
        }, function (data) {
            $("#cargando").hide();
            $("#estructura_lista_estructura").html('');
            $("#estructura_lista_estructura").html(data);
        });
    });
    $('body').on('click', '.item-visor', function () {
        hijo = $("#visor_hijo_estructura_" + $(this).attr("estructura"));
        if ($.trim($(hijo).html()) == "") {
            $("#cargando").show();
            if (_post && _post.readyState != 4) {
                _post.abort();
            }
            _post = $.post(_root_ + 'herramienta/_listarHijoArbolEstructuraH', {
                estructura: $(this).attr("estructura"),
                herramienta: $("#hd_id_visor").val()
            }, function (data) {
                $("#cargando").hide();
                $(hijo).html(data);
            });
        }
    });
    $('body').on('click', '#bt_buscar_especie', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _post = $.post(_root_ + 'herramienta/_buscarEspecie', {
            busqueda: $("#tb_buscar_especie").val(),
            idherramienta: $("#hd_id_visor").val()
        }, function (data) {
            $("#cargando").hide();
            $("#visor_hijo_estructura_356").html('');
            if ($.trim(data) != "") {
                $("#visor_hijo_estructura_356").html(data);
            } else {
                $("#visor_hijo_estructura_356").html("No se encontraron resultados");
            }
        });
    });
    $('body').on('click', '#bt_cancelar_especie', function () {

        $("#visor_hijo_estructura_356").html('');
        $("#tb_buscar_especie").val("");
    });
    $('body').on('click', '.idioma-herramienta', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        _post = $.post(_root_ + 'herramienta/_getTraduccionHerramienta', {
            idIdioma: $(this).val(),
            idIdiomaO: $("#hd_idioma_defecto").val(),
            idherramienta: $("#hd_herramienta").val()
        }, function (data) {
            $("#cargando").hide();
            $("#index_nueva_herramienta").html('');
            $("#index_nueva_herramienta").html(data);
        });
    });
    $('body').on('click', '.idioma-estructurah', function () {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        _post = $.post(_root_ + 'herramienta/_getTraduccionEstructura', {
            idIdioma: $(this).val(),
            idIdiomaO: $("#hd_idioma_defecto").val(),
            idestructura: $("#hd_id_padre_estructura").val()
        }, function (data) {
            $("#cargando").hide();
            $("#index_nueva_estructura").html('');
            $("#index_nueva_estructura").html(data);
        });
    });
    $('body').on('click', '#ver-recursos', function () {
        $('#lista-recurso').bootstrapTable();
    });
}
);
function CargarEHPredeterminado() {

    $.each(eh_predeterminado, function (index, estructura) {

        if (estructura.recurso.length > 0 && estructura.recurso[0].Tir_IdTipoRecurso == 2) {
            var id = "layer" + estructura.recurso[0].capas[0].tic_Nombre + "" + estructura.Esh_IdEstructuraHerramienta;
            var nombre = estructura.recurso[0].capas[0].Cap_Nombre;
            var url = estructura.recurso[0].capas[0].Cap_UrlCapa;
            var urlb = estructura.recurso[0].capas[0].Cap_UrlBase;
            if (estructura.recurso[0].capas[0].tic_Nombre == "wms") {
                if (url != null && url != "") {
                    addOverlayGestor(url, id, estructura.recurso[0].capas[0].Cap_Titulo);
                } else {
                    AddWMS(urlb, nombre, id, estructura.recurso[0].capas[0].Cap_Titulo);
                }
            }else if(estructura.recurso[0].capas[0].tic_Nombre == "kml"){
                  add_kml_google( id, url); 
            }else if(estructura.recurso[0].capas[0].tic_Nombre == "georss"){
                  add_kml_google( id, url);
            }else if(estructura.recurso[0].capas[0].tic_Nombre == "geojson"){
                  load_GeoJson_google(id, url);
            }
        }
    });
}
function starBitacora() {

    inicio = window.performance.now();
}
function endBitacora(herramienta, metodo, parametros) {
    var fin = window.performance.now();
    var tiempo = fin - inicio;
    tiempo = tiempo / 1000;

    $.post(_root_ + 'herramienta/_registroBitacoraHerramienta', {
        idherramineta: herramienta,
        nmetodo: metodo,
        lparametros: parametros,
        ntiempo: '' + tiempo
    }, function (data) {

    });
}


       