<?php

class ponderacionicaController extends Controller {

    private $_ponderacionicas;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_ponderacionicas = $this->loadModel('ponderacionica');
    }

    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_ponderacionica');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'PonderacionIcas');
        $this->_view->getLenguaje("monitoreoca_ponderacionica");
        $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarPonderacionIca();
        }

        $paginador = new Paginador();
        $this->_view->assign('ponderacionicas', $paginador->paginar($this->_ponderacionicas->getPonderacionIcas(), "listaregistros", "", false, 25));
        $this->_view->assign('variables', $this->_ponderacionicas->getVariables());
        $this->_view->assign('icas', $this->_ponderacionicas->getIcas());

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos al PonderacionIca');
        }
        $this->_view->renderizar('index', 'ponderacionicas');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_ponderacionica');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar PonderacionIca');
        $this->_view->getLenguaje("monitoreoca_ponderacionica");
        $this->_view->setJs(array('index'));

        if ($id) {
            $id = $this->filtrarInt($id);
        }

        if ($this->botonPress("bt_guardar")) {
            $this->_editarPonderacionIca($id);
        }

        $this->_view->assign('datos', $this->_ponderacionicas->getPonderacionIca($id));
        $this->_view->assign('variables', $this->_ponderacionicas->getVariables());
        $this->_view->assign('icas', $this->_ponderacionicas->getIcas());
        $this->_view->renderizar('edit', 'ponderacionicas');
    }

    public function _registrarPonderacionIca() {
        $idPonderacionIca = $this->_ponderacionicas->registrarPonderacionIca(
                $this->getSql('selVariable'), empty($this->getSql('peso'))?0:$this->getSql('peso'), $this->getSql('selIca'), $this->getSql('selEstado')
        );

        if (is_array($idPonderacionIca)) {
            if ($idPonderacionIca[0] > 0) {
                $this->_view->assign('_mensaje', 'PonderacionIca <b style="font-size: 1.15em;">' . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar la PonderacionIca');
            }
        }
    }

    public function _editarPonderacionIca($id) {

        $idPonderacionIca = $this->_ponderacionicas->actualizarPonderacionIca(
                $id, $this->getSql('selVariable'), empty($this->getSql('peso'))?0:$this->getSql('peso'), $this->getSql('selIca'), $this->getSql('selEstado')
        );

        if ($idPonderacionIca >= 0) {
            $this->_view->assign('_mensaje', 'PonderacionIca <b style="font-size: 1.15em;">' . '</b> actualizado..!!');
        } else {

            $this->_view->assign('_error', 'Error al actualizar la PonderacionIca');
        }
    }

    public function _paginacion_listaregistros() {
         $this->_view->getLenguaje("monitoreoca_ponderacionica");

        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('palabra');
        $idVariable = $this->getInt('idvariable');
        $idica = $this->getInt('idica');
        $condicion = "";

        $condicion .= " where Poi_Peso liKe '%$palabra%' ";
        if ($idVariable > 0) {
            $condicion .= " and ve.Var_IdVariable = $idVariable ";
        }
        if ($idica > 0) {
            $condicion .= " and ic.Ica_IdIca = $idica ";
        }

        $paginador = new Paginador();

        $this->_view->assign('ponderacionicas', $paginador->paginar($this->_ponderacionicas->getPonderacionIcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarPonderacionIca() {

        $this->_view->getLenguaje("monitoreoca_ponderacionica");
        $palabra = $this->getSql('palabra');
        $idVariable = $this->getInt('idvariable');
        $idica = $this->getInt('idica');
        $condicion = "";

        $condicion .= " where Poi_Peso liKe '%$palabra%' ";
        if ($idVariable > 0) {
            $condicion .= " and ve.Var_IdVariable = $idVariable ";
        }
        if ($idica > 0) {
            $condicion .= " and ic.Ica_IdIca = $idica ";
        }

        $paginador = new Paginador();

        $this->_view->assign('ponderacionicas', $paginador->paginar($this->_ponderacionicas->getPonderacionIcas($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoPonderacionIca() {
        $this->_view->getLenguaje("_ponderacionica");


        $pagina = $this->getInt('pagina');
        $idponderacionica = $this->getInt('idponderacionica');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $idVariable = $this->getInt('idvariable');
        $idica = $this->getInt('idica');
        $condicion = "";

        $condicion .= " where Poi_Peso liKe '%$palabra%' ";
        if ($idVariable > 0) {
            $condicion .= " and ve.Var_IdVariable = $idVariable ";
        }
        if ($idica > 0) {
            $condicion .= " and ic.Ica_IdIca = $idica ";
        }

        $paginador = new Paginador();
        $this->_ponderacionicas->actualizarEstadoPonderacionIca($idponderacionica, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('ponderacionicas', $paginador->paginar($this->_ponderacionicas->getPonderacionIcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulaponderacionica recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _eliminarPonderacionIca() {
        $this->_view->getLenguaje("monitoreoca_ponderacionica");

        $pagina = $this->getInt('pagina');
        $idponderacionica = $this->getInt('idponderacionica');
        $palabra = $this->getSql('palabra');
        $idVariable = $this->getInt('idvariable');
        $idica = $this->getInt('idica');
        $condicion = "";

        $condicion .= " where Poi_Peso liKe '%$palabra%' ";
        if ($idVariable > 0) {
            $condicion .= " and ve.Var_IdVariable = $idVariable ";
        }
        if ($idica > 0) {
            $condicion .= " and ic.Ica_IdIca = $idica ";
        }

        $paginador = new Paginador();
        $this->_ponderacionicas->eliminarPonderacionIca($idponderacionica);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('ponderacionicas', $paginador->paginar($this->_ponderacionicas->getPonderacionIcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulaponderacionica recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
