{if isset($visita) && count($visita)}
    <div class="table-responsive" >
        <table class="table">
            <tr>
                <th>N°</th>
                <th>{$lenguaje.est_tabla_columna4}</th>
                <th>{$lenguaje.est_tabla_columna1}</th>
                <th>{$lenguaje.est_tabla_columna2}</th>
                <th>{$lenguaje.est_tabla_columna3}</th>
                <th>{$lenguaje.est_tabla_columna5}</th>
                <th>{$lenguaje.est_tabla_columna6}</th>
                <th>{$lenguaje.est_tabla_columna7}</th>
            </tr>
            {foreach from=$visita item=v}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$v.Vis_Ip}</td>
                    <td>{$v.Vis_Explorador}</td>
                    <td>{$v.Vis_PaginaVisita}</td>
                    <td>{$v.Vis_PaginaAnterior}</td>
                    
                    <td>{$v.Vis_SistemaOperativo}</td>
                    <td>{$v.Vis_Fecha}</td>
                    <td>{$v.Vis_Idioma}</td>
                </tr>
            {/foreach}
        </table>
    </div>
    {$paginacion|default:""}
{else}
    {$lenguaje.no_registros}
{/if}