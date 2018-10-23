{if isset($descarga) && count($descarga)}
    <div class="table-responsive" >
        <table class="table">
            <tr>
                <th>N°</th>
                <th>{$lenguaje.est_tabla_columna9}</th>
                <th>{$lenguaje.est_tabla_columna8}</th>
                <th>{$lenguaje.est_tabla_columna4}</th>
                <th>{$lenguaje.est_tabla_columna6}</th>
            </tr>
            {foreach from=$descarga item=v}
                <tr >
                    <td>{$numeropagina++}</td>
                    <td>{$v.Arf_PosicionFisica}</td>
                    <td>{$v.Taf_Descripcion}</td>
                    <td>{$v.Esd_Ip}</td>
                    <td>{$v.Esd_Fecha}</td>
                </tr>
            {/foreach}
        </table>
    </div>
    {$paginacion|default:""}
{else}
    {$lenguaje.no_registros}
{/if}