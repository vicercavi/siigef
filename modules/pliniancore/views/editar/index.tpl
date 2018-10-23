<div class="container" >
  <div class="row">
        <div class="col-md-12">
            <h2 class="tit-pagina-principal" align="center">Editor PlinianCore</h2>
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
    <form data-toggle="validator" class="form-horizontal" role="form"  method="post" id="registrarplinian">
    <div class="panel panel-default">
      <div class="panel-heading">Datos Generales</div>
      <div class="panel-body">
      <div class="form-group">
        <label for="nombre_cientifico" class="col-md-4 control-label">{$ficha[0]['Fie_CampoFicha']} (*)</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Pli_NombreCientifico" name="Pli_NombreCientifico" 
                 placeholder="{$ficha[0]['Fie_CampoFicha']}" value="{$datos1.Pli_NombreCientifico|default:''}" required>
        </div>
      </div>
      <div class="form-group">
        <label for="acronimo_insitucion" class="col-md-4 control-label">{$ficha[1]['Fie_CampoFicha']} (*)</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Pli_AcronimoInstitucion" name="Pli_AcronimoInstitucion" 
                 placeholder="{$ficha[1]['Fie_CampoFicha']}" value="{$datos1.Pli_AcronimoInstitucion|default:''}" required>
        </div>
      </div>
      <div class="form-group">
        <label for="fecha_ultima_modificacion" class="col-md-4 control-label">{$ficha[2]['Fie_CampoFicha']} (*)</label>
        <div class="col-md-3">
          <input type="text" class="form-control" id="Pli_FechaUltimaModificacion" name="Pli_FechaUltimaModificacion" placeholder="dd/mm/yyyyy" value="{$datos1.Pli_FechaUltimaModificacion|default:''}" required>
        </div>
      </div>
      <div class="form-group">
        <label for="plinian_idioma" class="col-md-4 control-label">{$ficha[3]['Fie_CampoFicha']} (*)</label>
        <div class="col-md-3">
          <input type="text" class="form-control" id="Pli_Idioma" name="Pli_Idioma" 
                 placeholder="{$ficha[3]['Fie_CampoFicha']}" value="{$datos1.Pli_Idioma|default:''}" required>
        </div>
      </div>
      <div class="form-group">
        <label for="id_registro_taxon" class="col-md-4 control-label">{$ficha[4]['Fie_CampoFicha']} (*)</label>
        <div class="col-md-5">          
          <input type="text" class="form-control" id="Pli_IdRegistroTaxon" name="Pli_IdRegistroTaxon" 
                 placeholder="{$ficha[4]['Fie_CampoFicha']}" value="{$datos1.Pli_IdRegistroTaxon|default:''}" required>
        </div>
      </div>
      <div class="form-group">
        <label for="cita_sugerida" class="col-md-4 control-label">{$ficha[5]['Fie_CampoFicha']} (*)</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Pli_CitaSugerida" name="Pli_CitaSugerida" 
                 placeholder="{$ficha[5]['Fie_CampoFicha']}" value="{$datos1.Pli_CitaSugerida|default:''}" required>
        </div>
      </div>
      <div class="form-group">
        <label for="descripcion" class="col-md-4 control-label">{$ficha[6]['Fie_CampoFicha']} (*)</label>
        <div class="col-md-5">
          <input type="text" class="form-control" id="Pli_Distribucion" name="Pli_Distribucion" 
                 placeholder="{$ficha[6]['Fie_CampoFicha']}" value="{$datos1.Pli_Distribucion|default:''}" required>
        </div>
      </div>
      <div class="form-group">
        <label for="descripcion_general" class="col-md-4 control-label">{$ficha[7]['Fie_CampoFicha']} (*)</label>
        <div class="col-md-5">
          <textarea class="form-control" rows="3" id="Pli_DescripcionGeneral" name="Pli_DescripcionGeneral" placeholder="{$ficha[7]['Fie_CampoFicha']}" required>{$datos1.Pli_DescripcionGeneral|default:''}</textarea>
        </div>
      </div>
      </div>
    </div>      
                  
    <div class="panel panel-default">
      <div class="panel-heading jsoftCollap">                    
          <h3 aria-expanded="false" data-toggle="collapse" href="#collapse1" class="panel-title collapsed">
          <i style="float:right"class="fa fa-ellipsis-v"></i><i class="glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;<strong>Datos Taxonómicos</strong></h3>  
      </div>
    </div>

    <div aria-expanded="false" id="collapse1" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="form-group">
          <label for="reino" class="col-md-4 control-label">{$ficha[8]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text" class="form-control" id="Pli_Reino" name="Pli_Reino" 
                   placeholder="{$ficha[8]['Fie_CampoFicha']}" value="{$datos1.Pli_Reino|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="phylum" class="col-md-4 control-label">{$ficha[9]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text" class="form-control" id="Pli_Phylum" name="Pli_Phylum"
                   placeholder="{$ficha[9]['Fie_CampoFicha']}" value="{$datos1.Pli_Phylum|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="clase" class="col-md-4 control-label">{$ficha[10]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text" class="form-control" id="Pli_Clase" name="Pli_Clase"
                   placeholder="{$ficha[10]['Fie_CampoFicha']}" value="{$datos1.Pli_Clase|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="orden" class="col-md-4 control-label">{$ficha[11]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text" class="form-control" id="Pli_Orden" name="Pli_Orden" 
                   placeholder="{$ficha[11]['Fie_CampoFicha']}" value="{$datos1.Pli_Orden|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="familia" class="col-md-4 control-label">{$ficha[12]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text" class="form-control" id="Pli_Familia" name="Pli_Familia" 
                   placeholder="{$ficha[12]['Fie_CampoFicha']}" value="{$datos1.Pli_Familia|default:''}">          
          </div>
        </div>
        <div class="form-group">
          <label for="genero" class="col-md-4 control-label">{$ficha[13]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text" class="form-control" id="Pli_Genero" name="Pli_Genero" 
                   placeholder="{$ficha[13]['Fie_CampoFicha']}" value="{$datos1.Pli_Genero|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="especie" class="col-md-4 control-label">{$ficha[14]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text" class="form-control" id="Pli_Sinonimia" name="Pli_Sinonimia"
                   placeholder="{$ficha[14]['Fie_CampoFicha']}" value="{$datos1.Pli_Sinonimia|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="autor_fecha_taxon" class="col-md-4 control-label">{$ficha[15]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text" class="form-control" id="Pli_AutorFechaTaxon" name="Pli_AutorFechaTaxon"
                   placeholder="{$ficha[15]['Fie_CampoFicha']}" value="{$datos1.Pli_AutorFechaTaxon|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="especies_referencias_publicacion" class="col-md-4 control-label">{$ficha[16]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text" class="form-control" id="Pli_EspeciesReferenciasPublicacion" name="Pli_EspeciesReferenciasPublicacion"
                   placeholder="{$ficha[16]['Fie_CampoFicha']}" value="{$datos1.Pli_EspeciesReferenciasPublicacion|default:''}">
          </div>
        </div>  
        <div class="form-group">
          <label for="nombres_comunes" class="col-md-4 control-label">{$ficha[17]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_NombresComunes" name="Pli_NombresComunes"
                   placeholder="{$ficha[17]['Fie_CampoFicha']}" value="{$datos1.Pli_NombresComunes|default:''}">
          </div>
        </div>         
        <div class="form-group">
          <label for="informacion_tipos" class="col-md-4 control-label">{$ficha[18]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_InformacionTipos" name="Pli_InformacionTipos"
                   placeholder="{$ficha[18]['Fie_CampoFicha']}" value="{$datos1.Pli_InformacionTipos|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="identificador_unico_global" class="col-md-4 control-label">{$ficha[19]['Fie_CampoFicha']}</label>
          <div class="col-md-3">
            <input type="text"  class="form-control" id="Pli_IdentificadorUnicoGlobal" name="Pli_IdentificadorUnicoGlobal"
                   placeholder="{$ficha[19]['Fie_CampoFicha']}" value="{$datos1.Pli_IdentificadorUnicoGlobal|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="colaboradores" class="col-md-4 control-label">{$ficha[20]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_Colaboradores" name="Pli_Colaboradores"
                   placeholder="{$ficha[20]['Fie_CampoFicha']}" value="{$datos1.Pli_Colaboradores|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="fecha_creacion" class="col-md-4 control-label">{$ficha[21]['Fie_CampoFicha']}</label>
          <div class="col-md-3">
            <input type="text" class="form-control" id="Pli_FechaCreacion" name="Pli_FechaCreacion" placeholder="dd/mm/yyyy" value="{$datos1.Pli_FechaCreacion|default:''}">
          </div>
        </div>
      </div>      
    </div>  
    <div class="panel panel-default">
      <div class="panel-heading jsoftCollap">                    
          <h3 aria-expanded="false" data-toggle="collapse" href="#collapse2" class="panel-title collapsed">
          <i style="float:right"class="fa fa-ellipsis-v"></i><i class="glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;<strong>Ciclo Biológico</strong></h3>
      </div>
    </div>
    <div aria-expanded="false" id="collapse2" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="form-group">
          <label for="habito" class="col-md-4 control-label">{$ficha[22]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_Habito" name="Pli_Habito"
                   placeholder="{$ficha[22]['Fie_CampoFicha']}" value="{$datos1.Pli_Habito|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="ciclo_vida" class="col-md-4 control-label">{$ficha[23]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_CicloVida" name="Pli_CicloVida"
                   placeholder="{$ficha[23]['Fie_CampoFicha']}" value="{$datos1.Pli_CicloVida|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="reproduccion" class="col-md-4 control-label">{$ficha[24]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_Reproduccion" name="Pli_Reproduccion"
                   placeholder="{$ficha[24]['Fie_CampoFicha']}" value="{$datos1.Pli_Reproduccion|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="ciclo_anual" class="col-md-4 control-label">{$ficha[25]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_CicloAnual" name="Pli_CicloAnual"
                   placeholder="{$ficha[25]['Fie_CampoFicha']}" value="{$datos1.Pli_CicloAnual|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="descripcion_cientifica" class="col-md-4 control-label">{$ficha[26]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <textarea class="form-control" rows="3" id="Pli_DescripcionCientifica" name="Pli_DescripcionCientifica" placeholder="{$ficha[26]['Fie_CampoFicha']}">{$datos1.Pli_DescripcionCientifica|default:''}</textarea>          
          </div>
        </div>
        <div class="form-group">
          <label for="breve_descripcion" class="col-md-4 control-label">{$ficha[27]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <textarea class="form-control" rows="3" id="Pli_BreveDescripcion" name="Pli_BreveDescripcion" placeholder="{$ficha[27]['Fie_CampoFicha']}">{$datos1.Pli_BreveDescripcion|default:''}</textarea>          
          </div>
        </div>
        <div class="form-group">
          <label for="alimentacion" class="col-md-4 control-label">{$ficha[28]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_Alimentacion" name="Pli_Alimentacion"
                   placeholder="{$ficha[28]['Fie_CampoFicha']}" value="{$datos1.Pli_Alimentacion|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="comportamiento" class="col-md-4 control-label">{$ficha[29]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_Comportamiento" name="Pli_Comportamiento"
                   placeholder="{$ficha[29]['Fie_CampoFicha']}" value="{$datos1.Pli_Comportamiento|default:''}">
          </div>        
        </div>
        <div class="form-group">
          <label for="interacciones" class="col-md-4 control-label">{$ficha[30]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_Interacciones" name="Pli_Interacciones"
                   placeholder="{$ficha[30]['Fie_CampoFicha']}" value="{$datos1.Pli_Interacciones|default:''}">
          </div>
        </div>
      </div>
    </div>
    
    <div class="panel panel-default">
      <div class="panel-heading jsoftCollap">                    
          <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed">
          <i style="float:right"class="fa fa-ellipsis-v"></i><i class="glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;<strong>Genética</strong></h3>  
      </div>
    </div>

    <div aria-expanded="false" id="collapse3" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="form-group">
          <label for="numero_cromosomas" class="col-md-4 control-label">{$ficha[31]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_NumeroCromosomas" name="Pli_NumeroCromosomas"
                   placeholder="{$ficha[31]['Fie_CampoFicha']}" value="{$datos1.Pli_NumeroCromosomas|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="datos_moleculares" class="col-md-4 control-label">{$ficha[32]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_DatosMoleculares" name="Pli_DatosMoleculares"
                   placeholder="{$ficha[32]['Fie_CampoFicha']}" value="{$datos1.Pli_DatosMoleculares|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="estado_act_poblacion" class="col-md-4 control-label">{$ficha[33]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_EstadoActPoblacion" name="Pli_EstadoActPoblacion"
                   placeholder="{$ficha[33]['Fie_CampoFicha']}" value="{$datos1.Pli_EstadoActPoblacion|default:''}">
          </div>
        </div>
      </div>
    </div>  

    <div class="panel panel-default">
      <div class="panel-heading jsoftCollap">                    
          <h3 aria-expanded="false" data-toggle="collapse" href="#collapse4" class="panel-title collapsed">
          <i style="float:right"class="fa fa-ellipsis-v"></i><i class="glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;<strong>Legislación</strong></h3>  
      </div>
    </div>
    <div aria-expanded="false" id="collapse4" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="form-group">
          <label for="estado_uicn" class="col-md-4 control-label">{$ficha[34]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_EstadoUICN" name="Pli_EstadoUICN"
                   placeholder="{$ficha[34]['Fie_CampoFicha']}" value="{$datos1.Pli_EstadoUICN|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="estado_leg_nacional" class="col-md-4 control-label">{$ficha[35]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_EstadoLegNacional" name="Pli_EstadoLegNacional"
                   placeholder="{$ficha[35]['Fie_CampoFicha']}" value="{$datos1.Pli_EstadoLegNacional|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="habitat" class="col-md-4 control-label">{$ficha[36]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_Habitat" name="Pli_Habitat"
                   placeholder="{$ficha[36]['Fie_CampoFicha']}" value="{$datos1.Pli_Habitat|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="territorialidad" class="col-md-4 control-label">{$ficha[37]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_Territorialidad" name="Pli_Territorialidad"
                   placeholder="{$ficha[37]['Fie_CampoFicha']}" value="{$datos1.Pli_Territorialidad|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="endemismo" class="col-md-4 control-label">{$ficha[38]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_Endemismo" name="Pli_Endemismo"
                   placeholder="{$ficha[38]['Fie_CampoFicha']}" value="{$datos1.Pli_Endemismo|default:''}">
          </div>
        </div>
      </div>
    </div>
    
    <div class="panel panel-default">
      <div class="panel-heading jsoftCollap">                    
          <h3 aria-expanded="false" data-toggle="collapse" href="#collapse5" class="panel-title collapsed">
          <i style="float:right"class="fa fa-ellipsis-v"></i><i class="glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;<strong>Usos</strong></h3>  
      </div>
    </div>
    <div aria-expanded="false" id="collapse5" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="form-group">
        <label for="usos" class="col-md-4 control-label">{$ficha[39]['Fie_CampoFicha']}</label>
        <div class="col-md-5">
          <textarea class="form-control" rows="3" id="Pli_Usos" name="Pli_Usos" placeholder="{$ficha[39]['Fie_CampoFicha']}">{$datos1.Pli_Usos|default:''}</textarea>
        </div>
        </div>
        <div class="form-group">
          <label for="manejo" class="col-md-4 control-label">{$ficha[40]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <textarea class="form-control" rows="3" id="Pli_Manejo" name="Pli_Manejo" placeholder="{$ficha[40]['Fie_CampoFicha']}">{$datos1.Pli_Manejo|default:''}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="Folklore" class="col-md-4 control-label">{$ficha[41]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_Folklore" name="Pli_Folklore"
                   placeholder="{$ficha[41]['Fie_CampoFicha']}" value="{$datos1.Pli_Folklore|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="referencias_bibliograficas" class="col-md-4 control-label">{$ficha[42]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_ReferenciasBibliograficas" name="Pli_ReferenciasBibliograficas"
                   placeholder="{$ficha[42]['Fie_CampoFicha']}" value="{$datos1.Pli_ReferenciasBibliograficas|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="documentacion_no_estructurada" class="col-md-4 control-label">{$ficha[43]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_DocumentacionNoEstructurada" name="Pli_DocumentacionNoEstructurada"
                   placeholder="{$ficha[43]['Fie_CampoFicha']}" value="{$datos1.Pli_DocumentacionNoEstructurada|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="otra_fuente_informacion" class="col-md-4 control-label">{$ficha[44]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_OtraFuenteInformacion" name="Pli_OtraFuenteInformacion"
                   placeholder="{$ficha[44]['Fie_CampoFicha']}" value="{$datos1.Pli_OtraFuenteInformacion|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="articulo_cientifico" class="col-md-4 control-label">{$ficha[45]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_ArticuloCientifico" name="Pli_ArticuloCientifico"
                   placeholder="{$ficha[45]['Fie_CampoFicha']}" value="{$datos1.Pli_ArticuloCientifico|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="claves_taxonomicas" class="col-md-4 control-label">{$ficha[46]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_ClavesTaxonomicas" name="Pli_ClavesTaxonomicas"
                   placeholder="{$ficha[46]['Fie_CampoFicha']}" value="{$datos1.Pli_ClavesTaxonomicas|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="datos_migrados" class="col-md-4 control-label">{$ficha[47]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_DatosMigrados" name="Pli_DatosMigrados"
                   placeholder="{$ficha[47]['Fie_CampoFicha']}" value="{$datos1.Pli_DatosMigrados|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="importancia_ecologica" class="col-md-4 control-label">{$ficha[48]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_ImportanciaEcologica" name="Pli_ImportanciaEcologica"
                   placeholder="{$ficha[48]['Fie_CampoFicha']}" value="{$datos1.Pli_ImportanciaEcologica|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="historia_natural_no_estructurada" class="col-md-4 control-label">{$ficha[49]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_HistoriaNaturalNoEstructurada" name="Pli_HistoriaNaturalNoEstructurada"
                   placeholder="{$ficha[49]['Fie_CampoFicha']}" value="{$datos1.Pli_HistoriaNaturalNoEstructurada|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="datos_invasividad" class="col-md-4 control-label">{$ficha[50]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_DatosInvasividad" name="Pli_DatosInvasividad"
                   placeholder="{$ficha[50]['Fie_CampoFicha']}" value="{$datos1.Pli_DatosInvasividad|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="publico_objetivo" class="col-md-4 control-label">{$ficha[51]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_PublicoObjetivo" name="Pli_PublicoObjetivo"
                   placeholder="{$ficha[51]['Fie_CampoFicha']}" value="{$datos1.Pli_PublicoObjetivo|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="version" class="col-md-4 control-label">{$ficha[52]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_Version" name="Pli_Version"
                   placeholder="{$ficha[52]['Fie_CampoFicha']}" value="{$datos1.Pli_Version|default:''}">
          </div>
        </div>
      </div>
    </div>
    
    <div class="panel panel-default">
      <div class="panel-heading jsoftCollap">                    
          <h3 aria-expanded="false" data-toggle="collapse" href="#collapse6" class="panel-title collapsed">
          <i style="float:right"class="fa fa-ellipsis-v"></i><i class="glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;<strong>Infografía</strong></h3>  
      </div>
    </div>
    <div aria-expanded="false" id="collapse6" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="form-group">
          <label for="url_imagen1" class="col-md-4 control-label">{$ficha[53]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_URLImagen1" name="Pli_URLImagen1"
                   placeholder="{$ficha[53]['Fie_CampoFicha']}" value="{$datos1.Pli_URLImagen1|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="pie_imagen1" class="col-md-4 control-label">{$ficha[54]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_PieImagen1" name="Pli_PieImagen1"
                   placeholder="{$ficha[54]['Fie_CampoFicha']}" value="{$datos1.Pli_PieImagen1|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="url_imagen2" class="col-md-4 control-label">{$ficha[55]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_URLImagen2" name="Pli_URLImagen2"
                   placeholder="{$ficha[55]['Fie_CampoFicha']}" value="{$datos1.Pli_URLImagen2|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="pie_imagen2" class="col-md-4 control-label">{$ficha[56]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_PieImagen2" name="Pli_PieImagen2"
                   placeholder="{$ficha[56]['Fie_CampoFicha']}" value="{$datos1.Pli_PieImagen2|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="url_imagen3" class="col-md-4 control-label">{$ficha[57]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_URLImagen3" name="Pli_URLImagen3"
                   placeholder="{$ficha[57]['Fie_CampoFicha']}" value="{$datos1.Pli_URLImagen3|default:''}">
          </div>
        </div>
        <div class="form-group">
          <label for="pie_imagen3" class="col-md-4 control-label">{$ficha[58]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_PieImagen3" name="Pli_PieImagen3"
                   placeholder="{$ficha[58]['Fie_CampoFicha']}" value="{$datos1.Pli_PieImagen3|default:''}">
          </div>
        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading jsoftCollap">                    
          <h3 aria-expanded="false" data-toggle="collapse" href="#collapse7" class="panel-title collapsed">
          <i style="float:right"class="fa fa-ellipsis-v"></i><i class="glyphicon glyphicon-arrow-down"></i>&nbsp;&nbsp;<strong>Imagen</strong></h3>  
      </div>
    </div>
    <div aria-expanded="false" id="collapse7" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="form-group">
          <label for="imagen" class="col-md-4 control-label">{$ficha[59]['Fie_CampoFicha']}</label>
          <div class="col-md-5">
            <input type="text"  class="form-control" id="Pli_Imagen" name="Pli_Imagen"
                   placeholder="{$ficha[59]['Fie_CampoFicha']}" value="{$datos1.Pli_Imagen|default:''}">
          </div>
        </div>
      </div>
    </div>
      
      <div class="form-group">
        <div class="col-md-offset-4 col-md-5">
          <button type="submit" class="btn btn-primary">Actualizar</button>
        <input type="hidden" value="1" name="editarPlinian" />
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

