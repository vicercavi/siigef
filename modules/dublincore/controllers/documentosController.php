<?php

class documentosController extends Controller{

    private $_documentos;
    
    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_documentos = $this->loadModel('documentos');
    }
    
    public function index($pagina = false)
    {        
    	//$this->_acl->autenticado();
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("bd_documentos");
        $paginador = new Paginador();
        $this->_view->setJs(array('documentos'));
		$this->_view->setCss(array('listadocumentos'));
		$this->_view->setTemplate(LAYOUT_FRONTEND);
		$idioma = Cookie::lenguaje();
		$condicion = " Where Dub_Estado = 1 ";				
		$registro = 25;
		
		 
        $this->_view->assign('documentos', $paginador->paginar($this->_documentos->getDocumentosPaises($condicion,$idioma),"paginar","", $pagina,$registro));
		$this->_view->assign('paises', $this->_documentos->getCantDocumentosPaises($condicion,$idioma));		
		$this->_view->assign('totaldocumentos', $this->_documentos->getTotalDocumentos($condicion,$idioma));		
        $this->_view->assign('temadocumento', $this->_documentos->getCantidadTemasDocumentos($condicion,$idioma));		        		
		$this->_view->assign('tipodocumento', $this->_documentos->getCantidadTiposDocumentos($condicion,$idioma));
		$this->_view->assign('numeropagina',$this->getInt('pagina'));		
        
		$this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
		
		$this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        
		$this->_view->assign('titulo', 'Base de Datos de Documentos');
        
		$this->_view->renderizar('index','documentos');
    }
    
    public function buscarporpalabras($palabra = '', $temadocumento = '', $tipodocumento = '', $pais = '')
    {
    	$this->_acl->autenticado();
        $this->_view->setTemplate(LAYOUT_FRONTEND);
		$this->_view->getLenguaje("bd_documentos");
		$this->_view->setCss(array('listadocumentos'));
		$pagina = $this->getInt('pagina');
        //$palabra = $this->getSql('palabra'); 
		$idioma = Cookie::lenguaje();      
        $registro = 25;
        $condicion = "";
        $condicionPalabra = "";
		$condicionTema = "";
		$condicionTipo = "";
		$condicionPais = "";
	          
        if($palabra == 'all')
        {
        	$palabra = '';
        }

        $trozosPalabra = explode(" ",$palabra); 
        $numero = count($trozosPalabra); 
        if($numero==1){
        	$condicionPalabra .= " WHERE Dub_Estado = 1 and (fn_TraducirContenido('dublincore','Dub_Titulo',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Titulo) LIKE '%$palabra%' OR fn_TraducirContenido('dublincore','Dub_PalabraClave',dub.Dub_IdDublinCore,'$idioma',dub.Dub_PalabraClave) LIKE '%$palabra%' OR fn_TraducirContenido('dublincore','Dub_Descripcion',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Descripcion) LIKE '%$palabra%' OR Aut_Nombre LIKE '%$palabra%') ";
        } 
        if($numero>1){
            $condicionPalabra = " WHERE Dub_Estado = 1 AND (MATCH(Dub_Titulo, Dub_Descripcion, Dub_PalabraClave) AGAINST ('%".$palabra."%' IN BOOLEAN MODE) OR MATCH(Aut_Nombre) AGAINST ('%".$palabra."%' IN BOOLEAN MODE)) ";
        }

 
    	if($temadocumento != 'all')
        {
            $condicionTema .= " AND  fn_TraducirContenido('tema_dublin','Ted_Descripcion',ted.Ted_IdTemaDublin,'$idioma',ted.Ted_Descripcion) = '$temadocumento'";
        	if($tipodocumento != 'all')
	        {
	            $condicionTipo .= " and  fn_TraducirContenido('tipo_dublin','Tid_Descripcion',tid.Tid_IdTipoDublin,'$idioma',tid.Tid_Descripcion) = '$tipodocumento'";
	        	if($pais != 'all')
		        {
		            $condicion .= $condicionPalabra.$condicionTema.$condicionTipo. " AND pai.Pai_Nombre = '$pais' " ;
		            //$condicionPais .= " WHERE d.Pai_Nombre = '$pais' ";
		        } else {
		        	$condicion .= $condicionPalabra.$condicionTema.$condicionTipo. " " ;
		        }
	        } else { 
	        	if($pais != 'all')
		        {
		            $condicion .= $condicionPalabra.$condicionTema. " AND pai.Pai_Nombre = '$pais' " ;
		           // $condicionPais .= " WHERE d.Pai_Nombre = '$pais' ";
		        } else { 
		        	$condicion .= $condicionPalabra.$condicionTema. " " ;
		    	}
	        }
        } else {
        	if($tipodocumento != 'all')
	        {
	            $condicionTipo .= " and  fn_TraducirContenido('tipo_dublin','Tid_Descripcion',tid.Tid_IdTipoDublin,'$idioma',tid.Tid_Descripcion) = '$tipodocumento'";
	        	if($pais != 'all')
		        {
		            $condicion .= $condicionPalabra.$condicionTipo. " AND pai.Pai_Nombre = '$pais' " ;
		            //$condicionPais .= " WHERE d.Pai_Nombre = '$pais' ";
		        } else {
		        	$condicion .= $condicionPalabra.$condicionTipo. " " ;
		        }
	        } else {
	        	if($pais != 'all')
		        {
		            $condicion .= $condicionPalabra. " AND pai.Pai_Nombre = '$pais' " ;
		            //$condicionPais .= " WHERE d.Pai_Nombre = '$pais' ";
		        } else {
		        	$condicion .= $condicionPalabra. " " ;
		        }
	        }
        }
        

        if ($palabra != 'all') {
        	$this->_view->assign('palabrabuscada', $palabra);
        } 
        if ($temadocumento != 'all') {
        	$this->_view->assign('filtroTema', $temadocumento);	
        }
	    if ($tipodocumento != 'all') {
	    	$this->_view->assign('filtroTipo', $tipodocumento);
	    }
	    if ($pais != 'all') {
	    	$this->_view->assign('filtroPais', $pais);
	    }
	    
	    
        $paginador = new Paginador();
        $this->_view->setJs(array('documentos'));
        //$this->_view->assign('documentos', $paginador->paginar($this->_documentos->getDocumentosTraducido($condicion, $idioma ),"paginar","", $pagina,$registro));
		//$this->_view->assign('totaldocumentos', $this->_documentos->getTotalDocumentos($condicion,$idioma));		
        $this->_view->assign('documentos', $paginador->paginar($this->_documentos->getDocumentosPaises($condicion,$idioma),"paginar","", $pagina,$registro));
		$this->_view->assign('paises', $this->_documentos->getCantDocumentosPaises($condicion,$idioma));		
		$this->_view->assign('totaldocumentos', $this->_documentos->getTotalDocumentos($condicion,$idioma));		
        $this->_view->assign('temadocumento', $this->_documentos->getCantidadTemasDocumentos($condicion,$idioma));		        		
		$this->_view->assign('tipodocumento', $this->_documentos->getCantidadTiposDocumentos($condicion,$idioma));   

        $this->_view->assign('titulo', 'Buscador - Base de Datos de Documentos');   	
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));		
		$this->_view->assign('numeropagina', $paginador->getNumeroPagina());        
		$this->_view->renderizar('index','documentos');
    }

    public function paginar_resultados()
    {
        //$this->_view->setTemplate(LAYOUT_FRONTEND);
		$this->_view->getLenguaje("bd_documentos");
		$this->_view->setCss(array('listadocumentos'));
		$pagina = $this->getInt('pagina');
        $palabra = $this->getSql('palabra'); 
        $temadocumento = $this->getSql('tema'); 
        $tipodocumento = $this->getSql('tipo'); 
        $pais = $this->getSql('pais'); 
		
		$idioma = Cookie::lenguaje();      
        $registro = 25;
        $condicion = "";
        $condicionPalabra = "";
		$condicionTema = "";
		$condicionTipo = "";
		$condicionPais = "";
	          
        if($palabra == 'all')
        {
        	$palabra = '';
        }
        $condicionPalabra .= " WHERE Dub_Estado = 1 and (fn_TraducirContenido('dublincore','Dub_Titulo',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Titulo) LIKE '%$palabra%' OR fn_TraducirContenido('dublincore','Dub_PalabraClave',dub.Dub_IdDublinCore,'$idioma',dub.Dub_PalabraClave) LIKE '%$palabra%' OR fn_TraducirContenido('dublincore','Dub_Descripcion',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Descripcion) LIKE '%$palabra%' OR Aut_Nombre LIKE '%$palabra%') ";
    	if($temadocumento != 'all')
        {
            $condicionTema .= " and  fn_TraducirContenido('tema_dublin','Ted_Descripcion',ted.Ted_IdTemaDublin,'$idioma',ted.Ted_Descripcion) = '$temadocumento'";
        	if($tipodocumento != 'all')
	        {
	            $condicionTipo .= " and  fn_TraducirContenido('tipo_dublin','Tid_Descripcion',tid.Tid_IdTipoDublin,'$idioma',tid.Tid_Descripcion) = '$tipodocumento'";
	        	if($pais != 'all')
		        {
		            $condicion .= $condicionPalabra.$condicionTema.$condicionTipo. " AND pai.Pai_Nombre = '$pais' " ;
		            //$condicionPais .= " WHERE d.Pai_Nombre = '$pais' ";
		        } else {
		        	$condicion .= $condicionPalabra.$condicionTema.$condicionTipo. " " ;
		        }
	        } else {
	        	if($pais != 'all')
		        {
		            $condicion .= $condicionPalabra.$condicionTema. " AND pai.Pai_Nombre = '$pais' " ;
		           // $condicionPais .= " WHERE d.Pai_Nombre = '$pais' ";
		        } else {
		        	$condicion .= $condicionPalabra.$condicionTema. " " ;
		        }
	        }
        } else {
        	if($tipodocumento != 'all')
	        {
	            $condicionTipo .= " and  fn_TraducirContenido('tipo_dublin','Tid_Descripcion',tid.Tid_IdTipoDublin,'$idioma',tid.Tid_Descripcion) = '$tipodocumento'";
	        	if($pais != 'all')
		        {
		            $condicion .= $condicionPalabra.$condicionTipo. " AND pai.Pai_Nombre = '$pais' " ;
		            //$condicionPais .= " WHERE d.Pai_Nombre = '$pais' ";
		        } else {
		        	$condicion .= $condicionPalabra.$condicionTipo. " " ;
		        }
	        } else {
	        	if($pais != 'all')
		        {
		            $condicion .= $condicionPalabra. " AND pai.Pai_Nombre = '$pais' " ;
		            //$condicionPais .= " WHERE d.Pai_Nombre = '$pais' ";
		        } else {
		        	$condicion .= $condicionPalabra. " " ;
		        }
	        }
        }
        
        if ($palabra != 'all') {
        	$this->_view->assign('palabrabuscada', $palabra);
        } 
        if ($temadocumento != 'all') {
        	$this->_view->assign('filtroTema', $temadocumento);	
        }
	    if ($tipodocumento != 'all') {
	    	$this->_view->assign('filtroTipo', $tipodocumento);
	    }
	    if ($pais != 'all') {
	    	$this->_view->assign('filtroPais', $pais);
	    }
	    
	    $paginador = new Paginador();
        $this->_view->setJs(array('documentos'));
        
        $this->_view->assign('documentos', $paginador->paginar($this->_documentos->getDocumentosPaises($condicion,$idioma),"paginar","", $pagina,$registro));
		$this->_view->assign('paises', $this->_documentos->getCantDocumentosPaises($condicion,$idioma));		
		$this->_view->assign('totaldocumentos', $this->_documentos->getTotalDocumentos($condicion,$idioma));		
        $this->_view->assign('temadocumento', $this->_documentos->getCantidadTemasDocumentos($condicion,$idioma));		        		
		$this->_view->assign('tipodocumento', $this->_documentos->getCantidadTiposDocumentos($condicion,$idioma));   

        $this->_view->assign('titulo', 'Buscador - Base de Datos de Documentos');   	
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));		
		$this->_view->assign('numeropagina', $paginador->getNumeroPagina());        
		$this->_view->renderizar('ajax/resultados', false, true);
    }
   

    public function embed_dublincore()
    {
        //$this->_view->setTemplate(LAYOUT_FRONTEND);
		$this->_view->getLenguaje("bd_documentos");
		$this->_view->setCss(array('listadocumentos'));
		$palabra = $this->getSql('palabra'); 
        $temadocumento = $palabra; 
        $tipodocumento = $palabra; 
		//echo $palabra;
		$idioma = Cookie::lenguaje();      
        
        $condicion = "";
        $condicionPalabra = "";
		$condicionTema = "";
		$condicionTipo = "";
	          
        $condicionPalabra .= " WHERE Dub_Estado = 1 and (fn_TraducirContenido('dublincore','Dub_Titulo',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Titulo) LIKE '%$palabra%' 
        	OR fn_TraducirContenido('dublincore','Dub_PalabraClave',dub.Dub_IdDublinCore,'$idioma',dub.Dub_PalabraClave) LIKE '%$palabra%' 
        	OR fn_TraducirContenido('dublincore','Dub_Descripcion',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Descripcion) LIKE '%$palabra%' 
        	OR Aut_Nombre LIKE '%$palabra%') ";
        $condicionTema .= " OR  fn_TraducirContenido('tema_dublin','Ted_Descripcion',ted.Ted_IdTemaDublin,'$idioma',ted.Ted_Descripcion) = '$temadocumento'";
        $condicionTipo .= " OR  fn_TraducirContenido('tipo_dublin','Tid_Descripcion',tid.Tid_IdTipoDublin,'$idioma',tid.Tid_Descripcion) = '$tipodocumento'";
		$condicion = $condicionPalabra.$condicionTema.$condicionTipo;
	    
        $this->_view->assign('documentos',$this->_documentos->getDocumentosPaises($condicion,$idioma));
		     
		$this->_view->renderizar('ajax/embed_dublincore', false, true);
    }


   /*
    public function buscarportemadocumento()
    {
        $this->_view->setTemplate(LAYOUT_FRONTEND);
		$this->_view->getLenguaje("bd_documentos");
		$pagina = $this->getInt('pagina');
        $palabra = $this->getSql('palabra');
		$idioma = Cookie::lenguaje();
        $registro = 25;
        $condicion = "";
        if($palabra)
        {
            $condicion .= " WHERE Dub_Estado = 1 and  fn_TraducirContenido('tema_dublin','Ted_Descripcion',ted.Ted_IdTemaDublin,'$idioma',ted.Ted_Descripcion) = '$palabra'";
        }
        
		$paginador = new Paginador();
        
		$this->_view->setJs(array('documentos'));
        
		$this->_view->assign('documentos', $paginador->paginar($this->_documentos->getDocumentosTraducido($condicion,$idioma),"paginar","", $pagina,$registro));
		
		$this->_view->assign('totaldocumentos', $this->_documentos->getTotalDocumentos($condicion,$idioma));	
		
		$this->_view->assign('palabrabuscada', '');
        
		$this->_view->assign('paises', $this->_documentos->getCantidadDocumentosPaises());
        
		$this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        
		$this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        
		$this->_view->renderizar('ajax/resultados', false, true);
    }
	
	public function buscarportipodocumento()
    {
        $this->_view->setTemplate(LAYOUT_FRONTEND);
		$this->_view->getLenguaje("bd_documentos");
		$pagina = $this->getInt('pagina');
        $palabra = $this->getSql('palabra');
		$idioma = Cookie::lenguaje();
        $registro = 25;
        $condicion = "";
        if($palabra)
        {
            $condicion .= " WHERE Dub_Estado = 1 and  fn_TraducirContenido('tipo_dublin','Tid_Descripcion',tid.Tid_IdTipoDublin,'$idioma',tid.Tid_Descripcion) = '$palabra'";
        }
        
		$paginador = new Paginador();
        
		$this->_view->setJs(array('documentos'));
        
		$this->_view->assign('documentos', $paginador->paginar($this->_documentos->getDocumentosTraducido($condicion,$idioma),"paginar","", $pagina,$registro));
		
		$this->_view->assign('totaldocumentos', $this->_documentos->getTotalDocumentos($condicion,$idioma));	
		
		$this->_view->assign('palabrabuscada', '');
        
		$this->_view->assign('paises', $this->_documentos->getCantidadDocumentosPaises());
        
		$this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        
		$this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        
		$this->_view->renderizar('ajax/resultados', false, true);
    }	
    
    public function buscarporpais()
    {
        $this->_view->setTemplate(LAYOUT_FRONTEND);
		$this->_view->getLenguaje("bd_documentos");
		$pagina = $this->getInt('pagina');
        $palabra = $this->getSql('palabra');
        $variables = $this->getSql('variables');
        $tipo_archivo = $this->getSql('pais');
        $registros  = $this->getInt('registros');
        $paginas = $this->getInt('paginas');
		$idioma = Cookie::lenguaje();
        $condicion = "";
        $condicionPais = "";
        $registro = 25;

        if($palabra)
        {
            $condicion .= " WHERE Dub_Estado = 1 ";
            $condicionPais .= " WHERE d.Pai_Nombre = '$palabra' ";
        }
   
        $paginador = new Paginador();
        
		$this->_view->setJs(array('documentos'));        
		$this->_view->assign('documentos', $paginador->paginar($this->_documentos->getDocumentosPaises($condicion,$idioma),"paginar","", $pagina,$registro));
		$this->_view->assign('totaldocumentos', $this->_documentos->getCantDocumentosPaises($condicion,$idioma,$condicionPais));		
		$this->_view->assign('paises', $this->_documentos->getCantidadDocumentosPaises());        
		$this->_view->assign('palabrabuscada', '');		
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));		
		$this->_view->assign('numeropagina', $paginador->getNumeroPagina());        
		$this->_view->renderizar('ajax/resultados', false, true);
    }
    */
    public function metadata($Dub_IdDublinCore)
    {
    	$this->_acl->autenticado();
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("bd_documentos");
		$this->_view->getLenguaje("bdrecursos_metadata");
		$this->_view->setTemplate(LAYOUT_FRONTEND);
		$idioma = Cookie::lenguaje();
		$e = $this->loadModel('bdrecursos', true);        
        $condicion = "";
		$Dub_IdDublinCore = $this->filtrarInt($Dub_IdDublinCore);
		$condicion .= " where dub.Dub_Estado = 1 and dub.Dub_IdDublinCore = $Dub_IdDublinCore ";
		$metadatadublin = $this->_documentos->getDocumentosTraducido($condicion,$idioma);
		$metadatarecurso = $e->getRecursoCompletoXid($metadatadublin[0]['Rec_IdRecurso']);
		
        $this->_view->assign('recurso', $metadatarecurso);
        
        $this->_view->assign('detalle', $metadatadublin);
		
		$this->_view->assign('titulo', 'Documento - '.$metadatadublin[0]['Dub_Titulo'] );
        
		$this->_view->renderizar('metadata', 'documentos');
    }
	
	public function editar($registros)
    {
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("bd_documentos");
		$this->_view->setTemplate(LAYOUT_FRONTEND);

        $condicion = "";
		$registross = $this->filtrarInt($registros);
		$condicion .= " where Dub_Estado = 1 and dub.Dub_IdDublinCore = $registross ";
        
		if($this->getInt('actualizar')==1){
			$this->_documentos->actualizarDublinCore($this->getSql('Dub_Titulo'),$this->getSql('Dub_Descripcion'),$this->getSql('Dub_FechaDocumento'),$this->getSql('Dub_PalabraClave'),$this->filtrarInt($registros));
			$this->_view->assign('_error', 'Datos Actualizados Correctamente');
		}
		
		
        $this->_view->assign('detalle', $this->_documentos->getDocumentos($condicion));
		$this->_view->assign('titulo', 'Base de Datos de Documentos');
        $this->_view->renderizar('editar', 'documentos');
    }
    
    public function descargar($archivo='',$idArchivo)
	{
		$this->_acl->autenticado();
        if (is_readable(ROOT_ARCHIVO_FISICO.$archivo)){
           
            $registro = $this->_documentos->registrarDescarga($_SERVER['REMOTE_ADDR'],  $this->filtrarInt($idArchivo));
            if (is_array($registro)) {
                if ($registro  [0] > 0) {                    
                    header('Location:'.URL_ARCHIVO_FISICO.$archivo);
                    exit;
                }
            } else {                
                $this->_view->assign('_error', $registro );
            }
        }        
        header('Location:'.URL_ARCHIVO_FISICO.$archivo);
    }
	
	
	
	
}
