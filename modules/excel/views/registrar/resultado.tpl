{$item=1}
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <h2 class="tit-pagina-principal"><center>Detalle de Carga</center></h2>
        <input id="metodo" name="metodo" type="hidden" value="buscarporpalabras"/>
        <input id="query" name="query" type="hidden"/>
        </div>    
     </div>   
    <div class="row">
      <div id="resultados">
        <div class="col-md-12">
          <div class="panel panel-default">          	
            <div class="panel-heading">Total de Registros: {$total_registros}  Total Registrados: {$total_registrado} Total No Registrados: {$total_no_registrado} <span class="badge  pull-right"><a href="descargar_datos" target="_blank" title="Descargar Data"><i class="glyphicon glyphicon-download" ></i></a></span>
            </div>
            {$i=0}
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#
                      {foreach item=datos from=$cabecera}
                    <th>
                        {$datos}
                      {/foreach}
                    <tbody>                           
                      {foreach item=datos from=$no_registrado}
                        <tr>
                          <td data-th="#">{$numeropagina++}{foreach item=datos1 from=$cabecera}<td data-th="{$datos1}">
                            {$datos[$i]}{$i=$i+1}{/foreach}
                      {$i=0}
                      {/foreach}                         
                    </tbody>
              </table>
            </div>
            <div class="panel-footer">  {$paginacion|default:""}</div>              
          </div>
        </div>         
      </div>
    </div>
</div>