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
                        {if isset($fichaestandar) && count($fichaestandar)}                      
                            {foreach from=$fichaestandar item=dato}                                 
                                <th>{$dato.Fie_CampoFicha}</th> 
                                {/foreach}
                            {if isset($datos) && count($datos)}
                                {foreach from=$datos item=dato}
                                    <tr> 
                                        <td>{$numeropagina++}</td>
                                        {foreach from=$fichaestandar item=ficha}                                 
                                            <td>{$dato[$ficha.Fie_ColumnaTabla]}</td> 
                                        {/foreach}
                                    </tr>
                                {/foreach}
                            {else}
                            {/if}
                            </table>                  
                        {else}
                            ...
                        {/if}
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
                {if isset($fichaestandar) && count($fichaestandar)}
                    <table class="table table-user-information">
                        <tbody> 
                            {foreach from=$fichaestandar item=ficha}
                                <tr> 
                                    <td>{$ficha.Fie_CampoFicha}</td>                                                                       
                                    <td>
                                        {$dato[$ficha.Fie_ColumnaTabla]}</td>                                            
                                </tr>
                            {/foreach}                
                        </tbody>                               

                    </table>                  
                {else}
                    ...
                {/if}
            </div>
        </div>
    {/if}


</div>

