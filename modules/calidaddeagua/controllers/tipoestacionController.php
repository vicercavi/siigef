<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tipoestacionController
 *
 * @author CHUJE
 */
class tipoestacionController extends Controller{
    //put your code here
private $_tipoestacion;

    
    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
         $this->_tipoestacion = $this->loadModel('tipoestacion');
         
        }
    
    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_tipoestacion');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Tipo de Estacion');
        $this->_view->getLenguaje("monitoreoca_tipoestacion");
       $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarTipoEstacion();
        }

        $paginador = new Paginador();
        $this->_view->assign('tipoestaciones', $paginador->paginar($this->_tipoestacion->getTipoEstaciones(), "listaregistros", "", false, 25));
       

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos a la categoria   ecas');
        }
        $this->_view->renderizar('index', 'tipoestaciones');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_tipoestacion');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar TipoEstacion');
        $this->_view->getLenguaje("monitoreoca_tipoestacion");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) {
            $this->_editarTipoEstacion($id);
        }
        
        $this->_view->assign('datos', $this->_tipoestacion->getTipoEstacion($id));
        $this->_view->renderizar('edit', 'tipoestaciones');
    }

    public function _registrarTipoEstacion() {
        $idTipoEstacion = $this->_tipoestacion->registrarTipoEstacion(
              $this->getSql('nombre'),$this->getSql('selEstado')
        );

        if (is_array($idTipoEstacion)) {
            if ($idTipoEstacion[0] > 0) {
                $this->_view->assign('_mensaje', 'TipoEstacion <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar la tipoestacion');
            }
        }
    }

    public function _editarTipoEstacion($id) {
        
        $idTipoEstacion = $this->_tipoestacion->actualizarTipoEstacion(
        
                $id, $this->getSql('nombre'), $this->getSql('selEstado')
        );
       

        if ($idTipoEstacion>=0) {
            $this->_view->assign('_mensaje', 'TipoEstacion <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
             
        } else {
           
            $this->_view->assign('_error', 'Error al actualizar el TipoEstacion');
        }
    }

    public function _paginacion_listaregistros() {
        $this->_view->getLenguaje("monitoreoca_tipoestacion");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where te.Tie_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('tipoestaciones', $paginador->paginar($this->_tipoestacion->getTipoEstaciones($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarTipoEstacion() {

        $this->_view->getLenguaje("monitoreoca_tipoestacion");
        
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where te.Tie_Nombre like '%$palabra%' ";
        $paginador = new Paginador();

        $this->_view->assign('tipoestaciones', $paginador->paginar($this->_tipoestacion->getTipoEstaciones($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoTipoEstacion() {
         $this->_view->getLenguaje("monitoreoca_tipoestacion");


        $pagina = $this->getInt('pagina');
        $idtipoestacion = $this->getInt('idtipoestacion');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where te.Tie_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_tipoestacion->actualizarEstadoTipoEstacion($idtipoestacion, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('tipoestaciones', $paginador->paginar($this->_tipoestacion->getTipoEstaciones($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarTipoEstacion() {
        $this->_view->getLenguaje("monitoreoca_tipoestacion");


        $pagina = $this->getInt('pagina');
        $idtipoestacion = $this->getInt('idtipoestacion');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where te.Tie_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_tipoestacion->eliminarTipoEstacion($idtipoestacion);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('tipoestaciones', $paginador->paginar($this->_tipoestacion->getTipoEstaciones($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
