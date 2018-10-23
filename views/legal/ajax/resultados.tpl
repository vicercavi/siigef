<div class="col-md-10">
          <div class="panel panel-default">
          	
          <div class="panel-heading">Documentos Legal</div>
            
          <div class="panel-body">
                <div class="row">
                      <div class="col-md-8">
                         {if isset($totalpaises) && count($totalpaises)}
                              {foreach item=datos from=$totalpaises}
                                  <div style="display:inline-block;vertical-align:top;width:60px;text-align:center;margin-right:20px;">
                                      <img class="pais " style="cursor:pointer;width:40px" src="{$_layoutParams.root}public/img/legal/{$datos.Pai_Nombre}.png" 
                                          pais="{$datos.Pai_Nombre}" /><b>{$datos.Pai_Nombre}</b><p style="font-size:.8em">({$datos.cantidad|default:0})</p>
                                  </div>
                              {/foreach}
                         {else}
                              <p><strong>No hay aspectos legales!</strong></p>
                         {/if}
                      </div>
                      <div class="col-md-4">
                          <div class="row form-inline" style="text-align:right;padding-right:.5em"> 
                              <input class="form-control" placeholder="Documentos Legal" name="palabra" id="palabra" value="{$palabrabuscada}">    
                              <button class="btn btn-primary" type="button" id="btnEnviar"><i class="glyphicon glyphicon-search"></i></button>
                              
    
                          </div>
                          <div class="row" style="text-align:right;padding-right:.5em;">
                             <b><font size="-1">Total de registros: {count($totalregistros)}</font></b>
                          </div>
                      </div>
                </div>
                <!-- <p>Some default panel content here.</p> -->
            </div>
          
          
              <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr><th>Nro<th>Fecha de Publicacion<th>Titulo<th>Entidad<th>Tipo de Legislación<th>Acción
                        <tbody>
                           {if isset($legislacion)}
                                {foreach item=datos from=$legislacion}
                                <tr><td data-th="Nro">{$numeropagina++} <td data-th="Fecha de Publicacion">{$datos.Mal_FechaPublicacion}  <td data-th="Titulo">{$datos.Mal_Titulo} <td data-th="Entidad">{$datos.Mal_Entidad} <td data-th="Tipo legislación">{$datos.Mal_TipoLegislacion} <td data-th="Acción"><a data-toggle="tooltip" data-placement="top" class="btn btn-default" href="legal/metadata/{$datos.Mal_IdMatrizLegal}" target="_blank" title="Ver más"><i class="glyphicon glyphicon-eye-open" ></i></a> 
                               {/foreach}
                               {/if}
                        </tbody>
                    </table>
                </div>
                
              <div class="panel-footer">  {$paginacion|default:""}</div>
          </div>
          
          </div>
         
      </div>
    </div>