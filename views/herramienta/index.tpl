<form  method="post">
    <div  class="container-fluid">
        <div class="row">
            <h3 class="titulo-view">Herramienta SII</h3>
            {if $_acl->permiso("agregar_herramienta")}
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading jsoftCollap">
                            <h3 data-toggle="collapse"  href="#collapse1" class="panel-title">
                                <i style="float:right"class="fa fa-ellipsis-v">                            
                                </i>
                                <i class="fa fa-plug fa-plus">                            
                                </i>&nbsp;&nbsp;
                                <strong>{if isset($herramienta)}Editar Herramienta{else}Registro de Herramienta{/if}</strong>
                            </h3>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse {if isset($herramienta)}in{/if}" >
                            <div class="panel-body form-horizontal">
                                <div class="col-md-7">
                                    <div class="form-group" >
                                        <input type="hidden" id="hd_idioma_defecto" name="hd_idioma_defecto" value="{$herramienta.Idi_IdIdioma|default}">
                                        <label class="control-label col-lg-3">Idioma</label>
                                        {if  isset($idiomas) && count($idiomas)}                
                                            <div class="col-lg-9 form-inline">
                                                {foreach from=$idiomas item=idi}                                                                                    
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="rb_idioma" id="rb_idioma" class=" {if isset($herramienta)}idioma-herramienta{/if}" value="{$idi.Idi_IdIdioma}" 
                                                                   {if isset($herramienta) && $herramienta.Idi_IdIdioma==$idi.Idi_IdIdioma} 
                                                                       checked="checked" 
                                                                   {elseif !isset($herramienta) && isset($idioma) && $idioma==$idi.Idi_IdIdioma} 
                                                                       checked="checked"  
                                                                   {/if} 
                                                                   required>
                                                            {$idi.Idi_Idioma}
                                                        </label>                                        
                                                    </div>  
                                                {/foreach}
                                            </div>          
                                        {else} 
                                            <div class="form-inline col-lg-9">
                                                <label class="control-label">No existe idiomas en la Basse de Datos </label>
                                            </div>
                                        {/if}
                                    </div>
                                    <div id="index_nueva_herramienta">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label"  for="tb_nombre">Nombre*</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" id="tb_nombre"  name="tb_nombre" value="{$herramienta.Her_Nombre|default}"
                                                       placeholder="Introduce nombre de la herramienta">
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label"  for="tb_abreviatura">Abreviatura*</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" id="tb_abreviatura"  name="tb_abreviatura"
                                                       placeholder="Introduce un identificar sin espacios, ejemplo atlasvh" value="{$herramienta.Her_Abreviatura|default}">
                                            </div>
                                        </div>    
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label"  for="tb_descripcion">Descripcion*</label>
                                            <div class="col-lg-9">
                                                <textarea type="te" class="form-control" id="tb_descripcion"  name="tb_descripcion"
                                                          placeholder="Introduce descripcion de la herramienta">{$herramienta.Her_Descripcion|default}</textarea>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-9">
                                            {if isset($herramienta)} 
                                                <button type="submit"  class="btn btn-success" id="bt_registrar" name="bt_registrar"><i class="glyphicon glyphicon-floppy-disk"> </i>Actualizar</button>
                                                <a class="btn btn-danger" href="{$_layoutParams.root}herramienta"><i class="glyphicon glyphicon-remove-sign"> </i> Cancelar</a>
                                            {else}
                                                <button type="submit"  class="btn btn-success" id="bt_registrar" name="bt_registrar"><i class="glyphicon glyphicon-floppy-disk"> </i>Registrar</button>
                                            {/if}
                                        </div>
                                        <input type="hidden" id="hd_herramienta" value="{$herramienta.Her_IdHerramientaSii|default}">
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            {/if}
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <h3 class="panel-title">
                            <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;
                            <strong>Lista de Herramientas</strong>                       
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12 pull-right form-inline text-right">
                            <div class="input-group">
                                <input id="tb_buscar_filter" type="text" class="form-control"  placeholder="Buscar Herramienta" value="{$buscar|default}" />
                                <span class="input-group-btn">
                                    <button id="bt_buscar_filter" class="btn btn-success" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div id="index_lista_herramienta">
                        {if isset($herramientas) && count($herramientas)}
                            <div class="table-responsive" >
                                <table class="table">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th> 
                                        <th>Abreviatura</th>        
                                        <th>Descripción</th>    
                                        <th>Estado</th>    
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                    {foreach from=$herramientas item=dato}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$dato.Her_Nombre}</td>
                                            <td>{$dato.Her_Abreviatura}</td>
                                            <td class="text-justify" >{$dato.Her_Descripcion}</td>   
                                            <td>
                                                {if $dato.Her_Estado==0}
                                                    <i class="glyphicon glyphicon-remove-sign" title="Desabilitado" style="color: #DD4B39;"/>
                                                {else}
                                                    <i class="glyphicon glyphicon-ok-sign" title="Habilitado" style="color: #088A08;"/>
                                                {/if}
                                            </td>   
                                            <td style=" text-align: center">
                                                {if $_acl->permiso("editar_herramienta")}
                                                    <a type="button" title="Editar" class="btn btn-default btn-sm glyphicon glyphicon-pencil" href="{$_layoutParams.root}herramienta/index/{$dato.Her_IdHerramientaSii}">
                                                    </a>
                                                {/if}
                                                {if $_acl->permiso("habilitar_deshabilitar_herramienta")}
                                                    <a class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-herramienta" herramienta="{$dato.Her_IdHerramientaSii}" estado="{if $dato.Her_Estado==0}1{else}0{/if}"  title="Cambiar Estado" > </a>
                                                {/if}
                                                {if $_acl->permiso("editar_estructura_herramienta")}
                                                    <a type="button" title="Ver Estructura" class="btn btn-default btn-sm glyphicon glyphicon-list" href="{$_layoutParams.root}herramienta/estructura/{$dato.Her_IdHerramientaSii}">
                                                    </a>
                                                {/if}
                                                <a type="button" title="Ir a visor" class="btn btn-default btn-sm glyphicon glyphicon-eye-open" href="{$_layoutParams.root}herramienta/visor/{$dato.Her_Abreviatura}" target="_blank">
                                                </a>

                                            </td>

                                        </tr>

                                    {/foreach}

                                </table>

                            </div>
                            {$paginacion|default:""}
                        {else}
                            Sin Resultados...
                        {/if}

                    </div>
                </div>
            </div>        

        </div>
    </div>
</form>