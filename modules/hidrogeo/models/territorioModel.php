<?php

class territorioModel extends Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getTerritorios($condicion = '') 
    {
        try 
        {
            $territorio = $this->_db->query(
                    "select t.*,p.Pai_Nombre,d.Det_Nombre from territorio t left join pais p" .
                    " on t.Pai_IdPais = p.Pai_IdPais left join denominacion_territorio d "
                    . " on t.Det_IdDenomTerrit = d.Det_IdDenomTerrit"
                    . " $condicion"
            );
            return $territorio->fetchAll();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(territorioModel)", "getTerritorios", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getTerritorio($id) 
    {
        try 
        {
            $sql = "call s_s_territorio(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(territorioModel)", "getTerritorio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function registrarTerritorio($iPai_IdPais, $iDet_IdDenomTerrit, $iTer_Nombre, $iTer_Siglas, $iTer_Estado) 
    {
        try 
        {
            $sql = "call s_i_territorio(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iPai_IdPais, PDO::PARAM_STR);
            $result->bindParam(2, $iDet_IdDenomTerrit, PDO::PARAM_INT);
            $result->bindParam(3, $iTer_Nombre, PDO::PARAM_INT);
            $result->bindParam(4, $iTer_Siglas, PDO::PARAM_INT);
            $result->bindParam(5, $iTer_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(territorioModel)", "registrarTerritorio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarTerritorio($iTer_IdTerritorio, $iPai_IdPais, $iDet_IdDenomTerrit, $iTer_Nombre, $iTer_Siglas, $iTer_Estado) 
    {
        try 
        {
            $sql = "call s_u_territorio(?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTer_IdTerritorio, PDO::PARAM_STR);
            $result->bindParam(2, $iPai_IdPais, PDO::PARAM_STR);
            $result->bindParam(3, $iDet_IdDenomTerrit, PDO::PARAM_INT);
            $result->bindParam(4, $iTer_Nombre, PDO::PARAM_INT);
            $result->bindParam(5, $iTer_Siglas, PDO::PARAM_INT);
            $result->bindParam(6, $iTer_Estado, PDO::PARAM_INT);


            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(territorioModel)", "actualizarTerritorio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getPaisTerritorio() 
    {
        try 
        {
            $paises = $this->_db->query(
                    "SELECT * FROM pais");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(territorioModel)", "getPaisTerritorio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getDenominacionTerritorio() 
    {
        try 
        {
            $paises = $this->_db->query(
                    "SELECT * FROM denominacion_territorio order by Det_Nivel");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(territorioModel)", "getDenominacionTerritorio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function getDenominacionTerritorioxPais($idpais) 
    {        
        try 
        {
            $denominacion = $this->_db->query(
                    "SELECT * FROM denominacion_territorio d where d.Pai_IdPais = $idpais order by Det_Nivel" );
            return $denominacion->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(territorioModel)", "getDenominacionTerritorioxPais", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarEstadoTerritorio($iTer_IdTerritorio, $iTer_Estado) 
    {
        try 
        {
            $sql = "call s_u_estado_territorio(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTer_IdTerritorio, PDO::PARAM_INT);
            $result->bindParam(2, $iTer_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(territorioModel)", "actualizarEstadoTerritorio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function eliminarTerritorio($iTer_IdTerritorio) 
    {
        try 
        {
            $sql = "call s_d_territorio(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iTer_IdTerritorio, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(territorioModel)", "eliminarTerritorio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

}
