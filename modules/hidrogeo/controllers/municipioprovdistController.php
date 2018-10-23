<?php

class estadodepartamentoController extends hidrogeoController {

    private $_estadodepartamentos;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_estadodepartamentos = $this->loadModel('estadodepartamento');
    }

    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_estadodepartamento');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Estados|Departamentos');
        $this->_view->getLenguaje("hidrogeo_estadodepartamento");
        $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarEstadoDepartamento();
        }

        $paginador = new Paginador();
        $this->_view->assign('estadodepartamentos', $paginador->paginar($this->_estadodepartamentos->getEstadoDepartamentos(), "listaregistros", "", false, 25));
        $this->_view->assign('paises', $this->_estadodepartamentos->getPaisEstadoDepartamento());

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos al Estado|Departamento');
        }
        $this->_view->renderizar('index', 'estadodepartamentos');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_estadodepartamento');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar Estado|Departamento');
        $this->_view->getLenguaje("hidrogeo_estadodepartamento");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) {
            $this->_editarEstadoDepartamento($id);
        }
        
        $this->_view->assign('datos', $this->_estadodepartamentos->getEstadoDepartamento($id));
        $this->_view->assign('paises', $this->_estadodepartamentos->getPaisEstadoDepartamento());
        $this->_view->renderizar('edit', 'estadodepartamentos');
    }

    public function _registrarEstadoDepartamento() {
        
        $idEstadoDepartamento = $this->_estadodepartamentos->registrarEstadoDepartamento(
                $this->getSql('nombre'), $this->getSql('siglas'), $this->getSql('selPais'), $this->getSql('selEstado'), $this->getSql('denominacion')
        );
        if (is_array($idEstadoDepartamento)) {
            if ($idEstadoDepartamento[0] > 0) {
                $this->_view->assign('_mensaje', 'Estado|Departamento <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar el Estado|Departamento');
            }
        }
    }

    public function _editarEstadoDepartamento($id) {
        
        
        $idEstadoDepartamento = $this->_estadodepartamentos->actualizarEstadoDepartamento(
                $id, $this->getSql('nombre'), $this->getSql('siglas'), $this->getSql('selPais'), $this->getSql('selEstado'), $this->getSql('denominacion')
        );

        if ($idEstadoDepartamento>=0) {
            $this->_view->assign('_mensaje', 'Estado|Departamento <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
             
        } else {
           
            $this->_view->assign('_error', 'Error al actualizar el Estado|Departamento');
        }
    }

    public function _paginacion_listaregistros() {
        $this->_view->getLenguaje("hidrogeo_estadodepartamento");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $condicion = "";

        $condicion .= " where Esd_Nombre liKe '%$nombre%' ";
        if ($idPais > 0) {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }


        $paginador = new Paginador();

        $this->_view->assign('estadodepartamentos', $paginador->paginar($this->_estadodepartamentos->getEstadoDepartamentos($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarEstadoDepartamento() {

        $this->_view->getLenguaje("hidrogeo_estadodepartamento");
        $nombre = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $condicion = "";

        $condicion .= " where Esd_Nombre liKe '%$nombre%' ";
        if ($idPais > 0) {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }
        $paginador = new Paginador();

        $this->_view->assign('estadodepartamentos', $paginador->paginar($this->_estadodepartamentos->getEstadoDepartamentos($condicion), "listaregistros", "$nombre", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoEstadoDepartamento() {
        $this->_view->getLenguaje("hidrogeo_estadodepartamento");


        $pagina = $this->getInt('pagina');
        $idestadodepartamento = $this->getInt('idestadodepartamento');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');

        $condicion = "";

        $condicion .= " where Esd_Nombre liKe '%$palabra%' ";
        if ($idPais > 0) {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }

        $paginador = new Paginador();
        $this->_estadodepartamentos->actualizarEstadoEstadoDepartamento($idestadodepartamento, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('estadodepartamentos', $paginador->paginar($this->_estadodepartamentos->getEstadoDepartamentos($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarEstadoDepartamento() {
        $this->_view->getLenguaje("hidrogeo_estadodepartamento");


        $pagina = $this->getInt('pagina');
        $idestadodepartamento = $this->getInt('idestadodepartamento');
        $palabra = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');

        $condicion = "";

        $condicion .= " where Esd_Nombre liKe '%$palabra%' ";
        if ($idPais > 0) {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }

        $paginador = new Paginador();
        $this->_estadodepartamentos->eliminarEstadoDepartamento($idestadodepartamento);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('estadodepartamentos', $paginador->paginar($this->_estadodepartamentos->getEstadoDepartamentos($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
