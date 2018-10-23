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
                <td>{$datos.jem_Orden}</td>
                <td>{$datos.jem_Nombre}</td>
                <td>{$datos.jem_Descripcion}</td>                                       
                <td><a href="{$_layoutParams.root}mapa/gestormonitoreo/ver/{$datos.jem_IdJerarquiaCapa}">Ver</a></td>
            </tr>

        {/foreach}
    </table>
    <div style="text-align: right">
        {$paginacion|default}
    </div>
{else}

    <p><strong>No hay registros!</strong></p>

{/if}