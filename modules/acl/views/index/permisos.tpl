<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 style="width: 80%;  margin: 0px auto; text-align: center;">{$lenguaje.permisos_label_titulo}</h4>
    </div>
    {if $_acl->permiso("editar_rol")}
        <div class="panel panel-default">
            <div class="panel-heading jsoftCollap">
                <h3 aria-expanded="false" data-toggle="collapse" href="#collapse3" class="panel-title collapsed"><i style="float:right"class="fa fa-ellipsis-v"></i><i class="fa fa-key"></i>&nbsp;&nbsp;<strong>{$lenguaje.permisos_nuevo_titulo}</strong></h3>
            </div>
            <div style="height: 0px;" aria-expanded="false" id="collapse3" class="panel-collapse collapse">
                <div class="panel-body" id="cont-form" style=" margin: 15px">
                    <form class="form-horizontal"  data-toggle="validator" id="form4" role="form" name="form4" action="" method="post">                    
                        <div class="form-group">
                            <label class="col-lg-2 control-label">{$lenguaje.label_permiso} (*): </label>
                            <div class="col-lg-10">
                                <input  class="form-control" type="text" name="permiso_" id="permiso_" placeholder="{$lenguaje.label_permiso}" required=""  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">{$lenguaje.label_clave} (*): </label>
                            <div class="col-lg-10">
                                <input  class="form-control" type="text" name="key_" id="key_" placeholder="{$lenguaje.label_clave}" required="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-success" type="submit" id="bt_guardarPermiso" name="bt_guardarPermiso" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
                            </div>
                        </div>                 
                    </form> 
                </div>
            </div>
        </div>
    {/if}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;
                <strong>{$lenguaje.permisos_buscar_titulo}</strong>                      
            </h3>
        </div>
        <div class="panel-body" style=" margin: 15px">
             <div class="row" style="text-align:right">
                <div style="display:inline-block;padding-right:2em">
                    <input class="form-control" placeholder="{$lenguaje.text_buscar_permisos}" style="width: 150px; float: left; margin: 0px 10px;" name="palabraPermiso" id="palabraPermiso">
                    <button class="btn btn-success" style=" float: left" type="button" id="buscarPermiso"  ><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
            <div id="listarPermisos">
                {if isset($permisos) && count($permisos)}
                <div class="table-responsive">
                    <table class="table" style="  margin: 20px auto">
                        <tr>
                            <th style=" text-align: center">{$lenguaje.label_n}</th>
                            <th >{$lenguaje.label_permiso} </th>
                            <th style=" text-align: center">{$lenguaje.label_clave}</th>
                            {if $_acl->permiso("editar_rol")}
                            <th style=" text-align: center">{$lenguaje.label_opciones}</th>
                            {/if}
                        </tr>
                        {foreach item=rl from=$permisos}
                            <tr>
                                <td style=" text-align: center">{$numeropagina++}</td>
                                <td>{$rl.Per_Permiso}</td>
                                <td style=" text-align: center">{$rl.Per_Ckey}</td>
                                {if $_acl->permiso("editar_rol")}
                                <td style=" text-align: center">
                                    <a data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm glyphicon glyphicon-trash" title="{$lenguaje.label_eliminar}" href="{$_layoutParams.root}acl/index/_eliminarPermiso/{$rl.Per_IdPermiso}"> </a>
                                </td>
                                {/if}
                            </tr>
                        {/foreach}
                    </table>
                </div>
                    {$paginacionPermisos|default:""}
                {else}
                    {$lenguaje.no_registros}
                {/if}                
            </div>
        </div>
    </div>
</div>