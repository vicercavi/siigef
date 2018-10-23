<?php

class registrarController extends legislacionController {

    private $_registro;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_registro = $this->loadModel('registrar');
    }

    public function index($recurso = false) {
        $_SESSION['recurso'] = $recurso; 
		$this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
		$this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->setJs(array('registrar'));
		$idioma = Cookie::lenguaje();
        $e = $this->loadModel('bdrecursos', true);
		$metadatarecurso = $e->getRecursoCompletoXid($recurso);
		$this->_view->assign('recurso', $metadatarecurso);
        $idestandar = $this->_registro->getEstandarRecurso($this->filtrarInt($recurso));
        $this->_view->assign('ficha', $this->_registro->getFichaLegislacion($idestandar[0][0]));
        $this->_view->assign('Nil_IdNivelLegal', $this->_registro->getNombreNivelLegislacion($idioma));
        $this->_view->assign('Snl_IdSubNivelLegal', $this->_registro->getNombreSubNivelLegislacion($idioma));
        $this->_view->assign('Tel_IdTemaLegal', $this->_registro->getNombreTemaLegal($idioma));
		$this->_view->assign('Til_IdTipoLegal', $this->_registro->getNombreTipoLegislacion($idioma));
        $this->_view->assign('Mal_PalabraClave', $this->_registro->getPalabraClave($idioma));
		$this->_view->assign('idioma', $idioma);
        $this->_view->assign('idiomas', $this->_registro->getIdiomas());
        $this->_view->assign('paises', $this->_registro->getPaises());        
        $this->_view->assign('titulo', 'Formulario de Registro');		

		if($this->getInt('registrar')==1){
			
			$nivel_legal = $this->_registro->getNivelLegislacion($this->getSql('Nil_IdNivelLegal'),$this->getSql('Idi_IdIdioma'));			
			if(empty($nivel_legal)){
				$nivel_legal = $this->_registro->registrarNivelLegal(ucwords(strtolower($this->getSql('Nil_IdNivelLegal'))), $this->getSql('Idi_IdIdioma') );
				$sub_nivel_legal = $this->_registro->registrarSubNivelLegal(ucwords(strtolower($this->getSql('Snl_IdSubNivelLegal'))),$nivel_legal[0],$this->getSql('Idi_IdIdioma'));
				$tema_legal = $this->_registro->registrarTemaLegal(ucwords(strtolower($this->getSql('Tel_IdTemaLegal'))),$sub_nivel_legal[0],$this->getSql('Idi_IdIdioma'));
			}
			else{
				$sub_nivel_legal = $this->_registro->getSubNivelLegislacion($this->getSql('Snl_IdSubNivelLegal'),$nivel_legal[0],$this->getSql('Idi_IdIdioma'));
				if(empty($sub_nivel_legal)){
					$sub_nivel_legal = $this->_registro->registrarSubNivelLegal(ucwords(strtolower($this->getSql('Snl_IdSubNivelLegal')),$nivel_legal[0],$this->getSql('Idi_IdIdioma')));
					$tema_legal = $this->_registro->registrarTemaLegal(ucwords(strtolower($this->getSql('Tel_IdTemaLegal'))),$sub_nivel_legal[0],$this->getSql('Idi_IdIdioma'));
				}
				else{
					$tema_legal = $this->_registro->getTemaLegal($this->getSql('Tel_IdTemaLegal'), $sub_nivel_legal[0], $this->getSql('Idi_IdIdioma'));
					if(empty($tema_legal)){
						$tema_legal = $this->_registro->registrarTemaLegal(ucwords(strtolower($this->getSql('Tel_IdTemaLegal'))),$sub_nivel_legal[0],$this->getSql('Idi_IdIdioma'));
					}
				}
			}
			
			$tipo_legal = $this->_registro->getTipoLegal($this->getSql('Til_Nombre'),$this->getSql('Idi_IdIdioma'));			
			if(empty($tipo_legal)){
				$tipo_legal = $this->_registro->registrarNivelLegal(ucwords(strtolower($this->getSql('Nil_IdNivelLegal'))), $this->getSql('Idi_IdIdioma') );
			}
						
			if(!$this->_registro->verificarTitulo($this->getSql('Mal_Titulo'),$tema_legal[0],$this->getSql('Pai_IdPais'),$this->getSql('Idi_IdIdioma'))){
				if(empty($this->getSql('Mal_PalabraClave'))){
					$palabra_clave = 'Otros';
				}else
				{
					$palabra_clave = $this->getSql('Mal_PalabraClave');
				}
				$registrado = $this->_registro->registrarLegislacion(
						$this->getSql('Mal_FechaPublicacion'),
						strtoupper(strtolower($this->getSql('Mal_Entidad'))),
						$this->getSql('Mal_NumeroNormas'),
						ucfirst(strtolower($this->getSql('Mal_Titulo'))),
						$this->getSql('Mal_ArticuloAplicable'),
						$this->getSql('Mal_ResumenLegislacion'),
						$this->getSql('Mal_FechaRevision'),
						$this->getSql('Mal_NormasComplementarias'),
						$tipo_legal[0],
						$tema_legal[0],
						$this->getSql('Pai_IdPais'),
						$this->filtrarInt($recurso),
						$this->getSql('Idi_IdIdioma'),
						ucwords(strtolower($palabra_clave))
						);
				if($registrado){
					$this->_view->assign('_error', 'Datos Registrados Correctamente');
					$this->_view->renderizar('index', 'legislacion');
					exit;
				}else{
					$this->_view->assign('_error', 'Ha ocurrido un error, lo datos no se registraron');
					$this->_view->renderizar('index', 'legislacion');
					exit;
				}
			}else{
				$this->_view->assign('_error', 'EL registro ya existe');
				$this->_view->renderizar('index', 'legislacion');
				exit;
			}
		}
		
        $this->_view->renderizar('index', 'registrar');
    }
	
	public function gestion_idiomas($Idi_IdIdioma) {
        
		$this->_view->setJs(array('registrar'));         
        $idestandar = $this->_registro->getEstandarRecurso($this->filtrarInt($_SESSION['recurso']));        
        $this->_view->assign('ficha', $this->_registro->getFichaLegislacion($idestandar[0][0]));
        $this->_view->assign('Nil_IdNivelLegal', $this->_registro->getNombreNivelLegislacion($Idi_IdIdioma));
        $this->_view->assign('Snl_IdSubNivelLegal', $this->_registro->getNombreSubNivelLegislacion($Idi_IdIdioma));
        $this->_view->assign('Tel_IdTemaLegal', $this->_registro->getNombreTemaLegal($Idi_IdIdioma));
		$this->_view->assign('Til_IdTipoLegal', $this->_registro->getNombreTipoLegislacion($Idi_IdIdioma));
        $this->_view->assign('Mal_PalabraClave', $this->_registro->getPalabraClave($Idi_IdIdioma));
        $this->_view->assign('idiomas', $this->_registro->getIdiomas());
		$this->_view->assign('idioma', $Idi_IdIdioma);
        $this->_view->assign('paises', $this->_registro->getPaises());        
        $this->_view->assign('titulo', 'Formulario de Registro');        
        
        
        $this->_view->renderizar('ajax/gestion_idiomas', false, true);
    }
	
	

}

?>
