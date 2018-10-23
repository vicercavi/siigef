<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tipoestacionModel
 *
 * @author CHUJE
 */
class tipoestacionModel extends Model {
    
     public function __construct()
    {
        parent::__construct();
    }
    public function getTipoEstaciones($condicion = '')
    {
        try{
            $cuencas = $this->_db->query(
                 "select * from tipo_estacion te $condicion"
            );           
            return $cuencas->fetchAll();            
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(tipoestacionModel)", "getTipoEstaciones", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    public function getTipoEstacion($id) {
        try {
            $sql = "call s_s_tipo_estacion(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    public function registrarTipoEstacion($iTie_Nombre,$iTie_Estado) {
        try {
            $sql = "call s_i_tipo_estacion(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTie_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iTie_Estado, PDO::PARAM_STR);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("tipoestacionModel", "registrarTipoEstacion", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarTipoEstacion($iTie_IdTipoEstacion,$iTie_Nombre, $iTie_Estado) {
        try {
            $sql = "call s_u_tipo_estacion(?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTie_IdTipoEstacion, PDO::PARAM_INT);
            $result->bindParam(2, $iTie_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iTie_Estado, PDO::PARAM_INT);
            
           

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("tipoestacionModel", "actualizarTipoEstacion", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstadoTipoEstacion($iTie_IdTipoEstacion, $iTie_Estado) {

        try {
            $sql = "call s_u_estado_tipo_estacion(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTie_IdTipoEstacion, PDO::PARAM_INT);
            $result->bindParam(2, $iTie_Estado, PDO::PARAM_STR);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    public function eliminarTipoEstacion($iTie_IdTipoEstacion) {

        try {
            $sql = "call s_d_tipo_estacion(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTie_IdTipoEstacion, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
}

