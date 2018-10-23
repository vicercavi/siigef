<form action="../registrar/registrar" method="post" autocomplete="on" data-toggle="validator" class="form-horizontal" role="form" id="lista_estandar">
<table class="table">
  <thead>
    <tr>
      <th>Campos del Estandar</th>
      <th style="width:1%"></th>
      <th style="width:50%">Campos Vinculados</th>        
    </tr>
  </thead>    
  <tbody>
    {foreach item=datos from=$FichaEstandar}
      <tr>
        <td >{$datos.Fie_CampoFicha}</td>
        <td >:</td>
        <td>
          <select name="{$datos.Fie_ColumnaTabla}" id="{$datos.Fie_ColumnaTabla}"  required="required" >
            <option value="" selected="selected">Selecionar</option>
            {foreach $encabezado as $k => $v}
  	         <option value="{$k}">{$v}</option>
            {/foreach}
          </select>
        </td>
      </tr>      
     {/foreach} 
  </tbody>
</table>
<center>
  <button type="submit" id="btnEnviar" name="btnEnviar" class="btn btn-success">Registrar Datos</button></center>
</form>
