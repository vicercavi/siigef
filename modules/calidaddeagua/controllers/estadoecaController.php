<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of estadoecaController
 *
 * @author CHUJE
 */
class estadoecaController  extends Controller{
    //put your code here
private $_estadoeca;

    
    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
         $this->_estadoeca = $this->loadModel('estadoeca');
         
        }
    
    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_estadoeca');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'categorias eca');
         $this->_view->getLenguaje("monitoreoca_estadoeca");
       $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarEstadoEca();
        }

        $paginador = new Paginador();
        $this->_view->assign('estadoecas', $paginador->paginar($this->_estadoeca->getEstadoEcas(), "listaregistros", "", false, 25));
       

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos a la categoria   ecas');
        }
        $this->_view->renderizar('index', 'estadoecas');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_estadoeca');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar EstadoEca');
        $this->_view->getLenguaje("monitoreoca_estadoeca");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) {
            $this->_editarEstadoEca($id);
        }
        
        $this->_view->assign('datos', $this->_estadoeca->getEstadoEca($id));
        $this->_view->renderizar('edit', 'estadoecas');
    }

    public function _registrarEstadoEca() {
        $idEstadoEca = $this->_estadoeca->registrarEstadoEca(
              $this->getSql('referencia'), $this->getSql('nombre'),$this->getSql('color'),$this->getSql('selEstado')
        );

        if (is_array($idEstadoEca)) {
            if ($idEstadoEca[0] > 0) {
                $this->_view->assign('_mensaje', 'EstadoEca <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar la estadoeca');
            }
        }
    }

    public function _editarEstadoEca($id) {
        
         echo   $this->getSql('referencia'), $this->getSql('nombre'),$this->getSql('color'),$this->getSql('selEstado');

        $idEstadoEca = $this->_estadoeca->actualizarEstadoEca(
        $id, $this->getSql('referencia'), $this->getSql('nombre'),$this->getSql('color'),$this->getSql('selEstado')
        );
       

        if ($idEstadoEca>=0) {
            $this->_view->assign('_mensaje', 'EstadoEca <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
             
        } else {
           
            $this->_view->assign('_error', 'Error al actualizar el EstadoEca');
        }
    }

    public function _paginacion_listaregistros() {
        $this->_view->getLenguaje("monitoreoca_estadoeca");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Sue_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('estadoecas', $paginador->paginar($this->_estadoeca->getEstadoEcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarEstadoEca() {

        $this->_view->getLenguaje("monitoreoca_estadoeca");
        
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where ese_nombre like '%$palabra%' ";
        $paginador = new Paginador();

        $this->_view->assign('estadoecas', $paginador->paginar($this->_estadoeca->getEstadoEcas($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoEca() {
         $this->_view->getLenguaje("monitoreoca_estadoeca");

        $pagina = $this->getInt('pagina');
        $idestadoeca = $this->getInt('idestadoeca');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where ese_nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_estadoeca->actualizarEstadoEstadoEca($idestadoeca, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('estadoecas', $paginador->paginar($this->_estadoeca->getEstadoEcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarEstadoEca() {
        $this->_view->getLenguaje("monitoreoca_estadoeca");


        $pagina = $this->getInt('pagina');
        $idestadoeca = $this->getInt('idestadoeca');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where ese_nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_estadoeca->eliminarEstadoEca($idestadoeca);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('estadoecas', $paginador->paginar($this->_estadoeca->getEstadoEcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
