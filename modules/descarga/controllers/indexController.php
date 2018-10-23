<?php

class indexController extends descargaController {

    private $_descarga;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_descarga = $this->loadModel('index');
    }

    public function index($pagina = false) {
        $this->_acl->acceso('listar_descarga');
        $this->validarUrlIdioma();        
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('index'));

        $listaDescarga = $this->_descarga->getListarDescarga("%", "%");
        /*Listar Año*/
        $ultimoElemento = array_pop($listaDescarga);
        //print_r($ultimoElemento);exit;
        $anoUltimo = date('Y',strtotime($ultimoElemento['Esd_Fecha']));
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
        
        $this->_view->assign('titulo', 'Lista de Descargas');
        $this->_view->renderizar('index', 'descarga');
    }
    
    public function BuscarDescarga() {
        $this->_view->getLenguaje("index_inicio");
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
        $_SESSION['Descargar']=$this->_descarga->getListarDescarga($ano, $mes);
        $paginador = new Paginador();
        $this->_view->assign('descarga', $paginador->paginar($_SESSION['Descargar'], "divListarDescarga", "$iano/$imes", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/divListarDescarga', 'descarga', true);
    }

    public function _paginacion_divListarDescarga($iano = 'todos', $imes = 'todos') {
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
        
        $paginador = new Paginador();

        $this->_view->assign('descarga', $paginador->paginar($_SESSION['Descargar'], "divListarDescarga", "$iano/$imes", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/divListarDescarga', 'descarga', true);
    }
    
    public function c_DescargasMasFrecuentes() {
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
        
        $this->_view->assign('Descarga', $this->_descarga->getObtenerDescarga($ano, $mes));
        $this->_view->assign('titulo',$titulo.' ('.$til_ano.'/'.$til_mes.')');
        $this->_view->renderizar('ajax/Descarga', 'descarga', true);
    }
    
    public function descargar_datos() {
        error_reporting(0);
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,1, 'Esd_IdDescarga');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,1, 'Esd_Fecha');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,1, 'Esd_Ip');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,1, 'Arf_IdArchivoFisico');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,1, 'Esd_CantidadDescarga');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,1, 'Esd_TipoAcceso');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,1, 'Arf_PosicionFisica');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,1, 'Taf_Descripcion');
        
        for ($i = 2; $i <= (count($_SESSION['Descargar'])+1); $i++) {
            for ($j = 0; $j < count($_SESSION['Descargar'][0]); $j++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($j, $i, $_SESSION['Descargar'][$i-2][$j]);
            }
        }            
        $objPHPExcel->getActiveSheet()->setTitle('ListaDeDescargas');
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();
        ob_start();
        //Session::destroy('encabezado');
        Session::destroy('Descargar');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="SIIGEF-OTCA_Descargas.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}

?>
