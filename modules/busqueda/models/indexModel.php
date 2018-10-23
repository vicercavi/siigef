<?php

class indexModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function registrarBusqueda($iEsb_PalabraBuscada,$iEsb_Ip,$iEsb_TipoAcceso='') {
        try {                     
            $sql = "call s_i_estadistica_descarga(?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsb_PalabraBuscada, PDO::PARAM_STR);
            $result->bindParam(2, $iEsb_Ip, PDO::PARAM_STR);
            //  $result->bindParam(3, $Esd_CantidadBusqueda, PDO::PARAM_INT);
            $result->bindParam(3, $iEsb_TipoAcceso, PDO::PARAM_STR);
            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("busqueda(indexModel)", "registrarBusqueda", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }   
    
    public function getListarBusqueda($iano = "", $imes = "") {
        try {
            $sql = "call s_s_ListarBusqueda(?,?)";

            $result = $this->_db->prepare($sql);

            $result->bindParam(1, $iano, PDO::PARAM_STR);
            $result->bindParam(2, $imes, PDO::PARAM_STR);

            $result->execute();

            return $result->fetchAll();
        } catch (PDOException $ex) {
            $this->registrarBitacora("busqueda(indexModel)", "getListarBusqueda", "Error Model", $ex);
            return true;
        }
    }

    public function getObtenerBusqueda($iano = "", $imes = "") {
        try {
            $sql = "call s_s_ObtenerBusqueda(?,?)";

            $result = $this->_db->prepare($sql);

            $result->bindParam(1, $iano, PDO::PARAM_STR);
            $result->bindParam(2, $imes, PDO::PARAM_STR);

            $result->execute();

            return $result->fetchAll();
        } catch (PDOException $ex) {
            $this->registrarBitacora("busqueda(indexModel)", "getObtenerBusqueda", "Error Model", $ex);
            return true;
        }
    }
}

?>
