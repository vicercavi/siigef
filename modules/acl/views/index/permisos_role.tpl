<div  class="container-fluid" >
    <div class="row" style="padding-left: 1.3em; padding-bottom: 20px;">
        <h4 style="width: 80%;  margin: 0px auto; text-align: center;">{$lenguaje.permisos_label_titulo}</h4>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-key"></i>&nbsp;&nbsp;<strong>{$lenguaje.permisos_rol_titulo}</strong>                       
            </h3>
        </div>
        <div class="panel-body" style=" margin: 15px">
             <h4><i class="fa fa-user-secret"></i>&nbsp;&nbsp; <b>{$lenguaje.label_rol} :</b> {$role.Rol_role}</h4>
            <form name="form1" method="post" action="">
                <input type="hidden" name="guardar" value="1" />
               
                {if isset($permisos) && count($permisos)}
                <div class="table-responsive">
                <table class="table" style="  margin: 20px auto">
                        <tr>
                            <th>{$lenguaje.label_permiso}</th>
                            <th style="text-align:center">{$lenguaje.label_habilitado}</th>
                            <th style="text-align:center">{$lenguaje.label_denegado}</th>
                            <th style="text-align:center">{$lenguaje.label_ignorar}</th>
                        </tr>
                        {foreach item=pr from=$permisos}
                            <tr>
                                <td>{$pr.nombre}</td>
                                <td style="text-align:center">
                                    <input type="radio" name="perm_{$pr.id}" value="1" {if ($pr.valor == 1)}checked="checked"{/if}/></td>
                                    <td style="text-align:center"><input type="radio" name="perm_{$pr.id}" value="" {if ($pr.valor == "")}checked="checked"{/if}/></td>
                                    <td style="text-align:center"><input type="radio" name="perm_{$pr.id}" value="x" {if ($pr.valor === "x")}checked="checked"{/if}/>
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-success" type="submit" ><i class="glyphicon glyphicon-floppy-disk"> </i>&nbsp; {$lenguaje.button_ok}</button>
                    </div>
                </div>
                {else}
                    {$lenguaje.no_registros}
                {/if}
<!--                <input class="btn btn-primary" type="submit" value="Guardar" />-->
            </form> 
        </div>
    </div>
</div>