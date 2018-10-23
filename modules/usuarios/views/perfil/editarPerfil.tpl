<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad" >
            <div class="panel panel-default ">
                <div class="panel-heading " >
                    <h3 class="panel-title"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;<strong>{$datos.Rol_role|default:""}</strong>                       
                    </h3>
                </div>
                <div class="panel-body" style=" margin: 15px">
                    <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                        <input type="hidden" value="{$datos.Usu_IdUsuario}" id="idusuario" name="idusuario" />
                        <div class="form-group">
                            <label class="col-lg-4 control-label">{$lenguaje.label_nombre} : </label>
                            <div class="col-lg-7">
                                <input class="form-control" id ="nombre" type="text" pattern="([a-zA-Z][\sa-zA-Z]+)" name="nombre" value="{$datos.Usu_Nombre|default:""}" placeholder="{$lenguaje.label_nombre}" required=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-4 control-label" >{$lenguaje.label_apellidos} : </label>
                            <div class="col-lg-7">
                                <input class="form-control" id ="apellidos" type="text" pattern="([a-zA-Z][\sa-zA-Z]+)" name="apellidos" value="{$datos.Usu_Apellidos|default:""}" placeholder="{$lenguaje.label_apellidos}" required=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-4 control-label" >{$lenguaje.label_dni} : </label>
                            <div class="col-lg-7">
                                <input  class="form-control" id ="dni" type="text" pattern="[0-9]+" data-minlength="8" name="dni" value="{$datos.Usu_DocumentoIdentidad|default:""}" placeholder="{$lenguaje.label_dni}" required=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-4 control-label" >{$lenguaje.label_direccion} : </label>
                            <div class="col-lg-7">
                                <input  class="form-control" id ="direccion" type="text" name="direccion" value="{$datos.Usu_Direccion|default:""}" placeholder="{$lenguaje.label_direccion}" required=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-4 control-label" >{$lenguaje.label_telefono} : </label>
                            <div class="col-lg-7">
                                <input  class="form-control" id ="telefono" type="text"  pattern="^\+?[0-9][0-9][0-9]?[1-9][\-0-9]+$" name="telefono" value="{$datos.Usu_Telefono|default:""}" placeholder="{$lenguaje.label_telefono}" required=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label" >{$lenguaje.label_institucion} : </label>
                            <div class="col-lg-7">
                                <input  class="form-control" id ="institucion" type="text"  name="institucion" value="{$datos.Usu_InstitucionLaboral|default:""}" placeholder="{$lenguaje.label_institucion}" required=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">{$lenguaje.label_cargo} : </label>
                            <div class="col-lg-7">
                                <input  class="form-control" id ="cargo" type="text" name="cargo" value="{$datos.Usu_Cargo|default:""}" placeholder="{$lenguaje.label_cargo}" required=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-4 control-label">{$lenguaje.label_correo} : </label>
                            <div class="col-lg-7">
                                <input  class="form-control" id = "email" type="email" name="email" value="{$datos.Usu_Email|default:""}" placeholder="{$lenguaje.label_correo}" required=""/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-4 control-label">{$lenguaje.label_usuario} : </label>
                            <div class="col-lg-4">
                                <input  class="form-control" id="usuario" type="text" data-minlength="5" pattern="([_A-z0-9])+" name="usuario" value="{$datos.Usu_Usuario|default:""}" placeholder="{$lenguaje.label_usuario}" required=""/>
                            </div>
                            {if $_acl->permiso("editar_perfil")}
                            <div class="col-lg-3">                                
                                <a data-toggle="tooltip" data-placement="bottom" class="btn btn-dropbox btn-sm glyphicon glyphicon-edit" title="{$lenguaje.editar_contrasena}" href="{$_layoutParams.root}usuarios/perfil/editarContrasena/{$datos.Usu_IdUsuario}">&nbsp;{$lenguaje.editar_contrasena}</a>
                            </div>
                            {/if}
                        </div> 
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-7 pull-right">
                            <button class="btn btn-success" id="bt_guardarUsuario" name="bt_guardarUsuario" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
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