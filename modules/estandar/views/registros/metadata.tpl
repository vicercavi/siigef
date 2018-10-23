<div class="container" style="margin:10px auto;">
    <div class="row">
    <div class="col-md-12">
    <h2 class="tit-pagina-principal">{$lenguaje["label_h2_metadata_titulo"]} {$nombre_tabla2}</h2>
    </div>
    
    <div class="col-md-3">     
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <strong>{$lenguaje["label_recurso_bdrecursos"]}</strong>
                        </h4>
                    </div>               
                    <div class="panel-body">
                        <table class="table table-user-information">
                            <tbody>                           
                                <tr>
                                    <td style="border:none;">{$lenguaje["label_nombre_bdrecursos"]}:</td>
                                    <td style="border:none;">{$recurso.Rec_Nombre}</td>
                                </tr>
                                <tr>
                                    <td>{$lenguaje["label_tipo_bdrecursos"]}</td>
                                    <td>{$recurso.Tir_Nombre}</td>
                                </tr>
                                <tr>
                                    <td>{$lenguaje["label_estandar_bdrecursos"]}</td>
                                    <td>{$recurso.Esr_Nombre}</td>
                                </tr>                                
                                <tr>
                                    <td>{$lenguaje["label_fuente_bdrecursos"]}</td>
                                    <td>{$recurso.Rec_Fuente}</td>
                                </tr>
                                <tr>
                                    <td>{$lenguaje["label_origen_bdrecursos"]}</td>
                                    <td>{$recurso.Rec_Origen}</td>
                                </tr>                                
                                <tr>
                                    <td>{$lenguaje["herramienta_utilizada_bdrecursos"]}</td>
                                    <td>
                                        {if isset($recurso.herramientas)}
                                            <ul>
                                                {foreach item=herramienta from=$recurso.herramientas}
                                                    <li>
                                                        {$herramienta.Her_Nombre}
                                                    </li>
                                                {/foreach}
                                            </ul>
                                        {/if}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{$lenguaje["registro_bdrecursos"]}</td>
                                    <td>{$recurso.Rec_FechaRegistro|date_format:"%d/%m/%y"}</td>
                                </tr>
                                <tr>
                                    <td>{$lenguaje["modificacion_bdrecursos"]}</td>
                                    <td>{$recurso.Rec_UltimaModificacion|date_format:"%d/%m/%y"}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="col-md-9">
        
        
        {foreach item=datos from=$detalle}
<div class="panel panel-default">     
        <div class="table-responsive">
        <table class="table table-user-information">          
            <tbody>
                    <tr>
                        <td class="col-md-3" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);"><b>{$lenguaje["label_detalle"]} {$nombre_tabla2}</b></td>
                        <td class="col-md-9" style="padding:0;border: 0;">

                           
                            {if isset($datos) && count($datos)}                            
                                <table class="table table-user-information" style="margin:0;border:0;">
                                    <tbody>
                                        {if  isset($ficha) && count($ficha)}
                                            {foreach from=$ficha item=fi}
                                            <tr>                                                
                                                <td class="col-md-3 text-right">{$fi.Fie_CampoFicha} :</td>
                                                <td>
                                                    {$datos.{$fi.Fie_ColumnaTabla}}
                                                </td>
                                                
                                            <tr>                                                
                                            {/foreach}
                                        {/if} 
                                    </tbody>                                    
                                </table>
                        {else}
                            {$lenguaje.no_registros}
                        {/if}                             
                        </td>
            </tbody>
        </table>    
        </div>
</div>
{/foreach}
        </div> 
 </div> 
 
</div>