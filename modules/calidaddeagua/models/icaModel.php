<?php

class icaModel extends Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function getIcas($condicion = '')
    {
       
        try{
            $icas = $this->_db->query(
                 "select i.* from ica i  $condicion"
            );           
            return $icas->fetchAll();            
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(icaModel)", "getIcas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    public function getIca($id) {
        try {
            $sql = "call s_s_ica(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    public function registrarIca($iIca_Nombre, $iIca_Descripcion,$iIca_Estado) {
        try {
            $sql = "call s_i_ica(?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iIca_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iIca_Descripcion, PDO::PARAM_STR);
            $result->bindParam(3, $iIca_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("icaModel", "registrarIca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarIca($iIca_IdIca,$iIca_Nombre, $iIca_Descripcion,$iIca_Estado) {
        try {
            $sql = "call s_u_ica(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iIca_IdIca, PDO::PARAM_INT);
            $result->bindParam(2, $iIca_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iIca_Descripcion, PDO::PARAM_STR);
            $result->bindParam(4, $iIca_Estado, PDO::PARAM_INT);


            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("icaModel", "actualizarIca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstadoIca($iIca_IdIca, $iIca_Estado) {

        try {
            $sql = "call s_u_estado_ica(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iIca_IdIca, PDO::PARAM_INT);
            $result->bindParam(2, $iIca_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    public function eliminarIca($iIca_IdIca) {

        try {
            $sql = "call s_d_ica(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iIca_IdIca, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
}
