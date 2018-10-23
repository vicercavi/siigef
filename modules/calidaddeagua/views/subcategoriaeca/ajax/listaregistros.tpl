{if isset($subcategoriaecas) && count($subcategoriaecas)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_subcategoriaeca}</th>
                                        <th style=" text-align: center">{$lenguaje.label_categoriaeca}</th>
                                        <th style=" text-align: center">{$lenguaje.label_descripcion}</th>
                                         <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$subcategoriaecas item=subcategoriaeca}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            
                                            <td>{$subcategoriaeca.Sue_Nombre}</td>
                                            <td>{$subcategoriaeca.Cae_Nombre}</td>
                                            <td>{$subcategoriaeca.Sue_Descripcion}</td>
                                            <td style=" text-align: center">
                                                {if $subcategoriaeca.Sue_Estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $subcategoriaeca.Sue_Estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_subcategoriaeca")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/subcategoriaeca/editar/{$subcategoriaeca.Sue_IdSubcategoriaEca}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_subcategoriaeca")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-subcategoriaeca" title="{$lenguaje.label_cambiar_estado}" idsubcategoriaeca="{$subcategoriaeca.Sue_IdSubcategoriaEca}" estado="{if $subcategoriaeca.Sue_Estado==0}1{else}0{/if}"> </a>      
                                                {/if}{if $_acl->permiso("eliminar_subcategoriaeca")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-subcategoriaeca" title="{$lenguaje.label_eliminar}" idsubcategoriaeca="{$subcategoriaeca.Sue_IdSubcategoriaEca}"> </a>
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