{if isset($tipoaguas) && count($tipoaguas)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_tipoagua}</th>
                <th style=" text-align: center">{$lenguaje.label_descripcion}</th>
                <th style=" text-align: center">{$lenguaje.label_color}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$tipoaguas item=tipoagua}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$tipoagua.Tia_Nombre}</td>
                    <td>{$tipoagua.Tia_Descripcion}</td>
                    <td>{$tipoagua.Tia_Color}</td>
                    <td style=" text-align: center">
                        {if $tipoagua.Tia_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $tipoagua.Tia_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_tipoagua")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/tipoagua/index/{$tipoagua.Tia_IdTipoAgua}"></a>
                        {/if}{if $_acl->permiso("habilitar_deshabilitar_tipoagua")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-tipoagua" title="{$lenguaje.label_cambiar_estado}" idtipoagua="{$tipoagua.Tia_IdTipoAgua}" estado="{if $tipoagua.Tia_Estado==0}1{else}0{/if}"> </a>      
                        {/if}
                        {if $_acl->permiso("eliminar_tipoagua")}
                            <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="Confirmación de eliminación" data-id="{$tipoagua.Tia_IdTipoAgua}" data-nombre="{$tipoagua.Tia_Nombre}" class="btn btn-default btn-sm glyphicon glyphicon-trash">
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