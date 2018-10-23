<?php

class ubigeoController extends hidrogeoController {

    private $_ubigeos;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_ubigeos = $this->loadModel('ubigeo');
    }

    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_ubigeo');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Ubigeo');
        $this->_view->getLenguaje("hidrogeo_ubigeo");
        $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarUbigeo();
        }


        $paginador = new Paginador();
        $this->_view->assign('ubigeos', $paginador->paginar($this->_ubigeos->getUbigeos(), "listaregistros", "", false, 25));
        $this->_view->assign('paises', $this->_ubigeos->getPaisUbigeo());
        $this->_view->assign('denominaciones', $this->_ubigeos->getDenominacionTerritorioxPais(0));
        $this->_view->assign('territorios1', $this->_ubigeos->getTerritorios1(0));
        $this->_view->assign('territorios2', $this->_ubigeos->getTerritorios2(0));
        $this->_view->assign('territorios3', $this->_ubigeos->getTerritorios3(0));
        $this->_view->assign('territorios4', $this->_ubigeos->getTerritorios4(0));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos al Estado|Ubigeo');
        }
        $this->_view->renderizar('index', 'ubigeos');
    }

    public function _filtroNuevo() {

        $this->_view->getLenguaje("hidrogeo_ubigeo");
        $idpais = $this->getInt('idpais');
        $idterritorio1 = $this->getInt('idterritorio1');
        $idterritorio2 = $this->getInt('idterritorio2');
        $idterritorio3 = $this->getInt('idterritorio3');
        $idterritorio4 = $this->getInt('idterritorio4');

        $this->_view->assign('sl_pais', $idpais);
        $this->_view->assign('sl_territorio1', $idterritorio1);
        $this->_view->assign('sl_territorio2', $idterritorio2);
        $this->_view->assign('sl_territorio3', $idterritorio3);
        $this->_view->assign('sl_territorio4', $idterritorio4);

        $this->_view->assign('paises', $this->_ubigeos->getPaisUbigeo());
        $this->_view->assign('denominaciones', $this->_ubigeos->getDenominacionTerritorioxPais($idpais));
        $this->_view->assign('territorios1', $this->_ubigeos->getTerritorios1($idpais));
        $this->_view->assign('territorios2', $this->_ubigeos->getTerritorios2($idpais));
        $this->_view->assign('territorios3', $this->_ubigeos->getTerritorios3($idpais));
        $this->_view->assign('territorios4', $this->_ubigeos->getTerritorios4($idpais));

        $this->_view->renderizar('ajax/nuevoregistro', false, true);
    }

    public function _filtroEditar() {

       $this->_view->getLenguaje("hidrogeo_ubigeo");
        $idpais = $this->getInt('idpais');
        $idterritorio1 = $this->getInt('idterritorio1');
        $idterritorio2 = $this->getInt('idterritorio2');
        $idterritorio3 = $this->getInt('idterritorio3');
        $idterritorio4 = $this->getInt('idterritorio4');

        $this->_view->assign('sl_pais', $idpais);
        $this->_view->assign('sl_territorio1', $idterritorio1);
        $this->_view->assign('sl_territorio2', $idterritorio2);
        $this->_view->assign('sl_territorio3', $idterritorio3);
        $this->_view->assign('sl_territorio4', $idterritorio4);

        $this->_view->assign('paises', $this->_ubigeos->getPaisUbigeo());
        $this->_view->assign('denominaciones', $this->_ubigeos->getDenominacionTerritorioxPais($idpais));
        $this->_view->assign('territorios1', $this->_ubigeos->getTerritorios1($idpais));
        $this->_view->assign('territorios2', $this->_ubigeos->getTerritorios2($idpais));
        $this->_view->assign('territorios3', $this->_ubigeos->getTerritorios3($idpais));
        $this->_view->assign('territorios4', $this->_ubigeos->getTerritorios4($idpais));

        $this->_view->renderizar('ajax/editarregistro', false, true);
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_ubigeo');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar Ubigeo');
        $this->_view->getLenguaje("hidrogeo_ubigeo");
        $this->_view->setJs(array('edit'));

        if ($id) {
            $id = $this->filtrarInt($id);
        }

        if ($this->botonPress("bt_guardar")) {
            $this->_editarUbigeo($id);
        }
        $datos = $this->_ubigeos->getUbigeo($id);
        $this->_view->assign('datos', $datos);
        $this->_view->assign('paises', $this->_ubigeos->getPaisUbigeo());
        $this->_view->assign('denominaciones', $this->_ubigeos->getDenominacionTerritorioxPais($datos[1]));
        $this->_view->assign('territorios1', $this->_ubigeos->getTerritorios1($datos[1]));
        $this->_view->assign('territorios2', $this->_ubigeos->getTerritorios2($datos[1]));
        $this->_view->assign('territorios3', $this->_ubigeos->getTerritorios3($datos[1]));
        $this->_view->assign('territorios4', $this->_ubigeos->getTerritorios4($datos[1]));
        $this->_view->renderizar('edit', 'ubigeos');
    }

    public function _registrarUbigeo() {

        $idUbigeo = $this->_ubigeos->registrarUbigeo(
                $this->getSql('selPais'), $this->getSql('selTerritorio1'), $this->getSql('selTerritorio2'), $this->getSql('selTerritorio3'), $this->getSql('selTerritorio4'), $this->getSql('selEstado')
        );
        if (is_array($idUbigeo)) {
            if ($idUbigeo[0] > 0) {
                $this->_view->assign('_mensaje', 'Ubigeo <b style="font-size: 1.15em;">' . '' . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar el Ubigeo');
            }
        }
    }

    public function _editarUbigeo($id) {


        $idUbigeo = $this->_ubigeos->actualizarUbigeo(
                $id, $this->getSql('selPais'), $this->getSql('selTerritorio1'), $this->getSql('selTerritorio2'), $this->getSql('selTerritorio3'), $this->getSql('selTerritorio4'), $this->getSql('selEstado')
        );

        if ($idUbigeo >= 0) {
            $this->_view->assign('_mensaje', 'Ubigeo <b style="font-size: 1.15em;">' . '' . '</b> actualizado..!!');
        } else {

            $this->_view->assign('_error', 'Error al actualizar el Ubigeo');
        }
    }

    public function _paginacion_listaregistros() {
        $this->_view->getLenguaje("hidrogeo_ubigeo");

        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $condicion = "";

        $condicion .= " where t1 liKe '%$palabra%' or t2 like '%$palabra%' or t3 like '%$palabra%' or t4 like '%$palabra%' ";
        if ($idPais > 0) {
            $condicion .= " and Pai_IdPais = $idPais ";
        }

        $paginador = new Paginador();

        $this->_view->assign('ubigeos', $paginador->paginar($this->_ubigeos->getUbigeos($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarUbigeo() {

        $this->_view->getLenguaje("hidrogeo_ubigeo");
        $palabra = $this->getSql('palabra');
        $idpais = $this->getInt('idpais');


        $condicion = "";
        $condicion .= " where t1 liKe '%$palabra%' or t2 like '%$palabra%' or t3 like '%$palabra%' or t4 like '%$palabra%' ";
        $condicion .= " and Pai_IdPais= $idpais";
        if ($idpais > 0) {
            
        }

        $paginador = new Paginador();

        $this->_view->assign('ubigeos', $paginador->paginar($this->_ubigeos->getUbigeos($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoUbigeo() {
        $this->_view->getLenguaje("hidrogeo_ubigeo");


        $pagina = $this->getInt('pagina');
        $idubigeo = $this->getInt('idubigeo');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $condicion = "";

        $condicion .= " where t1 liKe '%$palabra%' or t2 like '%$palabra%' or t3 like '%$palabra%' or t4 like '%$palabra%' ";
        if ($idPais > 0) {
            $condicion .= " and Pai_IdPais = $idPais ";
        }
        $paginador = new Paginador();
        $this->_ubigeos->actualizarEstadoUbigeo($idubigeo, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('ubigeos', $paginador->paginar($this->_ubigeos->getUbigeos($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _eliminarUbigeo() {
        $this->_view->getLenguaje("hidrogeo_ubigeo");


        $pagina = $this->getInt('pagina');
        $idubigeo = $this->getInt('idubigeo');
        $palabra = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');

        $condicion = "";

        $condicion .= " where t1 liKe '%$palabra%' or t2 like '%$palabra%' or t3 like '%$palabra%' or t4 like '%$palabra%' ";
        if ($idPais > 0) {
            $condicion .= " and Pai_IdPais = $idPais ";
        }

        $paginador = new Paginador();
        $this->_ubigeos->eliminarUbigeo($idubigeo);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('ubigeos', $paginador->paginar($this->_ubigeos->getUbigeos($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
