var _post = null;
$(document).on('ready', function() {
    $('#form1').validator().on('submit', function(e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...

        } else {
            // everything looks good!
//        guardarUsuario($("#nombre").val(),$("#apellidos").val(),$("#dni").val(),$("#direccion").val(),
//                $("#telefono").val(),$("#institucion").val(),$("#cargo").val(),
//                $("#correo").val(),$("#usuario").val(),$("#contrasena").val(),$("#confirmarContrasena").val());
        }
    });
    $('body').on('click', '.pagina', function() {
        paginacion($(this).attr("pagina"), $(this).attr("nombre"), $(this).attr("parametros"));
    });
    
    var paginacion = function(pagina, nombrelista, datos) 
    {
        $("#cargando").show();

        _tipo = $(".active2 span").attr("recurso");
        if (_tipo === undefined) {
            _tipo = "";
        }

        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        _post = $.post(_root_ + 'bdrecursos/index/_paginacion_' + nombrelista + '/' + datos,
                {
                    pagina: pagina,
                    tipo: _tipo,
                    nombre: $("#tb_nombre_filter").val(),
                    estandar: $("#sl_estandar_recurso_filtro").val(),
                    fuente: $("#sl_fuente_filtro").val(),
                    origen: $("#sl_origen_filtro").val(),
                    herramienta: $("#sl_herramienta_filtro").val()

                }, function(data) {
            $("#cargando").hide();
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }

    $("body").on('click', '.tiporecurso', function() {
        paginacion(1, "lista_recursos", $(this).attr("recurso"));
    });

    $("body").on('click', '.estado-recurso', function() {

        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _tipo = $(".active2 span").attr("recurso");
        if (_tipo === undefined) {
            _tipo = "";
        }

        _post = $.post(_root_ + 'bdrecursos/index/_actualizarEstado',
                {
                    pagina: $(".pagination .active span").html(),
                    tipo: _tipo,
                    nombre: $("#tb_nombre_filter").val(),
                    estandar: $("#sl_estandar_recurso_filtro").val(),
                    fuente: $("#sl_fuente_filtro").val(),
                    origen: $("#sl_origen_filtro").val(),
                    herramienta: $("#sl_herramienta_filtro").val(),
                    idrecurso: $(this).attr("recurso"),
                    estado: $(this).attr("estado")
                },
        function(data) {
            $("#cargando").hide();
            $("#lista_recursos").html('');
            $("#lista_recursos").html(data);
        });
    });
    $("body").on('click', ".tipo_recurso a", function() {
        $(".tipo_recurso").removeClass("active2");
        $($($(this).parent()).parent()).addClass("active2");
    });

    var filtroRecurso = function() {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _tipo = $(".active2 span").attr("recurso");
        if (_tipo === undefined) {
            _tipo = "";
        }

        _post = $.post(_root_ + 'bdrecursos/index/_filtroRecursos',
                {
                    tipo: _tipo,
                    nombre: $("#tb_nombre_filter").val(),
                    estandar: $("#sl_estandar_recurso_filtro").val(),
                    fuente: $("#sl_fuente_filtro").val(),
                    origen: $("#sl_origen_filtro").val(),
                    herramienta: $("#sl_herramienta_filtro").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#lista_recursos").html('');
            $("#lista_recursos").html(data);
        });
    }

    $("body").on('click', "#bt_buscar_filter", function() {
        filtroRecurso();
    });
    $("body").on('change', "#sl_fuente_filtro", function() {
        filtroRecurso();
    });
    $("body").on('change', "#sl_estandar_recurso_filtro", function() {
        filtroRecurso();
    });
    $("body").on('change', "#sl_origen_filtro", function() {
        filtroRecurso();
    });
    $("body").on('change', "#sl_herramienta_filtro", function() {
        filtroRecurso();
    });

    $("body").on('click', '.eliminar_recurso', function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }

        _tipo = $(".active2 span").attr("recurso");
        if (_tipo === undefined) {
            _tipo = "";
        }

        _post = $.post(_root_ + 'bdrecursos/index/_eliminarRecurso',
                {
                    pagina: $(".pagination .active span").html(),
                    tipo: _tipo,
                    nombre: $("#tb_nombre_filter").val(),
                    estandar: $("#sl_estandar_recurso_filtro").val(),
                    fuente: $("#sl_fuente_filtro").val(),
                    origen: $("#sl_origen_filtro").val(),
                    herramienta: $("#sl_herramienta_filtro").val(),
                    idrecurso: $(this).attr("id")                    
                },
        function(data) {
            $("#cargando").hide();
            $("#lista_recursos").html('');
            $("#lista_recursos").html(data);
        }); 
    });

    $('#confirm-delete').on('show.bs.modal', function (e) 
    {        
        $(this).find('.danger').attr('id', $(e.relatedTarget).data('id'));
        $('.nombre-es').html($(e.relatedTarget).data('nombre'));
    });

    $('body').on('click', '.idioma-recurso', function() {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        _post = $.post(_root_ + 'bdrecursos/index/_getTraduccionRecurso', {
            idIdioma: $(this).val(),
            idIdiomaO: $("#hd_idioma_defecto").val(),
            idrecurso: $("#hd_idrecurso").val()
        }, function(data) {
            $("#cargando").hide();
            $("#index_nuevo_recurso").html('');
            $("#index_nuevo_recurso").html(data);

        });

    });
    
    ///////////////////////////////////////////Registros///////////////////////////////////
    $("body").on('click', "#buscar_recurso", function() {
           $("#cargando").show();
         if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/index/_buscarRecursoEstandar',
                {                 
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#listaregistros").html('');
            $("#listaregistros").html(data);
        });
    });

    $("body").on('click', "#buscarVariable", function() {
           $("#cargando").show();
         if (_post && _post.readyState != 4) {
            _post.abort();
        }        
        _post = $.post(_root_ + 'bdrecursos/index/_buscarVariableEstandar',
                {                 
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#listaregistrosVariable").html('');
            $("#listaregistrosVariable").html(data);
        });
    });

    $("body").on('click', "#bt_buscar_calidadagua", function() {
           $("#cargando").show();
         if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/index/_buscarCalidadAgua',
                {                 
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_calidadagua").html('');
            $("#metadata_lista_calidadagua").html(data);
        });
    });

    $("body").on('click', "#bt_buscar_legislacion", function() {
           $("#cargando").show();
         if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/index/_buscarLegislacion',
                {                 
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_legislacion").html('');
            $("#metadata_lista_legislacion").html(data);
        });
    });

    $("body").on('click', "#bt_buscar_dublin", function() {
           $("#cargando").show();
         if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/index/_buscarDublincore',
                {                 
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_dublin").html('');
            $("#metadata_lista_dublin").html(data);
        });
    });

    $("body").on('click', "#bt_buscar_plinian", function() {
           $("#cargando").show();
         if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/index/_buscarPlinianCore',
                {                 
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_plinian").html('');
            $("#metadata_lista_plinian").html(data);
        });
    });

    $("body").on('click', "#bt_buscar_darwin", function() {
           $("#cargando").show();
         if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/index/_buscarDarwinCore',
                {                 
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_darwin").html('');
            $("#metadata_lista_darwin").html(data);
        });
    });
    //---------------------cambiar estado

    $("body").on('click', ".ce_calidadagua", function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/index/_cambiarEstadoCalidadAgua',
                {                 
                    valor_estado:$(this).attr("estado_mca"),
                    id_mca:$(this).attr("id_mca"),
                    pagina: $(".pagination .active span").html(),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_calidadagua").html('');
            $("#metadata_lista_calidadagua").html(data);
        });
    });

    $("body").on('click', ".ce_legislacion", function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/index/_cambiarEstadoLegislacion',
                {                 
                    valor_estado:$(this).attr("estado_legislacion"),
                    id_legislacion:$(this).attr("id_legislacion"),
                    pagina: $(".pagination .active span").html(),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_legislacion").html('');
            $("#metadata_lista_legislacion").html(data);
        });
    });

    $("body").on('click', ".ce_dublin", function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/index/_cambiarEstadoDublin',
                {                 
                    valor_estado:$(this).attr("estado_dublin"),
                    id_dublin:$(this).attr("id_dublin"),
                    pagina: $(".pagination .active span").html(),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_dublin").html('');
            $("#metadata_lista_dublin").html(data);
        });
    });

    $("body").on('click', ".ce_plinian", function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/index/_cambiarEstadoPlinian',
                {                 
                    valor_estado:$(this).attr("estado_plinian"),
                    id_plinian:$(this).attr("id_plinian"),
                    pagina: $(".pagination .active span").html(),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_plinian").html('');
            $("#metadata_lista_plinian").html(data);
        });
    });

    $("body").on('click', ".ce_darwin", function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/index/_cambiarEstadoDarwin',
                {                 
                    valor_estado:$(this).attr("estado_darwin"),
                    id_darwin:$(this).attr("id_darwin"),
                    pagina: $(".pagination .active span").html(),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_darwin").html('');
            $("#metadata_lista_darwin").html(data);
        });
    });

    $("body").on('click', ".ce_estandar", function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/index/_cambiarEstado',
                {                 
                    nombre_tabla:$(this).attr("nombre_tabla"),
                    valor_estado:$(this).attr("estado_estandar"),
                    columna_estado:$(this).attr("columna_estado"),
                    valor_id:$(this).attr("valor_id"),
                    pagina: $(".pagination .active span").html(),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#listaregistros").html('');
            $("#listaregistros").html(data);
        });
    });
    //---------------eliminar recurso

    $("body").on('click', '.eliminar_calidadagua', function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }   

        _post = $.post(_root_ + 'bdrecursos/index/_eliminarCalidadAgua',
                {
                    pagina: $(".pagination .active span").html(),
                    id_mca: $(this).attr("id"),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                  
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_calidadagua").html('');
            $("#metadata_lista_calidadagua").html(data);
        });
    });
    $("body").on('click', '.eliminar_legislacion', function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }   

        _post = $.post(_root_ + 'bdrecursos/index/_eliminarLegislacion',
                {
                    pagina: $(".pagination .active span").html(),
                    id_legislacion: $(this).attr("id"),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                  
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_legislacion").html('');
            $("#metadata_lista_legislacion").html(data);
        });
    });

    $("body").on('click', '.eliminar_dublin', function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }   

        _post = $.post(_root_ + 'bdrecursos/index/_eliminarDublincore',
                {
                    pagina: $(".pagination .active span").html(),
                    id_dublin: $(this).attr("id"),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                  
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_dublin").html('');
            $("#metadata_lista_dublin").html(data);
        });
    });

    $("body").on('click', '.eliminar_plinian', function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }   

        _post = $.post(_root_ + 'bdrecursos/index/_eliminarPlinian',
                {
                    pagina: $(".pagination .active span").html(),
                    id_plinian: $(this).attr("id"),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                  
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_plinian").html('');
            $("#metadata_lista_plinian").html(data);
        });
    });

    $("body").on('click', '.eliminar_darwin', function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }   

        _post = $.post(_root_ + 'bdrecursos/index/_eliminarDarwinCore',
                {
                    pagina: $(".pagination .active span").html(),
                    id_darwin: $(this).attr("id"),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                  
                },
        function(data) {
            $("#cargando").hide();
            $("#metadata_lista_darwin").html('');
            $("#metadata_lista_darwin").html(data);
        });
    });
    $("body").on('click', '.eliminar_estandar', function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }   

        _post = $.post(_root_ + 'bdrecursos/index/_eliminarEstandarxRecurso',
                {
                    pagina: $(".pagination .active span").html(),
                    id_recurso_estandar: $(this).attr("idrecursoestandar"),
                    valor_id: $(this).attr("valorid"),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                  
                },
        function(data) {
            $("#cargando").hide();
            $("#listaregistros").html('');
            $("#listaregistros").html(data);
        });
    });
    
    $('#confirm-delete').on('show.bs.modal', function (e) {
        
        $(this).find('.danger').attr('id', $(e.relatedTarget).data('id'));
        $('.nombre-es').html($(e.relatedTarget).data('nombre'));
    });

    $('#eliminar_estandar').on('show.bs.modal', function (e) {
        
        $(this).find('.danger').attr('idrecursoestandar', $(e.relatedTarget).data('idrecursoestandar'));
        $(this).find('.danger').attr('valorid', $(e.relatedTarget).data('valorid'));
        //$('.nombre-es').html($(e.relatedTarget).data('nombre'));
    });
});

