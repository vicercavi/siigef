<style>
    body{
        background: #fff;
    }
    .container{
        padding: 0;
    }


</style> 


<div id="accordion" class="well span5" id="visorca">

    <h4 class="panel-title title-sidebar" style="width: 100%;text-align: center;font-weight: bold;">
        <a href="#" class="" data-toggle="modal" data-target="#basicModal3">VISOR DE CALIDAD DE AGUA </a> 
        <span class="glyphicon glyphicon-th-list" aria-hidden="true" style=" float: right;" data-toggle="collapse" data-parent="#accordion" href="#collapse0" aria-expanded="true" aria-controls="collapse0"></span>
    </h4>
    <div id="collapse0" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading0">                   
        <ul  class="dimul dos_columnas" style="padding-left: 10px;  padding-top: 10px;">  
            <li class="dimli"> 
                <input type="checkbox" id="cb_allpuntos">
                <label>Todos los puntos de Monitoreo</label>
            </li>
        </ul>
    </div>


    <!-- ESTE ES EL Modal-->
    <div class="modal fade basicModal" id="basicModal3" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&amp;times;</button>
                    <h4 class="modal-title" id="myModalLabel">VISOR DE CALIDAD DE AGUA</h4>
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

    <div id="contenido" class="scroll" style="overflow-y: auto; overflow-x: hidden; max-height: 400px;">
        <ul  class="nav nav-list">
            <li>
                <label class="tree-toggler nav-header" role="tab" id="heading1" >
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">VARIABLES DE ESTUDIO</h4></label>
                <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1">                   
                    <ul id="div_lita_variables"  class="nav nav-list tree dimul dos_columnas">                              
                        {if isset($variables) && count($variables)}
                            {foreach from=$variables key=key item=tipo name=i} 
                                <li class="dimli"> 
                                    <label class="tree-toggler" >{$tipo.Tiv_Nombre}</label>
                                    {if isset($tipo.params)}
                                        <ul style="margin-top: 3px;padding-left:0" class="nav nav-list tree dimul dos_columnas ul_parametros">
                                            {foreach from=$tipo.params key=key2 item=variable name=j} 
                                                <li class="dimli subitem">
                                                    <input type="checkbox" id="cb_parametros_{$smarty.foreach.j.index}" name="parametro[]" value="{$variable.Var_IdVariable}">                            
                                                    <label class="tree-toggler" >{$variable.Var_Nombre}</label>                           
                                                </li>
                                            {/foreach}
                                        </ul> 
                                    {/if}
                                </li>
                                <li class="divider"></li>    

                            {/foreach}


                        {else}

                            <p><strong>No hay registros!</strong></p>

                        {/if}
                    </ul> 

                </div>
            </li>
            <li class="divider"></li>
            <li>
                <label class="tree-toggler nav-header"  role="tab" id="heading2">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapse2">PAIS</h4></label>
                <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2" >
                    {if isset($pais)}
                        <ul id="ul_pais"  class="dimul dos_columnas" style="padding-left: 10px;  padding-top: 10px;">
                            {foreach from=$pais key=key item=item} 
                                <li class="dimli">
                                    <input type="checkbox" id="cb_pais_{$key}" value="{$item.Pai_IdPais}" >
                                    <label>{$item.Pai_Nombre}</label>
                                    <input type="hidden" id="hd_pais_{$key}" value="{$item.Pai_IdPais}" >                   
                                </li>
                            {/foreach}
                        </ul>
                    {/if}                   
                </div>
            </li>
            <li class="divider"></li>
            <li>
                <label class="tree-toggler nav-header" role="tab" id="heading3">
                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3">TEMÁTICAS</h4>
                </label> 
                <div id="collapse3" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading3" >
                    <ul  class="nav nav-list tree dimul dos_columnas">                              
                        <li class="dimli"> 
                            <label class="tree-toggler">Cuenca del Amazonas</label>
                            <ul style="margin-top: 3px;padding-left:0" class="nav nav-list tree dimul dos_columnas">

                                <li class="dimli subitem">
                                    <input type="checkbox" id="cb_layerWMS_-1">
                                    <label class="tree-toggler">Limite Amazonía</label>
                                    <input type="hidden" id="hd_layern_-1" value="0">
                                    <input type="hidden" id="hd_layer_-1" value="">
                                    <input type="hidden" id="hd_layerb_-1" value="http://200.60.174.200/ArcGIS/services/CONTINENTAL/limites_amazonia/MapServer/WMSServer?">
                                    <ul style="margin-top: 3px; padding-left:0" class="nav nav-list tree dimul dos_columnas">       
                                        <section class="prop-menu">                                  
                                            <input id="r_layerWMS_-1" type="range" value="100">                                    
                                            <!-- MOdal
                                             <br>
                                             <a href="#" class="" data-toggle="modal" data-target="#basicModal2">Ver detalle</a>
 
                                          
                                             <div class="modal fade basicModal" id="basicModal2" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                                 <div class="modal-dialog">
                                                     <div class="modal-content">
                                                         <div class="modal-header">
                                                             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&amp;times;</button>
                                                             <h4 class="modal-title" id="myModalLabel">Modal title 2</h4>
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
                                           FIN DEL MODAL -->

                                        </section>  
                                    </ul>
                                </li>
                            </ul> 
                        </li>
                        <div id="div_lita_tematica">

                        </div>
                    </ul>      
                </div>
                <!--     <ul class="nav nav-list tree">-->

            </li>
        </ul>

    </div>
</div>


</div>
<div style="display: inline-block;vertical-align: top;min-width:75%; width: 100%;heigth:300px">    
    <div id='map' class="map" > <div id='gmap' class="fill" ></div>  <div id="olmap" class="fill"></div></div>
</div>
