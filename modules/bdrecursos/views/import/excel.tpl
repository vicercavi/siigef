<div class="container" style="margin:10px auto;">
    <div class="row">
        <div class="col-md-12">
            <h2 class="tit-pagina-principal" class="titulo-view" align="center">Cargar Archivo</h2>
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
            <div class="panel panel-default">
                <div class="panel-heading"><strong> CARGAR ARCHIVO {if $tipo_estandar==2}- VARIABLES{/if}</strong></div>
                <div class="panel-body">  
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#excel" aria-controls="excel" role="tab" data-toggle="tab">Archivo Excel</a>
                            </li>
                            <li role="presentation">
                                <a href="#txt" aria-controls="txt" role="tab" data-toggle="tab">Archivo de Texto</a>
                            </li>    
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="excel">
                                <div style="margin:10px auto;" align="center">
                                    <form  action="../excel/registrar/" method="post" data-toggle="validator" class="form-horizontal" role="form" enctype="multipart/form-data" id="subir_archivo">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input type="file" name="archivo" id="archivo">
                                                    {if $estandar==3}
                                            </div>
                                            <div class="col-md-12" style="margin:30px auto">    
                                                <input type="file" name="archivos[]" id="archivos" multiple="multiple">
                                                {/if}
                                            </div>
                                        </div>
                                        <button type="submit" id="btnEnviar" name="btnEnviar" class="btn btn-success">CARGAR ARCHIVO</button>
                                        <input type="hidden" value="1" name="registrar" />
                                        <input type="hidden" value="0" name="data" />
                                    </form>
                                </div>
                            </div>    
                            <div role="tabpanel" class="tab-pane" id="txt">
                                <div style="margin:10px auto;" align="center">
                                    <form action="../txt/registrar/" method="post" enctype="multipart/form-data" class="form-horizontal" data-toggle="validator" role="form" id="subir_archivo">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input type="file" name="archivo" id="archivo">
                                                {if $estandar==3}
                                                </div>
                                                <div class="col-md-12" style="margin:30px auto">
                                                <input type="file" name="archivos[]" id="archivos" multiple="multiple">
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="checkbox-inline">
                                                <input type="radio" id="coma" value="," name="separador" checked> Separador Coma
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="radio" id="tabulacion" name="separador" value="\t"> Separador Tabulacion
                                            </label>
                                        </div>
                                        <div class="row" style="margin:10px auto;">
                                            <button type="submit" id="btnEnviar" class="btn btn-success">Cargar archivo</button>                       
                                        </div>
                                        <input type="hidden" value="0" name="data" />
                                    </form>
                                </div>    
                            </div>    
                      </div>
                    </div>
                </div> 
            </div>
            {if $tipo_estandar==2}  
                <div class="panel panel-default">
                    <div class="panel-heading"><strong> CARGAR ARCHIVO {if $tipo_estandar==2}- DATA{/if}</strong></div>
                    <div class="panel-body">  
                        <div role="tabpanel">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#excel2" aria-controls="excel" role="tab" data-toggle="tab">Archivo Excel</a>
                                </li>
                                <li role="presentation">
                                    <a href="#txt2" aria-controls="txt" role="tab" data-toggle="tab">Archivo de Texto</a>
                                </li>    
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="excel2">
                                    <div style="margin:10px auto;" align="center">
                                        <form  action="../excel/registrar/" method="post" data-toggle="validator" class="form-horizontal" role="form" enctype="multipart/form-data" id="subir_archivo">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input type="file" name="archivo" id="archivo">
                                                        {if $estandar==3}
                                                </div>
                                                <div class="col-md-12" style="margin:30px auto">    
                                                    <input type="file" name="archivos[]" id="archivos" multiple="multiple">
                                                    {/if}
                                                </div>
                                            </div>
                                            <button type="submit" id="btnEnviar" name="btnEnviar2" class="btn btn-success">CARGAR ARCHIVO</button>
                                            <input type="hidden" value="1" name="registrar" />
                                            <input type="hidden" value="1" name="data" />
                                        </form>
                                    </div>
                                </div>    
                                <div role="tabpanel" class="tab-pane" id="txt2">
                                    <div style="margin:10px auto;" align="center">
                                        <form action="../txt/registrar/" method="post" enctype="multipart/form-data" class="form-horizontal" data-toggle="validator" role="form" id="subir_archivo">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input type="file" name="archivo" id="archivo">
                                                    {if $estandar==3}
                                                    </div>
                                                    <div class="col-md-12" style="margin:30px auto">
                                                    <input type="file" name="archivos[]" id="archivos" multiple="multiple">
                                                    {/if}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="checkbox-inline">
                                                    <input type="radio" id="coma" value="," name="separador" checked> Separador Coma
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="radio" id="tabulacion" name="separador" value="\t"> Separador Tabulacion
                                                </label>
                                            </div>
                                            <div class="row" style="margin:10px auto;">
                                                <button type="submit" id="btnEnviar" name="btnEnviar2" class="btn btn-success">Cargar archivo</button>
                                            </div>
                                            <input type="hidden" value="1" name="registrar" />
                                            <input type="hidden" value="1" name="data" />
                                        </form>
                                    </div>    
                                </div>    
                          </div>
                        </div>
                    </div> 
                </div>
            {/if}      
        </div>           
    </div>    
</div>
