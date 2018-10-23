<form action="../registrar/registrarData" method="post" autocomplete="on" data-toggle="validator" class="form-horizontal" role="form" id="lista_estandar">
<table class="table">
  <thead>
    <tr>
      <th>Campos de la tabla variable</th>
      <th style="width:1%"></th>
      <th style="width:50%">Campos Vinculados</th>        
    </tr>
  </thead>    
  <tbody>{$i=0}
    {foreach item=datos from=$fichaVariable}
      <tr>
        <input type="hidden" value="{$datos.$campo_id}" name="{$datos.$campo_id}">
        <td>{$datos.$campo_nombre}</td>
        <td>:</td>
        <td>
            <select name="{$datos.$campo_nombre}" id="{$datos.$campo_nombre}" required="required">
              <option value="">Selecionar</option>
                {foreach $encabezado as $k => $v}
                 <option value="{$k}" {if $k==$i}selected{/if}>{$v}</option>
                {/foreach}
            </select>
        </td>
      </tr> 
      {$i=$i+1}     
    {/foreach} 
  </tbody>
</table>
<center>
  <button type="submit" id="btnEnviar" name="btnEnviar" class="btn btn-success">Registrar Datos</button></center>
</form>
