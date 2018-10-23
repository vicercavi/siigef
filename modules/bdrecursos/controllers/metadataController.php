<?php

class metadataController extends bdrecursosController
{
    private $_metadata; 

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_bdrecursos = $this->loadModel('indexbd');
        $this->_metadata = $this->loadModel('metadata');
        //$this->_registros = $this->loadModel('registros','estandar');    
    }

    public function index($idrecurso = false) 
    {
        if(!is_numeric($idrecurso))$this->redireccionar("bdrecursos");
        $this->_acl->autenticado();
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->setJs(array('index'));
        //$this->_view->setCss(array('metadata'));
        $paginador = new Paginador();


        $recurso = $this->_bdrecursos->getRecursoCompletoXid($idrecurso);
        
        if ($recurso) 
        {
            if ($this->botonPress("bt_registrar_metadata") && 
                $this->_acl->permiso("editar_metadata_recurso")) 
            {
                $metadata=$this->_metadata->getMetadata("");
                //echo strtolower($this->getTexto("tb_titulo_metadata")).'<br>';
                //print_r($metadata); exit();
            
                $a=0;
                
                for ($i=0; $i < count($metadata); $i++) 
                {                            
                    if(strtolower($this->getTexto("tb_titulo_metadata"))==strtolower($metadata[$i]['Met_Titulo']))
                    {
                        $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getTexto("tb_titulo_metadata") . '</b> no pudo ser registrado, nombre existente');               
                        $a=1;
                    }            
                }

                if($a==0)
                {      
                    $id_meta = $this->_metadata->insertarMetadada($this->getTexto("tb_titulo_metadata"), $this->getTexto("tb_nombre_metadata"), $this->getTexto("tb_tabla_metadata"), $this->getTexto("tb_proveedor_metadata"), $this->getTexto("tb_cadena_conexion_metadata"), $this->getTexto("tb_descripcion_metadata"), $this->getTexto("tb_campo_visible_metadata"), $this->getTexto("tb_titulo_cabecera_metadata"), $this->getTexto("tb_cambpo_search_metadata"), 0, $this->getTexto("tb_clasificacion_metadata"), $this->getTexto("tb_sub_clasificacion_metadata"), $this->getTexto("tb_ambito_metadata"), $this->getTexto("tb_poblacion_obj_metadata"), $this->getTexto("tb_estado_actualizacion_metadata"), $this->getTexto("tb_contacto_responsable_metadata"), $this->getTexto("tb_formato_version_metadata"), $this->getTexto("tb_info_relacionada_metadata"), $this->getTexto("tb_metodologia_metadata"), $this->getTexto("tb_georreferenciacion_metadata"), $this->getTexto("tb_restriccion_metadata"), $this->getTexto("tb_restriccion_acceso_metadata"), $this->getTexto("tb_derecho_autor_metadata"), $this->getTexto("tb_nodo_metadata"), $this->getTexto("tb_nombre_institucion_metadata"), $this->getTexto("tb_web_institucion_metadata"), $this->getTexto("tb_direccion_institucion_metadata"), $this->getTexto("tb_telefono_institucion_metadata"), $this->getTexto("tb_tipo_institucion_metadata"), $this->getTexto("tb_nombre_unidad_info_metadata"), $this->getTexto("tb_web_unidad_info_metadata"), $this->getTexto("tb_direccion_unidad_info_metadata"), $this->getTexto("tb_telefono_unidad_info_metadata"), $this->getTexto("tb_categoria_metadata"), $this->getTexto("tb_sub_categoria_metadata"), $idrecurso, "es", $this->getTexto("tb_palabrasclaves_metadata"), $this->getTexto("tb_tipoagregacion_metadata"), $this->getTexto("tb_idiomarecurso_metadata"), $this->getTexto("tb_urlwebservice_metadata")
                );    
                    if ($id_meta[0] > 0) 
                    {
                        $this->_view->assign('_mensaje', 'Metadata <b style="font-size: 1.15em;">' . $this->getTexto("tb_titulo_metadata") . '</b> registrado..!!');
                    } 
                    else 
                    {
                        $this->_view->assign('_error', 'Error en el registro');
                    }                     
                }             

                if (isset($id_meta) && !empty($id_meta))
                {
                    
                }
            } 
            else if ($this->botonPress("bt_actulizar_metadata") && 
                $this->_acl->permiso("editar_metadata_recurso")) 
            {
                $id_metadata = $this->getInt("hd_id_metadata");
                
                $metadata=$this->_metadata->getMetadata("WHERE Met_IdMetadata!=$id_metadata");
                
                $a=0;
                
                for ($i=0; $i < count($metadata); $i++) 
                {                       
                    if(strtolower($this->getTexto("tb_titulo_metadata"))==strtolower($metadata[$i]['Met_Titulo']))
                    {
                        $this->_view->assign('_error', 'El nombre <b style="font-size: 1.15em;">' . $this->getTexto("tb_titulo_metadata") . '</b> no pudo ser editado, nombre existente');               
                        $a=1;
                    }            
                }

                if($a==0)
                {      
                    $id_meta = $this->_metadata->actualizarMetadada($this->getInt("hd_id_metadata"), $this->getTexto("tb_titulo_metadata"), $this->getTexto("tb_nombre_metadata"), $this->getTexto("tb_tabla_metadata"), $this->getTexto("tb_proveedor_metadata"), $this->getTexto("tb_cadena_conexion_metadata"), $this->getTexto("tb_descripcion_metadata"), $this->getTexto("tb_campo_visible_metadata"), $this->getTexto("tb_titulo_cabecera_metadata"), $this->getTexto("tb_cambpo_search_metadata"), 0, $this->getTexto("tb_clasificacion_metadata"), $this->getTexto("tb_sub_clasificacion_metadata"), $this->getTexto("tb_ambito_metadata"), $this->getTexto("tb_poblacion_obj_metadata"), $this->getTexto("tb_estadoactualizacion_metadata"), $this->getTexto("tb_contacto_responsable_metadata"), $this->getTexto("tb_formato_version_metadata"), $this->getTexto("tb_info_relacionada_metadata"), $this->getTexto("tb_metodologia_metadata"), $this->getTexto("tb_georreferenciacion_metadata"), $this->getTexto("tb_restriccion_metadata"), $this->getTexto("tb_restriccion_acceso_metadata"), $this->getTexto("tb_derecho_autor_metadata"), $this->getTexto("tb_nodo_metadata"), $this->getTexto("tb_nombre_institucion_metadata"), $this->getTexto("tb_web_institucion_metadata"), $this->getTexto("tb_direccion_institucion_metadata"), $this->getTexto("tb_telefono_institucion_metadata"), $this->getTexto("tb_tipo_institucion_metadata"), $this->getTexto("tb_nombre_unidad_info_metadata"), $this->getTexto("tb_web_unidad_info_metadata"), $this->getTexto("tb_direccion_unidad_info_metadata"), $this->getTexto("tb_telefono_unidad_info_metadata"), $this->getTexto("tb_categoria_metadata"), $this->getTexto("tb_sub_categoria_metadata"), $this->getTexto("tb_palabrasclaves_metadata"), $this->getTexto("tb_tipoagregacion_metadata"), $this->getTexto("tb_idiomarecurso_metadata"), $this->getTexto("tb_urlwebservice_metadata")
                );

                    if ($id_meta[0] >= 0) 
                    {
                        $this->_view->assign('_mensaje', 'Metadata <b style="font-size: 1.15em;">'. $this->getTexto("tb_titulo_metadata") . '</b> actualizado..!!');
                    } 
                    else 
                    {
                        $this->_view->assign('_error', 'Error al actualizar');
                    }                     
                }
                
                if (isset($id_meta) && !empty($id_meta)) 
                {
                    
                }
            } 
            else if ($this->botonPress("bt_editar_metadata")) 
            {
                if ($this->_acl->permiso("editar_metadata_recurso")) 
                {
                    $this->_view->assign('editar', true);
                }
            }

            

            $this->_view->assign('fichaestandar', $this->_bdrecursos->getFichaEstandarXRecurso($recurso["Rec_IdRecurso"]));

            switch ($recurso["Esr_IdEstandarRecurso"]) 
            {
                case 5:

                    $this->_view->setJs(array(
                    array('https://maps.googleapis.com/maps/api/js?key=AIzaSyDPJoejdRh3XakrIcqEzI4kJguJxJrC9eg', true),
                    array("http://maps.stamen.com/js/tile.stamen.js?v1.2.1", false),
                    array(BASE_URL . "public/js/googlemaps.js", false),
                    'metadata_googlemaps',
                    array(BASE_URL . "public/js/document_ready.js", false),
                    'document_ready',
                    'index'
                    //'geoxml3',
                    //'ProjectedOverlay',
                    //'ZipFile.complete'
                    ));

                    $this->_view->setCss(array('gestor_capa', array(BASE_URL . "public/css/visor.css", true)));

                    $bdmapa = $this->loadModel('mapa', true);

                    $capas = $bdmapa->CapasCompletoXIdrecursoXMetadata($recurso["Rec_IdRecurso"]);

                    $idcapa = $capas[0]['Cap_Idcapa']; 

                    //$this->_cargaWMS($idcapa);

                    $this->_mapa = $this->loadModel('mapa', true);

                    $capa = $this->_mapa->obtnerCapaPor($this->filtrarInt($idcapa));

                    if ($capa) 
                    {
                        $this->_view->assign('capa', $capa);                    
                    }

                    $this->_view->assign('capas', $capas);
                     $this->_view->assign('titulo', 'Metadata Recurso '.$recurso["Esr_Nombre"].": ".$capa["Cap_Titulo"]);

                    break;

                default:
                    $metadata = $this->_bdrecursos->getMetadadaXRecurso($recurso["Rec_IdRecurso"]);
                    $this->_view->assign('metadata', $metadata);
                    break;
            }

            switch (str_replace(' ', '', strtolower($recurso['Esr_Nombre']))) 
            {
                case 'calidaddeagua':
                    $controlador = '0';
                    break;

                case 'legislacion':
                    $controlador = '1';
                    break;

                case 'dublincore':
                    $controlador = '1';
                    break;

                case 'darwincore':
                    $controlador = '1';
                    break;

                case 'pliniancore':
                    $controlador = '1';
                    break;

                default:

                    $recurso = $this->_bdrecursos->getRecursoCompletoXid($idrecurso);

                    $this->_view->assign('fichaestandar', $this->_bdrecursos->getFichaEstandarXRecurso($recurso["Rec_IdRecurso"]));

                    $idEstandarRecurso = $recurso["Esr_IdEstandarRecurso"];
                    $this->_estandar = $this->loadModel('index', 'estandar');
                    $estandar_recurso = $this->_estandar->getEstandar_recurso("WHERE Esr_IdEstandarRecurso=$idEstandarRecurso");

                    $tipoEstandarRecurso = $estandar_recurso[0]['Esr_Tipo'];

                    if ($tipoEstandarRecurso==2) 
                    {
                        $controlador='3';   
                    }
                    else
                    {
                        $controlador = '2';
                    }
            }
            $this->_view->assign('titulo', 'Metadata de Recurso '.$recurso["Esr_Nombre"]);
            $this->_view->assign('controlador', $controlador);
            $this->_view->assign('recurso', $recurso);
            $this->_view->assign('idrecurso', $idrecurso);
            $this->_view->renderizar('index', 'metadata');
        } 
        else 
        {
            $this->redireccionar("bdrecursos");
        }

       
    }

      
        
}
?>