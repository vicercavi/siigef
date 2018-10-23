<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.estandarcalidad_label_titulo}</h4>
    </div>
    
   {if $_acl->permiso("agregar_estandarcalidadagua")}
        <div class="panel panel-default">
            <div class="panel-heading jsoftCollap">
                <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed"><i style="float:right"class="fa fa-ellipsis-v"></i><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<strong>{$lenguaje.estandarcalidadaguas_nuevo_titulo}</strong></h3>
            </div>
            <div style="height: 0px;" aria-expanded="false" id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id="nuevoRegistro">
                        <div style="width: 90%; margin: 0px auto">                        
                            <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
    
                                <!--                            <input type="hidden" value="1" name="enviar" />-->                           
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_sub_categoria_eca_nuevo} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($subcategoriaeca) && count($subcategoriaeca)}
                                            <select class="form-control" id="selsubcategoria" name="selsubcategoria">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$subcategoriaeca item=c}
                                                    <option value="{$c.Sue_IdSubcategoriaEca}">{$c.Sue_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div> 
                                    
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_variable_estudio_nuevo} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($variablesestudio) && count($variablesestudio)}
                                            <select class="form-control" id="selvariabletipo" name="selvariabletipo">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$variablesestudio item=c}
                                                    <option value="{$c.Var_IdVariable}">{$c.Var_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div> 
                                
                                                                
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_eca_signo} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="ecasigno" type="text"  name="ecasigno" value="" placeholder="{$lenguaje.label_eca_signo}" required=""/>
                                    </div>
                                </div>
                                    
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_valor_min} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="valormin" type="text"  name="valormin" value="" placeholder="{$lenguaje.label_valor_min}" required=""/>
                                    </div>
                                </div>
                                              
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_valor_max} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="valormax" type="text"  name="valormax" value="" placeholder="{$lenguaje.label_valor_max}" required=""/>
                                    </div>
                                </div>
                                    
                                    
                                  <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_variable_estudio_nuevo} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($estadoeca) && count($estadoeca)}
                                            <select class="form-control" id="estadoeca" name="estadoeca">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$estadoeca item=c}
                                                    <option value="{$c.ese_IdEstadoEca}">{$c.ese_nombre}</option>    
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
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;<strong>{$lenguaje.estandarcalidadaguas_buscar_titulo}</strong>                       
                </h3>
            </div>
            <div class="panel-body">                          
                <div class="form-group ">
                    <div class="col-xs-3">
                        <input class="form-control" placeholder="{$lenguaje.text_buscar_estadoeca}"  name="palabra" id="palabra">                        
                    </div>
                    <button class=" btn btn-primary" type="button" id="buscar"  ><i class="glyphicon glyphicon-search"></i></button>
                </div>
                <div style="margin: 15px 25px">
                    <h4 class="panel-title"> <b>{$lenguaje.estandarcalidadaguas_buscar_tabla_titulo}</b></h4>
                    <div id="listaregistros">
                        {if isset($estandaraguas) && count($estandaraguas)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estadoeca}</th>
                                        <th style=" text-align: center">{$lenguaje.label_variable}</th>
                                        <th style=" text-align: center">{$lenguaje.label_Signo}</th>
                                        <th style=" text-align: center">{$lenguaje.label_valor_min}</th>
                                        <th style=" text-align: center">{$lenguaje.label_valor_max}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estado_eca}</th>
                                         <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$estandaraguas item=estandar}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            
                                            <td>{$estandar.Sue_Nombre}</td>
                                            <td>{$estandar.Var_Nombre}</td>
                                            <td>{$estandar.eca_signo}</td>
                                            <td>{$estandar.eca_minimo}</td>
                                            <td>{$estandar.eca_maximo}</td>
                                            <td>{$estandar.ese_nombre}</td>
                                            <td style=" text-align: center">
                                                {if $estandar.eca_estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $estandar.eca_estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_estandarcalidadagua")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/estandarcalidadagua/editar/{$estandar.eca_idEstandarCalidadAmbientalAgua}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_estandarcalidadagua")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-estandarcalidadagua" title="{$lenguaje.label_cambiar_estado}" idestandarcalidadagua="{$estandar.eca_idEstandarCalidadAmbientalAgua}" estado="{if $estandar.eca_estado==0}1{else}0{/if}"> </a>      
                                                {/if}{if $_acl->permiso("eliminar_estandarcalidadagua")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-estandarcalidadagua" title="{$lenguaje.label_eliminar}" idestandarcalidadagua="{$estandar.eca_idEstandarCalidadAmbientalAgua}"> </a>
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