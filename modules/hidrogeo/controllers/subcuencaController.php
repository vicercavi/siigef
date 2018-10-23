<?php

class subcuencaController extends hidrogeoController 
{
    private $_subcuencas;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_subcuencas = $this->loadModel('subcuenca');
    }

    public function index($Suc_IdSubcuenca=0) 
    {
        $this->_acl->acceso('listar_subcuenca');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Subcuencas');
        $this->_view->getLenguaje("hidrogeo_subcuenca");
        $this->_view->setJs(array('index'));

        $Suc_IdSubcuenca=$this->filtrarInt($Suc_IdSubcuenca);

        if ($this->botonPress("bt_guardar")) 
        {
            $this->_registrarSubcuenca();
        }

        if ($this->botonPress("bt_editar")) 
        {
            $this->_editarSubcuenca($Suc_IdSubcuenca);
        }

        if($Suc_IdSubcuenca>0)
        {
            $this->_acl->acceso('editar_subcuenca');
            $this->_view->assign('titulo', 'Editar Sub Cuenca');
            $this->_view->assign('datos', $this->_subcuencas->getSubcuenca($Suc_IdSubcuenca));                      
        }

        $paginador = new Paginador();
        $this->_view->assign('subcuencas', $paginador->paginar($this->_subcuencas->getSubcuencas(), "listaregistros", "", false, 25));
        $this->_view->assign('cuencas', $this->_subcuencas->getCuencas());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('index', 'subcuencas');       
    }

    public function editar($id = false) 
    {
        $this->_acl->acceso('editar_subcuenca');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar Subcuenca');
        $this->_view->getLenguaje("hidrogeo_subcuenca");
        $this->_view->setJs(array('index'));

        if ($id) 
        {
            $id = $this->filtrarInt($id);
        }

        if ($this->botonPress("bt_guardar")) 
        {
            $this->_editarSubcuenca($id);
        }

        $this->_view->assign('datos', $this->_subcuencas->getSubcuenca($id));
        $this->_view->assign('cuencas', $this->_subcuencas->getCuencas());
        $this->_view->renderizar('edit', 'subcuencas');
    }

    public function _registrarSubcuenca() 
    {
        $subcuencas=$this->_subcuencas->getSubcuencas("");

        $a=0;
        
        for ($i=0; $i < count($subcuencas); $i++) 
        {                        
            if(strtolower($this->getSql('nombre'))==strtolower($subcuencas[$i]['Suc_Nombre']))
            {
                $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> no pudo ser registrado, nombre existente');               
                $a=1;
            }            
        }

        if($a==0)
        {      
            $idSubcuenca = $this->_subcuencas->registrarSubcuenca($this->getSql('nombre'), $this->getSql('selEstado'), $this->getSql('selCuenca'));  

            if ($idSubcuenca[0] > 0) 
            {
                $this->_view->assign('_mensaje', 'Subcuenca <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al registrar la subcuenca');
            }                     
        }
    }

    public function _editarSubcuenca($id) 
    {
        $subcuencas=$this->_subcuencas->getSubcuencas("WHERE Suc_IdSubcuenca!=$id");

        $a=0;
        
        for ($i=0; $i < count($subcuencas); $i++) 
        {                       
            if(strtolower($this->getSql('nombre'))==strtolower($subcuencas[$i]['Suc_Nombre']))
            {
                $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> no pudo ser registrado, nombre existente');               
                $a=1;
            }            
        }

        if($a==0)
        {      
            $idSubcuenca = $this->_subcuencas->actualizarSubcuenca($id, $this->getSql('nombre'), $this->getSql('selEstado'),$this->getSql('selCuenca'));

            if ($idSubcuenca[0] >= 0) 
            {
                $this->_view->assign('_mensaje', 'Subcuenca <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> actualizado..!!');
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al editar la subcuenca');
            }                     
        }
    }

    public function _paginacion_listaregistros() 
    {
        $this->_view->getLenguaje("hidrogeo_subcuenca");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $idcuenca = $this->getSql('idcuenca');
        $condicion = "";

        $condicion .= " where Suc_Nombre liKe '%$nombre%' ";

        if ($idcuenca > 0) 
        {
            $condicion .= " and c.Cue_IdCuenca = $idcuenca ";
        }

        $paginador = new Paginador();

        $this->_view->assign('subcuencas', $paginador->paginar($this->_subcuencas->getSubcuencas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarSubcuenca() 
    {        
        $this->_view->getLenguaje("hidrogeo_subcuenca");

        $nombre = $this->getSql('palabra');
        $idcuenca = $this->getSql('idcuenca');
        $condicion = "";

        $condicion .= " where Suc_Nombre liKe '%$nombre%' ";

        if ($idcuenca > 0) 
        {
            $condicion .= " and c.Cue_IdCuenca = $idcuenca ";
        }

        $paginador = new Paginador();

        $this->_view->assign('subcuencas', $paginador->paginar($this->_subcuencas->getSubcuencas($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoSubcuenca() 
    {
        $this->_view->getLenguaje("hidrogeo_subcuenca");

        $pagina = $this->getInt('pagina');
        $idsubcuenca = $this->getInt('idsubcuenca');
        $estado = $this->getInt('estado');
        $nombre = $this->getSql('palabra');
        $idcuenca = $this->getSql('idcuenca');
        $condicion = "";

        $condicion .= " where Suc_Nombre liKe '%$nombre%' ";

        if ($idcuenca > 0) 
        {
            $condicion .= " and c.Cue_IdCuenca = $idcuenca ";
        }

        $paginador = new Paginador();
        $this->_subcuencas->actualizarEstadoSubcuenca($idsubcuenca, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('subcuencas', $paginador->paginar($this->_subcuencas->getSubcuencas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _eliminarSubcuenca() 
    {       
        $this->_view->getLenguaje("hidrogeo_subcuenca");

        $pagina = $this->getInt('pagina');
        $idsubcuenca = $this->getInt('idsubcuenca');
        $nombre = $this->getSql('palabra');
        $idcuenca = $this->getSql('idcuenca');
        $condicion = "";

        $condicion .= " where Suc_Nombre liKe '%$nombre%' ";

        if ($idcuenca > 0) 
        {
            $condicion .= " and c.Cue_IdCuenca = $idcuenca ";
        }

        $paginador = new Paginador();
        $this->_subcuencas->eliminarSubcuenca($idsubcuenca);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('subcuencas', $paginador->paginar($this->_subcuencas->getSubcuencas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
}

?>
