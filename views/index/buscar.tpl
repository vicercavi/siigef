<div  class="container-fluid" > 
    <div class="col-md-12">
         <h2 class="tit-pagina-principal">{$lenguaje.buscador_titulo}</h2>
     </div>   
    <div class="col-sm-2">
        <div class="panel panel-default">        
            <div class="panel-heading">
                <h2 class="panel-title"><b>{$lenguaje.buscador_titulo_tipo_registro}</b></h2> 
            </div>
            <div id="TipoRegistros">                
                <ul class="list-group">
                    <li class="list-group-item {if $tipoRegistro == 1} active  {/if} ">
                        <span class="badge">{if isset($cantPagina)}{$cantPagina}{/if}</span>
                        <a class="" {if $tipoRegistro == 1} style="color:#ffffff"  {/if}  href="{$_layoutParams.root}index/buscarPalabra/{$palabra1}/1/{$filtroPais|default:'all'}">
                            {$lenguaje.buscador_tipo_registro1}
                        </a>
                    </li>
                    <li class="list-group-item {if $tipoRegistro == 2} active  {/if}">
                        <span class="badge">{if isset($cantDublin)}{$cantDublin}{/if}</span>
                        <a class="" {if $tipoRegistro == 2} style="color:#ffffff"  {/if}  href="{$_layoutParams.root}index/buscarPalabra/{$palabra1}/2/{$filtroPais|default:'all'}">
                            {$lenguaje.buscador_tipo_registro2}
                        </a>
                    </li>
                    <li class="list-group-item {if $tipoRegistro == 3} active  {/if}">
                        <span class="badge">{if isset($cantLegal)}{$cantLegal}{/if}</span>
                        <a class="" {if $tipoRegistro == 3} style="color:#ffffff"  {/if}  href="{$_layoutParams.root}index/buscarPalabra/{$palabra1}/3/{$filtroPais|default:'all'}">
                            {$lenguaje.buscador_tipo_registro3}
                        </a>
                    </li>
                    <li class="list-group-item {if $tipoRegistro == 4} active  {/if}">
                        <span class="badge">{if isset($cantRecurso)}{$cantRecurso}{/if}</span>
                        <a class="" {if $tipoRegistro == 4} style="color:#ffffff" {/if} href="{$_layoutParams.root}index/buscarPalabra/{$palabra1}/4/{$filtroPais|default:'all'}">
                            {$lenguaje.buscador_tipo_registro4}
                        </a>
                    </li>
                </ul>                                   
            </div>
        </div>            
    </div>    
    <div class="col-sm-10">
        <div class="panel panel-default">        
            <div class="panel-heading">
                <h3 class="panel-title"><b>{$lenguaje.buscador_listado_titulo}</b></h3> 
            </div>
            <div id="">                
                {if isset($resultadoBusqueda) && count($resultadoBusqueda)}
                    <div class="panel-body">
                        <div class="row">
                              <div class="col-md-6 col-md-offset-3">
                                <div class="input-group">                            
                                 <input class="form-control" data-toggle="tooltip" data-placement="bottom" title="Busca en Arquitectura SII, Base de Datos Documentos, Base de Datos Legislacion, Base de Datos Recursos, " type="search" id="textBuscar2" name="textBuscar2" placeholder="{$lenguaje.text_buscador|default:''}" value="{$palabrabuscada|default:''}" onkeypress="tecla_enter2(event)" required="required">               
                                 <span class="input-group-btn">
                                  <button class="btn  btn-primary btn-buscador"  type="button" id="btnBuscar" name="btnBuscar" onclick="buscarPalabraGeneral('textBuscar2','filtrotipogeneral','filtropaisgeneral')" value=""><i class="glyphicon glyphicon-search"></i></button>
                                </span>
                               
                              </div><!-- /input-group -->
                            </div>

                            <div class="col-md-6 col-md-offset-3 div-filtro text-center">
                                {if isset($filtroTipo) OR  isset($filtroPais)}
                                <strong> Filtro:</strong> 
                                {/if}
                                {if isset($filtroTipo)}
                                <input type="hidden" id= "filtrotipogeneral" value="{$tipoRegistro|default:'all'}">
                                <a class="badge" href="{$_layoutParams.root}index/buscarPalabra/{$palabrabuscada|default:'all'}/all/{$filtroPais|default:'all'}">
                                 Tipo: {$filtroTipo} <i class="fa fa-times"></i>               
                                </a>
                                {/if}
                                {if isset($filtroPais)}
                                <input type="hidden" id= "filtropaisgeneral" value="{$pais|default:'all'}">
                                <a class="badge" href="{$_layoutParams.root}index/buscarPalabra/{$palabrabuscada|default:'all'}/{$tipoRegistro|default:'all'}/all">
                                 País: {$filtroPais} <i class="fa fa-times"></i>               
                                </a>
                                {/if}
                            </div>

                            <div class="col-md-12 text-center">
                                {if isset($paises) && count($paises)}
                                    <input type="hidden" id="palabra" value="{$palabra1}"/>
                                    {foreach item=datos from=$paises}
                                        <div style="margin-top:15px; display:inline-block;vertical-align:top;width:60px;text-align:center;margin-right:20px;">
                                            <img class="pais " style="cursor:pointer;width:40px" src="{$_layoutParams.root_clear}public/img/legal/{$datos.Pai_Nombre}.png" 
                                                pais="{$datos.Pai_Nombre}" /><b>{$datos.Pai_Nombre}</b>
                                                <p style="font-size:.8em">({$datos.cantidad|default:0})</p>
                                        </div>
                                    {/foreach}
                               {else}
                                    <p><strong>{$lenguaje["no_registros"]}</strong></p>
                               {/if}             
                            </div>
                             {if isset($cantTotal)}
                                <div class="col-md-12" >
                                    <h5>{$lenguaje.buscador_resultado1} <b>{$cantTotal}</b> {$lenguaje.buscador_resultado2} <b>"{$palabra}"</b> .</h5>
                                </div>        
                            {/if}        
                        </div> 
                          
                    <div id="ResultadoBusqueda" class="table-responsive" >                          
                        {foreach from=$resultadoBusqueda item=rb}
                            <div style="margin: 20px auto" >
                                <a style="font-size: 18px; margin: 30px auto" data-toggle="tooltip" data-placement="top" target="_blank" title="{$_layoutParams.root_clear}{$rb[3]}{$rb[0]}" href="{$_layoutParams.root}{$rb[3]}{$rb[0]}"> 
                                    {$rb[1]}
                                </a>                                       
                                    {if $rb[4] == 2} 
                                    <a style="color: #03A51E; line-height: 1.2;" data-toggle="tooltip" data-placement="top" href="{$_layoutParams.root}dublincore/documentos/descargar/{$rb[5]}/{$rb[6]}" target="_blank" title="{$lenguaje["icono_descargar_documentos"]} {$rb[7]}">
                                        <br>
                                        <img style="width: 20px" src="{$_layoutParams.root_clear}public/img/documentos/{$rb[7]}.png"/><b>&nbsp;{$lenguaje["icono_descargar_documentos"]} {$rb[7]}</a></b>
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
                        <div class="panel-footer">
                            {$paginacion|default:""}
                        </div> 
                    </div>
                    {else} 
			<div class="panel-body">
				{$lenguaje["no_registros"]}
			</div>		
		
                {/if} 
            </div>
        </div>
    </div>    
</div>
    