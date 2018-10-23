<div class="form-bg">
    <form name="form1" method="post" action="" autocomplete="on">
        <input type="hidden" value="1" name="enviar" />      
        <h2>Iniciar Sesión</h2>         
        <p><input type="text" name="usuario" value="{$datos.usuario|default:""}" placeholder="Usuario"/></p>
        
        <p><input type="password" name="pass" placeholder="Contraseña"/></p>

        <label for="remember">
          <!--  <a href="{$_layoutParams.root}usuarios/registro"><span  >Registrarse</span></a>-->
        </label>

        <button type="submit" value="Entrar" ></button>
    </form>
</div>
        