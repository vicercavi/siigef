<form method="post" class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2> Registro de datos desde JSON</h2>
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
                        <strong>JSON</strong> 
                    </h4>
                </div>               
                <div class="panel-body">
                    <div class="form-group">
                        <label for="tb_urlws">Url JSON</label>
                        <div class="form-group">
                            {if $tipo_estandar==2}
                                <label class="radio-inline"><input type="radio" name="r_tabla" value="1" checked="">Variable</label>
                                <label class="radio-inline"><input type="radio" name="r_tabla" value="2">Data</label>
                            {else}
                                <input type="hidden" name="r_tabla" value="0"></input>
                            {/if}
                        </div>                            
                        <div class="input-group">                            
                            <input type="url" class="form-control" id="tb_urljson" name="tb_urljson"  value="{$urljson|default}"
                                   placeholder="Introduce url del json">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="submit"id="bt_consultar_json" name="bt_consultar_json" >Consultar</button>
                            </span>
                            <input type="hidden" id="hd_url_json" value="{$urljson|default}">
                        </div>
                    </div>                    
                </div>
            </div>   
            {if isset($consulta)}
                <div id="resultado_json">                                  
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
                                            {if isset($fichaVariable)}
                                                {$i=0}
                                                {foreach item=datos from=$fichaVariable}
                                                    <tr>
                                                        <td>{$datos.$campo_nombre}</td>
                                                        <td>:</td>
                                                        <td>
                                                            <select name="{$datos.$campo_nombre}" id="{$datos.$campo_nombre}" required="">
                                                                <option value="s_" selected="selected">Selecionar</option>
                                                                {foreach from=$parametros key=key item=item} 
                                                                    <option value="{$item}">{$item}</option>
                                                                {/foreach}
                                                            </select>
                                                        </td>
                                                    </tr>   
                                                    {$i=$i+1}            
                                                {/foreach}
                                            {else}
                                                {if isset($fichaEstandar)}
                                                    {foreach item=datos from=$fichaEstandar}
                                                        <tr>
                                                            <td>{$datos.Fie_CampoFicha}</td>
                                                            <td>:</td>
                                                            <td>
                                                                <select name="{$datos.Fie_ColumnaTabla}" id="{$datos.Fie_ColumnaTabla}">
                                                                    <option value="s_" selected="selected">Selecionar</option>
                                                                    {foreach from=$parametros item=item} 
                                                                        <option value="{$item}">{$item}</option>
                                                                    {/foreach}                                                                         
                                                                </select>
                                                            </td>
                                                        </tr>              
                                                    {/foreach}
                                                {/if}
                                            {/if}
                                        </tbody>                                        
                                    </table>                                
                                    <div class="form-group">
                                        <center>
                                        <span class="input-group-btn">
                                            <button class="btn btn-success" type="submit" id="bt_registrar_json" name="bt_registrar_json" >Registrar Datos</button>
                                        </span>
                                        </center>
                                        <input type="hidden" id="hd_url_json" value="{$url_json|default}" name="url_json">
                                        <input type="hidden" value="{$r_tabla}" name="r_tabla">
                                    </div>
                                </form>
                            </div>            
                        </div>
                    </div>
                </div> 
            {/if}
        </div> 
    </div>
</form>