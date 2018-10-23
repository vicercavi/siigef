{if count($calidadagua)}
    <table class="table table-condensed table-hover" >   
        {foreach item=datos from=$calidadagua}
            <tr>  
                <td>                                            
                    <div class="row-fluid ">                                              

                        <div class="col-md-1">{$numeropagina++}</div>
                        <div class="col-md-11 table-responsive">
                            <table class="table table-user-information">
                                <tbody>                           
                                    <tr>
                                        <td>Variable: </td>
                                        <td>{$datos.Var_Nombre}</td>
                                    </tr>
                                    <tr>
                                        <td>Simbolo: </td>
                                        <td>{$datos.Var_Abreviatura}</td>
                                    </tr>
                                    <tr>
                                        <td>Valor:</td>
                                        <td>{$datos.Tid_Descripcion}</td>
                                    </tr>  
                                    <tr>
                                        <td>Fecha Colecta:</td>
                                        <td>{$datos.Dub_Formato}</td>
                                    </tr> 
                                    <tr>
                                        <td>Estacion:</td>
                                        <td><p>{$datos.Esm_Nombre}</p></td>
                                    </tr>
                                    <tr>
                                        <td>Longitud:</td>
                                        <td>{$datos.Esm_Longitud}</td>
                                    </tr>
                                    <tr>
                                        <td>Latitud:</td>
                                        <td>{$datos.Esm_Latitud}</td>
                                    </tr>
                                    <tr>                                                           
                                        <td colspan="2">
                                            <a type="button" title="Más Detalle" class="btn btn-default btn-sm glyphicon glyphicon-list" href="{$_layoutParams.root}calidaddeagua/monitoreo/variables{$dato.Esm_IdEstacionMonitoreo}">
                                            </a>
                                        </td>
                                    </tr>                                                       
                                </tbody>
                            </table>  
                        </div>


                    </div>
                </td>                
            </tr>                     
        {/foreach}

    </table>
    {$paginacion|default:""}
{else}
    Sin Registros...
{/if}