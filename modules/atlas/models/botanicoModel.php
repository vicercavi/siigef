<?php

class botanicoModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getPlinian($condicion = "") {
        $post = $this->_db->query(
                "SELECT * FROM plinian pli
INNER JOIN recurso rec ON pli.Rec_IdRecurso = rec.Rec_IdRecurso
WHERE (pli.Pli_NombreCientifico LIKE '%$condicion%' 
OR pli.Pli_NombresComunes LIKE '%$condicion%'
OR pli.Pli_Familia LIKE '%$condicion%' 
OR pli.Pli_Genero LIKE '%$condicion%'
OR pli.Pli_AcronimoInstitucion LIKE '%$condicion%')
AND rec.Rec_Estado = 1 AND pli.Pli_Estado = 1
ORDER BY pli.Pli_NombreCientifico ASC "
        );
        return $post->fetchAll();
    }

    public function getPlinianXRecurso($idrecurso, $condicion) 
    {
        $post = $this->_db->query(
                "SELECT * FROM plinian pli WHERE pli.Rec_IdRecurso = $idrecurso $condicion"
        );
        return $post->fetchAll();
    }

    public function getPlinianXId($id_plinian) 
    {
        $post = $this->_db->query(
                "SELECT * FROM plinian WHERE Pli_IdPlinian = $id_plinian"
        );
        return $post->fetch();
    }

    public function getcantRegistrosPlinian($condicion = "") {
        $post = $this->_db->query(
                "SELECT COUNT(*) AS cantidad FROM plinian pli WHERE pli.Pli_NombreCientifico LIKE '%$condicion%' OR pli.Pli_NombresComunes LIKE '%$condicion%' OR pli.Pli_Familia LIKE '%$condicion%'  OR pli.Pli_Genero LIKE '%$condicion%'"
        );
        return $post->fetchAll();
    }

    public function getMetadata($condicion = "") {
        $post = $this->_db->query(
                "SELECT * FROM plinian pli inner join recurso rec on pli.Rec_IdRecurso = rec. Rec_IdRecurso Where pli.Pli_IdPlinian =  $condicion and rec.Rec_Estado = 1 and pli.Pli_Estado = 1"
        );
        return $post->fetch();
    }

    public function _cambiarEstadoPlinian($id_plinian, $nuevo_estado)
    {
        $consulta = $this->_db->query(
            "UPDATE plinian SET Pli_Estado = $nuevo_estado WHERE Pli_IdPlinian=$id_plinian"
            );        
        
        return $consulta->rowCount(PDO::FETCH_ASSOC);
    }

    public function eliminarPlinian($id_plinian) {
        try {
            
            $consulta = $this->_db->query(
                    "DELETE FROM plinian WHERE Pli_IdPlinian = $id_plinian"
            );
            return $consulta->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("legislacion(LegalModel)", "eliminarLegislacion", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

}
