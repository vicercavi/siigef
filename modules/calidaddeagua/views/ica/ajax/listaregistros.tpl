{if isset($icas) && count($icas)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_ica}</th>
                <th style=" text-align: center">{$lenguaje.label_descripcion}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$icas item=ica}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$ica.Ica_Nombre}</td>
                    <td>{$ica.Ica_Descripcion}</td>
                    <td style=" text-align: center">
                        {if $ica.Ica_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $ica.Ica_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_ica")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/ica/editar/{$ica.Ica_IdIca}"></a>
                        {/if}{if $_acl->permiso("habilitar_deshabilitar_ica")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-ica" title="{$lenguaje.label_cambiar_estado}" idica="{$ica.Ica_IdIca}" estado="{if $ica.Ica_Estado==0}1{else}0{/if}"> </a>      
                        {/if}{if $_acl->permiso("eliminar_ica")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-ica" title="{$lenguaje.label_eliminar}" idica="{$ica.Ica_IdIca}"> </a>
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