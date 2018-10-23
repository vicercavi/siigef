<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of estacionmonitoreoModel
 *
 * @author CHUJE
 */
class estacionmonitoreoModel extends Model {
    
     public function __construct()
    {
        parent::__construct();
    }
    public function getEstacionMonitoreos($condicion = '')
    {
        
       
        try{
            $cuencas = $this->_db->query(
                 "select em. *, rc.Ric_Nombre, tp.Tie_Nombre, mpd.Mpd_Nombre , ed.Esd_Nombre    from estacion_monitoreo em"
                 . "  left join rio_cuenca rc       on em.Ric_IdRioCuenca  = rc.Ric_IdRioCuenca"
                 . "  left join tipo_estacion   tp  on em.Tie_IdTipoEstacion  = tp.Tie_IdTipoEstacion"
                 . "  left join municipio_provincia_distrito mpd   on em.Mpd_IdMunicipioProvDist  = mpd.Mpd_IdMunicipioProvDist"
                 . "  left join estado_departamento ed  on  em.Esd_IdEstadoDepartamento = ed.Esd_IdEstadoDepartamento   $condicion"
            );           
            return $cuencas->fetchAll();            
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(estacionmonitoreoModel)", "getEstacionMonitoreos", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    public function getEstacionMonitoreo($id) {
        try {
            $sql = "call s_s_estacion_monitoreo(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    
     public function getTipoEstacion() {
        try {
            $paises = $this->_db->query(
                    "SELECT * FROM tipo_estacion");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(subcategoriaecaModel)", "getTipoEstacion", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
     public function getRioCuenca() {
        try {
            $paises = $this->_db->query(
                    "SELECT rc.*, concat(r.Rio_Nombre,' | ',sc.Suc_Nombre,' | ', c.Cue_Nombre) as rio from rio_cuenca rc inner join sub_cuenca sc on rc.Suc_IdSubcuenca=sc.Suc_IdSubcuenca
inner join cuenca c on rc.Cue_IdCuenca = c.Cue_IdCuenca inner join rio r on rc.Rio_IdRio = r.Rio_IdRio;");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(subcategoriaecaModel)", "getRioCuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    
    
     public function getMunicipio() {
        try {
            $paises = $this->_db->query(
                    "SELECT * FROM municipio_provincia_distrito");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(subcategoriaecaModel)", "getMunicipio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    
     public function getDepartamento() {
        try {
            $paises = $this->_db->query(
                    "SELECT * FROM estado_departamento");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(subcategoriaecaModel)", "getDepartamento", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
   public function registrarEstacionMonitoreo($iEsm_Nombre,$iEsm_Latitud,$iEsm_Longitud,
    $iEsm_Referencia,$iEsm_Altitud,$iEsm_Estado,$iRic_IdRioCuenca,$iTie_IdTipoEstacion, $iUbi_IdUbigeo) {

        try {
            $sql = "call s_i_estacion_monitoreo(?,?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsm_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iEsm_Longitud, PDO::PARAM_STR);
            $result->bindParam(3, $iEsm_Latitud, PDO::PARAM_STR);
            $result->bindParam(4, $iEsm_Referencia, PDO::PARAM_STR);
            $result->bindParam(5, $iEsm_Altitud, PDO::PARAM_INT);
            $result->bindParam(6, $iEsm_Estado, PDO::PARAM_STR);
            $result->bindParam(7, $iRic_IdRioCuenca, PDO::PARAM_INT);
            $result->bindParam(8, $iTie_IdTipoEstacion, PDO::PARAM_INT);
            $result->bindParam(9, $iUbi_IdUbigeo, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("estacionmonitoreoModel", "registrarEstacionMonitoreo", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstacionMonitoreo($iEsm_IdEstacionMonitoreo,$iEsm_Nombre,$iEsm_Latitud,$iEsm_Longitud,$iEsm_Referencia,$iEsm_Altitud,
            $iEsm_Estado,$iRic_IdRioCuenca,$iTie_IdTipoEstacion,$iUbi_IdUbigeo) {
        try {
            $sql = "call s_u_estacion_monitoreo(?,?,?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsm_IdEstacionMonitoreo, PDO::PARAM_INT);
            $result->bindParam(2, $iEsm_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iEsm_Longitud, PDO::PARAM_STR);
            $result->bindParam(4, $iEsm_Latitud, PDO::PARAM_STR);
            $result->bindParam(5, $iEsm_Referencia, PDO::PARAM_STR);
            $result->bindParam(6, $iEsm_Altitud, PDO::PARAM_INT);
            $result->bindParam(7, $iEsm_Estado, PDO::PARAM_STR);
            $result->bindParam(8, $iRic_IdRioCuenca, PDO::PARAM_INT);
            $result->bindParam(9, $iTie_IdTipoEstacion, PDO::PARAM_INT);
            $result->bindParam(10, $iUbi_IdUbigeo, PDO::PARAM_INT);
            
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("estacionmonitoreoModel", "actualizarEstacionMonitoreo", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstadoEstacionMonitoreo($iEsm_IdEstacionMonitoreo, $iEsm_Estado) {

        try {
            $sql = "call s_u_estado_estacion_monitoreo(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsm_IdEstacionMonitoreo, PDO::PARAM_INT);
            $result->bindParam(2, $iEsm_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    public function eliminarEstacionMonitoreo($iEsm_IdEstacionMonitoreo) {

        try {
            $sql = "call s_d_estacion_monitoreo(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsm_IdEstacionMonitoreo, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
}
