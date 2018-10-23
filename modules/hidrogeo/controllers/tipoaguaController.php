<?php

class tipoaguaController extends hidrogeoController 
{
    private $_tipoaguas;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_tipoaguas = $this->loadModel('tipoagua');
    }

    public function index($Tia_IdTipoAgua=0) 
    {
        $this->_acl->acceso('listar_tipoagua');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Tipoaguas');
        $this->_view->getLenguaje("hidrogeo_tipoagua");
        $this->_view->setJs(array('index'));

        $Tia_IdTipoAgua=$this->filtrarInt($Tia_IdTipoAgua);

        if ($this->botonPress("bt_guardar")) 
        {
            $this->_registrarTipoagua();
        }

        if ($this->botonPress("bt_editar")) 
        {
            $this->_editarTipoagua($Tia_IdTipoAgua);
        }

        if($Tia_IdTipoAgua>0)
        {
            $this->_acl->acceso('editar_tipoagua');
            
            $this->_view->assign('titulo', 'Editar Tipoagua');
           
            $this->_view->assign('datos', $this->_tipoaguas->getTipoagua($Tia_IdTipoAgua));
            //$this->_view->renderizar('edit', 'tipoaguas');                      
        }

        $paginador = new Paginador();
        $this->_view->assign('tipoaguas', $paginador->paginar($this->_tipoaguas->getTipoaguas(), "listaregistros", "", false, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        
        $this->_view->renderizar('index', 'tipoaguas');
    }

    /*public function editar($id = false) {
        $this->_acl->acceso('editar_tipoagua');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar Tipoagua');
        $this->_view->getLenguaje("hidrogeo_tipoagua");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) {
            $this->_editarTipoagua($id);
        }
        
        $this->_view->assign('datos', $this->_tipoaguas->getTipoagua($id));
        $this->_view->renderizar('edit', 'tipoaguas');
    }*/

    public function _registrarTipoagua() 
    {        
        $tipoaguas=$this->_tipoaguas->getTipoaguas("");

        $a=0;
        
        for ($i=0; $i < count($tipoaguas); $i++) 
        {                        
            if(strtolower($this->getSql('nombre'))==strtolower($tipoaguas[$i]['Tia_Nombre']))
            {
                $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> no pudo ser registrado, nombre existente');               
                $a=1;
            }            
        }
        
        if($a==0)
        {      
            $idTipoagua = $this->_tipoaguas->registrarTipoagua($this->getSql('nombre'), $this->getSql('descripcion'), $this->getSql('color'), $this->getPostParam('selEstado'));  

            if ($idTipoagua[0] > 0) 
            {
                $this->_view->assign('_mensaje', 'Tipo Agua <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al registrar el tipo de agua');
            }                     
        }
    }

    public function _editarTipoagua($id) 
    {        
        $tipoaguas=$this->_tipoaguas->getTipoaguas("WHERE Tia_IdTipoAgua!=$id");

        $a=0;
        
        for ($i=0; $i < count($tipoaguas); $i++) 
        {                       
            if(strtolower($this->getSql('nombre'))==strtolower($tipoaguas[$i]['Tia_Nombre']))
            {
                $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> no pudo ser editado, nombre existente');               
                $a=1;
            }            
        }

        if($a==0)
        {
            $idTipoagua = $this->_tipoaguas->actualizarTipoagua($id,  $this->getSql('nombre'),$this->getSql('descripcion'),$this->getSql('color'), $this->getPostParam('selEstado'));

            if ($idTipoagua[0] >= 0) 
            {
                $this->_view->assign('_mensaje', 'Tipo Agua <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al actualizar Tipo de agua');
            }                     
        }                
    }

    public function _paginacion_listaregistros() 
    {
        $this->_view->getLenguaje("hidrogeo_tipoagua");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Tia_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('tipoaguas', $paginador->paginar($this->_tipoaguas->getTipoaguas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarTipoagua() 
    {
        $this->_view->getLenguaje("hidrogeo_tipoagua");
        
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Tia_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('tipoaguas', $paginador->paginar($this->_tipoaguas->getTipoaguas($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoTipoagua() 
    {
        $this->_view->getLenguaje("hidrogeo_tipoagua");

        $pagina = $this->getInt('pagina');
        $idtipoagua = $this->getInt('idtipoagua');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Tia_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_tipoaguas->actualizarEstadoTipoagua($idtipoagua, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('tipoaguas', $paginador->paginar($this->_tipoaguas->getTipoaguas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarTipoagua() 
    {
        $this->_view->getLenguaje("hidrogeo_tipoagua");

        $pagina = $this->getInt('pagina');
        $idtipoagua = $this->getInt('idtipoagua');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where Tia_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        
        $this->_tipoaguas->eliminarTipoagua($idtipoagua);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('tipoaguas', $paginador->paginar($this->_tipoaguas->getTipoaguas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
