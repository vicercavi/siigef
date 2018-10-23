<?php

class editarController extends Controller {

    private $_dar;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_dar_editar = $this->loadModel('editar');
        $this->_dar = $this->loadModel('registrar');
        $this->_bdarwin = $this->loadModel('biodiversidad',true);
    }

    public function index($recurso = false) {
        $this->_acl->acceso("editar_registros_recurso");
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('registrardarwincore'));
        $this->_view->getLenguaje("bdrecursos_metadata");
        $idioma = Cookie::lenguaje();
        $e = $this->loadModel('bdrecursos', true);
        
        $condicion = "";
        
        $id_darwin = $this->filtrarInt($recurso);
        
        
        $metadatadarwin= $this->_bdarwin->getDarwinMetadata($id_darwin);
        
        $metadatarecurso = $e->getRecursoCompletoXid($metadatadarwin[0]['Rec_idRecurso']);
        

        if ($this->botonPress("editarDarwin")) {
            $this->editarDarwin($this->filtrarInt($recurso));
        }

        $datos = $this->_dar_editar->getDarwinCore($this->filtrarInt($recurso));
        $idestandar = $this->_dar->getEstandarRecurso($this->filtrarInt($datos['Rec_idRecurso']));

        $this->_view->assign('recurso', $metadatarecurso);
        $this->_view->assign('datos1', $datos);
        $this->_view->assign('ficha', $this->_dar->getFichaDarwin($idestandar[0][0],Cookie::lenguaje()));
        $this->_view->assign('paises', $this->_dar->getPaises());
        $this->_view->assign('titulo', 'Editar Darwin');
        if ($this->getInt('registrar') == 1) {
            
        }
        $this->_view->renderizar('index', 'editar');
    }

    public function editarDarwin($registro = false) {


        if (is_numeric($this->getSql('Dar_Longitud')) and is_numeric($this->getSql('Dar_Latitud'))) {
            $darwin = $this->_dar_editar->editarDarwinCore(
                    $this->getSql('Dar_FechaActualizacion'), strtoupper($this->getSql('Dar_CodigoInstitucion')), $this->getSql('Dar_CodigoColeccion'), $this->getSql('Dar_NumeroCatalogo'), strtoupper($this->getSql('Dar_NombreCientifico')), $this->getSql('Dar_BaseRegistro'), $this->getSql('Dar_ReinoOrganismo'), $this->getSql('Dar_Division'), $this->getSql('Dar_ClaseOrganismo'), $this->getSql('Dar_OrdenOrganismo'), $this->getSql('Dar_FamiliaOrganismo'), $this->getSql('Dar_GeneroOrganismo'), $this->getSql('Dar_EspecieOrganismo'), $this->getSql('Dar_SubEspecieOrganismo'), $this->getSql('Dar_AutorNombreCientifico'), $this->getSql('Dar_IdentificadoPor'), $this->getSql('Dar_AnoIdentificacion'), $this->getSql('Dar_MesIdentificacion'), $this->getSql('Dar_DiaIdentificacion'), $this->getSql('Dar_StatusTipo'), $this->getSql('Dar_NumeroColector,'), $this->getSql('Dar_NumeroCampo'), $this->getSql('Dar_Colector'), $this->getSql('Dar_AnoColectado'), $this->getSql('Dar_MesColectado'), $this->getSql('Dar_DiaColectado'), $this->getSql('Dar_DiaOrdinario'), $this->getSql('Dar_HoraColectado'), $this->getSql('Dar_ContinenteOceano'), $this->getSql('Dar_Pais'), $this->getSql('Dar_EstadoProvincia'), $this->getSql('Dar_Municipio'), $this->getSql('Dar_Localidad'), $this->getSql('Dar_Longitud'), $this->getSql('Dar_Latitud'), $this->getSql('Dar_PrecisionDeCordenada'), $this->getSql('Dar_BoundingBox'), $this->getSql('Dar_MinimaElevacion'), $this->getSql('Dar_MaximaElevacion'), $this->getSql('Dar_MinimaProfundidad'), $this->getSql('Dar_MaximaProfundidad'), $this->getSql('Dar_SexoOrganismo'), $this->getSql('Dar_PreparacionTipo'), $this->getSql('Dar_ConteoIndividuo'), $this->getSql('Dar_NumeroCatalogoAnterior'), $this->getSql('Dar_TipoRelacion'), $this->getSql('Dar_InformacionRelacionada'), $this->getSql('Dar_EstadoVida'), $this->getSql('Dar_Nota'), $this->getSql('Dar_NombreComunOrganismo'), $this->filtrarInt($registro)
            );
            $this->_view->setJs(array('modal'));
            $this->_view->assign('mensaje', 'Los Datos fueron actualizados correctamente');
        }
    }

}

?>
