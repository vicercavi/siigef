  <!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>{$titulo|default:"SII INTRANET"}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="{$_layoutParams.ruta_css}bootstrapValidator.css" rel="stylesheet" type="text/css">
        <link href="{$_layoutParams.ruta_css}datepicker.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" href="{$_layoutParams.ruta_img}favicon.ico" type="image/x-icon" />
        <!-- Bootstrap 3.3.4 -->
        <!-- <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> -->
        <link href="{$_layoutParams.ruta_css}bootstrap.min.css" rel="stylesheet" type="text/css">  
        <!-- Font Awesome Icons -->
    <!--    <link href="{$_layoutParams.root_clear}public/css/font-awesome.min.css" rel="stylesheet" type="text/css"> -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> 
        <!-- Ionicons -->
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" /> 
   <!--    <link href="{$_layoutParams.root_clear}public/css/ionicons.min.css" rel="stylesheet" type="text/css"> -->
        <!-- Theme style -->
        <link href="{$_layoutParams.ruta_css}/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="{$_layoutParams.ruta_css}/customAdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. We have chosen the skin-green for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link href="{$_layoutParams.ruta_css}/skins/skin-green.min.css" rel="stylesheet" type="text/css" />
        <link href="{$_layoutParams.ruta_css}/jsoft-backend.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->    
        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 2.1.3 
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
       


        {if isset($_layoutParams.css) && count($_layoutParams.css)}
            {foreach item=css from=$_layoutParams.css}        
                <link href="{$css}" rel="stylesheet" type="text/css" />        
            {/foreach}
        {/if}

        <link href="{$_layoutParams.root_clear}public/css/util.css" rel="stylesheet" type="text/css"> 
        <style>
            .skin-green .sidebar-menu>li.header{
                color: #E1E1E1;
                font-weight: bold;
                font-size: 14px;
                background: #484848;}
            </style>

        </head>
        <!--
        BODY TAG OPTIONS:
        =================
        Apply one or more of the following classes to get the
        desired effect
        |---------------------------------------------------------|
        | SKINS         | skin-blue                               |
        |               | skin-black                              |
        |               | skin-purple                             |
        |               | skin-yellow                             |
        |               | skin-red                                |
        |               | skin-green                              |
        |---------------------------------------------------------|
        |LAYOUT OPTIONS | fixed                                   |
        |               | layout-boxed                            |
        |               | layout-top-nav                          |
        |               | sidebar-collapse                        |
        |               | sidebar-mini                            |
        |---------------------------------------------------------|
        -->
        <body class="skin-green fixed sidebar-mini ">
        <div class="wrapper">

            <!-- Main Header -->
            <header class="main-header">

                <!-- Logo -->
                <a href="{$_layoutParams.root}" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->

                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>SIIGEF</b></span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="title-sii pull-left " >
                        <h4 class="title-lg" >{$lenguaje.intranet_titulo_inicio}</h4>
                        <h4 class="title-md" >SII - OTCA</h4>
                    </div>
                    <section class="pull-right " >
                        <ul class="idiomas">
                            <li><a href="{$_layoutParams.root_clear}index/_loadLang/es">Español</a></li>
                            <li><a href="{$_layoutParams.root_clear}index/_loadLang/en">English</a></li>
                            <li><a href="{$_layoutParams.root_clear}index/_loadLang/pt">Português</a></li>
                        </ul>
                    </section>
                </nav>

            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <!-- Sidebar user panel (optional) -->
                    {if Session::get('usuario')}
                        <div class="user-panel">   
                            <div class="pull-left user-panel" >
                                <a class="image" style="  width: 100%; max-width: 45px; height: auto;" href="{$_layoutParams.root}usuarios/perfil/index/{Session::get('id_usuario')}">
                                    <img src="{$_layoutParams.ruta_img}/user2-160x160.jpg" class="img-circle" alt="User Image"><img/>
                                </a>                                 
                            </div>
                            <div class="pull-left info">
                                <p>{Session::get('usuario')}</p>
                                <!-- Status -->
                                <a href="{$_layoutParams.root}usuarios/login/cerrar"  class="label label-danger"><i class="glyphicon glyphicon-remove-sign"></i> {$lenguaje.text_cerrarsession|default}</a>
                            </div>
                        </div>
                    {/if}

                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu">
                        <li class="header">{$lenguaje.menu_izquierdo_1}</li>
                        <!-- Optionally, you can add icons to the links -->
                        {if $_acl->permiso("listar_arquitectura_web")}
                        <li class="active"><a href="{$_layoutParams.root}arquitectura"><i class='fa fa-gears'></i> <span>{$lenguaje.menu_izquierdo_1_1}</span></a></li>
                        {/if}
                        <li><a href="#"><i class='glyphicon glyphicon-comment'></i> <span>{$lenguaje.menu_izquierdo_1_2}</span></a></li>
                        {if $_acl->permiso("listar_usuarios")}
                        <li class="treeview">
                            <a href="#"><i class='glyphicon glyphicon-user'></i> <span>{$lenguaje.menu_izquierdo_1_3}</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="{$_layoutParams.root}usuarios">{$lenguaje.menu_izquierdo_1_3_1}</a></li>
                                <li><a href="{$_layoutParams.root}acl/index/roles">{$lenguaje.menu_izquierdo_1_3_2}</a></li>
                                <li><a href="{$_layoutParams.root}acl/index/permisos">{$lenguaje.menu_izquierdo_1_3_3}</a></li>
                            </ul>              
                        </li>
                        {/if}
                        {if $_acl->permiso("listar_bitacora")}
                        <li class="treeview">
                            <a href="{$_layoutParams.root}bitacora"><i class='glyphicon glyphicon-list-alt'></i> <span>{$lenguaje.menu_izquierdo_1_4}</span></a>              
                        </li>
                        {/if}
                        {if $_acl->permiso("listar_visita") || $_acl->permiso("listar_descarga") || $_acl->permiso("listar_busqueda")}
                        <li class="treeview">
                            <a href="#"><i class='glyphicon glyphicon-equalizer'></i> <span>{$lenguaje.menu_izquierdo_1_5}</span><i class="fa fa-angle-left pull-right"></i></a>              
                            <ul class="treeview-menu">
                                {if $_acl->permiso("listar_visita")}
                                <li><a href="{$_layoutParams.root}visita">{$lenguaje.menu_izquierdo_1_5_1}</a></li>
                                {/if}
                                {if $_acl->permiso("listar_descarga")}
                                <li><a href="{$_layoutParams.root}descarga">{$lenguaje.menu_izquierdo_1_5_2}</a></li>
                                {/if}
                                {if $_acl->permiso("listar_busqueda")}
                                <li><a href="{$_layoutParams.root}busqueda">{$lenguaje.menu_izquierdo_1_5_3}</a></li>
                                {/if}
                            </ul> 
                        </li>
                        {/if}
                        {if $_acl->permiso("listar_estandar") || $_acl->permiso("listar_recurso") || $_acl->permiso("listar_herramienta")}
                        <li class="header">{$lenguaje.menu_izquierdo_2}</li>
                        {/if}
                        {if $_acl->permiso("listar_estandar")}
                        <li class=""><a href="{$_layoutParams.root}estandar"><i class='fa fa-database'></i> <span>{$lenguaje.menu_izquierdo_2_3}</span></a></li>
                        {/if}



                        
                        {if $_acl->permiso("listar_rio") || 
                            $_acl->permiso("listar_cuenca") ||
                            $_acl->permiso("listar_subcuenca") ||
                            $_acl->permiso("listar_riocuenca") ||
                            $_acl->permiso("listar_tipoagua") ||
                            $_acl->permiso("listar_ubigeo") ||  
                            $_acl->permiso("listar_pais") || 
                            $_acl->permiso("listar_territorio") || 
                            $_acl->permiso("listar_denominacionterritorio")}
                        <li class="treeview">
                            <a href="#"><i class='glyphicon glyphicon-tint'></i> <span>{$lenguaje.menu_izquierdo_2_4}</span><i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                {if $_acl->permiso("listar_rio")}
                                <li><a href="{$_layoutParams.root}hidrogeo/rio">{$lenguaje.menu_izquierdo_2_4_1}</a></li>
                                {/if}
                                {if $_acl->permiso("listar_cuenca")}
                                <li><a href="{$_layoutParams.root}hidrogeo/cuenca">{$lenguaje.menu_izquierdo_2_4_2}</a></li>
                                {/if}
                                {if $_acl->permiso("listar_subcuenca")}
                                <li><a href="{$_layoutParams.root}hidrogeo/subcuenca">{$lenguaje.menu_izquierdo_2_4_3}</a></li>
                                {/if}
                                {if $_acl->permiso("listar_riocuenca")}
                                <li><a href="{$_layoutParams.root}hidrogeo/riocuenca">{$lenguaje.menu_izquierdo_2_4_4}</a></li>
                                {/if}
                                {if $_acl->permiso("listar_tipoagua")}
                                <li><a href="{$_layoutParams.root}hidrogeo/tipoagua">{$lenguaje.menu_izquierdo_2_4_5}</a></li>
                                {/if}
                                {if $_acl->permiso("listar_ubigeo") ||  $_acl->permiso("listar_pais") || $_acl->permiso("listar_territorio") || $_acl->permiso("listar_denominacionterritorio")}
                                <li>
                                    <a href="#">{$lenguaje.menu_izquierdo_2_4_6}<i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                        {if $_acl->permiso("listar_ubigeo")}
                                        <li><a href="{$_layoutParams.root}hidrogeo/ubigeo">{$lenguaje.menu_izquierdo_2_4_6}</a></li>
                                        {/if}
                                        {if $_acl->permiso("listar_pais")}
                                        <li><a href="{$_layoutParams.root}hidrogeo/pais">{$lenguaje.menu_izquierdo_2_4_6_1}</a></li>
                                        {/if}
                                        {if $_acl->permiso("listar_territorio")}
                                        <li><a href="{$_layoutParams.root}hidrogeo/territorio">{$lenguaje.menu_izquierdo_2_4_6_2}</a></li>
                                        {/if}
                                        {if $_acl->permiso("listar_denominacionterritorio")}
                                        <li><a href="{$_layoutParams.root}hidrogeo/denominacionterritorio">{$lenguaje.menu_izquierdo_2_4_6_3}</a></li>
                                        {/if}
                                    </ul> 
                                </li>
                                {/if}
                            </ul>
                        </li>
                        {/if}
                        
                        {if $_acl->permiso("listar_estandaragua")}
                        <li class="treeview">
                            <a ><i class='glyphicon glyphicon-scale'></i> <span>{$lenguaje["menu_izquierdo_2_5"]}</span><i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">                            
                                <li class="treeview">
                                    <a href="#">{$lenguaje.menu_izquierdo_2_5_1}<i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                        {if $_acl->permiso("listar_estandaragua")}
                                        <li><a href="{$_layoutParams.root}calidaddeagua/estandarcalidadagua">{$lenguaje.menu_izquierdo_2_5_1}</a></li>
                                        {/if}
                                        {if $_acl->permiso("listar_categoriaeca")}
                                        <li><a href="{$_layoutParams.root}calidaddeagua/categoriaeca">{$lenguaje.menu_izquierdo_2_5_1_1}</a></li>
                                        {/if}
                                        {if $_acl->permiso("listar_subcategoriaeca")}
                                        <li><a href="{$_layoutParams.root}calidaddeagua/subcategoriaeca">{$lenguaje.menu_izquierdo_2_5_1_2}</a></li>
                                        {/if}
                                        {if $_acl->permiso("listar_estadoeca")}
                                        <li><a href="{$_layoutParams.root}calidaddeagua/estadoeca">{$lenguaje.menu_izquierdo_2_5_1_3}</a></li>
                                        {/if}
                                    </ul> 
                                </li>                           
                                {if $_acl->permiso("listar_ica")}
                                <li class="treeview">
                                    <a href="#">{$lenguaje.menu_izquierdo_2_5_2}<i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                        {if $_acl->permiso("listar_ica")}
                                        <li><a href="{$_layoutParams.root}calidaddeagua/ica">{$lenguaje.menu_izquierdo_2_5_2}</a></li>
                                        {/if}
                                        {if $_acl->permiso("listar_categoriaica")}
                                        <li><a href="{$_layoutParams.root}calidaddeagua/categoriaica">{$lenguaje.menu_izquierdo_2_5_2_1}</a></li>
                                        {/if}
                                        {if $_acl->permiso("listar_clasificacionica")}
                                        <li><a href="{$_layoutParams.root}calidaddeagua/clasificacionica">{$lenguaje.menu_izquierdo_2_5_2_2}</a></li>
                                        {/if}
                                        {if $_acl->permiso("listar_ponderacionica")}
                                        <li><a href="{$_layoutParams.root}calidaddeagua/ponderacionica">{$lenguaje.menu_izquierdo_2_5_2_3}</a></li>
                                        {/if}
                                    </ul> 
                                </li>
                                {/if}
                                {if $_acl->permiso("listar_entidad")}
                                <li><a href="{$_layoutParams.root}calidaddeagua/entidad">{$lenguaje.menu_izquierdo_2_5_3}</a></li>
                                {/if}
                                {if $_acl->permiso("listar_estacionmonitoreo")}
                                <li class="treeview">
                                    <a href="#">{$lenguaje.menu_izquierdo_2_5_4}<i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                        {if $_acl->permiso("listar_estacionmonitoreo")}
                                        <li><a href="{$_layoutParams.root}calidaddeagua/estacionmonitoreo">{$lenguaje.menu_izquierdo_2_5_4}</a></li>
                                        {/if}
                                        {if $_acl->permiso("listar_tipoestacion")}
                                        <li><a href="{$_layoutParams.root}calidaddeagua/tipoestacion">{$lenguaje.menu_izquierdo_2_5_4_1}</a></li>
                                        {/if}
                                    </ul>
                                </li>
                                {/if}
                                {if $_acl->permiso("listar_variablesestudio")}
                                <li class="treeview">
                                    <a href="#">{$lenguaje.menu_izquierdo_2_5_5}<i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                        {if $_acl->permiso("listar_variablesestudio")}
                                        <li><a href="{$_layoutParams.root}calidaddeagua/tipoestacion">{$lenguaje.menu_izquierdo_2_5_5}</a></li>
                                        {/if}
                                        {if $_acl->permiso("listar_tipovariable")}
                                        <li><a href="{$_layoutParams.root}calidaddeagua/tipovariable">{$lenguaje.menu_izquierdo_2_5_5_1}</a></li>
                                        {/if}
                                    </ul>
                                </li>
                                {/if}
                            </ul>
                        </li>
                        {/if}
                        
                        
                        
                        {if $_acl->permiso("listar_recurso")}
                        <li class=""><a href="{$_layoutParams.root}bdrecursos"><i class='glyphicon glyphicon-globe'></i> <span>{$lenguaje.menu_izquierdo_2_1}</span></a></li>
                        {/if}
                        {if $_acl->permiso("listar_herramienta")}
                        <li><a href="{$_layoutParams.root}herramienta"><i class='fa fa-plug'></i> <span>{$lenguaje.menu_izquierdo_2_2}</span></a></li>            
                        {/if}
                    </ul><!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <!--        <section class="content-header">
                <!-- <h1>
                  SIIGEF -INTRANET
                  <small>Sistema Integrado de Información de los Recursos Hídricos Transfronterisos de la Cuenca Amazónica</small>
                </h1> --
                <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i>Inicio</a></li>
                  <li><a href="#"><i class="fa fa-link"></i>Enlace</a></li>
                  <li class="active">Aquí</li>
                </ol>
              </section>-->

                <!-- Main content -->
                <section class="content" style="padding-top: 30px;">
                    <div style="position:fixed; width:75%; margin: 0px auto; z-index:150 ">
                        {if isset($_error)}
                            <div id="_errl" class="alert alert-error " >
                                <a class="close " data-dismiss="alert">X</a>
                                {$_error}
                            </div>
                        {/if}
                        <div id="_mensaje" class="hide">

                        </div>

                        {if isset($_mensaje)}
                            <div id="_msgl" class="alert alert-success" >
                                <a class="close" data-dismiss="alert">X</a>
                                {$_mensaje}
                            </div>
                        {/if}             
                    </div>   
                    {include file=$_contenido} 
                    <!-- Your Page Content Here -->

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <!-- Main Footer -->
            <!--      <footer class="main-footer">
                    <-- To the right --
                    <div class="pull-right hidden-xs">
                     &copy;IIAP.ORG.PE
                    </div>
                    <-- Default to the left --
                    <strong>Copyright &copy; 2015 <a href="#">JsoftDesign</a>.</strong>.
                  </footer>-->


            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div id="cargando">   
                <div class="cargando"></div>   
            </div>
        </div>
        <script type="text/javascript" src="{$_layoutParams.root_clear}public/js/jquery-1.11.2.min.js"></script>
        
        <!--<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>--
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
        <!--Exportar Tabla a Excel-->
                
        <!-- Bootstrap 3.3.2 JS -->
        <script src="{$_layoutParams.ruta_js}bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="{$_layoutParams.ruta_js}app.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="{$_layoutParams.root_clear}public/js/util.js"></script>
        <script type="text/javascript" src="{$_layoutParams.root_clear}public/js/validator.js"></script>
        <script type="text/javascript" src="{$_layoutParams.root_clear}public/js/jquery.slimscroll.min.js"></script>
        <script type="text/javascript" src="{$_layoutParams.root_clear}public/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="{$_layoutParams.ruta_js}bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="{$_layoutParams.ruta_js}bootstrapValidator.js"></script>

        <script type="text/javascript" src="{$_layoutParams.root_clear}public/js/highcharts.js"></script>
        <script type="text/javascript" src="{$_layoutParams.root_clear}public/js/exporting.js"></script>     
        
        <!-- Estilos y escrips dinamicos-->
        <script type="text/javascript">
            var _root_ = '{$_layoutParams.root_clear}';
            var _root_lang = '{$_layoutParams.root}';
             var _root_archivo_fisico = '{$_layoutParams.root_archivo_fisico}';
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
    </body>
</html>