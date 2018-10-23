<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.ubigeos_label_titulo}</h4>
    </div>
    {if $_acl->permiso("agregar_ubigeo")}

        <div class="panel panel-default">
            <div class="panel-heading jsoftCollap">
                <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed"><i style="float:right"class="fa fa-ellipsis-v"></i><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<strong>{$lenguaje.ubigeos_nuevo_titulo}</strong></h3>
            </div>
            <div style="height: 0px;" aria-expanded="false" id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id="nuevoregistro">
                        <div style="width: 90%; margin: 0px auto">                        
                            <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                                <!--                            <input type="hidden" value="1" name="enviar" />-->   
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_pais_nuevo} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($paises)}
                                            <select class="form-control" id="selPais" name="selPais" required="">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$paises item=p}
                                                    <option value="{$p.Pai_IdPais}" {if isset( $sl_pais) && $sl_pais==$p.Pai_IdPais}selected{/if}>{$p.Pai_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>
                                {if  isset($denominaciones[0])}
                                    <div class="form-group">                                 
                                        <label class="col-lg-3 control-label">{$denominaciones[0]['Det_Nombre']} : </label>
                                        <div class="col-lg-8">

                                            <select class="form-control" id="selTerritorio1" name="selTerritorio1" required="">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$territorios1 item=t}
                                                    <option value="{$t.Ter_IdTerritorio}" {if isset( $sl_territorio1) && $sl_territorio1==$t.Ter_IdTerritorio}selected{/if}>{$t.Ter_Nombre}</option>    
                                                {/foreach}
                                            </select>

                                        </div>
                                    </div>
                                {/if}
                                {if  isset($denominaciones[1])}
                                    <div class="form-group">                                 
                                        <label class="col-lg-3 control-label">{$denominaciones[1]['Det_Nombre']} : </label>
                                        <div class="col-lg-8">

                                            <select class="form-control" id="selTerritorio2" name="selTerritorio2" required="">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$territorios2 item=t}
                                                    <option value="{$t.Ter_IdTerritorio}" {if isset( $sl_territorio2) && $sl_territorio2==$t.Ter_IdTerritorio}selected{/if}>{$t.Ter_Nombre}</option>    
                                                {/foreach}
                                            </select>

                                        </div>
                                    </div>
                                {/if}
                                {if  isset($denominaciones[2])}
                                    <div class="form-group">                                 
                                        <label class="col-lg-3 control-label">{$denominaciones[2]['Det_Nombre']} : </label>
                                        <div class="col-lg-8">

                                            <select class="form-control" id="selTerritorio3" name="selTerritorio3" required="">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$territorios3 item=t}
                                                    <option value="{$t.Ter_IdTerritorio}" {if isset( $sl_territorio3) && $sl_territorio3==$t.Ter_IdTerritorio}selected{/if}>{$t.Ter_Nombre}</option>    
                                                {/foreach}
                                            </select>

                                        </div>
                                    </div>
                                {/if}
                                {if  isset($denominaciones[3])}
                                    <div class="form-group">                                 
                                        <label class="col-lg-3 control-label">{$denominaciones[3]['Det_Nombre']} : </label>
                                        <div class="col-lg-8">

                                            <select class="form-control" id="selTerritorio4" name="selTerritorio4" required="">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$territorios4 item=t}
                                                    <option value="{$t.Ter_IdTerritorio}" {if isset( $sl_territorio4) && $sl_territorio4==$t.Ter_IdTerritorio}selected{/if}>{$t.Ter_Nombre}</option>    
                                                {/foreach}
                                            </select>

                                        </div>
                                    </div>
                                {/if}
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
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;<strong>{$lenguaje.ubigeos_buscar_titulo}</strong>                       
                </h3>
            </div>
            <div class="panel-body">
                <div id="filtrobusqueda">
                    <div class="form-group ">
                        <div class="col-xs-3" >                        
                            {if isset($paises)}
                                <select class="form-control" id="buscarPais" name="buscarPais">
                                    <option value="">{$lenguaje.label_todos_paises}</option>
                                    {foreach from=$paises item=p}
                                        <option value="{$p.Pai_IdPais}">{$p.Pai_Nombre}</option>    
                                    {/foreach}
                                </select>
                            {/if}
                        </div>
                        <div class="col-xs-3">
                            <input class="form-control" placeholder="{$lenguaje.text_buscar_ubigeo}"  name="palabra" id="palabra">                        
                        </div>
                        <button class=" btn btn-primary" type="button" id="buscar"  ><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
                <div style="margin: 15px 25px">
                    <h4 class="panel-title"> <b>{$lenguaje.ubigeos_buscar_tabla_titulo}</b></h4>
                    <div id="listaregistros">
                        {if isset($ubigeos) && count($ubigeos)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_ubigeo}</th>
                                        <th style=" text-align: center"></th>
                                        <th style=" text-align: center"></th>
                                        <th style=" text-align: center"></th>
                                        <th style=" text-align: center"></th>
                                        <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$ubigeos item=ubigeo}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                             <td>{$ubigeo.Pai_Nombre}</td> 
                                            <td>{$ubigeo.t1}</td>
                                            <td>{$ubigeo.t2}</td>
                                            <td>{$ubigeo.t3}</td>
                                            <td>{$ubigeo.t4}</td>
                                           
                                            <td style=" text-align: center">
                                                {if $ubigeo.Ubi_Estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $ubigeo.Ubi_Estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_ubigeo")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/ubigeo/editar/{$ubigeo.Ubi_IdUbigeo}"></a>
                                                {/if}{if $_acl->permiso("habilitar_deshabilitar_ubigeo")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-ubigeo" title="{$lenguaje.label_cambiar_estado}" idubigeo="{$ubigeo.Ubi_IdUbigeo}" estado="{if $ubigeo.Ubi_Estado==0}1{else}0{/if}"> </a>      
                                                {/if}{if $_acl->permiso("eliminar_ubigeo")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-ubigeo" title="{$lenguaje.label_eliminar}" idubigeo="{$ubigeo.Ubi_IdUbigeo}"> </a>
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