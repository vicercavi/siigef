<form id="form1" method="post"  enctype="multipart/form-data">
    {$error}<br/>
<div style="display: inline-block;vertical-align: top;min-width:450px;margin: 10px;">
        
  
<div style="min-width:400px">
        <label>Ingrese KML</label>
        <br>
         <input type="hidden" name="guardar" value="1" />
   
    <input type="file" name="kml" /><input id="bt_cargar" name="bt_cargar_kml" type="submit" class="button" value="Cargar" />
    
  
    
</div>
            <br/>
{if isset($kml)}
<div  style="width:400px">
    <label id="lb_nombrekml">{$kml.nombre}</label>
    <p><input id="bt_vistapreviakml" name="bt_vistapreviakml" type="button" onclick="pruebakml('{$kml.nombre}')" class="button" value="Vista Previa" /><input id="bt_guardar" name="bt_guardar"  type="submit" class="button" value="Guardar" /></p>
</div>
{/if}
</div>


<div style="display: inline-block;vertical-align: top;min-width:700px;margin: 10px;">
    <div id="panel">   
      <input onclick="removeOverlay();" type=button value="Quitar WMS">
      <input onclick="addOverlay();" type=button value="Add WMS">
    </div>
    <div id='map' class="map"></div>
</div>
</form>