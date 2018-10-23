<?php

class paisController extends hidrogeoController 
{
    private $_paises;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_paises = $this->loadModel('pais');
    }

    public function index($Pai_IdPais = 0) 
    {
        $this->_acl->acceso('listar_pais');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Paises');
        $this->_view->getLenguaje("hidrogeo_pais");
        $this->_view->setJs(array('index'));

        $Pai_IdPais=$this->filtrarInt($Pai_IdPais);

        if ($this->botonPress("bt_guardar")) 
        {
            $this->_registrarPais();
        }

        if ($this->botonPress("bt_editar")) 
        {
            $this->_editarPais($Pai_IdPais);
        }

        if($Pai_IdPais>0)
        {
            $this->_acl->acceso('editar_pais');            
            $this->_view->assign('titulo', 'Editar Pais');            
            
            $this->_view->assign('datos', $this->_paises->getPais($Pai_IdPais));           
        }

        $paginador = new Paginador();
        $this->_view->assign('paises', $paginador->paginar($this->_paises->getPaises(), "listaregistros", "", false, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));

        $this->_view->renderizar('index', 'paises');
    }

    public function editar($id = false) 
    {
        $this->_acl->acceso('editar_pais');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar Pais');
        $this->_view->getLenguaje("hidrogeo_pais");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) 
        {
            $this->_editarPais($id);
        }
        
        $this->_view->assign('datos', $this->_paises->getPais($id));
        $this->_view->renderizar('edit', 'paises');
    }

    public function _registrarPais() 
    {        
        $paises=$this->_paises->getPaises("");
        
        $a=0;
        
        for ($i=0; $i < count($paises); $i++) 
        { 
                       
            if(strtolower($this->getSql('nombre'))==strtolower($paises[$i]['Pai_Nombre']))
            {
                $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> no pudo ser registrado, nombre existente');               
                $a=1;
            }

            if(trim($this->getSql('siglas'))!="")
            {
                if(strtolower($this->getSql('siglas'))==strtolower($paises[$i]['Pai_Siglas']))
                {
                    $this->_view->assign('_error', 'La sigla <b style="font-size: 1.15em;">' . $this->getSql('siglas') . '</b> no pudo ser registrado, sigla existente');               
                    $a=2;
                }
            }
                      
        }

        if($a==0)
        {      
            $idPais = $this->_paises->registrarPais($this->getSql('nombre'),$this->getSql('siglas'),$this->getSql('selEstado'));   
            if ($idPais[0] > 0) 
            {
                $this->_view->assign('_mensaje', 'Rio <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al registrar el Rio');
            }                     
        }
    }

    public function _editarPais($id) 
    {        
        $paises=$this->_paises->getPaises("WHERE Pai_IdPais!=$id");
        
        $a=0;
        
        for ($i=0; $i < count($paises); $i++) 
        {                       
            if(strtolower($this->getSql('nombre'))==strtolower($paises[$i]['Pai_Nombre']))
            {
                $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> no pudo ser editado, nombre existente');               
                $a=1;
            }

            if(trim($this->getSql('siglas'))!="")
            {
                if(strtolower($this->getSql('siglas'))==strtolower($paises[$i]['Pai_Siglas']))
                {
                    $this->_view->assign('_error', 'La sigla <b style="font-size: 1.15em;">' . $this->getSql('siglas') . '</b> no pudo ser editado, sigla existente');               
                    $a=2;
                }
            }           
        }

        if($a==0)
        {      
            $idPais = $this->_paises->actualizarPais($id, $this->getSql('nombre'),$this->getSql('siglas'),$this->getSql('selEstado'));

            if ($idPais[0] >= 0) 
            {
                $this->_view->assign('_mensaje', 'País <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al actualizar el Pais');
            }                     
        } 
    }

    public function _paginacion_listaregistros() 
    {
        $this->_view->getLenguaje("hidrogeo_pais");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Pai_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('paises', $paginador->paginar($this->_paises->getPaises($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarPais() 
    {
        $this->_view->getLenguaje("hidrogeo_pais");
        
        $nombre = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Pai_Nombre liKe '%$nombre%' ";

        $paginador = new Paginador();

        $this->_view->assign('paises', $paginador->paginar($this->_paises->getPaises($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoPais() 
    {
        $this->_view->getLenguaje("hidrogeo_pais");

        $pagina = $this->getInt('pagina');
        $idpais = $this->getInt('idpais');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $condicion = "";

        $condicion .= " where Pai_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_paises->actualizarEstadoPais($idpais, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('paises', $paginador->paginar($this->_paises->getPaises($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarPais() 
    {
        $this->_view->getLenguaje("hidrogeo_pais");

        $pagina = $this->getInt('pagina');
        $idpais = $this->getInt('idpais');
        $palabra = $this->getSql('palabra');

        $condicion = "";

        $condicion .= " where Pai_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();
        $this->_paises->eliminarPais($idpais);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('paises', $paginador->paginar($this->_paises->getPaises($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
}

?>
