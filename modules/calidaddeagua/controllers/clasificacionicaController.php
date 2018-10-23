<?php

class clasificacionicaController extends Controller {

    private $_clasificacionicas;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_clasificacionicas = $this->loadModel('clasificacionica');
    }

    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_clasificacionica');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'ClasificacionIcas');
        $this->_view->getLenguaje("monitoreoca_clasificacionica");
        $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarClasificacionIca();
        }

        $paginador = new Paginador();
        $this->_view->assign('clasificacionicas', $paginador->paginar($this->_clasificacionicas->getClasificacionIcas(), "listaregistros", "", false, 25));
        $this->_view->assign('categoriaicas', $this->_clasificacionicas->getCategoriaIcas());
        $this->_view->assign('icas', $this->_clasificacionicas->getIcas());

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos al ClasificacionIca');
        }
        $this->_view->renderizar('index', 'clasificacionicas');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_clasificacionica');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar ClasificacionIca');
        $this->_view->getLenguaje("monitoreoca_clasificacionica");
        $this->_view->setJs(array('index'));

        if ($id) {
            $id = $this->filtrarInt($id);
        }

        if ($this->botonPress("bt_guardar")) {
            $this->_editarClasificacionIca($id);
        }

        $this->_view->assign('datos', $this->_clasificacionicas->getClasificacionIca($id));
        $this->_view->assign('categoriaicas', $this->_clasificacionicas->getCategoriaIcas());
        $this->_view->assign('icas', $this->_clasificacionicas->getIcas());
        $this->_view->renderizar('edit', 'clasificacionicas');
    }

    public function _registrarClasificacionIca() {
        $idClasificacionIca = $this->_clasificacionicas->registrarClasificacionIca(
                $this->getSql('nombre'), $this->getSql('descripcion'), $this->getInt('icamin'), $this->getInt('icamax'), $this->getSql('color'), $this->getSql('selCategoriaIca'), $this->getSql('selIca'), $this->getSql('selEstado')
        );

        if (is_array($idClasificacionIca)) {
            if ($idClasificacionIca[0] > 0) {
                $this->_view->assign('_mensaje', 'ClasificacionIca <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar la ClasificacionIca');
            }
        }
    }

    public function _editarClasificacionIca($id) {


        $idClasificacionIca = $this->_clasificacionicas->actualizarClasificacionIca(
                $id, $this->getSql('nombre'), $this->getSql('descripcion'), $this->getInt('icamin'), $this->getInt('icamax'), $this->getSql('color'), $this->getSql('selCategoriaIca'), $this->getSql('selIca'), $this->getSql('selEstado')
        );

        if ($idClasificacionIca >= 0) {
            $this->_view->assign('_mensaje', 'ClasificacionIca <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> actualizado..!!');
        } else {

            $this->_view->assign('_error', 'Error al actualizar la ClasificacionIca');
        }
    }

    public function _paginacion_listaregistros() {
        $this->_view->getLenguaje("monitoreoca_clasificacionica");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $idCategoriaIca = $this->getInt('idcategoriaica');
        $idica = $this->getInt('idica');
        $condicion = "";

        $condicion .= " where Cli_Nombre liKe '%$nombre%' ";
        if ($idCategoriaIca > 0) {
            $condicion .= " and ca.Cai_IdCategoriaIca = $idCategoriaIca ";
        }
        if ($idica > 0) {
            $condicion .= " and ic.Ica_IdIca = $idica ";
        }

        $paginador = new Paginador();

        $this->_view->assign('clasificacionicas', $paginador->paginar($this->_clasificacionicas->getClasificacionIcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarClasificacionIca() {

        $this->_view->getLenguaje("monitoreoca_clasificacionica");
        $nombre = $this->getSql('palabra');
        $idCategoriaIca = $this->getInt('idcategoriaica');
        $idica = $this->getInt('idica');
        $condicion = "";

        $condicion .= " where Cli_Nombre liKe '%$nombre%' ";
        if ($idCategoriaIca > 0) {
            $condicion .= " and ca.Cai_IdCategoriaIca = $idCategoriaIca ";
        }
        if ($idica > 0) {
            $condicion .= " and ic.Ica_IdIca = $idica ";
        }

        $paginador = new Paginador();

        $this->_view->assign('clasificacionicas', $paginador->paginar($this->_clasificacionicas->getClasificacionIcas($condicion), "listaregistros", "$nombre", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoClasificacionIca() {
        $this->_view->getLenguaje("monitoreoca_clasificacionica");


        $pagina = $this->getInt('pagina');
        $idclasificacionica = $this->getInt('idclasificacionica');
        $estado = $this->getInt('estado');
        $nombre = $this->getSql('palabra');
        $idCategoriaIca = $this->getInt('idcategoriaica');
        $idica = $this->getInt('idica');
        $condicion = "";

        $condicion .= " where Cli_Nombre liKe '%$nombre%' ";
        if ($idCategoriaIca > 0) {
            $condicion .= " and ca.Cai_IdCategoriaIca = $idCategoriaIca ";
        }
        if ($idica > 0) {
            $condicion .= " and ic.Ica_IdIca = $idica ";
        }

        $paginador = new Paginador();
        $this->_clasificacionicas->actualizarEstadoClasificacionIca($idclasificacionica, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('clasificacionicas', $paginador->paginar($this->_clasificacionicas->getClasificacionIcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulaclasificacionica recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _eliminarClasificacionIca() {
        $this->_view->getLenguaje("monitoreoca_clasificacionica");


        $pagina = $this->getInt('pagina');
        $idclasificacionica = $this->getInt('idclasificacionica');
        $nombre = $this->getSql('palabra');
        $idCategoriaIca = $this->getInt('idcategoriaica');
        $idica = $this->getInt('idica');
        $condicion = "";

        $condicion .= " where Cli_Nombre liKe '%$nombre%' ";
        if ($idCategoriaIca > 0) {
            $condicion .= " and ca.Cai_IdCategoriaIca = $idCategoriaIca ";
        }
        if ($idica > 0) {
            $condicion .= " and ic.Ica_IdIca = $idica ";
        }

        $paginador = new Paginador();
        $this->_clasificacionicas->eliminarClasificacionIca($idclasificacionica);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('clasificacionicas', $paginador->paginar($this->_clasificacionicas->getClasificacionIcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulaclasificacionica recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
