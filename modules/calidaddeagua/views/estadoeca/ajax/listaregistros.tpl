 {if isset($estadoecas) && count($estadoecas)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_referencia}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estadoeca}</th>
                                        <th style=" text-align: center">{$lenguaje.label_color}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$estadoecas item= estadoeca}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$estadoeca.ese_refencia}</td>
                                            <td>{$estadoeca.ese_nombre}</td>
                                            <td>{$estadoeca.ese_color}</td>
                                            <td style=" text-align: center">
                                                {if $estadoeca.ese_estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $estadoeca.ese_estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_estadoeca")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/estadoeca/editar/{$estadoeca.ese_IdEstadoEca}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_estadoeca")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-estadoeca" title="{$lenguaje.label_cambiar_estado}" idestadoeca="{$estadoeca.ese_IdEstadoEca}" estado="{if $estadoeca.ese_estado==0}1{else}0{/if}"> </a>      
                                                {/if}{if $_acl->permiso("eliminar_estadoeca")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-estadoeca" title="{$lenguaje.label_eliminar}" idestadoeca="{$estadoeca.ese_IdEstadoEca}"> </a>
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