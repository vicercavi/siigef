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