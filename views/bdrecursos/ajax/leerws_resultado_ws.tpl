<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <strong>Asignacion de Columnas</strong> 
        </h4>
    </div>               
    <div class="panel-body">       

            {if isset($fichaestandar)}  
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Columna Estandar</th>
                            <th>Columna WS</th>
                        </tr>
                    </thead>
                    {foreach item=datos from=$fichaestandar key=key}
                        <tr>
                            <td>                                   
                                {$datos.Fie_CampoFicha}
                                <input type="hidden" id="hd_cf_{$key}" name="hd_cf_{$key}" value="{$datos.Fie_ColumnaTabla}">
                            </td>
                            <td>
                                <select id="{$datos.Fie_ColumnaTabla}"  name="{$datos.Fie_ColumnaTabla}">
                                    <option value="" selected="selected">Selecione</option>
                                    {foreach from=$columnas key=key item=item} 
                                        <option value="{$item}">{$item}</option>
                                    {/foreach}
                                </select>
                            </td>
                        </tr>
                    {/foreach}
                </table>
                 <input type="submit" class="bt_importar_ws btn btn-default pull-right" id="bt_importar_ws" name="bt_importar_ws" value="Importar">
                {else}
                    No se cargaron los datos
            {/if}
           
    </div>
</div> 
