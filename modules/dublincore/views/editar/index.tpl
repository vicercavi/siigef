<div class="container-fluid" >
    <div class="row">
        <div class="col-md-12">
            <h3 class="titulo-view">Editor de DublinCore</h3>     
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
            {if  isset($datos) && count($datos)}
                <form data-toggle="validator" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" id="editardublin">
                    <input type="hidden" value="{$datos.Dub_IdDublinCore}" id="Dub_IdDublinCore" name="Dub_IdDublinCore" />
                    <input type="hidden" value="{$datos.Arf_IdArchivoFisico}" id="Arf_IdArchivoFisico" name="Arf_IdArchivoFisico" />
                    <input type="hidden" value="{$datos.Idi_IdIdioma}" id="Idi_IdIdiomaOriginal" name="Idi_IdIdiomaOriginal" />
                    <input type="hidden" value="{$datos.Arf_PosicionFisica}" id="Arf_PosicionFisica" name="Arf_PosicionFisica" />

                    <div id='gestion_idiomas' style="margin:5px 20px"><input type="hidden" id="idiomaSelect" name="idiomaSelect" value="{$datos.Idi_IdIdioma}" />
                        {if  isset($idiomas) && count($idiomas)}
                            <ul class="nav nav-tabs ">
                                {foreach from=$idiomas item=idi}
                                    <li role="presentation" class="{if $datos.Idi_IdIdioma == $idi.Idi_IdIdioma} active {/if}">
                                        <a class="idioma_s" id="idioma_{$idi.Idi_IdIdioma}" href="#">{$idi.Idi_Idioma}</a>
                                        <input type="hidden" id="hd_idioma_{$idi.Idi_IdIdioma}" value="{$idi.Idi_IdIdioma}" />
                                    </li>    
                                {/foreach}
                            </ul>
                        {/if}
                        <div class="panel panel-default">
                            <div class="panel-heading" >
                                <h4 class="panel-title">
                                    <strong>
                                        Editor de Documentos
                                    </strong>

                                </h4>

                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="titulo" class="col-md-4 control-label">{$ficha[0]['Fie_CampoFicha']} (*)</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{$datos.Dub_Titulo|default:''}" class="form-control" id="Dub_Titulo" name="Dub_Titulo" placeholder="{$ficha[0]['Fie_CampoFicha']}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion" class="col-md-4 control-label">{$ficha[1]['Fie_CampoFicha']} (*)</label>
                                    <div class="col-md-6">          
                                        <textarea class="form-control" rows="3" id="Dub_Descripcion" name="Dub_Descripcion" placeholder="{$ficha[1]['Fie_CampoFicha']}" required>{$datos.Dub_Descripcion|default:''}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="autor" class="col-md-4 control-label">{$ficha[15]['Fie_CampoFicha']} (*)</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{$datos.Aut_Nombre|default:''}" list="autores" class="form-control" id="Aut_IdAutor" name="Aut_IdAutor" placeholder="{$ficha[15]['Fie_CampoFicha']}" required>
                                        <datalist id="autores">
                                            {foreach item=aut from=$autores}
                                                <option value="{$aut.Aut_Nombre}"></option>
                                            {/foreach}    
                                        </datalist>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="editor" class="col-md-4 control-label">{$ficha[2]['Fie_CampoFicha']}</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{$datos.Dub_Editor|default:''}" class="form-control" id="Dub_Editor" name="Dub_Editor" 
                                               placeholder="{$ficha[2]['Fie_CampoFicha']}" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="colaborador" class="col-md-4 control-label">{$ficha[3]['Fie_CampoFicha']}</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{$datos.Dub_Colaborador|default:''}" class="form-control" id="Dub_Colabrorador" name="Dub_Colabrorador" 
                                               placeholder="{$ficha[3]['Fie_CampoFicha']}" >
                                    </div>
                                </div>            
                                <div class="form-group">
                                    <label for="fecha_documento" class="col-md-4 control-label">{$ficha[4]['Fie_CampoFicha']}</label>
                                    <div class="col-md-3">

                                        <input type="text" value="{$datos.Dub_FechaDocumento|default}" class="form-control" id="Dub_FechaDocumento" name="Dub_FechaDocumento"
                                               placeholder="dd/mm/yyyy" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="formato" class="col-md-4 control-label">{$ficha[5]['Fie_CampoFicha']}</label>
                                    <div class="col-md-3">
                                        <select class="form-control" id="Dub_Formato" name="Dub_Formato">
                                            {foreach from=$formatos_archivos item=ps}
                                                <option value="{$ps.Taf_IdTipoArchivoFisico}"
                                                        {if $datos.Taf_IdTipoArchivoFisico==$ps.Taf_IdTipoArchivoFisico} selected="selected" {/if}>
                                                    {$ps.Taf_Descripcion}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="identificador" class="col-md-4 control-label">{$ficha[6]['Fie_CampoFicha']}</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{$datos.Dub_Identificador|default:''}" class="form-control" id="Dub_Identificador" name="Dub_Identificador"
                                               placeholder="{$ficha[6]['Fie_CampoFicha']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fuente" class="col-md-4 control-label">{$ficha[7]['Fie_CampoFicha']}</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{$datos.Dub_Fuente|default:''}" class="form-control" id="Dub_Fuente" name="Dub_Fuente"
                                               placeholder="{$ficha[7]['Fie_CampoFicha']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dublin_idioma" class="col-md-4 control-label">{$ficha[8]['Fie_CampoFicha']}</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{$datos.Dub_Idioma|default:''}" class="form-control" id="Dub_Idioma" name="Dub_Idioma" 
                                               placeholder="{$ficha[8]['Fie_CampoFicha']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="relación_dublin" class="col-md-4 control-label">{$ficha[9]['Fie_CampoFicha']}</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{$datos.Dub_Relacion|default:''}" class="form-control" id="Dub_Relacion" name="Dub_Relacion" 
                                               placeholder="{$ficha[9]['Fie_CampoFicha']}">          
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cobertura_dublin" class="col-md-4 control-label">{$ficha[10]['Fie_CampoFicha']}</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{$datos.Dub_Cobertura|default:''}" class="form-control" id="Dub_Cobertura" name="Dub_Cobertura" 
                                               placeholder="{$ficha[10]['Fie_CampoFicha']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="derechos_dublin" class="col-md-4 control-label">{$ficha[11]['Fie_CampoFicha']}</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{$datos.Dub_Derechos|default:''}" class="form-control" id="Dub_Derechos" name="Dub_Derechos"
                                               placeholder="{$ficha[11]['Fie_CampoFicha']}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="palabras_claves" class="col-md-4 control-label">{$ficha[12]['Fie_CampoFicha']} (*)</label>
                                    <div class="col-md-6">        
                                        <input type="text" list="palabraclaves" value="{$datos.Dub_PalabraClave|default:''}" class="form-control" id="Dub_PalabraClave" name="Dub_PalabraClave" placeholder="{$ficha[12]['Fie_CampoFicha']}" required/>
                                        <datalist id="palabraclaves">
                                            {foreach item=pac from=$palabraclave}
                                                <option value="{$pac.Dub_PalabraClave}"></option>
                                            {/foreach}    
                                        </datalist>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tipo_dublin" class="col-md-4 control-label">{$ficha[14]['Fie_CampoFicha']} (*)</label>
                                    <div class="col-md-6">
                                        <input type="text" list="tiposdublin" value="{$datos.Tid_Descripcion|default:''}" class="form-control" id="Tid_IdTipoDublin" name="Tid_IdTipoDublin" placeholder="{$ficha[14]['Fie_CampoFicha']}" required/>
                                        <datalist id="tiposdublin">
                                            {foreach item=tid from=$tipodublin}
                                                <option value="{$tid.Tid_Descripcion}">
                                                {/foreach}    
                                        </datalist>
                                    </div>
                                </div>  
                                <div class="form-group">
                                    <label for="tema_dublin" class="col-md-4 control-label">{$ficha[19]['Fie_CampoFicha']} (*)</label>
                                    <div class="col-md-6">
                                        <input type="text" list="temasdublin" value="{$datos.Ted_Descripcion|default:''}" class="form-control" id="Ted_IdTemaDublin" name="Ted_IdTemaDublin" placeholder="{$ficha[19]['Fie_CampoFicha']}" required/>
                                        <datalist id="temasdublin">
                                            {foreach item=ted from=$temadublin}
                                                <option value="{$ted.Ted_Descripcion}">
                                                {/foreach}    
                                        </datalist>         
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile" class="col-md-4 control-label">{$ficha[18]['Fie_CampoFicha']}</label>
                                    <div class="col-md-5">
                                        <input type="file" id="Arf_IdArchivoFisico" name="Arf_IdArchivoFisico">
                                    </div>                                  
                                    <div class="col-md-1">
                                        {if !empty($datos.Arf_PosicionFisica)}
                                        <a title="Archivo adjunto" target="_blank" href="{$_layoutParams.root_archivo_fisico}{$datos.Arf_PosicionFisica}">
                                            <img src="{$_layoutParams.root}public/img/documentos/{$datos.Taf_Descripcion}.png"  alt="Doc Adjunto">
                                        </a>
                                        {/if}
                                        
                                    </div>
                                </div>      
                                <div class="form-group">
                                    <label for="url" class="col-md-4 control-label">{$ficha[20]['Fie_CampoFicha']}</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{$datos.Arf_URL|default:''}" class="form-control" id="Arf_URL" name="Arf_URL"
                                               placeholder="{$ficha[20]['Fie_CampoFicha']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pais" class="col-md-4 control-label">{$ficha[13]['Fie_CampoFicha']}</label>
                                    <div class="col-md-6">
                                        <input type="text" value="{$paises|default:''}" class="form-control" id="Pai_IdPais" name="Pai_IdPais"
                                               placeholder="{$ficha[13]['Fie_CampoFicha']}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-6">
                                        <button type="submit" id="editarDublin" name="editarDublin" class="btn btn-success">Actualizar</button>
                                    </div>
                                </div>    
                            </div> 
                        </div>
                    </div>
                </form>
            {/if}
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





