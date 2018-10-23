<!DOCTYPE html>
<html lang="es">
    <head>
        <title>{$titulo|default:"Sin t&iacute;tulo"}</title>
        <meta charset="utf-8">
        <link href="{$_layoutParams.ruta_css}bootstrap.css" rel="stylesheet" type="text/css">
        <link href="{$_layoutParams.ruta_css}bootstrapValidator.css" rel="stylesheet" type="text/css">
        <link href="{$_layoutParams.ruta_css}datepicker.css" rel="stylesheet" type="text/css">      
        <style type="text/css">
            #form1 .selectContainer .form-control-feedback {
                /* Adjust feedback icon position */
                right: -15px;
            }
        </style>  
        <link rel="shortcut icon" href="{$_layoutParams.ruta_img}favicon.ico" type="image/x-icon" />
        <style type="text/css">
            body{          
                padding-bottom: 40px;            
            }
        </style>
        <!-- javascript 

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css" />
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>
        <script src="//oss.maxcdn.com/jquery/1.11.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="//oss.maxcdn.com/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>-->
 
       


        {if isset($_layoutParams.css) && count($_layoutParams.css)}
            {foreach item=css from=$_layoutParams.css}        
                <link href="{$css}" rel="stylesheet" type="text/css" />        
            {/foreach}
        {/if}
        <link href="{$_layoutParams.ruta_css}simple-sidebar.css" rel="stylesheet" type="text/css">
        <link href="{$_layoutParams.ruta_css}jsoft-lage.css" rel="stylesheet" type="text/css">
        <link href="{$_layoutParams.ruta_css}jsoft.css" rel="stylesheet" type="text/css">
        <link href="{$_layoutParams.root}public/css/util.css" rel="stylesheet" type="text/css"> 

       
    </head>

    <body>
        
            <header>
                <h1>
                    <a href="{$_layoutParams.root}" title="SISTEMA INTEGRADO DE INFORMACIÓN"><img src="{$_layoutParams.ruta_img}{$lenguaje.imagen_logosii}"></a>
                   <!-- <a href="#"><img src="{$_layoutParams.ruta_img}gef.png"></a>-->
                </h1>
                {if isset($widgets.top)}
                    {foreach from=$widgets.top item=wd}
                        <nav class="top_menu" id="enlaces-header">
                        <ul >  
                        {$wd}
                        {if Session::get('autenticado')}
                            <li>
                                <a href="{$_layoutParams.root}usuarios/login/cerrar"  data-toggle="tooltip" data-placement="bottom" class="link-contacto"title="Cerrar Sesi&oacute;n">{$lenguaje.text_cerrarsession}</a>
                            </li>
                        {else}
                            <li>
                                <a href="#"  data-placement="bottom" class="link-contacto form-login"title="Iniciar Sesi&oacute;n" data-toggle="modal" data-target="#modal-1">{$lenguaje.text_iniciarsession}</a>                      
                            </li>
                        {/if}
                        </ul>
                        </nav>
                    {/foreach}
                {/if}
                
                <section id="buscador">
                    <ul class="idiomas">
                        <li><a href="{$_layoutParams.root}index/_loadLang/es">Español</a></li>
                        <li><a href="{$_layoutParams.root}index/_loadLang/en">English</a></li>
                        <li><a href="{$_layoutParams.root}index/_loadLang/pt">Português</a></li>
                    </ul>
                    <input  type="search" placeholder="{$lenguaje.text_buscador|default}">
                    <input  type="submit" value="">
                </section>
                    
            </header>

            <div class="container">

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
               
            <!--  Modal login -->
            <div class="modal fade top-space-0" id="modal-1" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content cursor-pointer">
                        <div class="modal-header">
                          <!--  <button type="button" class="close" data-dismiss="#modal-1">CLOSE &times;</button>-->
                          <h1 class="modal-title" >Bienvenido a la Intranet</h1>
                        </div>

                        <div class="modal-body">     
                            <form class="form-signin" name="form1" method="post" action="{$_layoutParams.root}usuarios/login" autocomplete="on"> 
                              <input type="hidden" value="1" name="enviar" />  
                              <h2 class="form-signin-heading">Ingrese sus datos de Acceso</h2>
                              <input type="text" class="form-control" name="usuario" value="{$datos.usuario|default:""}"  placeholder="Usuario" required autofocus />
                              <br>
                              <input type="password" class="form-control" name="pass" placeholder="Contraseña" required/>      
                              <br>
                              <button class="btn btn-lg btn-success btn-block" type="submit">Ingresar</button>   
                            </form>
                        </div>

                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
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
              <script type="text/javascript" src="{$_layoutParams.root}public/js/jquery-1.9.1.js"></script>
        <!--<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>-->
        
        <script type="text/javascript" src="{$_layoutParams.root}public/js/Validator.js"></script>
        <script type="text/javascript" src="{$_layoutParams.root}public/js/util.js"></script>
        <script type="text/javascript" src="{$_layoutParams.ruta_js}bootstrap.js"></script>
        <script type="text/javascript" src="{$_layoutParams.ruta_js}bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="{$_layoutParams.ruta_js}bootstrapValidator.js"></script>

        <script type="text/javascript" src="{$_layoutParams.root}public/ckeditor/ckeditor.js"></script>

        <script type="text/javascript">
                    var _root_ = '{$_layoutParams.root}';
                    var _root_archivo_fisico = '{$_layoutParams.root_archivo_fisico}';
                    $('.mitooltip').tooltip();    
        </script>
        {if isset($_layoutParams.js) && count($_layoutParams.js)}
            {foreach item=js from=$_layoutParams.js}
                <script src="{$js}" type="text/javascript" defer></script>
            {/foreach}
        {/if}

        {if isset($_layoutParams.js_plugin) && count($_layoutParams.js_plugin)}
            {foreach item=plg from=$_layoutParams.js_plugin}
                <script src="{$plg}" type="text/javascript" defer></script>
            {/foreach}
        {/if}
        
        
        <script type="text/javascript">
                    $(function(){

                    $('#slide-submenu').on('click', function() {
                    $(this).closest('.list-group').fadeOut('slide', function(){
                    $('.mini-submenu').fadeIn();
                    });
                    });
                            $('.mini-submenu').on('click', function(){
                    $(this).next('.list-group').toggle('slide');
                            $('.mini-submenu').hide();
                    })
                            })

                   
    </script>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        <script>
                        $(document).ready(function() {
                    $(function () {
                    $("[data-toggle='tooltip']").tooltip();
                    });       
                    });

                  $('.img-modal').on('click', function () {

        // returns #modal-Id
        var modalIdClicked = $(this).attr('data-target')
        console.log ('modal id clicked from .img-modal = '+ modalIdClicked);

        //console.log ('.img-modal clicked');

            $(modalIdClicked).on('show.bs.modal', function(event) {

                console.log ( 'show.bs.modal');

            });    

        });       


              $('.form-login').on('click', function () {

    // returns #modal-Id
    var modalIdClicked = $(this).attr('data-target')
    console.log ('modal id clicked from .form-login = '+ modalIdClicked);

    console.log ('.form-login clicked');

        $(modalIdClicked).on('show.bs.modal', function(event) {

            console.log ( 'show.bs.modal');

        });    

    });     
        </script>
        </body>
    </html>