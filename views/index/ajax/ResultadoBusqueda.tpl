 {if isset($resultadoBusqueda) && count($resultadoBusqueda)}
                    <div class="table-responsive" >                          
                        {foreach from=$resultadoBusqueda item=rb}
                            <div style="margin: 20px auto" >
                                <a style="font-size: 18px; margin: 30px auto" data-toggle="tooltip" data-placement="top" target="_blank" title="{$_layoutParams.root}{$rb[3]}{$rb[0]}" href="{$_layoutParams.root}{$rb[3]}{$rb[0]}"> 
                                    {$rb[1]}
                                </a>                                       
                                {if $rb[4] == 2} 
                                <a style="color: #03A51E; line-height: 1.2;" data-toggle="tooltip" data-placement="top" href="{$_layoutParams.root}dublincore/documentos/descargar/{$rb[5]}/{$rb[6]}" target="_blank" title="{$lenguaje["icono_descargar_documentos"]} {$rb[7]}">
                                    <br>
                                    <img style="width: 20px" src="{$_layoutParams.root}public/img/documentos/{$rb[7]}.png"/><b>&nbsp;{$lenguaje["icono_descargar_documentos"]} {$rb[7]}</a></b>
                                    {/if}
                                    <div>
                                        <spam>{$rb[2]}  ...</spam>
                                        <div>
                                            {if $rb[4] == 1}<label>{$lenguaje.buscador_tipo_registro1}</label>{/if}
                                            {if $rb[4] == 2}<label>{$lenguaje.buscador_tipo_registro2}</label>{/if}
                                            {if $rb[4] == 3}<label>{$lenguaje.buscador_tipo_registro3}</label>{/if}
                                            {if $rb[4] == 4}<label>{$lenguaje.buscador_tipo_registro4}</label>{/if}
                                        </div>
                                    </div>                                       
                            </div>
                        {/foreach}         
                    </div>                                     
              
                    <div class="panel-footer">
                        {$paginacion|default:""}
                    </div> 
                    {else} 
			<div class="panel-body">
				 {$lenguaje["no_registros"]}
			</div>
                    {/if} 