<form  method="post" enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="row">
            <h3 class="titulo-view">Estructura Herramienta {$herramienta.Her_Nombre} </h3> 
            <input type="hidden" id="hd_id_herramienta" name="hd_id_herramienta" value="{$idherramienta}">                                            
            <input type="hidden" id="hd_id_padre_estructura" name="hd_id_padre_estructura" value="{$idpadre}">                                            
            {if isset($padreestructura)}
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading jsoftCollap">
                            <h3 data-toggle="collapse"  href="#collapse1" class="panel-title">
                                <i style="float:right"class="fa fa-ellipsis-v">                            
                                </i>
                                <i class="fa fa-pencil">                            
                                </i>&nbsp;&nbsp;
                                <strong>Contenido Estructura</strong>
                            </h3>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in" >
                            <div class="panel-body">
                                <div class="col-md-5 form-horizontal">
                                    <div class="form-group" >
                                        <input type="hidden" id="hd_idioma_defecto" name="hd_idioma_defecto" value="{$padreestructura.Idi_IdIdioma|default}">
                                        <label class="control-label col-lg-3">Idioma</label>
                                        {if  isset($idiomas) && count($idiomas)}                
                                            <div class="col-lg-9 form-inline">
                                                {foreach from=$idiomas item=idi}                                                                                    
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="rb_idioma_padre" id="rb_idioma_padre" class=" {if isset($padreestructura)}idioma-estructurah{/if}" value="{$idi.Idi_IdIdioma}" 
                                                                   {if $padreestructura.Idi_IdIdioma==$idi.Idi_IdIdioma} 
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
                                    <div id="index_nueva_estructura">
                                        <div class="form-group ">
                                            <label class="col-lg-3 control-label"  for="tb_nombre_edit">Nombre*</label>
                                            <div class="col-lg-9">

                                                <input type="text" class="form-control" id="tb_nombre_edit"  name="tb_nombre_edit" value="{$padreestructura.Esh_Nombre}"
                                                       placeholder="Introduce nombre de la estructura">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label"  for="tb_titulo_edit">Cabecera</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control " id="tb_titulo_edit"  name="tb_titulo_edit" value="{$padreestructura.Esh_Titulo}">  
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label"  for="tb_orden_edit">Orden*</label>
                                            <div class="col-lg-9">
                                                <input type="number" class="form-control " id="tb_orden_edit"  name="tb_orden_edit" value="{$padreestructura.Esh_Orden}">  
                                            </div>

                                        </div> 
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label"  for="tb_descripcion_edit">Criterio Consulta*</label>
                                            <div class="col-lg-9">
                                                <input type="te" class="form-control" id="tb_descripcion_edit"  name="tb_descripcion_edit" value="{$padreestructura.Esh_Descripcion}"
                                                       placeholder="Introduce descripcion de la estructura">
                                            </div>
                                        </div>   
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label"  for="tb_columna_edit">Columna de Consulta</label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" id="tb_columna_edit"  name="tb_columna_edit"
                                                       placeholder="Introduce columna a consultar" value="{$padreestructura.Esh_ColumnaConsulta}">
                                            </div>
                                        </div>   
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label"  for="cb_he_predeterminado"></label>
                                            <div class="col-lg-9">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="cb_he_predeterminado" id="cb_he_predeterminado"  
                                                               {if !empty($padreestructura.Esh_Predeterminado)} 
                                                                   checked="checked"  
                                                               {/if} 
                                                               >
                                                        Mostrar al Cargar Herramienta
                                                    </label>
                                                </div>

                                            </div>
                                        </div> 
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-9">                                              
                                            <button type="submit"  class="btn btn-success" id="bt_actualizar" name="bt_actualizar"<i class="glyphicon glyphicon-floppy-disk"> </i>Actualizar</button>
                                            <a class="btn btn-danger" href="{$_layoutParams.root}herramienta/estructura/{$herramienta.Her_IdHerramientaSii}/{$padreestructura.Esh_IdPadre|default}"><i class="glyphicon glyphicon-remove-sign"> </i> Cancelar</a>
                                            <input type="hidden" id="hd_tipo_recurso" name="hd_tipo_recurso" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div id='estructura_gestor_recurso' class="col-md-7">
                                    <div class="form-group col-md-12">                         
                                        <label for="sl_estandar_recurso" class=" row col-lg-2 control-label">Estandar de Recurso</label>                               
                                        <div class="col-lg-4">
                                            <select id="sl_estandar_recurso" class="form-control" {if isset($er_asignado)} disabled {/if}>
                                                <option value="0">Seleccione..</option>   
                                                {if isset($estandar_recurso) && count($estandar_recurso)}
                                                    {foreach from=$estandar_recurso item=dato}
                                                        <option value="{$dato.Esr_IdEstandarRecurso}" {if isset($er_asignado)&& $er_asignado==$dato.Esr_IdEstandarRecurso} selected {/if}>{$dato.Esr_Nombre}</option>       
                                                    {/foreach}
                                                {/if}
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="form-group recurso_gestor">                         
                                        <div class="col-md-6">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <strong>Disponibles</strong>                                      
                                                </div>     
                                                <div class="panel-body">
                                                    <div class="input-group col-xs-12 ">
                                                        <input id="tb_buscar_rd_filter" type="text" class="form-control"  placeholder="Buscar Recursos Disponibles" value="{$buscar|default}" />                     
                                                        <span class="input-group-btn">
                                                            <button id="bt_buscar_rd_filter" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div id="estructura_lista_recursos_disponibles" class="form-inline">
                                                    {if isset($recurso_disponible) && count($recurso_disponible)}
                                                        <div class="table-responsive" >
                                                            <table class="table">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Nombre</th>    
                                                                    <th>Estandar</th>                                                             
                                                                    <th class="text-center">Opciones</th>
                                                                </tr>
                                                                {foreach from=$recurso_disponible item=dato}
                                                                    <tr>
                                                                        <td>{$numeropagina_rd++}</td>
                                                                        <td>{$dato.Rec_Nombre}</td>                                                            
                                                                        <td>{$dato.Esr_Nombre}</td>                                                            
                                                                        <td style=" text-align: center">
                                                                            <a type="button" title="Asignar" recurso='{$dato.Rec_IdRecurso}' estructura='{$padreestructura.Esh_IdEstructuraHerramienta}' class="btn btn-default btn-sm glyphicon glyphicon-chevron-right asignar_recurso">
                                                                            </a> 
                                                                        </td>

                                                                    </tr>

                                                                {/foreach}

                                                            </table>

                                                        </div>
                                                        {$paginacion_rd|default:""}
                                                    {else}
                                                        Seleccione Estandar de Recurso
                                                    {/if}

                                                </div>


                                            </div>
                                        </div>               
                                        <div class="col-md-6">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <strong>Asignados</strong>                                         
                                                </div>   
                                                <div class="panel-body">
                                                    <div class="input-group col-xs-12 ">
                                                        <input id="tb_buscar_ra_filter" type="text" class="form-control"  placeholder="Buscar Recursos Asignados" value="{$buscar|default}" />                     
                                                        <span class="input-group-btn">
                                                            <button id="bt_buscar_ra_filter" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div id="estructura_lista_recursos_asignados" class="form-inline">
                                                    {if isset($recurso_asignado) && count($recurso_asignado)}
                                                        <div class="table-responsive" >
                                                            <table class="table">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Nombre</th>    
                                                                    <th>Estandar</th>                                                             
                                                                    <th class="text-center">Opciones</th>
                                                                </tr>
                                                                {foreach from=$recurso_asignado item=dato}
                                                                    <tr>
                                                                        <td>{$numeropagina_ra++}</td>
                                                                        <td>{$dato.Rec_Nombre}</td>                                                               
                                                                        <td>{$dato.Esr_Nombre}</td>                                                            
                                                                        <td style=" text-align: center">   
                                                                            <a type="button" title="Quitar" recurso='{$dato.Rec_IdRecurso}' estructura='{$padreestructura.Esh_IdEstructuraHerramienta}' class="btn btn-default btn-sm glyphicon glyphicon-remove quitar_recurso" >
                                                                            </a>

                                                                        </td>
                                                                    </tr>

                                                                {/foreach}

                                                            </table>

                                                        </div>
                                                        {$paginacion_ra|default:""}
                                                    {else}
                                                        Sin Datos...
                                                    {/if}

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}          
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading jsoftCollap">
                        <h3 data-toggle="collapse"  href="#collapse2" class="panel-title">
                            <i style="float:right"class="fa fa-ellipsis-v">                            
                            </i>
                            <i class="fa fa-bars fa-plus">                            
                            </i>&nbsp;&nbsp;
                            <strong>Agregar Estructura</strong></h3>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse" >
                        <div class="panel-body">
                            <div class="with-nav-tabs panel-default">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab1default" data-toggle="tab">Individual</a></li>
                                    <li><a href="#tab2default" data-toggle="tab">Desde Excel</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active form-horizontal" id="tab1default">
                                        <br>
                                        <div class="col-md-7 ">
                                            <div class="form-group" >                                                   
                                                <label class="control-label col-lg-3">Idioma</label>
                                                {if  isset($idiomas) && count($idiomas)}                
                                                    <div class="col-lg-9 form-inline">
                                                        {foreach from=$idiomas item=idi}                                                                                    
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="rb_idioma" id="rb_idioma"  value="{$idi.Idi_IdIdioma}" 
                                                                           {if isset($padreestructura)}
                                                                               disabled
                                                                           {/if}

                                                                           {if isset($padreestructura) && $padreestructura.Idi_IdIdioma==$idi.Idi_IdIdioma} 
                                                                               checked="checked"                                                                                    
                                                                           {elseif !isset($padreestructura) && isset($idioma) && $idioma==$idi.Idi_IdIdioma} 
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
                                            <div class="form-group">
                                                <label  class="col-lg-3 control-label" for="tb_nombre">Nombre*</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" id="tb_nombre"  name="tb_nombre"
                                                           placeholder="Introduce nombre de la estructura">
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label  class="col-lg-3 control-label" for="tb_titulo">Cabecera</label>
                                                <div class="col-lg-9"> 
                                                    <input type="text" class="form-control " id="tb_titulo"  name="tb_titulo">  
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label   class="col-lg-3 control-label"  for="tb_orden">Orden*</label>
                                                <div class="col-lg-2">  
                                                    <input type="number" class="form-control " id="tb_orden"  name="tb_orden" >  
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label  class="col-lg-3 control-label" for="tb_descripcion">Descripcion*</label>
                                                <div class="col-lg-9">                                                 
                                                    <textarea type="te" class="form-control" id="tb_descripcion"  name="tb_descripcion"
                                                              placeholder="Introduce descripcion de la estructura"></textarea>
                                                </div>
                                            </div>   
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label"  for="tb_columna">Columna de Consulta</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" id="tb_columna"  name="tb_columna"
                                                           placeholder="Introduce columna a consultar">
                                                </div>
                                            </div>   
                                            <div class="form-group">
                                                <div class="col-lg-offset-3 col-lg-9">
                                                    <button type="submit"  class="btn btn-success" id="bt_registrar" name="bt_registrar" ><i class="glyphicon glyphicon-floppy-disk"> </i>Registrar</button>
                                                    <input type="hidden" id="hd_tipo_recurso" name="hd_tipo_recurso" value="1">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2default"> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fl_excel">Menu desde Excel</label>
                                                <input type="file" name="fl_excel" id='fl_excel' />

                                            </div>
                                            <button type="submit" id="bt_procesar" name="bt_procesar"  class="btn btn-success ">Procesar</button>       
                                        </div>
                                        <div class="col-md-4">
                                            <a href="{$_layoutParams.root}public/files/ejemplo_estructura_herramienta.xlsx">Ejemplo del menu desde Excel</a>
                                        </div>
                                    </div>

                                </div>

                            </div>


                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="glyphicon glyphicon-list-alt"></i>
                            <strong>Lista de Estructuras </strong>                       
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12 pull-right form-inline text-right">
                            <div class="input-group">
                                <input id="tb_buscar_filter" type="text" class="form-control"  placeholder="Buscar en estructura de Herramienta" value="{$buscar|default}" />                     
                                <span class="input-group-btn">
                                    <button id="bt_buscar_estructura_filter" class="btn btn-success" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div>
                        </div>            
                    </div>
                    <div id="estructura_lista_estructura" class="form-inline">

                        {if isset($estructura) && count($estructura)}
                            <div class="table-responsive" >
                                <table class="table">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>    
                                        <th>Titulo</th>  
                                        <th>Descripción</th>     
                                        <th>Orden</th>  
                                        <th>Estado</th> 
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                    {foreach from=$estructura item=dato}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$dato.Esh_Nombre}</td>
                                            <td>{$dato.Esh_Titulo}</td>
                                            <td>{$dato.Esh_Descripcion}</td>  
                                            <td>{$dato.Esh_Orden}</td>  
                                            <td>
                                                {if $dato.Esh_Estado==0}
                                                    <i class="glyphicon glyphicon-remove-sign" title="Desabilitado" style="color: #DD4B39;"/>
                                                {else}
                                                    <i class="glyphicon glyphicon-ok-sign" title="Habilitado" style="color: #088A08;"/>
                                                {/if}
                                            </td>  
                                            <td style=" text-align: center">
                                                <a type="button" title="Editar" class="btn btn-default btn-sm glyphicon glyphicon-pencil" href="{$_layoutParams.root}herramienta/estructura/{$herramienta.Her_IdHerramientaSii}/{$dato.Esh_IdEstructuraHerramienta}">
                                                </a>
                                                <a class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-estructura" estructura="{$dato.Esh_IdEstructuraHerramienta}" estado="{if $dato.Esh_Estado==0}1{else}0{/if}"  title="Cambiar Estado" ></a>

                                                <a data-toggle="modal" data-target="#confirm-delete" href="#" type="button" title="Eliminar" data-her='{$herramienta.Her_IdHerramientaSii}' data-pad='{$dato.Esh_IdPadre|default}' data-est='{$dato.Esh_IdEstructuraHerramienta}' data-nombre="{$dato.Esh_Nombre}" class="btn btn-default btn-sm glyphicon glyphicon-remove" >
                                                </a>
                                            </td>

                                        </tr>

                                    {/foreach}

                                </table>

                            </div>
                            {$paginacion|default:""}
                        {else}
                            Sin registros.
                        {/if}

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmación de Eliminación</h4>
            </div>

            <div class="modal-body">
                <p>Estás a punto de borrar un item que pueda que tenga elementos, este procedimiento es irreversible</p>
                <p>¿Deseas Continuar?</p>
                <p>Eliminar: <strong class="nombre-es"></strong></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a style="cursor:pointer" her="" pad="" est="" data-dismiss="modal" class="btn btn-danger danger deletee">Eliminar</a>
            </div>
        </div>
    </div>
</div>
