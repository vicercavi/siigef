<?php

class denominacionterritorioController extends hidrogeoController 
{
    private $_denominacionterritorios;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_denominacionterritorios = $this->loadModel('denominacionterritorio');
    }

    public function index($Det_IdDenomTerrit = 0) 
    {
        $this->_acl->acceso('listar_denominacionterritorio');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Denominacion Territorial');
        $this->_view->getLenguaje("hidrogeo_denominacionterritorio");
        $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) 
        {
            $this->_registrarDenominacionTerritorio();
        }

        if ($this->botonPress("bt_editar")) 
        {
            $this->_editarDenominacionTerritorio($Det_IdDenomTerrit);
        }

        if($Det_IdDenomTerrit>0)
        {
            $this->_acl->acceso('editar_denominacionterritorio');            
            $this->_view->assign('titulo', 'Editar Estado|Territorio');            
            
            $this->_view->assign('datos', $this->_denominacionterritorios->getDenominacionTerritorio($Det_IdDenomTerrit));
            $this->_view->assign('paisesE', $this->_denominacionterritorios->getPaisDenominacionTerritorio());            
        }

        $paginador = new Paginador();
        $this->_view->assign('denominacionterritorios', $paginador->paginar($this->_denominacionterritorios->getDenominacionTerritorios(), "listaregistros", "", false, 25));
        $this->_view->assign('paises', $this->_denominacionterritorios->getPaisDenominacionTerritorio());

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        
        $this->_view->renderizar('index', 'denominacionterritorios');
    }

    public function editar($id = false) 
    {
        $this->_acl->acceso('editar_denominacionterritorio');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar Estado|Territorio');
        $this->_view->getLenguaje("hidrogeo_denominacionterritorio");
        $this->_view->setJs(array('index'));
        
        if($id)
        {
            $id = $this->filtrarInt($id);
        }
        
        if ($this->botonPress("bt_guardar")) 
        {
            $this->_editarDenominacionTerritorio($id);
        }
        
        $this->_view->assign('datos', $this->_denominacionterritorios->getDenominacionTerritorio($id));
        $this->_view->assign('paises', $this->_denominacionterritorios->getPaisDenominacionTerritorio());
        $this->_view->renderizar('edit', 'denominacionterritorios');
    }

    public function _registrarDenominacionTerritorio() 
    {        
        $idDenominacionTerritorio = $this->_denominacionterritorios->registrarDenominacionTerritorio(
                $this->getSql('nombre'), $this->getSql('nivel'), $this->getSql('selPais'), $this->getSql('selEstado')
        );
        if (is_array($idDenominacionTerritorio)) 
        {
            if ($idDenominacionTerritorio[0] > 0) 
            {
                $this->_view->assign('_mensaje', 'Denominacion <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al registrar la Denominacion');
            }
        }
    }

    public function _editarDenominacionTerritorio($id) 
    {   
        $idDenominacionTerritorio = $this->_denominacionterritorios->actualizarDenominacionTerritorio(
                $id,  $this->getSql('nombre'), $this->getSql('nivel'), $this->getSql('selPais'), $this->getSql('selEstado')
        );

        if ($idDenominacionTerritorio>=0) 
        {
            $this->_view->assign('_mensaje', 'Denominacion <b style="font-size: 1.15em;">'. $this->getSql('nombre') . '</b> actualizado..!!');
             
        } 
        else 
        {
           
            $this->_view->assign('_error', 'Error al actualizar la Denominacion');
        }
    }

    public function _paginacion_listaregistros() 
    {
        $this->_view->getLenguaje("hidrogeo_denominacionterritorio");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $condicion = "";

        $condicion .= " where Det_Nombre liKe '%$nombre%' ";

        if ($idPais > 0) 
        {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }

        $paginador = new Paginador();

        $this->_view->assign('denominacionterritorios', $paginador->paginar($this->_denominacionterritorios->getDenominacionTerritorios($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarDenominacionTerritorio() 
    {
        $this->_view->getLenguaje("hidrogeo_denominacionterritorio");
        $nombre = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $condicion = "";

        $condicion .= " where Det_Nombre liKe '%$nombre%' ";

        if ($idPais > 0) 
        {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }
        $paginador = new Paginador();

        $this->_view->assign('denominacionterritorios', $paginador->paginar($this->_denominacionterritorios->getDenominacionTerritorios($condicion), "listaregistros", "$nombre", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoDenominacionTerritorio() 
    {
        $this->_view->getLenguaje("hidrogeo_denominacionterritorio");

        $pagina = $this->getInt('pagina');
        $iddenominacionterritorio = $this->getInt('iddenominacionterritorio');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');

        $condicion = "";

        $condicion .= " where Det_Nombre liKe '%$palabra%' ";
        if ($idPais > 0) 
        {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }

        $paginador = new Paginador();
        $this->_denominacionterritorios->actualizarEstadoDenominacionTerritorio($iddenominacionterritorio, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('denominacionterritorios', $paginador->paginar($this->_denominacionterritorios->getDenominacionTerritorios($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _eliminarDenominacionTerritorio() 
    {
        $this->_view->getLenguaje("hidrogeo_denominacionterritorio");

        $pagina = $this->getInt('pagina');
        $iddenominacionterritorio = $this->getInt('iddenominacionterritorio');
        $palabra = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');

        $condicion = "";

        $condicion .= " where Det_Nombre liKe '%$palabra%' ";

        if ($idPais > 0) 
        {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }

        $paginador = new Paginador();
        $this->_denominacionterritorios->eliminarDenominacionTerritorio($iddenominacionterritorio);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('denominacionterritorios', $paginador->paginar($this->_denominacionterritorios->getDenominacionTerritorios($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
}

?>
