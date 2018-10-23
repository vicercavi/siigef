<?php

class paisModel extends Model 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPaises($condicion = '')
    {       
        try
        {
            $paiss = $this->_db->query(
                 "select p.* from pais p  $condicion"
            );           
            return $paiss->fetchAll();            
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(paisModel)", "getPaises", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    public function getPais($id) 
    {
        try 
        {
            $sql = "call s_s_pais(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(paisModel)", "getPais", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function registrarPais($iPai_Nombre, $iPai_Siglas,$iPai_Estado) 
    {
        try 
        {
            $sql = "call s_i_pais(?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iPai_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iPai_Siglas, PDO::PARAM_STR);
            $result->bindParam(3, $iPai_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(paisModel)", "registrarPais", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarPais($iPai_IdPais,$iPai_Nombre, $iPai_Siglas,$iPai_Estado) 
    {
        try 
        {
            $sql = "call s_u_pais(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iPai_IdPais, PDO::PARAM_STR);
            $result->bindParam(2, $iPai_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iPai_Siglas, PDO::PARAM_STR);
            $result->bindParam(4, $iPai_Estado, PDO::PARAM_INT);


            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(paisModel)", "actualizarPais", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarEstadoPais($iPai_IdPais, $iPai_Estado) 
    {
        try 
        {
            $sql = "call s_u_estado_pais(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iPai_IdPais, PDO::PARAM_INT);
            $result->bindParam(2, $iPai_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(paisModel)", "actualizarEstadoPais", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function eliminarPais($iPai_IdPais) 
    {
        try 
        {
            $sql = "call s_d_pais(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iPai_IdPais, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(paisModel)", "eliminarPais", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
}
