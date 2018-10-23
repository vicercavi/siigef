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