<div class="container-fluid" >
    <div class="row">
        <div class="col-md-12">
            <h3 class="titulo-view">Editor de {$nombre_tabla}</h3>     
        </div>
        <div class="col-md-3">     
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <strong>{$lenguaje["label_recurso_bdrecursos"]}</strong>
                        </h4>
                    </div>               
                    <div class="panel-body">
                        <table class="table table-user-information">
                            <tbody>                           
                                <tr>
                                    <td>{$lenguaje["label_nombre_bdrecursos"]}:</td>
                                    <td>{$recurso.Rec_Nombre}</td>
                                </tr>
                                <tr>
                                    <td>{$lenguaje["label_tipo_bdrecursos"]}</td>
                                    <td>{$recurso.Tir_Nombre}</td>
                                </tr>
                                <tr>
                                    <td>{$lenguaje["label_estandar_bdrecursos"]}</td>
                                    <td>{$recurso.Esr_Nombre}</td> 
                                </tr>                                
                                <tr>
                                    <td>{$lenguaje["label_fuente_bdrecursos"]}</td>
                                    <td>{$recurso.Rec_Fuente}</td>
                                </tr>
                                <tr>
                                    <td>{$lenguaje["label_origen_bdrecursos"]}</td>
                                    <td>{$recurso.Rec_Origen}</td>
                                </tr>
                                <tr>
                                    <td>{$lenguaje["registros_bdrecursos"]}</td>
                                    <td>{$recurso.Rec_CantidadRegistros}</td>
                                </tr>
                                <tr>
                                    <td>{$lenguaje["herramienta_utilizada_bdrecursos"]}</td>
                                    <td>
                                        {if isset($recurso.herramientas)}
                                            <ul>
                                                {foreach item=herramienta from=$recurso.herramientas}
                                                    <li>
                                                        {$herramienta.Her_Nombre}
                                                    </li>
                                                {/foreach}
                                            </ul>
                                        {/if}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{$lenguaje["registro_bdrecursos"]}</td>
                                    <td>{$recurso.Rec_FechaRegistro|date_format:"%d/%m/%y"}</td>
                                </tr>
                                <tr>
                                    <td>{$lenguaje["modificacion_bdrecursos"]}</td>
                                    <td>{$recurso.Rec_UltimaModificacion|date_format:"%d/%m/%y"}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">  
            <div id='gestion_idiomas'>
                <div class="panel panel-default">
                    <div class="panel-heading ">
                        <h3 class="panel-title "><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<strong>EDITAR REGISTRO</strong></h3>
                    </div>
                    <div style="width: 90%; margin: 0px auto">
                        <form class="form-horizontal" id="form1" name="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                            {if isset($fichaVariable) && count($fichaVariable)}
                                {foreach from=$lista_variable2 item=lv2}
                                    <div class="form-group">
                                        <label class="col-lg-5 control-label">
                                            {$lv2.$campo_etiqueta} :
                                        </label> 
                                        <div class="col-lg-7">
                                            <input type="text" name="{$lv2.$campo_nombre}" placeholder="{$lv2.$campo_tipo}" class="form-control" value="{$lista_data[0][$lv2[$campo_nombre]]}" />
                                        </div>                                                        
                                    </div>
                                {/foreach}
                            {/if}                     
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-1">
                                    <a class="btn btn-danger" href="{$_layoutParams.root}bdrecursos/registros/index/{$idrecurso}" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; Atras</a>
                                </div>
                                <div class="col-lg-offset-1 col-lg-1">
                                    <input type="hidden" value="{$tipo_estandar}" name="tipo_estandar" />
                                    <button class="btn btn-success" id="bt_editarRegistro" name="bt_editarRegistro" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; Actualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p><center>{$mensaje}</center></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

