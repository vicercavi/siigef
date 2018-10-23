<?php

class ponderacionicaModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getPonderacionIcas($condicion = '') {

        try {
            $ponderacionicas = $this->_db->query(
                    "select pi.*, ic.Ica_Nombre, ve.Var_Nombre from ponderacion_ica pi " .
                    " left join variables_estudio ve on pi.Var_IdVariable = ve.Var_IdVariable" .
                    " left join ica ic on pi.Ica_IdIca = ic.Ica_IdIca  $condicion"
            );
            return $ponderacionicas->fetchAll();
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ponderacionicaModel)", "getPonderacionIcas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getPonderacionIca($id) {
        try {
            $sql = "call s_s_ponderacion_ica(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function registrarPonderacionIca($iVar_IdVariable, $iPoi_Peso, $iIca_IdIca, $iPoi_Estado) {
        try {
            $sql = "call s_i_ponderacion_ica(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iVar_IdVariable, PDO::PARAM_INT);
            $result->bindParam(2, $iPoi_Peso, PDO::PARAM_LOB);
            $result->bindParam(3, $iIca_IdIca, PDO::PARAM_INT);
            $result->bindParam(4, $iPoi_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("ponderacionicaModel", "registrarPonderacionIca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarPonderacionIca($iPoi_IdPonderacionIca, $iVar_IdVariable, $iPoi_Peso, $iIca_IdIca, $iPoi_Estado) {
        try {
            $sql = "call s_u_ponderacion_ica(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iPoi_IdPonderacionIca, PDO::PARAM_INT);
            $result->bindParam(2, $iVar_IdVariable, PDO::PARAM_INT);
            $result->bindParam(3, $iPoi_Peso, PDO::PARAM_LOB);
            $result->bindParam(4, $iIca_IdIca, PDO::PARAM_INT);
            $result->bindParam(5, $iPoi_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("ponderacionicaModel", "actualizarPonderacionIca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getIcas() {
        try {
            $tipos_agua = $this->_db->query(
                    "SELECT * FROM ica");
            return $tipos_agua->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ponderacionicaModel)", "getIcas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getVariables() {
        try {
            $paises = $this->_db->query(
                    "SELECT * FROM variables_estudio");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ponderacionicaModel)", "getVariables", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarEstadoPonderacionIca($iPoi_IdPonderacionIca, $iPoi_Estado) {

        try {
            $sql = "call s_u_estado_ponderacion_ica(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iPoi_IdPonderacionIca, PDO::PARAM_INT);
            $result->bindParam(2, $iPoi_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function eliminarPonderacionIca($iPoi_IdPonderacionIca) {

        try {
            $sql = "call s_d_ponderacion_ica(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iPoi_IdPonderacionIca, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

}
