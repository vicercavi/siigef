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
	
	public function getFichaLegislacion($Esr_IdEstandarRecurso,$Idi_IdIdioma)
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
	
	
	public function registrarPlinianCore($Pli_Idioma,$Pli_NombreCientifico,$Pli_AcronimoInstitucion,$Pli_FechaUltimaModificacion,$Pli_IdRegistroTaxon,$Pli_CitaSugerida,$Pli_Distribucion,$Pli_DescripcionGeneral,$Pli_Reino,$Pli_Phylum,$Pli_Clase,$Pli_Orden,$Pli_Familia,$Pli_Genero,$Pli_Sinonimia,$Pli_AutorFechaTaxon,$Pli_EspeciesReferenciasPublicacion,$Pli_NombresComunes,$Pli_InformacionTipos,$Pli_IdentificadorUnicoGlobal,$Pli_Colaboradores,$Pli_FechaCreacion,$Pli_Habito,$Pli_CicloVida,$Pli_Reproduccion,$Pli_CicloAnual,$Pli_DescripcionCientifica,$Pli_BreveDescripcion,$Pli_Alimentacion,$Pli_Comportamiento,$Pli_Interacciones,$Pli_NumeroCromosomas,$Pli_DatosMoleculares,$Pli_EstadoActPoblacion,$Pli_EstadoUICN,$Pli_EstadoLegNacional,$Pli_Habitat,$Pli_Territorialidad,$Pli_Endemismo,$Pli_Usos,$Pli_Manejo,$Pli_Folklore,$Pli_ReferenciasBibliograficas,$Pli_DocumentacionNoEstructurada,$Pli_OtraFuenteInformacion,$Pli_ArticuloCientifico,$Pli_ClavesTaxonomicas,$Pli_DatosMigrados,$Pli_ImportanciaEcologica,$Pli_HistoriaNaturalNoEstructurada,$Pli_DatosInvasividad,$Pli_PublicoObjetivo,$Pli_Version,$Pli_URLImagen1,$Pli_PieImagen1,$Pli_URLImagen2,$Pli_PieImagen2,$Pli_URLImagen3,$Pli_PieImagen3,$Pli_Imagen,$Rec_IdRecurso)
    {
        $this->_db->prepare(
                "insert into plinian (Pli_Idioma,Pli_NombreCientifico,Pli_AcronimoInstitucion,Pli_FechaUltimaModificacion,Pli_IdRegistroTaxon,Pli_CitaSugerida,Pli_Distribucion,Pli_DescripcionGeneral,Pli_Reino,Pli_Phylum,Pli_Clase,Pli_Orden,Pli_Familia,Pli_Genero,Pli_Sinonimia,Pli_AutorFechaTaxon,Pli_EspeciesReferenciasPublicacion,Pli_NombresComunes,Pli_InformacionTipos,Pli_IdentificadorUnicoGlobal,Pli_Colaboradores,Pli_FechaCreacion,Pli_Habito,Pli_CicloVida,Pli_Reproduccion,Pli_CicloAnual,Pli_DescripcionCientifica,Pli_BreveDescripcion,Pli_Alimentacion,Pli_Comportamiento,Pli_Interacciones,Pli_NumeroCromosomas,Pli_DatosMoleculares,Pli_EstadoActPoblacion,Pli_EstadoUICN,Pli_EstadoLegNacional,Pli_Habitat,Pli_Territorialidad,Pli_Endemismo,Pli_Usos,Pli_Manejo,Pli_Folklore,Pli_ReferenciasBibliograficas,Pli_DocumentacionNoEstructurada,Pli_OtraFuenteInformacion,Pli_ArticuloCientifico,Pli_ClavesTaxonomicas,Pli_DatosMigrados,Pli_ImportanciaEcologica,Pli_HistoriaNaturalNoEstructurada,Pli_DatosInvasividad,Pli_PublicoObjetivo,Pli_Version,Pli_URLImagen1,Pli_PieImagen1,Pli_URLImagen2,Pli_PieImagen2,Pli_URLImagen3,Pli_PieImagen3,Pli_Imagen,Rec_IdRecurso, Pli_Estado) values " .
                "(:Pli_Idioma,:Pli_NombreCientifico,:Pli_AcronimoInstitucion,:Pli_FechaUltimaModificacion,:Pli_IdRegistroTaxon,:Pli_CitaSugerida,:Pli_Distribucion,:Pli_DescripcionGeneral,:Pli_Reino,:Pli_Phylum,:Pli_Clase,:Pli_Orden,:Pli_Familia,:Pli_Genero,:Pli_Sinonimia,:Pli_AutorFechaTaxon,:Pli_EspeciesReferenciasPublicacion,:Pli_NombresComunes,:Pli_InformacionTipos,:Pli_IdentificadorUnicoGlobal,:Pli_Colaboradores,:Pli_FechaCreacion,:Pli_Habito,:Pli_CicloVida,:Pli_Reproduccion,:Pli_CicloAnual,:Pli_DescripcionCientifica,:Pli_BreveDescripcion,:Pli_Alimentacion,:Pli_Comportamiento,:Pli_Interacciones,:Pli_NumeroCromosomas,:Pli_DatosMoleculares,:Pli_EstadoActPoblacion,:Pli_EstadoUICN,:Pli_EstadoLegNacional,:Pli_Habitat,:Pli_Territorialidad,:Pli_Endemismo,:Pli_Usos,:Pli_Manejo,:Pli_Folklore,:Pli_ReferenciasBibliograficas,:Pli_DocumentacionNoEstructurada,:Pli_OtraFuenteInformacion,:Pli_ArticuloCientifico,:Pli_ClavesTaxonomicas,:Pli_DatosMigrados,:Pli_ImportanciaEcologica,:Pli_HistoriaNaturalNoEstructurada,:Pli_DatosInvasividad,:Pli_PublicoObjetivo,:Pli_Version,:Pli_URLImagen1,:Pli_PieImagen1,:Pli_URLImagen2,:Pli_PieImagen2,:Pli_URLImagen3,:Pli_PieImagen3,:Pli_Imagen,:Rec_IdRecurso,1)"
                )
                ->execute(array(
                    ':Pli_Idioma' => $Pli_Idioma,
                    ':Pli_NombreCientifico' => $Pli_NombreCientifico,
                    ':Pli_AcronimoInstitucion' => $Pli_AcronimoInstitucion,
					':Pli_FechaUltimaModificacion' => $Pli_FechaUltimaModificacion,
                    ':Pli_IdRegistroTaxon' => $Pli_IdRegistroTaxon,
					':Pli_CitaSugerida' => $Pli_CitaSugerida,
                    ':Pli_Distribucion' => $Pli_Distribucion,
					':Pli_DescripcionGeneral' => $Pli_DescripcionGeneral,
					':Pli_Reino' => $Pli_Reino,
					':Pli_Phylum' => $Pli_Phylum,
					':Pli_Clase' => $Pli_Clase,
                    ':Pli_Orden' => $Pli_Orden,
					':Pli_Familia' => $Pli_Familia,
                    ':Pli_Genero' => $Pli_Genero,
					':Pli_Sinonimia' => $Pli_Sinonimia,
                    ':Pli_AutorFechaTaxon' => $Pli_AutorFechaTaxon,
                    ':Pli_EspeciesReferenciasPublicacion' => $Pli_EspeciesReferenciasPublicacion,
					':Pli_NombresComunes' => $Pli_NombresComunes,
					':Pli_InformacionTipos' => $Pli_InformacionTipos,
                    ':Pli_IdentificadorUnicoGlobal' => $Pli_IdentificadorUnicoGlobal,
                    ':Pli_Colaboradores' => $Pli_Colaboradores,
					':Pli_FechaCreacion' => $Pli_FechaCreacion,
                    ':Pli_Habito' => $Pli_Habito,
					':Pli_CicloVida' => $Pli_CicloVida,
                    ':Pli_Reproduccion' => $Pli_Reproduccion,
                    ':Pli_CicloAnual' => $Pli_CicloAnual,
					':Pli_DescripcionCientifica' => $Pli_DescripcionCientifica,
                    ':Pli_BreveDescripcion' => $Pli_BreveDescripcion,
					':Pli_Alimentacion' => $Pli_Alimentacion,
                    ':Pli_Comportamiento' => $Pli_Comportamiento,
                    ':Pli_Interacciones' => $Pli_Interacciones,
					':Pli_NumeroCromosomas' => $Pli_NumeroCromosomas,
					':Pli_DatosMoleculares' => $Pli_DatosMoleculares,
                    ':Pli_EstadoActPoblacion' => $Pli_EstadoActPoblacion,
                    ':Pli_EstadoUICN' => $Pli_EstadoUICN,
					':Pli_EstadoLegNacional' => $Pli_EstadoLegNacional,
                    ':Pli_Habitat' => $Pli_Habitat,
					':Pli_Territorialidad' => $Pli_Territorialidad,
                    ':Pli_Endemismo' => $Pli_Endemismo,
                    ':Pli_Usos' => $Pli_Usos,
					':Pli_Manejo' => $Pli_Manejo,
                    ':Pli_Folklore' => $Pli_Folklore,
					':Pli_ReferenciasBibliograficas' => $Pli_ReferenciasBibliograficas,
                    ':Pli_DocumentacionNoEstructurada' => $Pli_DocumentacionNoEstructurada,
                    ':Pli_OtraFuenteInformacion' => $Pli_OtraFuenteInformacion,
					':Pli_ArticuloCientifico' => $Pli_ArticuloCientifico,
					':Pli_ClavesTaxonomicas' => $Pli_ClavesTaxonomicas,
                    ':Pli_DatosMigrados' => $Pli_DatosMigrados,
                    ':Pli_ImportanciaEcologica' => $Pli_ImportanciaEcologica,
					':Pli_HistoriaNaturalNoEstructurada' => $Pli_HistoriaNaturalNoEstructurada,
					':Pli_DatosInvasividad' => $Pli_DatosInvasividad,
					':Pli_PublicoObjetivo' => $Pli_PublicoObjetivo,
					':Pli_Version' => $Pli_Version,
                    ':Pli_URLImagen1' => $Pli_URLImagen1,
                    ':Pli_PieImagen1' => $Pli_PieImagen1,
					':Pli_URLImagen2' => $Pli_URLImagen2,
					':Pli_PieImagen2' => $Pli_PieImagen2,
                    ':Pli_URLImagen3' => $Pli_URLImagen3,
                    ':Pli_PieImagen3' => $Pli_PieImagen3,
					':Pli_Imagen' => $Pli_Imagen,
					':Rec_IdRecurso' => $Rec_IdRecurso
                ));
				
		$post = $this->_db->query("SELECT LAST_INSERT_ID()");				
        return $post->fetch();
    }
	
}

?>
