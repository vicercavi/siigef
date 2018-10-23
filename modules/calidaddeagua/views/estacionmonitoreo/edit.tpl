<br/>
<br/>

<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.estacionmonitoreo_label_titulo}</h4>
    </div>
    {if $_acl->permiso("editar_estacionmonitoreo")}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<strong>{$lenguaje.estacionmonitoreos_editar_titulo}</strong></h3>
            </div>
            <div class="panel-body" style=" margin: 15px">
                <div class="panel-body">
                    <div id="editarRegistro">
                        <div style="width: 90%; margin: 0px auto">                        
                            <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                                <!--                            <input type="hidden" value="1" name="enviar" />-->                           


                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_nombre} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="nombre" type="text"  name="nombre" value="{$datos.Esm_Nombre}" placeholder="{$lenguaje.label_nombre}" required=""/>
                                    </div>
                                </div>                          



                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_latitud} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="latitud" type="text"  name="latitud" value="{$datos.Esm_Latitud}" placeholder="{$lenguaje.label_latitud}" required=""/>
                                    </div>
                                </div>


                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_longitud} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="longitud" type="text"  name="longitud" value="{$datos.Esm_Longitud}" placeholder="{$lenguaje.label_longitud}" required=""/>
                                    </div>
                                </div>


                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_referencia} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="referencia" type="text"  name="referencia" value="{$datos.Esm_Referencia}" placeholder="{$lenguaje.label_referencia}" required=""/>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_altitud} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="altitud" type="text"  name="altitud" value="{$datos.Esm_Altitud}" placeholder="{$lenguaje.label_altitud}" required=""/>
                                    </div>
                                </div>

                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_nombre_rio} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($riocuenca) && count($riocuenca)}

                                            <select class="form-control" id="selrio" name="selrio">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$riocuenca item=c}
                                                    <option value="{$c.Ric_IdRioCuenca}" {if $c.Ric_IdRioCuenca == $datos.Ric_IdRioCuenca}selected="selected"{/if}>{$c.rio}</option>    
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
                                                    <option value="{$c.Tie_IdTipoEstacion}" {if $c.Tie_IdTipoEstacion == $datos.Tie_IdTipoEstacion}selected="selected"{/if}>{$c.Tie_Nombre}</option>    
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
                                                    <option value="{$ub.Ubi_IdUbigeo}"
                                                    {if $ub.Ubi_IdUbigeo == $datos.Ubi_IdUbigeo}selected="selected"{/if}
                                                    >{$ub.Pai_Nombre}|{$ub.t1}|{$ub.t2}|{$ub.t3}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>

                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_estado_editar} : </label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="selEstado" name="selEstado">
                                            <option value="0" {if $datos.Esm_Estado == 0}selected="selected"{/if}>Inactivo</option>
                                            <option value="1" {if $datos.Esm_Estado == 1}selected="selected"{/if}>Activo</option>
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