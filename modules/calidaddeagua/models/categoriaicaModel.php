<?php

class categoriaicaModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getCategoriaIcas($condicion = '') {

        try {
            $categoriaicas = $this->_db->query(
                    "select c.* from categoria_ica c  $condicion"
            );
            return $categoriaicas->fetchAll();
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(categoriaicaModel)", "getCategoriaIcas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getCategoriaIca($id) {
        try {
            $sql = "call s_s_categoria_ica(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function registrarCategoriaIca($iCai_Nombre, $iCai_Descripcion, $iCai_Fuente, $iCai_Estado) {
        try {
            $sql = "call s_i_categoria_ica(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCai_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iCai_Descripcion, PDO::PARAM_STR);
            $result->bindParam(3, $iCai_Fuente, PDO::PARAM_STR);
            $result->bindParam(4, $iCai_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("categoriaicaModel", "registrarCategoriaIca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarCategoriaIca($iCai_IdCategoriaIca, $iCai_Nombre, $iCai_Descripcion, $iCai_Fuente, $iCai_Estado) {
        try {
            $sql = "call s_u_categoria_ica(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCai_IdCategoriaIca, PDO::PARAM_INT);
            $result->bindParam(2, $iCai_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iCai_Descripcion, PDO::PARAM_STR);
            $result->bindParam(4, $iCai_Fuente, PDO::PARAM_STR);
            $result->bindParam(5, $iCai_Estado, PDO::PARAM_INT);


            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("categoriaicaModel", "actualizarCategoriaIca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarEstadoCategoriaIca($iCai_IdCategoriaIca, $iCai_Estado) {

        try {
            $sql = "call s_u_estado_categoria_ica(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCai_IdCategoriaIca, PDO::PARAM_INT);
            $result->bindParam(2, $iCai_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function eliminarCategoriaIca($iCai_IdCategoriaIca) {

        try {
            $sql = "call s_d_categoria_ica(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCai_IdCategoriaIca, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

}
