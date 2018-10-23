<?php

class estadodepartamentoModel extends Model {
    public function __construct()
    {
        parent::__construct();
    }
    public function getEstadoDepartamentos($condicion = '')
    {
       
        try{
            $estadodepartamento = $this->_db->query(
                 "select e.*,p.Pai_Nombre from estado_departamento e left join pais p".
                    " on e.Pai_IdPais = p.Pai_IdPais $condicion"
            );           
            return $estadodepartamento->fetchAll();            
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(estadodepartamentoModel)", "getEstadoDepartamentos", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    public function getEstadoDepartamento($id) {
        try {
            $sql = "call s_s_estado(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    public function registrarEstadoDepartamento($iEsd_Nombre, $iEsd_Siglas, $iPai_IdPais, $iEsd_Estado,$iEsd_Denominacion) {
        try {
            $sql = "call s_i_estado(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsd_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iEsd_Siglas, PDO::PARAM_STR);
            $result->bindParam(3, $iPai_IdPais, PDO::PARAM_INT);
            $result->bindParam(4, $iEsd_Estado, PDO::PARAM_INT);
            $result->bindParam(5, $iEsd_Denominacion, PDO::PARAM_STR);


            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("estadodepartamentoModel", "registrarEstadoDepartamento", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstadoDepartamento($iEsd_IdEstadoDepartamento,$iEsd_Nombre, $iEsd_Siglas, $iPai_IdPais, $iEsd_Estado,$iEsd_Denominacion) {
        try {
            $sql = "call s_u_estado(?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsd_IdEstadoDepartamento, PDO::PARAM_INT);
            $result->bindParam(2, $iEsd_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iEsd_Siglas, PDO::PARAM_STR);
            $result->bindParam(4, $iPai_IdPais, PDO::PARAM_INT);
            $result->bindParam(5, $iEsd_Estado, PDO::PARAM_INT);
            $result->bindParam(6, $iEsd_Denominacion, PDO::PARAM_STR);


            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("estadodepartamentoModel", "actualizarEstadoDepartamento", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function getPaisEstadoDepartamento()
    {
        try{
            $paises = $this->_db->query(
                "SELECT * FROM pais" );
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(estadodepartamentoModel)", "getPaisEstadoDepartamento", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstadoEstadoDepartamento($iEsd_IdEstadoDepartamento, $iEsd_Estado) {

        try {
            $sql = "call s_u_estado_estado(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsd_IdEstadoDepartamento, PDO::PARAM_INT);
            $result->bindParam(2, $iEsd_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    public function eliminarEstadoDepartamento($iEsd_IdEstadoDepartamento) {

        try {
            $sql = "call s_d_estado(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsd_IdEstadoDepartamento, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
}
