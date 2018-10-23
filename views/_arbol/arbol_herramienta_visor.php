<?php if (isset($this->_tree)): ?>   
    <ul style="margin-top: 3px;padding-left:0" class="nav nav-list tree dimul dos_columnas ul_tabular">
        <?php foreach ($this->_tree as $key => $hijo): ?>
            <li class="dimli subitem">
                <?php if (!empty($hijo["recurso"]) && $hijo["recurso"][0]["Tir_IdTipoRecurso"] == 2): ?>  
                    <input type="checkbox"  id="cb_layer<?php echo $hijo["recurso"][0]["capas"][0]["tic_Nombre"] . "_" . $hijo['Esh_IdEstructuraHerramienta'] . $key ?>">
                    <input type="hidden" id="hd_layern_<?php echo $hijo['Esh_IdEstructuraHerramienta'] . $key ?>" value="<?php echo $hijo["recurso"][0]["capas"][0]["Cap_Nombre"] ?>">
                    <input type="hidden" id="hd_layer_<?php echo $hijo['Esh_IdEstructuraHerramienta'] . $key ?>" value="<?php echo $hijo["recurso"][0]["capas"][0]["Cap_UrlCapa"] ?>">
                    <input type="hidden" id="hd_layerb_<?php echo $hijo['Esh_IdEstructuraHerramienta'] . $key ?>" value="<?php echo $hijo["recurso"][0]["capas"][0]["Cap_UrlBase"] ?>">   
                    <?php
                elseif (!empty($hijo["recurso"]) && $hijo["recurso"][0]["Tir_IdTipoRecurso"] == 1):

                    if ($hijo["recurso"][0]["Esr_IdEstandarRecurso"] == 6):
                        $idrecurso = $hijo["recurso"][0]["Rec_IdRecurso"];
                        for ($index = 1; $index < count($hijo["recurso"]); $index++) {
                            $idrecurso = $idrecurso . "," . $hijo["recurso"][$index]["Rec_IdRecurso"];
                        }
                        ?>  
                        <input type="checkbox" id="cb_especie_<?php $hijo["Esh_IdEstructuraHerramienta"] ?>" recurso="<?php echo $idrecurso ?>" name="parametro[]" value="<?php echo $hijo["Esh_Descripcion"] ?>">                            

                        <?php
                    endif;
                endif;
                ?>
                <label class="tree-toggler" style="text-transform: uppercase;" ><?php echo $hijo['Esh_Nombre'] ?> <small><?php echo trim($hijo['Esh_Titulo']) ?></small></label> 
                <?php if (!empty($hijo["recurso"]) && $hijo["recurso"][0]["Tir_Nombre"] == "Mapa"): ?>  
                    <ul style="margin-top: 3px; padding-left:0" class="nav nav-list tree dimul dos_columnas">       
                        <section class="prop-menu">                                  
                            <input id="r_layer<?php echo $hijo["recurso"][0]["capas"][0]["tic_Nombre"] . "_" . $hijo['Esh_IdEstructuraHerramienta'] . $key ?>" type="range" value="100" />                                    
                            <!-- ESTE ES EL Moda-->
                            <div class="row col-md-12">
                                <a title="Leyenda" class="mostraLeyenda" style="cursor: pointer">Leyenda
                                    <div id="dato-leyenda" class="hidden">
                                        <div id="div_leyenda_<?php echo $hijo['Esh_IdEstructuraHerramienta'] . $key ?>" class=" panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    <span><?php echo $hijo['Esh_Nombre'] ?></span> 
                                                    <div class="pull-right closeleyenda" data-effect="fadeOut"><i class="fa fa-times"></i></div>
                                                </h3>
                                            </div>
                                            <div class="panel-body">
                                                <img src="<?php echo $hijo["recurso"][0]["capas"][0]["Cap_Leyenda"] ?>">
                                            </div>

                                        </div>    
                                    </div>
                                </a>  
                                <!--
                                <a href="#" class="" data-toggle="modal" data-target="#basicModal2">Ver detalle
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
                                </a>                         
                                -->
                            </div>
                            <br>

                            <!--FIN DEL MODAL -->
                        </section    >  
                    </ul>
                <?php endif; ?>
                <?php if (!empty($hijo["hijo"])): ?>                    
                    <?php
                    $arbol = new Arbol();
                    echo $arbol->enrraizar($hijo["hijo"], $this->_vista, $this->_link, $this->_seleccionado);
                else:
                    if (!empty($hijo["recurso"]) && $hijo["recurso"][0]["Esr_IdEstandarRecurso"] == 1):
                        ?>
                        <ul style="margin-top: 3px;padding-left:0" class="nav nav-list tree dimul dos_columnas ul_parametros">
                            <?php
                            $arbol = new Arbol();
                            echo $arbol->enrraizar($hijo["recurso"]["menu-ca"], "arbol_varibles_ca");
                            ?>
                        </ul>
                        <?php
                    endif;
                endif;
                ?>

            </li>
        <?php endforeach; ?>

    </ul> 
<?php endif; ?>


