
{if isset($estructura) && count($estructura)}
    <div class="table-responsive" >
        <table class="table">
            <tr>
                <th>#</th>
                <th>Nombre</th>    
                <th>Titulo</th>  
                <th>Descripción</th>     
                <th>Orden</th>  
                <th>Estado</th> 
                <th class="text-center">Opciones</th>
            </tr>
            {foreach from=$estructura item=dato}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$dato.Esh_Nombre}</td>
                    <td>{$dato.Esh_Titulo}</td>
                    <td>{$dato.Esh_Descripcion}</td>  
                    <td>{$dato.Esh_Orden}</td>  
                    <td>
                        {if $dato.Esh_Estado==0}
                            <i class="glyphicon glyphicon-remove-sign" title="Desabilitado" style="color: #DD4B39;"/>
                        {else}
                            <i class="glyphicon glyphicon-ok-sign" title="Habilitado" style="color: #088A08;"/>
                        {/if}
                    </td>  
                    <td style=" text-align: center">
                        <a type="button" title="Editar" class="btn btn-default btn-sm glyphicon glyphicon-pencil" href="{$_layoutParams.root}herramienta/estructura/{$herramienta.Her_IdHerramientaSii}/{$dato.Esh_IdEstructuraHerramienta}">
                        </a>
                        <a class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-estructura" estructura="{$dato.Esh_IdEstructuraHerramienta}" estado="{if $dato.Esh_Estado==0}1{else}0{/if}"  title="Cambiar Estado" ></a>
                        <a type="button" title="Eliminar" her='{$herramienta.Her_IdHerramientaSii}' pad='{$dato.Esh_IdPadre|default}' est='{$dato.Esh_IdEstructuraHerramienta}' class="btn btn-default btn-sm glyphicon glyphicon-remove deletee" >
                        </a>
                    </td>

                </tr>

            {/foreach}

        </table>

    </div>
    {$paginacion|default:""}
{else}
    Sin registros.
{/if}