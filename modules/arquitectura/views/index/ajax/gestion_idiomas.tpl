{if  isset($datos) && count($datos)}
    {if  isset($idiomas) && count($idiomas)}
        <ul class="nav nav-tabs ">
        {foreach from=$idiomas item=idi}
            <li role="presentation" class="{if $datos.Idi_IdIdioma==$idi.Idi_IdIdioma} active {/if}">
                <a class="idioma_s" id="idioma_{$idi.Idi_IdIdioma}" href="#">{$idi.Idi_Idioma}</a>
                <input type="hidden" id="hd_idioma_{$idi.Idi_IdIdioma}" value="{$idi.Idi_IdIdioma}" />
                <input type="hidden" id="idiomaTradu" value="{$datos.Idi_IdIdioma}"/>
            </li>    
        {/foreach}
        </ul>
    {/if}
<div class = "panel panel-default" >
    <div class="panel-heading">
        <h3 aria-expanded="false" data-toggle="collapse" href="#collapse1" class="panel-title collapsed">
            <i style="float:right" class="glyphicon glyphicon-option-vertical"></i><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<strong>{$lenguaje.arquitectura_editar_titulo}</strong>
        </h3>
    </div>
    <div style="height: 0px;" aria-expanded="false" id="collapse1" class="panel-collapse collapse">
        <div class="panel-body">
            <div id="nueva_arquitectura" > 
                
                <form class=" form-horizontal " data-toggle="validator" id="form1" role="form" method="post" action="" autocomplete="on">
                    <input type="hidden" value="{$datos.Pag_IdPagina}" id="idPadreEditar" name="idPadreEditar" />
                    <input type="hidden" value="{$datos.Idi_IdIdioma}" id="idIdiomaEditar" name="idIdiomaEditar" />
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{$lenguaje.label_nombre} : </label>
                        <div class="col-lg-10">
                            <input class="form-control" id ="nombreEditar" type="text" name="nombreEditar"  placeholder="Nombre" value="{$datos.Pag_Nombre|default:""}" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label" >{$lenguaje.label_descripcion} : </label>
                        <div class="col-lg-10">
                            <textarea class="form-control" name="descripcionEditar" id="descripcionEditar" placeholder="Descripción" required>{$datos.Pag_Descripcion|default:""}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label" >{$lenguaje.label_orden} : </label>
                        <div class="col-lg-10">
                            {if $datos.Idi_IdIdioma != $IdiomaOriginal}  
                                <input type="hidden" id="ordenEditar" name="ordenEditar" value="{$datos.Pag_Orden}"/>
                                <input  class="form-control" disabled type="text" pattern="[1-9]+" data-maxlength="3" value="{$datos.Pag_Orden|default:""}" placeholder="Orden" required=""/>
                            {else}
                                <input  class="form-control"  id="ordenEditar" type="text" pattern="[1-9]+" data-maxlength="3" name="ordenEditar" value="{$datos.Pag_Orden|default:""}" placeholder="Orden" required=""/>
                            {/if}
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label" >{$lenguaje.label_url} : </label>
                        <div class="col-lg-10">
                            {if $datos.Idi_IdIdioma != $IdiomaOriginal}  
                                <input type="hidden" id="urlEditar" name="urlEditar" value="{$datos.Pag_Url}"/>
                                <input class="form-control" disabled type="text" placeholder="Url" value="{$datos.Pag_Url|default:""}"/>
                            {else}
                                <input class="form-control" id="urlEditar" type="text" name="urlEditar" placeholder="Url" value="{$datos.Pag_Url|default:""}"/>
                            {/if}                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label" >{$lenguaje.label_tipo} : </label>
                        <div class="col-lg-10">
                            {if $datos.Pag_TipoPagina==1} <input type="hidden" value="1" id="tipoEditar" name="tipoEditar"> {/if}
                            {if $datos.Pag_TipoPagina==2} <input type="hidden" value="2" id="tipoEditar" name="tipoEditar"> {/if}
                            {if $datos.Pag_TipoPagina==3} <input type="hidden" value="3" id="tipoEditar" name="tipoEditar"> {/if}
                            <select class="form-control " disabled="true" required>
                              <option value="">{$lenguaje.select_option_seleccione}</option>
                              <option value="1" {if $datos.Pag_TipoPagina==1} selected="selected" {/if}>Menú Superior</option>
                              <option value="2" {if $datos.Pag_TipoPagina==2} selected="selected" {/if}>Menú Izquierdo</option>
                              <option value="3" {if $datos.Pag_TipoPagina==3} selected="selected" {/if}>Página Suelta</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-success" id="editarPagina1" type="submit" name="editarPagina1" ><i class="glyphicon glyphicon-floppy-disk"> </i> {$lenguaje.button_ok}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{/if}

{if isset($contenido)}
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 aria-expanded="false" data-toggle="collapse" href="#collapse2" class="panel-title collapsed">
            <i style="float:right" class="glyphicon glyphicon-option-vertical"></i><i class="glyphicon glyphicon-edit"></i>&nbsp;&nbsp;<strong>{$lenguaje.arquitectura_editar_contenido_titulo}</strong>
        </h3>
    </div>
    <div style="height: 0px;" aria-expanded="false" id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
            <div id="nuevo_contenido" style="margin: 15px auto">
                <textarea class="ckeditor" cols="80" id="editor1" name="editor1" rows="40">{$contenido.Pag_Contenido|default:""}</textarea>
                <br>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-success" id="guardarContenido" type="button" ><i class="glyphicon glyphicon-floppy-disk"> </i> {$lenguaje.button_ok}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{/if}