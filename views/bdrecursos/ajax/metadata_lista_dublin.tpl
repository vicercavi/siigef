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
                    <td class="col-md-2">{$datos.Aut_Nombre|truncate:60:"...":true}</td>
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