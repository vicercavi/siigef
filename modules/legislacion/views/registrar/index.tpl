<div class="container">
  {if $_acl->permiso("agregar_registro_recurso")}
    <div class="row">
      <div class="col-md-12">
          <h2 class="tit-pagina-principal" align="center">Registro de Legislacion</h2>
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
                <strong>Formulario de Registro</strong>
            </h4>
          </div>
          <div class="panel-body">
            <form data-toggle="validator" class="form-horizontal" role="form" method="post" id="registrarlegislacion">                         
              <div class="form-group" align="center">
              		{foreach item=datos from=$idiomas}
                      <label class="radio-inline">
                        <input type="radio" name="Idi_IdIdioma" id="Idi_IdIdioma" value="{$datos.Idi_IdIdioma}" {if $idioma == $datos.Idi_IdIdioma } checked="checked" {/if}>
                          {$datos.Idi_Idioma}
                      </label>
                  {/foreach}
              </div>
              <div id="gestion_idiomas">
                <div class="form-group">
                    <label for="nivel_legal" class="col-md-4 control-label">{$ficha[12]['Fie_CampoFicha']} (*)</label>
                    <div class="col-md-5">          
                      <input type="text" list="nivel_legal" class="form-control" id="Nil_IdNivelLegal" name="Nil_IdNivelLegal" placeholder="{$ficha[12]['Fie_CampoFicha']}" required/>
                          <datalist id="nivel_legal">
                            {foreach item=datos from=$Nil_IdNivelLegal}
                             	<option value="{$datos.Nil_Nombre}">
                            {/foreach}    
                          </datalist>
                    </div>
                </div>
                <div class="form-group">
                  <label for="sub_nivel_legal" class="col-md-4 control-label">{$ficha[11]['Fie_CampoFicha']} (*)</label>
                  <div class="col-md-5">
                    <input type="text" list="sub_nivel_legal" class="form-control" id="Snl_IdSubNivelLegal" name="Snl_IdSubNivelLegal" 
                           placeholder="{$ficha[11]['Fie_CampoFicha']}" required>
                       <datalist id="sub_nivel_legal">
                        {foreach item=datos from=$Snl_IdSubNivelLegal}
                       	  <option value="{$datos.Snl_Nombre}">
                        {/foreach}
                      </datalist>  
                  </div>
                </div>
                <div class="form-group">
                  <label for="tema_legislacion" class="col-md-4 control-label">{$ficha[10]['Fie_CampoFicha']} (*)</label>
                  <div class="col-md-5">
                    <input type="text" list="tema_legal" class="form-control" id="Tel_IdTemaLegal" name="Tel_IdTemaLegal" 
                            placeholder="{$ficha[10]['Fie_CampoFicha']}" required>
                    <datalist id="tema_legal">
                    {foreach item=datos from=$Tel_IdTemaLegal}
                     	<option value="{$datos.Tel_Nombre}">
                    {/foreach}   
                    </datalist>
                  </div>
                </div>      
                <div class="form-group">
                  <label for="fecha_publicacion" class="col-md-4 control-label">{$ficha[0]['Fie_CampoFicha']}</label>
                  <div class="col-md-3">
                    <input type="date" class="form-control" id="Mal_FechaPublicacion" name="Mal_FechaPublicacion" placeholder="{$ficha[0]['Fie_CampoFicha']}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="entidad" class="col-md-4 control-label">{$ficha[1]['Fie_CampoFicha']}</label>
                  <div class="col-md-5">
                    <input type="text" class="form-control" id="Mal_Entidad" name="Mal_Entidad" placeholder="{$ficha[1]['Fie_CampoFicha']}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="numero_normas" class="col-md-4 control-label">{$ficha[2]['Fie_CampoFicha']}</label>
                  <div class="col-md-5">
                    <input type="text" class="form-control" id="Mal_NumeroNormas" name="Mal_NumeroNormas"
                           placeholder="{$ficha[2]['Fie_CampoFicha']}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="titulo" class="col-md-4 control-label">{$ficha[3]['Fie_CampoFicha']} (*)</label>
                  <div class="col-md-5">
                    <input type="text" class="form-control" id="Mal_Titulo" name="Mal_Titulo" placeholder="{$ficha[3]['Fie_CampoFicha']}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="articulos_aplicables" class="col-md-4 control-label">{$ficha[4]['Fie_CampoFicha']}</label>
                  <div class="col-md-5">
                    <input type="text" class="form-control" id="Mal_ArticuloAplicable" name="Mal_ArticuloAplicable" placeholder="{$ficha[4]['Fie_CampoFicha']}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="resumen_legislacion" class="col-md-4 control-label">{$ficha[5]['Fie_CampoFicha']}</label>
                  <div class="col-md-5">
                    <textarea class="form-control" rows="3" id="Mal_ResumenLegislacion" name="Mal_ResumenLegislacion" placeholder="{$ficha[5]['Fie_CampoFicha']}"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="fecha_revision" class="col-md-4 control-label">{$ficha[6]['Fie_CampoFicha']}</label>
                  <div class="col-md-3">
                    <input type="date" class="form-control" id="Mal_FechaRevision" name="Mal_FechaRevision" placeholder="{$ficha[6]['Fie_CampoFicha']}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="normas_complementarias" class="col-md-4 control-label">{$ficha[7]['Fie_CampoFicha']}</label>
                  <div class="col-md-5">
                    <input type="text" class="form-control" id="Mal_NormasComplemaentarias" name="Mal_NormasComplemaentarias" 
                    placeholder="{$ficha[7]['Fie_CampoFicha']}">
                  </div>
                </div>      
                <div class="form-group">
                  <label for="tipo_legislacion" class="col-md-4 control-label">{$ficha[8]['Fie_CampoFicha']}</label>
                  <div class="col-md-5">
                    <input type="text" list="tipo_legislacion" class="form-control" id="Til_Nombre" name="Til_Nombre"
                           placeholder="{$ficha[8]['Fie_CampoFicha']}" >
                    <datalist id="tipo_legislacion">
                      {foreach item=datos from=$Til_IdTipoLegal}
                       	<option value="{$datos.Til_Nombre}">
                      {/foreach}   
                    </datalist>
                  </div>
                </div>
                <div class="form-group">
                  <label for="palabra_clave" class="col-md-4 control-label">{$ficha[13]['Fie_CampoFicha']}</label>
                  <div class="col-md-5">
                    <input type="text" list="palabra_clave" class="form-control" id="Mal_PalabraClave" name="Mal_PalabraClave"
                           placeholder="{$ficha[13]['Fie_CampoFicha']}" >
                           <!--<datalist id="palabra_clave">
                          {foreach item=datos from=$Mal_PalabraClave}
                           	<option value="{$datos.Mal_PalabraClave}">
                          {/foreach}   
                          </datalist>-->
                  </div>
                </div>
                <div class="form-group">
                  <label for="pais" class="col-md-4 control-label">{$ficha[9]['Fie_CampoFicha']} (*)</label>
                  <div class="col-md-3">
                    <select class="form-control" id="Pai_IdPais" name="Pai_IdPais" required>
                      <option value="">Seleccione Pais</option>
                      {foreach from=$paises item=ps}
                      <option value="{$ps.Pai_IdPais}">{$ps.Pai_Nombre}</option>
                      {/foreach}
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-offset-4 col-md-6">
                    <button type="submit" class="btn btn-success">Registrar</button>
                  <input type="hidden" value="1" name="registrar" id="registrar" />
                  </div>
                </div>
              </div>
            </form>
          </div> 
        </div>
      </div>
    </div>
  {/if}
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Datos Registrados</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

