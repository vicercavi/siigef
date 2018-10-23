<?php

class indexModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getListarDescarga($iano = "", $imes = "") {
        try {
            $sql = "call s_s_ListarDescarga(?,?)";

            $result = $this->_db->prepare($sql);

            $result->bindParam(1, $iano, PDO::PARAM_STR);
            $result->bindParam(2, $imes, PDO::PARAM_STR);

            $result->execute();

            return $result->fetchAll();
        } catch (Exception $ex) {
            $this->registrarBitacora("descarga(indexModel)", "getListarDescarga", "Error Model", $ex);
            return true;
        }
    }

    public function getObtenerDescarga($iano = "", $imes = "") {
        try {
            $sql = "call s_s_ObtenerDescarga(?,?)";

            $result = $this->_db->prepare($sql);

            $result->bindParam(1, $iano, PDO::PARAM_STR);
            $result->bindParam(2, $imes, PDO::PARAM_STR);

            $result->execute();

            return $result->fetchAll();
        } catch (Exception $ex) {
            $this->registrarBitacora("descarga(indexModel)", "getObtenerDescarga", "Error Model", $ex);
            return true;
        }
    }

}

?>
