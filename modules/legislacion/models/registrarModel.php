<?php

class registrarModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
	
	public function getIdiomas()
    {
        $post = $this->_db->query(
                "SELECT * FROM idioma");				
        return $post->fetchAll();
    }
	
	public function getFichaLegislacion($Esr_IdEstandarRecurso)
    {
        $post = $this->_db->query(
                "SELECT * FROM ficha_estandar WHERE Esr_IdEstandarRecurso = $Esr_IdEstandarRecurso");				
        return $post->fetchAll();
    }
	
	public function getEstandarRecurso($rec_idrecurso)
    {
        $post = $this->_db->query(
                "SELECT Esr_IdEstandarRecurso FROM recurso WHERE rec_idrecurso = $rec_idrecurso");				
        return $post->fetchAll();
    }
	
	public function getNombreNivelLegislacion($Idi_IdIdioma) {
        $post = $this->_db->query("SELECT * FROM nivel_legal WHERE Idi_IdIdioma='$Idi_IdIdioma'");
        return $post->fetchAll();
    }
	
	public function getNombreTipoLegislacion($Idi_IdIdioma) {
        $post = $this->_db->query("SELECT * FROM tipo_legal WHERE Idi_IdIdioma='$Idi_IdIdioma'");
        return $post->fetchAll();
    }
    
	public function getNivelLegislacion($Nil_Nombre,$Idi_IdIdioma)
    {
        $post = $this->_db->query(
                "SELECT nil.Nil_IdNivelLegal FROM nivel_legal nil
                WHERE fn_TraducirContenido('nivel_legal','Nil_Nombre',nil.Nil_IdNivelLegal,'$Idi_IdIdioma',nil.Nil_Nombre) = '$Nil_Nombre'");				
        return $post->fetch();
    }
	
	public function registrarNivelLegal($Nil_Nombre, $Idi_IdIdioma)
    {
        $this->_db->prepare(
                "insert into nivel_legal (Nil_Nombre, Idi_IdIdioma) values " .
                "(:Nil_Nombre, :Idi_IdIdioma)"
                )
                ->execute(array(
                    ':Nil_Nombre' => $Nil_Nombre,
                    ':Idi_IdIdioma' => $Idi_IdIdioma
                ));
		$post = $this->_db->query("SELECT LAST_INSERT_ID()");				
        return $post->fetch();
    }
	
	public function getNombreSubNivelLegislacion($Idi_IdIdioma) {
        $post = $this->_db->query("SELECT * FROM sub_nivel_legal WHERE Idi_IdIdioma='$Idi_IdIdioma'");
        return $post->fetchAll();
    }
	
	public function getPalabraClave($Idi_IdIdioma)
    {
        try {         
            $sql = "call s_s_Listar_PalabraClave_matriz_legal(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $Idi_IdIdioma, PDO::PARAM_STR);
            $result->execute();
            return $result->fetchAll();
        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
    }
	
	public function getSubNivelLegislacion($Snl_Nombre, $Nil_IdNivelLegal, $Idi_IdIdioma)
    {
        $post = $this->_db->query(
                "SELECT snl_idsubnivellegal FROM sub_nivel_legal where fn_TraducirContenido('sub_nivel_legal','Snl_Nombre',Snl_IdSubNivelLegal,'$Idi_IdIdioma',Snl_Nombre) = '$Snl_Nombre' AND Nil_IdNivelLegal = $Nil_IdNivelLegal");				
        return $post->fetch();
    }
	
	public function registrarSubNivelLegal($Snl_Nombre, $Nil_IdNivelLegal, $Idi_IdIdioma)
    {            
        $this->_db->prepare(
                "insert into sub_nivel_legal (Snl_Nombre, Nil_IdNivelLegal, Idi_IdIdioma) values " .
                "(:Snl_Nombre, :Nil_IdNivelLegal, :Idi_IdIdioma)"
                )
                ->execute(array(
                    ':Snl_Nombre' => $Snl_Nombre,
                    ':Nil_IdNivelLegal' => $Nil_IdNivelLegal,
                    ':Idi_IdIdioma' => $Idi_IdIdioma
                ));
		$post = $this->_db->query("SELECT LAST_INSERT_ID()");				
        return $post->fetch();
    }
	
	public function getNombreTemaLegal($Idi_IdIdioma) 
    {
        $post = $this->_db->query("SELECT * FROM tema_legal WHERE Idi_IdIdioma='$Idi_IdIdioma'");
        return $post->fetchAll();
    }
	
	
	public function getTemaLegal($Tel_Nombre, $Snl_IdSubNivelLegal,$Idi_IdIdioma)
    {
        $post = $this->_db->query(
                "SELECT * FROM tema_legal WHERE fn_TraducirContenido('tema_legal','Tel_Nombre',Tel_IdTemaLegal,'$Idi_IdIdioma',Tel_Nombre) = '$Tel_Nombre' AND Snl_IdSubNivelLegal = $Snl_IdSubNivelLegal");				
        return $post->fetch();
    }
	
	public function registrarTemaLegal($Tel_Nombre, $Snl_IdSubNivelLegal, $Idi_IdIdioma)
    {
        $this->_db->prepare(
                "insert into tema_legal (Tel_Nombre,Snl_IdSubNivelLegal, Idi_IdIdioma) values " .
                "(:Tel_Nombre, :Snl_IdSubNivelLegal, :Idi_IdIdioma)"
                )
                ->execute(array(
                    ':Tel_Nombre' => $Tel_Nombre,
                    ':Snl_IdSubNivelLegal' => $Snl_IdSubNivelLegal,
                    ':Idi_IdIdioma' => $Idi_IdIdioma
                ));
		$post = $this->_db->query("SELECT LAST_INSERT_ID()");				
        return $post->fetch();
    }
	
	
	public function getTipoLegal($Til_Nombre, $Idi_IdIdioma)
    {
        $post = $this->_db->query(
                "SELECT * FROM tipo_legal 
WHERE fn_TraducirContenido('tipo_legal','Til_Nombre',Til_IdTipoLegal,'$Idi_IdIdioma',Til_Nombre) = '$Til_Nombre'");				
        return $post->fetch();
    }
	
	public function registrarTipoLegal($Til_Nombre, $Idi_IdIdioma)
    {
        $this->_db->prepare(
                "INSERT INTO tipo_legal (Til_Nombre, Idi_IdIdioma) values " .
                "(:Til_Nombre, :Idi_IdIdioma)"
                )
                ->execute(array(
                    ':Til_Nombre' => $Til_Nombre,                    
                    ':Idi_IdIdioma' => $Idi_IdIdioma
                ));
		$post = $this->_db->query("SELECT LAST_INSERT_ID()");				
        return $post->fetch();
    }	
	
	public function getPaises()
    {
        $post = $this->_db->query(
                "SELECT * FROM pais");				
        return $post->fetchAll();
    }
	
	public function verificarTitulo($titulo,$tema,$pais,$Idi_IdIdioma)
	{
            $id = $this->_db->query(
            "SELECT * FROM matriz_legal where fn_TraducirContenido('matriz_legal','Mal_Titulo',Mal_IdMatrizLegal,'$Idi_IdIdioma',Mal_Titulo) = '$titulo' and tel_idtemalegal = '$tema' and pai_idpais = '$pais'");
            if($id->fetch()){
                return true;
            }
            return false;
	}
	
	public function registrarLegislacion($Mal_FechaPublicacion, $Mal_Entidad, $Mal_NumeroNormas, $Mal_Titulo, $Mal_ArticuloAplicable, $Mal_ResumenLegislacion, $Mal_FechaRevision, $Mal_NormasComplementarias,$Til_IdTipoLegal, $Tel_IdTemaLegal, $Pai_IdPais, $Rec_IdRecurso, $Idi_IdIdioma, $Mal_PalabraClave)
    {
    	
        $this->_db->prepare(
                "insert into matriz_legal (Mal_FechaPublicacion,Mal_Entidad,Mal_NumeroNormas,Mal_Titulo,Mal_ArticuloAplicable,Mal_ResumenLegislacion,Mal_FechaRevision,Mal_NormasComplementarias,Til_IdTipoLegal,Tel_IdTemaLegal,Pai_IdPais, Rec_IdRecurso, Idi_IdIdioma, Mal_PalabraClave, Mal_Estado) values " .
                "(:Mal_FechaPublicacion, :Mal_Entidad, :Mal_NumeroNormas, :Mal_Titulo, :Mal_ArticuloAplicable, :Mal_ResumenLegislacion, :Mal_FechaRevision, :Mal_NormasComplementarias, :Til_IdTipoLegal, :Tel_IdTemaLegal, :Pai_IdPais, :Rec_IdRecurso, :Idi_IdIdioma, :Mal_PalabraClave,1)"
                )
                ->execute(array(
                    ':Mal_FechaPublicacion' => $Mal_FechaPublicacion,
                    ':Mal_Entidad' => $Mal_Entidad,
                    ':Mal_NumeroNormas' => $Mal_NumeroNormas,
                    ':Mal_Titulo' => $Mal_Titulo,
                    ':Mal_ArticuloAplicable' => $Mal_ArticuloAplicable,
                    ':Mal_ResumenLegislacion' => $Mal_ResumenLegislacion,
                    ':Mal_FechaRevision' => $Mal_FechaRevision,
                    ':Mal_NormasComplementarias' => $Mal_NormasComplementarias,
                    ':Til_IdTipoLegal' => $Til_IdTipoLegal,
                    ':Tel_IdTemaLegal' => $Tel_IdTemaLegal,
                    ':Pai_IdPais' => $Pai_IdPais,
                    ':Rec_IdRecurso' => $Rec_IdRecurso,
                    ':Idi_IdIdioma' => $Idi_IdIdioma,
                    ':Mal_PalabraClave' => $Mal_PalabraClave
                ));
				
		$post = $this->_db->query("SELECT LAST_INSERT_ID()");				
        return $post->fetch();
		
    }    	
    public function editarLegislacion($Mal_FechaPublicacion, $Mal_Entidad, $Mal_NumeroNormas, $Mal_Titulo, $Mal_ArticuloAplicable, $Mal_ResumenLegislacion, $Mal_FechaRevision, $Mal_NormasComplementarias,$Til_IdTipoLegal, $Tel_IdTemaLegal, $Pai_IdPais, $Rec_IdRecurso, $Idi_IdIdioma, $Mal_PalabraClave, $Mal_IdMatrizLegal)
    {
    	$post = $this->_db->query(
                "UPDATE matriz_legal SET Mal_FechaPublicacion = '$Mal_FechaPublicacion',Mal_Entidad='$Mal_Entidad',Mal_NumeroNormas= '$Mal_NumeroNormas',Mal_Titulo='$Mal_Titulo',Mal_ArticuloAplicable='$Mal_ArticuloAplicable',Mal_ResumenLegislacion='$Mal_ResumenLegislacion',Mal_FechaRevision='$Mal_FechaRevision',
                Mal_NormasComplementarias='$Mal_NormasComplementarias',Til_IdTipoLegal=$Til_IdTipoLegal,Tel_IdTemaLegal=$Tel_IdTemaLegal,Pai_IdPais=$Pai_IdPais, Rec_IdRecurso=$Rec_IdRecurso, Idi_IdIdioma='$Idi_IdIdioma', Mal_PalabraClave='$Mal_PalabraClave' WHERE Mal_IdMatrizLegal = $Mal_IdMatrizLegal" 
               ); 	
        return $post->rowCount();
    }
    
    
}

?>
