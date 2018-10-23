<?php

class entidadModel extends Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function getEntidades($condicion = '')
    {
       
        try{
            $entidads = $this->_db->query(
                 "select e.* from entidad e  $condicion"
            );           
            return $entidads->fetchAll();            
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(entidadModel)", "getEntidades", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    public function getEntidad($id) {
        try {
            $sql = "call s_s_entidad(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    public function registrarEntidad($iEnt_Nombre, $iEnt_Siglas,$iEnt_Estado) {
        try {
            $sql = "call s_i_entidad(?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEnt_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iEnt_Siglas, PDO::PARAM_STR);
            $result->bindParam(3, $iEnt_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("entidadModel", "registrarEntidad", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEntidad($iEnt_IdEntidad,$iEnt_Nombre, $iEnt_Siglas,$iEnt_Estado) {
        try {
            $sql = "call s_u_entidad(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEnt_IdEntidad, PDO::PARAM_STR);
            $result->bindParam(2, $iEnt_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iEnt_Siglas, PDO::PARAM_STR);
            $result->bindParam(4, $iEnt_Estado, PDO::PARAM_INT);


            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("entidadModel", "actualizarEntidad", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstadoEntidad($iEnt_IdEntidad, $iEnt_Estado) {

        try {
            $sql = "call s_u_estado_entidad(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEnt_IdEntidad, PDO::PARAM_INT);
            $result->bindParam(2, $iEnt_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    public function eliminarEntidad($iEnt_IdEntidad) {

        try {
            $sql = "call s_d_entidad(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEnt_IdEntidad, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
}
