<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of estadoecaModel
 *
 * @author CHUJE
 */
class estadoecaModel extends Model {
    
     public function __construct()
    {
        parent::__construct();
    }
    public function getEstadoEcas($condicion = '')
    {
        
       
        try{
            $cuencas = $this->_db->query(
                 "select * from estado_eca $condicion"
            );           
            return $cuencas->fetchAll();            
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(estadoecaModel)", "getEstadoEcas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    public function getEstadoEca($id) {
        try {
            $sql = "call s_s_estado_eca(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    public function registrarEstadoEca($iese_refencia, $iese_nombre,$iese_color,$iese_estado) {
        try {
            $sql = "call s_i_estado_eca(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iese_refencia, PDO::PARAM_INT);
            $result->bindParam(2, $iese_nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iese_color, PDO::PARAM_STR);
            $result->bindParam(4, $iese_estado, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("estadoecaModel", "registrarEstadoEca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstadoEca($iese_IdEstadoEca,$iese_refencia, $iese_nombre,$iese_color,$iese_estado) {
        try {
            $sql = "call s_u_estado_eca(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iese_IdEstadoEca, PDO::PARAM_INT);
            $result->bindParam(2, $iese_refencia, PDO::PARAM_INT);
            $result->bindParam(3, $iese_nombre, PDO::PARAM_STR);
            $result->bindParam(4, $iese_color, PDO::PARAM_STR);
            $result->bindParam(5, $iese_estado, PDO::PARAM_INT);

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("estadoecaModel", "actualizarEstadoEca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstadoEstadoEca($iese_IdEstadoEca, $iese_estado) {

        try {
            $sql = "call s_u_estado_estado_eca(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iese_IdEstadoEca, PDO::PARAM_INT);
            $result->bindParam(2, $iese_estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    public function eliminarEstadoEca($iese_IdEstadoEca) {

        try {
            $sql = "call s_d_estado_eca(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iese_IdEstadoEca, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
}
