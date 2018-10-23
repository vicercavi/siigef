<?php

class legalModel extends Model
{
    public function __construct() 
    {
        parent::__construct();
    }
	
	public function getLegislaciones($condicion = "", $Idi_IdIdioma = "")
    {
        $post = $this->_db->query("SELECT fn_TraducirContenido('matriz_legal','Mal_Titulo',mal.Mal_IdMatrizLegal,
            '$Idi_IdIdioma',mal.Mal_Titulo) Mal_Titulo, fn_TraducirContenido('matriz_legal','Mal_PalabraClave', mal.Mal_IdMatrizLegal,'$Idi_IdIdioma',
            mal.Mal_PalabraClave) Mal_PalabraClave, fn_TraducirContenido('matriz_legal','Mal_ResumenLegislacion',mal.Mal_IdMatrizLegal,'$Idi_IdIdioma',
            mal.Mal_ResumenLegislacion) Mal_ResumenLegislacion, fn_TraducirContenido('tipo_legal','Til_Nombre',til.Til_IdTipoLegal,'$Idi_IdIdioma',
            til.Til_Nombre) Til_Nombre, STR_TO_DATE(mal.Mal_FechaPublicacion , '%d/%m/%Y') Mal_FechaPublicacion, mal.Mal_IdMatrizLegal, mal.Mal_Entidad,
            mal.Mal_Titulo, mal.Mal_Estado, pai.Pai_Nombre, fn_devolverIdioma('matriz_legal',mal.Mal_IdMatrizLegal,'$Idi_IdIdioma',mal.Idi_IdIdioma)
            Idi_IdIdioma
            FROM matriz_legal mal
            INNER JOIN pais pai ON mal.Pai_IdPais = pai.Pai_IdPais
            INNER JOIN tipo_legal til ON mal.Til_IdTipoLegal = til.Til_IdTipoLegal
            INNER JOIN recurso rec ON mal.Rec_IdRecurso = rec.Rec_IdRecurso
            $condicion ORDER BY Mal_FechaPublicacion DESC ");				
        return $post->fetchAll();
    }

	public function getCantidadTipoLegislacion($Idi_IdIdioma = "")
    {
        $post = $this->_db->query("SELECT tip.*,t.cantidad from tipo_legal tip
            left join (SELECT COUNT(mal.Mal_IdMatrizLegal) cantidad, fn_TraducirContenido('tipo_legal','Til_Nombre',til.Til_IdTipoLegal,'$Idi_IdIdioma',
            til.Til_Nombre) Til_Nombre, til.Til_IdTipoLegal 
            FROM matriz_legal mal
            INNER JOIN tipo_legal til ON mal.Til_IdTipoLegal = til.Til_IdTipoLegal
            INNER JOIN recurso rec ON mal.Rec_IdRecurso = rec.Rec_IdRecurso
            WHERE rec.Rec_Estado = 1 AND mal.Mal_Estado = 1
            GROUP BY Til_Nombre) t on tip.Til_IdTipoLegal = t.Til_IdTipoLegal ORDER BY tip.Til_Nombre ASC  ");				
        return $post->fetchAll();
    }
    public function getCantidadTipoLegislacionV2($condicion = "", $Idi_IdIdioma = "")
    {        
        $post = $this->_db->query("SELECT tip.Til_Nombre,t.cantidad FROM tipo_legal tip
                LEFT JOIN (SELECT COUNT(mal.Mal_IdMatrizLegal) cantidad, fn_TraducirContenido('tipo_legal','Til_Nombre',til.Til_IdTipoLegal,'$Idi_IdIdioma',
                til.Til_Nombre) Til_Nombre, til.Til_IdTipoLegal
                FROM matriz_legal mal
                INNER JOIN pais pai ON mal.Pai_IdPais = pai.Pai_IdPais 
                INNER JOIN tipo_legal til ON mal.Til_IdTipoLegal = til.Til_IdTipoLegal
                INNER JOIN recurso rec ON mal.Rec_IdRecurso = rec.Rec_IdRecurso
                $condicion
                GROUP BY Til_Nombre) t ON tip.Til_IdTipoLegal = t.Til_IdTipoLegal ORDER BY t.cantidad DESC ,tip.Til_Nombre ASC");              
        return $post->fetchAll();
    }
	
	public function getCantidadLegislacionPais($Idi_IdIdioma = "")
    {
        $post = $this->_db->query("SELECT pa.*,sub.cantidad FROM pais pa
            LEFT JOIN (SELECT COUNT(m.Mal_IdMatrizLegal) AS cantidad, m.Pai_Nombre, m.Pai_IdPais 
            FROM (SELECT mal.Mal_IdMatrizLegal, mal.Pai_IdPais, pai.Pai_Nombre
            FROM matriz_legal mal
            INNER JOIN pais pai ON mal.Pai_IdPais = pai.Pai_IdPais
            INNER JOIN recurso rec ON mal.Rec_IdRecurso = rec.Rec_IdRecurso
            WHERE rec.Rec_Estado = 1 AND mal.Mal_Estado = 1 ) m 
            GROUP BY(m.Pai_Nombre) ) sub ON sub.Pai_IdPais=pa.Pai_IdPais ORDER BY pa.Pai_Nombre");				
        return $post->fetchAll();
    }
    public function getCantidadLegislacionPaisV2($condicion = "", $Idi_IdIdioma = "")
    {
        $post = $this->_db->query(
                "SELECT pa.Pai_Nombre,sub.cantidad FROM pais pa
                LEFT JOIN 
                (SELECT COUNT(mal.Mal_IdMatrizLegal) AS cantidad, pai.Pai_Nombre, pai.Pai_IdPais
                FROM matriz_legal mal
                INNER JOIN pais pai ON mal.Pai_IdPais = pai.Pai_IdPais
                INNER JOIN tipo_legal til ON mal.Til_IdTipoLegal = til.Til_IdTipoLegal
                INNER JOIN recurso rec ON mal.Rec_IdRecurso = rec.Rec_IdRecurso
                $condicion
                GROUP BY(pai.Pai_Nombre) ) sub ON sub.Pai_IdPais=pa.Pai_IdPais ORDER BY pa.Pai_Nombre");             
        return $post->fetchAll();
    }
	
	public function getLegislacionesMetadata($condicion = "", $Idi_IdIdioma = "")
    {
        $post = $this->_db->query(
            "SELECT STR_TO_DATE(m.Mal_FechaPublicacion , '%d/%m/%Y') Mal_FechaPublicacion,
            m.Mal_IdMatrizLegal, m.Mal_Entidad, m.Mal_NumeroNormas, m.Mal_ArticuloAplicable, m.Mal_FechaRevision, m.Mal_NormasComplementarias,
            m.Mal_Estado, m.Rec_IdRecurso, fn_TraducirContenido('matriz_legal','Mal_Titulo',m.Mal_IdMatrizLegal,'$Idi_IdIdioma',m.Mal_Titulo) Mal_Titulo,
            fn_TraducirContenido('matriz_legal','Mal_PalabraClave',m.Mal_IdMatrizLegal,'$Idi_IdIdioma',m.Mal_PalabraClave) Mal_PalabraClave,
            fn_TraducirContenido('matriz_legal','Mal_ResumenLegislacion',m.Mal_IdMatrizLegal,'$Idi_IdIdioma',m.Mal_ResumenLegislacion) 
            Mal_ResumenLegislacion, fn_TraducirContenido('tipo_legal','Til_Nombre',til.Til_IdTipoLegal,'$Idi_IdIdioma',til.Til_Nombre) Til_Nombre,
            tel.Tel_Nombre, snl.Snl_Nombre, nil.Nil_Nombre, pai.Pai_Nombre 
            FROM matriz_legal m
            INNER JOIN tema_legal tel ON m.Tel_IdTemaLegal = tel.Tel_IdTemaLegal
            INNER JOIN sub_nivel_legal snl ON tel.Snl_IdSubNivelLegal = snl.Snl_IdSubNivelLegal
            INNER JOIN nivel_legal nil ON snl.Nil_IdNivelLegal= nil.Nil_IdNivelLegal
            INNER JOIN pais pai ON  m.Pai_IdPais = pai.Pai_IdPais
            INNER JOIN tipo_legal til ON m.Til_IdTipoLegal = til.Til_IdTipoLegal
            INNER JOIN recurso rec ON m.Rec_IdRecurso = rec.Rec_IdRecurso $condicion");				
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
	
	public function getLegislacionesTipoLegislacion($condicion = "")
    {
        $post = $this->_db->query(
                "SELECT mal.Mal_Titulo,mal.Mal_Entidad,mal.Mal_IdMatrizLegal,mal.Mal_TipoLegislacion,STR_TO_DATE(mal.Mal_FechaPublicacion , '%d/%m/%Y') 
                AS Mal_FechaPublicacion, pai.Pai_Nombre FROM matriz_legal mal
                INNER JOIN pais pai ON mal.Pai_IdPais = pai.Pai_IdPais ".
				"$condicion ORDER BY Mal_FechaPublicacion DESC");				
        return $post->fetchAll();
    }	
    
    public function getLegalTraducido($condicion = "", $Idi_IdIdioma)
    {
        $post = $this->_db->query(
                "SELECT ml.* FROM ( 
                    SELECT   
                    mal.Mal_IdMatrizLegal, 			
                    mal.Mal_FechaPublicacion, mal.Mal_Entidad, mal.Mal_NumeroNormas,
                    fn_TraducirContenido('matriz_legal','Mal_Titulo',mal.Mal_IdMatrizLegal,'$Idi_IdIdioma',mal.Mal_Titulo) Mal_Titulo,
                    mal.Mal_ArticuloAplicable, 
                    fn_TraducirContenido('matriz_legal','Mal_ResumenLegislacion',mal.Mal_IdMatrizLegal,'$Idi_IdIdioma',mal.Mal_ResumenLegislacion) Mal_ResumenLegislacion,
                    mal.Mal_FechaRevision, mal.Mal_NormasComplemaentarias, mal.Mal_TipoLegislacion,
                    mal.Tel_IdTemaLegal, mal.Pai_IdPais, mal.Rec_IdRecurso, 
                    fn_TraducirContenido('matriz_legal','Mal_PalabraClave',mal.Mal_IdMatrizLegal,'$Idi_IdIdioma',mal.Mal_PalabraClave) Mal_PalabraClave,
                    mal.Mal_Estado, 
                    fn_TraducirContenido('tema_legal','Tel_Nombre',tel.Tel_IdTemaLegal,'$Idi_IdIdioma',tel.Tel_Nombre) Tel_Nombre,
                    snl.Snl_IdSubNivelLegal, 
                    fn_TraducirContenido('sub_nivel_legal','Snl_Nombre',snl.Snl_IdSubNivelLegal,'$Idi_IdIdioma',snl.Snl_Nombre) Snl_Nombre,
                    nil.Nil_IdNivelLegal, 
                    fn_TraducirContenido('nivel_legal','Nil_Nombre',nil.Nil_IdNivelLegal,'$Idi_IdIdioma',nil.Nil_Nombre) Nil_Nombre,
                    pai.Pai_Nombre,
                    fn_devolverIdioma('matriz_legal',mal.Mal_IdMatrizLegal,'$Idi_IdIdioma',mal.Idi_IdIdioma) Idi_IdIdioma
                    FROM matriz_legal mal 
                    INNER JOIN tema_legal tel ON mal.Tel_IdTemaLegal = tel.Tel_IdTemaLegal
                    INNER JOIN sub_nivel_legal snl ON tel.Snl_IdSubNivelLegal = snl.Snl_IdSubNivelLegal
                    INNER JOIN nivel_legal nil ON snl.Nil_IdNivelLegal= nil.Nil_IdNivelLegal
                    INNER JOIN pais pai ON  mal.Pai_IdPais = pai.Pai_IdPais) ml  $condicion");				
        return $post->fetchAll();
    }

    public function _cambiarEstadoLegislacion($id_legislacion, $nuevo_estado)
    {
        $consulta = $this->_db->query("UPDATE matriz_legal SET Mal_Estado = $nuevo_estado WHERE Mal_IdMatrizLegal= $id_legislacion");        
        
        return $consulta->rowCount(PDO::FETCH_ASSOC);
    }

    public function eliminarLegislacion($id_legislacion) 
    {
        try 
        {            
            $consulta = $this->_db->query("DELETE FROM matriz_legal WHERE Mal_IdMatrizLegal = $id_legislacion");
            return $consulta->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("legislacion(LegalModel)", "eliminarLegislacion", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }
}

?>
