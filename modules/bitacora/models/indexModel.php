<?php

class indexModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    public function getListarBitacoraErrores($iano = "", $imes = "", $iEvs_Tipo = "") {
        try {
            $sql = "call s_s_ListarBitacoraErrores(?,?,?)";
            
            $result = $this->_db->prepare($sql);
            
            $result->bindParam(1, $iano, PDO::PARAM_STR);
            $result->bindParam(2, $imes, PDO::PARAM_STR);
            $result->bindParam(3, $iEvs_Tipo, PDO::PARAM_STR);

            $result->execute();
            $bitacoras = $result->fetchAll();
//            
            if(empty($bitacoras)){
                throw new Exception('No se encontraron registros en la Base de Datos.');   
            }
            return $bitacoras;
            
        } catch (PDOException $exception) {
            $this->registrarBitacora("bitacora(indexModel)", "getListarBitacoraErrores", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getObtenerErroresMasComunes($iano = "", $imes = "", $iEvs_Tipo = "") {
        try {
            $sql = "call s_s_ObtenerErroresMasComunes(?,?,?)";

            $result = $this->_db->prepare($sql);

            $result->bindParam(1, $iano, PDO::PARAM_STR);
            $result->bindParam(2, $imes, PDO::PARAM_STR);
            $result->bindParam(3, $iEvs_Tipo, PDO::PARAM_STR);

            $result->execute();

            return $result->fetchAll();
        } catch (PDOException $exception) {            
            $this->registrarBitacora("bitacora(indexModel)", "getObtenerErroresMasComunes", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function getObtenerPaginasConMasErrores($iano = "", $imes = "", $iEvs_Tipo = "") {
        try {
            $sql = "call s_s_ObtenerPaginasConMasErrores(?,?,?)";

            $result = $this->_db->prepare($sql);

            $result->bindParam(1, $iano, PDO::PARAM_STR);
            $result->bindParam(2, $imes, PDO::PARAM_STR);
            $result->bindParam(3, $iEvs_Tipo, PDO::PARAM_STR);

            $result->execute();

            return $result->fetchAll();
        } catch (PDOException $exception) {            
            $this->registrarBitacora("bitacora(indexModel)", "getObtenerPaginasConMasErrores", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

}

?>
