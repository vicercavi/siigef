<?php

class cuencaModel extends Model 
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getCuencas($condicion = '')
    {       
        try
        {
            $cuencas = $this->_db->query(
                 "select c.* from cuenca c  $condicion"
            );           
            return $cuencas->fetchAll();            
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("monitoreo(cuancaModel)", "getCuencas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    public function getCuenca($id) 
    {
        try 
        {
            $sql = "call s_s_cuenca(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exception) 
        {
            $this->registrarBitacora("monitoreo(cuancaModel)", "getCuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function registrarCuenca($iCue_Nombre, $iCue_Estado) 
    {
        try 
        {
            $sql = "call s_i_cuenca(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCue_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iCue_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("cuencaModel", "registrarCuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarCuenca($iCue_IdCuenca,$iCue_Nombre, $iCue_Estado) 
    {
        try 
        {
            $sql = "call s_u_cuenca(?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCue_IdCuenca, PDO::PARAM_STR);
            $result->bindParam(2, $iCue_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iCue_Estado, PDO::PARAM_INT);


            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("cuencaModel", "actualizarCuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstadoCuenca($iCue_IdCuenca, $iCue_Estado) 
    {
        try 
        {
            $sql = "call s_u_estado_cuenca(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCue_IdCuenca, PDO::PARAM_INT);
            $result->bindParam(2, $iCue_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exception) 
        {
            $this->registrarBitacora("monitoreo(cuancaModel)", "actualizarEstadoCuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function eliminarCuenca($iCue_IdCuenca) 
    {
        try 
        {
            $sql = "call s_d_cuenca(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCue_IdCuenca, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (Exception $exception) 
        {
            $this->registrarBitacora("monitoreo(cuancaModel)", "eliminarCuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
}
