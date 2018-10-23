
<div id="buscardocumentos">
    <h2 align="center" class="tit-p">{$nombreRecurso}</h2>
    Actualmente existen {$cantidadElementos} registros...!!!
    <div id="wrapper">
        <div class="modif">
            {if $_acl->permiso('gestor')}
                <a class = "boton" id = "btnRegistrar" href='{$_layoutParams.root}dublincore/registro/index/{$idRecurso}/{$nombreRecurso}/{$cantidadElementos}' title='Registrar Elemento'>Registrar</a>
            {/if}
        </div>
        <div class="cont-form-buscador">
            Buscar :<input type="text"  name="nombre" id="nombre">
            <button type="button" id="btnBuscar" class="boton"></button>
            <input id="variable" name="variable" type="hidden" />   
            <input id="pais" name="pais" type="hidden" /> 
            <input id="idRecurso" value="{$idRecurso}" name="idRecurso" type="hidden" /> 
            <input id="registrosCantidad" name="registrosCantidad" type="hidden" /> 
        </div>

        <div id="buscar">
            <div id="sidebar-wrapper">
                <ul id="ul_tipo_documentos" class="sidebar-nav">
                    <li class="sidebar-brand">
                        <a href="#">
                            Tipos de Documentos
                        </a>
                    </li>

                    {if isset($tipoDocumento) && count($tipoDocumento)}
                        {foreach item=datos from = $tipoDocumento}
                            <li><a style="cursor:pointer">
                                    <span class="tipos_doc">{$datos.Tid_Descripcion}</span>({$datos.cantidad|default:0})</a>               
                            </li>       
                        {/foreach}    
                    {/if}
                </ul> 

            </div>
            <div id="resultadosbusqueda">         
                <div id="lista_registros" style="display: inline-block;vertical-align: top;width:100%;">
                    
                        <div class="contadorformato">  
                            {if isset($archivofisico) && count($archivofisico)}
                            {if isset($totaltipoarchivofisicos) && count($totaltipoarchivofisicos)}

                                {foreach item=datos from=$totaltipoarchivofisicos}    
                                    <div style="width: 100px; float: left">
                                        <img class="pais " style="cursor:pointer" src="{$_layoutParams.root}public/img/documentos/{$datos.Taf_Descripcion}.png" 
                                             pais="{$datos.Taf_Descripcion}" title="Listar {$datos.Taf_Descripcion}"/>
                                        <h5>{$datos.cantidad|default:0}</h5> 
                                    </div>
                                {/foreach}
                            {/if}
                        {else}    
                            <p><strong>No hay aspectos legales!</strong></p>    
                        {/if}
                    </div> 

                    {if isset($documentos) && count($documentos)}
                        {if $numeropagina != 0}                      
                            {if $cantidadporpagina==0}
                                {$cantidadporpagina=10};
                            {/if}
                            {$numeropagina = $numeropagina*$cantidadporpagina-($cantidadporpagina-1)}                       
                        {else}
                            {$numeropagina =1}  
                        {/if}            <br><br><br>
                        {foreach item=datos from=$documentos}
                            <br><div class="cajita">
                                <div class="primero">
                                    <span id="numero">{$numeropagina++}</span>
                                    <img class="pais " style="cursor:pointer" src="{$_layoutParams.root}public/img/documentos/{$datos.Taf_Descripcion}.png" pais="{$datos.Taf_Descripcion}" title="Listar {$datos.Taf_Descripcion}"/>
                                    <span class="titulo" >{$datos.Dub_Titulo}</span>
                                    <br><span id="tipo_documento">{$datos.Tid_Descripcion}</span>                            
                                </div>
                                <div class="segundo">
                                    <span class="autor">{$datos.Aut_Nombre}</span> ,
                                    <span class="tema">{$datos.Ted_Descripcion}</span>
                                </div>
                                <div class="tercero">
                                    <span id="descripcion">{$datos.Dub_Descripcion}</span>
                                </div>
                                <div class="cuarto">
                                    <span id="idioma">{$datos.Dub_Idioma}</span>
                                    
                                </div>  
                                <div >
                                    <a><span title="Ver Detalles" style="cursor:pointer" class="metadata" metadata="{$datos.Dub_IdDublinCore}" >Detalles</span></a> |
                                    <a href="{$_layoutParams.root_archivo_fisico}{$datos.Arf_PosicionFisica}" target="_blank"><span class="ha" style="cursor:pointer" title="Descargar {$datos.Taf_Descripcion}"> Descargar </span></a>
                                </div>
                                {if $_acl->permiso('editor')}
                                    <a class = "boton" id = "btnEditar" href='{$_layoutParams.root}dublincore/registro/index/{$idRecurso}/{$nombreRecurso}/{$cantidadElementos}' title='Editar Elemento'>Editar</a>
                                    {if $_acl->permiso('gestor')}
                                        <a class = "boton" id = "btnEliminar" href='{$_layoutParams.root}' title='Eliminar Elemento'>Eliminar</a>
                                    {/if}
                                {/if}
                            </div>
                        {/foreach}
                        {$paginacion|default:""}
                    {else}
                        <p><strong>No hay documentos!</strong></p>
                    {/if}        
                </div>
            </div>
        </div>
        <div align="center" >
            <label>Registros por Pagina :</label>
            <select name="selectCantidad" id="selectCantidad">                        
                <option  value="10">10</option>
                <option  value="20">20</option>
                <option  value="30">30</option>
                <option  value="40">40</option>
                <option  value="50">50</option>
                <option  value="60">60</option>
                <option  value="70">70</option>
                <option  value="80">80</option>
                <option  value="90">90</option>
                <option  value="100">100</option>
            </select>
            <br><br><br><br>
        </div>
    </div>
</div>