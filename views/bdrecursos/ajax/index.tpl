<div class="btn-group" role="group" >
    <span class="btn btn-success" metodo="agregarRecurso" ajax="#nuevo_recurso">Agregar Recurso</span>
</div>
<!-- fin opcion agregar recurso -->     

<!-- listado de recursos -->
{if $numeropagina!=0}                       
    {$numeropagina=$numeropagina*10-9}                       
{else}
    {$numeropagina=1} 
{/if}
<table class="table table-bordered table-condensed table-striped" >
    <tr>
        <th>N°</th>
        <th>Nombre</th>
        <th>Fuente</th>
        <th>Tipo</th>
        <th>Estándar</th>
        <th>N° Registros</th>                    
        <th>Origen</th>
        <th>Utilizado</th>
        <th>Fecha de Registro</th>
        <th>Última Modificación</th>


    </tr>
    {$item=1}
    {foreach item=datos from=$registros}

        <tr>                       
            <td>{$numeropagina++}</td>
            <td>{$datos.Rec_Nombre}</td>
            <td><h5><a href="{$datos.Est_Descripcion}/index/{$datos.Rec_IdRecurso}/{$datos.Rec_Nombre}/{$datos.Rec_CantidadRegistros}" target="_blank">{$datos.Rec_Fuente}</a></h5></td>
            <td>{$datos.Tir_Nombre}</td>
            <td>{$datos.Esr_Nombre}</td>
            <td>{$datos.Rec_CantidadRegistros}</td>                        
            <td>{$datos.Rec_Origen}</td>
            <td>
                {if isset($datos.herramientas)}
                    {foreach item=herramienta from=$datos.herramientas}
                        <label>{$herramienta.Her_Nombre}</label><br>
                    {/foreach}
                {/if}
            </td>
            <td>{$datos.Rec_FechaRegistro}</td>
            <td>{$datos.Rec_UltimaModificacion}</td>

        </tr>                     
    {/foreach}
</table>
{$paginacion|default:""}    
<!-- fin listado de recursos -->

<!-- nuevo recurso -->
<div id="nuevo_recurso">

</div>
<!-- nuevo recurso -->

