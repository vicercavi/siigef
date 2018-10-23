<div class="contadorformato" align='center'>                              
                {if isset($totaltipoarchivofisicos) && count($totaltipoarchivofisicos)}
                    {foreach item=datos from=$totaltipoarchivofisicos}    
                        <div style="width: 100%; width:12%; float: left" align="center">
                            <img class="pais " style="cursor:pointer" src="{$_layoutParams.root}public/img/legal/{$datos.Pai_Nombre}.png" 
                                 pais="{$datos.Pai_Nombre}" title="Listar {$datos.Pai_Nombre}"/>
                            <br><b>{$datos.Pai_Nombre}</b>
                            <br>({$datos.cantidad})
                        </div>
                    {/foreach}
                {/if}                            
            </div>
            <br /><br /><br /><br /><br /><b><font size="-1"><center>Total de documentos {$condicion}: {$totaldocumentos[0]}</center></font></b>
            <br /><br />
                    {if isset($documentos) && count($documentos)}
                        {if $numeropagina != 0}
                            {if $cantidadporpagina==0}
                                {$cantidadporpagina=20}
                            {/if}
                            {$numeropagina = $numeropagina*$cantidadporpagina-($cantidadporpagina-1)} 
                        {else}
                            {$numeropagina =1}  
                        {/if}            
                        {foreach item=datos from=$documentos}
                            <div class="cajita">
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
                                    <a href="documentos/metadata/{$datos.Dub_IdDublinCore}" target="_blank">Detalles</a> |
                                    <a href="{$_layoutParams.root_archivo_fisico}{$datos.Arf_PosicionFisica}" target="_blank"><span class="ha" style="cursor:pointer" title="Descargar {$datos.Taf_Descripcion}"> Descargar </span></a>
                                </div>
                            </div>
                                <br><br>
                        {/foreach}
                        {$paginacion|default:""}
                    {else}
                        <p><strong>No hay documentos!</strong></p>
                    {/if}        
                </div>