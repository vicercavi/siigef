<div class="container" >
    <div class="row">
        <div class="col-md-12">
            <h2 class="tit-pagina-principal" align="center">Registro de Calidad de Agua</h2>
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
            <div class="panel-heading">
                <h4 class="panel-title">
                    <strong>{$lenguaje["label_recurso_bdrecursos"]}</strong>
                </h4>
            </div>
            <div class="panel-body">
              <form data-toggle="validator" class="form-horizontal" role="form" method="post" id="registrarcalidaddeagua">
                <div class="form-group">
                  <label for="nombreestacion" class="col-md-4 control-label">{$ficha[5]['Fie_CampoFicha']} (*)</label>
                    <div class="col-md-5">
                      <select class="form-control" id="selEstacion" name="selEstacion" required="">
                        <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                          {foreach from=$estacion item=datos}
                              <option value="{$datos.Esm_IdEstacionMonitoreo}">{$datos.Esm_Nombre|truncate:60:"...":true}</option>  
                          {/foreach}
                      </select>  
                    </div>
                </div>
                <div class="form-group">
                  <label for="nombreestacion" class="col-md-4 control-label">Nombre de la Entidad (*)</label>
                    <div class="col-md-5">
                      <select class="form-control" id="selEntidad" name="selEntidad" required="">
                        <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                          {foreach from=$entidad item=datos}
                              <option value="{$datos.Ent_IdEntidad}">{$datos.Ent_Nombre|truncate:60:"...":true}</option>  
                          {/foreach}
                      </select>  
                    </div>
                </div> 
                <div class="form-group">
                  <label for="variable" class="col-md-4 control-label">{$ficha[2]['Fie_CampoFicha']} (*)</label>
                    <div class="col-md-5">
                      <select class="form-control" id="selVariable" name="selVariable" required="">
                        <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                          {foreach from=$variable item=datos}
                              <option value="{$datos.Var_IdVariable}">{$datos.Var_Nombre}</option>  
                          {/foreach}
                      </select>
                    </div>   
                </div>
                <div class="form-group">
                    <label for="valor" class="col-md-4 control-label">{$ficha[0]['Fie_CampoFicha']} (*)</label>
                    <div class="col-md-5">
                      <input type="text" class="form-control" id="Mca_Valor" name="Mca_Valor"
                             value="{$datos1.Mca_Valor|default:''}" required="">
                    </div>
                </div>      
                <div class="form-group">
                  <label for="fecha_colecta" class="col-md-4 control-label">{$ficha[1]['Fie_CampoFicha']}</label>
                  <div class="col-md-3">
                    <input type="date" class="form-control" id="Mca_Fecha" name="Mca_Fecha"
                             value="{$datos1.Mca_Fecha|default:''|date_format:"%d/%m/%y"}" >
                  </div>
                </div>
                <div class="form-group">                                 
                    <label class="col-md-4 control-label">{$lenguaje.label_pais_nuevo} (*) </label>
                    <div class="col-md-5">
                      <select class="form-control" id="selPais" name="selPais" required="">
                          <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                          {foreach from=$pais item=datos}
                              <option value="{$datos.Pai_IdPais}">{$datos.Pai_Nombre}</option>    
                          {/foreach}
                      </select>
                    </div>
                </div>
                <div class="form-group">                                 
                    <label class="col-md-4 control-label">{$lenguaje.label_estado_nuevo}  </label>
                    <div class="col-md-5">
                        <select class="form-control" id="selEstado" name="selEstado" >
                            <option value="0">Inactivo</option>
                            <option value="1">Activo</option>
                        </select>
                    </div>
                </div>     
                <div class="form-group">
                  <div class="col-md-offset-4 col-md-6">
                    <button type="submit" class="btn btn-success">Registrar</button>
                  <input type="hidden" value="1" name="registrar" />
                  </div>
                </div>
              </form>
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




