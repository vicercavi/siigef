<?php
class botanicoController extends Controller{
 
    private $_botanico;
    
    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_botanico = $this->loadModel('botanico');
    }
    
    public function index($pagina = false)
    {        
		$this->_acl->autenticado();
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("atlas_botanico");
		$this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->setJs(array('botanico'));
		$pagina = $this->getInt('pagina');
		$paginador = new Paginador();
		$this->_view->assign('registros', $paginador->paginar($this->_botanico->getPlinian(),"","","",25)); 
		$this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());		 
		$this->_view->assign('cantidad', $this->_botanico->getcantRegistrosPlinian());
        $this->_view->assign('titulo', 'Atlas Botánico');
        $this->_view->renderizar('index','botanico');
    }
    
    public function buscarporpalabras()
    {
        $this->_acl->autenticado();
        $this->_view->setTemplate(LAYOUT_FRONTEND);
		$this->_view->getLenguaje("atlas_botanico");
		$pagina = $this->getInt('pagina');
        $paginador = new Paginador();
        $this->_view->setJs(array('botanico'));
        $this->_view->assign('registros', $paginador->paginar($this->_botanico->getPlinian($this->getSql('palabra')),"resultado","", $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('numeropagina',$this->getInt('pagina'));
		$this->_view->assign('palabra',$this->getSql('palabra'));
		$this->_view->assign('cantidad', $this->_botanico->getcantRegistrosPlinian($this->getSql('palabra')));
		$this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/resultadosbusqueda', false, true);
    }

    public function metadata($registro)
    {   
        $this->_acl->autenticado();     
		$this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->getLenguaje("atlas_botanico");
		$this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $registros  = $this->filtrarInt($registro);
		$this->_view->getLenguaje("bdrecursos_metadata");
		$e = $this->loadModel('bdrecursos', true);
        $metadatabotanico = $this->_botanico->getMetadata($registros);
        
		
		$metadatarecurso = $e->getRecursoCompletoXid($metadatabotanico['Rec_IdRecurso']);
        $this->_view->assign('recurso', $metadatarecurso);
		$this->_view->assign('datos', $metadatabotanico );
		$this->_view->assign('titulo', 'Atlas Botánico');
        $this->_view->renderizar('metadata','botanico');
    }

    public function _getJsonAtlasBotanico($pbuscar=false) 
    {        
        $lbotanico = $this->_botanico->getPlinian($pbuscar);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");

        echo json_encode($lbotanico);
    }
    public function _getJsonAtlasMetaBotanico($idRegistro) {
        
        $lmetabotanico = $this->_botanico->getMetadata($idRegistro);
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        echo json_encode($lmetabotanico);
    }
}
