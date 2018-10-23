<?php

class cuencaController extends hidrogeoController 
{
    private $_cuencas;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_cuencas = $this->loadModel('cuenca');
    }

    public function index($Cue_IdCuenca=0) 
    {
        $this->_acl->acceso('listar_cuenca');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Cuencas');
        $this->_view->getLenguaje("hidrogeo_cuenca");
        $this->_view->setJs(array('index'));

        $Cue_IdCuenca=$this->filtrarInt($Cue_IdCuenca);

        if ($this->botonPress("bt_guardar")) 
        {
            $this->_registrarCuenca();
        }

        if($this->botonPress("bt_editar"))
        {
            $this->_editarCuenca($Cue_IdCuenca);
        }

        if($Cue_IdCuenca>0)
        {
            $this->_acl->acceso('editar_cuenca');
            $this->_view->assign('titulo', 'Editar Cuenca');
            $this->_view->assign('datos', $this->_cuencas->getCuenca($Cue_IdCuenca));                      
        }

        $paginador = new Paginador();
        $this->_view->assign('cuencas', $paginador->paginar($this->_cuencas->getCuencas(), "listaregistros", "", false, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));        
        $this->_view->renderizar('index', 'cuencas');
    }

    public function editar($id = false) 
    {
        $this->_acl->acceso('editar_cuenca');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar Cuenca');
        $this->_view->getLenguaje("hidrogeo_cuenca");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) 
        {
            $this->_editarCuenca($id);
        }
        
        $this->_view->assign('datos', $this->_cuencas->getCuenca($id));
        $this->_view->renderizar('edit', 'cuencas');
    }

    public function _registrarCuenca() 
    {        
        $cuencas=$this->_cuencas->getCuencas("");

        $a=0;
        
        for ($i=0; $i < count($cuencas); $i++) 
        {                       
            if(strtolower($this->getSql('nombre'))==strtolower($cuencas[$i]['Cue_Nombre']))
            {
                $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> no pudo ser registrado, nombre existente');               
                $a=1;
            }            
        }

        if($a==0)
        {      
            $idCuenca = $this->_cuencas->registrarCuenca($this->getSql('nombre'),$this->getPostParam('selEstado'));   

            if ($idCuenca[0] > 0) 
            {
                $this->_view->assign('_mensaje', 'Cuenca <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al registrar la cuenca');
            }                     
        }
    }

    public function _editarCuenca($id) 
    {   
        $cuencas=$this->_cuencas->getCuencas("WHERE Cue_IdCuenca!=$id");
        
        $a=0;
        
        for ($i=0; $i < count($cuencas); $i++) 
        {                       
            if(strtolower($this->getSql('nombre'))==strtolower($cuencas[$i]['Cue_Nombre']))
            {
                $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> no pudo ser editado, nombre existente');               
                $a=1;
            }            
        }

        if($a==0)
        {      
            $idCuenca = $this->_cuencas->actualizarCuenca($id, $this->getSql('nombre'), $this->getPostParam('selEstado'));   

            if ($idCuenca[0] >= 0) 
            {
                $this->_view->assign('_mensaje', 'Cuenca <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> actualizado..!!');
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al actualizar el Cuenca');
            }                     
        }  
    }

    public function _paginacion_listaregistros() 
    {
        $this->_view->getLenguaje("hidrogeo_cuenca");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Cue_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('cuencas', $paginador->paginar($this->_cuencas->getCuencas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarCuenca() 
    {
        $this->_view->getLenguaje("hidrogeo_cuenca");
        
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Cue_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('cuencas', $paginador->paginar($this->_cuencas->getCuencas($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoCuenca() 
    {
        $this->_view->getLenguaje("hidrogeo_cuenca");

        $pagina = $this->getInt('pagina');
        $idcuenca = $this->getInt('idcuenca');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Cue_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_cuencas->actualizarEstadoCuenca($idcuenca, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('cuencas', $paginador->paginar($this->_cuencas->getCuencas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarCuenca() 
    {
        $this->_view->getLenguaje("hidrogeo_cuenca");

        $pagina = $this->getInt('pagina');
        $idcuenca = $this->getInt('idcuenca');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where Cue_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_cuencas->eliminarCuenca($idcuenca);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('cuencas', $paginador->paginar($this->_cuencas->getCuencas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); 
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

}

?>
