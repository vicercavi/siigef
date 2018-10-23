<?php


class categoriaecaModel extends Model {
    
     public function __construct()
    {
        parent::__construct();
    }
    public function getCategoriaEcas($condicion = '')
    {
        
       
        try{
            $cuencas = $this->_db->query(
                 "select * from categoria_eca $condicion"
            );           
            return $cuencas->fetchAll();            
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreo(categoriaecaModel)", "getCategoriaEcas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    public function getCategoriaEca($id) {
        try {
            $sql = "call s_s_categoria_eca(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $id, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    public function registrarCategoriaEca($iCae_Nombre, $iCae_Descripcion,$iCae_Fuente,$iCae_Estado) {
        try {
            $sql = "call s_i_categoria_eca(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCae_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iCae_Descripcion, PDO::PARAM_STR);
            $result->bindParam(3, $iCae_Fuente, PDO::PARAM_STR);
            $result->bindParam(4, $iCae_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("categoriaecaModel", "registrarCategoriaEca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarCategoriaEca($iCae_IdCategoriaEca,$iCae_Nombre, $iCae_Descripcion,$iCae_Fuente,$iCae_Estado) {
        try {
            $sql = "call s_u_categoria_eca(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCae_IdCategoriaEca, PDO::PARAM_INT);
            $result->bindParam(2, $iCae_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iCae_Descripcion, PDO::PARAM_STR);
            $result->bindParam(4, $iCae_Fuente, PDO::PARAM_STR);
            $result->bindParam(5, $iCae_Estado, PDO::PARAM_INT);

            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("categoriaecaModel", "actualizarCategoriaEca", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
    public function actualizarEstadoCategoriaEca($iCae_IdCategoriaEca, $iCae_Estado) {

        try {
            $sql = "call s_u_estado_categoria_eca(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCae_IdCategoriaEca, PDO::PARAM_INT);
            $result->bindParam(2, $iCae_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
    public function eliminarCategoriaEca($iCae_IdCategoriaEca) {

        try {
            $sql = "call s_d_categoria_eca(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iCae_IdCategoriaEca, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            return $exc->getTraceAsString();
        }
    }
    
}
