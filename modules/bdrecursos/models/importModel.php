<?php
class importModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getFichaEstandar($condicion = "",$Idi_IdIdioma)
    { 
        $post = $this->_db->query("SELECT
		fie.Fie_IdFichaEstandar,
                fn_TraducirContenido('ficha_estandar','Fie_CampoFicha',fie.Fie_IdFichaEstandar,'$Idi_IdIdioma',fie.Fie_CampoFicha) Fie_CampoFicha,
                fie.Esr_IdEstandarRecurso,
                fie.Fie_NombreTabla,
                fie.Fie_TipoDatoCampo,
                fie.Fie_TamanoColumna,
                fie.Fie_ColumnaTabla,
                fie.Fie_ColumnaObligatorio,
                fie.Fie_ColumnaTraduccion,
                fie.Fie_ColumnaTipo
		FROM ficha_estandar fie
            INNER JOIN estandar_recurso esr ON fie.Esr_IdEstandarRecurso = esr.Esr_IdEstandarRecurso
            WHERE fie.Esr_IdEstandarRecurso = $condicion ");				
        return $post->fetchAll();
    }
	
    public function getFichaVariable($nombre_tabla, $id_recurso)
    {
        $post = $this->_db->query("SELECT * FROM $nombre_tabla WHERE Rec_IdRecurso=$id_recurso");
        return $post->fetchAll();
    }

    public function getValorMaximo($nombre_tabla, $campo_numregistro)
    {
        $post = $this->_db->query("SELECT MAX($campo_numregistro) num_registros FROM $nombre_tabla");
        return $post->fetchAll();
    }

	public function getRecurso($condicion = "")
    {
        $post = $this->_db->query("SELECT rec.Esr_IdEstandarRecurso, rec.Rec_NombreTabla FROM recurso rec WHERE rec.Rec_IdRecurso = $condicion ");				
        return $post->fetch();
    }	

    public function getEstandar($condicion = "")
    {
        $post = $this->_db->query("SELECT * FROM estandar_recurso esr WHERE esr.Esr_IdEstandarRecurso = $condicion ");				
        return $post->fetch();
    }

    public function getPais($Pai_Nombre)
    {
        $post = $this->_db->query("SELECT Pai_IdPais FROM pais WHERE Pai_Nombre = '$Pai_Nombre' ");             
        return $post->fetch();
    }
    
    //Para matriz Legal
    public function getNivelLegal($condicion = "",$Idi_IdIdioma)
    {
        $post = $this->_db->query("SELECT Nil_IdNivelLegal FROM nivel_legal WHERE fn_TraducirContenido('nivel_legal','Nil_Nombre',Nil_IdNivelLegal,'$Idi_IdIdioma',Nil_Nombre) = '$condicion' ");               
        return $post->fetch();
    }
    
    public function getSubNivelLegal($idnivellegal,$subnivellegal,$Idi_IdIdioma)
    {
        $post = $this->_db->query("SELECT * FROM sub_nivel_legal snl WHERE snl.Nil_IdNivelLegal = $idnivellegal AND fn_TraducirContenido('sub_nivel_legal','Snl_Nombre',snl.Snl_IdSubNivelLegal,'$Idi_IdIdioma',snl.Snl_Nombre) = '$subnivellegal'");               
        return $post->fetch();
    }
    
    public function getTemaLegal($idsubnivellegal,$temalegal,$Idi_IdIdioma)
    {
        $post = $this->_db->query("SELECT * FROM tema_legal tel WHERE tel.Snl_IdSubNivelLegal = $idsubnivellegal AND fn_TraducirContenido('tema_legal','Tel_Nombre',tel.Tel_IdTemaLegal,'$Idi_IdIdioma',tel.Tel_Nombre) = '$temalegal'");               
        return $post->fetch();
    }
    
    public function getTipoLegal($Til_Nombre, $Idi_IdIdioma)
    {
        $post = $this->_db->query("SELECT * FROM tipo_legal WHERE fn_TraducirContenido('tipo_legal','Til_Nombre',Til_IdTipoLegal,'$Idi_IdIdioma',Til_Nombre) = '$Til_Nombre'");             
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
    
    public function registrarNivelLegal($Nil_Nombre,$Idi_Idioma)
    {
        $this->_db->prepare(
                "insert into nivel_legal (Nil_Nombre,Idi_Idioma) values " .
                "(:Nil_Nombre,:Idi_Idioma)"
                )
                ->execute(array(
                    ':Nil_Nombre' => $Nil_Nombre,
                    ':Idi_Idioma' => $Idi_Idioma
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarSubNivelLegal($Snl_Nombre, $Nil_IdNivelLegal,$Idi_Idioma)
    {
        $this->_db->prepare(
                "insert into sub_nivel_legal (Snl_Nombre,Nil_IdNivelLegal,Idi_Idioma) values " .
                "(:Snl_Nombre, :Nil_IdNivelLegal, :Idi_Idioma)"
                )
                ->execute(array(
                    ':Snl_Nombre' => $Snl_Nombre,
                    ':Nil_IdNivelLegal' => $Nil_IdNivelLegal,
                    ':Idi_Idioma' => $Idi_Idioma
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarTemaLegal($Tel_Nombre, $Snl_IdSubNivelLegal,$Idi_Idioma)
    {
        $this->_db->prepare(
                "insert into tema_legal (Tel_Nombre,Snl_IdSubNivelLegal,Idi_Idioma) values " .
                "(:Tel_Nombre, :Snl_IdSubNivelLegal,:Idi_Idioma)"
                )
                ->execute(array(
                    ':Tel_Nombre' => $Tel_Nombre,
                    ':Snl_IdSubNivelLegal' => $Snl_IdSubNivelLegal,
                    ':Idi_Idioma' => $Idi_Idioma
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function verificarTitulo($fechapublicacion, $entidad, $numeronormas, $titulo, $articuloaplicable, $resumenlegislacion, $fecharevision, $normascomplementarias, $tipolegislacion, $tema,$pais, $idioma, $recurso, $palabraclave)
    {
        $id = $this->_db->query(
                "SELECT * FROM matriz_legal WHERE Mal_FechaPublicacion = '$fechapublicacion' AND Mal_Entidad = '$entidad' AND Mal_NumeroNormas = '$numeronormas' AND Mal_Titulo = '$titulo' AND Mal_ArticuloAplicable = '$articuloaplicable' AND Mal_ResumenLegislacion = '$resumenlegislacion' AND Mal_FechaRevision = '$fecharevision' AND Mal_NormasComplemaentarias = '$normascomplementarias' AND til_idtipolegal = $tipolegislacion AND tel_idtemalegal = $tema AND pai_idpais = $pais AND Idi_IdIdioma = '$idioma' AND rec_idrecurso = $recurso AND Mal_PalabraClave = '$palabraclave'");
        if($id->fetch()){
            return true;
        }
        return false;
    }
    
    public function registrarLegislacion($Mal_FechaPublicacion, $Mal_Entidad, $Mal_NumeroNormas, $Mal_Titulo, $Mal_ArticuloAplicable, $Mal_ResumenLegislacion, $Mal_FechaRevision, $Mal_NormasComplemaentarias,$Til_IdTipoLegal, $Tel_IdTemaLegal, $Pai_IdPais,$Rec_IdRecurso,$Mal_PalabraClave,$Idi_IdIdioma)
    {   
        $this->_db->prepare(
                "insert into matriz_legal (Mal_FechaPublicacion,Mal_Entidad,Mal_NumeroNormas,Mal_Titulo,Mal_ArticuloAplicable,Mal_ResumenLegislacion,Mal_FechaRevision,Mal_NormasComplemaentarias,Til_IdTipoLegal,Tel_IdTemaLegal,Pai_IdPais,Rec_IdRecurso,Mal_Estado,Mal_PalabraClave,Idi_IdIdioma) values " .
                "(:Mal_FechaPublicacion, :Mal_Entidad, :Mal_NumeroNormas, :Mal_Titulo, :Mal_ArticuloAplicable, :Mal_ResumenLegislacion, :Mal_FechaRevision, :Mal_NormasComplemaentarias, :Til_IdTipoLegal, :Tel_IdTemaLegal, :Pai_IdPais, :Rec_IdRecurso,1,:Mal_PalabraClave,:Idi_IdIdioma)"
                )
                ->execute(array(
                    ':Mal_FechaPublicacion' => $Mal_FechaPublicacion,
                    ':Mal_Entidad' => $Mal_Entidad,
                    ':Mal_NumeroNormas' => $Mal_NumeroNormas,
                    ':Mal_Titulo' => $Mal_Titulo,
                    ':Mal_ArticuloAplicable' => $Mal_ArticuloAplicable,
                    ':Mal_ResumenLegislacion' => $Mal_ResumenLegislacion,
                    ':Mal_FechaRevision' => $Mal_FechaRevision,
                    ':Mal_NormasComplemaentarias' => $Mal_NormasComplemaentarias,
                    ':Til_IdTipoLegal' => $Til_IdTipoLegal,
                    ':Tel_IdTemaLegal' => $Tel_IdTemaLegal,
                    ':Pai_IdPais' => $Pai_IdPais,
                    ':Rec_IdRecurso' => $Rec_IdRecurso,
                    ':Mal_PalabraClave' => $Mal_PalabraClave,
                    ':Idi_IdIdioma' => $Idi_IdIdioma
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    //Para monitoreo calidad de agua
    public function getCuenca($cuenca = "")
    {
        $post = $this->_db->query("SELECT * FROM cuenca cue WHERE cue.Cue_Nombre = '$cuenca' ");                
        return $post->fetch();
    }
    
    public function getSubCuenca($idcuenca,$subcuenca)
    {
        $post = $this->_db->query("SELECT * FROM sub_cuenca suc WHERE suc.Cue_IdCuenca = $idcuenca AND suc.Suc_Nombre = '$subcuenca' ");                
        return $post->fetch();
    }
    
    public function getRio($idpais,$rio)
    {
        $post = $this->_db->query("SELECT * FROM rio WHERE rio.Pai_IdPais = $idpais AND rio.Rio_Nombre = '$rio' ");             
        return $post->fetch();
    }
    
    public function getRioCuenca($cuenca,$subcuenca,$rio)
    {
        $post = $this->_db->query("SELECT * FROM rio_cuenca ric WHERE  ric.Cue_IdCuenca= $cuenca AND ric.Suc_IdSubcuenca=$subcuenca AND ric.Rio_IdRio=$rio ");
        return $post->fetch();
    }
    
    public function getEstacionMonitoreo($Esm_Latitud,$Esm_Longitud)
    {
        $post = $this->_db->query("SELECT esm.Esm_IdEstacionMonitoreo FROM estacion_monitoreo esm WHERE esm.Esm_Latitud = '$Esm_Latitud' and esm.Esm_Longitud = '$Esm_Longitud' ");             
        return $post->fetch();
    }
    
    public function getEntidad($Ent_Nombre)
    {
        $post = $this->_db->query("SELECT * FROM entidad WHERE Ent_Nombre = '$Ent_Nombre'");                
        return $post->fetch();
    }
    
    public function getVariable($variable)
    {
        $post = $this->_db->query("SELECT * FROM variables_estudio var WHERE var.Var_Nombre = '$variable' ");               
        return $post->fetch();
    }
    
    public function registrarCuenca($Cue_Nombre)
    {
        $this->_db->prepare(
                "insert into cuenca (Cue_Nombre) values " .
                "(:Cue_Nombre)"
                )
                ->execute(array(
                    ':Cue_Nombre' => $Cue_Nombre
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarSucCuenca($Suc_Nombre, $Cue_IdCuenca)
    {
        $this->_db->prepare(
                "insert into sub_cuenca (Suc_Nombre,Cue_IdCuenca) values " .
                "(:Suc_Nombre, :Cue_IdCuenca)"
                )
                ->execute(array(
                    ':Suc_Nombre' => $Suc_Nombre,
                    ':Cue_IdCuenca' => $Cue_IdCuenca
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarRio($Rio_Nombre, $Pai_IdPais)
    {
        $this->_db->prepare(
                "insert into rio (Rio_Nombre,Pai_IdPais) values " .
                "(:Rio_Nombre, :Pai_IdPais)"
                )
                ->execute(array(
                    ':Rio_Nombre' => $Rio_Nombre,
                    ':Pai_IdPais' => $Pai_IdPais
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarRioCuenca($Cue_IdCuenca,$Suc_IdSubcuenca,$Rio_IdRio)
    {
        $this->_db->prepare(
                "insert into rio_cuenca (Cue_IdCuenca,Suc_IdSubcuenca,Rio_IdRio) values " .
                "(:Cue_IdCuenca, :Suc_IdSubcuenca, :Rio_IdRio)"
                )
                ->execute(array(
                    ':Cue_IdCuenca' => $Cue_IdCuenca,
                    ':Suc_IdSubcuenca' => $Suc_IdSubcuenca,
                    ':Rio_IdRio' => $Rio_IdRio
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarEntidad($Ent_Nombre,$Ent_Siglas)
    {
        $this->_db->prepare(
                "insert into entidad (Ent_Nombre,Ent_Siglas) values " .
                "(:Ent_Nombre, :Ent_Siglas)"
                )
                ->execute(array(
                    ':Ent_Nombre' => $Ent_Nombre,
                    ':Ent_Siglas' => $Ent_Siglas
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarEstacionMonitoreo($Esm_Nombre,$Esm_Longitud,$Esm_Latitud,$Esm_Referencia, $Esm_Altitud, $Ric_IdRioCuenca)
    {
        $this->_db->prepare(
                "insert into estacion_monitoreo (Esm_Nombre,Esm_Longitud,Esm_Latitud,Esm_Referencia,Esm_Altitud,Ric_IdRioCuenca) values " .
                "(:Esm_Nombre, :Esm_Longitud, :Esm_Latitud, :Esm_Referencia, :Esm_Altitud, :Ric_IdRioCuenca)"
                )
                ->execute(array(
                    ':Esm_Nombre' => $Esm_Nombre,
                    ':Esm_Longitud' => $Esm_Longitud,
                    ':Esm_Latitud' => $Esm_Latitud,
                    ':Esm_Referencia' => $Esm_Referencia,
                    ':Esm_Altitud' => $Esm_Altitud,
                    ':Ric_IdRioCuenca' => $Ric_IdRioCuenca
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarVariables($Var_Nombre,$Var_Abreviatura,$Var_Medida,$Idi_IdIdioma)
    {
        $this->_db->prepare(
                "insert into variables_estudio (Var_Nombre,Var_Abreviatura,Var_Medida,Idi_IdIdioma) values " .
                "(:Var_Nombre, :Var_Abreviatura, :Var_Medida, :Idi_IdIdioma)"
                )
                ->execute(array(
                    ':Var_Nombre' => $Var_Nombre,
                    ':Var_Abreviatura' => $Var_Abreviatura,
                    ':Var_Medida' => $Var_Medida,
                    ':Idi_IdIdioma' => $Idi_IdIdioma
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function verificarMonitoreoCalidadAgua($Mca_Valor, $Mca_Fecha, $Var_IdVariable, $Ent_IdEntidad, $Esm_IdEstacionMonitoreo, $Pai_IdPais, $Rec_IdRecurso)
    {
        $id = $this->_db->query(
                "SELECT * FROM monitoreo_calidad_agua WHERE Mca_Valor = '$Mca_Valor' AND Mca_Fecha = '$Mca_Fecha' AND Var_IdVariable = $Var_IdVariable AND Ent_IdEntidad = $Ent_IdEntidad AND Esm_IdEstacionMonitoreo = $Esm_IdEstacionMonitoreo AND Pai_IdPais = $Pai_IdPais AND Rec_IdRecurso = $Rec_IdRecurso ");
        if($id->fetch()){
            return true;
        }
        return false;
    }
    
    public function registrarMonitoreoCalidadAgua($Mca_Valor, $Mca_Fecha, $Var_IdVariable, $Esm_IdEstacionMonitoreo, $Pai_IdPais, $Rec_IdRecurso,$Ent_IdEntidad)
    {
        $this->_db->prepare(
                "insert into monitoreo_calidad_agua (Mca_Valor, Mca_Fecha, Var_IdVariable, Esm_IdEstacionMonitoreo, Pai_IdPais, Rec_IdRecurso,Ent_IdEntidad,Mca_Estado) values " .
                "(:Mca_Valor, :Mca_Fecha, :Var_IdVariable, :Esm_IdEstacionMonitoreo, :Pai_IdPais, :Rec_IdRecurso,:Ent_IdEntidad,1)"
                )
                ->execute(array(
                    ':Mca_Valor' => $Mca_Valor,
                    ':Mca_Fecha' => $Mca_Fecha,
                    ':Var_IdVariable' => $Var_IdVariable,
                    ':Esm_IdEstacionMonitoreo' => $Esm_IdEstacionMonitoreo,
                    ':Pai_IdPais' => $Pai_IdPais,
                    ':Rec_IdRecurso' => $Rec_IdRecurso,
                    ':Ent_IdEntidad' => $Ent_IdEntidad
                ));
                
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function getArchivoFisicoURL($url = "")
    {
        $post = $this->_db->query("SELECT * FROM archivo_fisico WHERE Arf_URL = '$url' ");              
        return $post->fetch();
    }
    
    public function getArchivoFisico($archivofisico = "")
    {
        $post = $this->_db->query("SELECT * FROM archivo_fisico WHERE Arf_PosicionFisica = '$archivofisico' ");             
        return $post->fetch();
    }
    
    public function actualizarArchivoFisico($formato , $idarchivo, $url)
    {
        $this->_db->query("UPDATE archivo_fisico SET Taf_IdTipoArchivoFisico = $formato, Arf_URL = $url 
        WHERE Arf_IdArchivoFisico = $idarchivo ");       
    }
    
    public function getAutor($autor = "")
    {
        $post = $this->_db->query("SELECT * FROM autor WHERE autor.Aut_Nombre = '$autor' ");                
        return $post->fetch();
    }   
    
    public function getIdioma($Idi_IdIdioma = "")
    {
        $post = $this->_db->query("SELECT * FROM idioma WHERE Idi_IdIdioma = '$Idi_IdIdioma' ");                
        return $post->fetch();
    }
    
    public function getTemaDublin($temadublin = "",$Idi_IdIdioma)
    {
        $post = $this->_db->query("SELECT * FROM tema_dublin ted WHERE fn_TraducirContenido('tema_dublin','Ted_Descripcion',ted.Ted_IdTemaDublin,'$Idi_IdIdioma',ted.Ted_Descripcion) = '$temadublin' ");               
        return $post->fetch();
    }
    
    public function getTipoDublin($tipodublin = "",$Idi_IdIdioma)
    {
        $post = $this->_db->query("SELECT * FROM tipo_dublin tid WHERE fn_TraducirContenido('tipo_dublin','Tid_Descripcion',tid.Tid_IdTipoDublin,'$Idi_IdIdioma',tid.Tid_Descripcion) = '$tipodublin' ");               
        return $post->fetch();
    }
    
    public function getDublinAutor($dublin, $autor)
    {
        $post = $this->_db->query("SELECT * FROM dublincore_autor dua WHERE dua.Dub_IdDublinCore = $dublin AND dua.Aut_IdAutor= $autor");               
        return $post->fetch();
    }
    
    public function getDublinCore($titulo, $tid_dublin)
    {
        $post = $this->_db->query("SELECT * FROM dublincore dub WHERE dub.Dub_Titulo = '$titulo' AND dub.Tid_IdTipoDublin = $tid_dublin ");             
        return $post->fetch();
    }
        
    public function registrarArchivoFisico($ArchivoFisico)
    {
        $this->_db->prepare(
                "insert into archivo_fisico (Arf_PosicionFisica) values " .
                "(:Arf_PosicionFisica)"
                )
                ->execute(array(
                    ':Arf_PosicionFisica' => $ArchivoFisico
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarUrlArchivoFisico($Arf_URL,$Taf_IdTipoArchivoFisico)
    {
        $this->_db->prepare(
                "insert into archivo_fisico (Arf_URL,Taf_IdTipoArchivoFisico) values " .
                "(:Arf_URL,:Taf_IdTipoArchivoFisico)"
                )
                ->execute(array(
                    ':Arf_URL' => $Arf_URL,
                    ':Taf_IdTipoArchivoFisico' => $Taf_IdTipoArchivoFisico
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarAutor($Aut_Nombre)
    {
        $this->_db->prepare(
                "insert into autor (Aut_Nombre) values " .
                "(:Aut_Nombre)"
                )
                ->execute(array(
                    ':Aut_Nombre' => $Aut_Nombre
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarTemaDublin($Ted_Descripcion,$Idi_IdIdioma)
    {
        $this->_db->prepare(
                "insert into tema_dublin (Ted_Descripcion,Idi_IdIdioma) values " .
                "(:Ted_Descripcion,:Idi_IdIdioma)"
                )
                ->execute(array(
                    ':Ted_Descripcion' => $Ted_Descripcion,
                    ':Idi_IdIdioma' => $Idi_IdIdioma
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    
    public function registrarTipoDublin($Tid_Descripcion,$Idi_IdIdioma)
    {
        $this->_db->prepare(
                "insert into tipo_dublin (Tid_Descripcion, Idi_IdIdioma) values " .
                "(:Tid_Descripcion, :Idi_IdIdioma)"
                )
                ->execute(array(
                    ':Tid_Descripcion' => $Tid_Descripcion,
                    ':Idi_IdIdioma' => $Idi_IdIdioma
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarDublinCore($Dub_Titulo, $Dub_Descripcion, $Dub_Editor, $Dub_Colabrorador, $Dub_FechaDocumento, $Dub_Formato, $Dub_Identificador, $Dub_Fuente, $Dub_Idioma, $Dub_Relacion, $Dub_Cobertura, $Dub_Derechos, $Dub_PalabraClave, $Tid_IdTipoDublin, $Rec_IdRecurso, $Idi_IdIdioma, $Arf_IdArchivoFisico,$Ted_IdTemaDublin)
    {
        $this->_db->prepare(
                "insert into dublincore (Dub_Titulo, Dub_Descripcion, Dub_Editor, Dub_Colaborador, Dub_FechaDocumento, Dub_Formato, Dub_Identificador, Dub_Fuente, Dub_Idioma, Dub_Relacion, Dub_Cobertura, Dub_Derechos, Dub_PalabraClave, Tid_IdTipoDublin, Rec_IdRecurso,Idi_IdIdioma,Arf_IdArchivoFisico,Ted_IdTemaDublin) values " .
                "(:Dub_Titulo, :Dub_Descripcion, :Dub_Editor, :Dub_Colaborador, :Dub_FechaDocumento, :Dub_Formato, :Dub_Identificador, :Dub_Fuente, :Dub_Idioma, :Dub_Relacion, :Dub_Cobertura, :Dub_Derechos, :Dub_PalabraClave, :Tid_IdTipoDublin, :Rec_IdRecurso,:Idi_IdIdioma,:Arf_IdArchivoFisico,:Ted_IdTemaDublin)"
                )
                ->execute(array(
                    ':Dub_Titulo' => $Dub_Titulo,
                    ':Dub_Descripcion' => $Dub_Descripcion,
                    ':Dub_Editor' => $Dub_Editor,
                    ':Dub_Colaborador' => $Dub_Colabrorador,
                    ':Dub_FechaDocumento' => $Dub_FechaDocumento,
                    ':Dub_Formato' => $Dub_Formato,
                    ':Dub_Identificador' => $Dub_Identificador,
                    ':Dub_Fuente' => $Dub_Fuente,
                    ':Dub_Idioma' => $Dub_Idioma,
                    ':Dub_Relacion' => $Dub_Relacion,
                    ':Dub_Cobertura' => $Dub_Cobertura,
                    ':Dub_Derechos' => $Dub_Derechos,
                    ':Dub_PalabraClave' => $Dub_PalabraClave,
                    ':Tid_IdTipoDublin' => $Tid_IdTipoDublin,
                    ':Rec_IdRecurso' => $Rec_IdRecurso,
                    ':Idi_IdIdioma' => $Idi_IdIdioma,
                    ':Arf_IdArchivoFisico' => $Arf_IdArchivoFisico,
                    ':Ted_IdTemaDublin' => $Ted_IdTemaDublin
                ));
                
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function getFormatoArchivo($Formato)
    {
        $post = $this->_db->query(
                "SELECT * FROM tipo_archivo_fisico where taf_descripcion = '$Formato'");                
        return $post->fetch();
    }
    
    public function registrarFormatoArchivo($Taf_Descripcion)
    {
        $this->_db->prepare(
                "insert into tipo_archivo_fisico (Taf_Descripcion) values " .
                "(:Taf_Descripcion)"
                )
                ->execute(array(
                    ':Taf_Descripcion' => $Taf_Descripcion
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarDublinAutor($Dub_IdDublinCore, $Aut_IdAutor)
    {
        $this->_db->prepare(
                "insert into dublincore_autor (Dub_IdDublinCore, Aut_IdAutor) values " .
                "(:Dub_IdDublinCore, :Aut_IdAutor)"
                )
                ->execute(array(
                    ':Dub_IdDublinCore' => $Dub_IdDublinCore,
                    ':Aut_IdAutor' => $Aut_IdAutor
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
    }
    
    public function registrarDocumentosRelacionados($Dub_IdDublinCore, $Pai_IdPais)
    {
        $this->_db->prepare(
                "insert into documentos_relacionados (Dub_IdDublinCore, Pai_IdPais) values " .
                "(:Dub_IdDublinCore, :Pai_IdPais)"
                )
                ->execute(array(
                    ':Dub_IdDublinCore' => $Dub_IdDublinCore,
                    ':Pai_IdPais' => $Pai_IdPais
                ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");               
        return $post->fetch();
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