<?php

class indexController extends bitacoraController {

    private $_bitacora;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_bitacora = $this->loadModel('index');
    }

    public function index($pagina = false) {
        $this->_acl->acceso('listar_bitacora');
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('index'));
        $ano = '%'; $iano='todos';
        $mes = '%'; $imes='todos';
        $paginador = new Paginador();
        $listaBitacora = $this->_bitacora->getListarBitacoraErrores($ano, $mes);
        
        /*Listar Año*/
        $ultimoElemento = array_pop($listaBitacora);
        $anoUltimo = date('Y',strtotime($ultimoElemento['Bit_Fecha']));
        $hoy = getdate();
        $anoHoy = $hoy['year'];
        $listAno = array();
        $c = 0;
        for($i = $anoUltimo ; $i < $anoHoy + 1; ++$i){            
            $listAno[$c] = $i;
            $c = $c + 1;
        }
        //Fin Listar año
        $_SESSION['Bitacora'] = $listaBitacora;
        //print_r($listaBitacora);exit;
        $this->_view->assign('bitacora', $paginador->paginar($listaBitacora, "divListarBitacoraErrores", "$iano/$imes", $pagina, 25));
        $this->_view->assign('anoLista',$listAno);
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());        
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('titulo', 'Lista de Errores');
        $this->_view->renderizar('index', 'bitacora');
    }
    public function _paginacion_divListarBitacoraErrores($iano = 'todos', $imes = 'todos') {
        $this->_view->getLenguaje("index_inicio");
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
        $_SESSION['Bitacora'] = $this->_bitacora->getListarBitacoraErrores($ano, $mes);
        $paginador = new Paginador();

        $this->_view->assign('bitacora', $paginador->paginar($_SESSION['Bitacora'], "divListarBitacoraErrores", "$iano/$imes", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/divListarBitacoraErrores', 'bitacora', true);
    }
    
    public function BuscarErrores() {
        $iano = $this->getSql('iano');
        $imes = $this->getSql('imes');
        $this->_view->getLenguaje("index_inicio");
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
        $_SESSION['Bitacora'] = $this->_bitacora->getListarBitacoraErrores($ano, $mes);
        $paginador = new Paginador();
        
        $this->_view->assign('bitacora', $paginador->paginar($_SESSION['Bitacora'], "divListarBitacoraErrores", "$iano/$imes", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());        
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/divListarBitacoraErrores', 'bitacora', true);
    }
    
    public function ErroresComunes() {
        $iano = $this->getSql('iano');
        $imes = $this->getSql('imes');
        $pagina = $this->getInt('pagina');
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
        
        $paginador = new Paginador();
        
        $this->_view->assign('ErroresComunes', $paginador->paginar($this->_bitacora->getObtenerErroresMasComunes($ano, $mes), "divListarErroresComunes", "$iano/$imes", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());        
        $this->_view->assign('titulo',$titulo.' ('.$til_ano.'/'.$til_mes.')');
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/ErroresComunes', 'bitacora', true);
    }
    
    public function PaginaErrores() {
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
        
        $this->_view->assign('PaginaErrores', $this->_bitacora->getObtenerPaginasConMasErrores($ano, $mes));
        $this->_view->assign('titulo',$titulo.' ('.$til_ano.'/'.$til_mes.')');
        $this->_view->renderizar('ajax/PaginaErrores', 'bitacora', true);
    }
    
    public function descargar_datos() {

        error_reporting(0);
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,1, 'Bit_IdBitacora');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,1, 'Evs_Tipo');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,1, 'Evs_Descripcion');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,1, 'Bit_NombrePagina');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,1, 'Bit_Fecha');
        /*
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,1, 'Esd_TipoAcceso');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,1, 'Arf_PosicionFisica');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,1, 'Taf_Descripcion');*/
        
        for ($i = 2; $i <= (count($_SESSION['Bitacora'])+1); $i++) {
            for ($j = 0; $j < count($_SESSION['Bitacora'][0]); $j++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($j, $i, $_SESSION['Bitacora'][$i-2][$j]);
            }
        }            
        $objPHPExcel->getActiveSheet()->setTitle('ListaDeBitacora');
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();
        ob_start();
        //Session::destroy('encabezado');
        Session::destroy('Bitacora');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="SIIGEF-OTCA_Bitacora.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    
    
}

?>
