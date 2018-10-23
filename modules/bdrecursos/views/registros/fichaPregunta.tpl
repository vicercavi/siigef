{if !isset($variable)}     
        <div class="panel panel-default">
            <div class="panel-heading">                       
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;
                    <strong>Detalle de Repuestas</strong><span class="badge  pull-right">{$control_paginacion_var}</span> </h3>
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
                                <th>Etiqueta</th> 
                                <th>Tema</th>   
                                <th>SubTema</th>                                           
                                <th>Pais</th>
                                <th>Latitud</th>
                                <th>Longitud</th>
                            </tr>
                        </thead>
                        {foreach item=datos from=$variables key=key name=i}
                            <tr>
                                <td>{$numeropagina_var++}</td>
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
    <h2 class="tit-pagina-principal">Detalle de respuestas</h2>
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
                                    <td style="border:none;">{$variable[0][$campo_nombre]}</td>
                                </tr>
                                <tr>
                                    <td>Etiqueta: </td>
                                    <td>{$variable[0][$campo_etiqueta]}</td>
                                </tr>
                                <tr>
                                    <td>Tema: </td>
                                    <td>{$variable[0][$campo_tema]}</td>
                                </tr>                                
                                <tr>
                                    <td>Subtema: </td>
                                    <td>{$variable[0][$campo_subtema]}</td>
                                </tr>
                                <tr>
                                    <td>País: </td>
                                    <td>{$variable[0][$campo_pais]}</td>
                                </tr>
                                <tr>
                                    <td>Longitud: </td>
                                    <td>{$variable[0][$campo_latitud]}</td>
                                </tr>
                                <tr>
                                    <td>Latitud: </td>
                                    <td>{$variable[0][$campo_latitud]}</td>
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
                            <strong>Todas las repuestas</strong>
                        </h4>
                    </div> 
                    <div class="panel-body">
                        <div class="col-md-7">  
                            <div id="lista_respuesta">
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
                            </div>  
                        </div>
                        <div class="col-md-5">  
                            <div class="table-responsive" >                          
                        <table class="table table-user-information"> 
                            <input type="hidden"></input>                          
                                {if isset($dato) && count($dato)}                                    
                                    <tr> 
                                        <td colspan="2">
                                            <strong>
                                                <strong>Gráfico</strong>
                                            </strong>
                                        </td> 
                                    </tr>                                   
                                    <tr> 
                                        <td colspan="2">Resultado  <br>
                                            <div id="container{$dato[0]}" ></div>
                                                <script>
                                                    data=[
                                                    {foreach from=$dato.resultado item=item}
                                                        {
                                                           name: '{$item[$nombre_pregunta]}' ,
                                                            y: {$item.Total}
                                                        },   
                                                    {/foreach}        
                                                    ];
                                                    datotitle={$dato[0]}
                                                    
                                                    </script>                                 
                                            </td>
                                    </tr>                                    
                                {else}
                                {/if}
                        </table>
                    </div>
                        </div>                         
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
{/if}
