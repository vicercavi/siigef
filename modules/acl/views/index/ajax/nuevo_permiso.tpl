 {if isset($_error)}
                        <div id="_errl" class="alert alert-error ">
                            <a class="close" data-dismiss="alert">x</a>
                            {$_error}
                        </div>
                    {/if}
  {if isset($_mensaje)}
                        <div id="_msgl" class="alert alert-success">
                            <a class="close" data-dismiss="alert">x</a>
                            {$_mensaje}
                        </div>
                    {/if}

    <h4>Agregar Permiso</h4>
    <form class="form-horizontal" role="form" name="form1" action="" method="post">
        <input type="hidden" name="guardar" value="1" />
        <div class="form-group">
            
            <label class="col-lg-2 control-label">Permiso: </label>
            <div class="col-lg-10">
                <input  class="form-control" type="text" name="permisook" value="{$datos.permiso|default:""}" />
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