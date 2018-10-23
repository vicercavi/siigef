<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of variablesestudioModel
 *
 * @author CHUJE
 */
class variablesestudioModel  extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getvariablesestudios($condicion = '') {

        try {
            $cuencas = $this->_db->query(
                    "select vs.*,tp.Tiv_Nombre from variables_estudio vs inner join "
                    . " tipo_variable tp on vs.Tiv_IdTipoVariable = tp.Tiv_IdTipoVariable $condicion  "
            );
            return $cuencas->fetchAll();
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(variablesestudioModel)", "getvariablesestudios", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getTipoVariable() {
        try {
            $paises = $this->_db->query(
                    "SELECT * FROM tipo_variable");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(variablesestudioModel)", "getTipoVariable", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getvariablesestudio($id) {
        try {
            $sql = "call s_s_variable_estudio(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function registrarvariablesestudio($iVar_Nombre, $iVar_Abreviatura, $iVar_Medida, $iVar_Estado,$iTiv_IdTipoVariable,$iVar_DescripcionMedida) {
        try {
            $sql = "call s_i_variable_estudio(?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iVar_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iVar_Abreviatura, PDO::PARAM_STR);
            $result->bindParam(3, $iVar_Medida, PDO::PARAM_STR);
            $result->bindParam(4, $iVar_Estado, PDO::PARAM_INT);
             $result->bindParam(5, $iTiv_IdTipoVariable, PDO::PARAM_INT);
             $result->bindParam(6, $iVar_DescripcionMedida, PDO::PARAM_STR);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("variablesestudioModel", "registrarvariablesestudio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarvariablesestudio($iVar_IdVariable, $iVar_Nombre, $iVar_Abreviatura, $iVar_Medida, $iVar_Estado,$iTiv_IdTipoVariable,$iVar_DescripcionMedida) {
        try {
            $sql = "call s_u_variable_estudio(?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iVar_IdVariable, PDO::PARAM_INT);
            $result->bindParam(2, $iVar_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iVar_Abreviatura, PDO::PARAM_STR);
            $result->bindParam(4, $iVar_Medida, PDO::PARAM_STR);
            $result->bindParam(5, $iVar_Estado, PDO::PARAM_INT);
            $result->bindParam(6, $iTiv_IdTipoVariable, PDO::PARAM_INT);
            $result->bindParam(7, $iVar_DescripcionMedida, PDO::PARAM_STR);
            

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("subcategoriaecaModel", "actualizarvariablesestudio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarEstadovariablesestudio($iVar_IdVariable, $iVar_Estado) {

        try {
            $sql = "call s_u_estado_variable_estudio(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iVar_IdVariable, PDO::PARAM_INT);
            $result->bindParam(2, $iVar_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function eliminarvariablesestudio($iVar_IdVariable) {

        try {
            $sql = "call s_d_variable_estudio(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iVar_IdVariable, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

}
