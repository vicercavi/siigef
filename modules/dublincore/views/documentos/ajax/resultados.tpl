<div class="col-xs-12 col-sm-8 col-md-offset-0 col-md-9 col-lg-offset-0 col-lg-8">
      <div class="panel panel-default">
        <div class="panel-heading">
  <h4 class="panel-title">
    <strong>{$lenguaje["titulo_resultados_documentos"]}</strong> 
</h4>
  </div>
  
          
        <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                  <div class="row">
                   <div class="col-md-6 col-md-offset-3">
                    <div class="input-group">
                     <input type ="text" class="form-control"  data-toggle="tooltip" data-original-title="{$lenguaje["title_cuadro_buscar"]}" placeholder="{$lenguaje["titulo_resultados_documentos"]}" name="palabra" id="palabra" onkeypress="tecla_enter_dublincore(event)" value="{$palabrabuscada|default:''}">                  
                     <span class="input-group-btn">
                      <button class="btn  btn-primary btn-buscador" onclick="buscarPalabraDocumentos('palabra','filtrotemadocumento','filtrotipodocumento','filtropaisdocumento')" type="button" id="btnEnviar"><i class="glyphicon glyphicon-search"></i></button>
                      </span>
                    </div><!-- /input-group -->
                  </div>
                </div>
              </div>      
              <div class="col-md-6 col-md-offset-3 div-filtro text-center">
                {if isset($filtroTema) OR isset($filtroTipo) OR  isset($filtroPais)}
                  <strong> Filtro:</strong> 
                  {/if}
                {if isset($filtroTema)}
                <input type="hidden" id= "filtrotemadocumento" value="{$filtroTema}">
                <a class="badge" href="{$_layoutParams.root}dublincore/documentos/buscarporpalabras/{$palabrabuscada|default:'all'}/all/{$filtroTipo|default:'all'}/{$filtroPais|default:'all'}">
                 Tema: {$filtroTema}  <i class="fa fa-times"></i> 
                </a>
                {/if}
                {if isset($filtroTipo)}
                <input type="hidden" id= "filtrotipodocumento" value="{$filtroTipo}">
                <a class="badge" href="{$_layoutParams.root}dublincore/documentos/buscarporpalabras/{$palabrabuscada|default:'all'}/{$filtroTema|default:'all'}/all/{$filtroPais|default:'all'}">
                 Tipo: {$filtroTipo} <i class="fa fa-times"></i>               
                </a>
                {/if}
                {if isset($filtroPais)}
                <input type="hidden" id= "filtropaisdocumento" value="{$filtroPais}">
                <a class="badge" href="{$_layoutParams.root}dublincore/documentos/buscarporpalabras/{$palabrabuscada|default:'all'}/{$filtroTema|default:'all'}/{$filtroTipo|default:'all'}/all">
                 País: {$filtroPais} <i class="fa fa-times"></i>               
                </a>
                {/if}
              </div>

                 <div class="col-md-12 text-center">
                    {if isset($paises) && count($paises)}
                              {foreach item=datos from=$paises}
                                   <div style="margin-top:17px;display:inline-block;vertical-align:top;text-align:center;">
                                      <img class="pais " data-toggle="tooltip" data-original-title="{$lenguaje["title_paises_buscar"]}" style="cursor:pointer;width:40px" src="{$_layoutParams.root}public/img/legal/{$datos.Pai_Nombre}.png" 
                                          pais="{$datos.Pai_Nombre}" />
                                          <br>
                                          <b>{$datos.Pai_Nombre}</b>
                                          <p style="font-size:.8em">({$datos.cantidad|default:0})</p>
                                  </div>
                              {/foreach}
                         {else}
                              <p><strong>{$lenguaje["sin_resultados"]}</strong></p>
                         {/if}             
                  </div>
                   <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-6">
                        <b>Resultado de búsqueda</b>
                      </div>
                      <div class="col-md-6 text-right">
                       <b><font size="-1">{$lenguaje["total_resultados_documentos"]}: {$totaldocumentos[0]}</font></b>
                      </div>
                      </div>        
                     
                   </div>
                    
            </div>
            <!-- <p>Some default panel content here.</p> -->
        </div>
    <div id="paginar">
        <div class="table-responsive">
            <table class="table table-hover table-condensed">
              <thead>
                <tr><th>#<th>{$lenguaje["tabla_campo_tipo_documentos"]}<th>{$lenguaje["tabla_campo_titulo"]}<th>{$lenguaje["tabla_campo_descripcion_documentos"]}<th>{$lenguaje["tabla_campo_tipo_documento_documentos"]}<th>{$lenguaje["tabla_campo_pais_documentos"]}<th>{$lenguaje["tabla_campo_enlaces_documentos"]}
                <tbody>
                   {if isset($documentos) && count($documentos)}
                            
                            {foreach item=datos from=$documentos}
                                <tr>
                                    <td>{$numeropagina++}<td> <img  src="{$_layoutParams.root}public/img/documentos/{$datos.Taf_Descripcion}.png"/><td>{$datos.Dub_Titulo}<td>{$datos.Aut_Nombre}<br/>{$datos.Dub_Descripcion}<td>{$datos.Tid_Descripcion}{if isset($documentos[0].Pai_Nombre)} <td><img class="pais " style="width:40px" src="{$_layoutParams.root}public/img/legal/{$datos.Pai_Nombre}.png" 
                                           />{/if}<td> <a class="btn btn-default" data-toggle="tooltip" data-placement="top" href="{$_layoutParams.root}dublincore/documentos/metadata/{$datos.Dub_IdDublinCore}" target="_blank" title="{$lenguaje["tabla_campo_detalle_documentos"]}"><i class="glyphicon glyphicon-list-alt" ></i></a>
                                    <a data-toggle="tooltip" data-placement="top" class="btn btn-default" href="{$_layoutParams.root_archivo_fisico}{$datos.Arf_PosicionFisica}" target="_blank" title="{$lenguaje["icono_descargar_documentos"]}"><i class="glyphicon glyphicon-download-alt" ></i></a> 
                            {/foreach}                       
                                                                   
                        {/if}   
                </tbody>
            </table>
        </div>
        {if !empty(count($documentos))}
                                            {$paginacion|default:""}
                                            {else}
                                            <center>¡¡¡{$lenguaje["sin_resultados_documentos"]}!!!</center>
                                            {/if}
         </div>
    </div>
    </div>