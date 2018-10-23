<div class="pf-container">
    {if isset($datos)}
        <div class="pf-title">       
            <label>{$title[0]}
                {if count($title)>1}
                    {for $foo=1 to (count($title)-1)}
                        , {$title[$foo]}
                    {/for}
                {/if}
            </label>       
        </div>
        <div class="pf-content">   
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Lista de Datos</strong>   
                    <a class="pull-right"  href="{$_layoutParams.root}monitoreo/_exportaEstacionMonitoreo/{$estacion.Esm_IdEstacionMonitoreo}/{$idvars}" target="_blank"><i class="icon-share"></i>{$lenguaje.label_exportar|default}</a>
                </div>      
                <div id="monitoreo_lista_variables_estacacion" class="form-inline">
                    <div class="table-responsive" >                          
                        <table class="table table-user-information">                           
                            {if isset($datos) && count($datos)}
                                {foreach from=$datos item=dato}
                                    <tr> 
                                        <td colspan="2"><strong> {$dato.Iop_Tema} - {$dato.Iop_Subtema}</strong></td> 
                                    </tr>
                                    <tr>
                                        <td colspan="2"><em>{$dato.Iop_Pais} - <span>Lat: {$dato.Iop_Latitud}</span>, <span>long: {$dato.Iop_Longitud}</span> </em> </td>                                                              

                                    </tr>
                                    <tr> 
                                        <td>Pregunta</td>                                                                       
                                        <td>
                                            {$dato.Iop_Pregunta}
                                        </td>                                            
                                    </tr>
                                    <tr> 
                                        <td colspan="2">Respuesta  <br>                                                                

                                            {$dato.Iop_Respuesta}
                                        </td>  

                                    </tr>
                                {/foreach}
                            {else}
                            {/if}
                        </table>                  

                    </div>
                    {$paginacion|default:""}    
                </div>
            </div>
        </div>  
    {else if isset($dato)}
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    {$title[0]}
                    {if count($title)>1}
                        {for $foo=1 to (count($title)-1)}
                            , {$title[$foo]}
                        {/for}
                    {/if}
                </strong>                   
            </div>     
            <div class="table-responsive" >
                <table class="table table-user-information">
                    <tbody>
                        <tr> 
                            <td colspan="2"><strong>{$dato.Iop_Tema} - {$dato.Iop_Subtema}</strong> </td> 
                        </tr>
                        <tr>
                            <td colspan="2"><em> {$dato.Iop_Pais}- <span>Lat: {$dato.Iop_Latitud}</span>, <span>long: {$dato.Iop_Longitud}</span> <em></td>                                                              

                        </tr>
                        <tr> 
                            <td>Pregunta</td>                                                                       
                            <td>
                                {$dato.Iop_Pregunta}
                            </td>                                            
                        </tr>
                        <tr> 
                            <td colspan="2">Respuesta  <br>                                                                

                                {$dato.Iop_Respuesta}
                            </td>  

                        </tr>
                    </tbody>                               

                </table>                  

            </div>
        </div>
    {/if}


</div>

