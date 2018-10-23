<label for="rio" class="col-md-4 control-label">Rio (*)</label>
        <div class="col-md-5">
          <select class="form-control" id="Rio_IdRio" name="Rio_IdRio" >
              <option value="0">Seleccione Rio</option>
              {foreach item=datos from=$rio}
              <option value="{$datos.Rio_IdRio}">{$datos.Rio_Nombre}</option>
              {/foreach}
            </select>          
        </div>