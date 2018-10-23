<form method="post" class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2> Registro de datos desde Web Service</h2>
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
                        <strong>Web Service</strong> 
                    </h4>
                </div>               
                <div class="panel-body">
                    <div class="form-group">
                            {if $tipo_estandar==2}
                                <label class="radio-inline"><input type="radio" name="r_tabla" value="1" checked="">Variable</label>
                                <label class="radio-inline"><input type="radio" name="r_tabla" value="2">Data</label>
                            {else}
                                <input type="hidden" name="r_tabla" value="0"></input>
                            {/if}
                        </div> 
                    <div class="form-group">
                        <label for="tb_urlws">Url Web Service</label>                            
                        <div class="input-group">
                            <input type="url" class="form-control" id="tb_urlws" name="tb_urlws"  value="{$urlws|default}"
                                   placeholder="Introduce url de web service soap">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="submit"id="bt_consultarwsdl" name="bt_consultarwsdl" >Consultar</button>
                            </span>
                            <input type="hidden" id="hd_url_ws" value="{$urlws|default}">
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
                    {else}
                        <div class="info">
                            <p class="help-block">Invoque una Funcion</p>                         
                        </div>
                    {/if}
                </div>
            </div>   
            <div id="resultado_ws">
                <h4>Funciones Disponibles</h4>
                {if isset($funciones)}
                    {foreach from=$funciones key=key item=item} 
                        <input type="hidden" name="r_tabla" value="{$r_tabla}" class=""></input>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    {$item[0]}
                                </h4>
                            </div>               
                            <div class="panel-body">
                                {if is_array($item[1]) && count($item[1])}                                       
                                    {foreach from=$item[1] key=key2 item=item2}                                                 
                                        <div class="form-group">
                                            <label for="{$item2[1]}">{$item2[1]}</label>
                                            <input tipo="{$item2[0]}" class="parametro form-control" type="text" id="{$item2[1]}"
                                                   placeholder="{$item2[1]}">
                                        </div>
                                    {/foreach}
                                    </ul>
                                {/if}
                                {if $tipo_estandar==2}
                                    <div class="input-group col-md-3 pull-right">
                                       <input type="hidden" value="{$r_tabla}" name="r_tabla" id="r_tabla" />
                                        <span class="input-group-btn">
                                            <input metodo="{$item[0]}" result="{$item[2]}" type="button" class="bt_invocar_2 btn btn-default input-group" value="Invocar">
                                        </span>                                        
                                    </div>
                                {else}
                                    <input metodo="{$item[0]}" result="{$item[2]}" type="button" class="bt_invocar btn btn-default pull-right" value="Invocar">
                                {/if}                                
                            </div>
                        </div>                       
                    {/foreach} 
                {/if}
                {if isset($prueba)}
                    {include file=$prueba}
                {/if}
            </div> 
        </div> 
    </div>

</form>