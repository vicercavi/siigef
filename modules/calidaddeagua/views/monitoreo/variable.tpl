{if !isset($variable)}
     
        <div class="panel panel-default">
            <div class="panel-heading">                       
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;
                    <strong>Lista de Variable de Monitoreo de Calidad de Agua</strong><span class="badge  pull-right">{$control_paginacion_var}</span> </h3>
            </div>
            <div class=" row panel-body">
                <div class="col-md-12 pull-right form-inline text-right">
                    <div class="input-group">
                        <input id="tb_nombre_filter" type="text" class="form-control"  placeholder="Nombre de variable" value="{$tb_nombre|default}" /> 
                        <input type="hidden" value="" id="id_variable"></input>                    
                        <span class="input-group-btn">
                            <button id="bt_buscar_variable" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">                
                <div id="lista_variable">   
                    {if isset($variables) && count($variables)}                            
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th> 
                                <th>Abreviatura</th> 
                                <th>Unidad de Medida</th>   
                                <th>Tipo</th>                                           
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        {foreach item=datos from=$variables key=key name=i}
                            <tr>
                                <td>{{$numeropagina_var++}}</td>
                                <td>{$datos.Var_Nombre}</td>
                                <td>{$datos.Var_Abreviatura}</td>
                                <td>{$datos.Var_Medida}</td>
                                <td>{$datos.Tiv_Nombre}</td>
                                <td>
                                    <!--<a type="button" title="Editar" class="btn btn-default btn-sm glyphicon glyphicon-pencil" href="#"></a>-->  
                                    <a type="button" title="Ver" class="btn btn-default btn-sm glyphicon glyphicon-eye-open" target="_blank" href="{$_layoutParams.root}calidaddeagua/monitoreo/variable/{$datos.Var_IdVariable}"></a>
                                    </a>
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

{else}
<div class="container" style="margin:10px auto;">
    <div class="row">
    <div class="col-md-12">
    <h2 class="tit-pagina-principal">Monitoreo de calidad de agua</h2>
    </div>      
        <div class="col-md-3">     
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <strong>Metadata</strong>
                        </h4>
                        <input type="hidden" id="tb_nombre_filter" value=""></input>
                        <input type="hidden" value="{$id_variable}" id="id_variable"></input>
                    </div>               
                    <div class="panel-body">
                        <table class="table table-user-information">
                            <tbody>                           
                                <tr>
                                    <td style="border:none;">Nombre: </td>
                                    <td style="border:none;">{$variable_metadata[0]['Var_Nombre']}</td>
                                </tr>
                                <tr>
                                    <td>Abreviatura: </td>
                                    <td>{$variable_metadata[0]['Var_Abreviatura']}</td>
                                </tr>
                                <tr>
                                    <td>Unidad de Medidad: </td>
                                    <td>{$variable_metadata[0]['Var_Medida']}</td>
                                </tr>                                
                                <tr>
                                    <td>Unidad de Medidad Descripción: </td>
                                    <td>{$variable_metadata[0]['Var_DescripcionMedida']}</td>
                                </tr>
                                <tr>
                                    <td>Tipo: </td>
                                    <td>{ucfirst(strtolower($variable_metadata[0]['Tiv_Nombre']))|default:''}  </td>
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
                            <strong>Todas las estaciones estudiadas</strong>
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

                        <div id="lista_variable_estacion">
                            {if isset($estaciones) && count($estaciones)}
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
                            {$paginacion_estaciones|default}
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
{/if}
