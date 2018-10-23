<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">RECURSO : {$recurso}</h4>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading jsoftCollap">
            <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed"><i style="float:right"class="fa fa-ellipsis-v"></i><i class="fa fa-database fa-plus"></i>&nbsp;&nbsp;<strong>NUEVO REGISTRO</strong></h3>
        </div>
        <div style="height: 0px;" aria-expanded="false" id="collapse3" class="panel-collapse collapse">
            <div class="panel-body">
                <div id="nuevoRegistro">
                    <div style="width: 90%; margin: 0px auto">

                        <form class="form-horizontal" id="form1" name="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
    
                            {if  isset($ficha) && count($ficha)}
                                {foreach from=$ficha item=fi}
                                    <div class="form-group">                                    
                                        <label class="col-lg-3 control-label">
                                            {$fi.Fie_CampoFicha} :
                                            <br>
                                            {if $fi.Fie_TipoDatoCampo=="varchar" }  
                                                <div class="radio">
                                                    <label>
                                                        <input type="checkbox" class="cb_texto_editor" name="rb-{$fi.Fie_ColumnaTabla}" id="rb-{$fi.Fie_ColumnaTabla}" value="">  
                                                          Texto enriquecido
                                                    </label>                                        
                                                </div> 
                                            {/if}
                                        </label>
                                        
                                        <div class="col-lg-8">
                                            <input class="form-control {$fi.Fie_ColumnaTabla}-text" id ="{$fi.Fie_ColumnaTabla}" name="{$fi.Fie_ColumnaTabla}" type="text" 
                                                   placeholder="{$fi.Fie_CampoFicha} ({if $fi.Fie_TipoDatoCampo=="int"} Entero {/if}{if $fi.Fie_TipoDatoCampo=="double"} Decimal {/if}{if $fi.Fie_TipoDatoCampo=="varchar" } Texto {/if})" {if $fi.Fie_ColumnaObligatorio==1 } required="" {/if} />
                                            {if $fi.Fie_TipoDatoCampo=="varchar"}
                                            <textarea class="hide form-control {$fi.Fie_ColumnaTabla}-textarea " id ="{$fi.Fie_ColumnaTabla}"  name="{$fi.Fie_ColumnaTabla}" type="text" 
                                                      placeholder="{$fi.Fie_CampoFicha} ({if $fi.Fie_TipoDatoCampo=="int"} Entero {/if}{if $fi.Fie_TipoDatoCampo=="double"} Decimal {/if}{if $fi.Fie_TipoDatoCampo=="varchar" } Texto {/if})" {if $fi.Fie_ColumnaObligatorio==1 } required="" {/if} >
                                            </textarea>
                                            {/if}
                                        </div>
                                    </div>
                                {/foreach}
                            {/if}
                                
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-8">
                                <button class="btn btn-success" id="bt_guardarFichaEstandar" name="bt_guardarFichaEstandar" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
                                </div>
                            </div>
                        </form>
                    </div>        
                </div>
            </div>
        </div>
    </div>
    <div style=" margin: 15px auto">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;<strong>LISTA DE REGISTROS</strong>                       
                </h3>
            </div>
            <div class="panel-body">
                <div class="row" style="text-align: right;padding-right: 2em;">
                    <div style="display:inline-block">
                        <input class="form-control" type="text" id="palabra" placeholder="{$lenguaje.text_buscar_usuario}" style="width: 150px; float: left;  margin: 0px 10px;" name="nombre" />
                        <button class="btn btn-primary" style=" float: left" type="button" id="buscar" ><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div> 
                
                <div style="margin: 15px 25px">

                <h4 class="panel-title"> <b>LISTA DE ESTANDAR</b></h4>
                    <div id="listaregistros">
                        {if isset($datos) && count($datos)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">N°</th>
                                        {if  isset($ficha) && count($ficha)}
                                            {foreach from=$ficha item=fi}                                                
                                                <th style=" text-align: center">{$fi.Fie_CampoFicha}</th>                                                
                                            {/foreach}
                                        {/if}                                        
                                        <th style=" text-align: center">Opciones</th>
                                    </tr>
                                    {foreach from=$datos item=us}
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
                                                <a class="btn btn-default btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.tabla_opcion_editar}" href="{$_layoutParams.root}estandar/registros/editarRegistro/{$us[0]}/{$us.Rec_IdRecurso}/{$us.Idi_IdIdioma}"></a>                                                
                                                <a class="btn btn-default btn-sm glyphicon glyphicon-refresh" title="{$lenguaje.tabla_opcion_cambiar_est}" href="{$_layoutParams.root}estandar/index/_cambiarEstado/{$us.Usu_IdUsuario}/{$us.Usu_Estado}"> </a>      
                                                <a class="btn btn-default btn-sm glyphicon glyphicon-trash" title="{$lenguaje.tabla_opcion_cambiar_est}" href="{$_layoutParams.root}estandar/index/_eliminarUsuario/{$us.Usu_IdUsuario}"> </a>
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
                    
                    <script>
                        $("#cke_Iop_Tema").hide();
                    </script>