<?php

class registrarController extends Controller {

    private $_darwin;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_darwin = $this->loadModel('registrar');
    }

    public function index($recurso = false) {
        $this->_acl->acceso("registro_individual");   
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
		$this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->setJs(array('registrardarwincore'));
		$e = $this->loadModel('bdrecursos', true);
		$metadatarecurso = $e->getRecursoCompletoXid($recurso);
		$this->_view->assign('recurso', $metadatarecurso);
		$idestandar = $this->_darwin->getEstandarRecurso($this->filtrarInt($recurso));
        $this->_view->assign('ficha', $this->_darwin->getFichaDarwin($idestandar[0][0],Cookie::lenguaje()));
		$this->_view->assign('paises', $this->_darwin->getPaises());       
        $this->_view->assign('titulo', 'Formulario de Registro');
		if($this->getInt('registrar')==1){
			if(is_numeric(str_replace(',','.',$this->getSql('Dar_Longitud'))) and is_numeric(str_replace(',','.',$this->getSql('Dar_Latitud')))){
				$darwin = $this->_darwin->registrarDarwinCore(
						$this->getSql('Dar_FechaActualizacion'),
						strtoupper($this->getSql('Dar_CodigoInstitucion')),
						$this->getSql('Dar_CodigoColeccion'),
						$this->getSql('Dar_NumeroCatalogo'),
						strtoupper($this->getSql('Dar_NombreCientifico')),
						$this->getSql('Dar_BaseRegistro'),
						$this->getSql('Dar_ReinoOrganismo'),
						$this->getSql('Dar_Division'),
						$this->getSql('Dar_ClaseOrganismo'),
						$this->getSql('Dar_OrdenOrganismo'),
						$this->getSql('Dar_FamiliaOrganismo'),
						$this->getSql('Dar_GeneroOrganismo'),
						$this->getSql('Dar_EspecieOrganismo'),
						$this->getSql('Dar_SubEspecieOrganismo'),
						$this->getSql('Dar_AutorNombreCientifico'),
						$this->getSql('Dar_IdentificadoPor'),
						$this->getSql('Dar_AnoIdentificacion'),
						$this->getSql('Dar_MesIdentificacion'),
						$this->getSql('Dar_DiaIdentificacion'),
						$this->getSql('Dar_StatusTipo'),
						$this->getSql('Dar_NumeroColector,'),						
						$this->getSql('Dar_NumeroCampo'),
						$this->getSql('Dar_Colector'),
						$this->getSql('Dar_AnoColectado'),
						$this->getSql('Dar_MesColectado'),
						$this->getSql('Dar_DiaColectado'),
						$this->getSql('Dar_DiaOrdinario'),
						$this->getSql('Dar_HoraColectado'),
						$this->getSql('Dar_ContinenteOceano'),
						$this->getSql('Dar_Pais'),
						$this->getSql('Dar_EstadoProvincia'),
						$this->getSql('Dar_Municipio'),
						$this->getSql('Dar_Localidad'),
						str_replace(',','.',$this->getSql('Dar_Longitud')),
						str_replace(',','.',$this->getSql('Dar_Latitud')),
						$this->getSql('Dar_PrecisionDeCordenada'),
						$this->getSql('Dar_BoundingBox'),
						$this->getSql('Dar_MinimaElevacion'),
						$this->getSql('Dar_MaximaElevacion'),
						$this->getSql('Dar_MinimaProfundidad'),
						$this->getSql('Dar_MaximaProfundidad'),
						$this->getSql('Dar_SexoOrganismo'),
						$this->getSql('Dar_PreparacionTipo'),
						$this->getSql('Dar_ConteoIndividuo'),
						$this->getSql('Dar_NumeroCatalogoAnterior'),
						$this->getSql('Dar_TipoRelacion'),
						$this->getSql('Dar_InformacionRelacionada'),
						$this->getSql('Dar_EstadoVida'),
						$this->getSql('Dar_Nota'),
						$this->getSql('Dar_NombreComunOrganismo'),
						$this->filtrarInt($recurso)
						);
						
						if($darwin){
							$this->_view->setJs(array('modal'));
							$this->_view->assign('mensaje', 'Los Datos fueron registrados correctamente');
							$this->_view->renderizar('index', 'registrar');
							exit;
						}else{
							$this->_view->setJs(array('modal'));
							$this->_view->assign('mensaje', 'Los Datos NO fueron registrados, intentelo nuevamente!!!');
							$this->_view->renderizar('index', 'registrar');
							exit;
						}
			}else{
				$this->_view->setJs(array('modal'));
				$this->_view->assign('mensaje', 'Verifique los datos de Longitud y Latidud!!!');
				$this->_view->renderizar('index', 'registrar');
				exit;
			}
		}
        $this->_view->renderizar('index', 'registrar');
    }
}

?>
