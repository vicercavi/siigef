<?php

class indexModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function insertarVisita($iVis_Explorador,$iVis_PaginaVisita,$iVis_PaginaAnterior,$iVis_SistemaOperativo,$iVis_Idioma,$iVis_Ip){
        try {
            $sql = "call s_i_estadistica_visita(?,?,?,?,?,?)";
                $result = $this->_db->prepare($sql);
                $result->bindParam(1, $iVis_Explorador, PDO::PARAM_STR);
                $result->bindParam(2, $iVis_PaginaVisita, PDO::PARAM_STR);
                $result->bindParam(3, $iVis_PaginaAnterior, PDO::PARAM_STR);
                $result->bindParam(4, $iVis_SistemaOperativo, PDO::PARAM_STR);
                $result->bindParam(5, $iVis_Idioma, PDO::PARAM_STR);
                $result->bindParam(6, $iVis_Ip, PDO::PARAM_STR);
                $result->execute();
            
        } catch (PDOException $exception) {
            $this->registrarBitacora("visita(indexModel)", "insertarVisita", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }    

    public function getListarVisita($iano = "", $imes = "") {
        try {
            $sql = "call s_s_ListarVisita(?,?)";

            $result = $this->_db->prepare($sql);

            $result->bindParam(1, $iano, PDO::PARAM_STR);
            $result->bindParam(2, $imes, PDO::PARAM_STR);

            $result->execute();

            return $result->fetchAll();
        } catch (PDOException $exception) {
            $this->registrarBitacora("visita(indexModel)", "getListarVisita", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getObtenerExplorador($iano = "", $imes = "") {
        try {
            $sql = "call s_s_ObtenerExplorador(?,?)";

            $result = $this->_db->prepare($sql);

            $result->bindParam(1, $iano, PDO::PARAM_STR);
            $result->bindParam(2, $imes, PDO::PARAM_STR);

            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("visita(indexModel)", "getObtenerExplorador", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getObtenerIpMasFrecuentes($iano = "", $imes = "") {
        try {
            $sql = "call s_s_ObtenerIpMasFrecuentes(?,?)";

            $result = $this->_db->prepare($sql);

            $result->bindParam(1, $iano, PDO::PARAM_STR);
            $result->bindParam(2, $imes, PDO::PARAM_STR);

            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("visita(indexModel)", "getObtenerIpMasFrecuentes", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getObtenerOrigenesDeVisitas($iano = "", $imes = "") {
        try {
            $sql = "call s_s_ObtenerOrigenesDeVisitas(?,?)";

            $result = $this->_db->prepare($sql);

            $result->bindParam(1, $iano, PDO::PARAM_STR);
            $result->bindParam(2, $imes, PDO::PARAM_STR);

            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("visita(indexModel)", "getObtenerOrigenesDeVisitas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getObtenerPaginasMasVisitadas($iano = "", $imes = "") {
        try {
            $sql = "call s_s_ObtenerPaginasMasVisitadas(?,?)";

            $result = $this->_db->prepare($sql);

            $result->bindParam(1, $iano, PDO::PARAM_STR);
            $result->bindParam(2, $imes, PDO::PARAM_STR);

            $result->execute();

            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("visita(indexModel)", "getObtenerPaginasMasVisitadas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
}

?>
