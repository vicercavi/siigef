{if isset($territorios) && count($territorios)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">{$lenguaje.label_territorio}</th>
                <th style=" text-align: center">{$lenguaje.label_siglas}</th>
                <th style=" text-align: center">{$lenguaje.label_denominacion}</th>
                <th style=" text-align: center">{$lenguaje.label_pais}</th>
                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
            </tr>
            {foreach from=$territorios item=territorio}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$territorio.Ter_Nombre}</td>
                    <td>{$territorio.Ter_Siglas}</td>
                    <td>{$territorio.Det_Nombre}</td>
                    <td>{$territorio.Pai_Nombre}</td> 
                    <td style=" text-align: center">
                        {if $territorio.Ter_Estado==0}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                        {/if}                            
                        {if $territorio.Ter_Estado==1}
                            <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                        {/if}
                    </td>                                            
                    <td >
                        {if $_acl->permiso("editar_territorio")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/territorio/index/{$territorio.Ter_IdTerritorio}"></a>
                        {/if}
                        {if $_acl->permiso("habilitar_deshabilitar_territorio")}
                            <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-territorio" title="{$lenguaje.label_cambiar_estado}" idterritorio="{$territorio.Ter_IdTerritorio}" estado="{if $territorio.Ter_Estado==0}1{else}0{/if}"> </a>      
                        {/if}
                        {if $_acl->permiso("eliminar_territorio")}
                            <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="Confirmación de eliminación" data-id="{$territorio.Ter_IdTerritorio}" data-nombre="{$territorio.Ter_Nombre}" class="btn btn-default btn-sm glyphicon glyphicon-trash">
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