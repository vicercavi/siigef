<?php

class indexController extends estandarController
{
    private $_estandar;    
    private $_tablas;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_estandar = $this->loadModel('index');
        $this->_registros = $this->loadModel('registros');
        
        $this->_tablas = $this->_estandar->getTablasBD();
    }

    public function index() 
    {
        $this->_acl->acceso('listar_estandar');
        $this->validarUrlIdioma();        
        $this->_view->getLenguaje("estandar_index");
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('index'));
        
        if ($this->botonPress("bt_guardar")) 
        {
            $this->registrarEstandarRecurso();
        }

        $paginador = new Paginador();

        $this->_view->assign('datos', $paginador->paginar($this->_estandar->getEstandar_recurso(), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('titulo', 'Lista de Estandares');
        
        $this->_view->renderizar('index', 'Estandar');        
    }
    
    public function _eliminarEstandar()
    {   
        $this->_view->getLenguaje("estandar_index");
        $this->_view->getLenguaje("index_inicio");

        $Esr_NombreTabla = $this->getSql('Esr_NombreTabla');
        $Esr_IdEstandarRecurso = $this->getSql('Esr_IdEstandarRecurso');
        $i=0;        
        $tablasGeneradas = $this->_estandar->getTablasGeneradas();
        //print_r($this->_estandar->getTablasBD()); exit();

        foreach ($tablasGeneradas as $t)
        {
            if(in_array($Esr_NombreTabla, $t))
            {                
                $i=1;
            }            
        }

        if($i==1)
        {
            $registros = $this->_estandar->consultaEstandar($Esr_NombreTabla);
            
            if(!isset($registros) || count($registros)==0)
            {
                $scriptEliminarFicha = "DELETE FROM ficha_estandar WHERE Esr_IdEstandarRecurso = $Esr_IdEstandarRecurso";   
                $this->_estandar->generarTablaEstandar($scriptEliminarFicha);
                $scriptEliminarEstandar = "DELETE FROM estandar_recurso WHERE Esr_IdEstandarRecurso = $Esr_IdEstandarRecurso";   
                $this->_estandar->generarTablaEstandar($scriptEliminarEstandar);    
                $scriptEliminarTabla = "DROP TABLE $Esr_NombreTabla";   
                $this->_estandar->generarTablaEstandar($scriptEliminarTabla); 
                $this->_view->assign('_mensaje', "Estandar eliminado correctamente");
            } 
            else 
            {
                $this->_view->assign('_error', "Estandar no se puede eliminar porque tiene registro");
            } 

        } 
        else 
        {
            $scriptEliminarFicha = "DELETE FROM ficha_estandar WHERE Esr_IdEstandarRecurso = $Esr_IdEstandarRecurso";   
            $this->_estandar->generarTablaEstandar($scriptEliminarFicha);
            $scriptEliminarEstandar = "DELETE FROM estandar_recurso WHERE Esr_IdEstandarRecurso = $Esr_IdEstandarRecurso";   
            $this->_estandar->generarTablaEstandar($scriptEliminarEstandar);                
            $this->_view->assign('_mensaje', "Estandar eliminado correctamente");
        }
        
        $paginador = new Paginador();
        $this->_view->assign('datos', $paginador->paginar($this->_estandar->getEstandar_recurso(), "listaregistros", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
       // echo 'hola';exit;
    }
    
    public function _paginacion_listaregistros($palabra = "") 
    {
        //$this->validarUrlIdioma();
        $pagina = $this->getInt('pagina');
        //$registros = $this->getInt('registros');
        //$palabra = $this->getSql('palabra');
        $condicion = "";

        if($palabra)
        {
            $condicion = " WHERE Esr_Nombre LIKE '%".$palabra."%'";            
        }
        
        $paginador = new Paginador();
        
        $this->_view->assign('datos', $paginador->paginar($this->_estandar->getEstandar_recurso($condicion), "listaregistros", "$palabra", $pagina, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function _buscarEstandar($nombre = false) 
    {
        //$this->validarUrlIdioma();
        // $pagina = $this->getInt('pagina');
        $palabra = $this->getSql('palabra');
        $condicion = " WHERE Esr_Nombre LIKE '%".$palabra."%'";
        
        $paginador = new Paginador();
        //$r = $this->_estandar->getEstandar_recurso($condicion);
        //print_r($r);exit;
        $this->_view->assign('datos', $paginador->paginar($this->_estandar->getEstandar_recurso($condicion), "listaregistros", "$palabra", false, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistros', false, true);
    }
    
    public function registrarEstandarRecurso() 
    {        
        $i=0;
        $error = ""; $error1 = ""; 

        $nombreTabla = str_replace(' ','_',trim(strtolower($this->getSql('nombre'))));

        if ($this->getSql('tipo')==2) 
        {
            $nombreTabla2 = 'variable_'.$nombreTabla;

            foreach ($this->_tablas as $t)
            {
                if(in_array($nombreTabla2, $t))
                {
                    $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getSql('nombre') . '</b> no pudo ser registrado, nombre reservado');
                    $i=1;
                }            
            }
        }
        else
        {
            $nombreTabla2=$nombreTabla;
        }        
        
        if($i==0)
        {      
            $id = $this->_estandar->registrarEstandar($this->getSql('nombre'),$nombreTabla2,1,  Cookie::lenguaje(),$this->getSql('descripcion'), $this->getSql('tipo'));    

            if ($id > 0) 
            {
                $this->_view->assign('_mensaje', 'Estandar <b style="font-size: 1.15em;">'.$this->getSql('nombre').'</b> registrado..!!');                
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al registrar el Estandar');
            }                     
        } 
    }
    
    public function editarEstandar($idEstandarRecurso = false) 
    {
        $this->_acl->acceso('editar_estandar');
        $this->validarUrlIdioma();                
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('index'));
        $idEstandarRecurso = $this->filtrarInt($idEstandarRecurso);
        $estandar_recurso = $this->_estandar->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=$idEstandarRecurso");

        if (!empty($estandar_recurso)) 
        {
            $tipoEstandarRecurso = $estandar_recurso[0]['Esr_Tipo'];     
            $fichaEstandar = $this->_estandar->getFicha_Estandar($idEstandarRecurso);
            //print_r($fichaEstandar);exit;
            $insert = 0;
        
            if ($this->botonPress("bt_guardarFicha")) 
            {
                $this->registrarFichaEstandar($idEstandarRecurso);  
            }

            if ($this->botonPress("bt_generarTabla")) 
            {
                $this->generarTabla($idEstandarRecurso,$fichaEstandar, $tipoEstandarRecurso);
                $insert = 1;
            }

            $tabla = 1;

            if ($tipoEstandarRecurso==1) 
            {
                if(count($fichaEstandar)>0)
                {
                    foreach ($this->_tablas as $t)
                    {            
                        if(in_array($fichaEstandar[0]['Fie_NombreTabla'], $t))
                        {
                            $tabla = 0;
                            if($insert ==1)
                            {
                                $this->_view->assign('_mensaje', 'Se proceso correctamente el Estandar');
                            }                    
                        }
                    }
                }
            }
            else if ($tipoEstandarRecurso==2) 
            {
                //print_r($fichaEstandar); exit();

                if($fichaEstandar!=null)
                {
                    $nombre_tabla="variable_".$fichaEstandar[0]['Fie_NombreTabla'];

                    if(count($fichaEstandar)>0)
                    {
                        foreach ($this->_tablas as $t)
                        {            
                            if(in_array($nombre_tabla, $t))
                            {
                                $tabla = 0;
                                if($insert ==1)
                                {
                                    $this->_view->assign('_mensaje', 'Se proceso correctamente el Estandar');
                                }                    
                            }
                        }
                    }
                }

                //$this->_view->assign('tabla2', $tabla2);    
            }  

            $paginador = new Paginador();
            $fichaEstandar = $this->_registros->getFichaEstandar($idEstandarRecurso);

            //print_r($fichaEstandar); exit();
            //$lista = $this->_registros->getListaRegistrosEstandar('variable_'.$fichaEstandar[0]['Fie_NombreTabla'], Cookie::lenguaje(), "");            

            $this->_view->assign('tablaGenerada', $tabla);        
            $Idi_IdIdioma = Cookie::lenguaje();
            $this->_view->assign('ficha', $fichaEstandar);
            //$this->_view->assign('variables', $paginador->paginar($lista, "listaregistros", "$idEstandarRecurso", 1, 25));

            //$this->_view->assign('datosEstandar',  $this->_estandar->getEstandar_recurso2(" WHERE Esr_IdEstandarRecurso = $idEstandarRecurso"));
            $this->_view->assign('idiomaUrl',$Idi_IdIdioma);
            //$paginador = new Paginador();
            $this->_view->assign('datos', $paginador->paginar($this->_estandar->getFicha_Estandar($idEstandarRecurso), "listaregistrosFichas", "", 1, 25));
            $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
            $this->_view->assign('idiomas',$this->_estandar->getIdiomas());
            $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
            $this->_view->assign('titulo', 'Editar Estandar');
            $this->_view->renderizar('editarEstandar', 'Editar Estandar');       
        }
        else
        {
                echo "estandar no existe";
        }
    }

    public function editarVariable($idEstandarRecurso = false)
    {
        $this->_acl->acceso('editar_estandar');
        $this->validarUrlIdioma();                
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('index'));
        $idEstandarRecurso = $this->filtrarInt($idEstandarRecurso);
        $estandar_recurso = $this->_estandar->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=$idEstandarRecurso");

        if (!empty($estandar_recurso)) 
        {
            $tipoEstandarRecurso = $estandar_recurso[0]['Esr_Tipo'];     
            $fichaEstandar = $this->_estandar->getFicha_Estandar($idEstandarRecurso);
            //print_r($fichaEstandar);exit;
            $insert = 0;
        
            if ($this->botonPress("bt_guardarFichaVariable")) 
            {
                $this->registrarFichaVariable($fichaEstandar);            
            }  

            if($this->botonPress("bt_generarTablaData"))
            {

                $this->generarTablaData($idEstandarRecurso, $fichaEstandar);
            }

            $tabla = 1;

            if ($tipoEstandarRecurso==2) 
            {
                $nombre_tabla="data_".$fichaEstandar[0]['Fie_NombreTabla'];

                if(count($fichaEstandar)>0)
                {
                    foreach ($this->_tablas as $t)
                    {            
                        if(in_array($nombre_tabla, $t))
                        {
                            $tabla = 0;
                            if($insert ==1)
                            {
                                $this->_view->assign('_mensaje', 'Se proceso correctamente el Estandar');
                            }                    
                        }
                    }
                }
            }  
            
            $paginador = new Paginador();
            $fichaEstandar = $this->_registros->getFichaEstandar($idEstandarRecurso);

            //print_r($fichaEstandar); exit();
            $lista = $this->_registros->getListaRegistrosEstandar('variable_'.$fichaEstandar[0]['Fie_NombreTabla'], Cookie::lenguaje(), "");            

            $this->_view->assign('tablaGenerada', $tabla);        
            $Idi_IdIdioma = Cookie::lenguaje();
            $this->_view->assign('ficha', $fichaEstandar);
            $this->_view->assign('variables', $paginador->paginar($lista, "listaregistros", "$idEstandarRecurso", 1, 25));

            //$this->_view->assign('datosEstandar',  $this->_estandar->getEstandar_recurso2(" WHERE Esr_IdEstandarRecurso = $idEstandarRecurso"));
            $this->_view->assign('idiomaUrl',$Idi_IdIdioma);
            //$paginador = new Paginador();
            $this->_view->assign('datos', $paginador->paginar($this->_estandar->getFicha_Estandar($idEstandarRecurso), "listaregistrosVariables", "", 1, 25));
            $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
            $this->_view->assign('idiomas',$this->_estandar->getIdiomas());
            $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
            $this->_view->assign('titulo', 'Editar Estandar');
            $this->_view->renderizar('editarVariable', 'Editar variable');       
        }
        else
        {
            echo "estandar no existe";
        }   
    }
    
    public function _paginacion_listaregistrosFichas($idEstandarRecurso = false, $palabra = '') 
    {
        //$this->validarUrlIdioma();
        $pagina = $this->getInt('pagina');
        //$registros = $this->getInt('registros');
        $idEstandarRecurso =  $this->filtrarInt($idEstandarRecurso);
        
        $fichaEstandar = $this->_estandar->getFicha_Estandar($idEstandarRecurso);

        if(empty ($fichaEstandar))
        {
            $this->_view->assign('tablaGenerada', 1);
                // echo $fichaEstandar[0]['Fie_NombreTabla'];exit;   
        } 
        else 
        {
            $tabla = 1;

            foreach ($this->_tablas as $t)
            {            
                if(in_array($fichaEstandar[0]['Fie_NombreTabla'], $t))
                {
                    $tabla = 0;
                }
            }
            $this->_view->assign('tablaGenerada', $tabla);
        }
        
        $condicion = " AND Fie_CampoFicha LIKE '%".$palabra."%'";
        
        $paginador = new Paginador();

        $this->_view->assign('datos', $paginador->paginar($this->_estandar->getFicha_Estandar($idEstandarRecurso, $condicion), "listaregistrosFichas", "$idEstandarRecurso/$palabra", $pagina, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistrosFichas', false, true);
    }
    
    public function _buscarCampo($nombre = false) 
    {
        //$this->validarUrlIdioma();
        //$pagina = $this->getInt('pagina');
        $idEstandarRecurso = $this->getInt('idEstandarRecurso');
        $palabra = $this->getSql('palabra');
        
        $condicion = " AND Fie_CampoFicha LIKE '%".$palabra."%'";
        
        $fichaEstandar = $this->_estandar->getFicha_Estandar($idEstandarRecurso);

        if(empty ($fichaEstandar))
        {
            $this->_view->assign('tablaGenerada', 1);
                // echo $fichaEstandar[0]['Fie_NombreTabla'];exit;   
        } 
        else 
        {
            $tabla = 1;
            foreach ($this->_tablas as $t)
            {            
                if(in_array($fichaEstandar[0]['Fie_NombreTabla'], $t))
                {
                    $tabla = 0;
                }
            }

            $this->_view->assign('tablaGenerada', $tabla);
        }
        
        $paginador = new Paginador();

        $this->_view->assign('datos', $paginador->paginar($this->_estandar->getFicha_Estandar($idEstandarRecurso,$condicion), "listaregistrosFichas", "$idEstandarRecurso/$palabra", false, 25));

        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistrosFichas', false, true);
    }
    
    public function  registrarFichaEstandar($idEstandarRecurso,$idFichaEstandar = 0) 
    {
        $i=0;
        $error = ""; $error1 = ""; 
        $idEstandarRecurso = $this->filtrarInt($idEstandarRecurso);
        $condicion = ' WHERE Esr_IdEstandarRecurso = '.$idEstandarRecurso.' ';
        $estandarRecurso = $this->_estandar->getEstandar_recurso2($condicion);
        $nombreCampo = $this->getSql('nombre');
        $idFicha = $this->_estandar->verificarFichaEstandar($nombreCampo,$idEstandarRecurso);
        
        $estandar_recurso = $this->_estandar->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=$idEstandarRecurso");
        
        $tipo_estandar = $estandar_recurso[0]['Esr_Tipo'];   

        if($idFichaEstandar == 0)
        {
            if($idFicha['Fie_IdFichaEstandar'] > 0 )
            {
                $error = ' El campo <b style="font-size: 1.15em;">' . $nombreCampo . '</b> ya existe. ';
                $i=1;
            }
        }

        if($idFichaEstandar > 0 && $idFicha['Fie_IdFichaEstandar'] > 0 && $idFicha['Fie_IdFichaEstandar'] != $idFichaEstandar)
        {
            $error = ' El campo <b style="font-size: 1.15em;">' . $nombreCampo . '</b> ya existe. ';
            $i=1;
        }
        
        if($i==0)
        {
            if ($tipo_estandar==2) 
            {
                $nombre_estandar = str_replace("variable_", "", $estandarRecurso['Esr_NombreTabla']);
            }
            else
            {
                $nombre_estandar = $estandarRecurso['Esr_NombreTabla'];
                
            }
            
            $contar_ = substr_count($nombre_estandar, '_')+1;

            if($contar_==1)
            {
                $nombreColumna = substr(ucwords($nombre_estandar), 0, 3);
            }

            if($contar_==2)
            {
                $nombreColumna = substr(ucwords($nombre_estandar), 0, 2);
                $nombreColumna = $nombreColumna.substr($nombre_estandar,strpos($nombre_estandar,'_')+1,1);
                //echo $nombreColumna; exit;
            }

            if($contar_ > 2)
            {
                $nombreColumna = substr(ucwords($nombre_estandar), 0, 1);
                $nombreColumna = $nombreColumna.substr($nombre_estandar,strpos($nombre_estandar,'_')+1,1);
                
                $nombreColumna1 = substr($nombre_estandar,strpos($nombre_estandar,'_')+1,strlen($nombre_estandar));
                $nombreColumna = $nombreColumna.substr($nombreColumna1,strpos($nombreColumna1,'_')+1,1);
                //echo $nombreColumna; exit;
            }

            $nombreCampo1 = str_replace(" ", "", ucwords($nombreCampo));
            //$nombreColumna = substr($estandarRecurso['Esr_NombreTabla'], 0, 3);
            
            $nombreColumna = $nombreColumna.'_'.$nombreCampo1;

            if( $this->getSql('Fie_TipoDatoCampo')=="Decimal")
            {
                $tipo = "double";
                $tamano = "16,8";
            }

            if( $this->getSql('Fie_TipoDatoCampo')=="Entero")
            {
                $tipo = "int";
                $tamano = 10;
            }

            if( $this->getSql('Fie_TipoDatoCampo')=="Latitud")
            {
                $tipo = "varchar";
                $tamano = 100;
            }

            if( $this->getSql('Fie_TipoDatoCampo')=="Longitud")
            {
                $tipo = "varchar";
                $tamano = 100;
            }

            if( $this->getSql('Fie_TipoDatoCampo')=="Texto")
            {
                $tipo = "varchar"; 
                //echo $this->getSql('Fie_TamanoColumna')." - "; 
                //echo $this->getInt('Fie_TamanoColumna'); exit;
                $tamano = $this->getSql('Fie_TamanoColumna');
            }
            //echo $nombreColumna; exit;
            if($idFichaEstandar == 0)
            {
                $id = $this->_estandar->registrarFicha_Estandar(
                    $nombreCampo,
                    $idEstandarRecurso,
                    $nombre_estandar,
                    $tipo, $tamano, $nombreColumna,
                    $this->getInt('Fie_ColumnaObligatorio'),
                    $this->getInt('Fie_ColumnaTraduccion'),
                    $this->getSql('Fie_TipoDatoCampo'),
                    $this->getSql('idiomaRadio'));
            }

            if($idFichaEstandar > 0)
            {
                //echo $this->getSql('idIdiomaOriginal');exit;
                $id = $this->_estandar->actualizarFicha_Estandar(
                    $idFichaEstandar,
                    $nombreCampo,
                    $idEstandarRecurso,
                    $nombre_estandar,
                    $tipo, $tamano, $nombreColumna,
                    $this->getInt('Fie_ColumnaObligatorio'),
                    $this->getInt('Fie_ColumnaTraduccion'),
                    $this->getSql('Fie_TipoDatoCampo'), 
                    $this->getSql('idIdiomaOriginal'));            
            }
            //print_r($id); exit;
            
            if ($id > 0) 
            {
                if($idFichaEstandar > 0)
                {
                    $this->_view->assign('_mensaje', 'Campo <b style="font-size: 1.15em;">'.$this->getSql('nombre').'</b> editado correctamente..!!');
                } 
                else 
                {
                    $this->_view->assign('_mensaje', 'Campo <b style="font-size: 1.15em;">'.$this->getSql('nombre').'</b> registrado..!!');
                }
                
            } 
            else 
            {
                $this->_view->assign('_error', 'Error al registrar el Campo');
            } 

        } 
        else 
        {
            $this->_view->assign('_error', $error  );
        }
    } 

    public function registrarFichaVariable($fichaEstandar) 
    {
        $nombre_tabla="variable_".$fichaEstandar[0]['Fie_NombreTabla'];
        $fichaVariable = $this->_estandar->getFicha_Variable($nombre_tabla);

        //print_r($fichaVariable); 
        //print_r($fichaEstandar);
        //exit();
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
            //$escripFicha .= " '" . $this->getSql($ficha['Fie_ColumnaTabla']) . "' , ";
            $tabla = 'variable_'.$ficha['Fie_NombreTabla'];
        }
        
        $insertar = "INSERT INTO " . $tabla . " VALUES ( null, " . $escripFicha . " '" . Cookie::lenguaje() . "', 1)";

        //echo $insertar; exit;
        $this->_registros->insertarRegistro($insertar);
    }

    public function editarFicha($Esr_IdEstandarRecurso , $Fie_IdFichaEstandar = false) 
    {
        $this->_acl->acceso('agregar_estandar');
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('index'));
        $i=0;
        $Fie_IdFichaEstandar = $this->filtrarInt($Fie_IdFichaEstandar);
        $Esr_IdEstandarRecurso = $this->filtrarInt($Esr_IdEstandarRecurso);
        
        if ($this->botonPress("bt_guardarFicha")) 
        {
            if ($this->getSql('editar') == 1)
            {
                $this->registrarFichaEstandar($Esr_IdEstandarRecurso, $Fie_IdFichaEstandar);
            }  
            else 
            {
                $this->_estandar->editarTraduccionFicha($this->getSql('nombre'),$Fie_IdFichaEstandar,  $this->getSql('Idi_IdIdioma'));
                $i=1;
                $this->_view->assign('_mensaje', 'Edición Traducción Completado..!!');
            }
        }
        $fichaEstandar = $this->_estandar->getFicha_Estandar2($Fie_IdFichaEstandar);
        
        $paginador = new Paginador();
        $this->_view->assign('datos', $fichaEstandar);
        $this->_view->assign('idiomas',$this->_estandar->getIdiomas());
        $this->_view->assign('titulo', 'Editar Ficha');
        $this->_view->renderizar('editarFicha', 'Editar Ficha');
    }

    public function gestion_idiomas_ficha() 
    {
        $this->_view->getLenguaje('template_backend');
        $condicion1 ='';
        $Idi_IdIdioma =  $this->getPostParam('idIdioma');
        
        $Fie_IdFichaEstandar = $this->getPostParam('Fie_IdFichaEstandar');
        
        $condicion1 .= " WHERE Fie_IdFichaEstandar = $Fie_IdFichaEstandar ";            
        $datos = $this->_estandar->getFichaTraducida($condicion1,$Idi_IdIdioma);
        $this->_view->assign('idiomas',$this->_estandar->getIdiomas());

        if ($datos["Idi_IdIdioma"]==$Idi_IdIdioma) 
        {
            $this->_view->assign('datos',$datos);    
        }
        else
        {
            $datos["Fie_CampoFicha"]="";
            $datos["Idi_IdIdioma"]=$Idi_IdIdioma;
            $this->_view->assign('datos',$datos);    
        }

        $this->_view->assign('IdiomaOriginal',$this->getPostParam('idIdiomaOriginal'));
        
        $this->_view->renderizar('ajax/gestion_idiomas_ficha', false, true);
    }    
    
    public function _eliminarFicha() 
    {
        $idEstandarRecurso = $this->getInt('idEstandarRecurso');
        $palabra = $this->getSql('palabra');
        $Fie_IdFichaEstandar = $this->getSql('idficha');
        
        $condicion = " AND Fie_CampoFicha LIKE '%".$palabra."%'";
        
        $fichaEstandar = $this->_estandar->getFicha_Estandar($idEstandarRecurso);

        if(empty ($fichaEstandar))
        {
            $this->_view->assign('tablaGenerada', 1);
        } 
        else 
        {
            $tabla = 1;

            foreach ($this->_tablas as $t)
            {            
                if(in_array($fichaEstandar[0]['Fie_NombreTabla'], $t))
                {
                    $tabla = 0;
                }
            }
            $this->_view->assign('tablaGenerada', $tabla);            
        }

        $elim = $this->_estandar->eliminarRegistroFicha($Fie_IdFichaEstandar);

        if($elim>0)
        {
            $this->_view->assign('_mensaje', 'Se elimino correctamente la ficha..!!');
        }  
        else 
        {
            $this->_view->assign('_error', 'No se encontro el registro a eliminar..!!');
        }
        
        $paginador = new Paginador();

        $this->_view->assign('datos', $paginador->paginar($this->_estandar->getFicha_Estandar($idEstandarRecurso,$condicion), "listaregistrosFichas", "$idEstandarRecurso/$palabra", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        //$this->_view->assign('cantidadporpagina',$registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/listaregistrosFichas', false, true);        
    }
    
    public function generarTabla($idEstandarRecurso, $fichaEstandar, $tipoEstandarRecurso) 
    {
        $tipoEstandarRecurso = $this->filtrarInt($tipoEstandarRecurso);
            
        if($tipoEstandarRecurso==1)
        {            
            $i=0;
            $error = ""; $error1 = ""; 
            $idEstandarRecurso = $this->filtrarInt($idEstandarRecurso);
            $condicion = ' WHERE Esr_IdEstandarRecurso = '.$idEstandarRecurso.' ';
            $estandarRecurso = $this->_estandar->getEstandar_recurso2($condicion);
            //print_r($estandarRecurso);
            //$nombreCampo = $this->getSql('nombre');
            //$idFicha = $this->_estandar->verificarFichaEstandar($nombreCampo,$idEstandarRecurso);
            $escripFicha = '';

            foreach ($fichaEstandar as $ficha ) 
            {
                $escripFicha .= "  `".$ficha['Fie_ColumnaTabla']."` ".$ficha['Fie_TipoDatoCampo']."(".$ficha['Fie_TamanoColumna'].") ,  ";
                $ini = substr($ficha['Fie_ColumnaTabla'],0,3);
            }
            
            $idTabla = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $estandarRecurso['Esr_NombreTabla'])));
            $estado = $ini."_Estado";
            $table = " CREATE TABLE  `".$estandarRecurso['Esr_NombreTabla']."` ( 
                      `".$idTabla."` int(11) NOT NULL auto_increment, ".$escripFicha." "
                    . " `Rec_IdRecurso` int(11), `Idi_IdIdioma` char(11), `".$estado."` TINYINT(5), PRIMARY KEY  (`".$idTabla."`) ) ";
            //echo $table;exit;
            $this->_estandar->generarTablaEstandar($table);            
        }
        else if($tipoEstandarRecurso==2)
        {
            $i=0;
            $error = ""; $error1 = ""; 
            $idEstandarRecurso = $this->filtrarInt($idEstandarRecurso);
            $condicion = ' WHERE Esr_IdEstandarRecurso = '.$idEstandarRecurso.' ';
            $estandarRecurso = $this->_estandar->getEstandar_recurso2($condicion);

            $escripFicha = '';

            foreach ($fichaEstandar as $ficha) 
            {
                $escripFicha .= "  `".$ficha['Fie_ColumnaTabla']."` ".$ficha['Fie_TipoDatoCampo']."(".$ficha['Fie_TamanoColumna'].") ,  ";
                $ini = substr($ficha['Fie_ColumnaTabla'],0,3);
            }

            $nombre_tabla=$estandarRecurso['Esr_NombreTabla']; 
            
            $idTabla = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $estandarRecurso['Esr_NombreTabla'])));
            $estado = $ini."_Estado";
            /*$tipo_dato = $ini."_Tipo";
            $latitud = $ini."_Latitud";
            $longitud = $ini."_Longitud";*/

            /*$table = " CREATE TABLE  `".$nombre_tabla."` ( 
                      `".$idTabla."` int(11) NOT NULL auto_increment, ".$escripFicha." "
                    . " `".$tipo_dato."` VARCHAR(20), `".$latitud."` VARCHAR(100), `".$longitud."` VARCHAR(100), `Rec_IdRecurso` int(11), `Idi_IdIdioma` char(11), `".$estado."` TINYINT(5), PRIMARY KEY  (`".$idTabla."`) ) ";*/

            $table = " CREATE TABLE  `".$nombre_tabla."` ( 
                      `".$idTabla."` int(11) NOT NULL auto_increment, ".$escripFicha." "
                    . " `Rec_IdRecurso` int(11), `Idi_IdIdioma` char(11), `".$estado."` TINYINT(5), PRIMARY KEY  (`".$idTabla."`) ) ";
            
            $this->_estandar->generarTablaEstandar($table);

            //$nombre_tabla2 = str_replace('variable', 'data', $estandarRecurso['Esr_NombreTabla']);
            //$idTabla2 = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $nombre_tabla2)));
        
            //$campo_nregistro = $ini.'_NumRegistro';
            //$campo_valor = $ini.'_Valor';

            /*$table2 = " CREATE TABLE  `".$nombre_tabla2."` ( 
                      `".$idTabla2."` int(11) NOT NULL auto_increment, "
                    . " ".$campo_nregistro." int(11), ".$idTabla." int(11), ".$campo_valor." varchar(1000),`".$estado."` TINYINT(5), PRIMARY KEY  (`".$idTabla2."`) ) ";
            //echo $table;exit;
            $this->_estandar->generarTablaEstandar($table2);*/

            /*$scriptTriggersInsertar = ""
                    . "CREATE TRIGGER `tgr_insert_".$estandarRecurso['Esr_NombreTabla']."_actualizar_cantidad_recurso` AFTER INSERT ON `".$estandarRecurso['Esr_NombreTabla']."` 
                        FOR EACH ROW BEGIN        
                           SET @total= (SELECT Rec_CantidadRegistros FROM recurso WHERE Rec_IdRecurso=new.Rec_IdRecurso);  
                           SET @total=@total+1;  
                           UPDATE recurso SET Rec_CantidadRegistros=@total 
                           WHERE Rec_IdRecurso=new.Rec_IdRecurso;         
                        END; ";
            
            $this->_estandar->generarTablaEstandar($scriptTriggersInsertar);
            
            $scriptTriggersUpdate = "
                CREATE TRIGGER `tgr_update_".$estandarRecurso['Esr_NombreTabla']."_actualizar_cantidad_recurso` AFTER UPDATE ON `".$estandarRecurso['Esr_NombreTabla']."` 
                FOR EACH ROW BEGIN      
                    IF(old.".$estado.">new.".$estado.") THEN    
                        SET @total= (SELECT Rec_CantidadRegistros FROM recurso WHERE Rec_IdRecurso=new.Rec_IdRecurso); 
                        SET @total=@total-1; 
                        UPDATE recurso SET Rec_CantidadRegistros=@total 
                        WHERE Rec_IdRecurso=new.Rec_IdRecurso;  
                    END IF; 
                    IF(old.".$estado."<new.".$estado.") THEN    
                        SET @total= (SELECT Rec_CantidadRegistros FROM recurso WHERE Rec_IdRecurso=new.Rec_IdRecurso); 
                        SET @total=@total+1; 
                        UPDATE recurso SET Rec_CantidadRegistros=@total 
                        WHERE Rec_IdRecurso=new.Rec_IdRecurso;  
                    END IF; 
                END; ";
            
            $this->_estandar->generarTablaEstandar($scriptTriggersUpdate);
            
            $scriptTriggersDelete = "
                 CREATE TRIGGER `tgr_delete_".$estandarRecurso['Esr_NombreTabla']."_actualizar_cantidad_recurso` BEFORE DELETE ON `".$estandarRecurso['Esr_NombreTabla']."`  
                    FOR EACH ROW BEGIN  
                        SET @total= (SELECT Rec_CantidadRegistros FROM recurso WHERE Rec_IdRecurso=old.Rec_IdRecurso); 
                        SET @total=@total-1; 
                        UPDATE recurso SET Rec_CantidadRegistros=@total 
                        WHERE Rec_IdRecurso=old.Rec_IdRecurso;  
                    END; ";

            $this->_estandar->generarTablaEstandar($scriptTriggersDelete);*/

        }

        $this->redireccionar("estandar/index/editarEstandar/$idEstandarRecurso"); 
        // echo $table;  exit;      
    }  
}
