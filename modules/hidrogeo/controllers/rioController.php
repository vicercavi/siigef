<?php

class rioController extends hidrogeoController 
{
    private $_rios;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_rios = $this->loadModel('rio');
    }

    public function index($Rio_IdRio = 0) 
    {
        $this->_acl->acceso('listar_rio');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Rios');
        $this->_view->getLenguaje("hidrogeo_rio");
        $this->_view->setJs(array('index'));

        $Rio_IdRio=$this->filtrarInt($Rio_IdRio);

        if ($this->botonPress("bt_guardar")) 
        {
            $this->_registrarRio();
        }

        if($this->botonPress("bt_editar"))
        {
            $this->_editarRio($Rio_IdRio);
        }
        
        if($Rio_IdRio>0)
        {
            $this->_acl->acceso('editar_rio');
            $this->_view->assign('titulo', 'Editar Rio');

            $this->_view->assign('datos', $this->_rios->getRio($Rio_IdRio));
            $this->_view->assign('paises', $this->_rios->getPaisRio());
            $this->_view->assign('tipos_agua', $this->_rios->getTipoAgua());                    
        }

        $paginador = new Paginador();
        
        $this->_view->assign('rios', $paginador->paginar($this->_rios->getRios(), "listaregistros", "", false, 25));
        $this->_view->assign('paises', $this->_rios->getPaisRio());
        $this->_view->assign('tipos_agua', $this->_rios->getTipoAgua());

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        /*if ($PermisoVacio) {
            $this->_view->assign('_error', 'Error al editar Debe agregar permisos al Rio');
        }*/
        $this->_view->renderizar('index', 'rios');
    }

    public function _registrarRio() 
    {
        $rios=$this->_rios->getRios("");
        
        $a=0;
        
        for ($i=0; $i < count($rios); $i++) 
        {                       
            if(strtolower($this->getSql('nombre'))==strtolower($rios[$i]['Rio_Nombre']))
            {
                $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> no pudo ser registrado, nombre existente');               
                $a=1;
            }            
        }

        if($a==0)
        {      
            $idRio = $this->_rios->registrarRio($this->getSql('nombre'),$this->getSql('selEstado'), $this->getSql('selPais'), $this->getSql('selTipoAgua'));      
            if ($idRio[0] > 0) 
            {
                $this->_view->assign('_mensaje', 'Rio <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al registrar el Rio');
            }                     
        } 
    }

    public function _editarRio($id) 
    {        
        $rios=$this->_rios->getRios("WHERE Rio_IdRio!=$id");
        $a=0;
        
        for ($i=0; $i < count($rios); $i++) 
        {                       
            if(strtolower($this->getSql('nombre'))==strtolower($rios[$i]['Rio_Nombre']))
            {
                $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> no pudo ser editado, nombre existente');               
                $a=1;
            }            
        }

        if($a==0)
        {      
            $idRio = $this->_rios->actualizarRio($id, $this->getSql('nombre'), $this->getSql('selEstado'), $this->getSql('selPais'), $this->getSql('selTipoAgua')); 

            if ($idRio[0] >= 0) 
            {
                $this->_view->assign('_mensaje', 'Rio <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al actualizar el Rio');
            }                     
        }         
    }

    public function _paginacion_listaregistros() 
    {
        $this->_view->getLenguaje("hidrogeo_rio");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $idtipo_agua = $this->getInt('idtipo_agua');
        $condicion = "";

        $condicion .= " where Rio_Nombre liKe '%$nombre%' ";

        if ($idPais > 0) 
        {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }
        if ($idtipo_agua > 0) 
        {
            $condicion .= " and t.Tia_IdTipoAgua = $idtipo_agua ";
        }

        $paginador = new Paginador();

        $this->_view->assign('rios', $paginador->paginar($this->_rios->getRios($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarRio() 
    {
        $this->_view->getLenguaje("hidrogeo_rio");
        $nombre = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $idtipo_agua = $this->getInt('idtipo_agua');
        $condicion = "";

        $condicion .= " where Rio_Nombre liKe '%$nombre%' ";

        if ($idPais > 0) 
        {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }
        if ($idtipo_agua > 0)
        {
            $condicion .= " and t.Tia_IdTipoAgua = $idtipo_agua ";
        }

        $paginador = new Paginador();

        $this->_view->assign('rios', $paginador->paginar($this->_rios->getRios($condicion), "listaregistros", "$nombre", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoRio() 
    {
        $this->_view->getLenguaje("hidrogeo_rio");

        $pagina = $this->getInt('pagina');
        $idrio = $this->getInt('idrio');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $idtipo_agua = $this->getInt('idtipo_agua');

        $condicion = "";

        $condicion .= " where Rio_Nombre liKe '%$palabra%' ";

        if ($idPais > 0) 
        {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }

        if ($idtipo_agua > 0) 
        {
            $condicion .= " and t.Tia_IdTipoAgua = $idtipo_agua ";
        }

        $paginador = new Paginador();
        $this->_rios->actualizarEstadoRio($idrio, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('rios', $paginador->paginar($this->_rios->getRios($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarRio() 
    {
        $this->_view->getLenguaje("hidrogeo_rio");

        $pagina = $this->getInt('pagina');
        $idrio = $this->getInt('idrio');
        $palabra = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $idtipo_agua = $this->getInt('idtipo_agua');

        $condicion = "";

        $condicion .= " where Rio_Nombre liKe '%$palabra%' ";
        
        if ($idPais > 0) 
        {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }
        if ($idtipo_agua > 0) 
        {
            $condicion .= " and t.Tia_IdTipoAgua = $idtipo_agua ";
        }

        $paginador = new Paginador();
        $this->_rios->eliminarRio($idrio);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('rios', $paginador->paginar($this->_rios->getRios($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
}

?>
