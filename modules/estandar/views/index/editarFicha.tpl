<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">ESTANDARES DEL SISTEMA INTEGRADO</h4>
    </div>    
    <div id='gestion_idiomas_ficha'>
        {if  isset($idiomas) && count($idiomas)}
            
            <input type="hidden" id="Fie_IdFichaEstandar" value="{$datos.Fie_IdFichaEstandar}"/>
            <ul class="nav nav-tabs ">
            {foreach from=$idiomas item=idi}
                <li role="presentation" class="{if $datos.Idi_IdIdioma==$idi.Idi_IdIdioma} active {/if}">
                    <a class="idioma_s" id="idioma_{$idi.Idi_IdIdioma}" href="#">{$idi.Idi_Idioma}</a>
                    <input type="hidden" id="hd_idioma_{$idi.Idi_IdIdioma}" value="{$idi.Idi_IdIdioma}" />                    
                </li>    
            {/foreach}
            </ul>
        {/if}
        <div class="panel panel-default">
            <div class="panel-heading ">
                <h3 class="panel-title "><i style="float:right"class="fa fa-ellipsis-v"></i><i class="glyphicon glyphicon-inbox  "></i>&nbsp;&nbsp;<strong>EDITAR CAMPO</strong></h3>
            </div>        
            <div class="panel-body">
                <div id="nuevoRegistro">
                    <div style="width: 90%; margin: 0px auto">

                        <form class="form-horizontal" id="form1" name="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                            <input type="hidden" id="idIdiomaOriginal" name="idIdiomaOriginal" value="{$datos.Idi_IdIdioma}"/>
                            <input type="hidden" id="editar" name="editar" value="1"/>
                            <div class="form-group">                             
                                <label class="col-lg-3 control-label">Nombre Campo: </label>
                                <div class="col-lg-9">
                                    <input class="form-control" id ="nombre" name='nombre' type="text" pattern="([A-Z][\sa-no-z]+[a-z])" value="{$datos.Fie_CampoFicha|default:""}" placeholder="{$lenguaje.label_nombre}" required=""/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" >Tipo de Campo : </label>
                                <div class="col-lg-3">
                                    <select class="form-control" name="Fie_TipoDatoCampo" id="Fie_TipoDatoCampo" required="">                                    
                                        <option  value="" >-- Seleccionar --</option>
                                        <option {if $datos.Fie_ColumnaTipo == "Decimal"} selected="selected" {/if} value="Decimal" >Decimal</option>
                                        <option {if $datos.Fie_ColumnaTipo == "Entero"} selected="selected" {/if} value="Entero" >Entero</option>                                        
                                        <option {if $datos.Fie_ColumnaTipo == "Latitud"} selected="selected" {/if} value="Latitud" >Latitud</option>
                                        <option {if $datos.Fie_ColumnaTipo == "Longitud"} selected="selected" {/if} value="Longitud" >Longitud</option>    
                                        <option {if $datos.Fie_ColumnaTipo == "Texto"} selected="selected" {/if} value="Texto" >Texto</option>
                                    </select>
                                </div>
                                <div class="form-group-sm">
                                    <label class="col-lg-3 control-label" >Tamaño : </label>                                
                                    <div class="col-lg-3">
                                        {if $datos.Fie_ColumnaTipo == "Texto"}
                                            <input class="form-control" id ="Fie_TamanoColumna" name='Fie_TamanoColumna' type="text" pattern="(([1-9])?[0-9]+)" value="{$datos.Fie_TamanoColumna|default:""}" placeholder="Tamaño" required="required"/>
                                        {else}
                                            <input class="form-control" id ="Fie_TamanoColumna" name='Fie_TamanoColumna' disabled="disabled" type="text" pattern="(([1-9])?[0-9]+)" value="{$datos.Fie_TamanoColumna|default:""}" placeholder="Tamaño" required="required"/>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">                                    
                                <label class="col-lg-3 control-label">Campo Obligatorio : </label>
                                <div class="col-lg-3">
                                    <select class="form-control" name="Fie_ColumnaObligatorio" id="Fie_ColumnaObligatorio" required="">                                    
                                        <option  value="" >-- Seleccionar --</option>
                                        <option {if $datos.Fie_ColumnaObligatorio == 1} selected="selected" {/if} value="1" >Si</option>
                                        <option {if $datos.Fie_ColumnaObligatorio == 0} selected="selected" {/if} value="0" >No</option>
                                    </select>
                                </div>
                                <label class="col-lg-3 control-label">Requiere Traducción : </label>
                                <div class="col-lg-3">
                                    <select class="form-control" name="Fie_ColumnaTraduccion" id="Fie_ColumnaTraduccion" required="">                                    
                                        <option  value="" >-- Seleccionar --</option>
                                        <option {if $datos.Fie_ColumnaTraduccion == 1} selected="selected" {/if} value="1" >Si</option>
                                        <option {if $datos.Fie_ColumnaTraduccion == 0} selected="selected" {/if} value="0" >No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-1">
                                    <a class="btn btn-danger" href="{$_layoutParams.root}estandar/index/editarEstandar/{$datos.Esr_IdEstandarRecurso}" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_cancel}</a>
                                </div>
                                <div class="col-lg-offset-1 col-lg-1">
                                    <button class="btn btn-success" id="bt_guardarFicha" name="bt_guardarFicha" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
                                </div>
                            </div>
                        </form>
                    </div>        
                </div>
            </div>        
        </div>
    </div>
</div>