<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of indexController
 *
 * @author JHON CHARLIE
 */
class indexController extends movilController{
    //put your code here
    private $_dublincore;
    
    public function __construct($lang,$url) 
    {
        parent::__construct($lang,$url);
        $this->_dublincore = $this->loadModel('index');
    }
    
    public function index()
    {       
        $this->_view->assign('titulo', 'DublinCore');
        //$this->_view->assign('documentos', $this->_usuarios->getUsuarios());
        $this->_view->renderizar('index');
    }
}
