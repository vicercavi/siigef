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
	
	public function getFichaDarwin($Esr_IdEstandarRecurso,$Idi_IdIdioma)
    {
        $post = $this->_db->query(
                "SELECT
Fie_IdFichaEstandar,
fn_TraducirContenido('ficha_estandar','Fie_CampoFicha',Fie_IdFichaEstandar,'$Idi_IdIdioma',Fie_CampoFicha) Fie_CampoFicha,
Esr_IdEstandarRecurso,
Fie_NombreTabla,
Fie_ColumnaTabla
FROM ficha_estandar
WHERE Esr_IdEstandarRecurso = $Esr_IdEstandarRecurso");				
        return $post->fetchAll();
    }
	
	public function getEstandarRecurso($rec_idrecurso)
    {
        $post = $this->_db->query(
                "SELECT Esr_IdEstandarRecurso FROM recurso WHERE rec_idrecurso = $rec_idrecurso");				
        return $post->fetchAll();
    }
	
	
	
	public function getPaises()
    {
        $post = $this->_db->query(
                "SELECT * FROM pais");				
        return $post->fetchAll();
    }
	
	public function registrarDarwinCore($Dar_FechaActualizacion,$Dar_CodigoInstitucion,$Dar_CodigoColeccion,$Dar_NumeroCatalogo,$Dar_NombreCientifico,$Dar_BaseRegistro,$Dar_ReinoOrganismo, $Dar_Division,$Dar_ClaseOrganismo, $Dar_OrdenOrganismo, $Dar_FamiliaOrganismo, $Dar_GeneroOrganismo,$Dar_EspecieOrganismo,$Dar_SubEspecieOrganismo,$Dar_AutorNombreCientifico,$Dar_IdentificadoPor,$Dar_AnoIdentificacion,$Dar_MesIdentificacion,$Dar_DiaIdentificacion,$Dar_StatusTipo,$Dar_NumeroColector,$Dar_NumeroCampo,$Dar_Colector,$Dar_AnoColectado,$Dar_MesColectado,$Dar_DiaColectado,$Dar_DiaOrdinario,$Dar_HoraColectado,$Dar_ContinenteOceano,$Dar_Pais,$Dar_EstadoProvincia,$Dar_Municipio,$Dar_Localidad,$Dar_Longitud,$Dar_Latitud,$Dar_PrecisionDeCordenada,$Dar_BoundingBox,$Dar_MinimaElevacion,$Dar_MaximaElevacion,$Dar_MinimaProfundidad,$Dar_MaximaProfundidad,$Dar_SexoOrganismo,$Dar_PreparacionTipo,$Dar_ConteoIndividuo,$Dar_NumeroCatalogoAnterior,$Dar_TipoRelacion,$Dar_InformacionRelacionada,$Dar_EstadoVida,$Dar_Nota,$Dar_NombreComunOrganismo,$Rec_IdRecurso)
    {
        $this->_db->prepare(
                "insert into darwin (Dar_FechaActualizacion,Dar_CodigoInstitucion,Dar_CodigoColeccion,Dar_NumeroCatalogo,Dar_NombreCientifico,Dar_BaseRegistro,Dar_Division, Dar_ReinoOrganismo, Dar_ClaseOrganismo, Dar_OrdenOrganismo, Dar_FamiliaOrganismo, Dar_GeneroOrganismo,Dar_EspecieOrganismo,Dar_SubEspecieOrganismo,Dar_AutorNombreCientifico,Dar_IdentificadoPor,Dar_AnoIdentificacion,Dar_MesIdentificacion,Dar_DiaIdentificacion,Dar_StatusTipo,Dar_NumeroColector,Dar_NumeroCampo,Dar_Colector,Dar_AnoColectado,Dar_MesColectado,Dar_DiaColectado,Dar_DiaOrdinario,Dar_HoraColectado,Dar_ContinenteOceano,Dar_Pais,Dar_EstadoProvincia,Dar_Municipio,Dar_Localidad,Dar_Longitud,Dar_Latitud,Dar_PrecisionDeCordenada,Dar_BoundingBox,Dar_MinimaElevacion,Dar_MaximaElevacion,Dar_MinimaProfundidad,Dar_MaximaProfundidad,Dar_SexoOrganismo,Dar_PreparacionTipo,Dar_ConteoIndividuo,Dar_NumeroCatalogoAnterior,Dar_TipoRelacion,Dar_InformacionRelacionada,Dar_EstadoVida,Dar_Nota,Dar_NombreComunOrganismo, Rec_IdRecurso, Dar_Estado) values " .
                "(:Dar_FechaActualizacion,:Dar_CodigoInstitucion,:Dar_CodigoColeccion,:Dar_NumeroCatalogo,:Dar_NombreCientifico,:Dar_BaseRegistro,:Dar_Division, :Dar_ReinoOrganismo, :Dar_ClaseOrganismo, :Dar_OrdenOrganismo, :Dar_FamiliaOrganismo,:Dar_GeneroOrganismo,:Dar_EspecieOrganismo,:Dar_SubEspecieOrganismo,:Dar_AutorNombreCientifico,:Dar_IdentificadoPor,:Dar_AnoIdentificacion,:Dar_MesIdentificacion,:Dar_DiaIdentificacion,:Dar_StatusTipo,:Dar_NumeroColector,:Dar_NumeroCampo,:Dar_Colector,:Dar_AnoColectado,:Dar_MesColectado,:Dar_DiaColectado,:Dar_DiaOrdinario,:Dar_HoraColectado,:Dar_ContinenteOceano,:Dar_Pais,:Dar_EstadoProvincia,:Dar_Municipio,:Dar_Localidad,:Dar_Longitud,:Dar_Latitud,:Dar_PrecisionDeCordenada,:Dar_BoundingBox,:Dar_MinimaElevacion,:Dar_MaximaElevacion,:Dar_MinimaProfundidad,:Dar_MaximaProfundidad,:Dar_SexoOrganismo,:Dar_PreparacionTipo,:Dar_ConteoIndividuo,:Dar_NumeroCatalogoAnterior,:Dar_TipoRelacion,:Dar_InformacionRelacionada,:Dar_EstadoVida,:Dar_Nota,:Dar_NombreComunOrganismo, :Rec_IdRecurso, 1)"
                )
                ->execute(array(
                    ':Dar_FechaActualizacion' => $Dar_FechaActualizacion,
                    ':Dar_CodigoInstitucion' => $Dar_CodigoInstitucion,
                    ':Dar_CodigoColeccion' => $Dar_CodigoColeccion,
					':Dar_NumeroCatalogo' => $Dar_NumeroCatalogo,
                    ':Dar_NombreCientifico' => $Dar_NombreCientifico,
					':Dar_BaseRegistro' => $Dar_BaseRegistro,
                    ':Dar_Division' => $Dar_Division,
					':Dar_ReinoOrganismo' => $Dar_ReinoOrganismo,
					':Dar_ClaseOrganismo' => $Dar_ClaseOrganismo,
					':Dar_OrdenOrganismo' => $Dar_OrdenOrganismo,
					':Dar_FamiliaOrganismo' => $Dar_FamiliaOrganismo,
                    ':Dar_GeneroOrganismo' => $Dar_GeneroOrganismo,
					':Dar_EspecieOrganismo' => $Dar_EspecieOrganismo,
                    ':Dar_SubEspecieOrganismo' => $Dar_SubEspecieOrganismo,
					':Dar_AutorNombreCientifico' => $Dar_AutorNombreCientifico,
                    ':Dar_IdentificadoPor' => $Dar_IdentificadoPor,
                    ':Dar_AnoIdentificacion' => $Dar_AnoIdentificacion,
					':Dar_MesIdentificacion' => $Dar_MesIdentificacion,
					':Dar_DiaIdentificacion' => $Dar_DiaIdentificacion,
                    ':Dar_StatusTipo' => $Dar_StatusTipo,
                    ':Dar_NumeroColector' => $Dar_NumeroColector,
					':Dar_NumeroCampo' => $Dar_NumeroCampo,
                    ':Dar_Colector' => $Dar_Colector,
					':Dar_AnoColectado' => $Dar_AnoColectado,
                    ':Dar_MesColectado' => $Dar_MesColectado,
                    ':Dar_DiaColectado' => $Dar_DiaColectado,
					':Dar_DiaOrdinario' => $Dar_DiaOrdinario,
                    ':Dar_HoraColectado' => $Dar_HoraColectado,
					':Dar_ContinenteOceano' => $Dar_ContinenteOceano,
                    ':Dar_Pais' => $Dar_Pais,
                    ':Dar_EstadoProvincia' => $Dar_EstadoProvincia,
					':Dar_Municipio' => $Dar_Municipio,
					':Dar_Localidad' => $Dar_Localidad,
                    ':Dar_Longitud' => $Dar_Longitud,
                    ':Dar_Latitud' => $Dar_Latitud,
					':Dar_PrecisionDeCordenada' => $Dar_PrecisionDeCordenada,
                    ':Dar_BoundingBox' => $Dar_BoundingBox,
					':Dar_MinimaElevacion' => $Dar_MinimaElevacion,
                    ':Dar_MaximaElevacion' => $Dar_MaximaElevacion,
                    ':Dar_MinimaProfundidad' => $Dar_MinimaProfundidad,
					':Dar_MaximaProfundidad' => $Dar_MaximaProfundidad,
                    ':Dar_SexoOrganismo' => $Dar_SexoOrganismo,
					':Dar_PreparacionTipo' => $Dar_PreparacionTipo,
                    ':Dar_ConteoIndividuo' => $Dar_ConteoIndividuo,
                    ':Dar_NumeroCatalogoAnterior' => $Dar_NumeroCatalogoAnterior,
					':Dar_TipoRelacion' => $Dar_TipoRelacion,
					':Dar_InformacionRelacionada' => $Dar_InformacionRelacionada,
                    ':Dar_EstadoVida' => $Dar_EstadoVida,
                    ':Dar_Nota' => $Dar_Nota,
					':Dar_NombreComunOrganismo' => $Dar_NombreComunOrganismo,
					':Rec_IdRecurso' => $Rec_IdRecurso
                ));
				
		$post = $this->_db->query("SELECT LAST_INSERT_ID()");				
        return $post->fetch();
    }
	
}

?>
