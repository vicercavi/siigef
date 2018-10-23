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