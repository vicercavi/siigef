{if isset($estaciones) && count($estaciones)}                              
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th> 
                <th>Pais</th> 
                <th>Cuenca</th>   
                <th>Rio</th>                                           
                <th>Latitud</th>  
                <th>Longitud</th>   
                <th>Opciones</th>

            </tr>
        </thead>
        {foreach item=datos from=$estaciones key=key name=i}
            <tr>
                <td>{{$numeropagina_est++}}</td>
                <td>{$datos.Esm_Nombre}</td>
                <td>{$datos.Pai_Nombre}</td>
                <td>{$datos.Cue_Nombre}</td>
                <td>{$datos.Rio_Nombre}</td>
                <td>{$datos.Esm_Latitud}</td>
                <td>{$datos.Esm_Longitud}</td>
                <td>
                    <a type="button" title="Ver" class="btn btn-default btn-sm glyphicon glyphicon-eye-open" href="{$_layoutParams.root}calidaddeagua/monitoreo/estacion/{$datos.Esm_IdEstacionMonitoreo}" target="_blank"></a>
                </td>
            </tr>
        {/foreach}
    </table> 
    {$paginacion_estaciones|default}
{else}
    <p><strong>No hay registros!</strong></p>
{/if} 