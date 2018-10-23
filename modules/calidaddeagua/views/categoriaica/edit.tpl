<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.categoriaica_label_titulo}</h4>
    </div>
    {if $_acl->permiso("editar_categoriaica")}
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<strong>{$lenguaje.categoriaicas_editar_titulo}</strong></h3>
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
                                        <input class="form-control" id ="nombre" name="nombre" type="text" value="{$datos.Cai_Nombre}" placeholder="{$lenguaje.label_nombre_editar}" required=""/>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_descripcion_editar} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="descripcion" name="descripcion" type="text" value="{$datos.Cai_Descripcion}" placeholder="{$lenguaje.label_descripcion_editar}"/>
                                    </div>
                                </div>
                                <div class="form-group">

                                    <label class="col-lg-3 control-label">{$lenguaje.label_fuente_editar} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="fuente" name="fuente" type="text" value="{$datos.Cai_Fuente}" placeholder="{$lenguaje.label_fuente_editar}"/>
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_estado_editar} : </label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="selEstado" name="selEstado">
                                            <option value="0" {if $datos.Cai_Estado == 0}selected="selected"{/if}>Inactivo</option>
                                            <option value="1" {if $datos.Cai_Estado == 1}selected="selected"{/if}>Activo</option>
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