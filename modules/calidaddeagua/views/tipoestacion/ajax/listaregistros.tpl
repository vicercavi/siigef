{if isset($tipoestaciones) && count($tipoestaciones)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_tipoestacion}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$tipoestaciones item=tipoestacion}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$tipoestacion.Tie_Nombre}</td>
                                            <td style=" text-align: center">
                                                {if $tipoestacion.Tie_Estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $tipoestacion.Tie_Estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_tipoestacion")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/tipoestacion/editar/{$tipoestacion.Tie_IdTipoEstacion}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_tipoestacion")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-tipoestacion" title="{$lenguaje.label_cambiar_estado}" idtipoestacion="{$tipoestacion.Tie_IdTipoEstacion}" estado="{if $tipoestacion.Tie_Estado==0}1{else}0{/if}"> </a>      
                                                {/if}{if $_acl->permiso("eliminar_tipoestacion")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-tipoestacion" title="{$lenguaje.label_eliminar}" idtipoestacion="{$tipoestacion.Tie_IdTipoEstacion}"> </a>
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