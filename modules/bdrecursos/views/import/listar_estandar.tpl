<div class="container" style="margin:10px auto;">
    <div class="row">
        <div class="col-md-12">
            <h2 class="tit-pagina-principal" align="center">Cargar Archivo</h2>
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
                <div class="panel-heading">Cargar Archivo</div>
                <div class="panel-body">
                    <div id="ficha_estandar">    
                        <form action="../../registrar/txt" method="post" data-toggle="validator" class="form-horizontal" role="form" id="lista_estandar">
                            <table class="table">
                            	<thead>
                                  <tr>
                                    <th>Campos del Estandar</th>
                                    <th style="width:1%"></th>
                                    <th style="width:50%">Campos Vinculados</th>        
                                  </tr>
                                </thead>    
                                <tbody>
                                    {foreach item=datos from=$FichaEstandar}
                                        <tr>
                                            <td>{$datos.Fie_CampoFicha}</td>
                                            <td>:</td>
                                            <td>
                                                <select name="{$datos.Fie_ColumnaTabla}" id="{$datos.Fie_ColumnaTabla}">
                                                    <option value="" selected="selected">Selecionar</option>
                                                    {foreach $encabezado as $k => $v}
                                    	               <option value="{$k}">{$v}</option>{/foreach}
                                                </select>
                                            </td>
                                        </tr>              
                                    {/foreach} 
                                </tbody>
                            </table>
                            <center>
                                <span class="input-group-btn">
                                    <button type="submit" id="btnEnviar" class="btn btn-success">Registrar Datos</button>
                                </span>
                            </center>
                        </form>
                    </div>
                </div> 
            </div>
        </div>     
	</div>    
</div>

