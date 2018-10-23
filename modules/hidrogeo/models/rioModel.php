<?php

class rioModel extends Model 
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getRios($condicion = '')
    {       
        try
        {
            $rios = $this->_db->query(
                 "select r.*,p.Pai_Nombre, t.Tia_Nombre from rio r left join pais p".
                    " on r.Pai_IdPais = p.Pai_IdPais left join tipo_agua t".
                    " on r.Tia_IdTipoAgua = t.Tia_IdTipoAgua  $condicion"
            );           
            return $rios->fetchAll();            
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("monitoreo(rioModel)", "getRios", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }

    public function getRio($id) 
    {
        try 
        {
            $sql = "call s_s_rio(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exception) 
        {
            $this->registrarBitacora("monitoreo(rioModel)", "getRio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function registrarRio($iRio_Nombre, $iRio_Estado, $iPai_IdPais, $iTia_IdTipoAgua) 
    {
        try 
        {
            $sql = "call s_i_rio(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRio_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iRio_Estado, PDO::PARAM_INT);
            $result->bindParam(3, $iPai_IdPais, PDO::PARAM_INT);
            $result->bindParam(4, $iTia_IdTipoAgua, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("rioModel", "registrarRio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarRio($iRio_IdRio, $iRio_Nombre, $iRio_Estado, $iPai_IdPais, $iTia_IdTipoAgua) 
    {
        try 
        {
            $sql = "call s_u_rio(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRio_IdRio, PDO::PARAM_INT);
            $result->bindParam(2, $iRio_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iRio_Estado, PDO::PARAM_INT);
            $result->bindParam(4, $iPai_IdPais, PDO::PARAM_INT);
            $result->bindParam(5, $iTia_IdTipoAgua, PDO::PARAM_INT);

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("rioModel", "actualizarRio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function getTipoAgua()
    {
        try
        {
            $tipos_agua = $this->_db->query("SELECT * FROM tipo_agua" );

            return $tipos_agua->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("monitoreo(rioModel)", "getTipoAgua", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function getPaisRio()
    {
        try
        {
            $paises = $this->_db->query(
                "SELECT * FROM pais" );
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("monitoreo(rioModel)", "getPais", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstadoRio($iRio_IdRio, $iRio_Estado) 
    {
        try 
        {
            $sql = "call s_u_estado_rio(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRio_IdRio, PDO::PARAM_INT);
            $result->bindParam(2, $iRio_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exception) 
        {
            $this->registrarBitacora("monitoreo(rioModel)", "actualizarEstadoRio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function eliminarRio($iRio_IdRio) 
    {
        try 
        {
            $sql = "call s_d_rio(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRio_IdRio, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (Exception $exception) 
        {
            $this->registrarBitacora("monitoreo(rioModel)", "eliminarRio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
}
