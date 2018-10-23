
      <div class="col-md-12">
          <div class="panel panel-default">
          	
          <div class="panel-heading">Total de Registros: {$total_registros}  Total Registrados: {$total_registrado} Total No Registrados: {$total_no_registrado} <span class="badge  pull-right"><a href="../descargar_datos" title="Descargar Data"><i class="glyphicon glyphicon-download" ></i></a></span></div>
              
              <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr><th>#{foreach item=datos from=$cabecera}<th>{$datos}{/foreach}
                        <tbody>
                           
                                {foreach item=datos from=$no_registrado}
                                <tr><td data-th="#">{$numeropagina++}{foreach item=datos1 from=$cabecera}<td data-th="{$datos1}">{$datos[$datos1]}{/foreach}
                                
                               {/foreach}
                               
                        </tbody>
                    </table>
                </div>
              <div class="panel-footer">  {$paginacion|default:"Todos los datos fueron registrados"}</div>
              
          </div>
          </div>
         
>