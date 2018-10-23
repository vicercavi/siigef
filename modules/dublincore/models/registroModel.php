<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of registroModel
 *
 * @author JHON CHARLIE
 */
class registroModel extends Model{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function registrarDublinCore($idIdiomaMetadata, $idTemaDublin, $idTipoDublin, $Arf, $idRecurso, $idiomaDocumento, $formato,
            $titulo, $descripcion, $editor, $colaborador, $fechaDocumento, $fuente, $identificador, $relacion,
            $cobertura, $palabraclave, $derechos ) 
    {   
        $this->_db->prepare(
                "INSERT INTO dublincore VALUES (null, :titulo , :descripcion, :editor, :colaborador, :fechaDocumento, "
                . " :formato, :identificador, :fuente, :idiomaDocumento, :relacion, "
                . " :cobertura, :derechos, :palabraclave, '1', :idTipoDublin, :archivofisico, "
                . " :idIdiomaMetadata, :idTemaDublin, :idRecurso)"
                )                
                ->execute(array(
                    ':titulo' => $titulo, 
                    ':descripcion' => $descripcion,
                    ':editor' => $editor,
                    ':colaborador' => $colaborador,
                    ':fechaDocumento' => $fechaDocumento,
                    ':formato' => $formato,
                    ':identificador' => $identificador,
                    ':fuente' => $fuente,
                    ':idiomaDocumento' => $idiomaDocumento,
                    ':relacion' => $relacion, 
                    ':cobertura' => $cobertura,
                    ':derechos' => $derechos,
                    ':palabraclave' => $palabraclave,
                    //':estado' => "1",
                    ':idTipoDublin' => $idTipoDublin,
                    ':archivofisico' => $Arf,
                    ':idIdiomaMetadata' => $idIdiomaMetadata,
                    ':idTemaDublin' => $idTemaDublin,
                    ':idRecurso' => $idRecurso                
                ));
    }    
    
    public function registrarDublinCoreAutor($idDublinCore,$idAutor)
    {
        $this->_db->prepare(
                "INSERT INTO dublincore_autor VALUES (:idDublinCore , :idAutor)"
                )                
                ->execute(array(
                    ':idDublinCore' => $idDublinCore, 
                    ':idAutor' => $idAutor));
    }
    
    public function registrarNuevoIdioma($Idioma)
    {
        $this->_db->prepare(
                "INSERT INTO idiomap VALUES (null, :descripcion, 1)"
                )                
                ->execute(array(
                    ':descripcion' => $Idioma));
    }
    
    public function registrarNuevoTema($tema)
    {
        $this->_db->prepare(
                "INSERT INTO tema_dublin VALUES (null, :descripcion, '1')"
                )                
                ->execute(array(
                    ':descripcion' => $tema));
    }
    public function registrarNuevoAutor($nombre, $profesion, $email)
    {
        $this->_db->prepare(
                "INSERT INTO autor VALUES (null, :nombre, :profesion, :email, '1')"
                )                
                ->execute(array(
                    ':nombre' => $nombre,
                    ':profesion' => $profesion,
                    ':email' => $email
                ));
    }
    public function registrarNuevoFormato($formato)
    {
        $this->_db->prepare(
                "INSERT INTO tipo_archivo_fisico VALUES (null, :descripcion )"
                )                
                ->execute(array(
                    ':descripcion' => $formato));
    }
    public function registrarNuevoTipoDocumento($nombre, $idioma )
    {
        $this->_db->prepare(
                "INSERT INTO tipo_dublin VALUES (null, :nombre, '1', :idioma)"
                )                
                ->execute(array(
                    ':nombre' => $nombre,
                    ':idioma' => $idioma
                ));
    }
    
    public function registrarArchivoFisico($idTaf,$PosicionFisica,$Tamano)
    {
        $this->_db->prepare(
                "INSERT INTO archivo_fisico VALUES (null, null, null, :tipoArchivoFisico , :tamano, :posicionFisica, null, null, null, null, null)"
                )                
                ->execute(array(
                    ':tipoArchivoFisico' => $idTaf,
                    ':tamano' => $Tamano, 
                    ':posicionFisica' => $PosicionFisica));
    }

    public function verificarDublinCore($titulo)
    {
        $post = $this->_db->query(
        "SELECT dub.Dub_IdDublinCore, dub.Dub_Titulo FROM dublincore dub WHERE dub.Dub_Titulo =  '$titulo' ");        
        return $post->fetch();
    }
    public function getAutores($condicion = "")
    {
        $post = $this->_db->query(
        " SELECT * FROM autor $condicion ");        
        return $post->fetchAll();
    }
    public function getTemas($condicion = "")
    {
        $post = $this->_db->query(
        " SELECT * FROM tema_dublin $condicion ");        
        return $post->fetchAll();
    }
    
    public function getTipoDublin($condicion = "")
    {
        $post = $this->_db->query(
        " SELECT * FROM tipo_dublin $condicion");        
        return $post->fetchAll();
    }
    public function getIdiomas($condicion = "")
    {
        $post = $this->_db->query(
        " SELECT * FROM idioma $condicion");        
        return $post->fetchAll();
    }
    
    public function getCantidadRegistros($cantidadRegistros, $idRecurso)
    {
        $post = $this->_db->query(
            "   UPDATE recurso SET Rec_CantidadRegistros = $cantidadRegistros, Rec_UltimaModificacion = NOW() 
                WHERE Rec_IdRecurso = $idRecurso");       
    }
    
    public function getRecurso($idRecurso)
    {
        $post = $this->_db->query(
        " SELECT * FROM recurso WHERE Rec_IdRecurso = $idRecurso");        
        return $post->fetch();
    }
    public function getTipoArchivosFisicos($condicion = "")
    {
        $post = $this->_db->query(
        " SELECT * FROM tipo_archivo_fisico $condicion");        
        return $post->fetchAll();
    }
    
    public function verificarTaf($condicion)
    {
        $post = $this->_db->query(
        " SELECT * FROM tipo_archivo_fisico $condicion");        
        return $post->fetch();
    }
    
    public function verificarArf($ArfPosicionFisica)
    {
        $post = $this->_db->query(
        " SELECT * FROM archivo_fisico WHERE Arf_PosicionFisica = '$ArfPosicionFisica'");        
        return $post->fetch();
    }
}
