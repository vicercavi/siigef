<style type="text/css">
    body{
        background: #ddd;
    }
</style>
<div class="container" style="max-width:960px;background:#fff;box-shadow:3px 3px 3px rgba(0,0,0,.6);margin:10px auto;">
    <div class="row">
    <div class="col-md-12">
    <h2 class="tit-pagina-principal">Metadata</h2>
    </div>           
 </div> 
 {foreach item=datos from=$detalle}
<div class="panel panel-default">     
        <div class="table-responsive">
        <table class="table table-bordered">          
            <tbody>
                    <tr>
                        <td class="col-md-3"><b>Detalle de Legislación</b></td>
                        <td class="col-md-9" style="padding:0;border: 0;">

                            <table class="table table-bordered" style="margin:0;border:0;">
                                <tbody>
                                        <tr>
                                            <td class="col-md-3">Ambito de Legislación<td class="col-md-9">{$datos.Nil_Nombre}                                         
                                        <tr>
                                            <td class="col-md-3">Aspecto Legal<td class="col-md-9">{$datos.Snl_Nombre}                                                  
                                        <tr>
                                            <td class="col-md-3">Tema de Legislacion<td class="col-md-9">{$datos.Tel_Nombre}                        
                                        <tr>
                                            <td class="col-md-3">Pais<td class="col-md-9">{$datos.Pai_Nombre}                                 
                                </tbody>
                            </table>                              
                        </td>
            </tbody>
        </table>    
        </div>
</div>

<div class="panel panel-default">     
        <div class="table-responsive">
        <table class="table table-bordered">          
            <tbody>
                    <tr>
                        <td class="col-md-3"><b>Ficha Matriz Legal</b></td>
                        <td class="col-md-9" style="padding:0;border: 0;">

                            <table class="table table-bordered" style="margin:0;border:0;">
                                <tbody>
                                        <tr>                                        
                                            <td class="col-md-3">Fecha de Publicación<td class="col-md-9"><b>{$datos.Mal_FechaPublicacion}</b>
                                        <tr>                                        
                                            <td class="col-md-3">Entidad<td class="col-md-9"><b>{$datos.Mal_Entidad}</b>
                                        <tr>                                        
                                            <td class="col-md-3">Numero de Normas<td class="col-md-9"><b>{$datos.Mal_NumeroNormas}</b>
                                        <tr>                                        
                                            <td class="col-md-3">Titiulo<td class="col-md-9"><b>{$datos.Mal_Titulo}</b>
                                        <tr>                                        
                                            <td class="col-md-3">Articulo Aplicable<td class="col-md-9"><b>{$datos.Mal_ArticuloAplicable}</b>
                                        <tr>                                        
                                            <td class="col-md-3">Resumen de Legislación<td class="col-md-9"><b>{$datos.Mal_ResumenLegislacion}</b>
                                        <tr>                                        
                                            <td class="col-md-3">Fecha de Revisión<td class="col-md-9"><b>{$datos.Mal_FechaRevision}</b>
                                        <tr>                                        
                                            <td class="col-md-3">Normas Complementarias<td class="col-md-9"><b>{$datos.Mal_NormasComplemaentarias}</b>
                                        <tr>                                        
                                            <td class="col-md-3">Tipo de Legislación<td class="col-md-9"><b>{$datos.Mal_TipoLegislacion}</b>                                        
                                </tbody>
                            </table>                              
                        </td>
            </tbody>
        </table>    
        </div>
</div>



<!-- <br/>
<center><b>Detalle del Archivo</b></center>
<div  style="width:50%; margin:0 25%">
<table>
            <tbody>


<tr>
	<td  align="center">Nombre del Archivo</td>
    <td width="1%">:</td>
    <td>{$datos.Arf_PosicionFisica}</td>
</tr>
<tr>
	<td align="center">Formato</td>
    <td width="1%">:</td>
    <td><img src="{$_layoutParams.root}public/img/documentos/{$datos.Taf_Descripcion}.png" pais="{$datos.Taf_Descripcion}"/> {$datos.Taf_Descripcion}</td>
</tr>

<tr>
	<td  align="center">Tamaño del Archivo</td>
    <td width="1%">:</td>
    <td>{$datos.Dub_Titulo}</td>
</tr>
</tbody>
</table>
<center></center>

</div>
<br />
 -->
<!-- 

<div  style="width:50%; margin:0 25%">
<table>
            <tbody>
<tr>
	<td ><h3>Ficha Dublin Core</h3></td>
</tr>
</tbody>
</table>
</div>


            <div class="table-responsive" style="width:50%; margin:0 25%">
<table class="table">
            <tbody>

<tr>
	<td width="10%" align="center">Titulo</td>  
    <td><b>{$datos.Dub_Titulo}</b></td>
</tr>
<tr>
	<td width="10%" align="center">Autores</td>
    <td width="1%">:</td>
    <td><b>{$datos.Aut_Nombre}</b></td>
</tr>
<tr>
	<td width="10%" align="center">Tema</td>
    <td width="1%">:</td>
    <td><b>{$datos.Ted_Descripcion}</b></td>
</tr>
<tr>
	<td width="10%" align="center">Tipo Dublin Core</td>
    <td width="1%">:</td>
    <td><b>{$datos.Tid_Descripcion}</b></td>
</tr>
<tr>
	<td width="10%" align="center">Descripcion</td>
    <td width="1%">:</td>
    <td><b>{$datos.Dub_Descripcion}</b></td>
</tr>
<tr>
	<td width="10%" align="center">Fecha de Documento</td>
    <td width="1%">:</td>
    <td><b>{$datos.Dub_FechaDocumento}</b></td>
</tr>












<tr>
	<td width="10%" align="center">Formato</td>
    <td width="1%">:</td>
    <td><b>{$datos.Dub_Formato}</b></td>
</tr>

<tr>
	<td width="10%" align="center">Idioma</td>
    <td width="1%">:</td>
    <td><b>{$datos.Dub_Idioma}</b></td>
</tr> 

<tr>
	<td width="10%" align="center">Palabra Clave</td>
    <td width="1%">:</td>
    <td><b>{$datos.Dub_PalabraClave}</b></td>
</tr> 
  </tbody>
  </table>            
</div> -->
{/foreach}
</div>