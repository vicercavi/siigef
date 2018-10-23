{if isset($tematicas) && count($tematicas)}

    {foreach from=$tematicas key=key item=jerarquia name=i} 
        <li class="dimli"> 
            <label class="tree-toggler" >{$jerarquia.Jem_Nombre}</label>
            {if isset($jerarquia.capas)}
                <ul style="margin-top: 3px;padding-left:0" class="nav nav-list tree dimul dos_columnas">
                    {foreach from=$jerarquia.capas key=key2 item=capa name=j} 
                        <li class="dimli subitem">
                            <input type="checkbox"  id="cb_layer{$capa.tic_Nombre}_{$smarty.foreach.i.index}{$smarty.foreach.j.index}">
                            <label class="tree-toggler" >{$capa.Cap_Titulo}</label>
                            <input type="hidden" id="hd_layern_{$smarty.foreach.i.index}{$smarty.foreach.j.index}" value="{$capa.Cap_Nombre}">
                            <input type="hidden" id="hd_layer_{$smarty.foreach.i.index}{$smarty.foreach.j.index}" value="{$capa.Cap_UrlCapa}">
                            <input type="hidden" id="hd_layerb_{$smarty.foreach.i.index}{$smarty.foreach.j.index}" value="{$capa.Cap_UrlBase}">
                            <ul style="margin-top: 3px; padding-left:0" class="nav nav-list tree dimul dos_columnas">       
                                <section class="prop-menu">
                                    <input id="r_layer{$capa.tic_Nombre}_{$smarty.foreach.i.index}{$smarty.foreach.j.index}" type="range" value="100" />
                                    <div class="row col-md-12">
                                          <a title="Leyenda" class="mostraLeyenda" style="cursor: pointer">Leyenda
                                            <div id="dato-leyenda" class="hidden">
                                                <div id="div_leyenda_{$smarty.foreach.i.index}{$smarty.foreach.j.index}" class=" panel panel-default">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">
                                                            <span>{$capa.Cap_Titulo}</span> 
                                                            <div class="pull-right closeleyenda" data-effect="fadeOut"><i class="fa fa-times"></i></div>
                                                        </h3>
                                                    </div>
                                                    <div class="panel-body">
                                                        <img src="{$capa.Cap_Leyenda}">
                                                    </div>

                                                </div>    
                                            </div>
                                        </a>                                     
                                    </div>
                                    <!-- ESTE ES EL Moda
                                   <br/>
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
                                    <!--FIN DEL MODAL -->
                                </section    >  
                            </ul>
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
