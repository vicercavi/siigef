<form id="panel-monitoreo" method="post">
    <div style="margin: 15px; width: 80%">
        <h2 >Gestor del Visor de Monitoreo Calidad de Agua</h2>
        <div style="width: 70%;display: inline-table;vertical-align: top;margin-top: 10px">       

            <div class="panel panel-default nav nav-stacked" id="panelnuevoitem">
                <div class="panel-heading">
                    <a  data-toggle="collapse" href="#contenidonuevoitem"  data-parent="#panelnuevoitem"  class="panel-title"><h4>{if isset($ejerarquia)}Editar Item{else}Agregar Nuevo Item{/if}</h4></a>
                </div>
                <div id="contenidonuevoitem" {if !isset($ejerarquia)}class="collapse"{/if} style="background-color: rgb(251, 250, 250);">
                    <div id="datosgenerales" class="span11">                        
                        <h5>Datos Generales</h5>
                        <div class="div2">
                            <label>Nombre:</label> 
                            <input type="text" style="width: 95%;" name="tb_nombre" value="{$ejerarquia.Jem_Nombre|default}">
                        </div>
                        <div class="div2">
                            <label>Orden:</label> 
                            <input type="number" style="width: 50px;" name="tb_orden" value="{$ejerarquia.Jem_Orden|default}">
                        </div> 
                        <div class="div1">
                            <label>Descripcion:</label> 
                            <textarea type="text" style="width: 100%;max-width: 100%" name="tb_descripcion" >{$ejerarquia.Jem_Descripcion|default}</textarea>
                        </div>
                        <div class="span10" style="text-align: right">                       
                            {if isset($ejerarquia)}
                                <input type="hidden" id="hd_id_jerarquia" name="hd_id_jerarquia" value="{$ejerarquia.Jem_IdJerarquiaCapa}">
                                <button type="submit" id="bt_cancelar" name="bt_cancelar" class="bnt btn-success"> Cancelar</button>
                            {/if}
                            <button id="bt_guardar" name="bt_guardar" type="submit" class="bnt btn-success"> {if isset($ejerarquia)}Editar{else}Guardar{/if}</button>
                        </div>
                    </div>
                    {if isset($ejerarquia)}
                        <div id="listadecapas" class="span11">
                            <h5>Capa </h5>
                            <div class="span6" >  
                                <h5>Capas Disponibles - <a href="{$_layoutParams.root}mapa/gestorcapa" target="_blank" >Nueva Capa</a></h5>
                                <div id="listadecapasnmonitoreo">         
                                    {if isset($capasn) && count($capasn)}
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Nombre</th>  
                                                    <th>Fuente</th>   
                                                    <th>Pais</th>   
                                                    <th ></th>

                                                </tr>
                                            </thead>
                                            {foreach item=datos from=$capasn}
                                                <tr>
                                                    <td>{$datos.tic_Nombre}</td>
                                                    <td>{$datos.Cap_Titulo}</td>
                                                    <td>{$datos.Cap_Fuente}</td>
                                                    <td>
                                                        <select id="cmb_pais" style="width: 110px"> 
                                                            <option value="0">Seleccione..</option>
                                                            {if isset($pais)}
                                                                {foreach from=$pais key=key item=item} 
                                                                    <option value="{$item.Pai_IdPais}">{$item.Pai_Nombre} </option>
                                                                {/foreach}                                                             
                                                            {/if}

                                                        </select></td>
                                                    <td><span capa="{$datos.Cap_Idcapa}" class="sp_asignar_capa_vm btn-link">Asignar</span></td>

                                                </tr>

                                            {/foreach}
                                        </table>                                       
                                        {$paginacioncapasn|default}

                                    {else}

                                        <p><strong>No hay registros!</strong></p>

                                    {/if}
                                </div> 
                            </div>
                            <div class="span4">
                                <h5>Capa Asignada</h5>
                                <div id="listadecapasasignadasnmonitoreo"> 

                                    {if isset($capasa) && count($capasa)}
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tipo</th>
                                                    <th>Nombre</th>  
                                                    <th>Fuente</th>   
                                                    <th>Pais</th>    
                                                    <th ></th>

                                                </tr>
                                            </thead>
                                            {foreach item=datos from=$capasa}
                                                <tr>
                                                    <td>{$datos.tic_Nombre}</td>
                                                    <td>{$datos.Cap_Titulo}</td>
                                                    <td>{$datos.Cap_Fuente}</td>
                                                    <td>{$datos.Pai_Nombre}</td>
                                                    <td><a href="{$_layoutParams.root}calidaddeagua/monitoreo/gestor/edit/{$datos.Cap_Idcapa}">Ver Mapa</a></td>
                                                    <td><span capa="{$datos.Cap_Idcapa}" class="sp_quitar_capa_vm btn-link">Quitar</span></td></td>
                                                </tr>

                                            {/foreach}
                                        </table> 

                                        {$paginacioncapasa|default}
                                    {else}

                                        <p><strong>No hay registros!</strong></p>

                                    {/if} 
                                </div>
                            </div>
                        </div>           
                    {/if}                  
                </div>
            </div>

            <div  class="panel panel-default nav nav-stacked" id="listajerarquia">
                <div class="panel-heading">
                    <h4 class="panel-title">Lista de Jerarquias</h4>
                </div>
                <div>
                    <div id="listarjerarquiamonitoreo" class="span10">
                        {if isset($jerarquias) && count($jerarquias)}

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Orden</th>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th colspan="2"></th>

                                    </tr>
                                </thead>
                                {foreach item=datos from=$jerarquias}
                                    <tr>
                                        <td>{$datos.Jem_Orden}</td>
                                        <td>{$datos.Jem_Nombre}</td>
                                        <td>{$datos.Jem_Descripcion}</td>                                       
                                        <td><a href="{$_layoutParams.root}calidaddeagua/monitoreo/gestor/ver/{$datos.Jem_IdJerarquiaCapa}">Ver</a></td>
                                        <td><span jerarquia="{$datos.Jem_IdJerarquiaCapa}" class="sp_quitar_jerarquia_vm btn-link">Quitar</span></td>
                                    </tr>

                                {/foreach}
                            </table>
                            <div style="text-align: right">
                                {$paginacion|default}
                            </div>
                        {else}

                            <p><strong>No hay registros!</strong></p>

                        {/if}

                    </div>   

                </div>
            </div>
        </div>


    </div>
</form>

