<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of historialcalidadaguaModel
 *
 * @author CHUJE
 */
class historialcalidadaguaModel extends Model {
    
     public function __construct()
    {
        parent::__construct();
    }
    public function getHistorialCalidadAguas($condicion = '')
    {
            
        try{
            $cuencas = $this->_db->query(
                 "  select  hca.*, em.Esm_Nombre,  ica.Ica_Descripcion  from historial_calidad_agua   hca  "
               . "  inner join estacion_monitoreo  em  on hca.Esm_IdEstacionMonitoreo = em.Esm_IdEstacionMonitoreo "
               . "  inner join indice_calidad_agua ica  on hca.Ica_IdIndiceCalidadAgua = ica.Ica_IdIndiceCalidadAgua  "
               . "  $condicion"
            );           
            return $cuencas->fetchAll();            
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(historialcalidadaguaModel)", "getHistorialCalidadAguas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    public function getHistorialCalidadAgua($id) {
        try {
            $sql = "call s_s_historial_calidad(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
   public function getEstacionMonitoreo()
    {
        
       
        try{
            $cuencas = $this->_db->query(
                 "select  * from estacion_monitoreo"
               
            );           
            return $cuencas->fetchAll();            
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(historialcalidadaguaModel)", "getEstacionMonitoreo", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    
    
       public function getIndiceCalidad()
    {
        
       
        try{
            $cuencas = $this->_db->query(
                 "select  * from indice_calidad_agua"
               
            );           
            return $cuencas->fetchAll();            
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(historialcalidadaguaModel)", "getIndiceCalidad", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    
    
    
    
    
    
    public function registrarHistorialCalidadAgua($iEsm_IdEstacionMonitoreo, $iIca_IdIndiceCalidadAgua,$iHca_Fecha,$iHca_Valor) {
        try {
            $sql = "call s_i_historial_calidad_agua(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsm_IdEstacionMonitoreo, PDO::PARAM_INT);
            $result->bindParam(2, $iIca_IdIndiceCalidadAgua, PDO::PARAM_INT);
            $result->bindParam(3, $iHca_Fecha, PDO::PARAM_STR);
            $result->bindParam(4, $iHca_Valor, PDO::PARAM_STR);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("historialcalidadaguaModel", "registrarHistorialCalidadAgua", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarHistorialCalidadAgua($iHca_IdHistorialCalAgu,$iEsm_IdEstacionMonitoreo, $iIca_IdIndiceCalidadAgua,$iHca_Fecha,$iHca_Valor) {
        try {
            $sql = "call s_u_historial_calidad_agua(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iHca_IdHistorialCalAgu, PDO::PARAM_INT);
             $result->bindParam(2, $iEsm_IdEstacionMonitoreo, PDO::PARAM_INT);
            $result->bindParam(3, $iIca_IdIndiceCalidadAgua, PDO::PARAM_INT);
            $result->bindParam(4, $iHca_Fecha, PDO::PARAM_STR);
            $result->bindParam(5, $iHca_Valor, PDO::PARAM_STR);

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("historialcalidadaguaModel", "actualizarHistorialCalidadAgua", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function eliminarHistorialCalidadAgua($iHca_IdHistorialCalAgu) {

        try {
            $sql = "call s_d_eliminar_calidad_agua(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iHca_IdHistorialCalAgu, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
}

