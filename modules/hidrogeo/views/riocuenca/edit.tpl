<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.riocuenca_label_titulo}</h4>
    </div>
    {if $_acl->permiso("editar_riocuenca")}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<strong>{$lenguaje.riocuencas_editar_titulo}</strong></h3>
            </div>
            <div class="panel-body" style=" margin: 15px">
                <div class="panel-body">
                    <div id="editarRegistro">
                        <div style="width: 90%; margin: 0px auto">                        
                            <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                                <!--                            <input type="hidden" value="1" name="enviar" />-->                           
                                <div class="form-group" hidden="">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_nombre_editar} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="nombre" name="nombre" type="text" value="{$datos.Ric_Nombre}" placeholder="{$lenguaje.label_nombre}"/>
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_rio_editar} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($rios) && count($rios)}
                                            <select class="form-control" id="selRio" name="selRio" required="">
                                                <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                {foreach from=$rios item=r}
                                                    <option value="{$r.Rio_IdRio}" {if $r.Rio_IdRio == $datos.Rio_IdRio}selected="selected"{/if}>{$r.Rio_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_subcuenca_editar} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($subcuencas) && count($subcuencas)}
                                            <select class="form-control" id="selSubcuenca" name="selSubcuenca">
                                                <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                {foreach from=$subcuencas item=s}
                                                    <option value="{$s.Suc_IdSubcuenca}" {if $s.Suc_IdSubcuenca == $datos.Suc_IdSubcuenca}selected="selected"{/if}>{$s.Suc_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_cuenca_editar} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($cuencas) && count($cuencas)}
                                            <select class="form-control" id="selCuenca" name="selCuenca">
                                                <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                {foreach from=$cuencas item=c}
                                                    <option value="{$c.Cue_IdCuenca}" {if $c.Cue_IdCuenca == $datos.Cue_IdCuenca}selected="selected"{/if}>{$c.Cue_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_estado_editar} : </label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="selEstado" name="selEstado">
                                            <option value="0" {if $datos.Ric_Estado == 0}selected="selected"{/if}>Inactivo</option>
                                            <option value="1" {if $datos.Ric_Estado == 1}selected="selected"{/if}>Activo</option>
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