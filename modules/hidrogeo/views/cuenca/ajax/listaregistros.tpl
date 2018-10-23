{if isset($cuencas) && count($cuencas)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_cuenca}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$cuencas item=cuenca}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$cuenca.Cue_Nombre}</td>
                    <td style=" text-align: center">
                        {if $cuenca.Cue_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $cuenca.Cue_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_cuenca")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/cuenca/index/{$cuenca.Cue_IdCuenca}"></a>
                        {/if}
                        {if $_acl->permiso("habilitar_deshabilitar_cuenca")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-cuenca" title="{$lenguaje.label_cambiar_estado}" idcuenca="{$cuenca.Cue_IdCuenca}" estado="{if $cuenca.Cue_Estado==0}1{else}0{/if}"> </a>      
                        {/if}
                        {if $_acl->permiso("eliminar_cuenca")}
                            <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="Confirmación de eliminación" data-id="{$cuenca.Cue_IdCuenca}" data-nombre="{$cuenca.Cue_Nombre}" class="btn btn-default btn-sm glyphicon glyphicon-trash" >
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