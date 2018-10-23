<?php

class monitoreoController extends calidaddeaguaController 
{
    private $_model;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_model = $this->loadModel('monitoreo');
        $this->_ubigeos=$this->loadModel('ubigeo', 'hidrogeo');
    }

     public function index() 
     {
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");       
        $this->_view->renderizar('index', 'calidaddeagua');
    }

    public function registrar($recurso = false) 
    {
        $this->_acl->autenticado();
        $this->_acl->acceso("registro_individual");
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->getLenguaje("monitoreo_metadata");
        $this->_view->getLenguaje("hidrogeo_ubigeo");       
       
        //$this->_view->setJs(array('registrar'));
        $bdrecursos = $this->loadModel('bdrecursos', true);

        $metadatarecurso = $bdrecursos->getRecursoCompletoXid($recurso);
        $this->_view->assign('recurso', $metadatarecurso);
        $idestandar = $this->_model->getEstandarRecurso($this->filtrarInt($recurso));
        $this->_view->assign('ficha', $this->_model->getFichaCalidadAgua($idestandar[0][0], Cookie::lenguaje()));
        $this->_view->assign('estacion', $this->_model->getNombreEstacion());
        $this->_view->assign('entidad', $this->_model->getNombreEntidad());
        $this->_view->assign('variable', $this->_model->getNombreVariables(""));
        $this->_view->assign('pais', $this->_model->getPais());
        $this->_view->assign('titulo', 'Formulario de Registro');

        if ($this->getInt('registrar') == 1) 
        {
            //$fecha = str_replace('-', '', $this->getSql('Mca_Fecha'));
            
            //$Mca_Fecha = substr($fecha, -4) . substr($fecha, 2, 2) . substr($fecha, 0, 2);
            $Mca_Fecha=$this->getSql('Mca_Fecha');
            //echo $Mca_Fecha; exit();
            if (!empty($this->getSql('selPais')) and ! empty($this->getSql('selVariable')) and ! empty($this->getSql('selEstacion'))) 
            {
                $this->_model->registrarMonitoreoCalidadAgua($this->getSql('selEstacion'), $this->getSql('selEntidad'), $this->getSql('selVariable'), $this->getSql('Mca_Valor'), $Mca_Fecha, $this->getSql('selPais'), $this->getSql('selEstado'), $this->filtrarInt($recurso));

                $this->_view->setJs(array('modal'));
                $this->_view->assign('mensaje', 'Los Datos fueron registrados correctamente');
            }
        }

        $this->_view->renderizar('registrar', 'registrar');
    }

    public function metadata($id_mca=false)
    {
        $this->_acl->autenticado();
        $this->_view->getLenguaje("monitoreo_metadata");
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("bdrecursos_metadata");
        $idioma = Cookie::lenguaje();
        $e = $this->loadModel('bdrecursos', true);

        $id_mca = $this->filtrarInt($id_mca);

        if ($this->_acl->permiso("habilitar_deshabilitar_registros_recurso"))
        {
            $condicion_metadata="WHERE mca.Mca_IdMonitoreoCalidadAgua = $id_mca";
        }
        else
        {
            $condicion_metadata="WHERE mca.Mca_Estado = 1 and mca.Mca_IdMonitoreoCalidadAgua = $id_mca";
        }
                
        $metadatacalidadagua = $this->_model->getmonitoreoCalidadAguaMetadata($condicion_metadata);

        if(!empty($metadatacalidadagua))
        {
            $id_estacion = $metadatacalidadagua[0]['Esm_IdEstacionMonitoreo'];
            $condicion = "WHERE Esm_IdEstacionMonitoreo=$id_estacion";
            
            $riocuenca=$this->_model->getNombreRioCuenca($condicion); 

            if(count($riocuenca)>0)
            {
                $id_cuenca=$riocuenca[0]['Cue_IdCuenca'];
                $condicion2="WHERE Cue_IdCuenca=$id_cuenca";

                $id_subcuenca=$riocuenca[0]['Suc_IdSubcuenca'];
                $condicion3="WHERE Suc_IdSubcuenca=$id_subcuenca";

                $id_rio=$riocuenca[0]['Rio_IdRio'];
                $condicion4="WHERE Rio_IdRio=$id_rio";

                $this->_view->assign('cuenca', $this->_model->getNombreCuenca($condicion2));
                $this->_view->assign('subcuenca', $this->_model->getNombreSubCuenca($condicion3));
                $this->_view->assign('rio', $this->_model->getNombreRio($condicion4));
            }

            $metadatarecurso = $e->getRecursoCompletoXid($metadatacalidadagua[0]['Rec_IdRecurso']);
            $this->_view->assign('recurso', $metadatarecurso);
            $this->_view->assign('detalle', $metadatacalidadagua);
            //$this->_view->assign('riocuenca', );       
            
            $this->_view->assign('estacion', $this->_model->getNombreEstacion());
            $this->_view->assign('variable', $this->_model->getNombreVariables(""));
            //Ubigeo

            $ubigeo = $this->_ubigeos->getUbigeo($metadatacalidadagua[0]['Ubi_IdUbigeo']); 
            //{
                $this->_view->assign('ubigeos', $this->_ubigeos->getUbigeos());
                $this->_view->assign('denominaciones', $this->_ubigeos->getDenominacionTerritorioxPais($metadatacalidadagua[0][15]));

            if ($ubigeo!=null) 
            {
                $this->_view->assign('territorios1', $this->_ubigeos->getTerritorios1xIdUbigeo($ubigeo['Ubi_IdUbigeo']));
                $this->_view->assign('territorios2', $this->_ubigeos->getTerritorios2xIdUbigeo($ubigeo['Ubi_IdUbigeo']));
                $this->_view->assign('territorios3', $this->_ubigeos->getTerritorios3xIdUbigeo($ubigeo['Ubi_IdUbigeo']));
                $this->_view->assign('territorios4', $this->_ubigeos->getTerritorios4xIdUbigeo($ubigeo['Ubi_IdUbigeo']));
            }            
            //}
            //print_r($metadatacalidadagua[0][15]);
            //print_r($this->_ubigeos->getDenominacionTerritorioxPais($metadatacalidadagua[0][15])); exit();
            $this->_view->assign('titulo', 'Base de datos Calidad de Agua');
            
            $this->_view->renderizar('metadata', 'monitoreo');
        }
        else
        {
            echo 'Debe pasar como parametro el id del registro o el registro no ha sido encontrado';
        }
        

   }
    public function editar($idmonitoreo = false) 
    {
        $this->_acl->acceso("editar_registros_recurso");
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("monitoreo_metadata");
        $this->_view->getLenguaje("hidrogeo_ubigeo");
        
        $this->_view->setJs(array("editarMCA"));

        $e = $this->loadModel('bdrecursos', true);

        $id_mca = $this->filtrarInt($idmonitoreo);

        $condicion_editar="WHERE mca.Mca_IdMonitoreoCalidadAgua = $id_mca";
        
        $metadatacalidadagua = $this->_model->getmonitoreoCalidadAguaMetadata($condicion_editar);
        
        $metadatarecurso = $e->getRecursoCompletoXid($metadatacalidadagua[0]['Rec_IdRecurso']);       

        if ($this->botonPress("editarMCA")) 
        {
            $this->editarMonitoreoCalidadAgua($this->filtrarInt($idmonitoreo));
        }

        $condicion = "";
        $registros = $this->filtrarInt($idmonitoreo);

        $condicion .= "where mca.Mca_IdMonitoreoCalidadAgua = $registros ";
        //$datos = $this->_model->getmonitoreoCalidadAgua($registros);
        $datos = $this->_model->getmonitoreoCalidadAguaMetadata2($condicion);

        if (!empty($datos)) 
        {
            $idestandar = $this->_model->getEstandarRecurso($datos['Rec_IdRecurso']);
            $this->_view->assign('recurso', $metadatarecurso);
            $this->_view->assign('ficha', $this->_model->getFichaCalidadAgua($idestandar[0][0], Cookie::lenguaje()));

            //$this->_view->assign('cuencas', $this->_subcuencas->getCuencas());
            //$this->_view->assign('subcuenca', $this->_subcuencas->getSubcuenca($id));
            
            $this->_view->assign('riocuenca', $this->_model->getNombreRioCuenca(""));
            //$this->_view->assign('cuenca', $this->_model->getNombreCuenca());
            //$this->_view->assign('subcuenca', $this->_model->getNombreSubCuenca(""));
            //$this->_view->assign('rio', $this->_model->getNombreRio());
            $this->_view->assign('estacion', $this->_model->getNombreEstacion());
            $this->_view->assign('entidad', $this->_model->getNombreEntidad());
            $this->_view->assign('variable', $this->_model->getNombreVariables(""));
            $this->_view->assign('pais', $this->_model->getPais());
            //print_r($this->_model->getNombreCuenca()); exit();            
            //Para ubigeo
            
            //$this->_view->assign('datos', $ubigeo);
            //$this->_view->assign('paises', $this->_ubigeos->getPaisUbigeo());
            //if ($ubigeo!=null) {
              //  $this->_view->assign('denominaciones', $this->_ubigeos->getDenominacionTerritorioxPais($ubigeo[1]));    
            //}
            
            //$this->_view->assign('paises', $this->_model->getPaises());
            $this->_view->assign('datos1', $datos);
            $this->_view->assign('titulo', 'Formulario de Registro');
            //print_r($datos['Mca_Fecha']); exit();
            
            /*$this->_view->assign('ubigeos',$this->_ubigeos->getUbigeos());
            
            $this->_view->assign('denominaciones', $this->_ubigeos->getDenominacionTerritorioxPais(0));
            $this->_view->assign('territorios1', $this->_ubigeos->getTerritorios1(0));
            $this->_view->assign('territorios2', $this->_ubigeos->getTerritorios2(0));
            $this->_view->assign('territorios3', $this->_ubigeos->getTerritorios3(0));
            $this->_view->assign('territorios4', $this->_ubigeos->getTerritorios4(0));*/

            $this->_view->renderizar('editar', 'registrar');
        } 
        else 
        {
            echo 'Debe pasar como parametro el id del registro o el recurso no ha sido encontrado';
        }
    }

    private function editarMonitoreoCalidadAgua($registro = false) 
    {
        if (!empty($this->getSql('selPais')) and ! empty($this->getSql('selVariable')) and ! empty($this->getSql('selEstacion'))) 
        {
            /*$cuenca = $this->_model->getCuenca($this->getSql('Cue_IdCuenca'));
            if (empty($cuenca)) {
                $cuenca = $this->_model->registrarCuenca(ucwords($this->getSql('Cue_IdCuenca')));
            }
            $subcuenca = $this->_model->getSubCuenca($cuenca[0], $this->getSql('Suc_IdSubCuenca'));
            if (empty($subcuenca)) {
                $subcuenca = $this->_model->registrarSubCuenca(ucwords($this->getSql('Suc_IdSubCuenca')), $cuenca[0]);
            }

            $rio = $this->_model->getRio($this->getSql('Pai_IdPais'), $this->getSql('Rio_IdRio'));
            if (empty($rio)) {
                $rio = $this->_model->registrarRio(ucwords($this->getSql('Rio_IdRio')), $this->getSql('Pai_IdPais'));
            }

            $riocuenca = $this->_model->getRioCuenca($cuenca[0], $subcuenca[0], $rio[0]);
            if (empty($riocuenca)) {
                $riocuenca = $this->_model->registrarRioCuenca($cuenca[0], $subcuenca[0], $rio[0]);
            }

            $estacion = $this->_model->getEstacionMonitoreo($this->getSql('Esm_Latitud'), $this->getSql('Esm_Longitud'));
            if (empty($estacion) and is_numeric(str_replace(',', '.', $this->getSql('Esm_Longitud'))) and is_numeric(str_replace(',', '.', $this->getSql('Esm_Latitud')))) {
                $estacion = $this->_model->registrarEstacionMonitoreo($this->getSql('Esm_Nombre'), str_replace(',', '.', $this->getSql('Esm_Longitud')), str_replace(',', '.', $this->getSql('Esm_Latitud')), $this->getSql('Esm_Referencia'), $this->getSql('Esm_Altitud'), $riocuenca[0]);
            } else {
                $this->_model->actualizarEstacionRio($riocuenca[0], $estacion[0]);
            }

            $entidad = $this->_model->getEntidad($this->getSql('Ent_Nombre'));
            if (empty($entidad)) {
                $entidad = $this->_model->registrarEntidad($this->getSql('Ent_Nombre'), $this->getSql('Ent_Siglas'));
            }

            */

            $fecha = str_replace('/', '', $this->getSql('Mca_Fecha'));
            //$Mca_Fecha = substr($fecha, -4) . substr($fecha, 2, 2) . substr($fecha, 0, 2);            
            $Mca_Fecha=$this->getSql('Mca_Fecha'); 
            //echo $Mca_Fecha; exit();
            $this->_model->actualizarMonitoreoCalidadAgua($this->getSql('selEstacion'), $this->getSql('selEntidad'), $this->getSql('selVariable'), $this->getSql('Mca_Valor'), $Mca_Fecha, $this->getSql('selPais'), $this->getSql('selEstado'), $this->filtrarInt($registro));

            $this->_view->setJs(array('modal'));
            $this->_view->assign('mensaje', 'Los Datos fueron actualizados correctamente');            
        }
    }

    //////////////// Migracion del monitoreo
    
    //Para monitoreo  

    //Para monitoreo
    public function estacion($idestacion = false) 
    {
        $this->_acl->autenticado();
        $this->validarUrlIdioma();
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("bdrecursos_metadata");

        $this->_view->setJs(array('document_ready', 
                                  'estacion', 
                                  array('http://code.highcharts.com/highcharts.js', false), //agregado
                                  array('http://code.highcharts.com/modules/exporting.js', false), //agregado
                                  'chart1',//agregado
                                  'chartica'//agregado
        ));

        $this->_view->setCss(array(array(BASE_URL . "public/css/visor.css", true), 'estacion'));

        $paginador = new Paginador();

        if ($this->filtrarInt($idestacion)) 
        {
            $this->_view->assign('titulo', 'Estacion de Monitoreo');
            $this->_view->assign("estadoeca", $this->_model->listarEstadoECA());
            
            //Para metadata
            $estacion_metadata=$this->_model->getEstacionMetadata($idestacion);
            $this->_view->assign("estacion_metadata", $estacion_metadata);
            
            $condicion = "WHERE Esm_IdEstacionMonitoreo=$idestacion";
        
            $riocuenca=$this->_model->getNombreRioCuenca($condicion); 

            if(count($riocuenca)>0)
            {
                $id_cuenca=$riocuenca[0]['Cue_IdCuenca'];
                $condicion2="WHERE Cue_IdCuenca=$id_cuenca";

                $id_subcuenca=$riocuenca[0]['Suc_IdSubcuenca'];
                $condicion3="WHERE Suc_IdSubcuenca=$id_subcuenca";

                $id_rio=$riocuenca[0]['Rio_IdRio'];
                $condicion4="WHERE Rio_IdRio=$id_rio";

                $this->_view->assign('cuenca', $this->_model->getNombreCuenca($condicion2));
                $this->_view->assign('subcuenca', $this->_model->getNombreSubCuenca($condicion3));
                $this->_view->assign('rio', $this->_model->getNombreRio($condicion4));
            }
            
            //Ubigeo

            $ubigeo = $this->_ubigeos->getUbigeo($estacion_metadata[0]['Ubi_IdUbigeo']);
            
            $this->_view->assign('ubigeos', $this->_ubigeos->getUbigeos());            

            if ($ubigeo!=null) 
            {
                $this->_view->assign('denominaciones', $this->_ubigeos->getDenominacionTerritorioxPais($ubigeo['Pai_IdPais']));
                //$a=$this->_ubigeos->getDenominacionTerritorioxPais($ubigeo['Pai_IdPais']);
                //print_r($a[0]['Det_Nombre']); exit();   
                $this->_view->assign('territorios1', $this->_ubigeos->getTerritorios1xIdUbigeo($ubigeo['Ubi_IdUbigeo']));
                $this->_view->assign('territorios2', $this->_ubigeos->getTerritorios2xIdUbigeo($ubigeo['Ubi_IdUbigeo']));
                $this->_view->assign('territorios3', $this->_ubigeos->getTerritorios3xIdUbigeo($ubigeo['Ubi_IdUbigeo']));
                $this->_view->assign('territorios4', $this->_ubigeos->getTerritorios4xIdUbigeo($ubigeo['Ubi_IdUbigeo']));         
                
            }

            $this->_view->assign("estacion", $this->_model->EstacionPorId($this->filtrarInt($idestacion)));
            $this->_view->assign('id_estacion', $idestacion);

            $this->_view->assign("variables", $paginador->paginar($this->_model->VariablesPorEstacion($this->filtrarInt($idestacion), ""), "lista_estacion_variable", $this->filtrarInt($idestacion), 1, 25));
            $this->_view->assign("cat_fechas", $this->_model->getFechasMonitoreoV($this->filtrarInt($idestacion), "")); //AGREGADO
            $this->_view->assign("serie_name_variables", $this->_model->getVariablesMonitoreoV($this->filtrarInt($idestacion), "")); //AGREGADO
            $this->_view->assign("serie_data_valores", $this->_model->getValoresPromediadosPorFechaV($this->filtrarInt($idestacion), "")); //AGREGADO
            $this->_view->assign("serie_ica", $this->_model->getIcaMonitoreo($this->filtrarInt($idestacion),2,1)); //AGREGADO
            $this->_view->assign('paginacion_variables', $paginador->getView('paginacion_ajax', false));
            $this->_view->assign('control_paginacion_var', $paginador->getControlPaginaion());
            $this->_view->assign('numeropagina_var', $paginador->getNumeroPagina());
        } 
        else 
        {
            $this->_view->assign('titulo', 'Estacion de Monitoreo de Calidad de Agua');

            $this->_view->assign("paises", $this->_model->listarPais());

            $this->_view->assign("estaciones", $paginador->paginar($this->_model->ListarEstacionCompleto(""), "lista_estacion", "", 1, 25));
            $this->_view->assign('paginacion_estaciones', $paginador->getView('paginacion_ajax', false));
            $this->_view->assign('control_paginacion_est', $paginador->getControlPaginaion());
            $this->_view->assign('numeropagina_est', $paginador->getNumeroPagina());
        }

        $this->_view->renderizar('estacion', 'mapa');
    }
    //Para monitoreo
    public function variable($idvariable = false) 
    {
        $this->_acl->autenticado();
        $this->validarUrlIdioma();
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->assign('titulo', 'Variable de Estudio');
        $this->_view->setJs(array('document_ready', 
                            array('http://code.highcharts.com/highcharts.js', false), //agregado
                            array('http://code.highcharts.com/modules/exporting.js', false), //agregado
                            'chart2'//agregado
        ));

        $this->_view->setCss(array(array(BASE_URL . "public/css/visor.css", true)));

        $e = $this->loadModel('bdrecursos', true);
        $id_variable = $this->filtrarInt($idvariable);

        $paginador = new Paginador();
        if ($this->filtrarInt($idvariable)) 
        {
            $this->_view->assign("variable_metadata", $this->_model->getVariableMetadata($id_variable));
            
            $this->_view->assign("estadoeca", $this->_model->listarEstadoECA());
            $this->_view->assign("variable", $this->_model->VariablesPorId($this->filtrarInt($idvariable)));

            $this->_view->assign('id_variable', $idvariable);
            $this->_view->assign('estaciones', $paginador->paginar($this->_model->EstacionPorVariable($this->filtrarInt($idvariable),""),"lista_variable_estacion","", 1,25)); 

            $this->_view->assign("cat_fechas", $this->_model->getFechasMonitoreoE($this->filtrarInt($idvariable), "")); //AGREGADO
            $this->_view->assign("serie_name_estaciones", $this->_model->getEstacionesMonitoreoE($this->filtrarInt($idvariable), "")); //AGREGADO
            $this->_view->assign("serie_data_valores", $this->_model->getValoresPromediadosPorFechaE($this->filtrarInt($idvariable), "")); //AGREGADO

            //$this->_view->assign('paginacion_estaciones', $paginador->getView('paginacion_ajax', false));
            $this->_view->assign('paginacion_estaciones', $paginador->getView('paginacion_ajax'));

            $this->_view->assign('control_paginacion_est', $paginador->getControlPaginaion());
            $this->_view->assign('numeropagina_est', $paginador->getNumeroPagina());
        } 
        else 
        {
            $this->_view->assign("variables", $paginador->paginar($this->_model->getNombreVariables(""), "lista_variable", "", 1, 25));
            $this->_view->assign('paginacion_variables', $paginador->getView('paginacion_ajax', false));
            $this->_view->assign('control_paginacion_var', $paginador->getControlPaginaion());
            $this->_view->assign('numeropagina_var', $paginador->getNumeroPagina());
        }

        $this->_view->renderizar('variable', 'mapa');
    }

    public function _buscarVariable() 
    {
        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        //$id_recurso = $this->getInt('id_recurso');
        $idioma = Cookie::lenguaje();
        $condicion = "WHERE Var_Nombre LIKE '%$palabra%'";

        $this->_view->assign("variables", $paginador->paginar($this->_model->getNombreVariables($condicion), "lista_variable", "", 1, 25));
        $this->_view->assign('paginacion_variables', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion_var', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_var', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/lista_variable', false, true);
    }

    public function _buscarEstacion() 
    {
        $paginador = new Paginador();
        $palabra = $this->getSql('nombre');
        //$id_recurso = $this->getInt('id_recurso');
        $idioma = Cookie::lenguaje();
        //$condicion = "WHERE Var_Nombre LIKE '%$palabra%'";

        $this->_view->assign("estaciones", $paginador->paginar($this->_model->ListarEstacionCompleto($palabra), "lista_estacion", "", 1, 25));
        $this->_view->assign('paginacion_estaciones', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion_est', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_est', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/lista_estacion', false, true);
    }

    public function _paginacion_lista_variable() 
    {        
        $pagina = $this->getInt('pagina');
        $paginador = new Paginador();
        $idioma = Cookie::lenguaje();
        $palabra = $this->getSql('nombre');
        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "WHERE Var_Nombre LIKE '%$palabra%'";
        }
      
        $this->_view->assign("variables", $paginador->paginar($this->_model->getNombreVariables($condicion), "lista_variable", "", $pagina, 25));
        $this->_view->assign('paginacion_variables', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion_var', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_var', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/lista_variable', false, true);        
    }

    public function _paginacion_lista_estacion() 
    {        
        $pagina = $this->getInt('pagina');
        $paginador = new Paginador();
        $idioma = Cookie::lenguaje();
        $palabra = $this->getSql('nombre');
        if(trim($palabra)=="")
        {
            $condicion="";
        }
        else
        {
            $condicion = "WHERE Esm_Nombre LIKE '%$palabra%'";
        }
      
        $this->_view->assign("estaciones", $paginador->paginar($this->_model->ListarEstacionCompleto(""), "lista_estacion", "", $pagina, 25));
        $this->_view->assign('paginacion_estaciones', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion_est', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_est', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/lista_estacion', false, true);        
    }

    public function _paginacion_lista_variable_estacion() 
    {        
        $pagina = $this->getInt('pagina');
        $paginador = new Paginador();
        $idioma = Cookie::lenguaje();
        $id_variable = $this->getInt('id_variable');
        
        $this->_view->assign('estaciones', $paginador->paginar($this->_model->EstacionPorVariable($this->filtrarInt($id_variable),""),"lista_variable_estacion","", $pagina,25));
        $this->_view->assign('paginacion_estaciones', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion_est', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_est', $paginador->getNumeroPagina());  

        $this->_view->renderizar('ajax/lista_variable_estacion', false, true);
    }

    public function _paginacion_lista_estacion_variable() 
    {        
        $pagina = $this->getInt('pagina');
        $paginador = new Paginador();
        $idioma = Cookie::lenguaje();
        $id_estacion = $this->getInt('id_variable');

       $this->_view->assign("variables", $paginador->paginar($this->_model->VariablesPorEstacion($this->filtrarInt($id_estacion), ""), "lista_estacion_variable", $this->filtrarInt($id_estacion), $pagina, 25));
        $this->_view->assign('paginacion_variables', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion_var', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_var', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/lista_estacion_variable', false, true);
    }
    //Para monitoreo
    public function _paginacion_gestorcapa_lista_capas() 
    {
        //$this->validarUrlIdioma();
        $pagina = $this->getInt('pagina');

        $paginador = new Paginador();

        $this->_view->assign('capas', $paginador->paginar($this->_model->listarCapaWms(), "gestorcapa_lista_capas", '', $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/gestorcapa_lista_capas', false, true);
    }

    //Para monitoreo    

    //Para monitoreo
    public function _paginacion_estacion_lista_variables($idestacion) 
    {
        //$this->validarUrlIdioma();

        $pagina = $this->getInt('pagina');

        $paginador = new Paginador();

        $this->_view->assign("estadoeca", $this->_model->listarEstadoECA());
        $this->_view->assign("variables", $paginador->paginar($this->_model->VariablesPorEstacion($this->filtrarInt($idestacion), ""), "estacion_lista_variables", $this->filtrarInt($idestacion), $pagina, 25));
        
        $this->_view->assign('paginacion_variables', $paginador->getView('paginacion_ajax', false));
        $this->_view->assign('control_paginacion_var', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_var', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/estacion_lista_variables', false, true);
    }

    //Para monitoreo
    public function _puntosPorPais() 
    {
        //header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        if ($this->getPostParam('parametro')) 
        {
            // echo count(json_decode($this->getPostParam('parametro')));
            $datos = $this->_model->PuntosPorVariables(json_decode($this->getPostParam('parametro')));
            echo json_encode($datos);
            exit;
        }
        echo json_encode("{0:Faltan Parametros}");
    }

    public function _puntosPorVariable() 
    {
        //header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        if ($this->getPostParam('parametro')) 
        {
            // echo count(json_decode($this->getPostParam('parametro')));
            $datos = $this->_model->puntosPorVariablesCompleto(
                    json_decode($this->getPostParam('parametro')), Cookie::lenguaje()
            );
            echo json_encode($datos);
            exit;
        }
        echo json_encode("{0:Faltan Parametros}");
    }

    //Para monitoreo
    public function puntosPorPais($pais, $var) 
    {
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");

        // echo count(json_decode($this->getPostParam('parametro')));
        $datos = $this->_model->PuntosCompletoPorpais(
                explode(',', $pais), explode(',', $var)
        );
        echo json_encode($datos);
    }

    //Para monitoreo
    public function listartipoparam($pais) 
    {
        $arreglo = [$pais];

        print_r($this->_model->tiposParamCompletoPorpais($arreglo));
    }

    //Para monitoreo
    public function _ListarPais() 
    {
        // echo count(json_decode($this->getPostParam('parametro')));
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        $datos = $this->_model->listarPais();
        echo json_encode($datos);
    }

    public function _filtroEstacion() 
    {
        $paginador = new Paginador();

        $busqueda = $this->getSql('nombre');
        $idpais = $this->getInt('pais');
        $idrio = $this->getInt('rio');
        $idcuenca = $this->getInt('cuenca');

        $this->_view->assign('tb_nombre', $busqueda);
        $this->_view->assign('sl_pais', $idpais);
        $this->_view->assign('sl_rio', $idrio);
        $this->_view->assign('sl_cuenca', $idcuenca);

        $this->_view->assign("paises", $this->_model->listarPais());
        $this->_view->assign("rios", $this->_model->listarRioXCuenca($idcuenca));
        $this->_view->assign("cuencas", $this->_model->listarCuencaXpais($idpais));

        $this->_view->assign("estaciones", $paginador->paginar($this->_model->ListarEstacionCompleto($busqueda, $idpais, $idrio, $idcuenca), 'estacion_lista_estacion', ((empty($busqueda)) ? "-" : $busqueda) . "/" . $idpais . "/" . $idrio . "/" . $idcuenca, false, 25));
        $this->_view->assign('paginacion_estaciones', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion_est', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina_est', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/estacion_lista_estacion', false, true);
    }

    //Para monitoreo
    public function _exportaEstacionMonitoreo($idestacion, $idvars) 
    {
        error_reporting(0);
        if ($this->filtrarInt($idestacion)) 
        {
            $idvars = explode(',', $idvars);
            $temidvars = array();

            for ($i = 0; $i < count($idvars); $i++) 
            {
                if ($idvars[$i] != "") {
                    array_push($temidvars, $idvars[$i]);
                }
            }
            if (count($temidvars) > 0) 
            {
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
                $estadoeca = $this->_model->listarEstadoECA();
                $estacion = $this->_model->EstacionPorId($idestacion);

                $variables = $this->_model->ValorVariablesPorEstacionVariable($idestacion, $temidvars);

                //echo ($result["estacion"]["EstacionId"]);
                //Datos de la Estacion
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->setCellValue("A1", "Estacion " . $estacion["Esm_Nombre"]);
                $objPHPExcel->getActiveSheet()->setCellValue("A2", $estacion["Pai_Nombre"] . ", " . $estacion["Cue_Nombre"]);
                $objPHPExcel->getActiveSheet()->setCellValue("A3", "Latitud: " . $estacion["Esm_Latitud"]);
                $objPHPExcel->getActiveSheet()->setCellValue("A4", "Longitud: " . $estacion["Esm_Longitud"]);
                $objPHPExcel->getActiveSheet()->setTitle('Estacion');

                //datos de Leyenda
                $objPHPExcel->setActiveSheetIndex(2);
                $objPHPExcel->getActiveSheet()->setTitle('Leyenda');

                $rowNumber = 1; //start in cell 1
                foreach ($estadoeca as $row) 
                {                   // print_r($valor);
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

                foreach ($variables as $row) 
                {
                    $objPHPExcel->getActiveSheet()->setCellValue("A" . $rowNumber, $row["Var_Nombre"]);
                    $objPHPExcel->getActiveSheet()->setCellValue("B" . $rowNumber, $row["Var_Medida"]);
                    $objPHPExcel->getActiveSheet()->setCellValue("C" . $rowNumber, $row["Mca_Valor"]);
                    $objPHPExcel->getActiveSheet()->setCellValue("D" . $rowNumber, $row["EstadoECA"]);
                    $objPHPExcel->getActiveSheet()->setCellValue("E" . $rowNumber, ((strlen($row["Mca_Fecha"]) == 4) ? $row["Mca_Fecha"] : (substr($row["Mca_Fecha"], 6, 2) . '/' . substr($row["Mca_Fecha"], 4, 2) . '/' . substr($row["Mca_Fecha"], 0, 4))));

                    $rowNumber++;
                }
                
                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $objPHPExcel->getActiveSheet()->setTitle('GEF-OTCA');

                $objPHPExcel->setActiveSheetIndex(0);

                ob_end_clean();
                ob_start();
                Session::destroy('encabezado');
                Session::destroy('Descargar');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="SIIVisorCalidadAgua' . gmdate(' d M Y') . '.xls"');
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
        }

        /** Set Memory Limit 1.0 */
    }

    public function _perfilEstacion() 
    {
        $paginador = new Paginador();

        $this->_view->getLenguaje("monitoreo_perfil_estacion");
        $estadoeca = $this->_model->listarEstadoECA();
        $estacion = $this->_model->EstacionPorId($this->getPostParam('idestacion'));


        $this->_view->assign('variables', $this->_model->ValorVariablesPorEstacionVariable($this->getPostParam('idestacion'), json_decode($this->getPostParam('idvariables'))));
        //  $this->_view->assign('paginacion_variables', $paginador->getView('paginacion_ajax'));
        // $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', 1);

        $idvar = json_decode($this->getPostParam('idvariables'));

        $idvarstring = "";

        foreach ($idvar as $id) 
        {
            $idvarstring = $idvarstring . $id . ",";
        }

        $this->_view->assign('idvars', $idvarstring);
        $this->_view->assign('estadoeca', $estadoeca);
        $this->_view->assign('estacion', $estacion);
        $this->_view->renderizar('ajax/index_perfil_estacion', false, true);
    }

    public function _perfilEstacionM() 
    {
        $paginador = new Paginador();

        $this->_view->getLenguaje("monitoreo_perfil_estacion");
        $estadoeca = $this->_model->listarEstadoECA();
        $estacion = $this->_model->EstacionPorId($this->getPostParam('idestacion'));


        $this->_view->assign('variables', $this->_model->ValorVariablesPorEstacionVariable($this->getPostParam('idestacion'), json_decode($this->getPostParam('idvariables'))));
        //  $this->_view->assign('paginacion_variables', $paginador->getView('paginacion_ajax'));
        // $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', 1);

        $idvar = json_decode($this->getPostParam('idvariables'));

        $idvarstring = "";

        foreach ($idvar as $id) 
        {
            $idvarstring = $idvarstring . $id . ",";
        }

        $this->_view->assign('idvars', $idvarstring);
        $this->_view->assign('estadoeca', $estadoeca);
        $this->_view->assign('estacion', $estacion);
        $this->_view->renderizar('ajax/index_perfil_estacion_m', false, true);
    }

    //Gestion de Rios
    public function rio($padre = 0, $padreconten = false) 
    {
        $this->_acl->acceso('listar_rio');
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("monitoreo_rio");
        $this->_view->assign('titulo', 'Rios');
        $this->_view->setJs(array('index', array(BASE_URL . 'public/ckeditor/ckeditor.js'), array(BASE_URL . 'public/ckeditor/adapters/jquery.js')));

        $registros = $this->getInt('registros');
        $pagina = $this->getInt('pagina');
        $tipo = 'todos';
        $nombre = 'todos';
        $condicion = '';
        $condicion1 = '';
        $condicion2 = '';

        if ($this->botonPress("guardarPagina1")) 
        {
            $this->registrarPagina();
        }

        if ($this->botonPress("editarPagina1")) 
        {
            $this->editarPagina();
        }

        $id = $this->filtrarInt($padre);

        if ($id > 0) 
        {
            $condicion1 .= " WHERE Pag_IdPagina = $id ";
            $this->_view->assign('idiomas', $this->_arquitectura->getIdiomas());
            $original = $this->_arquitectura->getPagina($condicion1);
            $Idi_IdIdioma = $original['Idi_IdIdioma'];
            $this->_view->assign('datos', $original);
            $this->_view->assign('original', $original);
        } 
        else 
        {
            $Idi_IdIdioma = Cookie::lenguaje();
            $this->_view->assign('idiomaUrl', $Idi_IdIdioma);
        }

        $idCont = $this->filtrarInt($padreconten);

        if ($idCont) 
        {
            $condicion2 .= " WHERE Pag_IdPagina = $idCont ";
            $this->_view->assign('contenido', $this->_arquitectura->getPagina($condicion2));
        }

        $condicion .= " WHERE Pag_IdPrincipal = $id";
        // $this->_acl->acceso('admin');
        $paginador = new Paginador();
//        print_r($original);        
        $this->_view->assign('arquitectura', $paginador->paginar($this->_arquitectura->getPaginas($condicion, $Idi_IdIdioma), "listaregistros", "$tipo/'todos'/$nombre/$Idi_IdIdioma", $pagina, 25));
        $this->_view->assign('idiomas', $this->_arquitectura->getIdiomas());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('cantidadporpagina', $registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('index', 'arquitectura');
    }

    public function _getRio()
    {   
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("monitoreo_metadata");
       
        $id_pais = $this->getInt('id_pais');
        
        $this->_view->assign('rio', $this->_model->getRioxPais($id_pais));
        //$this->_view->assign('cantidad', count($this->_model->getRioxPais($id_pais)));
        
        //$this->_view->assign('subcuenca', $this->_model->getNombreSubCuenca($condicion));

        $this->_view->renderizar('ajax/lista_rio', false, true);
    }

    public function _getCuenca()
    {   
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("monitoreo_metadata");
       
        $id_rio = $this->getInt('id_rio');
        $condicion="WHERE rc.Rio_IdRio=$id_rio";

        //$this->_view->assign('cuenca', $this->_model->getNombreRioCuenca($condicion));
        $this->_view->assign('riocuenca', $this->_model->getNombreRioCuenca($condicion));

        //$this->_view->assign('subcuenca', $this->_model->getNombreSubCuenca($condicion));

        $this->_view->renderizar('ajax/lista_cuenca', false, true);
        //$this->_view->renderizar('ajax/lista_rio_cuenca', false, true);
    }

    public function _getSubCuenca()
    {   
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("monitoreo_metadata");

        $id_cuenca = $this->getInt('id_cuenca');
        $id_rio=$this->getInt('id_rio');

        $condicion="WHERE Cue_IdCuenca=$id_cuenca";
        $condicion2="WHERE rc.Cue_IdCuenca=$id_cuenca AND rc.Rio_IdRio=$id_rio";
        $this->_view->assign('subcuenca', $this->_model->getNombreSubCuenca($condicion));
        //$this->_view->assign('riocuenca', $this->_model->getNombreRioCuenca($condicion2));

        $this->_view->renderizar('ajax/lista_sub_cuenca', false, true);
    }

    public function _filtroEditar() 
    {
        $this->_view->getLenguaje("hidrogeo_ubigeo");
        $idpais = $this->getInt('idpais');
        $idterritorio1 = $this->getInt('idterritorio1');
        $idterritorio2 = $this->getInt('idterritorio2');
        $idterritorio3 = $this->getInt('idterritorio3');
        $idterritorio4 = $this->getInt('idterritorio4');  

        $this->_view->assign('ubigeos', $this->_ubigeos->getUbigeos());  

        $this->_view->assign('sl_pais', $idpais);
        $this->_view->assign('sl_territorio1', $idterritorio1);
        $this->_view->assign('sl_territorio2', $idterritorio2);
        $this->_view->assign('sl_territorio3', $idterritorio3);
        $this->_view->assign('sl_territorio4', $idterritorio4);

        $this->_view->assign('paises', $this->_ubigeos->getPaisUbigeo());
        $this->_view->assign('denominaciones', $this->_ubigeos->getDenominacionTerritorioxPais($idpais));
        $this->_view->assign('territorios1', $this->_ubigeos->getTerritorios1($idpais));
        $this->_view->assign('territorios2', $this->_ubigeos->getTerritorios2($idpais));
        $this->_view->assign('territorios3', $this->_ubigeos->getTerritorios3($idpais));
        $this->_view->assign('territorios4', $this->_ubigeos->getTerritorios4($idpais));

        $this->_view->renderizar('ajax/lista_ubigeo', false, true);
    }    
}

?>
