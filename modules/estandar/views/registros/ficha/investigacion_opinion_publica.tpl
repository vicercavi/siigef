<div class="pf-container">
     <div class="pf-title">       
            <label>Investigación Cuantitativa de Opinión Publica</label>       
        </div>   
    {if isset($datos)}        
        <div class="pf-content">   
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Lista de Resultados para: {$title[0]}
                {if count($title)>1}
                    {for $foo=1 to (count($title)-1)}
                        , {$title[$foo]}
                    {/for}
                {/if}</strong>   
                <label class="pull-right" >Exportar:  <a  href="{$_layoutParams.root}monitoreo/_exportaEstacionMonitoreo/{$estacion.Esm_IdEstacionMonitoreo}/{$idvars}" target="_blank"><i class="icon-share"></i>{$lenguaje.label_exportar|default:'PDF'}</a> | <a  href="{$_layoutParams.root}bdrecursos/share/excel/{$tabla}/{$subtema}/{$datos[0]['Rec_IdRecurso']}" target="_blank"><i class="icon-share"></i>{$lenguaje.label_exportar|default:'Excel'}</a></label>
                </div>      
                <div id="monitoreo_lista_variables_estacacion" class="form-inline">
                    <div class="table-responsive" >                          
                        <table class="table table-user-information"> 
                            <input type="hidden"></input>                          
                            {if isset($datos) && count($datos)}
                                {foreach from=$datos item=dato}
                                    <tr> 
                                        <td colspan="2">
                                            <strong>
                                                Categoria:
                                                {$dato.$campo_tema} - {$dato.$campo_subtema} - <em> {$dato.$campo_pais}</em>
                                            </strong>
                                        </td> 
                                    </tr>                                   
                                    <tr>                            
                                        <td colspan="2">
                                            <a target="_blank" title="Ver Datos" href="{$_layoutParams.root}bdrecursos/registros/opinionpublica/pregunta/{$dato.$campo_id}/{$dato.Rec_IdRecurso}">
                                                {$dato.$campo_pregunta}
                                            </a>                                            
                                        </td>                                            
                                    </tr>
                                    <tr> 
                                        <td colspan="2">Resultado  <br>  
                                            <div id="container{$dato[0]}" ></div>
                                            <script>
                                                data=[
                                                {foreach from=$dato.resultado item=item}
                                                {
                                                    name: '{$item[$dato.$campo_nombre]}' ,
                                                    y: {$item.Total}
                                                },   
                                                {/foreach}        
                                                ];
                                                chart({$dato[0]},'',data);
                                            </script>
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
                    Lista de Resultados para:
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
                            <td colspan="2"><strong>{$dato.$campo_tema} - {$dato.$campo_subtema} - <em> {$dato.$campo_pais}</em></strong> </td> 
                        </tr>                       
                        <tr>                                                                                                 
                            <td colspan="2">
                                {$dato.$campo_pregunta}
                            </td>                                            
                        </tr>
                        <tr> 
                            <td colspan="2">Resultado  <br>
                                <div id="container{$dato[0]}" ></div>
                                    <script>
                                        data=[
                                        {foreach from=$dato.resultado item=item}
                                            {
                                               name: '{$item[$dato.$campo_nombre]}' ,
                                                y: {$item.Total}
                                            },   
                                        {/foreach}        
                                        ];
                                        chart({$dato[0]},'',data);
                                        </script>                                 
                            </td>
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>
    {/if}
</div>
