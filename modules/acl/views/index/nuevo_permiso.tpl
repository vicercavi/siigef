<div style="width: 75%; float:left; margin: 0px auto">

    <h4>AGREGAR PERMISO</h4>
    <form class="form-horizontal" role="form" name="form1" action="" method="post">
        <input type="hidden" name="guardar" value="1" />
        <div class="form-group">
            
            <label class="col-lg-2 control-label">Permiso: </label>
            <div class="col-lg-10">
                <input  class="form-control" type="text" name="permiso" value="{$datos.permiso|default:""}" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Key: </label>
            <div class="col-lg-10">
                <input  class="form-control" type="text" name="key" value="{$datos.key|default:""}" />
            </div>
        </div>
        <button class="btn btn-primary" type="submit"  ><i class="glyphicon glyphicon-ok"> </i>  Guardar</button>
        
    </form> 
</div>