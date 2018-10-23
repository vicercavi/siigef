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
                            <input type="hidden" value="0" name="s_tabla">
                        </td>
                    </tr>
                {/foreach}
            </table>
            <center>
                <input type="submit" class="bt_importar_ws btn btn-success pull-center" id="bt_importar_ws" name="bt_importar_ws" value="Importar">
            </center>
        {elseif isset($fichaVariable)}
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Columna Estandar</th>
                        <th>Columna WS</th>
                    </tr>
                </thead>
                {foreach item=datos from=$fichaVariable key=key}
                    <tr>
                        <td>                                   
                            {$datos.$campo_nombre}
                            <input type="hidden" id="hd_cf_{$key}" name="hd_cf_{$key}" value="{$datos.$campo_id}">
                        </td>
                        <td>
                            <select id="{$datos.$campo_nombre}"  name="{$datos.$campo_nombre}">
                                <option value="" selected="selected">Selecione</option>
                                {foreach from=$columnas key=key item=item} 
                                    <option value="{$item}">{$item}</option>
                                {/foreach}
                            </select>
                            <input type="hidden" value="1" name="s_tabla">
                        </td>
                    </tr>
                {/foreach}
            </table>
            <center>
                <input type="submit" class="bt_importar_ws btn btn-success pull-center" id="bt_importar_ws" name="bt_importar_ws" value="Importar">
            </center>
        {else}
            No se cargaron los datos
        {/if}           
    </div>
</div> 
