<?php

class editarController extends legislacionController {

    private $_editar;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_editar = $this->loadModel('editar');
        $this->_registro = $this->loadModel('registrar');
        $this->_legal = $this->loadModel('legal');
    }

    public function index($idregistro=false)
    {
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->setJs(array('editar'));    
        $registross = $this->filtrarInt($idregistro);
        $idioma = Cookie::lenguaje();

        $e = $this->loadModel('bdrecursos', true);

        $condicion = "";
        $condicion = " where mal.Mal_IdMatrizLegal = $registross ";
        $datos = $this->_editar->getLegislacionesMetadata1($condicion);

        $Mal_IdMatrizLegal = $this->filtrarInt($idregistro);
        
        $condicion = " WHERE rec.Rec_Estado = 1 and m.Mal_IdMatrizLegal = $Mal_IdMatrizLegal ";
        $metadatalegislacion = $this->_legal->getLegislacionesMetadata($condicion,$idioma);
        $metadatarecurso = $e->getRecursoCompletoXid($metadatalegislacion[0]['Rec_IdRecurso']);

        if ($this->botonPress("btnEditarLegal")) {
              $this->editarLegal($datos['Rec_IdRecurso']);			                  
        }		
		
		
        $idestandar = $this->_registro->getEstandarRecurso($this->filtrarInt($datos['Rec_IdRecurso']));
        $this->_view->assign('ficha', $this->_registro->getFichaLegislacion($idestandar[0][0],$datos['Idi_IdIdioma']));
        $this->_view->assign('Nil_IdNivelLegal', $this->_registro->getNombreNivelLegislacion($datos['Idi_IdIdioma']));
        $this->_view->assign('Snl_IdSubNivelLegal', $this->_registro->getNombreSubNivelLegislacion($datos['Idi_IdIdioma']));
        $this->_view->assign('Tel_IdTemaLegal', $this->_registro->getNombreTemaLegal($datos['Idi_IdIdioma']));
		$this->_view->assign('Til_IdTipoLegal', $this->_registro->getNombreTipoLegislacion($datos['Idi_IdIdioma']));
        $this->_view->assign('Mal_PalabraClave', $this->_registro->getPalabraClave($datos['Idi_IdIdioma']));
		$this->_view->assign('Tipo_Legal', $this->_registro->getNombreTipoLegislacion($datos['Idi_IdIdioma']));
        $this->_view->assign('idiomas', $this->_registro->getIdiomas());
        $this->_view->assign('paises', $this->_registro->getPaises());   
        $this->_view->assign('recurso', $metadatarecurso);
        $this->_view->assign('datos1', $datos);
        $this->_view->assign('titulo', 'Editar Legislacion');
        $this->_view->renderizar('index', 'editar');
    }
    
    public function gestion_idiomas() {
        $this->_view->setJs(array('editar')); 
        $condicion1 ='';
        $Idi_IdIdioma =  $this->getPostParam('idIdioma');
        $id = $this->getPostParam('idLegal');
        $condicion1 .= " where mal.Mal_IdMatrizLegal = $id ";
        $datos = $this->_editar->getLegalTraducido($condicion1,$Idi_IdIdioma);
        
        $idestandar = $this->_registro->getEstandarRecurso($this->filtrarInt($datos['Rec_IdRecurso']));
        $this->_view->assign('ficha', $this->_registro->getFichaLegislacion($idestandar[0][0]));
        $this->_view->assign('Nil_IdNivelLegal', $this->_registro->getNombreNivelLegislacion($Idi_IdIdioma));
        $this->_view->assign('Snl_IdSubNivelLegal', $this->_registro->getNombreSubNivelLegislacion($Idi_IdIdioma));
        $this->_view->assign('Tel_IdTemaLegal', $this->_registro->getNombreTemaLegal($Idi_IdIdioma));
		$this->_view->assign('Til_IdTipoLegal', $this->_registro->getNombreTipoLegislacion($Idi_IdIdioma));
        $this->_view->assign('Mal_PalabraClave', $this->_registro->getPalabraClave($Idi_IdIdioma));
        $this->_view->assign('idiomas', $this->_registro->getIdiomas());
        $this->_view->assign('paises', $this->_registro->getPaises());        
        
        if ($datos["Idi_IdIdioma"]==$Idi_IdIdioma) {
            $this->_view->assign('datos1', $datos);    
        }else{
            $datos["Nil_Nombre"]="";
            $datos["Snl_Nombre"]="";
            $datos["Tel_Nombre"]="";
			$datos["Til_Nombre"]="";
            $datos["Mal_Titulo"]="";
            $datos["Mal_ResumenLegislacion"]="";
            $datos["Mal_PalabraClave"]="";
            $datos["Idi_IdIdioma"]=$Idi_IdIdioma;
            $this->_view->assign('datos1',$datos);  
        }            
        $this->_view->assign('IdiomaOriginal',$this->getPostParam('idIdiomaOriginal'));
        
        $this->_view->renderizar('ajax/gestion_idiomas', false, true);
    }
	
    public function editarLegal($Rec_IdRecurso){
        
		
		if($this->_editar->verificarIdiomaLegal($this->getInt('Mal_IdMatrizLegal'), $this->getSql('idiomaSelect'))){
            
			$nivel_legal = $this->_registro->getNivelLegislacion($this->getSql('Nil_Nombre'),$this->getSql('Idi_IdIdioma'));			
			if(empty($nivel_legal)){
				$nivel_legal = $this->_registro->registrarNivelLegal(ucwords(strtolower($this->getSql('Nil_Nombre'))), $this->getSql('Idi_IdIdioma') );
				$sub_nivel_legal = $this->_registro->registrarSubNivelLegal(ucwords(strtolower($this->getSql('Snl_Nombre'))),$nivel_legal[0],$this->getSql('Idi_IdIdioma'));
				$tema_legal = $this->_registro->registrarTemaLegal(ucwords(strtolower($this->getSql('Tel_IdTemaLegal'))),$sub_nivel_legal[0],$this->getSql('Idi_IdIdioma'));
			}
			else{
				$sub_nivel_legal = $this->_registro->getSubNivelLegislacion($this->getSql('Snl_Nombre'),$nivel_legal[0],$this->getSql('Idi_IdIdioma'));
				if(empty($sub_nivel_legal)){
					$sub_nivel_legal = $this->_registro->registrarSubNivelLegal(ucwords(strtolower($this->getSql('Snl_Nombre'))),$nivel_legal[0],$this->getSql('Idi_IdIdioma'));
					$tema_legal = $this->_registro->registrarTemaLegal(ucwords(strtolower($this->getSql('Tel_IdTemaLegal'))),$sub_nivel_legal[0],$this->getSql('Idi_IdIdioma'));
				}
				else{
					$tema_legal = $this->_registro->getTemaLegal($this->getSql('Tel_Nombre'), $sub_nivel_legal[0], $this->getSql('Idi_IdIdioma'));
					if(empty($tema_legal)){
						$tema_legal = $this->_registro->registrarTemaLegal(ucwords(strtolower($this->getSql('Tel_Nombre'))),$sub_nivel_legal[0],$this->getSql('Idi_IdIdioma'));
					}
				}
			}
			
			$tipo_legal = $this->_registro->getTipoLegal($this->getSql('Til_Nombre'),$this->getSql('Idi_IdIdioma'));			
			if(empty($tipo_legal)){
				$tipo_legal = $this->_registro->registrarNivelLegal(ucwords(strtolower($this->getSql('Nil_IdNivelLegal'))), $this->getSql('Idi_IdIdioma') );
			}
            
            if(empty($this->getSql('Mal_PalabraClave'))){
					$palabra_clave = 'Otros';
				}else
				{
					$palabra_clave = $this->getSql('Mal_PalabraClave');
				}
            $registrado = $this->_registro->editarLegislacion(
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
				$this->filtrarInt($Rec_IdRecurso),
				$this->getSql('idiomaSelect'),
				ucwords(strtolower($palabra_clave)),
				$this->getInt('Mal_IdMatrizLegal')
						);           
            if($registrado){
                $this->_view->setJs(array('modal'));
                //$this->_view->renderizar('index', 'editar');
				$this->_view->assign('mensaje', 'Datos Actualizados Correctamente');


            }else{
                $this->_view->setJs(array('modal'));
				$this->_view->assign('mensaje', 'Ha ocurrido un error, lo datos no se registraron');
            };
        }else{                   
            $this->_editar->editarTraduccion(
                    $this->getSql('Nil_IdNivelLegal'),
                    $this->getSql('Snl_IdSubNivelLegal'),                   
					$this->getSql('Tel_IdTemaLegal'),
					$this->getSql('Til_IdTipoLegal'),
                    $this->getSql('Nil_Nombre'),
                    $this->getSql('Snl_Nombre'),
                    $this->getSql('Tel_Nombre'),
					$this->getSql('Til_Nombre'),
                    $this->getSql('Mal_Titulo'),
                    $this->getSql('Mal_ResumenLegislacion'),
                    $this->getSql('Mal_PalabraClave'),
                    $this->getInt('Mal_IdMatrizLegal'),
                    $this->getSql('idiomaSelect')
            );
			
            $this->_view->setJs(array('modal'));
			$this->_view->assign('mensaje', 'Datos Actualizados Correctamente');
			
			
        }
    }
}

?>
