<form method="post" class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2> Registro de datos desde RSS</h2>
        </div>
        <div class="col-md-3">     
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <strong>Recurso</strong>
                        </h4>
                        <input type="hidden" id="hd_idrecurso" value="{$recurso.Rec_IdRecurso}">
                    </div>               
                    <div class="panel-body">
                        <table class="table table-user-information">
                            <tbody>                           
                                <tr>
                                    <td>Nombre:</td>
                                    <td>{$recurso.Rec_Nombre}</td>
                                </tr>
                                <tr>
                                    <td>Tipo</td>
                                    <td>{$recurso.Tir_Nombre}</td>
                                </tr>
                                <tr>
                                    <td>Estandar</td>
                                    <td>{$recurso.Esr_Nombre}</td>
                                </tr>                                
                                <tr>
                                    <td>Fuente</td>
                                    <td>{$recurso.Rec_Fuente}</td>
                                </tr>
                                <tr>
                                    <td>Origen</td>
                                    <td>{$recurso.Rec_Origen}</td>
                                </tr>
                                <tr>
                                    <td>Registros</td>
                                    <td>{$recurso.Rec_CantidadRegistros}</td>
                                </tr>
                                <tr>
                                    <td>Herramientas donde es utilizado</td>
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
                                    <td>Registro</td>
                                    <td>{$recurso.Rec_FechaRegistro|date_format:"%d/%m/%y"}</td>
                                </tr>
                                <tr>
                                    <td>Modificación</td>
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
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <strong>RSS</strong> 
                    </h4>
                </div>               
                <div class="panel-body">
                    <div class="form-group">
                        <label for="tb_urlws">Url RSS</label>
                        <div class="form-group">
                            {if $tipo_estandar==2}
                                <label class="radio-inline"><input type="radio" name="r_tabla" value="1" checked="">Variable</label>
                                <label class="radio-inline"><input type="radio" name="r_tabla" value="2">Data</label>
                            {else}
                                <input type="hidden" name="r_tabla" value="0"></input>
                            {/if}
                        </div>                            
                        <div class="input-group">                            
                            <input type="url" class="form-control" id="tb_urlrss" name="tb_urlrss"  value="{$urlrss|default}"
                                   placeholder="Introduce url del rss">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="submit"id="bt_consultar_rss" name="bt_consultar_rss" >Consultar</button>
                            </span>
                            <input type="hidden" id="hd_url_rss" value="{$urlrss|default}">
                        </div>
                    </div>
                    {if isset($funcion)}
                        <div class="form-group">
                            <label for="tb_nombre_ws">Nombre Web Service</label>   
                            <input id="tb_nombre_ws" type="text">
                        </div> 
                        <div class="form-group">
                            <label for="sp_funcion">Función Invocada:</label>   
                            <span id="sp_funcion">dime</span>
                        </div> 
                        <div class="form-group">
                            <label>Parametros</label>   
                            <ul>
                                <li>Li</li>
                            </ul>
                        </div>  
                        <div class="form-group">
                            <label for="tb_fuente_ws">Fuente</label>   
                            <input id="tb_fuente_ws" type="text">
                        </div> 
                        <div class="form-group">
                            <label for="tb_descripcion_ws">Descripción</label>   
                            <input id="tb_descripcion_ws" type="text">
                        </div>                    
                    {/if}
                </div>
            </div>   
            <div id="resultado_ws">
                {if isset($etiquetas)}                    
                    <div class="panel panel-default">
                        <div class="panel-body">                            
                            <div id="listar_estandar">    
                                <form action="../registrar/1" method="post" data-toggle="validator" class="form-horizontal" role="form" id="lista_estandar">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th>Campos del Estandar</th>
                                            <th style="width:1%"></th>
                                            <th style="width:50%">Campos Vinculados</th>        
                                          </tr>
                                        </thead>    
                                        <tbody>
                                            {if isset($fichaEstandar)}
                                                {foreach item=datos from=$fichaEstandar}
                                                    <tr>
                                                        <td>{$datos.Fie_CampoFicha}</td>
                                                        <td>:</td>
                                                        <td>
                                                            <select name="{$datos.Fie_ColumnaTabla}" id="{$datos.Fie_ColumnaTabla}">
                                                                <option value="s_" selected="selected">Selecionar</option>
                                                                {if isset($s_titulo) && $s_titulo==1}
                                                                    <option value="s_titulo">Título</option>
                                                                {/if}
                                                                {if isset($s_categoria) && $s_categoria==1}
                                                                    <option value="s_categoria">Categoría</option>
                                                                {/if}
                                                                {if isset($s_descripcion) && $s_descripcion==1}
                                                                    <option value="s_descripcion">Descripción</option>
                                                                {/if}
                                                                {if isset($s_contenido) && $s_contenido==1}
                                                                    <option value="s_contenido">Contenido</option>
                                                                {/if}
                                                                {if isset($s_autor) && $s_autor==1}
                                                                    <option value="s_autor">Autor</option>
                                                                {/if}
                                                                {if isset($s_contribuyente) && $s_contribuyente==1}
                                                                    <option value="s_contribuyente">Contribuyente</option>
                                                                {/if}
                                                                {if isset($s_derechos_autor) && $s_derechos_autor==1}
                                                                    <option value="s_derechos_autor">Derechos de autor</option>
                                                                {/if}
                                                                {if isset($s_link) && $s_link==1}
                                                                    <option value="s_link">Link</option>
                                                                {/if}
                                                                {if isset($s_fecha) && $s_fecha==1}
                                                                    <option value="s_fecha">Fecha</option>
                                                                {/if}                                                                         
                                                            </select>
                                                        </td>
                                                    </tr>              
                                                {/foreach}
                                            {/if}
                                            {if isset($fichaVariable)}
                                                {$i=0}
                                                {foreach item=datos from=$fichaVariable}
                                                    <tr>
                                                        <td>{$datos.$campo_nombre}</td>
                                                        <td>:</td>
                                                        <td>
                                                            <select name="{$datos.$campo_nombre}" id="{$datos.$campo_nombre}" required="">
                                                                <option value="s_" selected="selected">Selecionar</option>
                                                                {if isset($s_titulo) && $s_titulo==1}
                                                                    <option value="s_titulo">Título</option>
                                                                {/if}
                                                                {if isset($s_categoria) && $s_categoria==1}
                                                                    <option value="s_categoria">Categoría</option>
                                                                {/if}
                                                                {if isset($s_descripcion) && $s_descripcion==1}
                                                                    <option value="s_descripcion">Descripción</option>
                                                                {/if}
                                                                {if isset($s_contenido) && $s_contenido==1}
                                                                    <option value="s_contenido">Contenido</option>
                                                                {/if}
                                                                {if isset($s_autor) && $s_autor==1}
                                                                    <option value="s_autor">Autor</option>
                                                                {/if}
                                                                {if isset($s_contribuyente) && $s_contribuyente==1}
                                                                    <option value="s_contribuyente">Contribuyente</option>
                                                                {/if}
                                                                {if isset($s_derechos_autor) && $s_derechos_autor==1}
                                                                    <option value="s_derechos_autor">Derechos de autor</option>
                                                                {/if}
                                                                {if isset($s_link) && $s_link==1}
                                                                    <option value="s_link">Link</option>
                                                                {/if}
                                                                {if isset($s_fecha) && $s_fecha==1}
                                                                    <option value="s_fecha">Fecha</option>
                                                                {/if}     
                                                            </select>
                                                        </td>
                                                    </tr>   
                                                    {$i=$i+1}            
                                                {/foreach}
                                            {/if}
                                        </tbody>
                                            
                                    </table>                                
                                    <div class="form-group">
                                        <center>
                                        <span class="input-group-btn">
                                            <button class="btn btn-success" type="submit" id="bt_registrar_rss" name="bt_registrar_rss" >Registrar Datos</button>
                                        </span>
                                        </center>
                                        <input type="hidden" id="hd_url_rss" value="{$url_rss|default}" name="url_rss">
                                        <input type="hidden" value="{$r_tabla}" name="r_tabla">
                                    </div>
                                </form>
                            </div>            
                        </div>
                    </div>
                {/if}
                {if isset($prueba)}
                    {include file=$prueba}
                {/if}
            </div> 
        </div> 
    </div>
</form>