<style type="text/css">
    body{
        background: #ddd;
    }
</style>
<div class="container" style="max-width:960px;background:#fff;box-shadow:3px 3px 3px rgba(0,0,0,.6);margin:10px auto;">
	<div class="row">
        <div class="col-md-12">
            <h2 class="tit-pagina-principal" align="center">Registro Pecari</h2>
        </div>           
	</div>
    <div class="panel panel-success">
  <div class="panel-heading"></div>
  <div class="panel-body">
    <form  data-toggle="validator" class="form-horizontal" role="form" enctype="multipart/form-data" method="post" id="registrarpecari">
      <div class="form-group">
        <label for="proveedor" class="col-md-4 control-label">Ruta Proveedor</label>
        <div class="col-md-5">          
          <input type="text" class="form-control" id="Proveedor" name="Proveedor" 
                 placeholder="url proveedor" >
        </div>
      </div>
      {if $estandar==3}
      <div class="form-group">
        <label for="proveedor" class="col-md-4 control-label">Archivos a Subir</label>
        <div class="col-md-5">          
          <input type="file" name="archivos[]" id="archivos" multiple="multiple">
        </div>
      </div>
      {/if}
      
     <div class="form-group">
        <div class="col-md-offset-4 col-md-5">
          <button type="submit" class="btn btn-success">Registrar</button>
        <input type="hidden" value="1" name="registrar" />
        </div>
      </div>
    </form>
  </div> 
</div>
</div>