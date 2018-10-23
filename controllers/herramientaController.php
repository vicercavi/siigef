<?php

class herramientaController extends Controller 
{
    private $_bdherramieenta;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_bdherramieenta = $this->loadModel('herramienta');
    }

    public function index($idherramienta = false) 
    {
        $this->_acl->acceso("listar_herramienta");
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("template_backend");
        $this->_view->getLenguaje("herramienta_index");
        $paginador = new Paginador();
        $this->_view->setJs(array("document_ready"));
        $this->_view->assign('titulo', 'Herramientas SII');

        if ($this->filtrarInt($idherramienta) && $this->_acl->permiso("editar_herramienta")) 
        {
            if ($this->botonPress("bt_registrar")) 
            {
                if ($this->getTexto("tb_nombre") && $this->getTexto("tb_abreviatura") && $this->getTexto("tb_descripcion")) 
                {
                    $this->_bdherramieenta->actualizarHerramientaCompleto($this->filtrarInt($idherramienta), $this->getTexto("tb_nombre"), $this->getTexto("tb_descripcion"), $this->getTexto("tb_abreviatura"), 1, $this->getTexto("rb_idioma"));
                } 
                else 
                {
                    $this->_view->assign('_error', "Ingrese los datos obligatorios *");
                }
            }

            $this->_view->assign('herramienta', $this->_bdherramieenta->getHerramientaXid($this->filtrarInt($idherramienta)));
        } 
        else if ($this->botonPress("bt_registrar") && $this->_acl->permiso("agregar_herramienta")) 
        {
            if ($this->getTexto("tb_nombre") && $this->getTexto("tb_abreviatura") && $this->getTexto("tb_descripcion")) 
            {
                $idregistro = $this->_bdherramieenta->insertarHerramienta($this->getTexto("tb_nombre"), $this->getTexto("tb_descripcion"), $this->getTexto("tb_abreviatura"), 1, $this->getTexto("rb_idioma"));

                if (count($idregistro) && $idregistro[0] > 0) 
                {
                    $this->_view->assign('_mensaje', "Se registro con éxito los datos");
                }
            } 
            else 
            {
                $this->_view->assign('_error', "Ingrese los datos obligatorios *");
            }
        }

        $bdarquitectura = $this->loadModel('index', 'arquitectura');
        $this->_view->assign('idioma', Cookie::lenguaje());
        $this->_view->assign('idiomas', $bdarquitectura->getIdiomas());
        $this->_view->assign('herramientas', $paginador->paginar($this->_bdherramieenta->getHerramientaTraducido("", Cookie::lenguaje()), "index_lista_herramienta", "", false, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('index', 'mapa');
    }

    public function estructura($idherramienta = false, $idestructura = false) 
    {
        $this->_acl->acceso("editar_estructura_herramienta");
        $this->validarUrlIdioma();        
        $this->_view->getLenguaje("index_inicio");
        $this->_view->assign('titulo', 'Estructura Herramientas SII');
        $this->_view->setJs(array("document_ready"));
        $this->_view->setCss(array("gestor_estructura"));

        $paginador = new Paginador();

        if ($this->filtrarInt($idherramienta)) 
        {
            if ($this->botonPress("bt_registrar")) 
            {
                if ($this->getTexto("tb_nombre") && $this->getInt("tb_orden") && $this->getTexto("tb_descripcion")) 
                {
                    $idioma = "es";
                    if (empty($idestructura)) 
                    {
                        $idioma = $this->getTexto("rb_idioma");
                    } 
                    else 
                    {
                        $idioma = $this->getTexto("hd_idioma_defecto");
                    }

                    $predeterminado = 1;

                    if (empty($this->getTexto("cb_he_predeterminado"))) 
                    {
                        $predeterminado = 0;
                    }

                    $idregistro = $this->_bdherramieenta->insertarEstructuraH($this->filtrarInt($idherramienta), $idestructura, $this->getTexto("tb_nombre"), $this->getTexto("tb_titulo"), $this->getTexto("tb_descripcion"), $this->getTexto("tb_columna"), $this->getInt("tb_orden")
                            , 1, $predeterminado, $idioma
                    );

                    if (count($idregistro) && $idregistro[0] > 0)
                    {
                        $this->_view->assign('_mensaje', "Se registro con éxito los datos");
                    }
                } 
                else 
                {
                    $this->_view->assign('_error', "Ingrese los datos obligatorios *");
                }

            } 
            else if ($this->botonPress("bt_actualizar")) 
            {
                if ($this->getTexto("tb_nombre_edit") && $this->getInt("tb_orden_edit") && $this->getTexto("tb_descripcion_edit")) 
                {
                    $predeterminado = 1;
                    if (empty($this->getTexto("cb_he_predeterminado"))) 
                    {
                        $predeterminado = 0;
                    }

                    $this->_bdherramieenta->actualizarEstructuraHCompleto(
                            $this->filtrarInt($idestructura), $this->getTexto("tb_nombre_edit"), $this->getTexto("tb_titulo_edit"), $this->getTexto("tb_descripcion_edit"), $this->getTexto("tb_columna_edit"), $this->getInt("tb_orden_edit")
                            , 1, $predeterminado, $this->getTexto("rb_idioma_padre")
                    );
                } 
                else 
                {
                    $this->_view->assign('_error', "Ingrese los datos obligatorios *");
                }
            } 
            else if ($this->botonPress("bt_procesar")) 
            {
                if ($this->_verificarFileType('fl_excel')) 
                {
                    $arbol = $this->_leerExcel($_FILES['fl_excel']['tmp_name']);

                    if (isset($arbol) && count($arbol)) 
                    {
                        $this->_bdherramieenta->insertarArbolEstructuraH($this->filtrarInt($idherramienta), $idestructura, $arbol, 1, 0, "es");
                    } 
                    else 
                    {
                        $this->_view->assign('_error', "Archivo sin datos o estructura del excel incorrecto");
                    }

                } 
                else 
                {
                    $this->_view->assign('_error', "Tipo de archivo invalido");
                }
            } 
            else if ($this->botonPress("bt_generar_menu")) 
            {
                //ini_set("memory_limit","40480M");
                $menu = $this->_bdherramieenta->listarArbolArbolEstructuraHVisor($this->filtrarInt($idherramienta));

                $rutacorta = 'public' . DS . 'json' . DS . 'menu_herramienta' . DS;
                $ruta = ROOT . $rutacorta;
                $json_string = json_encode($menu);
                $file = 'menuherramineta_' . $this->filtrarInt($idherramienta) . '.json';
                file_put_contents($ruta . $file, $json_string);
                $this->_bdherramieenta->actualizarUrlMenuHerramienta($this->filtrarInt($idherramienta), $rutacorta . $file);

                $this->_view->assign('_mensaje', "Se generó con exito el menu del visor");
            }

            if ($this->filtrarInt($idestructura)) 
            {
                $padreestructura = $this->_bdherramieenta->getEstructuraHXId($this->filtrarInt($idestructura));
                if (isset($padreestructura) && !empty($padreestructura)) 
                {
                    $bdrecurso = $this->loadModel("indexbd", "bdrecursos");

                    $recurso_asignado = $this->_bdherramieenta->getRecursoXEH($padreestructura["Esh_IdEstructuraHerramienta"]);

                    $recurso_disponible;

                    if (isset($recurso_asignado) && !empty($recurso_asignado)) 
                    {
                        $recurso_disponible = $this->_bdherramieenta->getRecursoDispobibleXEH($padreestructura["Esh_IdEstructuraHerramienta"], $recurso_asignado[0]["Esr_IdEstandarRecurso"]);

                        $this->_view->assign('recurso_disponible', $paginador->paginar($recurso_disponible, "estructura_lista_recursos_disponibles", $padreestructura["Esh_IdEstructuraHerramienta"] . "/" . $recurso_asignado[0]["Esr_IdEstandarRecurso"], false, 5));
                        $this->_view->assign('paginacion_rd', $paginador->getView('paginacion_ajax'));
                        $this->_view->assign('control_paginacion_rd', $paginador->getControlPaginaion());
                        $this->_view->assign('numeropagina_rd', $paginador->getNumeroPagina());

                        $this->_view->assign('recurso_asignado', $paginador->paginar($recurso_asignado, "estructura_lista_recursos_asignados", $padreestructura["Esh_IdEstructuraHerramienta"], false, 5));
                        $this->_view->assign('paginacion_ra', $paginador->getView('paginacion_ajax'));
                        $this->_view->assign('control_paginacion_ra', $paginador->getControlPaginaion());
                        $this->_view->assign('numeropagina_ra', $paginador->getNumeroPagina());

                        $this->_view->assign('er_asignado', $recurso_asignado[0]["Esr_IdEstandarRecurso"]);
                    }

                    $this->_view->assign('estandar_recurso', $bdrecurso->getEstandar());
                    $this->_view->assign('padreestructura', $padreestructura);

                    $this->_view->assign('estructura', $paginador->paginar($this->_bdherramieenta->listarEstructuraHXidpadre($this->filtrarInt($idestructura)), "estructura_lista_estructura", $idherramienta . "/" . $this->filtrarInt($idestructura), false, 25));
                } 
                else 
                {
                    $this->redireccionar("herramienta/estructura/" . $idherramienta);
                }

            } 
            else 
            {
                $this->_view->assign('estructura', $paginador->paginar($this->_bdherramieenta->getEstructuraHXHTraducido($this->filtrarInt($idherramienta), "", Cookie::lenguaje()), "estructura_lista_estructura", $idherramienta . "/" . $this->filtrarInt($idestructura), false, 25));
            }

            $this->_view->assign('idherramienta', $this->filtrarInt($idherramienta));
            $this->_view->assign('idpadre', $this->filtrarInt($idestructura));

            $bdarquitectura = $this->loadModel('index', 'arquitectura');
            $this->_view->assign('idioma', Cookie::lenguaje());

            $this->_view->assign('idiomas', $bdarquitectura->getIdiomas());

            $this->_view->assign('herramienta', $this->_bdherramieenta->getHerramientaXid($this->filtrarInt($idherramienta)));
            $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
            $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
            $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

            $this->_view->renderizar('estructura');
        } 
        else 
        {
            $this->redireccionar("herramienta");
        }
    }

    public function visor($keyherramienta) 
    {
        //$this->_acl->autenticado();
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("herramienta_visor");
        $this->_view->setTemplate(LAYOUT_FRONTEND);

        $this->_view->setJs(array(
            array('https://maps.googleapis.com/maps/api/js?key=AIzaSyDPJoejdRh3XakrIcqEzI4kJguJxJrC9eg', true),
            array(BASE_URL . "public/js/googlemaps.js", false),
            array(BASE_URL . "public/js/document_ready.js", false),
            array(BASE_URL . "public/js/leyenda.js", false),
            array(BASE_URL . "public/js/bootstrap-table.min.js", false),
            array(BASE_URL . "public/js/bootstrap-table-export.min.js", false),
            array("http://maps.stamen.com/js/tile.stamen.js?v1.2.1", false),
            array('http://code.highcharts.com/highcharts.js', false), //agregado
            array('http://code.highcharts.com/modules/exporting.js', false), //agregado   
            'document_ready',
            'areatematicaBiodiversidad',
            "areatematicaMonitoreo",
            "areatematicaGenerico",
            "torta_reporte"
        ));                                    
         
        $this->_view->setCss(array(
            array(BASE_URL . "public/css/visor.css", true),
            array(BASE_URL . "public/css/bootstrap-table.min.css", true),
            "visor"
        ));

        $herramienta = $this->_bdherramieenta->getHerramientaXAbrevTraducido($keyherramienta, Cookie::lenguaje());

        if (isset($herramienta) && !empty($herramienta)) 
        {
            $this->_view->assign('titulo', $herramienta["Her_Nombre"]);            
            $paginador = new Paginador();
            $_bdrecursos = $this->loadModel("indexbd", "bdrecursos");
            $arbol = new Arbol();
            //  $json_menuArbol = array();
            // if (!empty($herramienta["Her_UrlMenu"])&&is_readable(ROOT . $herramienta["Her_UrlMenu"])) {
            //    $menuArbol = file_get_contents(ROOT . $herramienta["Her_UrlMenu"]);
            //   ini_set("memory_limit","3500M");
            //   $json_menuArbol = json_decode($menuArbol, true);
            // }else{
            //        $this->_view->assign('_error',"No se generó el menu del Visor");
            // }         
            $padre = $this->_bdherramieenta->listarPadreArbolEstructuraHVisor($this->filtrarInt($herramienta["Her_IdHerramientaSii"]), null, Cookie::lenguaje());
            $this->_view->assign('arbolherramienta', $arbol->enrraizar($padre, "padre_menu_herramienta_visor"));
            $recursos = $_bdrecursos->getRecursosXHerramienta($herramienta["Her_IdHerramientaSii"]);
            $this->_view->assign('eh_predeterminado', json_encode($this->_bdherramieenta->listarEhPredeterminadoCompleto($this->filtrarInt($herramienta["Her_IdHerramientaSii"]))));
            $this->_view->assign('padres', $padre);
            $this->_view->assign('recursos', $paginador->paginar($recursos, "visor_lista_recursos", $herramienta["Her_IdHerramientaSii"], false, count($recursos)));
            $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
            $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
            $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

            $this->_view->assign('herramienta', $herramienta);
            // $this->_view->setJs(array("document_ready"));         
            $this->_view->renderizar('visor', 'mapa');
        }
        else 
        {
            $this->redireccionar("herramienta");
        }
    }

    public function bitacora() 
    {
        ob_end_clean();
        ob_start();
        error_reporting(0);
        $result = $this->_bdherramieenta->getBitacoraHerramienta();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->createSheet(1);
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("SII - OTCA")
                ->setLastModifiedBy("IIAP")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Bitacora Herramienta")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Bitacora");

        //Datos de la Estacion
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('Resultado');

        $objPHPExcel->getActiveSheet()->setCellValue("A1", "Servidor");
        $objPHPExcel->getActiveSheet()->setCellValue("B1", "Id");
        $objPHPExcel->getActiveSheet()->setCellValue("C1", "IP");
        $objPHPExcel->getActiveSheet()->setCellValue("D1", "Sistema Operativo");
        $objPHPExcel->getActiveSheet()->setCellValue("E1", "Navegador");
        $objPHPExcel->getActiveSheet()->setCellValue("F1", "Herramienta");
        $objPHPExcel->getActiveSheet()->setCellValue("G1", "Metodo");
        $objPHPExcel->getActiveSheet()->setCellValue("H1", "Parametros Enviados");
        $objPHPExcel->getActiveSheet()->setCellValue("I1", "Tiempo Consulta Segundos");
        $objPHPExcel->getActiveSheet()->setCellValue("J1", "Fecha");
        $rowNumber = 2; //start in cell 1
        
        foreach ($result as $row) 
        {
            $objPHPExcel->getActiveSheet()->setCellValue("A" . $rowNumber, BASE_URL);
            $objPHPExcel->getActiveSheet()->setCellValue("B" . $rowNumber, $row["Bih_IdBitacoraHerramienta"]);
            $objPHPExcel->getActiveSheet()->setCellValue("C" . $rowNumber, $row["Bih_IpUsuario"]);
            $objPHPExcel->getActiveSheet()->setCellValue("D" . $rowNumber, $row["Bih_So"]);
            $objPHPExcel->getActiveSheet()->setCellValue("E" . $rowNumber, $row["Bih_Navegador"]);
            $objPHPExcel->getActiveSheet()->setCellValue("F" . $rowNumber, $row["Her_Herramienta"]);
            $objPHPExcel->getActiveSheet()->setCellValue("G" . $rowNumber, $row["Bih_Metodo"]);
            $objPHPExcel->getActiveSheet()->setCellValue("H" . $rowNumber, $row["Bih_Parametros"]);
            $objPHPExcel->getActiveSheet()->setCellValue("I" . $rowNumber, $row["Bih_TiempoConsultaSegundos"]);
            $objPHPExcel->getActiveSheet()->setCellValue("J" . $rowNumber, $row["Bih_FechaConsulta"]);
            $rowNumber++;
        }

// Set active sheet index to the first sheet, so Excel opens this as the first 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Bitacora Herramienta' . gmdate(' d M Y') . '.xls"');
        header('Cache-Control: max-age=0');

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

    public function _listaRecursos($idherramienta) 
    {
        $_bdrecursos = $this->loadModel("indexbd", "bdrecursos");
        echo json_encode($_bdrecursos->getRecursosXHerramienta($this->filtrarInt($idherramienta)));
    }

    public function _paginacion_index_lista_herramienta($busqueda = "") {

        $pagina = $this->getInt('pagina');
        $this->_view->getLenguaje("herramienta_index");

        $paginador = new Paginador();

        $this->_view->assign('herramientas', $paginador->paginar($this->_bdherramieenta->getHerramientaTraducido($busqueda, Cookie::lenguaje()), "index_lista_herramienta", "", $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/index_lista_herramienta', false, true);
    }

    public function _paginacion_estructura_lista_estructura($idherramienta, $idestructura, $busqueda = "") {

        $pagina = $this->getInt('pagina');

        $paginador = new Paginador();
        if ($this->filtrarInt($idestructura)) 
        {

            $this->_view->assign('estructura', $paginador->paginar($this->_bdherramieenta->listarEstructuraHXidpadre($this->filtrarInt($idestructura), $busqueda), "estructura_lista_estructura", $idherramienta . "/" . $this->filtrarInt($idestructura) . "/" . $busqueda, $pagina, 25));
        } 
        else 
        {
            $this->_view->assign('estructura', $paginador->paginar($this->_bdherramieenta->getEstructuraHXH($this->filtrarInt($idherramienta), $busqueda), "estructura_lista_estructura", $idherramienta . "/" . $this->filtrarInt($idestructura) . "/" . $busqueda, $pagina, 25));
        }

        $this->_view->assign('herramienta', $this->_bdherramieenta->getHerramientaXid($this->filtrarInt($idherramienta), Cookie::lenguaje()));

        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/estructura_lista_estructura', false, true);
    }

    public function _eliminarEstructura($busqueda = "") 
    {
        $pagina = $this->getInt('pagina');

        $paginador = new Paginador();

        $this->_bdherramieenta->eliminarEstructuraCompleto($this->getInt("idestructura"));

        if ($this->getInt("idpadre")) 
        {
            $this->_view->assign('estructura', $paginador->paginar($this->_bdherramieenta->listarEstructuraHXidpadre($this->getInt("idpadre")), "estructura_lista_estructura", $this->getInt("idherramienta") . "/" . $this->getInt("idpadre") . "/" . $busqueda, $pagina, 25));
        } 
        else 
        {
            $this->_view->assign('estructura', $paginador->paginar($this->_bdherramieenta->getEstructuraHXH($this->getInt("idherramienta")), "estructura_lista_estructura", $this->getInt("idherramienta") . "/" . $this->getInt("idpadre") . "/" . $busqueda, $pagina, 25));
        }

        $this->_view->assign('herramienta', $this->_bdherramieenta->getHerramientaXid($this->getInt("idherramienta"), Cookie::lenguaje()));

        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/estructura_lista_estructura', false, true);
    }

    public function _paginacion_visor_lista_recursos($idherramienta, $busqueda = "") 
    {
        $pagina = $this->getInt('pagina');

        $this->_view->getLenguaje("herramienta_visor");
        $paginador = new Paginador();

        $_bdrecursos = $this->loadModel("indexbd", "bdrecursos");
        $this->_view->assign('recursos', $paginador->paginar($_bdrecursos->getRecursosXHerramienta($this->filtrarInt($idherramienta), $this->getSql($busqueda)), "visor_lista_recursos", $this->filtrarInt($idherramienta) . "/" . $busqueda, $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/visor_lista_recursos', false, true);
    }

    public function _paginacion_estructura_lista_recursos_asignados($idEstructura, $busqueda = "") 
    {
        $pagina = $this->getInt('pagina');

        $paginador = new Paginador();

        $padreestructura = $this->_bdherramieenta->getEstructuraHXId($this->filtrarInt($idEstructura));
        $this->_view->assign('padreestructura', $padreestructura);

        $recurso_asignado = $this->_bdherramieenta->getRecursoXEH($idEstructura, $busqueda);
        $this->_view->assign('recurso_asignado', $paginador->paginar($recurso_asignado, "estructura_lista_recursos_asignados", $idEstructura . "/" . $busqueda, $pagina, 5));
        $this->_view->assign('paginacion_ra', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion_ra', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_ra', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/estructura_lista_recursos_asignados', false, true);
    }

    public function _paginacion_estructura_lista_recursos_disponibles($idEstructura, $idEstandar, $busqueda = "") 
    {
        $pagina = $this->getInt('pagina');

        $paginador = new Paginador();

        $padreestructura = $this->_bdherramieenta->getEstructuraHXId($this->filtrarInt($idEstructura));
        $this->_view->assign('padreestructura', $padreestructura);

        $recurso_disponible = $this->_bdherramieenta->getRecursoDispobibleXEH($idEstructura, $idEstandar, $busqueda);

        $this->_view->assign('recurso_disponible', $paginador->paginar($recurso_disponible, "estructura_lista_recursos_disponibles", $idEstructura . "/" . $idEstandar . "/" . $busqueda, $pagina, 5));
        $this->_view->assign('paginacion_rd', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion_rd', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_rd', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/estructura_lista_recursos_disponibles', false, true);
    }

    public function _listarRecursosDisponibleXEstandar() 
    {
        $paginador = new Paginador();

        $padreestructura = $this->_bdherramieenta->getEstructuraHXId($this->getInt("idestructura"));

        $recurso_disponible = $this->_bdherramieenta->getRecursoDispobibleXEH(0, $this->getInt("idEstandar"));

        $this->_view->assign('recurso_disponible', $paginador->paginar($recurso_disponible, "estructura_lista_recursos_disponibles", $this->getInt("idestructura") . "/" . $this->getInt("idEstandar"), false, 5));
        $this->_view->assign('paginacion_rd', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion_rd', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_rd', $paginador->getNumeroPagina());

        $this->_view->assign('padreestructura', $padreestructura);

        $this->_view->renderizar('ajax/estructura_lista_recursos_disponibles', false, true);
    }

    public function _asignarRecurso() 
    {
        $paginador = new Paginador();

        $this->_bdherramieenta->insertarEstructurah_Recurso($this->getInt("idestructura"), $this->getInt("idrecurso"));

        $bdrecurso = $this->loadModel("indexbd", "bdrecursos");

        $padreestructura = $this->_bdherramieenta->getEstructuraHXId($this->getInt("idestructura"));
        $this->_view->assign('padreestructura', $padreestructura);

        $recurso_asignado = $this->_bdherramieenta->getRecursoXEH($this->getInt("idestructura"));

        $recurso_disponible;
        if (isset($recurso_asignado) && !empty($recurso_asignado)) 
        {
            $recurso_disponible = $this->_bdherramieenta->getRecursoDispobibleXEH($this->getInt("idestructura"), $recurso_asignado[0]["Esr_IdEstandarRecurso"]);

            $this->_view->assign('recurso_disponible', $paginador->paginar($recurso_disponible, "estructura_lista_recursos_disponibles", $this->getInt("idestructura") . "/" . $recurso_asignado[0]["Esr_IdEstandarRecurso"], false, 5));
            $this->_view->assign('paginacion_rd', $paginador->getView('paginacion_ajax'));
            $this->_view->assign('control_paginacion_rd', $paginador->getControlPaginaion());
            $this->_view->assign('numeropagina_rd', $paginador->getNumeroPagina());

            $this->_view->assign('recurso_asignado', $paginador->paginar($recurso_asignado, "estructura_lista_recursos_asignados", $this->getInt("idestructura"), false, 5));
            $this->_view->assign('paginacion_ra', $paginador->getView('paginacion_ajax'));
            $this->_view->assign('control_paginacion_ra', $paginador->getControlPaginaion());
            $this->_view->assign('numeropagina_ra', $paginador->getNumeroPagina());

            $this->_view->assign('er_asignado', $recurso_asignado[0]["Esr_IdEstandarRecurso"]);
        }

        $this->_view->assign('estandar_recurso', $bdrecurso->getEstandar());


        $this->_view->renderizar('ajax/estructura_gestor_recurso', false, true);
    }

    public function _quitarRecurso() 
    {
        $paginador = new Paginador();

        $this->_bdherramieenta->eliminarEstructurah_Recurso($this->getInt("idestructura"), $this->getInt("idrecurso"));

        $bdrecurso = $this->loadModel("indexbd", "bdrecursos");

        $padreestructura = $this->_bdherramieenta->getEstructuraHXId($this->getInt("idestructura"));
        $this->_view->assign('padreestructura', $padreestructura);

        $recurso_asignado = $this->_bdherramieenta->getRecursoXEH($this->getInt("idestructura"));

        $recurso_disponible;
        if (isset($recurso_asignado) && !empty($recurso_asignado)) 
        {
            $recurso_disponible = $this->_bdherramieenta->getRecursoDispobibleXEH($this->getInt("idestructura"), $recurso_asignado[0]["Esr_IdEstandarRecurso"]);

            $this->_view->assign('recurso_disponible', $paginador->paginar($recurso_disponible, "estructura_lista_recursos_disponibles", $this->getInt("idestructura") . "/" . $recurso_asignado[0]["Esr_IdEstandarRecurso"], false, 5));
            $this->_view->assign('paginacion_rd', $paginador->getView('paginacion_ajax'));
            $this->_view->assign('control_paginacion_rd', $paginador->getControlPaginaion());
            $this->_view->assign('numeropagina_rd', $paginador->getNumeroPagina());

            $this->_view->assign('recurso_asignado', $paginador->paginar($recurso_asignado, "estructura_lista_recursos_asignados", $this->getInt("idestructura"), false, 5));
            $this->_view->assign('paginacion_ra', $paginador->getView('paginacion_ajax'));
            $this->_view->assign('control_paginacion_ra', $paginador->getControlPaginaion());
            $this->_view->assign('numeropagina_ra', $paginador->getNumeroPagina());

            $this->_view->assign('er_asignado', $recurso_asignado[0]["Esr_IdEstandarRecurso"]);
        }

        $this->_view->assign('estandar_recurso', $bdrecurso->getEstandar());

        $this->_view->renderizar('ajax/estructura_gestor_recurso', false, true);
    }

    public function _buscarHerramienta() 
    {
        $this->_view->getLenguaje("herramienta_index");
        $paginador = new Paginador();

        $busqueda = $this->getSql("busqueda");

        $this->_view->assign('herramientas', $paginador->paginar($this->_bdherramieenta->getHerramientaTraducido($busqueda, Cookie::lenguaje()), "index_lista_herramienta", $busqueda, false, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/index_lista_herramienta', false, true);
    }

    public function _buscarEstructura() 
    {
        $paginador = new Paginador();

        $busqueda = $this->getSql("busqueda");
        $idherramienta = $this->getSql("idherramienta");
        $idpadre = $this->getSql("idpadre");

        if ($this->filtrarInt($idpadre)) 
        {
            $this->_view->assign('estructura', $paginador->paginar($this->_bdherramieenta->listarEstructuraHXidpadre($this->filtrarInt($idpadre), $busqueda), "estructura_lista_estructura", $idherramienta . "/" . $this->filtrarInt($idpadre) . "/" . $busqueda, false, 25));
        } 
        else 
        {
            $this->_view->assign('estructura', $paginador->paginar($this->_bdherramieenta->getEstructuraHXH($this->filtrarInt($idherramienta), $busqueda), "estructura_lista_estructura", $idherramienta . "/" . $this->filtrarInt($idpadre) . "/" . $busqueda, false, 25));
        }

        $this->_view->assign('herramienta', $this->_bdherramieenta->getHerramientaXid($this->filtrarInt($idherramienta)), Cookie::lenguaje());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/estructura_lista_estructura', false, true);
    }

    public function _buscarRecursosDisponibles() 
    {
        $paginador = new Paginador();

        $padreestructura = $this->_bdherramieenta->getEstructuraHXId($this->getInt("idestructura"));

        $recurso_disponible = $this->_bdherramieenta->getRecursoDispobibleXEH(0, $this->getInt("estandar"), $this->getSql("busqueda"));

        $this->_view->assign('recurso_disponible', $paginador->paginar($recurso_disponible, "estructura_lista_recursos_disponibles", $this->getInt("idestructura") . "/" . $this->getInt("estandar") . "/" . $this->getSql("busqueda"), false, 5));
        $this->_view->assign('paginacion_rd', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion_rd', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_rd', $paginador->getNumeroPagina());

        $this->_view->assign('padreestructura', $padreestructura);

        $this->_view->renderizar('ajax/estructura_lista_recursos_disponibles', false, true);
    }

    public function _buscarRecursosAsignados() 
    {        
        $paginador = new Paginador();

        $padreestructura = $this->_bdherramieenta->getEstructuraHXId($this->getInt("idestructura"));
        $this->_view->assign('padreestructura', $padreestructura);

        $recurso_asignado = $this->_bdherramieenta->getRecursoXEH($this->getInt("idestructura"), $this->getSql("busqueda"));
        $this->_view->assign('recurso_asignado', $paginador->paginar($recurso_asignado, "estructura_lista_recursos_asignados", $this->getInt("idestructura") . "/" . $this->getSql("busqueda"), false, 5));
        $this->_view->assign('paginacion_ra', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion_ra', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_ra', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/estructura_lista_recursos_asignados', false, true);
    }

    public function _actualizarEstadoHerramienta() 
    {
        $this->_view->getLenguaje("herramienta_index");
        $paginador = new Paginador();

        $pagina = $this->getInt("pagina");

        $busqueda = $this->getSql("busqueda");
        $idherramienta = $this->getInt("idherramienta");
        $estado = $this->getInt("estado");

        $this->_bdherramieenta->actualizarEstadoHerramienta($idherramienta, $estado);

        $this->_view->assign('herramientas', $paginador->paginar($this->_bdherramieenta->getHerramientaTraducido($busqueda, Cookie::lenguaje()), "index_lista_herramienta", $busqueda, $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/index_lista_herramienta', false, true);
    }

    public function _actualizarEstadoEstructura() 
    {
        $pagina = $this->getInt('pagina');

        $busqueda = $this->getSql("busqueda");
        $idherramienta = $this->getInt("idherramienta");
        $idestructura = $this->getInt("idpadre");
        $idestructurau = $this->getInt("idestructura");
        $estado = $this->getInt("estado");

        $this->_bdherramieenta->actualizarEstadoEstructuraH($idestructurau, $estado);

        $paginador = new Paginador();
        if ($this->filtrarInt($idestructura)) 
        {
            $this->_view->assign('estructura', $paginador->paginar($this->_bdherramieenta->listarEstructuraHXidpadre($this->filtrarInt($idestructura), $busqueda), "estructura_lista_estructura", $idherramienta . "/" . $this->filtrarInt($idestructura) . "/" . $busqueda, $pagina, 25));
        } 
        else 
        {
            $this->_view->assign('estructura', $paginador->paginar($this->_bdherramieenta->getEstructuraHXH($this->filtrarInt($idherramienta), $busqueda), "estructura_lista_estructura", $idherramienta . "/" . $this->filtrarInt($idestructura) . "/" . $busqueda, $pagina, 25));
        }

        $this->_view->assign('herramienta', $this->_bdherramieenta->getHerramientaXid($this->filtrarInt($idherramienta), Cookie::lenguaje()));

        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/estructura_lista_estructura', false, true);
    }

    public function _listarHijoArbolEstructuraH() 
    {
        $this->_view->getLenguaje("herramienta_visor");
        $arbol = new Arbol();
        $idherramienta = $this->getInt("herramienta");
        $idestructura = $this->getInt("estructura");

        $padre = $this->_bdherramieenta->listarPadreArbolEstructuraHVisor($idherramienta, $idestructura, Cookie::lenguaje());
        echo $arbol->enrraizar($padre, "padre_menu_herramienta_visor");
    }

    public function _getJsonlistarHijoArbolEstructuraH($ididioma, $idherramienta, $idestructura = null) 
    {
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        $padre = $this->_bdherramieenta->listarPadreArbolEstructuraHVisor($idherramienta, $idestructura, $ididioma);
        echo json_encode($padre);
    }

    public function _getJsonHerramienta($ididioma, $keyherramienta) 
    {
        $herramienta = $this->_bdherramieenta->getHerramientaXAbrevTraducido($keyherramienta, Cookie::lenguaje());
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        $herramienta["estructura"] = $this->_bdherramieenta->listarPadreArbolEstructuraHVisor($herramienta["Her_IdHerramientaSii"], null, $ididioma);
        $herramienta["predeterminados"] = $this->_bdherramieenta->listarEhPredeterminadoCompleto($herramienta["Her_IdHerramientaSii"]);
        echo json_encode($herramienta);
    }

    public function _buscarEspecie() 
    {
        $this->_view->getLenguaje("herramienta_visor");
        $arbol = new Arbol();
        $busqueda = $this->getSql("busqueda");
        $idherramienta = $this->getInt("idherramienta");
        //echo $idherramienta."". $busqueda;
        $padre = $this->_bdherramieenta->buscarEspecieenHE($idherramienta, $busqueda);

        echo $arbol->enrraizar($padre, "padre_menu_herramienta_visor");
    }

    public function _getTraduccionHerramienta() 
    {
        $idherramienta = $this->getInt("idherramienta");
        $idIdioma = $this->getTexto("idIdioma");
        $idIdiomaO = $this->getTexto("idIdiomaO");

        $herramienta = $this->_bdherramieenta->getHerramientaXidTraducido($this->filtrarInt($idherramienta), $idIdioma);

        if ($herramienta["Idi_IdIdioma"] != $idIdioma) 
        {
            $herramienta["Her_Nombre"] = "";
            $herramienta["Her_Descripcion"] = "";
            $herramienta["Idi_IdIdioma"] = "";
        }

        $this->_view->assign('idIdiomaO', $idIdiomaO);
        $this->_view->assign('herramienta', $herramienta);
        $this->_view->renderizar('ajax/index_nueva_herramienta', false, true);
    }

    public function _getTraduccionEstructura() 
    {
        $idestructura = $this->getInt("idestructura");
        $idIdioma = $this->getTexto("idIdioma");
        $idIdiomaO = $this->getTexto("idIdiomaO");

        $estructura = $this->_bdherramieenta->getEstructuraHXIdTraducido($this->filtrarInt($idestructura), $idIdioma);

        if ($estructura["Idi_IdIdioma"] != $idIdioma) 
        {
            $estructura["Esh_Titulo"] = "";
            $estructura["Esh_Nombre"] = "";
            //$estructura["Esh_Descripcion"] = "";
            $estructura["Idi_IdIdioma"] = "";
        }

        $this->_view->assign('idIdiomaO', $idIdiomaO);
        $this->_view->assign('padreestructura', $estructura);
        $this->_view->renderizar('ajax/index_nueva_estructura', false, true);
    }

    private function _leerExcel($rutafile) 
    {
        new PHPExcel();

        $objReader = PHPExcel_IOFactory::createReaderForFile($rutafile);
        $worksheetData = $objReader->listWorksheetInfo($rutafile);

        $objPHPExcel = $objReader->load($rutafile);
        $objHoja = $objPHPExcel->getActiveSheet()->toArray();

        $columnas = $worksheetData[0]['totalColumns'];
        $filas = $worksheetData[0]['totalRows'];
        $encabezado = array_shift($objHoja);

        if ($columnas % 2 == 0) 
        {
            return $this->armarArbol($columnas, $filas, $objHoja);
        } 
        else 
        {
            return null;
        }
    }

    private function armarArbol($columnas, $filas, $registros) 
    {
        $arbol = array();

        for ($i = 0; $i < count($registros); $i++) 
        {
            $temp = array_chunk($registros[$i], 2);
            if ($i > 0) 
            {
                if ($arbol[count($arbol) - 1][0] == $temp[0][0]) 
                {
                    array_shift($temp);
                    if (count($temp) > 0 && $temp[0][0]) 
                    {
                        $arbol[count($arbol) - 1]["hijo"] = $this->armarJerarquia($temp, $arbol[count($arbol) - 1]["hijo"]);
                    }
                } 
                else 
                {
                    if ($temp[0][0]) 
                    {
                        $arbol[] = $this->armarJerarquia($temp);
                    }
                }
            } 
            else 
            {
                $arbol[] = $this->armarJerarquia($temp);
            }
        }

        return $arbol;
    }

    private function armarJerarquia($jerarquia, $hermanos = false) 
    {
        $padre = array();
        if (isset($jerarquia) && count($jerarquia) > 0) 
        {
            $padre = array_shift($jerarquia);
            if ($hermanos) 
            {
                if (count($hermanos) && $hermanos[count($hermanos) - 1][0] == $padre[0]) 
                {
                    $hermanos[count($hermanos) - 1]["hijo"] = ($this->armarJerarquia($jerarquia, $hermanos[count($hermanos) - 1]["hijo"]));
                } 
                else 
                {
                    $padre["hijo"] = array($this->armarJerarquia($jerarquia));
                    $hermanos[] = $padre;
                }

                return $hermanos;
            } 
            else 
            {
                if (count($jerarquia) > 0 && !empty($jerarquia[0][0])) 
                {
                    $padre["hijo"] = array($this->armarJerarquia($jerarquia));
                }

                return ($padre);
            }
        }
    }

    private function _verificarFileType($filename) 
    {
        if (($_FILES[$filename]["type"] == "application/vnd.ms-excel") || ($_FILES[$filename]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"))
            return true;
        else
            return false;
    }

    public function _registroBitacoraHerramienta() 
    {
        $herramienta = $this->getInt("idherramineta");
        $metodo = $this->getTexto("nmetodo");
        $parametros = $this->getTexto("lparametros");
        $tiempo = $this->getTexto("ntiempo");

        $browser = array("IE", "MOZILLA", "NETSCAPE", "FIREFOX", "SAFARI", "CHROME", "OPR", "TRIDENT");
        $os = array("WIN", "MAC", "LINUX");

        # definimos unos valores por defecto para el navegador y el sistema operativo
        $info['browser'] = "OTHER";
        $info['os'] = "OTHER";

        # buscamos el navegador con su sistema operativo
        foreach ($browser as $parent) 
        {
            $b = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
            $t = $b + strlen($parent);
            $version = substr($_SERVER['HTTP_USER_AGENT'], $t, 15);
            $version = preg_replace('/[^0-9,.]/', '', $version);
            if ($b) 
            {
                if ($parent == "TRIDENT") 
                {
                    $info['browser'] = "INTERNET EXPLORER";
                    $info['version'] = $version + 4;
                } 
                else 
                {
                    if ($parent == "SAFARI") 
                    {
                        $info['browser'] = $parent;
                        $b1 = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), 'VERSION');
                        $t1 = $b1 + strlen($parent);
                        $version1 = substr($_SERVER['HTTP_USER_AGENT'], $t1, 15);
                        $version1 = preg_replace('/[^0-9,.]/', '', $version1);
                        $info['version'] = $version1;
                    } 
                    else 
                    {
                        if ($parent == "OPR") 
                        {
                            $info['browser'] = "OPERA";
                            $info['version'] = $version;
                        } 
                        else 
                        {
                            $info['browser'] = $parent;
                            $info['version'] = $version;
                        }
                    }
                }
            }
        }

        # obtenemos el sistema operativo
        foreach ($os as $val)
         {
            $s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $val);
            $a = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $info['browser']);
            $r = $a - $s;
            $f = substr($_SERVER['HTTP_USER_AGENT'], $s - 1, $r);
            if ($s) 
            {
                $info['os'] = $f;
            }
        }

        # devolvemos el array de valores
        $dispositivonavegador = $info["browser"] . ' ' . $info["version"];
        var_dump($dispositivonavegador);
        $so = $info["os"];

        $ipsuarios = $_SERVER['REMOTE_ADDR'];

        echo json_encode($this->_bdherramieenta->insertarBitacoraHerramienta($ipsuarios, $so, $dispositivonavegador, $herramienta, $metodo, $parametros, $tiempo));
    }

    public function _asigancionMultipleER() 
    {
        $this->_bdherramieenta->asinacionMultipleRecurso();
    }

}
