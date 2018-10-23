{if isset($permisos) && count($permisos)}
<div class="table-responsive">
    <table class="table" style="  margin: 20px auto">
        <tr>
            <th style=" text-align: center">{$lenguaje.label_n}</th>
            <th >{$lenguaje.label_permiso} </th>
            <th style=" text-align: center">{$lenguaje.label_clave}</th>
            {if $_acl->permiso("editar_rol")}
            <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            {/if}
        </tr>
        {foreach item=rl from=$permisos}
            <tr>
                <td style=" text-align: center">{$numeropagina++}</td>
                <td>{$rl.Per_Permiso}</td>
                <td style=" text-align: center">{$rl.Per_Ckey}</td>
                {if $_acl->permiso("editar_rol")}
                <td style=" text-align: center">
                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash" title="{$lenguaje.label_eliminar}" href="{$_layoutParams.root}acl/index/_eliminarPermiso/{$rl.Per_IdPermiso}"> </a>
                </td>
                {/if}
            </tr>
        {/foreach}
    </table>
</div>
    {$paginacionPermisos|default:""}
{else}
    {$lenguaje.no_registros}
{/if}