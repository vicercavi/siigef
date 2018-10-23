<div class="container-fluid">
    <div class="row">
        <h3 class="titulo-view" >Gestor de Capas </h3> 
        {if $_acl->permiso("agregar_capa")}
            <div id="nueva_capa" >
                <div class="panel panel-default">
                    <div class="panel-heading jsoftCollap">
                        <h4 class="panel-title" data-toggle="collapse"  href="#capa">
                            <i style="float:right"class="fa fa-ellipsis-v"></i>
                            <i class="fa fa-globe fa-plus"></i>&nbsp;&nbsp;
                            <strong>{if isset($capa)} Editar Capa{else} Nueva Capa{/if}</strong>
                        </h4>
                    </div>   
                    <!--==Seccion de registro y edicion de Capa===-->
                    <div  id="capa" class="panel-collapse collapse {if isset($tkml) || isset($twms)|| isset($tjson)|| isset($timagenes)|| isset($trss)}in{/if}">
                        <div class="panel-body">
                            <form id="panel-wms" method="post"  {if (isset($tkml)&&!empty($tkml) || isset($tjson)&&!empty($tjson))} enctype="multipart/form-data"{/if}>    
                                <!--div style="display: inline-block;vertical-align: top;min-width:450px;width: 38%;margin: 10px;"-->
                                <div class="col-md-5">
                                    <ul class="nav nav-tabs nav-justified">
                                        <li class="{$twms|default}"><a href="{$_layoutParams.root}mapa/gestorcapa/wms">WMS</a></li>
                                        <li class="{$tjson|default}"><a href="{$_layoutParams.root}mapa/gestorcapa/geojson">GEOJSON</a></li>
                                        <li class="{$trss|default}"><a href="{$_layoutParams.root}mapa/gestorcapa/georss">GEORSS</a></li>    
                                        <li class="{$tkml|default}"><a href="{$_layoutParams.root}mapa/gestorcapa/kml">KML/KMZ</a></li>                                                                                                                   
                                        <!--li class="{$timagenes|default}" > <a href="{$_layoutParams.root}mapa/gestorcapa/imagenes">IMÁGENES</a></li-->
                                    </ul>
                                    <!--==Agregar o editar cada desde WMS===-->
                                    {if (isset($twms)&&!empty($twms))}
                                        {if !isset($capa)}
                                            <div class="col-md-12" >
                                                <div class="input-group">
                                                    <input type="texto" id="urlbase" name="urlbase" value="{$urlbase|default:($capa.Cap_UrlBase|default)}" class="form-control"  placeholder="Ingrese url base del WMS" />
                                                    <span class="input-group-btn">
                                                        <button id="bt_agregar_wms" name="bt_agregar_wms"  type="submit" value="Cargar" class="btn btn-default" ><span class="glyphicon glyphicon-search"></span></button>
                                                    </span>
                                                </div>       
                                                <div class="checkbox">
                                                    <label>
                                                        <input id="cb_carga_avanzada" name="cb_carga_avanzada"type="checkbox" {if isset($gestoravanzado)}checked{/if}> Carga Avanzada
                                                    </label>
                                                </div>          
                                                <input  id="hd_carga_avanzada" name="hd_carga_avanzada" type="hidden" value="{if isset($gestoravanzado)}1{else}0{/if}">
                                            </div>
                                        {/if }                                       
                                        {if (isset($xml_wms)&&!empty($xml_wms) || isset($capa))}<!-- -->
                                            <div class="col-md-12">  
                                                {if (isset($capa))}
                                                    <div style="margin: auto;word-wrap: break-word;"> 
                                                        <label id="lb_urlbase" >{$capa.Cap_UrlBase}</label>
                                                    </div>                                                      
                                                {else if isset($xml_wms)&&!empty($xml_wms)}
                                                    <div style="margin: auto;font-weight: bold"> 
                                                        <h3>{$xml_wms->Service->Title|default}</h3> 
                                                    </div> 
                                                    <div style="margin: auto;word-wrap: break-word;"> 
                                                        <label id='lb_urlbase'>{$urlbase}</label>
                                                        <input type="hidden" id="hd_urlbase" name="hd_urlbase" value="{$urlbase}">
                                                        Version:<span id="lb_version">{$xml_wms['version']|default}</span>
                                                    </div> 
                                                {/if}
                                            </div>
                                        {/if}
                                    {/if}
                                    <!--==Agregar o Editar capa desde KML===-->
                                    {if (isset($tkml)&&!empty($tkml))}
                                        {if !isset($capa)}
                                        <div class="col-md-12" >
                                             <label>Seleccione archivo KML</label>  
                                            <div class="input-group">
                                                <input type="file" name="kml" id="kml" class="form-control"  placeholder="Seleccione archivo KML" />
                                                <span class="input-group-btn">
                                                    <button id="bt_cargar_kml" name="bt_cargar_kml" type="submit" value="Cargar" title="Cargar" class="btn btn-default" ><span class="glyphicon glyphicon-upload"></span></button>
                                                </span>
                                            </div>                                                  
                                        </div>
                                        <div class="col-md-12">                                           
                                            {if isset($kml)}
                                                <div style="margin:5px 0px 5px 0px;word-wrap: break-word;"> 
                                                    <label id='lb_nombrekml'>{$kml.titulo}</label>
                                                    <input type="hidden" id="hd_nombrekml" name="hd_nombrekml" value="{$kml.nombre}">  
                                                    <script>kml_nombre='{$kml.nombre}'</script>
                                                </div>       
                                            {/if}
                                        </div>
                                        {else if isset($capa)}
                                         <div class="col-md-12" >
                                             <label>Actulizar archivo KML</label>  
                                            <div class="input-group">
                                                <input type="file" name="kml" id="kml" class="form-control"  placeholder="Seleccione archivo KML" />
                                                <span class="input-group-btn">
                                                    <button id="bt_cargar_kml" name="bt_cargar_kml" type="submit" value="Cargar" title="Cargar" class="btn btn-default" ><span class="glyphicon glyphicon-upload"></span></button>
                                                </span>
                                            </div>                                                  
                                        </div>
                                            <div style="margin:5px 0px 5px 0px;word-wrap: break-word;"> 
                                                {if !isset($kml)}
                                                    <label id='lb_nombrekml'>{$capa.Cap_Nombre}</label>                                                    
                                                    <script>kml_nombre='{$capa.Cap_Nombre}'</script>
                                                {else}
                                                    <label id='lb_nombrekml'>{$kml.titulo}</label>
                                                    <input type="hidden" id="hd_edit_nombrekml" name="hd_edit_nombrekml" value="{$kml.nombre}">  
                                                    <script>kml_nombre='{$kml.nombre}'</script>
                                                {/if}
                                            </div>    
                                        {/if}
                                    {/if}
                                    {if (isset($trss)&&!empty($trss))}
                                        <div class="col-md-12" >
                                            <div class="input-group">
                                                <input type="texto" id="url_rss" name="url_rss" value="{$url_rss|default:($edit_georss.Cap_UrlCapa|default)}" class="form-control"  placeholder="Ingrese url del GEORSS" />                                                 
                                                <span class="input-group-btn">
                                                    <button id="bt_agregar_georss" name="bt_agregar_georss"  type="submit" value="Cargar" class="btn btn-default" ><span class="glyphicon glyphicon-search"></span></button>
                                                </span>
                                            </div> 
                                            {if isset($url_rss)&&isset($formulario)}                                          
                                                <div style="margin: auto;font-weight: bold"> 
                                                    <h4 id="h4_kml_title"></h4> 
                                                </div> 
                                                <div style="margin: auto;word-wrap: break-word;"> 
                                                    <label id='lb_url_rss'>{$url_rss}</label>
                                                    <input type="hidden" id="hd_url_rss" name="hd_url_rss" value="{$url_rss|default}">  
                                                </div> 
                                                <script>url_georss='{$url_rss}'</script>                                          
                                            {/if}
                                            {if isset($capa)&&!isset($url_rss)}                                                
                                                <div style="margin: auto;word-wrap: break-word;"> 
                                                    <label id='lb_url_rss'>{$capa.Cap_UrlCapa}</label>                                                    
                                                </div> 
                                                <script>url_georss='{$capa.Cap_UrlCapa}'</script>      
                                            {/if}
                                        </div>
                                    {/if}
                                    {if (isset($timagenes)&&!empty($timagenes))}
                                        <div class="col-md-12" >
                                             <label>Seleccione archivo Imagen</label>  
                                            <div class="input-group">
                                                <input type="file" name="kml" id="kml" class="form-control"  placeholder="Seleccione archivo KML" />
                                                <span class="input-group-btn">
                                                    <button id="bt_cargar_kml" name="bt_cargar_kml" type="submit" value="Cargar" title="Cargar" class="btn btn-default" ><span class="glyphicon glyphicon-upload"></span></button>
                                                </span>
                                            </div>                                                  
                                        </div>
                                    {/if}
                                    {if (isset($tjson)&&!empty($tjson))}
                                        <div class="">
                                            <div class="panel with-nav-tabs panel-default">                                                 
                                                <div class="panel-heading">
                                                    <ul class="nav nav-tabs">
                                                        <li {if isset($tipo_json)&&$tipo_json=='url'} class="active"{/if}><a class="tab_json" tipo="url" href="#tab1default_1" data-toggle="tab">Desde Url</a></li>
                                                        <li {if isset($tipo_json)&&$tipo_json=='archivo'} class="active"{/if}><a class="tab_json" tipo="archivo" href="#tab2default_1" data-toggle="tab">Desde Archivo</a></li>
                                                    </ul>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade {if isset($tipo_json)&&$tipo_json=='url'}in active{/if}" id="tab1default_1">
                                                            <div class="input-group">
                                                                <input type="texto" id="url_json" name="url_json" value="{$url_json|default:($edit_geojson.Cap_UrlCapa|default)}" class="form-control"  placeholder="{if isset($capa)}Ingrese nueva url del GeoJSON{else}Ingrese url del GeoJSON{/if}" />                                                 
                                                                <span class="input-group-btn">
                                                                    <button id="bt_agregar_geojson" name="bt_agregar_geojson"  type="submit" value="Cargar" class="btn btn-default" ><span class="glyphicon glyphicon-search"></span></button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade {if isset($tipo_json)&&$tipo_json=='archivo'}in active{/if}" id="tab2default_1">   
                                                            <label>{if isset($capa)}Seleccione nuevo archivo GeoJSON{else}Seleccione archivo GeoJSON{/if}</label>  
                                                            <div class="input-group">
                                                                <input type="file" name="file_json" id="kml" class="form-control"  placeholder="Seleccione archivo JSON" />
                                                                <span class="input-group-btn">
                                                                    <button id="bt_cargar_geojson" name="bt_cargar_geojson" type="submit" value="Cargar" title="Cargar" class="btn btn-default" ><span class="glyphicon glyphicon-upload"></span></button>
                                                                </span>
                                                            </div>    
                                                        </div>
                                                        <input type="hidden" id="hd_tipo_json" name="hd_tipo_json" value="{$tipo_json|default:'url'}">          
                                                    </div>
                                                </div>
                                            </div> 
                                             {if isset($url_json)&&isset($formulario)}                                          
                                                <div style="margin: auto;font-weight: bold"> 
                                                    <h4 id="h4_json_title"></h4> 
                                                </div> 
                                                <div style="margin: auto;word-wrap: break-word;"> 
                                                    <label id='lb_url_rss'>{$url_json}</label>
                                                    <input type="hidden" id="hd_url_json" name="hd_url_json" value="{$url_json|default}">  
                                                </div> 
                                                <script>url_geojson='{$url_json}'</script>                                          
                                            {/if}
                                            {if isset($file_json)&&isset($formulario)}   
                                             <div style="margin:5px 0px 5px 0px;word-wrap: break-word;"> 
                                                    <label id='lb_nombrekml'>{$file_json.titulo}</label>
                                                    <input type="hidden" id="hd_url_json" name="hd_url_json" value="{$file_json.nombre}">  
                                                    <script>file_geojson='{$file_json.nombre}'</script>
                                                </div>   
                                            {/if}
                                             {if isset($capa)&&(!isset($file_json)&&!isset($url_json))}
                                                 <div style="margin:5px 0px 5px 0px;word-wrap: break-word;"> 
                                                    <label id='lb_nombrekml'>{$capa.Cap_UrlCapa}</label>                                                    
                                                    <script>url_geojson='{$capa.Cap_UrlCapa}'</script>
                                                </div>   
                                             {/if}
                                        </div>
                                    {/if}
                                    <div class="clearfix"></div>
                                    {if isset($formulario)}
                                        <div class="panel panel-default">

                                            <div class="panel-heading">
                                                <h3 data-toggle="collapse"  href="#collapse1" class="panel-title"><strong>Informacion Basica</strong></h3>
                                            </div>
                                            <div id="collapse1" class="panel-collapse collapse in" >
                                                <div class="panel-body">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="tb_titulocapa">Titulo:*</label>
                                                            <input type="text" class="form-control" id="tb_titulocapa" name="tb_titulocapa" value="{$capa.Cap_Titulo|default:($kml.titulo|default:($file_json.titulo|default))}"       placeholder="Introduce Titulo de la Capa" >
                                                        </div>   
                                                        <div class="form-group">
                                                            <label  class="control-label" for="tb_iCap_Fuente">Fuente:*</label>
                                                            <input type="text" class="form-control" id="tb_iCap_Fuente"  name="tb_iCap_Fuente" value="{$capa.Cap_Fuente|default}"
                                                                   placeholder="Introduce Fuente de la capa" >
                                                        </div>
                                                        <!--==Para Cambiar Capa desde otro WMS==-->
                                                        {if isset($twms)&&!empty($twms)&& isset($capa)}
                                                            <div class="form-group">
                                                                <label for="tb_urlbase">Url:</label>
                                                                <div class="input-group">
                                                                    <input type="texto" id="urlbase" name="urlbase" value="{$urlbase|default:($capa.Cap_UrlBase|default)}" class="form-control"  placeholder="Ingrese url base del WMS" />
                                                                    {if isset($urlbase)}
                                                                    <input type="hidden" id="hd_urlbase" name="hd_urlbase" value="{$urlbase|default}"/>
                                                                    {/if}
                                                                    <span class="input-group-btn">
                                                                        <button id="bt_agregar_wms_editar" name="bt_agregar_wms_editar"  type="submit" value="Cargar" class="btn btn-default" ><span class="glyphicon glyphicon-search"></span></button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="checkbox">
                                                                <label>
                                                                    <input id="cb_carga_avanzada" name="cb_carga_avanzada"type="checkbox" {if isset($gestoravanzado)}checked{/if}> Carga Avanzada
                                                                </label>
                                                            </div>          
                                                            <input  id="hd_carga_avanzada" name="hd_carga_avanzada" type="hidden" value="{if isset($gestoravanzado)}1{else}0{/if}">
                                                            <script>capa_wms=new Array();capa_wms['url']='{$capa.Cap_UrlCapa}';capa_wms['urlb']='{$capa.Cap_UrlBase}';capa_wms['nombre']='{$capa.Cap_Nombre}';capa_wms['titulo']='{$capa.Cap_Titulo}';</script> 
                                                        {/if} 
                                                        {if isset($twms)&&!empty($twms)&&!isset($capa)}
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iRec_Origen">Origen *</label>
                                                                <input type="text" class="form-control" id="tb_iRec_Origen"  name="tb_iRec_Origen" value="{$capa.Cap_Fuente|default}" placeholder="Introduce el origen de la capa" >
                                                            </div>
                                                        {/if}     
                                                        {if (isset($twms)&&!empty($twms)&&isset($capa))}                                                                
                                                            <!-- Lista las capas de la nueva fuente WMS al momento de editar -->
                                                            {if (isset($xml_wms_editar))}
                                                                {if !isset($gestoravanzado)}
                                                                    <div style="margin: auto;word-wrap: break-word;"> 
                                                                        <label id='lb_urlbase_editar'>{$urlbase}</label>
                                                                    </div>
                                                                    <label>Lista de Capas</label>
                                                                    <ul id="ul_layer">
                                                                        {foreach from=$xml_wms_editar->Capability->Layer->Layer key=key item=item name=layer} 
                                                                            <li>
                                                                                <input type="radio" class="cb_layer" id="cb_layeredit_{$smarty.foreach.layer.index}" data="edit"  name="cb_layeredit" value="{$item->Name}">{$item->Title}
                                                                                <br>
                                                                                <input id="r_layeredit_{$smarty.foreach.layer.index}" type="range" value="100"/><br>
                                                                                <a href="#" data-toggle="modal" data-target="#bm_layeredit_{$smarty.foreach.layer.index}" id="a_layeredit_{$smarty.foreach.layer.index}" class="leyenda" layer="{$item->Name}">Leyenda</a>
                                                                                <input type="hidden" id="hd_layeredit_editar_{$smarty.foreach.layer.index}" value="{$item->Name}" >
                                                                                <div class="modal_leyenda">
                                                                                    <div class="modal  basicModal" id="bm_layeredit_{$smarty.foreach.layer.index}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                                                                        <div class="modal-dialog">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button><h4 class="modal-title" id="myModalLabel">{$item->Title}</h4></div>
                                                                                                <div class="modal-body" id="img_layeredit_{$smarty.foreach.layer.index}">

                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                                                </div> </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        {/foreach}
                                                                    </ul>
                                                                {else if isset($gestoravanzado)}   <!--Carga Avanzada de WMS al momento de editar -->                
                                                                    <section id="wms_avanzado">    
                                                                        <input  id="hd_url_capa" name="hd_url_capa" type="hidden">
                                                                        <div class="form-group">
                                                                            <label  class="control-label" for="cmb_layer">Fuente*</label>
                                                                            <select id="cmb_layer" class="form-control"> 
                                                                                {foreach from=$xml_wms_editar->Capability->Layer->Layer key=key item=item} 
                                                                                    <option value="{$item->Name}">{$item->Title} </option>
                                                                                {/foreach}
                                                                            </select>
                                                                        </div>   
                                                                        <div class="form-group">
                                                                            <label  class="control-label" for="tb_stile">Stilo</label>
                                                                            <input class="form-control" type="text" id="tb_stile" value='{$xml_wms_editar->Capability->Layer->Layer->Style->Name}'> 
                                                                        </div>    
                                                                        <div class="form-group">
                                                                            <label  class="control-label" for="cmb_srs">Seleccione Sistema de Coordenadas de Referencia</label>
                                                                            <select id="cmb_srs" class="form-control" > 
                                                                                <option value="0">Seleccione....</option>
                                                                                {if isset($xml_wms_editar->Capability->Layer->SRS)}
                                                                                    {foreach from=$xml_wms_editar->Capability->Layer->SRS key=key item=item} 
                                                                                        <option value="{$item}">{$item} </option>
                                                                                    {/foreach}
                                                                                {else}
                                                                                    {foreach from=$xml_wms_editar->Capability->Layer->CRS key=key item=item} 
                                                                                        <option value="{$item}">{$item} </option>
                                                                                    {/foreach}   
                                                                                {/if}
                                                                            </select> 
                                                                        </div>   
                                                                        <div class="form-group">
                                                                            <label  class="control-label" for="tb_srs">SRS</label>
                                                                            <input type="text" class="form-control" id="tb_srs"> 
                                                                        </div>    
                                                                        <div class="form-group">
                                                                            <label  class="control-label" for="tb_ancho">WIDTH</label>
                                                                            <input style="width: inherit" type="text" class="form-control" id="tb_ancho" value="256" > 
                                                                        </div> 
                                                                        <div class="form-group">
                                                                            <label  class="control-label" for="tb_alto">HEIGHT</label>
                                                                            <input   style="width: inherit" type="text" id="tb_alto" class="form-control" value="256"> 
                                                                        </div> 
                                                                        <div class="form-group">
                                                                            <label  class="control-label" for="cmb_format">Seleccione Formato de salida del mapa</label>
                                                                            <select id="cmb_format" class="form-control" > 
                                                                                {foreach from=$xml_wms_editar->Capability->Request->GetMap->Format key=key item=item} 
                                                                                    <option value="{$item}">{$item} </option>
                                                                                {/foreach}
                                                                            </select>
                                                                        </div> 
                                                                        <div class="form-group">
                                                                            <label  class="control-label" for="cmb_transparencia">Trasparencia</label>
                                                                            <select id="cmb_transparencia" class="form-control" >            
                                                                                <option value="True">Si</option>
                                                                                <option value="False">No</option>
                                                                            </select>
                                                                        </div>      
                                                                        <div class="form-group">
                                                                            <label  class="control-label" for="tb_BGCOLOR">Color del fondo RGB</label>
                                                                            <input type="text" id="tb_BGCOLOR" value='0xFFFFFF' class="form-control" >
                                                                        </div>                            
                                                                    </section>   
                                                                {/if}
                                                            {/if} 

                                                        {else if isset($twms)&&!empty($twms)}
                                                            <!-- Carga avanzada de wms al momento de registrar uno nuevo-->
                                                            {if (isset($xml_wms)&&!empty($xml_wms) || isset($capa))&&!isset($gestoravanzado)}
                                                                <section id="wms_simple">
                                                                    <label>Lista de Capas</label>
                                                                    <ul id="ul_layer">
                                                                        {foreach from=$xml_wms->Capability->Layer->Layer key=key item=item name=layer} 
                                                                            <li>
                                                                                <input type="checkbox" class="cb_layer" id="cb_layeredit_{$smarty.foreach.layer.index}" value="{$item->Name}" >
                                                                                <span id="sp_layeredit_{$smarty.foreach.layer.index}" class="edittext">{$item->Title}</span><br>
                                                                                <input id="r_layeredit_{$smarty.foreach.layer.index}" type="range" value="100"/><br>
                                                                                <a href="#" data-toggle="modal" data-target="#bm_layeredit_{$smarty.foreach.layer.index}" id="a_layeredit_{$smarty.foreach.layer.index}" class="leyenda" layer="{$item->Name}">Leyenda</a>
                                                                                <input type="hidden" id="hd_layeredit_{$smarty.foreach.layer.index}" value="{$item->Name}" >
                                                                                <div class="modal_leyenda">
                                                                                    <div class="modal  basicModal" id="bm_layeredit_{$smarty.foreach.layer.index}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                                                                        <div class="modal-dialog">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button><h4 class="modal-title" id="myModalLabel">{$item->Title}</h4></div>
                                                                                                <div class="modal-body" id="img_layeredit_{$smarty.foreach.layer.index}">

                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                                                </div> </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                        {/foreach}
                                                                    </ul>
                                                                </section>
                                                            {else if (isset($xml_wms)&&!empty($xml_wms) || isset($capa))&&isset($gestoravanzado)}                    
                                                                <section id="wms_avanzado">    
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="cmb_layer">Capa*</label>
                                                                        <select id="cmb_layer" name="cmb_layer" class="form-control"> 
                                                                            {foreach from=$xml_wms->Capability->Layer->Layer key=key item=item} 
                                                                                <option value="{$item->Name}">{$item->Title} </option>
                                                                            {/foreach}
                                                                        </select>
                                                                    </div>   
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_stile">Stilo</label>
                                                                        <input class="form-control" type="text" id="tb_stile" value='{$xml_wms->Capability->Layer->Layer->Style->Name}'> 
                                                                    </div>    
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="cmb_srs">Seleccione Sistema de Coordenadas de Referencia</label>
                                                                        <select id="cmb_srs" class="form-control" > 
                                                                            <option value="0">Seleccione....</option>
                                                                            {if isset($xml_wms->Capability->Layer->SRS)}
                                                                                {foreach from=$xml_wms->Capability->Layer->SRS key=key item=item} 
                                                                                    <option value="{$item}">{$item} </option>
                                                                                {/foreach}
                                                                            {else}
                                                                                {foreach from=$xml_wms->Capability->Layer->CRS key=key item=item} 
                                                                                    <option value="{$item}">{$item} </option>
                                                                                {/foreach}   
                                                                            {/if}
                                                                        </select> 
                                                                    </div>   
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_srs">SRS</label>
                                                                        <input type="text" class="form-control" id="tb_srs"> 
                                                                    </div>    
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_ancho">WIDTH</label>
                                                                        <input style="width: inherit" type="text" class="form-control" id="tb_ancho" value="256" > 
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_alto">HEIGHT</label>
                                                                        <input   style="width: inherit" type="text" id="tb_alto" class="form-control" value="256"> 
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="cmb_format">Seleccione Formato de salida del mapa</label>
                                                                        <select id="cmb_format" class="form-control" > 
                                                                            {foreach from=$xml_wms->Capability->Request->GetMap->Format key=key item=item} 
                                                                                <option value="{$item}">{$item} </option>
                                                                            {/foreach}
                                                                        </select>
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="cmb_transparencia">Trasparencia</label>
                                                                        <select id="cmb_transparencia" class="form-control" >            
                                                                            <option value="True">Si</option>
                                                                            <option value="False">No</option>
                                                                        </select>
                                                                    </div>      
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_BGCOLOR">Color del fondo RGB</label>
                                                                        <input type="text" id="tb_BGCOLOR" value='0xFFFFFF' class="form-control" >
                                                                    </div>                            
                                                                </section>                          
                                                            {/if}
                                                        {/if}
                                                        <div class="form-group">
                                                            <label  class="control-label" for="tb_iCap_PalabrasClaves2">Palabras Clave</label>
                                                            <input type="text" class="form-control" id="tb_iCap_PalabrasClaves2"  name="tb_iCap_PalabrasClaves2" value="{$capa.Cap_PalabrasClaves2|default}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label  class="control-label" for="tb_iCap_Resumen">Resumen</label>
                                                            <textarea type="text" class="form-control" id="tb_iCap_Resumen"  name="tb_iCap_Resumen" >{$capa.Cap_Resumen|default}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label  class="control-label" for="tb_iCap_Descripcion">Descripcion</label>
                                                            <textarea type="text" class="form-control" id="tb_iCap_Descripcion"  name="tb_iCap_Descripcion" >{$capa.Cap_Descripcion|default}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label  class="control-label" for="tb_iCap_Creditos">Créditos</label>
                                                            <textarea type="text" class="form-control" id="tb_iCap_Creditos"  name="tb_iCap_Creditos" >{$capa.Cap_Creditos|default}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Leyenda:</label>
                                                            <div class="panel with-nav-tabs panel-default">                                                 <div class="panel-heading">
                                                                    <ul class="nav nav-tabs">
                                                                        <li class="active"><a href="#tab1default" data-toggle="tab">Url</a></li>
                                                                        <li><a href="#tab2default" data-toggle="tab">Imagen</a></li>
                                                                    </ul>
                                                            </div>
                                                                <div class="panel-body">
                                                                    <div class="tab-content">
                                                                        <div class="tab-pane fade in active" id="tab1default">
                                                                            {if isset($twms)&&!empty($twms)}
                                                                                <a id="sp_load_capa" style="cursor: pointer;"  layer="{$capa.Cap_Nombre|default}" >GetLegend Url</a>
                                                                            {/if}
                                                                            <input type="url" id="tb_leyendaurl" name="tb_leyendaurl" style="width: 100%" name="tb_leyendaurl"  value="{$capa.Cap_Leyenda|default}" >
                                                                        </div>
                                                                        <div class="tab-pane fade" id="tab2default">   
                                                                            <input type="file" name="fl_leyenda" id='fl_leyenda' />
                                                                            <input type="hidden" name="hd_leyenda" id='hd_leyenda' value=""/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fl_imagenprev">Imagen: <small>Vista previa de la Capa</span> </small>
                                                                <input class="form-control" class="form-control" type="file" name="fl_imagenprev" id='fl_imagenprev' />
                                                                <input type="hidden" name="hd_imagenprev" id='hd_imagenprev' value=""/>
                                                        </div>
                                                        {if isset($twms)&&!empty($twms)&& isset($gestoravanzado)}
                                                            <div  class="form-group">
                                                                <button id="bt_vistaprevia" class="btn btn-default" type="button" ><span class="glyphicon glyphicon-eye-open"></span>Vista Previa</button>              
                                                            </div>
                                                        {/if}           
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 data-toggle="collapse"  href="#collapse2" class="panel-title"><strong>1. Metadatos</strong></h3>
                                            </div>
                                            <div id="collapse2" class="panel-collapse collapse " >
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label  class="control-label" for="tb_iCap_IdentificadorFichero1">Identificador del Fichero</label>
                                                        <input type="text" class="form-control" id="tb_iCap_IdentificadorFichero1"  name="tb_iCap_IdentificadorFichero1" value="{$capa.Cap_IdentificadorFichero1|default}">
                                                    </div> 
                                                    <div class="form-group">
                                                        <label  class="control-label" for="tb_iCap_Idioma1">Idioma</label>
                                                        <input type="text" class="form-control" id="tb_iCap_Idioma1"  name="tb_iCap_Idioma1" value="{$capa.Cap_Idioma1|default}">
                                                    </div> 
                                                    <div class="form-group">
                                                        <label  class="control-label" for="tb_iCap_FechaCreacion1">Fecha de Creación*</label>
                                                        <input type="text" class="form-control" id="tb_iCap_Idioma1"  name="tb_iCap_FechaCreacion1" value="{$capa.Cap_FechaCreacion1|default}">
                                                    </div> 
                                                    <div class="form-group">
                                                        <label  class="control-label" for="tb_iCap_NormaMetadatos1">Norma de Metadatos*</label>
                                                        <input type="text" class="form-control" id="tb_iCap_NormaMetadatos1"  name="tb_iCap_NormaMetadatos1" value="{$capa.Cap_NormaMetadatos1|default}">
                                                    </div> 
                                                    <div class="form-group">
                                                        <label  class="control-label" for="tb_iCap_VersionNormaMetadatos1">Versión de Norma de Metadatos*</label>
                                                        <input type="text" class="form-control" id="tb_iCap_VersionNormaMetadatos1"  name="tb_iCap_VersionNormaMetadatos1"  value="{$capa.Cap_VersionNormaMetadatos1|default}">
                                                    </div> 
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Contacto</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_NombreIndividualdeContacto1">Nombre Individual</label>
                                                                <input type="text" class="form-control" id="tb_iCap_NombreIndividualdeContacto1"  name="tb_iCap_NombreIndividualdeContacto1" value="{$capa.Cap_NombreIndividualdeContacto1|default}">
                                                            </div> 
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_NombredelaOrganizaciondeContacto1">Nombre de la Organización*</label>
                                                                <input type="text" class="form-control" id="tb_iCap_NombredelaOrganizaciondeContacto1"  name="tb_iCap_NombredelaOrganizaciondeContacto1" value="{$capa.Cap_NombredelaOrganizaciondeContacto1|default}">
                                                            </div> 
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_CorreodelContacto1">Dirección de Correo Electrónico</label>
                                                                <input type="text" class="form-control" id="tb_iCap_CorreodelContacto1"  name="tb_iCap_CorreodelContacto1" value="{$capa.Cap_CorreodelContacto1|default}">
                                                            </div> 
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_RoldelContacto1">Rol</label>
                                                                <input type="text" class="form-control" id="tb_iCap_RoldelContacto1"  name="tb_iCap_RoldelContacto1" value="{$capa.Cap_RoldelContacto1|default}">
                                                            </div>                 
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 data-toggle="collapse"  href="#collapse3" class="panel-title"><strong>2. Información de Identificación</strong></h3>
                                            </div>
                                            <div id="collapse3" class="panel-collapse collapse " >
                                                <div class="panel-body">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Mención</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_TituloMencion2">Título</label>
                                                                <input type="text" class="form-control" id="tb_iCap_TituloMencion2"  name="tb_iCap_TituloMencion2" value="{$capa.Cap_TituloMencion2|default}">
                                                            </div>   
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title"><strong>Fecha</strong></h3>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_FechaMencion2">Fecha</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_FechaMencion2"  name="tb_iCap_FechaMencion2" value="{$capa.Cap_FechaMencion2|default}">
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_TipoFechaMencion2">Tipo de Fecha</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_TipoFechaMencion2"  name="tb_iCap_TipoFechaMencion2" value="{$capa.Cap_TipoFechaMencion2|default}">
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_FormaPresentacionMencion2">Forma de Presentación</label>
                                                                <input type="text" class="form-control" id="tb_iCap_FormaPresentacionMencion2"  name="tb_iCap_FormaPresentacionMencion2" value="{$capa.Cap_FormaPresentacionMencion2|default}">
                                                            </div>  
                                                        </div> 
                                                    </div>
                                                    <div class="form-group">
                                                        <label  class="control-label" for="tb_iCap_Resumen2">Resumen*</label>
                                                        <textarea type="text" class="form-control" id="tb_iCap_Resumen2"  name="tb_iCap_Resumen2">{$capa.Cap_Resumen2|default}</textarea>
                                                    </div> 
                                                    <div class="form-group">
                                                        <label  class="control-label" for="tb_iCap_Proposito2">Propósito</label>
                                                        <input type="text" class="form-control" id="tb_iCap_Proposito2"  name="tb_iCap_Proposito2"  value="{$capa.Cap_Proposito2|default}">
                                                    </div> 
                                                    <div class="form-group">
                                                        <label  class="control-label" for="tb_iCap_Estado2">Estado</label>
                                                        <input type="text" class="form-control" id="tb_iCap_Estado2"  name="tb_iCap_Estado2" value="{$capa.Cap_Estado2|default}">
                                                    </div> 
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Punto de Contacto</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_NombreIndividualPuntoContacto2">Nombre Individual</label>
                                                                <input type="text" class="form-control" id="tb_iCap_NombreIndividualPuntoContacto2"  name="tb_iCap_NombreIndividualPuntoContacto2" value="{$capa.Cap_NombreIndividualPuntoContacto2|default}">
                                                            </div> 
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_NombreOrganizacionPuntoContacto2">Nombre de la Organización</label>
                                                                <input type="text" class="form-control" id="tb_iCap_NombreOrganizacionPuntoContacto2"  name="tb_iCap_NombreOrganizacionPuntoContacto2" value="{$capa.Cap_NombreOrganizacionPuntoContacto2|default}">
                                                            </div> 
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_CorreoElectronicoPuntoContacto2">Dirección de Correo Electrónico</label>
                                                                <input type="text" class="form-control" id="tb_iCap_CorreoElectronicoPuntoContacto2"  name="tb_iCap_CorreoElectronicoPuntoContacto2" value="{$capa.Cap_CorreoElectronicoPuntoContacto2|default}">
                                                            </div> 
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_RolPuntodeContacto2">Rol</label>
                                                                <input type="text" class="form-control" id="tb_iCap_RolPuntodeContacto2"  name="tb_iCap_RolPuntodeContacto2" value="{$capa.Cap_RolPuntodeContacto2|default}">
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Vista del Gráfico</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_NombreFicherodeVistadelGrafico2">Nombre del Fichero</label>
                                                                <input type="text" class="form-control" id="tb_iCap_NombreFicherodeVistadelGrafico2"  name="tb_iCap_NombreFicherodeVistadelGrafico2"  value="{$capa.Cap_NombreFicherodeVistadelGrafico2|default}">
                                                            </div> 
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_DescripcionFicherodeVistadelGrafico2">Descripción del Fichero</label>
                                                                <input type="text" class="form-control" id="tb_iCap_DescripcionFicherodeVistadelGrafico2"  name="tb_iCap_DescripcionFicherodeVistadelGrafico2" value="{$capa.Cap_DescripcionFicherodeVistadelGrafico2|default}">
                                                            </div> 
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_TipoFicherodeVistadelGrafico2">Tipo de Fichero</label>
                                                                <input type="text" class="form-control" id="tb_iCap_TipoFicherodeVistadelGrafico2"  name="tb_iCap_TipoFicherodeVistadelGrafico2" value="{$capa.Cap_TipoFicherodeVistadelGrafico2|default}">
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Descripción de Palabras Clave</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_PalabraClaveDescripcionPC2">Palabra clave</label>
                                                                <input type="text" class="form-control" id="tb_iCap_PalabraClaveDescripcionPC2"  name="tb_iCap_PalabraClaveDescripcionPC2" value="{$capa.Cap_PalabraClaveDescripcionPC2|default}">
                                                            </div> 
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_TipoDescripcionPC2">Tipo</label>
                                                                <input type="text" class="form-control" id="tb_iCap_TipoDescripcionPC2"  name="tb_iCap_TipoDescripcionPC2" value="{$capa.Cap_TipoDescripcionPC2|default}">
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label  class="control-label" for="tb_iCap_TipodeRepresentacionEspacial2">Tipo de Representación Espacial</label>
                                                        <input type="text" class="form-control" id="tb_iCap_TipodeRepresentacionEspacial2"  name="tb_iCap_TipodeRepresentacionEspacial2" value="{$capa.Cap_TipodeRepresentacionEspacial2|default}">
                                                    </div> 
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Resolución Espacial</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_ResolucionEspacial2">Denominador</label>
                                                                <input type="text" class="form-control" id="tb_iCap_ResolucionEspacial2"  name="tb_iCap_ResolucionEspacial2" value="{$capa.Cap_ResolucionEspacial2|default}"
                                                                       >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label  class="control-label" for="tb_iCap_Idioma2">Idioma</label>
                                                        <input type="text" class="form-control" id="tb_iCap_Idioma2"  name="tb_iCap_Idioma2"  value="{$capa.Cap_Idioma2|default}"
                                                               >
                                                    </div> 
                                                    <div class="form-group">
                                                        <label  class="control-label" for="tb_iCap_CategoriadeTema2">Categoría de Temas</label>
                                                        <input type="text" class="form-control" id="tb_iCap_CategoriadeTema2"  name="tb_iCap_CategoriadeTema2" value="{$capa.Cap_CategoriadeTema2|default}"
                                                               >
                                                    </div> 

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Extensión</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title"><strong>Elemento Geográfico</strong></h3>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_LimiteLongitudOeste2">Límite de Longitud Oeste</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_LimiteLongitudOeste2"  name="tb_iCap_LimiteLongitudOeste2" value="{$capa.Cap_LimiteLongitudOeste2|default}"
                                                                               >
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_LimiteLongitudEste2">Límite de Longitud Este</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_LimiteLongitudEste2"  name="tb_iCap_LimiteLongitudEste2" value="{$capa.Cap_LimiteLongitudEste2|default}"
                                                                               >
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_LimiteLatitudSur2">Límite de Latitud Sur</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_LimiteLatitudSur2"  name="tb_iCap_LimiteLatitudSur2" value="{$capa.Cap_LimiteLatitudSur2|default}"
                                                                               >
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_LimiteLatitudNorte2">Límite de Latitud Norte</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_LimiteLatitudNorte2"  name="tb_iCap_LimiteLatitudNorte2" value="{$capa.Cap_LimiteLatitudNorte2|default}"
                                                                               >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title"><strong>Elemento Temporal</strong></h3>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_Extension2">Extensión</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_Extension2"  name="tb_iCap_Extension2" value="{$capa.Cap_Extension2|default}"
                                                                               >
                                                                    </div> 
                                                                </div>
                                                            </div>

                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title"><strong>Elemento Vertical</strong></h3>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_iCap_ValorMinimo2">Valor Mínimo</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_ValorMinimo2"  name="tb_iCap_ValorMinimo2" value="{$capa.Cap_ValorMinimo2|default}"
                                                                               >
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_ValorMaximo2">Valor Máximo</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_ValorMaximo2"  name="tb_iCap_ValorMaximo2" value="{$capa.Cap_ValorMaximo2|default}"
                                                                               >
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_UnidadesdeMedida2">Unidades de Medida</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_UnidadesdeMedida2"  name="tb_iCap_UnidadesdeMedida2" value="{$capa.Cap_UnidadesdeMedida2|default}"
                                                                               >
                                                                    </div>                        
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 data-toggle="collapse"  href="#collapse4" class="panel-title"><strong>3. Información de Constricciones</strong></h3>
                                            </div>
                                            <div id="collapse4" class="panel-collapse collapse " >
                                                <div class="panel-body">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Información de Constricciones Legales</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_LimitaciondeUso3">Limitación de Uso</label>
                                                                <input type="text" class="form-control" id="tb_iCap_LimitaciondeUso3"  name="tb_iCap_LimitaciondeUso3" value="{$capa.Cap_LimitaciondeUso3|default}"
                                                                       >
                                                            </div> 
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_ConstriccionesdeAcceso3">Constricciones de Acceso</label>
                                                                <input type="text" class="form-control" id="tb_iCap_ConstriccionesdeAcceso3"  name="tb_iCap_ConstriccionesdeAcceso3" value="{$capa.Cap_ConstriccionesdeAcceso3|default}"
                                                                       >
                                                            </div> 
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_ConstriccionesdeUso3">Constricciones de Uso</label>
                                                                <input type="text" class="form-control" id="tb_iCap_ConstriccionesdeUso3"  name="tb_iCap_ConstriccionesdeUso3"  value="{$capa.Cap_ConstriccionesdeUso3|default}"
                                                                       > 
                                                            </div> 
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_ConstriccionesdeOtroTipo3">Constricciones de Otro Tipo</label>
                                                                <input type="text" class="form-control" id="tb_iCap_ConstriccionesdeOtroTipo3"  name="tb_iCap_ConstriccionesdeOtroTipo3" value="{$capa.Cap_ConstriccionesdeOtroTipo3|default}"
                                                                       >
                                                            </div> 
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>  
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 data-toggle="collapse"  href="#collapse5" class="panel-title"><strong>4. Información de Calidad de los Datos</strong></h3>
                                            </div>
                                            <div id="collapse5" class="panel-collapse collapse " >
                                                <div class="panel-body">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Ámbito</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_Nivel4">Nivel</label>
                                                                <input type="text" class="form-control" id="tb_iCap_Nivel4"  name="tb_iCap_Nivel4" value="{$capa.Cap_Nivel4|default}"
                                                                       >
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Linaje</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_Declaracion4">Declaración</label>
                                                                <input type="text" class="form-control" id="tb_iCap_Declaracion4"  name="tb_iCap_Declaracion4" value="{$capa.Cap_Declaracion4|default}"
                                                                       >
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 data-toggle="collapse"  href="#collapse6" class="panel-title"><strong>5. Información de Mantenimiento</strong></h3>
                                            </div>
                                            <div id="collapse6" class="panel-collapse collapse " >
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label  class="control-label" for="tb_iCap_FrecuenciadeMantenimientoyActualizacion5">Frecuencia de Mantenimiento y Actualización</label>
                                                        <input type="text" class="form-control" id="tb_iCap_FrecuenciadeMantenimientoyActualizacion5"  name="tb_iCap_FrecuenciadeMantenimientoyActualizacion5"  value="{$capa.Cap_FrecuenciadeMantenimientoyActualizacion5|default}"
                                                               >
                                                    </div> 
                                                    <div class="form-group">
                                                        <label  class="control-label" for="tb_iCap_FechaProximaActualizacion5">Fecha de la Próxima Actualización</label>
                                                        <input type="text" class="form-control" id="tb_iCap_FechaProximaActualizacion5"  name="tb_iCap_FechaProximaActualizacion5"  value="{$capa.Cap_FechaProximaActualizacion5|default}"
                                                               >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 data-toggle="collapse"  href="#collapse7" class="panel-title"><strong>6. Representación Espacial</strong></h3>
                                            </div>
                                            <div id="collapse7" class="panel-collapse collapse " >
                                                <div class="panel-body">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Representación Espacial Vectorial</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_NivelTopologia6">Nivel de Topología</label>
                                                                <input type="text" class="form-control" id="tb_iCap_NivelTopologia6"  name="tb_iCap_NivelTopologia6" value="{$capa.Cap_NivelTopologia6|default}"
                                                                       >
                                                            </div>    
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title"><strong>Objetos Geométricos</strong></h3>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_TipoObjetoGeometrico6">Tipo de Objeto Geométrico</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_TipoObjetoGeometrico6"  name="tb_iCap_TipoObjetoGeometrico6" value="{$capa.Cap_TipoObjetoGeometrico6|default}"
                                                                               >
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_NumerodeDimensiones6">Número de Dimensiones</label>
                                                                <input type="text" class="form-control" id="tb_iCap_NumerodeDimensiones6"  name="tb_iCap_NumerodeDimensiones6" value="{$capa.Cap_NumerodeDimensiones6|default}"
                                                                       >
                                                            </div> 
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title"><strong>Propiedades de las Dimensiones de los Ejes</strong></h3>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_NombredeDimension6">Nombre de la Dimensión</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_NombredeDimension6"  name="tb_iCap_NombredeDimension6" value="{$capa.Cap_NombredeDimension6|default}">
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_TamañodeDimension6">Tamaño de la Dimensión</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_TamañodeDimension6"  name="tb_iCap_TamañodeDimension6" value="{$capa.Cap_TamanodeDimension6|default}">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label  class="control-label" for="tb_iCap_Resolucion6">Resolución</label>
                                                                        <input type="text" class="form-control" id="tb_iCap_Resolucion6"  name="tb_iCap_Resolucion6" value="{$capa.Cap_Resolucion6|default}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 data-toggle="collapse"  href="#collapse8" class="panel-title"><strong>7. Información del Sistema de Referencia</strong></h3>
                                            </div>
                                            <div id="collapse8" class="panel-collapse collapse " >
                                                <div class="panel-body">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Identificador del Sistema de Referencia</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_Codigo7">Código</label>
                                                                <input type="text" class="form-control" id="tb_iCap_Codigo7"  name="tb_iCap_Codigo7" value="{$capa.Cap_Codigo7|default}"
                                                                       >

                                                            </div>
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_CodigoSitio7">Código del Sitio</label>
                                                                <input type="text" class="form-control" id="tb_iCap_CodigoSitio7"  name="tb_iCap_CodigoSitio7"  value="{$capa.Cap_CodigoSitio7|default}"
                                                                       >

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 data-toggle="collapse"  href="#collapse9" class="panel-title"><strong>8. Información de Distribución</strong></h3>
                                            </div>
                                            <div id="collapse9" class="panel-collapse collapse " >
                                                <div class="panel-body">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Formato de Distribución</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_Nombre8">Nombre</label>
                                                                <input type="text" class="form-control" id="tb_iCap_Nombre8"  name="tb_iCap_Nombre8" value="{$capa.Cap_Nombre8|default}"
                                                                       >

                                                            </div>
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_Version8">Versión</label>
                                                                <input type="text" class="form-control" id="tb_iCap_Version8"  name="tb_iCap_Version8" value="{$capa.Cap_Version8|default}"
                                                                       >

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Opciones de Transferencia</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_Enlace8">Enlace</label>
                                                                <input type="text" class="form-control" id="tb_iCap_Enlace8"  name="tb_iCap_Enlace8" value="{$capa.Cap_Enlace8|default}"
                                                                       >

                                                            </div>
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_Protocolo8">Protocolo</label>
                                                                <input type="text" class="form-control" id="tb_iCap_Protocolo8"  name="tb_iCap_Protocolo8" value="{$capa.Cap_Protocolo8|default}"
                                                                       >

                                                            </div>
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_NombreOpcionesTransferencia8">Nombre</label>
                                                                <input type="text" class="form-control" id="tb_iCap_NombreOpcionesTransferencia8"  name="tb_iCap_NombreOpcionesTransferencia8" value="{$capa.Cap_NombreOpcionesTransferencia8|default}"
                                                                       >

                                                            </div>
                                                            <div class="form-group">
                                                                <label  class="control-label" for="tb_iCap_Descripcion8">Descripción</label>
                                                                <textarea type="text" class="form-control" id="tb_iCap_Descripcion8"  name="tb_iCap_Descripcion8" >{$capa.Cap_Descripcion8|default}</textarea>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="form-group">
                                            {if isset($capa)}
                                                <button type="submit"  class="btn btn-success"  name="bt_editar_capa" id="bt_editar_capa"><i class="glyphicon glyphicon-floppy-disk"> </i>Editar</button>

                                            {else}
                                                <button  {if isset($tjson)}id="bt_guardar_json"{/if}{if isset($trss)}id="bt_guardar_rss"{/if}{if isset($twms)}id="bt_guardar_wms"{/if} {if isset($tkml)}id="bt_guardar_kml"{/if} type="button"  class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"> </i>Guardar</button>
                                            {/if}
                                            <a class="btn btn-danger" href="{$_layoutParams.root}mapa/gestorcapa/{if isset($trss)}geojson{/if}{if isset($trss)}georss{/if}{if isset($twms)}wms{/if}{if isset($tkml)}kml{/if}"><i class="glyphicon glyphicon-remove-sign"> </i> Cancelar</a>
                                        </div>
                                    {/if}
                                </div>
                                <div  class="col-md-7">
                                    <div id="panel">   
                                        <input onclick="removerCapas();" type=button value="Limpiar Mapa">
                                    </div>
                                    <div id='map' class="map"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> 
            </div>
        {/if}
        <!--==Seccion Lisatdo de Capas===-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;
                    <strong>Lista de Capas</strong> 
                </h4>
            </div>   
            <div class="panel-body">
                <div class="col-md-12 pull-right form-inline text-right">
                    <div class="input-group">
                        <input id="tb_buscar_filter" type="text" class="form-control"  placeholder="Buscar capa" value="{$buscar|default}" />                     
                        <span class="input-group-btn">
                            <button id="bt_buscar_filter" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </div>            
            </div>
            <div id="gestorcapa_lista_capas" >
                {if isset($capas) && count($capas)}
                    <div  class="table-responsive">
                        <table class="table table-hover table-condensed" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Titulo</th>                   
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Url</th>                               
                                    <th style=" text-align: center">Estado</th>
                                    <th>Opciones</th>

                                </tr>
                            </thead>                  
                            <tbody>
                                {foreach item=datos from=$capas}
                                    <tr>                       
                                        <td>{$numeropagina++}</td>
                                        <td>{$datos.Cap_Titulo|truncate:30:"...":true}</td>
                                        <td>{$datos.Cap_Nombre|truncate:30:"...":true}</td>
                                        <td>{$datos.tic_Nombre}</td>
                                        <td class="col-md-4">
                                            <div style="max-width: 500px; margin: auto; 
                                                 word-wrap: break-word">
                                                {$datos.Cap_UrlBase|truncate:50:"...":true}
                                            </div> 
                                        </td>                                
                                        <td style=" text-align: center">
                                            {if $datos.Cap_Estado==0}
                                                <i class="glyphicon glyphicon-remove-sign" title="Desabilitado" style="color: #DD4B39;"/>
                                            {else}
                                                <i class="glyphicon glyphicon-ok-sign" title="Habilitado" style="color: #088A08;"/>
                                            {/if}
                                        </td>
                                        <td>
                                            {if $_acl->permiso("editar_capa")}
                                                <a class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}mapa/gestorcapa/{$datos.tic_Nombre}/{$datos.Cap_Idcapa}"></a>                                          
                                            {/if}
                                            {if $_acl->permiso("habilitar_deshabilitar_capa")}
                                                <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-capa" title="{$lenguaje.label_cambiar_estado}" idcapa="{$datos.Cap_Idcapa}" estado="{if $datos.Cap_Estado==0}1{else}0{/if}"> </a>      
                                            {/if}
                                            {if $_acl->permiso("eliminar_capa")}
                                                <a data-href="{$datos.Cap_Idcapa}" data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="{$lenguaje.label_eliminar}"  data-nombre="{$datos.Cap_Titulo}" class="btn btn-default btn-sm glyphicon glyphicon-trash">
                                                </a>
                                            {/if}
                                        </td>
                                    </tr>                     
                                {/foreach}
                            </tbody>
                        </table>
                    </div>          
                    {$paginacion|default}  
                {else}
                    Sin datos;
                {/if}
            </div>
        </div>
    </div>  
</div>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmación de Eliminación</h4>
            </div>

            <div class="modal-body">
                <p>Estás a punto de borrar una capa, este procedimiento es irreversible</p>
                <p>¿Deseas Continuar?</p>
                <p>Eliminar: <strong class="nombre-capa"></strong></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a style="cursor:pointer" capa="" data-dismiss="modal" class="btn btn-danger danger delete">Eliminar</a>
            </div>
        </div>
    </div>
</div>
