<?php

class entidadController extends Controller {

    private $_entidades;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_entidades = $this->loadModel('entidad');
    }

    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_entidad');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Entidades');
        $this->_view->getLenguaje("monitoreoca_entidad");
        $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarEntidad();
        }

        $paginador = new Paginador();
        $this->_view->assign('entidades', $paginador->paginar($this->_entidades->getEntidades(), "listaregistros", "", false, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos a la entidad');
        }
        $this->_view->renderizar('index', 'entidades');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_entidad');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar Entidad');
        $this->_view->getLenguaje("monitoreoca_entidad");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) {
            $this->_editarEntidad($id);
        }
        
        $this->_view->assign('datos', $this->_entidades->getEntidad($id));
        $this->_view->renderizar('edit', 'entidades');
    }

    public function _registrarEntidad() {
        $idEntidad = $this->_entidades->registrarEntidad(
                $this->getSql('nombre'),$this->getSql('siglas'),$this->getSql('selEstado')
        );

        if (is_array($idEntidad)) {
            if ($idEntidad[0] > 0) {
                $this->_view->assign('_mensaje', 'Entidad <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar la entidad');
            }
        }
    }

    public function _editarEntidad($id) {
        
        
        $idEntidad = $this->_entidades->actualizarEntidad(
                $id, $this->getSql('nombre'),$this->getSql('siglas'),$this->getSql('selEstado')
        );

        if ($idEntidad>=0) {
            $this->_view->assign('_mensaje', 'Entidad <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
             
        } else {
           
            $this->_view->assign('_error', 'Error al actualizar el Entidad');
        }
    }

    public function _paginacion_listaregistros() {
        $this->_view->getLenguaje("monitoreoca_entidad");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Ent_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('entidades', $paginador->paginar($this->_entidades->getEntidades($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarEntidad() {

         $this->_view->getLenguaje("monitoreoca_entidad");
        
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Ent_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('entidades', $paginador->paginar($this->_entidades->getEntidades($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoEntidad() {
        $this->_view->getLenguaje("monitoreoca_entidad");


        $pagina = $this->getInt('pagina');
        $identidad = $this->getInt('identidad');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Ent_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_entidades->actualizarEstadoEntidad($identidad, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('entidades', $paginador->paginar($this->_entidades->getEntidades($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarEntidad() {
        $this->_view->getLenguaje("monitoreoca_entidad");


        $pagina = $this->getInt('pagina');
        $identidad = $this->getInt('identidad');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where Ent_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_entidades->eliminarEntidad($identidad);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('entidades', $paginador->paginar($this->_entidades->getEntidades($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
