 {if isset($erroresComunes) && count($erroresComunes)}
    <div class="table-responsive" >
        <table class="table">
            <tr>
                <th>#</th>
                <th>Descripcion</th>
                <th>Cantidad</th>
            </tr>
            {foreach from=$erroresComunes item=b}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$b.descripcion}</td>
                    <td>{$b.N}</td>
                </tr>
            {/foreach}
        </table>
    </div>
{else}
    {$lenguaje.no_registros}
{/if}
{$paginacion|default:""}