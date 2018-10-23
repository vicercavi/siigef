<br/>
<br/>

<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.estandarcalidad_label_titulo}</h4>
    </div>
    {if $_acl->permiso("editar_estandarcalidadagua")}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<strong>{$lenguaje.estandarcalidadaguas_editar_titulo}</strong></h3>
            </div>
            <div class="panel-body" style=" margin: 15px">
                <div class="panel-body">
                    <div id="editarRegistro">
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
                                                   
                                                      <option value="{$c.Sue_IdSubcategoriaEca}" {if $c.Sue_IdSubcategoriaEca == $datos.sue_idSubcategoriaEca}selected="selected"{/if}>{$c.Sue_Nombre}</option> 
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div> 
                                
                                    
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_variable_estudio_nuevo} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($variablesestudio) && count($variablesestudio)}
                                            <select class="form-control" id="selvariabletipo" name="selvariable">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$variablesestudio item=c}
                                                   
                                                      <option value="{$c.Var_IdVariable}" {if $c.Var_IdVariable == $datos.Var_IdVariable}selected="selected"{/if}>{$c.Var_Nombre}</option> 
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div> 
                                
                                
                                
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_eca_signo} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="ecasigno" name="ecasigno" type="text" value="{$datos.eca_signo}" placeholder="{$lenguaje.label_eca_signo}" required=""/>
                                    </div>
                                </div>
                                    
                                    
                                    
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_valor_min} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="ecaminimo" name="ecaminimo" type="text" value="{$datos.eca_minimo}" placeholder="{$lenguaje.label_valor_min}" required=""/>
                                    </div>
                                </div>
                                    
                                                           <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_valor_max} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="ecamax" name="ecamax" type="text" value="{$datos.eca_maximo}" placeholder="{$lenguaje.label_valor_max}" required=""/>
                                    </div>
                                </div>
                                    
                                 <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_estadoeca_nuevo} : </label>
                                    <div class="col-lg-8">
                                        {if  isset($estadoeca) && count($estadoeca)}
                                            <select class="form-control" id="selestadoeca" name="selestadoeca">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$estadoeca item=c}
                                                   
                                                      <option value="{$c.ese_IdEstadoEca}" {if $c.ese_IdEstadoEca == $datos.ese_IdEstadoEca}selected="selected"{/if}>{$c.ese_nombre}</option> 
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div> 
                                
                                        
   
                       
                                    
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_estado_editar} : </label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="selEstado" name="selEstado">
                                            <option value="0" {if $datos.eca_estado == 0}selected="selected"{/if}>Inactivo</option>
                                            <option value="1" {if $datos.eca_estado == 1}selected="selected"{/if}>Activo</option>
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