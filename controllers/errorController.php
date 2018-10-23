<?php

class errorController extends Controller
{
    public function __construct($lang,$url) {
        parent::__construct($lang,$url);
    }
    
    public function index()
    {
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->assign('titulo', 'Error');
        $this->_view->assign('mensaje', $this->_getError());
        $this->_view->renderizar('index');
    }
    
    public function access($codigo,$data="")    {
       
        $this->validarUrlIdioma();
         $this->_view->setTemplate(LAYOUT_FRONTEND);
         $this->_view->getLenguaje("error_acces");
        $this->_view->assign('titulo', 'Error');
        $this->_view->assign('data', $data);        
        $this->_view->assign('mensaje', $this->_getError($codigo));
        $this->_view->renderizar('access');
    }
    
    private function _getError($codigo = false)
    {
        //$this->validarUrlIdioma();
        if($codigo){
            $codigo = $this->filtrarInt($codigo);
            if(is_int($codigo))
                $codigo = $codigo;
        }
        else{
            $codigo = 'default';
        }        
        
        $error['default'] = 'Ha ocurrido un error y la página no puede mostrarse';
        $error['5050'] = 'Acceso restringido!';
        $error['8080'] = 'Tiempo de la sesion agotado';
        
        if(array_key_exists($codigo, $error)){
            return $error[$codigo];
        }
        else{
            return $error['default'];
        }
    }
}

?>