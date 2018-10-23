<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of estandarcalidadaguaModel
 *
 * @author CHUJE
 */
class estandarcalidadaguaModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getEstandarAguas($condicion = '') {

        try {
            $cuencas = $this->_db->query(
                    "select ecaa.*,sce.Sue_Nombre, ee.ese_nombre, ves.Var_Nombre from estandar_calidad_ambiental_agua ecaa "
                    . " left join sub_categoria_eca sce on ecaa.sue_idSubcategoriaEca = sce.sue_idSubcategoriaEca"
                    . " left join estado_eca ee on ecaa.ese_IdEstadoEca  = ee.ese_IdEstadoEca"
                    . " left join variables_estudio ves on ecaa.Var_IdVariable = ves.Var_IdVariable $condicion  "
            );
            return $cuencas->fetchAll();
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(estandarcalidadaguaModel)", "getEstandarAguas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getSubCategoriaEcas() {
        try {
            $paises = $this->_db->query(
                    "SELECT * FROM sub_categoria_eca");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(estandarcalidadaguaModel)", "getSubCategoriaEca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    
     public function getVariablesEstudio() {
        try {
            $paises = $this->_db->query(
                    "SELECT * FROM variables_estudio");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(estandarcalidadaguaModel)", "getVariablesEstudio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    
    
     public function getEstadoEcas() {
        try {
            $paises = $this->_db->query(
                    "SELECT * FROM estado_eca");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(estandarcalidadaguaModel)", "getEstadoEcas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }


    

    public function getEstandarAgua($id) {
        try {
            $sql = "call s_s_estandar_agua(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    
    public function registrarEstandarAgua($isue_idSubcategoriaEca, $iVar_IdVariable,
            $ieca_signo, $ieca_minimo,$ieca_maximo,$ieca_estado,$iese_IdEstadoEca) {
        try {
            $sql = "call s_i_estandar_agua(?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $isue_idSubcategoriaEca, PDO::PARAM_INT);
            $result->bindParam(2, $iVar_IdVariable, PDO::PARAM_INT);
            $result->bindParam(3, $ieca_signo, PDO::PARAM_STR);
            $result->bindParam(4, $ieca_minimo, PDO::PARAM_INT);
            $result->bindParam(5, $ieca_maximo, PDO::PARAM_INT);
            $result->bindParam(6, $ieca_estado, PDO::PARAM_INT);
            $result->bindParam(7, $iese_IdEstadoEca, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("estandarcalidadaguaModel", "registrarEstandarAgua", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarEstandarAgua($ieca_idEstandarCalidadAmbientalAgua,$isue_idSubcategoriaEca, $iVar_IdVariable,
            $ieca_signo, $ieca_minimo,$ieca_maximo,$ieca_estado,$iese_IdEstadoEca) {
        try {
            $sql = "call s_u_estandar_agua(?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $ieca_idEstandarCalidadAmbientalAgua, PDO::PARAM_INT);
            $result->bindParam(2, $isue_idSubcategoriaEca, PDO::PARAM_INT);
            $result->bindParam(3, $iVar_IdVariable, PDO::PARAM_INT);
            $result->bindParam(4, $ieca_signo, PDO::PARAM_STR);
            $result->bindParam(5, $ieca_minimo, PDO::PARAM_INT);
            $result->bindParam(6, $ieca_maximo, PDO::PARAM_INT);
            $result->bindParam(7, $ieca_estado, PDO::PARAM_INT);
            $result->bindParam(8, $iese_IdEstadoEca, PDO::PARAM_INT);

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("estandarcalidadaguaModel", "actualizarEstandarAgua", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarEstadoEstandarAgua($ieca_idEstandarCalidadAmbientalAgua, $ieca_estado) {

        try {
            $sql = "call s_u_estado_estandar_agua(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $ieca_idEstandarCalidadAmbientalAgua, PDO::PARAM_INT);
            $result->bindParam(2, $ieca_estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function eliminarEstandarAgua($ieca_idEstandarCalidadAmbientalAgua) {

        try {
            $sql = "call s_d_estandar_agua(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $ieca_idEstandarCalidadAmbientalAgua, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

}
