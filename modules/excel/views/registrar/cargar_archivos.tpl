{$carpetaDestino="imagenes/"} 

{if $_FILES["archivo"]["name"][0]} 
    
    {foreach item=datos from=$_FILES["archivo"]["name"])}            

        {$origen = $_FILES["archivo"]["tmp_name"]}
        {$destino=$carpetaDestino.$_FILES["archivo"]["name"]}
        {@move_uploaded_file($origen, $destino)}                    
                
    {/foreach}
  
{/if}       
 
<form action="<?php echo $_SERVER["../legal/PHP_SELF"]?>" method="post" enctype="multipart/form-data" name="inscripcion">
    <input type="file" name="archivo[]" multiple="multiple">
    <input type="submit" value="Enviar" class="trig btn btn-success">
</form>