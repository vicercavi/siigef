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
    
    public function registrarDublinCore($idIdiomaMetadata, $idAutor, $idTemaDublin, $idTipoDublin, $idiomaDocumento,
            $titulo, $descripcion, $editor, $colaborador, $fechaDocumento, $fuente, $identificador,
            $formato, $derechos ) 
    {   
        $this->_db->prepare(
                "INSERT INTO dublincore VALUES (null, :titulo , :descripcion, :editor, :colaborador, :fechaDocumento, "
                . " :formato, :identificador, :fuente, :idiomaDocumento, 'relacion', "
                . " 'cobertura', :derechos, 'palabraclave', 'estado', 1, 1, "
                . " 1, 1, 1, 1 )"
                )                
                ->execute(array(
                    ':titulo' => $titulo, 
                    ':descripcion' => $descripcion,
                    ':editor' => "$editor",
                    ':colaborador' => "$colaborador",
                    ':fechaDocumento' => "$fechaDocumento",
                    ':formato' => "$formato",
                    ':identificador' => "$identificador",
                    ':fuente' => "$fuente",
                    ':idiomaDocumento' => "$idiomaDocumento",
                    //':relacion' => "relacion", 
                    //':cobertura' => "cobertura",
                    ':derechos' => "$derechos",
                    //':palabraclave' => "p",
                    //':estado' => "0",
                    //':idTipoDublin' => $idTipoDublin,
                    //':archivofisico' => 1,
                   // ':idIdiomaMetadata' => $idIdiomaMetadata,
                   // ':idTemaDublin' => $idTemaDublin,
                   // ':idAutor' => $idAutor,
                    //':idRecurso' => 1                
                ));
    }
        	    
    public function getAutores()
    {
        $post = $this->_db->query(
        " SELECT * FROM autor ");        
        return $post->fetchAll();
    }
    public function getTemas()
    {
        $post = $this->_db->query(
        " SELECT * FROM tema_dublin ");        
        return $post->fetchAll();
    }
    
    public function getTipoDublin()
    {
        $post = $this->_db->query(
        " SELECT * FROM tipo_dublin ");        
        return $post->fetchAll();
    }
    public function getIdiomas()
    {
        $post = $this->_db->query(
        " SELECT * FROM idioma ");        
        return $post->fetchAll();
    }
    
}
