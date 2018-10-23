<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><strong>Nuevo Recurso</strong></h3>       
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tabular" data-toggle="tab">Tabular</a></li>
            <li><a href="{$_layoutParams.root}mapa/gestorcapa" >Mapa</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane active in" id="tabular">
                <form  method="post">
                    <div class="container col-md-5">
                        <div class="form-group">
                            <label for="tb_nombre_recurso">Nombre*</label>
                            <input type="text" class="form-control" id="tb_nombre_recurso"  name="tb_nombre_recurso"
                                   placeholder="Introduce Nombre del Recurso">
                        </div> 
                        <div class="form-group">
                            <label for="tb_fuente_recurso">Fuente*</label>
                            <input type="text" class="form-control" id="tb_fuente_recurso"  name="tb_fuente_recurso"
                                   placeholder="Introduce Fuente del Recurso">
                        </div> 
                        <div class="form-group">
                            <label for="tb_origen_recurso">Origen*</label>
                            <input type="text" class="form-control" id="tb_origen_recurso"  name="tb_origen_recurso"
                                   placeholder="Introduce Fuente del Recurso">                       
                        </div>
                        <div class="form-group">
                            <label for="sl_estandar_recurso">Estandar*</label>                        
                            <select name="sl_estandar_recurso" id="sl_estandar_recurso"  class="form-control" name="sl_estandar_recurso">
                                {foreach item=datos from=$estandar}
                                    <option value='{$datos.Esr_IdEstandarRecurso}'> {$datos.Esr_Nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                            <input type="hidden" id="hd_tipo_recurso" name="hd_tipo_recurso" value="1">
                        <button type="submit" id="bt_registrar" name="bt_registrar"  class="btn btn-default ">Registrar</button>
                    </div>
                </form>
            </div>           
        </div>       

    </div>   
</div>

