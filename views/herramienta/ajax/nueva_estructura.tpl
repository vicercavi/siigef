<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><strong>Agregar Estructura</strong></h3>
        </div>
        <div class="panel-body">
            <div class="form-group row col-md-10">
                <label for="tb_nombre">Nombre*</label>
                <input type="text" class="form-control" id="tb_nombre"  name="tb_nombre"
                       placeholder="Introduce nombre de la estructura">
            </div> 
            <div class="form-group  col-md-2">                         
                <label for="tb_orden">Orden*</label>
                <input type="number" class="form-control " id="tb_orden"  name="tb_orden">  


            </div> 
            <div class="form-group">
                <label for="tb_descripcion">Descripcion*</label>
                <textarea type="te" class="form-control" id="tb_descripcion"  name="tb_descripcion"
                          placeholder="Introduce descripcion de la estructura"></textarea>
            </div>    
            <div class="form-group">
                <label for="sl_recurso">Recurso</label>
                <select  class="form-control" id="sl_recurso" name="sl_recurso">
                    <option value="0">Seleccione</option>
                    {foreach from=$trecurso item=dato}
                        <optgroup label="{$dato.Tir_Nombre}">
                            {foreach from=$dato.recurso item=dato2}
                                <option value="{$dato2.Rec_IdRecurso}">{$dato2.Rec_Nombre}</option>      
                            {/foreach}
                        </optgroup>
                    {/foreach}


                </select>
            </div>    
            <button type="submit" id="bt_registrar" name="bt_registrar"  class="btn btn-default ">Registrar</button>       

        </div>
    </div>
</div>

