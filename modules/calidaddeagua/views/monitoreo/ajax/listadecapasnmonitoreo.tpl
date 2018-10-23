{if isset($capasn) && count($capasn)}
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Nombre</th>  
                <th>Fuente</th>   
                <th>Pais</th>   
                <th ></th>

            </tr>
        </thead>
        {foreach item=datos from=$capasn}
            <tr>
                <td>{$datos.tic_Nombre}</td>
                <td>{$datos.Cap_Titulo}</td>
                <td>{$datos.Cap_Fuente}</td>
                <td>
                    <select id="cmb_pais" style="width: 110px"> 
                        <option value="0">Seleccione..</option>
                        {if isset($pais)}
                            {foreach from=$pais key=key item=item} 
                                <option value="{$item.Pai_IdPais}">{$item.Pai_Nombre} </option>
                            {/foreach}                                                             
                        {/if}

                    </select></td>
                <td><span capa="{$datos.Cap_Idcapa}" class="sp_asignar_capa_vm btn-link">Asignar</span></td>

            </tr>

        {/foreach}
    </table>                                       
    {$paginacioncapasn|default}

{else}

    <p><strong>No hay registros!</strong></p>

{/if}