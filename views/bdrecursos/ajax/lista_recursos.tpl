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