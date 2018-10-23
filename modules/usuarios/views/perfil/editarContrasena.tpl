<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad" >
            <div class="panel panel-default ">
                <div class="panel-heading " >
                    <h3 class="panel-title"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;<strong>{$datos.Rol_role|default:""}</strong>                       
                    </h3>
                </div>
                <div class="panel-body" style=" margin: 15px">
                    <form class="form-horizontal" data-toggle="validator" id="form2" role="form" name="form1" action="" method="post" >
                        <input type="hidden" id="idusuario" name="idusuario" value="{$idusuario}" />                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label">{$lenguaje.label_contrasena_actual} : </label>
                            <div class="col-lg-8">
                                <input class="form-control" id="contrasena" type="password" name="contrasena" placeholder="{$lenguaje.label_contrasena_actual}" required=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">{$lenguaje.nueva_contrasena} : </label>
                            <div class="col-lg-8">
                                <input class="form-control" id="nuevaContrasena" type="password" data-minlength="6" name="nuevaContrasena" placeholder="{$lenguaje.nueva_contrasena}" required=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">{$lenguaje.label_confirmar} : </label>
                            <div class="col-lg-8">
                                <input class="form-control" id="confirmarContrasena" type="password" data-match="#nuevaContrasena" data-match-error="Contraseña no coinciden" name="confirmarContrasena" placeholder="{$lenguaje.label_confirmar}" required="" />                        
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-8">
                            <button class="btn btn-success" id="bt_guardarContrasena" name="bt_guardarContrasena" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer ">                    
                    
                </div>          
            </div>
        </div>
    </div>
</div>