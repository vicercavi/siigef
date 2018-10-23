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
                    <td>{$datos.Mca_Fecha|date_format:"%d/%m/%Y"}</td>
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