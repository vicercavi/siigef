<?php

class categoriaicaController extends Controller {

    private $_categoriaicas;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_categoriaicas = $this->loadModel('categoriaica');
    }

    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_categoriaica');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'CategoriaIcas');
        $this->_view->getLenguaje("monitoreoca_categoriaica");
        $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarCategoriaIca();
        }

        $paginador = new Paginador();
        $this->_view->assign('categoriaicas', $paginador->paginar($this->_categoriaicas->getCategoriaIcas(), "listaregistros", "", false, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos a la categoriaica');
        }
        $this->_view->renderizar('index', 'categoriaicas');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_categoriaica');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar CategoriaIca');
        $this->_view->getLenguaje("monitoreoca_categoriaica");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) {
            $this->_editarCategoriaIca($id);
        }
        
        $this->_view->assign('datos', $this->_categoriaicas->getCategoriaIca($id));
        $this->_view->renderizar('edit', 'categoriaicas');
    }

    public function _registrarCategoriaIca() {
        $idCategoriaIca = $this->_categoriaicas->registrarCategoriaIca(
                $this->getSql('nombre'),$this->getSql('descripcion'),$this->getSql('fuente'),$this->getSql('selEstado')
        );

        if (is_array($idCategoriaIca)) {
            if ($idCategoriaIca[0] > 0) {
                $this->_view->assign('_mensaje', 'CategoriaIca <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar la categoriaica');
            }
        }
    }

    public function _editarCategoriaIca($id) {
        
        
        $idCategoriaIca = $this->_categoriaicas->actualizarCategoriaIca(
                $id, $this->getSql('nombre'),$this->getSql('descripcion'),$this->getSql('fuente'),$this->getSql('selEstado')
        );

        if ($idCategoriaIca>=0) {
            $this->_view->assign('_mensaje', 'CategoriaIca <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
             
        } else {
           
            $this->_view->assign('_error', 'Error al actualizar el CategoriaIca');
        }
    }

    public function _paginacion_listaregistros() {
        $this->_view->getLenguaje("monitoreoca_categoriaica");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Cai_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('categoriaicas', $paginador->paginar($this->_categoriaicas->getCategoriaIcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarCategoriaIca() {

        $this->_view->getLenguaje("monitoreoca_categoriaica");
        
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Cai_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('categoriaicas', $paginador->paginar($this->_categoriaicas->getCategoriaIcas($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoCategoriaIca() {
        $this->_view->getLenguaje("monitoreoca_categoriaica");


        $pagina = $this->getInt('pagina');
        $idcategoriaica = $this->getInt('idcategoriaica');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Cai_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_categoriaicas->actualizarEstadoCategoriaIca($idcategoriaica, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('categoriaicas', $paginador->paginar($this->_categoriaicas->getCategoriaIcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarCategoriaIca() {
        $this->_view->getLenguaje("monitoreoca_categoriaica");


        $pagina = $this->getInt('pagina');
        $idcategoriaica = $this->getInt('idcategoriaica');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where Cai_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_categoriaicas->eliminarCategoriaIca($idcategoriaica);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('categoriaicas', $paginador->paginar($this->_categoriaicas->getCategoriaIcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
