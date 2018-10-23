<?php
/**
 * Description of mapaController
 *
 * @author ROCAVI
 */
class biodiversidadController extends Controller 
{
    private $_bdarwin;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_bdarwin = $this->loadModel('biodiversidad');
    }

    public function index() 
    {
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");

        $this->_view->assign('titulo', 'Visor de Biodiversidad Amazonica');
        $this->_view->setJs(array(
            array('https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true', true),
            array(BASE_URL . "public/js/googlemaps.js", false),
            array(BASE_URL . "public/js/document_ready.js", false),
            'areatematica',
            'index'
        ));
        $this->_view->setCss(array(
            'visor',
            array(BASE_URL . "public/css/visor.css", true)
        ));
        $arbol = new Arbol();
        $this->_view->assign('arbolbiodiversidad', $arbol->enrraizar($this->_bdarwin->listarArbolJerarquiaBioVisor(), "arbol_biodiversidad_visor"));

        $this->_view->renderizar('index', 'plinian');
    }

    public function _puntosPorEspecie() 
    {
        header("access-control-allow-origin: *");
        if ($this->getPostParam('especie')) 
        {
            // echo count(json_decode($this->getPostParam('parametro')));
            $datos = $this->_bdarwin->PuntosPorEspecie(
                    json_decode($this->getPostParam('especie'))
            );
            echo json_encode($datos);
            exit;
        }
        echo json_encode("{0:Faltan Parametros}");
    }

    public function _puntosPorEspecieGet($criterio, $columna, $recurso) 
    {
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");       

        $especie = array(array($criterio, $recurso, $columna));

        $datos = $this->_bdarwin->PuntosPorEspecie($especie);
        echo json_encode($datos);
        
        exit;
    }

    public function _perfilDarwin() 
    {
        $datos = $this->_bdarwin->obtenerDarwinXid(
                $this->getInt('iddarwin')
        );
        $this->_view->assign('especie', $datos);
        $this->_view->renderizar('ajax/index_perfil_especie', false, true);
    }

    public function metadata($id_darwin)
    {
        $this->_acl->autenticado();
        $this->_view->getLenguaje("darwincore_metadata");
        $this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("bdrecursos_metadata");
        $idioma = Cookie::lenguaje();
        $e = $this->loadModel('bdrecursos', true);
        
        $condicion = "";
        
        $id_mca = $this->filtrarInt($id_darwin);        
        
        $metadatadarwin= $this->_bdarwin->getDarwinMetadata($id_darwin);
        
        $metadatarecurso = $e->getRecursoCompletoXid($metadatadarwin[0]['Rec_idRecurso']);
        $this->_view->assign('recurso', $metadatarecurso);
        $this->_view->assign('detalle', $metadatadarwin);
        
        $this->_view->assign('titulo', 'Base de datos Darwin Core');
        
        $this->_view->renderizar('metadata', 'biodiversidad');  
    }

}
