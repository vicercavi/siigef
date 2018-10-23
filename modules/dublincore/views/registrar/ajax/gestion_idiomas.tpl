<form data-toggle="validator" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" id="registrardublin">    
  <div class="form-group" align="center">
    		{foreach item=datos from=$idiomas}
          <label class="radio-inline"><input type="radio" name="Idi_IdIdioma" id="Idi_IdIdioma" value="{$datos.Idi_IdIdioma}" {if $idioma == $datos.Idi_IdIdioma } checked="checked" {/if}>{$datos.Idi_Idioma}</label>
        {/foreach}
  </div>    
    <div class="form-group">
      <label for="titulo" class="col-md-4 control-label">{$ficha[0]['Fie_CampoFicha']} (*)</label>
      <div class="col-md-6">
        <input type="text" class="form-control" id="Dub_Titulo" name="Dub_Titulo" 
               placeholder="{$ficha[0]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <label for="descripcion" class="col-md-4 control-label">{$ficha[1]['Fie_CampoFicha']} (*)</label>
      <div class="col-md-6">          
        <textarea class="form-control" rows="3" id="Dub_Descripcion" name="Dub_Descripcion" placeholder="{$ficha[1]['Fie_CampoFicha']}"></textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="autor" class="col-md-4 control-label">{$ficha[15]['Fie_CampoFicha']} (*)</label>
      <div class="col-md-6">
      	<input type="text" list="autores" class="form-control" id="Aut_IdAutor" name="Aut_IdAutor" placeholder="{$ficha[15]['Fie_CampoFicha']}"/>
            <datalist id="autores">
              {foreach item=datos from=$autores}
               	<option value="{$datos.Aut_Nombre}">
              {/foreach}    
            </datalist>
      </div>
    </div>
    <div class="form-group">
      <label for="editor" class="col-md-4 control-label">{$ficha[2]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" class="form-control" id="Dub_Editor" name="Dub_Editor" 
               placeholder="{$ficha[2]['Fie_CampoFicha']}" >
      </div>
    </div>
    <div class="form-group">
      <label for="colaborador" class="col-md-4 control-label">{$ficha[3]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" class="form-control" id="Dub_Colabrorador" name="Dub_Colabrorador" 
               placeholder="{$ficha[3]['Fie_CampoFicha']}" >
      </div>
    </div>            
    <div class="form-group">
      <label for="fecha_documento" class="col-md-4 control-label">{$ficha[4]['Fie_CampoFicha']}</label>
      <div class="col-md-3">
        <input type="date" class="form-control" id="Dub_FechaDocumento" name="Dub_FechaDocumento"
               placeholder="dd/mm/yyyy" >
      </div>
    </div>
    <div class="form-group">
      <label for="formato" class="col-md-4 control-label">{$ficha[5]['Fie_CampoFicha']}</label>
      <div class="col-md-3">        
        
        <input type="text" list="formatos" class="form-control" id="Dub_Formato" name="Dub_Formato" placeholder="{$ficha[5]['Fie_CampoFicha']}"/>
            <datalist id="formatos">
              {foreach item=datos from=$formatos_archivos}
               	<option value="{$datos.Taf_Descripcion}">
              {/foreach}    
            </datalist>
            
      </div>
    </div>
    <div class="form-group">
      <label for="identificador" class="col-md-4 control-label">{$ficha[6]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" class="form-control" id="Dub_Identificador" name="Dub_Identificador"
               placeholder="{$ficha[6]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <label for="fuente" class="col-md-4 control-label">{$ficha[7]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" class="form-control" id="Dub_Fuente" name="Dub_Fuente"
               placeholder="{$ficha[7]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <label for="dublin_idioma" class="col-md-4 control-label">{$ficha[8]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" class="form-control" id="Dub_Idioma" name="Dub_Idioma" 
               placeholder="{$ficha[8]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <label for="relación_dublin" class="col-md-4 control-label">{$ficha[9]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" class="form-control" id="Dub_Relacion" name="Dub_Relacion" 
               placeholder="{$ficha[9]['Fie_CampoFicha']}">          
      </div>
    </div>
    <div class="form-group">
      <label for="cobertura_dublin" class="col-md-4 control-label">{$ficha[10]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" class="form-control" id="Dub_Cobertura" name="Dub_Cobertura" 
               placeholder="{$ficha[10]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <label for="derechos_dublin" class="col-md-4 control-label">{$ficha[11]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" class="form-control" id="Dub_Derechos" name="Dub_Derechos"
               placeholder="{$ficha[11]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <label for="palabras_claves" class="col-md-4 control-label">{$ficha[12]['Fie_CampoFicha']} (*)</label>
      <div class="col-md-6">        
        
        <input type="text" list="palabraclaves" class="form-control" id="Dub_PalabraClave" name="Dub_PalabraClave" placeholder="{$ficha[12]['Fie_CampoFicha']}"/>
            <datalist id="palabraclaves">
              {foreach item=datos from=$palabraclave}
               	<option value="{$datos.Dub_PalabraClave}">
              {/foreach}    
            </datalist>
            
      </div>
    </div>
    <div class="form-group">
      <label for="tipo_dublin" class="col-md-4 control-label">{$ficha[14]['Fie_CampoFicha']} (*)</label>
      <div class="col-md-6">
        <input type="text" list="tiposdublin" class="form-control" id="Tid_IdTipoDublin" name="Tid_IdTipoDublin" placeholder="{$ficha[14]['Fie_CampoFicha']}"/>
            <datalist id="tiposdublin">
              {foreach item=datos from=$tipodublin}
               	<option value="{$datos.Tid_Descripcion}">
              {/foreach}    
            </datalist>                    
      </div>
    </div>  
    <div class="form-group">
      <label for="tema_dublin" class="col-md-4 control-label">{$ficha[19]['Fie_CampoFicha']} (*)</label>
      <div class="col-md-6">
        
         <input type="text" list="temasdublin" class="form-control" id="Ted_IdTemaDublin" name="Ted_IdTemaDublin" placeholder="{$ficha[19]['Fie_CampoFicha']}"/>
            <datalist id="temasdublin">
              {foreach item=datos from=$temadublin}
               	<option value="{$datos.Ted_Descripcion}">
              {/foreach}    
            </datalist>         
      </div>
    </div>
    <div class="form-group">
      <label for="exampleInputFile" class="col-md-4 control-label">{$ficha[18]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="file" id="Arf_IdArchivoFisico" name="Arf_IdArchivoFisico">
      </div>
    </div>      
    <div class="form-group">
      <label for="url" class="col-md-4 control-label">{$ficha[20]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text"  class="form-control" id="Arf_URL" name="Arf_URL"
               placeholder="{$ficha[20]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <label for="pais" class="col-md-4 control-label">{$ficha[13]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text"  class="form-control" id="Pai_IdPais" name="Pai_IdPais"
               placeholder="{$ficha[13]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-offset-4 col-md-6">
        <button type="submit" class="btn btn-success">Registrar</button>
      <input type="hidden" value="1" name="registrar" />
      </div>
    </div>
</form>