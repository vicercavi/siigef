
<div>
    <h4 aling="center">REGISTRAR USUARIO</h4>
    <form class="form-horizontal" role="form" method="post" action="" autocomplete="on">
        <input type="hidden" value="1" name="enviar" />
       
        <div class="form-group">
                
            <label class="col-lg-2 control-label">Nombre: </label>
            <div class="col-lg-10">
                <p><input class="form-control" id ="nombre"type="text" name="nombre" value="{$datos.nombre|default:""}" placeholder="Nombre"/></p>
            </div>
        </div>
            
        <div class="form-group">
            <label class="col-lg-2 control-label" >Apellidos: </label>
            <div class="col-lg-10">
                <p><input class="form-control" id ="apellidos"type="text" name="apellidos" value="{$datos.apellidos|default:""}" placeholder="Apellidos"/></p>
            </div>
        </div>
            
        <div class="form-group">
            <label class="col-lg-2 control-label" >Documento de Identidad: </label>
            <div class="col-lg-10">
                <p><input  class="form-control" id ="dni" type="text" name="dni" value="{$datos.dni|default:""}" placeholder="Documento de Identidad"/></p>
            </div>
        </div>
            
        <div class="form-group">
            <label class="col-lg-2 control-label" >Dirección: </label>
            <div class="col-lg-10">
                <p><input  class="form-control" id ="direccion"type="text" name="direccion" value="{$datos.direccion|default:""}" placeholder="Dirección"/></p>
            </div>
        </div>
            
        <div class="form-group">
            <label class="col-lg-2 control-label" >Teléfono: </label>
            <div class="col-lg-10">
                <p><input  class="form-control" id ="telefono"type="text" name="telefono" value="{$datos.telefono|default:""}" placeholder="Teléfono"/></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" >Institucion donde Labora: </label>
            <div class="col-lg-10">
                <p><input  class="form-control" id ="institucion"type="text" name="institucion" value="{$datos.institucion|default:""}" placeholder="Institucion donde Labora"/></p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Cargo: </label>
            <div class="col-lg-10">
                <p><input  class="form-control" id ="cargo"type="text" name="cargo" value="{$datos.cargo|default:""}" placeholder="Cargo"/></p>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-2 control-label">Correo: </label>
            <div class="col-lg-10">
                <p><input  class="form-control" id = "correo" type="email" name="email" value="{$datos.email|default:""}" placeholder="Correo"/></p>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-2 control-label">Usuario: </label>
            <div class="col-lg-10">
                <p><input  class="form-control" type="text" name="usuario" value="{$datos.usuario|default:""}" placeholder="Usuario"/></p>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-2 control-label">Contraseña: </label>
            <div class="col-lg-10">
                <p><input class="form-control" type="password" name="pass" placeholder="Contraseña"/></p>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-2 control-label">Confirmar: </label>
            <div class="col-lg-10">
                <p><input class="form-control" type="password" name="confirmar" placeholder="Confirmar"/></p>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-primary" type="submit" value="Enviar" ><i class="icon-plus-sign icon-white"> </i>Registrar</button>
            </div>
        </div>
    </form>
</div>
        <br><br><br>