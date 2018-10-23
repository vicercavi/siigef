<?php

class clasificacionicaModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getClasificacionIcas($condicion = '') {

        try {
            $clasificacionicas = $this->_db->query(
                    "select cl.*,ca.Cai_Nombre, ic.Ica_Nombre from clasificacion_ica cl left join categoria_ica ca" .
                    " on cl.Cai_IdCategoriaIca = ca.Cai_IdCategoriaIca left join ica ic" .
                    " on cl.Ica_IdIca = ic.Ica_IdIca  $condicion"
            );
            return $clasificacionicas->fetchAll();
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(clasificacionicaModel)", "getClasificacionIcas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getClasificacionIca($id) {
        try {
            $sql = "call s_s_clasificacion_ica(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function registrarClasificacionIca($iCli_Nombre, $iCli_Descripcion, $iCli_IcaMin, $Cli_IcaMax, $iCli_Color, $iCai_IdCategoriaIca, $iIca_IdIca,$iCli_Estado) {
        try {
            $sql = "call s_i_clasificacion_ica(?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCli_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iCli_Descripcion, PDO::PARAM_INT);
            $result->bindParam(3, $iCli_IcaMin, PDO::PARAM_INT);
            $result->bindParam(4, $Cli_IcaMax, PDO::PARAM_INT);
            $result->bindParam(5, $iCli_Color, PDO::PARAM_STR);
            $result->bindParam(6, $iCai_IdCategoriaIca, PDO::PARAM_INT);
            $result->bindParam(7, $iIca_IdIca, PDO::PARAM_INT);
            $result->bindParam(8, $iCli_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("clasificacionicaModel", "registrarClasificacionIca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarClasificacionIca($iCli_IdClasificacionIca, $iCli_Nombre, $iCli_Descripcion, $iCli_IcaMin, $Cli_IcaMax, $iCli_Color, $iCai_IdCategoriaIca, $iIca_IdIca, $iCli_Estado) {
        try {
            $sql = "call s_u_clasificacion_ica(?,?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCli_IdClasificacionIca, PDO::PARAM_INT);
            $result->bindParam(2, $iCli_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iCli_Descripcion, PDO::PARAM_INT);
            $result->bindParam(4, $iCli_IcaMin, PDO::PARAM_INT);
            $result->bindParam(5, $Cli_IcaMax, PDO::PARAM_INT);
            $result->bindParam(6, $iCli_Color, PDO::PARAM_STR);
            $result->bindParam(7, $iCai_IdCategoriaIca, PDO::PARAM_INT);
            $result->bindParam(8, $iIca_IdIca, PDO::PARAM_INT);
            $result->bindParam(9, $iCli_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("clasificacionicaModel", "actualizarClasificacionIca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getIcas() {
        try {
            $tipos_agua = $this->_db->query(
                    "SELECT * FROM ica");
            return $tipos_agua->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(clasificacionicaModel)", "getIca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getCategoriaIcas() {
        try {
            $paises = $this->_db->query(
                    "SELECT * FROM categoria_ica");
            return $paises->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(clasificacionicaModel)", "getPais", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarEstadoClasificacionIca($iClasificacionIca_IdClasificacionIca, $iClasificacionIca_Estado) {

        try {
            $sql = "call s_u_estado_clasificacion_ica(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iClasificacionIca_IdClasificacionIca, PDO::PARAM_INT);
            $result->bindParam(2, $iClasificacionIca_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

    public function eliminarClasificacionIca($iCli_IdClasificacionIca) {

        try {
            $sql = "call s_d_clasificacion_ica(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCli_IdClasificacionIca, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }

}
