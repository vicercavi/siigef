<style type="text/css">
    body{
        background: #ddd;
    }
</style>
<div class="container" style="max-width:960px;background:#fff;box-shadow:3px 3px 3px rgba(0,0,0,.6);margin:10px auto;">
    <div class="row">
    <div class="col-md-12">
    <h2 class="tit-pagina-principal">Editar Documento</h2>
    </div>           
 </div> 
 {foreach item=datos from=$detalle}
<div class="panel panel-default">     
        <div class="table-responsive">
        <table class="table table-bordered">          
            <tbody>
                    <tr>
                        <td class="col-md-3"><b>Detalle del Archivo</b></td>
                        <td class="col-md-9" style="padding:0;border: 0;">

                            <table class="table table-bordered" style="margin:0;border:0;">
                                <tbody>
                                        <tr>
                                            <td class="col-md-3">Nombre del Archivo<td class="col-md-9">{$datos.Arf_PosicionFisica}                                         
                                        <tr>
                                            <td class="col-md-3">Formato<td class="col-md-9"><img src="{$_layoutParams.root}public/img/documentos/{$datos.Taf_Descripcion}.png" pais="{$datos.Taf_Descripcion}"/> {$datos.Taf_Descripcion}                                                  
                                        <tr>
                                            <td class="col-md-3">Tamaño del Archivo<td class="col-md-9">{$datos.Dub_Titulo}                        
                                        
                                </tbody>
                            </table>                              
                        </td>
            </tbody>
        </table>    
        </div>
</div>

<div class="panel panel-default">
<form data-toggle="validator" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" id="registrardublincore">     
        <div class="table-responsive">
        <table class="table table-bordered">          
            <tbody>
                    <tr>
                        <td class="col-md-3"><b>Ficha Dublin Core</b></td>
                        <td class="col-md-9" style="padding:0;border: 0;">

                            <table class="table table-bordered" style="margin:0;border:0;">
                                <tbody>
                                        <tr>                                        
                                            <td class="col-md-3">Titulo<td class="col-md-9"><input type="text" class="form-control" id="Dub_Titulo" name="Dub_Titulo" value="{$datos.Dub_Titulo}">
                                        <tr>                                        
                                            <td class="col-md-3">Autores<td class="col-md-9"><input type="text" class="form-control" id="Aut_Nombre" name="Aut_Nombre" value="{$datos.Aut_Nombre}" disabled="disabled">
                                        <tr>                                        
                                            <td class="col-md-3">Tema<td class="col-md-9"><input type="text" class="form-control" id="Ted_Descripcion" name="Ted_Descripcion" value="{$datos.Ted_Descripcion}" disabled="disabled">
                                        <tr>                                        
                                            <td class="col-md-3">Tipo Dublin Core<td class="col-md-9"><input type="text" class="form-control" id="Tid_Descripcion" name="Tid_Descripcion" value="{$datos.Tid_Descripcion}" disabled="disabled">
                                        <tr>                                        
                                            <td class="col-md-3">Descripción<td class="col-md-9"><input type="text" class="form-control" id="Dub_Descripcion" name="Dub_Descripcion" value="{$datos.Dub_Descripcion}">
                                        <tr>                                        
                                            <td class="col-md-3">Fecha de Documento<td class="col-md-9"><input type="text" class="form-control" id="Dub_FechaDocumento" name="Dub_FechaDocumento" value="{$datos.Dub_FechaDocumento}">
                                        <tr>                                        
                                            <td class="col-md-3">Idioma<td class="col-md-9"><input type="text" class="form-control" id="Dub_Idioma" name="Dub_Idioma" value="{$datos.Dub_Idioma}" disabled="disabled">
                                        <tr>                                        
                                            <td class="col-md-3">Palabra Clave<td class="col-md-9"><input type="text" class="form-control" id="Dub_PalabraClave" name="Dub_PalabraClave" value="{$datos.Dub_PalabraClave}">                                        
                                </tbody>
                            </table>                              
                        </td>
            </tbody>
        </table>    
        </div>
        <center><button type="submit" class="btn btn-primary">Actualizar</button></center>
        <input type="hidden" value="1" name="actualizar" />
        </form>
</div>


{/foreach}
</div>