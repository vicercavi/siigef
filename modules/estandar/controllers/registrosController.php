<?php

class registrosController extends estandarController 
{
    private $_registros;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_registros = $this->loadModel('registros');
        $this->_bdrecursos = $this->loadModel('indexbd', 'bdrecursos');
        $this->_import = $this->loadModel('import', 'bdrecursos');
    }

    public function index($idrecurso = false) 
    {
        $this->_acl->acceso("listar_registros");
        
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        //$this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->setJs(array('index',array(BASE_URL.'public/ckeditor/ckeditor.js'),array(BASE_URL.'public/ckeditor/adapters/jquery.js')));
        $idrecurso = $this->filtrarInt($idrecurso);
        $idestandar = $this->_registros->getEstandarRecurso($idrecurso);
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        $this->_view->assign('ficha', $fichaEstandar);

        if ($this->botonPress("bt_guardarFichaEstandar")) 
        {
            $this->insertarRegistroRecurso($idrecurso, $fichaEstandar);
        }

        $estado = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Estado";

        $paginador = new Paginador();
        $lista = $this->_registros->getListaRegistrosEstandar($fichaEstandar[0]['Fie_NombreTabla'], $estado, Cookie::lenguaje(), "");
        $_SESSION['listaRegistro'] = $lista;
        unset($lista);
         $this->_view->assign('recurso', $idestandar[1]); 
        $this->_view->assign('datos', $paginador->paginar($_SESSION['listaRegistro'], "listaregistros", "$idrecurso", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));

        $this->_view->assign('titulo', 'Registro Estandar');
        $this->_view->renderizar('index', 'Registro Estandar');
    }

    public function _paginacion_listaregistros($idrecurso = false) 
    {
        $pagina = $this->getInt('pagina');
        //$registros = $this->getInt('registros');
        $idrecurso = $this->filtrarInt($idrecurso);
        $idestandar = $this->_registros->getEstandarRecurso($idrecurso);
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        $this->_view->assign('ficha', $fichaEstandar);

        $paginador = new Paginador();

        $this->_view->assign('datos', $paginador->paginar($_SESSION['listaRegistro'], "listaregistros", "$idrecurso", $pagina, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    //Insertar Registro
    public function insertarRegistroRecurso($idrecurso, $fichaEstandar) 
    {
        $escripFicha = ' ';
        foreach ($fichaEstandar as $ficha) 
        {
            if ($ficha['Fie_TipoDatoCampo'] == "int" || $ficha['Fie_TipoDatoCampo'] == "double") 
            {
                $escripFicha .= " " . $this->getSql($ficha['Fie_ColumnaTabla']) . " , ";
            }

            if ($ficha['Fie_TipoDatoCampo'] == "varchar") 
            {
                $escripFicha .= " '" . $this->getSql($ficha['Fie_ColumnaTabla']) . "' , ";
            }

            $tabla = $ficha['Fie_NombreTabla'];
        }

        $insertar = "INSERT INTO " . $tabla . " VALUES ( null, " . $escripFicha . " "
                . " " . $idrecurso . ", '" . Cookie::lenguaje() . "', 1)";
        //echo $insertar; exit;
        $this->_registros->insertarRegistro($insertar);
    }

    //Editar Registro....
    public function editarRegistro($idRegistro, $idRecurso, $idiomaRegistro) 
    {
        $this->_acl->acceso("editar_registros_recurso");
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->validarUrlIdioma();
        $this->_view->setJs(array('index',array(BASE_URL.'public/ckeditor/ckeditor.js'),array(BASE_URL.'public/ckeditor/adapters/jquery.js')));
        $idRegistro = $this->filtrarInt($idRegistro);
        $idRecurso = $this->filtrarInt($idRecurso);
        $idestandar = $this->_registros->getEstandarRecurso($idRecurso);
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Id";
        $idTabla = $ini . str_replace(' ', '', ucwords(str_replace('_', ' ', $fichaEstandar[0]['Fie_NombreTabla'])));        

        $recurso = $this->_bdrecursos->getRecursoCompletoXid($idRecurso);

        if ($this->botonPress("bt_guardarRegistro")) 
        {
            if ($this->getSql('Idi_IdIdioma') == $idiomaRegistro) 
            {
                $this->editarRegistroRecurso($idRegistro, $idTabla, $idRecurso, $fichaEstandar);
                //echo $this->getSql('Idi_IdIdioma').$registro['Idi_IdIdioma'];exit;
            } 
            else 
            {
                $this->editarRegistroTraduccion($idRegistro, $this->getSql('Idi_IdIdioma'), $fichaEstandar);
            }
        }

        $registro = $this->_registros->getRegistroEstandar($fichaEstandar[0]['Fie_NombreTabla'], $idRegistro, $idTabla);
        $columnas = $this->_bdrecursos->getColumnasTabla($fichaEstandar[0]['Fie_NombreTabla']);
        $nombre_tabla2 = str_replace(array(' ','_'), ' ', $fichaEstandar[0]['Fie_NombreTabla']);

        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('idiomas', $this->_registros->getIdiomas());
        $this->_view->assign('nombre_tabla2', $nombre_tabla2);
        //print_r($registro);exit;
        //$this->_view->assign('idiomaOriginal', $registro['Idi_IdIdioma'] );
        $this->_view->assign('recurso1', $idestandar[1]);
        $this->_view->assign('recurso', $recurso);
        $this->_view->assign('idRecurso', $idRecurso);
        $this->_view->assign('datos', $registro);

        $this->_view->assign('titulo', 'Editar Registro');
        $this->_view->renderizar('editarRegistro', 'Editar Registro');
    }

    //Registrar Edicion...
    public function editarRegistroRecurso($idRegistro, $idTabla, $idRecurso, $fichaEstandar) 
    {
        $escripFicha = ' ';
        foreach ($fichaEstandar as $ficha) 
        {
            if ($ficha['Fie_TipoDatoCampo'] == "int" || $ficha['Fie_TipoDatoCampo'] == "double") 
            {
                $escripFicha .= " " . $ficha['Fie_ColumnaTabla'] . " = " . $this->getSql($ficha['Fie_ColumnaTabla']) . " , ";
            }

            if ($ficha['Fie_TipoDatoCampo'] == "varchar") 
            {
                $escripFicha .= " " . $ficha['Fie_ColumnaTabla'] . " = " . " '" . $this->getPostParam($ficha['Fie_ColumnaTabla']) . "' , ";
            }

            $tabla = $ficha['Fie_NombreTabla'];
        }       

        $insertar = "UPDATE " . $tabla . " SET " . $escripFicha . " Rec_IdRecurso = " . $idRecurso . " WHERE " . $idTabla . " = " . $idRegistro . "";
        //echo $insertar; exit;
        $this->_registros->insertarRegistro($insertar);
    }

    //Registrar Traduccion...!!
    public function editarRegistroTraduccion($idRegistro, $Idi_IdIdioma, $fichaEstandar) 
    {
        $escripFicha = ' ';
        $bdarquitectura = $this->loadModel("index", "arquitectura");

        foreach ($fichaEstandar as $ficha) 
        {
            if ($ficha['Fie_TipoDatoCampo'] == "int" || $ficha['Fie_TipoDatoCampo'] == "double") 
            {
                //$escripFicha .= " ".$ficha['Fie_ColumnaTabla']." = ".$this->getSql($ficha['Fie_ColumnaTabla'])." , ";
            }

            if ($ficha['Fie_TipoDatoCampo'] == "varchar") 
            {
                $idTraduccion = $bdarquitectura->buscarCampoTraducido($ficha['Fie_NombreTabla'], $idRegistro, $ficha['Fie_ColumnaTabla'], $Idi_IdIdioma);
                //echo $idTraduccion[0];
                if ($idTraduccion[0] > 0) 
                {
                    $rowCount = $this->_registros->actualizarTraduccion($idTraduccion[0], $this->getSql($ficha['Fie_ColumnaTabla']));
                } 
                else 
                {
                    $idRegistroInsertado = $bdarquitectura->registrarTraduccion($ficha['Fie_NombreTabla'], $idRegistro, $ficha['Fie_ColumnaTabla'], $Idi_IdIdioma, $this->getSql($ficha['Fie_ColumnaTabla']));
                }
            }
            //$tabla = $ficha['Fie_NombreTabla'];
        }
    }

    //Gestion Idiomas
    public function gestion_idiomas() 
    {
        $idRegistro = $this->getPostParam('Reg_IdRegistro');
        $idRecurso = $this->getPostParam('Rec_IdRecurso');
        $idIdiomaSlect = $this->getPostParam('idIdiomaSlect');
        //$Idi_IdIdioma = $this->getPostParam('Idi_IdIdioma');
        //echo $idIdiomaSlect;exit;
        $idestandar = $this->_registros->getEstandarRecurso($idRecurso);
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('idiomas', $this->_registros->getIdiomas());

        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Id";
        $idTabla = $ini . str_replace(' ', '', ucwords(str_replace('_', ' ', $fichaEstandar[0]['Fie_NombreTabla'])));

        //$registro = $this->_registros->getRegistroEstandar($fichaEstandar[0]['Fie_NombreTabla'],$idRegistro,$idTabla);

        $datos = $this->getRegistroTraducido($idRegistro, $idTabla, $idIdiomaSlect, $fichaEstandar);
        //print_r($datos);exit;
        if ($datos["Idi_IdIdioma"] == $idIdiomaSlect) 
        {
            $this->_view->assign('datos', $datos);
        } 
        else 
        {
            foreach ($fichaEstandar as $ficha) 
            {
                if ($ficha['Fie_TipoDatoCampo'] == "int" || $ficha['Fie_TipoDatoCampo'] == "double") 
                {
                    //$escripFicha .= " ".$ficha['Fie_ColumnaTabla']." = ".$this->getSql($ficha['Fie_ColumnaTabla'])." , ";
                }

                if ($ficha['Fie_TipoDatoCampo'] == "varchar") 
                {
                    $datos[$ficha['Fie_ColumnaTabla']] = "";
                }
            }
            /* $datos["Pag_Nombre"]="";
              $datos["Pag_Descripcion"]="";
              $datos["Pag_Contenido"]=""; */
            $datos["Idi_IdIdioma"] = $idIdiomaSlect;
            $this->_view->assign('datos', $datos);
        }
        //$this->_view->assign('idiomaOriginal', $idIdiomaSlect );
        $this->_view->assign('idRecurso', $idRecurso);
        $this->_view->renderizar('ajax/gestion_idiomas', false, true);
    }

    public function getRegistroTraducido($idRegistro, $idTabla, $Idi_IdIdioma, $fichaEstandar) 
    {
        $escripFicha = ' ';
        foreach ($fichaEstandar as $ficha) 
        {
            if ($ficha['Fie_TipoDatoCampo'] == "int" || $ficha['Fie_TipoDatoCampo'] == "double") 
            {
                $escripFicha .= " " . $ficha['Fie_ColumnaTabla'] . " , ";
            }

            if ($ficha['Fie_TipoDatoCampo'] == "varchar") 
            {
                $escripFicha .= " fn_TraducirContenido('" . $ficha['Fie_NombreTabla'] . "', '" . $ficha['Fie_ColumnaTabla'] . "' , " . $idTabla . ", '" . $Idi_IdIdioma . "', " . $ficha['Fie_ColumnaTabla'] . " ) " . $ficha['Fie_ColumnaTabla'] . ", ";
            }

            $tabla = $ficha['Fie_NombreTabla'];
        }

        $scripGetRegistro = "SELECT " . $idTabla . ", " . $escripFicha . " fn_devolverIdioma('" . $tabla . "', " . $idTabla . ", '" . $Idi_IdIdioma . "', Idi_IdIdioma) Idi_IdIdioma FROM " . $tabla . " WHERE " . $idTabla . " = " . $idRegistro . "";
        //echo $scripGetRegistro; exit;
        $datos = $this->_registros->getRegistroTraducido($scripGetRegistro);

        return $datos;
    }

    //Gestion Idiomas

    public function _puntosEstandarGenerico() 
    {
        header("access-control-allow-origin: *");

        if ($this->getPostParam('parametro')) 
        {
            $datos = $this->_registros->puntosEstandarGenerico(json_decode($this->getPostParam('parametro')), Cookie::lenguaje()
            );
            echo json_encode($datos);
            exit;
        }
        echo json_encode("{0:Faltan Parametros}");
    }

    public function _perfilGenerico() 
    {     

        header("access-control-allow-origin: *");

        if ($this->getPostParam('filtro') && $this->getPostParam('tabla')) 
        {
            $paginador = new Paginador();

            //$this->_view->getLenguaje("estandar_registros_perfilgerico");
            $bdestandar = $this->loadModel('index');
            $datos = $this->_registros->perfilEstandarGenerico(json_decode($this->getPostParam('filtro')), $this->getPostParam('tabla'), $this->getPostParam('columna'),$this->getPostParam('lat'),$this->getPostParam('lng'), Cookie::lenguaje());

            $estandar = $this->_registros->estandarXTabla($this->getPostParam('tabla'));
            $fichaEstandar = $bdestandar->getFicha_Estandar($estandar["Esr_IdEstandarRecurso"]);

            $this->_view->assign('title', json_decode($this->getPostParam('filtro')));
            $this->_view->assign('estandar', $estandar);
            $this->_view->assign('fichaestandar', $fichaEstandar);

            $dato_recurso = $this->_import->getRecurso($datos[0]['Rec_IdRecurso']);

            $tabla_data = $dato_recurso[1];
            //echo $estandar['Esr_Tipo']; exit();
            
            if($estandar['Esr_Tipo']==2)
            {
                $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'],0,3);
                $nombre_tabla="variable_".$fichaEstandar[0]['Fie_NombreTabla']; 

                $nombre_tabla2="data_".$fichaEstandar[0]['Fie_NombreTabla'];    
                
                $campo_id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $nombre_tabla)));
                $campo_id2 = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $nombre_tabla2)));  
                $campo_nombre = $ini.'_Nombre';
                $campo_pregunta = $ini.'_Etiqueta';               
                $campo_valor = $ini.'_Valor';
                $campo_numregistro = $ini.'_NumRegistro';
                $campo_estado = $ini.'_Estado';
                $campo_tema = $ini.'_Tema';
                $campo_subtema = $ini.'_Subtema';
                $campo_pais = $ini.'_Pais';                

                $this->_view->assign('campo_pregunta',$campo_pregunta);                
                $this->_view->assign('campo_nombre', $campo_nombre);
                $this->_view->assign('campo_numregistro', $campo_numregistro);
                $this->_view->assign('campo_estado', $campo_estado);
                $this->_view->assign('campo_tema', $campo_tema);
                $this->_view->assign('campo_subtema', $campo_subtema);
                $this->_view->assign('campo_pais', $campo_pais);
                $this->_view->assign('campo_id', $campo_id);

                for ($index = 0; $index < count($datos); $index++) 
                {
                    $resultado=$this->_registros->getCantidadPorColumna($tabla_data, $datos[$index][$campo_nombre]);

                    $datos[$index]['resultado']=$resultado;
                }

                if (count($datos) != 1) 
                {
                    //$this->_view->assign('datos', $paginador->paginar($datos, 'perfilg_lista_datos', $this->getPostParam('filtro') . "/" . $this->getPostParam('tabla') . "/" . $this->getPostParam('columna'), false, 3));
                    $this->_view->assign('id_estandar', $estandar['Esr_IdEstandarRecurso']);
                    $this->_view->assign('subtema',str_replace(' ', '_', strtolower($datos[0][5])));
                    $this->_view->assign('datos', $datos);
                    //print_r($datos[0]);exit();
                    $this->_view->assign('resultado', $resultado);
                    $this->_view->assign('tabla', $fichaEstandar[0]['Fie_NombreTabla']);
                    $this->_view->assign('paginacion_datos', $paginador->getView('paginacion_ajax'));
                    $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
                    $this->_view->assign('numeropagina', 1);               
                }
                else
                {
                    $this->_view->assign('dato',$datos[0]);
                }
                
                $this->_view->renderizar('ficha/investigacion_opinion_publica', false, true);
            }
            else
            {
                $this->_view->renderizar('ajax/registros_perfil_generico', false, true);
            }
            
        }
    }

    public function metadata($idrecurso, $valorid)
    {
        $this->_acl->autenticado();
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->getLenguaje("estandar_metadata");
        $this->_view->setTemplate(LAYOUT_FRONTEND);

        $idrecurso = $this->filtrarInt($idrecurso);

        $recurso = $this->_bdrecursos->getRecursoCompletoXid($idrecurso);
        $idestandar = $this->_registros->getEstandarRecurso($idrecurso);
       
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('recurso', $recurso);
        //$bdestandar = $this->loadController('registros', 'estandar');

        if ($this->botonPress("bt_guardarFichaEstandar")) 
        {
           $this->insertarRegistroRecurso($idrecurso, $fichaEstandar);
        }

        $estado = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Estado";
        $columnas = $this->_bdrecursos->getColumnasTabla($fichaEstandar[0]['Fie_NombreTabla']);

        $metadata_estandar = $this->_registros->getEstandarMetadata($fichaEstandar[0]['Fie_NombreTabla'], $columnas[0][0], $valorid);
        $nombre_tabla2 = str_replace(array(' ','_'), ' ', $fichaEstandar[0]['Fie_NombreTabla']);
        
        $paginador = new Paginador();
        $lista = $this->_registros->getListaRegistrosEstandar($fichaEstandar[0]['Fie_NombreTabla'], Cookie::lenguaje(), "");

        $this->_view->assign('detalle', $metadata_estandar);

        $this->_view->assign('columna_estado', $estado);
        $this->_view->assign('nombre_tabla', $fichaEstandar[0]['Fie_NombreTabla']);
        $this->_view->assign('nombre_tabla2', $nombre_tabla2);
        $this->_view->assign('idEstandarRecurso', $idestandar[0]);
        $this->_view->assign('nombre_recurso', $idestandar[1]); 
        $this->_view->assign('datos', $paginador->paginar($lista, "listaregistros", "$idrecurso", 1, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('titulo', 'Metadata');
        $this->_view->renderizar('metadata', 'Metadata');
    }
}
