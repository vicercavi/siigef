<!DOCTYPE html>
<html lang="es">
    <head>
        <title>{$titulo|default:"Sin t&iacute;tulo"}</title>
        <meta charset="utf-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="robots" content="noindex">
        <link href="{$_layoutParams.ruta_css}bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="{$_layoutParams.ruta_css}bootstrapValidator.css" rel="stylesheet" type="text/css">
        <link href="{$_layoutParams.ruta_css}datepicker.css" rel="stylesheet" type="text/css">   
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">   
        <style type="text/css">
            #form1 .selectContainer .form-control-feedback {
                /* Adjust feedback icon position */
                right: -15px;
            }
        </style>  
        <link rel="shortcut icon" href="{$_layoutParams.ruta_img}favicon.ico" type="image/x-icon" />
        <style type="text/css">
            body{          
                padding-bottom: 90px;            
            }
        </style>
        
        <link href="{$_layoutParams.ruta_css}simple-sidebar.css" rel="stylesheet" type="text/css">
        <link href="{$_layoutParams.ruta_css}jsoft-lage.css" rel="stylesheet" type="text/css">
        <link href="{$_layoutParams.ruta_css}jsoft.css" rel="stylesheet" type="text/css">
        <link href="{$_layoutParams.root_clear}public/css/util.css" rel="stylesheet" type="text/css">         
        <link href="{$_layoutParams.ruta_css}AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="{$_layoutParams.ruta_css}customAdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <link href="{$_layoutParams.root_clear}public/css/util.css" rel="stylesheet" type="text/css"> 
        {if isset($_layoutParams.css) && count($_layoutParams.css)}
            {foreach item=css from=$_layoutParams.css}        
                <link href="{$css}" rel="stylesheet" type="text/css" />        
            {/foreach}
        {/if}
        
    </head>

    <body class="template-content">
        <header>
            <h1 class="col-xs-11 col-sm-6 col-md-5 col-lg-4">
                <a href="{$_layoutParams.root}" title="SISTEMA INTEGRADO DE INFORMACIÓN"><img src="{$_layoutParams.ruta_img}{$lenguaje.imagen_logosii}"></a>
               <!-- <a href="#"><img src="{$_layoutParams.ruta_img}gef.png"></a>-->
            </h1>
            <button type="button" class="navbar-right navbar-toggle collapsed col-xs-1" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
            </button> 
            <div class="col-sm-6 col-md-7 col-lg-8" id="section-content-buscador" >
                <section class="col-xs-12 col-sm-6 col-md-7 col-lg-offset-5 col-lg-5" id="logos-index">         
                    <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="Estado Plurinacional de Bolivia" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=1"><img src="{$_layoutParams.ruta_img}8.png"></a></figure>
                    <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República Federativa del Brasil" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=2"><img src="{$_layoutParams.ruta_img}7.png"></a></figure>
                    <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República de Colombia" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=3"><img src="{$_layoutParams.ruta_img}6.png"></a></figure>
                    <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República del Ecuador" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=4"><img src="{$_layoutParams.ruta_img}5.png"></a></figure>
                    <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República Bolivariana de Venezuela" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=8"><img src="{$_layoutParams.ruta_img}4.png"></a></figure>
                    <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República de Suriname" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=7"><img src="{$_layoutParams.ruta_img}3.png"></a></figure>    
                    <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República del Perú" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=6"><img src="{$_layoutParams.ruta_img}2.png"></a></figure>    
                    <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República Cooperativista de Guyana" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=5"><img src="{$_layoutParams.ruta_img}1.png"></a></figure>    
                </section>
                <section class="col-xs-12 col-sm-6 col-md-5 col-lg-2" id="buscador">
                    <ul class="idiomas">
                        <li><a href="{$_layoutParams.root_clear}index/_loadLang/es">Español</a></li>
                        <li><a href="{$_layoutParams.root_clear}index/_loadLang/en">English</a></li>
                        <li><a href="{$_layoutParams.root_clear}index/_loadLang/pt">Português</a></li>
                    </ul>
                    <form class="navbar-form navbar-right form-horizontal " data-toggle="validator" id="form1" role="form" method="post" autocomplete="on">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <input class="col-xs-1" type="button" id="btnBuscar" name="btnBuscar" onclick="buscarPalabra('textBuscar')" value="" > 
                            <input class = "col-xs-12 col-sm-12 col-lg-12" data-toggle="tooltip" data-placement="bottom" title="Busca en Arquitectura SII, Base de Datos Documentos, Base de Datos Legislacion, Base de Datos Recursos, " type="search" id="textBuscar" name="textBuscar" placeholder="{$lenguaje.text_buscador|default}" value="{$palabra|default:''}" required="required" onkeypress="tecla_enter(event)" >
                           
                        </div>                   
                    </form>                
                </section>
            </div>           

            {if isset($widgets.top)}
                {foreach from=$widgets.top item=wd}
                <div class="collapse navbar-collapse pull-right menu-p" id="navbar-collapse" style="background: rgba(0, 0, 0, 0.61); z-index:100"> 
                    <nav class="top_menu" id="enlaces-header">
                        <ul class="nav navbar-nav" >   
                        {$wd}
                        {if Session::get('autenticado')}
                            <li>
                                <a href="{$_layoutParams.root}acl"  data-toggle="tooltip" data-placement="bottom" title="Intranet"><i style="font-size:15px" class="fa fa-wrench"></i> {$lenguaje.text_intranet}</a>
                            </li>
                            <li>
                                <a href="{$_layoutParams.root}usuarios/login/cerrar"  data-toggle="tooltip" data-placement="bottom" title="Cerrar Sesi&oacute;n"><i style="font-size:15px" class="fa fa-sign-out"></i> {$lenguaje.text_cerrarsession}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#"  data-placement="bottom" class=" form-login"title="Intranet" data-toggle="modal" data-target="#modal-1">
                                    <i style="font-size:15px" class="fa  fa-user"></i> {$lenguaje.text_iniciarsession}</a>                      
                            </li>
                        {/if}
                        </ul>
                    </nav>
                </div>
                {/foreach}
            {/if}
        </header>

        <div class="container col-lg-12" style="margin-top: 10px;">

            <noscript><p>Para el correcto funcionamiento debe tener el soporte para javascript habilitado</p></noscript>

            {if isset($_error)}
                <div id="_errl" class="alert alert-error ">
                    <a class="close" data-dismiss="alert">x</a>
                    {$_error}
                </div>
            {/if}
            <div id="_mensaje" class="hide">

            </div>

            {if isset($_mensaje)}
                <div id="_msgl" class="alert alert-success">
                    <a class="close" data-dismiss="alert">x</a>
                    {$_mensaje}
                </div>
            {/if}                

            {include file=$_contenido}            
        </div>        
        <!-- Footer -->
        <!-- Footer -->
        <div class="navbar navbar-fixed-bottom">
            <div class="navbar-inner">
                <div class=" col-xs-12" style = "padding-top: 10px;">
                    <!--<div style="margin-top: 10px; text-align: center;">IIAP - 2015 - Todos los derechos reservados <a target="_blank" href="iiap.org.pe">iiap.org.pe</a></div>-->                      
                    {if isset($widgets.footer)}
                        {foreach from=$widgets.footer item=ft}
                            {$ft}
                        {/foreach}
                    {/if}
                </div>
            </div>
        </div>
        <div id="cargando">   
            <div class="cargando"></div>   
        </div>
        <div id="cargandoBusqueda">   
            <div class="cargando"></div>   
        </div>

        <!-- Login -->


        <!--  Modal login -->
        <div class="modal fade top-space-0" id="modal-1" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content cursor-pointer">
                    <div class="modal-header">
                        <!--  <button type="button" class="close" data-dismiss="#modal-1">CLOSE &times;</button>-->
                        <h1 class="modal-title" >{$lenguaje["login_intranet"]}</h1>
                    </div>

                    <div class="modal-body">     
                        <form class="form-signin" name="form1" method="post" action="{$_layoutParams.root}usuarios/login" autocomplete="on"> 
                            <input type="hidden" value="1" name="enviar" />  
                            <h2 class="form-signin-heading">{$lenguaje["login_intranet_1"]}</h2>
                            <input type="text" class="form-control" name="usuario" value="{$datos.usuario|default:""}"  placeholder="Usuario" required="" autofocus="" />
                            <br>
                            <input type="password" class="form-control" name="pass" placeholder="Contraseña" required=""/>      
                            <br>
                            <button id="logear" name="logear" class="btn btn-lg btn-success btn-block" type="submit">{$lenguaje["login_intranet_2"]}</button>   
                        </form>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-default" data-dismiss="modal">{$lenguaje["login_intranet_3"]}</a>
                    </div>
                </div>
            </div>
        </div>





        <style type="text/css"> 
            .form-signin {
                max-width: 380px;
                padding: 35px 35px 45px;
                margin: 0 auto;
                background-color: #fff;
                border: 1px solid rgba(0,180,0,0.3);  

                .form-signin-heading,
                .checkbox {
                    margin-bottom: 30px;
                }

                .form-signin .checkbox {
                    font-weight: normal;
                }

                .form-signin .form-control {
                    position: relative;
                    font-size: 16px;
                    height: auto;
                    padding: 10px;
                    @include box-sizing(border-box);

                    &:focus {
                        z-index: 2;
                    }
                }

                .form-signin  input[type="text"] {
                    margin-bottom: -1px;
                    border-bottom-left-radius: 0;
                    border-bottom-right-radius: 0;
                }

                .form-signin   input[type="password"] {
                    margin-bottom: 20px;
                    border-top-left-radius: 0;
                    border-top-right-radius: 0;
                }
            }

        </style>
        <!--  Modal end -->
       
         <script type="text/javascript" src="{$_layoutParams.root_clear}public/js/jquery-1.11.2.min.js"></script>
        <script language="javascript">
        $(document).ready(function() {
            $(".botonExcel").click(function(event) {
                $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
                $("#FormularioExportacion").submit();
            });
        });
        </script>
        <!--<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>-->
        <script src="{$_layoutParams.ruta_js}bootstrap.min.js" type="text/javascript"></script>
        <script src="{$_layoutParams.ruta_js}app.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="{$_layoutParams.root_clear}public/js/Validator.js"></script>
        <script type="text/javascript" src="{$_layoutParams.root_clear}public/js/util.js"></script>
        <script type="text/javascript" src="{$_layoutParams.root_clear}public/js/jquery.slimscroll.min.js"></script>

        <script type="text/javascript" src="{$_layoutParams.ruta_js}bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="{$_layoutParams.ruta_js}bootstrapValidator.js"></script>
        <script type="text/javascript" src="{$_layoutParams.root_clear}public/js/highcharts.js"></script>
        <script type="text/javascript" src="{$_layoutParams.root_clear}public/ckeditor/ckeditor.js"></script>

        <script type="text/javascript">
            var _root_ = '{$_layoutParams.root_clear}';
            var _root_lang = '{$_layoutParams.root}';
            var _root_archivo_fisico = '{$_layoutParams.root_archivo_fisico}';
            $('.mitooltip').tooltip();
        </script>
         {if isset($_layoutParams.js_plugin) && count($_layoutParams.js_plugin)}
            {foreach item=plg from=$_layoutParams.js_plugin}
                <script src="{$plg}" type="text/javascript" defer></script>
            {/foreach}
        {/if}
        {if isset($_layoutParams.js) && count($_layoutParams.js)}
            {foreach item=js from=$_layoutParams.js}
                <script src="{$js}" type="text/javascript" defer></script>
            {/foreach}
        {/if}
        <!--Buscador-->
        <script type="text/javascript">

        function tecla_enter(evento)
        {
        
            var iAscii;

            if (evento.keyCode)
            {
                iAscii = evento.keyCode;
                //alert('code');
            }  

            if (iAscii == 13) 
            {
                //alert('entro');

                buscarPalabra('textBuscar');
                evento.preventDefault();
            }
           
        }

        function buscarPalabra(campo) { 
            var palabra = $('#'+campo).val(); 
            if(!palabra)
            {
                palabra='all';
            }
            document.location.href = '{$_layoutParams.root}index/buscarPalabra/' + palabra 
            
        }
        </script>
        <script type="text/javascript">
            $(function() {

                $('#slide-submenu').on('click', function() {
                    $(this).closest('.list-group').fadeOut('slide', function() {
                        $('.mini-submenu').fadeIn();
                    });
                });
                //   $('.mini-submenu').on('click', function(){
                // $(this).next('.list-group').toggle('slide');
                //       $('.mini-submenu').hide();
                // })
                //     })


            });</script>        
        <script>
            $(document).ready(function() {
                $(function() {
                    $("[data-toggle='tooltip']").tooltip();
                });
            });

            $('.img-modal').on('click', function() {

                // returns #modal-Id
                var modalIdClicked = $(this).attr('data-target')
                console.log('modal id clicked from .img-modal = ' + modalIdClicked);

                //console.log ('.img-modal clicked');

                $(modalIdClicked).on('show.bs.modal', function(event) {

                    console.log('show.bs.modal');

                });

            });


            $('.form-login').on('click', function() {

                // returns #modal-Id
                var modalIdClicked = $(this).attr('data-target')
                console.log('modal id clicked from .form-login = ' + modalIdClicked);

                console.log('.form-login clicked');

                $(modalIdClicked).on('show.bs.modal', function(event) {

                    console.log('show.bs.modal');

                });

            });
        </script>
    </body>
</html>