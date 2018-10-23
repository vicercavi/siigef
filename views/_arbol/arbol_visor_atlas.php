<?php if (isset($this->_tree)): ?>   
    <ul style="margin-top: 3px;padding-left:0" class="nav nav-list tree dimul dos_columnas">
        <?php for ($i = 0; $i < count($this->_tree); $i++): ?> 
            <li class="dimli">
            <li class="dimli subitem">
                <?php if (!empty($this->_tree[$i]["capas"])): ?>  
                    <input type="checkbox"  id="cb_layer<?php echo $this->_tree[$i]["capas"][0]["tic_Nombre"] . "_" .  $this->_tree[$i]['Jea_IdJerarquiaAtlas'].$i  ?>">
                    <input type="hidden" id="hd_layern_<?php echo  $this->_tree[$i]['Jea_IdJerarquiaAtlas'].$i ?>" value="<?php echo $this->_tree[$i]["capas"][0]["Cap_Nombre"] ?>">
                    <input type="hidden" id="hd_layer_<?php echo  $this->_tree[$i]['Jea_IdJerarquiaAtlas'].$i ?>" value="<?php echo $this->_tree[$i]["capas"][0]["Cap_UrlCapa"] ?>">
                    <input type="hidden" id="hd_layerb_<?php echo  $this->_tree[$i]['Jea_IdJerarquiaAtlas'].$i ?>" value="<?php echo $this->_tree[$i]["capas"][0]["Cap_UrlBase"] ?>">   
                <?php endif; ?>

                <label class="tree-toggler" ><?php echo $this->_tree[$i]['Jea_Nombre'] ?></label>     
                <?php if (!empty($this->_tree[$i]["capas"])): ?>  
                    <ul style="margin-top: 3px; padding-left:0" class="nav nav-list tree dimul dos_columnas">       
                        <section class="prop-menu">                                  
                            <input id="r_layer<?php echo $this->_tree[$i]["capas"][0]["tic_Nombre"] . "_" .  $this->_tree[$i]['Jea_IdJerarquiaAtlas'].$i ?>" type="range" value="100" />                                    
                            <!-- ESTE ES EL Moda-->
                            <div class="row col-md-12">
                                <spam title="Leyenda" class="glyphicon glyphicon-list mostraLeyenda" style="cursor: pointer">
                                    <div id="dato-leyenda" class="hidden">
                                        <div id="div_leyenda_<?php echo  $this->_tree[$i]['Jea_IdJerarquiaAtlas'].$i ?>" class=" panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    <span><?php echo $this->_tree[$i]['Jea_Nombre'] ?></span> 
                                                    <div class="pull-right closeleyenda" data-effect="fadeOut"><i class="fa fa-times"></i></div>
                                                </h3>
                                            </div>
                                            <div class="panel-body">
                                                <img src="<?php echo $this->_tree[$i]["capas"][0]["Cap_Leyenda"]?>">
                                            </div>

                                        </div>    
                                    </div>
                                </spam>                                     
                            </div>
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
                            <!--FIN DEL MODAL -->
                        </section    >  
                    </ul>
                <?php endif; ?>

                <?php if (!empty($this->_tree[$i]["hijo"])): ?>                    
                    <?php
                    $arbol = new Arbol();
                    echo $arbol->enrraizar($this->_tree[$i]["hijo"], $this->_vista, $this->_link, $this->_seleccionado);
                    ?>               
                <?php endif; ?>
            <?php endfor; ?>    
    </ul> 
<?php endif; ?>


