<?php

class icaController extends Controller {

    private $_icas;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_icas = $this->loadModel('ica');
    }

    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_ica');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Icas');
         $this->_view->getLenguaje("monitoreoca_ica");
        $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarIca();
        }

        $paginador = new Paginador();
        $this->_view->assign('icas', $paginador->paginar($this->_icas->getIcas(), "listaregistros", "", false, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos a la ica');
        }
        $this->_view->renderizar('index', 'icas');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_ica');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar Ica');
        $this->_view->getLenguaje("monitoreoca_ica");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) {
            $this->_editarIca($id);
        }
        
        $this->_view->assign('datos', $this->_icas->getIca($id));
        $this->_view->renderizar('edit', 'icas');
    }

    public function _registrarIca() {
        $idIca = $this->_icas->registrarIca(
                $this->getSql('nombre'),$this->getSql('descripcion'),$this->getSql('selEstado')
        );

        if (is_array($idIca)) {
            if ($idIca[0] > 0) {
                $this->_view->assign('_mensaje', 'Ica <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar la ica');
            }
        }
    }

    public function _editarIca($id) {
        
        
        $idIca = $this->_icas->actualizarIca(
                $id, $this->getSql('nombre'),$this->getSql('descripcion'),$this->getSql('selEstado')
        );

        if ($idIca>=0) {
            $this->_view->assign('_mensaje', 'Ica <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
             
        } else {
           
            $this->_view->assign('_error', 'Error al actualizar el Ica');
        }
    }

    public function _paginacion_listaregistros() {
        $this->_view->getLenguaje("monitoreoca_ica");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Ica_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('icas', $paginador->paginar($this->_icas->getIcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarIca() {

        $this->_view->getLenguaje("monitoreoca_ica");
        
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Ica_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('icas', $paginador->paginar($this->_icas->getIcas($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoIca() {
        $this->_view->getLenguaje("monitoreoca_ica");


        $pagina = $this->getInt('pagina');
        $idica = $this->getInt('idica');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Ica_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_icas->actualizarEstadoIca($idica, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('icas', $paginador->paginar($this->_icas->getIcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarIca() {
        $this->_view->getLenguaje("monitoreoca_ica");


        $pagina = $this->getInt('pagina');
        $idica = $this->getInt('idica');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where Ica_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_icas->eliminarIca($idica);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('icas', $paginador->paginar($this->_icas->getIcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
