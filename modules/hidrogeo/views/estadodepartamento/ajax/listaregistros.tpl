{if isset($estadodepartamentos) && count($estadodepartamentos)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_estadodepartamento}</th>
                <th style=" text-align: center">{$lenguaje.label_siglas}</th>
                <th style=" text-align: center">{$lenguaje.label_denominacion}</th>
                <th style=" text-align: center">{$lenguaje.label_pais}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>

                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$estadodepartamentos item=estadodepartamento}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$estadodepartamento.Esd_Nombre}</td>
                    <td>{$estadodepartamento.Esd_Siglas}</td>
                    <td>{$estadodepartamento.Esd_Denominacion}</td>  
                    <td>{$estadodepartamento.Pai_Nombre}</td>  
                    <td style=" text-align: center">
                        {if $estadodepartamento.Esd_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $estadodepartamento.Esd_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_estadodepartamento")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/estadodepartamento/editar/{$estadodepartamento.Esd_IdEstadoDepartamento}"></a>
                        {/if}{if $_acl->permiso("habilitar_deshabilitar_estadodepartamento")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-estadodepartamento" title="{$lenguaje.label_cambiar_estado}" idestadodepartamento="{$estadodepartamento.Esd_IdEstadoDepartamento}" estado="{if $estadodepartamento.Esd_Estado==0}1{else}0{/if}"> </a>      
                        {/if}{if $_acl->permiso("eliminar_estadodepartamento")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-estadodepartamento" title="{$lenguaje.label_eliminar}" idestadodepartamento="{$estadodepartamento.Esd_IdEstadoDepartamento}"> </a>
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