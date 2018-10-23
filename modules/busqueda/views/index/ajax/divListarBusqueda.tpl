{if isset($busqueda) && count($busqueda)}
    <div class="table-responsive" >
        <table class="table">
            <tr>
                <th>N°</th>
                <th>{$lenguaje.buscador_tabla_1}</th>
                <th>{$lenguaje.buscador_tabla_2}</th>
                <th>{$lenguaje.buscador_tabla_3}</th>
            </tr>
            {foreach from=$busqueda item=b}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$b.Esb_PalabraBuscada}</td>
                    <td>{$b.Esb_Ip}</td>
                    <td>{$b.Esb_Fecha}</td>
                </tr>
            {/foreach}
        </table>
    </div>
    {$paginacion|default:""}
{else}
    {$lenguaje.no_registros}
{/if}