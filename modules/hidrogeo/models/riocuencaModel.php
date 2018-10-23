<?php

class riocuencaModel extends Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getRiocuencas($condicion = '') 
    {
        try 
        {
            $riocuencas = $this->_db->query(
                    "select rc.*,s.Suc_Nombre,c.Cue_Nombre,r.Rio_Nombre from rio_cuenca rc  left join sub_cuenca s on rc.Suc_IdSubcuenca = s.Suc_IdSubcuenca left join cuenca c "
                    . " on rc.Cue_IdCuenca = c.Cue_IdCuenca left join rio r on rc.Rio_IdRio = r.Rio_IdRio "
                    . "$condicion"
            );
            return $riocuencas->fetchAll();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(riocuencaModel)", "getRiocuencas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getRiocuenca($id) 
    {
        try 
        {
            $sql = "call s_s_rio_cuenca(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(riocuencaModel)", "getRiocuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function registrarRiocuenca($iRic_Nombre, $iRic_Estado, $iSuc_IdSubcuenca, $iCue_IdCuenca, $iRio_IdRio) 
    {
        try 
        {
            $sql = "call s_i_rio_cuenca(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRic_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iRic_Estado, PDO::PARAM_INT);
            $result->bindParam(3, $iSuc_IdSubcuenca, PDO::PARAM_INT);
            $result->bindParam(4, $iCue_IdCuenca, PDO::PARAM_INT);
            $result->bindParam(5, $iRio_IdRio, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(riocuencaModel)", "registrarRiocuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarRiocuenca($iRic_IdRioCuenca, $iRic_Nombre, $iRic_Estado, $iSuc_IdSubcuenca, $iCue_IdCuenca, $iRio_IdRio) 
    {
        try 
        {
            $sql = "call s_u_rio_cuenca(?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRic_IdRioCuenca, PDO::PARAM_INT);
            $result->bindParam(2, $iRic_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iRic_Estado, PDO::PARAM_INT);
            $result->bindParam(4, $iSuc_IdSubcuenca, PDO::PARAM_INT);
            $result->bindParam(5, $iCue_IdCuenca, PDO::PARAM_INT);
            $result->bindParam(6, $iRio_IdRio, PDO::PARAM_INT);

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(riocuencaModel)", "actualizarRiocuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarEstadoRiocuenca($iRic_IdRioCuenca, $iRic_Estado) 
    {
        try 
        {
            $sql = "call s_u_estado_rio_cuenca(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRic_IdRioCuenca, PDO::PARAM_INT);
            $result->bindParam(2, $iRic_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(riocuencaModel)", "actualizarEstadoRiocuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function eliminarRiocuenca($iSuc_IdRioCuenca) 
    {
        try 
        {
            $sql = "call s_d_rio_cuenca(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iSuc_IdRioCuenca, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(riocuencaModel)", "eliminarRiocuenca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getSubcuencas($condicion) 
    {
        try 
        {
            $subcuencas = $this->_db->query(
                    "SELECT * FROM sub_cuenca $condicion");
            return $subcuencas->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(riocuencaModel)", "getSubcuencas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getCuencas($condicion) 
    {
        try 
        {
            $cuencas = $this->_db->query("SELECT * FROM cuenca $condicion");
            return $cuencas->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(riocuencaModel)", "getCuencas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getRios($condicion) 
    {
        try 
        {
            $rios = $this->_db->query("SELECT * FROM rio $condicion");
            return $rios->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(riocuencaModel)", "getRios", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }


}
