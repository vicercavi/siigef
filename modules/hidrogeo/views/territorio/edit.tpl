<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.territorios_label_titulo}</h4>
    </div>
    {if $_acl->permiso("editar_territorio")}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<strong>{$lenguaje.territorios_editar_titulo}</strong></h3>
            </div>
            <div class="panel-body" style=" margin: 15px">
                <div class="panel-body">
                    <div id="editarregistro">
                        <div style="width: 90%; margin: 0px auto">                        
                            <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                                <!--                            <input type="hidden" value="1" name="enviar" />-->
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_pais_editar} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($paises)}
                                            <select class="form-control" id="selPais" name="selPais" required="">
                                                <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                {foreach from=$paises item=p}
                                                    <option value="{$p.Pai_IdPais}" {if $p.Pai_IdPais == $datos.Pai_IdPais}selected{/if}>{$p.Pai_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_denominacion_editar} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($denominaciones)}
                                            <select class="form-control" id="selDenominacion" name="selDenominacion" required="">
                                                <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                {foreach from=$denominaciones item=d}
                                                    <option value="{$d.Det_IdDenomTerrit}" {if $d.Det_IdDenomTerrit==$datos.Det_IdDenomTerrit}selected{/if}>{$d.Det_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{$lenguaje.label_nombre_editar} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="nombre" name="nombre" type="text" value="{$datos.Ter_Nombre}" placeholder="{$lenguaje.label_nombre_editar}" required=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">{$lenguaje.label_siglas_editar} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="siglas" type="text"  name="siglas" value="{$datos.Ter_Siglas}" placeholder="{$lenguaje.label_siglas_editar}"/>
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_estado_editar} : </label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="selEstado" name="selEstado">
                                            <option value="0" {if $datos.Ter_Estado == 0}selected="selected"{/if}>Inactivo</option>
                                            <option value="1" {if $datos.Ter_Estado == 1}selected="selected"{/if}>Activo</option>
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