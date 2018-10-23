{if isset($riocuencas) && count($riocuencas)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_rio}</th>
                <th style=" text-align: center">{$lenguaje.label_subcuenca}</th>
                <th style=" text-align: center">{$lenguaje.label_cuenca}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$riocuencas item=riocuenca}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$riocuenca.Rio_Nombre}</td>
                    <td>{$riocuenca.Suc_Nombre}</td>
                    <td>{$riocuenca.Cue_Nombre}</td>
                    <td style=" text-align: center">
                        {if $riocuenca.Ric_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $riocuenca.Ric_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_riocuenca")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/riocuenca/index/{$riocuenca.Ric_IdRioCuenca}"></a>
                        {/if}
                        {if $_acl->permiso("habilitar_deshabilitar_riocuenca")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-riocuenca" title="{$lenguaje.label_cambiar_estado}" idriocuenca="{$riocuenca.Ric_IdRioCuenca}" estado="{if $riocuenca.Ric_Estado==0}1{else}0{/if}"> </a>      
                        {/if}
                        {if $_acl->permiso("eliminar_riocuenca")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-riocuenca" title="{$lenguaje.label_eliminar}" idriocuenca="{$riocuenca.Ric_IdRioCuenca}"> </a>
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