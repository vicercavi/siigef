{if isset($tipovariables) && count($tipovariables)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_nombre}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$tipovariables item= tipovariable}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$tipovariable.Tiv_Nombre}</td>
                                            <td style=" text-align: center">
                                                {if $tipovariable.Tiv_Estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $tipovariable.Tiv_Estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_tipovariable")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/tipovariable/editar/{$tipovariable.Tiv_IdTipoVariable}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_tipovariable")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-tipovariable" title="{$lenguaje.label_cambiar_estado}" idtipovariable="{$tipovariable.Tiv_IdTipoVariable}" estado="{if $tipovariable.Tiv_Estado==0}1{else}0{/if}"> </a>      
                                                {/if}{if $_acl->permiso("eliminar_tipovariable")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-tipovariable" title="{$lenguaje.label_eliminar}" idtipovariable="{$tipovariable.Tiv_IdTipoVariable}"> </a>
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