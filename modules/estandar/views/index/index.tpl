<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje["titulo_estandar"]}</h4>
    </div>
    {if $_acl->permiso("agregar_estandar")}
        <div class="jsoftCollap">
            <div class="panel panel-default jsoftCollap">
                <div class="panel-heading ">
                    <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed"><i style="float:right"class="fa fa-ellipsis-v"></i><i class="fa fa-database "></i>&nbsp;&nbsp;<strong>{$lenguaje["tiutlo_nuevo_estandar"]}</strong></h3>
                </div>
                <div style="height: 0px;" aria-expanded="false" id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div id="nuevoRegistro">
                            <div style="width: 90%; margin: 0px auto">                        
                                <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                                    <div class="form-group">                                    
                                        <label class="col-lg-3 control-label">{$lenguaje["label_nombre"]} (*): </label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id ="nombre" name='nombre' type="text" pattern="([a-zA-Z][\sa-zA-Z]+[a-zA-Z])" name="nombre" value="{$datos.nombre|default:""}" placeholder="{$lenguaje["label_nombre"]}" data-error="* {$lenguaje["span_data_error_nombre"]}" required=""/>
                                            <span class="help-block with-errors"></span>
                                        </div>
                                    </div>                                
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" >{$lenguaje["label_descripcion"]} : </label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id ="descripcion" type="text"  name="descripcion" value="{$datos.apellidos|default:""}" placeholder="{$lenguaje["label_descripcion"]}" data-error="* {$lenguaje["span_data_error_descripcion"]}"/>
                                            <span class="help-block with-errors"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label" >Tipo (*): </label>
                                        <div class="col-lg-8">
                                            <label class="radio-inline"><input type="radio" name="tipo" checked="" value="1">Default</label>
                                            <label class="radio-inline"><input type="radio" name="tipo" value="2">Investigación</label>
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
        </div>
    {/if}              
    <div style=" margin: 15px auto">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;<strong>{$lenguaje["tiutlo_buscar_estandar"]}</strong>                       
                </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 "> 
                        <div class="col-md-4 pull-right">
                            <div class="input-group">
                                <input id="palabra" type="text" class="form-control"  placeholder="{$lenguaje["texto_buscar_estandar"]}"/>                     
                                <span class="input-group-btn">
                                    <button id="buscar" class="btn btn-success" type="button">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>                                
                <div style="margin: 15px 25px">
                    <h4 class="panel-title"> <b>{$lenguaje["tiutlo_lista_estandar"]}</b></h4>
                    <div id="listaregistros">
                        {if isset($datos) && count($datos)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr>
                                        <th style=" text-align: center">#</th>
                                        <th style=" text-align: center">{$lenguaje["label_nombre"]}</th>
                                        <th style=" text-align: center">{$lenguaje["label_nombre_tabla"]}</th>
                                        <th style=" text-align: center">{$lenguaje["label_descripcion"]}</th>
                                        {if $_acl->permiso("editar_estandar")}
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                        {/if}
                                    </tr>
                                    {foreach from=$datos item=us}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$us.Esr_Nombre}</td>
                                            <td>{$us.Esr_NombreTabla}</td>
                                            <td>{$us.Esr_Descripcion}</td>
                                            {if $_acl->permiso("editar_estandar")}
                                            <td>
                                                <a class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="{$lenguaje["label_editar"]}" href="{$_layoutParams.root}estandar/index/editarEstandar/{$us.Esr_IdEstandarRecurso}" target="_blank"></a>
                                                <a class="btn btn-default btn-sm glyphicon glyphicon-trash eliminarEstandar" title="{$lenguaje["label_eliminar"]}" Esr_IdEstandarRecurso = "{$us.Esr_IdEstandarRecurso}" Esr_NombreTabla = "{$us.Esr_NombreTabla}" ></a>
                                            </td>
                                            {/if}
                                        </tr>
                                    {/foreach}
                                </table>
                            </div>     
                            <div class="panel-footer">
                                {$paginacion|default:""}
                            </div>      
                        {else}
                            {$lenguaje.no_registros}
                        {/if}  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>