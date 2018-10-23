{if isset($capasa) && count($capasa)}
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Nombre</th>  
                <th>Fuente</th>   
                <th>Pais</th>    
                <th ></th>

            </tr>
        </thead>
        {foreach item=datos from=$capasa}
            <tr>
                <td>{$datos.tic_Nombre}</td>
                <td>{$datos.cap_Titulo}</td>
                <td>{$datos.cap_Fuente}</td>
                <td>{$datos.Pai_Nombre}</td>
                <td><a href="{$_layoutParams.root}mapa/gestoratlas/edit/{$datos.cap_Idcapa}">Ver Mapa</a></td>
                <td><a href="{$_layoutParams.root}mapa/gestoratlas/edit/{$datos.cap_Idcapa}">Quitar</a></td>
            </tr>

        {/foreach}
    </table> 

    {$paginacioncapasa|default}
{else}

    <p><strong>No hay registros!</strong></p>

{/if} 