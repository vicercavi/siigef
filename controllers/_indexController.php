<?php

class indexController extends Controller 
{
    //private $_inicio;
    private $_pagina;
    private $_dublin;
    private $_legal;
    private $_recurso;
    private $_jsonBusqueda;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_pagina = $this->loadModel('index', 'arquitectura');
    } 
    
    public function index($idPagina = 1) 
    {            
        if (Cookie::get('idioma') == NULL&&!$this->_lenguaje) 
        {
            $this->_view->getLenguaje("template_frontend");
            Cookie::set('idioma', 1);
            $this->_view->setTemplate('seleidioma');
            $this->_view->assign('titulo', 'Portada');
            $this->_view->renderizar('inicio', 'inicio');
        } 
        else 
        {
            $this->_acl->autenticado();
            $this->validarUrlIdioma();
            $this->_view->setTemplate(LAYOUT_FRONTEND);
            $this->_view->getLenguaje("index_inicio");
            $this->_view->setJs(array('index'));
            $condicion1 = '';
            $id = $this->filtrarInt($idPagina);

            $condicion1 .= " WHERE pa.Pag_Estado = 1 AND pa.Pag_IdPagina = $id ";
            $datos = $this->_pagina->getPaginaTraducida($condicion1, Cookie::lenguaje());


            //MenuRaiz
            if ($id>1) 
            {
                $padre = "";
                $arbolRaiz = $this->_pagina->getMenusRaiz($datos['Pag_TipoPagina'],$id);
                if(!empty($arbolRaiz) && count($arbolRaiz)){
                    if (!empty($arbolRaiz[0])) {
                        $padre = $this->getRaizPadre($arbolRaiz);
                    }                
                } 
                $arrayRaiz = array_reverse(explode("::", $padre));
                $arrayRaiz = array_chunk($arrayRaiz, 1);
                $this->_view->assign('menuRaiz', $arrayRaiz);
            }
            //FIn Menu Raiz
            
            $this->_view->assign('datos', $datos);
            $this->_view->assign('titulo', $datos['Pag_Nombre']);
            $this->_view->renderizar('index', 'inicio');
        }
    }
    public function getRaizPadre($arbolRaiz,$padreI = true)
    {
        $padre = "";
        //print_r($arbolRaiz);
        $href = $arbolRaiz[0]['Pag_IdPagina'];
        $Pag_Nombre = $arbolRaiz[0]['Pag_Nombre'];
        if ($padreI) 
        {
            $raiz = " <li>/</li><li> <a class='actual'>".$Pag_Nombre." </a> </li> :: ";
            $padre .= $raiz;
        } 
        else 
        {
            $raiz = " <li>/</li><li> <a href='".BASE_URL."index/index/".$href."'>".$Pag_Nombre." </a> </li> :: ";
            $padre .= $raiz;    
        }
        
        //echo $padre."0000000000000000000000000000000";
        for ($i = 0; $i < count($arbolRaiz); $i++) 
        {
            if (!empty($arbolRaiz[$i]["padre"])) 
            {
                $raizPadre = $arbolRaiz[$i]["padre"];                
                $temph = $this->getRaizPadre($raizPadre,false);
                $padre .= $temph;
            } 
        }
        return $padre;
    }

    public function _loadLang($lang) 
    {
        Cookie::setLenguaje($lang);
        if (isset($_SERVER['HTTP_REFERER'])) 
        {
            $ruta_anterior = $_SERVER['HTTP_REFERER'];
            $antLang = Cookie::antlenguaje();
            $ok = FALSE;
            $ruta = "";
            $ruta_anterior = explode('/', $ruta_anterior);

            foreach ($ruta_anterior as $value) 
            {
                if ($ok) 
                {
                    $ruta = $ruta . $value . "/";
                }
                if ($value == $antLang) 
                {
                    $ok = true;
                }
            }

            $ruta = substr($ruta, 0, strlen($ruta) - 1);
            //echo $ruta;
            $this->redireccionar($ruta);
        } 
        else
            $this->redireccionar();
    }

    public function buscarPalabra($palabraBuscada = false, $tipoRegistro = false, $pais = "all", $json = false) 
    {
        $this->_acl->autenticado();
        //$pais="";
        //$pais = $this->getPostParam('pais');
        if (!$json ) 
        {
            $this->validarUrlIdioma();
            $this->_view->setTemplate(LAYOUT_FRONTEND);
            $this->_view->setJs(array('index'));
            $this->_view->setCss(array('buscar'));            
            //$palabraBuscada=$palabra;}
        }

        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("index_buscador");
            
        $tipoRegistro = $this->filtrarInt($tipoRegistro);
        $this->_dublin = $this->loadModel('documentos', 'dublincore');
        $this->_legal = $this->loadModel('legal', 'legislacion');
        $this->_recurso = $this->loadModel('bdrecursos');
        $filtroTipo = "all";


        if ($palabraBuscada=='all') 
        {
            $palabra = 'all';
            $palabraBuscada = '';
        } 
        else 
        {
            $palabra = $palabraBuscada;
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $r = $this->_pagina->registrarBusqueda($palabra, $ip, '');
        
        $condicionPagina = " WHERE pa.Pag_Estado = 1 AND (pa.Pag_Nombre LIKE '%$palabraBuscada%' OR pa.Pag_Descripcion LIKE '%$palabraBuscada%' OR pa.Pag_Contenido LIKE '%$palabraBuscada%' )";
        if($pais=='all')
        {
            $condicionDublinPais = "";
            $condicionDublin = " WHERE Dub_Estado = 1 AND (Dub_Titulo LIKE '%$palabraBuscada%' OR Dub_Descripcion LIKE '%$palabraBuscada%' OR Dub_PalabraClave LIKE '%$palabraBuscada%' OR Aut_Nombre LIKE '%$palabraBuscada%')";
            $condicionLegal = " WHERE Mal_Estado =1 AND (Mal_Titulo LIKE '%$palabraBuscada%' OR Mal_PalabraClave LIKE '%$palabraBuscada%' OR Mal_ResumenLegislacion LIKE '%$palabraBuscada%' OR Mal_Entidad LIKE '%$palabraBuscada%')";
        } 
        else 
        {
            //echo $pais."/".$palabra;
            $condicionDublinPais = " WHERE d.Pai_Nombre = '$pais' ";
            $condicionDublin = " WHERE Pai_Nombre = '$pais' AND Dub_Estado = 1 AND (Dub_Titulo LIKE '%$palabraBuscada%' OR Dub_Descripcion LIKE '%$palabraBuscada%' OR Dub_PalabraClave LIKE '%$palabraBuscada%' OR Aut_Nombre LIKE '%$palabraBuscada%')";
            $condicionLegal = " WHERE Pai_Nombre = '$pais' AND Mal_Estado =1 AND (Mal_Titulo LIKE '%$palabraBuscada%' OR Mal_PalabraClave LIKE '%$palabraBuscada%' OR Mal_ResumenLegislacion LIKE '%$palabraBuscada%' OR Mal_Entidad LIKE '%$palabraBuscada%')";    
        }

        $idioma = Cookie::lenguaje();

        $listaPagina = $this->_pagina->getPaginas($condicionPagina, $idioma);
        $listaDublin = $this->_dublin->getDocumentosPaises($condicionDublin, $idioma);

        $listaLegal = $this->_legal->getLegislaciones($condicionLegal, $idioma);
        $listaRecurso = $this->_recurso->getRecursoBusquedaTraducido($palabraBuscada, $idioma);
        //print_r($listaLegalPaises);exit;
        
        //Paises
        $listaDublinPaises = $this->_dublin->getCantDocumentosPaises($condicionDublin,$idioma);
        $listaLegalPaises = $this->_legal->getCantidadLegislacionPaisV2($condicionLegal,$idioma);
        //$listaLegalPaises = $this->_legal->getCantLegislacionesPais($condicionLegal,$idioma);
        //$listaLegalPaises = $this->_recurso->getCantidadDocumentosPaises($condicionDublin);
        /* 
	echo count($listaLegalPaises);
        print_r($listaLegalPaises);
        print_r($listaDublinPaises);
	*/
        $listaPaisTotales = array();
        
        for ($i = 0; $i <= count($listaDublinPaises); $i++) 
        {
           // echo $i;echo $listaDublinPaises[$i]['cantidad'];
            for ($j = 0; $j <= count($listaLegalPaises); $j++) 
            {
              //  echo $j;
                if(isset($listaDublinPaises[$i]) && isset($listaLegalPaises[$j]) ) 
                {
                    if($listaDublinPaises[$i]['Pai_Nombre'] == $listaLegalPaises[$j]['Pai_Nombre'] )
                    {
                        $listaPaisTotales[$i]['cantidad'] = $listaDublinPaises[$i]['cantidad'] + $listaLegalPaises[$j]['cantidad'];
                        $listaPaisTotales[$i]['Pai_Nombre'] = $listaDublinPaises[$i]['Pai_Nombre'];
                   // echo $listaPaisTotales[$i]['cantidad'];
                        
                    }
                }
                
            }
        }

        //Fin Paises
        
        $cantPagina = count($listaPagina);
        $cantDublin = count($listaDublin);
        $cantLegal = count($listaLegal);
        $cantRecurso = count($listaRecurso);
        $listaBusqueda = array();
        $listaBus = array();        
        
        if (!$tipoRegistro) 
        {
            if (!$json) 
            {
                foreach ($listaPagina as $arra1) 
                {
                    // echo $arra['Pag_Nombre'];   exit;
                    array_push($listaBusqueda, $arra1['Pag_IdPagina'], $arra1['Pag_Nombre'], substr($arra1['Pag_Descripcion'], 0, 200), 'index/index/', 1, '', '', '', $arra1['Idi_IdIdioma']);
                    array_push($listaBus, $listaBusqueda);
                    $listaBusqueda = array();
                }            
            }

            foreach ($listaDublin as $arra2) 
            {
                // echo $arra['Pag_Nombre'];   exit;
                array_push($listaBusqueda, $arra2['Dub_IdDublinCore'], $arra2['Dub_Titulo'], substr($arra2['Dub_Descripcion'], 0, 200), 'dublincore/documentos/metadata/', 2, $arra2['Arf_PosicionFisica'], $arra2['Arf_IdArchivoFisico'], $arra2['Taf_Descripcion'], $arra2['Idi_IdIdioma']);
                array_push($listaBus, $listaBusqueda);
                $listaBusqueda = array();
            }
            foreach ($listaLegal as $arra3) 
            {
                // echo $arra['Pag_Nombre'];   exit;
                array_push($listaBusqueda, $arra3['Mal_IdMatrizLegal'], $arra3['Mal_Titulo'], substr($arra3['Mal_ResumenLegislacion'], 0, 200), 'legislacion/legal/metadata/', 3, '', '', '', $arra3['Idi_IdIdioma']);
                array_push($listaBus, $listaBusqueda);
                $listaBusqueda = array();
            }
            foreach ($listaRecurso as $arra4) 
            {
                // echo $arra['Pag_Nombre'];   exit;
                array_push($listaBusqueda, $arra4['Rec_IdRecurso'], $arra4['Rec_Nombre'], substr($arra4['Rec_Descripcion'], 0, 200), 'bdrecursos/metadata/index/', 4, '', '', '', $arra4['Idi_IdIdioma']);
                array_push($listaBus, $listaBusqueda);
                $listaBusqueda = array();
            }
        } 
        else 
        {
            if ($tipoRegistro == 1) 
            {
                foreach ($listaPagina as $arra1) 
                {
                    // echo $arra['Pag_Nombre'];   exit;
                    array_push($listaBusqueda, $arra1['Pag_IdPagina'], $arra1['Pag_Nombre'], substr($arra1['Pag_Descripcion'], 0, 200), 'index/index/', 1, '', '', '', $arra1['Idi_IdIdioma']);
                    array_push($listaBus, $listaBusqueda);
                    $listaBusqueda = array();
                }

                $filtroTipo = 'Arquitectura SII'; 
                for ($j = 0; $j <= count($listaPaisTotales); $j++) 
                {
                  //  echo $j;
                    if(isset($listaPaisTotales[$j])) 
                    {                        
                        $listaPaisTotales[$j]['cantidad'] = 0;
                    }                    
                }
            } 
            else 
            {
                if ($tipoRegistro == 2) 
                {
                    foreach ($listaDublin as $arra2) 
                    {
                        // echo $arra['Pag_Nombre'];   exit;
                        array_push($listaBusqueda, $arra2['Dub_IdDublinCore'], $arra2['Dub_Titulo'], substr($arra2['Dub_Descripcion'], 0, 200), 'dublincore/documentos/metadata/', 2, $arra2['Arf_PosicionFisica'], $arra2['Arf_IdArchivoFisico'], $arra2['Taf_Descripcion'], $arra2['Idi_IdIdioma']);
                        array_push($listaBus, $listaBusqueda);
                        $listaBusqueda = array();
                    }

                    $filtroTipo = 'Base de Datos de Documentos';                    
                    $listaPaisTotales = $listaDublinPaises;
                } 
                else 
                {
                    if ($tipoRegistro == 3) 
                    {
                        foreach ($listaLegal as $arra3) 
                        {
                            // echo $arra['Pag_Nombre'];   exit;
                            array_push($listaBusqueda, $arra3['Mal_IdMatrizLegal'], $arra3['Mal_Titulo'], substr($arra3['Mal_ResumenLegislacion'], 0, 200), 'legislacion/legal/metadata/', 3, '', '', '', $arra3['Idi_IdIdioma']);
                            array_push($listaBus, $listaBusqueda);
                            $listaBusqueda = array();
                        }

                        $filtroTipo = 'Base de Datos de Legislacion';                        
                        $listaPaisTotales = $listaLegalPaises;
                    } 
                    else 
                    {
                        if ($tipoRegistro == 4) 
                        {
                            foreach ($listaRecurso as $arra4) 
                            {
                                // echo $arra['Pag_Nombre'];   exit;
                                array_push($listaBusqueda, $arra4['Rec_IdRecurso'], $arra4['Rec_Nombre'], substr($arra4['Rec_Descripcion'], 0, 200), 'bdrecursos/metadata/', 4, '', '', '', $arra4['Idi_IdIdioma']);
                                array_push($listaBus, $listaBusqueda);
                                $listaBusqueda = array();
                            }

                            $filtroTipo = 'Base de Datos de Recursos';
                            for ($j = 0; $j <= count($listaPaisTotales); $j++) 
                            {
                              //  echo $j;
                                if(isset($listaPaisTotales[$j])) 
                                {                        
                                    $listaPaisTotales[$j]['cantidad'] = 0;
                                }                    
                            }
                        } else 
                        {
                            $filtroTipo = 'all';
                        }
                    }                    
                }                  
            }
        }

        $idiomas = $this->_pagina->getIdiomas();
        //echo $listaBus[0][0].'////55555555';
        // print_r($listaBus);  // exit;
        $cantTotal = count($listaBus);
        $registros = $this->getInt('registros');
        $_SESSION['resultado'] = $listaBus;
        if ($json == 1) {
            //print_r($listaBus);
            return $listaBus;
        }
        //$this->_jsonBusqueda = $listaBus;
        unset($listaBus);
        $paginador = new Paginador();
        $this->_view->assign('resultadoBusqueda', $paginador->paginar($_SESSION['resultado'], "ResultadoBusqueda", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('cantidadporpagina', $registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('cantTotal', $cantTotal);
        $this->_view->assign('palabra1', $palabra);
        $this->_view->assign('palabra', $palabraBuscada);
        $this->_view->assign('tipoRegistro', $tipoRegistro);

        if ($palabraBuscada != 'all') {
            $this->_view->assign('palabrabuscada', $palabraBuscada);
        } 
        if ($filtroTipo != 'all') {
            $this->_view->assign('filtroTipo', $filtroTipo);
        }
        if ($pais != 'all') {
            $this->_view->assign('filtroPais', $pais);
        }

        $this->_view->assign('paises', $listaPaisTotales );
        $this->_view->assign('idiomas', $idiomas);
        $this->_view->assign('cantPagina', $cantPagina);
        $this->_view->assign('cantDublin', $cantDublin);
        $this->_view->assign('cantLegal', $cantLegal);
        $this->_view->assign('cantRecurso', $cantRecurso);
        $this->_view->assign('titulo', 'Resultado de Búsqueda');
        
        $this->_view->renderizar('buscar');
    
        //$this->_view->renderizar('ajax/ResultadoBusqueda', false, true);
        
    }
    /*
    public function _buscarPorPais() {
        $palabra = $this->getSql('palabra');
        $variables = $this->getSql('variables');
        
        $paginador = new Paginador();
        
        $this->_view->setJs(array('documentos'));

        $this->_view->assign('documentos', $paginador->paginar($this->_documentos->getDocumentosPaises($condicion,$idioma),"paginar","", $pagina,$registro));
        $paginador = new Paginador();
        $this->_view->assign('resultadoBusqueda', $paginador->paginar($_SESSION['resultado'], "ResultadoBusqueda", "", false, 25));
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('cantidadporpagina', $registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->assign('cantTotal', $cantTotal);
        $this->_view->assign('palabra1', $palabra);
        $this->_view->assign('palabra', $palabraBuscada);
        $this->_view->assign('tipoRegistro', $tipoRegistro);
        $this->_view->assign('idiomas', $idiomas);
        $this->_view->assign('cantPagina', $cantPagina);
        $this->_view->assign('cantDublin', $cantDublin);
        $this->_view->assign('cantLegal', $cantLegal);
        $this->_view->assign('cantRecurso', $cantRecurso);
        $this->_view->assign('titulo', 'Resultado de Búsqueda');
        $this->_view->renderizar('buscar');
    }*/

    public function _paginacion_ResultadoBusqueda() 
    {
        $paginador = new Paginador();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("index_buscador");
        $registros = $this->getInt('registros');
        $pagina = $this->getPostParam('pagina');
        $idiomas = $this->_pagina->getIdiomas();
        //echo $pagina;
        $this->_view->assign('resultadoBusqueda', $paginador->paginar($_SESSION['resultado'], "ResultadoBusqueda", "", $pagina, 25));
        $this->_view->assign('idiomas', $idiomas);
        $this->_view->assign('numeropagina', $paginador->getNumeroPagina());
        $this->_view->assign('cantidadporpagina', $registros);
        $this->_view->assign('paginacion', $paginador->getView('paginacion_ajax'));
        $this->_view->renderizar('ajax/ResultadoBusqueda', false, true);
    }

    public function _getJsonResultadoBusqueda($palabraBuscada = false, $tipoRegistro = false) 
    {
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        $resultado = $this->buscarPalabra($palabraBuscada, $tipoRegistro, 1);
        //$resultado = $this->_jsonBusqueda;
        //print_r($resultado);
        echo json_encode($this->utf8_converter_array($resultado));        
    }
    public function _getJsonIdiomas() 
    {
        header('content-type: application/json; charset=utf-8');
        header("access-control-allow-origin: *");
        $idiomas = $this->_pagina->getIdiomas();
        //$resultado = $this->_jsonBusqueda;
        
        echo json_encode($this->utf8_converter_array($idiomas));        
    }

    public function _getLang() 
    {
        echo Cookie::lenguaje();
    }

}

?>
