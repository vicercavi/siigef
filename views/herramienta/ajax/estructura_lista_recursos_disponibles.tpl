{if isset($recurso_disponible) && count($recurso_disponible)}
    <div class="table-responsive" >
        <table class="table">
            <tr>
                <th>#</th>
                <th>Nombre</th>    
                <th>Estandar</th>                                                             
                <th class="text-center">Opciones</th>
            </tr>
            {foreach from=$recurso_disponible item=dato}
                <tr>
                    <td>{$numeropagina_rd++}</td>
                    <td>{$dato.Rec_Nombre}</td>                                                            
                    <td>{$dato.Esr_Nombre}</td>                                                            
                    <td style=" text-align: center">
                        <a type="button" title="Asignar" recurso='{$dato.Rec_IdRecurso}' estructura='{$padreestructura.Esh_IdEstructuraHerramienta}' class="btn btn-default btn-sm glyphicon glyphicon-chevron-right asignar_recurso">
                        </a> 
                    </td>

                </tr>

            {/foreach}

        </table>

    </div>
    {$paginacion_rd|default:""}
{else}
    Seleccione Estandar de Recurso
{/if}
