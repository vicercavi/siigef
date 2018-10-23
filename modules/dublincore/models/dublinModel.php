<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of indexModel
 *
 * @author JHON CHARLIE
 */
class dublinModel extends Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getDocumentos($condicion = "") {
        $post = $this->_db->query(
                "SELECT dub.*, aut.*,arf.*, taf.*, ted.*, tid.* FROM dublincore dub "
                . "INNER JOIN tema_dublin ted ON dub.Ted_IdTemaDublin = ted.Ted_IdTemaDublin "
                . "INNER JOIN dublincore_autor dua ON dub.Dub_IdDublinCore = dua.Dub_IdDublinCore "
                . "INNER JOIN autor aut ON dua.Aut_IdAutor = aut.Aut_IdAutor  "
                . "INNER JOIN archivo_fisico arf ON dub.Arf_IdArchivoFisico = arf.Arf_IdArchivoFisico "
                . "INNER JOIN tipo_dublin tid ON dub.Tid_IdTipoDublin = tid.Tid_IdTipoDublin "
                . "RIGHT JOIN tipo_archivo_fisico taf ON arf.Taf_IdTipoArchivoFisico = taf.Taf_IdTipoArchivoFisico  $condicion"
        );
        return $post->fetchAll();
    }

    public function getCantidadTipoDocumentos($condicion = "") {
        $post = $this->_db->query(
                "SELECT tid.*,sub.cantidad FROM tipo_dublin tid
			     LEFT JOIN  (
            SELECT COUNT(dub.Dub_IdDublinCore) AS cantidad, tidu.Tid_Descripcion, tidu.Tid_IdTipoDublin FROM dublincore dub "
                . "INNER JOIN tema_dublin ted ON dub.Ted_IdTemaDublin = ted.Ted_IdTemaDublin "
                . "INNER JOIN dublincore_autor dua ON dub.Dub_IdDublinCore = dua.Dub_IdDublinCore "
                . "INNER JOIN autor aut ON dua.Aut_IdAutor = aut.Aut_IdAutor  "
                . "INNER JOIN archivo_fisico arf ON dub.Arf_IdArchivoFisico = arf.Arf_IdArchivoFisico "
                . "INNER JOIN tipo_archivo_fisico taf ON arf.Taf_IdTipoArchivoFisico = taf.Taf_IdTipoArchivoFisico  "
                . "RIGHT JOIN tipo_dublin tidu ON dub.Tid_IdTipoDublin = tidu.Tid_IdTipoDublin $condicion "
                . "GROUP BY(dub.Tid_IdTipoDublin) ) AS sub ON sub.Tid_IdTipoDublin = tid.Tid_IdTipoDublin "
                . "ORDER BY tid.Tid_Descripcion ");
        return $post->fetchAll();
    }

    public function getTipoArchivoFisico($condicion = "") {
        $post = $this->_db->query(
                "SELECT * FROM tipo_archivo_fisico taf $condicion");
        return $post->fetchAll();
    }

    public function getCantidadDocumentosTipoArchivoFisico($condicion = "") {
        $post = $this->_db->query(
                "SELECT COUNT(dub.Dub_IdDublinCore) AS cantidad,taf.Taf_Descripcion FROM dublincore dub "
                . "INNER JOIN tema_dublin ted ON dub.Ted_IdTemaDublin = ted.Ted_IdTemaDublin "
                . "INNER JOIN dublincore_autor dua ON dub.Dub_IdDublinCore = dua.Dub_IdDublinCore "
                . "INNER JOIN autor aut ON dua.Aut_IdAutor = aut.Aut_IdAutor  "
                . "INNER JOIN archivo_fisico arf ON dub.Arf_IdArchivoFisico = arf.Arf_IdArchivoFisico "
                . "INNER JOIN tipo_archivo_fisico taf ON arf.Taf_IdTipoArchivoFisico = taf.Taf_IdTipoArchivoFisico  "
                . "INNER JOIN tipo_dublin tid ON dub.Tid_IdTipoDublin = tid.Tid_IdTipoDublin $condicion"
                . "GROUP BY(arf.Taf_IdTipoArchivoFisico)");
        return $post->fetchAll();
    }

    public function getCantidadTemaDocumentos($condicion = "") {
        $post = $this->_db->query(
                "SELECT COUNT(dub.Dub_IdDublinCore) AS cantidad,ted.Ted_Descripcion FROM dublincore dub "
                . "INNER JOIN tema_dublin ted ON dub.Ted_IdTemaDublin = ted.Ted_IdTemaDublin $condicion "
                . "GROUP BY(dub.Ted_IdTemaDublin)");
        return $post->fetchAll();
    }

    public function getCantidadDocumentosPais($condicion = "") {
        $post = $this->_db->query(
                "SELECT COUNT(dub.Dub_IdDublinCore) AS cantidad, pai.Pai_Nombre FROM dublincore dub "
                . "INNER JOIN documentos_relacionados dor ON dub.Dub_IdDublinCore = dor.Dub_IdDublinCore "
                . "RIGHT JOIN pais pai ON dor.Pai_IdPais = pai.Pai_IdPais $condicion "
                . "GROUP BY(pai.Pai_Nombre)");
        return $post->fetchAll();
    }

    public function getPaises() {
        $post = $this->_db->query(
                "SELECT * FROM pais");
        return $post->fetchAll();
    }

    public function _cambiarEstadoDublin($id_dublin, $nuevo_estado)
    {
        $consulta = $this->_db->query(
            "UPDATE dublincore SET Dub_Estado = $nuevo_estado WHERE Dub_IdDublinCore=$id_dublin"
            );        
        
        return $consulta->rowCount(PDO::FETCH_ASSOC);
    }

    public function eliminarDublincCoreCompleto($id_dublin) {
        $post = $this->_db->query(
                "SELECT af.* FROM archivo_fisico af
                 INNER JOIN dublincore d ON d.Arf_IdArchivoFisico=af.Arf_IdArchivoFisico
                 WHERE d.Dub_IdDublinCore= $id_dublin"
        );
        $arhivo_fisico = $post->fetchAll();
        if (!empty($arhivo_fisico)) {


            $e_autor=$this->eliminarDublinCoreAutor($id_dublin);
            $e_doc_re = $this->eliminarDublinCoreDocumentosRelacionados($id_dublin);
            $e_desc = $this->eliminarDublinCoreEstadisticasD($id_dublin);

            $e_dub = $this->eliminarDublinCore_Archivofisico($id_dublin);


            if ($e_dub>1 &&!empty($arhivo_fisico[0]['Arf_PosicionFisica'])) {
                $ruta_archivo = ROOT_ARCHIVO_FISICO. $arhivo_fisico[0]['Arf_PosicionFisica'];
                if (file_exists($ruta_archivo))
                    unlink($ruta_archivo);
            }
            if($e_dub>1)
                return true;
            else
                return false;
        } else {
             return false;
        }
    }

    public function eliminarDublinCore($id_dublin) {
        try {
            $consulta = $this->_db->query(
                    "DELETE FROM dublincore d 
                WHERE d.Dub_IdDublinCore = $id_dublin"
            );
            return $consulta->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("dublincore(indexModel)", "eliminarDublinCore_Archivofisico", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function eliminarDublinCore_Archivofisico($id_dublin) {
        try {
            $consulta = $this->_db->query(
                    "DELETE d,af FROM archivo_fisico  af 
                INNER JOIN dublincore d ON d.Arf_IdArchivoFisico=af.Arf_IdArchivoFisico
                WHERE d.Dub_IdDublinCore = $id_dublin"
            );
            return $consulta->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("dublincore(indexModel)", "eliminarDublinCore_Archivofisico", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function eliminarDublinCoreAutor($id_dublin) {
        try {
            $consulta = $this->_db->query(
                    "DELETE FROM dublincore_autor WHERE Dub_IdDublinCore = $id_dublin "
            );
            return $consulta->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("dublincore(indexModel)", "eliminarDublinCoreAutor", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function eliminarDublinCoreDocumentosRelacionados($id_dublin) {
        try {
            $consulta = $this->_db->query(
                    "DELETE FROM documentos_relacionados WHERE Dub_IdDublinCore = $id_dublin "
            );
            return $consulta->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("dublincore(indexModel)", "eliminarDublinCoreDocumentosRelacionados", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function eliminarDublinCoreEstadisticasD($id_dublin) {
        try {
            $consulta = $this->_db->query(
                    "DELETE sd FROM archivo_fisico  af 
                INNER JOIN dublincore d ON d.Arf_IdArchivoFisico=af.Arf_IdArchivoFisico
                INNER JOIN estadistica_descarga sd ON sd.Arf_IdArchivoFisico=af.Arf_IdArchivoFisico
                WHERE d.Dub_IdDublinCore = $id_dublin"
            );
            return $consulta->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("dublincore(indexModel)", "eliminarDublinCoreEstadisticasV", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

}
