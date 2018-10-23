

<div class="container" >
	<div class="row">
        <div class="col-md-12">
            <h2 class="tit-pagina-principal" align="center">Registro de DarwinCore</h2>
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
    <form data-toggle="validator" class="form-horizontal" role="form"  method="post" id="registrardarwin">
      
      <div class="form-group">
        <label for="fecha_actualizacion" class="col-md-4 control-label">{$ficha[0]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <div class='input-group date'>
                    <input type='text' class="form-control" id='Dar_FechaActualizacion' name="Dar_FechaActualizacion" placeholder="dd/mm/yyyy"/>
                    
                </div>
        </div>
      </div>
      <div class="form-group">
        <label for="codigo_institucion" class="col-md-4 control-label">{$ficha[1]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Dar_CodigoInstitucion" name="Dar_CodigoInstitucion" 
                 placeholder="{$ficha[1]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="codigo_coleccion" class="col-md-4 control-label">{$ficha[2]['Fie_CampoFicha']}</label>
        <div class="col-md-3">          
          <input type="text" class="form-control" id="Dar_CodigoColeccion" name="Dar_CodigoColeccion" 
                 placeholder="{$ficha[2]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="numero_catalogo" class="col-md-4 control-label">{$ficha[3]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text" class="form-control" id="Dar_NumeroCatalogo" name="Dar_NumeroCatalogo" 
                 placeholder="{$ficha[3]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="nombre_cientifico" class="col-md-4 control-label">{$ficha[4]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Dar_NombreCientifico" name="Dar_NombreCientifico" 
                 placeholder="{$ficha[4]['Fie_CampoFicha']}">
        </div>
      </div>
      <div class="form-group">
        <label for="base_registro" class="col-md-4 control-label">{$ficha[5]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text" class="form-control" id="Dar_BaseRegistro" name="Dar_BaseRegistro" 
                 placeholder="{$ficha[5]['Fie_CampoFicha']}" >
        </div>
      </div>            
      
      <div class="form-group">
        <label for="reino_organismo" class="col-md-4 control-label">{$ficha[6]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Dar_ReinoOrganismo" name="Dar_ReinoOrganismo" 
                 placeholder="{$ficha[6]['Fie_CampoFicha']}">
        </div>
      </div>
      <div class="form-group">
        <label for="division" class="col-md-4 control-label">{$ficha[7]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Dar_Division" name="Dar_Division"
                 placeholder="{$ficha[7]['Fie_CampoFicha']}">
        </div>
      </div>
      <div class="form-group">
        <label for="clase_organismo" class="col-md-4 control-label">{$ficha[8]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Dar_ClaseOrganismo" name="Dar_ClaseOrganismo"
                 placeholder="{$ficha[8]['Fie_CampoFicha']}">
        </div>
      </div>
      <div class="form-group">
        <label for="orden_organismo" class="col-md-4 control-label">{$ficha[9]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Dar_OrdenOrganismo" name="Dar_OrdenOrganismo" 
                 placeholder="{$ficha[9]['Fie_CampoFicha']}">
        </div>
      </div>
      <div class="form-group">
        <label for="familia_organismo" class="col-md-4 control-label">{$ficha[10]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Dar_FamiliaOrganismo" name="Dar_FamiliaOrganismo" 
                 placeholder="{$ficha[10]['Fie_CampoFicha']}">          
        </div>
      </div>
      <div class="form-group">
        <label for="genero_organismo" class="col-md-4 control-label">{$ficha[11]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Dar_GeneroOrganismo" name="Dar_GeneroOrganismo" 
                 placeholder="{$ficha[11]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="especie_organismo" class="col-md-4 control-label">{$ficha[12]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Dar_EspecieOrganismo" name="Dar_EspecieOrganismo"
                 placeholder="{$ficha[12]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="sub_especie_organismo" class="col-md-4 control-label">{$ficha[13]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Dar_SubEspecieOrganismo" name="Dar_SubEspecieOrganismo"
                 placeholder="{$ficha[13]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="autor_organismo" class="col-md-4 control-label">{$ficha[14]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Dar_AutorNombreCientifico" name="Dar_AutorNombreCientifico"
                 placeholder="{$ficha[14]['Fie_CampoFicha']}" >
        </div>
      </div>  
      <div class="form-group">
        <label for="identificado_por" class="col-md-4 control-label">{$ficha[15]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text"  class="form-control" id="Dar_IdentificadoPor" name="Dar_IdentificadoPor"
                 placeholder="{$ficha[15]['Fie_CampoFicha']}" >
        </div>
      </div>         
      <div class="form-group">
        <label for="año_identificación" class="col-md-4 control-label">{$ficha[16]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_AnoIdentificacion" name="Dar_AnoIdentificacion"
                 placeholder="{$ficha[16]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="mes_identificación" class="col-md-4 control-label">{$ficha[17]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_MesIdentificacion" name="Dar_MesIdentificacion"
                 placeholder="{$ficha[17]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="dia_identificación" class="col-md-4 control-label">{$ficha[18]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_DiaIdentificacion" name="Dar_DiaIdentificacion"
                 placeholder="{$ficha[18]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="estatus _tipo" class="col-md-4 control-label">{$ficha[19]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_StatusTipo" name="Dar_StatusTipo"
                 placeholder="{$ficha[19]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="numero_colector" class="col-md-4 control-label">{$ficha[20]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_NumeroColector" name="Dar_NumeroColector"
                 placeholder="{$ficha[20]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="numero_campo" class="col-md-4 control-label">{$ficha[21]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_NumeroCampo" name="Dar_NumeroCampo"
                 placeholder="{$ficha[21]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="colector" class="col-md-4 control-label">{$ficha[22]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_Colector" name="Dar_Colector"
                 placeholder="{$ficha[22]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="año_colectado" class="col-md-4 control-label">{$ficha[23]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_AnoColectado" name="Dar_AnoColectado"
                 placeholder="{$ficha[23]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="mes_colectado" class="col-md-4 control-label">{$ficha[24]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_MesColectado" name="Dar_MesColectado"
                 placeholder="{$ficha[24]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="día_colectado" class="col-md-4 control-label">{$ficha[25]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_DiaColectado" name="Dar_DiaColectado"
                 placeholder="{$ficha[25]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="dia_ordinario" class="col-md-4 control-label">{$ficha[26]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_DiaOrdinario" name="Dar_DiaOrdinario"
                 placeholder="{$ficha[26]['Fie_CampoFicha']}" >
        </div>        
      </div>
      <div class="form-group">
        <label for="hora_colectado" class="col-md-4 control-label">{$ficha[27]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_HoraColectado" name="Dar_HoraColectado"
                 placeholder="{$ficha[27]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="continente_oceano" class="col-md-4 control-label">{$ficha[28]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text"  class="form-control" id="Dar_ContinenteOceano" name="Dar_ContinenteOceano"
                 placeholder="{$ficha[28]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="pais" class="col-md-4 control-label">{$ficha[29]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <select class="form-control" id="Dar_Pais" name="Dar_Pais">
          		<option value="">Seleccionar Pais</option>
            {foreach from=$paises item=ps}
                <option value="{$ps.Pai_Nombre}">{$ps.Pai_Nombre}</option>
            {/foreach}
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="estado_provincia" class="col-md-4 control-label">{$ficha[30]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text"  class="form-control" id="Dar_EstadoProvincia" name="Dar_EstadoProvincia"
                 placeholder="{$ficha[30]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="municipio" class="col-md-4 control-label">{$ficha[31]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text"  class="form-control" id="Dar_Municipio" name="Dar_Municipio"
                 placeholder="{$ficha[31]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="localidad" class="col-md-4 control-label">{$ficha[32]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text"  class="form-control" id="Dar_Localidad" name="Dar_Localidad"
                 placeholder="{$ficha[32]['Fie_CampoFicha']}">
        </div>
      </div>
      <div class="form-group">
        <label for="longitud" class="col-md-4 control-label">{$ficha[33]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_Longitud" name="Dar_Longitud"
                 placeholder="{$ficha[33]['Fie_CampoFicha']}" pattern="(\-|\+)?(0|([1-9][0-9]*))(\.[0-9]+)?" >
        </div>
      </div>
      <div class="form-group">
        <label for="latitud" class="col-md-4 control-label">{$ficha[34]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_Latitud" name="Dar_Latitud"
                 placeholder="{$ficha[34]['Fie_CampoFicha']}" pattern="(\-|\+)?(0|([1-9][0-9]*))(\.[0-9]+)?" >
        </div>
      </div>
      <div class="form-group">
        <label for="precision_coordenada" class="col-md-4 control-label">{$ficha[35]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text"  class="form-control" id="Dar_PrecisionDeCordenada" name="Dar_PrecisionDeCordenada"
                 placeholder="{$ficha[35]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="boundingbox" class="col-md-4 control-label">{$ficha[36]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_BoundingBox" name="Dar_BoundingBox"
                 placeholder="{$ficha[36]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="minima_elevacion" class="col-md-4 control-label">{$ficha[37]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_MinimaElevacion" name="Dar_MinimaElevacion"
                 placeholder="{$ficha[37]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="maxima_elevacion" class="col-md-4 control-label">{$ficha[38]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_MaximaElevacion" name="Dar_MaximaElevacion"
                 placeholder="{$ficha[38]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="minima_profundidad" class="col-md-4 control-label">{$ficha[39]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_MinimaProfundidad" name="Dar_MinimaProfundidad"
                 placeholder="{$ficha[39]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="maxima_profundidad" class="col-md-4 control-label">{$ficha[40]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_MaximaProfundidad" name="Dar_MaximaProfundidad"
                 placeholder="{$ficha[40]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="sexo_organismo" class="col-md-4 control-label">{$ficha[41]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_SexoOrganismo" name="Dar_SexoOrganismo"
                 placeholder="{$ficha[41]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="preparación_tipo" class="col-md-4 control-label">{$ficha[42]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_PreparacionTipo" name="Dar_PreparacionTipo"
                 placeholder="{$ficha[42]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="conteo_individuo" class="col-md-4 control-label">{$ficha[43]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_ConteoIndividuo" name="Dar_ConteoIndividuo"
                 placeholder="{$ficha[43]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="numero_catalogo_anterior" class="col-md-4 control-label">{$ficha[44]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_NumeroCatalogoAnterior" name="Dar_NumeroCatalogoAnterior"
                 placeholder="{$ficha[44]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="tipo_relacion" class="col-md-4 control-label">{$ficha[45]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_TipoRelacion" name="Dar_TipoRelacion"
                 placeholder="{$ficha[45]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="información_relacionada" class="col-md-4 control-label">{$ficha[46]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text"  class="form-control" id="Dar_InformacionRelacionada" name="Dar_InformacionRelacionada"
                 placeholder="{$ficha[46]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="estado_via" class="col-md-4 control-label">{$ficha[47]['Fie_CampoFicha']}</label>
        <div class="col-md-3">
          <input type="text"  class="form-control" id="Dar_EstadoVida" name="Dar_EstadoVida"
                 placeholder="{$ficha[47]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="Nota" class="col-md-4 control-label">{$ficha[48]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text"  class="form-control" id="Dar_Nota" name="Dar_Nota"
                 placeholder="{$ficha[48]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <label for="nombre_comun_organismo" class="col-md-4 control-label">{$ficha[49]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <input type="text"  class="form-control" id="Dar_NombreComunOrganismo" name="Dar_NombreComunOrganismo"
                 placeholder="{$ficha[49]['Fie_CampoFicha']}" >
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-offset-4 col-md-5">
          <button type="submit" class="btn btn-primary">Registrar</button>
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

