<div class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 class="titulo-view">{$lenguaje.riocuenca_label_titulo}</h4>
    </div>
    {if $_acl->permiso("agregar_riocuenca")}
        <div class="panel panel-default">
            <div class="panel-heading jsoftCollap">
                <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed"><i style="float:right"class="fa fa-ellipsis-v"></i><i class="fa fa-user-plus"></i>&nbsp;&nbsp;<strong>{$lenguaje.riocuencas_nuevo_titulo}</strong></h3>
            </div>
            <div style="height: 0px;" aria-expanded="false" id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id="nuevoRegistro">
                        <div style="width: 90%; margin: 0px auto">                        
                            <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                                <!--                            <input type="hidden" value="1" name="enviar" />-->                           
                                <div class="form-group" hidden="">
                                    <label class="col-lg-3 control-label">{$lenguaje.label_nombre_nuevo} : </label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id ="nombre" type="text"  name="nombre" value="" placeholder="{$lenguaje.label_nombre}"/>
                                    </div>
                                </div>
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_rio_nuevo} (*): </label>
                                    <div class="col-lg-8">
                                        {if  isset($rios) && count($rios)}
                                            <select class="form-control" id="selRio" name="selRio" required="">
                                                <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                {foreach from=$rios item=r}
                                                    <option value="{$r.Rio_IdRio}">{$r.Rio_Nombre}</option>    
                                                {/foreach}
                                            </select>
                                        {/if}
                                    </div>
                                </div>
                                <div id="lista_subcuenca_cuenca">
                                    <div class="form-group">                                 
                                        <label class="col-lg-3 control-label">{$lenguaje.label_subcuenca_nuevo} (*): </label>
                                        <div id="lista_subcuenca_rio">
                                            <div class="col-lg-8">
                                                {if  isset($subcuencas) && count($subcuencas)}
                                                    <select class="form-control" id="selSubcuenca" name="selSubcuenca" required="">
                                                        <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                        {foreach from=$subcuencas item=s}
                                                            <option value="{$s.Suc_IdSubcuenca}">{$s.Suc_Nombre}</option>    
                                                        {/foreach}
                                                    </select>
                                                {/if}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">                                 
                                        <label class="col-lg-3 control-label">{$lenguaje.label_cuenca_nuevo} (*): </label>
                                        <div id="lista_cuenca_subcuenca">
                                            <div class="col-lg-8">
                                                {if  isset($cuencas) && count($cuencas)}
                                                    <select class="form-control" id="selCuenca" name="selCuenca" required="">
                                                        <option value="">{$lenguaje.label_seleccion_nuevo}</option>
                                                        {foreach from=$cuencas item=c}
                                                            <option value="{$c.Cue_IdCuenca}">{$c.Cue_Nombre}</option>    
                                                        {/foreach}
                                                    </select>
                                                {/if}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">                                 
                                    <label class="col-lg-3 control-label">{$lenguaje.label_estado_nuevo} : </label>
                                    <div class="col-lg-8">
                                        <select class="form-control" id="selEstado" name="selEstado" >
                                            <option value="0">Inactivo</option>
                                            <option value="1">Activo</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-8">
                                        <button class="btn btn-success" id="bt_guardar" name="bt_guardar" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
                                    </div>
                                </div>
                            </form>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
    {/if}
    {if  isset($datos) && count($datos)}
        {if $_acl->permiso("editar_riocuenca")}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 aria-expanded="false" data-toggle="collapse" href="#collapse2" class="panel-title collapsed">
                        <i style="float:right" class="glyphicon glyphicon-option-vertical"></i>
                        <i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;
                        <strong>{$lenguaje.riocuencas_editar_titulo}</strong>
                    </h3>
                </div>
                <div style="height: 0px;" aria-expanded="false" id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div id="editarRegistro">
                            <div style="width: 90%; margin: 0px auto">                        
                                <form class="form-horizontal" id="form1" role="form" data-toggle="validator" method="post" action="" autocomplete="on">
                                    <!--                            <input type="hidden" value="1" name="enviar" />-->                           
                                    <div class="form-group" hidden="">
                                        <label class="col-lg-3 control-label">{$lenguaje.label_nombre_editar} : </label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id ="nombre" name="nombre" type="text" value="{$datos.Ric_Nombre}" placeholder="{$lenguaje.label_nombre}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">                                 
                                        <label class="col-lg-3 control-label">{$lenguaje.label_rio_editar} (*): </label>
                                        <div class="col-lg-8">
                                            {if  isset($rios) && count($rios)}
                                                <select class="form-control" id="selRio" name="selRio" required="">
                                                    <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                    {foreach from=$rios item=r}
                                                        <option value="{$r.Rio_IdRio}" {if $r.Rio_IdRio == $datos.Rio_IdRio}selected="selected"{/if}>{$r.Rio_Nombre}</option>    
                                                    {/foreach}
                                                </select>
                                            {/if}
                                        </div>
                                    </div>
                                    <div class="form-group">                                 
                                        <label class="col-lg-3 control-label">{$lenguaje.label_subcuenca_editar} (*): </label>
                                        <div class="col-lg-8">
                                            {if  isset($subcuencas) && count($subcuencas)}
                                                <select class="form-control" id="selSubcuenca" name="selSubcuenca" required="">
                                                    <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                    {foreach from=$subcuencas item=s}
                                                        <option value="{$s.Suc_IdSubcuenca}" {if $s.Suc_IdSubcuenca == $datos.Suc_IdSubcuenca}selected="selected"{/if}>{$s.Suc_Nombre}</option>    
                                                    {/foreach}
                                                </select>
                                            {/if}
                                        </div>
                                    </div>
                                    <div class="form-group">                                 
                                        <label class="col-lg-3 control-label">{$lenguaje.label_cuenca_editar} (*): </label>
                                        <div class="col-lg-8">
                                            {if  isset($cuencas) && count($cuencas)}
                                                <select class="form-control" id="selCuenca" name="selCuenca" required="">
                                                    <option value="">{$lenguaje.label_seleccion_editar}</option>
                                                    {foreach from=$cuencas item=c}
                                                        <option value="{$c.Cue_IdCuenca}" {if $c.Cue_IdCuenca == $datos.Cue_IdCuenca}selected="selected"{/if}>{$c.Cue_Nombre}</option>    
                                                    {/foreach}
                                                </select>
                                            {/if}
                                        </div>
                                    </div>
                                    <div class="form-group">                                 
                                        <label class="col-lg-3 control-label">{$lenguaje.label_estado_editar} : </label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="selEstado" name="selEstado">
                                                <option value="0" {if $datos.Ric_Estado == 0}selected="selected"{/if}>Inactivo</option>
                                                <option value="1" {if $datos.Ric_Estado == 1}selected="selected"{/if}>Activo</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-8">
                                            <button class="btn btn-success" id="bt_editar" name="bt_editar" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; Actualizar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>        
                        </div>
                    </div>
                </div>
            </div>            
        {/if}
    {/if}
    <div style=" margin: 15px auto">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;<strong>{$lenguaje.riocuencas_buscar_titulo}</strong>                       
                </h3>
            </div>
            <div class="panel-body">                          
                <div class="form-group ">
                    <div class="col-xs-3">
                        <input class="form-control" placeholder="{$lenguaje.text_buscar_riocuenca}"  name="palabra" id="palabra">                        
                    </div>                    
                    {if  isset($cuencas) && count($cuencas)}
                        <div class="col-xs-3">
                            <select class="form-control" id="buscarCuenca" name="buscarCuenca">
                                <option value="0">{$lenguaje.label_todos_cuencas}</option>
                                {foreach from=$cuencas item=c}
                                    <option value="{$c.Cue_IdCuenca}">{$c.Cue_Nombre}</option>    
                                {/foreach}
                            </select>                            
                        </div>                    
                        <div id="lista_subcuenca">
                            <div class="col-xs-3">
                                <select class="form-control" id="buscarSubcuenca" name="buscarSubcuenca">
                                    <option value="0">{$lenguaje.label_todos_subcuencas}</option>
                                    {if  isset($subcuencas) && count($subcuencas)}
                                        {foreach from=$subcuencas item=s}
                                        <option value="{$s.Suc_IdSubcuenca}">{$s.Suc_Nombre}</option>
                                        {/foreach}
                                    {/if}
                                </select>
                            </div>
                        </div>
                    {/if}                    
                    <button class=" btn btn-success" type="button" id="buscar"  ><i class="glyphicon glyphicon-search"></i></button>
                </div>
                <div style="margin: 15px 25px">
                    <h4 class="panel-title"> <b>{$lenguaje.riocuencas_buscar_tabla_titulo}</b></h4>
                    <div id="listaregistros">
                        {if isset($riocuencas) && count($riocuencas)}
                            <div class="table-responsive" >
                                <table class="table" style=" text-align: center">
                                    <tr >
                                        <th style=" text-align: center">{$lenguaje.label_n}</th>
                                        <th style=" text-align: center">{$lenguaje.label_rio}</th>
                                        <th style=" text-align: center">{$lenguaje.label_subcuenca}</th>
                                        <th style=" text-align: center">{$lenguaje.label_cuenca}</th>
                                        <th style=" text-align: center">{$lenguaje.label_estado}</th>
                                        <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                                    </tr>
                                    {foreach from=$riocuencas item=riocuenca}
                                        <tr>
                                            <td>{$numeropagina++}</td>
                                            <td>{$riocuenca.Rio_Nombre}</td>
                                            <td>{$riocuenca.Suc_Nombre}</td>
                                            <td>{$riocuenca.Cue_Nombre}</td>
                                            <td style=" text-align: center">
                                                {if $riocuenca.Ric_Estado==0}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-remove-sign " title="{$lenguaje.label_deshabilitado}" style="color: #DD4B39;"></p>
                                                {/if}                            
                                                {if $riocuenca.Ric_Estado==1}
                                                    <p data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-ok-sign " title="{$lenguaje.label_habilitado}" style="color: #088A08;"></p>
                                                {/if}
                                            </td>                                            
                                            <td >
                                                {if $_acl->permiso("editar_riocuenca")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default  btn-sm glyphicon glyphicon-pencil" title="{$lenguaje.label_editar}" href="{$_layoutParams.root}hidrogeo/riocuenca/index/{$riocuenca.Ric_IdRioCuenca}"></a>
                                                {/if}
                                                {if $_acl->permiso("habilitar_deshabilitar_riocuenca")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-refresh estado-riocuenca" title="{$lenguaje.label_cambiar_estado}" idriocuenca="{$riocuenca.Ric_IdRioCuenca}" estado="{if $riocuenca.Ric_Estado==0}1{else}0{/if}"> </a>      
                                                {/if}
                                                {if $_acl->permiso("eliminar_riocuenca")}
                                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash eliminar-riocuenca" title="{$lenguaje.label_eliminar}" idriocuenca="{$riocuenca.Ric_IdRioCuenca}"> </a>
                                                {/if}
                                            </td>                                            
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
</div>