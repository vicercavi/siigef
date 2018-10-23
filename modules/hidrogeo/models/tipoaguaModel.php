<?php

class tipoaguaModel extends Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getTipoaguas($condicion = '') 
    {
        try 
        {
            $tipoaguas = $this->_db->query(
                    "select t.* from tipo_agua t  $condicion"
            );
            return $tipoaguas->fetchAll();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(tipoaguaModel)", "getTipoaguas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getTipoagua($id) 
    {
        try 
        {
            $sql = "call s_s_tipo_agua(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        }
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(tipoaguaModel)", "getTipoagua", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function registrarTipoagua($iTia_Nombre, $iTia_Descripcion, $iTia_Color, $iTia_Estado) 
    {
        try 
        {
            $sql = "call s_i_tipo_agua(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTia_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iTia_Descripcion, PDO::PARAM_STR);
            $result->bindParam(3, $iTia_Color, PDO::PARAM_STR);
            $result->bindParam(4, $iTia_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(tipoaguaModel)", "registrarTipoagua", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarTipoagua($iTia_IdTipoAgua,$iTia_Nombre, $iTia_Descripcion, $iTia_Color, $iTia_Estado) 
    {        
        try 
        {
            $sql = "call s_u_tipo_agua(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTia_IdTipoAgua, PDO::PARAM_STR);
            $result->bindParam(2, $iTia_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iTia_Descripcion, PDO::PARAM_STR);
            $result->bindParam(4, $iTia_Color, PDO::PARAM_STR);
            $result->bindParam(5, $iTia_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(tipoaguaModel)", "actualizarTipoagua", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarEstadoTipoagua($iTia_IdTipoAgua, $iTia_Estado) 
    {
        try 
        {
            $sql = "call s_u_estado_tipo_agua(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTia_IdTipoAgua, PDO::PARAM_INT);
            $result->bindParam(2, $iTia_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(tipoaguaModel)", "actualizarEstadoTipoagua", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function eliminarTipoagua($iTia_IdTipoagua) 
    {
        try 
        {
            $sql = "call s_d_tipo_agua(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTia_IdTipoagua, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(tipoaguaModel)", "eliminarTipoagua", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

}
