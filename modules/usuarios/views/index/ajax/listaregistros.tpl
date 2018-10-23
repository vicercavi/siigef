{if isset($usuarios) && count($usuarios)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">N°</th>
                <th style=" text-align: center">Usuario</th>
                <th style=" text-align: center">Rol</th>
                <th style=" text-align: center">Estado</th>
                <th style=" text-align: center">Opciones</th>
            </tr>
            {foreach from=$usuarios item=us}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$us.Usu_Usuario}</td>
                    <td>{$us.Rol_role}</td>
                    <td >
                        {if $us.Usu_Estado==0}
                            <p class="glyphicon glyphicon-remove-sign " title="Desabilitado" style="color: #DD4B39;"></p>
                        {/if}
                        {if $us.Usu_Estado==1}
                            <p class="glyphicon glyphicon-ok-sign " title="Habilitado" style="color: #088A08;"></p>
                        {/if}
                    </td>
                    <td >
                        <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="Editar Rol" href="{$_layoutParams.root}usuarios/index/rol/{$us.Usu_IdUsuario}/{$us.Usu_Usuario}/{$us.Rol_role}"></a>
                        <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-tasks" title="Editar Permisos"  href="{$_layoutParams.root}usuarios/index/permisos/{$us.Usu_IdUsuario}"></a>
                        <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh" title="Cambiar Estado" href="{$_layoutParams.root}usuarios/index/_cambiarEstado/{$us.Usu_IdUsuario}/{$us.Usu_Estado}"> </a>        
                        <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash" title="{$lenguaje.label_eliminar}" href="{$_layoutParams.root}usuarios/index/_eliminarUsuario/{$us.Usu_IdUsuario}"> </a>
                    </td>
                </tr>
            {/foreach}
        </table>
    </div>
    {$paginacion|default:""}
{else}
    {$lenguaje.no_registros}
{/if}