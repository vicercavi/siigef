<?php

class riocuencaController extends hidrogeoController 
{
    private $_riocuencas;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_riocuencas = $this->loadModel('riocuenca');
    }

    public function index($Ric_IdRioCuenca = 0) 
    {
        $this->_acl->acceso('listar_riocuenca');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Rio/Cuenca');
        $this->_view->getLenguaje("hidrogeo_riocuenca");
        $this->_view->setJs(array('index'));

        if ($this->botonPress("bt_guardar")) 
        {
            $this->_registrarRiocuenca();
        }

        if ($this->botonPress("bt_editar")) 
        {
            $this->_editarRiocuenca($Ric_IdRioCuenca);
        }

        if($Ric_IdRioCuenca>0)
        {
            $this->_acl->acceso('editar_riocuenca');
            $this->_view->assign('titulo', 'Editar Riocuenca');
            
            $this->_view->assign('datos', $this->_riocuencas->getRiocuenca($Ric_IdRioCuenca));
            $this->_view->assign('rios', $this->_riocuencas->getRios(""));
            $this->_view->assign('subcuencas', $this->_riocuencas->getSubcuencas(""));
            $this->_view->assign('cuencas', $this->_riocuencas->getCuencas(""));
            //$this->_view->renderizar('edit', 'riocuencas');
        }

        $nombre = $this->getSql('palabra');
        $idsubcuenca = $this->getSql('buscarSubcuenca');
        $idcuenca = $this->getSql('buscarCuenca');
        $condicion = "";

        $condicion .= " where r.Rio_Nombre liKe '%$nombre%' ";

        if ($idsubcuenca > 0) 
        {
            $condicion .= " and rc.Suc_IdSubcuenca = $idsubcuenca ";
        }

        if ($idcuenca > 0) 
        {
            $condicion .= " and rc.Cue_IdCuenca = $idcuenca ";
        }

        $paginador = new Paginador();

        //Filtrar rios cuencas
        //$this->_view->assign('cuencaXrio', $this->_riocuencas->getRiocuencas(""))
        $this->_view->assign('riocuencas', $paginador->paginar($this->_riocuencas->getRiocuencas($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('rios', $this->_riocuencas->getRios(""));
        $this->_view->assign('subcuencas', $this->_riocuencas->getSubcuencas(""));
        $this->_view->assign('cuencas', $this->_riocuencas->getCuencas(""));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        //if ($PermisoVacio) {
        //    $this->_view->assign('_error', 'Error al editar Debe agregar permisos al item');
        //}
        $this->_view->renderizar('index', 'riocuencas');
    }

    public function editar($id = false) 
    {
        $this->_acl->acceso('editar_riocuenca');
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Editar Riocuenca');
        $this->_view->getLenguaje("hidrogeo_riocuenca");
        $this->_view->setJs(array('index'));

        if ($id) 
        {
            $id = $this->filtrarInt($id);
        }

        if ($this->botonPress("bt_guardar")) 
        {
            $this->_editarRiocuenca($id);
        }

        $this->_view->assign('datos', $this->_riocuencas->getRiocuenca($id));
        $this->_view->assign('rios', $this->_riocuencas->getRios(""));
        $this->_view->assign('subcuencas', $this->_riocuencas->getSubcuencas(""));
        $this->_view->assign('cuencas', $this->_riocuencas->getCuencas(""));
        $this->_view->renderizar('edit', 'riocuencas');
    }

    public function _registrarRiocuenca() 
    {
        $idRiocuenca = $this->_riocuencas->registrarRiocuenca(
                $this->getSql('nombre'), $this->getSql('selEstado'), $this->getSql('selSubcuenca'), $this->getSql('selCuenca'), $this->getSql('selRio')
        );

        if (is_array($idRiocuenca)) 
        {
            if ($idRiocuenca[0] > 0) 
            {
                $this->_view->assign('_mensaje', 'Item <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> registrado..!!');
            } 
            else
            {
                $this->_view->assign('_error', 'Error al registrar el item');
            }
        }
    }

    public function _editarRiocuenca($id) 
    {
        $idRiocuenca = $this->_riocuencas->actualizarRiocuenca(
                $id, $this->getSql('nombre'), $this->getSql('selEstado'), $this->getSql('selSubcuenca'), $this->getSql('selCuenca'), $this->getSql('selRio')
        );

        if ($idRiocuenca >= 0) 
        {
            $this->_view->assign('_mensaje', 'Asignaciónn <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> actualizado..!!');
        } 
        else 
        {

            $this->_view->assign('_error', 'Error al actualizar la asignacion');
        }
    }

    public function _paginacion_listaregistros() 
    {
        $this->_view->getLenguaje("hidrogeo_riocuenca");

        $pagina = $this->getInt('pagina');
        $nombre = $this->getSql('palabra');
        $idsubcuenca = $this->getInt('idsubcuenca');
        $idcuenca = $this->getInt('idcuenca');
        $condicion = "";

        $condicion .= " where r.Rio_Nombre liKe '%$nombre%' ";
        
        if ($idcuenca > 0) 
        {
            $condicion .= " and rc.Cue_IdCuenca = $idcuenca ";
        }

        if ($idsubcuenca > 0) 
        {
            $condicion .= " and rc.Suc_IdSubcuenca = $idsubcuenca ";
        }
        //echo $idcuenca; exit();
        $paginador = new Paginador();

        $this->_view->assign('riocuencas', $paginador->paginar($this->_riocuencas->getRiocuencas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _buscarRiocuenca() 
    {
        $this->_view->getLenguaje("hidrogeo_riocuenca");

        $nombre = $this->getSql('palabra');
        $idsubcuenca = $this->getInt('idsubcuenca');
        $idcuenca = $this->getInt('idcuenca');
        $condicion = "";

        $condicion .= " where r.Rio_Nombre liKe '%$nombre%' ";
        
        if ($idcuenca > 0) 
        {
            $condicion .= " and rc.Cue_IdCuenca = $idcuenca ";
        }

        if ($idsubcuenca > 0) 
        {
            $condicion .= " and rc.Suc_IdSubcuenca = $idsubcuenca ";
        }

        $paginador = new Paginador();

        $this->_view->assign('riocuencas', $paginador->paginar($this->_riocuencas->getRiocuencas($condicion), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoRiocuenca() 
    {
        $this->_view->getLenguaje("hidrogeo_riocuenca");

        $pagina = $this->getInt('pagina');
        $idriocuenca = $this->getInt('idriocuenca');
        $estado = $this->getInt('estado');
        $nombre = $this->getSql('palabra');
        $idsubcuenca = $this->getSql('idsubcuenca');
        $idcuenca = $this->getSql('idcuenca');
        $condicion = "";

        $condicion .= " where r.Rio_Nombre liKe '%$nombre%' ";

        if ($idcuenca > 0) 
        {
            $condicion .= " and rc.Cue_IdCuenca = $idcuenca ";
        }

        if ($idsubcuenca > 0) 
        {
            $condicion .= " and rc.Suc_IdSubcuenca = $idsubcuenca ";
        }
        
        $paginador = new Paginador();
        $this->_riocuencas->actualizarEstadoRiocuenca($idriocuenca, $estado);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('riocuencas', $paginador->paginar($this->_riocuencas->getRiocuencas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _eliminarRiocuenca() 
    {
        $this->_view->getLenguaje("hidrogeo_riocuenca");

        $pagina = $this->getInt('pagina');
        $idriocuenca = $this->getInt('idriocuenca');
        $nombre = $this->getSql('palabra');
        $idsubcuenca = $this->getSql('idsubcuenca');
        $idcuenca = $this->getSql('idcuenca');
        $condicion = "";

        $condicion .= " where r.Rio_Nombre liKe '%$nombre%' ";

        if ($idsubcuenca > 0) 
        {
            $condicion .= " and rc.Suc_IdSubcuenca = $idsubcuenca ";
        }

        if ($idcuenca > 0) 
        {
            $condicion .= " and rc.Cue_IdCuenca = $idcuenca ";
        }

        $paginador = new Paginador();
        $this->_riocuencas->eliminarRiocuenca($idriocuenca);

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('riocuencas', $paginador->paginar($this->_riocuencas->getRiocuencas($condicion), "listaregistros", "", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion()); //para agregar paginacion ejem. 1 de 2 ver ejemplo en formulario recurso
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

     //Filtros 
    public function _filtroSubcuenca() 
    {        
        $this->_view->getLenguaje("hidrogeo_riocuenca");
        $id_cuenca = $this->getInt('cuenca');

        if($id_cuenca>0)
        {
            $condicion_subcuenca="WHERE Cue_IdCuenca=$id_cuenca";
        }
        else
        {
            $condicion_subcuenca="";
        }
        
        $this->_view->assign('subcuencas', $this->_riocuencas->getSubcuencas($condicion_subcuenca));      
        $this->_view->renderizar('ajax/lista_subcuenca', false, true);
    }


}

?>
