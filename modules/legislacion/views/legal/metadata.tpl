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
      <a href="{$_layoutParams.root}legislacion/legal">{$lenguaje["label_h2_titulo"]} </a>
    </li>
    <li>/</li>
    <li>
      <a class='actual' >{$lenguaje["label_h2_metadata_titulo"]} </a>
    </li>
  </ul>     
</div>
<div class="container col-lg-12" style="margin:10px auto;">
    <div class="row">
        <div class="col-md-12">
            <h2 class="tit-pagina-principal"><center>{$lenguaje["label_h2_metadata_titulo"]}</center></h2>
        </sdiv>    
        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-offset-1 col-lg-3">
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
    
        <div class="col-xs-12 col-sm-8 col-md-offset-0 col-md-9 col-lg-offset-0 col-lg-7">
            {foreach item=datos from=$detalle}
                <div class="panel panel-default">     
                    <div class="table-responsive">
                        <table class="table table-user-information">          
                            <tbody>
                                <tr>
                                    <td class="col-md-3" style="vertical-align:middle; text-align:center; background-color: rgb(249, 249, 249);"><b>{$lenguaje["label_detalle"]}</b></td>
                                    <td class="col-md-9" style="padding:0;border: 0;">
                                        <table class="table table-user-information" style="margin:0;border:0;">
                                            <tbody>
                                                <tr>                                        
                                                    <td class="col-md-3 text-right"><b>{$lenguaje["tabla_campo_titulo"]}</b><td >:<td >{(($datos.Mal_Titulo))|default:''}                                        
                                                <tr>                                        
                                                    <td class="col-md-3 text-right"><b>{$lenguaje["tabla_campo_resumen_legislacion"]}</b><td >:<td class="text-justify">{(($datos.Mal_ResumenLegislacion))|default:''}
                                                <tr>                                        
                                                    <td class="col-md-3 text-right"><b>{$lenguaje["tabla_campo_entidad"]}</b><td >:<td >{(($datos.Mal_Entidad))|default:''}
                                                <tr>                                        
                                                    <td class="col-md-3 text-right"><b>{$lenguaje["tabla_campo_tipo_legislacion"]}</b><td >:<td>{(($datos.Til_Nombre))|default:''}     
                                                <tr>                                        
                                                    <td class="col-md-3 text-right"><b>{$lenguaje["tabla_campo_numero_norma"]}</b><td >:<td>{(($datos.Mal_NumeroNormas))|default:''}
                                                <tr>                                        
                                                    <td class="col-md-3 text-right"><b>{$lenguaje["tabla_campo_articulos_aplicables"]}</b><td >:<td >{(($datos.Mal_ArticuloAplicable))|default:''}
                                                <tr>  
                                                    <td class="col-md-3 text-right"><b>{$lenguaje["tabla_campo_ambito"]}</b><td >:<td >{(($datos.Nil_Nombre))|default:''}                                         
                                                <tr>
                                                    <td class="col-md-3 text-right"><b>{$lenguaje["tabla_campo_aspecto"]}</b><td >:<td >{(($datos.Snl_Nombre))|default:''}                                                  
                                                <tr>
                                                    <td class="col-md-3 text-right"><b>{$lenguaje["tabla_campo_tema"]}</b><td >:<td >{(($datos.Tel_Nombre))|default:''}                        
                                                <tr>
                                                    <td class="col-md-3 text-right"><b>{$lenguaje["tabla_campo_pais"]}</b><td >:<td >{(($datos.Pai_Nombre))|default:''}
                                                    <tr>                                        
                                                    <td class="col-md-3 text-right"><b>{$lenguaje["tabla_campo_fecha_publicacion"]}</b><td >:<td >{$datos.Mal_FechaPublicacion|date_format:"%d/%m/%Y"|default:''}
                                                 <tr>
                                                    <td class="col-md-3 text-right"><b>{$lenguaje["tabla_campo_fecha_revision"]}</b><td >:<td >{$datos.Mal_FechaRevision|date_format:"%d/%m/%Y"|default:''}
                                                <tr>                                        
                                                    <td class="col-md-3 text-right"><b>{$lenguaje["tabla_campo_normas_complementarias"]}</b><td >:<td>{(($datos.Mal_NormasComplementarias))|default:''}                                                       
                                            </tbody>
                                        </table>                              
                                    </td>
                                </tr>
                            </tbody>
                        </table>    
                    </div>
                </div>
            {/foreach}
        </div> 
    </div>    
 </div> 
