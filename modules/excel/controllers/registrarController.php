<?php

ini_set('memory_limit', '-1');

class registrarController extends excelController 
{
    private $_excel;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_excel = $this->loadModel('registrar');
        $this->_estandar = $this->loadModel('index', 'estandar');
    }

    public function index($recurso = false) 
    {
        $this->_acl->acceso("registro_desde_excel");
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("bdrecursos_metadata");
        $_SESSION['recurso'] = $this->filtrarInt($recurso);
        $e = $this->loadModel('bdrecursos', true);
        $idrecurso = $this->_excel->getRecurso($this->filtrarInt($recurso));
        $metadatarecurso = $e->getRecursoCompletoXid($recurso);

        $idEstandarRecurso=$metadatarecurso['Esr_IdEstandarRecurso'];

        $estandar_recurso = $this->_estandar->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=$idEstandarRecurso");
        $tipo_estandar = $estandar_recurso[0]['Esr_Tipo'];

        $this->_view->assign('tipo_estandar', $tipo_estandar);
        $this->_view->assign('recurso', $metadatarecurso);
        $this->_view->setJs(array('registrar'));
        $this->_view->assign('titulo', 'Cargar Datos');
        $this->_view->assign('estandar', $idrecurso[0]);
        $this->_view->renderizar('index', 'registrar');
    }

    public function subir_documentos() 
    {
        $carpetaDestino = "imagenes/";

        if ($_FILES["archivos"]["name"][0]) 
        {
            for ($i = 0; $i < count($_FILES["archivos"]["name"]); $i++) 
            {
                $origen = $_FILES["archivos"]["tmp_name"][$i];
                $destino = $carpetaDestino . $_FILES["archivos"]["name"][$i];
                $archivo = $this->_excel->getArchivoFisico($_FILES["archivos"]["name"][$i]);

                if (!$archivo) 
                {
                    $this->_excel->registrarArchivoFisico($_FILES["archivos"]["name"][$i]);
                    @move_uploaded_file($origen, $destino);
                }
            }
        }
    }

    public function excel() 
    {
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->getLenguaje("index_inicio");

        //$this->_view->setJs(array('registrar'));


        $this->_view->setJs(array(
            array(BASE_URL."public/js/combobox/jquery.easyui.min.js"),
            array(BASE_URL."public/js/combobox/jquery.min.js"),
            'registrar'));
        $archivo = substr($_FILES['archivo']['tmp_name'], strlen($_FILES['archivo']['tmp_name']) - 7, 3) . $_FILES["archivo"]['name'];

        $_SESSION['archivo'] = $archivo;
        $destino = $_SERVER['DOCUMENT_ROOT'] . "/siigef/" . $archivo;
        copy($_FILES['archivo']['tmp_name'], $destino);
        new PHPExcel();
        $objLector = PHPExcel_IOFactory::createReaderForFile($archivo);
        $nombrehojas = $objLector->listWorksheetNames($archivo);
        unset($objLector);

        $idestandar = $this->_excel->getRecurso($_SESSION['recurso']);

        if ($idestandar[0] == 3) 
        {
            $this->subir_documentos();
        }

        $e = $this->loadModel('bdrecursos', true);
        $metadatarecurso = $e->getRecursoCompletoXid($_SESSION['recurso']);

        $this->_view->assign('data', $this->getPostParam('data'));
        $this->_view->assign('recurso', $metadatarecurso);
        $this->_view->assign('nombrehojas', $nombrehojas);
        $this->_view->assign('titulo', 'Cargar Datos');
        $this->_view->renderizar('ficha_estandar', 'excel/registrar');
    }

    public function txt() 
    {
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('registrar'));
        $archivo = $_FILES["archivo"]['name'];
        $_SESSION['archivo'] = $archivo;
        $destino = $_SERVER['DOCUMENT_ROOT'] . "/siigef/" . $archivo;
        copy($_FILES['archivo']['tmp_name'], $destino);
        new PHPExcel();
        $objLector = PHPExcel_IOFactory::createReaderForFile($archivo);

        switch ($_POST['separador']) 
        {
            case ',':
                $objLector->setDelimiter(",");
                break;
            case '\t':
                $objLector->setDelimiter("\t");
                break;
        }

        $objPHPExcel = $objLector->load($archivo);
        $valores_final = array();
        $valores_celda = array();
        $worksheet = $objPHPExcel->getActiveSheet();

        foreach ($worksheet->getRowIterator() as $row) 
        {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            foreach ($cellIterator as $cell) 
            {
                if (!is_null($cell)) 
                {
                    array_push($valores_celda, $cell->getValue());
                }
            }

            array_push($valores_final, $valores_celda);
            $valores_celda = array();
        }

        $encabezado = array_shift($valores_final);
        $_SESSION['valores_final'] = $valores_final;
        unset($objHoja);
        unset($objReader);
        $idrecurso = $this->_excel->getRecurso($_SESSION['recurso']);
        $_SESSION['idrecurso'] = $idrecurso[0];

        $e = $this->loadModel('bdrecursos', true);
        $metadatarecurso = $e->getRecursoCompletoXid($_SESSION['recurso']);

        $this->_view->assign('recurso', $metadatarecurso);
        $this->_view->assign('encabezado', $encabezado);
        $this->_view->assign('titulo', 'Cargar Datos');
        $this->_view->assign('FichaEstandar', $this->_excel->getFichaEstandar($_SESSION['idrecurso'], Cookie::lenguaje()));
        $this->_view->renderizar('listar_estandar', 'registrar');
    }

    public function listar_ficha_estandar() 
    {
        new PHPExcel();
        $this->_view->setJs(array('registrar'));
        $this->_view->assign('hoja', $this->getAlphaNum('hoja'));
        
        $archivo = $_SESSION['archivo'];
        $_SESSION['hoja'] = $this->getAlphaNum('hoja');
        $objReader = PHPExcel_IOFactory::createReaderForFile($archivo);
        $objPHPExcel = $objReader->load($archivo);
        $objHoja = $objPHPExcel->setActiveSheetIndexByName($this->getAlphaNum('hoja'))->toArray();
        $encabezado = array_shift($objHoja);
        $_SESSION['encabezado'] = $encabezado;
        unset($objHoja);
        unset($objReader);
        unset($objPHPExcel);
        $this->_view->assign('encabezado', $encabezado);
        $idrecurso = $this->_excel->getRecurso($_SESSION['recurso']);
        $_SESSION['idrecurso'] = $idrecurso[0];
        unset($idrecurso);
        $this->_view->assign('FichaEstandar', $this->_excel->getFichaEstandar($_SESSION['idrecurso'], Cookie::lenguaje()));
        $this->_view->assign('titulo', 'Cargar Datos');
        $this->_view->renderizar('ajax/listar_estandar', false, true);
    }

    public function listar_ficha_variable() 
    {
        new PHPExcel();

        $this->_view->setJs(array(
            array(BASE_URL."public/js/combobox/jquery.easyui.min.js"),
            array(BASE_URL."public/js/combobox/jquery.min.js"),
            'registrar'));
        //$this->_view->setJs(array('registrar'));
        $this->_view->assign('hoja', $this->getAlphaNum('hoja'));
        $this->_view->assign('data_tabla', $this->getSql('data_tabla'));

        $archivo = $_SESSION['archivo'];
        $_SESSION['hoja'] = $this->getAlphaNum('hoja');
        $objReader = PHPExcel_IOFactory::createReaderForFile($archivo);
        $objPHPExcel = $objReader->load($archivo);
        $objHoja = $objPHPExcel->setActiveSheetIndexByName($this->getAlphaNum('hoja'))->toArray();
        $encabezado = array_shift($objHoja);
        $_SESSION['encabezado'] = $encabezado;
        unset($objHoja);
        unset($objReader);
        unset($objPHPExcel);
        $this->_view->assign('encabezado', $encabezado);
        $idrecurso = $this->_excel->getRecurso($_SESSION['recurso']);
        $_SESSION['idrecurso'] = $idrecurso[0];

        $fichaEstandar = $this->_excel->getFichaEstandar($_SESSION['idrecurso'], Cookie::lenguaje());

        $nombre_tabla = 'variable_'.$fichaEstandar[0]['Fie_NombreTabla'];
        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'],0,3);
        $campo_id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $nombre_tabla)));
        $campo_nombre = $ini.'_Nombre';
        
        $fichaVariable = $this->_excel->getFichaVariable($nombre_tabla);
        
        $this->_view->assign('campo_id',$campo_id); 
        $this->_view->assign('campo_nombre',$campo_nombre); 
        $this->_view->assign('fichaVariable', $fichaVariable);
        $this->_view->assign('titulo', 'Cargar Datos');
        $this->_view->renderizar('ajax/listar_variable', false, true);
    }
    public function registrar($tipo_archivo = false) 
    {
        $this->validarUrlIdioma();
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->getLenguaje("index_inicio");
        $paginador = new Paginador();
        $this->_view->setJs(array('resultado'));
        $_SESSION['tipo_archivo'] = $this->filtrarInt($tipo_archivo);
        $tabla = $this->_excel->getEstandar($_SESSION['idrecurso']);
        $estandar_recurso = $tabla['Esr_NombreTabla'];

        switch ($estandar_recurso) 
        {
            case 'monitoreo_calidad_agua':
                $this->monitoreo_calidad_agua();
                break;
            case 'matriz_legal':
                $this->legislacion();
                break;
            case 'dublincore':
                $this->dublincore();
                break;
            case 'darwin':
                $this->darwincore();
                break;
            case 'plinian':
                $this->pliniancore();
                break;
            default :
                $this->estandar($tabla['Esr_Tipo']);
        }

        $descarga = $_SESSION['Descargar'];
        $cabecera = array_shift($descarga);
        $_SESSION['cabecera'] = $cabecera;
        $_SESSION['datos_no_registrados'] = $descarga;
        $this->_view->assign('total_registrado', $_SESSION['total_registrado']);
        $this->_view->assign('total_no_registrado', $_SESSION['total_no_registrado']);
        $this->_view->assign('no_registrado', $paginador->paginar($_SESSION['datos_no_registrados'], "", "", "", 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('total_registros', $_SESSION['total_registros']);
        $this->_view->assign('cabecera', $_SESSION['cabecera']);
        unlink($_SESSION['archivo']);
        unset($descarga);
        unset($cabecera);
        Session::destroy('excel');
        Session::destroy('archivo');
        Session::destroy('hoja');
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        Session::destroy('idrecurso');
        Session::destroy('recurso');
        $this->_view->assign('titulo', 'Cargar Datos');
        $this->_view->renderizar('resultado', 'registrar');
    }

    public function registrarData($tipo_archivo = false) 
    {
        $this->validarUrlIdioma();
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->getLenguaje("index_inicio");
        $paginador = new Paginador();
        $this->_view->setJs(array('resultado'));
        $_SESSION['tipo_archivo'] = $this->filtrarInt($tipo_archivo);
        
        $tabla = $this->_excel->getEstandar($_SESSION['idrecurso']);
        $estandar_recurso = $tabla['Esr_NombreTabla'];

        $this->variable();

        $descarga = $_SESSION['Descargar'];
        $cabecera = array_shift($descarga);
        $_SESSION['cabecera'] = $cabecera;
        $_SESSION['datos_no_registrados'] = $descarga;
        $this->_view->assign('total_registrado', $_SESSION['total_registrado']);
        $this->_view->assign('total_no_registrado', $_SESSION['total_no_registrado']);
        $this->_view->assign('no_registrado', $paginador->paginar($_SESSION['datos_no_registrados'], "", "", "", 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('total_registros', $_SESSION['total_registros']);
        $this->_view->assign('cabecera', $_SESSION['cabecera']);
        unlink($_SESSION['archivo']);
        unset($descarga);
        unset($cabecera);
        Session::destroy('excel');
        Session::destroy('archivo');
        Session::destroy('hoja');
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        Session::destroy('idrecurso');
        Session::destroy('recurso');
        $this->_view->assign('titulo', 'Cargar Datos');
        $this->_view->renderizar('resultado', 'registrar');
    }

    public function variable()
    {
        $bdEstandar = $this->loadModel('registros', 'estandar');
        $total_registrado = 0;
        $total_no_registrado = 0;
        $datos = array();
        $fichaEstandar = $this->_excel->getFichaEstandar($_SESSION['idrecurso'], Cookie::lenguaje());
        $nombre_tabla = 'variable_'.$fichaEstandar[0]['Fie_NombreTabla'];
        $nombre_tabla2 = 'data_'.$fichaEstandar[0]['Fie_NombreTabla'];
        $fichaVariable = $this->_excel->getFichaVariable($nombre_tabla);
        $idRecurso=$_SESSION['recurso'];

        //echo $_SESSION['idrecurso']; exit();
        $escripFicha = ' ';

        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'],0,3);
        
        $campo_id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $nombre_tabla)));
        $campo_nombre = $ini.'_Nombre';

        //$campo_tipo = $ini.'_Tipodato';
        //$campo_etiqueta = $ini.'_Etiqueta';
        $campo_estado = $ini.'_Estado';

        array_push($datos, $_SESSION['encabezado']);

        if (empty($_SESSION['tipo_archivo'])) 
        {
            new PHPExcel();
            $archivo = $_SESSION['archivo'];
            $hoja = $_SESSION['hoja'];

            $objReader = PHPExcel_IOFactory::createReaderForFile($archivo);
            $objPHPExcel = $objReader->load($archivo);

            $objHoja = $objPHPExcel->setActiveSheetIndexByName($hoja)->toArray();
            array_shift($objHoja);

            $i=1;

            foreach ($objHoja as $iIndice => $objCelda) 
            {
                foreach ($fichaVariable as $ficha) 
                {                   
                    $escripFicha .= " '" . $objCelda[$_POST[$ficha[$campo_nombre]]] . " ', ";
                    $insertar = "INSERT INTO " . $nombre_tabla2 . " VALUES ( null, " .$i.", " .$ficha[$campo_id].", " . $escripFicha . "  1)";
                   
                   $escripFicha = ' ';
                
                    $registrados = $bdEstandar->insertarRegistro($insertar);
                    $insertar = '';

                    if ($registrados == 1) 
                    {
                        $total_registrado++;
                    } 
                    else 
                    {
                        array_push($datos, $objCelda);
                        $total_no_registrado++;
                    }
                }
                
                //$escripFicha .= " " . $objCelda[0] . " , ";
                //$escripFicha .= " " . $objCelda[1] . " , ";
                //$escripFicha .= " '" . $objCelda[2] . "' , ";  
                

                //$insertar = "INSERT INTO " . $nombre_tabla2 . " VALUES ( null, " . $escripFicha . "  1)";
                
                

                $i=$i+1;
            }

            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($objHoja);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
            unset($objHoja);
            unset($objReader);
            unset($objPHPExcel);
        } 
        else 
        {
            foreach ($_SESSION['valores_final'] as $objCelda) 
            {
                foreach ($fichaVariable as $ficha) 
                {                   
                    $escripFicha .= " " . $objCelda[$_POST[$ficha[$campo_nombre]]] . " , ";
                    $insertar = "INSERT INTO " . $nombre_tabla2 . " VALUES ( null, " .$i.", " .$ficha[$campo_id].", " . $escripFicha . "  1)";
                    $escripFicha = ' ';
                
                    $registrados = $bdEstandar->insertarRegistro($insertar);
                    $insertar = '';

                    if ($registrados == 1) 
                    {
                        $total_registrado++;
                    } 
                    else 
                    {
                        array_push($datos, $objCelda);
                        $total_no_registrado++;
                    }
                }
            }

            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($_SESSION['valores_final']);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
        }
    }
    public function estandar($tipo_estandar) 
    {
        $bdEstandar = $this->loadModel('registros', 'estandar');
        $total_registrado = 0;
        $total_no_registrado = 0;
        $datos = array();
        $fichaEstandar = $this->_excel->getFichaEstandar($_SESSION['idrecurso'], Cookie::lenguaje());
        $escripFicha = ' ';

        array_push($datos, $_SESSION['encabezado']);

        if (empty($_SESSION['tipo_archivo'])) 
        {
            new PHPExcel();
            $archivo = $_SESSION['archivo'];
            $hoja = $_SESSION['hoja'];

            $objReader = PHPExcel_IOFactory::createReaderForFile($archivo);
            $objPHPExcel = $objReader->load($archivo);

            $objHoja = $objPHPExcel->setActiveSheetIndexByName($hoja)->toArray();
            array_shift($objHoja);

            foreach ($objHoja as $iIndice => $objCelda) 
            {
                foreach ($fichaEstandar as $ficha) 
                {
                    if ($ficha['Fie_TipoDatoCampo'] == "int" || $ficha['Fie_TipoDatoCampo'] == "double") 
                    {
                        //echo $_POST[$ficha['Fie_ColumnaTabla']];
                        if ($_POST[$ficha['Fie_ColumnaTabla']] != '' && is_numeric($objCelda[$_POST[$ficha['Fie_ColumnaTabla']]])) 
                        {
                            $escripFicha .= " " . $objCelda[$_POST[$ficha['Fie_ColumnaTabla']]] . " , ";
                        } 
                        else 
                        {
                            $escripFicha .= " 0,";
                        }
                    }
                    if ($ficha['Fie_TipoDatoCampo'] == "varchar") 
                    {
                        if ($_POST[$ficha['Fie_ColumnaTabla']] != '') 
                        {
                            $escripFicha .= " '" . $objCelda[$_POST[$ficha['Fie_ColumnaTabla']]] . "' , ";
                        } 
                        else 
                        {
                            $escripFicha .= " ''," ;
                        }
                    }

                    $tabla = $ficha['Fie_NombreTabla'];
                    
                }

                if ($tipo_estandar==2) 
                {
                    $tabla = 'variable_'.$tabla;
                    /*$insertar = "INSERT INTO " . $tabla . " VALUES ( null, " . $escripFicha . " "
                        . " '" . Cookie::lenguaje() . "', 1)";*/
                }
                
                $insertar = "INSERT INTO " . $tabla . " VALUES ( null, " . $escripFicha . " "
                        . " " . $_SESSION['recurso'] . ", '" . Cookie::lenguaje() . "', 1)";
                
                $escripFicha = ' ';
                //echo $insertar; exit;
                $registrados = $bdEstandar->insertarRegistro($insertar);
                $insertar = '';

                if ($registrados == 1) 
                {
                    $total_registrado++;
                } 
                else 
                {
                    array_push($datos, $objCelda);
                    $total_no_registrado++;
                }
            }

            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($objHoja);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
            unset($objHoja);
            unset($objReader);
            unset($objPHPExcel);
        } 
        else 
        {
            foreach ($_SESSION['valores_final'] as $objCelda) 
            {
                foreach ($fichaEstandar as $ficha) 
                {
                    if ($ficha['Fie_TipoDatoCampo'] == "int" || $ficha['Fie_TipoDatoCampo'] == "double") 
                    {
                        if ($_POST[$ficha['Fie_ColumnaTabla']] != '') 
                        {
                            $escripFicha .= " " . $objCelda[$_POST[$ficha['Fie_ColumnaTabla']]] . " , ";
                        } 
                        else 
                        {
                            $escripFicha .= " 0,";
                        }
                    }
                    if ($ficha['Fie_TipoDatoCampo'] == "varchar") 
                    {
                        if ($_POST[$ficha['Fie_ColumnaTabla']] != '') 
                        {
                            $escripFicha .= " '" . $objCelda[$_POST[$ficha['Fie_ColumnaTabla']]] . "' , ";
                        } 
                        else 
                        {
                            $escripFicha .= " '',";
                        }
                    }

                    $tabla = $ficha['Fie_NombreTabla'];
                    
                }

                if ($tipo_estandar==2) 
                {
                    $tabla = 'variable_'.$tabla;

                    $insertar = "INSERT INTO " . $tabla . " VALUES ( null, " . $escripFicha . " "
                        . " '" . Cookie::lenguaje() . "', 1)";

                }
                else
                {
                    $insertar = "INSERT INTO " . $tabla . " VALUES ( null, " . $escripFicha . " "
                        . " " . $_SESSION['recurso'] . ", '" . Cookie::lenguaje() . "', 1)";
                }
                //echo $insertar; exit();

                $escripFicha = ' ';

                $registrados = $bdEstandar->insertarRegistro($insertar);
                $insertar = '';

                if ($registrados == 1) 
                {
                    $total_registrado++;
                } 
                else 
                {
                    array_push($datos, $objCelda);
                    $total_no_registrado++;
                }
            }

            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($_SESSION['valores_final']);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
        }
    }

    public function dublincore() 
    {
        $total_registrado = 0;
        $total_no_registrado = 0;

        $Dub_Editor = "";
        $Idi_IdIdioma = Cookie::lenguaje();
        $Dub_Colaborador = "";
        $Dub_FechaDocumento = "";
        $Dub_Formato = "Otros";
        $Dub_Identificador = "";
        $Dub_Fuente = "";
        $Dub_Idioma = "";
        $Dub_Relacion = "";
        $Dub_Cobertura = "";
        $Dub_Derechos = "";
        $Aut_Profesion = "";
        $Aut_Email = "";
        $Tid_Descripcion = "Otros";
        $Ted_Descripcion = "Otros";
        $Dub_Descripcion = "";
        $Dub_Titulo = "";
        $Pai_Nombre = "";
        $Aut_Nombre = "";
        $Dub_PalabraClave = "Otros";
        $Arf_IdArchivoFisico = "";
        $Arf_URL = "";
        $datos = array();
        array_push($datos, $_SESSION['encabezado']);

        if (empty($_SESSION['tipo_archivo'])) 
        {
            new PHPExcel();
            $archivo = $_SESSION['archivo'];
            $hoja = $_SESSION['hoja'];

            $objReader = PHPExcel_IOFactory::createReaderForFile($archivo);
            $objPHPExcel = $objReader->load($archivo);

            $objHoja = $objPHPExcel->setActiveSheetIndexByName($hoja)->toArray();
            array_shift($objHoja);


            foreach ($objHoja as $iIndice => $objCelda) 
            {
                if ($_POST['Dub_Titulo'] != '') 
                {
                    $Dub_Titulo = $objCelda[$_POST['Dub_Titulo']];
                }

                if ($_POST['Arf_IdArchivoFisico'] != '') 
                {
                    $Arf_IdArchivoFisico = $objCelda[$_POST['Arf_IdArchivoFisico']];
                }

                if ($_POST['Pai_Nombre'] != '') 
                {
                    $Pai_Nombre = $objCelda[$_POST['Pai_Nombre']];
                }

                if ($_POST['Arf_URL'] != '') 
                {
                    $Arf_URL = $objCelda[$_POST['Arf_URL']];
                }

                if ($_POST['Aut_Nombre'] != '') 
                {
                    $Aut_Nombre = $objCelda[$_POST['Aut_Nombre']];
                }

                if ($Dub_Titulo != '' and ( $Arf_IdArchivoFisico != '' or $Arf_URL != '') and $Pai_Nombre != '' and $Aut_Nombre != '') 
                {
                    if ($_POST['Dub_Descripcion'] != '') 
                    {
                        $Dub_Descripcion = $objCelda[$_POST['Dub_Descripcion']];
                    }

                    if ($_POST['Dub_Editor'] != '') 
                    {
                        $Dub_Editor = $objCelda[$_POST['Dub_Editor']];
                    }

                    if ($_POST['Dub_Colaborador'] != '') 
                    {
                        $Dub_Colaborador = $objCelda[$_POST['Dub_Colaborador']];
                    }

                    if ($_POST['Dub_FechaDocumento'] != '') 
                    {
                        $Dub_FechaDocumento = $objCelda[$_POST['Dub_FechaDocumento']];
                    }

                    if ($_POST['Dub_Formato'] != '') 
                    {
                        $Dub_Formato = $objCelda[$_POST['Dub_Formato']];
                    }

                    if ($_POST['Dub_Identificador'] != '') 
                    {
                        $Dub_Identificador = $objCelda[$_POST['Dub_Identificador']];
                    }

                    if ($_POST['Dub_Fuente'] != '') 
                    {
                        $Dub_Fuente = $objCelda[$_POST['Dub_Fuente']];
                    }

                    if ($_POST['Idi_Idioma'] != '') 
                    {
                        $idioma = $this->_excel->getIdioma($objCelda[$_POST['Idi_Idioma']]);

                        if ($idioma) 
                        {
                            $Idi_Idioma = $idioma[0];
                        }
                    }

                    if ($_POST['Dub_Idioma'] != '') 
                    {
                        $Dub_Idioma = $objCelda[$_POST['Dub_Idioma']];
                    }

                    if ($_POST['Dub_Relacion'] != '') 
                    {
                        $Dub_Relacion = $objCelda[$_POST['Dub_Relacion']];
                    }

                    if ($_POST['Dub_Cobertura'] != '') 
                    {
                        $Dub_Cobertura = $objCelda[$_POST['Dub_Cobertura']];
                    }

                    if ($_POST['Dub_Derechos'] != '') 
                    {
                        $Dub_Derechos = $objCelda[$_POST['Dub_Derechos']];
                    }

                    if ($_POST['Dub_PalabraClave'] != '') 
                    {
                        $Dub_PalabraClave = $objCelda[$_POST['Dub_PalabraClave']];
                    }

                    if ($_POST['Aut_Profesion'] != '') 
                    {
                        $Aut_Profesion = $objCelda[$_POST['Aut_Profesion']];
                    }

                    if ($_POST['Aut_Email'] != '') 
                    {
                        $Aut_Email = $objCelda[$_POST['Aut_Email']];
                    }

                    if ($_POST['Tid_Descripcion'] != '') 
                    {
                        $Tid_Descripcion = $objCelda[$_POST['Tid_Descripcion']];
                    }

                    if ($_POST['Ted_IdTemaDublin'] != '') 
                    {
                        $Ted_Descripcion = $objCelda[$_POST['Ted_IdTemaDublin']];
                    }

                    $formato = $this->_excel->getFormatoArchivo($Dub_Formato);

                    if (empty($formato)) 
                    {
                        $formato = $this->_excel->registrarFormatoArchivo(ucwords($Dub_Formato));
                    }

                    $autor = $this->_excel->getAutor($Aut_Nombre);

                    if (empty($autor)) 
                    {
                        $autor = $this->_excel->registrarAutor(ucwords($Aut_Nombre));
                    }

                    $tipodublin = $this->_excel->getTipoDublin($Tid_Descripcion, $Idi_IdIdioma);

                    if (empty($tipodublin)) 
                    {
                        $tipodublin = $this->_excel->registrarTipoDublin(ucwords(strtolower($Tid_Descripcion)), $Idi_IdIdioma);
                    }

                    $nombrearchivo = $this->_excel->getArchivoFisico($Arf_IdArchivoFisico);
                    $temadublin = $this->_excel->getTemaDublin($Ted_Descripcion);

                    if (empty($temadublin)) 
                    {
                        $temadublin = $this->_excel->registrarTemaDublin(ucwords(strtolower($Ted_Descripcion)), $Idi_IdIdioma);
                    }

                    if (!empty($nombrearchivo)) 
                    {
                        $this->_excel->actualizarArchivoFisico($formato[0], $nombrearchivo[0], $Arf_URL);
                    } 
                    else 
                    {
                        $url = $this->_excel->registrarUrlArchivoFisico($Arf_URL, $formato[0]);
                    }

                    $url = $this->_excel->getArchivoFisicoURL($Arf_URL);

                    if (!empty($url)) 
                    {
                        $dublin = $this->_excel->getDublinCore($Dub_Titulo, $tipodublin[0]);

                        if (empty($dublin)) 
                        {
                            $dublin = $this->_excel->registrarDublinCore($Dub_Titulo, $Dub_Descripcion, $Dub_Editor, $Dub_Colaborador, $Dub_FechaDocumento, $formato[0], $Dub_Identificador, $Dub_Fuente, $Dub_Idioma, $Dub_Relacion, $Dub_Cobertura, $Dub_Derechos, $Dub_PalabraClave, $tipodublin[0], $_SESSION['recurso'], $Idi_IdIdioma, $url[0], $temadublin[0]);

                            $total_registrado++;

                            if ($dublin) 
                            {
                                $dublinautor = $this->_excel->registrarDublinAutor($dublin[0], $autor[0]);
                                $Pai_Nombre = explode(",", $Pai_Nombre);

                                foreach ($Pai_Nombre as $Pai_Nombre) 
                                {
                                    $Pai_Nombres = trim($Pai_Nombre);
                                    $pais = $this->_excel->getPais($Pai_Nombres);

                                    if (isset($dublin) and isset($pais)) 
                                    {
                                        $documentorelacionado = $this->_excel->registrarDocumentosRelacionados($dublin[0], $pais[0]);
                                    }
                                }
                            }
                        } 
                        else 
                        {
                            array_push($datos, $objCelda);
                            $total_no_registrado++;
                        }
                    } 
                    else 
                    {
                        array_push($datos, $objCelda);
                        $total_no_registrado++;
                    }
                } 
                else 
                {
                    array_push($datos, $objCelda);
                    $total_no_registrado++;
                }
            }

            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($objHoja);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
            unset($objHoja);
            unset($objReader);
            unset($objPHPExcel);
        } 
        else 
        {
            foreach ($_SESSION['valores_final'] as $objCelda) 
            {
                if ($_POST['Dub_Titulo'] != '') 
                {
                    $Dub_Titulo = $objCelda[$_POST['Dub_Titulo']];
                }

                if ($_POST['Arf_IdArchivoFisico'] != '') 
                {
                    $Arf_IdArchivoFisico = $objCelda[$_POST['Arf_IdArchivoFisico']];
                }

                if ($_POST['Pai_Nombre'] != '') 
                {
                    $Pai_Nombre = $objCelda[$_POST['Pai_Nombre']];
                }

                if ($_POST['Aut_Nombre'] != '') 
                {
                    $Aut_Nombre = $objCelda[$_POST['Aut_Nombre']];
                }

                if ($_POST['Arf_URL'] != '') 
                {
                    $Arf_URL = $objCelda[$_POST['Arf_URL']];
                }

                if ($Dub_Titulo != '' and ( $Arf_IdArchivoFisico != '' or $Arf_URL != '') and $Pai_Nombre != '' and $Aut_Nombre != '') 
                {
                    if ($_POST['Dub_Descripcion'] != '') 
                    {
                        $Dub_Descripcion = $objCelda[$_POST['Dub_Descripcion']];
                    }

                    if ($_POST['Dub_Editor'] != '') 
                    {
                        $Dub_Editor = $objCelda[$_POST['Dub_Editor']];
                    }

                    if ($_POST['Dub_Colaborador'] != '') 
                    {
                        $Dub_Colaborador = $objCelda[$_POST['Dub_Colaborador']];
                    }

                    if ($_POST['Dub_FechaDocumento'] != '') 
                    {
                        $Dub_FechaDocumento = $objCelda[$_POST['Dub_FechaDocumento']];
                    }

                    if ($_POST['Dub_Formato'] != '') 
                    {
                        $Dub_Formato = $objCelda[$_POST['Dub_Formato']];
                    }

                    if ($_POST['Dub_Identificador'] != '') 
                    {
                        $Dub_Identificador = $objCelda[$_POST['Dub_Identificador']];
                    }

                    if ($_POST['Dub_Fuente'] != '') 
                    {
                        $Dub_Fuente = $objCelda[$_POST['Dub_Fuente']];
                    }

                    if ($_POST['Idi_Idioma'] != '') 
                    {
                        $idioma = $this->_excel->getIdioma($objCelda[$_POST['Idi_Idioma']]);

                        if ($idioma) 
                        {
                            $Idi_Idioma = $idioma[0];
                        }
                    }

                    if ($_POST['Dub_Idioma'] != '') 
                    {
                        $Dub_Idioma = $objCelda[$_POST['Dub_Idioma']];
                    }

                    if ($_POST['Dub_Relacion'] != '') 
                    {
                        $Dub_Relacion = $objCelda[$_POST['Dub_Relacion']];
                    }

                    if ($_POST['Dub_Cobertura'] != '') 
                    {
                        $Dub_Cobertura = $objCelda[$_POST['Dub_Cobertura']];
                    }

                    if ($_POST['Dub_Derechos'] != '') 
                    {
                        $Dub_Derechos = $objCelda[$_POST['Dub_Derechos']];
                    }

                    if ($_POST['Dub_PalabraClave'] != '') 
                    {
                        $Dub_PalabraClave = $objCelda[$_POST['Dub_PalabraClave']];
                    }

                    if ($_POST['Aut_Profesion'] != '') 
                    {
                        $Aut_Profesion = $objCelda[$_POST['Aut_Profesion']];
                    }

                    if ($_POST['Aut_Email'] != '') 
                    {
                        $Aut_Email = $objCelda[$_POST['Aut_Email']];
                    }

                    if ($_POST['Tid_Descripcion'] != '') 
                    {
                        $Tid_Descripcion = $objCelda[$_POST['Tid_Descripcion']];
                    }

                    if ($_POST['Ted_IdTemaDublin'] != '') 
                    {
                        $Ted_Descripcion = $objCelda[$_POST['Ted_IdTemaDublin']];
                    }

                    $formato = $this->_excel->getFormatoArchivo($Dub_Formato);
                    if (empty($formato)) 
                    {
                        $formato = $this->_excel->registrarFormatoArchivo(ucwords($Dub_Formato));
                    }

                    $autor = $this->_excel->getAutor($Aut_Nombre);

                    if (empty($autor)) 
                    {
                        $autor = $this->_excel->registrarAutor(ucwords($Aut_Nombre));
                    }

                    $tipodublin = $this->_excel->getTipoDublin($Tid_Descripcion, $Idi_IdIdioma);

                    if (empty($tipodublin)) 
                    {
                        $tipodublin = $this->_excel->registrarTipoDublin(ucwords(strtolower($Tid_Descripcion)), $Idi_IdIdioma);
                    }

                    $nombrearchivo = $this->_excel->getArchivoFisico($Arf_IdArchivoFisico);
                    $temadublin = $this->_excel->getTemaDublin($Ted_Descripcion, $Idi_IdIdioma);

                    if (empty($temadublin)) 
                    {
                        $temadublin = $this->_excel->registrarTemaDublin(ucwords(strtolower($Ted_Descripcion)), $Idi_IdIdioma);
                    }

                    if (!empty($nombrearchivo)) 
                    {
                        $this->_excel->actualizarArchivoFisico($formato[0], $nombrearchivo[0], $Arf_URL);
                    } 
                    else 
                    {
                        $url = $this->_excel->registrarUrlArchivoFisico($Arf_URL, $formato[0]);
                    }

                    $url = $this->_excel->getArchivoFisicoURL($Arf_URL);

                    if (!empty($url)) 
                    {

                        $this->_excel->actualizarArchivoFisico($formato[0], $nombrearchivo[0]);
                        $dublin = $this->_excel->getDublinCore($Dub_Titulo, $tipodublin[0]);

                        if (empty($dublin)) 
                        {
                            $dublin = $this->_excel->registrarDublinCore($Dub_Titulo, $Dub_Descripcion, $Dub_Editor, $Dub_Colaborador, $Dub_FechaDocumento, $formato[0], $Dub_Identificador, $Dub_Fuente, $Dub_Idioma, $Dub_Relacion, $Dub_Cobertura, $Dub_Derechos, $Dub_PalabraClave, $tipodublin[0], $_SESSION['recurso'], $Idi_IdIdioma, $url[0], $temadublin[0]);

                            $total_registrado++;

                            if ($dublin) 
                            {
                                $dublinautor = $this->_excel->registrarDublinAutor($dublin[0], $autor[0]);
                                $Pai_Nombre = explode(",", $Pai_Nombre);

                                foreach ($Pai_Nombre as $Pai_Nombre) 
                                {
                                    $Pai_Nombres = trim($Pai_Nombre);
                                    $pais = $this->_excel->getPais($Pai_Nombres);

                                    if (isset($dublin) and isset($pais)) 
                                    {
                                        $documentorelacionado = $this->_excel->registrarDocumentosRelacionados($dublin[0], $pais[0]);
                                    }
                                }
                            }
                        } 
                        else 
                        {
                            array_push($datos, $objCelda);
                            $total_no_registrado++;
                        }
                    } 
                    else 
                    {
                        array_push($datos, $objCelda);
                        $total_no_registrado++;
                    }
                } 
                else 
                {
                    array_push($datos, $objCelda);
                    $total_no_registrado++;
                }
            }
            
            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($objHoja);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
            unset($objHoja);
            unset($objReader);
            unset($objPHPExcel);
        }
    }

    public function darwincore() 
    {
        $total_registrado = 0;
        $total_no_registrado = 0;
        $datos = array();
        array_push($datos, $_SESSION['encabezado']);

        $Dar_FechaActualizacion = "";
        $Dar_CodigoInstitucion = "";
        $Dar_CodigoColeccion = "";
        $Dar_NumeroCatalogo = "";
        $Dar_NombreCientifico = "";
        $Dar_BaseRegistro = "";
        $Dar_ReinoOrganismo = "";
        $Dar_Division = "";
        $Dar_ClaseOrganismo = "";
        $Dar_OrdenOrganismo = "";
        $Dar_FamiliaOrganismo = "";
        $Dar_GeneroOrganismo = "";
        $Dar_EspecieOrganismo = "";
        $Dar_SubEspecieOrganismo = "";
        $Dar_AutorNombreCientifico = "";
        $Dar_IdentificadoPor = "";
        $Dar_AnoIdentificacion = "";
        $Dar_MesIdentificacion = "";
        $Dar_DiaIdentificacion = "";
        $Dar_StatusTipo = "";
        $Dar_NumeroColector = "";
        $Dar_NumeroCampo = "";
        $Dar_Colector = "";
        $Dar_AnoColectado = "";
        $Dar_MesColectado = "";
        $Dar_DiaColectado = "";
        $Dar_DiaOrdinario = "";
        $Dar_HoraColectado = "";
        $Dar_ContinenteOceano = "";
        $Dar_Pais = "";
        $Dar_EstadoProvincia = "";
        $Dar_Municipio = "";
        $Dar_Localidad = "";
        $Dar_Longitud = "";
        $Dar_Latitud = "";
        $Dar_PrecisionDeCordenada = "";
        $Dar_BoundingBox = "";
        $Dar_MinimaElevacion = "";
        $Dar_MaximaElevacion = "";
        $Dar_MinimaProfundidad = "";
        $Dar_MaximaProfundidad = "";
        $Dar_SexoOrganismo = "";
        $Dar_PreparacionTipo = "";
        $Dar_ConteoIndividuo = "";
        $Dar_NumeroCatalogoAnterior = "";
        $Dar_TipoRelacion = "";
        $Dar_InformacionRelacionada = "";
        $Dar_EstadoVida = "";
        $Dar_Nota = "";
        $Dar_NombreComunOrganismo = "";

        if (empty($_SESSION['tipo_archivo'])) 
        {
            new PHPExcel();
            $archivo = $_SESSION['archivo'];
            $hoja = $_SESSION['hoja'];

            $objReader = PHPExcel_IOFactory::createReaderForFile($archivo);
            $objPHPExcel = $objReader->load($archivo);

            $objHoja = $objPHPExcel->setActiveSheetIndexByName($hoja)->toArray();
            array_shift($objHoja);

            foreach ($objHoja as $iIndice => $objCelda) 
            {
                if ($_POST['Dar_FechaActualizacion'] != '') 
                {
                    $Dar_FechaActualizacion = $objCelda[$_POST['Dar_FechaActualizacion']];
                }

                if ($_POST['Dar_CodigoInstitucion'] != '') 
                {
                    $Dar_CodigoInstitucion = $objCelda[$_POST['Dar_CodigoInstitucion']];
                }

                if ($_POST['Dar_CodigoColeccion'] != '') 
                {
                    $Dar_CodigoColeccion = $objCelda[$_POST['Dar_CodigoColeccion']];
                }

                if ($_POST['Dar_NumeroCatalogo'] != '') 
                {
                    $Dar_NumeroCatalogo = $objCelda[$_POST['Dar_NumeroCatalogo']];
                }

                if ($_POST['Dar_NombreCientifico'] != '') 
                {
                    $Dar_NombreCientifico = $objCelda[$_POST['Dar_NombreCientifico']];
                }

                if ($_POST['Dar_BaseRegistro'] != '') 
                {
                    $Dar_BaseRegistro = $objCelda[$_POST['Dar_BaseRegistro']];
                }

                if ($_POST['Dar_ReinoOrganismo'] != '') 
                {
                    $Dar_ReinoOrganismo = $objCelda[$_POST['Dar_ReinoOrganismo']];
                }

                if ($_POST['Dar_Division'] != '') 
                {
                    $Dar_Division = $objCelda[$_POST['Dar_Division']];
                }
                if ($_POST['Dar_ClaseOrganismo'] != '') 
                {
                    $Dar_ClaseOrganismo = $objCelda[$_POST['Dar_ClaseOrganismo']];
                }

                if ($_POST['Dar_OrdenOrganismo'] != '') 
                {
                    $Dar_OrdenOrganismo = $objCelda[$_POST['Dar_OrdenOrganismo']];
                }

                if ($_POST['Dar_FamiliaOrganismo'] != '') 
                {
                    $Dar_FamiliaOrganismo = $objCelda[$_POST['Dar_FamiliaOrganismo']];
                }

                if ($_POST['Dar_GeneroOrganismo'] != '') 
                {
                    $Dar_GeneroOrganismo = $objCelda[$_POST['Dar_GeneroOrganismo']];
                }

                if ($_POST['Dar_EspecieOrganismo'] != '') 
                {
                    $Dar_EspecieOrganismo = $objCelda[$_POST['Dar_EspecieOrganismo']];
                }

                if ($_POST['Dar_SubEspecieOrganismo'] != '') 
                {
                    $Dar_SubEspecieOrganismo = $objCelda[$_POST['Dar_SubEspecieOrganismo']];
                }

                if ($_POST['Dar_AutorNombreCientifico'] != '') 
                {
                    $Dar_AutorNombreCientifico = $objCelda[$_POST['Dar_AutorNombreCientifico']];
                }

                if ($_POST['Dar_IdentificadoPor'] != '') 
                {
                    $Dar_IdentificadoPor = $objCelda[$_POST['Dar_IdentificadoPor']];
                }

                if ($_POST['Dar_AnoIdentificacion'] != '') 
                {
                    $Dar_AnoIdentificacion = $objCelda[$_POST['Dar_AnoIdentificacion']];
                }

                if ($_POST['Dar_MesIdentificacion'] != '') 
                {
                    $Dar_MesIdentificacion = $objCelda[$_POST['Dar_MesIdentificacion']];
                }

                if ($_POST['Dar_DiaIdentificacion'] != '') 
                {
                    $Dar_DiaIdentificacion = $objCelda[$_POST['Dar_DiaIdentificacion']];
                }

                if ($_POST['Dar_StatusTipo'] != '') 
                {
                    $Dar_StatusTipo = $objCelda[$_POST['Dar_StatusTipo']];
                }

                if ($_POST['Dar_NumeroColector'] != '') 
                {
                    $Dar_NumeroColector = $objCelda[$_POST['Dar_NumeroColector']];
                }

                if ($_POST['Dar_NumeroCampo'] != '') 
                {
                    $Dar_NumeroCampo = $objCelda[$_POST['Dar_NumeroCampo']];
                }

                if ($_POST['Dar_Colector'] != '') 
                {
                    $Dar_Colector = $objCelda[$_POST['Dar_Colector']];
                }

                if ($_POST['Dar_AnoColectado'] != '') 
                {
                    $Dar_AnoColectado = $objCelda[$_POST['Dar_AnoColectado']];
                }

                if ($_POST['Dar_MesColectado'] != '') 
                {
                    $Dar_MesColectado = $objCelda[$_POST['Dar_MesColectado']];
                }

                if ($_POST['Dar_DiaColectado'] != '') 
                {
                    $Dar_DiaColectado = $objCelda[$_POST['Dar_DiaColectado']];
                }

                if ($_POST['Dar_DiaOrdinario'] != '') 
                {
                    $Dar_DiaOrdinario = $objCelda[$_POST['Dar_DiaOrdinario']];
                }

                if ($_POST['Dar_HoraColectado'] != '') 
                {
                    $Dar_HoraColectado = $objCelda[$_POST['Dar_HoraColectado']];
                }

                if ($_POST['Dar_ContinenteOceano'] != '') 
                {
                    $Dar_ContinenteOceano = $objCelda[$_POST['Dar_ContinenteOceano']];
                }

                if ($_POST['Dar_Pais'] != '') 
                {
                    $Dar_Pais = $objCelda[$_POST['Dar_Pais']];
                }

                if ($_POST['Dar_EstadoProvincia'] != '') 
                {
                    $Dar_EstadoProvincia = $objCelda[$_POST['Dar_EstadoProvincia']];
                }

                if ($_POST['Dar_Municipio'] != '') 
                {
                    $Dar_Municipio = $objCelda[$_POST['Dar_Municipio']];
                    ;
                }

                if ($_POST['Dar_Localidad'] != '') 
                {
                    $Dar_Localidad = $objCelda[$_POST['Dar_Localidad']];
                }

                if ($_POST['Dar_Longitud'] != '') 
                {
                    $Dar_Longitud = $objCelda[$_POST['Dar_Longitud']];
                }

                if ($_POST['Dar_Latitud'] != '') 
                {
                    $Dar_Latitud = $objCelda[$_POST['Dar_Latitud']];
                }

                if ($_POST['Dar_PrecisionDeCordenada'] != '') 
                {
                    $Dar_PrecisionDeCordenada = $objCelda[$_POST['Dar_PrecisionDeCordenada']];
                }

                if ($_POST['Dar_BoundingBox'] != '') 
                {
                    $Dar_BoundingBox = $objCelda[$_POST['Dar_BoundingBox']];
                }

                if ($_POST['Dar_MinimaElevacion'] != '') 
                {
                    $Dar_MinimaElevacion = $objCelda[$_POST['Dar_MinimaElevacion']];
                }

                if ($_POST['Dar_MaximaElevacion'] != '') 
                {
                    $Dar_MaximaElevacion = $objCelda[$_POST['Dar_MaximaElevacion']];
                }

                if ($_POST['Dar_MinimaProfundidad'] != '') 
                {
                    $Dar_MinimaProfundidad = $objCelda[$_POST['Dar_MinimaProfundidad']];
                }

                if ($_POST['Dar_MaximaProfundidad'] != '') 
                {
                    $Dar_MaximaProfundidad = $objCelda[$_POST['Dar_MaximaProfundidad']];
                }

                if ($_POST['Dar_SexoOrganismo'] != '') 
                {
                    $Dar_SexoOrganismo = $objCelda[$_POST['Dar_SexoOrganismo']];
                }

                if ($_POST['Dar_PreparacionTipo'] != '') 
                {
                    $Dar_PreparacionTipo = $objCelda[$_POST['Dar_PreparacionTipo']];
                }

                if ($_POST['Dar_ConteoIndividuo'] != '') 
                {
                    $Dar_ConteoIndividuo = $objCelda[$_POST['Dar_ConteoIndividuo']];
                }

                if ($_POST['Dar_NumeroCatalogoAnterior'] != '') 
                {
                    $Dar_NumeroCatalogoAnterior = $objCelda[$_POST['Dar_NumeroCatalogoAnterior']];
                }

                if ($_POST['Dar_TipoRelacion'] != '') 
                {
                    $Dar_TipoRelacion = $objCelda[$_POST['Dar_TipoRelacion']];
                }

                if ($_POST['Dar_InformacionRelacionada'] != '') 
                {
                    $Dar_InformacionRelacionada = $objCelda[$_POST['Dar_InformacionRelacionada']];
                }

                if ($_POST['Dar_EstadoVida'] != '') 
                {
                    $Dar_EstadoVida = $objCelda[$_POST['Dar_EstadoVida']];
                }

                if ($_POST['Dar_Nota'] != '') 
                {
                    $Dar_Nota = $objCelda[$_POST['Dar_Nota']];
                }

                if ($_POST['Dar_NombreComunOrganismo'] != '') 
                {
                    $Dar_NombreComunOrganismo = $objCelda[$_POST['Dar_NombreComunOrganismo']];
                }

                if ($Dar_Longitud != '' and $Dar_Latitud != '' and ( $Dar_NombreCientifico != '' or ( $Dar_GeneroOrganismo and $Dar_EspecieOrganismo)) and is_numeric(str_replace(',', '.', $Dar_Longitud)) and is_numeric(str_replace(',', '.', $Dar_Latitud))) 
                {
                    $darwin = $this->_excel->registrarDarwinCore(
                            $Dar_FechaActualizacion, $Dar_CodigoInstitucion, $Dar_CodigoColeccion, $Dar_NumeroCatalogo, $Dar_NombreCientifico, $Dar_BaseRegistro, $Dar_ReinoOrganismo, $Dar_Division, $Dar_ClaseOrganismo, $Dar_OrdenOrganismo, $Dar_FamiliaOrganismo, $Dar_GeneroOrganismo, $Dar_EspecieOrganismo, $Dar_SubEspecieOrganismo, $Dar_AutorNombreCientifico, $Dar_IdentificadoPor, $Dar_AnoIdentificacion, $Dar_MesIdentificacion, $Dar_DiaIdentificacion, $Dar_StatusTipo, $Dar_NumeroColector, $Dar_NumeroCampo, $Dar_Colector, $Dar_AnoColectado, $Dar_MesColectado, $Dar_DiaColectado, $Dar_DiaOrdinario, $Dar_HoraColectado, $Dar_ContinenteOceano, $Dar_Pais, $Dar_EstadoProvincia, $Dar_Municipio, $Dar_Localidad, str_replace(',', '.', $Dar_Longitud), str_replace(',', '.', $Dar_Latitud), $Dar_PrecisionDeCordenada, $Dar_BoundingBox, $Dar_MinimaElevacion, $Dar_MaximaElevacion, $Dar_MinimaProfundidad, $Dar_MaximaProfundidad, $Dar_SexoOrganismo, $Dar_PreparacionTipo, $Dar_ConteoIndividuo, $Dar_NumeroCatalogoAnterior, $Dar_TipoRelacion, $Dar_InformacionRelacionada, $Dar_EstadoVida, $Dar_Nota, $Dar_NombreComunOrganismo, $_SESSION['recurso']
                    );
                    $total_registrado++;
                } 
                else 
                {
                    array_push($datos, $objCelda);
                    $total_no_registrado++;
                }
            }

            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($objHoja);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
            unset($objHoja);
            unset($objReader);
            unset($objPHPExcel);
            unset($total_no_registrado);
            unset($total_registrado);
        } 
        else 
        {
            foreach ($_SESSION['valores_final'] as $objCelda) 
            {
                if ($_POST['Dar_FechaActualizacion'] != '') 
                {
                    $Dar_FechaActualizacion = $objCelda[$_POST['Dar_FechaActualizacion']];
                }

                if ($_POST['Dar_CodigoInstitucion'] != '') 
                {
                    $Dar_CodigoInstitucion = $objCelda[$_POST['Dar_CodigoInstitucion']];
                }

                if ($_POST['Dar_CodigoColeccion'] != '') 
                {
                    $Dar_CodigoColeccion = $objCelda[$_POST['Dar_CodigoColeccion']];
                }

                if ($_POST['Dar_NumeroCatalogo'] != '') 
                {
                    $Dar_NumeroCatalogo = $objCelda[$_POST['Dar_NumeroCatalogo']];
                }

                if ($_POST['Dar_NombreCientifico'] != '') 
                {
                    $Dar_NombreCientifico = $objCelda[$_POST['Dar_NombreCientifico']];
                }

                if ($_POST['Dar_BaseRegistro'] != '') 
                {
                    $Dar_BaseRegistro = $objCelda[$_POST['Dar_BaseRegistro']];
                }

                if ($_POST['Dar_ReinoOrganismo'] != '') 
                {
                    $Dar_ReinoOrganismo = $objCelda[$_POST['Dar_ReinoOrganismo']];
                }

                if ($_POST['Dar_Division'] != '') 
                {
                    $Dar_Division = $objCelda[$_POST['Dar_Division']];
                }

                if ($_POST['Dar_ClaseOrganismo'] != '') 
                {
                    $Dar_ClaseOrganismo = $objCelda[$_POST['Dar_ClaseOrganismo']];
                }

                if ($_POST['Dar_OrdenOrganismo'] != '') 
                {
                    $Dar_OrdenOrganismo = $objCelda[$_POST['Dar_OrdenOrganismo']];
                }

                if ($_POST['Dar_FamiliaOrganismo'] != '') 
                {
                    $Dar_FamiliaOrganismo = $objCelda[$_POST['Dar_FamiliaOrganismo']];
                }

                if ($_POST['Dar_GeneroOrganismo'] != '') 
                {
                    $Dar_GeneroOrganismo = $objCelda[$_POST['Dar_GeneroOrganismo']];
                }

                if ($_POST['Dar_EspecieOrganismo'] != '') 
                {
                    $Dar_EspecieOrganismo = $objCelda[$_POST['Dar_EspecieOrganismo']];
                }

                if ($_POST['Dar_SubEspecieOrganismo'] != '') 
                {
                    $Dar_SubEspecieOrganismo = $objCelda[$_POST['Dar_SubEspecieOrganismo']];
                }

                if ($_POST['Dar_AutorNombreCientifico'] != '') 
                {
                    $Dar_AutorNombreCientifico = $objCelda[$_POST['Dar_AutorNombreCientifico']];
                }

                if ($_POST['Dar_IdentificadoPor'] != '') 
                {
                    $Dar_IdentificadoPor = $objCelda[$_POST['Dar_IdentificadoPor']];
                }

                if ($_POST['Dar_AnoIdentificacion'] != '') 
                {
                    $Dar_AnoIdentificacion = $objCelda[$_POST['Dar_AnoIdentificacion']];
                }

                if ($_POST['Dar_MesIdentificacion'] != '') 
                {
                    $Dar_MesIdentificacion = $objCelda[$_POST['Dar_MesIdentificacion']];
                }

                if ($_POST['Dar_DiaIdentificacion'] != '') 
                {
                    $Dar_DiaIdentificacion = $objCelda[$_POST['Dar_DiaIdentificacion']];
                }

                if ($_POST['Dar_StatusTipo'] != '') 
                {
                    $Dar_StatusTipo = $objCelda[$_POST['Dar_StatusTipo']];
                }

                if ($_POST['Dar_NumeroColector'] != '') 
                {
                    $Dar_NumeroColector = $objCelda[$_POST['Dar_NumeroColector']];
                }

                if ($_POST['Dar_NumeroCampo'] != '') 
                {
                    $Dar_NumeroCampo = $objCelda[$_POST['Dar_NumeroCampo']];
                }

                if ($_POST['Dar_Colector'] != '') 
                {
                    $Dar_Colector = $objCelda[$_POST['Dar_Colector']];
                }

                if ($_POST['Dar_AnoColectado'] != '') 
                {
                    $Dar_AnoColectado = $objCelda[$_POST['Dar_AnoColectado']];
                }

                if ($_POST['Dar_MesColectado'] != '') 
                {
                    $Dar_MesColectado = $objCelda[$_POST['Dar_MesColectado']];
                }

                if ($_POST['Dar_DiaColectado'] != '') 
                {
                    $Dar_DiaColectado = $objCelda[$_POST['Dar_DiaColectado']];
                }

                if ($_POST['Dar_DiaOrdinario'] != '') 
                {
                    $Dar_DiaOrdinario = $objCelda[$_POST['Dar_DiaOrdinario']];
                }

                if ($_POST['Dar_HoraColectado'] != '') 
                {
                    $Dar_HoraColectado = $objCelda[$_POST['Dar_HoraColectado']];
                }

                if ($_POST['Dar_ContinenteOceano'] != '') 
                {
                    $Dar_ContinenteOceano = $objCelda[$_POST['Dar_ContinenteOceano']];
                }

                if ($_POST['Dar_Pais'] != '') 
                {
                    $Dar_Pais = $objCelda[$_POST['Dar_Pais']];
                }

                if ($_POST['Dar_EstadoProvincia'] != '') 
                {
                    $Dar_EstadoProvincia = $objCelda[$_POST['Dar_EstadoProvincia']];
                }

                if ($_POST['Dar_Municipio'] != '') 
                {
                    $Dar_Municipio = $objCelda[$_POST['Dar_Municipio']];
                }

                if ($_POST['Dar_Localidad'] != '') 
                {
                    $Dar_Localidad = $objCelda[$_POST['Dar_Localidad']];
                }

                if ($_POST['Dar_Longitud'] != '') 
                {
                    $Dar_Longitud = $objCelda[$_POST['Dar_Longitud']];
                }

                if ($_POST['Dar_Latitud'] != '') 
                {
                    $Dar_Latitud = $objCelda[$_POST['Dar_Latitud']];
                }

                if ($_POST['Dar_PrecisionDeCordenada'] != '') 
                {
                    $Dar_PrecisionDeCordenada = $objCelda[$_POST['Dar_PrecisionDeCordenada']];
                }

                if ($_POST['Dar_BoundingBox'] != '') 
                {
                    $Dar_BoundingBox = $objCelda[$_POST['Dar_BoundingBox']];
                }

                if ($_POST['Dar_MinimaElevacion'] != '') 
                {
                    $Dar_MinimaElevacion = $objCelda[$_POST['Dar_MinimaElevacion']];
                }

                if ($_POST['Dar_MaximaElevacion'] != '') 
                {
                    $Dar_MaximaElevacion = $objCelda[$_POST['Dar_MaximaElevacion']];
                }

                if ($_POST['Dar_MinimaProfundidad'] != '') 
                {
                    $Dar_MinimaProfundidad = $objCelda[$_POST['Dar_MinimaProfundidad']];
                }

                if ($_POST['Dar_MaximaProfundidad'] != '') 
                {
                    $Dar_MaximaProfundidad = $objCelda[$_POST['Dar_MaximaProfundidad']];
                }

                if ($_POST['Dar_SexoOrganismo'] != '') 
                {
                    $Dar_SexoOrganismo = $objCelda[$_POST['Dar_SexoOrganismo']];
                }

                if ($_POST['Dar_PreparacionTipo'] != '') 
                {
                    $Dar_PreparacionTipo = $objCelda[$_POST['Dar_PreparacionTipo']];
                }

                if ($_POST['Dar_ConteoIndividuo'] != '') 
                {
                    $Dar_ConteoIndividuo = $objCelda[$_POST['Dar_ConteoIndividuo']];
                }

                if ($_POST['Dar_NumeroCatalogoAnterior'] != '') 
                {
                    $Dar_NumeroCatalogoAnterior = $objCelda[$_POST['Dar_NumeroCatalogoAnterior']];
                }

                if ($_POST['Dar_TipoRelacion'] != '') 
                {
                    $Dar_TipoRelacion = $objCelda[$_POST['Dar_TipoRelacion']];
                }

                if ($_POST['Dar_InformacionRelacionada'] != '') 
                {
                    $Dar_InformacionRelacionada = $objCelda[$_POST['Dar_InformacionRelacionada']];
                }

                if ($_POST['Dar_EstadoVida'] != '') 
                {
                    $Dar_EstadoVida = $objCelda[$_POST['Dar_EstadoVida']];
                }

                if ($_POST['Dar_Nota'] != '') 
                {
                    $Dar_Nota = $objCelda[$_POST['Dar_Nota']];
                }

                if ($_POST['Dar_NombreComunOrganismo'] != '') 
                {
                    $Dar_NombreComunOrganismo = $objCelda[$_POST['Dar_NombreComunOrganismo']];
                }

                if ($Dar_Longitud != '' and $Dar_Latitud != '' and ( $Dar_NombreCientifico != '' or ( $Dar_GeneroOrganismo and $Dar_EspecieOrganismo)) and is_numeric(str_replace(',', '.', $Dar_Longitud)) and is_numeric(str_replace(',', '.', $Dar_Latitud))) 
                {
                    $darwin = $this->_excel->registrarDarwinCore(
                            $Dar_FechaActualizacion, $Dar_CodigoInstitucion, $Dar_CodigoColeccion, $Dar_NumeroCatalogo, $Dar_NombreCientifico, $Dar_BaseRegistro, $Dar_ReinoOrganismo, $Dar_Division, $Dar_ClaseOrganismo, $Dar_OrdenOrganismo, $Dar_FamiliaOrganismo, $Dar_GeneroOrganismo, $Dar_EspecieOrganismo, $Dar_SubEspecieOrganismo, $Dar_AutorNombreCientifico, $Dar_IdentificadoPor, $Dar_AnoIdentificacion, $Dar_MesIdentificacion, $Dar_DiaIdentificacion, $Dar_StatusTipo, $Dar_NumeroColector, $Dar_NumeroCampo, $Dar_Colector, $Dar_AnoColectado, $Dar_MesColectado, $Dar_DiaColectado, $Dar_DiaOrdinario, $Dar_HoraColectado, $Dar_ContinenteOceano, $Dar_Pais, $Dar_EstadoProvincia, $Dar_Municipio, $Dar_Localidad, str_replace(',', '.', $Dar_Longitud), str_replace(',', '.', $Dar_Latitud), $Dar_PrecisionDeCordenada, $Dar_BoundingBox, $Dar_MinimaElevacion, $Dar_MaximaElevacion, $Dar_MinimaProfundidad, $Dar_MaximaProfundidad, $Dar_SexoOrganismo, $Dar_PreparacionTipo, $Dar_ConteoIndividuo, $Dar_NumeroCatalogoAnterior, $Dar_TipoRelacion, $Dar_InformacionRelacionada, $Dar_EstadoVida, $Dar_Nota, $Dar_NombreComunOrganismo, $_SESSION['recurso']
                    );
                    $total_registrado++;
                } 
                else 
                {
                    array_push($datos, $objCelda);
                    $total_no_registrado;
                }
            }

            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($_SESSION['valores_final']);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
            unset($total_no_registrado);
            unset($total_registrado);
            Session::destroy('valores_final');
        }
    }

    public function pliniancore() 
    {
        $total_registrado = 0;
        $total_no_registrado = 0;
        $datos = array();
        array_push($datos, $_SESSION['encabezado']);

        $Pli_Idioma = "";
        $Pli_NombreCientifico = "";
        $Pli_AcronimoInstitucion = "";
        $Pli_FechaUltimaModificacion = "";
        $Pli_IdRegistroTaxon = "";
        $Pli_CitaSugerida = "";
        $Pli_Distribucion = "";
        $Pli_DescripcionGeneral = "";
        $Pli_Reino = "";
        $Pli_Phylum = "";
        $Pli_Clase = "";
        $Pli_Orden = "";
        $Pli_Familia = "";
        $Pli_Genero = "";
        $Pli_Sinonimia = "";
        $Pli_AutorFechaTaxon = "";
        $Pli_EspeciesReferenciasPublicacion = "";
        $Pli_NombresComunes = "";
        $Pli_InformacionTipos = "";
        $Pli_IdentificadorUnicoGlobal = "";
        $Pli_Colaboradores = "";
        $Pli_FechaCreacion = "";
        $Pli_Habito = "";
        $Pli_CicloVida = "";
        $Pli_Reproduccion = "";
        $Pli_CicloAnual = "";
        $Pli_DescripcionCientifica = "";
        $Pli_BreveDescripcion = "";
        $Pli_Alimentacion = "";
        $Pli_Comportamiento = "";
        $Pli_Interacciones = "";
        $Pli_NumeroCromosomas = "";
        $Pli_DatosMoleculares = "";
        $Pli_EstadoActPoblacion = "";
        $Pli_EstadoUICN = "";
        $Pli_EstadoLegNacional = "";
        $Pli_Habitat = "";
        $Pli_Territorialidad = "";
        $Pli_Endemismo = "";
        $Pli_Usos = "";
        $Pli_Manejo = "";
        $Pli_Folklore = "";
        $Pli_ReferenciasBibliograficas = "";
        $Pli_DocumentacionNoEstructurada = "";
        $Pli_OtraFuenteInformacion = "";
        $Pli_ArticuloCientifico = "";
        $Pli_ClavesTaxonomicas = "";
        $Pli_DatosMigrados = "";
        $Pli_ImportanciaEcologica = "";
        $Pli_HistoriaNaturalNoEstructurada = "";
        $Pli_DatosInvasividad = "";
        $Pli_PublicoObjetivo = "";
        $Pli_Version = "";
        $Pli_URLImagen1 = "";
        $Pli_PieImagen1 = "";
        $Pli_URLImagen2 = "";
        $Pli_PieImagen2 = "";
        $Pli_URLImagen3 = "";
        $Pli_PieImagen3 = "";
        $Pli_Imagen = "";

        if (empty($_SESSION['tipo_archivo'])) 
        {
            new PHPExcel();
            $archivo = $_SESSION['archivo'];
            $hoja = $_SESSION['hoja'];

            $objReader = PHPExcel_IOFactory::createReaderForFile($archivo);
            $objPHPExcel = $objReader->load($archivo);

            $objHoja = $objPHPExcel->setActiveSheetIndexByName($hoja)->toArray();
            array_shift($objHoja);

            foreach ($objHoja as $iIndice => $objCelda) 
            {
                if ($_POST['Pli_Idioma'] != '') 
                {
                    $Pli_Idioma = $objCelda[$_POST['Pli_Idioma']];
                }

                if ($_POST['Pli_NombreCientifico'] != '') 
                {
                    $Pli_NombreCientifico = $objCelda[$_POST['Pli_NombreCientifico']];
                }

                if ($_POST['Pli_AcronimoInstitucion'] != '') 
                {
                    $Pli_AcronimoInstitucion = $objCelda[$_POST['Pli_AcronimoInstitucion']];
                }

                if ($_POST['Pli_FechaUltimaModificacion'] != '') 
                {
                    $Pli_FechaUltimaModificacion = $objCelda[$_POST['Pli_FechaUltimaModificacion']];
                }

                if ($_POST['Pli_IdRegistroTaxon'] != '') 
                {
                    $Pli_IdRegistroTaxon = $objCelda[$_POST['Pli_IdRegistroTaxon']];
                }

                if ($_POST['Pli_CitaSugerida'] != '') 
                {
                    $Pli_CitaSugerida = $objCelda[$_POST['Pli_CitaSugerida']];
                }

                if ($_POST['Pli_Distribucion'] != '') 
                {
                    $Pli_Distribucion = $objCelda[$_POST['Pli_Distribucion']];
                }

                if ($_POST['Pli_DescripcionGeneral'] != '') 
                {
                    $Pli_DescripcionGeneral = $objCelda[$_POST['Pli_DescripcionGeneral']];
                }

                if ($_POST['Pli_Reino'] != '') 
                {
                    $Pli_Reino = $objCelda[$_POST['Pli_Reino']];
                }

                if ($_POST['Pli_Phylum'] != '') 
                {
                    $Pli_Phylum = $objCelda[$_POST['Pli_Phylum']];
                }

                if ($_POST['Pli_Clase'] != '') 
                {
                    $Pli_Clase = $objCelda[$_POST['Pli_Clase']];
                }

                if ($_POST['Pli_Orden'] != '') 
                {
                    $Pli_Orden = $objCelda[$_POST['Pli_Orden']];
                }

                if ($_POST['Pli_Familia'] != '') 
                {
                    $Pli_Familia = $objCelda[$_POST['Pli_Familia']];
                }

                if ($_POST['Pli_Genero'] != '') 
                {
                    $Pli_Genero = $objCelda[$_POST['Pli_Genero']];
                }

                if ($_POST['Pli_Sinonimia'] != '') 
                {
                    $Pli_Sinonimia = $objCelda[$_POST['Pli_Sinonimia']];
                }

                if ($_POST['Pli_AutorFechaTaxon'] != '') 
                {
                    $Pli_AutorFechaTaxon = $objCelda[$_POST['Pli_AutorFechaTaxon']];
                }

                if ($_POST['Pli_EspeciesReferenciasPublicacion'] != '') 
                {
                    $Pli_EspeciesReferenciasPublicacion = $objCelda[$_POST['Pli_EspeciesReferenciasPublicacion']];
                }

                if ($_POST['Pli_NombresComunes'] != '') 
                {
                    $Pli_NombresComunes = $objCelda[$_POST['Pli_NombresComunes']];
                }

                if ($_POST['Pli_InformacionTipos'] != '') 
                {
                    $Pli_InformacionTipos = $objCelda[$_POST['Pli_InformacionTipos']];
                }

                if ($_POST['Pli_IdentificadorUnicoGlobal'] != '') 
                {
                    $Pli_IdentificadorUnicoGlobal = $objCelda[$_POST['Pli_IdentificadorUnicoGlobal']];
                }

                if ($_POST['Pli_Colaboradores'] != '') 
                {
                    $Pli_Colaboradores = $objCelda[$_POST['Pli_Colaboradores']];
                }

                if ($_POST['Pli_FechaCreacion'] != '') 
                {
                    $Pli_FechaCreacion = $objCelda[$_POST['Pli_FechaCreacion']];
                }

                if ($_POST['Pli_Habito'] != '') 
                {
                    $Pli_Habito = $objCelda[$_POST['Pli_Habito']];
                }

                if ($_POST['Pli_CicloVida'] != '') 
                {
                    $Pli_CicloVida = $objCelda[$_POST['Pli_CicloVida']];
                }

                if ($_POST['Pli_Reproduccion'] != '') 
                {
                    $Pli_Reproduccion = $objCelda[$_POST['Pli_Reproduccion']];
                }

                if ($_POST['Pli_CicloAnual'] != '') 
                {
                    $Pli_CicloAnual = $objCelda[$_POST['Pli_CicloAnual']];
                }

                if ($_POST['Pli_DescripcionCientifica'] != '') 
                {
                    $Pli_DescripcionCientifica = $objCelda[$_POST['Pli_DescripcionCientifica']];
                }

                if ($_POST['Pli_BreveDescripcion'] != '') 
                {
                    $Pli_BreveDescripcion = $objCelda[$_POST['Pli_BreveDescripcion']];
                }

                if ($_POST['Pli_Alimentacion'] != '') 
                {
                    $Pli_Alimentacion = $objCelda[$_POST['Pli_Alimentacion']];
                }

                if ($_POST['Pli_Comportamiento'] != '') {
                    $Pli_Comportamiento = $objCelda[$_POST['Pli_Comportamiento']];
                }
                if ($_POST['Pli_Interacciones'] != '') {
                    $Pli_Interacciones = $objCelda[$_POST['Pli_Interacciones']];
                }
                if ($_POST['Pli_NumeroCromosomas'] != '') {
                    $Pli_NumeroCromosomas = $objCelda[$_POST['Pli_NumeroCromosomas']];
                }
                if ($_POST['Pli_DatosMoleculares'] != '') {
                    $Pli_DatosMoleculares = $objCelda[$_POST['Pli_DatosMoleculares']];
                }
                if ($_POST['Pli_EstadoActPoblacion'] != '') {
                    $Pli_EstadoActPoblacion = $objCelda[$_POST['Pli_EstadoActPoblacion']];
                }
                if ($_POST['Pli_EstadoUICN'] != '') {
                    $Pli_EstadoUICN = $objCelda[$_POST['Pli_EstadoUICN']];
                }
                if ($_POST['Pli_EstadoLegNacional'] != '') {
                    $Pli_EstadoLegNacional = $objCelda[$_POST['Pli_EstadoLegNacional']];
                }
                if ($_POST['Pli_Habitat'] != '') {
                    $Pli_Habitat = $objCelda[$_POST['Pli_Habitat']];
                }
                if ($_POST['Pli_Territorialidad'] != '') {
                    $Pli_Territorialidad = $objCelda[$_POST['Pli_Territorialidad']];
                }
                if ($_POST['Pli_Endemismo'] != '') {
                    $Pli_Endemismo = $objCelda[$_POST['Pli_Endemismo']];
                }
                if ($_POST['Pli_Usos'] != '') {
                    $Pli_Usos = $objCelda[$_POST['Pli_Usos']];
                }
                if ($_POST['Pli_Manejo'] != '') {
                    $Pli_Manejo = $objCelda[$_POST['Pli_Manejo']];
                }
                if ($_POST['Pli_Folklore'] != '') {
                    $Pli_Folklore = $objCelda[$_POST['Pli_Folklore']];
                }
                if ($_POST['Pli_ReferenciasBibliograficas'] != '') {
                    $Pli_ReferenciasBibliograficas = $objCelda[$_POST['Pli_ReferenciasBibliograficas']];
                }
                if ($_POST['Pli_DocumentacionNoEstructurada'] != '') {
                    $Pli_DocumentacionNoEstructurada = $objCelda[$_POST['Pli_DocumentacionNoEstructurada']];
                }
                if ($_POST['Pli_OtraFuenteInformacion'] != '') {
                    $Pli_OtraFuenteInformacion = $objCelda[$_POST['Pli_OtraFuenteInformacion']];
                }
                if ($_POST['Pli_ArticuloCientifico'] != '') {
                    $Pli_ArticuloCientifico = $objCelda[$_POST['Pli_ArticuloCientifico']];
                }
                if ($_POST['Pli_ClavesTaxonomicas'] != '') {
                    $Pli_ClavesTaxonomicas = $objCelda[$_POST['Pli_ClavesTaxonomicas']];
                }
                if ($_POST['Pli_DatosMigrados'] != '') {
                    $Pli_DatosMigrados = $objCelda[$_POST['Pli_DatosMigrados']];
                }
                if ($_POST['Pli_ImportanciaEcologica'] != '') {
                    $Pli_ImportanciaEcologica = $objCelda[$_POST['Pli_ImportanciaEcologica']];
                }
                if ($_POST['Pli_HistoriaNaturalNoEstructurada'] != '') {
                    $Pli_HistoriaNaturalNoEstructurada = $objCelda[$_POST['Pli_HistoriaNaturalNoEstructurada']];
                }
                if ($_POST['Pli_DatosInvasividad'] != '') {
                    $Pli_DatosInvasividad = $objCelda[$_POST['Pli_DatosInvasividad']];
                }
                if ($_POST['Pli_PublicoObjetivo'] != '') {
                    $Pli_PublicoObjetivo = $objCelda[$_POST['Pli_PublicoObjetivo']];
                }
                if ($_POST['Pli_Version'] != '') {
                    $Pli_Version = $objCelda[$_POST['Pli_Version']];
                }
                if ($_POST['Pli_URLImagen1'] != '') {
                    $Pli_URLImagen1 = $objCelda[$_POST['Pli_URLImagen1']];
                }
                if ($_POST['Pli_PieImagen1'] != '') {
                    $Pli_PieImagen1 = $objCelda[$_POST['Pli_PieImagen1']];
                }
                if ($_POST['Pli_URLImagen2'] != '') {
                    $Pli_URLImagen2 = $objCelda[$_POST['Pli_URLImagen2']];
                }
                if ($_POST['Pli_PieImagen2'] != '') {
                    $Pli_PieImagen2 = $objCelda[$_POST['Pli_PieImagen2']];
                }
                if ($_POST['Pli_URLImagen3'] != '') {
                    $Pli_URLImagen3 = $objCelda[$_POST['Pli_URLImagen3']];
                }
                if ($_POST['Pli_PieImagen3'] != '') {
                    $Pli_PieImagen3 = $objCelda[$_POST['Pli_PieImagen3']];
                }
                if ($_POST['Pli_Imagen'] != '') {
                    $Pli_Imagen = $objCelda[$_POST['Pli_Imagen']];
                }


                if ($Pli_AcronimoInstitucion != '' and $Pli_NombreCientifico != '' and $Pli_FechaUltimaModificacion != '') {

                    $plinian = $this->_excel->registrarPlinianCore(
                            $Pli_Idioma, $Pli_NombreCientifico, $Pli_AcronimoInstitucion, $Pli_FechaUltimaModificacion, $Pli_IdRegistroTaxon, $Pli_CitaSugerida, $Pli_Distribucion, $Pli_DescripcionGeneral, $Pli_Reino, $Pli_Phylum, $Pli_Clase, $Pli_Orden, $Pli_Familia, $Pli_Genero, $Pli_Sinonimia, $Pli_AutorFechaTaxon, $Pli_EspeciesReferenciasPublicacion, $Pli_NombresComunes, $Pli_InformacionTipos, $Pli_IdentificadorUnicoGlobal, $Pli_Colaboradores, $Pli_FechaCreacion, $Pli_Habito, $Pli_CicloVida, $Pli_Reproduccion, $Pli_CicloAnual, $Pli_DescripcionCientifica, $Pli_BreveDescripcion, $Pli_Alimentacion, $Pli_Comportamiento, $Pli_Interacciones, $Pli_NumeroCromosomas, $Pli_DatosMoleculares, $Pli_EstadoActPoblacion, $Pli_EstadoUICN, $Pli_EstadoLegNacional, $Pli_Habitat, $Pli_Territorialidad, $Pli_Endemismo, $Pli_Usos, $Pli_Manejo, $Pli_Folklore, $Pli_ReferenciasBibliograficas, $Pli_DocumentacionNoEstructurada, $Pli_OtraFuenteInformacion, $Pli_ArticuloCientifico, $Pli_ClavesTaxonomicas, $Pli_DatosMigrados, $Pli_ImportanciaEcologica, $Pli_HistoriaNaturalNoEstructurada, $Pli_DatosInvasividad, $Pli_PublicoObjetivo, $Pli_Version, $Pli_URLImagen1, $Pli_PieImagen1, $Pli_URLImagen2, $Pli_PieImagen2, $Pli_URLImagen3, $Pli_PieImagen3, $Pli_Imagen, $_SESSION['recurso']
                    );
                    $total_registrado++;
                } else {
                    array_push($datos, $objCelda);
                    $total_no_registrado++;
                }
            }
            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($objHoja);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
            unset($objHoja);
            unset($objReader);
            unset($objPHPExcel);
        } else {
            foreach ($_SESSION['valores_final'] as $objCelda) {



                if ($_POST['Pli_Idioma'] != '') {
                    $Pli_Idioma = $objCelda[$_POST['Pli_Idioma']];
                }
                if ($_POST['Pli_NombreCientifico'] != '') {
                    $Pli_NombreCientifico = $objCelda[$_POST['Pli_NombreCientifico']];
                }
                if ($_POST['Pli_AcronimoInstitucion'] != '') {
                    $Pli_AcronimoInstitucion = $objCelda[$_POST['Pli_AcronimoInstitucion']];
                }
                if ($_POST['Pli_FechaUltimaModificacion'] != '') {
                    $Pli_FechaUltimaModificacion = $objCelda[$_POST['Pli_FechaUltimaModificacion']];
                }
                if ($_POST['Pli_IdRegistroTaxon'] != '') {
                    $Pli_IdRegistroTaxon = $objCelda[$_POST['Pli_IdRegistroTaxon']];
                }
                if ($_POST['Pli_CitaSugerida'] != '') {
                    $Pli_CitaSugerida = $objCelda[$_POST['Pli_CitaSugerida']];
                }
                if ($_POST['Pli_Distribucion'] != '') {
                    $Pli_Distribucion = $objCelda[$_POST['Pli_Distribucion']];
                }
                if ($_POST['Pli_DescripcionGeneral'] != '') {
                    $Pli_DescripcionGeneral = $objCelda[$_POST['Pli_DescripcionGeneral']];
                }
                if ($_POST['Pli_Reino'] != '') {
                    $Pli_Reino = $objCelda[$_POST['Pli_Reino']];
                }
                if ($_POST['Pli_Phylum'] != '') {
                    $Pli_Phylum = $objCelda[$_POST['Pli_Phylum']];
                }
                if ($_POST['Pli_Clase'] != '') {
                    $Pli_Clase = $objCelda[$_POST['Pli_Clase']];
                }
                if ($_POST['Pli_Orden'] != '') {
                    $Pli_Orden = $objCelda[$_POST['Pli_Orden']];
                }
                if ($_POST['Pli_Familia'] != '') {
                    $Pli_Familia = $objCelda[$_POST['Pli_Familia']];
                }
                if ($_POST['Pli_Genero'] != '') {
                    $Pli_Genero = $objCelda[$_POST['Pli_Genero']];
                }
                if ($_POST['Pli_Sinonimia'] != '') {
                    $Pli_Sinonimia = $objCelda[$_POST['Pli_Sinonimia']];
                }
                if ($_POST['Pli_AutorFechaTaxon'] != '') {
                    $Pli_AutorFechaTaxon = $objCelda[$_POST['Pli_AutorFechaTaxon']];
                }
                if ($_POST['Pli_EspeciesReferenciasPublicacion'] != '') {
                    $Pli_EspeciesReferenciasPublicacion = $objCelda[$_POST['Pli_EspeciesReferenciasPublicacion']];
                }
                if ($_POST['Pli_NombresComunes'] != '') {
                    $Pli_NombresComunes = $objCelda[$_POST['Pli_NombresComunes']];
                }
                if ($_POST['Pli_InformacionTipos'] != '') {
                    $Pli_InformacionTipos = $objCelda[$_POST['Pli_InformacionTipos']];
                }
                if ($_POST['Pli_IdentificadorUnicoGlobal'] != '') {
                    $Pli_IdentificadorUnicoGlobal = $objCelda[$_POST['Pli_IdentificadorUnicoGlobal']];
                }
                if ($_POST['Pli_Colaboradores'] != '') {
                    $Pli_Colaboradores = $objCelda[$_POST['Pli_Colaboradores']];
                }
                if ($_POST['Pli_FechaCreacion'] != '') {
                    $Pli_FechaCreacion = $objCelda[$_POST['Pli_FechaCreacion']];
                }
                if ($_POST['Pli_Habito'] != '') {
                    $Pli_Habito = $objCelda[$_POST['Pli_Habito']];
                }
                if ($_POST['Pli_CicloVida'] != '') {
                    $Pli_CicloVida = $objCelda[$_POST['Pli_CicloVida']];
                }
                if ($_POST['Pli_Reproduccion'] != '') {
                    $Pli_Reproduccion = $objCelda[$_POST['Pli_Reproduccion']];
                }
                if ($_POST['Pli_CicloAnual'] != '') {
                    $Pli_CicloAnual = $objCelda[$_POST['Pli_CicloAnual']];
                }
                if ($_POST['Pli_DescripcionCientifica'] != '') {
                    $Pli_DescripcionCientifica = $objCelda[$_POST['Pli_DescripcionCientifica']];
                }
                if ($_POST['Pli_BreveDescripcion'] != '') {
                    $Pli_BreveDescripcion = $objCelda[$_POST['Pli_BreveDescripcion']];
                }
                if ($_POST['Pli_Alimentacion'] != '') {
                    $Pli_Alimentacion = $objCelda[$_POST['Pli_Alimentacion']];
                }
                if ($_POST['Pli_Comportamiento'] != '') {
                    $Pli_Comportamiento = $objCelda[$_POST['Pli_Comportamiento']];
                }
                if ($_POST['Pli_Interacciones'] != '') {
                    $Pli_Interacciones = $objCelda[$_POST['Pli_Interacciones']];
                }
                if ($_POST['Pli_NumeroCromosomas'] != '') {
                    $Pli_NumeroCromosomas = $objCelda[$_POST['Pli_NumeroCromosomas']];
                }
                if ($_POST['Pli_DatosMoleculares'] != '') {
                    $Pli_DatosMoleculares = $objCelda[$_POST['Pli_DatosMoleculares']];
                }
                if ($_POST['Pli_EstadoActPoblacion'] != '') {
                    $Pli_EstadoActPoblacion = $objCelda[$_POST['Pli_EstadoActPoblacion']];
                }
                if ($_POST['Pli_EstadoUICN'] != '') {
                    $Pli_EstadoUICN = $objCelda[$_POST['Pli_EstadoUICN']];
                }
                if ($_POST['Pli_EstadoLegNacional'] != '') {
                    $Pli_EstadoLegNacional = $objCelda[$_POST['Pli_EstadoLegNacional']];
                }
                if ($_POST['Pli_Habitat'] != '') {
                    $Pli_Habitat = $objCelda[$_POST['Pli_Habitat']];
                }
                if ($_POST['Pli_Territorialidad'] != '') {
                    $Pli_Territorialidad = $objCelda[$_POST['Pli_Territorialidad']];
                }
                if ($_POST['Pli_Endemismo'] != '') {
                    $Pli_Endemismo = $objCelda[$_POST['Pli_Endemismo']];
                }
                if ($_POST['Pli_Usos'] != '') {
                    $Pli_Usos = $objCelda[$_POST['Pli_Usos']];
                }
                if ($_POST['Pli_Manejo'] != '') {
                    $Pli_Manejo = $objCelda[$_POST['Pli_Manejo']];
                }
                if ($_POST['Pli_Folklore'] != '') {
                    $Pli_Folklore = $objCelda[$_POST['Pli_Folklore']];
                }
                if ($_POST['Pli_ReferenciasBibliograficas'] != '') {
                    $Pli_ReferenciasBibliograficas = $objCelda[$_POST['Pli_ReferenciasBibliograficas']];
                }
                if ($_POST['Pli_DocumentacionNoEstructurada'] != '') {
                    $Pli_DocumentacionNoEstructurada = $objCelda[$_POST['Pli_DocumentacionNoEstructurada']];
                }
                if ($_POST['Pli_OtraFuenteInformacion'] != '') {
                    $Pli_OtraFuenteInformacion = $objCelda[$_POST['Pli_OtraFuenteInformacion']];
                }
                if ($_POST['Pli_ArticuloCientifico'] != '') {
                    $Pli_ArticuloCientifico = $objCelda[$_POST['Pli_ArticuloCientifico']];
                }
                if ($_POST['Pli_ClavesTaxonomicas'] != '') {
                    $Pli_ClavesTaxonomicas = $objCelda[$_POST['Pli_ClavesTaxonomicas']];
                }
                if ($_POST['Pli_DatosMigrados'] != '') {
                    $Pli_DatosMigrados = $objCelda[$_POST['Pli_DatosMigrados']];
                }
                if ($_POST['Pli_ImportanciaEcologica'] != '') {
                    $Pli_ImportanciaEcologica = $objCelda[$_POST['Pli_ImportanciaEcologica']];
                }
                if ($_POST['Pli_HistoriaNaturalNoEstructurada'] != '') {
                    $Pli_HistoriaNaturalNoEstructurada = $objCelda[$_POST['Pli_HistoriaNaturalNoEstructurada']];
                }
                if ($_POST['Pli_DatosInvasividad'] != '') {
                    $Pli_DatosInvasividad = $objCelda[$_POST['Pli_DatosInvasividad']];
                }
                if ($_POST['Pli_PublicoObjetivo'] != '') {
                    $Pli_PublicoObjetivo = $objCelda[$_POST['Pli_PublicoObjetivo']];
                }
                if ($_POST['Pli_Version'] != '') {
                    $Pli_Version = $objCelda[$_POST['Pli_Version']];
                }
                if ($_POST['Pli_URLImagen1'] != '') {
                    $Pli_URLImagen1 = $objCelda[$_POST['Pli_URLImagen1']];
                }
                if ($_POST['Pli_PieImagen1'] != '') {
                    $Pli_PieImagen1 = $objCelda[$_POST['Pli_PieImagen1']];
                }
                if ($_POST['Pli_URLImagen2'] != '') {
                    $Pli_URLImagen2 = $objCelda[$_POST['Pli_URLImagen2']];
                }
                if ($_POST['Pli_PieImagen2'] != '') {
                    $Pli_PieImagen2 = $objCelda[$_POST['Pli_PieImagen2']];
                }
                if ($_POST['Pli_URLImagen3'] != '') {
                    $Pli_URLImagen3 = $objCelda[$_POST['Pli_URLImagen3']];
                }
                if ($_POST['Pli_PieImagen3'] != '') {
                    $Pli_PieImagen3 = $objCelda[$_POST['Pli_PieImagen3']];
                }
                if ($_POST['Pli_Imagen'] != '') {
                    $Pli_Imagen = $objCelda[$_POST['Pli_Imagen']];
                }
                if ($_POST['Idi_Idioma'] != '') {

                    $idioma = $this->_excel->getIdioma($objCelda[$_POST['Idi_Idioma']]);
                    if ($idioma) {
                        $Idi_Idioma = $idioma[0];
                    }
                }


                if ($Pli_AcronimoInstitucion != '' and $Pli_NombreCientifico != '' and $Pli_FechaUltimaModificacion != '') {

                    $plinian = $this->_excel->registrarPlinianCore(
                            $Pli_Idioma, $Pli_NombreCientifico, $Pli_AcronimoInstitucion, $Pli_FechaUltimaModificacion, $Pli_IdRegistroTaxon, $Pli_CitaSugerida, $Pli_Distribucion, $Pli_DescripcionGeneral, $Pli_Reino, $Pli_Phylum, $Pli_Clase, $Pli_Orden, $Pli_Familia, $Pli_Genero, $Pli_Sinonimia, $Pli_AutorFechaTaxon, $Pli_EspeciesReferenciasPublicacion, $Pli_NombresComunes, $Pli_InformacionTipos, $Pli_IdentificadorUnicoGlobal, $Pli_Colaboradores, $Pli_FechaCreacion, $Pli_Habito, $Pli_CicloVida, $Pli_Reproduccion, $Pli_CicloAnual, $Pli_DescripcionCientifica, $Pli_BreveDescripcion, $Pli_Alimentacion, $Pli_Comportamiento, $Pli_Interacciones, $Pli_NumeroCromosomas, $Pli_DatosMoleculares, $Pli_EstadoActPoblacion, $Pli_EstadoUICN, $Pli_EstadoLegNacional, $Pli_Habitat, $Pli_Territorialidad, $Pli_Endemismo, $Pli_Usos, $Pli_Manejo, $Pli_Folklore, $Pli_ReferenciasBibliograficas, $Pli_DocumentacionNoEstructurada, $Pli_OtraFuenteInformacion, $Pli_ArticuloCientifico, $Pli_ClavesTaxonomicas, $Pli_DatosMigrados, $Pli_ImportanciaEcologica, $Pli_HistoriaNaturalNoEstructurada, $Pli_DatosInvasividad, $Pli_PublicoObjetivo, $Pli_Version, $Pli_URLImagen1, $Pli_PieImagen1, $Pli_URLImagen2, $Pli_PieImagen2, $Pli_URLImagen3, $Pli_PieImagen3, $Pli_Imagen, $_SESSION['recurso'], $Idi_Idioma
                    );
                    $total_registrado++;
                } else {
                    array_push($datos, $objCelda);
                    $total_no_registrado++;
                }
            }
            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($_SESSION['valores_final']);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
            unset($total_no_registrado);
            unset($total_registrado);
            Session::destroy('valores_final');
        }
    }

    public function legislacion() {
        $Mal_FechaPublicacion = "";
        $Mal_Entidad = "";
        $Mal_NumeroNormas = "";
        $Mal_Titulo = "";
        $Mal_ArticuloAplicable = "";
        $Mal_ResumenLegislacion = "";
        $Mal_FechaRevision = "";
        $Mal_NormasComplementarias = "";
        $Mal_PalabraClave = "";
        $Pai_IdPais = "";
        $Nivel_Legal = "";
        $Snl_IdSubNivelLegal = "";
        $Tel_IdTemaLegal = "";
        $Til_IdTipoLegal = "";
        $Idi_IdIdioma = Cookie::lenguaje();


        $total_registrado = 0;
        $total_no_registrado = 0;

        $datos = array();
        array_push($datos, $_SESSION['encabezado']);

        if (empty($_SESSION['tipo_archivo'])) {
            new PHPExcel();
            $archivo = $_SESSION['archivo'];
            $hoja = $_SESSION['hoja'];

            $objReader = PHPExcel_IOFactory::createReaderForFile($archivo);
            $objPHPExcel = $objReader->load($archivo);

            $objHoja = $objPHPExcel->setActiveSheetIndexByName($hoja)->toArray();
            array_shift($objHoja);
            foreach ($objHoja as $iIndice => $objCelda) {

                if ($_POST['Mal_FechaPublicacion'] != '') {
                    $Mal_FechaPublicacion = $objCelda[$_POST['Mal_FechaPublicacion']];
                }

                if ($_POST['Mal_Entidad'] != '') {
                    $Mal_Entidad = $objCelda[$_POST['Mal_Entidad']];
                }

                if ($_POST['Mal_NumeroNormas'] != '') {
                    $Mal_NumeroNormas = $objCelda[$_POST['Mal_NumeroNormas']];
                }
                if ($_POST['Mal_Titulo'] != '') {
                    $Mal_Titulo = $objCelda[$_POST['Mal_Titulo']];
                }

                if ($_POST['Mal_ArticuloAplicable'] != '') {
                    $Mal_ArticuloAplicable = $objCelda[$_POST['Mal_ArticuloAplicable']];
                }
                if ($_POST['Mal_ResumenLegislacion'] != '') {
                    $Mal_ResumenLegislacion = $objCelda[$_POST['Mal_ResumenLegislacion']];
                }
                if ($_POST['Mal_FechaRevision'] != '') {
                    $Mal_FechaRevision = $objCelda[$_POST['Mal_FechaRevision']];
                }
                if ($_POST['Mal_NormasComplementarias'] != '') {
                    $Mal_NormasComplementarias = $objCelda[$_POST['Mal_NormasComplementarias']];
                }
                if ($_POST['Til_Nombre'] != '') {
                    $Til_IdTipoLegal = $objCelda[$_POST['Til_Nombre']];
                }
                if ($_POST['Mal_PalabraClave'] != '') {
                    $Mal_PalabraClave = $objCelda[$_POST['Mal_PalabraClave']];
                }
                if ($_POST['Pai_Nombre'] != '') {
                    $Pai_IdPais = $objCelda[$_POST['Pai_Nombre']];
                }
                $pais = $this->_excel->getPais($Pai_IdPais);
                if ($_POST['Nil_Nombre'] != '') {
                    $Nivel_Legal = $objCelda[$_POST['Nil_Nombre']];
                }
                if ($_POST['Snl_Nombre'] != '') {
                    $Snl_IdSubNivelLegal = $objCelda[$_POST['Snl_Nombre']];
                }
                if ($_POST['Tel_Nombre'] != '') {
                    $Tel_IdTemaLegal = $objCelda[$_POST['Tel_Nombre']];
                }
                if ($_POST['Idi_IdIdioma'] != '') {

                    $idioma = $this->_excel->getIdioma($objCelda[$_POST['Idi_IdIdioma']]);
                    if ($idioma) {
                        $Idi_IdIdioma = $idioma[0];
                    }
                }

                if (!empty($pais) and ! empty($Nivel_Legal) and ! empty($Snl_IdSubNivelLegal) and ! empty($Tel_IdTemaLegal)) {

                    $nivellegal = $this->_excel->getNivelLegal($Nivel_Legal, $Idi_IdIdioma);
                    if (empty($nivellegal)) {
                        $nivellegal = $this->_excel->registrarNivelLegal(ucwords(strtolower($Nivel_Legal)), $Idi_IdIdioma);
                    }
                    $subnivellegal = $this->_excel->getSubNivelLegal($nivellegal[0], $Snl_IdSubNivelLegal, $Idi_IdIdioma);
                    if (empty($subnivellegal)) {
                        $subnivellegal = $this->_excel->registrarSubNivelLegal(ucwords(strtolower($Snl_IdSubNivelLegal)), $nivellegal[0], $Idi_IdIdioma);
                    }
                    $temanivellegal = $this->_excel->getTemaLegal($subnivellegal[0], $Tel_IdTemaLegal, $Idi_IdIdioma);
                    if (empty($temanivellegal)) {
                        $temanivellegal = $this->_excel->registrarTemaLegal(ucwords($Tel_IdTemaLegal), $subnivellegal[0], $Idi_IdIdioma);
                    }

                    $tipo_legal = $this->_excel->getTipoLegal($Til_IdTipoLegal, $Idi_IdIdioma);
                    if (empty($tipo_legal)) {
                        $tipo_legal = $this->_excel->registrarTipoLegal(ucwords(strtolower($Til_IdTipoLegal)), $Idi_IdIdioma);
                    }

                    if ($Mal_PalabraClave == '') {
                        $Mal_PalabraClave = 'Otros';
                    }
                    if (!$this->_excel->verificarTitulo($Mal_FechaPublicacion, $Mal_Entidad, $Mal_NumeroNormas, $Mal_Titulo, $Mal_ArticuloAplicable, $Mal_ResumenLegislacion, $Mal_FechaRevision, $Mal_NormasComplementarias, $tipo_legal[0], $temanivellegal[0], $pais[0], $Idi_Idioma, $_SESSION['recurso'], $Mal_PalabraClave)) {
                        $legislacion = $this->_excel->registrarLegislacion(
                                $Mal_FechaPublicacion, ucwords($Mal_Entidad), $Mal_NumeroNormas, $Mal_Titulo, $Mal_ArticuloAplicable, $Mal_ResumenLegislacion, $Mal_FechaRevision, $Mal_NormasComplementarias, $tipo_legal[0], $temanivellegal[0], $pais[0], $_SESSION['recurso'], ucwords($Mal_PalabraClave), $Idi_IdIdioma);

                        $total_registrado++;
                    } else {
                        array_push($datos, $objCelda);
                        $total_no_registrado++;
                    }
                } else {
                    array_push($datos, $objCelda);
                    $total_no_registrado++;
                }
            }
            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($objHoja);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
            unset($objHoja);
            unset($objReader);
            unset($objPHPExcel);
            unset($total_no_registrado);
            unset($total_registrado);
        } else {
            foreach ($_SESSION['valores_final'] as $objCelda) {

                if ($_POST['Mal_FechaPublicacion'] != '') {
                    $Mal_FechaPublicacion = $objCelda[$_POST['Mal_FechaPublicacion']];
                }

                if ($_POST['Mal_Entidad'] != '') {
                    $Mal_Entidad = $objCelda[$_POST['Mal_Entidad']];
                }

                if ($_POST['Mal_NumeroNormas'] != '') {
                    $Mal_NumeroNormas = $objCelda[$_POST['Mal_NumeroNormas']];
                }
                if ($_POST['Mal_Titulo'] != '') {
                    $Mal_Titulo = $objCelda[$_POST['Mal_Titulo']];
                }

                if ($_POST['Mal_ArticuloAplicable'] != '') {
                    $Mal_ArticuloAplicable = $objCelda[$_POST['Mal_ArticuloAplicable']];
                }
                if ($_POST['Mal_ResumenLegislacion'] != '') {
                    $Mal_ResumenLegislacion = $objCelda[$_POST['Mal_ResumenLegislacion']];
                }
                if ($_POST['Mal_FechaRevision'] != '') {
                    $Mal_FechaRevision = $objCelda[$_POST['Mal_FechaRevision']];
                }
                if ($_POST['Mal_NormasComplementarias'] != '') {
                    $Mal_NormasComplementarias = $objCelda[$_POST['Mal_NormasComplementarias']];
                }
                if ($_POST['Til_Nombre'] != '') {
                    $Til_IdTipoLegal = $objCelda[$_POST['Til_Nombre']];
                }
                if ($_POST['Mal_PalabraClave'] != '') {
                    $Mal_PalabraClave = $objCelda[$_POST['Mal_PalabraClave']];
                }
                if ($_POST['Pai_Nombre'] != '') {
                    $Pai_IdPais = $objCelda[$_POST['Pai_Nombre']];
                }
                $pais = $this->_excel->getPais($Pai_IdPais);
                if ($_POST['Nil_Nombre'] != '') {
                    $Nivel_Legal = $objCelda[$_POST['Nil_Nombre']];
                }
                if ($_POST['Snl_Nombre'] != '') {
                    $Snl_IdSubNivelLegal = $objCelda[$_POST['Snl_Nombre']];
                }
                if ($_POST['Tel_Nombre'] != '') {
                    $Tel_IdTemaLegal = $objCelda[$_POST['Tel_Nombre']];
                }
                if ($_POST['Idi_IdIdioma'] != '') {

                    $idioma = $this->_excel->getIdioma($objCelda[$_POST['Idi_IdIdioma']]);
                    if ($idioma) {
                        $Idi_IdIdioma = $idioma[0];
                    }
                }

                if (!empty($pais) and ! empty($Nivel_Legal) and ! empty($Snl_IdSubNivelLegal) and ! empty($Tel_IdTemaLegal)) {

                    $nivellegal = $this->_excel->getNivelLegal($Nivel_Legal, $Idi_IdIdioma);
                    if (empty($nivellegal)) {
                        $nivellegal = $this->_excel->registrarNivelLegal(ucwords($Nivel_Legal), $Idi_IdIdioma);
                    }
                    $subnivellegal = $this->_excel->getSubNivelLegal($nivellegal[0], $Snl_IdSubNivelLegal, $Idi_IdIdioma);
                    if (empty($subnivellegal)) {
                        $subnivellegal = $this->_excel->registrarSubNivelLegal(ucwords($Snl_IdSubNivelLegal), $nivellegal[0], $Idi_IdIdioma);
                    }
                    $temanivellegal = $this->_excel->getTemaLegal($subnivellegal[0], $Tel_IdTemaLegal, $Idi_IdIdioma);
                    if (empty($temanivellegal)) {
                        $temanivellegal = $this->_excel->registrarTemaLegal(ucwords($Tel_IdTemaLegal), $subnivellegal[0], $Idi_IdIdioma);
                    }
                    $tipo_legal = $this->_excel->getTipoLegal($Til_IdTipoLegal, $Idi_IdIdioma);
                    if (empty($tipo_legal)) {
                        $tipo_legal = $this->_excel->registrarTipoLegal(ucwords(strtolower($Til_IdTipoLegal)), $Idi_IdIdioma);
                    }
                    if ($Mal_PalabraClave == '') {
                        $Mal_PalabraClave = 'Otros';
                    }
                    if (!$this->_excel->verificarTitulo($Mal_FechaPublicacion, $Mal_Entidad, $Mal_NumeroNormas, $Mal_Titulo, $Mal_ArticuloAplicable, $Mal_ResumenLegislacion, $Mal_FechaRevision, $Mal_NormasComplementarias, $tipo_legal[0], $temanivellegal[0], $pais[0], $Idi_IdIdioma, $_SESSION['recurso'], $Mal_PalabraClave)) {
                        $legislacion = $this->_excel->registrarLegislacion(
                                $Mal_FechaPublicacion, ucwords($Mal_Entidad), $Mal_NumeroNormas, $Mal_Titulo, $Mal_ArticuloAplicable, $Mal_ResumenLegislacion, $Mal_FechaRevision, $Mal_NormasComplementarias, $tipo_legal[0], $temanivellegal[0], $pais[0], $_SESSION['recurso'], ucwords($Mal_PalabraClave), $Idi_IdIdioma);

                        $total_registrado++;
                    } else {
                        array_push($datos, $objCelda);
                        $total_no_registrado++;
                    }
                } else {
                    array_push($datos, $objCelda);
                    $total_no_registrado++;
                }
            }
            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($_SESSION['valores_final']);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
            unset($total_no_registrado);
            unset($total_registrado);
            Session::destroy('valores_final');
        }
    }

    public function monitoreo_calidad_agua() {
        $Mca_Valor = "";
        $Mca_Fecha = "";
        $Var_Abreviatura = "";
        $Var_Medida = "";
        $Var_Nombre = "";

        $Esm_Nombre = "";
        $Esm_Referencia = "";
        $Esm_Altitud = "";
        $Esm_Longitud = "";
        $Esm_Latitud = "";


        $Ent_Nombre = "";
        $Ent_Siglas = "";

        $Rio_Nombre = "";
        $Cue_Nombre = "";
        $Suc_Nombre = "";

        $Pai_Nombre = "";
        $Idi_IdIdioma = Cookie::lenguaje();

        $Esd_Nombre = "";
        $Mpd_Nombre = "";

        $total_registrado = 0;
        $total_no_registrado = array();

        $datos = array();
        array_push($datos, $_SESSION['encabezado']);

        if (empty($_SESSION['tipo_archivo'])) {
            new PHPExcel();
            $archivo = $_SESSION['archivo'];
            $hoja = $_SESSION['hoja'];

            $objReader = PHPExcel_IOFactory::createReaderForFile($archivo);
            $objPHPExcel = $objReader->load($archivo);

            $objHoja = $objPHPExcel->setActiveSheetIndexByName($hoja)->toArray();
            array_shift($objHoja);



            foreach ($objHoja as $iIndice => $objCelda) {

                if ($_POST['Mca_Valor'] != '') {
                    $Mca_Valor = $objCelda[$_POST['Mca_Valor']];
                }
                if ($_POST['Mca_Fecha'] != '') {
                    $Mca_Fecha = $objCelda[$_POST['Mca_Fecha']];
                }
                if ($_POST['Var_Nombre'] != '') {
                    $Var_Nombre = $objCelda[$_POST['Var_Nombre']];
                }
                if ($_POST['Var_Abreviatura'] != '') {
                    $Var_Abreviatura = $objCelda[$_POST['Var_Abreviatura']];
                }
                if ($_POST['Var_Medida'] != '') {
                    $Var_Medida = $objCelda[$_POST['Var_Medida']];
                }

                if ($_POST['Esm_Nombre'] != '') {
                    $Esm_Nombre = $objCelda[$_POST['Esm_Nombre']];
                }
                if ($_POST['Esm_Longitud'] != '') {
                    $Esm_Longitud = $objCelda[$_POST['Esm_Longitud']];
                }
                if ($_POST['Esm_Latitud'] != '') {
                    $Esm_Latitud = $objCelda[$_POST['Esm_Latitud']];
                }
                if ($_POST['Esm_Referencia'] != '') {
                    $Esm_Referencia = $objCelda[$_POST['Esm_Referencia']];
                }
                if ($_POST['Esm_Altitud'] != '') {
                    $Esm_Altitud = $objCelda[$_POST['Esm_Altitud']];
                }


                if ($_POST['Ent_Nombre'] != '') {
                    $Ent_Nombre = $objCelda[$_POST['Ent_Nombre']];
                }
                if ($_POST['Ent_Siglas'] != '') {
                    $Ent_Siglas = $objCelda[$_POST['Ent_Siglas']];
                }
                if ($_POST['Rio_Nombre'] != '') {
                    $Rio_Nombre = $objCelda[$_POST['Rio_Nombre']];
                }
                if ($_POST['Cue_Nombre'] != '') {
                    $Cue_Nombre = $objCelda[$_POST['Cue_Nombre']];
                }
                if ($_POST['Suc_Nombre'] != '') {
                    $Suc_Nombre = $objCelda[$_POST['Suc_Nombre']];
                }


                if ($_POST['Esd_Nombre'] != '') {
                    $Esd_Nombre = $objCelda[$_POST['Esd_Nombre']];
                }
                if ($_POST['Mpd_Nombre'] != '') {
                    $Mpd_Nombre = $objCelda[$_POST['Mpd_Nombre']];
                }
                if ($_POST['Pai_Nombre'] != '') {
                    $Pai_Nombre = $objCelda[$_POST['Pai_Nombre']];
                }
                if ($_POST['Idi_Idioma'] != '') {

                    $idioma = $this->_excel->getIdioma($objCelda[$_POST['Idi_Idioma']]);
                    if ($idioma) {
                        $Idi_Idioma = $idioma[0];
                    }
                }

                $pais = $this->_excel->getPais($Pai_Nombre);

                if (!empty($pais) and ! empty($Var_Nombre) and ( $Esm_Longitud != '') and ( $Esm_Latitud != '') and ! empty($Cue_Nombre) and ! empty($Suc_Nombre) and ! empty($Rio_Nombre) and is_numeric($Esm_Longitud) and is_numeric($Esm_Latitud)) {

                    $cuenca = $this->_excel->getCuenca($Cue_Nombre);
                    if (empty($cuenca)) {
                        $cuenca = $this->_excel->registrarCuenca(ucwords($Cue_Nombre));
                    }
                    $subcuenca = $this->_excel->getSubCuenca($cuenca[0], $Suc_Nombre);
                    if (empty($subcuenca)) {
                        $subcuenca = $this->_excel->registrarSucCuenca(ucwords($Suc_Nombre), $cuenca[0]);
                    }

                    $rio = $this->_excel->getRio($pais[0], $Rio_Nombre);
                    if (empty($rio)) {
                        $rio = $this->_excel->registrarRio(ucwords($Suc_Nombre), $pais[0]);
                    }
                    $riocuenca = $this->_excel->getRioCuenca($cuenca[0], $subcuenca[0], $rio[0]);

                    if (empty($riocuenca)) {
                        $riocuenca = $this->_excel->registrarRioCuenca($cuenca[0], $subcuenca[0], $rio[0]);
                    }
                    $estacion = $this->_excel->getEstacionMonitoreo($Esm_Latitud, $Esm_Longitud);
                    if (empty($estacion) and is_numeric($Esm_Latitud) and is_numeric($Esm_Longitud)) {
                        $estacion = $this->_excel->registrarEstacionMonitoreo($Esm_Nombre, str_replace(',', '.', $Esm_Longitud), str_replace(',', '.', $Esm_Latitud), $Esm_Referencia, $Esm_Altitud, $riocuenca[0]);
                    }
                    $entidad = $this->_excel->getEntidad($Ent_Nombre);
                    if (empty($entidad)) {
                        $entidad = $this->_excel->registrarEntidad($Ent_Nombre, $Ent_Siglas);
                    }



                    $variable = $this->_excel->getVariable($Var_Nombre);
                    if (empty($variable)) {
                        $variable = $this->_excel->registrarVariables($Var_Nombre, $Var_Abreviatura, $Var_Medida, $Idi_Idioma);
                    }
                    if (!$this->_excel->verificarMonitoreoCalidadAgua($Mca_Valor, $Mca_Fecha, $variable[0], $entidad[0], $estacion[0], $pais[0], $_SESSION['recurso'])) {
                        $this->_excel->registrarMonitoreoCalidadAgua($Mca_Valor, $Mca_Fecha, $variable[0], $estacion[0], $pais[0], $_SESSION['recurso'], $entidad[0]);
                        $total_registrado++;
                    } else {
                        array_push($datos, $objCelda);
                        $total_no_registrado++;
                    }
                } else {
                    array_push($datos, $objCelda);
                    $total_no_registrado++;
                }
            }
            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($objHoja);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
            unset($objHoja);
            unset($objReader);
            unset($objPHPExcel);
            unset($total_no_registrado);
            unset($total_registrado);
        } else {
            foreach ($_SESSION['valores_final'] as $objCelda) {

                if ($_POST['Mca_Valor'] != '') {
                    $Mca_Valor = $objCelda[$_POST['Mca_Valor']];
                }
                if ($_POST['Mca_Fecha'] != '') {
                    $Mca_Fecha = $objCelda[$_POST['Mca_Fecha']];
                }
                if ($_POST['Var_Nombre'] != '') {
                    $Var_Nombre = $objCelda[$_POST['Var_Nombre']];
                }
                if ($_POST['Var_Abreviatura'] != '') {
                    $Var_Abreviatura = $objCelda[$_POST['Var_Abreviatura']];
                }
                if ($_POST['Var_Medida'] != '') {
                    $Var_Medida = $objCelda[$_POST['Var_Medida']];
                }

                if ($_POST['Esm_Nombre'] != '') {
                    $Esm_Nombre = $objCelda[$_POST['Esm_Nombre']];
                }
                if ($_POST['Esm_Longitud'] != '') {
                    $Esm_Longitud = $objCelda[$_POST['Esm_Longitud']];
                }
                if ($_POST['Esm_Latitud'] != '') {
                    $Esm_Latitud = $objCelda[$_POST['Esm_Latitud']];
                }
                if ($_POST['Esm_Referencia'] != '') {
                    $Esm_Referencia = $objCelda[$_POST['Esm_Referencia']];
                }
                if ($_POST['Esm_Altitud'] != '') {
                    $Esm_Altitud = $objCelda[$_POST['Esm_Altitud']];
                }

                //no se hizo validacion de la entidad
                if ($_POST['Ent_Nombre'] != '') {
                    $Ent_Nombre = $objCelda[$_POST['Ent_Nombre']];
                }
                if ($_POST['Ent_Siglas'] != '') {
                    $Ent_Siglas = $objCelda[$_POST['Ent_Siglas']];
                }
                if ($_POST['Rio_Nombre'] != '') {
                    $Rio_Nombre = $objCelda[$_POST['Rio_Nombre']];
                }
                if ($_POST['Cue_Nombre'] != '') {
                    $Cue_Nombre = $objCelda[$_POST['Cue_Nombre']];
                }
                if ($_POST['Suc_Nombre'] != '') {
                    $Suc_Nombre = $objCelda[$_POST['Suc_Nombre']];
                }


                if ($_POST['Esd_Nombre'] != '') {
                    $Esd_Nombre = $objCelda[$_POST['Esd_Nombre']];
                }
                if ($_POST['Mpd_Nombre'] != '') {
                    $Mpd_Nombre = $objCelda[$_POST['Mpd_Nombre']];
                }
                if ($_POST['Pai_Nombre'] != '') {
                    $Pai_Nombre = $objCelda[$_POST['Pai_Nombre']];
                }
                if ($_POST['Idi_Idioma'] != '') {

                    $idioma = $this->_excel->getIdioma($objCelda[$_POST['Idi_Idioma']]);
                    if ($idioma) {
                        $Idi_Idioma = $idioma[0];
                    }
                }

                $pais = $this->_excel->getPais($Pai_Nombre);

                if (!empty($pais) and ! empty($Var_Nombre) and ( $Esm_Longitud != '') and ( $Esm_Latitud != '') and ! empty($Cue_Nombre) and ! empty($Suc_Nombre) and ! empty($Rio_Nombre) and is_numeric($Esm_Longitud) and is_numeric($Esm_Latitud)) {

                    $cuenca = $this->_excel->getCuenca($Cue_Nombre);
                    if (empty($cuenca)) {
                        $cuenca = $this->_excel->registrarCuenca(ucwords($Cue_Nombre));
                    }
                    $subcuenca = $this->_excel->getSubCuenca($cuenca[0], $Suc_Nombre);
                    if (empty($subcuenca)) {
                        $subcuenca = $this->_excel->registrarSucCuenca(ucwords($Suc_Nombre), $cuenca[0]);
                    }

                    $rio = $this->_excel->getRio($pais[0], $Rio_Nombre);
                    if (empty($rio)) {
                        $rio = $this->_excel->registrarRio(ucwords($Suc_Nombre), $pais[0]);
                    }
                    $riocuenca = $this->_excel->getRioCuenca($cuenca[0], $subcuenca[0], $rio[0]);

                    if (empty($riocuenca)) {
                        $riocuenca = $this->_excel->registrarRioCuenca($cuenca[0], $subcuenca[0], $rio[0]);
                    }
                    $estacion = $this->_excel->getEstacionMonitoreo($Esm_Latitud, $Esm_Longitud);
                    if (empty($estacion) and is_numeric($Esm_Latitud) and is_numeric($Esm_Longitud)) {
                        $estacion = $this->_excel->registrarEstacionMonitoreo($Esm_Nombre, str_replace(',', '.', $Esm_Longitud), str_replace(',', '.', $Esm_Latitud), $Esm_Referencia, $Esm_Altitud, $riocuenca[0]);
                    }
                    $entidad = $this->_excel->getEntidad($Ent_Nombre);
                    if (empty($entidad)) {
                        $entidad = $this->_excel->registrarEntidad($Ent_Nombre, $Ent_Siglas);
                    }



                    $variable = $this->_excel->getVariable($Var_Nombre);
                    if (empty($variable)) {
                        $variable = $this->_excel->registrarVariables($Var_Nombre, $Var_Abreviatura, $Var_Medida, $Idi_Idioma);
                    }
                    if (!$this->_excel->verificarMonitoreoCalidadAgua($Mca_Valor, $Mca_Fecha, $variable[0], $entidad[0], $estacion[0], $pais[0], $_SESSION['recurso'])) {
                        $this->_excel->registrarMonitoreoCalidadAgua($Mca_Valor, $Mca_Fecha, $variable[0], $estacion[0], $pais[0], $_SESSION['recurso'], $entidad[0]);
                        $total_registrado++;
                    } else {
                        array_push($datos, $objCelda);
                        $total_no_registrado++;
                    }
                } else {
                    array_push($datos, $objCelda);
                    $total_no_registrado++;
                }
            }
            $_SESSION['Descargar'] = $datos;
            $_SESSION['total_registros'] = count($_SESSION['valores_final']);
            $_SESSION['total_no_registrado'] = $total_no_registrado;
            $_SESSION['total_registrado'] = $total_registrado;
            unset($total_no_registrado);
            unset($total_registrado);
            Session::destroy('valores_final');
        }
    }

    public function descargar_datos() {

        error_reporting(0);
        $objPHPExcel = new PHPExcel();


        $indice = 0;
        for ($i = 1; $i <= count($_SESSION['Descargar']); $i++) {
            $indice = $i - 1;
            for ($j = 0; $j < count($_SESSION['Descargar'][0]); $j++) {

                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($j, $i, $_SESSION['Descargar'][$indice][$j]);
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle('GEF-OTCA');

        $objPHPExcel->setActiveSheetIndex(0);

        ob_end_clean();
        ob_start();
        Session::destroy('encabezado');
        Session::destroy('Descargar');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="test.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function pagina_resultado() {
        $paginador = new Paginador();
        $this->_view->setJs(array('resultado'));
        $pagina = $this->getPostParam('pagina');
        $this->_view->assign('total_registrado', $_SESSION['total_registrado']);
        $this->_view->assign('total_no_registrado', count($_SESSION['total_no_registrado']));
        $this->_view->assign('total_registros', $_SESSION['total_registros']);
        $this->_view->assign('no_registrado', $paginador->paginar($_SESSION['datos_no_registrados'], "", "", $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('cabecera', $_SESSION['cabecera']);
        $this->_view->assign('titulo', 'Cargar Datos');
        $this->_view->renderizar('ajax/resultados', false, true);
    }

}

?>
