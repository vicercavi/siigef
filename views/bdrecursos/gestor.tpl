<div id="recursos" class="container-fluid" >
    <div class="row">
        <div class="col-md-12">
            <h2>  Gestor de Recurso</h2>
            <br>          
        </div>
        <div class="col-md-3">     
            <div class="panel-group" id="accordion">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <strong>Nuevo Recurso</strong> 
                            </h4>
                        </div>               
                        <div class="panel-body">
                            <table class="table" >
                                {foreach item=datos from=$tiporecurso}
                                    <tr>
                                        <td class="tipo_recurso">
                                            <span class="tiporecurso " recurso="{$datos.Tir_Nombre}"><a style="cursor: pointer">{$datos.Tir_Nombre}</a></span>
                                        </td>
                                    </tr>   
                                {/foreach}  
                            </table>
                        </div>
                    </div>
                </div>     
            </div>
        </div>
        <div class="col-md-9">     
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <strong>Metadata</strong>
                        </h4>
                    </div>               
                    <div class="panel-body">
                        {if isset($capas)}
                            <table class="table table-condensed" >   

                                {foreach item=datos from=$capas}
                                    <tr>  
                                        <td>                                            
                                            <div class="row-fluid">
                                                <div class="col-md-3">
                                                    <img src="http://placehold.it/380x500" alt="{$datos.Cap_imagenprev}" class="img-rounded img-responsive" />
                                                </div>
                                                <div class="col-md-9 table-responsive">
                                                    <table class="table table-user-information">
                                                        <tbody>                           
                                                            <tr>
                                                                <td>Titulo: </td>
                                                                <td>{$datos.Cap_Titulo}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Nombre: </td>
                                                                <td>{$datos.Cap_Nombre}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tipo:</td>
                                                                <td>{$datos.tic_Nombre}</td>
                                                            </tr>                                                          
                                                            <tr>
                                                                <td>Url:</td>
                                                                <td><p>{$datos.Cap_UrlBase}</p></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Fuente:</td>
                                                                <td>{$datos.Cap_Fuente}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Resumen:</td>
                                                                <td><p>{$datos.Cap_Resumen}</p> </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Descripcion:</td>
                                                                <td>
                                                                    <p >{$datos.Cap_Descripcion}</p>                                                                    
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Creditos:</td>
                                                                <td>{$datos.Cap_Creditos}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Leyenda:</td>
                                                                <td>{$datos.Cap_Leyenda}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>  
                                                </div>
                                            </div>
                                        </td>                
                                    </tr>                     
                                {/foreach}
                            </table>

                        {else if isset($monitoreo)}
                        {else if isset($dublin)}  
                        {else if isset($plinian)}  
                        {else if isset($legislacion)}  
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>  

</div>