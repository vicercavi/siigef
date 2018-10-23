{if isset($herramientas) && count($herramientas)}
    <div class="table-responsive" >
        <table class="table">
            <tr>
                <th>#</th>
                <th>Nombre</th> 
                <th>Abreviatura</th>        
                <th>Descripción</th>    
                <th>Estado</th>    
                <th class="text-center">Opciones</th>
            </tr>
            {foreach from=$herramientas item=dato}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$dato.Her_Nombre}</td>
                    <td>{$dato.Her_Abreviatura}</td>
                    <td class="text-justify" >{$dato.Her_Descripcion}</td>   
                    <td>
                        {if $dato.Her_Estado==0}
                            <i class="glyphicon glyphicon-remove-sign" title="Desabilitado" style="color: #DD4B39;"/>
                        {else}
                            <i class="glyphicon glyphicon-ok-sign" title="Habilitado" style="color: #088A08;"/>
                        {/if}
                    </td>   
                    <td style=" text-align: center">
                        <a type="button" title="Editar" class="btn btn-default btn-sm glyphicon glyphicon-pencil" href="{$_layoutParams.root}herramienta/index/{$dato.Her_IdHerramientaSii}">
                        </a>
                        <a class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-herramienta" herramienta="{$dato.Her_IdHerramientaSii}" estado="{if $dato.Her_Estado==0}1{else}0{/if}"  title="Cambiar Estado" > </a>
                        <a type="button" title="Ver Estructura" class="btn btn-default btn-sm glyphicon glyphicon-list" href="{$_layoutParams.root}herramienta/estructura/{$dato.Her_IdHerramientaSii}">
                        </a>
                        <a type="button" title="Ir a visor" class="btn btn-default btn-sm glyphicon glyphicon-eye-open" href="{$_layoutParams.root}herramienta/visor/{$dato.Her_Abreviatura}">
                        </a>

                    </td>

                </tr>

            {/foreach}

        </table>

    </div>
    {$paginacion|default:""}
{else}
    Sin Resultados...
{/if}