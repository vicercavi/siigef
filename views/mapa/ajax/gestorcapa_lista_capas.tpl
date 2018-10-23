{if isset($capas) && count($capas)}
    <div  class="table-responsive">
        <table class="table table-hover table-condensed" >
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titulo</th>                   
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Url</th>                               
                    <th style=" text-align: center">Estado</th>
                    <th>Opciones</th>

                </tr>
            </thead>                  
            <tbody>
                {foreach item=datos from=$capas}
                    <tr>                       
                        <td>{$numeropagina++}</td>
                        <td>{$datos.Cap_Titulo|truncate:30:"...":true}</td>
                        <td>{$datos.Cap_Nombre|truncate:30:"...":true}</td>
                        <td>{$datos.tic_Nombre}</td>
                        <td class="col-md-4">
                            <div style="max-width: 500px; margin: auto; 
                            word-wrap: break-word">
                                {$datos.Cap_UrlBase|truncate:50:"...":true}
                            </div> 
                        </td>                                
                        <td style=" text-align: center">
                            {if $datos.Cap_Estado==0}
                                <i class="glyphicon glyphicon-remove-sign" title="Desabilitado" style="color: #DD4B39;"/>
                            {else}
                                <i class="glyphicon glyphicon-ok-sign" title="Habilitado" style="color: #088A08;"/>
                            {/if}
                        </td>
                        <td>
                            {if $_acl->permiso("editar_capa")}
                                <a class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}mapa/gestorcapa/{$datos.tic_Nombre}/{$datos.Cap_Idcapa}"></a>                                          
                            {/if}
                            {if $_acl->permiso("habilitar_deshabilitar_capa")}
                                <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-capa" title="{$lenguaje.label_cambiar_estado}" idcapa="{$datos.Cap_Idcapa}" estado="{if $datos.Cap_Estado==0}1{else}0{/if}"> </a>      
                            {/if}
                            {if $_acl->permiso("eliminar_capa")}
                                <a data-href="{$datos.Cap_Idcapa}" data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="{$lenguaje.label_eliminar}"  data-nombre="{$datos.Cap_Titulo}" class="btn btn-default btn-sm glyphicon glyphicon-trash">
                                </a>
                            {/if}
                        </td>
                    </tr>                     
                {/foreach}
            </tbody>
        </table>
    </div>          
    {$paginacion|default}  
{else}
    Sin datos;
{/if}