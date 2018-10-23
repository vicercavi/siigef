<div class="container" style="margin:10px auto;">
    <div class="row">
    <div class="col-md-12">
    <h2 class="tit-pagina-principal">{$lenguaje["label_h2_metadata_titulo"]}</h2>
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
                                    <td style="border:none;">{$lenguaje["label_nombre_bdrecursos"]}:</td>
                                    <td style="border:none;">{$recurso.Rec_Nombre}</td>
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
        
        
        {foreach item=datos from=$detalle}
<div class="panel panel-default">     
        <div class="table-responsive">
        <table class="table table-user-information">          
            <tbody>
                    <tr>
                        <td class="col-md-3" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);"><b>{$lenguaje["label_detalle"]}</b></td>
                        <td class="col-md-9" style="padding:0;border: 0;">

                            <table class="table table-user-information" style="margin:0;border:0;">
                                <tbody>
                                        <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_fecha_actualizacion"]}<td >:<td >{ucfirst(strtolower($datos.Dar_FechaActualizacion|date_format:"%d/%m/%y"))|default:''}         
                                        <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_codigo_institucion"]}<td >:<td >{ucfirst(strtolower($datos.Dar_CodigoInstitucion))|default:''}                        
                                        <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_codigo_coleccion"]}<td >:<td >{ucfirst(strtolower($datos.Dar_CodigoColeccion))|default:''}
                                        <tr>                                        
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_numero_Catalogo"]}<td >:<td >{ucfirst(strtolower($datos.Dar_NumeroCatalogo))|default:''}
                                        <tr>                                        
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_nombre_cientifico"]}<td >:<td>{ucfirst(strtolower($datos.Dar_NombreCientifico))|default:''}
                                        <tr>                                        
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_base_registro"]}<td >:<td>{ucfirst(strtolower($datos.Dar_BaseRegistro))|default:''}
                                        <tr>                                        
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_reino_organismo"]}<td >:<td>{ucfirst(strtolower($datos.Dar_ReinoOrganismo))|default:''}
                                        <tr>                                        
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_division"]}<td >:<td >{$datos.Dar_Division|default:''} 
                                        <tr>                                        
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_clase_organismo"]}<td >:<td >{$datos.Dar_ClaseOrganismo|default:''}
                                        <tr>   
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_orden_organismo"]}<td >:<td >{$datos.Dar_OrdenOrganismo|default:''}           
                                        <tr>  
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_familia_organismo"]}<td >:<td >{$datos.Dar_FamiliaOrganismo|default:''}           
                                        <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_genero_organismo"]}<td >:<td >{$datos.Dar_GeneroOrganismo|default:''}           
                                        <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_especie_organismo"]}<td >:<td >{$datos.Dar_EspecieOrganismo|default:''}           
                                        <tr>  
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_subespecie_organismo"]}<td >:<td >{$datos.Dar_SubEspecieOrganismo|default:''}           
                                        <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_autor_nombre_cientifico"]}<td >:<td >{$datos.Dar_AutorNombreCientifico|default:''}           
                                        <tr> 
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_identificado_por"]}<td >:<td >{$datos.Dar_IdentificadorPor|default:''}           
                                        <tr>
                                           <td class="col-md-3 text-right">{$lenguaje["tabla_campo_fecha_identificacion"]}<td >:<td >{$datos.Dar_AnoIndentificacion|default:''}{$datos.Dar_MesIdentificacion|default:''}{$datos.Dar_DiaIdentificacion|default:''}           
                                        <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_status_tipo"]}<td >:<td > 
                                            {$datos.Dar_StatusTipo|default:''}          
                                        <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_numero_colector"]}<td >:<td >{$datos.Dar_NumeroColector|default:''}           
                                        <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_numero_campo"]}<td >:<td >{$datos.Dar_NumeroCampo|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_colector"]}<td >:<td >{$datos.Dar_Colector|default:''}           
                                        <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_fecha_colectado"]}<td >:<td >{$datos.Dar_AnoColectado|default:''}{$datos.Dar_MesColectado|default:''}{$datos.Dar_DiaColectado|default:''}                 
                                        <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_diario_colectado"]}<td >:<td >{$datos.Dar_DiarioColectado|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_dia_ordinario"]}<td >:<td >{$datos.Dar_DiaOrdinario|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_hora_colectado"]}<td >:<td >{$datos.Dar_HoraColectado|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_continente_oceano"]}<td >:<td >{$datos.Dar_ContinenteOceano|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_pais"]}<td >:<td >{$datos.Dar_Pais|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_estado_provincia"]}<td >:<td >{$datos.Dar_EstadoProvincia|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_municipio"]}<td >:<td >{$datos.Dar_Municipio|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_localidad"]}<td >:<td >{$datos.Dar_Localidad|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_precision_coordenada"]}<td >:<td >{$datos.Dar_PrecisionDeCoordenada|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_bounding_box"]}<td >:<td >{$datos.Dar_BoundingBox|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_minima_elevacion"]}<td >:<td >{$datos.Dar_MinimaElevacion|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_maxima_elevacion"]}<td >:<td >{$datos.Dar_MaximaElevacion|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_minima_profundidad"]}<td >:<td >{$datos.Dar_MinimaProfundidad|default:''}
                                         <tr>  
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_maxima_profundidad"]}<td >:<td >{$datos.Dar_MaximaProfundidad|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_sexo_organismo"]}<td >:<td >{$datos.Dar_SexoOrganismo|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_preparacion_tipo"]}<td >:<td >{$datos.Dar_PreparacionTipo|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_conteo_individuo"]}<td >:<td >{$datos.Dar_ConteoIndividuo|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_numero_catalogo_anterior"]}<td >:<td >{$datos.Dar_NumeroCatalogoAnterior|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_tipo_relacion"]}<td >:<td >{$datos.Dar_TipoRelacion|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_informacion_relacionada"]}<td >:<td >{$datos.Dar_InformacionRelacionada|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_estado_vida"]}<td >:<td >{$datos.Dar_EstadoVida|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_nota"]}<td >:<td >{$datos.Dar_Nota|default:''}
                                         <tr>
                                            <td class="col-md-3 text-right">{$lenguaje["tabla_campo_nombre_comun_organismo"]}<td >:<td >{$datos.Dar_NombreComunOrganismo|default:''}
                                         <tr>
                                                                          

                                </tbody>
                            </table>                              
                        </td>
            </tbody>
        </table>    
        </div>
</div>





{/foreach}
        
        
        
        
        
        </div>
    
    
    
    
    
               
 </div> 
 
</div>