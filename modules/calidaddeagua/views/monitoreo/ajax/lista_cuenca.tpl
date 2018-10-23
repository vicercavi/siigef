<label for="cuenca" class="col-md-4 control-label">Cuenca (*)</label>
        <div class="col-md-5">          
          <select class="form-control" id="Cue_IdCuenca" name="Cue_IdCuenca" >
            <option value="0">Seleccione Cuenca</option>
            {foreach item=datos from=$riocuenca}
            <option value="{$datos.Cue_IdCuenca}">{$datos.Cue_Nombre}</option>
            {/foreach}
          </select>
            
        </div>