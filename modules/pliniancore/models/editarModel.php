<?php

class editarModel extends Model
{
    public function __construct() {
        parent::__construct();
    }
	
	public function getPlinian($condicion = "")
    {
        $post = $this->_db->query(
            " SELECT * FROM plinian  $condicion"
             );     
        return $post->fetch();
    }
	
	public function registrarPlinianCore($Pli_Idioma,$Pli_NombreCientifico,$Pli_AcronimoInstitucion,$Pli_FechaUltimaModificacion,$Pli_IdRegistroTaxon,$Pli_CitaSugerida,$Pli_Distribucion,$Pli_DescripcionGeneral,$Pli_Reino,$Pli_Phylum,$Pli_Clase,$Pli_Orden,$Pli_Familia,$Pli_Genero,$Pli_Sinonimia,$Pli_AutorFechaTaxon,$Pli_EspeciesReferenciasPublicacion,$Pli_NombresComunes,$Pli_InformacionTipos,$Pli_IdentificadorUnicoGlobal,$Pli_Colaboradores,$Pli_FechaCreacion,$Pli_Habito,$Pli_CicloVida,$Pli_Reproduccion,$Pli_CicloAnual,$Pli_DescripcionCientifica,$Pli_BreveDescripcion,$Pli_Alimentacion,$Pli_Comportamiento,$Pli_Interacciones,$Pli_NumeroCromosomas,$Pli_DatosMoleculares,$Pli_EstadoActPoblacion,$Pli_EstadoUICN,$Pli_EstadoLegNacional,$Pli_Habitat,$Pli_Territorialidad,$Pli_Endemismo,$Pli_Usos,$Pli_Manejo,$Pli_Folklore,$Pli_ReferenciasBibliograficas,$Pli_DocumentacionNoEstructurada,$Pli_OtraFuenteInformacion,$Pli_ArticuloCientifico,$Pli_ClavesTaxonomicas,$Pli_DatosMigrados,$Pli_ImportanciaEcologica,$Pli_HistoriaNaturalNoEstructurada,$Pli_DatosInvasividad,$Pli_PublicoObjetivo,$Pli_Version,$Pli_URLImagen1,$Pli_PieImagen1,$Pli_URLImagen2,$Pli_PieImagen2,$Pli_URLImagen3,$Pli_PieImagen3,$Pli_Imagen,$Pli_IdPlinian)
    {
       $this->_db->query(
                "update plinian set Pli_Idioma = '$Pli_Idioma',Pli_NombreCientifico ='$Pli_NombreCientifico',Pli_AcronimoInstitucion = '$Pli_AcronimoInstitucion',Pli_FechaUltimaModificacion = '$Pli_FechaUltimaModificacion',Pli_IdRegistroTaxon='$Pli_IdRegistroTaxon',Pli_CitaSugerida='$Pli_CitaSugerida',Pli_Distribucion = '$Pli_Distribucion',Pli_DescripcionGeneral ='$Pli_DescripcionGeneral',Pli_Reino='$Pli_Reino',Pli_Phylum='$Pli_Phylum',Pli_Clase='$Pli_Clase',Pli_Orden='$Pli_Orden',Pli_Familia='$Pli_Familia',Pli_Genero='$Pli_Genero',Pli_Sinonimia='$Pli_Sinonimia',Pli_AutorFechaTaxon='$Pli_AutorFechaTaxon',Pli_EspeciesReferenciasPublicacion='$Pli_EspeciesReferenciasPublicacion',Pli_NombresComunes='$Pli_NombresComunes',Pli_InformacionTipos='$Pli_InformacionTipos',Pli_IdentificadorUnicoGlobal='$Pli_IdentificadorUnicoGlobal',Pli_Colaboradores='$Pli_Colaboradores',Pli_FechaCreacion='$Pli_FechaCreacion',Pli_Habito='$Pli_Habito',Pli_CicloVida='$Pli_CicloVida',Pli_Reproduccion='$Pli_Reproduccion',Pli_CicloAnual='$Pli_CicloAnual',Pli_DescripcionCientifica='$Pli_DescripcionCientifica',Pli_BreveDescripcion='$Pli_BreveDescripcion',Pli_Alimentacion='$Pli_Alimentacion',Pli_Comportamiento='$Pli_Comportamiento',Pli_Interacciones='$Pli_Interacciones',Pli_NumeroCromosomas='$Pli_NumeroCromosomas',Pli_DatosMoleculares='$Pli_DatosMoleculares',Pli_EstadoActPoblacion='$Pli_EstadoActPoblacion',Pli_EstadoUICN='$Pli_EstadoUICN',Pli_EstadoLegNacional='$Pli_EstadoLegNacional',Pli_Habitat='$Pli_Habitat',Pli_Territorialidad='$Pli_Territorialidad',Pli_Endemismo='$Pli_Endemismo',Pli_Usos='$Pli_Usos',Pli_Manejo='$Pli_Manejo',Pli_Folklore='$Pli_Folklore',Pli_ReferenciasBibliograficas='$Pli_ReferenciasBibliograficas',Pli_DocumentacionNoEstructurada='$Pli_DocumentacionNoEstructurada',Pli_OtraFuenteInformacion='$Pli_OtraFuenteInformacion',Pli_ArticuloCientifico='$Pli_ArticuloCientifico',Pli_ClavesTaxonomicas='$Pli_ClavesTaxonomicas',Pli_DatosMigrados='$Pli_DatosMigrados',Pli_ImportanciaEcologica='$Pli_ImportanciaEcologica',Pli_HistoriaNaturalNoEstructurada='$Pli_HistoriaNaturalNoEstructurada',Pli_DatosInvasividad='$Pli_DatosInvasividad',Pli_PublicoObjetivo='$Pli_PublicoObjetivo',Pli_Version='$Pli_Version',Pli_URLImagen1='$Pli_URLImagen1',Pli_PieImagen1='$Pli_PieImagen1',Pli_URLImagen2='$Pli_URLImagen2',Pli_PieImagen2='$Pli_PieImagen2',Pli_URLImagen3='$Pli_URLImagen3',Pli_PieImagen3='$Pli_PieImagen3',Pli_Imagen='$Pli_Imagen' where Pli_IdPlinian = $Pli_IdPlinian");
				
		
    }
	
	public function actualizaEstado()
    {
		 $this->_db->query(
            " update plinian  set Pli_Estado = 0"
             );
	}
	
	    	
}
?>
