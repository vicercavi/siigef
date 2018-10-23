<form class="form-horizontal" id="form1" role="form" method="post" action="" autocomplete="on">
    <input type="hidden" value="1" name="enviar" />

    <div class="form-group" >
        <label class="col-lg-2 control-label">Idioma: </label>
        <div class="col-lg-10">
            <input type="checkbox"  name="español" id="" /> Español
            <input type="checkbox"  name="portugues" id="" /> Portugués
            <input type="checkbox"  name="ingles" id="" /> Inglés
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Nombre: </label>
        <div class="col-lg-10">
            <p><input class="form-control" id ="nombre"type="text" name="nombre"  placeholder="Nombre" /></p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label" >Descripción: </label>
        <div class="col-lg-10">
            <p><textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripción" ></textarea></p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label" >Orden: </label>
        <div class="col-lg-10">

            <select class="form-control " id="orden" name="orden">
              <option value="">Seleccione</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label" >Url: </label>
        <div class="col-lg-10">
            <p><input class="form-control" id="url" type="text" name="url" placeholder="Url"/></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label" >Tipo: </label>
        <div class="col-lg-10">
            {if  isset($datos) && count($datos) && $datos.Pag_TipoPagina >0}
                <select class="form-control" disabled="true" id="tipoPagina" name="tipoPagina" style=" float: left; margin: 0px 4px 0px 4px" >
                    <option value="">Seleccione</option>
                    <option value="1" {if $datos.Pag_TipoPagina==1} selected="selected" {/if}>Menú Superior</option>
                    <option value="2" {if $datos.Pag_TipoPagina==2} selected="selected" {/if}>Menú Izquierdo</option>
                    <option value="3" {if $datos.Pag_TipoPagina==3} selected="selected" {/if}>Página Suelta</option>
                </select>
            {else}
            <select class="form-control" id="tipoPagina" name="tipoPagina" style=" float: left; margin: 0px 4px 0px 4px" >
                <option value="">Seleccione</option>
                <option value="1">Menú Superior</option>
                <option value="2">Menú Izquierdo</option>
                <option value="3">Página Suelta</option>
            </select>
            {/if}
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <button class="btn btn-success" id="guardarPagina" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i> Guardar</button>
            <button class="btn btn-danger" id="cancelarNuevo" type="button" ><i class="glyphicon glyphicon-remove-sign"> </i> Cancelar</button>
        </div>
    </div>
</form>