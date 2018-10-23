<?php if (isset($this->_tree)): ?> 
    <?php foreach ($this->_tree as $hijo): ?> 
        <li class="dimli subitem"> 
            <?php if (empty($hijo["params"])): ?> 
                <input type="checkbox" id="cb_parametros_<?php echo $hijo["Var_IdVariable"] ?>" name="parametro[]" value="<?php echo $hijo["Var_IdVariable"] ?>">                            
            <?php endif; ?>
            <label class="tree-toggler" style="text-transform: uppercase;" ><?php echo ((!isset($hijo['Tiv_Nombre'])) ? "" : $hijo['Tiv_Nombre']) . ((!isset($hijo['Var_Nombre'])) ? "" : $hijo['Var_Nombre']) ?></label> 
            <?php if (!empty($hijo["params"])): ?>  
                <ul style="margin-top: 3px;padding-left:0" class="nav nav-list tree dimul dos_columnas">
                    <?php
                    $arbol = new Arbol();
                    echo $arbol->enrraizar($hijo["params"], $this->_vista, $this->_link, $this->_seleccionado);
                    ?>    
                </ul> 
            <?php endif; ?>
        </li>
    <?php endforeach; ?>     
<?php endif; ?>
