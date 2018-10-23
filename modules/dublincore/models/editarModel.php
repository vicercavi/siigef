<?php

class editarModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDocumento1($condicion = "") {
        $post = $this->_db->query(
                " SELECT dub.*, aut.Aut_IdAutor, aut.Aut_Nombre,arf.Arf_IdArchivoFisico, arf.Arf_PosicionFisica, arf.Arf_FechaCreacion,arf.Arf_URL, taf.*,
             ted.Ted_Descripcion, tid.Tid_Descripcion, tid.Tid_Estado FROM dublincore dub 
            INNER JOIN tema_dublin ted ON dub.Ted_IdTemaDublin = ted.Ted_IdTemaDublin 
            INNER JOIN dublincore_autor dua ON dub.Dub_IdDublinCore = dua.Dub_IdDublinCore 
            INNER JOIN autor aut ON dua.Aut_IdAutor = aut.Aut_IdAutor  
            INNER JOIN archivo_fisico arf ON dub.Arf_IdArchivoFisico = arf.Arf_IdArchivoFisico 
            INNER JOIN tipo_dublin tid ON dub.Tid_IdTipoDublin = tid.Tid_IdTipoDublin 
            RIGHT JOIN tipo_archivo_fisico taf ON arf.Taf_IdTipoArchivoFisico = taf.Taf_IdTipoArchivoFisico  $condicion"
        );
        return $post->fetch();
    }

    public function verificarIdiomaDublin($Dub_IdDublinCore, $Idi_IdIdioma) {
        $post = $this->_db->query(
                "SELECT Dub_IdDublinCore, Dub_Titulo FROM dublincore WHERE Dub_IdDublinCore = $Dub_IdDublinCore AND Idi_IdIdioma = '$Idi_IdIdioma' ");
        return $post->fetch();
    }

    public function actualizarArchivoFisico($Arf_IdArchivoFisico, $Arf_Descripcion, $Taf_IdTipoArchivoFisico, $Arf_TypeMime, $Arf_TamanoArchivo, $Arf_PosicionFisica, $Arf_FechaCreacion, $Arf_URL, $Arf_Estado, $Idi_IdIdioma) {
        try {
            $sql = "UPDATE archivo_fisico SET "
                    . "Arf_Descripcion='$Arf_Descripcion', "
                    . "Taf_IdTipoArchivoFisico=$Taf_IdTipoArchivoFisico, "
                    . "Arf_TypeMime='$Arf_TypeMime',"
                    . "Arf_TamanoArchivo='$Arf_TamanoArchivo', "
                    . "Arf_PosicionFisica='$Arf_PosicionFisica', "
                    . "Arf_FechaCreacion='$Arf_FechaCreacion', "
                    . "Arf_URL='$Arf_URL', "
                    . "Arf_Estado=$Arf_Estado, "
                    . "Idi_IdIdioma='$Idi_IdIdioma' WHERE "
                    . " Arf_IdArchivoFisico=$Arf_IdArchivoFisico";

            $result = $this->_db->prepare($sql);

            $result->execute();

            return $result->rowCount();
        } catch (PDOException $exception) {
            var_dump($exception->getTraceAsString());
            $this->registrarBitacora("dublincore(editarModel)", "actualizarArchivoFisico", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarArchivoFisicoTipo($Taf_IdTipoArchivoFisico, $Dub_IdDublinCore) {
        $post = $this->_db->query(
                "UPDATE archivo_fisico af
                 INNER JOIN dublincore db    ON db.Arf_IdArchivoFisico = af.Arf_IdArchivoFisico
                 SET af.Taf_IdTipoArchivoFisico = '$Taf_IdTipoArchivoFisico' WHERE db.Dub_IdDublinCore = $Dub_IdDublinCore");
    }

    public function actualizararDublinCore($Dub_Titulo, $Dub_Descripcion, $Dub_Editor, $Dub_Colaborador, $Dub_FechaDocumento, $Dub_Formato, $Dub_Identificador, $Dub_Fuente, $Dub_Idioma, $Dub_Relacion, $Dub_Cobertura, $Dub_Derechos, $Dub_PalabraClave, $Tid_IdTipoDublin, $Arf_IdArchivoFisico, $Ted_IdTemaDublin, $Dub_IdDublinCore) {
        try {
            $sql = "UPDATE dublincore SET Dub_Titulo= '$Dub_Titulo' ,Dub_Descripcion= '$Dub_Descripcion', Dub_Editor = '$Dub_Editor', Dub_Colaborador = '$Dub_Colaborador', Dub_FechaDocumento = '$Dub_FechaDocumento' , Dub_Formato = '$Dub_Formato', Dub_Identificador = '$Dub_Identificador' , Dub_Fuente = '$Dub_Fuente', Dub_Idioma = '$Dub_Idioma', Dub_Relacion = '$Dub_Relacion', Dub_Cobertura = '$Dub_Cobertura', Dub_Derechos = '$Dub_Derechos', Dub_PalabraClave = '$Dub_PalabraClave', Tid_IdTipoDublin = $Tid_IdTipoDublin, Arf_IdArchivoFisico = $Arf_IdArchivoFisico, Ted_IdTemaDublin = $Ted_IdTemaDublin WHERE Dub_IdDublinCore = $Dub_IdDublinCore";
            $result = $this->_db->prepare($sql);

            $result->execute();

            return $result->rowCount();
        } catch (PDOException $exception) {
            var_dump($exception->getTraceAsString());
            $this->registrarBitacora("dublincore(editarModel)", "actualizararDublinCore", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function actualizarDublinAutor($Dub_IdDublinCore, $Aut_IdAutor) {
        $post = $this->_db->query(
                "UPDATE dublincore_autor SET  Aut_IdAutor = $Aut_IdAutor WHERE Dub_IdDublinCore =  $Dub_IdDublinCore");
    }

    public function eliminaDocumentosRelacionados($Dub_IdDublinCore) {
        $post = $this->_db->query(
                "DELETE FROM  documentos_relacionados WHERE Dub_IdDublinCore = $Dub_IdDublinCore");
    }

    public function getPaises($Dub_IdDublinCore = "") {
        $post = $this->_db->query(
                " SELECT pai.Pai_Nombre FROM documentos_relacionados dor
              INNER JOIN pais pai ON dor.Pai_IdPais = pai.Pai_IdPais WHERE dor.Dub_IdDublinCore =  $Dub_IdDublinCore"
        );
        return $post->fetchall();
    }

    public function editarTraduccion($Dub_Titulo, $Dub_Descripcion, $Dub_PalabraClave, $Dub_IdDublinCore, $Idi_IdIdioma) {

        $ContTradTitulo = $this->buscarCampoTraducido('dublincore', $Dub_IdDublinCore, 'Dub_Titulo', $Idi_IdIdioma);
        $ContTradDescripcion = $this->buscarCampoTraducido('dublincore', $Dub_IdDublinCore, 'Dub_Descripcion', $Idi_IdIdioma);
        $ContTradPalabraClave = $this->buscarCampoTraducido('dublincore', $Dub_IdDublinCore, 'Dub_PalabraClave', $Idi_IdIdioma);

        $idContTradTitulo = $ContTradTitulo['Cot_IdContenidoTraducido'];
        $idContTradDescripcion = $ContTradDescripcion['Cot_IdContenidoTraducido'];
        $idContTradPalabraClave = $ContTradPalabraClave['Cot_IdContenidoTraducido'];

        if (isset($idContTradTitulo)) {
            $this->_db->query(
                    "UPDATE contenido_traducido SET Cot_Traduccion = '$Dub_Titulo' WHERE Cot_IdContenidoTraducido = $idContTradTitulo"
            );
        } else {

            $this->_db->prepare(
                            "INSERT INTO contenido_traducido VALUES (null, 'dublincore', :Cot_IdRegistro, 'Dub_Titulo', :Idi_IdIdioma, :Cot_Traduccion)"
                    )
                    ->execute(array(
                        ':Cot_IdRegistro' => $Dub_IdDublinCore,
                        ':Idi_IdIdioma' => $Idi_IdIdioma,
                        ':Cot_Traduccion' => $Dub_Titulo
            ));
        }

        if (isset($idContTradDescripcion)) {
            $this->_db->query(
                    "UPDATE contenido_traducido SET Cot_Traduccion = '$Dub_Descripcion' WHERE Cot_IdContenidoTraducido = $idContTradDescripcion"
            );
        } else {

            $this->_db->prepare(
                            "INSERT INTO contenido_traducido VALUES (null, 'dublincore', :Cot_IdRegistro, 'Dub_Descripcion' , :Idi_IdIdioma, :Cot_Traduccion)"
                    )
                    ->execute(array(
                        ':Cot_IdRegistro' => $Dub_IdDublinCore,
                        ':Idi_IdIdioma' => $Idi_IdIdioma,
                        ':Cot_Traduccion' => $Dub_Descripcion
            ));
        }

        if (isset($idContTradPalabraClave)) {
            $this->_db->query(
                    "UPDATE contenido_traducido SET Cot_Traduccion = '$Dub_PalabraClave' WHERE Cot_IdContenidoTraducido = $idContTradPalabraClave"
            );
        } else {

            $this->_db->prepare(
                            "INSERT INTO contenido_traducido VALUES (null, 'dublincore', :Cot_IdRegistro, 'Dub_PalabraClave' , :Idi_IdIdioma, :Cot_Traduccion)"
                    )
                    ->execute(array(
                        ':Cot_IdRegistro' => $Dub_IdDublinCore,
                        ':Idi_IdIdioma' => $Idi_IdIdioma,
                        ':Cot_Traduccion' => $Dub_PalabraClave
            ));
        }
    }

    public function buscarCampoTraducido($tabla, $Pag_IdPagina, $columna, $Idi_IdIdioma) {
        $post = $this->_db->query(
                "SELECT * FROM contenido_traducido WHERE Cot_Tabla = '$tabla' AND Cot_IdRegistro =  $Pag_IdPagina AND  Cot_Columna = '$columna' AND Idi_IdIdioma= '$Idi_IdIdioma'");
        return $post->fetch();
    }

    public function getDublinTraducido($condicion, $Idi_IdIdioma) {
        $paginas = $this->_db->query(
                "SELECT 
                dub.Dub_IdDublinCore, 
                fn_TraducirContenido('dublincore','Dub_Titulo',dub.Dub_IdDublinCore,'$Idi_IdIdioma',dub.Dub_Titulo) Dub_Titulo,
                fn_TraducirContenido('dublincore','Dub_Descripcion',dub.Dub_IdDublinCore,'$Idi_IdIdioma',dub.Dub_Descripcion) Dub_Descripcion,
                fn_TraducirContenido('dublincore','Dub_PalabraClave',dub.Dub_IdDublinCore,'$Idi_IdIdioma',dub.Dub_PalabraClave) Dub_PalabraClave,
                dub.Dub_Editor, dub.Dub_Colaborador, dub.Dub_FechaDocumento, dub.Dub_Formato, dub.Dub_Identificador, dub.Dub_Fuente, dub.Dub_Idioma,
                dub.Dub_Relacion, dub.Dub_Cobertura, dub.Dub_Derechos, dub.Dub_Estado, dub.Tid_IdTipoDublin, dub.Arf_IdArchivoFisico, 
                dub.Ted_IdTemaDublin, dub.Rec_IdRecurso,
                aut.Aut_IdAutor, aut.Aut_Nombre, arf.Arf_PosicionFisica, arf.Arf_FechaCreacion, taf.*,
                ted.Ted_Descripcion, tid.Tid_Descripcion, tid.Tid_Estado,
                fn_devolverIdioma('dublincore',dub.Dub_IdDublinCore,'$Idi_IdIdioma',dub.Idi_IdIdioma) Idi_IdIdioma

                FROM dublincore dub     
                             
                INNER JOIN tema_dublin ted ON dub.Ted_IdTemaDublin = ted.Ted_IdTemaDublin 
                INNER JOIN dublincore_autor dua ON dub.Dub_IdDublinCore = dua.Dub_IdDublinCore 
                INNER JOIN autor aut ON dua.Aut_IdAutor = aut.Aut_IdAutor  
                INNER JOIN archivo_fisico arf ON dub.Arf_IdArchivoFisico = arf.Arf_IdArchivoFisico 
                INNER JOIN tipo_dublin tid ON dub.Tid_IdTipoDublin = tid.Tid_IdTipoDublin 
                RIGHT JOIN tipo_archivo_fisico taf ON arf.Taf_IdTipoArchivoFisico = taf.Taf_IdTipoArchivoFisico  $condicion"
        );
        return $paginas->fetch();
    }

}

?>
