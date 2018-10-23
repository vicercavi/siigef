<?php

class indexController extends busquedaController {

    private $_busqueda;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_busqueda = $this->loadModel('index');
    }

    public function index($pagina = false) {
        $this->_acl->acceso('listar_busqueda');
        $this->validarUrlIdioma();        
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("backend_buscador");
        $this->_view->setJs(array('index'));
        
        $listaBusqueda = $this->_busqueda->getListarBusqueda("%", "%");
        /*Listar Año*/
        $ultimoElemento = array_pop($listaBusqueda);
        //print_r($ultimoElemento);exit;
        $anoUltimo = date('Y',strtotime($ultimoElemento['Esb_Fecha']));
        $hoy = getdate();
        $anoHoy = $hoy['year'];
        $listAno = array();
        $c = 0;
        for($i = $anoUltimo ; $i < $anoHoy + 1; ++$i){            
            $listAno[$c] = $i;
            $c = $c + 1;
        }
        $this->_view->assign('anoLista',$listAno);
        //Fin Listar año
        
        $this->_view->assign('titulo', 'Lista de Busquedas');
        $this->_view->renderizar('index', 'busqueda');
    }
    
    public function BuscarBusqueda() {
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("backend_buscador");
        $iano = $this->getSql('iano');
        $imes = $this->getSql('imes');
        $pagina = $this->getInt('pagina');
        if($iano=='todos'){
            $ano='%';
        }else{
            $ano=$iano;
        }
        if($imes=='todos'){
            $mes='%';
        }else{
            $mes=$imes;
        }       
        $_SESSION['Busqueda'] = $this->_busqueda->getListarBusqueda($ano, $mes);
        
        $paginador = new Paginador();
        $this->_view->assign('busqueda', $paginador->paginar($_SESSION['Busqueda'], "divListarBusqueda", "$iano/$imes", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/divListarBusqueda', 'busqueda', true);
    }

    public function _paginacion_divListarBusqueda($iano = 'todos', $imes = 'todos') {
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("backend_buscador");
        $pagina = $this->getInt('pagina');
        $registros  = $this->getInt('registros');
        
        if($iano=='todos'){
            $ano='%';
        }else{
            $ano=$iano;
        }
        if($imes=='todos'){
            $mes='%';
        }else{
            $mes=$imes;
        }
        
        $paginador = new Paginador();

        $this->_view->assign('busqueda', $paginador->paginar($this->_busqueda->getListarBusqueda($ano, $mes), "divListarBusqueda", "$iano/$imes", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/divListarBusqueda', 'busqueda', true);
    }
    
    public function c_BusquedasMasFrecuentes() {
        $iano = $this->getSql('iano');
        $imes = $this->getSql('imes');
        $titulo = $this->getSql('titulo');
        if($iano=='todos'){
            $ano='%';
            $til_ano='*';
        }else{
            $ano=$iano;
            $til_ano=$iano;
        }
        if($imes=='todos'){
            $mes='%';
            $til_mes='*';
        }else{
            $mes=$imes;
            $til_mes=$imes;
        }
        
        $this->_view->assign('Busqueda', $this->_busqueda->getObtenerBusqueda($ano, $mes));
        $this->_view->assign('titulo',$titulo.' ('.$til_ano.'/'.$til_mes.')');
        $this->_view->renderizar('ajax/Busqueda', 'busqueda', true);
    }
    
    public function descargar_datos() {
        error_reporting(0);
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,1, 'Esb_IdEstadisticaBusqueda');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,1, 'Esb_PalabraBuscada');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,1, 'Esb_Ip');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,1, 'Esb_Fecha');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,1, 'Esb_TipoAcceso');
        
        for ($i = 2; $i <= (count($_SESSION['Busqueda'])+1); $i++) {
            for ($j = 0; $j < count($_SESSION['Busqueda'][0]); $j++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($j, $i, $_SESSION['Busqueda'][$i-2][$j]);
            }
        }            
        $objPHPExcel->getActiveSheet()->setTitle('ListaDeBusquedas');
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();
        ob_start();
        //Session::destroy('encabezado');
        Session::destroy('Busqueda');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="SIIGEF-OTCA_Busquedas.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}

?>
