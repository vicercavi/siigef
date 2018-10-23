<div class="form-group">
    <label class="col-lg-2 control-label" for="tb_nombre_recurso">Nombre*</label>
    <div class="col-lg-10">
        <input type="text" class="form-control" id="tb_nombre_recurso"  name="tb_nombre_recurso"
               placeholder="Introduce Nombre del Recurso" value="{$recurso.Rec_Nombre|default}" required/>

    </div>

</div> 
<div class="form-group">
    <label  class="col-lg-2 control-label" for="tb_fuente_recurso">Fuente*</label>
    <div class="col-lg-10">
        <input type="text" list="dl_fuente" class="form-control" id="tb_fuente_recurso"  value="{$recurso.Rec_Fuente|default}" name="tb_fuente_recurso"
               placeholder="Introduce Fuente del Recurso"required/>
        <datalist id="dl_fuente">
            {foreach item=datos from=$fuente}
                <option value='{$datos.Rec_Fuente}'>
                {/foreach}                                                    
        </datalist>
    </div>

</div> 
<div class="form-group">
    <label  class="col-lg-2 control-label" for="tb_origen_recurso">Origen*</label>
    <div class="col-lg-10">
        <input type="text" list="dl_origen" class="form-control" id="tb_origen_recurso" value="{$recurso.Rec_Origen|default}" name="tb_origen_recurso"
               placeholder="Introduce Fuente del Recurso" required/>
        <datalist id="dl_origen">
            {foreach item=datos from=$origenrecurso}
                <option value='{$datos.Rec_Origen}'> {$datos.Rec_Origen}</option>
            {/foreach}
        </datalist>
    </div>

</div>