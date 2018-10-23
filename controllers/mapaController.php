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
class mapaController extends Controller 
{
    private $_mapa;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_mapa = $this->loadModel('mapa');
    }

    private $_xml_wms;

    //Para monitoreo
    public function index() 
    {
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->redireccionar();
    }

    public function visorOL() 
    {
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Visualizador GEF');
        $this->_view->setJs(array(
            array(BASE_URL . "public/olv3.1.1/build/ol.js", true),
            'openlayer',
            'areatematica',
            array(BASE_URL . "public/js/document_ready.js", false),
            'acordeon'));
        $this->_view->setCss(array(
            array(BASE_URL . "public/olv3.1.1/css/ol.css", true),
            'acordeon',
            array(BASE_URL . "public/css/visor.css", true)));
        $this->_view->assign('capas', $this->_jerarquiacompleto());
        $this->_view->assign('pais', $this->_mapa->listarPais());
        $this->_view->renderizar('index', 'mapa');
    }

    public function visorOLgm() 
    {
        $this->validarUrlIdioma();
        $this->_view->assign('titulo', 'Visualizador GEF');
        $this->_view->setJs(array(
            array(BASE_URL . "public/olv3.1.1/build/ol.js", true),
            array("http://maps.google.com/maps/api/js?v=3&amp;sensor=false", true),
            'openlayergm',
            'areatematica',
            array(BASE_URL . "public/js/document_ready.js", false),
            'acordeon'));
        $this->_view->setCss(array(
            array(BASE_URL . "public/olv3.1.1/css/ol.css", true),
            'acordeon',
            array(BASE_URL . "public/css/visor.css", true)));
        $this->_view->assign('capas', $this->_jerarquiacompleto());
        $this->_view->assign('pais', $this->_mapa->listarPais());
        $this->_view->renderizar('index', 'mapa');
    }

    public function gestorcapa($tipocapa = false, $idcapa = false) 
    {
        $this->_acl->acceso("listar_capa");
        $this->validarUrlIdioma();
        $paginador = new Paginador();
        $this->_view->getLenguaje("template_backend");
        $this->_view->assign('titulo', 'Gestor Capas');
        $this->_view->setJs(array(
            array('https://maps.googleapis.com/maps/api/js?key=AIzaSyDPJoejdRh3XakrIcqEzI4kJguJxJrC9eg', true),
            array("http://maps.stamen.com/js/tile.stamen.js?v1.2.1", false),
            array(BASE_URL . "public/js/googlemaps.js", false),
            'gestorcapas',
            array(BASE_URL . "public/js/document_ready.js", false),
            'document_ready',
            //'geoxml3',
            //'ProjectedOverlay',
            //'ZipFile.complete'
            ));

        $this->_view->setCss(array('gestor_capa', array(BASE_URL . "public/css/visor.css", true)));
        
        switch ($tipocapa) 
        {
            case false:
                $this->_cargaWMS($idcapa);
                break;
            case 'wms':
                $this->_cargaWMS($idcapa);
                break;         
            case 'georss':
                $this->_cargarGEORSS($idcapa);
                break;
            case 'geojson':
                $this->_cargarGEOJSON($idcapa);                 
                break;
            case 'kml':
                $this->_cargarKML();                
                break;          
            case 'imagenes':
                $this->_view->assign("timagenes", "active");
                break;        
            default:
                $this->redireccionar("mapa/gestorcapa/");
                break;
        }

        if ($this->_acl->permiso("editar_capa")&&$this->filtrarInt($idcapa)) 
        {
            if ($this->botonPress('bt_editar_capa')) {
                $capa = $this->_mapa->obtnerCapaPor($this->filtrarInt($idcapa));
                $url_base="";
                $url_capa="";
                $nombre="";
                
                switch ($tipocapa) {                 
                    case 'wms':
                        if($this->getPostParam('hd_urlbase')){
                            $url_base=$this->getSql('hd_urlbase');
                            $url_capa=($this->getInt('hd_carga_avanzada')) ? $this->getSql('hd_url_capa') : "";
                            $nombre=($this->getPostParam('cb_layeredit'))?$this->getPostParam('cb_layeredit'):$this->getPostParam('cmb_layer');
                        }else{
                            $url_base = $capa["Cap_UrlBase"];
                            $url_capa = $capa["Cap_UrlCapa"];
                            $nombre = $capa["Cap_Nombre"];
                        }
                        break;
                    case 'georss':
                        if ($this->getPostParam('url_rss')) {
                            $url_capa = $this->getPostParam('url_rss');
                            $protocolos = array('http://', 'https://', 'ftp://', 'www.');
                            $urs = explode('/', str_replace($protocolos, '', $url_capa));
                            $url_base=$urs[0];
                        }else{
                            $url_base = $capa["Cap_UrlBase"];
                            $url_capa = $capa["Cap_UrlCapa"];
                            $nombre = $capa["Cap_Nombre"];
                        }
                        break;
                    case 'geojson':
                        if($this->getPostParam('hd_url_json')){
                        $tipo_json = $this->getPostParam('hd_tipo_json');
                        $url_json = $this->getPostParam('hd_url_json');

                        if ($tipo_json == "url") {
                            $protocolos = array('http://', 'https://', 'ftp://', 'www.');
                            $url_base = explode('/', str_replace($protocolos, '', $url_json))[0];
                            $url_capa=$url_json;
                            $nombre = "";                        
                        } else {
                        
                               //echo $this->getPostParam('hd_urlbase');
                            $url_base = BASE_URL . 'archivosFisicos/json/';
                            //Mover archivo de sitio temporal
                            $nombre = $url_json;
                            $url_capa = $url_base . $nombre;
                            $ruta_final = ROOT . 'archivosFisicos' . DS . 'json' . DS . $nombre;
                            $temp_file = ROOT . 'tmp' . DS . 'varios' . DS . $nombre;

                            if (is_readable($temp_file)) {
                                rename($temp_file, $ruta_final);
                            }
                        }
                        }else{
                            $url_base = $capa["Cap_UrlBase"];
                            $url_capa = $capa["Cap_UrlCapa"];
                            $nombre = $capa["Cap_Nombre"];
                        }
                        break;
                    case 'kml':                        
                        if($this->getPostParam('hd_edit_nombrekml')){
                            $url_base = BASE_URL . 'archivosFisicos/kml/';
                            //Mover archivo de sitio temporal
                            $nombre = $this->getPostParam('hd_edit_nombrekml');
                            $ruta_final = ROOT . 'archivosFisicos' . DS . 'kml' . DS . $nombre;
                            $temp_file = ROOT . 'tmp' . DS . 'varios' . DS . $nombre;
                            
                            $url_capa=$ruta_final.$nombre;
                            try {
                                if(is_readable($temp_file))
                                    rename($temp_file, $ruta_final);
                                else
                                    $this->_view->assign('_error','No se logro guardar el archivo kml');
                            } catch (Exception $exc) {                             
                                $contenido = $exc->getTraceAsString();                                
                                $this->_view->assign('_error',$contenido);
                            }
                        }else{
                            $url_base = $capa["Cap_UrlBase"];
                            $url_capa = $capa["Cap_UrlCapa"];
                            $nombre = $capa["Cap_Nombre"];
                        }
                      
                        break;
                    case 'imagenes':
                        $this->_view->assign("timagenes", "active");
                        break;
                }


                
                $capa = array(
                    'Cap_Idcapa' => $capa['Cap_Idcapa'],
                    'Cap_UrlBase' => $url_base,
                    'Cap_UrlCapa' => $url_capa,
                    'Cap_Fuente' => $this->getPostParam('tb_iCap_Fuente'),
                    'Cap_Nombre' => $nombre,
                    'Cap_Titulo' => $this->getSql('tb_titulocapa'),
                    'Cap_PalabrasClaves2' => $this->getSql('tb_iCap_PalabrasClaves2'),
                    'Cap_Resumen' => $this->getSql('tb_iCap_Resumen'),
                    'Cap_Descripcion' => $this->getSql('tb_iCap_Descripcion'),
                    'Cap_Creditos' => $this->getSql('tb_iCap_Creditos'),
                    'Cap_Leyenda' => $this->getPostParam('tb_leyendaurl'),
                    'Cap_imagenprev' => $capa['Cap_imagenprev'],
                    'Cap_IdentificadorFichero1' => $this->getTexto('tb_iCap_IdentificadorFichero1'),
                    'Cap_Idioma1' => $this->getTexto('tb_iCap_Idioma1'),
                    'Cap_FechaCreacion1' => $this->getTexto('tb_iCap_FechaCreacion1'),
                    'Cap_NormaMetadatos1' => $this->getTexto('tb_iCap_NormaMetadatos1'),
                    'Cap_VersionNormaMetadatos1' => $this->getTexto('tb_iCap_VersionNormaMetadatos1'),
                    'Cap_NombreIndividualdeContacto1' => $this->getTexto('tb_iCap_NombreIndividualdeContacto1'),
                    'Cap_NombredelaOrganizaciondeContacto1' => $this->getTexto('tb_iCap_NombredelaOrganizaciondeContacto1'),
                    'Cap_CorreodelContacto1' => $this->getTexto('tb_iCap_CorreodelContacto1'),
                    'Cap_RoldelContacto1' => $this->getTexto('tb_iCap_RoldelContacto1'),
                    'Cap_TituloMencion2' => $this->getTexto('tb_iCap_TituloMencion2'),
                    'Cap_FechaMencion2' => $this->getTexto('tb_iCap_FechaMencion2'),
                    'Cap_TipoFechaMencion2' => $this->getTexto('tb_iCap_TipoFechaMencion2'),
                    'Cap_FormaPresentacionMencion2' => $this->getTexto('tb_iCap_FormaPresentacionMencion2'),
                    'Cap_Resumen2' => $this->getTexto('tb_iCap_Resumen2'),
                    'Cap_Proposito2' => $this->getTexto('tb_iCap_Proposito2'),
                    'Cap_Estado2' => $this->getTexto('tb_iCap_Estado2'),
                    'Cap_NombreIndividualPuntoContacto2' => $this->getTexto('tb_iCap_NombreIndividualPuntoContacto2'),
                    'Cap_NombreOrganizacionPuntoContacto2' => $this->getTexto('tb_iCap_NombreOrganizacionPuntoContacto2'),
                    'Cap_CorreoElectronicoPuntoContacto2' => $this->getTexto('tb_iCap_CorreoElectronicoPuntoContacto2'),
                    'Cap_RolPuntodeContacto2' => $this->getTexto('tb_iCap_RolPuntodeContacto2'),
                    'Cap_NombreFicherodeVistadelGrafico2' => $this->getTexto('tb_iCap_NombreFicherodeVistadelGrafico2'),
                    'Cap_DescripcionFicherodeVistadelGrafico2' => $this->getTexto('tb_iCap_DescripcionFicherodeVistadelGrafico2'),
                    'Cap_TipoFicherodeVistadelGrafico2' => $this->getTexto('tb_iCap_TipoFicherodeVistadelGrafico2'),
                    'Cap_PalabraClaveDescripcionPC2' => $this->getTexto('tb_iCap_PalabraClaveDescripcionPC2'),
                    'Cap_TipoDescripcionPC2' => $this->getTexto('tb_iCap_TipoDescripcionPC2'),
                    'Cap_TipodeRepresentacionEspacial2' => $this->getTexto('tb_iCap_TipodeRepresentacionEspacial2'),
                    'Cap_ResolucionEspacial2' => $this->getTexto('tb_iCap_ResolucionEspacial2'),
                    'Cap_Idioma2' => $this->getTexto('tb_iCap_Idioma2'),
                    'Cap_CategoriadeTema2' => $this->getTexto('tb_iCap_CategoriadeTema2'),
                    'Cap_LimiteLongitudOeste2' => $this->getTexto('tb_iCap_LimiteLongitudOeste2'),
                    'Cap_LimiteLongitudEste2' => $this->getTexto('tb_iCap_LimiteLongitudEste2'),
                    'Cap_LimiteLatitudSur2' => $this->getTexto('tb_iCap_LimiteLatitudSur2'),
                    'Cap_LimiteLatitudNorte2' => $this->getTexto('tb_iCap_LimiteLatitudNorte2'),
                    'Cap_Extension2' => $this->getTexto('tb_iCap_Extension2'),
                    'Cap_ValorMinimo2' => $this->getTexto('tb_iCap_ValorMinimo2'),
                    'Cap_ValorMaximo2' => $this->getTexto('tb_iCap_ValorMaximo2'),
                    'Cap_UnidadesdeMedida2' => $this->getTexto('tb_iCap_UnidadesdeMedida2'),
                    'Cap_LimitaciondeUso3' => $this->getTexto('tb_iCap_LimitaciondeUso3'),
                    'Cap_ConstriccionesdeAcceso3' => $this->getTexto('tb_iCap_ConstriccionesdeAcceso3'),
                    'Cap_ConstriccionesdeUso3' => $this->getTexto('tb_iCap_ConstriccionesdeUso3'),
                    'Cap_ConstriccionesdeOtroTipo3' => $this->getTexto('tb_iCap_ConstriccionesdeOtroTipo3'),
                    'Cap_Nivel4' => $this->getTexto('tb_iCap_Nivel4'),
                    'Cap_Declaracion4' => $this->getTexto('tb_iCap_Declaracion4'),
                    'Cap_FrecuenciadeMantenimientoyActualizacion5' => $this->getTexto('tb_iCap_FrecuenciadeMantenimientoyActualizacion5'),
                    'Cap_FechaProximaActualizacion5' => $this->getTexto('tb_iCap_FechaProximaActualizacion5'),
                    'Cap_NivelTopologia6' => $this->getTexto('tb_iCap_NivelTopologia6'),
                    'Cap_TipoObjetoGeometrico6' => $this->getTexto('tb_iCap_TipoObjetoGeometrico6'),
                    'Cap_NumerodeDimensiones6' => $this->getTexto('tb_iCap_NumerodeDimensiones6'),
                    'Cap_NombredeDimension6' => $this->getTexto('tb_iCap_NombredeDimension6'),
                    'Cap_TamañodeDimension6' => $this->getTexto('tb_iCap_TamañodeDimension6'),
                    'Cap_Resolucion6' => $this->getTexto('tb_iCap_Resolucion6'),
                    'Cap_Codigo7' => $this->getTexto('tb_iCap_Codigo7'),
                    'Cap_CodigoSitio7' => $this->getTexto('tb_iCap_CodigoSitio7'),
                    'Cap_Nombre8' => $this->getTexto('tb_iCap_Nombre8'),
                    'Cap_Version8' => $this->getTexto('tb_iCap_Version8'),
                    'Cap_Enlace8' => $this->getTexto('tb_iCap_Enlace8'),
                    'Cap_Protocolo8' => $this->getTexto('tb_iCap_Protocolo8'),
                    'Cap_NombreOpcionesTransferencia8' => $this->getTexto('tb_iCap_NombreOpcionesTransferencia8'),
                    'Cap_Descripcion8' => $this->getTexto('tb_iCap_Descripcion8'),
                    'Cap_Estado' => $capa["Cap_Estado"],
                    'Idi_IdIdioma' => $capa["Idi_IdIdioma"],
                    'Rec_IdRecurso' => $capa["Rec_IdRecurso"]
                );

                if (!$this->getSql('tb_titulocapa') || !$this->getPostParam('tb_iCap_Fuente')) {
                    $this->_view->assign('_error', 'Debe introducir los campos obligatorios');
                } else {
                    //Mover imagen vista previa
                    if ($this->getPostParam('hd_leyenda')) 
                    {
                        $rutatemp = ROOT . 'tmp' . DS . 'varios' . DS;
                        $ruta = ROOT . 'public' . DS . 'img' . DS . 'mapa' . DS;
                        $filetem = $this->getPostParam('hd_leyenda');
                        $file = 'Leyenda_' . $this->_normalizar_cadena($this->getSql('tb_titulocapa')) . "." . explode('.', $filetem)[1];
                        if (is_readable($rutatemp . $filetem)) {
                            rename($rutatemp . $filetem, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ruta . $file));
                            $capa["Cap_Leyenda"] = BASE_URL . "public/img/mapa/" . $file;
                        } 
                        else 
                        {
                            $capa["Cap_Leyenda"] = $this->getPostParam('tb_leyendaurl');
                        }
                    } 
                    else 
                    {
                        $capa["Cap_Leyenda"] = $this->getPostParam('tb_leyendaurl');
                    }

                    if ($this->getPostParam('hd_imagenprev')) 
                    {
                        $rutatemp = ROOT . 'tmp' . DS . 'varios' . DS;
                        $ruta = ROOT . 'public' . DS . 'img' . DS . 'mapa' . DS;
                        $filetem = $this->getPostParam('hd_imagenprev');
                        $file = 'Imagen_' . $this->_normalizar_cadena($this->getSql('tb_titulocapa')) . "." . explode('.', $filetem)[1];

                        if (is_readable($rutatemp . $filetem)) 
                        {
                            $destino = ROOT.'public/img/mapa/' . $file;
                            
                            copy($rutatemp. $filetem, $destino);

                            rename($rutatemp . $filetem, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ruta . $file));
                            $capa['Cap_imagenprev'] = BASE_URL . "public/img/mapa/" . $file;
                        }
                    }

                    $bdrecurso = $this->loadModel("indexbd", "bdrecursos");
                    $bdrecurso->actualizarRecurso($capa["Rec_IdRecurso"], $capa["Cap_Titulo"], $capa["Cap_Fuente"], $this->getSql('tb_origenrecurso'));

                    $this->_mapa->actualizarCapa($capa["Cap_Idcapa"], $capa["Cap_UrlBase"], $capa["Cap_UrlCapa"], $capa["Cap_Fuente"], $capa["Cap_Nombre"], $capa["Cap_Titulo"], $capa["Cap_PalabrasClaves2"], $capa["Cap_Resumen"], $capa["Cap_Descripcion"], $capa["Cap_Creditos"], $capa["Cap_Leyenda"], $capa["Cap_imagenprev"], $capa["Cap_IdentificadorFichero1"], $capa["Cap_Idioma1"], $capa["Cap_FechaCreacion1"], $capa["Cap_NormaMetadatos1"], $capa["Cap_VersionNormaMetadatos1"], $capa["Cap_NombreIndividualdeContacto1"], $capa["Cap_NombredelaOrganizaciondeContacto1"], $capa["Cap_CorreodelContacto1"], $capa["Cap_RoldelContacto1"], $capa["Cap_TituloMencion2"], $capa["Cap_FechaMencion2"], $capa["Cap_TipoFechaMencion2"], $capa["Cap_FormaPresentacionMencion2"], $capa["Cap_Resumen2"], $capa["Cap_Proposito2"], $capa["Cap_Estado2"], $capa["Cap_NombreIndividualPuntoContacto2"], $capa["Cap_NombreOrganizacionPuntoContacto2"], $capa["Cap_CorreoElectronicoPuntoContacto2"], $capa["Cap_RolPuntodeContacto2"], $capa["Cap_NombreFicherodeVistadelGrafico2"], $capa["Cap_DescripcionFicherodeVistadelGrafico2"], $capa["Cap_TipoFicherodeVistadelGrafico2"], $capa["Cap_PalabraClaveDescripcionPC2"], $capa["Cap_TipoDescripcionPC2"], $capa["Cap_TipodeRepresentacionEspacial2"], $capa["Cap_ResolucionEspacial2"], $capa["Cap_Idioma2"], $capa["Cap_CategoriadeTema2"], $capa["Cap_LimiteLongitudOeste2"], $capa["Cap_LimiteLongitudEste2"], $capa["Cap_LimiteLatitudSur2"], $capa["Cap_LimiteLatitudNorte2"], $capa["Cap_Extension2"], $capa["Cap_ValorMinimo2"], $capa["Cap_ValorMaximo2"], $capa["Cap_UnidadesdeMedida2"], $capa["Cap_LimitaciondeUso3"], $capa["Cap_ConstriccionesdeAcceso3"], $capa["Cap_ConstriccionesdeUso3"], $capa["Cap_ConstriccionesdeOtroTipo3"], $capa["Cap_Nivel4"], $capa["Cap_Declaracion4"], $capa["Cap_FrecuenciadeMantenimientoyActualizacion5"], $capa["Cap_FechaProximaActualizacion5"], $capa["Cap_NivelTopologia6"], $capa["Cap_TipoObjetoGeometrico6"], $capa["Cap_NumerodeDimensiones6"], $capa["Cap_NombredeDimension6"], $capa["Cap_TamañodeDimension6"], $capa["Cap_Resolucion6"], $capa["Cap_Codigo7"], $capa["Cap_CodigoSitio7"], $capa["Cap_Nombre8"], $capa["Cap_Version8"], $capa["Cap_Enlace8"], $capa["Cap_Protocolo8"], $capa["Cap_NombreOpcionesTransferencia8"], $capa["Cap_Descripcion8"], $capa["Cap_Estado"], $capa["Idi_IdIdioma"], $capa["Rec_IdRecurso"]);
                    $this->_view->assign('_ok', 'Se actualizo ' . $capa["Rec_IdRecurso"] . "----" . $this->getSql('tb_titulocapa') . "----" . $this->getSql('tb_fuentecapa') . "----" . $this->getSql('tb_origenrecurso'));
                }
            }

            $capa = $this->_mapa->obtnerCapaPor($this->filtrarInt($idcapa));
            if ($capa) 
            {
                $this->_view->assign('capa', $capa);
                $this->_view->assign("formulario",true);
            }else{
                $this->_view->assign('_error','Registro no Econtrado');
            }
        }

        $this->_view->assign('capas', $paginador->paginar($this->_mapa->listarCapaWms(), "gestorcapa_lista_capas", '', false, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->getLenguaje("mapa_gestorcapa");
        $this->_view->renderizar('gestorcapa', 'Mapas');
    }

    public function _paginacion_gestorcapa_lista_capas($busqueda = "") 
    {
        //$this->validarUrlIdioma();
        $pagina = $this->getInt('pagina');

        $paginador = new Paginador();

        $this->_view->assign('capas', $paginador->paginar($this->_mapa->listarCapaWms($busqueda), "gestorcapa_lista_capas", $busqueda, $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/gestorcapa_lista_capas', false, true);
    }

    public function _buscarCapa() 
    {
        //$this->validarUrlIdioma();
        $pagina = $this->getInt('pagina');
        $busqueda = $this->getSql('busqueda');
        $paginador = new Paginador();

        $this->_view->assign('capas', $paginador->paginar($this->_mapa->listarCapaWms($busqueda), "gestorcapa_lista_capas", $busqueda, $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->renderizar('ajax/gestorcapa_lista_capas', false, true);
    }

  
    private function _capturarFormulario($idtipo,$urlbase,$urlcapa,$nombre,$leyenda){
        $capa = array(
            'Tic_IdTipoCapa' => $idtipo,//2,
            'Cap_UrlBase' =>$urlbase,// $this->getPostParam('hd_urlbase'),
            'Cap_UrlCapa' => $urlcapa,//$this->getPostParam('urlcapa'),
            'Cap_Fuente' => $this->getPostParam('tb_iCap_Fuente'),
            'Cap_Nombre' => $nombre,//$this->getSql('cmb_layer'),
            'Cap_Titulo' => $this->getSql('tb_titulocapa'),
            'Cap_PalabrasClaves2' => $this->getSql('tb_iCap_PalabrasClaves2'),
            'Cap_Resumen' => $this->getSql('tb_iCap_Resumen'),
            'Cap_Descripcion' => $this->getSql('tb_iCap_Descripcion'),
            'Cap_Creditos' => $this->getSql('tb_iCap_Creditos'),
            'Cap_Leyenda' => $leyenda,//$this->getPostParam('leyenda2'),
            'Cap_imagenprev' => "",
            'Cap_IdentificadorFichero1' => $this->getTexto('tb_iCap_IdentificadorFichero1'),
            'Cap_Idioma1' => $this->getTexto('tb_iCap_Idioma1'),
            'Cap_FechaCreacion1' => $this->getTexto('tb_iCap_FechaCreacion1'),
            'Cap_NormaMetadatos1' => $this->getTexto('tb_iCap_NormaMetadatos1'),
            'Cap_VersionNormaMetadatos1' => $this->getTexto('tb_iCap_VersionNormaMetadatos1'),
            'Cap_NombreIndividualdeContacto1' => $this->getTexto('tb_iCap_NombreIndividualdeContacto1'),
            'Cap_NombredelaOrganizaciondeContacto1' => $this->getTexto('tb_iCap_NombredelaOrganizaciondeContacto1'),
            'Cap_CorreodelContacto1' => $this->getTexto('tb_iCap_CorreodelContacto1'),
            'Cap_RoldelContacto1' => $this->getTexto('tb_iCap_RoldelContacto1'),
            'Cap_TituloMencion2' => $this->getTexto('tb_iCap_TituloMencion2'),
            'Cap_FechaMencion2' => $this->getTexto('tb_iCap_FechaMencion2'),
            'Cap_TipoFechaMencion2' => $this->getTexto('tb_iCap_TipoFechaMencion2'),
            'Cap_FormaPresentacionMencion2' => $this->getTexto('tb_iCap_FormaPresentacionMencion2'),
            'Cap_Resumen2' => $this->getTexto('tb_iCap_Resumen2'),
            'Cap_Proposito2' => $this->getTexto('tb_iCap_Proposito2'),
            'Cap_Estado2' => $this->getTexto('tb_iCap_Estado2'),
            'Cap_NombreIndividualPuntoContacto2' => $this->getTexto('tb_iCap_NombreIndividualPuntoContacto2'),
            'Cap_NombreOrganizacionPuntoContacto2' => $this->getTexto('tb_iCap_NombreOrganizacionPuntoContacto2'),
            'Cap_CorreoElectronicoPuntoContacto2' => $this->getTexto('tb_iCap_CorreoElectronicoPuntoContacto2'),
            'Cap_RolPuntodeContacto2' => $this->getTexto('tb_iCap_RolPuntodeContacto2'),
            'Cap_NombreFicherodeVistadelGrafico2' => $this->getTexto('tb_iCap_NombreFicherodeVistadelGrafico2'),
            'Cap_DescripcionFicherodeVistadelGrafico2' => $this->getTexto('tb_iCap_DescripcionFicherodeVistadelGrafico2'),
            'Cap_TipoFicherodeVistadelGrafico2' => $this->getTexto('tb_iCap_TipoFicherodeVistadelGrafico2'),
            'Cap_PalabraClaveDescripcionPC2' => $this->getTexto('tb_iCap_PalabraClaveDescripcionPC2'),
            'Cap_TipoDescripcionPC2' => $this->getTexto('tb_iCap_TipoDescripcionPC2'),
            'Cap_TipodeRepresentacionEspacial2' => $this->getTexto('tb_iCap_TipodeRepresentacionEspacial2'),
            'Cap_ResolucionEspacial2' => $this->getTexto('tb_iCap_ResolucionEspacial2'),
            'Cap_Idioma2' => $this->getTexto('tb_iCap_Idioma2'),
            'Cap_CategoriadeTema2' => $this->getTexto('tb_iCap_CategoriadeTema2'),
            'Cap_LimiteLongitudOeste2' => $this->getTexto('tb_iCap_LimiteLongitudOeste2'),
            'Cap_LimiteLongitudEste2' => $this->getTexto('tb_iCap_LimiteLongitudEste2'),
            'Cap_LimiteLatitudSur2' => $this->getTexto('tb_iCap_LimiteLatitudSur2'),
            'Cap_LimiteLatitudNorte2' => $this->getTexto('tb_iCap_LimiteLatitudNorte2'),
            'Cap_Extension2' => $this->getTexto('tb_iCap_Extension2'),
            'Cap_ValorMinimo2' => $this->getTexto('tb_iCap_ValorMinimo2'),
            'Cap_ValorMaximo2' => $this->getTexto('tb_iCap_ValorMaximo2'),
            'Cap_UnidadesdeMedida2' => $this->getTexto('tb_iCap_UnidadesdeMedida2'),
            'Cap_LimitaciondeUso3' => $this->getTexto('tb_iCap_LimitaciondeUso3'),
            'Cap_ConstriccionesdeAcceso3' => $this->getTexto('tb_iCap_ConstriccionesdeAcceso3'),
            'Cap_ConstriccionesdeUso3' => $this->getTexto('tb_iCap_ConstriccionesdeUso3'),
            'Cap_ConstriccionesdeOtroTipo3' => $this->getTexto('tb_iCap_ConstriccionesdeOtroTipo3'),
            'Cap_Nivel4' => $this->getTexto('tb_iCap_Nivel4'),
            'Cap_Declaracion4' => $this->getTexto('tb_iCap_Declaracion4'),
            'Cap_FrecuenciadeMantenimientoyActualizacion5' => $this->getTexto('tb_iCap_FrecuenciadeMantenimientoyActualizacion5'),
            'Cap_FechaProximaActualizacion5' => $this->getTexto('tb_iCap_FechaProximaActualizacion5'),
            'Cap_NivelTopologia6' => $this->getTexto('tb_iCap_NivelTopologia6'),
            'Cap_TipoObjetoGeometrico6' => $this->getTexto('tb_iCap_TipoObjetoGeometrico6'),
            'Cap_NumerodeDimensiones6' => $this->getTexto('tb_iCap_NumerodeDimensiones6'),
            'Cap_NombredeDimension6' => $this->getTexto('tb_iCap_NombredeDimension6'),
            'Cap_TamañodeDimension6' => $this->getTexto('tb_iCap_TamañodeDimension6'),
            'Cap_Resolucion6' => $this->getTexto('tb_iCap_Resolucion6'),
            'Cap_Codigo7' => $this->getTexto('tb_iCap_Codigo7'),
            'Cap_CodigoSitio7' => $this->getTexto('tb_iCap_CodigoSitio7'),
            'Cap_Nombre8' => $this->getTexto('tb_iCap_Nombre8'),
            'Cap_Version8' => $this->getTexto('tb_iCap_Version8'),
            'Cap_Enlace8' => $this->getTexto('tb_iCap_Enlace8'),
            'Cap_Protocolo8' => $this->getTexto('tb_iCap_Protocolo8'),
            'Cap_NombreOpcionesTransferencia8' => $this->getTexto('tb_iCap_NombreOpcionesTransferencia8'),
            'Cap_Descripcion8' => $this->getTexto('tb_iCap_Descripcion8'),
            'Cap_Estado' => 1,
            'Idi_IdIdioma' => Cookie::lenguaje(),
            'Rec_IdRecurso' => ""
        );
        return $capa;
    }

    //Para monitoreo
    public function _insertarCapaWms() 
    {
        $resultado = array();
        $mensaje = "error";
        $contenido = "";
        //echo $this->getPostParam('hd_urlbase');
        $capa = array(
            'Tic_IdTipoCapa' => 2,
            'Cap_UrlBase' => $this->getPostParam('hd_urlbase'),
            'Cap_UrlCapa' => $this->getPostParam('urlcapa'),
            'Cap_Fuente' => $this->getPostParam('tb_iCap_Fuente'),
            'Cap_Nombre' => $this->getSql('cmb_layer'),
            'Cap_Titulo' => $this->getSql('tb_titulocapa'),
            'Cap_PalabrasClaves2' => $this->getSql('tb_iCap_PalabrasClaves2'),
            'Cap_Resumen' => $this->getSql('tb_iCap_Resumen'),
            'Cap_Descripcion' => $this->getSql('tb_iCap_Descripcion'),
            'Cap_Creditos' => $this->getSql('tb_iCap_Creditos'),
            'Cap_Leyenda' => $this->getPostParam('leyenda2'),
            'Cap_imagenprev' => "",
            'Cap_IdentificadorFichero1' => $this->getTexto('tb_iCap_IdentificadorFichero1'),
            'Cap_Idioma1' => $this->getTexto('tb_iCap_Idioma1'),
            'Cap_FechaCreacion1' => $this->getTexto('tb_iCap_FechaCreacion1'),
            'Cap_NormaMetadatos1' => $this->getTexto('tb_iCap_NormaMetadatos1'),
            'Cap_VersionNormaMetadatos1' => $this->getTexto('tb_iCap_VersionNormaMetadatos1'),
            'Cap_NombreIndividualdeContacto1' => $this->getTexto('tb_iCap_NombreIndividualdeContacto1'),
            'Cap_NombredelaOrganizaciondeContacto1' => $this->getTexto('tb_iCap_NombredelaOrganizaciondeContacto1'),
            'Cap_CorreodelContacto1' => $this->getTexto('tb_iCap_CorreodelContacto1'),
            'Cap_RoldelContacto1' => $this->getTexto('tb_iCap_RoldelContacto1'),
            'Cap_TituloMencion2' => $this->getTexto('tb_iCap_TituloMencion2'),
            'Cap_FechaMencion2' => $this->getTexto('tb_iCap_FechaMencion2'),
            'Cap_TipoFechaMencion2' => $this->getTexto('tb_iCap_TipoFechaMencion2'),
            'Cap_FormaPresentacionMencion2' => $this->getTexto('tb_iCap_FormaPresentacionMencion2'),
            'Cap_Resumen2' => $this->getTexto('tb_iCap_Resumen2'),
            'Cap_Proposito2' => $this->getTexto('tb_iCap_Proposito2'),
            'Cap_Estado2' => $this->getTexto('tb_iCap_Estado2'),
            'Cap_NombreIndividualPuntoContacto2' => $this->getTexto('tb_iCap_NombreIndividualPuntoContacto2'),
            'Cap_NombreOrganizacionPuntoContacto2' => $this->getTexto('tb_iCap_NombreOrganizacionPuntoContacto2'),
            'Cap_CorreoElectronicoPuntoContacto2' => $this->getTexto('tb_iCap_CorreoElectronicoPuntoContacto2'),
            'Cap_RolPuntodeContacto2' => $this->getTexto('tb_iCap_RolPuntodeContacto2'),
            'Cap_NombreFicherodeVistadelGrafico2' => $this->getTexto('tb_iCap_NombreFicherodeVistadelGrafico2'),
            'Cap_DescripcionFicherodeVistadelGrafico2' => $this->getTexto('tb_iCap_DescripcionFicherodeVistadelGrafico2'),
            'Cap_TipoFicherodeVistadelGrafico2' => $this->getTexto('tb_iCap_TipoFicherodeVistadelGrafico2'),
            'Cap_PalabraClaveDescripcionPC2' => $this->getTexto('tb_iCap_PalabraClaveDescripcionPC2'),
            'Cap_TipoDescripcionPC2' => $this->getTexto('tb_iCap_TipoDescripcionPC2'),
            'Cap_TipodeRepresentacionEspacial2' => $this->getTexto('tb_iCap_TipodeRepresentacionEspacial2'),
            'Cap_ResolucionEspacial2' => $this->getTexto('tb_iCap_ResolucionEspacial2'),
            'Cap_Idioma2' => $this->getTexto('tb_iCap_Idioma2'),
            'Cap_CategoriadeTema2' => $this->getTexto('tb_iCap_CategoriadeTema2'),
            'Cap_LimiteLongitudOeste2' => $this->getTexto('tb_iCap_LimiteLongitudOeste2'),
            'Cap_LimiteLongitudEste2' => $this->getTexto('tb_iCap_LimiteLongitudEste2'),
            'Cap_LimiteLatitudSur2' => $this->getTexto('tb_iCap_LimiteLatitudSur2'),
            'Cap_LimiteLatitudNorte2' => $this->getTexto('tb_iCap_LimiteLatitudNorte2'),
            'Cap_Extension2' => $this->getTexto('tb_iCap_Extension2'),
            'Cap_ValorMinimo2' => $this->getTexto('tb_iCap_ValorMinimo2'),
            'Cap_ValorMaximo2' => $this->getTexto('tb_iCap_ValorMaximo2'),
            'Cap_UnidadesdeMedida2' => $this->getTexto('tb_iCap_UnidadesdeMedida2'),
            'Cap_LimitaciondeUso3' => $this->getTexto('tb_iCap_LimitaciondeUso3'),
            'Cap_ConstriccionesdeAcceso3' => $this->getTexto('tb_iCap_ConstriccionesdeAcceso3'),
            'Cap_ConstriccionesdeUso3' => $this->getTexto('tb_iCap_ConstriccionesdeUso3'),
            'Cap_ConstriccionesdeOtroTipo3' => $this->getTexto('tb_iCap_ConstriccionesdeOtroTipo3'),
            'Cap_Nivel4' => $this->getTexto('tb_iCap_Nivel4'),
            'Cap_Declaracion4' => $this->getTexto('tb_iCap_Declaracion4'),
            'Cap_FrecuenciadeMantenimientoyActualizacion5' => $this->getTexto('tb_iCap_FrecuenciadeMantenimientoyActualizacion5'),
            'Cap_FechaProximaActualizacion5' => $this->getTexto('tb_iCap_FechaProximaActualizacion5'),
            'Cap_NivelTopologia6' => $this->getTexto('tb_iCap_NivelTopologia6'),
            'Cap_TipoObjetoGeometrico6' => $this->getTexto('tb_iCap_TipoObjetoGeometrico6'),
            'Cap_NumerodeDimensiones6' => $this->getTexto('tb_iCap_NumerodeDimensiones6'),
            'Cap_NombredeDimension6' => $this->getTexto('tb_iCap_NombredeDimension6'),
            'Cap_TamañodeDimension6' => $this->getTexto('tb_iCap_TamañodeDimension6'),
            'Cap_Resolucion6' => $this->getTexto('tb_iCap_Resolucion6'),
            'Cap_Codigo7' => $this->getTexto('tb_iCap_Codigo7'),
            'Cap_CodigoSitio7' => $this->getTexto('tb_iCap_CodigoSitio7'),
            'Cap_Nombre8' => $this->getTexto('tb_iCap_Nombre8'),
            'Cap_Version8' => $this->getTexto('tb_iCap_Version8'),
            'Cap_Enlace8' => $this->getTexto('tb_iCap_Enlace8'),
            'Cap_Protocolo8' => $this->getTexto('tb_iCap_Protocolo8'),
            'Cap_NombreOpcionesTransferencia8' => $this->getTexto('tb_iCap_NombreOpcionesTransferencia8'),
            'Cap_Descripcion8' => $this->getTexto('tb_iCap_Descripcion8'),
            'Cap_Estado' => 1,
            'Idi_IdIdioma' => Cookie::lenguaje(),
            'Rec_IdRecurso' => ""
        );

        if ($this->getInt('hd_carga_avanzada')) 
        {
            if ($capa["Cap_UrlBase"] && $capa["Cap_UrlCapa"] && $capa["Cap_Titulo"] && $capa["Cap_Fuente"]) 
            {
                $existecapa = $this->_mapa->ListarCapaPor($capa["Cap_UrlBase"], $capa["Cap_Nombre"]);

                if (is_array($existecapa) && count($existecapa) == 0) 
                {
                    $bdrecurso = $this->loadModel("indexbd", "bdrecursos");
                    $idrecurso = $bdrecurso->insertarRecurso($capa["Cap_Titulo"], $capa["Cap_Fuente"], 2, 1, 5, $this->getSql('tb_iRec_Origen'), $capa["Idi_IdIdioma"]);
                    $idcapawms = 0;
                    if (is_array($idrecurso) && $this->filtrarInt($idrecurso[0])) 
                    {
                        $capa["Rec_IdRecurso"] = $idrecurso[0];
                        if ($this->getPostParam('leyenda')) 
                        {
                            $rutatemp = ROOT . 'tmp' . DS . 'varios' . DS;
                            $ruta = ROOT . 'public' . DS . 'img' . DS . 'mapa' . DS;
                            $filetem = $this->getPostParam('leyenda');
                            $file = 'Leyenda_' . $this->_normalizar_cadena($this->getSql('titulo')) . "." . explode('.', $filetem)[1];
                            if (is_readable($rutatemp . $filetem)) 
                            {
                                rename($rutatemp . $filetem, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ruta . $file));
                                $capa["Cap_Leyenda"] = BASE_URL . "public/img/mapa/" . $file;
                            }

                        } 
                        else 
                        {
                            if (!empty($this->getPostParam('tb_leyendaurl'))) 
                            {
                                $capa["Cap_Leyenda"] = $this->getPostParam('tb_leyendaurl');
                            }
                        }

                        if ($this->getPostParam('imagenprev')) 
                        {
                            $rutatemp = ROOT . 'tmp' . DS . 'varios' . DS;
                            $ruta = ROOT . 'public' . DS . 'img' . DS . 'mapa' . DS;
                            $filetem = $this->getPostParam('imagenprev');
                            $file = 'Imagen_' . $this->_normalizar_cadena($this->getSql('titulo')) . "." . explode('.', $filetem)[1];
                            if (is_readable($rutatemp . $filetem)) 
                            {
                                rename($rutatemp . $filetem, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ruta . $file));
                                $capa["Cap_imagenprev"] = BASE_URL . "public/img/mapa/" . $file;
                            } 
                            else 
                            {
                                $capa["Cap_imagenprev"] = "";
                            }

                        } 
                        else 
                        {
                            $capa["Cap_imagenprev"] = "";
                        }

                        $idcapawms = $this->_mapa->insertarCapaWms($capa["Tic_IdTipoCapa"], $capa["Cap_UrlBase"], $capa["Cap_UrlCapa"], $capa["Cap_Fuente"], $capa["Cap_Nombre"], $capa["Cap_Titulo"], $capa["Cap_PalabrasClaves2"], $capa["Cap_Resumen"], $capa["Cap_Descripcion"], $capa["Cap_Creditos"], $capa["Cap_Leyenda"], $capa["Cap_imagenprev"], $capa["Cap_IdentificadorFichero1"], $capa["Cap_Idioma1"], $capa["Cap_FechaCreacion1"], $capa["Cap_NormaMetadatos1"], $capa["Cap_VersionNormaMetadatos1"], $capa["Cap_NombreIndividualdeContacto1"], $capa["Cap_NombredelaOrganizaciondeContacto1"], $capa["Cap_CorreodelContacto1"], $capa["Cap_RoldelContacto1"], $capa["Cap_TituloMencion2"], $capa["Cap_FechaMencion2"], $capa["Cap_TipoFechaMencion2"], $capa["Cap_FormaPresentacionMencion2"], $capa["Cap_Resumen2"], $capa["Cap_Proposito2"], $capa["Cap_Estado2"], $capa["Cap_NombreIndividualPuntoContacto2"], $capa["Cap_NombreOrganizacionPuntoContacto2"], $capa["Cap_CorreoElectronicoPuntoContacto2"], $capa["Cap_RolPuntodeContacto2"], $capa["Cap_NombreFicherodeVistadelGrafico2"], $capa["Cap_DescripcionFicherodeVistadelGrafico2"], $capa["Cap_TipoFicherodeVistadelGrafico2"], $capa["Cap_PalabraClaveDescripcionPC2"], $capa["Cap_TipoDescripcionPC2"], $capa["Cap_TipodeRepresentacionEspacial2"], $capa["Cap_ResolucionEspacial2"], $capa["Cap_Idioma2"], $capa["Cap_CategoriadeTema2"], $capa["Cap_LimiteLongitudOeste2"], $capa["Cap_LimiteLongitudEste2"], $capa["Cap_LimiteLatitudSur2"], $capa["Cap_LimiteLatitudNorte2"], $capa["Cap_Extension2"], $capa["Cap_ValorMinimo2"], $capa["Cap_ValorMaximo2"], $capa["Cap_UnidadesdeMedida2"], $capa["Cap_LimitaciondeUso3"], $capa["Cap_ConstriccionesdeAcceso3"], $capa["Cap_ConstriccionesdeUso3"], $capa["Cap_ConstriccionesdeOtroTipo3"], $capa["Cap_Nivel4"], $capa["Cap_Declaracion4"], $capa["Cap_FrecuenciadeMantenimientoyActualizacion5"], $capa["Cap_FechaProximaActualizacion5"], $capa["Cap_NivelTopologia6"], $capa["Cap_TipoObjetoGeometrico6"], $capa["Cap_NumerodeDimensiones6"], $capa["Cap_NombredeDimension6"], $capa["Cap_TamañodeDimension6"], $capa["Cap_Resolucion6"], $capa["Cap_Codigo7"], $capa["Cap_CodigoSitio7"], $capa["Cap_Nombre8"], $capa["Cap_Version8"], $capa["Cap_Enlace8"], $capa["Cap_Protocolo8"], $capa["Cap_NombreOpcionesTransferencia8"], $capa["Cap_Descripcion8"], $capa["Cap_Estado"], $capa["Idi_IdIdioma"], $capa["Rec_IdRecurso"]);
                    }

                    if (is_array($idcapawms)) 
                    {
                        if ($idcapawms[0] > 0) 
                        {
                            $mensaje = "ok";
                            $contenido = "Se Registró con éxito los datos";
                            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                        } 
                        else 
                        {
                            $bdrecurso->eliminarRecurso($idrecurso[0]);
                            $mensaje = "error";
                            $contenido = "No se registró los datos, Registro: " . $idcapawms . "-" . $idrecurso;
                            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                        }
                    } 
                    else 
                    {
                        $bdrecurso->eliminarRecurso($idrecurso[0]);
                        $mensaje = "error";
                        $contenido = "Ocurrio un error al Registrar los datos, Error: " . $idcapawms;
                        array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                    }

                } 
                else 
                {
                    $mensaje = "error";
                    $contenido = "La Capa " . $capa["Cap_Titulo"] . " se encuentra registrada como " . $existecapa[0]["Cap_Titulo"] . "!...";
                    array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                }
            } 
            else 
            {
                $mensaje = "error";
                $contenido = "LLene los campos obligatorios";
                array_push($resultado, array(0 => $mensaje, 1 => $contenido));
            }

        } 
        else 
        {
            $capas = json_decode($this->getPostParam('capas'));
            
            if ($capa["Cap_UrlBase"] && $capa["Cap_Titulo"] && count($capas) && $capa["Cap_Fuente"] && $this->getSql('tb_iRec_Origen')) 
            {
                $bdrecurso = $this->loadModel("indexbd", "bdrecursos");
                foreach ($capas as $cap) 
                {
                    $capa["Cap_Nombre"] = $cap[1];
                    //$capa["Cap_Titulo"] = $cap[0];

                    $existecapa = $this->_mapa->ListarCapaPor($capa["Cap_UrlBase"], $capa["Cap_Nombre"]);

                    if (is_array($existecapa) && count($existecapa) == 0) 
                    {
                        $idrecurso = $bdrecurso->insertarRecurso($capa["Cap_Titulo"], $capa["Cap_Fuente"], 2, 1, 5, $this->getSql('tb_iRec_Origen'), $capa["Idi_IdIdioma"]);
                        $idcapawms = 0;

                        if (is_array($idrecurso) && $this->filtrarInt($idrecurso[0])) 
                        {
                            $capa["Rec_IdRecurso"] = $idrecurso[0];
                            $rutaleyenda;
                            $rutaimagen;
                            if ($this->getPostParam('leyenda')) 
                            {
                                $rutatemp = ROOT . 'tmp' . DS . 'varios' . DS;
                                $ruta = ROOT . 'public' . DS . 'img' . DS . 'mapa' . DS;
                                $filetem = $this->getPostParam('hd_leyenda');
                                $file = 'Leyenda_' . $this->_normalizar_cadena($capa["Cap_Titulo"]) . "." . explode('.', $filetem)[1];
                                if (is_readable($rutatemp . $filetem)) 
                                {
                                    rename($rutatemp . $filetem, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ruta . $file));
                                    $capa["Cap_Leyenda"] = BASE_URL . "public/img/mapa/" . $file;
                                }
                            } 

                            if (!empty($this->getPostParam('tb_leyendaurl'))) 
                            {
                                $capa["Cap_Leyenda"] = $this->getPostParam('tb_leyendaurl');
                            }

                            if ($this->getPostParam('imagenprev')) 
                            {
                                $rutatemp = ROOT . 'tmp' . DS . 'varios' . DS;
                                $ruta = ROOT . 'public' . DS . 'img' . DS . 'mapa' . DS;
                                $filetem = $this->getPostParam('imagenprev');
                                $file = 'Imagen_' . $this->_normalizar_cadena($capa["Cap_Titulo"]) . "." . explode('.', $filetem)[1];
                                if (is_readable($rutatemp . $filetem)) 
                                {
                                    rename($rutatemp . $filetem, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ruta . $file));
                                    $capa["Cap_imagenprev"] = BASE_URL . "public/img/mapa/" . $file;
                                } 
                                else 
                                {
                                    $capa["Cap_imagenprev"] = "";
                                }
                            } 
                            else 
                            {
                                $capa["Cap_imagenprev"] = "";
                            }

                            $idcapawms = $this->_mapa->insertarCapaWms($capa["Tic_IdTipoCapa"], $capa["Cap_UrlBase"], $capa["Cap_UrlCapa"], $capa["Cap_Fuente"], $capa["Cap_Nombre"], $capa["Cap_Titulo"], $capa["Cap_PalabrasClaves2"], $capa["Cap_Resumen"], $capa["Cap_Descripcion"], $capa["Cap_Creditos"], $capa["Cap_Leyenda"], $capa["Cap_imagenprev"], $capa["Cap_IdentificadorFichero1"], $capa["Cap_Idioma1"], $capa["Cap_FechaCreacion1"], $capa["Cap_NormaMetadatos1"], $capa["Cap_VersionNormaMetadatos1"], $capa["Cap_NombreIndividualdeContacto1"], $capa["Cap_NombredelaOrganizaciondeContacto1"], $capa["Cap_CorreodelContacto1"], $capa["Cap_RoldelContacto1"], $capa["Cap_TituloMencion2"], $capa["Cap_FechaMencion2"], $capa["Cap_TipoFechaMencion2"], $capa["Cap_FormaPresentacionMencion2"], $capa["Cap_Resumen2"], $capa["Cap_Proposito2"], $capa["Cap_Estado2"], $capa["Cap_NombreIndividualPuntoContacto2"], $capa["Cap_NombreOrganizacionPuntoContacto2"], $capa["Cap_CorreoElectronicoPuntoContacto2"], $capa["Cap_RolPuntodeContacto2"], $capa["Cap_NombreFicherodeVistadelGrafico2"], $capa["Cap_DescripcionFicherodeVistadelGrafico2"], $capa["Cap_TipoFicherodeVistadelGrafico2"], $capa["Cap_PalabraClaveDescripcionPC2"], $capa["Cap_TipoDescripcionPC2"], $capa["Cap_TipodeRepresentacionEspacial2"], $capa["Cap_ResolucionEspacial2"], $capa["Cap_Idioma2"], $capa["Cap_CategoriadeTema2"], $capa["Cap_LimiteLongitudOeste2"], $capa["Cap_LimiteLongitudEste2"], $capa["Cap_LimiteLatitudSur2"], $capa["Cap_LimiteLatitudNorte2"], $capa["Cap_Extension2"], $capa["Cap_ValorMinimo2"], $capa["Cap_ValorMaximo2"], $capa["Cap_UnidadesdeMedida2"], $capa["Cap_LimitaciondeUso3"], $capa["Cap_ConstriccionesdeAcceso3"], $capa["Cap_ConstriccionesdeUso3"], $capa["Cap_ConstriccionesdeOtroTipo3"], $capa["Cap_Nivel4"], $capa["Cap_Declaracion4"], $capa["Cap_FrecuenciadeMantenimientoyActualizacion5"], $capa["Cap_FechaProximaActualizacion5"], $capa["Cap_NivelTopologia6"], $capa["Cap_TipoObjetoGeometrico6"], $capa["Cap_NumerodeDimensiones6"], $capa["Cap_NombredeDimension6"], $capa["Cap_TamañodeDimension6"], $capa["Cap_Resolucion6"], $capa["Cap_Codigo7"], $capa["Cap_CodigoSitio7"], $capa["Cap_Nombre8"], $capa["Cap_Version8"], $capa["Cap_Enlace8"], $capa["Cap_Protocolo8"], $capa["Cap_NombreOpcionesTransferencia8"], $capa["Cap_Descripcion8"], $capa["Cap_Estado"], $capa["Idi_IdIdioma"], $capa["Rec_IdRecurso"]);
                        }
                        if (is_array($idcapawms)) 
                        {
                            if ($idcapawms[0] > 0) 
                            {
                                $mensaje = "ok";
                                $contenido = "Se Registró con éxito los datos";
                                array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                            } 
                            else 
                            {
                                $bdrecurso = $this->loadModel("indexbd", "bdrecursos");
                                $bdrecurso->eliminarRecurso($idrecurso[0]);
                                $mensaje = "error";
                                $contenido = "No se registró los datos, Registro: " . $idcapawms;
                                array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                            }
                        } 
                        else 
                        {
                            $bdrecurso->eliminarRecurso($idrecurso[0]);
                            $mensaje = "error";
                            $contenido = "No se registró los datos, Registro: " . $idcapawms . "- recurso" . $idrecurso[0];
                            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                        }
                    } 
                    else 
                    {
                        $mensaje = "error";
                        $contenido = "La Capa " . $capa["Cap_Titulo"] . " se encuentra registrada como " . $existecapa[0]["Cap_Titulo"] . "!...";
                        array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                    }
                }
            } 
            else 
            {
                $mensaje = "error";
                $contenido = "LLene los campos obligatorios";
                array_push($resultado, array(0 => $mensaje, 1 => $contenido));
            }
        }
        //echo $capa["Cap_Leyenda"];
        echo json_encode($resultado);
    }
     public function _insertarCapaKML() 
    {
        $resultado = array();
        $mensaje = "error";
        $contenido = "";
        //echo $this->getPostParam('hd_urlbase');
        $urlbase=BASE_URL.'archivosFisicos/kml/';
        //Mover archivo de sitio temporal
        $nombre=$this->getPostParam('kml');
        $ruta_final = ROOT . 'archivosFisicos' . DS . 'kml'. DS.$nombre;
        $temp_file= ROOT . 'tmp' . DS . 'varios'. DS.$nombre;
        $ismover=false;
        try {
            $ismover=rename($temp_file, $ruta_final);
        } catch (Exception $exc) {
            $mensaje = "error";
            $contenido=$exc->getTraceAsString();
            $resultado=array(0 => $mensaje, 1 => $contenido);              
        }
        if(count($resultado)==0&&$ismover){
        $capa=$this->_capturarFormulario(1, $urlbase,$urlbase.$nombre,$nombre,$this->getPostParam('tb_leyendaurl'));

            if ($capa["Cap_UrlBase"] && $capa["Cap_UrlCapa"] && $capa["Cap_Titulo"] && $capa["Cap_Fuente"]) 
            {
                $existecapa = $this->_mapa->ListarCapaPor($capa["Cap_UrlBase"], $capa["Cap_Nombre"]);

                if (is_array($existecapa) && count($existecapa) == 0) 
                {
                    $bdrecurso = $this->loadModel("indexbd", "bdrecursos");
                    $idrecurso = $bdrecurso->insertarRecurso($capa["Cap_Titulo"], $capa["Cap_Fuente"], 2, 1, 5, $this->getSql('tb_iRec_Origen'), $capa["Idi_IdIdioma"]);
                    $idcapawms = 0;
                    if (is_array($idrecurso) && $this->filtrarInt($idrecurso[0])) 
                    {
                        $capa["Rec_IdRecurso"] = $idrecurso[0];
                        if ($this->getPostParam('leyenda')) 
                        {
                            $rutatemp = ROOT . 'tmp' . DS . 'varios' . DS;
                            $ruta = ROOT . 'public' . DS . 'img' . DS . 'mapa' . DS;
                            $filetem = $this->getPostParam('leyenda');
                            $file = 'Leyenda_' . $this->_normalizar_cadena($this->getSql('titulo')) . "." . explode('.', $filetem)[1];
                            if (is_readable($rutatemp . $filetem)) 
                            {
                                rename($rutatemp . $filetem, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ruta . $file));
                                $capa["Cap_Leyenda"] = BASE_URL . "public/img/mapa/" . $file;
                            }

                        } 
                        else 
                        {
                            if (!empty($this->getPostParam('tb_leyendaurl'))) 
                            {
                                $capa["Cap_Leyenda"] = $this->getPostParam('tb_leyendaurl');
                            }
                        }

                        if ($this->getPostParam('imagenprev')) 
                        {
                            $rutatemp = ROOT . 'tmp' . DS . 'varios' . DS;
                            $ruta = ROOT . 'public' . DS . 'img' . DS . 'mapa' . DS;
                            $filetem = $this->getPostParam('imagenprev');
                            $file = 'Imagen_' . $this->_normalizar_cadena($this->getSql('titulo')) . "." . explode('.', $filetem)[1];
                            if (is_readable($rutatemp . $filetem)) 
                            {
                                rename($rutatemp . $filetem, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ruta . $file));
                                $capa["Cap_imagenprev"] = BASE_URL . "public/img/mapa/" . $file;
                            } 
                            else 
                            {
                                $capa["Cap_imagenprev"] = "";
                            }

                        } 
                        else 
                        {
                            $capa["Cap_imagenprev"] = "";
                        }

                        $idcapawms = $this->_mapa->insertarCapaWms($capa["Tic_IdTipoCapa"], $capa["Cap_UrlBase"], $capa["Cap_UrlCapa"], $capa["Cap_Fuente"], $capa["Cap_Nombre"], $capa["Cap_Titulo"], $capa["Cap_PalabrasClaves2"], $capa["Cap_Resumen"], $capa["Cap_Descripcion"], $capa["Cap_Creditos"], $capa["Cap_Leyenda"], $capa["Cap_imagenprev"], $capa["Cap_IdentificadorFichero1"], $capa["Cap_Idioma1"], $capa["Cap_FechaCreacion1"], $capa["Cap_NormaMetadatos1"], $capa["Cap_VersionNormaMetadatos1"], $capa["Cap_NombreIndividualdeContacto1"], $capa["Cap_NombredelaOrganizaciondeContacto1"], $capa["Cap_CorreodelContacto1"], $capa["Cap_RoldelContacto1"], $capa["Cap_TituloMencion2"], $capa["Cap_FechaMencion2"], $capa["Cap_TipoFechaMencion2"], $capa["Cap_FormaPresentacionMencion2"], $capa["Cap_Resumen2"], $capa["Cap_Proposito2"], $capa["Cap_Estado2"], $capa["Cap_NombreIndividualPuntoContacto2"], $capa["Cap_NombreOrganizacionPuntoContacto2"], $capa["Cap_CorreoElectronicoPuntoContacto2"], $capa["Cap_RolPuntodeContacto2"], $capa["Cap_NombreFicherodeVistadelGrafico2"], $capa["Cap_DescripcionFicherodeVistadelGrafico2"], $capa["Cap_TipoFicherodeVistadelGrafico2"], $capa["Cap_PalabraClaveDescripcionPC2"], $capa["Cap_TipoDescripcionPC2"], $capa["Cap_TipodeRepresentacionEspacial2"], $capa["Cap_ResolucionEspacial2"], $capa["Cap_Idioma2"], $capa["Cap_CategoriadeTema2"], $capa["Cap_LimiteLongitudOeste2"], $capa["Cap_LimiteLongitudEste2"], $capa["Cap_LimiteLatitudSur2"], $capa["Cap_LimiteLatitudNorte2"], $capa["Cap_Extension2"], $capa["Cap_ValorMinimo2"], $capa["Cap_ValorMaximo2"], $capa["Cap_UnidadesdeMedida2"], $capa["Cap_LimitaciondeUso3"], $capa["Cap_ConstriccionesdeAcceso3"], $capa["Cap_ConstriccionesdeUso3"], $capa["Cap_ConstriccionesdeOtroTipo3"], $capa["Cap_Nivel4"], $capa["Cap_Declaracion4"], $capa["Cap_FrecuenciadeMantenimientoyActualizacion5"], $capa["Cap_FechaProximaActualizacion5"], $capa["Cap_NivelTopologia6"], $capa["Cap_TipoObjetoGeometrico6"], $capa["Cap_NumerodeDimensiones6"], $capa["Cap_NombredeDimension6"], $capa["Cap_TamañodeDimension6"], $capa["Cap_Resolucion6"], $capa["Cap_Codigo7"], $capa["Cap_CodigoSitio7"], $capa["Cap_Nombre8"], $capa["Cap_Version8"], $capa["Cap_Enlace8"], $capa["Cap_Protocolo8"], $capa["Cap_NombreOpcionesTransferencia8"], $capa["Cap_Descripcion8"], $capa["Cap_Estado"], $capa["Idi_IdIdioma"], $capa["Rec_IdRecurso"]);
                    }

                    if (is_array($idcapawms)) 
                    {
                        if ($idcapawms[0] > 0) 
                        {
                            $mensaje = "ok";
                            $contenido = "Se Registró con éxito los datos";
                            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                        } 
                        else 
                        {
                            $bdrecurso->eliminarRecurso($idrecurso[0]);
                            $mensaje = "error";
                            $contenido = "No se registró los datos, Registro: " . $idcapawms . "-" . $idrecurso;
                            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                        }
                    } 
                    else 
                    {
                        $bdrecurso->eliminarRecurso($idrecurso[0]);
                        $mensaje = "error";
                        $contenido = "Ocurrio un error al Registrar los datos, Error: " . $idcapawms;
                        array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                    }

                } 
                else 
                {
                    $mensaje = "error";
                    $contenido = "La Capa " . $capa["Cap_Titulo"] . " se encuentra registrada como " . $existecapa[0]["Cap_Titulo"] . "!...";
                    array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                }
            } 
            else 
            {
                $mensaje = "error";
                $contenido = "LLene los campos obligatorios: ".(($capa["Cap_UrlBase"])?"":"Url Base").(($capa["Cap_UrlCapa"])?"":" | Url Capa").(($capa["Cap_Titulo"])?"":" | Titulo").(($capa["Cap_Fuente"])?"":" | Fuente");
                array_push($resultado, array(0 => $mensaje, 1 => $contenido));
            }

        }       
        //echo $capa["Cap_Leyenda"];
        echo json_encode($resultado);
    }
    public function _insertarCapaRSS() {
        $resultado = array();
        //echo $this->getPostParam('hd_urlbase');
        $url_rss=$this->getPostParam('url_rss');
         $protocolos = array('http://', 'https://', 'ftp://', 'www.');
         $urlbase = explode('/', str_replace($protocolos, '', $url_rss));
        $capa = $this->_capturarFormulario(5, $urlbase[0], $url_rss,"", $this->getPostParam('tb_leyendaurl'));

        if ($capa["Cap_UrlBase"] && $capa["Cap_UrlCapa"] && $capa["Cap_Titulo"] && $capa["Cap_Fuente"]) {
            $existecapa = $this->_mapa->ListarCapaPor($capa["Cap_UrlBase"], $capa["Cap_Nombre"]);

            if (is_array($existecapa) && count($existecapa) == 0) {
                $bdrecurso = $this->loadModel("indexbd", "bdrecursos");
                $idrecurso = $bdrecurso->insertarRecurso($capa["Cap_Titulo"], $capa["Cap_Fuente"], 2, 1, 5, $this->getSql('tb_iRec_Origen'), $capa["Idi_IdIdioma"]);
                $idcapawms = 0;
                if (is_array($idrecurso) && $this->filtrarInt($idrecurso[0])) {
                    $capa["Rec_IdRecurso"] = $idrecurso[0];
                    if ($this->getPostParam('leyenda')) {
                        $rutatemp = ROOT . 'tmp' . DS . 'varios' . DS ;
                        $ruta = ROOT . 'public' . DS . 'img' . DS . 'mapa' . DS;
                        $filetem = $this->getPostParam('leyenda');
                        $file = 'Leyenda_' . $this->_normalizar_cadena($this->getSql('titulo')) . "." . explode('.', $filetem)[1];
                        if (is_readable($rutatemp . $filetem)) {
                            rename($rutatemp . $filetem, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ruta . $file));
                            $capa["Cap_Leyenda"] = BASE_URL . "public/img/mapa/" . $file;
                        }
                    } else {
                        if (!empty($this->getPostParam('tb_leyendaurl'))) {
                            $capa["Cap_Leyenda"] = $this->getPostParam('tb_leyendaurl');
                        }
                    }

                    if ($this->getPostParam('imagenprev')) {
                        $rutatemp = ROOT . 'tmp' . DS . 'varios' . DS;
                        $ruta = ROOT . 'public' . DS . 'img' . DS . 'mapa' . DS;
                        $filetem = $this->getPostParam('imagenprev');
                        $file = 'Imagen_' . $this->_normalizar_cadena($this->getSql('titulo')) . "." . explode('.', $filetem)[1];
                        if (is_readable($rutatemp . $filetem)) {
                            rename($rutatemp . $filetem, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ruta . $file));
                            $capa["Cap_imagenprev"] = BASE_URL . "public/img/mapa/" . $file;
                        } else {
                            $capa["Cap_imagenprev"] = "";
                        }
                    } else {
                        $capa["Cap_imagenprev"] = "";
                    }

                    $idcapawms = $this->_mapa->insertarCapaWms($capa["Tic_IdTipoCapa"], $capa["Cap_UrlBase"], $capa["Cap_UrlCapa"], $capa["Cap_Fuente"], $capa["Cap_Nombre"], $capa["Cap_Titulo"], $capa["Cap_PalabrasClaves2"], $capa["Cap_Resumen"], $capa["Cap_Descripcion"], $capa["Cap_Creditos"], $capa["Cap_Leyenda"], $capa["Cap_imagenprev"], $capa["Cap_IdentificadorFichero1"], $capa["Cap_Idioma1"], $capa["Cap_FechaCreacion1"], $capa["Cap_NormaMetadatos1"], $capa["Cap_VersionNormaMetadatos1"], $capa["Cap_NombreIndividualdeContacto1"], $capa["Cap_NombredelaOrganizaciondeContacto1"], $capa["Cap_CorreodelContacto1"], $capa["Cap_RoldelContacto1"], $capa["Cap_TituloMencion2"], $capa["Cap_FechaMencion2"], $capa["Cap_TipoFechaMencion2"], $capa["Cap_FormaPresentacionMencion2"], $capa["Cap_Resumen2"], $capa["Cap_Proposito2"], $capa["Cap_Estado2"], $capa["Cap_NombreIndividualPuntoContacto2"], $capa["Cap_NombreOrganizacionPuntoContacto2"], $capa["Cap_CorreoElectronicoPuntoContacto2"], $capa["Cap_RolPuntodeContacto2"], $capa["Cap_NombreFicherodeVistadelGrafico2"], $capa["Cap_DescripcionFicherodeVistadelGrafico2"], $capa["Cap_TipoFicherodeVistadelGrafico2"], $capa["Cap_PalabraClaveDescripcionPC2"], $capa["Cap_TipoDescripcionPC2"], $capa["Cap_TipodeRepresentacionEspacial2"], $capa["Cap_ResolucionEspacial2"], $capa["Cap_Idioma2"], $capa["Cap_CategoriadeTema2"], $capa["Cap_LimiteLongitudOeste2"], $capa["Cap_LimiteLongitudEste2"], $capa["Cap_LimiteLatitudSur2"], $capa["Cap_LimiteLatitudNorte2"], $capa["Cap_Extension2"], $capa["Cap_ValorMinimo2"], $capa["Cap_ValorMaximo2"], $capa["Cap_UnidadesdeMedida2"], $capa["Cap_LimitaciondeUso3"], $capa["Cap_ConstriccionesdeAcceso3"], $capa["Cap_ConstriccionesdeUso3"], $capa["Cap_ConstriccionesdeOtroTipo3"], $capa["Cap_Nivel4"], $capa["Cap_Declaracion4"], $capa["Cap_FrecuenciadeMantenimientoyActualizacion5"], $capa["Cap_FechaProximaActualizacion5"], $capa["Cap_NivelTopologia6"], $capa["Cap_TipoObjetoGeometrico6"], $capa["Cap_NumerodeDimensiones6"], $capa["Cap_NombredeDimension6"], $capa["Cap_TamañodeDimension6"], $capa["Cap_Resolucion6"], $capa["Cap_Codigo7"], $capa["Cap_CodigoSitio7"], $capa["Cap_Nombre8"], $capa["Cap_Version8"], $capa["Cap_Enlace8"], $capa["Cap_Protocolo8"], $capa["Cap_NombreOpcionesTransferencia8"], $capa["Cap_Descripcion8"], $capa["Cap_Estado"], $capa["Idi_IdIdioma"], $capa["Rec_IdRecurso"]);
                }

                if (is_array($idcapawms)) {
                    if ($idcapawms[0] > 0) {
                        $mensaje = "ok";
                        $contenido = "Se Registró con éxito los datos";
                        array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                    } else {
                        $bdrecurso->eliminarRecurso($idrecurso[0]);
                        $mensaje = "error";
                        $contenido = "No se registró los datos, Registro: " . $idcapawms . "-" . $idrecurso;
                        array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                    }
                } else {
                    $bdrecurso->eliminarRecurso($idrecurso[0]);
                    $mensaje = "error";
                    $contenido = "Ocurrio un error al Registrar los datos, Error: " . $idcapawms;
                    array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                }
            } else {
                $mensaje = "error";
                $contenido = "La Capa " . $capa["Cap_Titulo"] . " se encuentra registrada como " . $existecapa[0]["Cap_Titulo"] . "!...";
                array_push($resultado, array(0 => $mensaje, 1 => $contenido));
            }
        } else {
            $mensaje = "error";
            $contenido = "LLene los campos obligatorios: " . (($capa["Cap_UrlBase"]) ? "" : "Url Base") . (($capa["Cap_UrlCapa"]) ? "" : " | Url Capa") . (($capa["Cap_Titulo"]) ? "" : " | Titulo") . (($capa["Cap_Fuente"]) ? "" : " | Fuente");
            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
        }


        //echo $capa["Cap_Leyenda"];
        echo json_encode($resultado);
    }
    
     public function _insertarCapaJSON() {
        $resultado = array();
        //echo $this->getPostParam('hd_urlbase');
        $tipo_json=$this->getPostParam('tipo_json');
        $url_json=$this->getPostParam('url_json');       
        
        if($tipo_json=="url"){
         $protocolos = array('http://', 'https://', 'ftp://', 'www.');
         $urlbase = explode('/', str_replace($protocolos, '', $url_json))[0];
         $nombre="";
         $ismover=true;
        } else {
           
            $mensaje = "error";
            $contenido = "";
//echo $this->getPostParam('hd_urlbase');
            $urlbase = BASE_URL . 'archivosFisicos/json/';
//Mover archivo de sitio temporal
            $nombre = $url_json;            
            $url_json=$urlbase.$nombre;
            $ruta_final = ROOT . 'archivosFisicos' . DS . 'json' . DS . $nombre;
            $temp_file = ROOT . 'tmp' . DS . 'varios' . DS . $nombre;
            $ismover = false;
            try {
                $ismover = rename($temp_file, $ruta_final);
            } catch (Exception $exc) {
                $mensaje = "error";
                $contenido = $exc->getTraceAsString();
                array_push($resultado,array(0 => $mensaje, 1 => $contenido));
                $ismover=false;
            }
        }
        if ($ismover) {
            $capa = $this->_capturarFormulario(4, $urlbase, $url_json, $nombre, $this->getPostParam('tb_leyendaurl'));

            if ($capa["Cap_UrlBase"] && $capa["Cap_UrlCapa"] && $capa["Cap_Titulo"] && $capa["Cap_Fuente"]) {
                $existecapa = $this->_mapa->ListarCapaPor($capa["Cap_UrlBase"], $capa["Cap_Nombre"]);

                if (is_array($existecapa) && count($existecapa) == 0) {
                    $bdrecurso = $this->loadModel("indexbd", "bdrecursos");
                    $idrecurso = $bdrecurso->insertarRecurso($capa["Cap_Titulo"], $capa["Cap_Fuente"], 2, 1, 5, $this->getSql('tb_iRec_Origen'), $capa["Idi_IdIdioma"]);
                    $idcapawms = 0;
                    if (is_array($idrecurso) && $this->filtrarInt($idrecurso[0])) {
                        $capa["Rec_IdRecurso"] = $idrecurso[0];
                        if ($this->getPostParam('leyenda')) {
                            $rutatemp = ROOT . 'tmp' . DS . 'varios' . DS;
                            $ruta = ROOT . 'public' . DS . 'img' . DS . 'mapa' . DS;
                            $filetem = $this->getPostParam('leyenda');
                            $file = 'Leyenda_' . $this->_normalizar_cadena($this->getSql('titulo')) . "." . explode('.', $filetem)[1];
                            if (is_readable($rutatemp . $filetem)) {
                                rename($rutatemp . $filetem, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ruta . $file));
                                $capa["Cap_Leyenda"] = BASE_URL . "public/img/mapa/" . $file;
                            }
                        } else {
                            if (!empty($this->getPostParam('tb_leyendaurl'))) {
                                $capa["Cap_Leyenda"] = $this->getPostParam('tb_leyendaurl');
                            }
                        }

                        if ($this->getPostParam('imagenprev')) {
                            $rutatemp = ROOT . 'tmp' . DS . 'varios' . DS;
                            $ruta = ROOT . 'public' . DS . 'img' . DS . 'mapa' . DS;
                            $filetem = $this->getPostParam('imagenprev');
                            $file = 'Imagen_' . $this->_normalizar_cadena($this->getSql('titulo')) . "." . explode('.', $filetem)[1];
                            if (is_readable($rutatemp . $filetem)) {
                                rename($rutatemp . $filetem, iconv("UTF-8", "ISO-8859-1//TRANSLIT", $ruta . $file));
                                $capa["Cap_imagenprev"] = BASE_URL . "public/img/mapa/" . $file;
                            } else {
                                $capa["Cap_imagenprev"] = "";
                            }
                        } else {
                            $capa["Cap_imagenprev"] = "";
                        }

                        $idcapawms = $this->_mapa->insertarCapaWms($capa["Tic_IdTipoCapa"], $capa["Cap_UrlBase"], $capa["Cap_UrlCapa"], $capa["Cap_Fuente"], $capa["Cap_Nombre"], $capa["Cap_Titulo"], $capa["Cap_PalabrasClaves2"], $capa["Cap_Resumen"], $capa["Cap_Descripcion"], $capa["Cap_Creditos"], $capa["Cap_Leyenda"], $capa["Cap_imagenprev"], $capa["Cap_IdentificadorFichero1"], $capa["Cap_Idioma1"], $capa["Cap_FechaCreacion1"], $capa["Cap_NormaMetadatos1"], $capa["Cap_VersionNormaMetadatos1"], $capa["Cap_NombreIndividualdeContacto1"], $capa["Cap_NombredelaOrganizaciondeContacto1"], $capa["Cap_CorreodelContacto1"], $capa["Cap_RoldelContacto1"], $capa["Cap_TituloMencion2"], $capa["Cap_FechaMencion2"], $capa["Cap_TipoFechaMencion2"], $capa["Cap_FormaPresentacionMencion2"], $capa["Cap_Resumen2"], $capa["Cap_Proposito2"], $capa["Cap_Estado2"], $capa["Cap_NombreIndividualPuntoContacto2"], $capa["Cap_NombreOrganizacionPuntoContacto2"], $capa["Cap_CorreoElectronicoPuntoContacto2"], $capa["Cap_RolPuntodeContacto2"], $capa["Cap_NombreFicherodeVistadelGrafico2"], $capa["Cap_DescripcionFicherodeVistadelGrafico2"], $capa["Cap_TipoFicherodeVistadelGrafico2"], $capa["Cap_PalabraClaveDescripcionPC2"], $capa["Cap_TipoDescripcionPC2"], $capa["Cap_TipodeRepresentacionEspacial2"], $capa["Cap_ResolucionEspacial2"], $capa["Cap_Idioma2"], $capa["Cap_CategoriadeTema2"], $capa["Cap_LimiteLongitudOeste2"], $capa["Cap_LimiteLongitudEste2"], $capa["Cap_LimiteLatitudSur2"], $capa["Cap_LimiteLatitudNorte2"], $capa["Cap_Extension2"], $capa["Cap_ValorMinimo2"], $capa["Cap_ValorMaximo2"], $capa["Cap_UnidadesdeMedida2"], $capa["Cap_LimitaciondeUso3"], $capa["Cap_ConstriccionesdeAcceso3"], $capa["Cap_ConstriccionesdeUso3"], $capa["Cap_ConstriccionesdeOtroTipo3"], $capa["Cap_Nivel4"], $capa["Cap_Declaracion4"], $capa["Cap_FrecuenciadeMantenimientoyActualizacion5"], $capa["Cap_FechaProximaActualizacion5"], $capa["Cap_NivelTopologia6"], $capa["Cap_TipoObjetoGeometrico6"], $capa["Cap_NumerodeDimensiones6"], $capa["Cap_NombredeDimension6"], $capa["Cap_TamañodeDimension6"], $capa["Cap_Resolucion6"], $capa["Cap_Codigo7"], $capa["Cap_CodigoSitio7"], $capa["Cap_Nombre8"], $capa["Cap_Version8"], $capa["Cap_Enlace8"], $capa["Cap_Protocolo8"], $capa["Cap_NombreOpcionesTransferencia8"], $capa["Cap_Descripcion8"], $capa["Cap_Estado"], $capa["Idi_IdIdioma"], $capa["Rec_IdRecurso"]);
                    }

                    if (is_array($idcapawms)) {
                        if ($idcapawms[0] > 0) {
                            $mensaje = "ok";
                            $contenido = "Se Registró con éxito los datos";
                            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                        } else {
                            $bdrecurso->eliminarRecurso($idrecurso[0]);
                            $mensaje = "error";
                            $contenido = "No se registró los datos, Registro: " . $idcapawms . "-" . $idrecurso;
                            array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                        }
                    } else {
                        $bdrecurso->eliminarRecurso($idrecurso[0]);
                        $mensaje = "error";
                        $contenido = "Ocurrio un error al Registrar los datos, Error: " . $idcapawms;
                        array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                    }
                } else {
                    $mensaje = "error";
                    $contenido = "La Capa " . $capa["Cap_Titulo"] . " se encuentra registrada como " . $existecapa[0]["Cap_Titulo"] . "!...";
                    array_push($resultado, array(0 => $mensaje, 1 => $contenido));
                }
            } else {
                $mensaje = "error";
                $contenido = "LLene los campos obligatorios: " . (($capa["Cap_UrlBase"]) ? "" : "Url Base") . (($capa["Cap_UrlCapa"]) ? "" : " | Url Capa") . (($capa["Cap_Titulo"]) ? "" : " | Titulo") . (($capa["Cap_Fuente"]) ? "" : " | Fuente");
                array_push($resultado, array(0 => $mensaje, 1 => $contenido));
            }
        }


        //echo $capa["Cap_Leyenda"];
        echo json_encode($resultado);
    }

    private function _LeerWMSCapacidades($urlwms) 
    {
        $urlbase;
        if (strpos($urlwms, '?') == strlen($urlwms) - 1) 
        {
            $urlbase = $urlwms;
        } 
        else if (empty(strpos($urlwms, '?'))) 
        {
            $urlbase = $urlwms . "?";
        } 
        else 
        {
            $urlbase = $urlwms . "&";
        }

        $urlwms = $urlbase . "request=GetCapabilities&service=WMS";
        /* $urlwms = $urlwms .
          "&Service=" . "WMS" .
          "&Version=" . "1.1.0" .
          "&Request=" . "GetCapabilities"; */
        // "&tema="."wwfterr";
        //libxml_disable_entity_loader(false);
        //$temp = file_get_contents($urlwms);   
        // libxml_disable_entity_loader(false); 
        //$urlwms = str_replace("%C3%A7", "ç", $urlwms);
        //$urlwms = str_replace("%C3%A3", "ã", $urlwms);
        //echo $urlwms;
        // $xml = file_get_contents($urlwms);
        $this->_xml_wms = simplexml_load_file($urlwms);
        //$this->_xml_wms =simplexml_load_string($xml);
        return $urlbase;
    }

    public function _uploadimagentemp() 
    {
        $upload_folder = "images";
        $nombre_archivo = $_FILES["archivo"]["name"];

        $tipo_archivo = $_FILES["archivo"]["type"];

        $tamano_archivo = $_FILES["archivo"]["size"];

        $tmp_archivo = $_FILES["archivo"]["tmp_name"];

        $ruta = ROOT . 'tmp' . DS . 'varios'. DS;

        if (!move_uploaded_file($tmp_archivo, $ruta . $_FILES['archivo']['name'])) 
        {
            $return = Array("error" => FALSE, "msg" => "Ocurrio un error al subir el archivo. No pudo guardarse.", "status" => "error");
        } 
        else 
        {
            //$return = Array("ok" => TRUE, "msg" => BASE_URL . "public/img/temp/" . $nombre_archivo);
            $return = Array("ok" => TRUE, "msg" => $nombre_archivo);
        }

        echo json_encode($return);
    }

    public function _cambiarEstadoCapa() 
    {
        //$this->_view->getLenguaje("hidrogeo_rio");
        $this->_view->getLenguaje("mapa_gestorcapa");

        $pagina = $this->getInt('pagina');
        $idcapa = $this->getInt('idcapa');
        $estado = $this->getInt('estado');
        $palabra = $this->getSql('busqueda');
        
        if($pagina = $this->getInt('pagina')&&$idcapa = $this->getInt('idcapa')){
        //$idPais = $this->getInt('idpais');
        //$idtipo_agua = $this->getInt('idtipo_agua');

        $condicion = "";

        $condicion .= " where Cap_Nombre liKe '%$palabra%' ";

        $paginador = new Paginador();

        $this->_mapa->actualizarEstadoCapa($idcapa, $estado);

        $this->_view->assign('capas', $paginador->paginar($this->_mapa->listarCapaWms(), "gestorcapa_lista_capas", '', $pagina, 25));
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('control_paginacion', $paginador->getControlPaginaion());
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());

        $this->_view->renderizar('ajax/gestorcapa_lista_capas', false, true);
        }else{
            echo "Faltan Parametros";
        }

        
    }

    public function _eliminarCapa($busqueda = "") 
    {
        //$this->validarUrlIdioma();
        $capa = $this->getInt('idcapa');

        $result = $this->_mapa->eliminarCapaCompleto($capa);
        if (is_int($result)) 
        {
            if ($result > 0) 
            {
                $this->_buscarCapa();
                exit;
            }
        }
        echo json_encode(array(array(0 => "error", 1 => "No se puede eliminar la Capa, verifique que no esté siendo utilizada")));
    }

    private function _verificarFileTypeKML() 
    {
        if (($_FILES["kml"]["type"] == "application/vnd.google-earth.kml+xml") || ($_FILES["kml"]["type"] == "application/xml") || ($_FILES["kml"]["type"] == "text/xml") || ($_FILES["kml"]["type"] == "application/gpx+xml"))
            return true;
        else
            return false;
    }
    private function _verificarFileTypeGEOJSON() 
    {
        if (($_FILES["file_json"]["type"] == "application/vnd.geo+json")||($_FILES["file_json"]["type"] == "text/plain"))
            return true;
        else
            return false;
    }
     private function _cargarGEOJSON($idecapa){
        $this->_view->assign("tjson", "active");
        $this->_view->assign("tipo_json", "url");
        if ($this->botonPress('bt_agregar_geojson')) 
        {
            $this->_view->assign("tipo_json", "url");
            $this->_view->assign("url_json", $this->getTexto('url_json'));
            if ((!$this->getTexto('url_json'))) 
            {
                $this->_view->assign('_error', 'Debe introducir URL del canal GeoRSS');
            } 
            else if (!filter_var($this->getTexto('url_json'), FILTER_VALIDATE_URL)) 
            {
                $this->_view->assign('_error', 'URL no es valido');
            } 
            else 
            {
                $this->_view->assign("formulario",true);                   
            }
        }
        else  if ($this->botonPress('bt_cargar_geojson')) 
        {
            $this->_view->assign("tipo_json", "archivo");
            if (isset($_FILES['file_json']['name'])) 
            {
                if ($_FILES["file_json"]["error"] == 4) 
                {
                    $this->_view->assign('_error',"Seleccionar Archivo." );
                } 
                else if ($_FILES["file_json"]["error"] > 0 && $_FILES["file_json"]["error"])
                   $this->_view->assign('_error', "Error: " . $_FILES["file_json"]["error"]);                  
                else if ($this->_verificarFileTypeGEOJSON() || $this->_verificarFileExtensionGEOJSON()) 
                {
                    $ruta = ROOT . 'tmp' . DS . 'varios'. DS;
                    $temp_file = $_FILES['file_json']['tmp_name'];
                    $nombre=uniqid().$_FILES['file_json']['name'];
                    move_uploaded_file($temp_file, $ruta . $nombre);
                    $json["titulo"] = $_FILES['file_json']['name'];
                    $json["nombre"] = $nombre;
                    
                    $this->_view->assign('file_json',$json);
                    $this->_view->assign("formulario",true);
                } 
                else 
                {
                    $this->_view->assign('_error', "Tipo de archivo no admitido. Type:" . $_FILES["file_json"]["type"]); 
                }
            } 
        }
        
        
    }

    private function _cargarGEORSS($idecapa){
        $this->_view->assign("trss", "active");
        if ($this->botonPress('bt_agregar_georss')) 
        {
            $this->_view->assign("url_rss", $this->getTexto('url_rss'));
            if ((!$this->getTexto('url_rss'))) 
            {
                $this->_view->assign('_error', 'Debe introducir URL del canal GeoRSS');
            } 
            else if (!filter_var($this->getTexto('url_rss'), FILTER_VALIDATE_URL)) 
            {
                $this->_view->assign('_error', 'URL no es valido');
            } 
            else 
            {
                $this->_view->assign("formulario",true);                   
            }
        }
    }
    
    
    private function _cargaWMS($idcapa) 
    {
        $this->_view->assign("twms", "active");
        
        if ($this->botonPress('bt_agregar_wms')) 
        {
            $this->_view->assign("urlbase", $this->getTexto('urlbase'));
            if ($this->getTexto('cb_carga_avanzada'))
                $this->_view->assign("gestoravanzado", $this->getTexto('cb_carga_avanzada'));

            if ((!$this->getTexto('urlbase'))) 
            {
                $this->_view->assign('_error', 'Debe introducir URL del Servicio');
            } 
            else if (!filter_var($this->getTexto('urlbase'), FILTER_VALIDATE_URL)) 
            {
                $this->_view->assign('_error', 'URL no es valido');
            } 
            else 
            {
                try 
                {
                    $urlbase = $this->_LeerWMSCapacidades($this->getTexto('urlbase'));
                    $this->_view->assign("urlbase", $urlbase);

                    if (!empty($this->_xml_wms)) 
                    {
                        $this->_view->assign("xml_wms", $this->_xml_wms);
                        // $this->_view->assign('pais', $this->_mapa->listarPais());
                    } 
                    else 
                    {
                        $this->_view->assign("_error", "No se puede contactar con el servidor, Verificar Url del Servicio");
                    }
                } 
                catch (Exception $exc) 
                {
                    $this->_view->assign("_error", $exc->getTraceAsString());
                }
                // $this->_view->url_wms_base=$urlbase;
                $this->_view->assign("formulario",true);
            }
        }
        else if ($this->botonPress('bt_agregar_wms_editar')) 
        {
            $this->_view->assign("urlbase", $this->getTexto('urlbase'));

            if ($this->getTexto('cb_carga_avanzada'))
                $this->_view->assign("gestoravanzado", $this->getTexto('cb_carga_avanzada'));

            if ((!$this->getTexto('urlbase'))) 
            {
                $this->_view->assign('_error', 'Debe introducir URL del Servicio');
            } 
            else if (!filter_var($this->getTexto('urlbase'), FILTER_VALIDATE_URL)) 
            {
                $this->_view->assign('_error', 'URL no es valido');
            } 
            else 
            {
                try 
                {
                    $urlbase = $this->_LeerWMSCapacidades($this->getTexto('urlbase'));
                    $this->_view->assign("urlbase", $urlbase);

                    if (!empty($this->_xml_wms)) 
                    {
                        $this->_view->assign("xml_wms_editar", $this->_xml_wms);
                        // $this->_view->assign('pais', $this->_mapa->listarPais());
                    } 
                    else 
                    {
                        $this->_view->assign("_error", "No se puede contactar con el servidor, Verificar Url del Servicio");
                    }
                } 
                catch (Exception $exc) 
                {
                    $this->_view->assign("_error", $exc->getTraceAsString());
                }
                // $this->_view->url_wms_base=$urlbase;
            }
        } 
        
        
    }

    private function _cargarKML() 
    {
        $this->_view->assign("tkml", "active");

        if ($this->botonPress('bt_cargar_kml')) 
        {
            if (isset($_FILES['kml']['name'])) 
            {
                if ($_FILES["kml"]["error"] == 4) 
                {
                    $this->_view->assign('_error',"Seleccionar Archivo." );
                } 
                else if ($_FILES["kml"]["error"] > 0 && $_FILES["kmz"]["error"])
                   $this->_view->assign('_error', "Error: " . $_FILES["kml"]["error"]);                  
                else if ($this->_verificarFileTypeKML() || $this->_verificarFileExtensionKML()) 
                {
                    $ruta = ROOT . 'tmp' . DS . 'varios'. DS;
                    $temp_file = $_FILES['kml']['tmp_name'];
                    $monbre=uniqid().$_FILES['kml']['name'];
                    move_uploaded_file($temp_file, $ruta . $monbre);
                    $kml["titulo"] = $_FILES['kml']['name'];
                    $kml["nombre"] = $monbre;
                    
                    $this->_view->assign('kml', $kml);
                    $this->_view->assign("formulario",true);
                } 
                else 
                {
                    $this->_view->assign('_error', "Error: " . $_FILES["kml"]["error"]); 
                }
            }
        } 
        else if ($this->botonPress('bt_guardar_kml')) {
            //..........registro del jml-
        }
    }

    private function _verificarFileExtensionKML() 
    {
        $file_extension = end(explode(".", $_FILES["kml"]["name"]));     
        if ($file_extension == "gpx" || $file_extension == "kml" || $file_extension == "kmz" || $file_extension == "rar" || $file_extension == "zip")
            return true;
        else
            return false;
    }
    private function _verificarFileExtensionGEOJSON() 
    {
        $file_extension = end(explode(".", $_FILES["file_json"]["name"]));        
        if ($file_extension == "json" || $file_extension == "geojson" || $file_extension == "txt")
            return true;
        else
            return false;
    }

    private function _normalizar_cadena($s)
    {
        $patrones = array ('[\s+]',
                   '/[áàâãª]/',
                   '/[ÁÀÂÃ]/',
                   '/[ÍÌÎ]/',
                   '/[íìî]/',
                   '/[éèê]/',
                   '/[ÉÈÊ]/',
                   '/[óòôõº]/',
                   '/[ÓÒÔÕ]/',
                   '/[úùû]/',
                   '/[ÚÙÛ]/',
                   );
        $sustitución = array ('', 
            'a',
            'A',
            'I',
            'i',
            'e',
            'E',
            'o',
            'O',
            'u',
            'U',

            );
        $s = str_replace('ç','c',$s);
        $s = str_replace('Ç','C',$s);
        $s = str_replace('ñ','n',$s);
        $s = str_replace('Ñ','N',$s);   

        return preg_replace($patrones, $sustitución, $s);

     
    }

}
