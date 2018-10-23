{if isset($clasificacionicas) && count($clasificacionicas)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_clasificacionica}</th>
                <th style=" text-align: center">{$lenguaje.label_descripcion}</th>
                <th style=" text-align: center">{$lenguaje.label_icamin}</th>
                <th style=" text-align: center">{$lenguaje.label_icamax}</th>
                <th style=" text-align: center">{$lenguaje.label_color}</th>
                <th style=" text-align: center">{$lenguaje.label_categoriaica}</th>
                <th style=" text-align: center">{$lenguaje.label_ica}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$clasificacionicas item=clasificacionica}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$clasificacionica.Cli_Nombre}</td>
                    <td>{$clasificacionica.Cli_Descripcion}</td>
                    <td>{$clasificacionica.Cli_IcaMin}</td>
                    <td>{$clasificacionica.Cli_IcaMax}</td>
                    <td style="color: {$clasificacionica.Cli_Color}">
                        {$clasificacionica.Cli_Color}
                    </td>
                    <td>{$clasificacionica.Cai_Nombre}</td>
                    <td>{$clasificacionica.Ica_Nombre}</td>
                    <td style=" text-align: center">
                        {if $clasificacionica.Cli_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $clasificacionica.Cli_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_clasificacionica")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/clasificacionica/editar/{$clasificacionica.Cli_IdClasificacionIca}"></a>
                        {/if}{if $_acl->permiso("habilitar_deshabilitar_clasificacionica")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-clasificacionica" title="{$lenguaje.label_cambiar_estado}" idclasificacionica="{$clasificacionica.Cli_IdClasificacionIca}" estado="{if $clasificacionica.Cli_Estado==0}1{else}0{/if}"> </a>      
                        {/if}{if $_acl->permiso("eliminar_clasificacionica")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-clasificacionica" title="{$lenguaje.label_eliminar}" idclasificacionica="{$clasificacionica.Cli_IdClasificacionIca}"> </a>
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