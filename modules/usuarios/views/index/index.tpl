<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.usuarios_label_titulo}</h4>
    </div>
    {if $_acl->permiso("agregar_usuario")}
    <div class="panel panel-default">
        <div class="panel-heading jsoftCollap">
            <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed"><i style="float:right"class="fa fa-ellipsis-v"></i><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<strong>{$lenguaje.usuarios_nuevo_titulo}</strong></h3>
        </div>
        <div style="height: 0px;" aria-expanded="false" id="collapse3" class="panel-collapse collapse">
            <div class="panel-body">
                <div id="nuevoRegistro">
                    <div style="width: 90%; margin: 0px auto">                        
                        <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
<!--                            <input type="hidden" value="1" name="enviar" />-->                           
                            <div class="form-group">
                                    
                                <label class="col-lg-3 control-label">{$lenguaje.label_nombre} : </label>
                                <div class="col-lg-8">
                                    <input class="form-control" id ="nombre" type="text" pattern="([a-zA-Z][\sa-zA-Z]+)" name="nombre" value="{$datos.nombre|default:""}" placeholder="{$lenguaje.label_nombre}" required=""/>
                                </div>
                            </div>
                                
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >{$lenguaje.label_apellidos} : </label>
                                <div class="col-lg-8">
                                    <input class="form-control" id ="apellidos" type="text" pattern="([a-zA-Z][\sa-zA-Z]+)" name="apellidos" value="{$datos.apellidos|default:""}" placeholder="{$lenguaje.label_apellidos}" required=""/>
                                </div>
                            </div>
                                
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >{$lenguaje.label_dni} : </label>
                                <div class="col-lg-8">
                                    <input  class="form-control" id ="dni" type="text" pattern="[0-9]+" data-minlength="8" name="dni" value="{$datos.dni|default:""}" placeholder="{$lenguaje.label_dni}" required=""/>
                                </div>
                            </div>
                                
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >{$lenguaje.label_direccion} : </label>
                                <div class="col-lg-8">
                                    <input  class="form-control" id ="direccion" type="text" name="direccion" value="{$datos.direccion|default:""}" placeholder="{$lenguaje.label_direccion}" required=""/>
                                </div>
                            </div>                                
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >{$lenguaje.label_telefono} : </label>
                                <div class="col-lg-8">
                                    <input  class="form-control" id ="telefono" type="text"  pattern="^\+?[0-9][0-9][0-9]?[1-9][\-0-9]+$" name="telefono" value="{$datos.telefono|default:""}" placeholder="{$lenguaje.label_telefono}" required=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" >{$lenguaje.label_institucion} : </label>
                                <div class="col-lg-8">
                                    <input  class="form-control" id ="institucion" type="text"  name="institucion" value="{$datos.institucion|default:""}" placeholder="{$lenguaje.label_institucion}" required=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{$lenguaje.label_cargo} : </label>
                                <div class="col-lg-8">
                                    <input  class="form-control" id ="cargo" type="text" name="cargo" value="{$datos.cargo|default:""}" placeholder="{$lenguaje.label_cargo}" required=""/>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{$lenguaje.label_correo} : </label>
                                <div class="col-lg-8">
                                    <input  class="form-control" id = "email" type="email" name="email" value="{$datos.email|default:""}" placeholder="{$lenguaje.label_correo}" required=""/>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{$lenguaje.label_usuario} : </label>
                                <div class="col-lg-8">
                                    <input  class="form-control" id="usuario" type="text" data-minlength="5" pattern="([_A-z0-9])+" name="usuario" value="{$datos.usuario|default:""}" placeholder="{$lenguaje.label_usuario}" required=""/>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{$lenguaje.label_contrasena} : </label>
                                <div class="col-lg-8">
                                    <input class="form-control" id="contrasena" type="password" data-minlength="6" name="contrasena" placeholder="{$lenguaje.label_contrasena}" required=""/>
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label">{$lenguaje.label_confirmar} : </label>
                                <div class="col-lg-8">
                                    <input class="form-control" id="confirmarContrasena" type="password" data-match="#contrasena" data-match-error="Contraseña no coinciden" name="confirmarContrasena" placeholder="{$lenguaje.label_confirmar}" required=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-8">
                                <button class="btn btn-success" id="bt_guardar" name="bt_guardar" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
                                </div>
                            </div>
                        </form>
                    </div>        
                </div>
            </div>
        </div>
    </div>
    {/if}
    <div style=" margin: 15px auto">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;<strong>{$lenguaje.usuarios_buscar_titulo}</strong>                       
                </h3>
            </div>
            <div class="panel-body">                          
                <div class="form-group ">
                    <div class="col-xs-offset-4 col-xs-4" >                        
                        {if  isset($roles) && count($roles)}
                            <select class="form-control" id="buscarRol" name="buscarRol">
                                <option value="">{$lenguaje.label_todos_roles}</option>
                            {foreach from=$roles item=r}
                                <option value="{$r.Rol_IdRol}">{$r.Rol_role}</option>    
                            {/foreach}
                            </select>
                        {/if}
                    </div>
                    <div class="col-xs-3">
                        <input class="form-control" placeholder="{$lenguaje.text_buscar_usuario}"  name="palabra" id="palabra">                        
                    </div>
                    <button class=" btn btn-primary" type="button" id="buscar"  ><i class="glyphicon glyphicon-search"></i></button>
                </div>
                <div style="margin: 15px 25px">
                <h4 class="panel-title"> <b>{$lenguaje.usuarios_buscar_tabla_titulo}</b></h4>
                    <div id="listaregistros">
                        {if isset($usuarios) && count($usuarios)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_usuario}</th>
                                        <th style=" text-align: center">{$lenguaje.label_rol}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        {if $_acl->permiso("editar_usuario")}
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                        {/if}
                                    </tr>
                                    {foreach from=$usuarios item=us}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$us.Usu_Usuario}</td>
                                            <td>{$us.Rol_role}</td>
                                            <td style=" text-align: center">
                                                {if $us.Usu_Estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $us.Usu_Estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_usuario")}
                                                <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar_usuario}" href="{$_layoutParams.root}usuarios/index/rol/{$us.Usu_IdUsuario}"></a>
                                                {/if}{if $_acl->permiso("agregar_rol")}
                                                <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-tasks" title="{$lenguaje.tabla_opcion_editar_permisos}"  href="{$_layoutParams.root}usuarios/index/permisos/{$us.Usu_IdUsuario}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_usuario")}
                                                <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh" title="{$lenguaje.tabla_opcion_cambiar_est}" href="{$_layoutParams.root}usuarios/index/_cambiarEstado/{$us.Usu_IdUsuario}/{$us.Usu_Estado}"> </a>      
                                                {/if}{if $_acl->permiso("eliminar_usuario")}
                                                <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash" title="{$lenguaje.label_eliminar}" href="{$_layoutParams.root}usuarios/index/_eliminarUsuario/{$us.Usu_IdUsuario}"> </a>
                                                {/if}
                                            </td>                                            
                                        </tr>
                                    {/foreach}
                                </table>
                            </div>
                            {$paginacion|default:""}
                        {else}
                            {$lenguaje.no_registros}
                        {/if}                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>