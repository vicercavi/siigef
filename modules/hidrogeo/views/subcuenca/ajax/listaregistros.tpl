{if isset($subcuencas) && count($subcuencas)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_subcuenca}</th>
                <th style=" text-align: center">{$lenguaje.label_cuenca}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$subcuencas item=subcuenca}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$subcuenca.Suc_Nombre}</td>
                    <td>{$subcuenca.Cue_Nombre}</td>
                    <td style=" text-align: center">
                        {if $subcuenca.Suc_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $subcuenca.Suc_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_subcuenca")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/subcuenca/index/{$subcuenca.Suc_IdSubcuenca}"></a>
                        {/if}
                        {if $_acl->permiso("habilitar_deshabilitar_subcuenca")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-subcuenca" title="{$lenguaje.label_cambiar_estado}" idsubcuenca="{$subcuenca.Suc_IdSubcuenca}" estado="{if $subcuenca.Suc_Estado==0}1{else}0{/if}"> </a>      
                        {/if}
                        {if $_acl->permiso("eliminar_subcuenca")}
                            <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="Confirmación de eliminación" data-id="{$subcuenca.Suc_IdSubcuenca}" data-nombre="{$subcuenca.Suc_Nombre}" class="btn btn-default btn-sm glyphicon glyphicon-trash" >
                                </a>
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