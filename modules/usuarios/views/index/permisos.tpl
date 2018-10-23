<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.permisos_label_titulo}</h4>
    </div>
    {if $_acl->permiso("agregar_usuario")}
    <div class="panel panel-default">
        <div class="panel-heading ">
            <h3 aria-expanded="false"  class="panel-title collapsed"><i class="fa fa-key"></i>&nbsp;&nbsp;<strong>{$lenguaje.permisos_usuarios_titulo}</strong></h3>
        </div>        
        <div class="panel-body" style="width: 90%; margin: 0px auto">
            <h4>
                <b><i class="fa fa-user"></i>&nbsp;&nbsp;{$lenguaje.label_usuario} : &nbsp;&nbsp; {$info.Usu_Usuario} </b>&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; 
                <b><i class="fa fa-user-secret"></i>&nbsp;&nbsp;{$lenguaje.label_rol} : &nbsp;&nbsp; {$info.Rol_role}</b>
            </h4>
            <br>
            <form class="form-horizontal" role="form" name="form1" method="post" action="">
                    <input type="hidden" value="1" name="guardar">
                {if isset($permisos) && count($permisos)}
                    <div class="table-responsive" >
                    <table class="table">
                        <tr><td><b>{$lenguaje.label_permiso}</b></td>
                            <td><b>{$lenguaje.label_estado}</b></td>
                        </tr>
                        {foreach from=$permisos item=pr}
                            {if $role.$pr.valor == 1}
                                {assign var="v" value="{$lenguaje.label_habilitado}"}
                            {else}
                                {assign var="v" value="{$lenguaje.label_denegado}"}
                            {/if}
                        <tr>
                            <td>{$usuario.$pr.permiso}: </td>
            
                            <td>
                                <select name="perm_{$usuario.$pr.id}">
                                    <option value="x"{if $usuario.$pr.heredado} selected="selected"{/if}>Heredado({$v})</option>
                                    <option value="1"{if ($usuario.$pr.valor == 1 && $usuario.$pr.heredado == "")} selected="selected"{/if}>Habilitado</option>
                                    <option value=""{if ($usuario.$pr.valor == "" && $usuario.$pr.heredado == "")} selected="selected"{/if}>Denegado</option>
                                </select>
                            </td>
                        </tr>
            
                        {/foreach}
                    </table>                    
                    </div>
                    <button class="btn btn-success" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
                {else}
                    {$lenguaje.no_registros}
                {/if}
            </form>
        </div>
    </div>
    {/if}
</div>