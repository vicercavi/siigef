<style> 
  #raizaMenu 
  {
     padding-top: 10px;   
  }
  @media (min-width: 1200px)
  {
    #raizaMenu 
    {  
       margin-left: 8.33333333%;
    }
  }
  @media(max-width: 991px)
  {
    #raizaMenu ul
    {
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
      <a class='actual' >{$lenguaje["label_h2_titulo"]} </a>
    </li>
  </ul>     
</div>
<div class="container col-lg-12">
  <div class="row">
    <div class="col-md-12 col-lg-offset-1 col-lg-10">
      <h2 class="tit-pagina-principal"><center>{$lenguaje["label_h2_titulo"]}</center></h2>
      <input id="metodo" name="metodo" type="hidden" value="buscarporpalabras"/>
      <input id="query" name="query" type="hidden"/>
    </div>    
  </div>   
  <div class="row"> 
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-offset-1 col-lg-2">
      <div class="panel-group" id="accordion">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" data-parent="#accordion" href="#accordionOne2">
                <strong>{$lenguaje["menu_izquierdo"]}</strong>
              </a>
            </h4>
          </div>       
          <div id="accordionOne2" class="panel-collapse" >
            <ul id="menulegislaciones" class="list-group scroll"   style="overflow-y: auto;" >
              {if isset($tipolegislacion) && count($tipolegislacion)}
              {foreach item=datos from=$tipolegislacion}
              <li class="list-group-item">
                <span class="badge">{$datos.cantidad|default:0}</span>
                <a style="cursor:pointer" ><span class="tipolegislacion">{$datos.Til_Nombre}</span></a>
              </li>
              {/foreach}
              {/if}
            </ul>
          </div>
        </div>
      </div>          
    </div>
    <div class="col-xs-12 col-sm-8 col-md-offset-0 col-md-9 col-lg-offset-0 col-lg-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
           <strong>{$lenguaje["titulo_resultados"]}</strong>
         </h4>
        </div>
        <div class="panel-body">
          <div class="row ">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6 col-md-offset-3">
                  <div class="input-group">
                    <input type ="text" class="form-control"  data-toggle="tooltip"placeholder="{$lenguaje['text_buscar_placeholder']}" name="palabra" id="palabra" data-original-title="La búsqueda puede realizarse por Título, Entidad, Palabra Clave, Tipo" onkeypress="tecla_enter_legalizacion(event)" value="{$palabrabuscada|default:''}">   
                     <span class="input-group-btn">
                      <button class="btn  btn-success btn-buscador" type="button" id="btnEnviar"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                    <input id="palabradebusqueda" name="palabradebusqueda" type="hidden" />
                    <input id="tipo" name="tipo" type="hidden" value="{$tipo}" />
                    <input id="pais" name="pais" type="hidden" value="{$pais}"/>
                  </div><!-- /input-group -->
                </div>
                {if $tipo!="%" || $pais!="%"}
                <div class="col-md-6 col-md-offset-3 div-filtro text-center">
                  <strong> Filtro:</strong> 
                  {if $tipo!="%"}
                    <a class="badge" href="{$_layoutParams.root}/legislacion/legal/{if $pais!='%'}index/{if empty($palabrabuscada)}all{else}{$palabrabuscada}{/if}/all/{$pais}{else if !empty($palabrabuscada)}index/{$palabrabuscada}{/if}">
                     Tipo: {$tipo}  <i class="fa fa-times"></i>               
                    </a>
                  {/if}
                  {if $pais!="%"}
                     <a class="badge" href="{$_layoutParams.root}/legislacion/legal/{if $tipo!='%'}index/{if empty($palabrabuscada)}all{else}{$palabrabuscada}{/if}/{$tipo}{else if !empty($palabrabuscada)}index/{$palabrabuscada}{/if}">
                       País: {$pais} <i class="fa fa-times"></i>               
                     </a>
                  {/if}
                </div>
               {/if}
              </div>
            </div>    
            <div class="col-md-12 text-center">
              {if isset($totalpaises) && count($totalpaises)}
                {foreach item=datos from=$totalpaises}
                  <div style="margin-top:15px;display:inline-block;vertical-align:top;width:10.333333%;text-align:center;"> 
                    <img class="pais " data-toggle="tooltip" data-original-title="{$lenguaje["title_paises_buscar"]}" style="cursor:pointer;width:40px" src="{$_layoutParams.root_clear}public/img/legal/{$datos.Pai_Nombre}.png"
                    pais="{$datos.Pai_Nombre}" />  
                    <br>                                        
                    <b>{$datos.Pai_Nombre}</b>                                        
                    <p style="font-size:.8em">({$datos.cantidad|default:0})</p>
                  </div>
                {/foreach}
              {else}
              <p><strong>{$lenguaje["sin_resultados"]}</strong></p>
              {/if}
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                 <b> Resultado de búsqueda: {if !empty($palabrabuscada)}"{$palabrabuscada}"{/if}</b>
               </div>
                <div class="col-md-6 text-right">
                  <b><font size="-1">{$lenguaje["total_resultados"]}: {count($totalregistros)}</font></b>
                </div>
              </div>
            </div>
          </div>
        </div>          
        <div id="resultados">
          <div class="table-responsive">
            <table class="table table-hover table-condensed">
              <thead>
                <tr>
                  <th>#</th>                       
                  <th>{$lenguaje["tabla_campo_titulo"]}</th>
                  <th>{$lenguaje["tabla_campo_entidad"]}</th>
                  <th>{$lenguaje["tabla_campo_tipo_legislacion"]}</th>
                  <th>{$lenguaje["tabla_campo_pais"]}</th>
                  <th>{$lenguaje["tabla_campo_fecha_publicacion"]}</th>
                  <th>{$lenguaje["tabla_campo_detalle"]}</th>
                </tr>
              </thead>
              <tbody>
                {if isset($legislacion)}
                  {foreach item=datos from=$legislacion}
                    <tr>
                      <td data-th="Nro">{$numeropagina++}</td>
                      <td data-th="Titulo">{$datos.Mal_Titulo} </td>
                      <td data-th="Entidad">{$datos.Mal_Entidad} </td>
                      <td data-th="Tipo Legislación">{$datos.Til_Nombre}</td>
                      <td data-th="Pais"><img style="width:40px" src="{$_layoutParams.root_clear}public/img/legal/{$datos.Pai_Nombre}.png" /> </td>
                      <td data-th="Fecha de Publicacion">{$datos.Mal_FechaPublicacion}  </td>
                      <td data-th="Detalle"><a data-toggle="tooltip" data-placement="top" class="btn btn-default" href="{$_layoutParams.root}legislacion/legal/metadata/{$datos.Mal_IdMatrizLegal}" target="_blank" data-original-title="Ver Ficha"><i class="glyphicon glyphicon-list-alt" ></i></a></td>
                    </tr>
                  {/foreach}
                {else}
                <tr>
                  <td colspan="7">No se Encontraron Registros </td>
                {/if}
                </tr>
              </tbody>
            </table>
          </div>
          <div class="panel-footer">  
            {if isset($legislacion) && count($legislacion)}
              {$paginacion|default:""}
            {/if}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
