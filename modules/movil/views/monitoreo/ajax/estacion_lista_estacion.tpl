{if isset($estaciones) && count($estaciones)}
    <h3>Lista de Estacion de Monitoreo</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>N</th>
                <th>Nombre</th> 
                <th>Pais</th>  
                <th>Cuenca</th>   
                <th>LongitudGM</th>  
                <th>LatitudGM</th>   
                <th ></th>

            </tr>
        </thead>
        {foreach item=datos from=$estaciones key=key name=i}
            <tr>
                <td>{$smarty.foreach.i.index+1}</td>
                <td>{$datos.nombrePunto}</td>
                <td>{$datos.Pais}</td>
                <td>{$datos.nombreCuenca}</td>
                <td>{$datos.LongitudGM}</td>
                <td>{$datos.LatitudGM}</td>
                <td><a href="{$_layoutParams.root}mapa/estacion/{$datos.EstacionId}">Ver</a></td>

            </tr>

        {/foreach}
    </table> 

    {$paginacion_estaciones|default}
{else}

    <p><strong>No hay registros!</strong></p>

{/if} 