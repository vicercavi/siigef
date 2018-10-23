<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of subcategoriaecaController
 *
 * @author CHUJE
 */
class subcategoriaecaController extends Controller {
    
    
    private $_subcategoriaecas;

    
    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
         $this->_subcategoriaecas = $this->loadModel('subcategoriaeca');
         
        }
    
    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_subcategoriaeca');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'categorias eca');
         $this->_view->getLenguaje("monitoreoca_subcategoriaeca");
       $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarSubCategoriaEca();
        }

        $paginador = new Paginador();
        $this->_view->assign('subcategoriaecas', $paginador->paginar($this->_subcategoriaecas->getSubCategoriaEcas(), "listaregistros", "", false, 25));
        $this->_view->assign('categoriaecas', $this->_subcategoriaecas->getCategoriaEca());

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos a la categoria   ecas');
        }
        $this->_view->renderizar('index', 'subcategoriaecas');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_subcategoriaeca');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar SubCategoriaEca');
        $this->_view->getLenguaje("monitoreoca_subcategoriaeca");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) {
            $this->_editarSubCategoriaEca($id);
        }
        
        $this->_view->assign('datos', $this->_subcategoriaecas->getSubCategoriaEca($id));
        $this->_view->assign('categoriaecas', $this->_subcategoriaecas->getCategoriaEca());
        $this->_view->renderizar('edit', 'subcategoriaecas');
    }

    public function _registrarSubCategoriaEca() {
        $idSubCategoriaEca = $this->_subcategoriaecas->registrarSubCategoriaEca(
              $this->getSql('selCategoria'), $this->getSql('nombre'),$this->getSql('descripcion'),$this->getSql('selEstado')
        );

        if (is_array($idSubCategoriaEca)) {
            if ($idSubCategoriaEca[0] > 0) {
                $this->_view->assign('_mensaje', 'SubCategoriaEca <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar la subcategoriaeca');
            }
        }
    }

    public function _editarSubCategoriaEca($id) {
        
         
        $idSubCategoriaEca = $this->_subcategoriaecas->actualizarSubCategoriaEca(
                $id,$this->getSql('selCategoria'), $this->getSql('nombre'),  $this->getSql('descripcion'),  $this->getSql('fuente'), $this->getSql('selEstado')
        );
       

        if ($idSubCategoriaEca>=0) {
            $this->_view->assign('_mensaje', 'SubCategoriaEca <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
             
        } else {
           
            $this->_view->assign('_error', 'Error al actualizar el SubCategoriaEca');
        }
    }

    public function _paginacion_listaregistros() {
        $this->_view->getLenguaje("monitoreoca_subcategoriaeca");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Sue_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('subcategoriaecas', $paginador->paginar($this->_subcategoriaecas->getSubCategoriaEcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarSubCategoriaEca() {

        $this->_view->getLenguaje("monitoreoca_subcategoriaeca");
        
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where s.Sue_Nombre like '%$palabra%' ";
        $paginador = new Paginador();

        $this->_view->assign('subcategoriaecas', $paginador->paginar($this->_subcategoriaecas->getSubCategoriaEcas($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoSubCategoriaEca() {
        $this->_view->getLenguaje("monitoreoca_subcategoriaeca");


        $pagina = $this->getInt('pagina');
        $idsubcategoriaeca = $this->getInt('idsubcategoriaeca');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where s.Sue_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_subcategoriaecas->actualizarEstadoSubCategoriaEca($idsubcategoriaeca, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('subcategoriaecas', $paginador->paginar($this->_subcategoriaecas->getSubCategoriaEcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarSubCategoriaEca() {
        $this->_view->getLenguaje("monitoreoca_subcategoriaeca");

        $pagina = $this->getInt('pagina');
        $idsubcategoriaeca = $this->getInt('idsubcategoriaeca');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where s.Sue_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_subcategoriaecas->eliminarSubCategoriaEca($idsubcategoriaeca);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('subcategoriaecas', $paginador->paginar($this->_subcategoriaecas->getSubCategoriaEcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
