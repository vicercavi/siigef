<div class="container">
    {if  isset($usuario) && count($usuario)}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xs-offset-0 col-sm-offset-0 col-md-offset-2 col-lg-offset-2 toppad" >
            <div class="panel panel-default ">
                <div class="panel-heading " >
                    <h3 class="panel-title"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;<strong>{$usuario.Rol_role|default:""}</strong>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 " align="center">
                            <div class="user-panel" >
                                <img  class=" glyphicon glyphicon-user "> 
                                <div class="pull-left image">
                                    <img src="{$_layoutParams.root}/views/layout/backend/img/user2-160x160.jpg" class="img-circle" style="  max-width: 60px;" alt="User Image">
                                </div>                            
                            </div>
                        </div>
                        <div class=" col-md-9 col-lg-9 "> 
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td class="text-bold">{$lenguaje.label_nombre} : </td>
                                        <td>{$usuario.Usu_Nombre}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">{$lenguaje.label_apellidos} : </td>
                                        <td>{$usuario.Usu_Apellidos}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">{$lenguaje.label_direccion} : </td>
                                        <td>{$usuario.Usu_Direccion}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">{$lenguaje.label_dni} : </td>
                                        <td>{$usuario.Usu_DocumentoIdentidad}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">{$lenguaje.label_telefono} : </td>
                                        <td>{$usuario.Usu_Telefono}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">{$lenguaje.label_institucion} : </td>
                                        <td>{$usuario.Usu_InstitucionLaboral}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">{$lenguaje.label_cargo} : </td>
                                        <td>{$usuario.Usu_Cargo}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">{$lenguaje.label_correo} : </td>
                                        <td>{$usuario.Usu_Email}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">{$lenguaje.label_usuario} : </td>
                                        <td>{$usuario.Usu_Usuario}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">{$lenguaje.label_fecha_usuario} : </td>
                                        <td>{$usuario.Usu_Fecha}</td>
                                    </tr> 
                                </tbody>
                            </table>      
                        </div>
                    </div>
                </div>
                <div class="panel-footer ">                    
                    <a style="background-color: #FFF" href="{$_layoutParams.root}usuarios/perfil/editarPerfil/{$usuario.Usu_IdUsuario}" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-default " ><i class="glyphicon glyphicon-edit"></i></a>
                </div>          
            </div>
        </div>
    </div>
    {else}
        {$lenguaje.no_registros}
    {/if}
</div>