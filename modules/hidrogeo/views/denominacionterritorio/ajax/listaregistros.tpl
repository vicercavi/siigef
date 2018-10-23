{if isset($denominacionterritorios) && count($denominacionterritorios)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_denominacionterritorio}</th>
                <th style=" text-align: center">{$lenguaje.label_nivel}</th>
                <th style=" text-align: center">{$lenguaje.label_pais}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>

                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$denominacionterritorios item=denominacionterritorio}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$denominacionterritorio.Det_Nombre}</td>
                    <td>{$denominacionterritorio.Det_Nivel}</td>
                    <td>{$denominacionterritorio.Pai_Nombre}</td>  
                    <td style=" text-align: center">
                        {if $denominacionterritorio.Det_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $denominacionterritorio.Det_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_denominacionterritorio")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/denominacionterritorio/index/{$denominacionterritorio.Det_IdDenomTerrit}"></a>
                        {/if}
                        {if $_acl->permiso("habilitar_deshabilitar_denominacionterritorio")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-denominacionterritorio" title="{$lenguaje.label_cambiar_estado}" iddenominacionterritorio="{$denominacionterritorio.Det_IdDenomTerrit}" estado="{if $denominacionterritorio.Det_Estado==0}1{else}0{/if}"> </a>      
                        {/if}
                        {if $_acl->permiso("eliminar_denominacionterritorio")}
                            <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="Confirmación de eliminación" data-id="{$denominacionterritorio.Det_IdDenomTerrit}" data-nombre="{$denominacionterritorio.Det_Nombre}" class="btn btn-default btn-sm glyphicon glyphicon-trash">
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