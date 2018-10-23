<?php if (isset($this->_tree)): ?>     
    <?php for ($i = 0; $i < count($this->_tree); $i++): ?> 

        <li  <?php if (isset($this->_tree[$i]["hijo"]) && sizeof($this->_tree[$i]["hijo"]) > 0): ?>class="dropdown-submenu "<?php endif; ?>>
               
            <a href=" <?php if($this->_tree[$i]['Pag_Selectable']==0):
                            echo BASE_URL."index/index/".$this->_link.$this->_tree[$i]['Pag_IdPagina'];  
                            else : echo $this->_link.$this->_tree[$i]['Pag_Url']; endif;?>"
                            data-toggle="tooltip" data-placement="bottom" 
                            
                            title="<?php echo $this->_tree[$i]['Pag_Nombre'] ?>"> 
                            <i style="font-size:15px" <?php if($this->_tree[$i]['Pag_IdPagina']==45): ?>
                            class="fa fa-info-circle" 
                            <?php endif;?>
                            <?php if($this->_tree[$i]['Pag_IdPagina']==46): ?>
                            class="fa fa-envelope" 
                            <?php endif;?>
                            <?php if($this->_tree[$i]['Pag_IdPagina']==44): ?>
                            class="fa fa-home" 
                            <?php endif;?> ></i>
                            <?php echo $this->_tree[$i]['Pag_Nombre'] ?>
                        </a>   
            
        <?php
        if (!empty($this->_tree[$i]["hijo"]) && sizeof($this->_tree[$i]["hijo"]) > 0):
            $arbol = new Arbol();?>
        <ul class="dropdown-menu" >
           <?php echo $arbol->enrraizar($this->_tree[$i]["hijo"], $this->_vista, $this->_link,$this->_seleccionado);?> 
        </ul>    

        <?php endif; ?>
        </li>
    <?php endfor; ?>    
<?php endif; ?>

       