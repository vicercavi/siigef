<?php

class legalModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
	
    public function getLegislaciones($condicion = "")
    {
        $post = $this->_db->query(
                "SELECT STR_TO_DATE(mal.Mal_FechaPublicacion , '%d/%m/%Y') AS Mal_FechaPublicacion, mal.Mal_IdMatrizLegal, mal.Mal_Entidad, mal.Mal_Titulo, tel.Tel_Nombre, pai.Pai_Nombre,mal.Mal_TipoLegislacion FROM matriz_legal mal ".
				"INNER JOIN tema_legal tel ON mal.Tel_IdTemaLegal = tel.Tel_IdTemaLegal INNER JOIN pais pai ON mal.Pai_IdPais = pai.Pai_IdPais  $condicion ORDER BY Mal_FechaPublicacion DESC");				
        return $post->fetchAll();
    }
	
	public function getLegislacionesMetadata($condicion = "")
    {
        $post = $this->_db->query(
                "SELECT mal.*, tel.Tel_Nombre, snl.Snl_Nombre, nil.Nil_Nombre, pai.Pai_Nombre FROM matriz_legal mal 
INNER JOIN sub_nivel_legal snl ON mal.Snl_IdSubNivelLegal = snl.Snl_IdSubNivelLegal
INNER JOIN nivel_legal nil ON snl.Nil_IdNivelLegal= nil.Nil_IdNivelLegal
INNER JOIN tema_legal tel ON mal.Tel_IdTemaLegal = tel.Tel_IdTemaLegal 
INNER JOIN pais pai ON  mal.Pai_IdPais = pai.Pai_IdPais  $condicion");				
        return $post->fetchAll();
    }
	
	public function getCantidadTipoLegislacion($condicion = "")
    {
        $post = $this->_db->query(
                "SELECT COUNT(mal.Mal_IdMatrizLegal) AS cantidad,mal.Mal_PalabraClave FROM matriz_legal mal ".
				"INNER JOIN pais pai ON mal.Pai_IdPais = pai.Pai_IdPais ".
				"$condicion GROUP BY(mal.Mal_PalabraClave)  ");				
        return $post->fetchAll();
    }
	
	public function getCantidadTipoLegislacionPais($condicion = "")
    {
        $post = $this->_db->query(
                "SELECT COUNT(mal.Mal_IdMatrizLegal) AS cantidad,mal.Mal_TipoLegislacion FROM matriz_legal mal ".
				"INNER JOIN pais pai ON mal.Pai_IdPais = pai.Pai_IdPais ".
				"$condicion GROUP BY(mal.Mal_TipoLegislacion)  ");				
        return $post->fetchAll();
    }
	
	public function getCantidadLegislacionPais($condicion = "")
    {
        $post = $this->_db->query(
                "SELECT pa.*,sub.cantidad FROM pais pa
			     LEFT JOIN  (
                SELECT COUNT(mal.Mal_IdMatrizLegal) AS cantidad,pai.Pai_Nombre, pai.Pai_IdPais FROM matriz_legal mal 
				RIGHT JOIN pais pai ON mal.Pai_IdPais = pai.Pai_IdPais 	".
		        $condicion." GROUP BY(pai.Pai_Nombre) ORDER BY Mal_FechaPublicacion
				 ) AS sub ON sub.Pai_IdPais=pa.Pai_IdPais ORDER BY pa.Pai_Nombre
                ");				
        return $post->fetchAll();
    }
	
	public function getLegislacionesTipoLegislacion($condicion = "")
    {
        $post = $this->_db->query(
                "SELECT mal.Mal_Titulo,mal.Mal_Entidad,mal.Mal_IdMatrizLegal,mal.Mal_TipoLegislacion,STR_TO_DATE(mal.Mal_FechaPublicacion , '%d/%m/%Y') AS Mal_FechaPublicacion, pai.Pai_Nombre FROM matriz_legal mal
INNER JOIN pais pai ON mal.Pai_IdPais = pai.Pai_IdPais ".
				"$condicion ORDER BY Mal_FechaPublicacion DESC");				
        return $post->fetchAll();
    }	
    
	public function getPaises()
    {
        $post = $this->_db->query(
                "SELECT * FROM pais");				
        return $post->fetchAll();
    }	
    
	public function getPaiseseses($condicion = "")
    {
        $post = $this->_db->query(
                "SELECT mal.Mal_Titulo,mal.Mal_Entidad,mal.Mal_IdMatrizLegal,mal.Mal_TipoLegislacion,STR_TO_DATE(mal.Mal_FechaPublicacion , '%d/%m/%Y') AS Mal_FechaPublicacion, pai.Pai_Nombre FROM matriz_legal mal ".
				"INNER JOIN pais pai ON mal.Pai_IdPais = pai.Pai_IdPais ".
				"$condicion  ORDER BY Mal_FechaPublicacion DESC");				
        return $post->fetchAll();
    }	
    
}

?>
