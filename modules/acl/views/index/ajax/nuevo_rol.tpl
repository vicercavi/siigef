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
<form class="form-horizontal" data-toggle="validator" id="form2" role="form" name="form1" action="" method="post" >
<!--  <input type="hidden" name="guardarRol" value="1" />-->
    <div class="form-group">
        <label class="col-lg-2 control-label">{$lenguaje.label_nombre_rol} : </label>
        <div class="col-lg-10">
            <input class="form-control" id="nuevoRol"  type="text" name="nuevoRol" placeholder="Rol" required="" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-success" type="button" id="btn_guardarRol" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
        </div>
    </div>
</form>