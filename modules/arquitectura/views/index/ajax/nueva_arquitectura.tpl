{if isset($_error)}
    <div id="_errl" class="alert alert-error ">
        <a class="close" data-dismiss="alert">x</a>
        {$_error}
    </div>
{/if}

{if isset($_mensaje)}
    <div id="_msgl" class="alert alert-success">
        <a class="close" data-dismiss="alert">x</a>
        {$_mensaje}
    </div>
{/if}

<form class="form-horizontal" role="form" method="post" action="" autocomplete="on"  style=" margin: 15px auto">
    <input type="hidden" value="1" id="idPagina" name="enviar" />

    <div class="form-group">
        <label class="col-lg-2 control-label">Nombre: </label>
        <div class="col-lg-10">
            <p><input class="form-control" id ="nombreEditar" type="text" name="nombre"  placeholder="Nombre" value="{$datos.Pag_Nombre|default:""}"/></p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label" >Descripción: </label>
        <div class="col-lg-10">
            <p><textarea class="form-control" name="descripcion" id="descripcionEditar" placeholder="Descripción" >{$datos.Pag_Descripcion|default:""}</textarea></p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label" >Orden: </label>
        <div class="col-lg-10">

            <p><select class="form-control" id="ordenEditar" name="orden" >
              <option value="0">Seleccione</option>
              <option value="1" {if $datos.Pag_Orden==1} selected="selected" {/if}>1</option>
              <option value="2" {if $datos.Pag_Orden==2} selected="selected" {/if}>2</option>
              <option value="3" {if $datos.Pag_Orden==3} selected="selected" {/if}>3</option>
              <option value="4" {if $datos.Pag_Orden==4} selected="selected" {/if}>4</option>
              <option value="5" {if $datos.Pag_Orden==5} selected="selected" {/if}>5</option>
              <option value="6" {if $datos.Pag_Orden==6} selected="selected" {/if}>6</option>
            </select></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label" >Url: </label>
        <div class="col-lg-10">
            <p><input class="form-control" id="urlEditar" type="text" name="url" placeholder="Url" value="{$datos.Pag_Url|default:""}"/></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label" >Tipo: </label>
        <div class="col-lg-10">
            <p><select class="form-control " disabled="true" id="tipoEditar" name="tipo">
              <option value="0">Seleccione</option>
              <option value="1" {if $datos.Pag_TipoPagina==1} selected="selected" {/if}>Menú Superior</option>
              <option value="2" {if $datos.Pag_TipoPagina==2} selected="selected" {/if}>Menú Izquierdo</option>
              <option value="3" {if $datos.Pag_TipoPagina==3} selected="selected" {/if}>Página Suelta</option>
            </select></p>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-success" id="editarPagina" type="button" ><i class="glyphicon glyphicon-floppy-disk"> </i> Guardar</button>
            <button class="btn btn-danger" id="cancelarEdicion" type="button" ><i class="glyphicon glyphicon-remove-sign"> </i> Cancelar</button>
        </div>
    </div>
</form>