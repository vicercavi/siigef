<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mapaController
 *
 * @author ROCAVI
 */
class monitoreoController extends Controller {

    private $_mapa;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_mapa = $this->loadModel('mapa', true);
    }

    private $_mapasM;
    private $_xml_wms;

    public function index() {
        $this->_view->assign('titulo', 'Visualizador GEF');
        $this->_view->setJs(array(
            array('https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true', true),
            array(BASE_URL . "public/js/googlemaps.js", false),
            array(BASE_URL . "public/js/document_ready.js", false),
            'areatematica',
            'document_ready',
            'acordeon'));
        $this->_view->setCss(array(
            'acordeon',
            array(BASE_URL . "public/css/visor.css", true)
        ));

        $this->_view->assign('variables', $this->_mapa->tiposParamCompletoPorpais());
        $this->_view->assign('tematicas', $this->_jerarquiacompletoLibres());
        $this->_view->assign('pais', $this->_mapa->listarPaisMonitoreo());
        $this->_view->renderizar('index', 'mapa');
    }

    public function estacion($idestacion = false) {
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Estacion de Monitoreo');
        $this->_view->setJs(array(
            'document_ready',
        ));
        $this->_view->setCss(array(
            array(BASE_URL . "public/css/visor.css", true)));
        $paginador = new Paginador();


        if ($this->filtrarInt($idestacion)) {
            $this->_view->assign("estadoeca", $this->_mapa->listarEstadoECA());
            $this->_view->assign("estacion", $this->_mapa->EstacionPorId($this->filtrarInt($idestacion)));
            $this->_view->assign("variables", $paginador->paginar($this->_mapa->VariablesPorEstacion($this->filtrarInt($idestacion), ""), "estacion_lista_variables", $this->filtrarInt($idestacion), false, 25));
            $this->_view->assign('paginacion_variables', $paginador->getView('paginacion_ajax', false));
        } else {
            $this->_view->assign("estaciones", $paginador->paginar($this->_mapa->puntosPorPais("", ""), "estacion_lista_estacion", "", false, 25));
            $this->_view->assign('paginacion_estaciones', $paginador->getView('paginacion_ajax', false));
        }



        $this->_view->renderizar('estacion', 'mapa');
    }

    public function variable($idvariable = false) {
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Variable de Estudio');
        $this->_view->setJs(array(
            'document_ready',
        ));
        $this->_view->setCss(array(
            array(BASE_URL . "public/css/visor.css", true)));
        $paginador = new Paginador();
        if ($this->filtrarInt($idvariable)) {
            $this->_view->assign("estadoeca", $this->_mapa->listarEstadoECA());
            $this->_view->assign("variable", $this->_mapa->VariablesPorId($this->filtrarInt($idvariable)));
            $this->_view->assign("estaciones", $paginador->paginar($this->_mapa->EstacionPorVariable($this->filtrarInt($idvariable), ""), "variable_lista_estacion", $this->filtrarInt($idvariable), false, 25));
            $this->_view->assign('paginacion_estaciones', $paginador->getView('paginacion_ajax', false));
        } else {
            $this->_view->assign("estaciones", $paginador->paginar($this->_mapa->puntosPorPais("", ""), "estacion_lista_estacion", "", false, 5));
            $this->_view->assign('paginacion_estaciones', $paginador->getView('paginacion_ajax', false));
        }



        $this->_view->renderizar('variable', 'mapa');
    }

    public function _puntosPorPais() {
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        if ($this->getPostParam('parametro')) {
            // echo count(json_decode($this->getPostParam('parametro')));
            $datos = $this->_mapa->PuntosCompletoPorpais(
                    json_decode($this->getPostParam('pais')), json_decode($this->getPostParam('parametro'))
            );
            echo json_encode($datos);
            exit;
        }
        echo json_encode("{0:Faltan Parametros}");
    }

    public function _ListarPais() {
        // echo count(json_decode($this->getPostParam('parametro')));
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        $datos = $this->_mapa->listarPais();
        echo json_encode($datos);
    }

    public function _listarVariables() {

        header('Access-Control-Allow-Origin: *');
        $this->_view->assign('variables', $this->_mapa->tiposParamCompletoPorpais());
        $this->_view->renderizar('ajax/index_lista_variables', false, true);
    }

    public function _parametrosCompletoPorPais() {

        header('Access-Control-Allow-Origin: *');
        $datos = array();
        if ($this->getPostParam('pais')) {
            // echo count(json_decode($this->getPostParam('parametro')));
            $datos = $this->_mapa->tiposParamCompletoPorpais(
                    json_decode($this->getPostParam('pais'))
            );
        }
        $this->_view->assign('variables', $datos);
        $this->_view->renderizar('ajax/index_lista_variables', false, true);
    }

    public function _listartipocapa($pais) {
        $arreglo = [$pais];

        print_r($this->_mapa->tiposCapasCompletoPorPais($arreglo));
    }

    public function _capasCompletoPorPais() {
        header('Access-Control-Allow-Origin: *');
        $datos = array();
        if ($this->getPostParam('pais')) {
            // echo count(json_decode($this->getPostParam('parametro')));
            $datos = $this->_mapa->tiposCapasCompletoPorPais(
                    json_decode($this->getPostParam('pais'))
            );
        }
        $this->_view->assign('tematicas', $datos);
        $this->_view->renderizar('ajax/index_lista_tematica', false, true);
    }

    public function _exportaEstacionMonitoreo($idestacion, $idvars) {
        header('Access-Control-Allow-Origin: *');
        if ($this->filtrarInt($idestacion)) {
            $idvars = explode(',', $idvars);
            $temidvars = array();

            for ($i = 0; $i < count($idvars); $i++) {
                if ($idvars[$i] != "") {
                    array_push($temidvars, $idvars[$i]);
                }
            }
            if (count($temidvars) > 0) {

                ini_set("memory_limit", "500M"); // set your memory limit in the case of memory problem

                $objPHPExcel = new PHPExcel();
                $objPHPExcel->createSheet(1);
                $objPHPExcel->createSheet(2);
                // Set document properties
                $objPHPExcel->getProperties()->setCreator("SII - OTCA")
                        ->setLastModifiedBy("IIAP")
                        ->setTitle("Office 2007 XLSX Test Document")
                        ->setSubject("Office 2007 XLSX Test Document")
                        ->setDescription("Datos de calidad de agua")
                        ->setKeywords("office 2007 openxml php")
                        ->setCategory("Export punto estudio");

                /** connection with the database 1.0 */
                /** Query 1.0 */
                $result = $this->_mapa->VariablesCompletoPorEstacioncion(
                        $idestacion, $temidvars);

                //echo ($result["estacion"]["EstacionId"]);
                //Datos de la Estacion
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->setCellValue("A1", "Estacion " . $result["estacion"]["nombrePunto"]);
                $objPHPExcel->getActiveSheet()->setCellValue("A2", $result["estacion"]["Pais"] . ", " . $result["estacion"]["nombreCuenca"]);
                $objPHPExcel->getActiveSheet()->setCellValue("A3", "Latitud: " . $result["estacion"]["LatitudGM"]);
                $objPHPExcel->getActiveSheet()->setCellValue("A4", "Longitud: " . $result["estacion"]["LongitudGM"]);
                $objPHPExcel->getActiveSheet()->setTitle('Estacion');

                //datos de Leyenda
                $objPHPExcel->setActiveSheetIndex(2);
                $objPHPExcel->getActiveSheet()->setTitle('Leyenda');

                $rowNumber = 1; //start in cell 1
                foreach ($result["estadoeca"] as $row) {                   // print_r($valor);
                    $objPHPExcel->getActiveSheet()->setCellValue("A" . $rowNumber, $row["ese_nombre"]);
                    $objPHPExcel->getActiveSheet()->setCellValue("B" . $rowNumber, $row["ese_color"]);

                    $rowNumber++;
                }

                //datos de Variable
                $objPHPExcel->setActiveSheetIndex(1);
                $objPHPExcel->getActiveSheet()->setTitle('Datos');


                $objPHPExcel->getActiveSheet()->setCellValue("A2", "Variable");
                $objPHPExcel->getActiveSheet()->setCellValue("B2", "Und");
                $objPHPExcel->getActiveSheet()->setCellValue("C2", "Valor");
                $objPHPExcel->getActiveSheet()->setCellValue("D2", "Estado");
                $objPHPExcel->getActiveSheet()->setCellValue("E2", "Colecta");
                $rowNumber = 3; //start in cell 1
                foreach ($result["estacion"]["params"] as $row) {

                    $objPHPExcel->getActiveSheet()->setCellValue("A" . $rowNumber, $row["nombreParametro"]);
                    $objPHPExcel->getActiveSheet()->setCellValue("B" . $rowNumber, $row["unidadMedida"]);
                    $objPHPExcel->getActiveSheet()->setCellValue("C" . $rowNumber, $row["ParametroCantidad"]);
                    $objPHPExcel->getActiveSheet()->setCellValue("D" . $rowNumber, $row["EstadoECA"]);
                    $objPHPExcel->getActiveSheet()->setCellValue("E" . $rowNumber, $row["fecha"]);


                    $rowNumber++;
                }



// Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $objPHPExcel->setActiveSheetIndex(1);
                //  echo $objPHPExcel->getSheetCount();
// Redirect output to a client’s web browser (Excel5)
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="SIIVisorCalidadAgua' . gmdate(' d M Y') . '.xls"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
                exit;
            }
        }

        /** Set Memory Limit 1.0 */
    }

    public function _asignarcapamonitoreo() {
        $resultado = array();
        $mensaje = "error";
        $contenido = "";


        if ($this->getInt("jerarquia") && $this->getInt("capa")) {

            $idwms = $this->_mapa->asignarCapaMonitoreo(
                    $this->getInt("jerarquia"), $this->getInt("capa"), $this->getInt("pais"));
            $mensaje = "ok";
            $contenido = "Se asigno con exito la capa";
            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
        } else {
            $mensaje = "error";
            $contenido = "Seleccione el Pais";
            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
        }
        echo json_encode($resultado);
    }

    public function _quitarcapamonitoreo() {
        $resultado = array();
        $mensaje = "error";
        $contenido = "";


        if ($this->getInt("jerarquia") && $this->getInt("capa")) {

            $idwms = $this->_mapa->eliminarCapaMonitoreo(
                    $this->getInt("jerarquia"), $this->getInt("capa"));
            $mensaje = "ok";
            $contenido = "Se Elimino con exito la capa";
            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
        } else {
            $mensaje = "error";
            $contenido = "Seleccione el Pais";
            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
        }
        echo json_encode($resultado);
    }

    public function _quitar_jerarquia_monitoreo() {
        $resultado = array();
        $mensaje = "error";
        $contenido = "";


        if ($this->getInt("jerarquia")) {

            $idwms = $this->_mapa->eliminarJerarquiaMonitoreo(
                    $this->getInt("jerarquia"));
            $mensaje = "ok";
            $contenido = "Se Elimino con exito la capa";
            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
        } else {
            $mensaje = "error";
            $contenido = "Seleccione el Pais";
            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
        }
        echo json_encode($resultado);
    }

    private function _jerarquiacompleto() {
        $jerarquia = $this->_mapa->listarJerarquiaMonitoreo();
        for ($index = 0; $index < count($jerarquia); $index++) {
            $jerarquia[$index]["capas"] = $this->_mapa->listarCapaWmsJerarquia($jerarquia[$index]["Jem_IdJerarquiaCapa"]);
        }
        return $jerarquia;
    }

    private function _jerarquiacompletoLibres() {
        $jerarquia = $this->_mapa->listarJerarquiaMonitoreoLibres();
        for ($index = 0; $index < count($jerarquia); $index++) {
            $jerarquia[$index]["capas"] = $this->_mapa->listarCapaWmsJerarquia($jerarquia[$index]["Jem_IdJerarquiaCapa"]);
        }
        return $jerarquia;
    }

}
