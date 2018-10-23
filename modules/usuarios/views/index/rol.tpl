<div  class="container-fluid" >
    <div class="row" >
        <h4 class="titulo-view">{$lenguaje.usuarios_label_titulo}</h4>
    </div>
    <div id="agregarRol">        
    </div>
    <div id="editarContrasena">        
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<strong>{$lenguaje.roles_editar_titulo}</strong>                       
            </h3>
        </div>
        <div id="rol_usuario" class="panel-body" style=" margin: 15px">
            <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                {if isset($datos) && count($datos)}
                    <input type="hidden" value="{$datos.Usu_IdUsuario}" id="idusuario" name="idusuario" />
                    <input type="hidden" value="{$datos.Usu_Usuario}" id="usuario" name="usuario" />
                    <div class="form-group">
                        <label class="col-lg-3 control-label ">
                            <b>{$lenguaje.label_usuario} :</b>
                        </label>
                        <div class="col-lg-3 panel-default" >
                            <strong class="form-control" style="  color: #333; background-color: #f5f5f5;" >
                                <b>{$datos.Usu_Usuario}</b>
                            </strong>
                        </div>
                        {if $_acl->permiso("agregar_usuario")}
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-dropbox" id="btn_editContra" name="btn_editContra"><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;{$lenguaje.editar_contrasena}</button>
                        </div>
                        {/if}
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">
                            <b>{$lenguaje.label_rol} :</b>
                        </label>
                        <div class="col-lg-3">
                        {if isset($roles) && count($roles)}
                            <select class="form-control" name="Rol_IdRol" id="Rol_IdRol" >
                                {foreach item=r from=$roles}
                                    <option  value="{$r.Rol_IdRol|default:0}"  {if $r.Rol_role == $datos.Rol_role}selected="selected"{/if}>{$r.Rol_role|default:"select"}</option>
                                {/foreach}            
                            </select>
                        {/if}
                        </div>
                        {if $_acl->permiso("agregar_rol")}
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-facebook" id="btn_nuevoRol" name="btn_nuevoRol"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;{$lenguaje.roles_editar_label_nuevo}</button>
                        </div>
                        {/if}
                    </div>
                        
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{$lenguaje.label_nombre} : </label>
                        <div class="col-lg-8">
                            <input class="form-control" id ="nombre" type="text" pattern="([a-zA-Z][\sa-zA-Z]+)" name="nombre" value="{$datos.Usu_Nombre|default:""}" placeholder="{$lenguaje.label_nombre}" required=""/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" >{$lenguaje.label_apellidos} : </label>
                        <div class="col-lg-8">
                            <input class="form-control" id ="apellidos" type="text" pattern="([a-zA-Z][\sa-zA-Z]+)" name="apellidos" value="{$datos.Usu_Apellidos|default:""}" placeholder="{$lenguaje.label_apellidos}" required=""/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" >{$lenguaje.label_dni} : </label>
                        <div class="col-lg-8">
                            <input  class="form-control" id ="dni" type="text" pattern="[0-9]+" data-minlength="8" name="dni" value="{$datos.Usu_DocumentoIdentidad|default:""}" placeholder="{$lenguaje.label_dni}" required=""/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" >{$lenguaje.label_direccion} : </label>
                        <div class="col-lg-8">
                            <input  class="form-control" id ="direccion" type="text" name="direccion" value="{$datos.Usu_Direccion|default:""}" placeholder="{$lenguaje.label_direccion}" required=""/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" >{$lenguaje.label_telefono} : </label>
                        <div class="col-lg-8">
                            <input  class="form-control" id ="telefono" type="text"  pattern="^\+?[0-9][0-9][0-9]?[1-9][\-0-9]+$" name="telefono" value="{$datos.Usu_Telefono|default:""}" placeholder="{$lenguaje.label_telefono}" required=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" >{$lenguaje.label_institucion} : </label>
                        <div class="col-lg-8">
                            <input  class="form-control" id ="institucion" type="text"  name="institucion" value="{$datos.Usu_InstitucionLaboral|default:""}" placeholder="{$lenguaje.label_institucion}" required=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{$lenguaje.label_cargo} : </label>
                        <div class="col-lg-8">
                            <input  class="form-control" id ="cargo" type="text" name="cargo" value="{$datos.Usu_Cargo|default:""}" placeholder="{$lenguaje.label_cargo}" required=""/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">{$lenguaje.label_correo} : </label>
                        <div class="col-lg-8">
                            <input  class="form-control" id = "email" type="email" name="email" value="{$datos.Usu_Email|default:""}" placeholder="{$lenguaje.label_correo}" required=""/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-8">
                        <button class="btn btn-success" id="bt_guardarUsuario" name="bt_guardarUsuario" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
                        </div>
                    </div>                
                {/if}                
            </form>
        </div>
    </div>
</div>