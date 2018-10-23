<div class="panel panel-default">
    <div class="panel-heading  jsoftCollap" data-toggle="collapse" href="#collapse3" >
        <h3 class="panel-title "><i class="glyphicon glyphicon-option-vertical pull-right"></i><i class="fa fa-user-secret"></i>&nbsp;&nbsp;<strong>{$lenguaje.roles_nuevo_titulo}</strong></h3>
    </div>
    <div style="height: 0px;" aria-expanded="false" id="collapse3" class="panel-collapse collapse">
        <div id="nuevo_rol" class="panel-body" style="width: 90%; margin: 0px auto">
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
        </div>
    </div>
</div>
