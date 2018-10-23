{if isset($respuestas) && count($respuestas)}
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th>#</th> 
                <th>Respuesta</th>
            </tr>
        </thead> 
        <tbody>
            {foreach item=respuesta from=$respuestas}
                <tr>
                    <td>{$numeropagina_respuesta++}</td>               
                    <td>{$respuesta.$nombre_pregunta}</td>
                </tr>
            {/foreach}
        </tbody>
    </table> 
{$paginacion_respuesta|default}
{else}
    <p><strong>No hay registros!</strong></p>
{/if} 