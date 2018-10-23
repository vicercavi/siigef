{if !isset($estacion)}
     
    <div class="panel panel-default">
        <div class="panel-heading">                       
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;
                <strong>Lista de Estaciónes de Monitoreo de Calidad de Agua</strong>
                <span class="badge  pull-right">{$control_paginacion_est}</span> 
            </h3>
        </div>
        <div class=" row panel-body">
            <div class="col-md-12 pull-right form-inline text-right">
                <div class="input-group">
                    <input id="tb_nombre_filter" type="text" class="form-control"  placeholder="Nombre de estación" value="{$tb_nombre|default}" />  
                    <input type="hidden" value="" id="id_variable"></input>                     
                    <span class="input-group-btn">
                        <button id="bt_buscar_estacion" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>                
            </div>
        </div>
        <div class="table-responsive">
            <div id="lista_estacion"> 
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
            </div>
        </div>
    </div>
    

{else}
<div class="container" style="margin:10px auto;">
    <div class="row">
    <div class="col-md-12">
    <h2 class="tit-pagina-principal">Estación de Monitoreo de calidad de agua</h2>
    </div>      
        <div class="col-md-3">     
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <strong>Metadata</strong>
                        </h4>
                        <input type="hidden" id="tb_nombre_filter" value=""></input>
                        <input type="hidden" value="{$id_estacion}" id="id_variable"></input>
                    </div>               
                    <div class="panel-body">
                        <table class="table table-user-information">
                            <tbody>                           
                                <tr>
                                    <td style="border:none;">Nombre: </td>
                                    <td style="border:none;">{$estacion_metadata[0]['Esm_Nombre']}</td>
                                </tr>
                                <tr>
                                    <td>Latitud: </td>
                                    <td>{$estacion_metadata[0]['Esm_Latitud']}</td>
                                </tr>
                                <tr>
                                    <td>Longitud: </td>
                                    <td>{$estacion_metadata[0]['Esm_Longitud']}</td>
                                </tr>                                
                                <tr>
                                    <td>Cuenca: </td>
                                    <td>{ucfirst(strtolower($cuenca[0]['Cue_Nombre']))|default:''}</td>
                                </tr>
                                <tr>
                                    <td>Sub Cuenca: </td>
                                    <td>{ucfirst(strtolower($subcuenca[0]['Suc_Nombre']))|default:''}  </td>
                                </tr>
                                <tr>
                                    <td>Rio: </td>
                                    <td>{ucfirst(strtolower($rio[0]['Rio_Nombre']))|default:''}</td>
                                </tr>
                                <tr>                                    
                                    {if  isset($denominaciones[0])}
                                        <td class="col-md-3 text-right">{$denominaciones[0]['Det_Nombre']}:</td>
                                        <td>{ucfirst(strtolower($territorios1[0]['Ter_Nombre']))|default:''} </td> 
                                    {/if}                                    
                                </tr>
                                <tr>                                    
                                    {if  isset($denominaciones[1])}
                                        <td class="col-md-3 text-right">{$denominaciones[1]['Det_Nombre']}:</td>
                                        <td>{ucfirst(strtolower($territorios2[0]['Ter_Nombre']))|default:''} </td> 
                                    {/if}                                    
                                </tr>
                                <tr>                                    
                                    {if  isset($denominaciones[2])}
                                        <td class="col-md-3 text-right">{$denominaciones[2]['Det_Nombre']}:</td>
                                        <td>{ucfirst(strtolower($territorios3[0]['Ter_Nombre']))|default:''} </td> 
                                    {/if}                                    
                                </tr>
                                <tr>                                    
                                    {if  isset($denominaciones[4])}
                                        <td class="col-md-3 text-right">{$denominaciones[2]['Det_Nombre']}:</td>
                                        <td>{ucfirst(strtolower($territorios4[0]['Ter_Nombre']))|default:''} </td> 
                                    {/if}                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
               <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <strong>Todas las variables estudiadas</strong>
                        </h4>
                    </div> 
                    <div class="col-md-4 col-md-offset-9">
                        {if isset($estadoeca) && count($estadoeca)}
                            {foreach item=datos from=$estadoeca key=key name=i}
                                <div class="estadoeca" style="background-color: {$datos.ese_color}"> {$datos.ese_nombre}</div>
                            {/foreach}

                        {/if}
                    </div>              
                    <div class="panel-body">
                        <div id="lista_estacion_variable">
                            {if isset($variables) && count($variables)}
                            <table class="table table-hover">
                                <thead>
                                    <tr>  
                                        <th>#</th>
                                        <th>Variable</th> 
                                        <th>UND</th>  
                                        <th>Valor</th>                                         
                                        <th>Colecta</th>                                      

                                    </tr>
                                </thead>
                                {foreach item=dato from=$variables key=key name=i}
                                    <tr>
                                        <td>{$numeropagina_var++}</td>                                       
                                        <td>{$dato.Var_Nombre} {if empty($dato.Var_Abreviatura)}{$dato.Var_Abreviatura}{/if}</td>
                                        <td>{$dato.Var_Medida}</td>
                                        <td>
                                        {if empty($dato.EstadoECA)}{$dato.Mca_Valor}{else}
                                            <div data-toggle="popover" rel="popover" data-placement="top" data-content="
                                                 <strong>ECA: </strong>{$dato.Cae_Nombre}<br><strong>Fuente: </strong>{$dato.Cae_Fuente}<br><strong>
                                                 Limite: </strong>{if $dato.eca_signo=='<'}<{$dato.eca_maximo}{elseif $dato.eca_signo=='<='}{$dato.eca_maximo}{elseif $dato.eca_signo=='>'}>{$dato.eca_minimo}{elseif $dato.eca_signo=='>='}>={$dato.eca_minimo}{elseif $dato.eca_signo=='[]'}{$dato.eca_minimo} - {$dato.eca_maximo}{/if}                                        
                                                 " data-trigger="hover"
                                                 data-original-title="Estandar de Calidad Ambiental para Agua" 
                                                 style="background-color: {$dato.EstadoECA};    text-align: center;    color: white;    font-weight: bold;  padding: 0 4px 0 4px;">{$dato.Mca_Valor}</div>
                                        {/if}</td>  
                                        <td>
                                        {if ($dato.Mca_Fecha|count_characters:true)<=7}
                                            {$dato.Mca_Fecha}
                                        {elseif ($dato.Mca_Fecha|count_characters:true)>=8 && ($dato.Mca_Fecha|count_characters:true)<=10 }
                                            {$dato.Mca_Fecha|date_format:"%d/%m/%Y"}                                    
                                        {else}
                                            {$dato.Mca_Fecha|date_format:"%d/%m/%Y %H:%M"}                                    
                                        {/if}
                                    </td>  
                                    </tr>
                                {/foreach}
                            </table> 
                            {$paginacion_variables|default}
                            {else}
                                <p><strong>No hay registros!</strong></p>
                            {/if} 
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
{/if}
