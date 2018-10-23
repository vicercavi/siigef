<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of indexController
 *
 * @author JHON CHARLIE
 */
class indexController extends dublincoreController{
    //put your code here
    private $_dublincore;
    
    public function __construct($lang,$url) 
    {
        parent::__construct($lang,$url);
        $this->_dublincore = $this->loadModel('dublin');
    }
    
    public function index($idRecurso = false, $nombreRecurso = false, $cantidaRegistros = false)
    {        
        $this->validarUrlIdioma();  
        //$this->_acl->acceso('usuario');
        $paginador = new Paginador();
        $this->_view->setJs(array('index'));
        $this->_view->setCss(array('listadocumentos'));
        
        $pagina = $this->getInt('pagina');
        $registros  = $this->getInt('registros');
        $this->_view->assign('nombreRecurso',$nombreRecurso);
        $condicion = "";
	          
        if($this->filtrarInt($idRecurso)>0)
        {            
            $this->_view->assign('idRecurso',$idRecurso);
            $this->_view->assign('cantidadElementos',$cantidaRegistros);
            $condicion .= " where dub.Rec_IdRecurso = $idRecurso ";
        }
        
        $this->_view->assign('documentos', $paginador->paginar($this->_dublincore->getDocumentos($condicion),"","",$pagina,$registros));
        $this->_view->assign('tipoDocumento', $this->_dublincore->getCantidadTipoDocumentos($condicion)); 
        $this->_view->assign('archivofisico', $this->_dublincore->getTipoArchivoFisico());
        $this->_view->assign('totaltipoarchivofisicos', $this->_dublincore->getCantidadDocumentosTipoArchivoFisico($condicion));
        //$this->_view->assign('totalpaises', $this->_documentos->getCantidadDocumentosPais());
        $this->_view->assign('numeropagina',$this->getInt('pagina'));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));        
        $this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('titulo', 'Base de Datos de Documentos');
        $this->_view->renderizar('index');
    }
    
    public function buscarporpalabras()
    {
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');       
        $registros  = $this->getInt('registros');
        $idRecurso = $this->getInt('idRecurso');
        
        $condicion = "";
        $condicion1 = "";
        $condicion2 = "";
	          
        if($idRecurso>0)
        {            
            $condicion1 .= " WHERE dub.Rec_IdRecurso = $idRecurso ";
        }
        if($palabra)
        {
            $condicion2 .= " AND Dub_Titulo liKe '%$palabra%' ";
        }
        
        
        $condicion = $condicion1.$condicion2;
        
        
        $paginador = new Paginador();
        $this->_view->setJs(array('index'));
        $this->_view->assign('documentos', $paginador->paginar($this->_dublincore->getDocumentos($condicion),"","", $pagina, $registros));
        //$this->_view->assign('temaDocumento', $this->_documentos->getCantidadTemaDocumentos());
        $this->_view->assign('archivofisico', $this->_dublincore->getTipoArchivoFisico());
        $this->_view->assign('totaltipoarchivofisicos', $this->_dublincore->getCantidadDocumentosTipoArchivoFisico($condicion));
        $this->_view->assign('tipoDocumento', $this->_dublincore->getCantidadTipoDocumentos($condicion)); 
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('numeropagina',$pagina);        
        $this->_view->assign('cantidadporpagina',$registros);
        $this->_view->renderizar('ajax/resultadosbusqueda', false, true);
    }
	
    public function buscarportipodocumento()
    {
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $variables_tipo = $this->getSql('variables');
        $registros  = $this->getInt('registros');
        $idRecurso = $this->getInt('idRecurso');
        
        $condicion = "";
        $condicion1 = "";
        $condicion2 = "";
        $condicion3 = "";

        if($idRecurso>0)
        {            
            $condicion1 .= " WHERE dub.Rec_IdRecurso = $idRecurso ";
        }
        if($variables_tipo)
        {
            $condicion2 .= " AND Tid_Descripcion = '$variables_tipo'";
        }
        if($palabra)
        {
            $condicion3 .= " AND Dub_Titulo LIKE '%$palabra%'";
        }

        $condicion = $condicion1.$condicion2.$condicion3;

 
        $paginador = new Paginador();
        $this->_view->setJs(array('index'));
        $this->_view->assign('documentos', $paginador->paginar($this->_dublincore->getDocumentos($condicion),"","", $pagina, $registros));
        $this->_view->assign('archivofisico', $this->_dublincore->getTipoArchivoFisico());
        $this->_view->assign('totaltipoarchivofisicos', $this->_dublincore->getCantidadDocumentosTipoArchivoFisico($condicion));
       
        $this->_view->assign('numeropagina',$this->getInt('pagina'));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));        
        $this->_view->assign('cantidadporpagina',$registros);
        $this->_view->renderizar('ajax/lista_registros', false, true);
    }	
    
    public function buscarporpais()
    {
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $variables = $this->getSql('variables');
        $tipo_archivo = $this->getSql('pais');
        $registros  = $this->getInt('registros');
        $idRecurso = $this->getInt('idRecurso');
        $condicion = "";
        $condicion1 = "";
        $condicion2 = "";
        $condicion3 = "";
        $condicion4 = "";

        if($idRecurso>0)
        {            
            $condicion1 .= " WHERE dub.Rec_IdRecurso = $idRecurso ";
        }
        if($tipo_archivo)
        {
            $condicion2 .= " AND Taf_Descripcion = '$tipo_archivo'";
        }

        if($variables)
        {
            $condicion3 .= " AND Tid_Descripcion = '$variables'";
        }

        if($palabra)
        {
            $condicion4 .= " AND Dub_Titulo LIKE '%$palabra%'";
        }

        $condicion = $condicion1.$condicion2.$condicion3.$condicion4;

   
        $paginador = new Paginador();
        $this->_view->setJs(array('index'));
        $this->_view->assign('documentos', $paginador->paginar($this->_dublincore->getDocumentos($condicion),"","", $pagina, $registros));
        //$this->_view->assign('temaDocumento', $this->_documentos->getCantidadTemaDocumentos());
        $this->_view->assign('tipoDocumento', $this->_dublincore->getCantidadTipoDocumentos($condicion)); 
        $this->_view->assign('archivofisico', $this->_dublincore->getTipoArchivoFisico());
        $this->_view->assign('totaltipoarchivofisicos', $this->_dublincore->getCantidadDocumentosTipoArchivoFisico($condicion));
       
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('numeropagina',$this->getInt('pagina'));        
        $this->_view->assign('cantidadporpagina',$registros);
        $this->_view->renderizar('ajax/resultadosbusqueda', false, true);
    }
    
    public function metadata()
    {
        $condicion = "";
        $registros  = $this->getSql('registros');
        if($registros)
        {
            $condicion .= " where dub.Dub_IdDublinCore = $registros ";
        }
        $this->_view->assign('detalle', $this->_dublincore->getDocumentos($condicion));
        $this->_view->renderizar('ajax/metadata', false, true);
    }
    
    public function _eliminarDublin(){
        
         $id_Dublin = $this->getInt('id_dublin');
         if (!empty($id_Dublin)) {
               $this->_dublincore->eliminarDublincCoreCompleto($id_Dublin);
         }else{
             echo "Faltan parametros";
         }
       
    }
}
