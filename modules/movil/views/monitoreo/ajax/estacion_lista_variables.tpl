{if isset($variables) && count($variables)}
    <div class="col-md-6">
        <h3>Variables Estudiadas</h3>
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
                <th>N</th>
                <th>Variable</th> 
                <th>UND</th>  
                <th>Valor</th>   
                <th>Colecta</th>                                       

            </tr>
        </thead>
        {foreach item=datos from=$variables key=key name=i}
            <tr>
                <td>{$smarty.foreach.i.index+1}</td>
                <td>{$datos.nombreParametro}</td>
                <td>{$datos.unidadMedida}</td>
                <td> 
                    {if ($datos.EstadoECA == null)}
                        <div style=" text-align: center;">{$datos.ParametroCantidad}</div>
                    {else }
                        <div style="background-color:   {$datos.EstadoECA}  ;    text-align: center;    color: white;    font-weight: bold;  padding: 0 4px 0 4px;">  {$datos.ParametroCantidad}  </div>
                    {/if}
                </td>
                <td>{$datos.fecha}</td>


            </tr>

        {/foreach}
    </table> 


    {$paginacion_variables|default}
{else}

    <p><strong>No hay registros!</strong></p>

{/if} 