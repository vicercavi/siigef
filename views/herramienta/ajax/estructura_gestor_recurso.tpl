<div class="form-group col-md-12">                         
    <label for="sl_estandar_recurso" class=" row col-lg-2 control-label">Estandar de Recurso</label>                               
    <div class="col-lg-4">
        <select id="sl_estandar_recurso" class="form-control" {if isset($er_asignado)} disabled {/if}>
            <option value="0">Seleccione..</option>   
            {if isset($estandar_recurso) && count($estandar_recurso)}
                {foreach from=$estandar_recurso item=dato}
                    <option value="{$dato.Esr_IdEstandarRecurso}" {if isset($er_asignado)&& $er_asignado==$dato.Esr_IdEstandarRecurso} selected {/if}>{$dato.Esr_Nombre}</option>       
                {/foreach}
            {/if}
        </select>
    </div>
</div> 
<div class="form-group recurso_gestor">                         
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Disponibles</strong>                                      
            </div>     
            <div class="panel-body">
                <div class="input-group col-xs-12 ">
                    <input id="tb_buscar_rd_filter" type="text" class="form-control"  placeholder="Buscar Recursos Disponibles" value="{$buscar|default}" />                     
                    <span class="input-group-btn">
                        <button id="bt_buscar_rd_filter" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
            </div>
            <div id="estructura_lista_recursos_disponibles" class="form-inline">
                {if isset($recurso_disponible) && count($recurso_disponible)}
                    <div class="table-responsive" >
                        <table class="table">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>    
                                <th>Estandar</th>                                                             
                                <th class="text-center">Opciones</th>
                            </tr>
                            {foreach from=$recurso_disponible item=dato}
                                <tr>
                                    <td>{$numeropagina_rd++}</td>
                                    <td>{$dato.Rec_Nombre}</td>                                                            
                                    <td>{$dato.Esr_Nombre}</td>                                                            
                                    <td style=" text-align: center">
                                        <a type="button" title="Asignar" recurso='{$dato.Rec_IdRecurso}' estructura='{$padreestructura.Esh_IdEstructuraHerramienta}' class="btn btn-default btn-sm glyphicon glyphicon-chevron-right asignar_recurso">
                                        </a> 
                                    </td>
                                </tr>
                            {/foreach}
                        </table>
                    </div>
                    {$paginacion_rd|default:""}
                {else}
                    Seleccione Estandar de Recurso
                {/if}
            </div>
        </div>
    </div>               
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Asignados</strong>                                         
            </div>   
            <div class="panel-body">
                <div class="input-group col-xs-12 ">
                    <input id="tb_buscar_ra_filter" type="text" class="form-control"  placeholder="Buscar Recursos Asignados" value="{$buscar|default}" />                     
                    <span class="input-group-btn">
                        <button id="bt_buscar_ra_filter" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
            </div>
            <div id="estructura_lista_recursos_asignados" class="form-inline">
                {if isset($recurso_asignado) && count($recurso_asignado)}
                    <div class="table-responsive" >
                        <table class="table">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>    
                                <th>Estandar</th>                                                             
                                <th class="text-center">Opciones</th>
                            </tr>
                            {foreach from=$recurso_asignado item=dato}
                                <tr>
                                    <td>{$numeropagina_ra++}</td>
                                    <td>{$dato.Rec_Nombre}</td>                                                               
                                    <td>{$dato.Esr_Nombre}</td>                                                            
                                    <td style=" text-align: center">                                                                
                                        <a type="button" title="Quitar" recurso='{$dato.Rec_IdRecurso}' estructura='{$padreestructura.Esh_IdEstructuraHerramienta}' class="btn btn-default btn-sm glyphicon glyphicon-remove quitar_recurso" >
                                        </a>
                                    </td>
                                </tr>
                            {/foreach}
                        </table>
                    </div>
                    {$paginacion_ra|default:""}
                {else}
                    Sin Datos...
                {/if}
            </div>
        </div>
    </div>
</div>