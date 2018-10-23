<div id="recursos" class="container-fluid" >
    <div class="row">
        <div class="col-md-12">
            <h3 class="titulo-view">  {$lenguaje["label_h3_titulo_bdrecursos"]}</h3>  
            {if $_acl->permiso("agregar_recurso") || (isset($recurso) && $_acl->permiso("editar_recurso"))}
                <div class="panel panel-default">
                    <div class="panel-heading jsoftCollap">                    
                        <h3 aria-expanded="false" data-toggle="collapse" href="#collapse1" class="panel-title collapsed">
                            <i style="float:right"class="fa fa-ellipsis-v"></i><i class="fa fa-globe fa-plus"></i>&nbsp;&nbsp;<strong>{if isset($recurso)}{$lenguaje["label_editar_bdrecursos"]}{else}{$lenguaje["label_nuevo_bdrecursos"]}{/if}</strong></h3>       
                    </div>
                    <div aria-expanded="false" id="collapse1" class="panel-collapse collapse {if isset($recurso)}in{/if}">
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tabular" data-toggle="tab">{$lenguaje["label_tabular_bdrecursos"]}</a></li>
                                <li><a href="{$_layoutParams.root}mapa/gestorcapa" >{$lenguaje["label_mapa_bdrecursos"]}</a></li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane active in  form-horizontal" id="tabular">
                                    <form id="form1" method="post" data-toggle="validator"role="form" autocomplete="on">
                                        <div class="container col-md-5">
                                            <input type="hidden" id="hd_idrecurso"  name="hd_idrecurso"
                                                   value="{$recurso.Rec_IdRecurso|default}"/>
                                            <div class="form-group" >
                                                <input type="hidden" id="hd_idioma_defecto" name="hd_idioma_defecto" value="{$recurso.Idi_IdIdioma|default}">
                                                <label class="control-label col-lg-2">{$lenguaje["label_idioma_bdrecursos"]}</label>
                                                {if  isset($idiomas) && count($idiomas)}                
                                                    <div class="col-lg-10 form-inline">
                                                        {foreach from=$idiomas item=idi}               
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="rb_idioma" id="rb_idioma" class=" {if isset($recurso)}{$lenguaje["label_idioma-recurso_bdrecursos"]}{/if}" value="{$idi.Idi_IdIdioma}" 
                                                                           {if isset($recurso) && $recurso.Idi_IdIdioma==$idi.Idi_IdIdioma} 
                                                                               checked="checked" 
                                                                           {elseif !isset($recurso) && isset($idioma) && $idioma==$idi.Idi_IdIdioma} 
                                                                               checked="checked"
                                                                            {/if} 
                                                                           required>
                                                                    {$idi.Idi_Idioma}
                                                                </label>                       
                                                            </div>  
                                                        {/foreach}
                                                    </div>          
                                                {else} 
                                                    <div class="form-inline col-lg-9">
                                                        <label class="control-label">{$lenguaje["label_idioma-inexistente_bdrecursos"]} </label>
                                                    </div>
                                                {/if}
                                            </div>
                                            <div id="index_nuevo_recurso">
                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label" for="tb_nombre_recurso">{$lenguaje["label_nombre_bdrecursos"]}*</label>
                                                    <div class="col-lg-10">
                                                        <input type="text" class="form-control" id="tb_nombre_recurso"  name="tb_nombre_recurso"
                                                               placeholder="{$lenguaje["label_place_nombre_bdrecursos"]}" value="{$recurso.Rec_Nombre|default}" required/>
                                                    </div>
                                                </div> 
                                                <div class="form-group">
                                                    <label  class="col-lg-2 control-label" for="tb_fuente_recurso">{$lenguaje["label_fuente_bdrecursos"]}*</label>
                                                    <div class="col-lg-10">
                                                        <input type="text" list="dl_fuente" class="form-control" id="tb_fuente_recurso"  value="{$recurso.Rec_Fuente|default}" name="tb_fuente_recurso"
                                                               placeholder="{$lenguaje["label_place_fuente_bdrecursos"]}"required/>
                                                        <datalist id="dl_fuente">
                                                            {foreach item=datos from=$fuente}
                                                                <option value='{$datos.Rec_Fuente}'>
                                                                {/foreach} 
                                                        </datalist>
                                                    </div>
                                                </div> 
                                                <div class="form-group">
                                                    <label  class="col-lg-2 control-label" for="tb_origen_recurso">{$lenguaje["label_origen_bdrecursos"]}*</label>
                                                    <div class="col-lg-10">
                                                        <input type="text" list="dl_origen" class="form-control" id="tb_origen_recurso" value="{$recurso.Rec_Origen|default}" name="tb_origen_recurso"
                                                               placeholder="{$lenguaje["label_place_origen_bdrecursos"]}" required/>
                                                        <datalist id="dl_origen">
                                                            {foreach item=datos from=$origenrecurso}
                                                                <option value='{$datos.Rec_Origen}'> {$datos.Rec_Origen}</option>
                                                            {/foreach}
                                                        </datalist>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label" for="sl_estandar_recurso">Estandar*</label>    
                                                <div class="col-lg-10">
                                                    <select name="sl_estandar_recurso"  class="form-control" id="sl_estandar_recurso"  name="sl_estandar_recurso" {if  isset($recurso)} disabled{/if} required="">
                                                        <option value="">{$lenguaje["label_seleccione_estandar_bdrecursos"]}</option>
                                                        {foreach item=datos from=$estandar}
                                                            <option value='{$datos.Esr_IdEstandarRecurso}' {if isset($recurso)&& $recurso.Esr_IdEstandarRecurso==$datos.Esr_IdEstandarRecurso}selected{/if}> {$datos.Esr_Nombre}</option>
                                                        {/foreach}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-2 col-lg-10">
                                                    <input type="hidden" id="hd_tipo_recurso" name="hd_tipo_recurso" value="1">
                                                    {if isset($recurso)} 
                                                        <button type="submit"  class="btn btn-success" id="bt_actualizar" name="bt_actualizar"><i class="glyphicon glyphicon-floppy-disk"> </i> {$lenguaje["boton_editar_bdrecursos"]}</button>
                                                        <a class="btn btn-danger" href="{$_layoutParams.root}bdrecursos"><i class="glyphicon glyphicon-remove-sign"></i> Cancelar</a>
                                                    {else}
                                                        <button type="submit"  class="btn btn-success" id="bt_registrar" name="bt_registrar"><i class="glyphicon glyphicon-floppy-disk"> </i> {$lenguaje["boton_guardar_bdrecursos"]}</button>
                                                    {/if}
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>           
                            </div>
                        </div> 
                    </div>
                </div>
            {/if}
        </div>
        <div  id="tipo_recurso"  class="col-md-2"> 
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <strong><a href="{$_layoutParams.root}bdrecursos">{$lenguaje["tipo_recurso_bdrecursos"]}</a></strong> 
                        </h4>
                    </div>               
                    <div class="panel-body">
                        <table class="table" >
                            {foreach item=datos from=$tiporecurso}
                                <tr>
                                    <td class="tipo_recurso">
                                        <span class="tiporecurso " recurso="{$datos.Tir_Nombre}"><a style="cursor: pointer">{$datos.Tir_Nombre}</a></span>
                                        <span class="badge">{$datos.Tir_Total}</span>
                                    </td>
                                </tr>   
                            {/foreach}  
                        </table>
                    </div>
                </div>
            </div>     
        </div>
        <!-- nuevo recurso -->
        <div class="col-md-10">           
            <!-- nuevo recurso -->
            <div  id="lista_recursos">
                <div class="panel panel-default">
                    <div class="panel-heading">                       
                        <h3 class="panel-title">
                            <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;
                            <strong>{$lenguaje["lista_recursos_bdrecursos"]}</strong>  <span class="badge  pull-right">{$control_paginacion}</span></h3>
                    </div>
                    <div class=" row panel-body">
                        <div class="col-md-12 pull-right form-inline text-right">
                            <div class=" input-group">
                                <input id="tb_nombre_filter" type="text" class="form-control"  placeholder="{$lenguaje["nombre_bdrecursos"]}" value="{$nombre|default}" />
                                <span class="input-group-btn">
                                    <button id="bt_buscar_filter" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div>
                            <select name="sl_estandar_recurso_filtro"  class="select-recurso-filter form-control" id="sl_estandar_recurso_filtro" >
                                <option value="0">{$lenguaje["todos_estandares_bdrecursos"]}</option>
                                {foreach item=datos from=$estandar}
                                    <option value='{$datos.Esr_IdEstandarRecurso}' {if isset($sl_estandar) && $sl_estandar==$datos.Esr_IdEstandarRecurso}selected{/if}> {$datos.Esr_Nombre}</option>
                                {/foreach}
                            </select>
                            <select name="sl_fuente_filtro"  class="form-control select-recurso-filter" id="sl_fuente_filtro" >
                                <option value="0">{$lenguaje["todas_fuentes_bdrecursos"]}</option>
                                {foreach item=datos from=$fuente}
                                    <option value='{$datos.Rec_Fuente}' {if isset($sl_fuente) && $sl_fuente==$datos.Rec_Fuente}selected{/if}> {$datos.Rec_Fuente}</option>
                                {/foreach}
                            </select>
                            <select name="sl_origen_filtro"  class="form-control select-recurso-filter" id="sl_origen_filtro" >
                                <option value="0">{$lenguaje["todos_origenes_bdrecursos"]}</option>
                                {foreach item=datos from=$origenrecurso}
                                    <option value='{$datos.Rec_Origen}' {if isset($sl_origen) && $sl_origen==$datos.Rec_Origen}selected{/if}> {$datos.Rec_Origen}</option>
                                {/foreach}
                            </select>
                            <select name="sl_herramienta_filtro"  class="form-control select-recurso-filter" id="sl_herramienta_filtro"  >
                                <option value="0">{$lenguaje["todas_herramientas_bdrecursos"]}</option>
                                {foreach item=datos from=$herramientas}
                                    <option value='{$datos.Her_IdHerramientaSii}'  {if isset($sl_herramienta) && $sl_herramienta==$datos.Her_IdHerramientaSii}selected{/if}> {$datos.Her_Nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    {if isset($registros) && count($registros)}
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="col-md-2">{$lenguaje["label_nombre_bdrecursos"]}s</th>
                                        <th class="col-md-1">{$lenguaje["label_tipo_bdrecursos"]}</th>
                                        <th>{$lenguaje["label_estandar_bdrecursos"]}</th>
                                        <th>{$lenguaje["label_fuente_bdrecursos"]}</th>  
                                        <th>{$lenguaje["registros_bdrecursos"]}</th> 
                                        <th style=" text-align: center">{$lenguaje["herramienta_bdrecursos"]}</th>
                                        <th>{$lenguaje["registro_bdrecursos"]}</th>
                                        <th style=" text-align: center">{$lenguaje["estado_bdrecursos"]}</th>
                                        <th style=" text-align: center">{$lenguaje["opciones_bdrecursos"]}</th>
                                    </tr>
                                </thead>                                
                                <tbody>
                                    {foreach item=datos from=$registros}
                                        <tr>                       
                                            <td>{$numeropagina++}</td>
                                            <td class="col-md-2">{$datos.Rec_Nombre}</td>
                                            <td class="col-md-1">{$datos.Tir_Nombre}</td>
                                            <td>{$datos.Esr_Nombre}</td>
                                            <td>{$datos.Rec_Fuente}</td>                  
                                            <td>{$datos.Rec_CantidadRegistros}</td> 
                                            <td>
                                                {if isset($datos.herramientas)}
                                                    <ul>
                                                        {foreach item=herramienta from=$datos.herramientas}
                                                            <li>{$herramienta.Her_Nombre}</li>
                                                            {/foreach}
                                                    </ul>
                                                {/if}
                                            </td>
                                            <td>{$datos.Rec_FechaRegistro|date_format:"%d/%m/%y"}</td>
                                            <td style=" text-align: center">                                              
                                                {if $datos.Rec_Estado==0}
                                                    <i class="glyphicon glyphicon-remove-sign" title="{$lenguaje["desabilitado_bdrecursos"]}" style="color: #DD4B39;"/>
                                                {else}
                                                    <i class="glyphicon glyphicon-ok-sign" title="{$lenguaje["habilitado_bdrecursos"]}" style="color: #088A08;"/>
                                                {/if}
                                            </td>
                                            <td style=" text-align: center">
                                                <a type="button" title="{$lenguaje["ver_bdrecursos"]}" class="btn btn-default btn-sm glyphicon glyphicon-search" href="{$_layoutParams.root}bdrecursos/metadata/{$datos.Rec_IdRecurso}" target="_blank">
                                                </a>
                                                {if $_acl->permiso("editar_recurso")}
                                                    <a type="button" title="{$lenguaje["editar_bdrecursos"]}" class="btn btn-default btn-sm glyphicon glyphicon-pencil" href="{$_layoutParams.root}bdrecursos/index/{$datos.Rec_IdRecurso}">
                                                    </a>
                                                {/if}
                                                {if $_acl->permiso("habilitar_deshabilitar_recurso")}
                                                    <a class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-recurso" recurso="{$datos.Rec_IdRecurso}" estado="{if $datos.Rec_Estado==0}1{else}0{/if}"  title="{$lenguaje["cambiar_estado_bdrecursos"]}" > </a>
                                                {/if}                                                
                                                {if $_acl->permiso("eliminar_recurso")}
                                                    <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="Confirmación de eliminación" data-id="{$datos.Rec_IdRecurso}" data-nombre="{$datos.Rec_Nombre}" class="btn btn-default btn-sm glyphicon glyphicon-trash">
                                                    </a>
                                                {/if}      
                                            </td>
                                        </tr>                     
                                    {/foreach}
                                </tbody>
                            </table>
                        </div>
                        {$paginacion|default:""}    
                    {else}
                        {$lenguaje["sin_resultados_bdrecursos"]}
                    {/if}
                </div>
                <!-- fin listado de recursos -->
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
                <p>Estás a punto de borrar un item, este procedimiento es irreversible</p>
                <p>¿Deseas Continuar?</p>
                <p>Eliminar: <strong class="nombre-es">{$datos.Rec_Nombre}</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a style="cursor:pointer"  id="{$datos.Rec_IdRecurso}" data-dismiss="modal" class="btn btn-danger danger eliminar_recurso">Eliminar</a>
            </div>
        </div>
    </div>
</div>