<?php

class mapaModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function insertarCapaWms(
    $iTic_IdTipoCapa, $iCap_UrlBase, $iCap_UrlCapa, $iCap_Fuente, $iCap_Nombre, $iCap_Titulo, $iCap_PalabrasClaves2, $iCap_Resumen, $iCap_Descripcion, $iCap_Creditos, $iCap_Leyenda, $iCap_imagenprev, $iCap_IdentificadorFichero1, $iCap_Idioma1, $iCap_FechaCreacion1, $iCap_NormaMetadatos1, $iCap_VersionNormaMetadatos1, $iCap_NombreIndividualdeContacto1, $iCap_NombredelaOrganizaciondeContacto1, $iCap_CorreodelContacto1, $iCap_RoldelContacto1, $iCap_TituloMencion2, $iCap_FechaMencion2, $iCap_TipoFechaMencion2, $iCap_FormaPresentacionMencion2, $iCap_Resumen2, $iCap_Proposito2, $iCap_Estado2, $iCap_NombreIndividualPuntoContacto2, $iCap_NombreOrganizacionPuntoContacto2, $iCap_CorreoElectronicoPuntoContacto2, $iCap_RolPuntodeContacto2, $iCap_NombreFicherodeVistadelGrafico2, $iCap_DescripcionFicherodeVistadelGrafico2, $iCap_TipoFicherodeVistadelGrafico2, $iCap_PalabraClaveDescripcionPC2, $iCap_TipoDescripcionPC2, $iCap_TipodeRepresentacionEspacial2, $iCap_ResolucionEspacial2, $iCap_Idioma2, $iCap_CategoriadeTema2, $iCap_LimiteLongitudOeste2, $iCap_LimiteLongitudEste2, $iCap_LimiteLatitudSur2, $iCap_LimiteLatitudNorte2, $iCap_Extension2, $iCap_ValorMinimo2, $iCap_ValorMaximo2, $iCap_UnidadesdeMedida2, $iCap_LimitaciondeUso3, $iCap_ConstriccionesdeAcceso3, $iCap_ConstriccionesdeUso3, $iCap_ConstriccionesdeOtroTipo3, $iCap_Nivel4, $iCap_Declaracion4, $iCap_FrecuenciadeMantenimientoyActualizacion5, $iCap_FechaProximaActualizacion5, $iCap_NivelTopologia6, $iCap_TipoObjetoGeometrico6, $iCap_NumerodeDimensiones6, $iCap_NombredeDimension6, $iCap_TamañodeDimension6, $iCap_Resolucion6, $iCap_Codigo7, $iCap_CodigoSitio7, $iCap_Nombre8, $iCap_Version8, $iCap_Enlace8, $iCap_Protocolo8, $iCap_NombreOpcionesTransferencia8, $iCap_Descripcion8, $iCap_Estado, $iIdi_IdIdioma, $iRec_IdRecurso
    ) {

        try {
            $id_registro;
            $sql = "call s_i_capa(?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?)";
            if (empty($iTic_IdTipoCapa)) {
                $iTic_IdTipoCapa = null;
            }

            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTic_IdTipoCapa, PDO::PARAM_NULL | PDO::PARAM_INT);
            $result->bindParam(2, $iCap_UrlBase, PDO::PARAM_STR);
            $result->bindParam(3, $iCap_UrlCapa, PDO::PARAM_STR);
            $result->bindParam(4, $iCap_Fuente, PDO::PARAM_STR);
            $result->bindParam(5, $iCap_Nombre, PDO::PARAM_STR);
            $result->bindParam(6, $iCap_Titulo, PDO::PARAM_STR);
            $result->bindParam(7, $iCap_PalabrasClaves2, PDO::PARAM_STR);
            $result->bindParam(8, $iCap_Resumen, PDO::PARAM_STR);
            $result->bindParam(9, $iCap_Descripcion, PDO::PARAM_STR);
            $result->bindParam(10, $iCap_Creditos, PDO::PARAM_STR);
            $result->bindParam(11, $iCap_Leyenda, PDO::PARAM_STR);
            $result->bindParam(12, $iCap_imagenprev, PDO::PARAM_STR);
            $result->bindParam(13, $iCap_IdentificadorFichero1, PDO::PARAM_STR);
            $result->bindParam(14, $iCap_Idioma1, PDO::PARAM_STR);
            $result->bindParam(15, $iCap_FechaCreacion1, PDO::PARAM_STR);
            $result->bindParam(16, $iCap_NormaMetadatos1, PDO::PARAM_STR);
            $result->bindParam(17, $iCap_VersionNormaMetadatos1, PDO::PARAM_STR);
            $result->bindParam(18, $iCap_NombreIndividualdeContacto1, PDO::PARAM_STR);
            $result->bindParam(19, $iCap_NombredelaOrganizaciondeContacto1, PDO::PARAM_STR);
            $result->bindParam(20, $iCap_CorreodelContacto1, PDO::PARAM_STR);
            $result->bindParam(21, $iCap_RoldelContacto1, PDO::PARAM_STR);
            $result->bindParam(22, $iCap_TituloMencion2, PDO::PARAM_STR);
            $result->bindParam(23, $iCap_FechaMencion2, PDO::PARAM_STR);
            $result->bindParam(24, $iCap_TipoFechaMencion2, PDO::PARAM_STR);
            $result->bindParam(25, $iCap_FormaPresentacionMencion2, PDO::PARAM_STR);
            $result->bindParam(26, $iCap_Resumen2, PDO::PARAM_STR);
            $result->bindParam(27, $iCap_Proposito2, PDO::PARAM_STR);
            $result->bindParam(28, $iCap_Estado2, PDO::PARAM_STR);
            $result->bindParam(29, $iCap_NombreIndividualPuntoContacto2, PDO::PARAM_STR);
            $result->bindParam(30, $iCap_NombreOrganizacionPuntoContacto2, PDO::PARAM_STR);
            $result->bindParam(31, $iCap_CorreoElectronicoPuntoContacto2, PDO::PARAM_STR);
            $result->bindParam(32, $iCap_RolPuntodeContacto2, PDO::PARAM_STR);
            $result->bindParam(33, $iCap_NombreFicherodeVistadelGrafico2, PDO::PARAM_STR);
            $result->bindParam(34, $iCap_DescripcionFicherodeVistadelGrafico2, PDO::PARAM_STR);
            $result->bindParam(35, $iCap_TipoFicherodeVistadelGrafico2, PDO::PARAM_STR);
            $result->bindParam(36, $iCap_PalabraClaveDescripcionPC2, PDO::PARAM_STR);
            $result->bindParam(37, $iCap_TipoDescripcionPC2, PDO::PARAM_STR);
            $result->bindParam(38, $iCap_TipodeRepresentacionEspacial2, PDO::PARAM_STR);
            $result->bindParam(39, $iCap_ResolucionEspacial2, PDO::PARAM_STR);
            $result->bindParam(40, $iCap_Idioma2, PDO::PARAM_STR);
            $result->bindParam(41, $iCap_CategoriadeTema2, PDO::PARAM_STR);
            $result->bindParam(42, $iCap_LimiteLongitudOeste2, PDO::PARAM_STR);
            $result->bindParam(43, $iCap_LimiteLongitudEste2, PDO::PARAM_STR);
            $result->bindParam(44, $iCap_LimiteLatitudSur2, PDO::PARAM_STR);
            $result->bindParam(45, $iCap_LimiteLatitudNorte2, PDO::PARAM_STR);
            $result->bindParam(46, $iCap_Extension2, PDO::PARAM_STR);
            $result->bindParam(47, $iCap_ValorMinimo2, PDO::PARAM_STR);
            $result->bindParam(48, $iCap_ValorMaximo2, PDO::PARAM_STR);
            $result->bindParam(49, $iCap_UnidadesdeMedida2, PDO::PARAM_STR);
            $result->bindParam(50, $iCap_LimitaciondeUso3, PDO::PARAM_STR);
            $result->bindParam(51, $iCap_ConstriccionesdeAcceso3, PDO::PARAM_STR);
            $result->bindParam(52, $iCap_ConstriccionesdeUso3, PDO::PARAM_STR);
            $result->bindParam(53, $iCap_ConstriccionesdeOtroTipo3, PDO::PARAM_STR);
            $result->bindParam(54, $iCap_Nivel4, PDO::PARAM_STR);
            $result->bindParam(55, $iCap_Declaracion4, PDO::PARAM_STR);
            $result->bindParam(56, $iCap_FrecuenciadeMantenimientoyActualizacion5, PDO::PARAM_STR);
            $result->bindParam(57, $iCap_FechaProximaActualizacion5, PDO::PARAM_STR);
            $result->bindParam(58, $iCap_NivelTopologia6, PDO::PARAM_STR);
            $result->bindParam(59, $iCap_TipoObjetoGeometrico6, PDO::PARAM_STR);
            $result->bindParam(60, $iCap_NumerodeDimensiones6, PDO::PARAM_STR);
            $result->bindParam(61, $iCap_NombredeDimension6, PDO::PARAM_STR);
            $result->bindParam(62, $iCap_TamañodeDimension6, PDO::PARAM_STR);
            $result->bindParam(63, $iCap_Resolucion6, PDO::PARAM_STR);
            $result->bindParam(64, $iCap_Codigo7, PDO::PARAM_STR);
            $result->bindParam(65, $iCap_CodigoSitio7, PDO::PARAM_STR);
            $result->bindParam(66, $iCap_Nombre8, PDO::PARAM_STR);
            $result->bindParam(67, $iCap_Version8, PDO::PARAM_STR);
            $result->bindParam(68, $iCap_Enlace8, PDO::PARAM_STR);
            $result->bindParam(69, $iCap_Protocolo8, PDO::PARAM_STR);
            $result->bindParam(70, $iCap_NombreOpcionesTransferencia8, PDO::PARAM_STR);
            $result->bindParam(71, $iCap_Descripcion8, PDO::PARAM_STR);
            $result->bindParam(72, $iCap_Estado, PDO::PARAM_STR);
            $result->bindParam(73, $iIdi_IdIdioma, PDO::PARAM_STR);
            $result->bindParam(74, $iRec_IdRecurso, PDO::PARAM_INT);
            $result->execute();

            return $result->fetch();
        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
    }

    public function actualizarCapa(
    $iCap_Idcapa, $iCap_UrlBase, $iCap_UrlCapa, $iCap_Fuente, $iCap_Nombre, $iCap_Titulo, $iCap_PalabrasClaves2, $iCap_Resumen, $iCap_Descripcion, $iCap_Creditos, $iCap_Leyenda, $iCap_imagenprev, $iCap_IdentificadorFichero1, $iCap_Idioma1, $iCap_FechaCreacion1, $iCap_NormaMetadatos1, $iCap_VersionNormaMetadatos1, $iCap_NombreIndividualdeContacto1, $iCap_NombredelaOrganizaciondeContacto1, $iCap_CorreodelContacto1, $iCap_RoldelContacto1, $iCap_TituloMencion2, $iCap_FechaMencion2, $iCap_TipoFechaMencion2, $iCap_FormaPresentacionMencion2, $iCap_Resumen2, $iCap_Proposito2, $iCap_Estado2, $iCap_NombreIndividualPuntoContacto2, $iCap_NombreOrganizacionPuntoContacto2, $iCap_CorreoElectronicoPuntoContacto2, $iCap_RolPuntodeContacto2, $iCap_NombreFicherodeVistadelGrafico2, $iCap_DescripcionFicherodeVistadelGrafico2, $iCap_TipoFicherodeVistadelGrafico2, $iCap_PalabraClaveDescripcionPC2, $iCap_TipoDescripcionPC2, $iCap_TipodeRepresentacionEspacial2, $iCap_ResolucionEspacial2, $iCap_Idioma2, $iCap_CategoriadeTema2, $iCap_LimiteLongitudOeste2, $iCap_LimiteLongitudEste2, $iCap_LimiteLatitudSur2, $iCap_LimiteLatitudNorte2, $iCap_Extension2, $iCap_ValorMinimo2, $iCap_ValorMaximo2, $iCap_UnidadesdeMedida2, $iCap_LimitaciondeUso3, $iCap_ConstriccionesdeAcceso3, $iCap_ConstriccionesdeUso3, $iCap_ConstriccionesdeOtroTipo3, $iCap_Nivel4, $iCap_Declaracion4, $iCap_FrecuenciadeMantenimientoyActualizacion5, $iCap_FechaProximaActualizacion5, $iCap_NivelTopologia6, $iCap_TipoObjetoGeometrico6, $iCap_NumerodeDimensiones6, $iCap_NombredeDimension6, $iCap_TamañodeDimension6, $iCap_Resolucion6, $iCap_Codigo7, $iCap_CodigoSitio7, $iCap_Nombre8, $iCap_Version8, $iCap_Enlace8, $iCap_Protocolo8, $iCap_NombreOpcionesTransferencia8, $iCap_Descripcion8, $iCap_Estado, $iIdi_IdIdioma, $iRec_IdRecurso
    ) {

        try {
            $id_registro;
            $sql = "call s_u_capa(?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,?)";

            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCap_Idcapa, PDO::PARAM_INT);
            $result->bindParam(2, $iCap_UrlBase, PDO::PARAM_STR);
            $result->bindParam(3, $iCap_UrlCapa, PDO::PARAM_STR);
            $result->bindParam(4, $iCap_Fuente, PDO::PARAM_STR);
            $result->bindParam(5, $iCap_Nombre, PDO::PARAM_STR);
            $result->bindParam(6, $iCap_Titulo, PDO::PARAM_STR);
            $result->bindParam(7, $iCap_PalabrasClaves2, PDO::PARAM_STR);
            $result->bindParam(8, $iCap_Resumen, PDO::PARAM_STR);
            $result->bindParam(9, $iCap_Descripcion, PDO::PARAM_STR);
            $result->bindParam(10, $iCap_Creditos, PDO::PARAM_STR);
            $result->bindParam(11, $iCap_Leyenda, PDO::PARAM_STR);
            $result->bindParam(12, $iCap_imagenprev, PDO::PARAM_STR);
            $result->bindParam(13, $iCap_IdentificadorFichero1, PDO::PARAM_STR);
            $result->bindParam(14, $iCap_Idioma1, PDO::PARAM_STR);
            $result->bindParam(15, $iCap_FechaCreacion1, PDO::PARAM_STR);
            $result->bindParam(16, $iCap_NormaMetadatos1, PDO::PARAM_STR);
            $result->bindParam(17, $iCap_VersionNormaMetadatos1, PDO::PARAM_STR);
            $result->bindParam(18, $iCap_NombreIndividualdeContacto1, PDO::PARAM_STR);
            $result->bindParam(19, $iCap_NombredelaOrganizaciondeContacto1, PDO::PARAM_STR);
            $result->bindParam(20, $iCap_CorreodelContacto1, PDO::PARAM_STR);
            $result->bindParam(21, $iCap_RoldelContacto1, PDO::PARAM_STR);
            $result->bindParam(22, $iCap_TituloMencion2, PDO::PARAM_STR);
            $result->bindParam(23, $iCap_FechaMencion2, PDO::PARAM_STR);
            $result->bindParam(24, $iCap_TipoFechaMencion2, PDO::PARAM_STR);
            $result->bindParam(25, $iCap_FormaPresentacionMencion2, PDO::PARAM_STR);
            $result->bindParam(26, $iCap_Resumen2, PDO::PARAM_STR);
            $result->bindParam(27, $iCap_Proposito2, PDO::PARAM_STR);
            $result->bindParam(28, $iCap_Estado2, PDO::PARAM_STR);
            $result->bindParam(29, $iCap_NombreIndividualPuntoContacto2, PDO::PARAM_STR);
            $result->bindParam(30, $iCap_NombreOrganizacionPuntoContacto2, PDO::PARAM_STR);
            $result->bindParam(31, $iCap_CorreoElectronicoPuntoContacto2, PDO::PARAM_STR);
            $result->bindParam(32, $iCap_RolPuntodeContacto2, PDO::PARAM_STR);
            $result->bindParam(33, $iCap_NombreFicherodeVistadelGrafico2, PDO::PARAM_STR);
            $result->bindParam(34, $iCap_DescripcionFicherodeVistadelGrafico2, PDO::PARAM_STR);
            $result->bindParam(35, $iCap_TipoFicherodeVistadelGrafico2, PDO::PARAM_STR);
            $result->bindParam(36, $iCap_PalabraClaveDescripcionPC2, PDO::PARAM_STR);
            $result->bindParam(37, $iCap_TipoDescripcionPC2, PDO::PARAM_STR);
            $result->bindParam(38, $iCap_TipodeRepresentacionEspacial2, PDO::PARAM_STR);
            $result->bindParam(39, $iCap_ResolucionEspacial2, PDO::PARAM_STR);
            $result->bindParam(40, $iCap_Idioma2, PDO::PARAM_STR);
            $result->bindParam(41, $iCap_CategoriadeTema2, PDO::PARAM_STR);
            $result->bindParam(42, $iCap_LimiteLongitudOeste2, PDO::PARAM_STR);
            $result->bindParam(43, $iCap_LimiteLongitudEste2, PDO::PARAM_STR);
            $result->bindParam(44, $iCap_LimiteLatitudSur2, PDO::PARAM_STR);
            $result->bindParam(45, $iCap_LimiteLatitudNorte2, PDO::PARAM_STR);
            $result->bindParam(46, $iCap_Extension2, PDO::PARAM_STR);
            $result->bindParam(47, $iCap_ValorMinimo2, PDO::PARAM_STR);
            $result->bindParam(48, $iCap_ValorMaximo2, PDO::PARAM_STR);
            $result->bindParam(49, $iCap_UnidadesdeMedida2, PDO::PARAM_STR);
            $result->bindParam(50, $iCap_LimitaciondeUso3, PDO::PARAM_STR);
            $result->bindParam(51, $iCap_ConstriccionesdeAcceso3, PDO::PARAM_STR);
            $result->bindParam(52, $iCap_ConstriccionesdeUso3, PDO::PARAM_STR);
            $result->bindParam(53, $iCap_ConstriccionesdeOtroTipo3, PDO::PARAM_STR);
            $result->bindParam(54, $iCap_Nivel4, PDO::PARAM_STR);
            $result->bindParam(55, $iCap_Declaracion4, PDO::PARAM_STR);
            $result->bindParam(56, $iCap_FrecuenciadeMantenimientoyActualizacion5, PDO::PARAM_STR);
            $result->bindParam(57, $iCap_FechaProximaActualizacion5, PDO::PARAM_STR);
            $result->bindParam(58, $iCap_NivelTopologia6, PDO::PARAM_STR);
            $result->bindParam(59, $iCap_TipoObjetoGeometrico6, PDO::PARAM_STR);
            $result->bindParam(60, $iCap_NumerodeDimensiones6, PDO::PARAM_STR);
            $result->bindParam(61, $iCap_NombredeDimension6, PDO::PARAM_STR);
            $result->bindParam(62, $iCap_TamañodeDimension6, PDO::PARAM_STR);
            $result->bindParam(63, $iCap_Resolucion6, PDO::PARAM_STR);
            $result->bindParam(64, $iCap_Codigo7, PDO::PARAM_STR);
            $result->bindParam(65, $iCap_CodigoSitio7, PDO::PARAM_STR);
            $result->bindParam(66, $iCap_Nombre8, PDO::PARAM_STR);
            $result->bindParam(67, $iCap_Version8, PDO::PARAM_STR);
            $result->bindParam(68, $iCap_Enlace8, PDO::PARAM_STR);
            $result->bindParam(69, $iCap_Protocolo8, PDO::PARAM_STR);
            $result->bindParam(70, $iCap_NombreOpcionesTransferencia8, PDO::PARAM_STR);
            $result->bindParam(71, $iCap_Descripcion8, PDO::PARAM_STR);
            $result->bindParam(72, $iCap_Estado, PDO::PARAM_STR);
            $result->bindParam(73, $iIdi_IdIdioma, PDO::PARAM_STR);
            $result->bindParam(74, $iRec_IdRecurso, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount();
        } catch (PDOException $exception) {

            return $exception->getMessage();
        }
    }

    public function ListarCapaPor($urlbase, $nombre) {
        try {
            $sql = $this->_db->query(
                    "SELECT * FROM capas WHERE TRIM(cap_UrlBase)=TRIM('$urlbase') AND  TRIM(cap_Nombre)=TRIM('$nombre')");
            return $sql->fetchAll();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function obtnerCapaPor($iCap_IdCapa) {
        try {
            $sql = "call s_s_capa_idcapa(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCap_IdCapa, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function listarCapaWms($busqueda = "") {
        try {
            $busqueda = trim($busqueda);
            $sql = "call s_s_capa(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $busqueda, PDO::PARAM_STR);
            $result->execute();
            return $result->fetchAll();
        } catch (PDOException $exception) {
            $this->insertarBitacora("Ocurrio un error al momento de Litar las capas: Parametros: " . $busqueda, "MySql", Session::get('usuario'), $exception->getFile(), "listarCapaWms", $exception->getMessage(), 1);
            return $exception->getMessage();
        }
    }

    public function CapasCompletoXIdrecurso($idRecurso) {


        //consultar varibles
        $post = $this->_db->query(
                "SELECT c.Cap_Idcapa,c.Cap_Nombre,c.Cap_Titulo,c.Cap_Leyenda,c.Cap_UrlBase,c.Cap_UrlCapa,tc.tic_Nombre FROM capas c
INNER JOIN tipo_capa tc ON tc.tic_IdTipoCapa=c.tic_IdTipoCapa
WHERE c.Rec_IdRecurso = $idRecurso");

        return $post->fetchAll();
    }

    public function CapasCompletoXIdrecursoXMetadata($idRecurso) {


        //consultar varibles
        $post = $this->_db->query(
                "SELECT c.*,tc.tic_Nombre FROM capas c
INNER JOIN tipo_capa tc ON tc.tic_IdTipoCapa=c.tic_IdTipoCapa
WHERE c.Rec_IdRecurso = $idRecurso");

        return $post->fetchAll();
    }

    public function verficarUsoCapa($iCap_Idcapa) {

        try {
            $sql = "SELECT DISTINCT rec.Rec_idRecurso FROM recurso rec
            INNER JOIN capas cap ON cap.Rec_IdRecurso=rec.Rec_IdRecurso
            INNER JOIN eh_recurso ehr ON ehr.Rec_IdRecurso=rec.Rec_IdRecurso
            WHERE cap.Cap_Idcapa=?";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCap_Idcapa, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->insertarBitacora("Ocurrio un error al Eliminar Capa : Parametros: " . json_encode(array($iCap_Idcapa)), "MySql", Session::get('usuario'), $exception->getFile(), "VerficarUsoCapa", $exception->getMessage(), 1);
            return $exception->getMessage();
        }
    }

    public function actualizarEstadoCapa($iCap_IdCapa, $iCap_Estado) 
    {
        try 
        {
            $sql = "call s_u_estado_capa(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCap_IdCapa, PDO::PARAM_INT);
            $result->bindParam(2, $iCap_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function eliminarCapaCompleto($iCap_Idcapa) 
    {
        $result = $this->verficarUsoCapa($iCap_Idcapa);
       
        if (empty($result["Rec_idRecurso"])) 
        {
            try 
            {
                $sql = "call s_d_capa_completo_x_id(?)";
                $result = $this->_db->prepare($sql);
                $result->bindParam(1, $iCap_Idcapa, PDO::PARAM_INT);
                $result->execute();
                return $result->rowCount();
            } 
            catch (PDOException $exception) 
            {
                $this->insertarBitacora("Ocurrio un error al Eliminar Capa : Parametros: " . json_encode(array($iCap_Idcapa)), "MySql", Session::get('usuario'), $exception->getFile(), "eliminarCapaCompleto", $exception->getMessage(), 1);
                return $exception->getMessage();
            }
        }
        else
        {
            return "La capa esta siendo utilizada";
        }
    }

}

?>
