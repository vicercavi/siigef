<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.rios_label_titulo}</h4>
    </div>
    {if $_acl->permiso("editar_rio")}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<strong>{$lenguaje.rios_editar_titulo}</strong></h3>
            </div>
            <div class="panel-body" style=" margin: 15px">
                <div class="panel-body">
                    <div id="editarRegistro">
                        <div style="width: 90%; margin: 0px auto">                        
                            <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                                <!--                            <input type="hidden" value="1" name="enviar" />-->                           
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_nombre_editar} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="nombre" name="nombre" type="text" value="{$datos.Rio_Nombre}" placeholder="{$lenguaje.label_nombre}" required=""/>
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_pais_editar} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($paises) && count($paises)}
                                            <select class="form-control" id="selPais" name="selPais" required>
                                                <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                {foreach from=$paises item=p}
                                                    <option value="{$p.Pai_IdPais}" {if $p.Pai_IdPais == $datos.Pai_IdPais}selected="selected"{/if}>{$p.Pai_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_tipo_agua_editar} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($tipos_agua) && count($tipos_agua)}
                                            <select class="form-control" id="selTipoAgua" name="selTipoAgua">
                                                <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                {foreach from=$tipos_agua item=t}
                                                    <option value="{$t.Tia_IdTipoAgua}" {if $t.Tia_IdTipoAgua == $datos.Tia_IdTipoAgua}selected="selected"{/if}>{$t.Tia_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_estado_editar} : </label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="selEstado" name="selEstado">
                                            <option value="0" {if $datos.Rio_Estado == 0}selected="selected"{/if}>Inactivo</option>
                                            <option value="1" {if $datos.Rio_Estado == 1}selected="selected"{/if}>Activo</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-8">
                                        <button class="btn btn-success" id="bt_guardar" name="bt_guardar" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; Actualizar</button>
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