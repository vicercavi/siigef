<?php
class metadataModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getMetadata($condicion = '')
    {       
        try
        {
            $metadata = $this->_db->query("SELECT * FROM metadata m INNER JOIN recurso r 
                                            ON m.Rec_IdRecurso=r.Rec_IdRecurso  $condicion"
            );           
            return $metadata->fetchAll();            
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("monitoreo(rioModel)", "getRios", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }

    public function insertarMetadada(
        $iMet_Titulo, 
        $iMet_Nombre, 
        $iMet_Tabla, 
        $iMet_Proveedor, 
        $iMet_CadenaConexion, 
        $iMet_Descripcion, 
        $iMet_CampoVisible, 
        $iMet_TituloCabecera, $iMet_CampoSearch, $iMet_NroRegistro, $iMet_Clasificacion, 
        $iMet_SubClasificacion, $iMet_AmbitoAccion, $iMet_PoblacionObj, $iMet_EstadoActualizacion, 
        $iMet_ContactoResponsable, $iMet_FormatoVersion, $iMet_InfoRelacionada, $iMet_Metodologia, 
        $iMet_Georeferenciacion, $iMet_Restriccion, $iMet_RestriccionAcceso, $iMet_DerechoAutor, 
        $iMet_Nodo, $iMet_NombreInstitucion, $iMet_WebInstitucion, $iMet_DireccionInstitucion, 
        $iMet_TelefonoInstitucion, $iMet_TipoInstitucion, $iMet_NombreUnidadInformacion, 
        $iMet_WebUnidadInformacion, $iMet_DireccionUnidadInformacion, $iMet_TelefonoUnidadInformacion, 
        $iMet_Categoria, $iMet_SubCategoria, $iRec_IdRecurso, $iIdi_IdIdioma, $iMet_PalabrasClaves,
        $iMet_TipoAgregacionDatos, $iMet_Idioma, $iMet_UrlWebService            
    ) 
    {

        try {
            $id_registro;
            $sql = "call s_i_metadata(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iMet_Titulo, PDO::PARAM_STR);
            $result->bindParam(2, $iMet_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iMet_Tabla, PDO::PARAM_STR);
            $result->bindParam(4, $iMet_Proveedor, PDO::PARAM_STR);
            $result->bindParam(5, $iMet_CadenaConexion, PDO::PARAM_STR);
            $result->bindParam(6, $iMet_Descripcion, PDO::PARAM_STR);
            $result->bindParam(7, $iMet_CampoVisible, PDO::PARAM_STR);
            $result->bindParam(8, $iMet_TituloCabecera, PDO::PARAM_STR);
            $result->bindParam(9, $iMet_CampoSearch, PDO::PARAM_STR);
            $result->bindParam(10, $iMet_NroRegistro, PDO::PARAM_STR);
            $result->bindParam(11, $iMet_Clasificacion, PDO::PARAM_STR);
            $result->bindParam(12, $iMet_SubClasificacion, PDO::PARAM_STR);
            $result->bindParam(13, $iMet_AmbitoAccion, PDO::PARAM_STR);
            $result->bindParam(14, $iMet_PoblacionObj, PDO::PARAM_STR);
            $result->bindParam(15, $iMet_EstadoActualizacion, PDO::PARAM_STR);
            $result->bindParam(16, $iMet_ContactoResponsable, PDO::PARAM_STR);
            $result->bindParam(17, $iMet_FormatoVersion, PDO::PARAM_STR);
            $result->bindParam(18, $iMet_InfoRelacionada, PDO::PARAM_STR);
            $result->bindParam(19, $iMet_Metodologia, PDO::PARAM_STR);
            $result->bindParam(20, $iMet_Georeferenciacion, PDO::PARAM_STR);
            $result->bindParam(21, $iMet_Restriccion, PDO::PARAM_STR);
            $result->bindParam(22, $iMet_RestriccionAcceso, PDO::PARAM_STR);
            $result->bindParam(23, $iMet_DerechoAutor, PDO::PARAM_STR);
            $result->bindParam(24, $iMet_Nodo, PDO::PARAM_STR);
            $result->bindParam(25, $iMet_NombreInstitucion, PDO::PARAM_STR);
            $result->bindParam(26, $iMet_WebInstitucion, PDO::PARAM_STR);
            $result->bindParam(27, $iMet_DireccionInstitucion, PDO::PARAM_STR);
            $result->bindParam(28, $iMet_TelefonoInstitucion, PDO::PARAM_STR);
            $result->bindParam(29, $iMet_TipoInstitucion, PDO::PARAM_STR);
            $result->bindParam(30, $iMet_NombreUnidadInformacion, PDO::PARAM_STR);
            $result->bindParam(31, $iMet_WebUnidadInformacion, PDO::PARAM_STR);
            $result->bindParam(32, $iMet_DireccionUnidadInformacion, PDO::PARAM_STR);
            $result->bindParam(33, $iMet_TelefonoUnidadInformacion, PDO::PARAM_STR);
            $result->bindParam(34, $iMet_Categoria, PDO::PARAM_STR);
            $result->bindParam(35, $iMet_SubCategoria, PDO::PARAM_INT);
            $result->bindParam(36, $iRec_IdRecurso, PDO::PARAM_STR);
            $result->bindParam(37, $iIdi_IdIdioma, PDO::PARAM_STR);
            $result->bindParam(38, $iMet_PalabrasClaves, PDO::PARAM_STR);
            $result->bindParam(39, $iMet_TipoAgregacionDatos, PDO::PARAM_STR);
            $result->bindParam(40, $iMet_Idioma, PDO::PARAM_STR);
            $result->bindParam(41, $iMet_UrlWebService, PDO::PARAM_STR);
        
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function actualizarMetadada(
    $iMet_IdMetadata, 
            $iMet_Titulo, 
            $iMet_Nombre, 
            $iMet_Tabla, 
            $iMet_Proveedor, 
            $iMet_CadenaConexion, 
            $iMet_Descripcion,            
            $iMet_CampoVisible, 
            $iMet_TituloCabecera, 
            $iMet_CampoSearch, 
            $iMet_NroRegistro, 
            $iMet_Clasificacion, 
            $iMet_SubClasificacion, 
            $iMet_AmbitoAccion, 
            $iMet_PoblacionObj, 
            $iMet_EstadoActualizacion, 
            $iMet_ContactoResponsable, 
            $iMet_FormatoVersion, 
            $iMet_InfoRelacionada, 
            $iMet_Metodologia, 
            $iMet_Georeferenciacion, 
            $iMet_Restriccion, 
            $iMet_RestriccionAcceso, 
            $iMet_DerechoAutor, 
            $iMet_Nodo, 
            $iMet_NombreInstitucion, 
            $iMet_WebInstitucion, 
            $iMet_DireccionInstitucion, 
            $iMet_TelefonoInstitucion, 
            $iMet_TipoInstitucion, 
            $iMet_NombreUnidadInformacion, 
            $iMet_WebUnidadInformacion, 
            $iMet_DireccionUnidadInformacion, 
            $iMet_TelefonoUnidadInformacion, 
            $iMet_Categoria, 
            $iMet_SubCategoria,
            $iMet_PalabrasClaves,
            $iMet_TipoAgregacionDatos,
            $iMet_Idioma,
            $iMet_UrlWebService
    ) 
    {

        try 
        {
            $id_registro;
            $sql = "call s_u_metadata(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iMet_IdMetadata, PDO::PARAM_INT);
            $result->bindParam(2, $iMet_Titulo, PDO::PARAM_STR);
            $result->bindParam(3, $iMet_Nombre, PDO::PARAM_STR);
            $result->bindParam(4, $iMet_Tabla, PDO::PARAM_STR);
            $result->bindParam(5, $iMet_Proveedor, PDO::PARAM_STR);
            $result->bindParam(6, $iMet_CadenaConexion, PDO::PARAM_STR);
            $result->bindParam(7, $iMet_Descripcion, PDO::PARAM_STR);
            $result->bindParam(8, $iMet_CampoVisible, PDO::PARAM_STR);
            $result->bindParam(9, $iMet_TituloCabecera, PDO::PARAM_STR);
            $result->bindParam(10, $iMet_CampoSearch, PDO::PARAM_STR);
            $result->bindParam(11, $iMet_NroRegistro, PDO::PARAM_STR);
            $result->bindParam(12, $iMet_Clasificacion, PDO::PARAM_STR);
            $result->bindParam(13, $iMet_SubClasificacion, PDO::PARAM_STR);
            $result->bindParam(14, $iMet_AmbitoAccion, PDO::PARAM_STR);
            $result->bindParam(15, $iMet_PoblacionObj, PDO::PARAM_STR);
            $result->bindParam(16, $iMet_EstadoActualizacion, PDO::PARAM_STR);
            $result->bindParam(17, $iMet_ContactoResponsable, PDO::PARAM_STR);
            $result->bindParam(18, $iMet_FormatoVersion, PDO::PARAM_STR);
            $result->bindParam(19, $iMet_InfoRelacionada, PDO::PARAM_STR);
            $result->bindParam(20, $iMet_Metodologia, PDO::PARAM_STR);
            $result->bindParam(21, $iMet_Georeferenciacion, PDO::PARAM_STR);
            $result->bindParam(22, $iMet_Restriccion, PDO::PARAM_STR);
            $result->bindParam(23, $iMet_RestriccionAcceso, PDO::PARAM_STR);
            $result->bindParam(24, $iMet_DerechoAutor, PDO::PARAM_STR);
            $result->bindParam(25, $iMet_Nodo, PDO::PARAM_STR);
            $result->bindParam(26, $iMet_NombreInstitucion, PDO::PARAM_STR);
            $result->bindParam(27, $iMet_WebInstitucion, PDO::PARAM_STR);
            $result->bindParam(28, $iMet_DireccionInstitucion, PDO::PARAM_STR);
            $result->bindParam(29, $iMet_TelefonoInstitucion, PDO::PARAM_STR);
            $result->bindParam(30, $iMet_TipoInstitucion, PDO::PARAM_STR);
            $result->bindParam(31, $iMet_NombreUnidadInformacion, PDO::PARAM_STR);
            $result->bindParam(32, $iMet_WebUnidadInformacion, PDO::PARAM_STR);
            $result->bindParam(33, $iMet_DireccionUnidadInformacion, PDO::PARAM_STR);
            $result->bindParam(34, $iMet_TelefonoUnidadInformacion, PDO::PARAM_STR);
            $result->bindParam(35, $iMet_Categoria, PDO::PARAM_STR);
            $result->bindParam(36, $iMet_SubCategoria, PDO::PARAM_INT);
            $result->bindParam(37, $iMet_PalabrasClaves, PDO::PARAM_STR);
            $result->bindParam(38, $iMet_TipoAgregacionDatos, PDO::PARAM_STR);
            $result->bindParam(39, $iMet_Idioma, PDO::PARAM_STR);
            $result->bindParam(40, $iMet_UrlWebService, PDO::PARAM_STR);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }
}
?>