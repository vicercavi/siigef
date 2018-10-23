<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class categoriaecaController extends Controller
{
    
    private $_categoriaecas;
    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
         $this->_categoriaecas = $this->loadModel('categoriaeca');
    
    }
    
    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_categoriaeca');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'categorias eca');
        $this->_view->getLenguaje("monitoreoca_categoriaeca");
       $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarCategoriaEca();
        }

        $paginador = new Paginador();
        $this->_view->assign('categoriaecas', $paginador->paginar($this->_categoriaecas->getCategoriaEcas(), "listaregistros", "", false, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos a la categoria   ecas');
        }
        $this->_view->renderizar('index', 'categoriaecas');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_categoriaeca');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar CategoriaEca');
        $this->_view->getLenguaje("monitoreoca_categoriaeca");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) {
            $this->_editarCategoriaEca($id);
        }
        
        $this->_view->assign('datos', $this->_categoriaecas->getCategoriaEca($id));
        $this->_view->renderizar('edit', 'categoriaecas');
    }

    public function _registrarCategoriaEca() {
        $idCategoriaEca = $this->_categoriaecas->registrarCategoriaEca(
                $this->getSql('nombre'),$this->getSql('descripcion'),$this->getSql('fuente'),$this->getSql('selEstado')
        );

        if (is_array($idCategoriaEca)) {
            if ($idCategoriaEca[0] > 0) {
                $this->_view->assign('_mensaje', 'CategoriaEca <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar la categoriaeca');
            }
        }
    }

    public function _editarCategoriaEca($id) {
        
        
        $idCategoriaEca = $this->_categoriaecas->actualizarCategoriaEca(
                $id, $this->getSql('nombre'),  $this->getSql('descripcion'),  $this->getSql('fuente'), $this->getSql('selEstado')
        );

        if ($idCategoriaEca>=0) {
            $this->_view->assign('_mensaje', 'CategoriaEca <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
             
        } else {
           
            $this->_view->assign('_error', 'Error al actualizar el CategoriaEca');
        }
    }

    public function _paginacion_listaregistros() {
        $this->_view->getLenguaje("monitoreoca_categoriaeca");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Cae_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('categoriaecas', $paginador->paginar($this->_categoriaecas->getCategoriaEcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarCategoriaEca() {

        $this->_view->getLenguaje("monitoreoca_categoriaeca");
        
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Cae_Nombre like '%$palabra%' ";
        $paginador = new Paginador();

        $this->_view->assign('categoriaecas', $paginador->paginar($this->_categoriaecas->getCategoriaEcas($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoCategoriaEca() {
        $this->_view->getLenguaje("monitoreoca_categoriaeca");


        $pagina = $this->getInt('pagina');
        $idcategoriaeca = $this->getInt('idcategoriaeca');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Cae_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_categoriaecas->actualizarEstadoCategoriaEca($idcategoriaeca, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('categoriaecas', $paginador->paginar($this->_categoriaecas->getCategoriaEcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarCategoriaEca() {
         $this->_view->getLenguaje("monitoreoca_categoriaeca");


        $pagina = $this->getInt('pagina');
        $idcategoriaeca = $this->getInt('idcategoriaeca');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where Cae_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_categoriaecas->eliminarCategoriaEca($idcategoriaeca);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('categoriaecas', $paginador->paginar($this->_categoriaecas->getCategoriaEcas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
