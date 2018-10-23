<?php

ini_set('memory_limit', '-1');

class registrarController extends pecariController {

    private $_pecari;

    public function __construct($lang, $url) {
        parent::__construct($lang, $url);
        $this->_pecari = $this->loadModel('registrar');
    }

    public function index($recurso = false) {
        $this->_acl->acceso("registro_desde_pecari");
        $this->validarUrlIdioma();
        $this->_view->getLenguaje("index_inicio");
        $this->_view->setJs(array('pecari'));
        $_SESSION['recurso'] = $this->filtrarInt($recurso);
        $idrecurso = $this->_pecari->getRecurso($this->filtrarInt($this->filtrarInt($recurso)));

        if ($this->getInt('registrar') == 1) {
            $tabla = $this->_pecari->getEstandar($idrecurso[0]);
            $estandar_recurso = $tabla[0]['Esr_NombreTabla'];
            $this->subir_documentos();
            switch ($estandar_recurso) {
                case 'monitoreo_calidad_agua':
                    $this->monitoreo_calidad_agua();
                    break;
                case 'matriz_legal':
                    $this->legislacion();
                    break;
                case 'dublincore':
                    $this->dublincore();
                    break;
                case 'darwin':
                    $this->darwincore();
                    break;
                case 'plinian':
                    $this->pliniancore();
                    break;
            }
        }
        $this->_view->assign('estandar', $idrecurso[0]);
        $this->_view->setJs(array('registrar'));
        $this->_view->assign('titulo', 'Cargar Datos');
        $this->_view->renderizar('index', 'registrar');
    }

    public function subir_documentos() {
        $carpetaDestino = "imagenes/";
        if ($_FILES["archivos"]["name"][0]) {
            for ($i = 0; $i < count($_FILES["archivos"]["name"]); $i++) {
                $origen = $_FILES["archivos"]["tmp_name"][$i];
                $destino = $carpetaDestino . $_FILES["archivos"]["name"][$i];
                $archivo = $this->_pecari->getArchivoFisico($_FILES["archivos"]["name"][$i]);
                if (!$archivo) {
                    $this->_pecari->registrarArchivoFisico($_FILES["archivos"]["name"][$i]);
                    @move_uploaded_file($origen, $destino);
                }
            }
        }
    }

    public function darwincore() {
        $xml = simplexml_load_file($this->getSql('Proveedor'));
        for ($i = 0; $i < count($xml); $i++) {
            $Dar_FechaActualizacion = $xml->Table[$i]->Dar_FechaActualizacion;
            $Dar_CodigoInstitucion = $xml->Table[$i]->Dar_CodigoInstitucion;
            $Dar_CodigoColeccion = $xml->Table[$i]->Dar_CodigoColeccion;
            $Dar_NumeroCatalogo = $xml->Table[$i]->Dar_NumeroCatalogo;
            $Dar_NombreCientifico = $xml->Table[$i]->Dar_NombreCientifico;
            $Dar_BaseRegistro = $xml->Table[$i]->Dar_BaseRegistro;
            $Dar_ReinoOrganismo = $xml->Table[$i]->Dar_ReinoOrganismo;
            $Dar_Division = $xml->Table[$i]->Dar_Division;
            $Dar_ClaseOrganismo = $xml->Table[$i]->Dar_ClaseOrganismo;
            $Dar_OrdenOrganismo = $xml->Table[$i]->Dar_OrdenOrganismo;
            $Dar_FamiliaOrganismo = $xml->Table[$i]->Dar_FamiliaOrganismo;
            $Dar_GeneroOrganismo = $xml->Table[$i]->Dar_GeneroOrganismo;
            $Dar_EspecieOrganismo = $xml->Table[$i]->Dar_EspecieOrganismo;
            $Dar_SubEspecieOrganismo = $xml->Table[$i]->Dar_SubEspecieOrganismo;
            $Dar_AutorNombreCientifico = $xml->Table[$i]->Dar_AutorNombreCientifico;
            $Dar_IdentificadoPor = $xml->Table[$i]->Dar_IdentificadoPor;
            $Dar_AnoIdentificacion = $xml->Table[$i]->Dar_AnoIdentificacion;
            $Dar_MesIdentificacion = $xml->Table[$i]->Dar_MesIdentificacion;
            $Dar_DiaIdentificacion = $xml->Table[$i]->Dar_DiaIdentificacion;
            $Dar_StatusTipo = $xml->Table[$i]->Dar_StatusTipo;
            $Dar_NumeroColector = $xml->Table[$i]->Dar_NumeroColector;
            $Dar_NumeroCampo = $xml->Table[$i]->Dar_NumeroCampo;
            $Dar_Colector = $xml->Table[$i]->Dar_Colector;
            $Dar_AnoColectado = $xml->Table[$i]->Dar_AnoColectado;
            $Dar_MesColectado = $xml->Table[$i]->Dar_MesColectado;
            $Dar_DiaColectado = $xml->Table[$i]->Dar_DiaColectado;
            $Dar_DiaOrdinario = $xml->Table[$i]->Dar_DiaOrdinario;
            $Dar_HoraColectado = $xml->Table[$i]->Dar_HoraColectado;
            $Dar_ContinenteOceano = $xml->Table[$i]->Dar_ContinenteOceano;
            $Dar_Pais = $xml->Table[$i]->Dar_Pais;
            $Dar_EstadoProvincia = $xml->Table[$i]->Dar_EstadoProvincia;
            $Dar_Municipio = $xml->Table[$i]->Dar_Municipio;
            $Dar_Localidad = $xml->Table[$i]->Dar_Localidad;
            $Dar_Longitud = $xml->Table[$i]->Dar_Longitud;
            $Dar_Latitud = $xml->Table[$i]->Dar_Latitud;
            $Dar_PrecisionDeCordenada = $xml->Table[$i]->Dar_PrecisionDeCordenada;
            $Dar_BoundingBox = $xml->Table[$i]->Dar_BoundingBox;
            $Dar_MinimaElevacion = $xml->Table[$i]->Dar_MinimaElevacion;
            $Dar_MaximaElevacion = $xml->Table[$i]->Dar_MaximaElevacion;
            $Dar_MinimaProfundidad = $xml->Table[$i]->Dar_MinimaProfundidad;
            $Dar_MaximaProfundidad = $xml->Table[$i]->Dar_MaximaProfundidad;
            $Dar_SexoOrganismo = $xml->Table[$i]->Dar_SexoOrganismo;
            $Dar_PreparacionTipo = $xml->Table[$i]->Dar_PreparacionTipo;
            $Dar_ConteoIndividuo = $xml->Table[$i]->Dar_ConteoIndividuo;
            $Dar_NumeroCatalogoAnterior = $xml->Table[$i]->Dar_NumeroCatalogoAnterior;
            $Dar_TipoRelacion = $xml->Table[$i]->Dar_TipoRelacion;
            $Dar_InformacionRelacionada = $xml->Table[$i]->Dar_InformacionRelacionada;
            $Dar_EstadoVida = $xml->Table[$i]->Dar_EstadoVida;
            $Dar_Nota = $xml->Table[$i]->Dar_Nota;
            $Dar_NombreComunOrganismo = $xml->Table[$i]->Dar_NombreComunOrganismo;

            if ($Dar_Longitud != '' and $Dar_Latitud != '' and ( $Dar_NombreCientifico != '' or ( $Dar_GeneroOrganismo and $Dar_EspecieOrganismo)) and is_numeric(str_replace(',', '.', $Dar_Longitud)) and is_numeric(str_replace(',', '.', $Dar_Latitud))) {

                $darwin = $this->_pecari->registrarDarwinCore(
                        $Dar_FechaActualizacion, $Dar_CodigoInstitucion, $Dar_CodigoColeccion, $Dar_NumeroCatalogo, $Dar_NombreCientifico, $Dar_BaseRegistro, $Dar_ReinoOrganismo, $Dar_Division, $Dar_ClaseOrganismo, $Dar_OrdenOrganismo, $Dar_FamiliaOrganismo, $Dar_GeneroOrganismo, $Dar_EspecieOrganismo, $Dar_SubEspecieOrganismo, $Dar_AutorNombreCientifico, $Dar_IdentificadoPor, $Dar_AnoIdentificacion, $Dar_MesIdentificacion, $Dar_DiaIdentificacion, $Dar_StatusTipo, $Dar_NumeroColector, $Dar_NumeroCampo, $Dar_Colector, $Dar_AnoColectado, $Dar_MesColectado, $Dar_DiaColectado, $Dar_DiaOrdinario, $Dar_HoraColectado, $Dar_ContinenteOceano, $Dar_Pais, $Dar_EstadoProvincia, $Dar_Municipio, $Dar_Localidad, str_replace(',', '.', $Dar_Longitud), str_replace(',', '.', $Dar_Latitud), $Dar_PrecisionDeCordenada, $Dar_BoundingBox, $Dar_MinimaElevacion, $Dar_MaximaElevacion, $Dar_MinimaProfundidad, $Dar_MaximaProfundidad, $Dar_SexoOrganismo, $Dar_PreparacionTipo, $Dar_ConteoIndividuo, $Dar_NumeroCatalogoAnterior, $Dar_TipoRelacion, $Dar_InformacionRelacionada, $Dar_EstadoVida, $Dar_Nota, $Dar_NombreComunOrganismo, $_SESSION['recurso']
                );
            } else {
                echo 'no registro nada';
            }
        }
    }

    public function pliniancore() {
        $xml = simplexml_load_file($this->getSql('Proveedor'));
        for ($i = 0; $i < count($xml); $i++) {
            $Pli_Idioma = $xml->Table[$i]->Pli_Idioma;
            $Pli_NombreCientifico = $xml->Table[$i]->Pli_NombreCientifico;
            $Pli_AcronimoInstitucion = $xml->Table[$i]->Pli_AcronimoInstitucion;
            $Pli_FechaUltimaModificacion = $xml->Table[$i]->Pli_FechaUltimaModificacion;
            $Pli_IdRegistroTaxon = $xml->Table[$i]->Pli_IdRegistroTaxon;
            $Pli_CitaSugerida = $xml->Table[$i]->Pli_CitaSugerida;
            $Pli_Distribucion = $xml->Table[$i]->Pli_Distribucion;
            $Pli_DescripcionGeneral = $xml->Table[$i]->Pli_DescripcionGeneral;
            $Pli_Reino = $xml->Table[$i]->Pli_Reino;
            $Pli_Phylum = $xml->Table[$i]->Pli_Phylum;
            $Pli_Clase = $xml->Table[$i]->Pli_Clase;
            $Pli_Orden = $xml->Table[$i]->Pli_Orden;
            $Pli_Familia = $xml->Table[$i]->Pli_Familia;
            $Pli_Genero = $xml->Table[$i]->Pli_Genero;
            $Pli_Sinonimia = $xml->Table[$i]->Pli_Sinonimia;
            $Pli_AutorFechaTaxon = $xml->Table[$i]->Pli_AutorFechaTaxon;
            $Pli_EspeciesReferenciasPublicacion = $xml->Table[$i]->Pli_EspeciesReferenciasPublicacion;
            $Pli_NombresComunes = $xml->Table[$i]->Pli_NombresComunes;
            $Pli_InformacionTipos = $xml->Table[$i]->Pli_InformacionTipos;
            $Pli_IdentificadorUnicoGlobal = $xml->Table[$i]->Pli_IdentificadorUnicoGlobal;
            $Pli_Colaboradores = $xml->Table[$i]->Pli_Colaboradores;
            $Pli_FechaCreacion = $xml->Table[$i]->Pli_FechaCreacion;
            $Pli_Habito = $xml->Table[$i]->Pli_Habito;
            $Pli_CicloVida = $xml->Table[$i]->Pli_CicloVida;
            $Pli_Reproduccion = $xml->Table[$i]->Pli_Reproduccion;
            $Pli_CicloAnual = $xml->Table[$i]->Pli_CicloAnual;
            $Pli_DescripcionCientifica = $xml->Table[$i]->Pli_DescripcionCientifica;
            $Pli_BreveDescripcion = $xml->Table[$i]->Pli_BreveDescripcion;
            $Pli_Alimentacion = $xml->Table[$i]->Pli_Alimentacion;
            $Pli_Comportamiento = $xml->Table[$i]->Pli_Comportamiento;
            $Pli_Interacciones = $xml->Table[$i]->Pli_Interacciones;
            $Pli_NumeroCromosomas = $xml->Table[$i]->Pli_NumeroCromosomas;
            $Pli_DatosMoleculares = $xml->Table[$i]->Pli_DatosMoleculares;
            $Pli_EstadoActPoblacion = $xml->Table[$i]->Pli_EstadoActPoblacion;
            $Pli_EstadoUICN = $xml->Table[$i]->Pli_EstadoUICN;
            $Pli_EstadoLegNacional = $xml->Table[$i]->Pli_EstadoLegNacional;
            $Pli_Habitat = $xml->Table[$i]->Pli_Habitat;
            $Pli_Territorialidad = $xml->Table[$i]->Pli_Territorialidad;
            $Pli_Endemismo = $xml->Table[$i]->Pli_Endemismo;
            $Pli_Usos = $xml->Table[$i]->Pli_Usos;
            $Pli_Manejo = $xml->Table[$i]->Pli_Manejo;
            $Pli_Folklore = $xml->Table[$i]->Pli_Folklore;
            $Pli_ReferenciasBibliograficas = $xml->Table[$i]->Pli_ReferenciasBibliograficas;
            $Pli_DocumentacionNoEstructurada = $xml->Table[$i]->Pli_DocumentacionNoEstructurada;
            $Pli_OtraFuenteInformacion = $xml->Table[$i]->Pli_OtraFuenteInformacion;
            $Pli_ArticuloCientifico = $xml->Table[$i]->Pli_ArticuloCientifico;
            $Pli_ClavesTaxonomicas = $xml->Table[$i]->Pli_ClavesTaxonomicas;
            $Pli_DatosMigrados = $xml->Table[$i]->Pli_DatosMigrados;
            $Pli_ImportanciaEcologica = $xml->Table[$i]->Pli_ImportanciaEcologica;
            $Pli_HistoriaNaturalNoEstructurada = $xml->Table[$i]->Pli_HistoriaNaturalNoEstructurada;
            $Pli_DatosInvasividad = $xml->Table[$i]->Pli_DatosInvasividad;
            $Pli_PublicoObjetivo = $xml->Table[$i]->Pli_PublicoObjetivo;
            $Pli_Version = $xml->Table[$i]->Pli_Version;
            $Pli_URLImagen1 = $xml->Table[$i]->Pli_URLImagen1;
            $Pli_PieImagen1 = $xml->Table[$i]->Pli_PieImagen1;
            $Pli_URLImagen2 = $xml->Table[$i]->Pli_URLImagen2;
            $Pli_PieImagen2 = $xml->Table[$i]->Pli_PieImagen2;
            $Pli_URLImagen3 = $xml->Table[$i]->Pli_URLImagen3;
            $Pli_PieImagen3 = $xml->Table[$i]->Pli_PieImagen3;
            $Pli_Imagen = $xml->Table[$i]->Pli_Imagen;
            if ($Pli_AcronimoInstitucion != '' and $Pli_NombreCientifico != '' and $Pli_FechaUltimaModificacion != '') {

                $plinian = $this->_pecari->registrarPlinianCore(
                        $Pli_Idioma, $Pli_NombreCientifico, $Pli_AcronimoInstitucion, $Pli_FechaUltimaModificacion, $Pli_IdRegistroTaxon, $Pli_CitaSugerida, $Pli_Distribucion, $Pli_DescripcionGeneral, $Pli_Reino, $Pli_Phylum, $Pli_Clase, $Pli_Orden, $Pli_Familia, $Pli_Genero, $Pli_Sinonimia, $Pli_AutorFechaTaxon, $Pli_EspeciesReferenciasPublicacion, $Pli_NombresComunes, $Pli_InformacionTipos, $Pli_IdentificadorUnicoGlobal, $Pli_Colaboradores, $Pli_FechaCreacion, $Pli_Habito, $Pli_CicloVida, $Pli_Reproduccion, $Pli_CicloAnual, $Pli_DescripcionCientifica, $Pli_BreveDescripcion, $Pli_Alimentacion, $Pli_Comportamiento, $Pli_Interacciones, $Pli_NumeroCromosomas, $Pli_DatosMoleculares, $Pli_EstadoActPoblacion, $Pli_EstadoUICN, $Pli_EstadoLegNacional, $Pli_Habitat, $Pli_Territorialidad, $Pli_Endemismo, $Pli_Usos, $Pli_Manejo, $Pli_Folklore, $Pli_ReferenciasBibliograficas, $Pli_DocumentacionNoEstructurada, $Pli_OtraFuenteInformacion, $Pli_ArticuloCientifico, $Pli_ClavesTaxonomicas, $Pli_DatosMigrados, $Pli_ImportanciaEcologica, $Pli_HistoriaNaturalNoEstructurada, $Pli_DatosInvasividad, $Pli_PublicoObjetivo, $Pli_Version, $Pli_URLImagen1, $Pli_PieImagen1, $Pli_URLImagen2, $Pli_PieImagen2, $Pli_URLImagen3, $Pli_PieImagen3, $Pli_Imagen, $_SESSION['recurso']
                );
            }
        }
    }

    public function legislacion() {

        $xml = simplexml_load_file($this->getSql('Proveedor'));
        for ($i = 0; $i < count($xml); $i++) {
            $Mal_FechaPublicacion = $xml->Table[$i]->Mal_FechaPublicacion;
            $Mal_Entidad = $xml->Table[$i]->Mal_Entidad;
            $Mal_NumeroNormas = $xml->Table[$i]->Mal_NumeroNormas;
            $Mal_Titulo = $xml->Table[$i]->Mal_Titulo;
            $Mal_ArticuloAplicable = $xml->Table[$i]->Mal_ArticuloAplicable;
            $Mal_ResumenLegislacion = $xml->Table[$i]->Mal_ResumenLegislacion;
            $Mal_FechaRevision = $xml->Table[$i]->Mal_FechaRevision;
            $Mal_NormasComplemaentarias = $xml->Table[$i]->Mal_NormasComplemaentarias;
            $Mal_TipoLegislacion = $xml->Table[$i]->Mal_TipoLegislacion;
            $Mal_PalabraClave = $xml->Table[$i]->Mal_PalabraClave;
            $Pai_IdPais = $xml->Table[$i]->Pai_IdPais;
            $Nivel_Legal = $xml->Table[$i]->Nivel_Legal;
            $Snl_IdSubNivelLegal = $xml->Table[$i]->Snl_IdSubNivelLegal;
            $Tel_IdTemaLegal = $xml->Table[$i]->Tel_IdTemaLegal;


            if (!empty($pais) and ! empty($Nivel_Legal) and ! empty($Snl_IdSubNivelLegal) and ! empty($Tel_IdTemaLegal)) {

                $nivellegal = $this->_pecari->getNivelLegal($Nivel_Legal);
                if (empty($nivellegal)) {
                    $nivellegal = $this->_pecari->registrarNivelLegal(ucwords($Nivel_Legal));
                }
                $subnivellegal = $this->_pecari->getSubNivelLegal($nivellegal[0], $Snl_IdSubNivelLegal);
                if (empty($subnivellegal)) {
                    $subnivellegal = $this->_pecari->registrarSubNivelLegal(ucwords($Snl_IdSubNivelLegal), $nivellegal[0]);
                }
                $temanivellegal = $this->_pecari->getTemaLegal($subnivellegal[0], $Tel_IdTemaLegal);
                if (empty($temanivellegal)) {
                    $temanivellegal = $this->_pecari->registrarTemaLegal(ucwords($Tel_IdTemaLegal), $subnivellegal[0]);
                }
                if ($Mal_TipoLegislacion == '' or $Mal_PalabraClave == '') {
                    $Mal_PalabraClave = 'Otros';
                }
                if (!$this->_pecari->verificarTitulo($Mal_FechaPublicacion, $Mal_Entidad, $Mal_NumeroNormas, $Mal_Titulo, $Mal_ArticuloAplicable, $Mal_ResumenLegislacion, $Mal_FechaRevision, $Mal_NormasComplemaentarias, $Mal_TipoLegislacion, $temanivellegal[0], $pais[0], 'es', $_SESSION['recurso'], $Mal_PalabraClave)) {
                    $legislacion = $this->_pecari->registrarLegislacion(
                            $Mal_FechaPublicacion, ucwords($Mal_Entidad), $Mal_NumeroNormas, $Mal_Titulo, $Mal_ArticuloAplicable, $Mal_ResumenLegislacion, $Mal_FechaRevision, $Mal_NormasComplemaentarias, ucwords($Mal_TipoLegislacion), $temanivellegal[0], $pais[0], $_SESSION['recurso'], ucwords($Mal_PalabraClave), 'es');
                }
            }
        }
    }

    public function monitoreo_calidad_agua() {

        $xml = simplexml_load_file($this->getSql('Proveedor'));
        for ($i = 0; $i < count($xml); $i++) {
            $Mca_Valor = $xml->Table[$i]->Mca_Valor;
            $Mca_Fecha = $xml->Table[$i]->Mca_Fecha;
            $Var_Abreviatura = $xml->Table[$i]->Var_Abreviatura;
            $Var_Medida = $xml->Table[$i]->Var_Medida;
            $Var_Nombre = $xml->Table[$i]->Var_Nombre;
            $Esm_Nombre = $xml->Table[$i]->Esm_Nombre;
            $Esm_Referencia = $xml->Table[$i]->Esm_Referencia;
            $Esm_Altitud = $xml->Table[$i]->Esm_Altitud;
            $Esm_Longitud = $xml->Table[$i]->Esm_Longitud;
            $Esm_Latitud = $xml->Table[$i]->Esm_Latitud;
            $Ent_Nombre = $xml->Table[$i]->Ent_Nombre;
            $Ent_Siglas = $xml->Table[$i]->Ent_Siglas;
            $Rio_Nombre = $xml->Table[$i]->Rio_Nombre;
            $Cue_Nombre = $xml->Table[$i]->Cue_Nombre;
            $Suc_Nombre = $xml->Table[$i]->Suc_Nombre;
            $Pai_Nombre = $xml->Table[$i]->Pai_Nombre;
            $Esd_Nombre = $xml->Table[$i]->Esd_Nombre;
            $Mpd_Nombre = $xml->Table[$i]->Mpd_Nombre;
            $pais = $this->_excel->getPais($Pai_Nombre);

            if (!empty($pais) and ! empty($Var_Nombre) and ( $Esm_Longitud != '') and ( $Esm_Latitud != '') and ! empty($Cue_Nombre) and ! empty($Suc_Nombre) and ! empty($Rio_Nombre) and is_numeric($Esm_Longitud) and is_numeric($Esm_Latitud)) {

                $cuenca = $this->_pecari->getCuenca($Cue_Nombre);
                if (empty($cuenca)) {
                    $cuenca = $this->_pecari->registrarCuenca(ucwords($Cue_Nombre));
                }
                $subcuenca = $this->_pecari->getSubCuenca($cuenca[0], $Suc_Nombre);
                if (empty($subcuenca)) {
                    $subcuenca = $this->_pecari->registrarSucCuenca(ucwords($Suc_Nombre), $cuenca[0]);
                }

                $rio = $this->_pecari->getRio($pais[0], $Rio_Nombre);
                if (empty($rio)) {
                    $rio = $this->_pecari->registrarRio(ucwords($Suc_Nombre), $pais[0]);
                }
                $riocuenca = $this->_pecari->getRioCuenca($cuenca[0], $subcuenca[0], $rio[0]);

                if (empty($riocuenca)) {
                    $riocuenca = $this->_pecari->registrarRioCuenca($cuenca[0], $subcuenca[0], $rio[0]);
                }
                $estacion = $this->_pecari->getEstacionMonitoreo($Esm_Latitud, $Esm_Longitud);
                if (empty($estacion) and is_numeric($Esm_Latitud) and is_numeric($Esm_Longitud)) {
                    $estacion = $this->_pecari->registrarEstacionMonitoreo($Esm_Nombre, str_replace(',', '.', $Esm_Longitud), str_replace(',', '.', $Esm_Latitud), $Esm_Referencia, $Esm_Altitud, $riocuenca[0]);
                }
                $entidad = $this->_pecari->getEntidad($Ent_Nombre);
                if (empty($entidad)) {
                    $entidad = $this->_pecari->registrarEntidad($Ent_Nombre, $Ent_Siglas);
                }



                $variable = $this->_pecari->getVariable($Var_Nombre);
                if (empty($variable)) {
                    $variable = $this->_pecari->registrarVariables($Var_Nombre, $Var_Abreviatura, $Var_Medida);
                }
                if (!$this->_pecari->verificarMonitoreoCalidadAgua($Mca_Valor, $Mca_Fecha, $variable[0], $entidad[0], $estacion[0], $pais[0], $_SESSION['recurso'])) {
                    $this->_pecari->registrarMonitoreoCalidadAgua($Mca_Valor, $Mca_Fecha, $variable[0], $estacion[0], $pais[0], $_SESSION['recurso'], $entidad[0]);
                    $total_registrado++;
                }
            }
        }
    }

    public function dublincore() {


        $xml = simplexml_load_file($this->getSql('Proveedor'));
        for ($i = 0; $i < count($xml); $i++) {
            $Dub_Editor = $xml->Table[$i]->Dub_Editor;
            $Dub_Colaborador = $xml->Table[$i]->Dub_Colaborador;
            $Dub_FechaDocumento = $xml->Table[$i]->Dub_FechaDocumento;
            $Dub_Formato = $xml->Table[$i]->Dub_Formato;
            $Dub_Identificador = $xml->Table[$i]->Dub_Identificador;
            $Dub_Fuente = $xml->Table[$i]->Dub_Fuente;
            $Dub_Idioma = $xml->Table[$i]->Dub_Idioma;
            $Dub_Relacion = $xml->Table[$i]->Dub_Relacion;
            $Dub_Cobertura = $xml->Table[$i]->Dub_Cobertura;
            $Dub_Derechos = $xml->Table[$i]->Dub_Derechos;
            $Aut_Profesion = $xml->Table[$i]->Aut_Profesion;
            $Aut_Email = $xml->Table[$i]->Aut_Email;
            $Tid_Descripcion = $xml->Table[$i]->Tid_Descripcion;
            $Ted_Descripcion = $xml->Table[$i]->Ted_Descripcion;
            $Dub_Titulo = $xml->Table[$i]->Dub_Titulo;
            $Pai_Nombre = $xml->Table[$i]->Pai_Nombre;
            $Aut_Nombre = $xml->Table[$i]->Aut_Nombre;
            $Dub_PalabraClave = $xml->Table[$i]->Dub_PalabraClave;
            $Arf_IdArchivoFisico = $xml->Table[$i]->Arf_IdArchivoFisico;
            $Arf_URL = $xml->Table[$i]->Arf_URL;


            if ($Dub_Titulo != '' and ( $Arf_IdArchivoFisico != '' or $Arf_URL != '') and $Pai_Nombre != '' and $Aut_Nombre != '') {



                $formato = $this->_pecari->getFormatoArchivo($Dub_Formato);
                if (empty($formato)) {
                    $formato = $this->_pecari->registrarFormatoArchivo(ucwords($Dub_Formato));
                }
                $autor = $this->_pecari->getAutor($Aut_Nombre);
                if (empty($autor)) {
                    $autor = $this->_pecari->registrarAutor(ucwords($Aut_Nombre));
                }
                $tipodublin = $this->_pecari->getTipoDublin($Tid_Descripcion);
                if (empty($tipodublin)) {
                    $tipodublin = $this->_pecari->registrarTipoDublin(ucwords($Tid_Descripcion));
                }
                $nombrearchivo = $this->_pecari->getArchivoFisico($Arf_IdArchivoFisico);
                $temadublin = $this->_pecari->getTemaDublin($Ted_Descripcion);
                if (empty($temadublin)) {
                    $temadublin = $this->_pecari->registrarTemaDublin(ucwords($Ted_Descripcion));
                }

                if (!empty($nombrearchivo)) {

                    $this->_excel->actualizarArchivoFisico($formato[0], $nombrearchivo[0], $Arf_URL);
                } else {
                    $url = $this->_excel->registrarUrlArchivoFisico($Arf_URL, $formato[0]);
                }

                $url = $this->_excel->getArchivoFisicoURL($Arf_URL);

                if (!empty($url)) {

                    $this->_pecari->actualizarArchivoFisico($formato[0], $nombrearchivo[0]);
                    $dublin = $this->_pecari->getDublinCore($Dub_Titulo, $tipodublin[0]);

                    if (empty($dublin)) {
                        $dublin = $this->_pecari->registrarDublinCore($Dub_Titulo, $Dub_Descripcion, $Dub_Editor, $Dub_Colaborador, $Dub_FechaDocumento, $formato[0], $Dub_Identificador, $Dub_Fuente, $Dub_Idioma, $Dub_Relacion, $Dub_Cobertura, $Dub_Derechos, $Dub_PalabraClave, $tipodublin[0], $_SESSION['recurso'], 'es', $url[0], $temadublin[0]);



                        if ($dublin) {
                            $dublinautor = $this->_pecari->registrarDublinAutor($dublin[0], $autor[0]);
                            $Pai_Nombre = explode(",", $Pai_Nombre);

                            foreach ($Pai_Nombre as $Pai_Nombre) {
                                $Pai_Nombres = trim($Pai_Nombre);
                                $pais = $this->_pecari->getPais($Pai_Nombres);
                                if (isset($dublin) and isset($pais)) {
                                    $documentorelacionado = $this->_pecari->registrarDocumentosRelacionados($dublin[0], $pais[0]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

}

?>
