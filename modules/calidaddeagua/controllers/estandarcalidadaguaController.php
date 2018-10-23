<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of estandarcalidadaguaController
 *
 * @author CHUJE
 */
class estandarcalidadaguaController extends Controller {
    
    
    private $_estandaraguas;

    
    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
         $this->_estandaraguas = $this->loadModel('estandarcalidadagua');
         
        }
    
    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_estandaragua');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'categorias eca');
        $this->_view->getLenguaje("monitoreoca_estandarcalidadagua");
       $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarEstandarAgua();
        }

        $paginador = new Paginador();
        $this->_view->assign('estandaraguas', $paginador->paginar($this->_estandaraguas->getEstandarAguas(), "listaregistros", "", false, 25));
        $this->_view->assign('subcategoriaeca', $this->_estandaraguas->getSubCategoriaEcas());
        $this->_view->assign('variablesestudio', $this->_estandaraguas->getVariablesEstudio());
         $this->_view->assign('estadoeca', $this->_estandaraguas->getEstadoEcas());


        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos a la categoria   ecas');
        }
        $this->_view->renderizar('index', 'estandaraguas');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_estandarcalidadagua');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar EstandarAgua');
         $this->_view->getLenguaje("monitoreoca_estandarcalidadagua");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) {
            $this->_editarEstandarAgua($id);
        }
        
        $this->_view->assign('datos', $this->_estandaraguas->getEstandarAgua($id));
        $this->_view->assign('subcategoriaeca', $this->_estandaraguas->getSubCategoriaEcas());
        $this->_view->assign('variablesestudio', $this->_estandaraguas->getVariablesEstudio());
        $this->_view->assign('estadoeca', $this->_estandaraguas->getEstadoEcas());
        $this->_view->renderizar('edit', 'estandaraguas');
    }

    public function _registrarEstandarAgua() {
        
        $idEstandarAgua = $this->_estandaraguas->registrarEstandarAgua(
              $this->getSql('selsubcategoria'), $this->getSql('selvariabletipo'),
              $this->getSql('ecasigno'),$this->getSql('valormin'),
              $this->getSql('valormax'),$this->getSql('estadoeca'),  $this->getSql("selEstado")
        );

        if (is_array($idEstandarAgua)) {
            if ($idEstandarAgua[0] > 0) {
                $this->_view->assign('_mensaje', 'EstandarAgua <b style="font-size: 1.15em;">' . $this->getSql('selsubcategoria') . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar la estandarcalidadagua');
            }
        }
    }

    public function _editarEstandarAgua($id) {
        
         
        $idEstandarAgua = $this->_estandaraguas->actualizarEstandarAgua(
                
                $id,$this->getSql('selsubcategoria'), $this->getSql('selvariable'),
                $this->getSql('ecasigno'),  $this->getSql('ecaminimo'), 
                $this->getSql('ecamax'),  $this->getSql('selEstado'),
                $this->getSql('selestadoeca')
        );
       

        if ($idEstandarAgua>=0) {
            $this->_view->assign('_mensaje', 'EstandarAgua <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
             
        } else {
           
            $this->_view->assign('_error', 'Error al actualizar el EstandarAgua');
        }
    }

    public function _paginacion_listaregistros() {
        $this->_view->getLenguaje("monitoreoca_estandarcalidadagua");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
      
        $condicion = "";

        $condicion .= " where sce.Sue_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('estandaraguas', $paginador->paginar($this->_estandaraguas->getEstandarAguas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarEstandarAgua() {

        $this->_view->getLenguaje("monitoreoca_estandarcalidadagua");
        
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where sce.Sue_Nombre like '%$palabra%' ";
        $paginador = new Paginador();

        $this->_view->assign('estandaraguas', $paginador->paginar($this->_estandaraguas->getEstandarAguas($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoEstandarAgua() {
        $this->_view->getLenguaje("monitoreoca_estandarcalidadagua");

        $pagina = $this->getInt('pagina');
        $idestandarcalidadagua = $this->getInt('idestandarcalidadagua');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where sce.Sue_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_estandaraguas->actualizarEstadoEstandarAgua($idestandarcalidadagua, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('estandaraguas', $paginador->paginar($this->_estandaraguas->getEstandarAguas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarEstandarAgua() {
         $this->_view->getLenguaje("monitoreoca_estandarcalidadagua");


        $pagina = $this->getInt('pagina');
        $idestandarcalidadagua = $this->getInt('idestandarcalidadagua');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where sce.Sue_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_estandaraguas->eliminarEstandarAgua($idestandarcalidadagua);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('estandaraguas', $paginador->paginar($this->_estandaraguas->getEstandarAguas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
