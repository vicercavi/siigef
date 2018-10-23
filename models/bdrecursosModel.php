<?php

class bdrecursosModel extends Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getRecursos($tipo = "", $nombre = "", $estandar = 0, $fuente = "", $origen = "", $herramienta = 0) 
    {
        $where = " WHERE Rec_Nombre LIKE '%" . ((empty($nombre)) ? "" : $nombre) . "%' ";


        if (!empty($estandar)) 
        {
            $where = $where . " and rec.Esr_IdEstandarRecurso=$estandar ";
        }

        if (!empty($fuente)) 
        {
            $where = $where . " and rec.Rec_Fuente LIKE '%$fuente%'";
        }

        if (!empty($origen)) 
        {
            $where = $where . " and Rec_Origen LIKE '%$origen%' ";
        }

        if (!empty($tipo)) 
        {
            $where = $where . " and tir.Tir_Nombre='$tipo' ";
        }
        if (!empty($herramienta)) 
        {
            $where = $where . " and EXISTS(SELECT esh.Her_IdHerramientaSii FROM eh_recurso ehr
                INNER JOIN estructura_herramienta esh ON esh.Esh_IdEstructuraHerramienta=ehr.Esh_IdEstructuraHerramienta 
                 WHERE esh.Her_IdHerramientaSii=$herramienta AND ehr.Rec_IdRecurso=rec.Rec_IdRecurso)=TRUE ";
        }

        $post = $this->_db->query("SELECT rec.*, tir.Tir_Nombre,est.Esr_Nombre FROM recurso rec
                INNER JOIN tipo_recurso tir ON rec.Tir_IdTipoRecurso = tir.Tir_IdTipoRecurso              
                INNER JOIN estandar_recurso est ON rec.Esr_IdEstandarRecurso = est.Esr_IdEstandarRecurso
                $where ORDER BY rec.Rec_Nombre");

        return $post->fetchAll();
    }

    public function getRecursosXHerramienta($herramienta, $busqueda = "") 
    {
        $busqueda = trim($busqueda);
        $post = $this->_db->query("SELECT DISTINCT rec.Rec_IdRecurso, rec.*, tir.Tir_Nombre,est.Esr_Nombre                       FROM recurso rec
                                   INNER JOIN tipo_recurso tir ON 
                                   rec.Tir_IdTipoRecurso = tir.Tir_IdTipoRecurso
                                   INNER JOIN estandar_recurso est ON
                                    rec.Esr_IdEstandarRecurso = est.Esr_IdEstandarRecurso 
                                   WHERE EXISTS(SELECT DISTINCT ehr.Rec_IdRecurso FROM eh_recurso ehr 
                                   INNER JOIN estructura_herramienta esh ON 
                                   esh.Esh_IdEstructuraHerramienta=ehr.Esh_IdEstructuraHerramienta 
                                   WHERE esh.Her_IdHerramientaSii=$herramienta AND  
                                   ehr.Rec_IdRecurso=rec.Rec_IdRecurso)=True  and 
                                   (rec.Rec_Nombre LIKE '%$busqueda%' or rec.Rec_Fuente 
                                   LIKE '%$busqueda%' or rec.Rec_Origen LIKE '%$busqueda%' )
                                   ORDER BY rec.Rec_Nombre ");

        return $post->fetchAll();
    }

    public function getRecursosCompleto($tipo = "", $nombre = "", $estandar = 0, $fuente = "", $origen = "", $herramienta = 0) 
    {
        $listarecurso = $this->getRecursos($tipo, $nombre, $estandar, $fuente, $origen, $herramienta);
        for ($i = 0; $i < count($listarecurso); $i++) 
        {
            if (!empty($listarecurso[$i]['Rec_IdRecurso'])) 
            {
                $listarecurso[$i]['herramientas'] = $this->getHerramientaXrecurso($listarecurso[$i]['Rec_IdRecurso'], Cookie::lenguaje());
            }
        }
        return $listarecurso;
    }

    public function getRecursoCompletoXid($idrecurso) 
    {
        $listarecurso = $this->getRecursoMetadata($idrecurso);
        if (!empty($listarecurso['Rec_IdRecurso'])) {
            $listarecurso['herramientas'] = $this->getHerramientaXrecurso($listarecurso['Rec_IdRecurso'], Cookie::lenguaje());
        }
        return $listarecurso;
    }

    public function getRecursoCompletoXidTraducido($idrecurso, $Ididioma) 
    {
        $listarecurso = $this->getRecursoMetadataTraducido($idrecurso, $Ididioma);
        if (!empty($listarecurso['Rec_IdRecurso'])) 
        {
            $listarecurso['herramientas'] = $this->getHerramientaXrecurso($listarecurso['Rec_IdRecurso'], $Ididioma);
        }

        return $listarecurso;
    }

    public function getRecursoBusquedaTraducido($busqueda, $idIdioma)
    {
        try 
        {
            $sql = "SELECT rec.Rec_IdRecurso, fn_TraducirContenido('recurso','Rec_Nombre',rec.Rec_IdRecurso,'$idIdioma',rec.Rec_Nombre) Rec_Nombre, CASE rec.Tir_IdTipoRecurso WHEN 2 THEN (fn_TraducirContenido('capas','Cap_Descripcion',cap.Cap_Idcapa,'$idIdioma',cap.Cap_Descripcion)) WHEN 1 THEN (fn_TraducirContenido('metadata','Met_Descripcion',met.Met_IdMetadata,'$idIdioma',met.Met_Descripcion)) END AS Rec_Descripcion, CASE rec.Tir_IdTipoRecurso WHEN 2 THEN (cap.Cap_Idioma2) WHEN 1 THEN (met.Met_Idioma) END AS Rec_Idioma, fn_devolverIdioma('recurso',rec.Rec_IdRecurso,'$idIdioma',rec.Idi_IdIdioma) Idi_IdIdioma 
                FROM recurso rec LEFT JOIN capas cap ON cap.Rec_IdRecurso = rec.Rec_IdRecurso
                LEFT JOIN metadata met ON met.Rec_IdRecurso = rec.Rec_IdRecurso 
                WHERE rec.Rec_Estado = 1 AND (fn_TraducirContenido('recurso','Rec_Nombre',
                rec.Rec_IdRecurso,'$idIdioma',rec.Rec_Nombre) LIKE '%$busqueda%' OR 
                fn_TraducirContenido('capas','Cap_Descripcion',cap.Cap_Idcapa,'$idIdioma',cap.Cap_Descripcion) LIKE '%$busqueda%' OR 
                fn_TraducirContenido('capas','Cap_PalabrasClaves2',cap.Cap_Idcapa,'$idIdioma',cap.Cap_PalabrasClaves2) LIKE '%$busqueda%' OR 
                fn_TraducirContenido('metadata','Met_Descripcion',met.Met_IdMetadata,'$idIdioma',met.Met_Descripcion) LIKE '%$busqueda%' OR 
                fn_TraducirContenido('metadata','Met_PalabrasClaves',met.Met_IdMetadata,'$idIdioma',met.Met_PalabrasClaves) LIKE '%$busqueda%' )";

            $result = $this->_db->prepare($sql);
            $result->execute();
            return $result->fetchAll();
        } 
        catch (PDOException $exception) 
        {
            $this->insertarBitacora("Ocurrio un error al Buscar recursos : Parametros: " . json_encode(array($busqueda,$idIdioma)), "MySql", Session::get('usuario'), $exception->getFile(), "getRecursoBusquedaTraducido", $exception->getMessage(), 1);
            return $exception->getMessage();
        }
    }

    public function getHerramientaXrecurso($idrecurso, $ididioma) 
    {
        $post = $this->_db->query("SELECT Her_IdHerramientaSii, fn_TraducirContenido('herramienta_sii','Her_Nombre',hes.Her_IdHerramientaSii,'$ididioma',hes.Her_Nombre) Her_Nombre, Her_Abreviatura,
            fn_TraducirContenido('herramienta_sii','Her_Descripcion',hes.Her_IdHerramientaSii,'
            $ididioma',hes.Her_Descripcion) Her_Descripcion, Her_UrlMenu, Her_Estado, 
            fn_devolverIdioma('herramienta_sii',hes.Her_IdHerramientaSii,'$ididioma',
            hes.Idi_IdIdioma) Idi_IdIdioma  FROM herramienta_sii hes WHERE 
            EXISTS(SELECT DISTINCT ehr.Rec_IdRecurso FROM eh_recurso ehr INNER JOIN 
            estructura_herramienta esh ON esh.Esh_IdEstructuraHerramienta=ehr.Esh_IdEstructuraHerramienta 
            WHERE esh.Her_IdHerramientaSii=hes.Her_IdHerramientaSii and 
            ehr.Rec_IdRecurso=$idrecurso)=True ");
        
        return $post->fetchAll();
    }

    public function getRecurso() 
    {
        $post = $this->_db->query(
                "SELECT * FROM recurso ORDER BY Rec_Nombre");
        return $post->fetchAll();
    }

    public function getServicioSii() 
    {
        $post = $this->_db->query(
                "SELECT * FROM herramienta_sii");
        return $post->fetchAll();
    }

    public function getNombreRecurso() 
    {
        $post = $this->_db->query(
                "SELECT DISTINCT(rec.Rec_Nombre) AS Rec_Nombre FROM recurso rec ORDER BY Rec_Nombre ASC");
        return $post->fetchAll();
    }

    public function getRecursoCompletoXTipo() 
    {
        $tipo = $this->getTipoRecurso();
        for ($i = 0; $i < count($tipo); $i++) 
        {
            $tipo[$i]['recurso'] = $this->getRecursoXTipo($tipo[$i]['Tir_IdTipoRecurso']);
        }
        return $tipo;
    }

    public function getTipoRecurso() 
    {
        $post = $this->_db->query("SELECT tir.Tir_IdTipoRecurso,tir.Tir_Nombre, 
        COUNT(tir.Tir_IdTipoRecurso) AS Tir_Total FROM tipo_recurso tir 
        INNER JOIN recurso rec ON rec.Tir_IdTipoRecurso=tir.Tir_IdTipoRecurso
        GROUP BY tir.Tir_IdTipoRecurso,tir.Tir_Nombre
        ORDER BY tir.Tir_Nombre ASC");
        return $post->fetchAll();
    }

    public function getRecursoXTipo($idtipo) 
    {
        $post = $this->_db->query("SELECT r.* FROM recurso r
            INNER JOIN tipo_recurso tr ON tr.Tir_IdTipoRecurso=r.Tir_IdTipoRecurso
            WHERE r.Tir_IdTipoRecurso = $idtipo
            ORDER BY r.Rec_Nombre ");
        return $post->fetchAll();
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
    ) {

        try {
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

    public function insertarRecurso($iRec_Nombre, $iRec_Fuente, $iTir_IdTipoRecurso, 
        $iRec_CantidadRegistros, $iEst_IdEstandar, $iRec_Origen, $iIdi_IdIdioma) 
    {
        try 
        {
            $id_registro;
            $sql = "call s_i_recurso(?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRec_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iRec_Fuente, PDO::PARAM_STR);
            $result->bindParam(3, $iTir_IdTipoRecurso, PDO::PARAM_INT);
            $result->bindParam(4, $iRec_CantidadRegistros, PDO::PARAM_INT);
            $result->bindParam(5, $iEst_IdEstandar, PDO::PARAM_INT);
            $result->bindParam(6, $iRec_Origen, PDO::PARAM_STR);
            $result->bindParam(7, $iIdi_IdIdioma, PDO::PARAM_STR);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function actualizarRecurso($iRec_IdRecurso, $iRec_Nombre, $iRec_Fuente, $iRec_Origen
    ) 
    {
        try 
        {
            $id_registro;
            $sql = "call s_u_recurso(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRec_IdRecurso, PDO::PARAM_INT);
            $result->bindParam(2, $iRec_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iRec_Fuente, PDO::PARAM_STR);
            $result->bindParam(4, $iRec_Origen, PDO::PARAM_STR);
            $result->execute();
            return $result->rowCount();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function actualizarRecursoCompleto($iRec_IdRecurso, $iRec_Nombre, $iRec_Fuente, $iRec_Origen, $iIdi_IdIdioma) 
    {
        $bdarquitectura = $this->loadModel("index", "arquitectura");

        $herramienta = $this->getHerramientaXid($iHer_IdHerramientaSii);

        if ($herramienta["Idi_IdIdioma"] == $iIdi_IdIdioma) 
        {
            $this->actualizarHerramienta($iHer_IdHerramientaSii, $iHer_Nombre, $iHer_Descripcion, $iHer_Abreviatura, $iHer_Estado, $iIdi_IdIdioma);
        } 
        else 
        {
            $Her_Nombre = $bdarquitectura->buscarCampoTraducido("herramienta_sii", 
            $iHer_IdHerramientaSii, "Her_Nombre", $iIdi_IdIdioma);

            $Her_Descripcion = $bdarquitectura->buscarCampoTraducido("herramienta_sii", 
            $iHer_IdHerramientaSii, "Her_Descripcion", $iIdi_IdIdioma);

            if (isset($Her_Nombre["Idi_IdIdioma"]) && !empty($Her_Nombre["Idi_IdIdioma"]))
            {
                $bdarquitectura->actualizarTraduccion($Her_Nombre["Cot_IdContenidoTraducido"], 
                $Her_Nombre["Cot_Tabla"], $Her_Nombre["Cot_IdRegistro"], $Her_Nombre["Cot_Columna"], 
                $Her_Nombre["Idi_IdIdioma"], $iHer_Nombre);
            } 
            else 
            {
                $Her_Nombre = array();
                $Her_Nombre["Cot_IdContenidoTraducido"] = $bdarquitectura->registrarTraduccion("herramienta_sii", $iHer_IdHerramientaSii, "Her_Nombre", $iIdi_IdIdioma, $iHer_Nombre);
            }

            if (isset($Her_Descripcion["Idi_IdIdioma"]) && !empty($Her_Descripcion["Idi_IdIdioma"])) 
            {
                $bdarquitectura->actualizarTraduccion($Her_Descripcion["Cot_IdContenidoTraducido"], $Her_Descripcion["Cot_Tabla"], $Her_Descripcion["Cot_IdRegistro"], $Her_Descripcion["Cot_Columna"], $Her_Descripcion["Idi_IdIdioma"], $iHer_Descripcion);
            } 
            else 
            {
                $Her_Descripcion = array();
                $Her_Descripcion["Cot_IdContenidoTraducido"] = $bdarquitectura->registrarTraduccion("herramienta_sii", $iHer_IdHerramientaSii, "Her_Descripcion", $iIdi_IdIdioma, $iHer_Descripcion);
            }
        }
    }

    public function eliminarRecurso($iRec_IdRecurso)
    {
        try 
        {
            $id_registro;
            $sql = "call s_d_recurso(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRec_IdRecurso, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function actualizarEstadoRecurso($iRec_IdRecurso, $iRec_Estado) 
    {
        try 
        {
            $id_registro;
            $sql = "call s_u_estado_recurso(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRec_IdRecurso, PDO::PARAM_INT);
            $result->bindParam(2, $iRec_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getEstandar() 
    {
        $post = $this->_db->query("SELECT est.* FROM estandar_recurso est 
        WHERE EXISTS (SELECT Table_Name FROM information_schema.TABLES 
        WHERE Table_Name=est.Esr_NombreTabla AND TABLE_SCHEMA='siigef')");

        return $post->fetchAll();
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

    public function getMetadadaXRecurso($idRecurso) 
    {
        try 
        {
            $sql = "call s_s_metadata_x_recurso(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $idRecurso, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getOrigenRecurso() 
    {
        $post = $this->_db->query("SELECT DISTINCT(rec.Rec_Origen) AS Rec_Origen FROM recurso rec");

        return $post->fetchAll();
    }

    public function getFuente() 
    {
        $post = $this->_db->query("SELECT DISTINCT(rec.Rec_Fuente) AS Rec_Fuente FROM recurso rec");

        return $post->fetchAll();
    }

    public function getRecursoMetadata($idrecurso) 
    {
        $post = $this->_db->query("SELECT rec.*, tir.Tir_Nombre,est.Esr_IdEstandarRecurso,
        est.Esr_Nombre FROM recurso rec INNER JOIN tipo_recurso tir ON 
        rec.Tir_IdTipoRecurso = tir.Tir_IdTipoRecurso INNER JOIN estandar_recurso est ON 
        rec.Esr_IdEstandarRecurso = est.Esr_IdEstandarRecurso WHERE rec.Rec_IdRecurso=$idrecurso");

        return $post->fetch();
    }

    public function getRecursoMetadataTraducido($idrecurso, $idIdioma) 
    {
        $post = $this->_db->query("SELECT Rec_IdRecurso, fn_TraducirContenido('recurso','Rec_Nombre',
        rec.Rec_IdRecurso,'$idIdioma',rec.Rec_Nombre) Rec_Nombre, fn_TraducirContenido('recurso',
        'Rec_Fuente',rec.Rec_IdRecurso,'$idIdioma',rec.Rec_Fuente) Rec_Fuente, rec.Tir_IdTipoRecurso,
        Rec_CantidadRegistros, rec.Esr_IdEstandarRecurso, fn_TraducirContenido('recurso','Rec_Origen', 
        rec.Rec_IdRecurso,'$idIdioma',rec.Rec_Origen) Rec_Origen, Rec_FechaRegistro,
        Rec_UltimaModificacion, Rec_Estado, fn_devolverIdioma('recurso',rec.Rec_IdRecurso,'$idIdioma', 
        rec.Idi_IdIdioma) Idi_IdIdioma, tir.Tir_Nombre,est.Esr_IdEstandarRecurso, 
        fn_TraducirContenido('estandar_recurso','Rec_Origen', est.Esr_IdEstandarRecurso,'$idIdioma', 
        est.Esr_Nombre) Esr_Nombre 
        FROM recurso rec
        INNER JOIN tipo_recurso tir ON rec.Tir_IdTipoRecurso = tir.Tir_IdTipoRecurso           
        INNER JOIN estandar_recurso est ON rec.Esr_IdEstandarRecurso = est.Esr_IdEstandarRecurso  
        WHERE rec.Rec_IdRecurso=$idrecurso");

        return $post->fetch();
    }

    public function getFichaEstandarXRecurso($idrecurso) 
    {
        $post = $this->_db->query("SELECT fe.* FROM ficha_estandar fe 
        INNER JOIN estandar_recurso er ON fe.Esr_IdEstandarRecurso=er.Esr_IdEstandarRecurso    
        INNER JOIN recurso rec ON rec.Esr_IdEstandarRecurso=er.Esr_IdEstandarRecurso
        WHERE rec.Rec_IdRecurso=$idrecurso");

        return $post->fetchall();
    }

    public function getTablaXIdEstandarRecurso($idRecursoEstandar)
    {
        $post=$this->_db->query("SELECT Fie_NombreTabla FROM ficha_estandar 
        WHERE Esr_IdEstandarRecurso=$idRecursoEstandar");

        return $post->fetchAll();
    }   

     public function getColumnasTabla($tabla)
    {
        $post=$this->_db->query("SHOW COLUMNS FROM $tabla");

        return $post->fetchAll();
    }

    public function getEstado($tabla, $columna_estado, $columna_id, $valor_id)
    {
        $post=$this->_db->query("SELECT $columna_estado FROM $tabla WHERE $columna_id=$valor_id");

        return $post->fetchAll();
    }
    public function cambiarEstadoRecursoEstandar($tabla, $columna_estado, $nuevo_estado, $columna_id, $valor_id)
    {        
        $consulta = $this->_db->query("UPDATE $tabla SET $columna_estado = $nuevo_estado 
            WHERE $columna_id = $valor_id");        
        
        return $consulta->rowCount(PDO::FETCH_ASSOC);
    }

    public function eliminarEstandarxRecurso($idRecurso, $tabla, $campo_id) 
    {
        try 
        {          
            $consulta = $this->_db->query("DELETE FROM $tabla WHERE $campo_id = $idRecurso");

            return $consulta->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("legislacion(LegalModel)", "eliminarLegislacion", "Error Model", 
            $exception);
            return $exception->getTraceAsString();
        }
    }
}


?>
