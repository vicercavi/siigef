{if isset($paises) && count($paises)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_pais}</th>
                <th style=" text-align: center">{$lenguaje.label_siglas}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$paises item=pais}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$pais.Pai_Nombre}</td>
                    <td>{$pais.Pai_Siglas}</td>
                    <td style=" text-align: center">
                        {if $pais.Pai_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $pais.Pai_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_pais")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/pais/index/{$pais.Pai_IdPais}"></a>
                        {/if}
                        {if $_acl->permiso("habilitar_deshabilitar_pais")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-pais" title="{$lenguaje.label_cambiar_estado}" idpais="{$pais.Pai_IdPais}" estado="{if $pais.Pai_Estado==0}1{else}0{/if}"> </a>      
                        {/if}
                        {if $_acl->permiso("eliminar_pais")}
                            <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="Confirmación de eliminación" data-id="{$pais.Pai_IdPais}" data-nombre="{$pais.Pai_Nombre}" class="btn btn-default btn-sm glyphicon glyphicon-trash">
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