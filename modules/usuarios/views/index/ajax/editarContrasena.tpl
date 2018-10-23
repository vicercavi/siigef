<div class="panel panel-default">
    <div class="panel-heading  jsoftCollap "  data-toggle="collapse" href="#collapse2">
        <h3 class="panel-title "><i class="glyphicon glyphicon-option-vertical pull-right"></i><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;<strong>{$lenguaje.titulo_editar_contrasena}</strong></h3>
    </div>
    <div  aria-expanded="false" id="collapse2" class="panel-collapse collapse">
        <div id="nuevo_rol" class="panel-body" style="width: 90%; margin: 0px auto">
            <form class="form-horizontal" data-toggle="validator" id="form2" role="form" name="form1" action="" method="post" >
                <input type="hidden" id="idusuario" name="idusuario" value="{$idusuario}" />
                <div class="form-group">
                    <label class="col-lg-3 control-label">{$lenguaje.nueva_contrasena} : </label>
                    <div class="col-lg-8">
                        <input class="form-control" id="contrasena" type="password" data-minlength="6" name="contrasena" placeholder="{$lenguaje.nueva_contrasena}" required=""/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">{$lenguaje.label_confirmar} : </label>
                    <div class="col-lg-8">
                        <input class="form-control" id="confirmarContrasena" type="password" data-match="#contrasena" data-match-error="Contraseña no coinciden" name="confirmarContrasena" placeholder="{$lenguaje.label_confirmar}" required="" />                        
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-8">
                    <button class="btn btn-success" id="bt_guardarContrasena" name="bt_guardarContrasena" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
