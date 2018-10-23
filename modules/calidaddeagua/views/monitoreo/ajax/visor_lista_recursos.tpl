<!-- listado de recursos -->
{if $numeropagina!=0}                       
    {$numeropagina=$numeropagina*20-19}                       
{else}
    {$numeropagina=1} 
{/if}

{if isset($recursos)}
    <table class="table table-hover table-condensed" >
        <tr>
            <th>#</th>
            <th>Nombre</th>                   
            <th>Tipo</th>
            <th>Estándar</th>
            <th>Fuente</th>
            <th>Origen</th>                              

        </tr>
        {$item=1}
        {foreach item=datos from=$recursos}

            <tr>                       
                <td>{$numeropagina++}</td>
                <td>{$datos.Rec_Nombre}</td>
                <td>{$datos.Tir_Nombre}</td>
                <td>{$datos.Esr_Nombre}</td>
                <td>{$datos.Rec_Fuente}</td>
                <td>{$datos.Rec_Origen}</td>    
            </tr>                     
        {/foreach}
    </table>
    {$paginacion|default:""}                           
{/if}