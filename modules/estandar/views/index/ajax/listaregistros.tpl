{if isset($datos) && count($datos)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr>
                <th style=" text-align: center">#</th>
                <th style=" text-align: center">{$lenguaje["label_nombre"]}</th>
                <th style=" text-align: center">{$lenguaje["label_nombre_tabla"]}</th>
                <th style=" text-align: center">{$lenguaje["label_descripcion"]}</th>
                {if $_acl->permiso("editar_estandar")}
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                {/if}
            </tr>
            {foreach from=$datos item=us}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$us.Esr_Nombre}</td>
                    <td>{$us.Esr_NombreTabla}</td>
                    <td>{$us.Esr_Descripcion}</td>
                    {if $_acl->permiso("editar_estandar")}
                    <td>
                        <a class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="{$lenguaje["label_editar"]}" href="{$_layoutParams.root}estandar/index/editarEstandar/{$us.Esr_IdEstandarRecurso}" target="_blank"></a>
                        <a class="btn btn-default btn-sm glyphicon glyphicon-trash eliminarEstandar" title="{$lenguaje["label_eliminar"]}" Esr_IdEstandarRecurso = "{$us.Esr_IdEstandarRecurso}" Esr_NombreTabla = "{$us.Esr_NombreTabla}" ></a>
                    </td>
                    {/if}
                </tr>
            {/foreach}
        </table>
    </div>     
    <div class="panel-footer">
        {$paginacion|default:""}
    </div>      
{else}
    {$lenguaje.no_registros}
{/if}  