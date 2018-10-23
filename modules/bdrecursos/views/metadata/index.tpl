<style type="text/css">
    .alert-info {
    color: #31708f !important;
    background-color: #d9edf7 !important;
    border-color: #bce8f1;
}
</style>
<div id="recursos" class="container-fluid" >
    <div class="row">
        <div class="col-md-12">
            <h3 class="titulo-view">{$lenguaje["label_h2_titulo_bdrecursos"]} {$recurso.Esr_Nombre|upper}</h3>
            <br>          
        </div>
        {if empty($capas)}
            <div class="col-md-3">     
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <strong>{$lenguaje["label_recurso_bdrecursos"]}</strong>
                            </h4>
                        </div>               
                        <div class="panel-body">
                            <table class="table table-user-information">
                                <tbody>                           
                                    <tr>
                                        <td>{$lenguaje["label_nombre_bdrecursos"]}:</td>
                                        <td>{$recurso.Rec_Nombre}</td>     
                                    </tr>
                                    <tr>
                                        <td>{$lenguaje["label_tipo_bdrecursos"]}</td>
                                        <td>{$recurso.Tir_Nombre}</td>
                                    </tr>
                                    <tr>
                                        <td>{$lenguaje["label_estandar_bdrecursos"]}</td>
                                        <td>{$recurso.Esr_Nombre}</td>
                                    </tr>                                
                                    <tr>
                                        <td>{$lenguaje["label_fuente_bdrecursos"]}</td>
                                        <td>{$recurso.Rec_Fuente}</td>
                                    </tr>
                                    <tr>
                                        <td>{$lenguaje["label_origen_bdrecursos"]}</td>
                                        <td>{$recurso.Rec_Origen}</td>
                                    </tr>
                                    <tr>
                                        <td>{$lenguaje["registros_bdrecursos"]}</td>
                                        <td>
                                            {if $recurso.Tir_Nombre=='Tabular'}
                                                {if $controlador=='1' ||  $controlador=='0'}
                                                    <a type="button" title="Ver Registros" class="btn btn-default btn-sm" href="{$_layoutParams.root}bdrecursos/registros/index/{$idrecurso}" target="_blank">
                                                    <span class="badge">{$recurso.Rec_CantidadRegistros}</span>
                                                    </a>
                                                {else}
                                                     <a type="button" title="Ver Registros" class="btn btn-default btn-sm" href="{$_layoutParams.root}bdrecursos/registros/index/{$idrecurso}" target="_blank">
                                                        <span class="badge">{$recurso.Rec_CantidadRegistros}</span>
                                                    </a>
                                                {/if}
                                            {else}
                                                <span class="badge">{$recurso.Rec_CantidadRegistros}</span>
                                            {/if}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{$lenguaje["herramienta_utilizada_bdrecursos"]}</td>
                                        <td>
                                            {if isset($recurso.herramientas)}
                                                <ul>
                                                    {foreach item=herramienta from=$recurso.herramientas}
                                                        <li>
                                                        <a target="_blank" href="{$_layoutParams.root}herramienta/visor/{$herramienta.Her_Abreviatura}">
                                                            {$herramienta.Her_Nombre}
                                                        </a>
                                                            
                                                        </li>
                                                    {/foreach}
                                                </ul>
                                            {/if}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{$lenguaje["registro_bdrecursos"]}</td>
                                        <td>{$recurso.Rec_FechaRegistro|date_format:"%d/%m/%y"}</td>
                                    </tr>
                                    <tr>
                                        <td>{$lenguaje["modificacion_bdrecursos"]}</td>
                                        <td>{$recurso.Rec_UltimaModificacion|date_format:"%d/%m/%y"}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="col-md-9"> 
        {else}
            <div  class="col-md-12"> 
        {/if}
                <div class="panel-group">
                    {if isset($metadata)}
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <strong>Importar Datos</strong>
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="pull-left">
                                    <ul class="nav nav-pills"> 
                                        <li role="presentation">
                                            <span>Nuevo Registro desde:</span> 
                                        </li>
                                        {if $_acl->permiso("registro_individual")}
                                            <li role="presentation">
                                                <a href="{$_layoutParams.root}{if $controlador == '1'}{str_replace(' ','',strtolower($recurso.Esr_Nombre))}/registrar/index{else if $controlador == '0'}{str_replace(' ','',strtolower($recurso.Esr_Nombre))}/monitoreo/registrar{else}bdrecursos/registros/index{/if}/{$recurso.Rec_IdRecurso}" target="_blank">
                                                    <p class="text-success"><strong>{$lenguaje["individual_bdrecursos"]}</strong></p>
                                                </a>
                                            </li>
                                        {/if}
                                        {if $_acl->permiso("registro_desde_excel")}
                                            <li role="presentation">
                                                <a href="{$_layoutParams.root}bdrecursos/import/excel/{$recurso.Rec_IdRecurso}" target="_blank">
                                                    <p class="text-success"><strong>{$lenguaje["excel_bdrecursos"]}</strong></p>
                                                </a>
                                            </li>
                                        {/if}
                                        {if $_acl->permiso("registro_desde_web_servicie")}
                                            <li role="presentation">
                                                <a href="{$_layoutParams.root}bdrecursos/import/webservices/{$recurso.Rec_IdRecurso}" target="_blank">
                                                    <p class="text-success"><strong>Web Services</strong></p>
                                                </a>
                                            </li>
                                        {/if}
                                        {if $_acl->permiso("registro_desde_pecari")}
                                            <li role="presentation">
                                                <a href="{$_layoutParams.root}pecari/registrar/index/{$recurso.Rec_IdRecurso}" target="_blank">
                                                    <p class="text-success"><strong>Pecari</strong></p>
                                                </a>
                                            </li>
                                        {/if}
                                        {if $_acl->permiso("registro_desde_rss")}
                                            <li role="presentation">
                                                <a href="{$_layoutParams.root}bdrecursos/import/rss/{$recurso.Rec_IdRecurso}" target="_blank">
                                                    <p class="text-success"><strong>RSS</strong></p>
                                                </a>
                                            </li>
                                        {/if}
                                        {if $_acl->permiso("registro_desde_json")}
                                            <li role="presentation">
                                                <a href="{$_layoutParams.root}bdrecursos/import/json/{$recurso.Rec_IdRecurso}" target="_blank">
                                                    <p class="text-success"><strong>JSON</strong></p>
                                                </a>
                                            </li>
                                        {/if}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    {/if}
                    <div class="panel panel-default metadata">
                        <div class="panel-heading" style="height: 50px">
                            <div class="btn-group pull-right">
                                {if $_acl->permiso("editar_metadata_recurso")}
                                    <a href="{$_layoutParams.root}mapa/gestorcapa/{$capa.tic_Nombre}/{$capa.Cap_Idcapa}" id="bt_editar_metadata" name="bt_editar_metadata"  class="btn btn-success">{$lenguaje["editar_bdrecursos"]}</a>
                                {/if}
                            </div>
                            <h4 class="panel-title">
                                <strong>
                                    {if empty($metadata)} 
                                        {if isset($capas)}
                                            Detalle de Metadata
                                        {else}
                                            {$lenguaje["registro_metadata_bdrecursos"]}
                                        {/if} 
                                    {else} 
                                        {$lenguaje["metadata_bdrecursos"]} {$recurso.Esr_Nombre}
                                    {/if}
                                </strong>
                            </h4>
                        </div>               
                        <div class="panel-body">
                            {if isset($capas)}
                                {foreach item=capa from=$capas}
                                    <div class="col-md-7">
                                        <h2><i class="glyphicon glyphicon-info-sign"></i> {$capa.Cap_Titulo}</h2>
                                        <div class="pull-right">
                                          <i class="fa fa-calendar"></i>&nbsp;
                                          <span>Actualizado:</span>
                                          <span>{$recurso.Rec_UltimaModificacion|date_format:"%d/%m/%y"}</span>
                                        </div>
                                        <div style="clear:both"></div>    
                                        <div class="well2">{$capa.Cap_Resumen}</div>
                                        <div class="col-md-12">
                                            <h3>Información Básica</h3>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th class="col-md-2">Fuente</th>
                                                            <td>{$capa.Cap_Fuente}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Palabras claves</th>
                                                            {assign var=palabras value=", "|explode:$capa.Cap_PalabrasClaves2}
                                                            <td>
                                                                <ul>
                                                                {for $i=0 to count($palabras)-1}
                                                                    <li>{$palabras[$i]}</li>
                                                                {/for}
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Idioma</th>
                                                            <td>{$capa.Cap_Idioma1}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Descripción</th>
                                                            <td>{$capa.Cap_Descripcion}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Créditos</th>
                                                            <td>{$capa.Cap_Creditos}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Formato de Consumo</th>
                                                            <td>{$capa.tic_Nombre}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Url</th>
                                                            <td><a href="{$capa.Cap_UrlBase}" target="_blank" title="{$capa.Cap_UrlBase}">{$capa.Cap_UrlBase|truncate:70:"...":true}</a></td>
                                                        </tr>
                                                         <tr>
                                                            <th>Layer</th>
                                                            <td>{$capa.Cap_Nombre}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Leyenda</th>
                                                            <td>
                                                                <a href="{$capa.Cap_Leyenda}" target="_blank" title="{$capa.Cap_Leyenda}"><img src="{$capa.Cap_Leyenda}" style="border: 1px solid black"></a> 
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>{$lenguaje["herramienta_utilizada_bdrecursos"]}</th>
                                                            <td>
                                                                {if isset($recurso.herramientas)}
                                                                    <ul>
                                                                        {foreach item=herramienta from=$recurso.herramientas}
                                                                            <li>
                                                                                 <a target="_blank" href="{$_layoutParams.root}herramienta/visor/{$herramienta.Her_Abreviatura}">
                                                            {$herramienta.Her_Nombre}
                                                        </a>
                                                                            </li>
                                                                        {/foreach}
                                                                    </ul>
                                                                {/if}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-center">
                                        <div class="col-md-12">
                                            <div class="alert alert-info alert-dismissible">
                                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <p style="text-align:justify"><span style="font-family:arial,helvetica,sans-serif"><span style="font-size:14px">{$lenguaje["label_nota_venezuela"]|default:"Las denominaciones e informaciones empleadas en esta publicación técnica de la OTCA, y la forma que aparecen representados los datos, mapas, imágenes y cuadros que contienen información geográfica de los Países Miembros, no constituyen, juicio sobre cualesquiera otros Tratados o Actos Internacionales vigentes entre las Partes, ni sobre cualesquiera divergencias sobre límites o derechos territoriales que existan entre las Partes, ni podrá interpretarse o invocarse este documento para alegar aceptación o renuncia, afirmación o modificación, directa o indirecta, expresa o tácita, de las posiciones e interpretaciones que sobre estos asuntos sostenga cada Parte."}</span></span></p>
                                                </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h5 style="background: #f7f7f7; padding: 5px;"><strong>Vista en Google Maps</strong> </h5>
                                            <script>
                                                capa_wms=new Array();capa_wms['url']='{$capa.Cap_UrlCapa}';capa_wms['urlb']='{$capa.Cap_UrlBase}';capa_wms['nombre']='{$capa.Cap_Nombre}';capa_wms['titulo']='{$capa.Cap_Titulo}';
                                            </script> 
                                            <div id="map" class="map"></div>
                                        </div>
                                        <div class="col-md-12">
                                            <h5 style="background: #f7f7f7; padding: 5px;"><strong>Imagen</strong></h5>
                                            <img src="{$capa.Cap_imagenprev|default:'http://placehold.it/380x500'}" alt="{$capa.Cap_imagenprev}" class="img-rounded img-responsive" style="width: 100%; height: auto; margin: 5px;"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h3>Metadatos</h3>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th>Identificación del Fichero</th>
                                                        <td>{$capa.Cap_IdentificadorFichero1}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fecha de creación</th>
                                                        <td>{$capa.Cap_FechaCreacion1}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Norma de Metadatos</th>
                                                        <td>{$capa.Cap_NormaMetadatos1}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Versión de Norma de Metadatos</th>
                                                        <td>{$capa.Cap_VersionNormaMetadatos1}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-md-2">Contacto</th>
                                                        <td>
                                                            <table class="table" style="padding:0 0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Nombre Individual: </td>
                                                                        <td>{$capa.Cap_NombreIndividualdeContacto1}</td>
                                                                    </tr> 
                                                                    <tr>
                                                                        <td class="text-left">Nombre de la organización: </td>
                                                                        <td>{$capa.Cap_NombredelaOrganizaciondeContacto1}</td>
                                                                    </tr> 
                                                                    <tr>
                                                                        <td class="text-left">Dirección de Correo Electrónico: </td>
                                                                        <td>{$capa.Cap_CorreodelContacto1}</td>
                                                                    </tr> 
                                                                    <tr>
                                                                        <td class="text-left">Rol: </td>
                                                                        <td>{$capa.Cap_RoldelContacto1}</td>
                                                                    </tr>             
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>                  
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h3>Información de Identificación</h3>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th  class="col-md-2">Punto de Contacto</th>
                                                        <td>
                                                            <table class="table" style="padding:0 0;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Nombre Individual: </td>
                                                                        <td>{$capa.Cap_NombreIndividualPuntoContacto2}</td>
                                                                    </tr> 
                                                                    <tr>
                                                                        <td>Nombre de la organización: </td>
                                                                        <td>{$capa.Cap_NombreOrganizacionPuntoContacto2}</td>
                                                                    </tr> 
                                                                    <tr>
                                                                        <td>Dirección de Correo Electrónico: </td>
                                                                        <td>{$capa.Cap_CorreoElectronicoPuntoContacto2}</td>
                                                                    </tr> 
                                                                    <tr>
                                                                        <td>Rol: </td>
                                                                        <td>{$capa.Cap_RolPuntodeContacto2}</td>
                                                                    </tr>                  
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Vista del gráfico</th>
                                                        <td>
                                                            <table class="table">
                                                                <tr>
                                                                    <td>Nombre del Fichero</td>
                                                                    <td>{$capa.Cap_NombreFicherodeVistadelGrafico2}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Descripción del Fichero</td>
                                                                    <td>{$capa.Cap_DescripcionFicherodeVistadelGrafico2}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tipo de Fichero</td>
                                                                    <td>{$capa.Cap_TipoFicherodeVistadelGrafico2}</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>   
                                                    <tr>
                                                        <th>Descripción de Palabras Claves</th>
                                                        <td>
                                                            <table class="table">
                                                                <tr>
                                                                    <td class="col-md-2">Palabra clave: </td>
                                                                    <td>{$capa.Cap_PalabraClaveDescripcionPC2}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td >Tipo: </td>
                                                                    <td>{$capa.Cap_TipoDescripcionPC2}</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tipo de representación espacial</th>
                                                        <td>{$capa.Cap_TipodeRepresentacionEspacial2}</td>
                                                    </tr> 
                                                    <tr>
                                                        <th>Resolución Espacial</th>
                                                        <td>{$capa.Cap_ResolucionEspacial2}</td>
                                                    </tr>    
                                                    <tr>
                                                        <th>Idioma</th>
                                                        <td>{$capa.Cap_Idioma2}</td>
                                                    </tr>   
                                                    <tr>
                                                        <th>Categoría de Temas</th>
                                                        <td>{$capa.Cap_CategoriadeTema2}</td>
                                                    </tr>       
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-12">
                                            <h4>Extensión</h4>
                                            <div class="col-md-12">
                                                <strong>Elemento Geográfico</strong>
                                            </div>
                                            <div class="col-md-8 col-md-offset-2" style="background: #f7f7f7; padding: 5px;">
                                            <div class="row">
                                                <div class="col-md-6 col-md-offset-3 text-center">
                                                    <strong>Límite de Latitud Norte</strong>
                                                    <br>
                                                    <span>{$capa.Cap_LimiteLatitudNorte2}</span>
                                                </div>
                                            </div>
                                           
                                                <div class="row">
                                                    <div class="col-md-3 text-center vcenter">
                                                        <strong>Límite de Longitud Oeste</strong>
                                                        <br>
                                                        <span>{$capa.Cap_LimiteLongitudOeste2}</span>
                                                    </div>
                                                    
                                                    <div class="col-md-6 text-center vcenter">
                                                         <script>
                                                limites_capa=new Array();
                                                limit=new Array();
                                                limit["lat"]={$capa.Cap_LimiteLatitudNorte2}
                                                 limit["lng"]={$capa.Cap_LimiteLongitudOeste2}
                                                limites_capa[0]=limit;

                                                limit=new Array();
                                                limit["lat"]={$capa.Cap_LimiteLatitudNorte2}
                                                 limit["lng"]={$capa.Cap_LimiteLongitudEste2}
                                                limites_capa[1]=limit;

                                                limit=new Array();
                                                limit["lat"]={$capa.Cap_LimiteLatitudSur2}
                                                 limit["lng"]={$capa.Cap_LimiteLongitudEste2}
                                                limites_capa[2]=limit;

                                                limit=new Array();
                                                limit["lat"]={$capa.Cap_LimiteLatitudSur2}
                                                 limit["lng"]={$capa.Cap_LimiteLongitudOeste2}
                                                limites_capa[3]=limit;

                                                limit=new Array();
                                                limit["lat"]={$capa.Cap_LimiteLatitudNorte2}
                                                 limit["lng"]={$capa.Cap_LimiteLongitudOeste2}
                                                limites_capa[4]=limit;
                                                            </script> 
                                                        <div id="map_limites" class="map" style="width: auto; height: 250px; min-width: 100px; min-height: 100px; margin: 5px;"></div>
                                                    </div>
                                                   
                                                    <div class="col-md-3 text-center vcenter">
                                                        <strong>Límite de Longitud Este</strong>
                                                        <br>
                                                        <span>{$capa.Cap_LimiteLongitudEste2}</span>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-md-offset-3 text-center">
                                                        <strong>Límite de Latitud Sur</strong>
                                                        <br>
                                                        <span>{$capa.Cap_LimiteLatitudSur2}</span>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th class="col-md-2">Elemento Temporal</th>
                                                            <td>{$capa.Cap_Extension2}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Elemento Vertical</th>
                                                            <td>
                                                                <table class="table">
                                                                    <tr>
                                                                        <td>Valor Mínimo</td>
                                                                        <td >:</td>
                                                                        <td>{$capa.Cap_ValorMinimo2}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Valor Máximo: </td>
                                                                        <td>{$capa.Cap_ValorMaximo2}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Unidades de Medida: </td>
                                                                        <td>{$capa.Cap_UnidadesdeMedida2}</td>
                                                                    </tr>
                                                                </table>          
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h3>Información de Constricciones</h3>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th class="col-md-2">Información de Constricciones Legales
                                                        </th>
                                                        <td>
                                                            <table class="table table-user-information">
                                                                <tr>
                                                                    <td class="col-md-2">Limitación de Uso: </td>
                                                                    <td>{$capa.Cap_LimitaciondeUso3}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Constricciones de Acceso: </td>
                                                                    <td>{$capa.Cap_ConstriccionesdeAcceso3}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Constricciones de Uso: </td>
                                                                    <td>{$capa.Cap_ConstriccionesdeUso3}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Constricciones de Otro Tipo: </td>
                                                                    <td>{$capa.Cap_ConstriccionesdeOtroTipo3}</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h3>Información de Calidad de los Datos</h3>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th>Ámbito</th>
                                                        <td>
                                                            {$capa.Cap_Nivel4}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Linaje</th>
                                                        <td>
                                                            {$capa.Cap_Declaracion4}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h3>Información de Mantenimiento</h3>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th class="col-md-3">Frencuencia de Mantenimieto y Actualización</th>
                                                        <td>
                                                            {$capa.Cap_FrecuenciadeMantenimientoyActualizacion5}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fecha de la Próxima Actualización</th>
                                                        <td>
                                                            {$capa.Cap_FechaProximaActualizacion5}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h3>Representación Espacial</h3>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th>Representación Espacial Vectorial</th>
                                                        <td>
                                                            <table class="table">
                                                                <tr>
                                                                    <td >Nivel de Topología: </td>
                                                                    <td>{$capa.Cap_NivelTopologia6}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Objetos Geométricos: </td>
                                                                    <td>
                                                                        <table class="table">
                                                                            <tr>
                                                                                <td>Tipo de Objeto Geométrico</td>
                                                                                <td>{$capa.Cap_TipoObjetoGeometrico6}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table> 
                                                        <td>
                                                    </tr>
                                                    <tr>
                                                        <th>Representación Espacial Ráster</th>
                                                        <td>
                                                            <table class="table table-user-information">
                                                                <tr>
                                                                    <td>Número de Dimensiones</td>
                                                                    <td>{$capa.Cap_NumerodeDimensiones6}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Propiedades de las Dimensiones de los Ejes</td>
                                                                    <td>
                                                                        <table>
                                                                            <tr>
                                                                                <td>Nombre de la Dimensión: </td>
                                                                                <td>{$capa.Cap_NombredeDimension6}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Tamaño de la Dimensión: </td>
                                                                                <td>{$capa.Cap_TamanodeDimension6}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Resolución: </td>
                                                                                <td>{$capa.Cap_Resolucion6}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table> 
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h3>Información del Sistema de Referencia</h3>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="col-md-2">Código</th>
                                                        <td>{$capa.Cap_Codigo7}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Código del Sitio</th>
                                                        <td>{$capa.Cap_CodigoSitio7}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h3>Información de Distribución</h3>
                                        <div class="table-responsive">
                                            <table class="table table-user-information">
                                                <tbody>
                                                    <tr>
                                                        <th class="col-md-2">Formato de Distribución</th>
                                                        <td>
                                                            <table class="table">
                                                                <tr>
                                                                    <td class="col-md-2">Nombre:</td>
                                                                    <td>{$capa.Cap_Nombre8}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Versión: </td>
                                                                    <td >:</td>
                                                                    <td>{$capa.Cap_Version8}</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Opciones de Transferencia</th>
                                                        <td>
                                                            <table class="table">
                                                                <tr>
                                                                    <td>Enlace: </td>
                                                                    <td>{$capa.Cap_Enlace8}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Protocolo: </td>
                                                                    <td>{$capa.Cap_Protocolo8}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Nombre: </td>
                                                                    <td>{$capa.Cap_NombreOpcionesTransferencia8}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Descripción: </td>
                                                                    <td>{$capa.Cap_Descripcion8}</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                {/foreach}
                            {else}
                                {if (isset($metadata)&&!empty($metadata)||!$_acl->permiso("editar_metadata_recurso"))&&!isset($editar)}
                                    <div class="container col-md-12">   
                                        <table class="table table-user-information">
                                            <tr>
                                                <td class="col-md-3" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);"><b>Campos de Identificación</b>
                                                </td>
                                                <td>
                                                    <table class="table table-user-information">
                                                        <tr>
                                                            <td class="col-md-3 text-right">Título</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_Titulo}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-3 text-right">Título Cabecera</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_TituloCabecera}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-3 text-right">Ámbito</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_AmbitoAccion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="col-md-3 text-right">Población Objetivo</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_PoblacionObj}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Contacto Responsable</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_ContactoResponsable}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Nombre de la Institución</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_NombreInstitucion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Web de la Institución</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_WebInstitucion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Dirección de la Institución</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_DireccionInstitucion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Teléfono de la Institución</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_TelefonoInstitucion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Tipo de Institución</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_TipoInstitucion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Nombre de la Unidad de Información</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_NombreUnidadInformacion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Web de la Unidad de Información</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_WebUnidadInformacion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Dirección de la Unidad de Información</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_DireccionUnidadInformacion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Teléfono de la Unidad de Información</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_TelefonoUnidadInformacion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Derecho de Autor</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_DerechoAutor}</td>
                                                        </tr><tr>
                                                            <td  class="col-md-3 text-right">Formato Versión</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_FormatoVersion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Metodología</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_Metodologia}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Tipo de Agreagacion de datos al SII</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_TipoAgregacionDatos}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Idioma de recursos</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_Idioma}</td>
                                                        </tr>  
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-3" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);"><b>Usos</b>
                                                </td>
                                                <td>
                                                    <table class="table table-user-information">
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Campos Visible</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_CampoVisible}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Campo de Búsqueda</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_CampoSearch}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Restricción</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_Restriccion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Restricción de Acceso</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_RestriccionAcceso}</td>
                                                        </tr>                                          
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-3" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);"><b>Interoperabilidad</b></td>
                                                <td>
                                                    <table class="table table-user-information">
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Nodo</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_Nodo}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Tabla</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_Tabla}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Proveedor</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_Proveedor}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Cadena de Conexion</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_CadenaConexion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Publicacion de datos a traves de web service  (Url para compartir en la web)</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_UrlWebService}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-3" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);"><b>Estado de Actualización</b></td>
                                                <td>
                                                    <table class="table table-user-information">
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Fecha Publicación</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_FechaPublicacion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Última Modificación</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_UltimaModificacion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Estado de Actualización</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_EstadoActualizacion}</td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-3" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);"><b>Caracaterización de los datos</b></td>
                                                <td>
                                                    <table class="table table-user-information">
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Georreferenciación</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_Georeferenciacion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Descripción</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_Descripcion}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Palabras claves</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_PalabrasClaves}</td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="col-md-3 text-right">Informacion Relacionada</td>
                                                            <td >:</td>
                                                            <td>{$metadata.Met_InfoRelacionada}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <form  method="post" class="form-inline">
                                            {if $_acl->permiso("editar_metadata_recurso")}
                                                <center><button type="submit" id="bt_editar_metadata" name="bt_editar_metadata"  class="btn btn-success ">{$lenguaje["editar_bdrecursos"]}</button></center>
                                            {/if}
                                        </form>
                                    </div>
                                {/if}
                                {if ((!isset($metadata)||empty($metadata))&&$_acl->permiso("editar_metadata_recurso"))||isset($editar)}
                                    <form  method="post" id="form1">
                                        <div class="container col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 data-toggle="collapse"  href="#collapse1" class="panel-title" style="cursor:pointer"><strong>Campos de Identificación</strong></h3>
                                                </div>
                                                <div id="collapse1" class="panel-collapse collapse in" >
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <label for="tb_titulo_metadata">{$lenguaje["titulo_bdrecursos"]}*</label>
                                                            <input type="text" class="form-control" id="tb_titulo_metadata"  name="tb_titulo_metadata"
                                                                   value="{$metadata.Met_Titulo|default}"
                                                                   placeholder="Titulo" required="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_titulo_cabecera_metadata">{$lenguaje["titulo_cabecera_bdrecursos"]}*</label>                        
                                                            <input type="text" class="form-control" id="tb_titulo_cabecera_metadata"  name="tb_titulo_cabecera_metadata"
                                                                   value="{$metadata.Met_TituloCabecera|default}"
                                                                   placeholder="Titulo Cabecera" required="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_ambito_metadata">{$lenguaje["ambito_bdrecursos"]}</label>
                                                            <input type="text" class="form-control" id="tb_ambito_metadata"  name="tb_ambito_metadata"
                                                                   value="{$metadata.Met_AmbitoAccion|default}"
                                                                   placeholder="Ámbito">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_poblacion_obj_metadata">{$lenguaje["poblacion_objetivo_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_poblacion_obj_metadata"  name="tb_poblacion_obj_metadata"
                                                                   value="{$metadata.Met_PoblacionObj|default}"
                                                                   placeholder="{$lenguaje["poblacion_objetivo_bdrecursos"]}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_contacto_responsable_metadata">{$lenguaje["contacto_responsable_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_contacto_responsable_metadata"  name="tb_contacto_responsable_metadata"
                                                                   value="{$metadata.Met_ContactoResponsable|default}"
                                                                   placeholder="{$lenguaje["contacto_responsable_bdrecursos"]}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_nombre_institucion_metadata">{$lenguaje["nombre_institución_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_nombre_institucion_metadata"  name="tb_nombre_institucion_metadata"
                                                                   value="{$metadata.Met_NombreInstitucion|default}"
                                                                   placeholder="{$lenguaje["nombre_institución_bdrecursos"]}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_web_institucion_metadata">{$lenguaje["web_institucion_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_web_institucion_metadata"  name="tb_web_institucion_metadata"
                                                                   value="{$metadata.Met_WebInstitucion|default}"
                                                                   placeholder="{$lenguaje["web_institucion_bdrecursos"]}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_direccion_institucion_metadata">{$lenguaje["dirección_institución_bdrecursos"]}*</label>                        
                                                            <input type="text" class="form-control" id="tb_direccion_institucion_metadata"  name="tb_direccion_institucion_metadata"
                                                                   value="{$metadata.Met_DireccionInstitucion|default}"
                                                                   placeholder="{$lenguaje["dirección_institución_bdrecursos"]}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_telefono_institucion_metadata">{$lenguaje["telefono_institucion_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_telefono_institucion_metadata"  name="tb_telefono_institucion_metadata"
                                                                   value="{$metadata.Met_TelefonoInstitucion|default}"
                                                                   placeholder="{$lenguaje["telefono_institucion_bdrecursos"]}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_tipo_institucion_metadata">{$lenguaje["tipo_institucion_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_tipo_institucion_metadata"  name="tb_tipo_institucion_metadata"
                                                                   value="{$metadata.Met_TipoInstitucion|default}"
                                                                   placeholder="{$lenguaje["tipo_institucion_bdrecursos"]}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_nombre_unidad_info_metadata">{$lenguaje["nombre_unidad_info_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_nombre_unidad_info_metadata"  name="tb_nombre_unidad_info_metadata"
                                                                   value="{$metadata.Met_NombreUnidadInformacion|default}"
                                                                   placeholder="{$lenguaje["nombre_unidad_info_bdrecursos"]}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_web_unidad_info_metadata">{$lenguaje["web_unidad_info_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_web_unidad_info_metadata"  name="tb_web_unidad_info_metadata"
                                                                   value="{$metadata.Met_WebUnidadInformacion|default}"
                                                                   placeholder="{$lenguaje["web_unidad_info_bdrecursos"]}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_direccion_unidad_info_metadata">{$lenguaje["direccion_unidad_info_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_direccion_unidad_info_metadata"  name="tb_direccion_unidad_info_metadata"
                                                                   value="{$metadata.Met_DireccionUnidadInformacion|default}"
                                                                   placeholder="{$lenguaje["direccion_unidad_info_bdrecursos"]}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_telefono_unidad_info_metadata">{$lenguaje["telefono_unidad_info_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_telefono_unidad_info_metadata"  name="tb_telefono_unidad_info_metadata"
                                                                   value="{$metadata.Met_TelefonoUnidadInformacion|default}"
                                                                   placeholder="{$lenguaje["telefono_unidad_info_bdrecursos"]}">
                                                        </div> 
                                                        <div class="form-group">
                                                            <label for="tb_derecho_autor_metadata">{$lenguaje["derecho_autor_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_derecho_autor_metadata"  name="tb_derecho_autor_metadata"
                                                                   value="{$metadata.Met_DerechoAutor|default}"
                                                                   placeholder="{$lenguaje["derecho_autor_bdrecursos"]}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_formato_version_metadata">{$lenguaje["formato_version_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_formato_version_metadata"  name="tb_formato_version_metadata"
                                                                   value="{$metadata.Met_FormatoVersion|default}"
                                                                   placeholder="{$lenguaje["formato_version_bdrecursos"]}">
                                                        </div> 
                                                        <div class="form-group">
                                                            <label for="tb_metodologia_metadata">{$lenguaje["metodologia_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_metodologia_metadata"  name="tb_metodologia_metadata"
                                                                   value="{$metadata.Met_Metodologia|default}"
                                                                   placeholder="{$lenguaje["metodologia_bdrecursos"]}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_tipoagregacion_metadata">Tipo de Agreagacion de datos al SII</label>                        
                                                            <input type="text" class="form-control" id="tb_tipoagregacion_metadata"  name="tb_tipoagregacion_metadata"
                                                                   value="{$metadata.Met_TipoAgregacionDatos|default}"
                                                                   placeholder="Tipo de Agreagacion de datos al SII">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_idiomarecurso_metadata">Idioma de Recurso</label>                        
                                                            <input type="text" class="form-control" id="tb_idiomarecurso_metadata"  name="tb_idiomarecurso_metadata"
                                                                   value="{$metadata.Met_Idioma}"
                                                                   placeholder="Tipo de Agreagacion de datos al SII">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 data-toggle="collapse"  href="#collapse2" class="panel-title" style="cursor:pointer"><strong>Usos</strong></h3>
                                                </div>
                                                <div id="collapse2" class="panel-collapse collapse " >
                                                    <div class="panel-body">

                                                        <div class="form-group">
                                                            <label for="tb_campo_visible_metadata">{$lenguaje["campo_visible_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_campo_visible_metadata"  name="tb_campo_visible_metadata"
                                                                   value="{$metadata.Met_CampoVisible|default}"
                                                                   placeholder="Campo Visible">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="tb_cambpo_search_metadata">{$lenguaje["campo_busqueda_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_cambpo_search_metadata"  name="tb_cambpo_search_metadata"
                                                                   value="{$metadata.Met_CampoSearch|default}"
                                                                   placeholder="Campo de Busqueda">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="tb_restriccion_metadata">{$lenguaje["restriccion_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_restriccion_metadata"  name="tb_restriccion_metadata"
                                                                   value="{$metadata.Met_Restriccion|default}"
                                                                   placeholder="{$lenguaje["restriccion_bdrecursos"]}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_restriccion_acceso_metadata">{$lenguaje["restricción_acceso_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_restriccion_acceso_metadata"  name="tb_restriccion_acceso_metadata"
                                                                   value="{$metadata.Met_RestriccionAcceso|default}"
                                                                   placeholder="{$lenguaje["restricción_acceso_bdrecursos"]}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                         
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 data-toggle="collapse"  href="#collapse3" class="panel-title" style="cursor:pointer"><strong>Interoperabilidad</strong></h3>
                                                </div>
                                                <div id="collapse3" class="panel-collapse collapse " >
                                                    <div class="panel-body">

                                                        <div class="form-group">
                                                            <label for="tb_nodo_metadata">{$lenguaje["nodo_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_nodo_metadata"  name="tb_nodo_metadata"
                                                                   value="{$metadata.Met_Nodo|default}"
                                                                   placeholder="{$lenguaje["nodo_bdrecursos"]}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="tb_tabla_metadata">{$lenguaje["tabla_bdrecursos"]}</label>
                                                            <input type="text" class="form-control" id="tb_tabla_metadata"  name="tb_tabla_metadata"
                                                                   value="{$metadata.Met_Tabla|default}"
                                                                   placeholder="Tabla">                       
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="tb_proveedor_metadata">{$lenguaje["proveedor_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_proveedor_metadata"  name="tb_proveedor_metadata"
                                                                   value="{$metadata.Met_Proveedor|default}"
                                                                   placeholder="Proveedor">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="tb_cadena_conexion_metadata">{$lenguaje["cadena_conexion_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_cadena_conexion_metadata"  name="tb_cadena_conexion_metadata"
                                                                   value="{$metadata.Met_CadenaConexion|default}"
                                                                   placeholder="Cadena Conexion">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="tb_urlwebservice_metadata">Publicacion de datos a traves de web service  (Url para compartir en la web)</label>                        
                                                            <input type="text" class="form-control" id="tb_urlwebservice_metadata"  name="tb_urlwebservice_metadata"
                                                                   value="{$metadata.Met_UrlWebService}"
                                                                   placeholder="Publicacion de datos a traves de web service  (Url para compartir en la web)">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 data-toggle="collapse"  href="#collapse4" class="panel-title" style="cursor:pointer"><strong>Estado de Actualizacion</strong></h3>
                                                </div>
                                                <div id="collapse4" class="panel-collapse collapse " >
                                                    <div class="panel-body">

                                                        <div class="form-group">
                                                            <label for="tb_fechapublicacion_metadata">Fecha Publicación</label>                        
                                                            <input type="text" class="form-control" id="tb_fechapublicacion_metadata"  name="tb_fechapublicacion_metadata"
                                                                   value="{$metadata.Met_FechaPublicacion}"
                                                                   placeholder="Fecha Publicación">
                                                        </div> 

                                                        <div class="form-group">
                                                            <label for="tb_ultimamodificacion_metadata">Última Modificación</label>                        
                                                            <input type="text" class="form-control" id="tb_ultimamodificacion_metadata"  name="tb_ultimamodificacion_metadata"
                                                                   value="{$metadata.Met_UltimaModificacion}"
                                                                   placeholder="Última Modificación">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tb_estadoactualizacion_metadata">Estado de Actualización</label>                        
                                                            <input type="text" class="form-control" id="tb_estadoactualizacion_metadata"  name="tb_estadoactualizacion_metadata"
                                                                   value="{$metadata.Met_EstadoActualizacion}"
                                                                   placeholder="Estado de Actualización">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 data-toggle="collapse"  href="#collapse5" class="panel-title" style="cursor:pointer"><strong>Caracaterizacion de los Datos</strong></h3>
                                                </div>
                                                <div id="collapse5" class="panel-collapse collapse " >
                                                    <div class="panel-body">

                                                        <div class="form-group">
                                                            <label for="tb_georreferenciacion_metadata">{$lenguaje["georreferenciación_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_georreferenciacion_metadata"  name="tb_georreferenciacion_metadata"
                                                                   value="{$metadata.Met_Georeferenciacion|default}"
                                                                   placeholder="{$lenguaje["georreferenciación_bdrecursos"]}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="tb_descripcion_metadata">{$lenguaje["descripcion_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_descripcion_metadata"  name="tb_descripcion_metadata"
                                                                   value="{$metadata.Met_Descripcion|default}"
                                                                   placeholder="Descripcion">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="tb_palabrasclaves_metadata">Palabras claves*</label>                        
                                                            <input type="text" class="form-control" id="tb_palabrasclaves_metadata"  name="tb_palabrasclaves_metadata"
                                                                   value="{$metadata.Met_PalabrasClaves|default}"
                                                                   placeholder="Descripcion">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="tb_info_relacionada_metadata">{$lenguaje["info_relacionada_bdrecursos"]}</label>                        
                                                            <input type="text" class="form-control" id="tb_info_relacionada_metadata"  name="tb_info_relacionada_metadata"
                                                                   value="{$metadata.Met_InfoRelacionada|default}"
                                                                   placeholder="{$lenguaje["info_relacionada_bdrecursos"]}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-inline">
                                            <br>
                                                {if !isset($editar)} 
                                                    <center><button type="submit" id="bt_registrar_metadata" name="bt_registrar_metadata"  class="btn btn-success ">{$lenguaje["registrar_bdrecursos"]}</button></center>
                                                {else}
                                                    <input type="hidden" id="hd_id_metadata" name="hd_id_metadata" value="{$metadata.Met_IdMetadata}">
                                                    <center><button type="submit" id="bt_actulizar_metadata" name="bt_actulizar_metadata"  class="btn btn-success ">{$lenguaje["actualizar_bdrecursos"]}</button></center>
                                                    <a href="{$_layoutParams.root}bdrecursos/metadata/{$recurso.Rec_IdRecurso}">{$lenguaje["cancelar_bdrecursos"]}</a>
                                                {/if}
                                            </div>
                                        </div>
                                    </form>
                                {/if}
                            {/if}                       
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<style type="text/css">
    .well2
    {
        min-height: 20px;
        padding: 19px;
        margin-bottom: 20px;
        margin-top: 20px;
        background-color: #f5f5f5;
        border: 1px solid #e3e3e3;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    }    
</style>