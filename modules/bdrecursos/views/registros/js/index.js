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
        _post = $.post(_root_ + 'bdrecursos/registros/_paginacion_' + nombrelista + '/' + datos,
                {
                    pagina: pagina,
                    nombre: $("#palabraVariable").val()
                }, function(data) {                    
            $("#cargando").hide();
            $("#" + nombrelista).html('');
            $("#" + nombrelista).html(data);
        });
    }   

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
        
        _post = $.post(_root_ + 'bdrecursos/registros/_buscarRecursoEstandar',
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
        _post = $.post(_root_ + 'bdrecursos/registros/_buscarVariableEstandar',
                {                 
                    nombre: $("#palabraVariable").val(),
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
        
        _post = $.post(_root_ + 'bdrecursos/registros/_buscarCalidadAgua',
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
        
        _post = $.post(_root_ + 'bdrecursos/registros/_buscarLegislacion',
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
        
        _post = $.post(_root_ + 'bdrecursos/registros/_buscarDublincore',
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
        
        _post = $.post(_root_ + 'bdrecursos/registros/_buscarPlinianCore',
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
        
        _post = $.post(_root_ + 'bdrecursos/registros/_buscarDarwinCore',
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
        
        _post = $.post(_root_ + 'bdrecursos/registros/_cambiarEstadoCalidadAgua',
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
        
        _post = $.post(_root_ + 'bdrecursos/registros/_cambiarEstadoLegislacion',
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
        
        _post = $.post(_root_ + 'bdrecursos/registros/_cambiarEstadoDublin',
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
        
        _post = $.post(_root_ + 'bdrecursos/registros/_cambiarEstadoPlinian',
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
        
        _post = $.post(_root_ + 'bdrecursos/registros/_cambiarEstadoDarwin',
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
        
        _post = $.post(_root_ + 'bdrecursos/registros/_cambiarEstado',
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
    $("body").on('click', ".ce_estandar2", function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/registros/_cambiarEstadoVariable',
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
            $("#listaregistrosVariable").html('');
            $("#listaregistrosVariable").html(data);
        });
    });

    $("body").on('click', ".ce_estandar3", function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/registros/_cambiarEstadoData',
                {                 
                    nombre_tabla:$(this).attr("nombre_tabla"),
                    valor_estado:$(this).attr("estado_estandar"),
                    columna_estado:$(this).attr("columna_estado"),
                    valor_id:$(this).attr("valor_id"),
                    pagina: $(".pagination .active span").html(),
                    nombre: $("#tb_nombre_filter_data").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#listaregistrosData").html('');
            $("#listaregistrosData").html(data);
        });
    });

    $("body").on('click', ".ce_data", function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }
        
        _post = $.post(_root_ + 'bdrecursos/registros/_cambiarEstadoData',
                {                 
                    nombre_tabla:$(this).attr("nombre_tabla"),
                    valor_estado:$(this).attr("estado_estandar"),
                    campo_estado:$(this).attr("campo_estado"),
                    valor_id:$(this).attr("valor_id"),
                    pagina: $(".pagination .active span").html(),
                    nombre: $("#tb_nombre_filter_data").val(),
                    id_recurso:$("#hd_id_recurso").val()
                },
        function(data) {
            $("#cargando").hide();
            $("#listaregistrosData").html('');
            $("#listaregistrosData").html(data);
        });
    });
    //---------------eliminar recurso

    $("body").on('click', '.eliminar_calidadagua', function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }   

        _post = $.post(_root_ + 'bdrecursos/registros/_eliminarCalidadAgua',
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

        _post = $.post(_root_ + 'bdrecursos/registros/_eliminarLegislacion',
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

        _post = $.post(_root_ + 'bdrecursos/registros/_eliminarDublincore',
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

        _post = $.post(_root_ + 'bdrecursos/registros/_eliminarPlinian',
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

        _post = $.post(_root_ + 'bdrecursos/registros/_eliminarDarwinCore',
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

        _post = $.post(_root_ + 'bdrecursos/registros/_eliminarEstandarxRecurso',
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

    $("body").on('click', '.eliminar_estandar2', function() {
        
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }   

        _post = $.post(_root_ + 'bdrecursos/registros/_eliminarEstandarxRecursoVariable',
                {
                    pagina: $(".pagination .active span").html(),
                    id_recurso_estandar: $(this).attr("idrecursoestandar"),
                    valor_id: $(this).attr("valorid"),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                  
                },
        function(data) {
            $("#cargando").hide();
            $("#listaregistrosVariable").html('');
            $("#listaregistrosVariable").html(data);
        });
    });

    $("body").on('click', '.eliminar_data', function() {
        $("#cargando").show();
        if (_post && _post.readyState != 4) {
            _post.abort();
        }   

        _post = $.post(_root_ + 'bdrecursos/registros/_eliminarEstandarxRecursoData',
                {
                    pagina: $(".pagination .active span").html(),
                    nombre_tabla:$(this).attr("nombretabla"),
                    valor_id: $(this).attr("valorid"),
                    nombre: $("#tb_nombre_filter").val(),
                    id_recurso:$("#hd_id_recurso").val()
                  
                },
        function(data) {
            $("#cargando").hide();
            $("#listaregistrosData").html('');
            $("#listaregistrosData").html(data);
        });
    });
    
    $('#confirm-delete').on('show.bs.modal', function (e) {
        
        $(this).find('.danger').attr('id', $(e.relatedTarget).data('id'));
        $('.nombre-es').html($(e.relatedTarget).data('nombre'));
    });

    $('#eliminar_estandar').on('show.bs.modal', function (e) {
        
        $(this).find('.danger').attr('idrecursoestandar', $(e.relatedTarget).data('idrecursoestandar'));
        $(this).find('.danger').attr('nombretabla', $(e.relatedTarget).data('nombretabla'));
        $(this).find('.danger').attr('valorid', $(e.relatedTarget).data('valorid'));
        //$('.nombre-es').html($(e.relatedTarget).data('nombre'));
    });
    
    
});

