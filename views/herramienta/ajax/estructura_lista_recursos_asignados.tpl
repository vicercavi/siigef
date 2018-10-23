{if isset($recurso_asignado) && count($recurso_asignado)}
    <div class="table-responsive" >
        <table class="table">
            <tr>
                <th>#</th>
                <th>Nombre</th>    
                <th>Estandar</th>                                                             
                <th class="text-center">Opciones</th>
            </tr>
            {foreach from=$recurso_asignado item=dato}
                <tr>
                    <td>{$numeropagina_ra++}</td>
                    <td>{$dato.Rec_Nombre}</td>                                                               
                    <td>{$dato.Esr_Nombre}</td>                                                            
                    <td style=" text-align: center">                                                                
                        <a type="button" title="Quitar" recurso='{$dato.Rec_IdRecurso}' estructura='{$padreestructura.Esh_IdEstructuraHerramienta}' class="btn btn-default btn-sm glyphicon glyphicon-remove quitar_recurso" >
                        </a>
                    </td>
                </tr>
            {/foreach}
        </table>
    </div>
    {$paginacion_ra|default:""}
{else}
    Sin Datos...
{/if}
