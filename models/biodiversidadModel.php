<?php

class biodiversidadModel extends Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getReino() 
    {
        $post = $this->_db->query(
                "SELECT DISTINCT(Dar_ReinoOrganismo) Dar_ReinoOrganismo FROM darwin");
        return $post->fetchAll();
    }

    public function getClase($reino) 
    {
        $post = $this->_db->query(
                "SELECT DISTINCT(Dar_ClaseOrganismo)Dar_ClaseOrganismo FROM darwin 
                WHERE REPLACE(Dar_ReinoOrganismo,' ','')=REPLACE('$reino',' ','')");
        return $post->fetchAll();
    }

    public function getOrden($clase) 
    {
        $post = $this->_db->query(
                "SELECT DISTINCT(Dar_OrdenOrganismo) Dar_OrdenOrganismo FROM darwin
                WHERE REPLACE(Dar_ClaseOrganismo,' ','')=REPLACE('$clase',' ','')");
        return $post->fetchAll();
    }

    public function getFamilia($orden) 
    {
        $post = $this->_db->query(
                "SELECT DISTINCT(Dar_FamiliaOrganismo)Dar_FamiliaOrganismo FROM darwin 
                WHERE REPLACE(Dar_OrdenOrganismo,' ','')=REPLACE('$orden',' ','')");
        return $post->fetchAll();
    }

    public function getEspecie($Familia) 
    {
        $post = $this->_db->query(
                "SELECT DISTINCT(Dar_NombreCientifico) Dar_NombreCientifico FROM darwin
                WHERE REPLACE(Dar_FamiliaOrganismo,' ','')=REPLACE('$Familia',' ','')");
        return $post->fetchAll();
    }

    public function getEspecieXNC($NC) 
    {
        $post = $this->_db->query(
                "SELECT DISTINCT(Dar_NombreCientifico) Dar_NombreCientifico FROM darwin
                WHERE REPLACE(Dar_NombreCientifico,' ','')=REPLACE('$NC',' ','')");
        return $post->fetch();
    }

    public function getEspecieCompleto() 
    {
        $Reino = $this->getReino();
        for ($index = 0; $index < count($Reino); $index++) 
        {
            $Reino[$index]["Clase"] = $this->getClase($Reino[$index]["Dar_ReinoOrganismo"]);

            for ($index1 = 0; $index1 < count($Reino[$index]["Clase"]); $index1++) 
            {
                $Reino[$index]["Clase"][$index1]["Orden"] = $this->getOrden($Reino[$index]["Clase"][$index1]["Dar_ClaseOrganismo"]);

                for ($index2 = 0; $index2 < count($Reino[$index]["Clase"][$index1]["Orden"]); $index2++) 
                {
                    $Reino[$index]["Clase"][$index1]["Orden"][$index2]["Familia"] = $this->getFamilia($Reino[$index]["Clase"][$index1]["Orden"][$index2]["Dar_OrdenOrganismo"]);

                    for ($index3 = 0; $index3 < count($Reino[$index]["Clase"][$index1]["Orden"][$index2]["Familia"]); $index3++) 
                    {
                        $Reino[$index]["Clase"][$index1]["Orden"][$index2]["Familia"][$index3]["Especie"] = $this->getEspecie($Reino[$index]["Clase"][$index1]["Orden"][$index2]["Familia"][$index3]["Dar_FamiliaOrganismo"]);
                    }
                }
            }
        }
        return $Reino;
    }

    public function listarArbolJerarquiaBioVisor($idpadre = null) 
    {
        $padre = $this->listarJerarquiaBiodiversidadXidpadre($idpadre);
        $bdcapa = $this->loadModel("mapa");

        for ($i = 0; $i < count($padre); $i++) 
        {
            $id = $padre[$i]["Jeb_IdJerarquiaBiodiversidad"];
            $temph = $this->listarArbolJerarquiaBioVisor($id);

            if (!count($temph)) 
            {
                //$padre[$i]["darwin"] = $this->getEspecieXNC($padre[$i]["Jeb_Nombre"]);
            }
            $padre[$i]["hijo"] = $temph;
        }
        return $padre;
    }

    public function listarJerarquiaBiodiversidadXidpadre($idpadre = null) 
    {
        try 
        {
            $sql = "call s_s_jerarquia_biodiversidad_completo_idpadre(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $idpadre, PDO::PARAM_NULL | PDO::PARAM_INT);
            $result->execute();
            return $result->fetchAll();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function obtenerDarwinXid($iddarwin) 
    {
        try 
        {
            $sql = "call s_s_darwin_x_id(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iddarwin, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function PuntosPorEspecie($especie) 
    {
        try 
        {                      
            $count = count($especie);

            if ($count && $especie) 
            {
                $recurso = $especie[0][1];
                $recurso = explode(",", $recurso);

                $param_r = "Rec_IdRecurso=$recurso[0]";
                for ($i = 1; $i < count($recurso); $i++) 
                {
                    $param_r = $param_r . " or Rec_IdRecurso =$recurso[$i]";
                }

                $para = $especie[0][2] . "  LIKE CONCAT('%','" . $especie[0][0] . "','%') ";

                for ($i = 1; $i < $count; $i++) 
                {
                    $para = $para . " or " . $especie[$i][2] . " LIKE CONCAT('%','" . $especie[$i][0] . "','%')";
                }
                //$para = "where ($para) and ($param_r) AND (CAST(Dar_Latitud AS DECIMAL(9,7))  BETWEEN  -14.00 AND 2)  AND( CAST(Dar_Longitud AS DECIMAL(9,7)) BETWEEN -78 AND -50 ) ";
                $para = "where ($para) and ($param_r) AND Dar_Estado=1";

                // $para = " WHERE Dar_CodigoInstitucion LIKE '%colombia%'    ";
            }

            $result = $this->_db->prepare("SELECT  DISTINCT Dar_IdDarwinCore,Dar_ReinoOrganismo,Dar_NombreCientifico,Dar_Latitud,Dar_Longitud FROM darwin  $para");

            $result->execute();


            return $result->fetchAll();
        } 
        catch (PDOException $exception) 
        {
            //$this->insertarBitacora("Ocurrio un error al actualizar estructura : Parametros: " . json_encode(array($iEsh_IdEstructuraHerramienta, $iEsh_Nombre, $iEsh_Titulo, $iEsh_Descripcion, $iEsh_Orden)), "MySql", Session::get('usuario'), $exception->getFile(), "listarCapaWms", $exception->getMessage(), 1);
            echo $exception->getMessage();
            return $exception->getMessage();
        }
    }

    public function getDarwinXrecurso($idrecurso, $condicion) 
    {
        $post = $this->_db->query(
            "SELECT * FROM darwin WHERE Rec_IdRecurso = $idrecurso $condicion"
            );
        return $post->fetchAll();
    }

    public function getDarwinMetadata($id_darwin) 
    {
        $post = $this->_db->query(
            "SELECT * FROM darwin WHERE Dar_IdDarwinCore=$id_darwin and Dar_Estado=1"
            );
        return $post->fetchAll();
    }

    public function _cambiarEstadoDarwin($id_darwin, $nuevo_estado)
    {
        $consulta = $this->_db->query(
            "UPDATE darwin SET Dar_Estado = $nuevo_estado WHERE Dar_IdDarwinCore=$id_darwin"
            );        
        
        return $consulta->rowCount(PDO::FETCH_ASSOC);
    }

    public function eliminarDarwinCore($id_darwin) 
    {
        try 
        {            
            $consulta = $this->_db->query(
                    "DELETE FROM darwin WHERE Dar_IdDarwinCore= $id_darwin"
            );
            return $consulta->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("index(biodiversidadModel)", "eliminarDarwinCore", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

}

?>
