<style> 
#raizaMenu {
   padding-top: 10px;   
}
@media (min-width: 1200px){
  #raizaMenu {  
     margin-left: 8.33333333%;
  }
}
@media(max-width: 991px){
  #raizaMenu ul{
      height: 30px !important;
  }
}
#raizaMenu ul{
   list-style: none;
   width: 100%;
    height: 30px;
      padding: 0px 10px;
}
#raizaMenu li{
   top: 3px;
   margin: 0px 2px;
   float: left;
}
#raizaMenu li .actual{
  color: #444f4a;
}
#raizaMenu a{
   margin: 0px 3px;
   color: #03a506;
}
  
</style> 

<div id="raizaMenu" clas="col-xs-3 col-sm-3 col-md-2 col-lg-2">
  <ul clas="col-xs-3 col-sm-3 col-md-2 col-lg-2">
    <li>
      <a href="{$_layoutParams.root}">{$lenguaje["label_inicio"]} </a>
    </li>
    <li>/</li>
    <li>
      <a href="{$_layoutParams.root}atlas/botanico">{$lenguaje["label_titulo_botanico"]} </a>
    </li>
    <li>/</li>
    <li>
      <a class='actual' >{$lenguaje["metadata_infoespecie_botanico"]} </a>
    </li>
  </ul>     
</div>


<div class="container col-lg-12">
  <div class="row">
    <div class="col-md-12">
      <h2 class="tit-pagina-principal"><center>{$lenguaje["metadata_infoespecie_botanico"]}</center></h2>
      <input id="metodo" name="metodo" type="hidden" value="buscarporpalabras"/>
      <input id="query" name="query" type="hidden"/>
    </div> 
    
    <h4 align="center">{$datos.Pli_NombreCientifico}</h4>
    <br />
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-offset-1 col-lg-3 ">
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


    <div class="col-xs-12 col-sm-8 col-md-offset-0 col-md-9 col-lg-offset-0 col-lg-7">


      <div class="panel panel-default">     
        <div class="table-responsive">
          <table class="table table-user-information">       
            <tbody>
              <tr>
                <td class="col-md-3" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);">{$lenguaje["metadata_datostaxon_botanico"]}</td>        
                <td>
                    <table class="table table-user-information">
                          <tr>
                           <td class="col-md-2 text-right" style="border:none;">{$lenguaje["label_nombrecientifico_botanico"]}</td>
                           <td style="border:none;">:</td>
                           <td style="border:none;">
                            <div  class="row">
                                <div class="col-md-7">
                                <b>{ucfirst(strtolower($datos.Pli_NombreCientifico))}</b> 
                            </div>
                             <div class="col-md-4">
                                <a href="https:///www.bing.com/images/search?q=%2b{urlencode($datos.Pli_NombreCientifico)}" target="_blank" class="btn btn-info pull-rigth"><span class="glyphicon glyphicon-camera"></span>&nbsp;{$lenguaje["metadata_fotosweb_botanico"]}</a><font size="-2"></font></span>
                            </div>
                          
                            </div>
                            

                           </td>
                         </tr>
                          <tr>
                           <td class="col-md-2 text-right">{$lenguaje["metadata_nomcomun_botanico"]}</td>
                           <td>:</td>
                           <td><b>{ucfirst(strtolower($datos.Pli_NombresComunes))}</b></td>
                         </tr> 
                         <tr>                        
                         <tr>
                           <td class="col-md-2 text-right">{$lenguaje["metadata_reino_botanico"]}</td>
                           <td>:</td>
                           <td><b>{ucfirst(strtolower($datos.Pli_Reino))}</b></td>
                         </tr>
                         <tr>
                           <td class="col-md-2 text-right">{$lenguaje["metadata_phylum_botanico"]}</td>
                           <td>:</td>
                           <td><b>{ucfirst(strtolower($datos.Pli_Phylum))}</b></td>
                         </tr>
                         <tr>
                           <td class="col-md-2 text-right">{$lenguaje["metadata_clase_botanico"]}</td>
                           <td>:</td>
                           <td><b>{ucfirst(strtolower($datos.Pli_Clase))}</b></td>
                         </tr>
                         <tr>
                           <td class="col-md-2 text-right">{$lenguaje["label_orden_botanico"]}</td>
                           <td>:</td>
                           <td><b>{ucfirst(strtolower($datos.Pli_Orden))}</b></td>
                         </tr>
                         <tr>
                           <td class="col-md-2 text-right">{$lenguaje["label_familia_botanico"]}</td>
                           <td>:</td>
                           <td><b>{ucfirst(strtolower($datos.Pli_Familia))}</b></td>
                         </tr>
                         <tr>
                           <td class="col-md-2 text-right">{$lenguaje["metadata_genero_botanico"]}</td>
                           <td>:</td>
                           <td><b>{ucfirst(strtolower($datos.Pli_Genero))}</b></td>
                         </tr> 
                         <tr>
                           <td class="col-md-2 text-right">{$lenguaje["metadata_sinonimia_botanico"]}</td>
                           <td>:</td>
                           <td><b>{ucfirst(strtolower($datos.Pli_Sinonimia))}</b></td>
                         </tr> 
                         <tr>
                           <td class="col-md-2 text-right">{$lenguaje["metadata_auttaxon_botanico"]}</td>
                           <td>:</td>
                           <td><b>{ucfirst(strtolower($datos.Pli_AutorFechaTaxon))}</b></td>
                         </tr>
                         <tr>
                           <td class="col-md-2 text-right">{$lenguaje["metadata_fechpub_botanico"]}</td>
                           <td>:</td>
                           <td><b></b></td>
                         </tr>                         
                         <tr>
                           <td class="col-md-2 text-right">{$lenguaje["metadata_infotipo_botanico"]}</td>
                           <td>:</td>
                           <td><b>{ucfirst(strtolower($datos.Pli_InformacionTipos))}</b></td>
                         </tr>
                         <tr>
                           <td class="col-md-2 text-right">{$lenguaje["metadata_idunico_botanico"]}</td>
                           <td>:</td>
                           <td><b>{ucfirst(strtolower($datos.Pli_IdentificadorUnicoGlobal))}</b></td>
                         </tr>
                         <tr>
                           <td class="col-md-2 text-right">{$lenguaje["metadata_colabo_botanico"]}</td>
                           <td>:</td>
                           <td><b>{ucfirst(strtolower($datos.Pli_Colaboradores))}</b></td>
                         </tr>
                         <tr>
                           <td class="col-md-2 text-right">{$lenguaje["metadata_fechcrea_botanico"]}</td>
                           <td>:</td>
                           <td><b>{ucfirst(strtolower($datos.Pli_FechaCreacion))}</b></td>
                         </tr>
                    </table>
             </td>
           </tr>
           <tr>
            <td class="col-md-2 text-right" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);">{$lenguaje["metadata_otrosdatos_botanico"]}</td>        
            <td>


              <table class="table">

                <tbody>


                  <tr>
                    <td class="col-md-2 text-right" style="border:none;">{$lenguaje["metadata_acronimo_botanico"]}</td>
                    <td style="border:none;">:</td>
                    <td style="border:none;"><b>{ucfirst(strtolower($datos.Pli_AcronimoInstitucion))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_fechmodif_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_FechaUltimaModificacion))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_idtaxon_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_IdRegistroTaxon))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_idioma_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_Idioma))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_cita_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_CitaSugerida))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_distri_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_Distribucion))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_descrigeneral_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_DescripcionGeneral))}</b></td>
                  </tr>
                </tbody>
              </table>



            </td>
          </tr>
          <tr>
            <td class="col-md-2 text-right" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);">{$lenguaje["metadata_ciclobiologico_botanico"]}</td>        
            <td>


              <table class="table">

                <tbody>


                  <tr>
                    <td class="col-md-2 text-right" style="border:none;">{$lenguaje["metadata_habito_botanico"]}</td>
                    <td style="border:none;">:</td>
                    <td style="border:none;"><b>{ucfirst(strtolower($datos.Pli_Habito))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_ciclovida_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_CicloVida))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_reproduccion_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_Reproduccion))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_cicloanual_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_CicloAnual))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_descricientifica_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_DescripcionCientifica))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_brevedescripcion_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_BreveDescripcion))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_alimentacion_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_Alimentacion))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_comportamiento_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_Comportamiento))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_interacciones_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_Interacciones))}</b></td>
                  </tr>      
                </tbody>
              </table>


            </td>
          </tr>
          <tr>
            <td class="col-md-2 text-right" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);">{$lenguaje["metadata_genetica_botanico"]}</td>        
            <td>


              <table class="table">

                <tbody>


                  <tr>
                    <td class="col-md-2 text-right" style="border:none;">{$lenguaje["metadata_numerocromosomas_botanico"]}</td>
                    <td style="border:none;">:</td>
                    <td style="border:none;">{ucfirst(strtolower($datos.Pli_NumeroCromosomas))}</b></td>
                  </tr>

                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_datosmoleculares_botanico"]}</td>
                    <td>:</td>
                    <td>{ucfirst(strtolower($datos.Pli_DatosMoleculares))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_estactpob_botanico"]}</td>
                    <td>:</td>
                    <td>{ucfirst(strtolower($datos.Pli_EstadoActPoblacion))}</b></td>
                  </tr>
                </tbody>
              </table>



            </td>
          </tr>
          <tr>
            <td class="col-md-2 text-right" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);">{$lenguaje["metadata_legislacion_botanico"]}</td>        
            <td>


              <table class="table">

                <tbody>


                  <tr>
                    <td class="col-md-2 text-right" style="border:none;">{$lenguaje["metadata_uicn_botanico"]}</td>
                    <td style="border:none;">:</td>
                    <td style="border:none;"><b>{ucfirst(strtolower($datos.Pli_EstadoUICN))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_estadolegislacion_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_EstadoLegNacional))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_habitat_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_Habitat))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_territorialidad_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_Territorialidad))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_endemismo_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_Endemismo))}</b></td>
                  </tr>
                </tbody>
              </table>




            </td>
          </tr>
          <tr>
            <td class="col-md-2 text-right" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);">{$lenguaje["metadata_usos_botanico"]}</td>        
            <td>


              <table class="table">

                <tbody>


                  <tr>
                    <td class="col-md-2 text-right" style="border:none;">{$lenguaje["metadata_usos_botanico"]}</td>
                    <td style="border:none;">:</td>
                    <td style="border:none;"><b>{ucfirst(strtolower($datos.Pli_Usos))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_manejo_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_Manejo))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_folklore_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_Folklore))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_refbiblio_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_ReferenciasBibliograficas))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_docenostruc_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_DocumentacionNoEstructurada))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_otrafuenteinfo_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_OtraFuenteInformacion))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_articienti_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_ArticuloCientifico))}</b></td>
                  </tr>
                  <tr>
                    <td class="col-md-2 text-right">{$lenguaje["metadata_clavetaxo_botanico"]}</td>
                    <td>:</td>
                    <td><b>{ucfirst(strtolower($datos.Pli_ClavesTaxonomicas))}</b></td>
                  </tr><tr>
                  <td class="col-md-2 text-right">{$lenguaje["metadata_datomigrad_botanico"]}</td>
                  <td>:</td>
                  <td><b>{ucfirst(strtolower($datos.Pli_DatosMigrados))}</b></td>
                </tr>
                <tr>
                  <td class="col-md-2 text-right">{$lenguaje["metadata_importecologi_botanico"]}</td>
                  <td>:</td>
                  <td><b>{ucfirst(strtolower($datos.Pli_ImportanciaEcologica))}</b></td>
                </tr>
                <tr>
                  <td class="col-md-2 text-right">{$lenguaje["metadata_histnatura_botanico"]}</td>
                  <td>:</td>
                  <td><b>{ucfirst(strtolower($datos.Pli_HistoriaNaturalNoEstructurada))}</b></td>
                </tr>
                <tr>
                  <td class="col-md-2 text-right">{$lenguaje["metadata_datoinvasi_botanico"]}</td>
                  <td>:</td>
                  <td><b>{ucfirst(strtolower($datos.Pli_DatosInvasividad))}</b></td>
                </tr>
                <tr>
                  <td class="col-md-2 text-right">{$lenguaje["metadata_pubobje_botanico"]}</td>
                  <td>:</td>
                  <td><b>{ucfirst(strtolower($datos.Pli_PublicoObjetivo))}</b></td>
                </tr>
                <tr>
                  <td class="col-md-2 text-right">{$lenguaje["metadata_version_botanico"]}</td>
                  <td>:</td>
                  <td><b>{ucfirst(strtolower($datos.Pli_Version))}</b></td>
                </tr>

              </tbody>
            </table>



          </td>
        </tr>
        <tr>
          <td class="col-md-2 text-right" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);">{$lenguaje["metadata_infografia_botanico"]}</td>        
          <td>



            <table class="table">

              <tbody>


                <tr>
                  <td class="col-md-2 text-right" style="border:none;">{$lenguaje["metadata_url1_botanico"]}</td>
                  <td style="border:none;">:</td>
                  <td style="border:none;"><b>{ucfirst(strtolower($datos.Pli_URLImagen1))}</b></td>
                </tr>
                <tr>
                  <td class="col-md-2 text-right">{$lenguaje["metadata_pie1_botanico"]}</td>
                  <td>:</td>
                  <td><b>{ucfirst(strtolower($datos.Pli_PieImagen1))}</b></td>
                </tr>
                <tr>
                  <td class="col-md-2 text-right">{$lenguaje["metadata_url2_botanico"]}</td>
                  <td>:</td>
                  <td><b>{ucfirst(strtolower($datos.Pli_URLImagen2))}</b></td>
                </tr>
                <tr>
                  <td class="col-md-2 text-right">{$lenguaje["metadata_pie2_botanico"]}</td>
                  <td>:</td>
                  <td><b>{ucfirst(strtolower($datos.Pli_PieImagen2))}</b></td>
                </tr>
                <tr>
                  <td class="col-md-2 text-right">{$lenguaje["metadata_url3_botanico"]}</td>
                  <td>:</td>
                  <td><b>{ucfirst(strtolower($datos.Pli_PieImagen1))}</b></td>
                </tr>
                <tr>
                  <td class="col-md-2 text-right">{$lenguaje["metadata_pie3_botanico"]}</td>
                  <td>:</td>
                  <td><b>{ucfirst(strtolower($datos.Pli_PieImagen3))}</b></td>
                </tr>
              </tbody>
            </table>



          </td>
        </tr>      
      </tbody>
    </table>
  </div> 
</div>



</div> 

</div>  

</div>

