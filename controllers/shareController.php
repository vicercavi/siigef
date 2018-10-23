<?php

class shareController extends Controller
{
	private $_share;

	public function __construct($lang, $url)
	{
		parent::__construct($lang, $url);
        $this->_bdrecursos = $this->loadModel('bdrecursos');
        //$this->_import = $this->loadModel('import');
        //$this->_estandar = $this->loadModel('index', 'estandar');  
	}

	public function index()
    {
       $this->validarUrlIdioma();
    }
    
	public function json($tabla = '')
	{	
		$this->_acl->autenticado();
		$this->validarUrlIdioma();
		$this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->assign('titulo', 'Compartir datos JSON');

        if($tabla!='')
        {
        	header('Content-Type: application/json');
        	echo json_encode($this->mostrar_recursos());        	
        }
        else
        {
        	$this->_view->renderizar('json','share');
        }
        
	}

	public function mostrar_recursos()
	{
		$recursos = $this->_bdrecursos->getRecursos();
		return $recursos;
	}
}

?>