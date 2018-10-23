<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.estacionmonitoreo_label_titulo}</h4>
    </div>
    {if $_acl->permiso("agregar_estacionmonitoreo")}
        <div class="panel panel-default">
            <div class="panel-heading jsoftCollap">
                <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed"><i style="float:right"class="fa fa-ellipsis-v"></i><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<strong>{$lenguaje.estacionmonitoreos_nuevo_titulo}</strong></h3>
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
                                        <input class="form-control" id ="nombre" type="text"  name="nombre" value="" placeholder="{$lenguaje.label_nombre}" required=""/>
                                    </div>
                                </div>
                                    
                                 <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_latitud} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="latitud" type="text"  name="latitud" value="" placeholder="{$lenguaje.label_latitud}" required=""/>
                                    </div>
                                </div>
                                    
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_longitud} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="longitud" type="text"  name="longitud" value="" placeholder="{$lenguaje.label_longitud}" required=""/>
                                    </div>
                                </div> 
                                 
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_referencia} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="referencia" type="text"  name="referencia" value="" placeholder="{$lenguaje.label_referencia}" required=""/>
                                    </div>
                                </div>
                                    
                                    
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_altitud} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="altitud" type="text"  name="altitud" value="" placeholder="{$lenguaje.label_altitud}" required=""/>
                                    </div>
                                </div>
                                        
                               
                                 <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_nombre_rio} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($riocuenca) && count($riocuenca)}
                                            
                                            <select class="form-control" id="selrio" name="selrio">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$riocuenca item=c}
                                                    <option value="{$c.Ric_IdRioCuenca}">{$c.rio}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>    
                                    
                                    
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_tipo_estacion} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($tipoestacion) && count($tipoestacion)}
                                            
                                            <select class="form-control" id="seltipo" name="seltipo">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$tipoestacion item=c}
                                                    <option value="{$c.Tie_IdTipoEstacion}">{$c.Tie_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div> 
                                    
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Ubigeo</label>
                                    <div class="col-lg-8">   
                                        {if  isset($ubigeos)}
                                            <select class="form-control" id="selUbigeo" name="selUbigeo" required="">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$ubigeos item=ub}
                                                    <option value="{$ub.Ubi_IdUbigeo}">{$ub.Pai_Nombre}|{$ub.t1}|{$ub.t2}|{$ub.t3}</option>    
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
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;<strong>{$lenguaje.estacionmonitoreos_buscar_titulo}</strong>                       
                </h3>
            </div>
            <div class="panel-body">                          
                <div class="form-group ">
                    <div class="col-xs-3">
                        <input class="form-control" placeholder="{$lenguaje.text_buscar_estacionmonitoreo}"  name="palabra" id="palabra">                        
                    </div>
                    <button class=" btn btn-primary" type="button" id="buscar"  ><i class="glyphicon glyphicon-search"></i></button>
                </div>
                <div style="margin: 15px 25px">
                    <h4 class="panel-title"> <b>{$lenguaje.estacionmonitoreos_buscar_tabla_titulo}</b></h4>
                    <div id="listaregistros">
                        {if isset($estacionmonitoreos) && count($estacionmonitoreos)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_nombre_1}</th>
                                        <th style=" text-align: center">{$lenguaje.label_latitud}</th>
                                        <th style=" text-align: center">{$lenguaje.label_longitud}</th>
                                        <th style=" text-align: center">{$lenguaje.label_referencia}</th>
                                        <th style=" text-align: center">{$lenguaje.label_altitud}</th>
                                        <th style=" text-align: center">{$lenguaje.label_nombre_rio}</th>
                                        <th style=" text-align: center">{$lenguaje.label_tipo_estacion}</th>
                                        <th style=" text-align: center">{$lenguaje.label_municipio}</th>
                                        <th style=" text-align: center">{$lenguaje.label_departamento}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$estacionmonitoreos item=estacionmonitoreo}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$estacionmonitoreo.Esm_Nombre}</td>
                                            <td>{$estacionmonitoreo.Esm_Latitud}</td>
                                            <td>{$estacionmonitoreo.Esm_Longitud}</td>
                                            <td>{$estacionmonitoreo.Esm_Referencia}</td>
                                            <td>{$estacionmonitoreo.Esm_Altitud}</td>
                                            <td>{$estacionmonitoreo.Ric_Nombre}</td>
                                            <td>{$estacionmonitoreo.Tie_Nombre}</td>
                                            <td>{$estacionmonitoreo.Mpd_Nombre}</td>
                                            <td>{$estacionmonitoreo.Esd_Nombre}</td>
                                            <td style=" text-align: center">
                                                {if $estacionmonitoreo.Esm_Estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $estacionmonitoreo.Esm_Estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_estacionmonitoreo")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}calidaddeagua/estacionmonitoreo/editar/{$estacionmonitoreo.Esm_IdEstacionMonitoreo}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_estacionmonitoreo")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-estacionmonitoreo" title="{$lenguaje.label_cambiar_estado}" idestacionmonitoreo="{$estacionmonitoreo.Esm_IdEstacionMonitoreo}" estado="{if $estacionmonitoreo.Esm_Estado==0}1{else}0{/if}"> </a>      
                                                {/if}{if $_acl->permiso("eliminar_estacionmonitoreo")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-estacionmonitoreo" title="{$lenguaje.label_eliminar}" idestacionmonitoreo="{$estacionmonitoreo.Esm_IdEstacionMonitoreo}"> </a>
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