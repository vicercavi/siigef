<?php

class indexController extends visitasController {

    private $_visita;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_visita = $this->loadModel('index');
        
        $listaVisita = $this->_visita->getListarVisita("%", "%");
        /*Listar Año*/
        $ultimoElemento = array_pop($listaVisita);
        //print_r($ultimoElemento);exit;
        $anoUltimo = date('Y',strtotime($ultimoElemento['Vis_Fecha']));
        $hoy = getdate();
        $anoHoy = $hoy['year'];
        $listAno = array();
        $c = 0;
        for($i = $anoUltimo ; $i < $anoHoy + 1; ++$i){            
            $listAno[$c] = $i;
            $c = $c + 1;
        }
        $this->_listAno = $listAno;
    }

    public function index($pagina = false) {
        $this->_acl->acceso('listar_visita');
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('index'));
        //$this->_view->setCss(array('index'));
        $this->_view->assign('select', 1);
                
        $this->_view->assign('anoLista',$this->_listAno);
        $this->_view->assign('titulo', 'Lista de Visitas');
        $this->_view->renderizar('index', 'visita');
    }

    public function Explorador($pagina = false) {
        $this->_acl->acceso('listar_visita');
        $this->validarUrlIdioma();
        //$this->_view->setTemplate(LAYOUT_FRONTEND);
        
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('Explorador'));
       // $this->_view->setCss(array('index'));
        $this->_view->assign('select', 2);        
        
        $this->_view->assign('anoLista',$this->_listAno);
        $this->_view->assign('titulo', 'Visitas por Explorador');
        $this->_view->renderizar('tpl_Explorador', 'visita');
    }

    public function IpMasFrecuentes($pagina = false) {
        $this->_acl->acceso('listar_visita');
        $this->validarUrlIdioma();
        //$this->_view->setTemplate(LAYOUT_FRONTEND);
        
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('IpMasFrecuentes'));
       // $this->_view->setCss(array('index'));
        $this->_view->assign('select', 3);

        $this->_view->assign('anoLista',$this->_listAno);
        
        $this->_view->assign('titulo', 'Lista de Ip');
        $this->_view->renderizar('tpl_IpMasFrecuentes', 'visita');
    }

    public function OrigenesDeVisitas($pagina = false) {
        $this->_acl->acceso('listar_visita');
        $this->validarUrlIdioma();
        
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('OrigenesDeVisitas'));
        //  $this->_view->setCss(array('index'));
        $this->_view->assign('select', 4);

        $this->_view->assign('anoLista',$this->_listAno);
        
        $this->_view->assign('titulo', 'Visitas por Origenes');
        $this->_view->renderizar('tpl_OrigenesDeVisitas', 'visita');
    }

    public function BuscarVisita() {
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
        
        $paginador = new Paginador();
        $_SESSION['Visita'] = $this->_visita->getListarVisita($ano, $mes);
        
        $this->_view->assign('visita', $paginador->paginar($_SESSION['Visita'], "divListarVisita", "$iano/$imes", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('divListarVisita', 'visita', true);
    }

    public function _paginacion_divListarVisita($iano = 'todos', $imes = 'todos') {
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

        $this->_view->assign('visita', $paginador->paginar($this->_visita->getListarVisita($ano, $mes), "divListarVisita", "$iano/$imes", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('divListarVisita', 'visita', true);
    }
    
    
    public function c_PaginasMasVisitadas() {
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
        
        $this->_view->assign('PaginasMasVisitadas', $this->_visita->getObtenerPaginasMasVisitadas($ano, $mes));
        $this->_view->assign('titulo',$titulo.' ('.$til_ano.'/'.$til_mes.')');
        $this->_view->renderizar('PaginasMasVisitadas', 'visita', true);
    }

    public function c_OrigenesDeVisitas() {
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
        
        $this->_view->assign('OrigenesDeVisitas', $this->_visita->getObtenerOrigenesDeVisitas($ano, $mes));
        $this->_view->assign('titulo',$titulo.' ('.$til_ano.'/'.$til_mes.')');
        $this->_view->renderizar('OrigenesDeVisitas', 'visita', true);
    }

    public function c_IpMasFrecuentes() {
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
        
        $this->_view->assign('IpMasFrecuentes', $this->_visita->getObtenerIpMasFrecuentes($ano, $mes));
        $this->_view->assign('titulo',$titulo.' ('.$til_ano.'/'.$til_mes.')');
        $this->_view->renderizar('IpMasFrecuentes', 'visita', true);
    }

    public function c_Explorador() {
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
        
        $this->_view->assign('Explorador', $this->_visita->getObtenerExplorador($ano, $mes));
        $this->_view->assign('titulo',$titulo.' ('.$til_ano.'/'.$til_mes.')');
        $this->_view->renderizar('Explorador', 'visita', true);
    }
    
    public function descargar_datos() {
        error_reporting(0);
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,1, 'Vis_IdVisita');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,1, 'Vis_Explorador');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,1, 'Vis_Fecha');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,1, 'Vis_PaginaVisita');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,1, 'Vis_PaginaAnterior');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,1, 'Vis_SistemaOperativo');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,1, 'Vis_Idioma');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,1, 'Vis_Ip');
        
        for ($i = 2; $i <= (count($_SESSION['Visita'])+1); $i++) {
            for ($j = 0; $j < count($_SESSION['Visita'][0]); $j++) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($j, $i, $_SESSION['Visita'][$i-2][$j]);
            }
        }            
        $objPHPExcel->getActiveSheet()->setTitle('ListaDeVisitas');
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();
        ob_start();
        //Session::destroy('encabezado');
        Session::destroy('Visita');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="SIIGEF-OTCA_Visitas.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}

?>
