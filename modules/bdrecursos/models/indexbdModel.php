<?php

class indexbdModel extends Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getProximoId($tabla)
    {
        $post = $this->_db->query("SHOW TABLE STATUS LIKE '".$tabla."'");
        return $post->fetchAll();
    }

    public function getRecursosIndex($tipo = "", $nombre = "", $estandar = 0, $fuente = "", $origen = "", $herramienta = 0) 
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

    public function getRecursos($where="") 
    {
        $post = $this->_db->query("SELECT rec.*, tir.Tir_Nombre,est.Esr_Nombre, est.Esr_Tipo FROM recurso rec INNER JOIN tipo_recurso tir ON rec.Tir_IdTipoRecurso = tir.Tir_IdTipoRecurso INNER JOIN estandar_recurso est ON rec.Esr_IdEstandarRecurso = est.Esr_IdEstandarRecurso 
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
                                   ehr.Rec_IdRecurso=rec.Rec_IdRecurso AND  esh.Esh_Estado=1)=True  and 
                                   (rec.Rec_Nombre LIKE '%$busqueda%' or rec.Rec_Fuente 
                                   LIKE '%$busqueda%' or rec.Rec_Origen LIKE '%$busqueda%' )
                                   ORDER BY rec.Rec_Nombre ");
        return $post->fetchAll();
    }

    public function getRecursosCompleto($tipo = "", $nombre = "", $estandar = 0, $fuente = "", $origen = "", $herramienta = 0) 
    {
        $listarecurso = $this->getRecursosIndex($tipo, $nombre, $estandar, $fuente, $origen, $herramienta);
        for ($i = 0; $i < count($listarecurso); $i++) 
        {
            if (!empty($listarecurso[$i]['Rec_IdRecurso'])) 
            {
                $listarecurso[$i]['herramientas'] = $this->getHerramientaXrecurso($listarecurso[$i]['Rec_IdRecurso'], Cookie::lenguaje());
            }
        }
        return $listarecurso;
    }

    public function getRecursoMetadata($idrecurso) 
    {
        $post = $this->_db->query("SELECT rec.*, tir.Tir_Nombre,est.Esr_IdEstandarRecurso,
        est.Esr_Nombre FROM recurso rec INNER JOIN tipo_recurso tir ON 
        rec.Tir_IdTipoRecurso = tir.Tir_IdTipoRecurso INNER JOIN estandar_recurso est ON 
        rec.Esr_IdEstandarRecurso = est.Esr_IdEstandarRecurso WHERE rec.Rec_IdRecurso=$idrecurso");

        return $post->fetch();
    }

    public function getRecursoCompletoXid($idrecurso) 
    {
        $listarecurso = $this->getRecursoMetadata($idrecurso);
        if (!empty($listarecurso['Rec_IdRecurso'])) 
        {
            $listarecurso['herramientas'] = $this->getHerramientaXrecurso($listarecurso['Rec_IdRecurso'], Cookie::lenguaje());
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

    public function getRecursoCompletoXidTraducido($idrecurso, $Ididioma) 
    {
        $listarecurso = $this->getRecursoMetadataTraducido($idrecurso, $Ididioma);
        if (!empty($listarecurso['Rec_IdRecurso'])) 
        {
            $listarecurso['herramientas'] = $this->getHerramientaXrecurso($listarecurso['Rec_IdRecurso'], $Ididioma);
        }

        return $listarecurso;
    }
    
    public function getFichaEstandarXRecurso($idrecurso) 
    {
        $post = $this->_db->query("SELECT fe.* FROM ficha_estandar fe 
        INNER JOIN estandar_recurso er ON fe.Esr_IdEstandarRecurso=er.Esr_IdEstandarRecurso    
        INNER JOIN recurso rec ON rec.Esr_IdEstandarRecurso=er.Esr_IdEstandarRecurso
        WHERE rec.Rec_IdRecurso=$idrecurso");

        return $post->fetchall();
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

    public function getTablaData($tabla_recurso) 
    {
        $post = $this->_db->query("SELECT Table_Name FROM information_schema.TABLES 
        WHERE Table_Name LIKE '".$tabla_recurso."%' AND TABLE_SCHEMA='siigef' ORDER BY Table_Name desc");
        return $post->fetchAll();
    }

    public function getRecursoXEstandar($id_estandar)
    {
        $post = $this->_db->query("SELECT * FROM recurso WHERE Esr_IdEstandarRecurso=$id_estandar");
        return $post->fetchAll();
    }

    public function getEstandar() 
    {
        $post = $this->_db->query("SELECT est.* FROM estandar_recurso est 
        WHERE EXISTS (SELECT Table_Name FROM information_schema.TABLES 
        WHERE Table_Name=est.Esr_NombreTabla AND TABLE_SCHEMA='siigef')");

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
            $this->registrarBitacora("bdrecursos(indexbdModel)", "eliminarEstandarxRecurso", "Error Model", 
            $exception);
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

    public function insertarRecurso($iRec_Nombre, $iRec_Fuente, $iTir_IdTipoRecurso, 
        $iRec_CantidadRegistros, $iEst_IdEstandar, $iRec_Origen, $Rec_NombreTabla, $iIdi_IdIdioma) 
    {
        try 
        {
            $id_registro;
            $sql = "call s_i_recurso(?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRec_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iRec_Fuente, PDO::PARAM_STR);
            $result->bindParam(3, $iTir_IdTipoRecurso, PDO::PARAM_INT);
            $result->bindParam(4, $iRec_CantidadRegistros, PDO::PARAM_INT);
            $result->bindParam(5, $iEst_IdEstandar, PDO::PARAM_INT);
            $result->bindParam(6, $iRec_Origen, PDO::PARAM_STR);
            $result->bindParam(7, $Rec_NombreTabla, PDO::PARAM_STR);
            $result->bindParam(8, $iIdi_IdIdioma, PDO::PARAM_STR);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }
    
    public function actualizarRecurso($iRec_IdRecurso, $iRec_Nombre, $iRec_Fuente, $iRec_Origen) 
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

    //Para los registros

    public function registrarRegistroEncuesta($tabla_data, $valor_registro, $campo_id, $campo_valor) 
    {
        try 
        {
            $insertar = "INSERT INTO " . $tabla_data . " VALUES (null, " . $valor_registro . ", "
                . " " . $campo_id . ", '" . $campo_valor. "', 1)";
                
            $result = $this->_db->prepare($insertar);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("bdrecursos(indexbdModel)", "registrarRegistroEncuesta", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getRegistrosXRecurso($tabla, $idRegistro, $condicion='') 
    {
        try 
        {
            $post = $this->_db->query("SELECT * FROM $tabla WHERE  Rec_IdRecurso = $idRegistro $condicion");
            return $post->fetchAll();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("bdrecursos(indexbdModel)", "getRegistrosXRecurso", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getRegistroMetadata($nombre_tabla1, $nombre_tabla2, $campo_id, $campo_registro, $valor_registro)
    {
        $post=$this->_db->query("SELECT * FROM $nombre_tabla2 d INNER JOIN $nombre_tabla1 v 
            ON d.$campo_id=v.$campo_id WHERE $campo_registro=$valor_registro");
        return $post->fetchAll();

    }

    public function getRegistrosData($tabla_data, $condicion='')
    {
        try 
        {
            //echo "SELECT * FROM $tabla_data $condicion"; exit();
            $post = $this->_db->query("SELECT * FROM $tabla_data $condicion");
            return $post->fetchAll();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("bdrecursos(indexbdModel)", "getRegistrosData", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
}
?>
