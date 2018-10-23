<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">ESTANDARES DEL SISTEMA INTEGRADO</h4>
    </div>
    {if isset($tablaGenerada) && $tablaGenerada == 1}
        <div class="panel panel-default">
            <div class="panel-heading jsoftCollap">
                <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed"><i style="float:right"class="fa fa-ellipsis-v"></i><i class="glyphicon glyphicon-inbox  "></i>&nbsp;&nbsp;<strong>NUEVO CAMPO TABLA VARIABLE</strong></h3>
            </div>        
            <div style="height: 0px;" aria-expanded="false" id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id="nuevoRegistro">
                        <div style="width: 90%; margin: 0px auto">
                            <form class="form-horizontal" id="form2" name="form2" role="form" data-toggle="validator" method="post" action="" autocomplete="on">    
                                {if isset($ficha) && count($ficha)}
                                    {foreach from=$ficha item=fi}
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">
                                                {$fi.Fie_CampoFicha} :
                                            </label> 
                                            <div class="col-lg-8">
                                                <input type="text" name="{$fi.Fie_ColumnaTabla}" class="form-control" placeholder="{$fi.Fie_CampoFicha} ({if $fi.Fie_TipoDatoCampo=="int"} Entero {/if}{if $fi.Fie_TipoDatoCampo=="double"} Decimal {/if}{if $fi.Fie_TipoDatoCampo=="varchar" } Texto {/if})"/>
                                            </div>                                            
                                        </div>
                                    {/foreach}
                                {/if}                                                          
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-8">
                                        <button class="btn btn-success" id="bt_guardarFichaVariable" name="bt_guardarFichaVariable" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
                                    </div>
                                </div>
                            </form>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
    {/if}
    <div style=" margin: 15px auto">
        <div class="panel panel-default">
            <div class="panel-heading">
                <form  id="form2" role="form" method="post" action="" autocomplete="on">
                    <h3 class="panel-title">
                        <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;<strong>BUSCAR VARIABLE</strong>
                        {if isset($tablaGenerada) && $tablaGenerada == 1}
                            <button class="btn btn-xs btn-danger pull-right" id="bt_generarTablaData" name="bt_generarTablaData" type="submit" ><i class="glyphicon glyphicon-tasks " ></i>&nbsp; PROCESAR VARAIBLE</button>
                        {/if}
                    </h3>     
                </form>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 "> 
                        <div class="col-md-4 pull-right">
                            <div class="input-group">
                                {if isset($datos) && count($datos)}
                                    <input type="hidden" id="idEstandarRecurso" name="idEstandarRecurso" value="{$datos[0]['Esr_IdEstandarRecurso']}" />
                                {/if}
                                <input id="palabraVariable" type="text" class="form-control"  placeholder="Buscar Variable" name="palabraVariablee"/>                    
                                <span class="input-group-btn">
                                    <button id="buscarVariable" class="btn btn-success" type="button">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin: 15px 25px">
                <h4 class="panel-title"> <b>LISTA DE VARIABLES</b></h4>
                    <div id="listaregistrosVariables">
                    {if isset($variables) && count($variables)}
                        <div class="table-responsive" >
                            <table class="table" style=" text-align: center">
                                <tr>
                                    <th style=" text-align: center">N°</th>
                                    {if  isset($ficha) && count($ficha)}
                                        {foreach from=$ficha item=fi}                                                
                                            <th style=" text-align: center">{$fi.Fie_CampoFicha}</th>
                                        {/foreach}
                                    {/if}   
                                    <th style=" text-align: center">Estado</th>
                                    <th style=" text-align: center">Opciones</th>
                                </tr>
                                {foreach from=$variables item=us}
                                    <tr>
                                        <td>{$numeropagina++}</td>                  
                                        {if  isset($ficha) && count($ficha)}
                                            {foreach from=$ficha item=fi}
                                                <td>
                                                    {$us.{$fi.Fie_ColumnaTabla}}
                                                </td>
                                            {/foreach}
                                        {/if}
                                        <td>
                                            {if {$us.$columna_estado}==0}
                                                <i class="glyphicon glyphicon-remove-sign" title="deshabilitado" style="color: #DD4B39;"/>
                                            {else}
                                                <i class="glyphicon glyphicon-ok-sign" title="habilitado" style="color: #088A08;"/>
                                            {/if}
                                        </td>
                                        <td>
                                            {if $_acl->permiso("habilitar_deshabilitar_registros_recurso")} 
                                                <a class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.tabla_opcion_editar}" href="{$_layoutParams.root}estandar/registros/editarRegistro/{$us[0]}/{$us.Rec_IdRecurso}/{$us.Idi_IdIdioma}"></a>
                                            {/if}
                                            {if $_acl->permiso("editar_registros_recurso")}
                                                <a class="btn btn-default btn-sm glyphicon glyphicon-refresh ce_estandar" nombre_tabla="{$nombre_tabla}" estado_estandar="{if {$us.$columna_estado}==0}1{else}0{/if}" columna_estado="{$columna_estado}" title="{$lenguaje["cambiar_estado_bdrecursos"]}" valor_id="{$us[0]}"> </a>
                                            {/if}
                                            {if $_acl->permiso("eliminar_registros_recurso")}
                                                <a data-toggle="modal" data-target="#eliminar_estandar" href="#" type="button" title="{$lenguaje["label_eliminar_bdrecursos"]}" data-idrecursoestandar="{$idEstandarRecurso}" data-valorid="{$us[0]}" class="btn btn-default btn-sm glyphicon glyphicon-trash" >
                                                    </a>
                                            {/if}                                                
                                        </td>
                                    </tr>
                                {/foreach}
                            </table>
                        </div>          
                    <div class="panel-footer">
                        {$paginacion|default:""}
                    </div>
                    {else}
                        {$lenguaje.no_registros}
                    {/if}                          
                </div>
                </div>
            </div>
        </div>
    </div>
</div>