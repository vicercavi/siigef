<br/>
<br/>

<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.estadoeca_label_titulo}</h4>
    </div>
    {if $_acl->permiso("editar_estadoeca")}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<strong>{$lenguaje.estadoecas_editar_titulo}</strong></h3>
            </div>
            <div class="panel-body" style=" margin: 15px">
                <div class="panel-body">
                    <div id="editarRegistro">
                        <div style="width: 90%; margin: 0px auto">                        
                            <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                                <!--                            <input type="hidden" value="1" name="enviar" />-->                           
                                
                              
                                                           
                                
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_referencia_editar} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="referencia" name="referencia" type="text" value="{$datos.ese_refencia}" placeholder="{$lenguaje.label_referencia_editar}" required=""/>
                                    </div>
                                </div>
                                    
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_nombre_editar} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="nombre" name="nombre" type="text" value="{$datos.ese_nombre}" placeholder="{$lenguaje.label_nombre_editar}" required=""/>
                                    </div>
                                </div>
                                    
                                    
   
                                                                                    
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_color_editar} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="color" name="color" type="text" value="{$datos.ese_color}" placeholder="{$lenguaje.label_color_editar}" required=""/>
                                    </div>
                                </div>
                   
                                    
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_estado_editar} : </label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="selEstado" name="selEstado">
                                            <option value="0" {if $datos.ese_estado == 0}selected="selected"{/if}>Inactivo</option>
                                            <option value="1" {if $datos.ese_estado == 1}selected="selected"{/if}>Activo</option>
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