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
                <td>{$datos.Cap_Titulo}</td>
                <td>{$datos.Cap_Fuente}</td>
                <td>{$datos.Pai_Nombre}</td>
                <td><a href="{$_layoutParams.root}calidaddeagua/monitoreo/gestor/edit/{$datos.Cap_Idcapa}">Ver Mapa</a></td>
                <td><a href="{$_layoutParams.root}calidaddeagua/monitoreo/gestor/edit/{$datos.Cap_Idcapa}">Quitar</a></td>
            </tr>

        {/foreach}
    </table> 

    {$paginacioncapasa|default}
{else}

    <p><strong>No hay registros!</strong></p>

{/if} 