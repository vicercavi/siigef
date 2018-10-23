$(document).on('change', 'input', function() 
{
    if ($(this).attr("type") == "checkbox") 
    {
        var tipo = $(this).attr("id").split('_')[1];
        if (this.checked) 
        {
            //Para las Capas
            if (tipo == "layerwms") 
            {
                var padre = this.parentElement;
                var nombre = $(padre).find("#hd_layern_" + $(this).attr("id").split('_')[2]).val();
                var url = $(padre).find("#hd_layer_" + $(this).attr("id").split('_')[2]).val();
                var urlb = $(padre).find("#hd_layerb_" + $(this).attr("id").split('_')[2]).val();
                var ids = $(this).attr("id").split('_');
                if (url != "") 
                {
                    addOverlayGestor(url, urlb, ids[1] + ids[2], $(this).attr("titulo"));
                } 
                else 
                {
                    AddWMS(urlb, nombre, ids[1] + ids[2], $(this).attr("titulo"));
                }
            }else
            if (tipo == "layerkml") 
            {
                var padre = this.parentElement;
                var url = $(padre).find("#hd_layerKML_" + $(this).attr("id").split('_')[2]).val();
                 var ids = $(this).attr("id").split('_');
                add_kml_google( ids[1] + ids[2], url)
            }else
             if (tipo == "layergeorss") 
            {
                var padre = this.parentElement;
                var url = $(padre).find("#hd_layer_" + $(this).attr("id").split('_')[2]).val();
                 var ids = $(this).attr("id").split('_');
                add_kml_google( ids[1] + ids[2], url);
            }else
             if (tipo == "layergeojson") 
            {
                var padre = this.parentElement;
                var url = $(padre).find("#hd_layer_" + $(this).attr("id").split('_')[2]).val();
                 var ids = $(this).attr("id").split('_');
                load_GeoJson_google(ids[1] + ids[2], url);
            }
            else if (tipo == "layeredit") 
            {
                var padre = this.parentElement;
                var urlbase = $("#lb_urlbase").html();
                var nombrecapa = $(padre).find("#hd_layeredit_" + $(this).attr("id").split('_')[2]).val();
                AddWMS(urlbase, nombrecapa, ($(this).attr("id").split('_')[1] + $(this).attr("id").split('_')[2]), "Ver WMS");
            }
        } 
        else 
        {
            if (tipo == "layerwms") 
            {
                var padre = this.parentElement;
                var nombre = $(padre).find("#hd_layern_" + $(this).attr("id").split('_')[2]).val();
                var url = $(padre).find("#hd_layer_" + $(this).attr("id").split('_')[2]).val();
                var urlb = $(padre).find("#hd_layerb_" + $(this).attr("id").split('_')[2]).val();
                var ids = $(this).attr("id").split('_');
                if (url != "") 
                {
                    RemoveWMS(url);
                } 
                else 
                {
                    RemoveWMS(ids[1]+ids[2]);
                }

            }else  if (tipo == "layerkml") {
                  var padre = this.parentElement;               
                 var ids = $(this).attr("id").split('_');
                RemoveKML( ids[1] + ids[2]);
            }else  if (tipo == "layergeorss") {
                  var padre = this.parentElement;               
                 var ids = $(this).attr("id").split('_');
                RemoveKML( ids[1] + ids[2]);
            }else  if (tipo == "layergeojson") {
                  var padre = this.parentElement;               
                 var ids = $(this).attr("id").split('_');
                RemoveJSON( ids[1] + ids[2]);
            }
            else
            if (tipo == "layeredit") 
            {
                var padre = this.parentElement;
                var urlbase = $("#lb_urlbase").html();
                var nombrecapa = $(padre).find("#hd_layeredit_" + $(this).attr("id").split('_')[2]).val();
                RemoveWMS(($(this).attr("id").split('_')[1] + $(this).attr("id").split('_')[2]));
            }
            else 
            {
                try 
                {
                    removeOverlayGestor($(this).attr("id"));
                } 
                catch (e) 
                {
                    /////OJOJJOJOJOJO
                }
            }
        }
        if (tipo == "pais") 
        {
            CargarDatosPaisSeleccionados();
        }
        else if (tipo == "parametros") 
        {
            CargarPuntosMonitoreo();
        }
        else if (tipo == "allpuntos") 
        {
            puntos("", "");
            ;
        } 
        else if (tipo == "especie")
        {
            CargarPuntosEspecie();
        } 
        else if (tipo == "estructurah") 
        {
            if ($(this).attr("tabla") == "monitoreo_calidad_agua") 
            {
                CargarPuntosMonitoreo2();
            } 
            else if ($(this).attr("tabla") == "darwin") 
            {
                CargarPuntosEspecie();
            }
            else
            {
                CargarPuntosEstandarGenerico();
            }
        }
    }

    if ($(this).attr("type") == "radio") 
    {
        var tipo = $(this).attr("id").split('_')[1];
        if (this.checked) 
        {
            //Para las Capas
            if (tipo == "layerwms") 
            {
                var padre = this.parentElement;
                var nombre = $(padre).find("#hd_layern_" + $(this).attr("id").split('_')[2]).val();
                var url = $(padre).find("#hd_layer_" + $(this).attr("id").split('_')[2]).val();
                var urlb = $(padre).find("#hd_layerb_" + $(this).attr("id").split('_')[2]).val();
                var ids = $(this).attr("id").split('_');
                if (url != "") 
                {
                    addOverlayGestor(url, urlb, ids[1] + ids[2], $(this).attr("titulo"));
                } 
                else 
                {
                    AddWMS(urlb, nombre, ids[1] + ids[2], $(this).attr("titulo"));
                }
            }
            if (tipo == "layerKML") 
            {
                var padre = this.parentElement;
                var url = $(padre).find("#hd_layerKML_" + $(this).attr("id").split('_')[2]).val();
                verkml(url);
            }
            else if (tipo == "layeredit") 
            {
                if($(this).attr("data")=='edit'){
                    removeOverlay();
                }
                var padre = this.parentElement;
                var urlbase = $("#lb_urlbase_editar").html();
                var nombrecapa = $(padre).find("#hd_layeredit_editar_" + $(this).attr("id").split('_')[2]).val();
                AddWMS(urlbase, nombrecapa, ($(this).attr("id").split('_')[1] + $(this).attr("id").split('_')[2]), "Ver WMS");
            }
        } 
        else 
        {
            if (tipo == "layerwms") 
            {
                var padre = this.parentElement;
                var nombre = $(padre).find("#hd_layern_" + $(this).attr("id").split('_')[2]).val();
                var url = $(padre).find("#hd_layer_" + $(this).attr("id").split('_')[2]).val();
                var urlb = $(padre).find("#hd_layerb_" + $(this).attr("id").split('_')[2]).val();
                var ids = $(this).attr("id").split('_');
                if (url != "") 
                {
                    RemoveWMS(url);
                } 
                else 
                {
                    RemoveWMS(ids[1]+ids[2]);
                }

            } 
            else
            if (tipo == "layeredit") 
            {
                var padre = this.parentElement;
                var urlbase = $("#lb_urlbase").html();
                var nombrecapa = $(padre).find("#hd_layeredit_" + $(this).attr("id").split('_')[2]).val();
                RemoveWMS(($(this).attr("id").split('_')[1] + $(this).attr("id").split('_')[2]));
            }
            else 
            {
                try 
                {
                    removeOverlayGestor($(this).attr("id"));
                } 
                catch (e) 
                {
                    /////OJOJJOJOJOJO
                }
            }
        }
        if (tipo == "pais") 
        {
            CargarDatosPaisSeleccionados();
        }
        else if (tipo == "parametros") 
        {
            CargarPuntosMonitoreo();
        }
        else if (tipo == "allpuntos") 
        {
            puntos("", "");
            ;
        } 
        else if (tipo == "especie")
        {
            CargarPuntosEspecie();
        } 
        else if (tipo == "estructurah") 
        {
            if ($(this).attr("tabla") == "monitoreo_calidad_agua") 
            {
                CargarPuntosMonitoreo2();
            } 
            else if ($(this).attr("tabla") == "darwin") 
            {
                CargarPuntosEspecie();
            }
            else
            {
                CargarPuntosEstandarGenerico();
            }
        }
    }

    if ($(this).attr("type") == "range") 
    {
        var tipo = $(this).attr("id").split('_')[1];
        if (tipo == "layeredit") 
        {
            var padre = (this.parentElement).parentElement;
            var nombrecapa = $(padre).find("#hd_layeredit_" + $(this).attr("id").split('_')[2]).val();
            if ($(padre).find("input:checkbox").is(':checked')) 
            {
                Transparencia(($(this).attr("id").split('_')[1] + $(this).attr("id").split('_')[2]), ($(this).val() / 100));
            }
        }
        if (tipo == "layerwms") 
        {
            var padre = ((this.parentElement).parentElement).parentElement;
            var nombre = $(padre).find("#hd_layern_" + $(this).attr("id").split('_')[2]).val();
            var url = $(padre).find("#hd_layer_" + $(this).attr("id").split('_')[2]).val();
            var urlb = $(padre).find("#hd_layerb_" + $(this).attr("id").split('_')[2]).val();

            if ($(padre).find("input:checkbox").is(':checked')) 
            {
                if (url != "") 
                {
                    Transparencia(url, ($(this).val() / 100));
                } 
                else 
                {
                    Transparencia(($(this).attr("id").split('_')[1] + $(this).attr("id").split('_')[2]), ($(this).val() / 100));
                }
            }
        }
    }

});

$(document).ready(function() 
{
   

    $('body').on('click', '.mostraLeyenda', function() {
        //  var padre = this.parentElement;
        var leyenda = $(this).find("#dato-leyenda");
        var leyendas = $("#item-leyenda");
        if (!$(leyendas).find("#" + $(($.parseHTML($(leyenda).html()))[1]).attr("id")).length) {
            $(leyendas).append($(leyenda).html());
        } else {
            $(leyendas).find("#" + $(($.parseHTML($(leyenda).html()))[1]).attr("id")).show();
        }
        mostrarLeyenda();
    });

    $('body').on('click', '.closeleyenda', function() {
        var effect = $(this).data('effect');
        $(this).closest('.panel')[effect]();
    })

    /*Patra los Check*/
    $('label.tree-toggler').parent().children('ul.tree').toggle(300);
    $("#bt_vistaprevia").click(function() {
        
        var urlcompleto = ConstruirUrlCapa();
        $("#hd_url_capa").val(urlcompleto);
        addOverlayGestor(urlcompleto, "WMS", "Mostrar WMS");

    });
    $("#cmb_layer").change(function() {
        var op = $("#cb_layer option:selected").val();
        removeOverlay();
        SetCapaWMS(op);
        addOverlay();
    });



    $("#cmb_srs").change(function() {
        var op = $("#cmb_srs option:selected").val();
        $("#tb_srs").val(op)
    });


  
    //Para Mostrar los Puntos de Monitoreo
    $("#bt_mostrar").click(function() {
        CargarPuntosMonitoreo();
    });

    //Para Mostrar Los Datos por Pais
    $("#bt_mostrar_par").click(function() {
        CargarDatosPaisSeleccionados();
    });

    //Para el acordeon 
    $('#acordeon_didesweb .contenido_acordeon').not('.menues.desplegado + .contenido_acordeon').hide();

    $('#acordeon_didesweb .menues').click(function() {
        if ($(this).hasClass('desplegado')) {
            $(this).removeClass('desplegado');
            $(this).next().slideUp();
        } else {
            $('#acordeon_didesweb .menues').removeClass('desplegado');
            $(this).addClass('desplegado');
            //$('#acordeon_didesweb .contenido_acordeon').slideUp();
            $(this).next().slideDown();
        }
    });

    //Para Editar Texto
    $(".edittext").click(function() {
        $(this).hide();
        $("<input id='edittext' type='text' class='text' value='" + $(this).html() + "'>").insertAfter($($(this).parent().children()[1]));
        var edit = $("#edittext");
        edit.focus();
        edit.focusout(function() {
            var span = $($(this).parent().children()[1]);
            span.html($(this).val());
            $(this).remove();
            span.show();

        });
    });

    //Subir imagen temporal.
    $("#fl_leyenda").change(function() {
        uploadAjaxImagen("leyenda");
    });

    $("#fl_imagenprev").change(function() {
        uploadAjaxImagen("imagenprev");
    });
    $('body').on('click', 'label.tree-toggler', function() {
        $(this).parent().find('ul.tree').toggle(300);
    });
    //$(".sp_asignar_capa_vm").click(function() {
    //   asignaciondecapa(this);
    // });
    $('body').on('click', '.sp_asignar_capa_vm', function() {
        asignaciondecapa(this);
    });
    var asignaciondecapa = function(objeto) {
        var idpais = $($($($(objeto).parent()).parent()).find("select")).val();
        asignarcapa($("#hd_id_jerarquia").val(), idpais, $(objeto).attr("capa"));

    };
    $('body').on('click', '.sp_quitar_capa_vm', function() {
        quitarcapa($("#hd_id_jerarquia").val(), $(this).attr("capa"));
    });

    $('body').on('click', '.sp_quitar_capa_av', function() {
        quitarcapa($("#hd_idpadre").val(), $(this).attr("capa"));
    });
    $('body').on('click', '.sp_asignar_capa_av', function() {
        asignarcapa($("#hd_idpadre").val(), $(this).attr("capa"));
    });
    $('body').on('click', '.sp_quitar_jerarquia_av', function() {
        quitarcapa_jerarquia($(this).attr("jerarquia"));
    });
    $('body').on('click', '.sp_quitar_jerarquia_vm', function() {
        quitarcapa_jerarquia($(this).attr("jerarquia"));
    });
});
