<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.ponderacionicas_label_titulo}</h4>
    </div>
    {if $_acl->permiso("editar_ponderacionica")}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<strong>{$lenguaje.ponderacionicas_editar_titulo}</strong></h3>
            </div>
            <div class="panel-body" style=" margin: 15px">
                <div class="panel-body">
                    <div id="editarRegistro">
                        <div style="width: 90%; margin: 0px auto">                        
                            <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                                <!--                            <input type="hidden" value="1" name="enviar" />-->                           
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_variable_editar} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($variables) && count($variables)}
                                            <select class="form-control" id="selVariable" name="selVariable">
                                                <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                {foreach from=$variables item=v}
                                                    <option value="{$v.Var_IdVariable}" {if $v.Var_IdVariable == $datos.Var_IdVariable}selected="selected"{/if}>{$v.Var_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{$lenguaje.label_peso_editar} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="peso" type="text"  name="peso" value="{$datos.Poi_Peso}" placeholder="{$lenguaje.label_peso_nuevo}" required=""/>
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_ica_editar} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($icas) && count($icas)}
                                            <select class="form-control" id="selIca" name="selIca">
                                                <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                {foreach from=$icas item=i}
                                                    <option value="{$i.Ica_IdIca}" {if $i.Ica_IdIca == $datos.Ica_IdIca}selected="selected"{/if}>{$i.Ica_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_estado_editar} : </label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="selEstado" name="selEstado">
                                            <option value="0" {if $datos.Poi_Estado == 0}selected="selected"{/if}>Inactivo</option>
                                            <option value="1" {if $datos.Poi_Estado == 1}selected="selected"{/if}>Activo</option>
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

</div>