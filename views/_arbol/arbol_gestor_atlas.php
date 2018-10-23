<?php if (isset($this->_tree)): ?> 
    <ul class="nav nav-list">
        <?php for ($i = 0; $i < count($this->_tree); $i++): ?> 
            <li  <?php if ($this->_tree[$i]['Jea_IdJerarquiaAtlas']==$this->_seleccionado): ?>class="active"<?php endif; ?>>

                <a href="<?php echo BASE_URL.$this->_link.$this->_tree[$i]['Jea_IdJerarquiaAtlas'] ?>"> <?php echo $this->_tree[$i]['Jea_Nombre'] ?></a></li>
            <?php
            if (!empty($this->_tree[$i]["hijo"])):
                $arbol = new Arbol();
                echo $arbol->enrraizar($this->_tree[$i]["hijo"], $this->_vista, $this->_link,$this->_seleccionado);
                ?> 
            <?php endif; ?>
    <?php endfor; ?>                    
    </ul>

<?php endif; ?>