<?php

class ubigeoModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getUbigeos($condicion = '') {

        try {
            $ubigeo = $this->_db->query(
                    "select * from (SELECT  u.* ,p.Pai_Nombre "
                    . " ,(select t.Ter_Nombre from territorio t where t.Ter_IdTerritorio = u.Ter_IdTerritorio1) as t1 "
                    . " ,(select t.Ter_Nombre from territorio t where t.Ter_IdTerritorio = u.Ter_IdTerritorio2) as t2 "
                    . " ,(select t.Ter_Nombre from territorio t where t.Ter_IdTerritorio = u.Ter_IdTerritorio3) as t3 "
                    . " ,(select t.Ter_Nombre from territorio t where t.Ter_IdTerritorio = u.Ter_IdTerritorio4) as t4 "
                    . " FROM ubigeo u inner join pais p on u.Pai_IdPais = p.Pai_IdPais) as temp"
                    . " $condicion"
            );
            return $ubigeo->fetchAll();
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ubigeoModel)", "getUbigeo", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getUbigeo($id) {
        try {
            $sql = "call s_s_ubigeo(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function registrarUbigeo($iPai_IdPais, $iTer_IdTerritorio1, $iTer_IdTerritorio2, $iTer_IdTerritorio3, $iTer_IdTerritorio4, $iUbi_Estado) {
        try {
            $sql = "call s_i_ubigeo(?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iPai_IdPais, PDO::PARAM_INT);
            $result->bindParam(2, $iTer_IdTerritorio1, PDO::PARAM_INT);
            $result->bindParam(3, $iTer_IdTerritorio2, PDO::PARAM_INT);
            $result->bindParam(4, $iTer_IdTerritorio3, PDO::PARAM_INT);
            $result->bindParam(5, $iTer_IdTerritorio4, PDO::PARAM_INT);
            $result->bindParam(6, $iUbi_Estado, PDO::PARAM_INT);


            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("ubigeoModel", "registrarUbigeo", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarUbigeo($iUbi_IdUbigeo, $iPai_IdPais, $iTer_IdTerritorio1, $iTer_IdTerritorio2, $iTer_IdTerritorio3, $iTer_IdTerritorio4, $iUbi_Estado) {
        try {
            $sql = "call s_u_ubigeo(?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iUbi_IdUbigeo, PDO::PARAM_INT);
            $result->bindParam(2, $iPai_IdPais, PDO::PARAM_INT);
            $result->bindParam(3, $iTer_IdTerritorio1, PDO::PARAM_INT);
            $result->bindParam(4, $iTer_IdTerritorio2, PDO::PARAM_INT);
            $result->bindParam(5, $iTer_IdTerritorio3, PDO::PARAM_INT);
            $result->bindParam(6, $iTer_IdTerritorio4, PDO::PARAM_INT);
            $result->bindParam(7, $iUbi_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("ubigeoModel", "actualizarUbigeo", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getPaisUbigeo() {
        try {
            $paises = $this->_db->query(
                    "SELECT * FROM pais");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ubigeoModel)", "getPaisUbigeo", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getDenominacionTerritorioxPais($idpais) {

        try {
            $denominacion = $this->_db->query(
                    "SELECT * FROM denominacion_territorio d where d.Pai_IdPais = $idpais order by Det_Nivel");
            return $denominacion->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ubigeoModel)", "getDenominacionTerritorioxPais", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getTerritorios1($idpais) {

        try {
            $denominacion = $this->_db->query(
                    "SELECT t.* FROM territorio t left join denominacion_territorio d on t.Det_IdDenomTerrit = d.Det_IdDenomTerrit "
                    . "where d.Det_Nivel = 1 and t.Pai_IdPais = $idpais");
            return $denominacion->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ubigeoModel)", "getTerritorios1", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getTerritorios2($idpais) {

        try {
            $denominacion = $this->_db->query(
                    "SELECT t.* FROM territorio t left join denominacion_territorio d on t.Det_IdDenomTerrit = d.Det_IdDenomTerrit "
                    . "where d.Det_Nivel = 2 and t.Pai_IdPais = $idpais");
            return $denominacion->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ubigeoModel)", "getTerritorios2", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function getTerritorios3($idpais) {

        try {
            $denominacion = $this->_db->query(
                    "SELECT t.* FROM territorio t left join denominacion_territorio d on t.Det_IdDenomTerrit = d.Det_IdDenomTerrit "
                    . "where d.Det_Nivel = 3 and t.Pai_IdPais = $idpais");
            return $denominacion->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ubigeoModel)", "getTerritorios3", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function getTerritorios4($idpais) {

        try {
            $denominacion = $this->_db->query(
                    "SELECT t.* FROM territorio t left join denominacion_territorio d on t.Det_IdDenomTerrit = d.Det_IdDenomTerrit "
                    . "where d.Det_Nivel = 4 and t.Pai_IdPais = $idpais");
            return $denominacion->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ubigeoModel)", "getTerritorios4", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getTerritorios1xIdUbigeo($id_ubigeo)
    {
        try {
            $consulta = $this->_db->query(
                    "SELECT * FROM ubigeo u INNER JOIN territorio t ON u.Ter_IdTerritorio1=t.Ter_IdTerritorio WHERE Ubi_IdUbigeo=$id_ubigeo ");
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ubigeoModel)", "getTerritorios1xIdUbigeo", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function getTerritorios2xIdUbigeo($id_ubigeo)
    {
        try {
            $consulta = $this->_db->query(
                    "SELECT * FROM ubigeo u INNER JOIN territorio t ON u.Ter_IdTerritorio2=t.Ter_IdTerritorio WHERE Ubi_IdUbigeo=$id_ubigeo ");
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ubigeoModel)", "getTerritorios1xIdUbigeo", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function getTerritorios3xIdUbigeo($id_ubigeo)
    {
        try {
            $consulta = $this->_db->query(
                    "SELECT * FROM ubigeo u INNER JOIN territorio t ON u.Ter_IdTerritorio3=t.Ter_IdTerritorio WHERE Ubi_IdUbigeo=$id_ubigeo ");
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ubigeoModel)", "getTerritorios1xIdUbigeo", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function getTerritorios4xIdUbigeo($id_ubigeo)
    {
        try {
            $consulta = $this->_db->query(
                    "SELECT * FROM ubigeo u INNER JOIN territorio t ON u.Ter_IdTerritorio4=t.Ter_IdTerritorio WHERE Ubi_IdUbigeo=$id_ubigeo ");
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(ubigeoModel)", "getTerritorios1xIdUbigeo", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarEstadoUbigeo($iUbi_IdUbigeo, $iUbi_Estado) {

        try {
            $sql = "call s_u_estado_ubigeo(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iUbi_IdUbigeo, PDO::PARAM_INT);
            $result->bindParam(2, $iUbi_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function eliminarUbigeo($iUbi_IdUbigeo) {

        try {
            $sql = "call s_d_ubigeo(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iUbi_IdUbigeo, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

}
