<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.ubigeos_label_titulo}</h4>
    </div>
    {if $_acl->permiso("editar_ubigeo")}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<strong>{$lenguaje.ubigeos_editar_titulo}</strong></h3>
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
                                {if  isset($denominaciones[0])}
                                    <div class="form-group">                                 
                                        <label class="col-lg-3 control-label">{$denominaciones[0]['Det_Nombre']} : </label>
                                        <div class="col-lg-8">

                                            <select class="form-control" id="selTerritorio1" name="selTerritorio1" required="">
                                                <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                {foreach from=$territorios1 item=t}
                                                    <option value="{$t.Ter_IdTerritorio}" {if $t.Ter_IdTerritorio==$datos.Ter_IdTerritorio1}selected{/if}>{$t.Ter_Nombre}</option>    
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
                                                <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                {foreach from=$territorios2 item=t}
                                                     <option value="{$t.Ter_IdTerritorio}" {if $t.Ter_IdTerritorio==$datos.Ter_IdTerritorio2}selected{/if}>{$t.Ter_Nombre}</option>    
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
                                                <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                {foreach from=$territorios3 item=t}
                                                    <option value="{$t.Ter_IdTerritorio}" {if $t.Ter_IdTerritorio==$datos.Ter_IdTerritorio3}selected{/if}>{$t.Ter_Nombre}</option>    
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
                                                <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                {foreach from=$territorios4 item=t}
                                                    <option value="{$t.Ter_IdTerritorio}" {if $t.Ter_IdTerritorio==$datos.Ter_IdTerritorio4}selected{/if}>{$t.Ter_Nombre}</option>    
                                                {/foreach}
                                            </select>

                                        </div>
                                    </div>
                                {/if}
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_estado_editar} : </label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="selEstado" name="selEstado">
                                            <option value="0" {if $datos.Ubi_Estado == 0}selected="selected"{/if}>Inactivo</option>
                                            <option value="1" {if $datos.Ubi_Estado == 1}selected="selected"{/if}>Activo</option>
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