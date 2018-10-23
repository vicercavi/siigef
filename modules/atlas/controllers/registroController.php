<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of registrarController
 *
 * @author JHON CHARLIE
 */
class registroController extends dublincoreController{
    //put your code here
    private $_registro;
    
    public function __construct($lang,$url) {
        parent::__construct($lang,$url);
        $this->_registro = $this->loadModel('registro');
    }
    
    public function index()
    {
        $this->_acl->acceso("registro_individual");   
        $this->validarUrlIdioma();        
        //$this->_view->setJs(array('registro'));
        $this->_view->assign('titulo', 'DublinCore');
        $this->_view->assign('autores', $this->_registro->getAutores());
        $this->_view->assign('temas', $this->_registro->getTemas());
        $this->_view->assign('tipodublin', $this->_registro->getTipoDublin());
        $this->_view->assign('idiomas', $this->_registro->getIdiomas());
        //$this->_view->assign('documentos', $this->_usuarios->getUsuarios());
        
        if(isset($_POST['submitregistrar'])){
            $this->_view->assign('datos', $_POST);
            
            $this->_registro->registrarDublinCore(
                $this->getInt('idIdiomaMetadata'),
                $this->getInt('idAutor'),
                $this->getInt('idTemaDublin'),
                $this->getInt('idTipoDublin'),
                $this->getSql('idiomaDocumento'),
                    $this->getSql('titulo'),
                    $this->getSql('descripcion'),
                    $this->getSql('editor'),
                    $this->getSql('colaborador'),
                    $this->getSql('fechaDocumento'),
                    $this->getSql('fuente'),
                    $this->getSql('identificador'),
                    $this->getSql('formato'),
                    $this->getSql('derechos')
                );
            
            $this->_view->assign('datos', false);
            $this->_view->assign('_mensaje', 'Registro Completado...');
        
        }        
        
        $this->_view->renderizar('index');
    }
    
    public function registrarDocumento() {
                         /*
        if($this->getInt('registrar') == 1){
            $this->_registro->registrarDublinCore(
                $this->getInt('idIdiomaMetadata'),
                $this->getInt('idAutor'),
                $this->getInt('idTemaDublin'),
                $this->getInt('idTipoDublin'),
                $this->getSql('idiomaDocumento'),
                    $this->getSql('titulo'),
                    $this->getSql('descripcion'),
                    $this->getSql('editor'),
                    $this->getSql('colaborador'),
                    $this->getSql('fechaDocumento'),
                    $this->getSql('fuente'),
                    $this->getSql('identificador'),
                    $this->getSql('formato'),
                    $this->getSql('derechos')
                );
            $this->redireccionar('dublincore/documentos');
        }
        $this->_view->renderizar('registrarDocumento');
        */
    }
}
