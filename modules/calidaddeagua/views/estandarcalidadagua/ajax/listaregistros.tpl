{if isset($estandaraguas) && count($estandaraguas)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_estadoeca}</th>
                <th style=" text-align: center">{$lenguaje.label_variable}</th>
                <th style=" text-align: center">{$lenguaje.label_Signo}</th>
                <th style=" text-align: center">{$lenguaje.label_valor_min}</th>
                <th style=" text-align: center">{$lenguaje.label_valor_max}</th>
                <th style=" text-align: center">{$lenguaje.label_estado_eca}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$estandaraguas item=estandar}
                <tr>
                    <td>{$numeropagina++}</td>

                    <td>{$estandar.Sue_Nombre}</td>
                    <td>{$estandar.Var_Nombre}</td>
                    <td>{$estandar.eca_signo}</td>
                    <td>{$estandar.eca_minimo}</td>
                    <td>{$estandar.eca_maximo}</td>
                    <td>{$estandar.ese_nombre}</td>
                    <td style=" text-align: center">
                        {if $estandar.eca_estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $estandar.eca_estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_estandarcalidadagua")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/estandarcalidadagua/editar/{$estandar.eca_idEstandarCalidadAmbientalAgua}"></a>
                        {/if}{if $_acl->permiso("habilitar_deshabilitar_estandarcalidadagua")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-estandarcalidadagua" title="{$lenguaje.label_cambiar_estado}" idestandarcalidadagua="{$estandar.eca_idEstandarCalidadAmbientalAgua}" estado="{if $estandar.eca_estado==0}1{else}0{/if}"> </a>      
                        {/if}{if $_acl->permiso("eliminar_estandarcalidadagua")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-estandarcalidadagua" title="{$lenguaje.label_eliminar}" idestandarcalidadagua="{$estandar.eca_idEstandarCalidadAmbientalAgua}"> </a>
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