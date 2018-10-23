<?php
class indexController extends bdrecursosController
{
    private $_bdrecursos;    
    private $_import;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_bdrecursos = $this->loadModel('indexbd');
        $this->_import = $this->loadModel('import');
        $this->_registros = $this->loadModel('registros','estandar');  
        $this->_mapa = $this->loadModel('mapa', true);       
    }

    public function index($idrecurso = false) 
    {
        $this->_acl->acceso("listar_recurso");
        $this->validarUrlIdioma();
        //$this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("bdrecursos_index");
        $paginador = new Paginador();

        $this->_view->setJs(array(array(BASE_URL . "getDocumentospublic/js/bootstrap-table.min.js", 
        false), 'bdrecursos'));

        $this->_view->setCss(array(array(BASE_URL . "public/css/bootstrap-table.min.css", false),
        'index'));

        if ($this->botonPress("bt_registrar")) 
        {
            if ($this->getTexto("tb_nombre_recurso") && $this->getTexto("tb_fuente_recurso") &&
                $this->getTexto("tb_origen_recurso") && $this->getTexto("sl_estandar_recurso")) 
            {
                $id_estandar = $this->getTexto("sl_estandar_recurso");
                $estandar_recurso = $this->_registros->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=".$id_estandar."");
                $tipoEstandarRecurso = $estandar_recurso[0]['Esr_Tipo'];

                $recursos = $this->_bdrecursos->getRecursosIndex();        
                
                $a=0;
                
                for ($i=0; $i < count($recursos); $i++) 
                {                               
                    if(strtolower($this->getTexto('tb_nombre_recurso'))==strtolower($recursos[$i]['Rec_Nombre']))
                    {
                        $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getTexto('tb_nombre_recurso') . '</b> no pudo ser registrado, nombre existente');
                        $a=1;
                    }            
                }

                if($a==0)
                {   
                    $nombre_tabla = ''; 
                    
                    if($tipoEstandarRecurso == 2)
                    {
                        //Para crear la tabla data (x cada recurso)

                        $fichaEstandar = $this->_registros->getFichaEstandar($id_estandar);

                        $nombre_tabla = 'data_'.$fichaEstandar[0]['Fie_NombreTabla'];

                        $tabla_data_x_recurso = $this->_bdrecursos->getTablaData($nombre_tabla); 

                        if(!empty($tabla_data_x_recurso))
                        {
                            $i=str_replace('data_'.$fichaEstandar[0]['Fie_NombreTabla'].'_', '', $tabla_data_x_recurso[0]);

                            $i = $this->filtrarInt($i[0]);

                            $ii = $i+1; 
                            $nombre_tabla = 'data_'.$fichaEstandar[0]['Fie_NombreTabla'].'_'.$ii;
                        }
                        else
                        {
                            $nombre_tabla = 'data_'.$fichaEstandar[0]['Fie_NombreTabla'].'_1'; 
                        }
                    } 

                    $idrecurrso = $this->_bdrecursos->insertarRecurso($this->getTexto("tb_nombre_recurso"), 
                    $this->getTexto("tb_fuente_recurso"), $this->getTexto("hd_tipo_recurso"), 0, 
                    $this->getTexto("sl_estandar_recurso"), $this->getTexto("tb_origen_recurso"), $nombre_tabla, 'es');

                    if ($idrecurrso[0] > 0) 
                    {
                        $this->redireccionar("bdrecursos/metadata/" . $idrecurrso[0]);
                    } 
                    else 
                    {
                        $this->_view->assign('_error', 'No se pudo registrar el recurso: ' . $idrecurrso);
                    }                    
                }                
            } 
            else 
            {
                $this->_view->assign('_error', 'Debe Ingresar los Campos Obligatorios (*)');
            }
        } 
        else if ($this->botonPress("bt_actualizar")) 
        {
            if ($this->getTexto("tb_nombre_recurso") && $this->getTexto("tb_fuente_recurso") &&
                $this->getTexto("tb_origen_recurso")) 
            {
                $idrecurrso = $this->_bdrecursos->actualizarRecurso($this->filtrarInt($recurso), $this->getTexto("tb_nombre_recurso"), $this->getTexto("tb_fuente_recurso"), $this->getTexto("tb_origen_recurso"));

                if ($idrecurrso > 0) 
                {
                    $this->_view->assign('_mensaje', 'Operación ejecutada con éxito.');
                } 
                else 
                {
                    $this->_view->assign('_error', 'No se pudo actualizar el recurso: ' . $idrecurrso);
                }
            } 
            else 
            {
                $this->_view->assign('_error', 'Debe Ingresar los Campos Obligatorios (*)');
            }
        }
        
        if ($this->filtrarInt($idrecurso)) 
        {            
            $this->_acl->acceso("editar_recurso");
            $recurso = $this->_bdrecursos->getRecursoCompletoXid($this->filtrarInt($idrecurso));

            if (isset($recurso) && !empty($recurso)) 
            {
                if($recurso['Tir_IdTipoRecurso'] == 2)
                {
                    $capa = $this->_mapa->CapasCompletoXIdrecurso($idrecurso);
                    $id_capa = $capa[0]['Cap_Idcapa'];
                    $this->redireccionar("mapa/gestorcapa/wms/$id_capa");
                }
                else
                {
                    $this->_view->assign('recurso', $recurso);
                }
            } 
            else 
            {
                $this->redireccionar("bdrecursos");
            }
        } 

        

        $bdarquitectura = $this->loadModel('index', 'arquitectura');
        $this->_view->assign('idioma', Cookie::lenguaje());
        $this->_view->assign('idiomas', $bdarquitectura->getIdiomas());

        $bdherramienta = $this->loadModel('herramienta', true);
        $this->_view->assign('registros', $paginador->paginar($this->_bdrecursos->getRecursosCompleto(), "lista_recursos", "", false, 25));
        $this->_view->assign('tiporecurso', $this->_bdrecursos->getTipoRecurso());
        $this->_view->assign('origenrecurso', $this->_bdrecursos->getOrigenRecurso());
        $this->_view->assign('fuente', $this->_bdrecursos->getFuente());
        $this->_view->assign('herramientas', $bdherramienta->getHerramienta());
        $this->_view->assign('estandar', $this->_bdrecursos->getEstandar());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->assign('titulo', 'Banco de Recursos');
        $this->_view->renderizar('index', 'bdrecursos');    
    }

    public function _filtroRecursos() 
    {
        $this->_view->getLenguaje("bdrecursos_index");
        $paginador = new Paginador();

        $tipo = $this->getTexto('tipo');
        $nombre = $this->getSql('nombre');
        $estandar = $this->getInt('estandar');
        $fuente = $this->getTexto('fuente');
        $origen = $this->getTexto('origen');
        $herramienta = $this->getInt('herramienta');

        $this->_view->assign('nombre', $nombre);
        $this->_view->assign('sl_estandar', $estandar);
        $this->_view->assign('sl_fuente', $fuente);
        $this->_view->assign('sl_origen', $origen);
        $this->_view->assign('sl_herramienta', $herramienta);

        $bdherramienta = $this->loadModel('herramienta', true);

        $this->_view->assign('registros', $paginador->paginar($this->_bdrecursos->getRecursosCompleto($tipo, $nombre, $estandar, $fuente, $origen, $herramienta), "lista_recursos", "", false, 25));
        $this->_view->assign('tiporecurso', $this->_bdrecursos->getTipoRecurso());
        $this->_view->assign('origenrecurso', $this->_bdrecursos->getOrigenRecurso());
        $this->_view->assign('fuente', $this->_bdrecursos->getFuente());
        $this->_view->assign('herramientas', $bdherramienta->getHerramienta());
        $this->_view->assign('estandar', $this->_bdrecursos->getEstandar());
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/lista_recursos', false, true);
    }

    public function _actualizarEstado() 
    {
        $pagina = $this->getInt('pagina');
        $this->_view->getLenguaje("bdrecursos_index");

        $paginador = new Paginador();

        $idrecurso = $this->getInt('idrecurso');
        $estado = $this->getInt('estado');

        $tipo = $this->getTexto('tipo');
        $nombre = $this->getTexto('nombre');
        $estandar = $this->getInt('estandar');
        $fuente = $this->getTexto('fuente');
        $origen = $this->getTexto('origen');
        $herramienta = $this->getInt('herramienta');

        $this->_bdrecursos->actualizarEstadoRecurso($idrecurso, $estado);

        $this->_view->assign('nombre', $nombre);
        $this->_view->assign('sl_estandar', $estandar);
        $this->_view->assign('sl_fuente', $fuente);
        $this->_view->assign('sl_origen', $origen);
        $this->_view->assign('sl_herramienta', $herramienta);

        $bdherramienta = $this->loadModel('herramienta', true);
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

        $bdherramienta = $this->loadModel('herramienta', true);
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

    public function _paginacion_lista_recursos() 
    {
        $pagina = $this->getInt('pagina');
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("bdrecursos_index");
        $paginador = new Paginador();

        $tipo = $this->getTexto('tipo');
        $nombre = $this->getSql('nombre');
        $estandar = $this->getInt('estandar');
        $fuente = $this->getTexto('fuente');
        $origen = $this->getTexto('origen');
        $herramienta = $this->getInt('herramienta');

        $this->_view->assign('nombre', $nombre);
        $this->_view->assign('sl_estandar', $estandar);
        $this->_view->assign('sl_fuente', $fuente);
        $this->_view->assign('sl_origen', $origen);
        $this->_view->assign('sl_herramienta', $herramienta);

        $bdherramienta = $this->loadModel('herramienta', true);
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

    public function _getTraduccionRecurso() 
    {
        //$this->validarUrlIdioma();
        $idrecurso = $this->getInt("idrecurso");
        $idIdioma = $this->getTexto("idIdioma");
        $idIdiomaO = $this->getTexto("idIdiomaO");

        $recurso = $this->_bdrecursos->getRecursoMetadataTraducido($idrecurso, Cookie::lenguaje());

        if ($recurso["Idi_IdIdioma"] != $idIdioma) 
        {
            $recurso["Rec_Nombre"] = "";
            $recurso["Rec_Fuente"] = "";
            $recurso["Rec_Origen"] = "";
            $recurso["Idi_IdIdioma"] = "";
        }

        $this->_view->assign('recurso', $recurso);
        $this->_view->assign('idIdiomaO', $idIdiomaO);
        $this->_view->renderizar('ajax/index_nuevo_recurso', false, true);
    }
     
}
?>