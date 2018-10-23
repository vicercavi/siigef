<?php if (isset($this->_tree)): ?>  
    <?php for ($i = 0; $i < count($this->_tree); $i++): ?> 
        <li class="dimli panel subitem"> 
            <?php if (empty($this->_tree[$i]["hijo"])): ?>  
                <input type="checkbox" id="cb_especie_{$key5}" name="parametro[]" value="<?php echo $this->_tree[$i]["Jeb_Nombre"]?>">                            
            <?php endif; ?>

                <label data-toggle="collapse" data-parent="<?php echo $this->_seleccionado?>" style="text-transform: uppercase;" href="#h<?php echo preg_replace('[\s+]', "", $this->_tree[$i]["Jeb_Nombre"]) . $this->_tree[$i]["Jeb_IdJerarquiaBiodiversidad"] . $i ?>" ><?php echo $this->_tree[$i]["Jeb_Nombre"] ?></label> 
            <?php if (!empty($this->_tree[$i]["hijo"])): ?>  
                <div id="h<?php echo preg_replace('[\s+]', "", $this->_tree[$i]["Jeb_Nombre"]) . $this->_tree[$i]["Jeb_IdJerarquiaBiodiversidad"] . $i ?>" class="panel-collapse collapse">                  
                    <ul id="<?php echo preg_replace('[\s+]', "", $this->_tree[$i]["Jeb_Nombre"]) . $this->_tree[$i]["Jeb_IdJerarquiaBiodiversidad"] . $i ?>" class="nav nav-list dimul dos_columnas ul_especie">
                        <?php
                        $arbol = new Arbol();
                        echo $arbol->enrraizar($this->_tree[$i]["hijo"], $this->_vista, $this->_link,("h".preg_replace('[\s+]', "", $this->_tree[$i]["Jeb_Nombre"]) . $this->_tree[$i]["Jeb_IdJerarquiaBiodiversidad"] . $i));
                        ?>    
                    </ul> 
                </div>
            <?php endif; ?>
        </li>
    <?php endfor; ?> 
<?php endif; ?>
