<?php

class registrarController extends Controller 
{
    private $_dublincore;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_dublincore = $this->loadModel('registrar');
        $this->_bdrecursos = $this->loadModel('indexbd', 'bdrecursos');
    }

    public function index($recurso = false) 
    {
        $this->_acl->acceso('registro_individual');
        $this->validarUrlIdioma();
        //$this->_view->setTemplate(LAYOUT_FRONTEND);
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->setJs(array('dublincore'));

        if (empty($this->getSql('Idi_IdIdioma'))) 
        {
            $idioma = Cookie::lenguaje();
        } 
        else 
        {
            $idioma = $this->getSql('Idi_IdIdioma');
        }
       
        $_SESSION['recurso'] = $recurso;
        $metadatarecurso = $this->_bdrecursos ->getRecursoCompletoXid($_SESSION['recurso']);
        $idestandar = $this->_dublincore->getEstandarRecurso($this->filtrarInt($recurso));
        $this->_view->assign('recurso', $metadatarecurso);
        $this->_view->assign('ficha', $this->_dublincore->getFichaLegislacion($idestandar[0][0], $idioma));
        $this->_view->assign('idiomas', $this->_dublincore->getIdiomas());
        $this->_view->assign('autores', $this->_dublincore->getAutores());
        $this->_view->assign('idioma', $idioma);
        $this->_view->assign('palabraclave', $this->_dublincore->getPalabrasClaves($idioma));
        $this->_view->assign('tipodublin', $this->_dublincore->getTiposDublin($idioma));
        $this->_view->assign('temadublin', $this->_dublincore->getTemasDublin($idioma));
        $this->_view->assign('formatos_archivos', $this->_dublincore->getFormatoArchivo());
        $this->_view->assign('titulo', 'Formulario de Registro');

        if ($this->getInt('registrar') == 1) 
        {
            $pais_no_encontrado = array();
            $pais_encontrado = array();

            if (!empty($_FILES["Arf_IdArchivoFisico"]['name'])) 
            {
                $nombre_archivo = $_FILES["Arf_IdArchivoFisico"]['name'];
            } 
            else 
            {
                $nombre_archivo = '';
            }

            if (!empty($this->getSql('Arf_URL'))) 
            {
                $url_archivo = $this->getSql('Arf_URL');
            } 
            else 
            {
                $url_archivo = '';
            }

            $archivo_fisico = $this->_dublincore->getArchivoFisico($nombre_archivo);

            if (empty($archivo_fisico) or ! empty($url_archivo)) 
            {
                $formato = $this->_dublincore->getFormatosArchivos($this->getSql('Dub_Formato'));

                if (empty($formato)) 
                {
                    $formato = $this->_dublincore->registrarFormatoArchivo($this->getSql('Dub_Formato'));
                }

                $archivo_fisico = $this->_dublincore->registrarArchivoFisico($this->getSql('Dub_Titulo'), $formato[0], $_FILES['Arf_IdArchivoFisico']['type'], $_FILES['Arf_IdArchivoFisico']['size'], $nombre_archivo, $this->getSql('Dub_FechaDocumento'), $url_archivo, 1, $this->getSql('Dub_Idioma')
                );

                $autor = $this->_dublincore->getAutor($this->getSql('Aut_IdAutor'));

                if (empty($autor)) 
                {
                    $autor = $this->_dublincore->registrarAutor($this->getSql('Aut_IdAutor'));
                }

                $tipo_dublin = $this->_dublincore->getTipoDublin($this->getSql('Tid_IdTipoDublin'), $this->getSql('Idi_IdIdioma'));

                if (empty($tipo_dublin)) 
                {
                    $tipo_dublin = $this->_dublincore->registrarTipoDublin($this->getSql('Tid_IdTipoDublin'), $this->getSql('Idi_IdIdioma'));
                }

                $tema_dublin = $this->_dublincore->getTemaDublin($this->getSql('Ted_IdTemaDublin'), $this->getSql('Idi_IdIdioma'));

                if (empty($tema_dublin)) 
                {
                    $tema_dublin = $this->_dublincore->registrarTemaDublin($this->getSql('Ted_IdTemaDublin'), $this->getSql('Idi_IdIdioma'));
                }

                if ($archivo_fisico) 
                {
                    if (!empty($nombre_archivo)) 
                    {
                        $destino = ROOT_ARCHIVO_FISICO . $nombre_archivo;
                        copy($_FILES['Arf_IdArchivoFisico']['tmp_name'], $destino);
                    }

                    $dublin = $this->_dublincore->registrarDublinCore(
                            $this->getSql('Dub_Titulo'), $this->getSql('Dub_Descripcion'), $this->getSql('Dub_Editor'), $this->getSql('Dub_Colabrorador'), date('d/m/Y', strtotime($this->getSql('Dub_FechaDocumento'))), $this->getSql('Dub_Formato'), $this->getSql('Dub_Identificador'), $this->getSql('Dub_Fuente'), $this->getSql('Dub_Idioma'), $this->getSql('Dub_Relacion'), $this->getSql('Dub_Cobertura'), $this->getSql('Dub_Derechos'), $this->getSql('Dub_PalabraClave'), $tipo_dublin[0], $archivo_fisico[0], $this->getSql('Idi_IdIdioma'), $tema_dublin[0], $this->filtrarInt($recurso));

                    if ($dublin) 
                    {
                        $dublin_autor = $this->_dublincore->getDublinAutor($dublin[0], $autor[0]);

                        if (empty($dublin_autor)) {
                            $dublin_autor = $this->_dublincore->registrarDublinAutor($dublin[0], $autor[0]);
                        }
                    }
                }
                //Para Registro de paises
                $paises = explode(",", $this->getSql('Pai_IdPais'));
                foreach ($paises as $paises) {
                    $paises = trim($paises);
                    $pais = $this->_dublincore->getPais($paises);
                    if (!empty($pais)) {
                        if ($dublin) {
                            if (isset($dublin)) {
                                $documentorelacionado = $this->_dublincore->registrarDocumentosRelacionados($dublin[0], $pais[0]);
                            }
                            array_push($pais_encontrado, $paises);
                        }
                    } else {
                        array_push($pais_no_encontrado, $paises);
                    }
                }
                $mensaje_registrados = '';
                $mensaje_no_registrados = '';
                if (isset($pais_encontrado) && count($pais_encontrado)) 
                {
                    $mensaje_registrados = 'Los Datos fueron registrados correctamente de ';
                    foreach ($pais_encontrado as $item1) 
                    {
                        $mensaje_registrados = $mensaje_registrados . ' - ' . $item1;
                    }
                }
                if (isset($pais_no_encontrado) && count($pais_no_encontrado)) 
                {
                    $mensaje_no_registrados = 'Los siguientes Datos no fueron registrados ';
                    foreach ($pais_no_encontrado as $item2) 
                    {
                        $mensaje_no_registrados = $mensaje_no_registrados . ' - ' . $item2;
                    }
                }

                $this->_view->setJs(array('modal'));
                $this->_view->assign('mensaje', $mensaje_registrados . '.<br>' . $mensaje_no_registrados . '.');
                $this->_view->renderizar('index', 'dublincore');
                exit;
            } 
            else 
            {
                $this->_view->setJs(array('modal'));
                $this->_view->assign('mensaje', 'Archivo Existente, verifique el nombre del archivo a registrar');
                $this->_view->renderizar('index', 'dublincore');
                exit;
            }
        }

        $this->_view->renderizar('index', 'dublincore');
    }

    public function gestion_idiomas($Idi_IdIdioma) 
    {
        $this->_view->setJs(array('dublincore'));
        $e = $this->loadModel('indexbd', 'bdrecursos');
        $metadatarecurso = $e->getRecursoCompletoXid($_SESSION['recurso']);
        $this->_view->assign('recurso', $metadatarecurso);
        $idestandar = $this->_dublincore->getEstandarRecurso($this->filtrarInt($_SESSION['recurso']));
        $this->_view->assign('ficha', $this->_dublincore->getFichaLegislacion($idestandar[0][0], $Idi_IdIdioma));
        $this->_view->assign('idiomas', $this->_dublincore->getIdiomas());
        $this->_view->assign('autores', $this->_dublincore->getAutores());
        $this->_view->assign('idioma', $Idi_IdIdioma);
        $this->_view->assign('palabraclave', $this->_dublincore->getPalabrasClaves($Idi_IdIdioma));
        $this->_view->assign('tipodublin', $this->_dublincore->getTiposDublin($Idi_IdIdioma));
        $this->_view->assign('temadublin', $this->_dublincore->getTemasDublin($Idi_IdIdioma));
        $this->_view->assign('formatos_archivos', $this->_dublincore->getFormatoArchivo());
        $this->_view->assign('titulo', 'Formulario de Registro');

        $this->_view->renderizar('ajax/gestion_idiomas', false, true);
    }
}

?>
