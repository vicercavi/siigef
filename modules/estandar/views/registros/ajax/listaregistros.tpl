{if isset($datos) && count($datos)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">N°</th>
                {if  isset($ficha) && count($ficha)}
                    {foreach from=$ficha item=fi}                                                
                        <th style=" text-align: center">{$fi.Fie_CampoFicha}</th>                                                
                    {/foreach}
                {/if}                                        
                <th style=" text-align: center">Opciones</th>
            </tr>
            {foreach from=$datos item=us}
                <tr>
                    <td>{$numeropagina++}</td>                                            
                    {if  isset($ficha) && count($ficha)}
                        {foreach from=$ficha item=fi}
                            <td>
                                {$us.{$fi.Fie_ColumnaTabla}}
                            </td>
                        {/foreach}
                    {/if}
                    <td >
                        <a class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.tabla_opcion_editar}" href="{$_layoutParams.root}estandar/registros/editarRegistro/{$us[0]}/{$us.Rec_IdRecurso}/{$us.Idi_IdIdioma}"></a>                                                
                        <a class="btn btn-default btn-sm glyphicon glyphicon-tasks" title="{$lenguaje.tabla_opcion_editar_cont}"  href="{$_layoutParams.root}estandar/index/permisos/{$us.Usu_IdUsuario}"></a>
                        <a class="btn btn-default btn-sm glyphicon glyphicon-refresh" title="{$lenguaje.tabla_opcion_cambiar_est}" href="{$_layoutParams.root}estandar/index/_cambiarEstado/{$us.Usu_IdUsuario}/{$us.Usu_Estado}"> </a>      
                        <a class="btn btn-default btn-sm glyphicon glyphicon-trash" title="{$lenguaje.tabla_opcion_cambiar_est}" href="{$_layoutParams.root}estandar/index/_eliminarUsuario/{$us.Usu_IdUsuario}"> </a>
                    </td>
                </tr>
            {/foreach}
        </table>
    </div>                            
{/if}  
<div class="panel-footer">
    {$paginacion|default:""}
</div>