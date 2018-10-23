<?php

class editarController extends Controller 
{
    private $_editar;

    public function __construct($lang, $url) 
    {
        parent::__construct($lang, $url);
        $this->_editar = $this->loadModel('editar');
        $this->_registrar = $this->loadModel('registrar');
    }

    public function index($registros = false) 
    {
        $this->_acl->acceso('editar_registros_recurso');
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->getLenguaje("bdrecursos_metadata");
        $this->_view->setJs(array('dublincore'));

        if ($this->botonPress("editarDublin")) 
        {
            $this->editarDublin($this->filtrarInt($registros));
        }

        $condicion = "";
        $registross = $this->filtrarInt($registros);
        $condicion .= " where dub.Dub_IdDublinCore = $registross ";

        $datos = $this->_editar->getDocumento1($condicion);
        $paises = $this->_editar->getPaises($this->filtrarInt($registros));
        $valor_paises = "";
        $i = 1;

        foreach ($paises as $pais) 
        {
            if ($i == 1) 
            {
                $valor_paises = $pais[0];
                $i++;
            } 
            else 
            {
                $valor_paises = $valor_paises . ', ' . $pais[0];
            }
        }
        //Cargar Datos de Recurso
        $bdrecurso_model = $this->loadModel('indexbd', 'bdrecursos');
        $metadatarecurso = $bdrecurso_model->getRecursoCompletoXid($datos['Rec_IdRecurso']);
        $this->_view->assign('recurso', $metadatarecurso);

        $idestandar = $this->_registrar->getEstandarRecurso($this->filtrarInt($datos['Rec_IdRecurso']));
        $this->_view->assign('ficha', $this->_registrar->getFichaLegislacion($idestandar[0][0], Cookie::lenguaje()));
        $this->_view->assign('idiomas', $this->_registrar->getIdiomas());
        $this->_view->assign('autores', $this->_registrar->getAutores());
        $this->_view->assign('palabraclave', $this->_registrar->getPalabrasClaves(Cookie::lenguaje()));
        $this->_view->assign('tipodublin', $this->_registrar->getTiposDublin(Cookie::lenguaje()));
        $this->_view->assign('temadublin', $this->_registrar->getTemasDublin(Cookie::lenguaje()));
        $this->_view->assign('formatos_archivos', $this->_registrar->getFormatoArchivo());
        $this->_view->assign('paises', $valor_paises);
        $this->_view->assign('datos', $datos);

        $this->_view->assign('titulo', 'Editar Registro');
        $this->_view->renderizar('index', 'editar');
    }

    private function editarDublin($registros = false) 
    {
        if ($this->_editar->verificarIdiomaDublin($this->getInt('Dub_IdDublinCore'), $this->getSql('idiomaSelect'))) 
        {
            $paises = explode(",", $this->getSql('Pai_IdPais'));
            $this->_editar->eliminaDocumentosRelacionados($this->filtrarInt($registros));

            ///Archivo Fisico
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

            $archivo_fisico = $this->_registrar->getArchivoFisico($nombre_archivo);

            if (empty($archivo_fisico) || !empty($nombre_archivo) && $archivo_fisico['Arf_IdArchivoFisico'] == $this->getInt('Arf_IdArchivoFisico')) 
            {
                if (!empty($nombre_archivo)) {//Verifica si esta subiendo una nueva version del archivo para que lo reemplace
                    $ruta_archivo = ROOT_ARCHIVO_FISICO . $this->getSql('Arf_PosicionFisica');
                    if (file_exists($ruta_archivo))
                        unlink($ruta_archivo);

                    $destino = ROOT_ARCHIVO_FISICO . $nombre_archivo;
                    copy($_FILES['Arf_IdArchivoFisico']['tmp_name'], $destino);
                    $archivo_fisico['Arf_TypeMime'] = $_FILES['Arf_IdArchivoFisico']['type'];
                    $archivo_fisico['Arf_TamanoArchivo'] = $_FILES['Arf_IdArchivoFisico']['size'];
                    $archivo_fisico['Arf_PosicionFisica'] = $nombre_archivo;
                }
                else 
                {
                    $archivo_fisico = $this->_registrar->getArchivoFisicoXId($this->getInt('Arf_IdArchivoFisico'));
                }

                $formato = $this->_registrar->getFormatosArchivos($this->getSql('Dub_Formato'));

                if (empty($formato)) 
                {
                    $formato = $this->_registrar->registrarFormatoArchivo($this->getSql('Dub_Formato'));
                }

                $this->_editar->actualizarArchivoFisico(
                        $this->getInt('Arf_IdArchivoFisico'), $this->getSql('Dub_Titulo'), $formato[0], $archivo_fisico['Arf_TypeMime'], $archivo_fisico['Arf_TamanoArchivo'], $archivo_fisico['Arf_PosicionFisica'], $this->getSql('Dub_FechaDocumento'), $url_archivo, 1, $this->getSql('Dub_Idioma')
                );
            }

            $autor = $this->_registrar->getAutor($this->getSql('Aut_IdAutor'));

            if (empty($autor)) 
            {
                $autor = $this->_registrar->registrarAutor($this->getSql('Aut_IdAutor'));
            }

            $tipo_dublin = $this->_registrar->getTipoDublin($this->getSql('Tid_IdTipoDublin'), Cookie::lenguaje());

            if (empty($tipo_dublin)) 
            {
                $tipo_dublin = $this->_registrar->registrarTipoDublin($this->getSql('Tid_IdTipoDublin'), $this->getSql('Idi_IdIdioma'));
            }

            $tema_dublin = $this->_registrar->getTemaDublin($this->getSql('Ted_IdTemaDublin'), Cookie::lenguaje());

            if (empty($tema_dublin)) 
            {
                $tema_dublin = $this->_registrar->registrarTemaDublin($this->getSql('Ted_IdTemaDublin'), $this->getSql('Idi_IdIdioma'));
            }

            $dublin = $this->_editar->actualizararDublinCore(
                    $this->getSql('Dub_Titulo'), $this->getSql('Dub_Descripcion'), $this->getSql('Dub_Editor'), $this->getSql('Dub_Colabrorador'), $this->getSql('Dub_FechaDocumento'), $formato[0], $this->getSql('Dub_Identificador'), $this->getSql('Dub_Fuente'), $this->getSql('Dub_Idioma'), $this->getSql('Dub_Relacion'), $this->getSql('Dub_Cobertura'), $this->getSql('Dub_Derechos'), $this->getSql('Dub_PalabraClave'), $tipo_dublin[0], 1, $tema_dublin[0], $this->filtrarInt($registros)
            );


            $dublin_autor = $this->_registrar->getDublinAutor($this->filtrarInt($registros), $autor[0]);

            if (empty($dublin_autor)) 
            {
                $dublin_autor = $this->_editar->actualizarDublinAutor($this->filtrarInt($registros), $autor[0]);
            }

            foreach ($paises as $paises) 
            {
                $paises = trim($paises);
                $pais = $this->_registrar->getPais($paises);

                if (!empty($pais)) 
                {
                    $this->_registrar->registrarDocumentosRelacionados($this->filtrarInt($registros), $pais[0]);

                    $this->_view->setJs(array('modal'));
                    $this->_view->assign('mensaje', 'Los Datos fueron actualizados correctamente');
                } 
                else 
                {
                    $this->_view->setJs(array('modal'));
                    $this->_view->assign('mensaje', 'Nombre de archivo existente en otro registro, verifique el nombre del archivo a registrar');
                }
            }
            




        }
        else
        {
            $this->_editar->editarTraduccion(
            $this->getSql('Dub_Titulo'),
            $this->getSql('Dub_Descripcion'),
            $this->getInt('Dub_PalabraClave'),
            $registros,
            $this->getSql('idiomaSelect')
            );
            $this->_view->assign('_mensaje', 'Edición Traducción Completado..!!');

        }
    }

    public function gestion_idiomas() 
    {
        $this->_view->setJs(array('dublincore',
            array(BASE_URL . 'modules/dublincore/views/registrar/js/dublincore.js')));
        $paises = $this->_editar->getPaises($this->getPostParam('idDublin'));
        $valor_paises = "";
        $i = 1;

        foreach ($paises as $pais) 
        {
            if ($i == 1) 
            {
                $valor_paises = $pais[0];
                $i++;
            } 
            else 
            {
                $valor_paises = $valor_paises . ', ' . $pais[0];
            }
        }

        $condicion1 = '';
        $Idi_IdIdioma = $this->getPostParam('idIdioma');

        $id = $this->getPostParam('idDublin');

        $condicion1 .= " WHERE dub.Dub_IdDublinCore = $id ";
        $datos = $this->_editar->getDublinTraducido($condicion1, $Idi_IdIdioma);

        $idestandar = $this->_registrar->getEstandarRecurso($this->filtrarInt(5));
        $this->_view->assign('ficha', $this->_registrar->getFichaLegislacion($idestandar[0][0], $Idi_IdIdioma));
        $this->_view->assign('idiomas', $this->_registrar->getIdiomas());
        $this->_view->assign('autores', $this->_registrar->getAutores());
        $this->_view->assign('palabraclave', $this->_registrar->getPalabrasClaves($Idi_IdIdioma));
        $this->_view->assign('tipodublin', $this->_registrar->getTiposDublin($Idi_IdIdioma));
        $this->_view->assign('temadublin', $this->_registrar->getTemasDublin($Idi_IdIdioma));
        $this->_view->assign('paises', $valor_paises);
        $this->_view->assign('formatos_archivos', $this->_registrar->getFormatoArchivo());

        if ($datos["Idi_IdIdioma"] == $Idi_IdIdioma) 
        {
            $this->_view->assign('datos', $datos);
        } 
        else 
        {
            $datos["Dub_Titulo"] = "";
            $datos["Dub_Descripcion"] = "";
            $datos["Dub_PalabraClave"] = "";
            $datos["Idi_IdIdioma"] = $Idi_IdIdioma;
            $this->_view->assign('datos', $datos);
        }

        $this->_view->assign('IdiomaOriginal', $this->getPostParam('idIdiomaOriginal'));

        $this->_view->renderizar('ajax/gestion_idiomas', false, true);
    }
}
