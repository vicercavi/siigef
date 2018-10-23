<div class="pf-container">    
    <div class="pf-title">
        <a data-toggle="tooltip"  target='_blank' data-placement="bottom" class="link-home" title="Listar todas las viariables estudiadas" href="{$_layoutParams.root}calidaddeagua/monitoreo/estacion/{$estacion.Esm_IdEstacionMonitoreo}" target="_blank">
            <label>{$lenguaje.label_estacion|default}: {$estacion.Esm_Nombre}</label>   
        </a>
    </div>
    <div class="pf-content">   
        <div class="clearfix">
            <div class="pull-left">
                <span>{$estacion.Pai_Nombre|default}, {$estacion.Rio_Nombre|default},{if (!empty($estacion.Cue_Nombre))} {$lenguaje.label_cuenca|default}: {$estacion.Cue_Nombre|default}{/if}</span><br>
                <span>{$lenguaje.label_latitud|default}: {$estacion.Esm_Latitud}</span><br>
                <span>{$lenguaje.label_longitud|default}: {$estacion.Esm_Longitud}</span><br>
            </div>

            <div  class='pull-right'>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{$lenguaje.label_leyendaeca|default}</strong>                                      
                    </div>      
                    <div class="text-center">
                        {foreach from=$estadoeca item=dato}
                            <div class="estadoeca" style="background-color: {$dato.ese_color}">{$dato.ese_nombre}</div>
                        {/foreach}

                    </div>
                </div>
            </div>        
        </div>



        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>{$lenguaje.label_variablesselec|default}</strong>   
                <a class="pull-right"  href="{$_layoutParams.root}calidaddeagua/monitoreo/_exportaEstacionMonitoreo/{$estacion.Esm_IdEstacionMonitoreo}/{$idvars}" target="_blank"><i class="icon-share"></i>{$lenguaje.label_exportar|default}</a>
            </div>      
            <div id="monitoreo_lista_variables_estacacion" class="form-inline">
                <div class="table-responsive" >
                    {if isset($variables) && count($variables)}
                        <table class="table">
                            <tr>
                                <th>#</th>    
                                <th>{$lenguaje.label_variable|default}</th>    
                                <th>{$lenguaje.label_und|default}</th>  
                                <th>{$lenguaje.label_valor|default}</th>     
                                <th>{$lenguaje.label_colecta|default}</th> 
                            </tr>
                            {if isset($variables) && count($variables)}
                                {foreach from=$variables item=dato}
                                    <tr> 
                                        <td>{$numeropagina++}</td>
                                        <td><a title="{$lenguaje.label_ver|default}" target="_blank" href="{$_layoutParams.root}calidaddeagua/monitoreo/variable/{$dato.Var_IdVariable}">
                                                {$dato.Var_Nombre}{if empty($dato.Var_Abreviatura)}{$dato.Var_Abreviatura}{/if}
                                        </a></td>
                                        <td><div data-toggle="popover" rel="popover" data-placement="top" data-content="{$dato.Var_DescripcionMedida|default}" 
                                                 data-trigger="hover"
                                                 data-original-title="{$lenguaje.label_decripcionund|default}">{$dato.Var_Medida}</div></td>  
                                        <td>                                       
                                            {if empty($dato.EstadoECA)}
                                            <div class="text-center">
                                                {$dato.Mca_Valor}
                                            </div>
                                            {else}
                                            <div data-toggle="popover" rel="popover" data-placement="top" data-content="
                                                 <strong>{$lenguaje.label_eca|default}: </strong>{$dato.Cae_Nombre}<br><strong>{$lenguaje.label_fuente|default}: </strong>{$dato.Cae_Fuente}<br><strong>
                                            {$lenguaje.label_limite|default}: </strong>
                                            {if $dato.eca_signo=='<'}<{$dato.eca_maximo}
                                            {elseif $dato.eca_signo=='<='}
                                            {$dato.eca_maximo}
                                            {elseif $dato.eca_signo=='>'}>{$dato.eca_minimo}
                                            {elseif $dato.eca_signo=='>='}>={$dato.eca_minimo}
                                            {elseif $dato.eca_signo=='[]'}{$dato.eca_minimo} - {$dato.eca_maximo}{/if}                                        
                                            " data-trigger="hover"
                                            data-original-title=" {$lenguaje.title_eca|default}" 
                                            style="background-color: {$dato.EstadoECA};    text-align: center;    color: white;    font-weight: bold;  padding: 0 4px 0 4px;">
                                                {$dato.Mca_Valor}    
                                            </div>
                                            {/if}
                                                </td>  
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

                        {else}
                        {/if}
                    </table>

                  
                {else}
                   ...
                {/if}
            </div>
        </div>

    </div>




</div>     
</div>

