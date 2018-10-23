<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.entidad_label_titulo}</h4>
    </div>
    {if $_acl->permiso("agregar_entidad")}
        <div class="panel panel-default">
            <div class="panel-heading jsoftCollap">
                <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed"><i style="float:right"class="fa fa-ellipsis-v"></i><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<strong>{$lenguaje.entidades_nuevo_titulo}</strong></h3>
            </div>
            <div style="height: 0px;" aria-expanded="false" id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id="nuevoRegistro">
                        <div style="width: 90%; margin: 0px auto">                        
                            <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                                <!--                            <input type="hidden" value="1" name="enviar" />-->                           
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_nombre_nuevo} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="nombre" type="text"  name="nombre" value="" placeholder="{$lenguaje.label_nombre_nuevo}" required=""/>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_siglas_nuevo} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="siglas" type="text"  name="siglas" value="" placeholder="{$lenguaje.label_siglas_nuevo}"/>
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
    <div style=" margin: 15px auto">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;<strong>{$lenguaje.entidades_buscar_titulo}</strong>                       
                </h3>
            </div>
            <div class="panel-body">                          
                <div class="form-group ">
                    <div class="col-xs-3">
                        <input class="form-control" placeholder="{$lenguaje.text_buscar_entidad}"  name="palabra" id="palabra">                        
                    </div>
                    <button class=" btn btn-primary" type="button" id="buscar"  ><i class="glyphicon glyphicon-search"></i></button>
                </div>
                <div style="margin: 15px 25px">
                    <h4 class="panel-title"> <b>{$lenguaje.entidades_buscar_tabla_titulo}</b></h4>
                    <div id="listaregistros">
                        {if isset($entidades) && count($entidades)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_entidad}</th>
                                        <th style=" text-align: center">{$lenguaje.label_siglas}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$entidades item=entidad}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$entidad.Ent_Nombre}</td>
                                            <td>{$entidad.Ent_Siglas}</td>
                                            <td style=" text-align: center">
                                                {if $entidad.Ent_Estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $entidad.Ent_Estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_entidad")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/entidad/editar/{$entidad.Ent_IdEntidad}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_entidad")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-entidad" title="{$lenguaje.label_cambiar_estado}" identidad="{$entidad.Ent_IdEntidad}" estado="{if $entidad.Ent_Estado==0}1{else}0{/if}"> </a>      
                                                {/if}{if $_acl->permiso("eliminar_entidad")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-entidad" title="{$lenguaje.label_eliminar}" identidad="{$entidad.Ent_IdEntidad}"> </a>
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