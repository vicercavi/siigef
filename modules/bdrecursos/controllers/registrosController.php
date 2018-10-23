<?php

class registrosController extends bdrecursosController
{
	private $_registros_recurso;

	public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_bdrecursos = $this->loadModel('indexbd');
        $this->_import = $this->loadModel('import');
        $this->_registros = $this->loadModel('registros','estandar'); 
        $this->_estandar = $this->loadModel('index', 'estandar');  
        $this->_share = $this->loadModel('share');      
    }

    public function index($idrecurso = false) 
    {
        $this->_acl->acceso("listar_recurso");
        $this->validarUrlIdioma();

        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("bdrecursos_registros");
        $this->_view->setJs(array('index'));
        $this->_view->setCss(array('metadata'));

        $paginador = new Paginador();

        $idrecurso = $this->filtrarInt($idrecurso);

        $this->_view->assign('titulo', 'Lista de Registro');
        
        if ($idrecurso) 
        {
            
        } 
        else 
        {
            $this->redireccionar("bdrecursos");
        }

        $recurso = $this->_bdrecursos->getRecursoCompletoXid($idrecurso);

        $this->_view->assign('fichaestandar', $this->_bdrecursos->getFichaEstandarXRecurso($recurso["Rec_IdRecurso"]));

        $idEstandarRecurso = $recurso["Esr_IdEstandarRecurso"];

        switch ($idEstandarRecurso) 
        {
            case 1:
                $bdmonitoreo = $this->loadModel("monitoreo","calidaddeagua");
                $this->_view->assign('calidadagua', $paginador->paginar($bdmonitoreo->getmonitoreocalidadXidRecurso($recurso["Rec_IdRecurso"],""), "metadata_lista_calidadagua", $idrecurso, false, 25));
                $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
                $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
                $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
                $this->_view->assign('recurso', $recurso);        
                $this->_view->renderizar('registros', 'registros');
                break;

            case 2:
                $condicion = "where  m.Rec_IdRecurso = " . $recurso["Rec_IdRecurso"];

                $bdlegal = $this->loadModel('legal', 'legislacion');
                $this->_view->assign('legislacion', $paginador->paginar($bdlegal->getLegislacionesMetadata($condicion), "metadata_lista_legislacion", $idrecurso, false, 25));
                $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
                $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
                $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
                $this->_view->assign('recurso', $recurso);        
                $this->_view->renderizar('registros', 'bdrecursos');                
                break;

            case 3:
                $condicion = "where  Rec_IdRecurso = " . $recurso["Rec_IdRecurso"];
                $bddublin = $this->loadModel('documentos', 'dublincore');

                $this->_view->assign('dublin', $paginador->paginar($bddublin->getDocumentosTraducido($condicion, Cookie::lenguaje()), "metadata_lista_dublin", $idrecurso, false, 25));
                $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
                $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
                $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
                $this->_view->assign('recurso', $recurso);        
                $this->_view->renderizar('registros', 'bdrecursos');
                break;

            case 4:
                $bdplinian = $this->loadModel('botanico', 'atlas');
                $this->_view->assign('plinian', $paginador->paginar($bdplinian->getPlinianXRecurso($recurso["Rec_IdRecurso"], ""), "metadata_lista_plinian", $recurso["Rec_IdRecurso"], false, 25));
                $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
                $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
                $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
                $this->_view->assign('recurso', $recurso);        
                $this->_view->renderizar('registros', 'bdrecursos');
                break;

            case 5:
                $bdmapa = $this->loadModel('mapa');
                $this->_view->assign('capas', $bdmapa->CapasCompletoXIdrecurso($recurso["Rec_IdRecurso"]));
                $this->_view->assign('recurso', $recurso);        
                $this->_view->renderizar('registros', 'bdrecursos');
                break;

            case 6:

                $bddarwin = $this->loadModel('biodiversidad', true);
                $this->_view->assign('darwin', $paginador->paginar($bddarwin->getDarwinXrecurso($recurso["Rec_IdRecurso"],""), "metadata_lista_darwin", $recurso["Rec_IdRecurso"], false, 25));
                $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
                $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
                $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
                $this->_view->assign('recurso', $recurso);        
                $this->_view->renderizar('registros', 'bdrecursos');
                break;

            default:

            	$estandar_recurso = $this->_estandar->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=$idEstandarRecurso");
                $tipoEstandarRecurso = $estandar_recurso[0]['Esr_Tipo'];

                $idrecurso = $this->filtrarInt($idrecurso);
                $idestandar = $this->_registros->getEstandarRecurso($idrecurso);
                $this->_view->assign('nombre_recurso', $idestandar[1]);   
                $this->_view->assign('tipoEstandar', $tipoEstandarRecurso);

                if($tipoEstandarRecurso==2)
                {
                    $this->_tablas = $this->_estandar->getTablasBD();                    

                    $idEstandarRecurso = $this->filtrarInt($idEstandarRecurso);
                    $estandar_recurso = $this->_estandar->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=$idEstandarRecurso");

                    if (!empty($estandar_recurso)) 
                    {
                        $tipoEstandarRecurso = $estandar_recurso[0]['Esr_Tipo'];     
                        $fichaEstandar = $this->_estandar->getFicha_Estandar($idEstandarRecurso);
                        $tabla_variable="variable_".$fichaEstandar[0]['Fie_NombreTabla'];

                        $dato_recurso = $this->_import->getRecurso($idrecurso);
                        $tabla_data = $dato_recurso[1];

                        if ($this->botonPress("bt_guardarFichaVariable")) 
                        {
                            $this->insertarRegistroRecurso($idrecurso, $fichaEstandar, $tipoEstandarRecurso);           
                        }  

                        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'],0,3);
                        
                        $campo_id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_variable)));
                        $campo_id2 = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_data)));
                        $campo_nombre = $ini.'_Nombre';
                        $campo_etiqueta = $ini.'_Etiqueta';
                        $campo_tipo = $ini.'_Tipo';
                        $campo_estado = $ini.'_Estado'; 
                        
                        if($this->botonPress("bt_guardarRegistroData"))
                        {
                            $this->registrarTablaData($tabla_variable, $tabla_data, $campo_nombre, $campo_tipo, $idrecurso);
                        }

                        $fichaEstandar = $this->_registros->getFichaEstandar($idEstandarRecurso);

                        $lista_variable = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $idrecurso);

                        $lista_variable2 = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $idrecurso, "Limit 10");

                        $paginadorVariable = new Paginador();
                        
                        $lista_data = $this->_bdrecursos->getRegistrosData($tabla_data);

                        $this->_view->assign('campo_id', $campo_id);

                        $this->_view->assign('campo_nombre',$campo_nombre);
                        $this->_view->assign('campo_etiqueta',$campo_etiqueta);
                        $this->_view->assign('campo_tipo',$campo_tipo);
                        $this->_view->assign('campo_estado', $campo_estado);
                        
                        $this->_view->assign('lista_variable', $paginadorVariable->paginar($lista_variable, "listaregistrosVariable", "$idrecurso", 1, 25));
                        $this->_view->assign('numeropaginaVariable', $paginadorVariable->getNumeroPagina());                        
                        $this->_view->assign('paginacionVariable', $paginadorVariable->getView('paginacion_ajax'));
                        $this->_view->assign('control_paginacion', $paginadorVariable->getControlPaginaion());

                        //Para data

                        $paginadorData = new Paginador();

                        $this->_view->assign('campo_id2', $campo_id2);
                        $this->_view->assign('tabla_data', $tabla_data);
                        $this->_view->assign('lista_variable2', $lista_variable);
                        $this->_view->assign('lista_variable3',$lista_variable2);
                        $this->_view->assign('lista_data', $paginadorData->paginar($lista_data, "listaregistrosData", "$idrecurso/$tabla_data", 1, 25));
                        $this->_view->assign('numeropaginaData', $paginadorData->getNumeroPagina());                        
                        $this->_view->assign('paginacionData', $paginadorData->getView('paginacion_ajax'));
                    }
                    else
                    {
                        echo "estandar no existe";
                    }

                    $fichaEstandar = $this->_estandar->getFicha_Estandar($idestandar[0]);
                    
                    $fichaVariable = $this->_import->getFichaVariable($tabla_variable, $idrecurso);
                    $this->_view->assign('fichaVariable', $fichaVariable);                     
                }
                else
                {                   
                    $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
                    $this->_view->assign('fichaEstandar', $fichaEstandar);
                    
                    
                    if ($this->botonPress("bt_guardarFichaEstandar")) 
                    {
                       $this->insertarRegistroRecurso($idrecurso, $fichaEstandar);
                    }

                    $estado = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Estado";
                    
                    $paginador = new Paginador();
                    $lista = $this->_registros->getListaRegistrosEstandar($fichaEstandar[0]['Fie_NombreTabla'], Cookie::lenguaje(), "");

                    $this->_view->assign('columna_estado', $estado);
                    $this->_view->assign('nombre_tabla1', $fichaEstandar[0]['Fie_NombreTabla']);
                    
                    $this->_view->assign('datos', $paginador->paginar($lista, "listaregistros", "$idrecurso", 1, 25));
                    $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
                    $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
                }

                $this->_view->assign('idEstandarRecurso', $idestandar[0]);

                $this->_view->assign('recurso', $recurso);
                $this->_view->assign('ficha', $fichaEstandar);
                $this->_view->assign('titulo', 'Registro Recurso');
                $this->_view->renderizar('estandar', 'Registro Estandar');
                break;
        }        
    }

    public function metadata($idrecurso, $valorid)
    {
        $this->_acl->autenticado();
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->getLenguaje("estandar_metadata");
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->setJs(array('registros'));

        $idrecurso = $this->filtrarInt($idrecurso);

        $recurso = $this->_bdrecursos->getRecursoCompletoXid($idrecurso);
        $idestandar = $this->_registros->getEstandarRecurso($idrecurso);

        $estandar_recurso = $this->_estandar->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=$idestandar[0]");

        $tipoEstandarRecurso = $estandar_recurso[0]['Esr_Tipo'];
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        $nombre_tabla = ucwords(str_replace(array(' ','_'), ' ', $fichaEstandar[0]['Fie_NombreTabla']));

        $paginador = new Paginador();
        
        if($tipoEstandarRecurso==2)
        {
            $dato_recurso = $this->_import->getRecurso($idrecurso);

            $tabla_variable = 'variable_'.$fichaEstandar[0]['Fie_NombreTabla'];
            $tabla_data = $dato_recurso[1];
            
            $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3);
            $lista_variable = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $idrecurso); 

            $campo_id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_variable)));
            $campo_id2 = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_data)));
            $campo_nombre = $ini."_Nombre";
            $campo_etiqueta = $ini.'_Etiqueta';
            $lista_data = $this->_bdrecursos->getRegistrosData($tabla_data, "WHERE $campo_id2 = $valorid");

            $this->_view->assign('respuesta', 1);
            $this->_view->assign('campo_nombre', $campo_nombre);
            $this->_view->assign('campo_etiqueta', $campo_etiqueta);

            $this->_view->assign('lista_variable', $paginador->paginar($lista_variable, "metadata_registros", "$idrecurso/$valorid", 1, 25));
            $this->_view->assign('lista_data', $lista_data);

            $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
            $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
            $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        }
        else
        {
            $estado = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Estado";
            $columnas = $this->_bdrecursos->getColumnasTabla($fichaEstandar[0]['Fie_NombreTabla']);
            
            $metadata_estandar = $this->_registros->getEstandarMetadata($fichaEstandar[0]['Fie_NombreTabla'], $columnas[0][0], $valorid);

            $lista = $this->_registros->getListaRegistrosEstandar($fichaEstandar[0]['Fie_NombreTabla'], Cookie::lenguaje(), "");

            $this->_view->assign('detalle', $metadata_estandar);

            $this->_view->assign('columna_estado', $estado);
            $this->_view->assign('nombre_tabla', $fichaEstandar[0]['Fie_NombreTabla']);
            
            $this->_view->assign('idEstandarRecurso', $idestandar[0]);
            $this->_view->assign('nombre_recurso', $idestandar[1]); 
            //$this->_view->assign('datos', $lista);
            $this->_view->assign('respuesta', 0);

            $this->_view->assign('datos', $paginador->paginar($lista, "listaregistros", "$id_recurso", 1, 25));        
        }

        $this->_view->assign('nombre_tabla', $nombre_tabla);
        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('recurso', $recurso);
        //$bdestandar = $this->loadController('registros', 'estandar');

              
        $this->_view->assign('titulo', 'Metadata Registros');
        $this->_view->renderizar('metadata', 'registros');
    }
    public function editarRegistro($idRegistro, $idRecurso, $idiomaRegistro) 
    {
        $this->_acl->acceso("editar_registros_recurso");
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->validarUrlIdioma();
        $this->_view->setJs(array('index',array(BASE_URL.'public/ckeditor/ckeditor.js'),array(BASE_URL.'public/ckeditor/adapters/jquery.js')));        

        $idRegistro = $this->filtrarInt($idRegistro);
        $idRecurso = $this->filtrarInt($idRecurso);

        $idestandar = $this->_registros->getEstandarRecurso($idRecurso);        

        $estandar_recurso = $this->_estandar->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=$idestandar[0]");

        $tipoEstandarRecurso = $estandar_recurso[0]['Esr_Tipo']; 
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]); 

        $tabla = $fichaEstandar[0]['Fie_NombreTabla'];
        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Id"; 
        $idTabla = $ini . str_replace(' ', '', ucwords(str_replace('_', ' ', $tabla)));   

        if($tipoEstandarRecurso==2)
        {
            $tabla = 'variable_'.$tabla;
            $idTabla = $ini . str_replace(' ', '', ucwords(str_replace('_', ' ', $tabla)));   
        }

        $nombre_tabla2 = str_replace(array(' ','_'), ' ', $tabla); 
        
        if ($this->botonPress("bt_editarRegistro")) 
        {
            if($_POST['tipo_estandar']==2)
            {
                $this->editarRegistroRecurso($idRegistro, $idTabla, $idRecurso, $fichaEstandar, $tipoEstandarRecurso);
            }
            else
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
        }
        
        $recurso = $this->_bdrecursos->getRecursoCompletoXid($idRecurso);

        $columnas = $this->_bdrecursos->getColumnasTabla($tabla);         

        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('idiomas', $this->_registros->getIdiomas());        

        $registro = $this->_registros->getRegistroEstandar($tabla, $idRegistro, $idTabla);

        $this->_view->assign('datos', $registro);
        $this->_view->assign('recurso', $recurso);

        $this->_view->assign('recurso1', $idestandar[1]);
        //print_r($registro);exit;
        //$this->_view->assign('idiomaOriginal', $registro['Idi_IdIdioma'] );
        $this->_view->assign('nombre_tabla2', $nombre_tabla2);
        $this->_view->assign('tipo_estandar', $tipoEstandarRecurso);
        
        
        $this->_view->assign('idRecurso', $idRecurso);
        

        $this->_view->assign('titulo', 'Editar Registro');
        $this->_view->renderizar('editarRegistro', 'Editar Registro');
    }

    public function editarRegistroData($idregistro, $idrecurso, $idiomaRegistro)
    {
        $this->_acl->acceso("editar_registros_recurso");
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->validarUrlIdioma();
        $this->_view->setJs(array('index',array(BASE_URL.'public/ckeditor/ckeditor.js'),array(BASE_URL.'public/ckeditor/adapters/jquery.js')));       

        $idregistro = $this->filtrarInt($idregistro);
        $idrecurso = $this->filtrarInt($idrecurso);

        $idestandar = $this->_registros->getEstandarRecurso($idrecurso);    
        $dato_recurso = $this->_import->getRecurso($idrecurso);    

        $estandar_recurso = $this->_estandar->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=$idestandar[0]");

        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]); 
        $tabla_variable = 'variable_'.$fichaEstandar[0]['Fie_NombreTabla'];
        $tabla_data = $dato_recurso[1];
        $nombre_tabla = str_replace(array(' ','_'), ' ', $fichaEstandar[0]['Fie_NombreTabla']);
        $lista_variable = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $idrecurso);
        
        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3);
        $campo_id = $campo_id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_variable)));
        $campo_id2 = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_data)));
        $campo_nombre = $ini.'_Nombre';
        $campo_etiqueta = $ini.'_Etiqueta';
        $campo_tipo = $ini.'_Tipo';
        $campo_estado = $ini.'_Estado';

        if ($this->botonPress("bt_editarRegistro")) 
        {            
            $this->editarRegistroRecursoData($tabla_variable, $idrecurso, $ini, $tabla_data, $idregistro);
        }

        $recurso = $this->_bdrecursos->getRecursoCompletoXid($idrecurso);
        $fichaVariable = $this->_registros->getFichaVariable($tabla_variable, $idrecurso);
        $lista_variable2 = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $idrecurso);
        $lista_data = $this->_bdrecursos->getRegistrosData($tabla_data, "WHERE $campo_id2 = $idregistro");        
        
        $this->_view->assign('nombre_tabla', $nombre_tabla);
        $this->_view->assign('recurso', $recurso);
        $this->_view->assign('fichaVariable', $fichaVariable);
        $this->_view->assign('lista_variable2', $lista_variable);
        $this->_view->assign('lista_data', $lista_data);
        $this->_view->assign('respuesta', 1);
        $this->_view->assign('campo_nombre', $campo_nombre);
        $this->_view->assign('campo_etiqueta', $campo_etiqueta); 
        $this->_view->assign('campo_tipo', $campo_tipo); 
        $this->_view->assign('idrecurso', $idrecurso);       
        
        $this->_view->assign('titulo', 'Editar Registro');
        $this->_view->renderizar('editarRegistroData', 'Editar Registro');
    }

    public  function registrarTablaData($tabla_variable, $tabla_data, $campo_nombre, $campo_tipo, $Rec_IdRecurso)
    {
        $fichaVariable = $this->_import->getFichaVariable($tabla_variable, $Rec_IdRecurso);

        $escripFicha = '';

        foreach ($fichaVariable as $ficha) 
        {         
            if(strtolower($ficha[$campo_tipo]) == "numero" || strtolower($ficha[$campo_tipo]) == 'decimal') 
            {
                if ($_POST[$ficha[$campo_nombre]]!='') 
                {
                    $escripFicha .= " " . $_POST[$ficha[$campo_nombre]] . " , ";
                }
                else
                {
                    $escripFicha .= " 0,";
                }                
            }
            else
            {
                if ($_POST[$ficha[$campo_nombre]]!='') 
                {
                    $escripFicha .= " '" . $_POST[$ficha[$campo_nombre]] . "', ";
                }
                else
                {
                    $escripFicha .= " ''," ;
                }    
            }                               
        }
        
        $insertar = "INSERT INTO " . $tabla_data . " VALUES ( null, " . $escripFicha . "  '".Cookie::lenguaje()."', ".$Rec_IdRecurso.", 1)";

        $registrados = $this->_registros->insertarRegistro($insertar);
        
        $this->_view->assign('_mensaje', 'Registrado correctamente');
    }

    public function editarRegistroRecurso($idRegistro, $idTabla, $idRecurso, $fichaEstandar, $tipoEstandarRecurso=false) 
    {
        $tipoEstandarRecurso = $this->filtrarInt($tipoEstandarRecurso);

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

            if($tipoEstandarRecurso==2)
            {
                $tabla = 'variable_'.$tabla;
            }
        }

        $insertar = "UPDATE " . $tabla . " SET " . $escripFicha . " Rec_IdRecurso = " . $idRecurso . " WHERE " . $idTabla . " = " . $idRegistro . "";
        //echo $insertar; exit;
        $this->_registros->insertarRegistro($insertar);
    }

    public function editarRegistroRecursoData($tabla_variable, $idrecurso, $ini, $tabla_data, $idregistro) 
    {
        $fichaVariable = $this->_registros->getFichaVariable($tabla_variable, $idrecurso);

        $escripFicha = '';
        $campo_id = $campo_id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_variable)));
        $campo_id2 = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_data)));
        $campo_nombre = $ini.'_Nombre';
        $campo_tipo = $ini.'_Tipo';

        foreach ($fichaVariable as $ficha) 
        { 
            if(strtolower($ficha[$campo_tipo]) == "numero" || strtolower($ficha[$campo_tipo]) == 'decimal') 
            {
                //$escripFicha .= " " . $_POST[$ficha[$campo_nombre]] . " , ";
                $actualizar = "UPDATE " . $tabla_data . " SET ". $ficha[$campo_nombre]."=".$_POST[$ficha[$campo_nombre]]."". " WHERE " . $campo_id2 . " = " . $idregistro."";  
                
            }
            else
            {
                //$escripFicha .= " '" . $_POST[$ficha[$campo_nombre]] . " ', ";
                $actualizar = "UPDATE " . $tabla_data . " SET ". $ficha[$campo_nombre]."='".$_POST[$ficha[$campo_nombre]]."'". " WHERE " . $campo_id2 . " = " . $idregistro."";  
                
            }
                
            $registrados = $this->_registros->insertarRegistro($actualizar);
        }
        
        $this->_view->assign('_mensaje', 'Registrado correctamente');
    }

    public function _buscarRecursoEstandar() 
    {       
        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');
        $idioma = Cookie::lenguaje();
        
        $recurso = $this->_bdrecursos->getRecursoCompletoXid($id_recurso);
        
        $idestandar = $this->_registros->getEstandarRecurso($id_recurso);
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('recurso', $recurso);

        $estado = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Estado";

        for ($i=0; $i <3 ; $i++) 
        { 
            $campo[$i]=$fichaEstandar[$i]['Fie_ColumnaTabla'];
        }
        
        $condicion = "WHERE Rec_IdRecurso = $recurso and ($campo[0] LIKE '%$palabra%' OR $campo[1] LIKE '%$palabra%' OR $campo[2] LIKE '%$palabra%')";

        $lista = $this->_registros->getListaRegistrosEstandar($fichaEstandar[0]['Fie_NombreTabla'], Cookie::lenguaje(), $condicion);
        //print_r($lista);
        
        $this->_view->assign('columna_estado', $estado);
        $this->_view->assign('nombre_tabla', $fichaEstandar[0]['Fie_NombreTabla']);
        $this->_view->assign('idEstandarRecurso', $idestandar[0]);
        $this->_view->assign('nombre_recurso', $idestandar[1]); 
        $this->_view->assign('datos', $paginador->paginar($lista, "listaregistros", "$id_recurso", 1, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        //$this->_view->assign('titulo', 'Registro Estandar');
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _buscarVariableEstandar() 
    {       
        $this->_view->getLenguaje("bdrecursos_registros");
        $pagina = $this->getInt('pagina');
        $paginadorVariable = new Paginador();
        $palabra = $this->getSql('nombre');
        $idrecurso = $this->getPostParam('id_recurso');
        $Idi_IdIdioma = Cookie::lenguaje();   

        $recurso = $this->_bdrecursos->getRecursoCompletoXid($idrecurso);

        $idEstandarRecurso = $recurso["Esr_IdEstandarRecurso"];
        
        $fichaEstandar = $this->_registros->getFichaEstandar($idEstandarRecurso);

        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'],0,3);                            
        $campo_nombre = $ini.'_Nombre';
        $campo_tipo = $ini.'_Tipo';
        $campo_etiqueta = $ini.'_Etiqueta';
        $campo_estado = $ini.'_Estado';

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            for ($i=0; $i <3 ; $i++) 
            { 
                $campo[$i]=$fichaEstandar[$i]['Fie_ColumnaTabla'];
            }

            $condicion = "AND ($campo[0] LIKE '%$palabra%' OR $campo[1] LIKE '%$palabra%' OR $campo[2] LIKE '%$palabra%')";
        }

        $lista_variable = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $idrecurso, $condicion);

        $this->_view->assign('campo_nombre',$campo_nombre);
        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('campo_estado', $campo_estado);

        $this->_view->assign('lista_variable', $paginadorVariable->paginar($lista_variable, "listaregistrosVariable", "$idrecurso", $pagina, 25));
        $this->_view->assign('numeropaginaVariable', $paginadorVariable->getNumeroPagina());
        $this->_view->assign('paginacionVariable', $paginadorVariable->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginadorVariable->getControlPaginaion());

        $this->_view->renderizar('ajax/listaregistrosVariable', false, true);
    }
           
    public function _buscarCalidadAgua() 
    {
        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');
        $idioma = Cookie::lenguaje();
        $condicion = "and (Var_Nombre LIKE '%$palabra%' OR Var_Abreviatura LIKE '%$palabra%' OR Esm_Nombre LIKE '%$palabra%')";

        $bdcalidadagua = $this->loadModel('monitoreo', 'calidaddeagua');
        $this->_view->assign('calidadagua', $paginador->paginar($bdcalidadagua->getmonitoreoCalidadXidRecurso($id_recurso, $condicion), "metadata_lista_calidadagua", $this->filtrarInt($id_recurso), 1, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/metadata_lista_calidadagua', false, true);
    }

    public function _buscarLegislacion() 
    {
        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');
        $idioma = Cookie::lenguaje();
        $condicion = "and (m.Mal_Titulo LIKE '%$palabra%' OR Mal_ResumenLegislacion LIKE '%$palabra%' OR Mal_Entidad LIKE '%$palabra%' OR Mal_PalabraClave LIKE '%$palabra%' OR Pai_Nombre LIKE '%$palabra%')";

        $bdlegislacion = $this->loadModel('legal', 'legislacion');
        $this->_view->assign('legislacion', $paginador->paginar($bdlegislacion->getLegislacionesMetadata($condicion, $idioma), "metadata_lista_legislacion", $this->filtrarInt($id_recurso), 1, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/metadata_lista_legislacion', false, true);
    }

    public function _buscarDublincore() 
    {
        $this->_view->getLenguaje("bdrecursos_registros");
        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');
        $idioma = Cookie::lenguaje();
        $condicion = " where  Rec_IdRecurso = " . $id_recurso . " and (fn_TraducirContenido('dublincore','Dub_Titulo',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Titulo) LIKE '%$palabra%' OR fn_TraducirContenido('dublincore','Dub_PalabraClave',dub.Dub_IdDublinCore,'$idioma',dub.Dub_PalabraClave) LIKE '%$palabra%' OR fn_TraducirContenido('dublincore','Dub_Descripcion',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Descripcion) LIKE '%$palabra%' OR Aut_Nombre LIKE '%$palabra%')";
        $bddublin = $this->loadModel('documentos', 'dublincore');
        $this->_view->assign('dublin', $paginador->paginar($bddublin->getDocumentosTraducido($condicion, $idioma), "metadata_lista_dublin", $this->filtrarInt($id_recurso), 1, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/metadata_lista_dublin', false, true);
    }

    public function _buscarPlinianCore() 
    {
        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');
        $idioma = Cookie::lenguaje();
        $condicion = "and (Pli_NombreCientifico LIKE '%$palabra%' OR Pli_NombresComunes LIKE '%$palabra%' OR Pli_DescripcionGeneral LIKE '%$palabra%')";

        $bdplinian = $this->loadModel('botanico', 'atlas');
        $this->_view->assign('plinian', $paginador->paginar($bdplinian->getPlinianXRecurso($id_recurso, $condicion), "metadata_lista_plinian", $this->filtrarInt($id_recurso), 1, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/metadata_lista_plinian', false, true);
    }

    public function _buscarDarwinCore() 
    {
        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');
        $idioma = Cookie::lenguaje();
        $condicion = "and (Dar_NombreCientifico LIKE '%$palabra%' OR Dar_NombreComunOrganismo LIKE '%$palabra%' OR Dar_Localidad LIKE '%$palabra%')";

        $bddarwin = $this->loadModel('biodiversidad', true);
        $this->_view->assign('darwin', $paginador->paginar($bddarwin->getDarwinXrecurso($id_recurso, $condicion), "metadata_lista_darwin", $this->filtrarInt($id_recurso), 1, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/metadata_lista_darwin', false, true);
    }

    public function insertarRegistroRecurso($idrecurso, $fichaEstandar, $tipoEstandarRecurso=false) 
    {
        $tipoEstandarRecurso = $this->filtrarInt($tipoEstandarRecurso);
        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'],0,3);
        $campo_nombre = $ini.'_Nombre';
        $campo_tipo = $ini.'_Tipo';

        $escripFicha = ' ';
        
        foreach ($fichaEstandar as $ficha) 
        {
            if ($ficha['Fie_TipoDatoCampo'] == "int" || $ficha['Fie_TipoDatoCampo'] == "double") 
            {
                $escripFicha .= " " . $_POST[$ficha['Fie_ColumnaTabla']] . " , ";
            }

            if ($ficha['Fie_TipoDatoCampo'] == "varchar") 
            {
                $escripFicha .= " '" . $_POST[$ficha['Fie_ColumnaTabla']] . "' , ";
            }

            $tabla = $ficha['Fie_NombreTabla'];

            if ($tipoEstandarRecurso==2) 
            {
               $tabla = 'variable_'.$tabla;                             
            }            
        }

        $insertar = "INSERT INTO " . $tabla . " VALUES ( null, " . $escripFicha . " "
                . " " . $idrecurso . ", '" . Cookie::lenguaje() . "', 1)";
        $this->_registros->insertarRegistro($insertar);        

        if ($tipoEstandarRecurso==2)
        {
            $dato_recurso = $this->_import->getRecurso($idrecurso);
            $tabla_data = $dato_recurso[1];
            $tabla_data_x_recurso = $this->_bdrecursos->getTablaData($tabla_data);

            $fichaVariable = $this->_import->getFichaVariable($tabla, $idrecurso);

            $ultimo_campo = $fichaVariable[count($fichaVariable)-1][$campo_nombre]; 
            
            if(empty($tabla_data_x_recurso))
            {

            }
            else
            {
                if(strtolower($_POST[$campo_tipo]) == "numero")
                {
                    $tipo_campo  = "INT(11)";
                }
                else if(strtolower($_POST[$campo_tipo]) == "fecha")
                {
                    $tipo_campo = "DATE";
                }
                else
                {
                    $tipo_campo  = "VARCHAR(300)";   
                }

                $sql = "ALTER TABLE `".$tabla_data."` add `".$_POST[$campo_nombre]."` ".$tipo_campo." NULL AFTER `".$ultimo_campo."`";
                
                $this->_registros->insertarRegistro($sql);
            }
        }        
    }

    public function _cambiarEstadoCalidadAgua()
    {
        $valor_estado = $this->getInt('valor_estado');
        $id_mca = $this->getInt('id_mca');

        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');

        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();

        $idioma = Cookie::lenguaje();

        //Llamada a modelo Dublin Index
        $bdmonitoreo_index = $this->loadModel('monitoreo', 'calidaddeagua');
        $bdmonitoreo_index->_cambiarEstadoCalidadAgua($id_mca, $valor_estado);

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "and (Var_Nombre LIKE '%$palabra%' OR Var_Abreviatura LIKE '%$palabra%' OR Esm_Nombre LIKE '%$palabra%')"; 
        }   
           
        $bdcalidadagua = $this->loadModel('monitoreo', 'calidaddeagua');
        $this->_view->assign('calidadagua', $paginador->paginar($bdcalidadagua->getmonitoreoCalidadXidRecurso($this->filtrarInt($id_recurso), $condicion), "metadata_lista_calidadagua", $this->filtrarInt($id_recurso), $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/metadata_lista_calidadagua', false, true);
    }

    public function _cambiarEstadoLegislacion()
    {
        $valor_estado = $this->getInt('valor_estado');
        $id_legislacion = $this->getInt('id_legislacion');

        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');

        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();

        $idioma = Cookie::lenguaje();

        $bdmonitoreo_index = $this->loadModel('legal', 'legislacion');
        $bdmonitoreo_index->_cambiarEstadoLegislacion($id_legislacion, $valor_estado);

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "and (m.Mal_Titulo LIKE '%$palabra%' OR Mal_ResumenLegislacion LIKE '%$palabra%' OR Mal_Entidad LIKE '%$palabra%' OR Mal_PalabraClave LIKE '%$palabra%' OR Pai_Nombre LIKE '%$palabra%')";
        }         

        $bdlegislacion = $this->loadModel('legal', 'legislacion');
        $this->_view->assign('legislacion', $paginador->paginar($bdlegislacion->getLegislacionesMetadata($condicion, $idioma), "metadata_lista_legislacion", $id_recurso, $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/metadata_lista_legislacion', false, true);
    }

    public function _cambiarEstadoDublin()
    {
        $valor_estado = $this->getInt('valor_estado');
        $id_dublin = $this->getInt('id_dublin');

        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');

        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();

        $idioma = Cookie::lenguaje();

        $bddublin_index = $this->loadModel('dublin', 'dublincore');
        $bddublin_index->_cambiarEstadoDublin($id_dublin, $valor_estado);

        $bddublin = $this->loadModel('documentos', 'dublincore');
        $condicion = " where  Rec_IdRecurso = " . $id_recurso . " and (fn_TraducirContenido('dublincore','Dub_Titulo',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Titulo) LIKE '%$palabra%' OR fn_TraducirContenido('dublincore','Dub_PalabraClave',dub.Dub_IdDublinCore,'$idioma',dub.Dub_PalabraClave) LIKE '%$palabra%' OR fn_TraducirContenido('dublincore','Dub_Descripcion',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Descripcion) LIKE '%$palabra%' OR Aut_Nombre LIKE '%$palabra%')";

        $this->_view->assign('dublin', $paginador->paginar($bddublin->getDocumentosTraducido($condicion, $idioma), "metadata_lista_dublin", $this->filtrarInt($id_recurso), $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/metadata_lista_dublin', false, true);
    }

    public function _cambiarEstadoPlinian()
    {
        $valor_estado = $this->getInt('valor_estado');
        $id_plinian = $this->getInt('id_plinian');

        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');

        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();

        $idioma = Cookie::lenguaje();

        $bdmonitoreo_index = $this->loadModel('botanico', 'atlas');
        $bdmonitoreo_index->_cambiarEstadoPlinian($id_plinian, $valor_estado);

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "and (Pli_NombreCientifico LIKE '%$palabra%' OR Pli_NombresComunes LIKE '%$palabra%' OR Pli_DescripcionGeneral LIKE '%$palabra%')";
        }
        
        $bdplinian = $this->loadModel('botanico', 'atlas');
        $this->_view->assign('plinian', $paginador->paginar($bdplinian->getPlinianXRecurso($id_recurso, $condicion), "metadata_lista_plinian", $this->filtrarInt($id_recurso), $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/metadata_lista_plinian', false, true);
    }

    public function _cambiarEstadoDarwin()
    {
        $valor_estado = $this->getInt('valor_estado');
        $id_darwin = $this->getInt('id_darwin');

        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');

        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();

        $idioma = Cookie::lenguaje();

        $bddarwin_index = $this->loadModel('biodiversidad', true);
        $bddarwin_index->_cambiarEstadoDarwin($id_darwin, $valor_estado);

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "and (Dar_NombreCientifico LIKE '%$palabra%' OR Dar_NombreComunOrganismo LIKE '%$palabra%' OR Dar_Localidad LIKE '%$palabra%')";
        }        

        $bddarwin = $this->loadModel('biodiversidad', true);
        $this->_view->assign('darwin', $paginador->paginar($bddarwin->getDarwinXrecurso($id_recurso, $condicion), "metadata_lista_darwin", $this->filtrarInt($id_recurso), $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/metadata_lista_darwin', false, true);
    }

    public function _cambiarEstado()
    {
        $this->_view->getLenguaje("bdrecursos_registros");

        $valor_estado = $this->getInt('valor_estado'); 
        $nombre_tabla = $this->getTexto('nombre_tabla'); 
        $columna_estado = $this->getTexto('columna_estado');
        $valor_id=$this->getInt('valor_id');

        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');

        $paginador = new Paginador();

        $idioma = Cookie::lenguaje();

        $columnas = $this->_bdrecursos->getColumnasTabla($nombre_tabla);         

        $this->_bdrecursos->cambiarEstadoRecursoEstandar($nombre_tabla, $columna_estado, $valor_estado, $columnas[0][0], $valor_id);  

        if ($this->botonPress("bt_guardarFichaEstandar")) 
        {
           $this->insertarRegistroRecurso($idrecurso, $fichaEstandar);
        }

        $recurso = $this->_bdrecursos->getRecursoCompletoXid($id_recurso);
        
        $idestandar = $this->_registros->getEstandarRecurso($id_recurso);
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('recurso', $recurso);

        $estado = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Estado";

        //$this->_view->assign('id_estandar', $id_recurso);


        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            for ($i=0; $i <3 ; $i++) 
            { 
                $campo[$i]=$fichaEstandar[$i]['Fie_ColumnaTabla'];
            }

            $condicion = "WHERE Rec_IdRecurso = $recurso and ($campo[0] LIKE '%$palabra%' OR $campo[1] LIKE '%$palabra%' OR $campo[2] LIKE '%$palabra%')";
        }
        
        
        //print_r($lista);
        
        $lista = $this->_registros->getListaRegistrosEstandar($fichaEstandar[0]['Fie_NombreTabla'], Cookie::lenguaje(), $condicion);
        
        $this->_view->assign('columna_estado', $estado);
        $this->_view->assign('nombre_tabla', $fichaEstandar[0]['Fie_NombreTabla']);
        $this->_view->assign('idEstandarRecurso', $idestandar[0]);
        $this->_view->assign('nombre_recurso', $idestandar[1]); 
        $this->_view->assign('datos', $paginador->paginar($lista, "listaregistros", "$id_recurso", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));

        //$this->_view->assign('titulo', 'Registro Estandar');
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }

    public function _cambiarEstadoVariable()
    {        
        $this->_view->getLenguaje("bdrecursos_registros");

        $valor_estado = $this->getInt('valor_estado'); 
        $nombre_tabla = $this->getTexto('nombre_tabla'); 
        $columna_estado = $this->getTexto('columna_estado');
        $valor_id=$this->getInt('valor_id');

        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');

        $paginadorVariable = new Paginador();

        $idioma = Cookie::lenguaje();

        $columnas = $this->_bdrecursos->getColumnasTabla($nombre_tabla);         

        $this->_bdrecursos->cambiarEstadoRecursoEstandar($nombre_tabla, $columna_estado, $valor_estado, $columnas[0][0], $valor_id);  
        
        $idestandar = $this->_registros->getEstandarRecurso($id_recurso);
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        
        $estado = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Estado";

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            for ($i=0; $i <3 ; $i++) 
            { 
                $campo[$i]=$fichaEstandar[$i]['Fie_ColumnaTabla'];
            }

            $condicion = "and ($campo[0] LIKE '%$palabra%' OR $campo[1] LIKE '%$palabra%' OR $campo[2] LIKE '%$palabra%')";
        }
        
        $lista = $this->_registros->getListaRegistrosEstandar($nombre_tabla, Cookie::lenguaje(), $condicion);
        
        $this->_view->assign('columna_estado', $estado);
        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('nombre_tabla1', $nombre_tabla); 
        $this->_view->assign('idestandar', $idestandar[0]);
        $this->_view->assign('nombre_recurso', $idestandar[1]);  
        $this->_view->assign('variables', $paginadorVariable->paginar($lista, "listaregistrosVariable", "".$idestandar[0]."", $pagina, 25));       
        $this->_view->assign('numeropaginaVariable', $paginadorVariable->getNumeroPagina());
        $this->_view->assign('paginacionVariable', $paginadorVariable->getView('paginacion_ajax'));

        $this->_view->renderizar('ajax/listaregistrosVariable', false, true);
    }  

    public function _cambiarEstadoData()
    {     
        $this->_view->getLenguaje("bdrecursos_registros");

        $valor_estado = $this->getInt('valor_estado'); 
        $tabla_data = $this->getTexto('nombre_tabla'); 
        $campo_estado = $this->getTexto('campo_estado');
        $valor_estado = $this->getPostParam('valor_estado');
        $valor_id=$this->getInt('valor_id');

        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');

        $idioma = Cookie::lenguaje();

        $columnas = $this->_bdrecursos->getColumnasTabla($tabla_data); 

        $this->_bdrecursos->cambiarEstadoRecursoEstandar($tabla_data, $campo_estado, $valor_estado, $columnas[0][0], $valor_id);  
        
        $idestandar = $this->_registros->getEstandarRecurso($id_recurso);
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);

        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'],0,3);                        
        $campo_id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_variable)));
        $campo_id2 = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_data)));
        $campo_nombre = $ini.'_Nombre';
        $campo_etiqueta = $ini.'_Etiqueta';
        $campo_tipo = $ini.'_Tipo';
        $campo_estado = $ini.'_Estado';                         
        
        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            for ($i=0; $i <3 ; $i++) 
            { 
                $campo[$i]=$fichaEstandar[$i]['Fie_ColumnaTabla'];
            }

            $condicion = "and ($campo[0] LIKE '%$palabra%' OR $campo[1] LIKE '%$palabra%' OR $campo[2] LIKE '%$palabra%')";
        }

        $paginadorData = new Paginador();
        $pagina = $this->getInt('pagina');
        
        $lista = $this->_registros->getListaRegistrosEstandar($nombre_tabla, Cookie::lenguaje(), $condicion);
        $lista_variable = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $id_recurso);
        $lista_variable2 = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $id_recurso, "Limit 10");
        $lista_data = $this->_bdrecursos->getRegistrosData($tabla_data);
        
        $this->_view->assign('campo_nombre', $campo_nombre);
        $this->_view->assign('campo_etiqueta', $campo_etiqueta);
        $this->_view->assign('campo_estado', $campo_estado);
        $this->_view->assign('lista_variable2', $lista_variable);
        $this->_view->assign('lista_variable3',$lista_variable2);
        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('tabla_data', $tabla_data); 
        $this->_view->assign('idestandar', $idestandar[0]);
        
        $this->_view->assign('lista_data', $paginadorData->paginar($lista_data, "listaregistrosData", "$id_recurso/$tabla_data", $pagina, 25));
        $this->_view->assign('numeropaginaData', $paginadorData->getNumeroPagina());                        
        $this->_view->assign('paginacionData', $paginadorData->getView('paginacion_ajax'));

        $this->_view->renderizar('ajax/listaregistrosData', false, true);
    }    

    public function _eliminarRecurso() 
    {
        $pagina = $this->getInt('pagina');
        $this->_view->getLenguaje("bdrecursos_index");

        $paginador = new Paginador();

        $idrecurso = $this->getInt('idrecurso');
        
        $tipo = $this->getTexto('tipo');
        $nombre = $this->getTexto('nombre');
        $estandar = $this->getInt('estandar');
        $fuente = $this->getTexto('fuente');
        $origen = $this->getTexto('origen');
        $herramienta = $this->getInt('herramienta');

        $this->_bdrecursos->eliminarRecurso($idrecurso);

        $this->_view->assign('nombre', $nombre);
        $this->_view->assign('sl_estandar', $estandar);
        $this->_view->assign('sl_fuente', $fuente);
        $this->_view->assign('sl_origen', $origen);
        $this->_view->assign('sl_herramienta', $herramienta);

        $bdherramienta = $this->loadModel('herramienta');
        $this->_view->assign('tiporecurso', $this->_bdrecursos->getTipoRecurso());
        $this->_view->assign('origenrecurso', $this->_bdrecursos->getOrigenRecurso());
        $this->_view->assign('fuente', $this->_bdrecursos->getFuente());
        $this->_view->assign('herramientas', $bdherramienta->getHerramienta());
        $this->_view->assign('estandar', $this->_bdrecursos->getEstandar());

        $this->_view->assign('numeropagina', $pagina);
        $this->_view->assign('registros', $paginador->paginar($this->_bdrecursos->getRecursosCompleto($tipo, $nombre, $estandar, $fuente, $origen, $herramienta), "lista_recursos", "", $pagina, 25));

        //$this->_view->assign("variables", $paginador->paginar($this->_mapa->VariablesPorEstacion($this->filtrarInt($idestacion), ""), "estacion_lista_variables", $this->filtrarInt($idestacion), $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/lista_recursos', false, true);
    }

    public function _eliminarCalidadAgua() 
    {
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');
        $id_mca = $this->getInt('id_mca');
        
        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();

        $idioma = Cookie::lenguaje();

        //Llamada a modelo Dublin Index
        $bdmonitoreo_index = $this->loadModel('monitoreo', 'calidaddeagua');
        $bdmonitoreo_index->eliminarCalidadAgua($id_mca);

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "and (Var_Nombre LIKE '%$palabra%' OR Var_Abreviatura LIKE '%$palabra%' OR Esm_Nombre LIKE '%$palabra%')"; 
        }   
           
        $bdcalidadagua = $this->loadModel('monitoreo', 'calidaddeagua');
        $this->_view->assign('calidadagua', $paginador->paginar($bdcalidadagua->getmonitoreoCalidadXidRecurso($this->filtrarInt($id_recurso), $condicion), "metadata_lista_calidadagua", $this->filtrarInt($id_recurso), $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/metadata_lista_calidadagua', false, true);
    }

    public function _eliminarLegislacion()
    {
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');
        $id_legislacion = $this->getInt('id_legislacion');
        
        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();

        $idioma = Cookie::lenguaje();

        //Llamada a modelo Legislacion Index
        $bdmonitoreo_index = $this->loadModel('legal', 'legislacion');
        $bdmonitoreo_index->eliminarLegislacion($id_legislacion);

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "and (m.Mal_Titulo LIKE '%$palabra%' OR Mal_ResumenLegislacion LIKE '%$palabra%' OR Mal_Entidad LIKE '%$palabra%' OR Mal_PalabraClave LIKE '%$palabra%' OR Pai_Nombre LIKE '%$palabra%')";
        }         

        $bdlegislacion = $this->loadModel('legal', 'legislacion');
        $this->_view->assign('legislacion', $paginador->paginar($bdlegislacion->getLegislacionesMetadata($condicion, $idioma), "metadata_lista_legislacion", $id_recurso, $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/metadata_lista_legislacion', false, true);
    }

    public function _eliminarPlinian() 
    {
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');
        $id_plinian = $this->getInt('id_plinian');
        
        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();

        $idioma = Cookie::lenguaje();

        //Llamada a modelo Dublin Index
        $bdmonitoreo_index = $this->loadModel('botanico', 'atlas');
        $bdmonitoreo_index->eliminarPlinian($id_plinian);

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "and (Pli_NombreCientifico LIKE '%$palabra%' OR Pli_NombresComunes LIKE '%$palabra%' OR Pli_DescripcionGeneral LIKE '%$palabra%')";
        }

        $bdplinian = $this->loadModel('botanico', 'atlas');
        $this->_view->assign('plinian', $paginador->paginar($bdplinian->getPlinianXRecurso($id_recurso, $condicion), "metadata_lista_plinian", $this->filtrarInt($id_recurso), $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/metadata_lista_plinian', false, true);
    }

    public function _eliminarDublincore() 
    {
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');
        $id_dublin = $this->getInt('id_dublin');

        if (!empty($pagina) && !empty($id_recurso) && !empty($id_dublin)) 
        {
            $this->_view->getLenguaje("bdrecursos_registros");

            $paginador = new Paginador();

            $idioma = Cookie::lenguaje();

            //Llamada a modelo Dublin Index
            $bddublin_index = $this->loadModel('dublin', 'dublincore');
            $bddublin_index->eliminarDublincCoreCompleto($id_dublin);

            $bddublin = $this->loadModel('documentos', 'dublincore');
            $condicion = " where  Rec_IdRecurso = " . $id_recurso . " and (fn_TraducirContenido('dublincore','Dub_Titulo',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Titulo) LIKE '%$palabra%' OR fn_TraducirContenido('dublincore','Dub_PalabraClave',dub.Dub_IdDublinCore,'$idioma',dub.Dub_PalabraClave) LIKE '%$palabra%' OR fn_TraducirContenido('dublincore','Dub_Descripcion',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Descripcion) LIKE '%$palabra%' OR Aut_Nombre LIKE '%$palabra%')";

            $this->_view->assign('dublin', $paginador->paginar($bddublin->getDocumentosTraducido($condicion, $idioma), "metadata_lista_dublin", $this->filtrarInt($id_recurso), $pagina, 25));
            $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
            $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
            $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
            $this->_view->renderizar('ajax/metadata_lista_dublin', false, true);
        }
        else
        {
            echo "Faltan Parametros";
        }
    }

    public function _eliminarDarwinCore() 
    {
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');
        $id_darwin = $this->getInt('id_darwin');
        
        $this->_view->getLenguaje("bdrecursos_registros");

        $paginador = new Paginador();

        $idioma = Cookie::lenguaje();

        //Llamada a modelo Darwin Index
        $bddarwin_index = $this->loadModel('biodiversidad', true);
        $bddarwin_index->eliminarDarwinCore($id_darwin);

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "and (Dar_NombreCientifico LIKE '%$palabra%' OR Dar_NombreComunOrganismo LIKE '%$palabra%' OR Dar_Localidad LIKE '%$palabra%')";
        }        

        $bddarwin = $this->loadModel('biodiversidad', true);
        $this->_view->assign('darwin', $paginador->paginar($bddarwin->getDarwinXrecurso($id_recurso, $condicion), "metadata_lista_darwin", $this->filtrarInt($id_recurso), $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/metadata_lista_darwin', false, true);        
    }

    public function _eliminarEstandarxRecurso()
    {
        $this->_view->getLenguaje("bdrecursos_registros");

        $valor_id = $this->getInt('valor_id'); 
        $id_recurso_estandar = $this->getInt('id_recurso_estandar');
        
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');

        $paginador = new Paginador();

        $tabla = $this->_bdrecursos->getTablaXIdEstandarRecurso($id_recurso_estandar);
        $nombre_tabla=$tabla[0]['Fie_NombreTabla'];
               
        $columnas = $this->_bdrecursos->getColumnasTabla($tabla[0]['Fie_NombreTabla']);
       

        $this->_bdrecursos->eliminarEstandarxRecurso($valor_id, $nombre_tabla, $columnas[0][0]); 

        if ($this->botonPress("bt_guardarFichaEstandar")) 
        {
           $this->insertarRegistroRecurso($idrecurso, $fichaEstandar);
        }

        $recurso = $this->_bdrecursos->getRecursoCompletoXid($id_recurso);
        
        $idestandar = $this->_registros->getEstandarRecurso($id_recurso);
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('recurso', $recurso);

        $estado = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Estado";

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            for ($i=0; $i <3 ; $i++) 
            { 
                $campo[$i]=$fichaEstandar[$i]['Fie_ColumnaTabla'];
            }

            $condicion = "and ($campo[0] LIKE '%$palabra%' OR $campo[1] LIKE '%$palabra%' OR $campo[2] LIKE '%$palabra%')";
        }
        
        $lista = $this->_registros->getListaRegistrosEstandar($fichaEstandar[0]['Fie_NombreTabla'], Cookie::lenguaje(), $condicion);        
        
        $this->_view->assign('columna_estado', $estado);
        $this->_view->assign('nombre_tabla', $fichaEstandar[0]['Fie_NombreTabla']);

        $this->_view->assign('idEstandarRecurso', $idestandar[0]);
        $this->_view->assign('nombre_recurso', $idestandar[1]); 
        $this->_view->assign('datos', $paginador->paginar($lista, "listaregistros", "$id_recurso", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        //$this->_view->assign('titulo', 'Registro Estandar');
        $this->_view->renderizar('ajax/listaregistros', false, true);           
    }

    public function _eliminarEstandarxRecursoVariable()
    {
        $this->_view->getLenguaje("bdrecursos_registros");

        $valor_id = $this->getInt('valor_id'); 
        $id_recurso_estandar = $this->getInt('id_recurso_estandar');
        
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');

        $idestandar = $this->_registros->getEstandarRecurso($id_recurso);
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        
        $paginadorVariable = new Paginador();

        $tabla = $this->_bdrecursos->getTablaXIdEstandarRecurso($id_recurso_estandar);
        $nombre_tabla='variable_'.$tabla[0]['Fie_NombreTabla'];
        $nombre_tabla2 = 'data_'.$tabla[0]['Fie_NombreTabla'];
               
        $columnas = $this->_bdrecursos->getColumnasTabla($nombre_tabla);  

        $estado = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Estado";
        $campo_id = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $nombre_tabla)));

        $script = "DELETE FROM $nombre_tabla2 WHERE $campo_id = $valor_id";   

        $this->_registros->insertarRegistro($script);

        //$this->_bdrecursos->eliminarEstandarxRecurso($valor_id, $nombre_tabla, $campo_id); 

        $script2 = "DELETE FROM $nombre_tabla WHERE $campo_id = $valor_id"; 

        $this->_registros->insertarRegistro($script2);

        $recurso = $this->_bdrecursos->getRecursoCompletoXid($id_recurso);
        
        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            for ($i=0; $i <3 ; $i++) 
            { 
                $campo[$i]=$fichaEstandar[$i]['Fie_ColumnaTabla'];
            }

            $condicion = "and ($campo[0] LIKE '%$palabra%' OR $campo[1] LIKE '%$palabra%' OR $campo[2] LIKE '%$palabra%')";
        }

        $lista = $this->_registros->getListaRegistrosEstandar($nombre_tabla, Cookie::lenguaje(), $condicion);        
        $this->_view->assign('recurso', $recurso);
        $this->_view->assign('columna_estado', $estado);
        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('nombre_tabla1', $nombre_tabla); 
        $this->_view->assign('variables', $paginadorVariable->paginar($lista, "listaregistrosVariable", "".$idestandar[0]."", $pagina, 25));
        $this->_view->assign('nombre_tabla', $fichaEstandar[0]['Fie_NombreTabla']);
        $this->_view->assign('idestandar', $idestandar[0]);
        $this->_view->assign('nombre_recurso', $idestandar[1]); 
        $this->_view->assign('numeropaginaVariable', $paginadorVariable->getNumeroPagina());
        $this->_view->assign('paginacionVariable', $paginadorVariable->getView('paginacion_ajax'));

        //$this->_view->assign('titulo', 'Registro Estandar');
        $this->_view->renderizar('ajax/listaregistrosVariable', false, true);          
    }

    public function _eliminarEstandarxRecursoData()
    {
        $this->_view->getLenguaje("bdrecursos_registros");

        $valor_id = $this->getInt('valor_id'); 
        $id_recurso_estandar = $this->getInt('id_recurso_estandar');        
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $id_recurso = $this->getInt('id_recurso');
        $tabla_data = $this->getSql('nombre_tabla');

        $idestandar = $this->_registros->getEstandarRecurso($id_recurso);
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        
        $paginadorVariable = new Paginador();

        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3); 
        
        $campo_id2 = $ini. "_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_data)));
        
        $script = "DELETE FROM $tabla_data WHERE $campo_id2 = $valor_id";   

        $this->_registros->insertarRegistro($script);

        //$this->_bdrecursos->eliminarEstandarxRecurso($valor_id, $nombre_tabla, $campo_id); 

        $recurso = $this->_bdrecursos->getRecursoCompletoXid($id_recurso);
        
        $campo_id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_variable)));
        $campo_id2 = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_data)));
        $campo_nombre = $ini.'_Nombre';
        $campo_etiqueta = $ini.'_Etiqueta';
        $campo_tipo = $ini.'_Tipo';
        $campo_estado = $ini.'_Estado';                         
        
        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            for ($i=0; $i <3 ; $i++) 
            { 
                $campo[$i]=$fichaEstandar[$i]['Fie_ColumnaTabla'];
            }

            $condicion = "and ($campo[0] LIKE '%$palabra%' OR $campo[1] LIKE '%$palabra%' OR $campo[2] LIKE '%$palabra%')";
        }

        $paginadorData = new Paginador();
        $pagina = $this->getInt('pagina');
        
        $lista = $this->_registros->getListaRegistrosEstandar($nombre_tabla, Cookie::lenguaje(), $condicion);
        $lista_variable = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $id_recurso);
        $lista_variable2 = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $id_recurso, "Limit 10");
        $lista_data = $this->_bdrecursos->getRegistrosData($tabla_data);
        
        $this->_view->assign('campo_nombre', $campo_nombre);
        $this->_view->assign('campo_etiqueta', $campo_etiqueta);
        $this->_view->assign('campo_estado', $campo_estado);
        $this->_view->assign('lista_variable2', $lista_variable);
        $this->_view->assign('lista_variable3',$lista_variable2);
        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('tabla_data', $tabla_data); 
        $this->_view->assign('idestandar', $idestandar[0]);
        
        $this->_view->assign('lista_data', $paginadorData->paginar($lista_data, "listaregistrosData", "$id_recurso/$tabla_data", $pagina, 25));
        $this->_view->assign('numeropaginaData', $paginadorData->getNumeroPagina());                        
        $this->_view->assign('paginacionData', $paginadorData->getView('paginacion_ajax'));

        $this->_view->renderizar('ajax/listaregistrosData', false, true);      
    }

    public function _paginacion_listaregistros($idrecurso = false) 
    {        
        $this->_view->getLenguaje("bdrecursos_registros");
        $pagina = $this->getInt('pagina');
        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        $idioma = Cookie::lenguaje();

        $recurso = $this->_bdrecursos->getRecursoCompletoXid($idrecurso);

        $idrecurso = $this->filtrarInt($idrecurso);
        $idestandar = $this->_registros->getEstandarRecurso($idrecurso);
        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('recurso', $recurso);
        
        if ($this->botonPress("bt_guardarFichaEstandar")) 
        {
           $this->insertarRegistroRecurso($idrecurso, $fichaEstandar);
        }

        $estado = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3) . "_Estado";
        
        $this->_view->assign('id_estandar', $idrecurso);

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            for ($i=0; $i <3 ; $i++) 
            { 
                $campo[$i]=$fichaEstandar[$i]['Fie_ColumnaTabla'];
            }

            $condicion = "WHERE Rec_IdRecurso = $recurso and ($campo[0] LIKE '%$palabra%' OR $campo[1] LIKE '%$palabra%' OR $campo[2] LIKE '%$palabra%')";
        }

        $lista = $this->_registros->getListaRegistrosEstandar($fichaEstandar[0]['Fie_NombreTabla'], 
        Cookie::lenguaje(), $condicion);
        
        $this->_view->assign('columna_estado', $estado);
        $this->_view->assign('nombre_tabla', $fichaEstandar[0]['Fie_NombreTabla']);
        $this->_view->assign('idEstandarRecurso', $idestandar[0]);
        $this->_view->assign('nombre_recurso', $idestandar[1]); 
        $this->_view->assign('datos', $paginador->paginar($lista, "listaregistros", "$idrecurso", $pagina, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));

        $this->_view->renderizar('ajax/listaregistros', false, true);        
    }

    public function _paginacion_listaregistrosVariable($idrecurso = false)
    {
        $this->_view->getLenguaje("bdrecursos_registros");
        $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('nombre');
        $Idi_IdIdioma = Cookie::lenguaje();   
        
        $idrecurso = $this->filtrarInt($idrecurso);
        $idestandar = $this->_registros->getEstandarRecurso($idrecurso);

        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'],0,3);                            
        $campo_nombre = $ini.'_Nombre';
        $campo_tipo = $ini.'_Tipo';
        $campo_etiqueta = $ini.'_Etiqueta';
        $campo_estado = $ini.'_Estado';

        $paginadorVariable = new Paginador();
        $pagina = $this->getInt('pagina');

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            for ($i=0; $i <3 ; $i++) 
            { 
                $campo[$i]=$fichaEstandar[$i]['Fie_ColumnaTabla'];
            }

            $condicion = "AND ($campo[0] LIKE '%$palabra%' OR $campo[1] LIKE '%$palabra%' OR $campo[2] LIKE '%$palabra%')";
        }

        $lista_variable = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $idrecurso, $condicion);
        
        $this->_view->assign('campo_nombre',$campo_nombre);
        $this->_view->assign('campo_tipo',$campo_tipo);
        $this->_view->assign('campo_etiqueta', $campo_etiqueta);
        $this->_view->assign('campo_estado', $campo_estado);
        $this->_view->assign('idEstandarRecurso', $idEstandarRecurso);
        $this->_view->assign('ficha', $fichaEstandar);
        $this->_view->assign('nombre_tabla1', 'variable_'.$fichaEstandar[0]['Fie_NombreTabla']);

        $this->_view->assign('lista_variable', $paginadorVariable->paginar($lista_variable, "listaregistrosVariable", "$idrecurso", $pagina, 25));
        $this->_view->assign('numeropaginaVariable', $paginadorVariable->getNumeroPagina());
        $this->_view->assign('paginacionVariable', $paginadorVariable->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginadorVariable->getControlPaginaion());

        $this->_view->renderizar('ajax/listaregistrosVariable', false, true);
    }

    public function _paginacion_listaregistrosData($idrecurso=false, $tabla_data='')
    {
        $this->_view->getLenguaje("bdrecursos_registros");
        
        $palabra = $this->getSql('nombre');
        $Idi_IdIdioma = Cookie::lenguaje();   
        $idrecurso = $this->filtrarInt($idrecurso);

        $recurso = $this->_bdrecursos->getRecursoCompletoXid($idrecurso);
        
        $idestandar = $this->_registros->getEstandarRecurso($idrecurso);

        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        $lista_variable = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $idrecurso);   
        $lista_variable2 = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $idrecurso, "Limit 10");
        $lista_data = $this->_bdrecursos->getRegistrosData($tabla_data); 

        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'],0,3);
        $campo_id2 = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_data)));                            
        $campo_nombre = $ini.'_Nombre';
        $campo_tipo = $ini.'_Tipo';
        $campo_etiqueta = $ini.'_Etiqueta';
        $campo_estado = $ini.'_Estado';   

        $paginadorData = new Paginador();
        $pagina = $this->getInt('pagina');

        $this->_view->assign('recurso', $recurso);
        $this->_view->assign('campo_id2', $campo_id2);
        $this->_view->assign('campo_nombre',$campo_nombre);
        $this->_view->assign('campo_etiqueta',$campo_etiqueta);
        $this->_view->assign('campo_estado', $campo_estado);
        $this->_view->assign('lista_variable2', $lista_variable);
        $this->_view->assign('lista_variable3',$lista_variable2);
        $this->_view->assign('tabla_data', $tabla_data);
        $this->_view->assign('lista_data', $paginadorData->paginar($lista_data, "listaregistrosData", "$idrecurso/$tabla_data", $pagina, 25));
        $this->_view->assign('numeropaginaData', $paginadorData->getNumeroPagina());                        
        $this->_view->assign('paginacionData', $paginadorData->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistrosData', false, true);
    }
     
    public function _paginacion_metadata_lista_calidadagua($recurso = false) 
    {
        $this->_view->getLenguaje("bdrecursos_registros");
        $pagina = $this->getInt('pagina');
        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        $idioma = Cookie::lenguaje();
        
       // $recurso = $this->_bdrecursos->getRecursoCompletoXid($idrecurso);
        //$this->_view->assign('recurso', $recurso
        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "and (Var_Nombre LIKE '%$palabra%' OR Var_Abreviatura LIKE '%$palabra%' OR Esm_Nombre LIKE '%$palabra%')"; 
        }   
           

        $bdcalidadagua = $this->loadModel('monitoreo', 'calidaddeagua');
        $this->_view->assign('calidadagua', $paginador->paginar($bdcalidadagua->getmonitoreoCalidadXidRecurso($this->filtrarInt($recurso), $condicion), "metadata_lista_calidadagua", $this->filtrarInt($recurso), $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/metadata_lista_calidadagua', false, true);
    }

    public function _paginacion_metadata_lista_legislacion($idrecurso = false) 
    {
        $this->_view->getLenguaje("bdrecursos_registros");
        $pagina = $this->getInt('pagina');
        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        $idioma = Cookie::lenguaje();

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "and (m.Mal_Titulo LIKE '%$palabra%' OR Mal_ResumenLegislacion LIKE '%$palabra%' OR Mal_Entidad LIKE '%$palabra%' OR Mal_PalabraClave LIKE '%$palabra%' OR Pai_Nombre LIKE '%$palabra%')";
        }         

        $bdlegislacion = $this->loadModel('legal', 'legislacion');
        $this->_view->assign('legislacion', $paginador->paginar($bdlegislacion->getLegislacionesMetadata($condicion, $idioma), "metadata_lista_legislacion", $idrecurso, $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/metadata_lista_legislacion', false, true);        
    }

    public function _paginacion_metadata_lista_dublin($recurso = false) 
    {
        $this->_view->getLenguaje("bdrecursos_registros");
        $pagina = $this->getInt('pagina');
        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        $idioma = Cookie::lenguaje();
        $condicion = " where  Rec_IdRecurso = " . $this->filtrarInt($recurso) . " and (fn_TraducirContenido('dublincore','Dub_Titulo',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Titulo) LIKE '%$palabra%' OR fn_TraducirContenido('dublincore','Dub_PalabraClave',dub.Dub_IdDublinCore,'$idioma',dub.Dub_PalabraClave) LIKE '%$palabra%' OR fn_TraducirContenido('dublincore','Dub_Descripcion',dub.Dub_IdDublinCore,'$idioma',dub.Dub_Descripcion) LIKE '%$palabra%' OR Aut_Nombre LIKE '%$palabra%')";

        $bddublin = $this->loadModel('documentos', 'dublincore');
        $this->_view->assign('dublin', $paginador->paginar($bddublin->getDocumentosTraducido($condicion, Cookie::lenguaje()), "metadata_lista_dublin", $this->filtrarInt($recurso), $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/metadata_lista_dublin', false, true);
    }

    public function _paginacion_metadata_lista_plinian($idrecurso = false) 
    {
        $this->_view->getLenguaje("bdrecursos_registros");
        $pagina = $this->getInt('pagina');
        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        $idioma = Cookie::lenguaje();
        
        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "and (Pli_NombreCientifico LIKE '%$palabra%' OR Pli_NombresComunes LIKE '%$palabra%' OR Pli_DescripcionGeneral LIKE '%$palabra%')";
        }
        
        $bdplinian = $this->loadModel('botanico', 'atlas');
        $this->_view->assign('plinian', $paginador->paginar($bdplinian->getPlinianXRecurso($idrecurso, $condicion), "metadata_lista_plinian", $this->filtrarInt($idrecurso), $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/metadata_lista_plinian', false, true);                
    }

    public function _paginacion_metadata_lista_darwin($idrecurso = false) 
    {
        $this->_view->getLenguaje("bdrecursos_registros");        
        $pagina = $this->getInt('pagina');
        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        $idioma = Cookie::lenguaje();

        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "and (Dar_NombreCientifico LIKE '%$palabra%' OR Dar_NombreComunOrganismo LIKE '%$palabra%' OR Dar_Localidad LIKE '%$palabra%')";
        }
        
        $bddarwin = $this->loadModel('biodiversidad', true);
        $this->_view->assign('darwin', $paginador->paginar($bddarwin->getDarwinXrecurso($idrecurso, $condicion), "metadata_lista_darwin", $this->filtrarInt($idrecurso), $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/metadata_lista_darwin', false, true);
    }

    //Para mostrar luego del visor

    public function opinionpublica($arg1='', $arg2=false, $arg3=false)
    {
        header("access-control-allow-origin: *");

        $this->_view->setJs(array(
            array('http://code.highcharts.com/highcharts.js', false), //agregado
            array('http://code.highcharts.com/modules/exporting.js', false), //agregado
            array(BASE_URL . "views/herramienta/js/torta_reporte.js", false),   
            "registros"
        ));

        $this->_acl->autenticado();
        $this->validarUrlIdioma();
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->assign('titulo', 'Detalle Respuestas | SIIGEF');
        $this->_share = $this->loadModel('share');

        $id_recurso = $this->filtrarInt($arg3);
        $id_variable = $this->filtrarInt($arg2);

        $recurso = $this->_bdrecursos->getRecursoCompletoXid($id_recurso);

        $idEstandarRecurso = $recurso["Esr_IdEstandarRecurso"];

        $ficha = $this->_share->getFichaEstandarXIdEstandar($idEstandarRecurso); 
        
        $ini = substr($ficha[0]['Fie_ColumnaTabla'],0,3);
        $nombre_tabla1 = 'variable_'.$ficha[0]['Fie_NombreTabla'];
        
        $dato_recurso = $this->_import->getRecurso($id_recurso);
        $tabla_data = $dato_recurso[1];

        $campo_id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $nombre_tabla1)));
        $campo_valor = $ini.'_Valor';
        $campo_latitud = $ini.'_Latitud';
        $campo_longitud = $ini.'_Longitud';
        $campo_estado = $ini.'_Estado';
        $campo_nombre = $ini.'_Nombre';
        //$campo_id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ','data_'.$ficha[0]['Fie_NombreTabla'])));

        $campo_subtema=$ini.'_Subtema';  

        $variable = $this->_share->getTablaVariable($ficha[0]['Fie_NombreTabla'], $id_recurso, "AND $campo_id=".$id_variable.""); 

        $paginador = new Paginador();

        $data = $this->_share->getTablaData($tabla_data);

        $datos = $this->_registros->perfilEstandarGenericoXId($variable[0][$campo_subtema], $nombre_tabla1, $campo_subtema, $variable[0][$campo_latitud], $variable[0][$campo_longitud], $campo_id, $id_variable, $campo_latitud, $campo_longitud, $campo_estado);
       
        $resultado=$this->_registros->getCantidadPorColumna($tabla_data, $datos[0][$campo_nombre]);
        $datos[0]['resultado']=$resultado; 

        $nombre_pregunta = $variable[0][$campo_nombre];

        $this->_view->assign('nombre_pregunta', $nombre_pregunta);
        $this->_view->assign('respuestas', $paginador->paginar($data,"lista_respuesta", "$id_recurso/$nombre_pregunta", 1,25));
        $this->_view->assign('paginacion_respuesta', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion_respuesta', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_respuesta', $paginador->getNumeroPagina());  
        
        $this->_view->assign('campo_nombre', $campo_nombre);
        $this->_view->assign('campo_etiqueta', $ini.'_Etiqueta');
        $this->_view->assign('campo_tema', $ini.'_Tema');
        $this->_view->assign('campo_subtema', $ini.'_Subtema');
        $this->_view->assign('campo_pais', $ini.'_Pais');
        $this->_view->assign('campo_latitud', $campo_latitud);
        $this->_view->assign('campo_longitud', $campo_longitud);
        $this->_view->assign('campo_valor', $campo_valor);
        
        #$this->_view->assign('id_estandar', $estandar['Esr_IdEstandarRecurso']);
        $this->_view->assign('subtema',str_replace(' ', '_', strtolower($datos[0][4])));
        $this->_view->assign('dato', $datos[0]);
        #$this->_view->assign('tabla', $fichaEstandar[0]['Fie_NombreTabla']);
        $this->_view->assign('paginacion_datos', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', 1);   
        $this->_view->assign('variable', $variable);
        $this->_view->renderizar('fichaPregunta', 'registros');
    }

    public function _paginacion_lista_respuesta($id_recurso=false, $nombre_pregunta = '') 
    {
        $this->_acl->autenticado();
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->assign('titulo', 'Detalle Pregunta');
        $this->_view->setJs(array('registros'));

        $this->_share = $this->loadModel('share');
        $id_recurso = $this->filtrarInt($id_recurso);

        $dato_recurso = $this->_import->getRecurso($id_recurso);
        
        $tabla_data = $dato_recurso[1];

        $data = $this->_share->getTablaData($tabla_data);

        $paginador = new Paginador();
        $pagina = $this->getInt('pagina');
        
        $this->_view->assign('nombre_pregunta', $nombre_pregunta);
        $this->_view->assign('respuestas', $paginador->paginar($data, "lista_respuesta", "$id_recurso/$nombre_pregunta", $pagina,25));
        $this->_view->assign('paginacion_respuesta', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion_respuesta', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_respuesta', $paginador->getNumeroPagina());  
        
        $this->_view->renderizar('ajax/lista_respuesta', false, true);
    }

    public function _paginacion_metadata_registros($idrecurso=false, $valorid=false)
    {
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->getLenguaje("estandar_metadata");

        $idrecurso = $this->filtrarInt($idrecurso);
        $valorid = $this->filtrarInt($valorid);

        $idestandar = $this->_registros->getEstandarRecurso($idrecurso);

        $fichaEstandar = $this->_registros->getFichaEstandar($idestandar[0]);
        $nombre_tabla = ucwords(str_replace(array(' ','_'), ' ', $fichaEstandar[0]['Fie_NombreTabla']));

        $dato_recurso = $this->_import->getRecurso($idrecurso);

        $tabla_variable = 'variable_'.$fichaEstandar[0]['Fie_NombreTabla'];
        $tabla_data = $dato_recurso[1];
        
        $paginador = new Paginador();
        $pagina = $this->getInt('pagina');

        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3);
        $lista_variable = $this->_share->getTablaVariable($fichaEstandar[0]['Fie_NombreTabla'], $idrecurso); 

        $campo_id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_variable)));
        $campo_id2 = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $tabla_data)));
        $campo_nombre = $ini."_Nombre";
        $campo_etiqueta = $ini.'_Etiqueta';
        $lista_data = $this->_bdrecursos->getRegistrosData($tabla_data, "WHERE $campo_id2 = $valorid");

        $this->_view->assign('respuesta', 1);
        $this->_view->assign('campo_nombre', $campo_nombre);
        $this->_view->assign('campo_etiqueta', $campo_etiqueta);

        $this->_view->assign('lista_variable', $paginador->paginar($lista_variable, "metadata_registros", "$idrecurso/$valorid", $pagina, 25));
        $this->_view->assign('lista_data', $lista_data);
        $this->_view->assign('nombre_tabla', $nombre_tabla);

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->renderizar('ajax/metadata_registros', false, true);
    }
}
?>