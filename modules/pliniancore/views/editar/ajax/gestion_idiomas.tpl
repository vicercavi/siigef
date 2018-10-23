<input type="hidden" id="idiomaSelect" name="idiomaSelect" value="{$datos.Idi_IdIdioma}" />
{if  isset($idiomas) && count($idiomas)}
    <ul class="nav nav-tabs ">
    {foreach from=$idiomas item=idi}
        <li role="presentation" class="{if $datos.Idi_IdIdioma == $idi.Idi_IdIdioma} active {/if}">
            <a class="idioma_s" id="idioma_{$idi.Idi_IdIdioma}" href="#">{$idi.Idi_Idioma}</a>
            <input type="hidden" id="hd_idioma_{$idi.Idi_IdIdioma}" value="{$idi.Idi_IdIdioma}" />
        </li>    
    {/foreach}
    </ul>
{/if}
<div class="panel panel-primary" style="margin: 0 0 10px">
  <div class="panel-heading" style="margin: 0 0 10px">Editor de Documentos</div>
  <div class="panel-body">
    <div class="form-group">
      <label for="titulo" class="col-md-4 control-label">{$ficha[0]['Fie_CampoFicha']} (*)</label>
      <div class="col-md-6">
        <input type="text" value="{$datos.Dub_Titulo|default:''}" class="form-control" id="Dub_Titulo" name="Dub_Titulo" placeholder="{$ficha[0]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <label for="descripcion" class="col-md-4 control-label">{$ficha[1]['Fie_CampoFicha']} (*)</label>
      <div class="col-md-6">          
        <textarea class="form-control" rows="3" id="Dub_Descripcion" name="Dub_Descripcion" placeholder="{$ficha[1]['Fie_CampoFicha']}">{$datos.Dub_Descripcion|default:''}</textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="autor" class="col-md-4 control-label">{$ficha[15]['Fie_CampoFicha']} (*)</label>
      <div class="col-md-6">
        <input type="text" value="{$datos.Aut_Nombre|default:''}" list="autores" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} class="form-control" id="Aut_IdAutor" name="Aut_IdAutor" placeholder="{$ficha[15]['Fie_CampoFicha']}">
            <datalist id="autores">
              {foreach item=aut from=$autores}
                <option value="{$aut.Aut_Nombre}"></option>
              {/foreach}    
            </datalist>
      </div>
    </div>
    <div class="form-group">
      <label for="editor" class="col-md-4 control-label">{$ficha[2]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" value="{$datos.Dub_Editor|default:''}" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} class="form-control" id="Dub_Editor" name="Dub_Editor" 
               placeholder="{$ficha[2]['Fie_CampoFicha']}" >
      </div>
    </div>
    <div class="form-group">
      <label for="colaborador" class="col-md-4 control-label">{$ficha[3]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text"   value="{$datos.Dub_Colabrorador|default:''}" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} class="form-control" id="Dub_Colabrorador" name="Dub_Colabrorador" 
               placeholder="{$ficha[3]['Fie_CampoFicha']}" >
      </div>
    </div>            
    <div class="form-group">
      <label for="fecha_documento" class="col-md-4 control-label">{$ficha[4]['Fie_CampoFicha']}</label>
      <div class="col-md-3">
        <input type="Date" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} class="form-control" id="Dub_FechaDocumento" name="Dub_FechaDocumento"
               placeholder="dd/mm/yyhyy" >
      </div>
    </div>
    <div class="form-group">
      <label for="formato" class="col-md-4 control-label">{$ficha[5]['Fie_CampoFicha']}</label>
      <div class="col-md-3">
        <select class="form-control" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} id="Dub_Formato" name="Dub_Formato">
              {foreach from=$formatos_archivos item=ps}
              <option value="{$ps.Taf_IdTipoArchivoFisico}" 
                      {if $datos.Taf_IdTipoArchivoFisico==$ps.Taf_IdTipoArchivoFisico} selected="selected" {/if}>
                  {$ps.Taf_Descripcion}</option>
              {/foreach}
          </select>
      </div>
    </div> 
    <div class="form-group">
      <label for="identificador" class="col-md-4 control-label">{$ficha[6]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" value="{$datos.Dub_Identificador|default:''}" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} class="form-control" id="Dub_Identificador" name="Dub_Identificador"
               placeholder="{$ficha[6]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <label for="fuente" class="col-md-4 control-label">{$ficha[7]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" value="{$datos.Dub_Fuente|default:''}" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} class="form-control" id="Dub_Fuente" name="Dub_Fuente"
               placeholder="{$ficha[7]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <label for="dublin_idioma" class="col-md-4 control-label">{$ficha[8]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" value="{$datos.Dub_Idioma|default:''}" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} class="form-control" id="Dub_Idioma" name="Dub_Idioma" 
               placeholder="{$ficha[8]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <label for="relación_dublin" class="col-md-4 control-label">{$ficha[9]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" value="{$datos.Dub_Relacion|default:''}" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} class="form-control" id="Dub_Relacion" name="Dub_Relacion" 
               placeholder="{$ficha[9]['Fie_CampoFicha']}">          
      </div>
    </div>
    <div class="form-group">
      <label for="cobertura_dublin" class="col-md-4 control-label">{$ficha[10]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" value="{$datos.Dub_Cobertura|default:''}" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} class="form-control" id="Dub_Cobertura" name="Dub_Cobertura" 
               placeholder="{$ficha[10]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <label for="derechos_dublin" class="col-md-4 control-label">{$ficha[11]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" value="{$datos.Dub_Derechos|default:''}" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} class="form-control" id="Dub_Derechos" name="Dub_Derechos"
               placeholder="{$ficha[11]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <label for="palabras_claves" class="col-md-4 control-label">{$ficha[12]['Fie_CampoFicha']} (*)</label>
      <div class="col-md-6">        
        <input type="text" list="palabraclaves" value="{$datos.Dub_PalabraClave|default:''}" class="form-control" id="Dub_PalabraClave" name="Dub_PalabraClave" placeholder="{$ficha[12]['Fie_CampoFicha']}"/>
        <datalist id="palabraclaves">
          {foreach item=pac from=$palabraclave}
            <option value="{$pac.Dub_PalabraClave}">
          {/foreach}    
        </datalist>
      </div>
    </div>
    <div class="form-group">
      <label for="tipo_dublin" class="col-md-4 control-label">{$ficha[14]['Fie_CampoFicha']} (*)</label>
      <div class="col-md-6">
        <input type="text" list="tiposdublin" value="{$datos.Tid_Descripcion|default:''}" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} class="form-control" id="Tid_IdTipoDublin" name="Tid_IdTipoDublin" placeholder="{$ficha[14]['Fie_CampoFicha']}"/>
          <datalist id="tiposdublin">
          {foreach item=tid from=$tipodublin}
            <option value="{$tid.Tid_Descripcion}">
          {/foreach}    
        </datalist>
      </div>
    </div>  
    <div class="form-group">
      <label for="tema_dublin" class="col-md-4 control-label">{$ficha[19]['Fie_CampoFicha']} (*)</label>
      <div class="col-md-6">
        <input type="text" list="temasdublin" value="{$datos.Ted_Descripcion|default:''}" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} class="form-control" id="Ted_IdTemaDublin" name="Ted_IdTemaDublin" placeholder="{$ficha[19]['Fie_CampoFicha']}"/>
          <datalist id="temasdublin">
            {foreach item=ted from=$temadublin}
              <option value="{$ted.Ted_Descripcion}">
            {/foreach}    
          </datalist>         
      </div>
    </div>
    <div class="form-group">
      <label for="pais" class="col-md-4 control-label">{$ficha[13]['Fie_CampoFicha']}</label>
      <div class="col-md-6">
        <input type="text" value="{$paises|default:''}" {if $IdiomaOriginal != $datos.Idi_IdIdioma} disabled {/if} class="form-control" id="Pai_IdPais" name="Pai_IdPais"
               placeholder="{$ficha[13]['Fie_CampoFicha']}">
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-offset-4 col-md-6">
        <button type="submit" id="editarDublin" name="editarDublin" class="btn btn-primary">Registrar</button>
      </div>
    </div>    
  </div> 
</div>