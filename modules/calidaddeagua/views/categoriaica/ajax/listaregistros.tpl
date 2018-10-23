{if isset($categoriaicas) && count($categoriaicas)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_categoriaica}</th>
                <th style=" text-align: center">{$lenguaje.label_descripcion}</th>
                <th style=" text-align: center">{$lenguaje.label_fuente}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$categoriaicas item=categoriaica}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$categoriaica.Cai_Nombre}</td>
                    <td>{$categoriaica.Cai_Descripcion}</td>
                    <td>{$categoriaica.Cai_Fuente}</td>
                    <td style=" text-align: center">
                        {if $categoriaica.Cai_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $categoriaica.Cai_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_categoriaica")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/categoriaica/editar/{$categoriaica.Cai_IdCategoriaIca}"></a>
                        {/if}{if $_acl->permiso("habilitar_deshabilitar_categoriaica")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-categoriaica" title="{$lenguaje.label_cambiar_estado}" idcategoriaica="{$categoriaica.Cai_IdCategoriaIca}" estado="{if $categoriaica.Cai_Estado==0}1{else}0{/if}"> </a>      
                        {/if}{if $_acl->permiso("eliminar_categoriaica")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-categoriaica" title="{$lenguaje.label_eliminar}" idcategoriaica="{$categoriaica.Cai_IdCategoriaIca}"> </a>
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