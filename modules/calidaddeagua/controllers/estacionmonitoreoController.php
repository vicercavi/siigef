<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of estaciomonitoreo
 *
 * @author CHUJE
 */
class estacionmonitoreoController extends Controller{
    //put your code here
private $_estacionmonitoreo;

    
    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
         $this->_estacionmonitoreo = $this->loadModel('estacionmonitoreo');
         $this->_ubigeos=$this->loadModel('ubigeo', 'hidrogeo');         
        }
    
    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_estacionmonitoreo');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Estacion Monitoreo');
        $this->_view->getLenguaje("monitoreoca_estacionmonitoreo");
       $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarEstacionMonitoreo();
        }

        $paginador = new Paginador();

        $this->_view->assign('ubigeos', $this->_ubigeos->getUbigeos());
        $this->_view->assign('estacionmonitoreos', $paginador->paginar($this->_estacionmonitoreo->getEstacionMonitoreos(), "listaregistros", "", false, 25));
        $this->_view->assign('tipoestacion', $this->_estacionmonitoreo->getTipoEstacion());
        $this->_view->assign('riocuenca', $this->_estacionmonitoreo->getRioCuenca());
        $this->_view->assign('municipio', $this->_estacionmonitoreo->getMunicipio());
        $this->_view->assign('departamento', $this->_estacionmonitoreo->getDepartamento());
        
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos a la categoria   ecas');
        }
        $this->_view->renderizar('index', 'estacionmonitoreos');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_estacionmonitoreo');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar Estacion Monitoreo');
         $this->_view->getLenguaje("monitoreoca_estacionmonitoreo");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) {
            $this->_editarEstacionMonitoreo($id);
        }
        $this->_view->assign('ubigeos', $this->_ubigeos->getUbigeos());
        $this->_view->assign('datos', $this->_estacionmonitoreo->getEstacionMonitoreo($id));
        $this->_view->assign('tipoestacion', $this->_estacionmonitoreo->getTipoEstacion());
        $this->_view->assign('riocuenca', $this->_estacionmonitoreo->getRioCuenca());
        $this->_view->assign('municipio', $this->_estacionmonitoreo->getMunicipio());
        $this->_view->assign('departamento', $this->_estacionmonitoreo->getDepartamento());
        $this->_view->renderizar('edit', 'estacionmonitoreos');
    }

    public function _registrarEstacionMonitoreo() {

        $idEstacionMonitoreo = $this->_estacionmonitoreo->registrarEstacionMonitoreo(
              $this->getSql('nombre'),$this->getSql('latitud'),$this->getSql('longitud'),$this->getSql('referencia'),$this->getSql('altitud'), $this->getSql('selEstado'), $this->getSql('selrio'),$this->getSql('seltipo'), $this->getSql('selUbigeo')  
        );

        if (is_array($idEstacionMonitoreo)) {
            if ($idEstacionMonitoreo[0] > 0) {
                $this->_view->assign('_mensaje', 'EstacionMonitoreo <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar la estacionmonitoreo');
            }
        }
    }

    public function _editarEstacionMonitoreo($id) {

        $idEstacionMonitoreo = $this->_estacionmonitoreo->actualizarEstacionMonitoreo(
        $id, $this->getSql('nombre'), $this->getSql('latitud'), $this->getSql('longitud'), $this->getSql('referencia'), $this->getSql('altitud'), $this->getSql('selEstado'), $this->getSql('selrio'), $this->getSql('seltipo'), $this->getSql('selUbigeo') 
        );
       
        if ($idEstacionMonitoreo>=0) {
            $this->_view->assign('_mensaje', 'EstacionMonitoreo <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
             
        } else {
           
            $this->_view->assign('_error', 'Error al actualizar el EstacionMonitoreo');
        }
    }

    public function _paginacion_listaregistros() {
        $this->_view->getLenguaje("monitoreoca_estacionmonitoreo");

        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Esm_Nombre like '%$palabra%' ";

        $paginador = new Paginador();

        $this->_view->assign('estacionmonitoreos', $paginador->paginar($this->_estacionmonitoreo->getEstacionMonitoreos($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarEstacionMonitoreo() {

        $this->_view->getLenguaje("monitoreoca_estacionmonitoreo");
        
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Esm_Nombre like '%$palabra%' ";
        $paginador = new Paginador();

        $this->_view->assign('estacionmonitoreos', $paginador->paginar($this->_estacionmonitoreo->getEstacionMonitoreos($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoEstacionMonitoreo() {
        $this->_view->getLenguaje("monitoreoca_estacionmonitoreo");


        $pagina = $this->getInt('pagina');
        $idestacionmonitoreo = $this->getInt('idestacionmonitoreo');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Esm_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_estacionmonitoreo->actualizarEstadoEstacionMonitoreo($idestacionmonitoreo, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('estacionmonitoreos', $paginador->paginar($this->_estacionmonitoreo->getEstacionMonitoreos($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarEstacionMonitoreo() {
        $this->_view->getLenguaje("monitoreoca_estacionmonitoreo");


        $pagina = $this->getInt('pagina');
        $idestacionmonitoreo = $this->getInt('idestacionmonitoreo');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where Esm_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_estacionmonitoreo->eliminarEstacionMonitoreo($idestacionmonitoreo);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('estacionmonitoreos', $paginador->paginar($this->_estacionmonitoreo->getEstacionMonitoreos($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>

