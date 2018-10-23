<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.tipoagua_label_titulo}</h4>
    </div>
    {if $_acl->permiso("agregar_tipoagua")}
        <div class="panel panel-default">
            <div class="panel-heading jsoftCollap">
                <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed"><i style="float:right"class="fa fa-ellipsis-v"></i><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<strong>{$lenguaje.tipoaguas_nuevo_titulo}</strong></h3>
            </div>
            <div style="height: 0px;" aria-expanded="false" id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id="nuevoRegistro">
                        <div style="width: 90%; margin: 0px auto">                        
                            <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                                <!--                            <input type="hidden" value="1" name="enviar" />-->                           
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{$lenguaje.label_nombre_nuevo} (*): </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="nombre" type="text"  name="nombre" value="" placeholder="{$lenguaje.label_nombre_nuevo}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{$lenguaje.label_descripcion_nuevo} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="txtdescripcion" type="text"  name="descripcion" value="" placeholder="{$lenguaje.label_descripcion_nuevo}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{$lenguaje.label_color_nuevo} (*): </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="txtcolor" type="text"  name="color" value="" placeholder="{$lenguaje.label_color_nuevo}" required="" />
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_estado_nuevo} : </label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="selEstado" name="selEstado" >
                                            <option value="0">Inactivo</option>
                                            <option value="1">Activo</option>
                                        </select>
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
    {if  isset($datos) && count($datos)}
        {if $_acl->permiso("editar_tipoagua")}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 aria-expanded="false" data-toggle="collapse" href="#collapse2" class="panel-title collapsed">
                        <i style="float:right" class="glyphicon glyphicon-option-vertical"></i>
                        <i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;
                        <strong>{$lenguaje.tipoaguas_editar_titulo}</strong>
                    </h3>
                </div>
                <div style="height: 0px;" aria-expanded="false" id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div id="editarRegistro">
                            <div style="width: 90%; margin: 0px auto">                        
                                <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                                    <!--                            <input type="hidden" value="1" name="enviar" />-->                           
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">{$lenguaje.label_nombre_editar} (*): </label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id ="nombre" name="nombre" type="text" value="{$datos.Tia_Nombre}" placeholder="{$lenguaje.label_nombre_editar}" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">{$lenguaje.label_descripcion_editar} : </label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id ="txtdescripcion" type="text"  name="descripcion" value="{$datos.Tia_Descripcion}" placeholder="{$lenguaje.label_descripcion_editar}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">{$lenguaje.label_color_editar} (*): </label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id ="txtcolor" type="text"  name="color" value="{$datos.Tia_Color}" placeholder="{$lenguaje.label_color_editar}" required="" />
                                        </div>
                                    </div>
                                    <div class="form-group">                                 
                                        <label class="col-lg-3 control-label">{$lenguaje.label_estado_editar} : </label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="selEstado" name="selEstado">
                                                <option value="0" {if $datos.Tia_Estado == 0}selected="selected"{/if}>Inactivo</option>
                                                <option value="1" {if $datos.Tia_Estado == 1}selected="selected"{/if}>Activo</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-8">
                                            <button class="btn btn-success" id="bt_editar" name="bt_editar" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; Actualizar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>        
                        </div>
                    </div>
                </div>
            </div>            
        {/if}
    {/if}
    <div style=" margin: 15px auto">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;<strong>{$lenguaje.tipoaguas_buscar_titulo}</strong>                       
                </h3>
            </div>
            <div class="panel-body">                          
                <div class="row">
                    <div class="col-md-12 "> 
                        <div class="col-md-4 pull-right">
                            <div class="input-group">
                                <input id="palabra" type="text" class="form-control"  placeholder="{$lenguaje.text_buscar_tipoagua}" name="palabra" />
                                <span class="input-group-btn">
                                    <button id="buscar" class="btn btn-success" type="button">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin: 15px 25px">
                    <h4 class="panel-title"> <b>{$lenguaje.tipoaguas_buscar_tabla_titulo}</b></h4>
                    <div id="listaregistros">
                        {if isset($tipoaguas) && count($tipoaguas)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_tipoagua}</th>
                                        <th style=" text-align: center">{$lenguaje.label_descripcion}</th>
                                        <th style=" text-align: center">{$lenguaje.label_color}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$tipoaguas item=tipoagua}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$tipoagua.Tia_Nombre}</td>
                                            <td>{$tipoagua.Tia_Descripcion}</td>
                                            <td>{$tipoagua.Tia_Color}</td>
                                            <td style=" text-align: center">
                                                {if $tipoagua.Tia_Estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $tipoagua.Tia_Estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_tipoagua")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/tipoagua/index/{$tipoagua.Tia_IdTipoAgua}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_tipoagua")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-tipoagua" title="{$lenguaje.label_cambiar_estado}" idtipoagua="{$tipoagua.Tia_IdTipoAgua}" estado="{if $tipoagua.Tia_Estado==0}1{else}0{/if}"> </a>      
                                                {/if}
                                                {if $_acl->permiso("eliminar_tipoagua")}
                                                    <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="Confirmación de eliminación" data-id="{$tipoagua.Tia_IdTipoAgua}" data-nombre="{$tipoagua.Tia_Nombre}" class="btn btn-default btn-sm glyphicon glyphicon-trash">
                                                    </a>
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
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmación de Eliminación</h4>
            </div>

            <div class="modal-body">
                <p>Estás a punto de borrar un item, este procedimiento es irreversible</p>
                <p>¿Deseas Continuar?</p>
                <p>Eliminar: <strong class="nombre-es">{$tipoagua.Tia_Nombre}</strong></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a style="cursor:pointer"  id="{$tipoagua.Tia_IdTipoAgua}" data-dismiss="modal" class="btn btn-danger danger eliminar_tipoagua">Eliminar</a>
            </div>
        </div>
    </div>
</div>