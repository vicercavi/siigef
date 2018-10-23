{if isset($jerarquias) && count($jerarquias)}
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Orden</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th colspan="2"></th>

            </tr>
        </thead>
        {foreach item=datos from=$jerarquias}
            <tr>
                <td>{$datos.Jem_Orden}</td>
                <td>{$datos.Jem_Nombre}</td>
                <td>{$datos.Jem_Descripcion}</td>                                       
                <td><a href="{$_layoutParams.root}calidaddeagua/monitoreo/gestor/ver/{$datos.Jem_IdJerarquiaCapa}">Ver</a></td>
                <td><span jerarquia="{$datos.Jem_IdJerarquiaCapa}" class="sp_quitar_jerarquia_vm btn-link">Quitar</span></td>
            </tr>

        {/foreach}
    </table>
    <div style="text-align: right">
        {$paginacion|default}
    </div>
{else}

    <p><strong>No hay registros!</strong></p>

{/if}