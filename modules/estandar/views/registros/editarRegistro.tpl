<div class="container-fluid" >
    <div class="row">
        <div class="col-md-12">
            <h3 class="titulo-view">Editor de {$nombre_tabla2}</h3>     
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
                                    <td>{$lenguaje["label_nombre_bdrecursos"]}:</td>
                                    <td>{$recurso.Rec_Nombre}</td>
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
                                    <td>{$lenguaje["registros_bdrecursos"]}</td>
                                    <td>{$recurso.Rec_CantidadRegistros}</td>
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
        <div id='gestion_idiomas'>
        {if  isset($idiomas) && count($idiomas)}
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
            <h3 class="panel-title "><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<strong>EDITAR REGISTRO</strong></h3>
        </div>
             <form class="form-horizontal" id="form1" name="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                        
                        {if  isset($ficha) && count($ficha)}
                            <input type="hidden" id="Rec_IdRecurso" name="Rec_IdRecurso" value="{$idRecurso}" />
                            {if  isset($datos) && count($datos)}
                            <input type="hidden" id="Reg_IdRegistro" name="Reg_IdRegistro" value="{$datos[0]}" />
                            <input type="hidden" id="Idi_IdIdioma" name="Idi_IdIdioma" value="{$datos.Idi_IdIdioma}" />
                            {/if}
                            {foreach from=$ficha item=fi}
                                <div class="form-group">                                    
                                    <label class="col-lg-3 control-label">{$fi.Fie_CampoFicha} :
                                    
                                    </label>
                                     
                                    <div class="col-lg-8">
                                        {if $fi.Fie_TamanoColumna>=300}
                                               <textarea class="ckeditor form-control " id ="{$fi.Fie_ColumnaTabla}"  name="{$fi.Fie_ColumnaTabla}" type="text" 
                                                      placeholder="{$fi.Fie_CampoFicha} ({if $fi.Fie_TipoDatoCampo=="int"} Entero {/if}{if $fi.Fie_TipoDatoCampo=="double"} Decimal {/if}{if $fi.Fie_TipoDatoCampo=="varchar" } Texto {/if})" {if $fi.Fie_ColumnaObligatorio==1 } required="" {/if}>
                                                {$datos.{$fi.Fie_ColumnaTabla}}
                                            </textarea>
                                            {else}
                                            <input class="form-control " id ="{$fi.Fie_ColumnaTabla}" name="{$fi.Fie_ColumnaTabla}" type="text" value="{$datos.{$fi.Fie_ColumnaTabla}}"
                                               placeholder="{$fi.Fie_CampoFicha} ({if $fi.Fie_TipoDatoCampo=="int"} Entero {/if}{if $fi.Fie_TipoDatoCampo=="double"} Decimal {/if}{if $fi.Fie_TipoDatoCampo=="varchar" } Texto {/if})" {if $fi.Fie_ColumnaObligatorio==1 } required="" {/if}/>       
                                       
                                         
                                        {/if}
                                    </div>
                                </div>
                            {/foreach}
                        {/if}

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-1">
                                <a class="btn btn-danger" href="{$_layoutParams.root}bdrecursos/registros/{$idRecurso}" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; Atras</a>
                            </div>
                            <div class="col-lg-offset-1 col-lg-1">
                                <button class="btn btn-success" id="bt_guardarRegistro" name="bt_guardarRegistro" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
                            </div>
                        </div>
                    </form>
                    </div>
                    </div>
        </div>  
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p><center>{$mensaje}</center></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>

