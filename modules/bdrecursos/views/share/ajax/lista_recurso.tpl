<div class="form-group col-md-5 col-md-offset-3" id="listaRecurso"> 
    <label class="col-md-2 control-label" for="sl_recurso">Recurso*</label>    
    <div class="col-md-12">
        <select name="sl_recurso"  class="form-control" id="sl_recurso"  name="sl_recurso" required="">
            <option value="">Seleccione</option>
            {foreach item=datos from=$recursos}
                <option value="{$datos.Rec_IdRecurso}"> {$datos.Rec_Nombre}</option>
            {/foreach}
        </select>
    </div>
</div>