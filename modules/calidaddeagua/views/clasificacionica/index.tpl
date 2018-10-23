<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.clasificacionicas_label_titulo}</h4>
    </div>
    {if $_acl->permiso("agregar_clasificacionica")}
        <div class="panel panel-default">
            <div class="panel-heading jsoftCollap">
                <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed"><i style="float:right"class="fa fa-ellipsis-v"></i><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<strong>{$lenguaje.clasificacionicas_nuevo_titulo}</strong></h3>
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
                                        <input class="form-control" id ="nombre" type="text"  name="nombre" value="" placeholder="{$lenguaje.label_nombre}" required=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{$lenguaje.label_descripcion_nuevo} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="descripcion" type="text"  name="descripcion" value="" placeholder="{$lenguaje.label_descripcion_nuevo}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{$lenguaje.label_icamin_nuevo} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="icamin" type="text"  name="icamin" value="" placeholder="{$lenguaje.label_icamin_nuevo}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{$lenguaje.label_icamax_nuevo} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="icamax" type="text"  name="icamax" value="" placeholder="{$lenguaje.label_icamax_nuevo}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{$lenguaje.label_color_nuevo} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="color" type="text"  name="color" value="" placeholder="{$lenguaje.label_color_nuevo}"/>
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_categoriaica_nuevo} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($categoriaicas) && count($categoriaicas)}
                                            <select class="form-control" id="selCategoriaIca" name="selCategoriaIca">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$categoriaicas item=c}
                                                    <option value="{$c.Cai_IdCategoriaIca}">{$c.Cai_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_ica_nuevo} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($icas) && count($icas)}
                                            <select class="form-control" id="selIca" name="selIca" >
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$icas item=i}
                                                    <option value="{$i.Ica_IdIca}">{$i.Ica_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
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
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;<strong>{$lenguaje.clasificacionicas_buscar_titulo}</strong>                       
                </h3>
            </div>
            <div class="panel-body">                          
                <div class="form-group ">
                    <div class="col-xs-3" >                        
                        {if  isset($categoriaicas) && count($categoriaicas)}
                            <select class="form-control" id="buscarCategoriaIca" name="buscarCategoriaIca">
                                <option value="">{$lenguaje.label_todos_categoriaicas}</option>
                                {foreach from=$categoriaicas item=c}
                                    <option value="{$c.Cai_IdCategoriaIca}">{$c.Cai_Nombre}</option>    
                                {/foreach}
                            </select>
                        {/if}
                    </div>
                    <div class="col-xs-3" >                        
                        {if  isset($icas) && count($icas)}
                            <select class="form-control" id="buscarIca" name="buscarIca">
                                <option value="">{$lenguaje.label_todos_icas}</option>
                                {foreach from=$icas item=i}
                                    <option value="{$i.Ica_IdIca}">{$i.Ica_Nombre}</option>    
                                {/foreach}
                            </select>
                        {/if}
                    </div>
                    <div class="col-xs-3">
                        <input class="form-control" placeholder="{$lenguaje.text_buscar_clasificacionica}"  name="palabra" id="palabra">                        
                    </div>
                    <button class=" btn btn-primary" type="button" id="buscar"  ><i class="glyphicon glyphicon-search"></i></button>
                </div>
                <div style="margin: 15px 25px">
                    <h4 class="panel-title"> <b>{$lenguaje.clasificacionicas_buscar_tabla_titulo}</b></h4>
                    <div id="listaregistros">
                        {if isset($clasificacionicas) && count($clasificacionicas)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_clasificacionica}</th>
                                        <th style=" text-align: center">{$lenguaje.label_descripcion}</th>
                                        <th style=" text-align: center">{$lenguaje.label_icamin}</th>
                                        <th style=" text-align: center">{$lenguaje.label_icamax}</th>
                                        <th style=" text-align: center">{$lenguaje.label_color}</th>
                                        <th style=" text-align: center">{$lenguaje.label_categoriaica}</th>
                                        <th style=" text-align: center">{$lenguaje.label_ica}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$clasificacionicas item=clasificacionica}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$clasificacionica.Cli_Nombre}</td>
                                            <td>{$clasificacionica.Cli_Descripcion}</td>
                                            <td>{$clasificacionica.Cli_IcaMin}</td>
                                            <td>{$clasificacionica.Cli_IcaMax}</td>
                                            <td style="color: {$clasificacionica.Cli_Color}">
                                                {$clasificacionica.Cli_Color}
                                            </td>
                                            <td>{$clasificacionica.Cai_Nombre}</td>
                                            <td>{$clasificacionica.Ica_Nombre}</td>
                                            <td style=" text-align: center">
                                                {if $clasificacionica.Cli_Estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $clasificacionica.Cli_Estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_clasificacionica")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/clasificacionica/editar/{$clasificacionica.Cli_IdClasificacionIca}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_clasificacionica")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-clasificacionica" title="{$lenguaje.label_cambiar_estado}" idclasificacionica="{$clasificacionica.Cli_IdClasificacionIca}" estado="{if $clasificacionica.Cli_Estado==0}1{else}0{/if}"> </a>      
                                                {/if}{if $_acl->permiso("eliminar_clasificacionica")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-clasificacionica" title="{$lenguaje.label_eliminar}" idclasificacionica="{$clasificacionica.Cli_IdClasificacionIca}"> </a>
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