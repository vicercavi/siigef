<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class acercadeController extends Controller{
       public function __construct($lang, $url) {
        parent::__construct($lang, $url);
      }
public function index($pagina = false) {
        //Para idioma
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");      
        $this->_view->renderizar('index', 'acercade');
    }
}
?>
