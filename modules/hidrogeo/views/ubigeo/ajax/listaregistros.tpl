{if isset($ubigeos) && count($ubigeos)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_ubigeo}</th>
                <th style=" text-align: center"></th>
                <th style=" text-align: center"></th>
                <th style=" text-align: center"></th>
                <th style=" text-align: center"></th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$ubigeos item=ubigeo}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$ubigeo.Pai_Nombre}</td> 
                    <td>{$ubigeo.t1}</td>
                    <td>{$ubigeo.t2}</td>
                    <td>{$ubigeo.t3}</td>
                    <td>{$ubigeo.t4}</td>

                    <td style=" text-align: center">
                        {if $ubigeo.Ubi_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $ubigeo.Ubi_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_ubigeo")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/ubigeo/editar/{$ubigeo.Ubi_IdUbigeo}"></a>
                        {/if}{if $_acl->permiso("habilitar_deshabilitar_ubigeo")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-ubigeo" title="{$lenguaje.label_cambiar_estado}" idubigeo="{$ubigeo.Ubi_IdUbigeo}" estado="{if $ubigeo.Ubi_Estado==0}1{else}0{/if}"> </a>      
                        {/if}{if $_acl->permiso("eliminar_ubigeo")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-ubigeo" title="{$lenguaje.label_eliminar}" idubigeo="{$ubigeo.Ubi_IdUbigeo}"> </a>
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