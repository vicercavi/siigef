<?php

class editarModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
	
    public function getLegislacionesMetadata1($condicion = "")
    {
        $post = $this->_db->query(
                "SELECT mal.*, tel.Tel_Nombre,til.Til_Nombre, snl.Snl_IdSubNivelLegal, snl.Snl_Nombre, nil.Nil_Nombre,nil.Nil_IdNivelLegal, pai.Pai_Nombre FROM matriz_legal mal 
                INNER JOIN tema_legal tel ON mal.Tel_IdTemaLegal = tel.Tel_IdTemaLegal
                INNER JOIN tipo_legal til ON mal.Til_IdTipoLegal = til.Til_IdTipoLegal
                INNER JOIN sub_nivel_legal snl ON tel.Snl_IdSubNivelLegal = snl.Snl_IdSubNivelLegal
                INNER JOIN nivel_legal nil ON snl.Nil_IdNivelLegal= nil.Nil_IdNivelLegal
                INNER JOIN pais pai ON  mal.Pai_IdPais = pai.Pai_IdPais   $condicion");				
        return $post->fetch();
    }
    
    public function getLegalTraducido($condicion = "", $Idi_IdIdioma)
    {
        $post = $this->_db->query(
                "SELECT   
mal.Mal_IdMatrizLegal, 			
mal.Mal_FechaPublicacion,
mal.Mal_Entidad,
mal.Mal_NumeroNormas,
fn_TraducirContenido('matriz_legal','Mal_Titulo',mal.Mal_IdMatrizLegal,'$Idi_IdIdioma',mal.Mal_Titulo) Mal_Titulo,
mal.Mal_ArticuloAplicable, 
fn_TraducirContenido('matriz_legal','Mal_ResumenLegislacion',mal.Mal_IdMatrizLegal,'$Idi_IdIdioma',mal.Mal_ResumenLegislacion) Mal_ResumenLegislacion,
mal.Mal_FechaRevision,
mal.Mal_NormasComplementarias,
mal.Til_IdTipoLegal,
fn_TraducirContenido('tipo_legal','Til_Nombre',til.Til_IdTipoLegal,'$Idi_IdIdioma',til.Til_Nombre) Til_Nombre,
mal.Tel_IdTemaLegal,
mal.Pai_IdPais,
mal.Idi_IdIdioma,
mal.Rec_IdRecurso,
fn_TraducirContenido('matriz_legal','Mal_PalabraClave',mal.Mal_IdMatrizLegal,'$Idi_IdIdioma',mal.Mal_PalabraClave) Mal_PalabraClave,
mal.Mal_Estado,
tel.Tel_IdTemaLegal,
fn_TraducirContenido('tema_legal','Tel_Nombre',tel.Tel_IdTemaLegal,'$Idi_IdIdioma',tel.Tel_Nombre) Tel_Nombre,
snl.Snl_IdSubNivelLegal, 
fn_TraducirContenido('sub_nivel_legal','Snl_Nombre',snl.Snl_IdSubNivelLegal,'$Idi_IdIdioma',snl.Snl_Nombre) Snl_Nombre,
nil.Nil_IdNivelLegal, 
fn_TraducirContenido('nivel_legal','Nil_Nombre',nil.Nil_IdNivelLegal,'$Idi_IdIdioma',nil.Nil_Nombre) Nil_Nombre,
pai.Pai_Nombre,
fn_devolverIdioma('matriz_legal',mal.Mal_IdMatrizLegal,'$Idi_IdIdioma',mal.Idi_IdIdioma) Idi_IdIdioma
FROM matriz_legal mal 
INNER JOIN tema_legal tel ON mal.Tel_IdTemaLegal = tel.Tel_IdTemaLegal
INNER JOIN tipo_legal til ON mal.Til_IdTipoLegal = til.Til_IdTipoLegal
INNER JOIN sub_nivel_legal snl ON tel.Snl_IdSubNivelLegal = snl.Snl_IdSubNivelLegal
INNER JOIN nivel_legal nil ON snl.Nil_IdNivelLegal= nil.Nil_IdNivelLegal
INNER JOIN pais pai ON  mal.Pai_IdPais = pai.Pai_IdPais  $condicion");				
        return $post->fetch();
    }
    public function verificarIdiomaLegal($Mal_IdMatrizLegal, $Idi_IdIdioma)
    {
        $post = $this->_db->query(
                "SELECT * FROM matriz_legal WHERE Mal_IdMatrizLegal = $Mal_IdMatrizLegal AND Idi_IdIdioma = '$Idi_IdIdioma'");				
        return $post->fetch();
    }
    
    public function editarTraduccion($Nil_IdNivelLegal,$Snl_IdSubNivelLegal,$Tel_IdTemaLegal,$Til_IdTipoLegal,$Nil_Nombre,$Snl_Nombre,$Tel_Nombre,$Til_Nombre,$Mal_Titulo,$Mal_ResumenLegislacion,$Mal_PalabraClave,$Mal_IdMatrizLegal,$Idi_IdIdioma)
    {
        $ContTradNil_Nombre = $this->buscarCampoTraducido('nivel_legal',$Nil_IdNivelLegal,'Nil_Nombre',$Idi_IdIdioma);
        
        $ContTradSnl_Nombre = $this->buscarCampoTraducido('sub_nivel_legal',$Snl_IdSubNivelLegal,'Snl_Nombre',$Idi_IdIdioma);
        $ContTradTel_Nombre = $this->buscarCampoTraducido('tema_legal',$Tel_IdTemaLegal,'Tel_Nombre',$Idi_IdIdioma);
		$ContTradTil_Nombre = $this->buscarCampoTraducido('tipo_legal',$Til_IdTipoLegal,'Til_Nombre',$Idi_IdIdioma);
        $ContTradMal_Titulo = $this->buscarCampoTraducido('matriz_legal',$Mal_IdMatrizLegal,'Mal_Titulo',$Idi_IdIdioma);
        $ContTradMal_ResumenLegislacion = $this->buscarCampoTraducido('matriz_legal',$Mal_IdMatrizLegal,'Mal_ResumenLegislacion',$Idi_IdIdioma);
        $ContTradMal_PalabraClave = $this->buscarCampoTraducido('matriz_legal',$Mal_IdMatrizLegal,'Mal_PalabraClave',$Idi_IdIdioma);
        
        $idContTradNil_Nombre = $ContTradNil_Nombre['Cot_IdContenidoTraducido'];
        $idContTradSnl_Nombre = $ContTradSnl_Nombre['Cot_IdContenidoTraducido'];        
        $idContTradTel_Nombre = $ContTradTel_Nombre['Cot_IdContenidoTraducido'];
		$idContTradTil_Nombre = $ContTradTil_Nombre['Cot_IdContenidoTraducido'];
        $idContTradMal_Titulo = $ContTradMal_Titulo['Cot_IdContenidoTraducido'];
        $idContTradMal_ResumenLegislacion = $ContTradMal_ResumenLegislacion['Cot_IdContenidoTraducido'];        
        $idContTradMal_PalabraClave = $ContTradMal_PalabraClave['Cot_IdContenidoTraducido'];
        
        if(isset($idContTradNil_Nombre))
        {
            $this->_db->query(
                "UPDATE contenido_traducido SET Cot_Traduccion = '$Nil_Nombre' WHERE Cot_IdContenidoTraducido = $idContTradNil_Nombre"
            );
        }else{

            $this->_db->prepare(
           "INSERT INTO contenido_traducido VALUES (null, 'nivel_legal', :Cot_IdRegistro, 'Nil_Nombre', :Idi_IdIdioma, :Cot_Traduccion)"
           )                
           ->execute(array(
               ':Cot_IdRegistro' => $Nil_IdNivelLegal,
               ':Idi_IdIdioma' => $Idi_IdIdioma,
               ':Cot_Traduccion' => $Nil_Nombre                  
               ));
        }
        
        if(isset($idContTradSnl_Nombre))
        {
            $this->_db->query(
                "UPDATE contenido_traducido SET Cot_Traduccion = '$Snl_Nombre' WHERE Cot_IdContenidoTraducido = $idContTradSnl_Nombre"
            );
        }else{

            $this->_db->prepare(
           "INSERT INTO contenido_traducido VALUES (null, 'sub_nivel_legal', :Cot_IdRegistro, 'Snl_Nombre', :Idi_IdIdioma, :Cot_Traduccion)"
           )                
           ->execute(array(
               ':Cot_IdRegistro' => $Snl_IdSubNivelLegal,
               ':Idi_IdIdioma' => $Idi_IdIdioma,
               ':Cot_Traduccion' => $Snl_Nombre                  
               ));
        }
        
        if(isset($idContTradTel_Nombre))
        {
            $this->_db->query(
                "UPDATE contenido_traducido SET Cot_Traduccion = '$Tel_Nombre' WHERE Cot_IdContenidoTraducido = $idContTradTel_Nombre"
            );
        }else{

            $this->_db->prepare(
           "INSERT INTO contenido_traducido VALUES (null, 'tema_legal', :Cot_IdRegistro, 'Tel_Nombre', :Idi_IdIdioma, :Cot_Traduccion)"
           )                
           ->execute(array(
               ':Cot_IdRegistro' => $Tel_IdTemaLegal,
               ':Idi_IdIdioma' => $Idi_IdIdioma,
               ':Cot_Traduccion' => $Tel_Nombre                  
               ));
        }
		
		if(isset($idContTradTil_Nombre))
        {	
			$this->_db->query(
                "UPDATE contenido_traducido SET Cot_Traduccion = '$Til_Nombre' WHERE Cot_IdContenidoTraducido = $idContTradTil_Nombre"
            );
        }else{

            $this->_db->prepare(
           "INSERT INTO contenido_traducido VALUES (null, 'tipo_legal', :Cot_IdRegistro, 'Til_Nombre', :Idi_IdIdioma, :Cot_Traduccion)"
           )                
           ->execute(array(
               ':Cot_IdRegistro' => $Til_IdTipoLegal,
               ':Idi_IdIdioma' => $Idi_IdIdioma,
               ':Cot_Traduccion' => $Til_Nombre                  
               ));
        }
        
		
        if(isset($idContTradMal_Titulo))
        {
            $this->_db->query(
                "UPDATE contenido_traducido SET Cot_Traduccion = '$Mal_Titulo' WHERE Cot_IdContenidoTraducido = $idContTradMal_Titulo"
            );

        }else{

            $this->_db->prepare(
           "INSERT INTO contenido_traducido VALUES (null, 'matriz_legal', :Cot_IdRegistro, 'Mal_Titulo' , :Idi_IdIdioma, :Cot_Traduccion)"
           )                
           ->execute(array(
               ':Cot_IdRegistro' => $Mal_IdMatrizLegal,
               ':Idi_IdIdioma' => $Idi_IdIdioma,
               ':Cot_Traduccion' => $Mal_Titulo                  
               ));
        }

        if(isset($idContTradMal_ResumenLegislacion))
        {
            $this->_db->query(
                "UPDATE contenido_traducido SET Cot_Traduccion = '$Mal_ResumenLegislacion' WHERE Cot_IdContenidoTraducido = $idContTradMal_ResumenLegislacion"
            );

        }else{

            $this->_db->prepare(
           "INSERT INTO contenido_traducido VALUES (null, 'matriz_legal', :Cot_IdRegistro, 'Mal_ResumenLegislacion' , :Idi_IdIdioma, :Cot_Traduccion)"
           )                
           ->execute(array(
               ':Cot_IdRegistro' => $Mal_IdMatrizLegal,
               ':Idi_IdIdioma' => $Idi_IdIdioma,
               ':Cot_Traduccion' => $Mal_ResumenLegislacion                  
               ));
        }
        
        if(isset($idContTradMal_PalabraClave))
        {
            $this->_db->query(
                "UPDATE contenido_traducido SET Cot_Traduccion = '$Mal_PalabraClave' WHERE Cot_IdContenidoTraducido = $idContTradMal_PalabraClave"
            );

        }else{

            $this->_db->prepare(
           "INSERT INTO contenido_traducido VALUES (null, 'matriz_legal', :Cot_IdRegistro, 'Mal_PalabraClave' , :Idi_IdIdioma, :Cot_Traduccion)"
           )                
           ->execute(array(
               ':Cot_IdRegistro' => $Mal_IdMatrizLegal,
               ':Idi_IdIdioma' => $Idi_IdIdioma,
               ':Cot_Traduccion' => $Mal_PalabraClave                  
               ));
        }
        
    }
    

    public function buscarCampoTraducido($tabla,$IdRegistro,$columna,$Idi_IdIdioma)
    { 
        $post = $this->_db->query(
            "SELECT * FROM contenido_traducido WHERE Cot_Tabla = '$tabla' AND Cot_IdRegistro =  $IdRegistro AND  Cot_Columna = '$columna' AND Idi_IdIdioma= '$Idi_IdIdioma'"); 
        return $post->fetch();
    }
}

?>
