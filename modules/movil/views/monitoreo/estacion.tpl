<style>

    body{
        background: #fff;
    }
    .container{
        padding: 0;
    }


</style> 
<div class="container-fluid">
    <div class="row">
        <h1></h1>
        <div class="col-md-7">  
            {if !isset($estacion)}
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Ingrese nombre">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Buscar</button>
                        </span>
                    </div>
                </div>
            {else}
                <div class="col-md-12">
                    <h3>{$estacion.nombrePunto}</h3>
                    <span>{$estacion.Pais},Cuenca {$estacion.nombreCuenca}</span>
                </div>
            {/if}

            <div class="col-md-12">
                {if !isset($estacion)}
                    <div id="estacion_lista_estacion"> 
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
                                        <td><a href="{$_layoutParams.root}monitoreo/estacion/{$datos.EstacionId}">Ver</a></td>

                                    </tr>

                                {/foreach}
                            </table> 

                            {$paginacion_estaciones|default}
                        {else}

                            <p><strong>No hay registros!</strong></p>

                        {/if} 
                    </div>
                {else}
                    <div id="estacion_lista_variables"> 

                        {if isset($variables) && count($variables)}
                            <div class="col-md-6">
                                <h3>Todas las variables estudiadas</h3>
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
                                        <th>Variable</th> 
                                        <th>UND</th>  
                                        <th>Valor</th>                                         
                                        <th>Colecta</th>                                      

                                    </tr>
                                </thead>
                                {foreach item=datos from=$variables key=key name=i}
                                    <tr>
                                       
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
                    </div> 
                {/if}
            </div>

        </div> 
    </div>
</div>
