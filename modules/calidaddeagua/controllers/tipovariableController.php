<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tipovariable
 *
 * @author CHUJE
 */
class tipovariableController extends Controller{
    //put your code here
    
private $_tipovariable;

    
    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
         $this->_tipovariable = $this->loadModel('tipovariable');
         
        }
    
    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_tipovariable');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Tipo Variable');
        $this->_view->getLenguaje("monitoreoca_tipovariable");
       $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarTipoVariable();
        }

        $paginador = new Paginador();
        $this->_view->assign('tipovariables', $paginador->paginar($this->_tipovariable->getTipoVariables(), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos a la categoria   ecas');
        }
        $this->_view->renderizar('index', 'tipovariables');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_tipovariable');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar TipoVariable');
        $this->_view->getLenguaje("monitoreoca_tipovariable");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) {
            $this->_editarTipoVariable($id);
        }
        
        $this->_view->assign('datos', $this->_tipovariable->getTipoVariable($id));
        $this->_view->renderizar('edit', 'tipovariables');
    }

    public function _registrarTipoVariable() {
           
        $idTipoVariable = $this->_tipovariable->registrarTipoVariable(
                
         $this->getSql('nombre'),$this->getSql('selEstado')
        );

        if (is_array($idTipoVariable)) {
            if ($idTipoVariable[0] > 0) {
                $this->_view->assign('_mensaje', 'TipoVariable <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar el tipovariable');
            }
        }
    }

    public function _editarTipoVariable($id) {
        
         
        $idTipoVariable = $this->_tipovariable->actualizarTipoVariable(
        $id,$this->getSql('nombre'),$this->getSql('selEstado')
        );
       

        if ($idTipoVariable>=0) {
            $this->_view->assign('_mensaje', 'TipoVariable <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
             
        } else {
           
            $this->_view->assign('_error', 'Error al actualizar el TipoVariable');
        }
    }

    public function _paginacion_listaregistros() {
         $this->_view->getLenguaje("monitoreoca_tipovariable");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Tiv_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('tipovariables', $paginador->paginar($this->_tipovariable->getTipoVariables($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarTipoVariable() {

         $this->_view->getLenguaje("monitoreoca_tipovariable");
        
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Tiv_Nombre like '%$palabra%' ";
        $paginador = new Paginador();

        $this->_view->assign('tipovariables', $paginador->paginar($this->_tipovariable->getTipoVariables($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarTipoVariable() {
         $this->_view->getLenguaje("monitoreoca_tipovariable");


        $pagina = $this->getInt('pagina');
        $idtipovariable = $this->getInt('idtipovariable');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Tiv_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_tipovariable->actualizarEstadoTipoVariable($idtipovariable, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('tipovariables', $paginador->paginar($this->_tipovariable->getTipoVariables($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarTipoVariable() {
        $this->_view->getLenguaje("_tipovariable");


        $pagina = $this->getInt('pagina');
        $idtipovariable = $this->getInt('idtipovariable');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where Tiv_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_tipovariable->eliminarTipoVariable($idtipovariable);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('tipovariables', $paginador->paginar($this->_tipovariable->getTipoVariables($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
