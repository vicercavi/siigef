{if isset($roles) && count($roles)}
    <div class="table-responsive">
        <table class="table" style="  margin: 20px auto">
            <tr>
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th >{$lenguaje.label_rol}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach item=rl from=$roles}
                <tr>
                    <td style=" text-align: center">{$numeropagina++}</td>
                    <td>{$rl.Rol_role}</td>
                    <td style=" text-align: center">
                        {if $rl.Rol_Estado==0}
                            <p class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_denegado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $rl.Rol_Estado==1}
                            <p class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>
                    {if $_acl->permiso("editar_rol")}
                    <td style=" text-align: center">
                        <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.tabla_opcion_editar_rol}" href="{$_layoutParams.root}acl/index/editarRol/{$rl.Rol_IdRol}"></a>
                        <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-list" title="{$lenguaje.tabla_opcion_editar_permisos}" href="{$_layoutParams.root}acl/index/permisos_role/{$rl.Rol_IdRol}"></a>
                        <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh" title="{$lenguaje.tabla_opcion_cambiar_est}" href="{$_layoutParams.root}acl/index/_cambiarEstadoRol/{$rl.Rol_IdRol}/{$rl.Rol_Estado}"></a>
                        <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash" title="{$lenguaje.label_eliminar}" href="{$_layoutParams.root}acl/index/_eliminarRol/{$rl.Rol_IdRol}"></a>
                    </td>
                    {/if}
                </tr>
            {/foreach}
        </table>
    </div>
    {$paginacion|default:""}
{else}
    {$lenguaje.no_registros}
{/if}