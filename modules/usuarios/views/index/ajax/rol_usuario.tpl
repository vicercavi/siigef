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
<form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
{if isset($datos) && count($datos)}
<input type="hidden" value="{$datos.Usu_IdUsuario}" id="idusuario" name="idusuario" />
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
        <div class="col-lg-3">
            <button type="button" class="btn btn-primary" id="btn_nuevoRol" name="btn_nuevoRol"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;{$lenguaje.roles_nuevo_titulo}</button>
        </div>
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
        <label class="col-lg-3 control-label">{$lenguaje.label_usuario} : </label>
        <div class="col-lg-8">
            <input  class="form-control" id="usuario" type="text" data-minlength="5" pattern="([_A-z0-9])+" name="usuario" value="{$datos.Usu_Usuario|default:""}" placeholder="{$lenguaje.label_usuario}" required=""/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">{$lenguaje.label_contrasena} : </label>
        <div class="col-lg-8">
            <input class="form-control" id="contrasena" type="password" data-minlength="6" name="contrasena" placeholder="{$lenguaje.label_contrasena}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-3 control-label">{$lenguaje.label_confirmar} : </label>
        <div class="col-lg-8">
            <input class="form-control" id="confirmarContrasena" type="password" data-match="#contrasena" data-match-error="Contraseña no coinciden" name="confirmarContrasena" placeholder="{$lenguaje.label_confirmar}" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-8">
        <button class="btn btn-success" id="bt_guardarUsuario" name="bt_guardarUsuario" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
        </div>
    </div>                
{/if}                
</form>