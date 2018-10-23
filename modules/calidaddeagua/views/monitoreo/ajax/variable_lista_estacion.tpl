{if isset($estaciones) && count($estaciones)}
    <div class="col-md-6">
        <h3>Estaciones donde se estudió la variable</h3>
    </div>
    <div class="col-md-6">
        {if isset($estadoeca) && count($estadoeca)}
            {foreach item=datos from=$estadoeca key=key name=i}
                <div class="estadoeca" style="background-color: {$datos.ese_color}"> {$datos.ese_nombre}</div>
            {/foreach}

        {/if}
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th> 
                <th>Estacion</th> 
                <th>Pais</th>  
                <th>Cuenca</th>     
                <th>Valor</th>    
                <th>Colecta</th>                                      

            </tr>
        </thead>
        {foreach item=dato from=$estaciones key=key name=i}
            <tr>
                <td>{$numeropagina_est++}</td>
                <td>{$dato.Esm_Nombre}</td>
                <td>{$dato.Pai_Nombre}</td>
                <td>{$dato.Cue_Nombre}</td>
                <td>
                {if empty($dato.EstadoECA)}{$dato.Mca_Valor}{else}
                    <div data-toggle="popover" rel="popover" data-placement="top" data-content="
                         <strong>ECA: </strong>{$dato.Cae_Nombre}<br><strong>Fuente: </strong>{$dato.Cae_Fuente}<br><strong>
                         Limite: </strong>{if $dato.eca_signo=='<'}<{$dato.eca_maximo}{elseif $dato.eca_signo=='<='}{$dato.eca_maximo}{elseif $dato.eca_signo=='>'}>{$dato.eca_minimo}{elseif $dato.eca_signo=='>='}>={$dato.eca_minimo}{elseif $dato.eca_signo=='[]'}{$dato.eca_minimo} - {$dato.eca_maximo}{/if}                                        
                         " data-trigger="hover"
                         data-original-title="Estandar de Calidad Ambiental para Agua" 
                         style="background-color: {$dato.EstadoECA};    text-align: center;    color: white;    font-weight: bold;  padding: 0 4px 0 4px;">{$dato.Mca_Valor}</div>{/if}</td>  
                <td>{if ($dato.Mca_Fecha|count_characters)==4}{$dato.Mca_Fecha}{else}{$dato.Mca_Fecha|substr:6:2}/{$dato.Mca_Fecha|substr:4:2}/{$dato.Mca_Fecha|substr:0:4}{/if}</td>  
            </tr>

            {/foreach}
            </table> 


            {$paginacion_estaciones|default}
            {else}

                <p><strong>No hay registros!</strong></p>

                {/if} 