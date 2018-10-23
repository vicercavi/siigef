<div style="position:fixed; width:75%; margin: 0px auto; z-index:150 ">
    {if isset($_error)}
        <div id="_errl" class="alert alert-error " >
            <a class="close " data-dismiss="alert">X</a>
            {$_error}
        </div>
    {/if}
    {if isset($_mensaje)}
        <div id="_msgl" class="alert alert-success" >
            <a class="close" data-dismiss="alert">X</a>
            {$_mensaje}
        </div>
    {/if}             
</div> 
{if isset($datos) && count($datos)}
    <div class="table-responsive" >
        <table class="table" style=" text-align: center">
            <tr >
                <th style=" text-align: center">{$lenguaje.label_n}</th>
                <th style=" text-align: center">Nombre Campo</th>
                <th style=" text-align: center">Nombre de Tabla</th>                                        
                <th style=" text-align: center">Nombre Columna</th>
                <th style=" text-align: center">Tipo Campo</th>
                <th style=" text-align: center">Tamaño</th>
                {if isset($tablaGenerada) && $tablaGenerada == 1}
                    <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                {/if}
            </tr>
            {foreach from=$datos item=us}
                <tr>
                    <td>{$numeropagina++}</td>
                    <td>{$us.Fie_CampoFicha}</td>
                    <td>{$us.Fie_NombreTabla}</td>                                            
                    <td>{$us.Fie_ColumnaTabla}</td>
                    <td>{$us.Fie_TipoDatoCampo}</td>
                    <td>{$us.Fie_TamanoColumna}</td>
                    {if isset($tablaGenerada) && $tablaGenerada == 1}
                    <td >
                        <a class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.tabla_opcion_editar}" href="{$_layoutParams.root}estandar/index/editarFicha/{$us.Esr_IdEstandarRecurso}/{$us.Fie_IdFichaEstandar}"></a>
                        <a class="btn btn-default btn-sm glyphicon glyphicon-trash estado-ficha" ficha="{$us.Fie_IdFichaEstandar}" title="{$lenguaje.tabla_opcion_cambiar_est}" > </a>
                    </td>
                    {/if}
                </tr>
            {/foreach}
        </table>
    </div>          
    <div class="panel-footer">
        {$paginacion|default:""}
    </div>
{else}
    No se encontraron datos...!!
{/if}  