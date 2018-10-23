{if isset($data) && count($data)}
    <div class="table-responsive" >
            <table class="table" style=" text-align: center">
                <tr>
                    <th style=" text-align: center">N°</th>
                    {if  isset($fichaVariable) && count($fichaVariable)}
                        {foreach from=$fichaVariable item=fi}                                                
                            <th style=" text-align: center">{$fi.$campo_nombre}</th>
                        {/foreach}
                    {/if}   
                    <th style=" text-align: center">Estado</th>
                    <th style=" text-align: center">Opciones</th>
                </tr>
                {foreach from=$data item=us}
                    <tr>
                        <td>{$numeropaginaData++}</td>                  
                        {if  isset($fichaVariable) && count($fichaVariable)}
                            {foreach from=$fichaVariable item=fi}
                                <td>
                                    {$us.{$fi.$campo_nombre}}
                                </td>
                            {/foreach}
                        {/if}
                        <td>
                            {if {$us.$campo_estado}==0}
                                <i class="glyphicon glyphicon-remove-sign" title="deshabilitado" style="color: #DD4B39;"/>
                            {else}
                                <i class="glyphicon glyphicon-ok-sign" title="habilitado" style="color: #088A08;"/>
                            {/if}
                        </td>
                        <td>
                            {if $_acl->permiso("habilitar_deshabilitar_registros_recurso")} 
                                <a class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.tabla_opcion_editar}" href="{$_layoutParams.root}estandar/registros/editarRegistro/{$us[0]}/{$us.Rec_IdRecurso}/{$us.Idi_IdIdioma}"></a>
                            {/if}
                            {if $_acl->permiso("editar_registros_recurso")}
                                <a class="btn btn-default btn-sm glyphicon glyphicon-refresh ce_estandar" nombre_tabla="{$nombre_tabla}" estado_estandar="{if {$us.$campo_estado}==0}1{else}0{/if}" columna_estado="{$campo_estado}" title="{$lenguaje["cambiar_estado_bdrecursos"]}" valor_id="{$us[0]}"> </a>
                            {/if}
                            {if $_acl->permiso("eliminar_registros_recurso")}
                                <a data-toggle="modal" data-target="#eliminar_estandar" href="#" type="button" title="{$lenguaje["label_eliminar_bdrecursos"]}" data-idrecursoestandar="{$idEstandarRecurso}" data-valorid="{$us[0]}" class="btn btn-default btn-sm glyphicon glyphicon-trash" >
                                    </a>
                            {/if}   
                        </td>
                    </tr>
                {/foreach}
            </table>
    </div>          
    <div class="panel-footer">
        {$paginacionData|default:""}
    </div>
{else}
    {$lenguaje.no_registros}
{/if} 