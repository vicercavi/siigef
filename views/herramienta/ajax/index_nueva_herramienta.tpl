<div class="form-group">
    <label class="col-lg-3 control-label"  for="tb_nombre">Nombre*</label>
    <div class="col-lg-9">
        <input type="text" class="form-control" id="tb_nombre"  name="tb_nombre" value="{$herramienta.Her_Nombre|default}"
               placeholder="Introduce nombre de la herramienta">
    </div>
</div> 
<div class="form-group">
    <label class="col-lg-3 control-label"  for="tb_abreviatura">Abreviatura*</label>
    <div class="col-lg-9">
        <input type="text" class="form-control"  id="tb_abreviatura"  name="tb_abreviatura"
               placeholder="Introduce un identificar sin espacios, ejemplo atlasvh" value="{$herramienta.Her_Abreviatura|default}" {if $herramienta.Idi_IdIdioma!=$idIdiomaO}disabled{/if}>
        {if $herramienta.Idi_IdIdioma!=$idIdiomaO}<input type="hidden"id="tb_abreviatura"  name="tb_abreviatura" value="{$herramienta.Her_Abreviatura|default}">{/if}
        
    </div>
</div>    
<div class="form-group">
    <label class="col-lg-3 control-label"  for="tb_descripcion">Descripcion*</label>
    <div class="col-lg-9">
        <textarea type="te" class="form-control" id="tb_descripcion"  name="tb_descripcion"
                  placeholder="Introduce descripcion de la herramienta">{$herramienta.Her_Descripcion|default}</textarea>
    </div>
</div>    