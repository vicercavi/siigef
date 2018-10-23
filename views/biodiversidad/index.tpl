<style>
    body{
        background: #fff;
    }
    .container{
        padding: 0;
    }


</style> 

<div class="well visorbio">
    <h4 class="panel-title title-sidebar" style="width: 100%;text-align: center;font-weight: bold;">
        <a href="#" class="" data-toggle="modal" data-target="#basicModal3">VISOR DE BIODIVERSIDAD AMAZÓNICA</a> 
        <!--span class="glyphicon glyphicon-th-list" aria-hidden="true" style=" float: right;" data-toggle="collapse" data-parent="#accordion" href="#collapse0" aria-expanded="true" aria-controls="collapse0"></span-->
    </h4>
    <!-- ESTE ES EL Modal-->
    <div class="modal fade basicModal" id="basicModal3" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&amp;times;</button>
                    <h4 class="modal-title" id="myModalLabel">VISOR DE BIODIVERSIDAD AMAZÓNICA</h4>
                </div>
                <div class="modal-body">
                    <h3>Modal Body</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!--FIN DEL MODAL -->

    <div id="contenido" class="scroll visorbio" style="overflow-y: auto; overflow-x: hidden; max-height: 400px;">
        <ul id="reino" class="nav nav-list tree dimul dos_columnas">
            {$arbolbiodiversidad|default:"No existe datos"}
           
        </ul>
        <ul class="nav nav-list">           
            <li>
                <label class="tree-toggler nav-header" role="tab" id="heading3">
                    <h4 class="panel-title">
                        <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>     <a href="#" data-toggle="modal" data-target="#basicModal4">Lista de Recursos</a>
                    </h4>
                </label> 
                <!-- ESTE ES EL Modal-->
                <div class="modal fade basicModal" id="basicModal4" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                                <h4 class="modal-title" id="myModalLabel">LISTA DE RECURSOS</h4>
                            </div>
                            <div id="visor_lista_recursos" class="modal-body">
                                {if isset($recursos)}
                                    <table class="table table-hover table-condensed" >
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>                   
                                            <th>Tipo</th>
                                            <th>Estándar</th>
                                            <th>Fuente</th>
                                            <th>Origen</th> 
                                            <th>Registros</th>

                                        </tr>
                                        {$item=1}
                                        {foreach item=datos from=$recursos}

                                            <tr>                       
                                                <td>{$numeropagina++}</td>
                                                <td>{$datos.Rec_Nombre}</td>
                                                <td>{$datos.Tir_Nombre}</td>
                                                <td>{$datos.Esr_Nombre}</td>
                                                <td>{$datos.Rec_Fuente}</td>
                                                <td>{$datos.Rec_Origen}</td>  
                                                <td>{$datos.Rec_CantidadRegistros}</td>  
                                            </tr>                     
                                        {/foreach}
                                    </table>
                                    {$paginacion|default:""}   
                                {/if}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>  
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN DEL MODAL -->
            </li>
        </ul>

    </div>
</div>


</div>
<div style="display: inline-block;vertical-align: top;min-width:75%; width: 100%;heigth:300px">    
    <div id='map' class="map" > <div id='gmap' class="fill" ></div>  <div id="olmap" class="fill"></div></div>
</div>
