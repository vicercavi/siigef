<div class="row" >
    <a  class="col s12" style="text-align:center;" href="{$_layoutParams.root}calidaddeagua/monitoreo/estacion/{$estacion.Esm_IdEstacionMonitoreo}"><h6>{$lenguaje.label_estacion|default}: {$estacion.Esm_Nombre}</h6></a>
        <ul class="collection col s12 m7 l6" style="margin-bottom: 2px;">
            
            <li class="collection-item" style="padding:5px 0px;">{$estacion.Pai_Nombre|default}, {$estacion.Rio_Nombre|default}, {if (!empty($estacion.Cue_Nombre))} {$lenguaje.label_cuenca|default}: {$estacion.Cue_Nombre|default}{/if}</li>
            <li class="collection-item" style="padding:5px 0px;">{$lenguaje.label_latitud|default}: {$estacion.Esm_Latitud}</li>
            <li class="collection-item" style="padding:5px 0px;">{$lenguaje.label_longitud|default}: {$estacion.Esm_Longitud}</li>
        </ul>
        <ul class="collection with-header col s12 m5 l6" style="margin-bottom: 2px;">
            <li class="collection-header" style="padding:5px 0px;"><h6>{$lenguaje.label_leyendaeca|default}</h6></li>
            <li class="collection-item" style="padding:5px 0px;">
                {foreach from=$estadoeca item=dato}
                <div class="estadoeca" style="background-color: {$dato.ese_color}">{$dato.ese_nombre}</div>
                {/foreach}
            </li>        
        </ul>
</div>
<div class="row">
    <div class="col  s12 m12 l12">
        <ul class="collection with-header">
            <li class="collection-header" style="text-transform: capitalize; font-weight: bold; padding:5px 0px;">{$lenguaje.label_variablesselec|default}<a class="secondary-content" href="{$_layoutParams.root}calidaddeagua/monitoreo/_exportaEstacionMonitoreo/{$estacion.Esm_IdEstacionMonitoreo}/{$idvars}" target="_blank">{$lenguaje.label_exportar|default}</a></li>
            <li class="collection-item" style="padding:5px 0px;">


                <table class="responsive-table striped bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{$lenguaje.label_variable|default}</th>    
                            <th>{$lenguaje.label_und|default}</th>  
                            <th>{$lenguaje.label_valor|default}</th>     
                            <th>{$lenguaje.label_colecta|default}</th>  
                            <!-- <th class="text-center"></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        {if isset($variables) && count($variables)}
                        {foreach from=$variables item=dato}

                        <tr> 
                            <td >{$numeropagina++}</td>
                            <td>
                            <a title="{$lenguaje.label_ver|default}" target="_blank"  href="{$_layoutParams.root}calidaddeagua/monitoreo/variable/{$dato.Var_IdVariable}">{$dato.Var_Nombre}{if empty($dato.Var_Abreviatura)}{$dato.Var_Abreviatura}{/if}</a>
                            </td>
                            <td><div data-toggle="popover" rel="popover" data-placement="top" data-content="{$dato.Var_DescripcionMedida|default}"data-trigger="hover"
                                data-original-title="{$lenguaje.label_decripcionund|default}">{$dato.Var_Medida}</div></td>  
                                <td>{if empty($dato.EstadoECA)}{$dato.Mca_Valor}{else}<div data-toggle="popover" rel="popover" data-placement="top" data-content="<strong>{$lenguaje.label_eca|default}: </strong>{$dato.Cae_Nombre}<br><strong>{$lenguaje.label_fuente|default}: </strong>{$dato.Cae_Fuente}<br><strong>
                                    {$lenguaje.label_limite|default}: </strong>{if $dato.eca_signo=='<'}<{$dato.eca_maximo}{elseif $dato.eca_signo=='<='}{$dato.eca_maximo}{elseif $dato.eca_signo=='>'}>{$dato.eca_minimo}{elseif $dato.eca_signo=='>='}>={$dato.eca_minimo}{elseif $dato.eca_signo=='[]'}{$dato.eca_minimo} - {$dato.eca_maximo}{/if}                                        
                                    " data-trigger="hover"
                                    data-original-title=" {$lenguaje.title_eca|default}" 
                                    style="background-color: {$dato.EstadoECA};    text-align: center;    color: white;    font-weight: bold;  padding: 0 4px 0 4px;">{$dato.Mca_Valor}</div>{/if}</td>  
                                    <td>{if ($dato.Mca_Fecha|count_characters)==4}{$dato.Mca_Fecha}{else}{$dato.Mca_Fecha|substr:6:2}/{$dato.Mca_Fecha|substr:4:2}/{$dato.Mca_Fecha|substr:0:4}{/if}</td>                                      
                                </tr>
                                {/foreach}
                                {else}
                                {/if}
                            </tbody>
                        </table>
                    </li>
                </ul>
            </div>
        </div>

