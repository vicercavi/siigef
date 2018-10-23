<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tipovariableModel
 *
 * @author CHUJE
 */
class tipovariableModel extends Model {
    
     public function __construct()
    {
        parent::__construct();
    }
    public function getTipoVariables($condicion = '')
    {
        
       
        try{
            $cuencas = $this->_db->query(
                 "select * from tipo_variable $condicion"
            );           
            return $cuencas->fetchAll();            
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(tipovariableModel)", "getTipoVariables", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    public function getTipoVariable($id) {
        try {
            $sql = "call s_s_tipo_variable(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    public function registrarTipoVariable($iTiv_Nombre,$iTiv_Estado) {
        try {
            $sql = "call s_i_tipo_variable(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTiv_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iTiv_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("tipovariableModel", "registrarTipoVariable", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }   
    public function actualizarTipoVariable($iTiv_IdTipoVariable, $iTiv_Nombre,$iTiv_Estado) {
        try {
            $sql = "call s_u_tipo_variable(?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTiv_IdTipoVariable, PDO::PARAM_INT);
            $result->bindParam(2, $iTiv_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iTiv_Estado, PDO::PARAM_INT);
            

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("tipovariableModel", "actualizarTipoVariable", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstadoTipoVariable($iTiv_IdTipoVariable, $iTiv_Estado) {

        try {
            $sql = "call s_u_estado_tipo_variable(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTiv_IdTipoVariable, PDO::PARAM_INT);
            $result->bindParam(2, $iTiv_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    public function eliminarTipoVariable($iTiv_IdTipoVariable) {

        try {
            $sql = "call s_d_tipo_variable(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTiv_IdTipoVariable, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
}
