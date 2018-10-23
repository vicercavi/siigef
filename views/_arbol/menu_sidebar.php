<?php if (isset($this->_tree)): ?> 
    <?php for ($i = 0; $i < count($this->_tree); $i++): ?>             
        <li  <?php if (isset($this->_tree[$i]["hijo"]) && sizeof($this->_tree[$i]["hijo"]) > 0): ?>class="dropdown-submenu "<?php endif; ?>>
        <a href="<?php if($this->_tree[$i]['Pag_Selectable']==0):
            echo BASE_URL."index/index/".$this->_link.$this->_tree[$i]['Pag_IdPagina'];  
            else :
                echo $this->_link.$this->_tree[$i]['Pag_Url']; 
            endif; ?>" > 
            <?php echo $this->_tree[$i]['Pag_Nombre'] ?>
        </a>   

        <?php if (!empty($this->_tree[$i]["hijo"]) && sizeof($this->_tree[$i]["hijo"]) > 0):
            $arbol = new Arbol();?>
            <ul class="dropdown-menu" >
               <?php echo $arbol->enrraizar($this->_tree[$i]["hijo"], $this->_vista, $this->_link,$this->_seleccionado);?> 
            </ul>
        <?php endif; ?>

        </li>
        <?php if (isset($this->_tree[$i+1]["hijo"]) ):?>
        <li class="divider"></li>
        <?php endif; ?>        
    <?php endfor; ?>    
<?php endif; ?>