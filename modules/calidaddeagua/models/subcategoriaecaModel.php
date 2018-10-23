<?php

class subcategoriaecaModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getSubCategoriaEcas($condicion = '') {

        try {
            $cuencas = $this->_db->query(
                    "select s.*,c.Cae_Nombre from sub_categoria_eca s inner join "
                    . " categoria_eca c on s.Cae_IdCategoriaEca = c.Cae_IdCategoriaEca $condicion  "
            );
            return $cuencas->fetchAll();
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(subcategoriaecaModel)", "getSubCategoriaEcas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getCategoriaEca() {
        try {
            $paises = $this->_db->query(
                    "SELECT * FROM categoria_eca");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(subcategoriaecaModel)", "getCategoriaEca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getSubCategoriaEca($id) {
        try {
            $sql = "call s_s_sub_categoria_eca(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function registrarSubCategoriaEca($iCae_IdCategoriaEca, $iSue_Nombre, $iSue_Descripcion, $iSue_Estado) {
        try {
            $sql = "call s_i_sub_categoria_eca(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCae_IdCategoriaEca, PDO::PARAM_INT);
            $result->bindParam(2, $iSue_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iSue_Descripcion, PDO::PARAM_STR);
            $result->bindParam(4, $iSue_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("subcategoriaecaModel", "registrarSubCategoriaEca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarSubCategoriaEca($iSue_IdSubcategoriaEca, $iCae_IdCategoriaEca, $iSue_Nombre, $iSue_Descripcion, $iSue_Estado) {
        try {
            $sql = "call s_u_sub_categoria_eca(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iSue_IdSubcategoriaEca, PDO::PARAM_INT);
            $result->bindParam(2, $iCae_IdCategoriaEca, PDO::PARAM_INT);
            $result->bindParam(3, $iSue_Nombre, PDO::PARAM_STR);
            $result->bindParam(4, $iSue_Descripcion, PDO::PARAM_STR);
            $result->bindParam(5, $iSue_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("subcategoriaecaModel", "actualizarSubCategoriaEca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarEstadoSubCategoriaEca($iSue_IdSubcategoriaEca, $iSue_Estado) {

        try {
            $sql = "call s_u_estado_sub_categoria_eca(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iSue_IdSubcategoriaEca, PDO::PARAM_INT);
            $result->bindParam(2, $iSue_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function eliminarSubCategoriaEca($iSue_IdSubcategoriaEca) {

        try {
            $sql = "call s_d_sub_categoria_eca(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iSue_IdSubcategoriaEca, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

}
