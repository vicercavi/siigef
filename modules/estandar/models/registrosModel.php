<?php

class registrosModel extends Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getIdiomas() 
    {
        $post = $this->_db->query(
                "SELECT * FROM idioma");
        return $post->fetchAll();
    }

    public function getFichaEstandar($Esr_IdEstandarRecurso) 
    {
        $post = $this->_db->query(
                "SELECT * FROM ficha_estandar WHERE Esr_IdEstandarRecurso = $Esr_IdEstandarRecurso");
        return $post->fetchAll();
    }
    
    public function getEstandar_recurso($condicion = '')
    {
        try
        {
            $esr = $this->_db->query("select * from estandar_recurso $condicion");

            return $esr->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "getEstandar_recurso", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }

    public function getFichaVariable($nombre_tabla)
    {        
        $post = $this->_db->query("SELECT * FROM $nombre_tabla");
        return $post->fetchAll();
    }

    public function getDatosTabla($nombre_tabla, $condicion='')
    {
        $post = $this->_db->query("SELECT * FROM $nombre_tabla $condicion");
        return $post->fetchAll();
    }

    public function getValorMaximo($nombre_tabla, $campo_numregistro)
    {
        $post = $this->_db->query("SELECT MAX($campo_numregistro) num_registros FROM $nombre_tabla");
        return $post->fetchAll();
    }
    public function getDatosEstandar2($nombre_tabla, $nombre_tabla2, $ini, $condicion='')
    {
        $id = $ini."_Id".str_replace(' ','',ucwords(str_replace('_', ' ', $nombre_tabla)));

        $post =$this->_db->query("SELECT * FROM $nombre_tabla a INNER JOIN $nombre_tabla2 b ON a.$id=b.$id");
        return $post->fetchAll();
    }

    public function getEstandarRecurso($rec_idrecurso) 
    {
        $post = $this->_db->query(
                "SELECT Esr_IdEstandarRecurso,Rec_Nombre FROM recurso WHERE rec_idrecurso = $rec_idrecurso");
        return $post->fetch();
    }

    public function insertarRegistro($insertar) 
    {
        try 
        {
            $result = $this->_db->prepare($insertar);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(registrosModel)", "insertarRegistro", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getRegistroTraducido($insertar) 
    {
        try 
        {
            $result = $this->_db->prepare($insertar);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(registrosModel)", "getRegistroTraducido", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getListaRegistrosEstandar($tabla, $idioma, $condicion="") 
    {
        try 
        {
            $post = $this->_db->query(
                    "SELECT * FROM $tabla WHERE Idi_IdIdioma = '$idioma' $condicion");
            return $post->fetchAll();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(registrosModel)", "getListaRegistrosEstandar", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
        //poner estado
    }

    public function getRegistroEstandar($tabla, $idRegistro, $idTabla) 
    {
        try 
        {
            $post = $this->_db->query(
                    "SELECT * FROM $tabla WHERE $idTabla = $idRegistro  ");
            return $post->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(registrosModel)", "getaRegistrosEstandar", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarTraduccion($Cot_IdContenidoTraducido, $Cot_Traduccion) 
    {
        try 
        {
            $sql = "call s_u_actualizar_contenido_traducido(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $Cot_IdContenidoTraducido, PDO::PARAM_INT);
            $result->bindParam(2, $Cot_Traduccion, PDO::PARAM_STR);
            $result->execute();
            return $result->rowCount();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(registrosModel)", "actualizarTraduccion", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function estandarXTabla($tabla) 
    {
        try 
        {
            $sql = "SELECT * FROM estandar_recurso WHERE Esr_NombreTabla ='$tabla'";
            $result = $this->_db->prepare($sql);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("eoro", "actualizarTraduccion", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function puntosEstandarGenerico($parametros, $idIdioma) 
    {
        $para = "";
        $count = count($parametros);

        if ($count && $parametros) 
        {
            $tabla = $parametros[0][2];
            $recurso = $parametros[0][3];
            $recurso = explode(",", $recurso);

            $bdestandar = $this->loadModel('index', 'estandar');

            $estandar = $this->estandarXTabla($tabla);
            $fichaEstandar = $bdestandar->getFicha_Estandar($estandar["Esr_IdEstandarRecurso"]);

            $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3);

            $idTabla = $ini . "_Id" . str_replace(' ', '', ucwords(str_replace('_', ' ', $estandar['Esr_NombreTabla'])));
            $estado = $ini . "_Estado";
            $latitud = "";
            $longitud = "";

            foreach ($fichaEstandar as $ficha) 
            {
                if ($ficha["Fie_ColumnaTipo"] == "Latitud") 
                {
                    $latitud = $ficha["Fie_ColumnaTabla"];
                }

                if ($ficha["Fie_ColumnaTipo"] == "Longitud") 
                {
                    $longitud = $ficha["Fie_ColumnaTabla"];
                }
            }

            $param_r = "Rec_IdRecurso=$recurso[0]";

            for ($i = 1; $i < count($recurso); $i++) 
            {
                $param_r = $param_r . " or Rec_IdRecurso =$recurso[$i]";
            }

            if (is_numeric($parametros[0][0])) 
            {
                $para = " " . $parametros[0][1] . "  =  " . $parametros[0][0];
            } 
            else
            {
                $para = " TRIM(" . $parametros[0][1] . ")  LIKE TRIM('" . $parametros[0][0] . "')";
            }

            for ($i = 1; $i < $count; $i++) 
            {
                if (is_numeric($parametros[0][0])) 
                {

                    $para = $para . " or " . $parametros[$i][1] . "  = " . $parametros[$i][0];
                } 
                else 
                {
                    $para = $para . " or TRIM(" . $parametros[$i][1] . ")  LIKE TRIM('" . $parametros[$i][0] . "') ";
                }
            }
        }

        $para = " WHERE ($para) and ($param_r)";


        $sql = "SELECT $idTabla esr_id,"
                . $parametros[0][1] . " esr_nombre, "
                . "$latitud esr_latitud, "
                . "$longitud esr_longitud, "
                . "'$tabla' esr_tabla, "
                . "'".$parametros[0][1]."' esr_columna, "
                . "Rec_IdRecurso esr_recurso "
                . "FROM  $tabla  "
                . $para . " AND $estado=1 "
                ." GROUP BY $latitud,$longitud ";
      
        $result = $this->_db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }

    public function perfilEstandarGenerico($filtro, $tabla, $columna, $latitud, $longitud, $idIdioma) 
     {
        $bdestandar = $this->loadModel('index', 'estandar');

        $estandar = $this->estandarXTabla($tabla);
        $fichaEstandar = $bdestandar->getFicha_Estandar($estandar["Esr_IdEstandarRecurso"]);

        $ini = substr($fichaEstandar[0]['Fie_ColumnaTabla'], 0, 3);

        $idTabla = $ini . "_Id" . str_replace(' ', '', ucwords(str_replace('_', ' ', $estandar['Esr_NombreTabla'])));
        $estado = $ini . "_Estado";
        $clatitud = "";
        $clongitud = "";

        foreach ($fichaEstandar as $ficha) 
        {
            if ($ficha["Fie_ColumnaTipo"] == "Latitud") 
            {
                $clatitud = $ficha["Fie_ColumnaTabla"];
            }

            if ($ficha["Fie_ColumnaTipo"] == "Longitud") 
            {
                $clongitud = $ficha["Fie_ColumnaTabla"];
            }
        }            
       
        $wherefiltro = "TRIM($columna) LIKE TRIM('$filtro[0]')";

        for ($i = 1; $i < count($filtro); $i++) 
        {
            $wherefiltro = $wherefiltro . " or TRIM($columna) LIKE TRIM('$filtro[$i]')";
        }
            
        $para = " WHERE ($wherefiltro) and ($clatitud like '%$latitud%' and $clongitud like '%$longitud%' )";


        $sql = "SELECT * FROM  $tabla  "
                . $para . " AND $estado=1 ";
        //echo $sql; exit();
        $result = $this->_db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }

    public function perfilEstandarGenericoXId($filtro, $tabla, $columna, $valor_latitud, $valor_longitud, $campo_id, $valor_id, $campo_latitud, $campo_longitud, $campo_estado) 
     {
        
        $sql = "SELECT * FROM $tabla WHERE (TRIM($columna) LIKE TRIM('".$filtro."')) AND ($campo_latitud LIKE '%".$valor_latitud."%' AND $campo_longitud LIKE '%".$valor_longitud."%' ) AND $campo_id= $valor_id AND $campo_estado=1";

        $result = $this->_db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }

    public function getEstandarMetadata($tabla, $columna_id, $valor_id) 
    {
        //consultar varibles
        $post = $this->_db->query(
                "SELECT * FROM $tabla WHERE $columna_id = $valor_id");
        return $post->fetchAll();
    }

    //Para Reportes

    public function getCantidadPorPregunta($tabla, $campo_id, $valor_id, $condicion='')
    {
        $post = $this->_db->query("SELECT COUNT(*) cantidad FROM $tabla WHERE $campo_id=$valor_id $condicion");
        return $post->fetchAll();
    }
    public function getCantidadPorColumna($tabla_data, $nombre_columna, $condicion='')
    {
        $post = $this->_db->query("SELECT $nombre_columna, COUNT(*) Total FROM $tabla_data GROUP BY $nombre_columna $condicion");
        return $post->fetchAll();
    }
}

?>
