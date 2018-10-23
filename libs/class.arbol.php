<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author ROCAVI
 */
class Arbol {

//put your code here
    private $_tree;   
    private  $_vista;
    private $_link;
    private $_seleccionado;
    private  $_lenguaje;

    public function enrraizar($query, $vista,$link=false, $idpadre=false) {
        $this->_tree = $query;
        $this->_vista=$vista;
        $this->_seleccionado=$idpadre;
        $this->_link=$link;
        $this->_lenguaje=Session::get("fileLenguaje");
                
        $rutaView = ROOT . 'views' . DS . '_arbol' . DS . $vista . '.php';
		
				
		if(is_readable($rutaView)){
			ob_start();
			
			include $rutaView;
			
			$contenido = ob_get_contents();
			
			ob_end_clean();
			
			return $contenido;
		}
		
		throw new Exception('Error de Arbol');		
        
    }

}
