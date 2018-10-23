{if isset($rios) && count($rios)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_rio}</th>
                <th style=" text-align: center">{$lenguaje.label_pais}</th>
                <th style=" text-align: center">{$lenguaje.label_tipoagua}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$rios item=rio}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$rio.Rio_Nombre}</td>
                    <td>{$rio.Pai_Nombre}</td>
                    <td>{$rio.Tia_Nombre}</td>
                    <td style=" text-align: center">
                        {if $rio.Rio_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $rio.Rio_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_rio")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/rio/index/{$rio.Rio_IdRio}"> </a>
                        {/if}
                        {if $_acl->permiso("habilitar_deshabilitar_rio")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-rio" title="{$lenguaje.label_cambiar_estado}" idrio="{$rio.Rio_IdRio}" estado="{if $rio.Rio_Estado==0}1{else}0{/if}"> </a>      
                        {/if}
                        {if $_acl->permiso("eliminar_rio")}
                            <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="Confirmación de eliminación" data-id="{$rio.Rio_IdRio}" data-nombre="{$rio.Rio_Nombre}" class="btn btn-default btn-sm glyphicon glyphicon-trash" >
                                </a>
                        {/if}
                    </td>                                            
                </tr>
            {/foreach}
        </table>
    </div>
    {$paginacion|default:""}
{else}
    {$lenguaje.no_registros}
{/if}