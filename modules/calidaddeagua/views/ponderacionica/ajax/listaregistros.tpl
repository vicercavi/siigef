{if isset($ponderacionicas) && count($ponderacionicas)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_variable}</th>
                <th style=" text-align: center">{$lenguaje.label_peso}</th>
                <th style=" text-align: center">{$lenguaje.label_ica}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$ponderacionicas item=ponderacionica}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$ponderacionica.Var_Nombre}</td>
                    <td>{$ponderacionica.Poi_Peso}</td>

                    <td>{$ponderacionica.Ica_Nombre}</td>
                    <td style=" text-align: center">
                        {if $ponderacionica.Poi_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $ponderacionica.Poi_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_ponderacionica")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/ponderacionica/editar/{$ponderacionica.Poi_IdPonderacionIca}"></a>
                        {/if}{if $_acl->permiso("habilitar_deshabilitar_ponderacionica")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-ponderacionica" title="{$lenguaje.label_cambiar_estado}" idponderacionica="{$ponderacionica.Poi_IdPonderacionIca}" estado="{if $ponderacionica.Poi_Estado==0}1{else}0{/if}"> </a>      
                        {/if}{if $_acl->permiso("eliminar_ponderacionica")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-ponderacionica" title="{$lenguaje.label_eliminar}" idponderacionica="{$ponderacionica.Poi_IdPonderacionIca}"> </a>
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