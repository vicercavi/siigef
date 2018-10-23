<?php

class subcuencaModel extends Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getSubcuencas($condicion = '') 
    {
        try 
        {
            $subcuencas = $this->_db->query(
                    "select s.*,c.Cue_Nombre from sub_cuenca s  left join cuenca c on s.Cue_IdCuenca = c.Cue_IdCuenca "
                    . "$condicion"
            );
            return $subcuencas->fetchAll();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(subcuencaModel)", "getSubcuencas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getSubcuenca($id) 
    {
        try 
        {
            $sql = "call s_s_sub_cuenca(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        }
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(subcuencaModel)", "getSubcuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function registrarSubcuenca($iSuc_Nombre, $iSuc_Estado, $iCue_IdCuenca) 
    {
        try 
        {
            $sql = "call s_i_sub_cuenca(?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iSuc_Nombre, PDO::PARAM_INT);
            $result->bindParam(2, $iSuc_Estado, PDO::PARAM_INT);
            $result->bindParam(3, $iCue_IdCuenca, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(subcuencaModel)", "registrarSubcuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarSubcuenca($iSuc_IdSubcuenca, $iSuc_Nombre, $iSuc_Estado, $iCue_IdCuenca) 
    {
        try 
        {
            $sql = "call s_u_sub_cuenca(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iSuc_IdSubcuenca, PDO::PARAM_INT);
            $result->bindParam(2, $iSuc_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iSuc_Estado, PDO::PARAM_INT);
            $result->bindParam(4, $iCue_IdCuenca, PDO::PARAM_INT);

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(subcuencaModel)", "actualizarSubcuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarEstadoSubcuenca($iSuc_IdSubcuenca, $iSuc_Estado) 
    {
        try 
        {
            $sql = "call s_u_estado_sub_cuenca(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iSuc_IdSubcuenca, PDO::PARAM_INT);
            $result->bindParam(2, $iSuc_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(subcuencaModel)", "actualizarEstadoSubcuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function eliminarSubcuenca($iSuc_IdSubcuenca) 
    {
        try 
        {
            $sql = "call s_d_sub_cuenca(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iSuc_IdSubcuenca, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(subcuencaModel)", "eliminarSubcuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function getCuencas()
    {
        try
        {
            $paises = $this->_db->query("SELECT * FROM cuenca");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(subcuencaModel)", "getCuencas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    

}
