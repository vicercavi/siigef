<?php

class denominacionterritorioModel extends Model 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDenominacionTerritorios($condicion = '')
    {       
        try
        {
            $denominacionterritorio = $this->_db->query(
                 "select d.*,p.Pai_Nombre from denominacion_territorio d left join pais p".
                    " on d.Pai_IdPais = p.Pai_IdPais $condicion order by p.Pai_IdPais,d.Det_Nivel"
            );           
            return $denominacionterritorio->fetchAll();            
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(denominacionterritorioModel)", "getDenominacionTerritorios", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }

    public function getDenominacionTerritorio($id) 
    {
        try 
        {
            $sql = "call s_s_denominacion_territorio(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(denominacionterritorioModel)", "getDenominacionTerritorio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function registrarDenominacionTerritorio($iDet_Nombre, $iDet_Nivel, $iPai_IdPais, $iDet_Estado) 
    {
        try 
        {
            $sql = "call s_i_denominacion_territorio(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iDet_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iDet_Nivel, PDO::PARAM_INT);
            $result->bindParam(3, $iPai_IdPais, PDO::PARAM_INT);
            $result->bindParam(4, $iDet_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(denominacionterritorioModel)", "registrarDenominacionTerritorio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarDenominacionTerritorio($iDet_IdDenomTerrit,$iDet_Nombre, $iDet_Nivel, $iPai_IdPais, $iDet_Estado) 
    {
        try 
        {
            $sql = "call s_u_denominacion_territorio(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iDet_IdDenomTerrit, PDO::PARAM_INT);
            $result->bindParam(2, $iDet_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iDet_Nivel, PDO::PARAM_INT);
            $result->bindParam(4, $iPai_IdPais, PDO::PARAM_INT);
            $result->bindParam(5, $iDet_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(denominacionterritorioModel)", "actualizarDenominacionTerritorio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function getPaisDenominacionTerritorio()
    {
        try
        {
            $paises = $this->_db->query(
                "SELECT * FROM pais" );
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(denominacionterritorioModel)", "getPaisDenominacionTerritorio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstadoDenominacionTerritorio($iDet_IdDenomTerrit, $iDet_Estado) 
    {
        try 
        {
            $sql = "call s_u_estado_denominacion_territorio(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iDet_IdDenomTerrit, PDO::PARAM_INT);
            $result->bindParam(2, $iDet_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        }
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(denominacionterritorioModel)", "actualizarEstadoDenominacionTerritorio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
    public function eliminarDenominacionTerritorio($iDet_IdDenomTerrit) 
    {
        try 
        {
            $sql = "call s_d_denominacion_territorio(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iDet_IdDenomTerrit, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("hidrogeo(denominacionterritorioModel)", "eliminarDenominacionTerritorio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    
}
