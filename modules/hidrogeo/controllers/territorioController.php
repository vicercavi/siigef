<?php

class territorioController extends hidrogeoController 
{
    private $_territorios;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_territorios = $this->loadModel('territorio');
    }

    public function index($Ter_IdTerritorio = 0) 
    {
        $this->_acl->acceso('listar_territorio');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Territorio');
        $this->_view->getLenguaje("hidrogeo_territorio");
        $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) 
        {
            $this->_registrarTerritorio();
        }

        if ($this->botonPress("bt_editar")) 
        {
            $this->_editarTerritorio($Ter_IdTerritorio);
        }

        if($Ter_IdTerritorio>0)
        {
            $this->_acl->acceso('editar_territorio');
            $this->_view->assign('titulo', 'Editar Territorio');
            
            
            $datos = $this->_territorios->getTerritorio($Ter_IdTerritorio);
            $this->_view->assign('datos', $datos);
            $this->_view->assign('paisesE', $this->_territorios->getPaisTerritorio());
            $this->_view->assign('denominacionesE', $this->_territorios->getDenominacionTerritorioxPais($datos[1]));
            
        }

        $paginador = new Paginador();
        $this->_view->assign('territorios', $paginador->paginar($this->_territorios->getTerritorios(), "listaregistros", "", false, 25));
        $this->_view->assign('paises', $this->_territorios->getPaisTerritorio());
        $this->_view->assign('denominaciones', $this->_territorios->getDenominacionTerritorioxPais(0));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        
        $this->_view->renderizar('index', 'territorios');
    }

    public function _filtroNuevo() 
    {
        $this->_view->getLenguaje("hidrogeo_territorio");
        $idpais = $this->getInt('idpais');
        $iddenominacion = $this->getInt('iddenominacion');

        $this->_view->assign('sl_pais', $idpais);
        $this->_view->assign('sl_denominacion', $iddenominacion);

        $this->_view->assign('paises', $this->_territorios->getPaisTerritorio());
        $this->_view->assign('denominaciones', $this->_territorios->getDenominacionTerritorioxPais($idpais));
        $this->_view->renderizar('ajax/nuevoregistro', false, true);
    }

    public function _filtroEditar() 
    {
        $this->_view->getLenguaje("hidrogeo_territorio");
        $idpais = $this->getInt('idpais');
        $iddenominacion = $this->getInt('iddenominacion');
        $nombre = $this->getSql('nombre');
        $siglas = $this->getSql('siglas');
        $estado = $this->getInt('estado');

        $this->_view->assign('sl_pais', $idpais);
        $this->_view->assign('sl_denominacion', $iddenominacion);
        $this->_view->assign('nombre', $nombre);
        $this->_view->assign('siglas', $siglas);
        $this->_view->assign('estado', $estado);
        
        $this->_view->assign('paises', $this->_territorios->getPaisTerritorio());
        $this->_view->assign('denominaciones', $this->_territorios->getDenominacionTerritorioxPais($idpais));
        $this->_view->renderizar('ajax/editarregistro', false, true);
    }

    public function _filtroBusqueda() 
    {
        $this->_view->getLenguaje("hidrogeo_territorio");
        $idpais = $this->getInt('idpais');
        $iddenominacion = $this->getInt('iddenominacion');

        $this->_view->assign('fl_pais', $idpais);
        $this->_view->assign('fl_denominacion', $iddenominacion);

        $this->_view->assign('paises', $this->_territorios->getPaisTerritorio());
        $this->_view->assign('denominaciones', $this->_territorios->getDenominacionTerritorioxPais($idpais));
        $this->_view->renderizar('ajax/filtrobusqueda', false, true);
    }

    public function editar($id = false) 
    {
        $this->_acl->acceso('editar_territorio');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar Territorio');
        $this->_view->getLenguaje("hidrogeo_territorio");
        $this->_view->setJs(array('edit'));

        if ($id) 
        {
            $id = $this->filtrarInt($id);
        }

        if ($this->botonPress("bt_guardar")) 
        {
            $this->_editarTerritorio($id);
        }

        $datos = $this->_territorios->getTerritorio($id);
        $this->_view->assign('datos', $datos);
        $this->_view->assign('paises', $this->_territorios->getPaisTerritorio());
        $this->_view->assign('denominaciones', $this->_territorios->getDenominacionTerritorioxPais($datos[1]));
        $this->_view->renderizar('edit', 'territorios');
    }

    public function _registrarTerritorio() 
    {
        $idTerritorio = $this->_territorios->registrarTerritorio(
                $this->getSql('selPais'), $this->getSql('selDenominacion'), $this->getSql('nombre'), $this->getSql('siglas'), $this->getSql('selEstado')
        );
        if (is_array($idTerritorio)) 
        {
            if ($idTerritorio[0] > 0) 
            {
                $this->_view->assign('_mensaje', 'Territorio <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al registrar el Territorio');
            }
        }
    }

    public function _editarTerritorio($id) 
    {
        $idTerritorio = $this->_territorios->actualizarTerritorio(
                $id, $this->getSql('selPais'), $this->getSql('selDenominacion'), $this->getSql('nombre'), $this->getSql('siglas'), $this->getSql('selEstado')
        );

        if ($idTerritorio >= 0) 
        {
            $this->_view->assign('_mensaje', 'Territorio <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> actualizado..!!');
        } 
        else 
        {

            $this->_view->assign('_error', 'Error al actualizar el Territorio');
        }
    }

    public function _paginacion_listaregistros() 
    {
        $this->_view->getLenguaje("hidrogeo_territorio");

        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $iddenominacion = $this->getInt('iddenominacion');
        $condicion = "";

        $condicion .= " where Ter_Nombre liKe '%$palabra%' ";

        if ($idPais > 0) 
        {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }

        if ($iddenominacion > 0) 
        {
            $condicion .= " and d.Det_IdDenomTerrit = $iddenominacion ";
        }

        $paginador = new Paginador();

        $this->_view->assign('territorios', $paginador->paginar($this->_territorios->getTerritorios($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarTerritorio() 
    {
        $this->_view->getLenguaje("hidrogeo_territorio");
        $palabra = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $iddenominacion = $this->getInt('iddenominacion');
        $condicion = "";

        $condicion .= " where Ter_Nombre liKe '%$palabra%' ";

        if ($idPais > 0) 
        {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }

        if ($iddenominacion > 0) 
        {
            $condicion .= " and d.Det_IdDenomTerrit = $iddenominacion ";
        }

        $paginador = new Paginador();

        $this->_view->assign('territorios', $paginador->paginar($this->_territorios->getTerritorios($condicion), "listaregistros", "$palabra", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoTerritorio() 
    {
        $this->_view->getLenguaje("hidrogeo_territorio");

        $pagina = $this->getInt('pagina');
        $idterritorio = $this->getInt('idterritorio');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $iddenominacion = $this->getInt('iddenominacion');
        $condicion = "";

        $condicion .= " where Ter_Nombre liKe '%$palabra%' ";

        if ($idPais > 0) {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }

        if ($iddenominacion > 0) 
        {
            $condicion .= " and d.Det_IdDenomTerrit = $iddenominacion ";
        }
        $paginador = new Paginador();
        $this->_territorios->actualizarEstadoTerritorio($idterritorio, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('territorios', $paginador->paginar($this->_territorios->getTerritorios($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _eliminarTerritorio() 
    {
        $this->_view->getLenguaje("hidrogeo_territorio");

        $pagina = $this->getInt('pagina');
        $idterritorio = $this->getInt('idterritorio');
        $palabra = $this->getSql('palabra');
        $idPais = $this->getInt('idpais');
        $iddenominacion = $this->getInt('iddenominacion');
        $condicion = "";

        $condicion .= " where Ter_Nombre liKe '%$palabra%' ";

        if ($idPais > 0) 
        {
            $condicion .= " and p.Pai_IdPais = $idPais ";
        }
        if ($iddenominacion > 0) 
        {
            $condicion .= " and d.Det_IdDenomTerrit = $iddenominacion ";
        }

        $paginador = new Paginador();
        $this->_territorios->eliminarTerritorio($idterritorio);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('territorios', $paginador->paginar($this->_territorios->getTerritorios($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
}

?>
