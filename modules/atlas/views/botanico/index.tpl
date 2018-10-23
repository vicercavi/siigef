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
      <a class='actual' >{$lenguaje["label_titulo_botanico"]} </a>
    </li>
  </ul>     
</div>

<div class="container col-lg-12">
    <div class="row">
        <div class="col-md-12 col-lg-offset-1 col-lg-10">
            <h2 class="tit-pagina-principal"><center>{$lenguaje["label_titulo_botanico"]}</center></h2>
            <input id="metodo" name="metodo" type="hidden" value="buscarporpalabras"/>
            <input id="query" name="query" type="hidden"/>
        </div>       
    </div>      

    <div class="row"> 
        {if isset($registros) && count($registros)}
        <div id="resultados">
           <div class="col-md-12 col-lg-offset-1 col-lg-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <strong> {$lenguaje["label_titulo_panel"]}</strong>
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form class="col-md-6 col-md-offset-3"  role="form" >
                            <div class="input-group">
                               <input type="text" class="form-control" data-toggle="tooltip" name="nombre" id="nombre" placeholder="{$lenguaje["text_placeholder_botanico"]}" data-original-title="{$lenguaje["label_formasabuscar_botanico"]}">
                               <span class="input-group-btn">
                                <button class="btn  btn-success btn-buscador" type="button" id="btnBuscar" ><i class="glyphicon glyphicon-search"></i></button>
                            </span>                    
                        </div><!-- /input-group -->
                    </form>                  
                    <input id="palabra" name="palabra" type="hidden" />
                    <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-6">
                             <b> Resultado de búsqueda: </b>
                         </div>
                         <div class="col-md-6 text-right">
                          <b><font size="-1">Total de Registros: {foreach item=datos from=$cantidad} {$datos.cantidad} {/foreach}</font></b>
                      </div>
                  </div>  
              </div>
              
          </div> 
      </div>
      <div id="buscarbotanico">
       <div id="buscar">
           <div id="resultadosbusqueda" >         
               <div id="lista_registros">                                         
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr><th>#<th>{$lenguaje["label_nombrecientifico_botanico"]}<th>{$lenguaje["label_familia_botanico"]}<th>{$lenguaje["metadata_genero_botanico"]}<th>{$lenguaje["label_nombrecomun_botanico"]}<th>Institución<th>{$lenguaje["label_h2_metadata_titulo"]}
                                <tbody>
                                    {foreach item=datos from=$registros}
                                    <tr><td> {$numeropagina++}<td>{ucwords(strtolower($datos.Pli_NombreCientifico))}<td>{ucwords(strtolower($datos.Pli_Orden))}<td>{ucwords(strtolower($datos.Pli_Familia))}<td>{ucwords(strtolower($datos.Pli_NombresComunes))}<td>{ucwords(strtolower($datos.Pli_AcronimoInstitucion))}<td><a data-toggle="tooltip" href="botanico/metadata/{$datos.Pli_IdPlinian}"   target="_blank" data-original-title="{$lenguaje["enlace_vermetadata_botanico"]}"><button type="button" id="btnBuscar" class="btn btn-default"><span class="glyphicon glyphicon-list-alt"></span></button></a>             
                                        {/foreach}
                                    </tbody>
                                </table>
                                {if !empty(count($datos))}
                                {$paginacion|default:""}
                                {else}
                                <center>¡¡¡No se encontraron resultados!!!</center>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
{/if}
</div>
</div>