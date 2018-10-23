{if isset($entidades) && count($entidades)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_entidad}</th>
                <th style=" text-align: center">{$lenguaje.label_siglas}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$entidades item=entidad}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$entidad.Ent_Nombre}</td>
                    <td>{$entidad.Ent_Siglas}</td>
                    <td style=" text-align: center">
                        {if $entidad.Ent_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $entidad.Ent_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_entidad")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/entidad/editar/{$entidad.Ent_IdEntidad}"></a>
                        {/if}{if $_acl->permiso("habilitar_deshabilitar_entidad")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-entidad" title="{$lenguaje.label_cambiar_estado}" identidad="{$entidad.Ent_IdEntidad}" estado="{if $entidad.Ent_Estado==0}1{else}0{/if}"> </a>      
                        {/if}{if $_acl->permiso("eliminar_entidad")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-entidad" title="{$lenguaje.label_eliminar}" identidad="{$entidad.Ent_IdEntidad}"> </a>
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