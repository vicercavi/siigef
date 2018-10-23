 <label for="subcuenca" class="col-md-4 control-label">SubCuenca (*)</label>        
        <div class="col-md-5">
          <select class="form-control" id="Suc_IdSubCuenca" name="Suc_IdSubCuenca" >
              <option value="0">Seleccione SubCuenca</option>
              {foreach item=datos from=$subcuenca}
              <option value="{$datos.Suc_IdSubCuenca}" >{$datos.Suc_Nombre}</option>
              {/foreach}              
            </select>
        </div>
        <!--
{if $datos.Suc_Nombre == $datos.Suc_Nombre} selected="selected"{/if}-->