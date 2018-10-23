<?php

class legalController extends legislacionController 
{
    private $_legal;

    public function __construct($lang, $url)
    {
        parent::__construct($lang, $url);
        $this->_legal = $this->loadModel('legal');
        $this->_registro = $this->loadModel('registrar');
    }

    public function index($palabra="%",$tipo="%",$pais="%") 
	{
        #$this->_acl->autenticado();
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("bdlegal");
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $paginador = new Paginador();
        $this->_view->setJs(array('legal'));
        $this->_view->setCss(array('legal'));
		$idioma = Cookie::lenguaje();
		
        if(trim($palabra)=="all")
            $palabra="%";

        if(trim($tipo)=="all")
            $tipo="%";

        if(trim($pais)=="all")
            $pais="%";

        //CUENTA EL NUMERO DE PALABRAS 
        $trozosPalabra = explode(" ",$palabra); 
        $numero = count($trozosPalabra);

        if ($numero == 1) {
            
            $condicion = " where mal_estado = 1 and rec.Rec_Estado = 1 
                    AND (fn_TraducirContenido('matriz_legal','Mal_Titulo',mal.Mal_IdMatrizLegal,'$idioma',mal.Mal_Titulo) LIKE '%$palabra%' 
                    OR Mal_Entidad LIKE '%$palabra%' 
                    OR  fn_TraducirContenido('tipo_legal','Til_Nombre',til.Til_IdTipoLegal,'$idioma',til.Til_Nombre) LIKE '%$palabra%' 
                    OR fn_TraducirContenido('matriz_legal','Mal_ResumenLegislacion',mal.Mal_IdMatrizLegal,'$idioma',mal.Mal_ResumenLegislacion)  LIKE '%$palabra%' 
                    OR fn_TraducirContenido('matriz_legal','Mal_PalabraClave',mal.Mal_IdMatrizLegal,'$idioma',mal.Mal_PalabraClave)  LIKE '%$palabra%') 
                    AND pai.Pai_Nombre LIKE '$pais' 
                    AND til.Til_Nombre LIKE '$tipo' ";

        } elseif ($numero > 1) {

            $condicion = "  WHERE Mal_Estado = 1 AND rec.Rec_Estado = 1
                        AND ((MATCH(Mal_Titulo, Mal_PalabraClave, Mal_ResumenLegislacion, Mal_Entidad) AGAINST ('%" . $palabra . "%' IN BOOLEAN MODE))
                            OR  fn_TraducirContenido('tipo_legal','Til_Nombre',til.Til_IdTipoLegal,'$idioma',til.Til_Nombre) LIKE '%$palabra%') 
                        AND pai.Pai_Nombre LIKE '$pais' 
                        AND til.Til_Nombre LIKE '$tipo' ";
        }


		$registro = 25;
        
		$this->_view->assign('legislacion', $paginador->paginar($this->_legal->getLegislaciones($condicion,$idioma), "","","",$registro));
        
		$this->_view->assign('palabrabuscada', ($palabra=="%")?"":$palabra);
        $this->_view->assign('tipo',$tipo);
        $this->_view->assign('pais',$pais);

        $this->_view->assign('totalregistros', $this->_legal->getLegislaciones($condicion,$idioma));
        
		$this->_view->assign('tipolegislacion', $this->_legal->getCantidadTipoLegislacionV2($condicion,$idioma));
        
		$this->_view->assign('totalpaises', $this->_legal->getCantidadLegislacionPaisV2($condicion,$idioma));
        
		$this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        
		$this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        
		$this->_view->assign('titulo', 'Base de Datos Legal');
        
		$this->_view->renderizar('index', 'legal');
    }

    public function buscarporpalabras()
	{
        $this->_acl->autenticado();
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('palabra');
        $tipo=$this->getSql('tipo');
        $pais=$this->getSql('pais');        

        $this->_view->getLenguaje("bdlegal");
        $this->_view->setTemplate(LAYOUT_FRONTEND);
		$idioma = Cookie::lenguaje();
		$registro = 25;

        if(trim($palabra)=="all")
            $palabra="%";
        if(trim($tipo)=="all")
            $tipo="%";
        if(trim($pais)=="all")
            $pais="%";		
        
        $condicion = "where mal_estado = 1 and rec.Rec_Estado = 1 
                AND (fn_TraducirContenido('matriz_legal','Mal_Titulo',mal.Mal_IdMatrizLegal,'$idioma',mal.Mal_Titulo) LIKE '%$palabra%' OR Mal_Entidad LIKE '%$palabra%' OR  fn_TraducirContenido('tipo_legal','Til_Nombre',til.Til_IdTipoLegal,'$idioma',til.Til_Nombre) LIKE '%$palabra%' OR fn_TraducirContenido('matriz_legal','Mal_ResumenLegislacion',mal.Mal_IdMatrizLegal,'$idioma',mal.Mal_ResumenLegislacion)  LIKE '%$palabra%' OR fn_TraducirContenido('matriz_legal','Mal_PalabraClave',mal.Mal_IdMatrizLegal,'$idioma',mal.Mal_PalabraClave)  LIKE '%$palabra%') 
                AND pai.Pai_Nombre LIKE '$pais' 
                AND til.Til_Nombre LIKE '$tipo' ";
        
        $paginador = new Paginador();
        $this->_view->setJs(array('legal'));
        
		$this->_view->assign('legislacion', $paginador->paginar($this->_legal->getLegislaciones($condicion,$idioma),"resultados","",$pagina,$registro));
        
		$this->_view->assign('totalregistros', $this->_legal->getLegislaciones($condicion,$idioma));
        
		$this->_view->assign('totalpaises', $this->_legal->getCantidadLegislacionPais($idioma));
		
		$this->_view->assign('palabrabuscada', $this->getSql('palabra'));
        
		$this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        
		$this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        
	   $this->_view->renderizar('ajax/resultados', false, true);
    }

    public function buscarportipolegislacion()
	{
        $this->_acl->autenticado();
        $this->_view->getLenguaje("bdlegal");
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('palabra');
        $idioma = Cookie::lenguaje();
        $registro = 25;

        $condicion = "";
        
        if ($palabra) 
        {
            $condicion .= " WHERE mal_estado = 1 and rec.Rec_Estado = 1 and fn_TraducirContenido('tipo_legal','Til_Nombre',til.Til_IdTipoLegal,'$idioma',til.Til_Nombre) = '$palabra' ";
        }
        
        $paginador = new Paginador();

        $this->_view->setJs(array('legal'));
        
        $this->_view->assign('legislacion', $paginador->paginar($this->_legal->getLegislaciones($condicion,$idioma),"resultados","",$pagina,$registro));
        
        $this->_view->assign('totalregistros', $this->_legal->getLegislaciones($condicion,$idioma));
        
        $this->_view->assign('totalpaises', $this->_legal->getCantidadLegislacionPais($idioma));
        
		$this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        
		$this->_view->assign('palabrabuscada', '');
        
		$this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        
		$this->_view->renderizar('ajax/resultados', false, true);
    }

    public function buscarporpais()
	{
        $this->_acl->autenticado();
        $this->_view->getLenguaje("bdlegal");
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('palabra');
		$idioma = Cookie::lenguaje();
        $condicion = " where mal_estado = 1 and rec.Rec_Estado=1";
        
		if ($palabra) 
        {
            $condicion .= " AND Pai_Nombre = '$palabra'";        
		}

        $paginador = new Paginador();

        $this->_view->setJs(array('legal'));
        
		$this->_view->assign('legislacion', $paginador->paginar($this->_legal->getLegislaciones($condicion,$idioma),"resultados","", $pagina,25));
        
		$this->_view->assign('totalregistros', $this->_legal->getLegislaciones($condicion,$idioma));
        
        $this->_view->assign('totalpaises', $this->_legal->getCantidadLegislacionPais($idioma));
        
		$this->_view->assign('numeropagina', $paginador->getNumeroPagina());
		
		$this->_view->assign('palabrabuscada', '');
        
		$this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        
		$this->_view->renderizar('ajax/resultados', false, true);
    }

    public function metadata($Mal_IdMatrizLegal)
	{

        $this->_acl->autenticado();
        $this->_view->getLenguaje("bdlegal");
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->validarUrlIdioma();
		$this->_view->getLenguaje("bdrecursos_metadata");
		$idioma = Cookie::lenguaje();
		$e = $this->loadModel('bdrecursos', true);
		
		$condicion = "";

        if ($this->_acl->permiso("habilitar_deshabilitar_registros_recurso"))
        {
            $condicion .= "WHERE rec.Rec_Estado = 1 and m.Mal_IdMatrizLegal = $Mal_IdMatrizLegal ";            
        }
        else
        {
            $condicion .= "WHERE m.Mal_Estado=1 and rec.Rec_Estado = 1 and m.Mal_IdMatrizLegal = $Mal_IdMatrizLegal ";            
        }
        
		$Mal_IdMatrizLegal = $this->filtrarInt($Mal_IdMatrizLegal);
        
		//$condicion .= "WHERE m.Mal_Estado=1 and rec.Rec_Estado = 1 and m.Mal_IdMatrizLegal = $Mal_IdMatrizLegal ";
		$metadatalegislacion = $this->_legal->getLegislacionesMetadata($condicion,$idioma);

        if(!empty($metadatalegislacion))
        {
            $metadatarecurso = $e->getRecursoCompletoXid($metadatalegislacion[0]['Rec_IdRecurso']);
            $this->_view->assign('recurso', $metadatarecurso);
            $this->_view->assign('detalle', $metadatalegislacion);        
            $this->_view->assign('titulo', "Legislacion - ".$metadatalegislacion[0]['Mal_Titulo']);

            $this->_view->renderizar('metadata', 'legal');
        }
        else
        {
            echo 'Debe pasar como parametro el id del registro o el recurso no ha sido encontrado';
        }
    }
}

?>
