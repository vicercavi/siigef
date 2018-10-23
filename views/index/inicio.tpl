
<style type="text/css">
    header,#footer{
        display: none;
    }  
    body{
        background: #ddd;
    }   
    html, body,.container, #map-index,.cont-principal{
        height: 100%;
        margin: 0px !important;
        padding: 0px;
        width: 100%;
    }

    .panel{
        max-width: 600px;
        position: absolute;
        top: 0px;
        left: 32%;
        margin: 10px auto;   
        border: 2px solid #6BA740;
        min-height: 100px; 
        padding: 20px 10px;
        box-shadow: 2px 2px 2px rgba(0,0,0,.1);
        -moz-box-shadow: 2px 2px 2px rgba(0,0,0,.1);
        -webkit-box-shadow: 2px 2px 2px rgba(0,0,0,.1);
        -o-box-shadow: 2px 2px 2px rgba(0,0,0,.1);
        -ie-box-shadow: 2px 2px 2px rgba(0,0,0,.1);
        background-color: rgba(255,255,255,.7);
    }
    /*  .panel:hover{
        background-color: #fff;
      }*/

    .idiomas{
        background: rgb(226,226,226); /* Old browsers */
        /* IE9 SVG, needs conditional override of 'filter' to 'none' */
        background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2UyZTJlMiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjUwJSIgc3RvcC1jb2xvcj0iI2RiZGJkYiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjUxJSIgc3RvcC1jb2xvcj0iI2QxZDFkMSIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmZWZlZmUiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
        background: -moz-linear-gradient(top,  rgba(226,226,226,1) 0%, rgba(219,219,219,1) 50%, rgba(209,209,209,1) 51%, rgba(254,254,254,1) 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(226,226,226,1)), color-stop(50%,rgba(219,219,219,1)), color-stop(51%,rgba(209,209,209,1)), color-stop(100%,rgba(254,254,254,1))); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  rgba(226,226,226,1) 0%,rgba(219,219,219,1) 50%,rgba(209,209,209,1) 51%,rgba(254,254,254,1) 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  rgba(226,226,226,1) 0%,rgba(219,219,219,1) 50%,rgba(209,209,209,1) 51%,rgba(254,254,254,1) 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  rgba(226,226,226,1) 0%,rgba(219,219,219,1) 50%,rgba(209,209,209,1) 51%,rgba(254,254,254,1) 100%); /* IE10+ */
        background: linear-gradient(to bottom,  rgba(226,226,226,1) 0%,rgba(219,219,219,1) 50%,rgba(209,209,209,1) 51%,rgba(254,254,254,1) 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e2e2e2', endColorstr='#fefefe',GradientType=0 ); /* IE6-8 */

        border-radius: .5em;  
        max-width: 400px;
        margin: 10px auto;
        font-size: 1.5em;
        text-align: center;
        height: 40px;
        box-shadow: 2px 2px 2px rgba(0,0,0,.1);
        -moz-box-shadow: 2px 2px 2px rgba(0,0,0,.1);
        -webkit-box-shadow: 2px 2px 2px rgba(0,0,0,.1);
        -o-box-shadow: 2px 2px 2px rgba(0,0,0,.1);
        -ie-box-shadow: 2px 2px 2px rgba(0,0,0,.1);
    }
    .idiomas li a{
        padding: .25em;

    }
    section#logos-index{
        position: relative;
        top: 0;
        right: 0;
        margin-top: 10px;
        width: 554px;
        padding: 0;
        text-align: center;
    }
    p{
        max-width: 400px;
        margin: 10px auto;
        text-align: justify;
    }  
    #map-index{
        background-color: #fff;
        background-image: url(public/img/bg1.jpg);
        background-repeat:no-repeat;
        background-size: cover;
        /*background-position-y: 100px;*/
    }
    #clouds,#clouds1,#clouds2 {         
        background-image: url(public/img/nube.png);
        background-repeat: no-repeat;
        background-size: contain;
        width: 100%;
        height: 100px;
        top: 0;
        z-index: 18;
        position: absolute;
    }
    #clouds {
        animation: animatedBg2 30s linear infinite;
    } 
    #clouds2 {
        animation: animatedBg2 60s linear infinite;
    } 
    @keyframes animatedBg2 {
        from {
            background-position: 150% 0;
        }
        to {
            background-position: -640px 0;
        }
    </style>

    <div id="clouds"></div>
    <div id="clouds2"></div>
    <div id="map-index">
    <div class="col-xs-9 col-sm-offset-1 col-sm-7 col-md-offset-2 col-md-5 col-lg-offset-2 col-lg-5" style="z-index: 100;top: 31%;">

        <div class="panel panel-success">
            <div style="text-align:center">
                    <img src="{$_layoutParams.ruta_img}{$lenguaje.imagen_logosii}">
                </div>
                <div class="row">
                    <ul class="idiomas">
                        <li><a href="{$_layoutParams.root}index/_loadLang/es">Español</a></li>
                        <li><a href="{$_layoutParams.root}index/_loadLang/en">English</a></li>
                        <li><a href="{$_layoutParams.root}index/_loadLang/pt">Português</a></li>
                    </ul>
                </div>
                <div class="row">
                    <p>El Sistema Integrado de Información (SII) sirve de apoyo en el proyecto de Manejo Integrado y Sostenible de los recursos hídricos transfronterizos en la cuenca del amazonas considerando la variabilidad y el cambio climático GEF Amazonas.
                    </p>
                </div>
                <div class="row">
                    <section id="logos-index">         
                        <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="Estado Plurinacional de Bolivia" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=1"><img src="{$_layoutParams.ruta_img}8.png"></a></figure>
                        <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República Federativa del Brasil" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=2"><img src="{$_layoutParams.ruta_img}7.png"></a></figure>
                        <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República de Colombia" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=3"><img src="{$_layoutParams.ruta_img}6.png"></a></figure>
                        <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República del Ecuador" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=4"><img src="{$_layoutParams.ruta_img}5.png"></a></figure>
                        <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República Bolivariana de Venezuela" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=8"><img src="{$_layoutParams.ruta_img}4.png"></a></figure>
                        <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República de Suriname" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=7"><img src="{$_layoutParams.ruta_img}3.png"></a></figure>    
                        <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República del Perú" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=6"><img src="{$_layoutParams.ruta_img}2.png"></a></figure>    
                        <figure><a data-toggle="tooltip" data-placement="bottom" class="link-home" title="República Cooperativista de Guyana" target="_blank" href="http://otca.info/portal/paises-membros.php?p=otca&id=5"><img src="{$_layoutParams.ruta_img}1.png"></a></figure>    

                    </section>
                </div> 

            </div>
        </div> 
    </div>

    