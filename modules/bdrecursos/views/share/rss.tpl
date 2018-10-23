<style> 
	#raizaMenu 
	{
	   padding-top: 10px;   
	}
	@media (min-width: 1200px)
	{
	  #raizaMenu {  
	     margin-left: 8.33333333%;
	  }
	}
	@media(max-width: 991px)
	{
	  #raizaMenu ul{
	      height: 30px !important;
	  }
	}
	#raizaMenu ul
	{
	   list-style: none;
	   width: 100%;
	    height: 30px;
	      padding: 0px 10px;
	}
	#raizaMenu li
	{
	   top: 3px;
	   margin: 0px 2px;
	   float: left;
	}
	#raizaMenu li .actual
	{
	  color: #444f4a;
	}
	#raizaMenu a
	{
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
      <a class='actual' > Compartir datos desde RSS </a>
    </li>
  </ul>     
</div>
<div class="container-fluid">
	<div class="row">
        <div class="col-md-12">
            <h2 class="tit-pagina-principal"><center>Compartir datos desde RSS</center></h2>           
        </div>       
    </div> 
    <div class="row">
		<div class="col-md-12 col-md-offset-1 col-md-10">
			 <div class="panel panel-default">
			 	<div class="panel-heading">
					<h4 class="panel-title"> Lista de datos </h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="container col-md-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<p>Lista de todos los recursos: </p>
									<a href="{$_layoutParams.root}bdrecursos/share/rss/recurso" target="_blank">{$_layoutParams.root}bdrecursos/share/rss/recurso </a> 
									
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-body">
									<p>Generar RSS para los registros: </p>
									<form id="form1" method="post" data-toggle="validator" role="form" autocomplete="on">
										<hr color="#000">
										<div class="form-group col-md-5 col-md-offset-3">
                                            <label class="col-md-2 control-label" for="sl_estandar">Estandar*</label>    
                                            <div class="col-md-12">
                                                <select name="sl_estandar"  class="form-control" id="sl_estandar"  name="sl_estandar" required="">
                                                    <option value="">Seleccione</option>
                                                    {foreach item=datos from=$estandares}
                                                        <option value="{$datos.Esr_IdEstandarRecurso}"> {$datos.Esr_Nombre}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </div>
                                        <div id="lista_recurso">
	                                        <div class="form-group col-md-5 col-md-offset-3" id="listaRecurso"> 
	                                            <label class="col-md-2 control-label" for="sl_recurso">Recurso*</label>    
	                                            <div class="col-md-12">
	                                                <select name="sl_recurso"  class="form-control" id="sl_recurso"  name="sl_recurso" required="">
	                                                    <option value="">Seleccione</option>
	                                                    {foreach item=datos from=$recursos}
	                                                        <option value="{$datos.Rec_IdRecurso}">{$datos.Rec_Nombre}</option>
	                                                    {/foreach}
	                                                </select>
	                                            </div>
	                                        </div>
	                                    </div>
                                        <div class="form-group col-md-5 col-md-offset-3">
                                        	<div class="col-md-12">
                                        		<center>
                                        			<button type="submit" class="btn btn-success" id="bt_generar_rss" name="bt_generar_rss">
	                                           			Generar
	                                           		</button>
                                        		</center>
	                                         </div>
                                        </div>
                                        {if isset($link_rss)}
                                        	<div class="form-group col-md-5 col-md-offset-3">
	                                        	<div class="col-md-12">
	                                        		<label>Copia o click en el enlace</label>
	                                        		<a href="{$_layoutParams.root}bdrecursos/share/rss/{$nombre_tabla}/{$id_recurso}" class="btn btn-info" target="_blank">{$_layoutParams.root}bdrecursos/share/rss/{$nombre_tabla}/{$id_recurso}</a>
	                                        		</center>
		                                         </div>
	                                        </div>
                                        {/if}                                        
									</form>
								</div>
							</div>
						</div>					
					</div>							
				</div>
			</div>			
		</div>		
	</div>
</div>