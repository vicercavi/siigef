<div  class="container-fluid" >       
    <h3 class="titulo-view">{$lenguaje.arquitectura_label_titulo}</h3>
    <br>
    {if $_acl->permiso("editar_arquitectura_web")}
    <div id='gestion_idiomas'>
        {if isset($datos) && count($datos)}
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
                        
                        <form class=" form-horizontal " data-toggle="validator" id="form1" name="form1" role="form" method="post" action="" autocomplete="on">
                            <input type="hidden" value="{$datos.Pag_IdPrincipal}" id="idPrincipalEditar" name="idPrincipalEditar" />
                            <input type="hidden" value="{$datos.Pag_IdPagina}" id="idPadreEditar" name="idPadreEditar" />
                            <input type="hidden" value="{$datos.Idi_IdIdioma}" id="idIdiomaEditar" name="idIdiomaEditar" />
                            <div class="form-group">
                                <label class="col-lg-2 control-label">{$lenguaje.label_nombre} : </label>
                                <div class="col-lg-10">
                                    <input class="form-control" id ="nombreEditar" type="text" name="nombreEditar"  placeholder="{$lenguaje.label_nombre}" value="{$datos.Pag_Nombre|default:""}" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">{$lenguaje.label_descripcion} : </label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" name="descripcionEditar" id="descripcionEditar" placeholder="{$lenguaje.label_descripcion}" required>{$datos.Pag_Descripcion|default:""}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label" >{$lenguaje.label_orden} : </label>
                                <div class="col-lg-10">
                                    <input  class="form-control"  id="ordenEditar" type="text" pattern="[1-9]+" maxlength="3"  name="ordenEditar" value="{$datos.Pag_Orden|default:""}" placeholder="{$lenguaje.label_orden}" required=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label" >{$lenguaje.label_tipo} : </label>
                                <div class="col-lg-10">
                                    <select class="form-control" id="tipoEditar" name="tipoEditar" style=" float: left; margin: 0px 4px 0px 4px" required>                                      
                                        <option value="0" {if $datos.Pag_Selectable==0} selected="selected" {/if}>{$lenguaje.arquitectura_buscar_opcion4}</option>
                                        <option value="1" {if $datos.Pag_Selectable==1} selected="selected" {/if}>{$lenguaje.arquitectura_buscar_opcion5}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label" >{$lenguaje.label_url} : </label>
                                <div class="col-lg-10">
                                    <input class="form-control" id="urlEditar" type="text" name="urlEditar" placeholder="{$lenguaje.label_url}" value="{$datos.Pag_Url|default:""}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label" >{$lenguaje.label_posicion} : </label>
                                <div class="col-lg-10">
                                    {if $datos.Pag_TipoPagina==1} <input type="hidden" value="1" id="posicionEditar" name="posicionEditar"> {/if}
                                    {if $datos.Pag_TipoPagina==2} <input type="hidden" value="2" id="posicionEditar" name="posicionEditar"> {/if}
                                    {if $datos.Pag_TipoPagina==3} <input type="hidden" value="3" id="posicionEditar" name="posicionEditar"> {/if}
                                    <select class="form-control " disabled="true" required>
                                        <option value="">{$lenguaje.select_option_seleccione}</option>
                                        <option value="1" {if $datos.Pag_TipoPagina==1} selected="selected" {/if}>{$lenguaje.arquitectura_buscar_opcion1}</option>
                                        <option value="2" {if $datos.Pag_TipoPagina==2} selected="selected" {/if}>{$lenguaje.arquitectura_buscar_opcion2}</option>
                                        <option value="3" {if $datos.Pag_TipoPagina==3} selected="selected" {/if}>{$lenguaje.arquitectura_buscar_opcion3}</option>
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
    </div>
    {/if}
    {if $_acl->permiso("agregar_arquitectura_web")}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed">
                <i style="float:right" class="glyphicon glyphicon-option-vertical"></i><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;&nbsp;<strong>{$lenguaje.arquitectura_nuevo_titulo}</strong>
            </h3>
        </div>
        <div style="height: 0px;" aria-expanded="false" id="collapse3" class="panel-collapse collapse">
            <div class="panel-body">
                <div id="nueva_arquitectura_hijo" style=" margin: 15px auto" >
                    <form class=" form-horizontal " data-toggle="validator" id="form2" name="form2" role="form" method="post" action="" autocomplete="on">
                 
                        {if  isset($datos) && count($datos)}
                        <input type="hidden" value="{$datos.Pag_IdPagina}" id="idPadre" name="idPadre" />
                        {else}
                            <input type="hidden" value="0" id="idPadre" name="idPadre" />
                        {/if}
                        
                        <div class="form-group" >
                            <label class="col-lg-2 control-label">{$lenguaje.label_idioma} : </label>
                            {if  isset($idiomas) && count($idiomas)}              
                                <div class="form-inline col-lg-10">
                                {foreach from=$idiomas item=idi}
                                    {if  isset($datos) && count($datos)}
                                    {if $datos.Idi_IdIdioma==$idi.Idi_IdIdioma} <input type="hidden" value="{$idi.Idi_Idioma}" id="idiomaRadio" name="idiomaRadio"> {/if}
                                    <div class="radio">
                                        <label>
                                            <input disabled="true" type="radio"  value="{$idi.Idi_IdIdioma}" 
                                                {if $datos.Idi_IdIdioma==$idi.Idi_IdIdioma} checked="checked" {/if} required>
                                            {$idi.Idi_Idioma}
                                        </label>                                        
                                    </div>   
                                    {else}
                                    <div class="radio">
                                        <label>
                                            <input type="radio"  name="idiomaRadio" id="idiomaRadio" value="{$idi.Idi_IdIdioma}"  
                                                {if isset($idiomaUrl) && $idiomaUrl == $idi.Idi_IdIdioma } checked="checked" {/if} required>
                                            {$idi.Idi_Idioma} 
                                        </label>                                        
                                    </div>
                                    {/if}
                                {/foreach}
                                </div>              
                            {/if}
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">{$lenguaje.label_nombre} : </label>
                            <div class="col-lg-10">
                                <input class="form-control" id ="nombre" type="text" name="nombre"  placeholder="{$lenguaje.label_nombre}" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" >{$lenguaje.label_descripcion} : </label>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="{$lenguaje.label_descripcion}" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" >{$lenguaje.label_orden} : </label>
                            <div class="col-lg-10">
                                <input  class="form-control"  id="orden" type="text" pattern="[1-9]+" maxlength="3" name="orden" placeholder="{$lenguaje.label_orden}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" >{$lenguaje.label_tipo} : </label>
                            <div class="col-lg-10">
                                <select class="form-control" id="tipoPagina" name="tipoPagina" style=" float: left; margin: 0px 4px 0px 4px" required>
                                    <option value="">{$lenguaje.select_option_seleccione}</option>
                                    <option value="0">{$lenguaje.arquitectura_buscar_opcion4}</option>
                                    <option value="1">{$lenguaje.arquitectura_buscar_opcion5}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" >{$lenguaje.label_url} : </label>
                            <div class="col-lg-10">
                                <input class="form-control" id="url" type="text" name="url" placeholder="{$lenguaje.label_url}" required="" disabled="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" >{$lenguaje.label_posicion} : </label>
                            <div class="col-lg-10">
                                 {if  isset($datos) && count($datos) && $datos.Pag_TipoPagina >0}
                                    {if $datos.Pag_TipoPagina==1} <input type="hidden" value="1" id="posicionPagina" name="posicionPagina"> {/if}
                                    {if $datos.Pag_TipoPagina==2} <input type="hidden" value="2" id="posicionPagina" name="posicionPagina"> {/if}
                                    {if $datos.Pag_TipoPagina==3} <input type="hidden" value="3" id="posicionPagina" name="posicionPagina"> {/if}
                                    <select class="form-control" disabled="true" style=" float: left; margin: 0px 4px 0px 4px" required>
                                        <option value="">{$lenguaje.select_option_seleccione}</option>
                                        <option value="1" {if $datos.Pag_TipoPagina==1} selected="selected" {/if}>{$lenguaje.arquitectura_buscar_opcion1}</option>
                                        <option value="2" {if $datos.Pag_TipoPagina==2} selected="selected" {/if}>{$lenguaje.arquitectura_buscar_opcion2}</option>
                                        <option value="3" {if $datos.Pag_TipoPagina==3} selected="selected" {/if}>{$lenguaje.arquitectura_buscar_opcion3}</option>
                                    </select>
                                {else}
                                <select class="form-control" id="posicionPagina" name="posicionPagina" style=" float: left; margin: 0px 4px 0px 4px" required>
                                    <option value="">{$lenguaje.select_option_seleccione}</option>
                                    <option value="1">{$lenguaje.arquitectura_buscar_opcion1}</option>
                                    <option value="2">{$lenguaje.arquitectura_buscar_opcion2}</option>
                                    <option value="3">{$lenguaje.arquitectura_buscar_opcion3}</option>
                                </select>
                                {/if}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-success" id="guardarPagina1" name="guardarPagina1" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i> {$lenguaje.button_ok}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {/if}
    <div style=" margin: 15px auto">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;<strong>{$lenguaje.arquitectura_buscar_titulo}</strong>                       
                </h3>
            </div>
            <div class="panel-body">
                  <form name="form3" class="form-inline" method="post" action="" autocomplete="on">
                    {if  isset($datos) && count($datos)}
                        <input type="hidden" value="{$datos.Pag_IdPagina}" id="idPadreIdiomas" name="idPadreIdiomas" />
                    {else}
                        <input type="hidden" value="0" id="idPadreIdiomas" name="idPadreIdiomas" />
                    {/if}
                    {if  isset($original) && count($original)}
                    <input type="hidden" value="{$original.Idi_IdIdioma}" id="idIdiomaOriginal" name="idIdiomaOriginal" />
                    {/if}
                    <div class="row" style="text-align: right;padding-right: 2em; margin-top: 10px">
                        <input class="form-control" placeholder="{$lenguaje.text_buscar_pagina}"  name="palabra" id="palabra">
                        {if  isset($datos) && count($datos) && $datos.Pag_TipoPagina >0}
                        <select class="form-control " disabled="true" id="buscarTipo" name="buscarTipo" style=" margin: 0px 10px">
                            <option value="0">{$lenguaje.arquitectura_buscar_opcion0}</option>
                            <option value="1" {if $datos.Pag_TipoPagina==1} selected="selected" {/if}>{$lenguaje.arquitectura_buscar_opcion1}</option>
                            <option value="2" {if $datos.Pag_TipoPagina==2} selected="selected" {/if}>{$lenguaje.arquitectura_buscar_opcion2}</option>
                            <option value="3" {if $datos.Pag_TipoPagina==3} selected="selected" {/if}>{$lenguaje.arquitectura_buscar_opcion3}</option>
                        </select>
                        {else}
                        <select class="form-control" id="buscarTipo" name='buscarTipo' style="margin: 0px 10px" >
                            <option value="0">{$lenguaje.arquitectura_buscar_opcion0}</option>
                            <option value="1">{$lenguaje.arquitectura_buscar_opcion1}</option>
                            <option value="2">{$lenguaje.arquitectura_buscar_opcion2}</option>
                            <option value="3">{$lenguaje.arquitectura_buscar_opcion3}</option>
                        </select>
                        {/if}
                        <button class="btn btn-primary" type="button" id="buscar"  ><i class="glyphicon glyphicon-search"></i></button>
                    </div>    
                </form>

                <h4><b>{$lenguaje.arquitectura_buscar_tabla_titulo}</b></h4>

                <div id="listaregistros">
                    {if isset($arquitectura) && count($arquitectura)}
                    <div class="table-responsive" >
                        <table class="table">
                            <tr>
                                <th>#</th>
                                <th>{$lenguaje.label_nombre}</th>
                                <th>{$lenguaje.label_orden}</th>
                                <th>{$lenguaje.label_descripcion}</th>
                                <th>{$lenguaje.label_tipo}</th>
                                <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                {if $_acl->permiso("editar_arquitectura_web")}
                                <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                {/if}
                            </tr>
                            {foreach from=$arquitectura item=ar}
                                <tr>
                                    <td>{$numeropagina++}</td>
                                    <td>{$ar.Pag_Nombre}</td>
                                    <td>{$ar.Pag_Orden}</td>
                                    <td>{$ar.Pag_Descripcion}</td>
                                    <td>
                                        {if $ar.Pag_TipoPagina==1}{$lenguaje.arquitectura_buscar_opcion1}{/if}
                                        {if $ar.Pag_TipoPagina==2}{$lenguaje.arquitectura_buscar_opcion2}{/if}
                                        {if $ar.Pag_TipoPagina==3}{$lenguaje.arquitectura_buscar_opcion3}{/if}
                                    </td>
                                    <td style=" text-align: center">
                                        {if $ar.Pag_Estado==0}
                                            <p class="glyphicon glyphicon-remove-sign " title="Desabilitado" style="color: #DD4B39;"></p>
                                        {/if}                            
                                        {if $ar.Pag_Estado==1}
                                            <p class="glyphicon glyphicon-ok-sign " title="Habilitado" style="color: #088A08;"></p>
                                        {/if}
                                    </td>
                                    {if $_acl->permiso("editar_arquitectura_web")}
                                    <td style=" text-align: center">
                                        <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.tabla_opcion_editar}" href="{$_layoutParams.root}arquitectura/index/index/{$ar.Pag_IdPagina}"> </a>                          
                                        <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-edit" title="{$lenguaje.tabla_opcion_editar_cont}"  href="{$_layoutParams.root}arquitectura/index/index/{$ar.Pag_IdPagina}/{$ar.Pag_IdPagina}"> </a>
                                        <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh cambiarEstadoPagina" title="{$lenguaje.tabla_opcion_cambiar_est}" Pag_IdPagina="{$ar.Pag_IdPagina}" Pag_Estado="{$ar.Pag_Estado}"> </a>
                                    </td>
                                    {/if}
                                </tr>
                            {/foreach}
                        </table>
                    </div>
                    {$paginacion|default:""}
                    {else}
                        {$lenguaje.no_registros}
                    {/if}                    
                </div>
            </div>
        </div>
    </div>
</div>