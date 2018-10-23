{if isset($bitacora) && count($bitacora)}
    <div class="table-responsive" >
        <table class="table">
            <tr>
                <th>{$lenguaje.label_n}</th>
                <th>{$lenguaje.label_tipo_error}</th>
                <th>{$lenguaje.label_evento_desc}</th>
                <th>{$lenguaje.label_nombre_pagina}</th>
                <th>{$lenguaje.label_fecha}</th>
            </tr>
            {foreach from=$bitacora item=b}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$b.Evs_Tipo}</td>
                    <td>{$b.Evs_Descripcion}</td>
                    <td>{$b.Bit_NombrePagina}</td>
                    <td>{$b.Bit_Fecha}</td>
                </tr>
            {/foreach}
        </table>
    </div>
    {$paginacion|default:""}
{else}
    {$lenguaje.no_registros}
{/if}