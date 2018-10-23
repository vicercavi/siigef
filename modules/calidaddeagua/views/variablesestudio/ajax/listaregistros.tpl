{if isset($variablesestudios) && count($variablesestudios)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_variablesestudio}</th>
                                        <th style=" text-align: center">{$lenguaje.label_abreviatura}</th>
                                        <th style=" text-align: center">{$lenguaje.label_medida}</th>
                                         <th style=" text-align: center">{$lenguaje.label_tipovariable}</th>
                                          <th style=" text-align: center">{$lenguaje.label_descripcion}</th>
                                         <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$variablesestudios item=variablesestudio}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            
                                            <td>{$variablesestudio.Var_Nombre}</td>
                                            <td>{$variablesestudio.Var_Abreviatura}</td>
                                            <td>{$variablesestudio.Var_Medida}</td>
                                            <td>{$variablesestudio.Tiv_Nombre}</td>
                                            <td>{$variablesestudio.Var_DescripcionMedida}</td>
                                            <td style=" text-align: center">
                                                {if $variablesestudio.Var_Estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $variablesestudio.Var_Estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_variablesestudio")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/variablesestudio/editar/{$variablesestudio.Var_IdVariable}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_variablesestudio")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-variablesestudio" title="{$lenguaje.label_cambiar_estado}" idvariablesestudio="{$variablesestudio.Var_IdVariable}" estado="{if $variablesestudio.Var_Estado==0}1{else}0{/if}"> </a>      
                                                {/if}{if $_acl->permiso("eliminar_variablesestudio")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-variablesestudio" title="{$lenguaje.label_eliminar}" idvariablesestudio="{$variablesestudio.Var_IdVariable}"> </a>
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