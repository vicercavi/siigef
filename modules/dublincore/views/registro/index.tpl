<div id="registrarDocumento" >
              
        <h1 align="center" >{$nombreRecurso}</h1>
        <h2 align="center">Registro Documento </h2>
    
    
        <form enctype="multipart/form-data" class="formulario" name="form_registro_documento" method="post" >
            <input id="registrar" type="hidden" value="1" name="registrar"  />   
            <input type="hidden" value="{$idrecurso}" name="recurso"/>
            <input type="hidden" value="{$cantidaRegistros}" name="cantidadRegistros"/>
            <div class="nuevo_dato">
                
            </div>
            <div id="form_registrar_documento" >
            <table class="table-registro-documento">
                <tr>
                    <td> <label>Idioma de Metadata :</label> </td>
                    <td> 
                        {if isset($idiomas) && count($idiomas)}
                        <select name="idIdiomaMetadata">
                            {foreach item=datos from=$idiomas}
                                <option  value="{$datos.Idi_IdIdioma|default:0}">{$datos.Idi_Idioma|default:"Selecionar Tema"}</option>
                            {/foreach}            
                        </select>
                        {/if}                        
                        <a href="{$_layoutParams.root}dublincore/registro/nuevoIdioma">Nuevo</a>
                    </td>
                </tr>    
                <tr>
                    <td> <label>Autor: </label> </td>
                    <td>
                        {if isset($autores) && count($autores)}
                        <select name="idAutor">
                            {foreach item=datos from=$autores}
                                <option  value="{$datos.Aut_IdAutor|default:0}">{$datos.Aut_Nombre|default:"Selecionar Autor"}</option>
                            {/foreach}            
                        </select>
                        {else}

                        {/if}
                        <a href="{$_layoutParams.root}dublincore/registro/nuevoAutor">Nuevo</a>
                    </td>
                </tr>
                <tr>
                    <td><label>Tema: </label> </td>
                    <td>
                        {if isset($temas) && count($temas)}
                        <select name="idTemaDublin">
                            {foreach item=datos from=$temas}
                                <option  value="{$datos.Ted_IdTemaDublin|default:0}">{$datos.Ted_Descripcion|default:"Selecionar Tema"}</option>
                            {/foreach}            
                        </select>
                        {else}

                        {/if}
                        <a href="{$_layoutParams.root}dublincore/registro/nuevoTema">Nuevo</a>
                    </td>
                </tr>
                <tr>
                    <td><label>Tipo Documento: </label></td>
                    <td>
                        {if isset($tipodublin) && count($tipodublin)}
                        <select  name="idTipoDublin">
                            {foreach item=datos from=$tipodublin}
                                <option value="{$datos.Tid_IdTipoDublin|default:0}">{$datos.Tid_Descripcion|default:"Selecionar Tema"}</option>
                            {/foreach}            
                        </select>
                        {else}

                        {/if}
                        <a href="{$_layoutParams.root}dublincore/registro/nuevoTipoDocumento">Nuevo</a>
                    </td>
                </tr>
                <tr>
                    <td><label>Idioma Documento: </label></td>
                    <td>
                        {if isset($idiomas) && count($idiomas)}
                        <select name="idiomaDocumento">
                            {foreach item=datos from=$idiomas}
                                <option  value="{$datos.Idi_Idioma|default:0}">{$datos.Idi_Idioma|default:"Selecionar Tema"}</option>
                            {/foreach}            
                        </select>
                        {else}

                        {/if}
                        <a href="{$_layoutParams.root}dublincore/registro/nuevoIdioma">Nuevo</a>
                    </td>
                </tr>
                <tr>
                    <td><label>Formato : </label></td>
                    <td>
                        {if isset($tipoarchivosfisicos) && count($tipoarchivosfisicos)}
                        <select  name="formato">
                            {foreach item=datos from=$tipoarchivosfisicos}
                                <option value="{$datos.Taf_IdTipoArchivoFisico|default:0}">{$datos.Taf_Descripcion|default:"Selecionar Formato"}</option>
                            {/foreach}            
                        </select>
                        {else}

                        {/if}
                        <a href="{$_layoutParams.root}dublincore/registro/nuevoFormato">Nuevo</a>
                    </td>
                </tr>
                <tr>
                    <td><label>Subir archivo</label></td>
                    <td><input name="archivo" type="file" id="archivo" /></td> 
                    <td></td> 
                </tr>
                <tr > <td></td><td class="messages"></td> </tr>
                <tr > <td></td><td class="showImage"></td> </tr>
                <tr>
                    <td><label>Titulo: </label></td>                  
                    <td><input type="text" name="titulo" value="{$datos.titulo|default:""}"/></td></tr>
                <tr>
                    <td><label>Descripcion: </label></td>
                    <td><input type="text" name="descripcion" value="{$datos.descripcion|default:""}"/></td></tr>
                <tr>
                    <td><label>Editor: </label></td>
                    <td><input type="text" name="editor" value="{$datos.editor|default:""}"/></td></tr>
                <tr>                    
                    <td><label>Colaborador: </label></td>
                    <td><input type="text" name="colaborador" value="{$datos.colaborador|default:""}"/></td></tr>
                <tr>
                  <td>
                    <label>Fecha Documento:</label>
                  </td>
                  <td>
                    <input type="text" id="f_rangeIni" name="fechaDocumento" />
                    <button id="f_rangeIni_trigger">...</button>
                    <script type="text/javascript">
                      CAL_1 = new Calendar({
                              inputField: "f_rangeIni",
                              dateFormat: "%d/%m/%Y",
                              trigger: "f_rangeIni_trigger",
                              bottomBar: false,
                              onSelect: function() {
                                      var date = Calendar.intToDate(this.selection.get());
                                      LEFT_CAL.args.max = date;
                                      LEFT_CAL.redraw();
                                      this.hide();
                              }
                      });        
                    </script>
                  </td>
                </tr>
                <tr>
                    <td><label>Fuente: </label></td>
                    <td><input type="text" name="fuente" value="{$datos.fuente|default:""}"/></td></tr>
                <tr>
                    <td><label>Identificador: </label></td>
                    <td><input type="text" name="identificador" value="{$datos.identificador|default:""}"/></td></tr>      
                <tr>
                    <td><label>Relacion: </label></td>
                    <td><input type="text" name="relacion" value="{$datos.relacion|default:""}"/></td></tr>        
                <tr>
                    <td><label>Cobertura: </label></td>
                    <td><input type="text" name="cobertura" value="{$datos.cobertura|default:""}"/></td></tr>        
                <tr>
                    <td><label>Palabra Clave: </label></td>
                    <td><input type="text" name="palabraclave" value="{$datos.palabraclave|default:""}"/></td></tr>        
                <tr>
                    <td><label>Derecho(s): </label></td>
                    <td><input type="text" name="derechos" value="{$datos.derechos|default:""}"/></td></tr>
                
            </table>            
            
                <input type="submit" id="btnregistrarDoc" name="submit_registrar" value="registrar" />  
            
        </form>
                <br><br><br>
    </div>
                
</div>
                