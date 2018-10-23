<div class="container" style="margin:10px auto;">
    <div class="row">
        <div class="col-md-12">
        <h2 class="tit-pagina-principal">{$lenguaje["label_h2_metadata_titulo"]}</h2>
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
                                    <td class="col-md-3" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);"><b>{$lenguaje["label_detalle"]}</b>
                                    </td>
                                    <td class="col-md-9" style="padding:0;border: 0;">
                                        <table class="table table-user-information" style="margin:0;border:0;">
                                            <tbody>
                                                <tr>
                                                    <td class="col-md-3 text-right">Cuenca<td >:<td >{ucfirst(strtolower($cuenca[0]['Cue_Nombre']))|default:''}         
                                                <tr>
                                                <tr>
                                                    <td class="col-md-3 text-right">Sub Cuenca<td >:<td >{ucfirst(strtolower($subcuenca[0]['Suc_Nombre']))|default:''}         
                                                <tr>
                                                <tr>
                                                    <td class="col-md-3 text-right">Río<td >:<td >{ucfirst(strtolower($rio[0]['Rio_Nombre']))|default:''}         
                                                <tr>
                                                <tr>
                                                    {if  isset($denominaciones[0])}
                                                         <td class="col-md-3 text-right">{$denominaciones[0]['Det_Nombre']} <td >:<td >{ucfirst(strtolower($territorios1[0]['Ter_Nombre']))|default:''} 
                                                    {/if}   
                                                <tr>
                                                <tr>
                                                    {if  isset($denominaciones[1])}
                                                         <td class="col-md-3 text-right">{$denominaciones[1]['Det_Nombre']} <td >:<td >{ucfirst(strtolower($territorios2[0]['Ter_Nombre']))|default:''} 
                                                    {/if}   
                                                <tr>
                                                <tr>
                                                    {if  isset($denominaciones[2])}
                                                         <td class="col-md-3 text-right">{$denominaciones[2]['Det_Nombre']} <td >:<td >{ucfirst(strtolower($territorios3[0]['Ter_Nombre']))|default:''} 
                                                    {/if}   
                                                <tr>
                                                <tr>
                                                    {if  isset($denominaciones[3])}
                                                         <td class="col-md-3 text-right">{$denominaciones[3]['Det_Nombre']} <td >:<td >{ucfirst(strtolower($territorios4[0]['Ter_Nombre']))|default:''} 
                                                    {/if}   
                                                <tr>
                                                <tr>
                                                    <td class="col-md-3 text-right">Entidad Responsable<td >:<td >{ucfirst(strtolower($cuenca))|default:''}         
                                                <tr>
                                                <tr>
                                                    <td class="col-md-3 text-right">{$lenguaje["tabla_campo_ambito"]}<td >:<td >{ucfirst(strtolower($datos.Esm_Nombre))|default:''}         
                                                <tr>
                                                    <td class="col-md-3 text-right">{$lenguaje["tabla_campo_tema"]}<td >:<td >{ucfirst(strtolower($datos.Esm_Longitud))|default:''}                        
                                                <tr>
                                                    <td class="col-md-3 text-right">{$lenguaje["tabla_campo_pais"]}<td >:<td >{ucfirst(strtolower($datos.Esm_Latitud))|default:''}
                                                <tr>                                        
                                                    <td class="col-md-3 text-right">{$lenguaje["tabla_campo_entidad"]}<td >:<td >{ucfirst(strtolower($datos.Var_Nombre))|default:''}
                                                <tr>                                        
                                                    <td class="col-md-3 text-right">{$lenguaje["tabla_campo_numero_norma"]}<td >:<td>{ucfirst(strtolower($datos.Var_Abreviatura))|default:''}
                                                <tr>                                        
                                                    <td class="col-md-3 text-right">{$lenguaje["tabla_campo_titulo"]}<td >:<td>{ucfirst(strtolower($datos.Var_Medida))|default:''}
                                                <tr>                                        
                                                    <td class="col-md-3 text-right">{$lenguaje["tabla_campo_articulos_aplicables"]}<td >:<td>{ucfirst(strtolower($datos.Mca_Valor))|default:''}
                                                <tr>                                        
                                                    <td class="col-md-3 text-right">{$lenguaje["tabla_campo_resumen_legislacion"]}<td >:<td >{$datos.Mca_Fecha|date_format:"%d/%m/%y"} 
                                                <tr>                                        
                                                    <td class="col-md-3 text-right">{$lenguaje["tabla_campo_fecha_revision"]}<td >:<td >{$datos.Pai_Nombre|default:''}
                                                <tr>                                 
                                            </tbody>
                                        </table>                              
                                    </td>                
                            </tbody>
                        </table>    
                    </div>
                </div>
            {/foreach}
        </div> 
    </div> 
</div>