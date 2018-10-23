<div id="recursos" class="container-fluid" >
    <div class="row">
        <div class="col-md-12">
            <h2><center>{$lenguaje["label_h3_titulo_bdrecursos"]} {$recurso.Rec_Nombre}</center></h2>
            <input type="hidden" id="hd_id_recurso" value="{$recurso.Rec_IdRecurso}">
            <br>          
        </div>
        <div  class="col-md-12">     
            <div class="panel-group" >
                <div class="panel panel-default metadata">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <strong>{$lenguaje["label_registros_bdrecursos"]} {$recurso.Esr_Nombre}</strong>
                        </h4>
                        <div class="pull-right">
                        </div>
                    </div> 
                    {if isset($capas)}
                        <table class="table table-condensed" >   
                            {foreach item=datos from=$capas}
                                <tr>  
                                    <td>                                            
                                        <div class="row-fluid">
                                            <div class="col-md-3">
                                                <img src="http://placehold.it/380x500" alt="{$datos.Cap_imagenprev}" class="img-rounded img-responsive" />
                                            </div>
                                            <div class="col-md-9 table-responsive">
                                                <table class="table table-user-information">
                                                    <tbody>                           
                                                        <tr>
                                                            <td>{$lenguaje["label_titulo_bdrecursos"]}: </td>
                                                            <td>{$datos.Cap_Titulo}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{$lenguaje["label_nombre_bdrecursos"]}: </td>
                                                            <td>{$datos.Cap_Nombre}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{$lenguaje["label_tipo_bdrecursos"]}:</td>
                                                            <td>{$datos.tic_Nombre}</td>
                                                        </tr>                                                          
                                                        <tr>
                                                            <td>{$lenguaje["label_url_bdrecursos"]}:</td>
                                                            <td><p>{$datos.Cap_UrlBase}</p></td>
                                                        </tr>
                                                        <tr>
                                                            <td>{$lenguaje["label_fuente_bdrecursos"]}:</td>
                                                            <td>{$datos.Cap_Fuente}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{$lenguaje["label_resumen_bdrecursos"]}:</td>
                                                            <td><p>{$datos.Cap_Resumen}</p> </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{$lenguaje["label_descripcion_bdrecursos"]}:</td>
                                                            <td>
                                                                <p >{$datos.Cap_Descripcion}</p>                       
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>{$lenguaje["label_creditos_bdrecursos"]}:</td>
                                                            <td>{$datos.Cap_Creditos}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>{$lenguaje["label_leyenda_bdrecursos"]}:</td>
                                                            <td>{$datos.Cap_Leyenda}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>  
                                            </div>
                                        </div>
                                    </td>                
                                </tr>                     
                            {/foreach}
                        </table>
                    {else if isset($calidadagua)}
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 ">   
                                    <div class="col-md-4 pull-right">
                                        <div class="input-group">
                                            <input id="tb_nombre_filter" type="text" class="form-control"  placeholder="variable|símbolo|estación" value="{$nombre|default}" />                     
                                            <span class="input-group-btn">
                                                <button id="bt_buscar_calidadagua" class="btn btn-success" type="button">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </span>
                                        </div>  
                                    </div>
                                </div>
                            </div>                                           
                        </div>
                        <div id="metadata_lista_calidadagua">
                            {if count($calidadagua)}
                                <table class="table table-hover table-condensed" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{$lenguaje["label_variable_bdrecursos"]}</th><th>{$lenguaje["label_simbolo_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_valor_colecta_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_fecha_colecta_bdrecursos"]}</th>
                                            <th class="col-md-2">{$lenguaje["label_estacion_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_longitud_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_latitud_bdrecursos"]}</th>  
                                            <th style=" text-align: center">Estado</th>          
                                            <th style=" text-align: center">Opciones</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        {foreach item=datos from=$calidadagua}
                                            <tr>
                                                <td>{$numeropagina++}</td>
                                                <td>{$datos.Var_Nombre}</td>
                                                <td>{$datos.Var_Abreviatura}</td>
                                                <td>{$datos.Mca_Valor}</td>
                                                <td>
                                                    {if ($datos.Mca_Fecha|count_characters:true)<=7}
                                                    {$datos.Mca_Fecha}
                                                    {elseif ($datos.Mca_Fecha|count_characters:true)==10}
                                                    {$datos.Mca_Fecha|date_format:"%d/%m/%Y"}                                    
                                                    {else}
                                                    {$datos.Mca_Fecha|date_format:"%d/%m/%Y %H:%M"}                                    
                                                    {/if}                                                                                         
                                                </td>
                                                <td class="col-md-2"><p>{$datos.Esm_Nombre}</p></td>
                                                <td>{$datos.Esm_Longitud}</td>
                                                <td>{$datos.Esm_Latitud}</td>
                                                <td style=" text-align: center">
                                                    {if {$datos.Mca_Estado}==0}
                                                        <i class="glyphicon glyphicon-remove-sign" title="deshabilitado" style="color: #DD4B39;"/>
                                                    {else}
                                                        <i class="glyphicon glyphicon-ok-sign" title="habilitado" style="color: #088A08;"/>
                                                    {/if}
                                                </td>
                                                <td>
                                                    <a type="button" title="{$lenguaje["label_mas_detalle_bdrecursos"]}" class="btn btn-default btn-sm glyphicon glyphicon-search" href="{$_layoutParams.root}calidaddeagua/monitoreo/metadata/{$datos.Mca_IdMonitoreoCalidadAgua}" target="_blank">
                                                    </a>
                                                    {if $_acl->permiso("editar_registros_recurso")}
                                                        <a type="button" title="{$lenguaje["label_editar_bdrecursos"]}" class="btn btn-default btn-sm glyphicon glyphicon-edit" href="{$_layoutParams.root}calidaddeagua/monitoreo/editar/{$datos.Mca_IdMonitoreoCalidadAgua}" target="_blank">
                                                        </a>
                                                    {/if}
                                                    {if $_acl->permiso("habilitar_deshabilitar_registros_recurso")}
                                                        <a class="btn btn-default btn-sm glyphicon glyphicon-refresh ce_calidadagua" id_mca="{$datos.Mca_IdMonitoreoCalidadAgua}" estado_mca="{if $datos.Mca_Estado==0}1{else}0{/if}"  title="{$lenguaje["cambiar_estado_bdrecursos"]}" > </a>
                                                    {/if}
                                                    {if $_acl->permiso("eliminar_registros_recurso")}                                                       
                                                         <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="{$lenguaje["label_eliminar_bdrecursos"]}" data-id="{$datos.Mca_IdMonitoreoCalidadAgua}" data-nombre="{$datos.Var_Nombre}" class="btn btn-default btn-sm glyphicon glyphicon-trash" >
                                                        </a>
                                                    {/if}
                                                </td>
                                            </tr>
                                        {/foreach} 
                                    </tbody>
                                </table>
                                {$paginacion|default:""}
                            {else}
                                {$lenguaje["label_sin_resultados_bdrecursos"]}
                            {/if}
                        </div>
                    {else if isset($dublin)}  
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 ">   
                                    <div class="col-md-4 pull-right">
                                        <div class="input-group">
                                            <input id="tb_nombre_filter" type="text" class="form-control"  placeholder="nombre|descripcion|autor|keys" value="{$nombre|default}" />                     
                                            <span class="input-group-btn">
                                                <button id="bt_buscar_dublin" class="btn btn-success" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                            </span>
                                        </div>  
                                    </div>
                                </div>
                            </div>                                           
                        </div>
                        <div id="metadata_lista_dublin" class="table-responsive">
                            {if count($dublin)}                                                
                                <table class="table table-hover table-condensed" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="col-md-2">{$lenguaje["label_titulo_bdrecursos"]}</th>                   
                                            <th class="col-md-2">{$lenguaje["label_descripcion_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_tipo_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_formato_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_idioma_bdrecursos"]}</th> 
                                            <th class="col-md-2">{$lenguaje["label_autor_bdrecursos"]}</th> 
                                            <th style=" text-align: center">Estado</th>          
                                            <th style=" text-align: center">Opciones</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        {foreach item=datos from=$dublin}
                                            <tr>
                                                <td>{$numeropagina++}</td>
                                                <td class="col-md-2">{$datos.Dub_Titulo|truncate:60:"...":true}</td>
                                                <td class="col-md-2">{$datos.Dub_Descripcion|truncate:60:"...":true}</td>
                                                <td>{$datos.Tid_Descripcion|truncate:60:"...":true}</td>
                                                <td>{$datos.Dub_Formato}</td>
                                                <td><p>{$datos.Dub_Idioma}</p></td>
                                                <td class="col-md-2">{$datos.Aut_Nombre|truncate:40:"...":true}</td>
                                                <td style=" text-align: center">
                                                    {if {$datos.Dub_Estado}==0}
                                                        <i class="glyphicon glyphicon-remove-sign" title="deshabilitado" style="color: #DD4B39;"/>
                                                    {else}
                                                        <i class="glyphicon glyphicon-ok-sign" title="habilitado" style="color: #088A08;"/>
                                                    {/if}
                                                </td>
                                                <td>
                                                    <a type="button" title="{$lenguaje["label_mas_detalle_bdrecursos"]}" class="btn btn-default btn-sm glyphicon glyphicon-search" href="{$_layoutParams.root}dublincore/documentos/metadata/{$datos.Dub_IdDublinCore}" target="_blank">
                                                    </a>
                                                    {if $_acl->permiso("editar_registros_recurso")}
                                                        <a type="button" title="{$lenguaje["label_editar_bdrecursos"]}" class="btn btn-default btn-sm glyphicon glyphicon-edit" href="{$_layoutParams.root}dublincore/editar/index/{$datos.Dub_IdDublinCore}" target="_blank">
                                                        </a>
                                                    {/if}
                                                    {if $_acl->permiso("habilitar_deshabilitar_registros_recurso")}
                                                        <a class="btn btn-default btn-sm glyphicon glyphicon-refresh ce_dublin" id_dublin="{$datos.Dub_IdDublinCore}" estado_dublin="{if $datos.Dub_Estado==0}1{else}0{/if}"  title="{$lenguaje["cambiar_estado_bdrecursos"]}" > </a>
                                                    {/if}
                                                    {if $_acl->permiso("eliminar_registros_recurso")}
                                                         <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="{$lenguaje["label_eliminar_bdrecursos"]}" data-id='{$datos.Dub_IdDublinCore}' data-nombre="{$datos.Dub_Titulo}" class="btn btn-default btn-sm glyphicon glyphicon-trash" >
                                                        </a>
                                                    {/if}
                                                </td>
                                            </tr>
                                        {/foreach} 
                                    </tbody>
                                </table>
                                {$paginacion|default:""}
                            {else}
                                {$lenguaje["label_sin_resultados_bdrecursos"]}
                            {/if}
                        </div>
                    {else if isset($plinian)}  
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 ">   
                                    <div class="col-md-4 pull-right">
                                        <div class="input-group">
                                            <input id="tb_nombre_filter" type="text" class="form-control"  placeholder="nombre científico o común|descripción" value="{$nombre|default}" />                     
                                            <span class="input-group-btn">
                                                <button id="bt_buscar_plinian" class="btn btn-success" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                            </span>
                                        </div>  
                                    </div>
                                </div>
                            </div>                                           
                        </div>
                        <div id="metadata_lista_plinian" class="table-responsive">
                            {if count($plinian)}
                                 <table class="table table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="col-md-2">{$lenguaje["label_nombre_cientifico_bdrecursos"]}</th>                   
                                            <th class="col-md-1">{$lenguaje["label_nombre_comun_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_reino_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_orden_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_clase_bdrecursos"]}</th> 
                                            <th>{$lenguaje["label_familia_bdrecursos"]}</th> 
                                            <th class="col-md-2">{$lenguaje["label_descripcion_general_bdrecursos"]}</th>
                                            <th style=" text-align: center">Estado</th>          
                                            <th style=" text-align: center">Opciones</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        {foreach item=datos from=$plinian}
                                            <tr>
                                                <td>{$numeropagina++}</td>
                                                <td class="col-md-2">{$datos.Pli_NombreCientifico}</td>
                                                <td class="col-md-1">{$datos.Pli_NombresComunes}</td>
                                                <td>{$datos.Pli_Reino}</td>
                                                <td>{$datos.Pli_Orden}</td>
                                                <td><p>{$datos.Pli_Clase}</p></td>
                                                <td>{$datos.Pli_Familia}</td>                  
                                                <td class="col-md-2">{$datos.Pli_DescripcionGeneral|truncate:60:"...":true}</td>
                                                <td style=" text-align: center">
                                                    {if {$datos.Pli_Estado}==0}
                                                        <i class="glyphicon glyphicon-remove-sign" title="deshabilitado" style="color: #DD4B39;"/>
                                                    {else}
                                                        <i class="glyphicon glyphicon-ok-sign" title="habilitado" style="color: #088A08;"/>
                                                    {/if}
                                                </td>
                                                <td>
                                                    <a type="button" title="{$lenguaje["label_mas_detalle_bdrecursos"]}" class="btn btn-default btn-sm glyphicon glyphicon-search" href="{$_layoutParams.root}atlas/botanico/metadata/{$datos.Pli_IdPlinian}" target="_blank">
                                                    </a>
                                                    {if $_acl->permiso("editar_registros_recurso")}
                                                        <a type="button" title="{$lenguaje["label_editar_bdrecursos"]}" class="btn btn-default btn-sm glyphicon glyphicon-edit" href="{$_layoutParams.root}pliniancore/editar/index/{$datos.Pli_IdPlinian}" target="_blank">
                                                        </a>
                                                    {/if}
                                                    {if $_acl->permiso("habilitar_deshabilitar_registros_recurso")}
                                                        <a class="btn btn-default btn-sm glyphicon glyphicon-refresh ce_plinian" id_plinian="{$datos.Pli_IdPlinian}" estado_plinian="{if $datos.Pli_Estado==0}1{else}0{/if}"  title="{$lenguaje["cambiar_estado_bdrecursos"]}" > </a>
                                                    {/if}
                                                    {if $_acl->permiso("eliminar_registros_recurso")}                                                       
                                                         <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="{$lenguaje["label_eliminar_bdrecursos"]}" data-id="{$datos.Pli_IdPlinian}" data-nombre="{$datos.Pli_NombresComunes}" class="btn btn-default btn-sm glyphicon glyphicon-trash" >
                                                        </a>
                                                    {/if}
                                                </td>
                                            </tr>
                                        {/foreach} 
                                    </tbody>
                                </table>
                                {$paginacion|default:""}
                            {else}
                                {$lenguaje["label_sin_resultados_bdrecursos"]}
                            {/if}
                        </div>
                    {else if isset($darwin)} 
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 ">   
                                    <div class="col-md-4 pull-right">
                                        <div class="input-group">
                                            <input id="tb_nombre_filter" type="text" class="form-control"  placeholder="nombre científico|nombre común|localidad" value="{$nombre|default}" />                     
                                            <span class="input-group-btn">
                                                <button id="bt_buscar_darwin" class="btn btn-success" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                            </span>
                                        </div>  
                                    </div>
                                </div>
                            </div>                                           
                        </div>
                        <div id="metadata_lista_darwin">
                            {if count($darwin)}
                                <table class="table table-hover table-condensed" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{$lenguaje["label_nombre_cientifico_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_nombre_comun_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_colector_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_localidad_bdrecursos"]}</th>
                                            <th>{$lenguaje["label_longitud_bdrecursos"]}</th> 
                                            <th>{$lenguaje["label_latitud_bdrecursos"]}</th>   
                                            <th style=" text-align: center">Estado</th>          
                                            <th style=" text-align: center">Opciones</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        {foreach item=datos from=$darwin}
                                            <tr>
                                                <td>{$numeropagina++}</td>
                                                <td>{$datos.Dar_NombreCientifico}</td>
                                                <td>{$datos.Dar_NombreComunOrganismo}</td>
                                                <td>{$datos.Dar_Colector}</td>
                                                <td>{$datos.Dar_Localidad}</td>
                                                <td><p>{$datos.Dar_Longitud}</p></td>
                                                <td>{$datos.Dar_Latitud}</td>
                                                <td style=" text-align: center">
                                                    {if {$datos.Dar_Estado}==0}
                                                        <i class="glyphicon glyphicon-remove-sign" title="deshabilitado" style="color: #DD4B39;"/>
                                                    {else}
                                                        <i class="glyphicon glyphicon-ok-sign" title="habilitado" style="color: #088A08;"/>
                                                    {/if}
                                                </td>
                                                <td>
                                                    <a type="button" title="{$lenguaje["label_mas_detalle_bdrecursos"]}" class="btn btn-default btn-sm glyphicon glyphicon-search" href="{$_layoutParams.root}biodiversidad/metadata/{$datos.Dar_IdDarwinCore}" target="_blank">
                                                    </a>
                                                    {if $_acl->permiso("editar_registros_recurso")}
                                                        <a type="button" title="{$lenguaje["label_editar_bdrecursos"]}" class="btn btn-default btn-sm glyphicon glyphicon-edit" href="{$_layoutParams.root}darwincore/editar/index/{$datos.Dar_IdDarwinCore}" target="_blank">
                                                        </a>
                                                    {/if}
                                                    {if $_acl->permiso("habilitar_deshabilitar_registros_recurso")}
                                                        <a class="btn btn-default btn-sm glyphicon glyphicon-refresh ce_darwin" id_darwin="{$datos.Dar_IdDarwinCore}" estado_darwin="{if $datos.Dar_Estado==0}1{else}0{/if}"  title="{$lenguaje["cambiar_estado_bdrecursos"]}" > </a>
                                                    {/if}
                                                    {if $_acl->permiso("eliminar_registros_recurso")}    
                                                         <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="{$lenguaje["label_eliminar_bdrecursos"]}" data-id="{$datos.Dar_IdDarwinCore}" data-nombre="{$datos.Dar_NombreComunOrganismo}" class="btn btn-default btn-sm glyphicon glyphicon-trash" >
                                                        </a>
                                                    {/if}
                                                </td>
                                            </tr>
                                        {/foreach} 
                                    </tbody>
                                </table>
                                {$paginacion|default:""}
                            {else}
                                {$lenguaje["label_sin_resultados_bdrecursos"]}
                            {/if}
                        </div>
                    {else if isset($legislacion)}
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">   
                                    <div class="col-md-4 pull-right">
                                        <div class="input-group">
                                            <input id="tb_nombre_filter" type="text" class="form-control"  placeholder="título|descripcion|entidadd|keys|pais" value="{$nombre|default}" />                     
                                            <span class="input-group-btn">
                                                <button id="bt_buscar_legislacion" class="btn btn-success" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                            </span>
                                        </div>  
                                    </div>
                                </div>
                            </div>                                           
                        </div>  
                        <div id="metadata_lista_legislacion">
                            {if count($legislacion)}
                                <table class="table table-hover table-condensed" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="col-md-2">{$lenguaje["label_titulo_bdrecursos"]}</th>                   
                                            <th class="col-md-2">{$lenguaje["label_resumen_bdrecursos"]}</th>
                                            <th class="col-md-2">{$lenguaje["label_entidad_bdrecursos"]}</th>
                                            <th class="col-md-1">{$lenguaje["label_tipo_bdrecursos"]}</th>                                                 
                                            <th class="col-md-1">{$lenguaje["label_articulo_aplicable_bdrecursos"]}</th> 
                                            <th>{$lenguaje["label_fecha_publicación_bdrecursos"]}</th>
                                            <th style=" text-align: center">Estado</th>          
                                            <th style=" text-align: center">Opciones</th>                                            
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        {foreach item=datos from=$legislacion}
                                            <tr>
                                                <td>{$numeropagina++}</td>
                                                <td class="col-md-2">{$datos.Mal_Titulo|truncate:60:"...":true}</td>
                                                <td class="col-md-2">{$datos.Mal_ResumenLegislacion|truncate:60:"...":true}</td>
                                                <td class="col-md-2">{$datos.Mal_Entidad|truncate:60:"...":true}</td>
                                                <td class="col-md-1">{$datos.Til_Nombre}</td>
                                                <td class="col-md-1"><p>{$datos.Mal_ArticuloAplicable|truncate:10:"...":true}</p></td>
                                                <td>{$datos.Mal_FechaPublicacion|date_format:"%d/%m/%Y"}</td>
                                                <td style=" text-align: center">
                                                    {if {$datos.Mal_Estado}==0}
                                                        <i class="glyphicon glyphicon-remove-sign" title="deshabilitado" style="color: #DD4B39;"/>
                                                    {else}
                                                        <i class="glyphicon glyphicon-ok-sign" title="habilitado" style="color: #088A08;"/>
                                                    {/if}
                                                </td>
                                                <td>
                                                    <a type="button" title="{$lenguaje["label_mas_detalle_bdrecursos"]}" class="btn btn-default btn-sm glyphicon glyphicon-search" href="{$_layoutParams.root}legislacion/legal/metadata/{$datos.Mal_IdMatrizLegal}" target="_blank">
                                                    </a>
                                                    {if $_acl->permiso("editar_registros_recurso")}
                                                        <a type="button" title="{$lenguaje["label_editar_bdrecursos"]}" class="btn btn-default btn-sm glyphicon glyphicon-edit" href="{$_layoutParams.root}legislacion/editar/index/{$datos.Mal_IdMatrizLegal}" target="_blank">
                                                        </a>
                                                    {/if}
                                                    {if $_acl->permiso("habilitar_deshabilitar_registros_recurso")}
                                                        <a class="btn btn-default btn-sm glyphicon glyphicon-refresh ce_legislacion" id_legislacion="{$datos.Mal_IdMatrizLegal}" estado_legislacion="{if $datos.Mal_Estado==0}1{else}0{/if}"  title="{$lenguaje["cambiar_estado_bdrecursos"]}" > </a>
                                                    {/if}
                                                    {if $_acl->permiso("eliminar_registros_recurso")}                                                       
                                                         <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="{$lenguaje["label_eliminar_bdrecursos"]}" data-id="{$datos.Mal_IdMatrizLegal}" data-nombre="{$datos.Mal_Titulo}" class="btn btn-default btn-sm glyphicon glyphicon-trash" >
                                                        </a>
                                                    {/if}
                                                </td>
                                            </tr>
                                        {/foreach} 
                                    </tbody>
                                </table>
                                {$paginacion|default:""}
                            {else}
                                {$lenguaje["label_sin_resultados_bdrecursos"]}
                            {/if}
                        </div>
                    {/if}
                </div>
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
                <p>Estás a punto de borrar un item que pueda que tenga elementos, este procedimiento es irreversible</p>
                <p>¿Deseas Continuar?</p>
                <p>Eliminar: <strong class="nombre-es"></strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                {if isset($calidadagua)}
                <a style="cursor:pointer"  id="{$datos.Mca_IdMonitoreoCalidadAgua}" data-dismiss="modal" class="btn btn-danger danger eliminar_calidadagua">Eliminar</a>
                {else if isset($dublin)}
                <a style="cursor:pointer"  id="{$datos.Dub_IdDublinCore}" data-dismiss="modal" class="btn btn-danger danger eliminar_dublin">Eliminar</a>
                {else if isset($plinian)}
                <a style="cursor:pointer"  id="{$datos.Pli_IdPlinian}" data-dismiss="modal" class="btn btn-danger danger eliminar_plinian">Eliminar</a>
                {else if isset($darwin)}
                <a style="cursor:pointer"  id="{$datos.Dar_IdDarwinCore}" data-dismiss="modal" class="btn btn-danger danger eliminar_darwin">Eliminar</a>
                {else if isset($legislacion)}
                <a style="cursor:pointer"  id="{$datos.Mal_IdMatrizLegal}" data-dismiss="modal" class="btn btn-danger danger eliminar_legislacion">Eliminar</a>
                {/if}
            </div>
        </div>
    </div>
</div>