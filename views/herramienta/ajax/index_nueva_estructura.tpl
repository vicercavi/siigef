<div class="form-group ">
    <label class="col-lg-3 control-label"  for="tb_nombre_edit">Nombre*</label>
    <div class="col-lg-9">

        <input type="text" class="form-control" id="tb_nombre_edit"  name="tb_nombre_edit" value="{$padreestructura.Esh_Nombre}"
               placeholder="Introduce nombre de la estructura">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label"  for="tb_titulo_edit">Cabecera</label>
    <div class="col-lg-9">
        <input type="text" class="form-control " id="tb_titulo_edit"  name="tb_titulo_edit" value="{$padreestructura.Esh_Titulo}">  
    </div>
</div> 
<div class="form-group">
    <label class="col-lg-3 control-label"  for="tb_orden_edit">Orden*</label>
    <div class="col-lg-9">
        <input type="number" class="form-control " id="tb_orden_edit"  name="tb_orden_edit" value="{$padreestructura.Esh_Orden}" {if $padreestructura.Idi_IdIdioma!=$idIdiomaO}disabled{/if}> 
        {if $padreestructura.Idi_IdIdioma!=$idIdiomaO} <input type="hidden" id="tb_orden_edit"  name="tb_orden_edit" value="{$padreestructura.Esh_Orden}" > {/if}

    </div>

</div> 
<div class="form-group">
    <label class="col-lg-3 control-label"  for="tb_descripcion_edit">Criterio Consulta*</label>
    <div class="col-lg-9">
        <input type="text" class="form-control" id="tb_descripcion_edit"  name="tb_descripcion_edit"
               placeholder="Introduce descripcion de la estructura" value="{$padreestructura.Esh_Descripcion}" {if $padreestructura.Idi_IdIdioma!=$idIdiomaO}disabled{/if}>
        <input type="hidden" id="tb_descripcion_edit"  name="tb_descripcion_edit" value="{$padreestructura.Esh_Descripcion}" > 
    </div>
</div>   
<div class="form-group">
    <label class="col-lg-3 control-label"  for="tb_columna_edit">Columna de Consulta</label>
    <div class="col-lg-9">
        <input type="text" class="form-control" id="tb_columna_edit"  name="tb_columna_edit"
               placeholder="Introduce columna a consultar" value="{$padreestructura.Esh_ColumnaConsulta}" {if $padreestructura.Idi_IdIdioma!=$idIdiomaO}disabled{/if}>
    </div>
</div>   
<div class="form-group">
    <label class="col-lg-3 control-label"  for="cb_he_predeterminado"></label>
    <div class="col-lg-9">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="cb_he_predeterminado" id="cb_he_predeterminado"  
                       {if !empty($padreestructura.Esh_Predeterminado)} 
                           checked="checked"  
                       {/if} 
                       {if $padreestructura.Idi_IdIdioma!=$idIdiomaO}disabled{/if}>
                
                Mostrar al Cargar Herramienta
            </label>
        </div>

    </div>
</div> 