{if isset($estacionmonitoreos) && count($estacionmonitoreos)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_nombre_1}</th>
                                        <th style=" text-align: center">{$lenguaje.label_latitud}</th>
                                        <th style=" text-align: center">{$lenguaje.label_longitud}</th>
                                        <th style=" text-align: center">{$lenguaje.label_referencia}</th>
                                        <th style=" text-align: center">{$lenguaje.label_altitud}</th>
                                        <th style=" text-align: center">{$lenguaje.label_nombre_rio}</th>
                                        <th style=" text-align: center">{$lenguaje.label_tipo_estacion}</th>
                                        <th style=" text-align: center">{$lenguaje.label_municipio}</th>
                                        <th style=" text-align: center">{$lenguaje.label_departamento}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$estacionmonitoreos item=estacionmonitoreo}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$estacionmonitoreo.Esm_Nombre}</td>
                                            <td>{$estacionmonitoreo.Esm_Latitud}</td>
                                            <td>{$estacionmonitoreo.Esm_Longitud}</td>
                                            <td>{$estacionmonitoreo.Esm_Referencia}</td>
                                            <td>{$estacionmonitoreo.Esm_Altitud}</td>
                                            <td>{$estacionmonitoreo.Ric_Nombre}</td>
                                            <td>{$estacionmonitoreo.Tie_Nombre}</td>
                                            <td>{$estacionmonitoreo.Mpd_Nombre}</td>
                                            <td>{$estacionmonitoreo.Esd_Nombre}</td>
                                            <td style=" text-align: center">
                                                {if $estacionmonitoreo.Esm_Estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $estacionmonitoreo.Esm_Estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_estacionmonitoreo")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/estacionmonitoreo/editar/{$estacionmonitoreo.Esm_IdEstacionMonitoreo}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_estacionmonitoreo")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-estacionmonitoreo" title="{$lenguaje.label_cambiar_estado}" idestacionmonitoreo="{$estacionmonitoreo.Esm_IdEstacionMonitoreo}" estado="{if $estacionmonitoreo.Esm_Estado==0}1{else}0{/if}"> </a>      
                                                {/if}{if $_acl->permiso("eliminar_estacionmonitoreo")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-estacionmonitoreo" title="{$lenguaje.label_eliminar}" idestacionmonitoreo="{$estacionmonitoreo.Esm_IdEstacionMonitoreo}"> </a>
                                                {/if}
                                            </td>                                            
                                        </tr>
                                    {/foreach}
                                </table>
                            </div>
                            {$paginacion|default:""}
                        {else}
                            {$lenguaje.no_registros}
                        {/if} 