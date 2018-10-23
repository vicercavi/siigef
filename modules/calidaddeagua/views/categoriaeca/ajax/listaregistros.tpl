            {if isset($categoriaecas) && count($categoriaecas)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_categoriaeca}</th>
                                         <th style=" text-align: center">{$lenguaje.label_descripcion}</th>
                                          <th style=" text-align: center">{$lenguaje.label_fuente}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$categoriaecas item=categoriaeca}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$categoriaeca.Cae_Nombre}</td>
                                            <td>{$categoriaeca.Cae_Descripcion}</td>
                                            <td>{$categoriaeca.Cae_Fuente}</td>
                                            <td style=" text-align: center">
                                                {if $categoriaeca.Cae_Estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $categoriaeca.Cae_Estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_categoriaeca")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/categoriaeca/editar/{$categoriaeca.Cae_IdCategoriaEca}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_categoriaeca")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-categoriaeca" title="{$lenguaje.label_cambiar_estado}" idcategoriaeca="{$categoriaeca.Cae_IdCategoriaEca}" estado="{if $categoriaeca.Cae_Estado==0}1{else}0{/if}"> </a>      
                                                {/if}{if $_acl->permiso("eliminar_categoriaeca")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-categoriaeca" title="{$lenguaje.label_eliminar}" idcategoriaeca="{$categoriaeca.Cae_IdCategoriaEca}"> </a>
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