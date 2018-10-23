<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of variablesestudioController
 *
 * @author CHUJE
 */
class variablesestudioController extends Controller {
    
    
    private $_variablesestudios;

    
    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
         $this->_variablesestudios = $this->loadModel('variablesestudio');
         
        }
    
    public function index($PermisoVacio = false) {
        $this->_acl->acceso('listar_variablesestudio');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'categorias eca');
        $this->_view->getLenguaje("monitoreoca_variablesestudio");
       $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) {
            $this->_registrarvariablesestudio();
        }

        $paginador = new Paginador();
        $this->_view->assign('variablesestudios', $paginador->paginar($this->_variablesestudios->getvariablesestudios(), "listaregistros", "", false, 25));
        $this->_view->assign('tipovariable', $this->_variablesestudios->getTipoVariable());

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos a la categoria   ecas');
        }
        $this->_view->renderizar('index', 'variablesestudios');
    }

    public function editar($id = false) {
        $this->_acl->acceso('editar_variablesestudio');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar variablesestudio');
        $this->_view->getLenguaje("monitoreoca_variablesestudio");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) {
            $this->_editarvariablesestudio($id);
        }
        
        $this->_view->assign('datos', $this->_variablesestudios->getvariablesestudio($id));
        $this->_view->assign('tipovariable', $this->_variablesestudios->getTipoVariable());
        $this->_view->renderizar('edit', 'variablesestudios');
    }

    public function _registrarvariablesestudio() {
        $idvariablesestudio = $this->_variablesestudios->registrarvariablesestudio(
           $this->getSql('nombre'),  $this->getSql('abreviatura'),$this->getSql('medida'),$this->getSql('selEstado'),$this->getSql('seltipo'),$this->getSql('descripcion')
        );

        if (is_array($idvariablesestudio)) {
            if ($idvariablesestudio[0] > 0) {
                $this->_view->assign('_mensaje', 'variablesestudio <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } else {
                $this->_view->assign('_error', 'Error al registrar la variablesestudio');
            }
        }
    }

    public function _editarvariablesestudio($id) {
        
         
        $idvariablesestudio = $this->_variablesestudios->actualizarvariablesestudio(
                $id ,$this->getSql('nombre'),  $this->getSql("abreviatura"),$this->getSql("medida"),$this->getSql('selEstado'),$this->getSql('seltipo'),$this->getSql('descripcion')
        );
       

        if ($idvariablesestudio>=0) {
            $this->_view->assign('_mensaje', 'variablesestudio <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
             
        } else {
           
            $this->_view->assign('_error', 'Error al actualizar el variablesestudio');
        }
    }

    public function _paginacion_listaregistros() {
        $this->_view->getLenguaje("monitoreoca_variablesestudio");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where vs.Var_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('variablesestudios', $paginador->paginar($this->_variablesestudios->getvariablesestudios($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarVariablesEstudio() {

        $this->_view->getLenguaje("monitoreoca_variablesestudio");
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where vs.Var_Nombre like '%$palabra%' ";
        $paginador = new Paginador();

        $this->_view->assign('variablesestudios', $paginador->paginar($this->_variablesestudios->getvariablesestudios($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoVariablesEstudio() {
        $this->_view->getLenguaje("monitoreoca_variablesestudio");


        $pagina = $this->getInt('pagina');
        $idvariablesestudio = $this->getInt('idvariablesestudio');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where vs.Var_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_variablesestudios->actualizarEstadovariablesestudio($idvariablesestudio, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('variablesestudios', $paginador->paginar($this->_variablesestudios->getvariablesestudios($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarVariablesEstudio() {
        $this->_view->getLenguaje("monitoreoca_variablesestudio");


        $pagina = $this->getInt('pagina');
        $idvariablesestudio = $this->getInt('idvariablesestudio');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where vs.Var_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_variablesestudios->eliminarvariablesestudio($idvariablesestudio);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('variablesestudios', $paginador->paginar($this->_variablesestudios->getvariablesestudios($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
