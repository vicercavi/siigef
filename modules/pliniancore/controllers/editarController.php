<?php

class editarController extends Controller {

    private $_editar;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_editar = $this->loadModel('editar');
        $this->_plinian = $this->loadModel('registrar');
        $this->_botanico = $this->loadModel('botanico', 'atlas');
    }

    public function index($recurso = false) {

        $this->_acl->acceso("editar_registros_recurso");
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('plinian'));

        $this->_view->getLenguaje("bdrecursos_metadata");
        $e = $this->loadModel('bdrecursos', true);
        $metadatabotanico = $this->_botanico->getMetadata($recurso);
        
        
        $metadatarecurso = $e->getRecursoCompletoXid($metadatabotanico['Rec_IdRecurso']);
        

        if ($this->botonPress("editarPlinian")) {
            $this->editarPlinian($this->filtrarInt($recurso));
        }


        $condicion = "";
        $registross = $this->filtrarInt($recurso);
        $condicion .= " WHERE Pli_IdPlinian = $registross ";

        $datos = $this->_editar->getPlinian($condicion);


        $idestandar = $this->_plinian->getEstandarRecurso($this->filtrarInt($recurso));
        $this->_view->assign('recurso', $metadatarecurso);
        $this->_view->assign('ficha', $this->_plinian->getFichaLegislacion(4, Cookie::lenguaje()));
        $this->_view->assign('datos1', $datos);
        $this->_view->assign('titulo', 'Editar Darwin');

        $this->_view->renderizar('index', 'registrar');
    }

    public function editarPlinian($registro = false) {



        $this->_editar->registrarPlinianCore(
                $this->getSql('Pli_Idioma'), $this->getSql('Pli_NombreCientifico'), $this->getSql('Pli_AcronimoInstitucion'), $this->getSql('Pli_FechaUltimaModificacion'), $this->getSql('Pli_IdRegistroTaxon'), $this->getSql('Pli_CitaSugerida'), $this->getSql('Pli_Distribucion'), $this->getSql('Pli_DescripcionGeneral'), $this->getSql('Pli_Reino'), $this->getSql('Pli_Phylum'), $this->getSql('Pli_Clase'), $this->getSql('Pli_Orden'), $this->getSql('Pli_Familia'), $this->getSql('Pli_Genero'), $this->getSql('Pli_Sinonimia'), $this->getSql('Pli_AutorFechaTaxon'), $this->getSql('Pli_EspeciesReferenciasPublicacion'), $this->getSql('Pli_NombresComunes'), $this->getSql('Pli_InformacionTipos'), $this->getSql('Pli_IdentificadorUnicoGlobal'), $this->getSql('Pli_Colaboradores'), $this->getSql('Pli_FechaCreacion'), $this->getSql('Pli_Habito'), $this->getSql('Pli_CicloVida'), $this->getSql('Pli_Reproduccion'), $this->getSql('Pli_CicloAnual'), $this->getSql('Pli_DescripcionCientifica'), $this->getSql('Pli_BreveDescripcion'), $this->getSql('Pli_Alimentacion'), $this->getSql('Pli_Comportamiento'), $this->getSql('Pli_Interacciones'), $this->getSql('Pli_NumeroCromosomas'), $this->getSql('Pli_DatosMoleculares'), $this->getSql('Pli_EstadoActPoblacion'), $this->getSql('Pli_EstadoUICN'), $this->getSql('Pli_EstadoLegNacional'), $this->getSql('Pli_Habitat'), $this->getSql('Pli_Territorialidad'), $this->getSql('Pli_Endemismo'), $this->getSql('Pli_Usos'), $this->getSql('Pli_Manejo'), $this->getSql('Pli_Folklore'), $this->getSql('Pli_ReferenciasBibliograficas'), $this->getSql('Pli_DocumentacionNoEstructurada'), $this->getSql('Pli_OtraFuenteInformacion'), $this->getSql('Pli_ArticuloCientifico'), $this->getSql('Pli_ClavesTaxonomicas'), $this->getSql('Pli_DatosMigrados'), $this->getSql('Pli_ImportanciaEcologica'), $this->getSql('Pli_HistoriaNaturalNoEstructurada'), $this->getSql('Pli_DatosInvasividad'), $this->getSql('Pli_PublicoObjetivo'), $this->getSql('Pli_Version'), $this->getSql('Pli_URLImagen1'), $this->getSql('Pli_PieImagen1'), $this->getSql('Pli_URLImagen2'), $this->getSql('Pli_PieImagen2'), $this->getSql('Pli_URLImagen3'), $this->getSql('Pli_PieImagen3'), $this->getSql('Pli_Imagen'), $this->filtrarInt($registro)
        );

        $this->_view->setJs(array('modal'));
        $this->_view->assign('mensaje', 'Los Datos fueron actualizados correctamente');
    }

}

?>
