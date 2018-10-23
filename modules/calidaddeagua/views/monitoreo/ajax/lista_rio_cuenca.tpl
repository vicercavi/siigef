<label for="subcuenca" class="col-md-4 control-label">Rio Cuenca (*)</label>        
          <div class="col-md-5">
            <select class="form-control" id="Suc_IdSubCuenca" name="Suc_IdSubCuenca" >
                <option value="0">Seleccione</option>
                {foreach item=datos from=$ocuenca}
                <option value="{$datos.Suc_IdSubCuenca}" >{$datos.Rio_Nombre}|{$datos.Cue_Nombre}|{$datos.Suc_Nombre}</option>
                {/foreach}              
              </select>              
          </div