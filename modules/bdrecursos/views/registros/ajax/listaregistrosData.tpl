{if isset($lista_variable2) && count($lista_variable2)}
    <div class="table-responsive">
        <table class="table" style=" text-align: center">
            <tr>
                <th style=" text-align: center">N°</th>          
                {foreach from=$lista_variable3 item=us}
                    <th style=" text-align: center">
                        {$us.$campo_etiqueta|truncate:50:"...":true}
                    </th>
                {/foreach}
                <th style=" text-align: center">Estado</th>
                <th style=" text-align: center">Opciones</th>      
            </tr>
            {foreach from=$lista_data item=ld}
                <tr>
                    <td>
                        {$numeropaginaData++}
                    </td> 
                    {foreach from=$lista_variable3 item=lv3}
                        <td>
                            {$ld[$lv3[$campo_nombre]]}
                        </td>
                    {/foreach}
                    <td style=" text-align: center">
                        {if {$ld.$campo_estado}==0}
                            <i class="glyphicon glyphicon-remove-sign" title="deshabilitado" style="color: #DD4B39;"/>
                        {else}
                            <i class="glyphicon glyphicon-ok-sign" title="habilitado" style="color: #088A08;"/>
                        {/if}
                    </td>
                    <td style=" text-align: center">
                        <a type="button" title="{$lenguaje["label_mas_detalle_bdrecursos"]}" class="btn btn-default btn-sm glyphicon glyphicon-search" href="{$_layoutParams.root}bdrecursos/registros/metadata/{$recurso.Rec_IdRecurso}/{$ld[$campo_id2]}" target="_blank"></a>
                        {if $_acl->permiso("editar_registros_recurso")} 
                            <a class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.tabla_opcion_editar}" href="{$_layoutParams.root}bdrecursos/registros/editarRegistroData/{$ld[$campo_id2]}/{$recurso.Rec_IdRecurso}/es"></a>
                        {/if}
                        {if $_acl->permiso("habilitar_deshabilitar_registros_recurso")}
                            <a class="btn btn-default btn-sm glyphicon glyphicon-refresh ce_data" nombre_tabla="{$tabla_data}" estado_estandar="{if {$ld.$campo_estado}==0}1{else}0{/if}" campo_estado="{$campo_estado}" title="{$lenguaje["cambiar_estado_bdrecursos"]}" valor_id="{$ld[0]}"> </a>
                        {/if}
                        {if $_acl->permiso("eliminar_registros_recurso")}
                            <a data-toggle="modal" data-target="#eliminar_estandar" href="#" type="button" title="{$lenguaje["label_eliminar_bdrecursos"]}"  data-nombretabla="{$tabla_data}" data-valorid="{$ld[0]}" class="btn btn-default btn-sm glyphicon glyphicon-trash" >
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