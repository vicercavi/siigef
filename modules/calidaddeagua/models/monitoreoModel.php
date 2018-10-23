<?php

class monitoreoModel extends Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    /////Seccion Registro de Monitoreo\\\\\\\\\\\
    public function getIdiomas() 
    {
        $post = $this->_db->query("SELECT * FROM idioma");
        return $post->fetchAll();
    }

    public function getFichaCalidadAgua($Esr_IdEstandarRecurso, $Idi_IdIdioma) 
    {
        $post = $this->_db->query(
            "SELECT 
            Fie_IdFichaEstandar, fn_TraducirContenido('ficha_estandar','Fie_CampoFicha',
            Fie_IdFichaEstandar,'$Idi_IdIdioma',Fie_CampoFicha) Fie_CampoFicha,
            Esr_IdEstandarRecurso, Fie_NombreTabla, Fie_ColumnaTabla FROM ficha_estandar
            WHERE Esr_IdEstandarRecurso = $Esr_IdEstandarRecurso");
        return $post->fetchAll();
    }

    public function getEstandarRecurso($rec_idrecurso) 
    {
        $post = $this->_db->query(
                "SELECT Esr_IdEstandarRecurso FROM recurso WHERE rec_idrecurso = $rec_idrecurso");
        return $post->fetchAll();
    }

    public function getPais() 
    {
        $post = $this->_db->query("SELECT * FROM pais WHERE Pai_Estado=1");
        return $post->fetchAll();
    }

    public function getNombreCuenca($condicion) 
    {
        $post = $this->_db->query("SELECT * FROM cuenca $condicion");
        return $post->fetchAll();
    }

    public function getCuenca($cuenca = "") 
    {
        $post = $this->_db->query("SELECT * FROM cuenca cue WHERE cue.Cue_Nombre = '$cuenca' ");
        return $post->fetch();
    }

    public function getNombreSubCuenca($condicion) 
    {
        $post = $this->_db->query("SELECT * FROM sub_cuenca $condicion");
        return $post->fetchAll();
    }

    public function getSubCuenca($idcuenca, $subcuenca) 
    {
        $post = $this->_db->query("SELECT * FROM sub_cuenca suc WHERE suc.Cue_IdCuenca = $idcuenca 
            AND suc.Suc_Nombre = '$subcuenca' ");
        return $post->fetch();
    }

    public function getNombreRio($condicion) 
    {
        $post = $this->_db->query("SELECT * FROM rio $condicion");
        return $post->fetchAll();
    }

    public function getRio($idpais, $rio) 
    {
        $post = $this->_db->query("SELECT * FROM rio WHERE rio.Pai_IdPais = $idpais 
            AND rio.Rio_Nombre = '$rio' ");
        return $post->fetch();
    }

    public function getRioxPais($idpais)
    {
        $post=$this->_db->query("SELECT * FROM rio WHERE rio.Pai_IdPais=$idpais");
        return $post->fetchAll();
    }

    public function getNombreRioCuenca($condicion) 
    {
        $post = $this->_db->query("SELECT * FROM rio_cuenca rc
        INNER JOIN estacion_monitoreo em ON rc.Ric_IdRioCuenca=em.Ric_IdRioCuenca 
        $condicion");
        return $post->fetchAll();
    }

    public function getRioCuenca($cuenca, $subcuenca, $rio) 
    {
        $post = $this->_db->query("SELECT * FROM rio_cuenca ric
        WHERE  ric.Cue_IdCuenca= $cuenca AND ric.Suc_IdSubcuenca=$subcuenca AND ric.Rio_IdRio=$rio ");
        return $post->fetch();
    }


    public function getEstacionMonitoreo($Esm_Latitud, $Esm_Longitud) 
    {
        $post = $this->_db->query("SELECT esm.Esm_IdEstacionMonitoreo FROM estacion_monitoreo esm
            WHERE esm.Esm_Latitud = '$Esm_Latitud' and esm.Esm_Longitud = '$Esm_Longitud' ");
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

    public function registrarSubCuenca($Suc_Nombre, $Cue_IdCuenca) 
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

  
    public function registrarRioCuenca($Cue_IdCuenca, $Suc_IdSubcuenca, $Rio_IdRio) 
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

    public function registrarEntidad($Ent_Nombre, $Ent_Siglas) 
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

    public function getNombreEstacion() 
    {
        $post = $this->_db->query("SELECT * FROM estacion_monitoreo WHERE Esm_Estado=1");
        return $post->fetchAll();
    }

    public function getNombreEntidad() 
    {
        $post = $this->_db->query("SELECT * FROM entidad WHERE Ent_Estado=1");
        return $post->fetchAll();
    }

    public function registrarEstacionMonitoreo($Esm_Nombre, $Esm_Longitud, $Esm_Latitud, $Esm_Referencia, $Esm_Altitud, $Ric_IdRioCuenca) 
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

    public function getNombreVariables($condicion) 
    {
        $post = $this->_db->query("SELECT * FROM variables_estudio ve INNER JOIN tipo_variable tv 
                ON ve.Tiv_IdTipoVariable=tv.Tiv_IdTipoVariable $condicion");
        return $post->fetchAll();
    }

    public function registrarVariables($Var_Nombre, $Var_Abreviatura, $Var_Medida, $Idi_IdIdioma) 
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

    public function verificarMonitoreoCalidadAgua($Mca_Valor, $Mca_Fecha, $Var_IdVariable, $Esm_IdEstacionMonitoreo, $Pai_IdPais, $Rec_IdRecurso) 
    {
        $id = $this->_db->query(
                "SELECT * FROM monitoreo_calidad_agua WHERE Mca_Valor = '$Mca_Valor' AND Mca_Fecha = '$Mca_Fecha' AND Var_IdVariable = $Var_IdVariable AND Esm_IdEstacionMonitoreo = $Esm_IdEstacionMonitoreo AND Pai_IdPais = $Pai_IdPais AND Rec_IdRecurso = $Rec_IdRecurso ");
        if ($id->fetch()) 
        {
            return true;
        }
        return false;
    }

    public function registrarMonitoreoCalidadAgua($Esm_IdEstacionMonitoreo, $Ent_IdEntidad, $Var_IdVariable, $Mca_Valor, $Mca_Fecha, $Pai_IdPais, $Mca_Estado, $Rec_IdRecurso) 
    {
        $this->_db->prepare(
                        "insert into monitoreo_calidad_agua (Esm_IdEstacionMonitoreo, Ent_IdEntidad, Var_IdVariable, Mca_Valor, Mca_Fecha, Pai_IdPais,Mca_Estado, Rec_IdRecurso) values " .
                        "(:Esm_IdEstacionMonitoreo, :Ent_IdEntidad, :Var_IdVariable, :Mca_Valor, :Mca_Fecha, :Pai_IdPais,:Mca_Estado, :Rec_IdRecurso)"
                )
                ->execute(array(
                    ':Esm_IdEstacionMonitoreo' => $Esm_IdEstacionMonitoreo,
                    ':Ent_IdEntidad' => $Ent_IdEntidad,
                    ':Var_IdVariable' => $Var_IdVariable,
                    ':Mca_Valor' => $Mca_Valor,
                    ':Mca_Fecha' => $Mca_Fecha,
                    ':Pai_IdPais' => $Pai_IdPais,
                    ':Mca_Estado' => $Mca_Estado,
                    ':Rec_IdRecurso' => $Rec_IdRecurso
                    
        ));
        $post = $this->_db->query("SELECT LAST_INSERT_ID()");
        return $post->fetch();
    }

    //////Seccion Editar Monitoreo\\\\\\\\\\\
   /* public function getMonitoreoCalidadAgua($condicion = "") {
        $post = $this->_db->query(
                " SELECT mca.*, var.*, ent.*, esm.*,pai.*,cue.*, suc.*,rio.* FROM monitoreo_calidad_agua mca
INNER JOIN variables_estudio var ON mca.Var_IdVariable = var.Var_IdVariable
LEFT JOIN entidad ent ON mca.Ent_IdEntidad = ent.Ent_IdEntidad
INNER JOIN estacion_monitoreo esm ON mca.Esm_IdEstacionMonitoreo = esm.Esm_IdEstacionMonitoreo
INNER JOIN pais pai ON mca.Pai_IdPais = pai.Pai_IdPais
INNER JOIN rio_cuenca ric ON esm.Ric_IdRioCuenca = ric.Ric_IdRioCuenca
INNER JOIN cuenca cue ON ric.Cue_IdCuenca = cue.Cue_IdCuenca
INNER JOIN sub_cuenca suc ON ric.Suc_IdSubcuenca = suc.Suc_IdSubcuenca
INNER JOIN rio ON ric.Rio_IdRio = rio.Rio_IdRio  $condicion"
        );
        return $post->fetch();
    }
*/
    public function getMonitoreoCalidadAgua($id_mca) 
    {
        $post = $this->_db->query(
                " SELECT mca.*,ve.Var_Nombre,ve.Var_Abreviatura,ve.Var_Medida,em.Esm_Nombre,em.Esm_Longitud,em.Esm_Latitud,p.Pai_Nombre FROM monitoreo_calidad_agua mca 
                 INNER JOIN variables_estudio ve ON ve.Var_IdVariable = mca.Var_IdVariable 
                 INNER JOIN estacion_monitoreo em ON em.Esm_IdEstacionMonitoreo= mca.Esm_IdEstacionMonitoreo INNER JOIN pais p ON p.Pai_IdPais=mca.Pai_IdPais
                 WHERE mca.Mca_Estado = 1 and mca.Mca_IdMonitoreoCalidadAgua = $id_mca"
        );
        return $post->fetch();
    }

    public function getMonitoreoCalidadAgua2($id_mca) 
    {
        $post = $this->_db->query(
                " SELECT mca.*,ve.Var_Nombre,ve.Var_Abreviatura,ve.Var_Medida,em.Esm_Nombre,em.Esm_Longitud,em.Esm_Latitud,p.Pai_Nombre FROM monitoreo_calidad_agua mca 
                 INNER JOIN variables_estudio ve ON ve.Var_IdVariable = mca.Var_IdVariable 
                 INNER JOIN estacion_monitoreo em ON em.Esm_IdEstacionMonitoreo= mca.Esm_IdEstacionMonitoreo INNER JOIN pais p ON p.Pai_IdPais=mca.Pai_IdPais
                 WHERE mca.Mca_IdMonitoreoCalidadAgua = $id_mca"
        );
        return $post->fetch();
    }
    
    public function actualizarMonitoreoCalidadAgua($Esm_IdEstacionMonitoreo, $Ent_IdEntidad, $Var_IdVariable, $Mca_Valor, $Mca_Fecha, $Pai_IdPais, $Mca_Estado, $Mca_IdMonitoreoCalidadAgua) 
    {

        /*echo "1: ". $Esm_IdEstacionMonitoreo.'<br>';
        echo "2: ". $Ent_IdEntidad.'<br>';
        echo "3: ". $Var_IdVariable.'<br>';
        echo "4: ". $Mca_Valor.'<br>';
        echo "5: ". $Mca_Fecha.'<br>';
        echo "6: ". $Pai_IdPais.'<br>';
        echo "7: ". $Mca_Estado.'<br>';
        echo "8: ". $Mca_IdMonitoreoCalidadAgua.'<br>';
        exit();*/

        
        $post = $this->_db->query(
                "UPDATE monitoreo_calidad_agua SET Mca_Valor = '$Mca_Valor', 
                Mca_Fecha = '$Mca_Fecha', Mca_Estado = $Mca_Estado, 
                Var_IdVariable = $Var_IdVariable, Ent_IdEntidad = $Ent_IdEntidad, 
                Esm_IdEstacionMonitoreo = $Esm_IdEstacionMonitoreo, Pai_IdPais = $Pai_IdPais 
                WHERE Mca_IdMonitoreoCalidadAgua = $Mca_IdMonitoreoCalidadAgua");        
    }

    public function actualizarEstacionRio($Ric_IdRioCuenca, $Esm_IdEstacionMonitoreo) 
    {
        $post = $this->_db->query(
                "UPDATE estacion_monitoreo SET Ric_IdRioCuenca = $Ric_IdRioCuenca WHERE Esm_IdEstacionMonitoreo = $Esm_IdEstacionMonitoreo ");
    }

    
    //////// MIgrado de modulo monitoreo\\\\\\\\\\\\\
    
    public function insertarMonitoreoCalidad(
    $iMca_Valor, $iMca_Fecha, $iMca_Estado, $iVar_IdVariable, $iEnt_IdEntidad, $iEsm_IdEstacionMonitoreo, $iPai_IdPais, $iRec_IdRecurso) 
    {
        try 
        {
            $id_registro = "";
            $sql = "call s_i_monitoreo_calidad_agua(?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iMca_Valor, PDO::PARAM_STR);
            $result->bindParam(2, $iMca_Fecha, PDO::PARAM_STR);
            $result->bindParam(3, $iMca_Estado, PDO::PARAM_STR);
            $result->bindParam(4, $iVar_IdVariable, PDO::PARAM_INT);
            $result->bindParam(5, $iEnt_IdEntidad, empty($iEnt_IdEntidad) ? null : $iEnt_IdEntidad, PDO::PARAM_NULL | PDO::PARAM_INT);
            $result->bindParam(6, $iEsm_IdEstacionMonitoreo, PDO::PARAM_INT);
            $result->bindParam(7, $iPai_IdPais, empty($iPai_IdPais) ? null : $iPai_IdPais, PDO::PARAM_NULL | PDO::PARAM_INT);
            $result->bindParam(8, $iRec_IdRecurso, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function insertarVariableEstudio(
    $iVar_Nombre, $iVar_Abreviatura, $iVar_Medida, $iVar_Estado, $iTiv_IdTipoVariable, $iVar_Columna
    ) 
    {
        try 
        {
            $id_registro = "";
            $sql = "call s_i_variables_estudio(?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iVar_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iVar_Abreviatura, PDO::PARAM_STR);
            $result->bindParam(3, $iVar_Medida, PDO::PARAM_STR);
            $result->bindParam(4, $iVar_Estado, PDO::PARAM_STR);
            $result->bindParam(5, $iTiv_IdTipoVariable, empty($iTiv_IdTipoVariable) ? null : $iTiv_IdTipoVariable, PDO::PARAM_NULL | PDO::PARAM_INT);
            $result->bindParam(6, $iVar_Columna, PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function insertarEstacion(
    $iEsm_Nombre, $iEsm_Longitud, $iEsm_Latitud, $iEsm_Referencia, $iEsm_Altitud, $iEsm_Estado, $iRic_IdRioCuenca, $iTie_IdTipoEstacion, $iMpd_IdMunicipioProvDist, $iEsd_IdEstadoDepartamento
    ) 
    {
        try 
        {
            $id_registro = "";
            $sql = "call s_i_estacion_monitoreo(?,?,?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsm_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iEsm_Longitud, PDO::PARAM_STR);
            $result->bindParam(3, $iEsm_Latitud, PDO::PARAM_STR);
            $result->bindParam(4, $iEsm_Referencia, PDO::PARAM_STR);
            $result->bindParam(5, $iEsm_Altitud, PDO::PARAM_INT);
            $result->bindParam(6, $iEsm_Estado, PDO::PARAM_INT);
            $result->bindParam(7, $iRic_IdRioCuenca, empty($iRic_IdRioCuenca) ? null : $iRic_IdRioCuenca, PDO::PARAM_NULL | PDO::PARAM_INT);
            $result->bindParam(8, $iTie_IdTipoEstacion, empty($iTie_IdTipoEstacion) ? null : $iTie_IdTipoEstacion, PDO::PARAM_NULL | PDO::PARAM_INT);
            $result->bindParam(9, $iMpd_IdMunicipioProvDist, empty($iMpd_IdMunicipioProvDist) ? null : $iMpd_IdMunicipioProvDist, PDO::PARAM_NULL | PDO::PARAM_INT);
            $result->bindParam(10, $iEsd_IdEstadoDepartamento, empty($iEsd_IdEstadoDepartamento) ? null : $iEsd_IdEstadoDepartamento, PDO::PARAM_NULL | PDO::PARAM_INT);

            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    //Para monitoreo
    public function listarPais() 
    {
        $post = $this->_db->query("SELECT * from pais");
        return $post->fetchAll();
    }

    public function listarRio() 
    {
        $post = $this->_db->query("SELECT * FROM rio");
        return $post->fetchAll();
    }

    public function listarRioXCuenca($idcuenca) 
    {
        $post = $this->_db->query("SELECT DISTINCT r.* FROM rio r 
                    INNER JOIN rio_cuenca rc ON rc.Rio_IdRio=r.Rio_IdRio 
                    WHERE rc.Cue_IdCuenca= $idcuenca ORDER BY r.Rio_Nombre");
        return $post->fetchAll();
    }

    public function listarCuencaXpais($idpais) 
    {
        $post = $this->_db->query("SELECT DISTINCT c.* FROM rio r
            INNER JOIN rio_cuenca rc ON rc.Rio_IdRio=r.Rio_IdRio
            INNER JOIN cuenca c ON c.Cue_IdCuenca=rc.Cue_IdCuenca
            WHERE r.Pai_IdPais=$idpais ORDER BY c.Cue_Nombre");
        return $post->fetchAll();
    }

    //Para monitoreo
    public function listarPaisMonitoreo() 
    {
        $post = $this->_db->query("SELECT DISTINCT(p.Pai_IdPais),p.Pai_Nombre  
            FROM pais p INNER JOIN monitoreo_calidad_agua mca ON mca.Pai_IdPais =p.Pai_IdPais");
        return $post->fetchAll();
    }

    //Para monitoreo
    public function listarEstadoECA() 
    {
        $post = $this->_db->query("SELECT * FROM estado_eca");
        return $post->fetchAll();
    }

    //Para monitoreo
    public function PuntosCompletoPorpais($pais, $numero) 
    {
        $valorPar = $this->ValorParametrosPorPais($pais, $numero);

        $estacion = array(
            "estacion" => $this->puntosPorPais($pais, $numero)
            , "estadoeca" => $this->listarEstadoECA()
        );
        for ($i = 0; $i < count($estacion["estacion"]); $i++) 
        {
            $temp = array();
            for ($j = 0; $j < count($valorPar); $j++) 
            {
                if ($estacion["estacion"][$i]["EstacionId"] == $valorPar[$j]["EstacionId"]) 
                {
                    $temp[$j] = $valorPar[$j];
                }
            }
            $estacion["estacion"][$i]["params"] = $temp;
        }
        return $estacion;
    }

    public function puntosPorVariablesCompleto($idvariables, $idIdioma) 
    {
        $estacion = $this->puntosPorVariable($idvariables, $idIdioma);

        for ($i = 0; $i < count($estacion); $i++) 
        {
            $temp = $this->MonitoreoCAxEstacionVariable($estacion[$i]["Esm_IdEstacionMonitoreo"], $idvariables, $idIdioma);
            $estacion[$i]["variables"] = $temp;
        }

        return $estacion;
    }

    //Para monitoreo
    public function VariablesCompletoPorEstacioncion($estacion, $variables) 
    {
        $valorPar = $this->VariablesPorEstacion($estacion, $variables);
        $estacion = array(
            "estacion" => $this->EstacionPorId($estacion),
            "estadoeca" => $this->listarEstadoECA()
        );
        $temp = array();
        for ($j = 0; $j < count($valorPar); $j++) 
        {
            if ($estacion["estacion"]["EstacionId"] == $valorPar[$j]["EstacionId"]) 
            {
                $temp[$j] = $valorPar[$j];
            }
        }
        $estacion["estacion"]["params"] = $temp;

        return $estacion;
    }

    //Para monitoreo
    public function ValorParametrosPorPais($pais, $numero) 
    {
        $para = "";
        $count = count($numero);

        if ($count && $numero) {
            $para = "mca.Var_IdVariable = " . $numero[0];
            for ($i = 1; $i < $count; $i++) {
                $para = $para . " or mca.Var_IdVariable = " . $numero[$i];
            }
            $para = "WHERE ($para) ";
        }

        $count2 = count($pais);
        $tempais = "";
        if ($count2 && $pais) 
        {
            $tempais = "mca.Pai_IdPais = " . $pais[0];
            for ($i = 1; $i < $count2; $i++) 
            {
                $tempais = $tempais . " or mca.Pai_IdPais = " . $pais[$i];
            }

            $tempais = "and ($tempais)";
        }

        $post = $this->_db->query("SELECT epm.Esm_IdEstacionMonitoreo, 
            mca.Var_IdVariable, par.Var_Nombre, par.Var_Abreviatura, mca.Mca_Valor, par.Var_Medida, 
            mca.Mca_Fecha, cae.Cae_Nombre, cae.Cae_Fuente, eca.eca_minimo, eca.eca_maximo, 
            eca.eca_signo,
            CASE eca.eca_signo
            WHEN '<' THEN  
            CASE WHEN mca.Mca_Valor < eca.eca_maximo
            THEN 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '<=' THEN 
            CASE WHEN mca.Mca_Valor <= eca.eca_maximo
            THEN 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '>' THEN 
            CASE WHEN mca.Mca_Valor > eca.eca_minimo
            THEN 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '>=' THEN 
            CASE WHEN mca.Mca_Valor >= eca.eca_minimo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '[]' THEN 
            CASE WHEN mca.Mca_Valor >= eca.eca_minimo AND mca.Mca_Valor <= eca.eca_maximo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            END AS EstadoECA FROM monitoreo_calidad_agua mca 
            INNER JOIN estacion_monitoreo epm ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo
            INNER JOIN variables_estudio par ON mca.Var_IdVariable = par.Var_IdVariable
            LEFT JOIN estandar_calidad_ambiental_agua eca ON par.Var_IdVariable=eca.Var_IdVariable
            LEFT JOIN sub_categoria_eca sce ON  sce.Sue_IdSubcategoriaEca=eca.Sue_IdSubcategoriaEca
            LEFT JOIN categoria_eca cae ON cae.Cae_IdCategoriaEca=sce.Cae_IdCategoriaEca
            " .
            " $para $tempais" .
            " ORDER BY par.Var_Nombre,mca.Mca_Fecha ASC");

        return $post->fetchAll();
    }

    public function ValorVariablesPorEstacionVariable($idestacion, $variables) 
    {
        $para = "";
        $count = count($variables);
        $where = "WHERE mca.Esm_IdEstacionMonitoreo = " . $idestacion;
        if ($count && $variables) 
        {
            $para = "mca.Var_IdVariable = " . $variables[0];
            for ($i = 1; $i < $count; $i++) 
            {
                $para = $para . " or mca.Var_IdVariable = " . $variables[$i];
            }
            $where = $where . " and ($para)";
        }

        $post = $this->_db->query(
            "SELECT epm.Esm_IdEstacionMonitoreo, mca.Var_IdVariable, par.Var_Nombre, 
            par.Var_Abreviatura, mca.Mca_Valor, par.Var_Medida, par.Var_DescripcionMedida,
            mca.Mca_Fecha, cae.Cae_Nombre, cae.Cae_Fuente, eca.eca_minimo, eca.eca_maximo, 
            eca.eca_signo,
            CASE eca.eca_signo
            WHEN '<' THEN
            CASE WHEN mca.Mca_Valor < eca.eca_maximo
            THEN (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '<=' THEN
            CASE WHEN mca.Mca_Valor <= eca.eca_maximo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '>' THEN
            CASE WHEN mca.Mca_Valor > eca.eca_minimo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '>=' THEN
            CASE WHEN mca.Mca_Valor >= eca.eca_minimo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '[]' THEN
            CASE WHEN mca.Mca_Valor >= eca.eca_minimo AND mca.Mca_Valor <= eca.eca_maximo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            END AS EstadoECA
            FROM monitoreo_calidad_agua mca 
            INNER JOIN estacion_monitoreo epm ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo
            INNER JOIN variables_estudio par ON mca.Var_IdVariable = par.Var_IdVariable
            LEFT JOIN estandar_calidad_ambiental_agua eca ON par.Var_IdVariable=eca.Var_IdVariable
            LEFT JOIN sub_categoria_eca sce ON  sce.Sue_IdSubcategoriaEca=eca.Sue_IdSubcategoriaEca
            LEFT JOIN categoria_eca cae ON cae.Cae_IdCategoriaEca=sce.Cae_IdCategoriaEca
            " .
            " $where " .
            " ORDER BY par.Var_Nombre,mca.Mca_Fecha ASC");

        return $post->fetchAll();
    }

    public function MonitoreoCAxEstacionVariable($idestacion, $variables, $idIdioma) 
    {
        $recurso = $variables[0][1];
        $recurso = explode(",", $recurso);

        $param_r = "Rec_IdRecurso=$recurso[0]";
        for ($i = 1; $i < count($recurso); $i++) 
        {
            $param_r = $param_r . " or Rec_IdRecurso =$recurso[$i]";
        }

        $para = "";
        $count = count($variables);
        $where = "WHERE mca.Esm_IdEstacionMonitoreo = " . $idestacion;
        if ($count && $variables) 
        {
            if (trim($variables[0][2]) == "Var_Nombre")
                $para = " var.Var_Nombre  LIKE CONCAT('%','" . $variables[0][0] . "','%')";
            for ($i = 1; $i < $count; $i++) 
            {
                if (trim($variables[$i][2]) == "Var_Nombre")
                    $para = $para . " or var.Var_Nombre  LIKE CONCAT('%','" . $variables[$i][0] . "','%')";
            }
            if (empty($para)) 
            {
                $where = $where . " and ($param_r)";
            }
            else 
            {
                $where = $where . " and ($para) and ($param_r)";
            }          
        }

        $post = $this->_db->query(
                "SELECT SQL_SMALL_RESULT  DISTINCT(mca.Var_IdVariable) Var_IdVariable, 
                mca.Esm_IdEstacionMonitoreo 
                FROM monitoreo_calidad_agua mca INNER JOIN variables_estudio var ON 
                var.Var_IdVariable=mca.Var_IdVariable $where");

        return $post->fetchAll();
    }

    //Para monitoreo
    public function VariablesPorEstacion($estacion, $numero) 
    {
        $para = " where ";
        $count = count($numero);
        if ($count && $numero) 
        {
            $para = "mca.Var_IdVariable = " . $numero[0];
            for ($i = 1; $i < $count; $i++) 
            {
                $para = $para . " or mca.Var_IdVariable = " . $numero[$i];
            }

            $para = " where ($para) and";
        }


        $post = $this->_db->query(
                "SELECT epm.Esm_IdEstacionMonitoreo ,
                mca.Var_IdVariable , 
                par.Var_Nombre ,
                par.Var_Abreviatura,
                mca.Mca_Valor ,
                par.Var_Medida ,
                mca.Mca_Fecha,
                cae.Cae_Nombre,
                cae.Cae_Fuente,
                eca.eca_minimo,
                eca.eca_maximo,
                eca.eca_signo,
                CASE eca.eca_signo
                WHEN '<' THEN  
                	CASE WHEN mca.Mca_Valor < eca.eca_maximo
                	THEN 
                	(SELECT estado_eca.ese_color FROM estado_eca 
                	WHERE ese_refencia=1)
                	ELSE
                	(SELECT estado_eca.ese_color FROM estado_eca 
                	WHERE ese_refencia=0)
                	END
                WHEN '<=' THEN 
                	CASE WHEN mca.Mca_Valor <= eca.eca_maximo
                	THEN 
                	(SELECT estado_eca.ese_color FROM estado_eca 
                	WHERE ese_refencia=1)
                	ELSE
                	(SELECT estado_eca.ese_color FROM estado_eca 
                	WHERE ese_refencia=0)
                	END
                WHEN '>' THEN 
                	CASE WHEN mca.Mca_Valor > eca.eca_minimo
                	THEN 
                	(SELECT estado_eca.ese_color FROM estado_eca 
                	WHERE ese_refencia=1)
                	ELSE
                	(SELECT estado_eca.ese_color FROM estado_eca 
                	WHERE ese_refencia=0)
                	END
                WHEN '>=' THEN 
                        CASE WHEN mca.Mca_Valor >= eca.eca_minimo
                	THEN 
                	(SELECT estado_eca.ese_color FROM estado_eca 
                	WHERE ese_refencia=1)
                	ELSE
                	(SELECT estado_eca.ese_color FROM estado_eca 
                	WHERE ese_refencia=0)
                	END
                WHEN '[]' THEN 
                	CASE WHEN mca.Mca_Valor >= eca.eca_minimo AND mca.Mca_Valor <= eca.eca_maximo
                	THEN 
                	(SELECT estado_eca.ese_color FROM estado_eca 
                	WHERE ese_refencia=1)
                	ELSE
                	(SELECT estado_eca.ese_color FROM estado_eca 
                	WHERE ese_refencia=0)
                	END
                END AS EstadoECA
                FROM monitoreo_calidad_agua mca 
                INNER JOIN estacion_monitoreo epm ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo
                INNER JOIN variables_estudio par ON mca.Var_IdVariable = par.Var_IdVariable
                LEFT JOIN estandar_calidad_ambiental_agua eca ON par.Var_IdVariable=eca.Var_IdVariable
                LEFT JOIN sub_categoria_eca sce ON  sce.Sue_IdSubcategoriaEca=eca.Sue_IdSubcategoriaEca
                LEFT JOIN categoria_eca cae ON cae.Cae_IdCategoriaEca=sce.Cae_IdCategoriaEca" .
                                " $para (epm.Esm_IdEstacionMonitoreo=$estacion)" .
                                " ORDER BY par.Var_Nombre,mca.Mca_Fecha ASC");

        return $post->fetchAll();
    }

    //AGREGADO
    public function getFechasMonitoreoV($estacion, $numero) 
    {
        $para = " where ";
        $count = count($numero);
        if ($count && $numero) 
        {
            $para = "mca.Var_IdVariable = " . $numero[0];
            for ($i = 1; $i < $count; $i++) 
            {
                $para = $para . " or mca.Var_IdVariable = " . $numero[$i];
            }
            $para = " where ($para) and";
        }


        $post = $this->_db->query(
            "SELECT epm.Esm_IdEstacionMonitoreo, mca.Var_IdVariable, par.Var_Nombre, 
            par.Var_Abreviatura, mca.Mca_Valor, par.Var_Medida, mca.Mca_Fecha, cae.Cae_Nombre,
            cae.Cae_Fuente, eca.eca_minimo, eca.eca_maximo, eca.eca_signo, 
            CASE eca.eca_signo
            WHEN '<' THEN  
            CASE WHEN mca.Mca_Valor < eca.eca_maximo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '<=' THEN
            CASE WHEN mca.Mca_Valor <= eca.eca_maximo
            THEN 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '>' THEN
            CASE WHEN mca.Mca_Valor > eca.eca_minimo 
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '>=' THEN
            CASE WHEN mca.Mca_Valor >= eca.eca_minimo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '[]' THEN 
            CASE WHEN mca.Mca_Valor >= eca.eca_minimo AND mca.Mca_Valor <= eca.eca_maximo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            END AS EstadoECA
            FROM monitoreo_calidad_agua mca 
            INNER JOIN estacion_monitoreo epm ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo
            INNER JOIN variables_estudio par ON mca.Var_IdVariable = par.Var_IdVariable
            LEFT JOIN estandar_calidad_ambiental_agua eca ON par.Var_IdVariable=eca.Var_IdVariable
            LEFT JOIN sub_categoria_eca sce ON  sce.Sue_IdSubcategoriaEca=eca.Sue_IdSubcategoriaEca
            LEFT JOIN categoria_eca cae ON cae.Cae_IdCategoriaEca=sce.Cae_IdCategoriaEca" .
                " $para (epm.Esm_IdEstacionMonitoreo=$estacion)" .
                " group by Mca_Fecha " .
                " ORDER BY par.Var_Nombre,mca.Mca_Fecha ASC");

        return $post->fetchAll();
    }

    public function getValoresPromediadosPorFechaV($estacion, $numero) 
    {
        $para = " where ";
        $count = count($numero);
        if ($count && $numero) 
        {
            $para = "mca.Var_IdVariable = " . $numero[0];
            for ($i = 1; $i < $count; $i++) 
            {
                $para = $para . " or mca.Var_IdVariable = " . $numero[$i];
            }

            $para = " where ($para) and";
        }

        $post = $this->_db->query(
                "SELECT epm.Esm_IdEstacionMonitoreo, mca.Var_IdVariable, 
                par.Var_Nombre, par.Var_Abreviatura, avg(mca.Mca_Valor)Mca_Valor,
                par.Var_Medida, mca.Mca_Fecha, cae.Cae_Nombre, cae.Cae_Fuente,
                eca.eca_minimo, eca.eca_maximo, eca.eca_signo, 
                CASE eca.eca_signo
                WHEN '<' THEN
                CASE WHEN mca.Mca_Valor < eca.eca_maximo
                THEN
                (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
                ELSE
                (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
                END
                WHEN '<=' THEN
                CASE WHEN mca.Mca_Valor <= eca.eca_maximo
                THEN
                (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
                ELSE
                (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
                END
                WHEN '>' THEN
                CASE WHEN mca.Mca_Valor > eca.eca_minimo
                THEN
                (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
                ELSE
                (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
                END
                WHEN '>=' THEN
                CASE WHEN mca.Mca_Valor >= eca.eca_minimo
                THEN
                (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
                ELSE
                (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
                END
                WHEN '[]' THEN
                CASE WHEN mca.Mca_Valor >= eca.eca_minimo AND mca.Mca_Valor <= eca.eca_maximo
                THEN
                (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
                ELSE 
                (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
                END
                END AS EstadoECA
                FROM monitoreo_calidad_agua mca
                INNER JOIN estacion_monitoreo epm ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo
                INNER JOIN variables_estudio par ON mca.Var_IdVariable = par.Var_IdVariable
                LEFT JOIN estandar_calidad_ambiental_agua eca ON par.Var_IdVariable=eca.Var_IdVariable
                LEFT JOIN sub_categoria_eca sce ON  sce.Sue_IdSubcategoriaEca=eca.Sue_IdSubcategoriaEca
                LEFT JOIN categoria_eca cae ON cae.Cae_IdCategoriaEca=sce.Cae_IdCategoriaEca" .
                " $para (epm.Esm_IdEstacionMonitoreo=$estacion)" .
                " group by Var_IdVariable,Mca_Fecha " .
                " ORDER BY par.Var_Nombre,mca.Mca_Fecha ASC");

        return $post->fetchAll();
    }

    public function getVariablesMonitoreoV($estacion, $numero) 
    {
        $para = " where ";
        $count = count($numero);
        if ($count && $numero) 
        {
            $para = "mca.Var_IdVariable = " . $numero[0];
            for ($i = 1; $i < $count; $i++) 
            {
                $para = $para . " or mca.Var_IdVariable = " . $numero[$i];
            }

            $para = " where ($para) and";
        }

        $post = $this->_db->query("SELECT epm.Esm_IdEstacionMonitoreo, mca.Var_IdVariable,
            par.Var_Nombre, par.Var_Abreviatura, mca.Mca_Valor, par.Var_Medida, mca.Mca_Fecha,
            cae.Cae_Nombre, cae.Cae_Fuente, eca.eca_minimo, eca.eca_maximo, eca.eca_signo, 
            CASE eca.eca_signo
            WHEN '<' THEN
            CASE WHEN mca.Mca_Valor < eca.eca_maximo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '<=' THEN
            CASE WHEN mca.Mca_Valor <= eca.eca_maximo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '>' THEN
            CASE WHEN mca.Mca_Valor > eca.eca_minimo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '>=' THEN 
            CASE WHEN mca.Mca_Valor >= eca.eca_minimo
            THEN 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '[]' THEN 
            CASE WHEN mca.Mca_Valor >= eca.eca_minimo AND mca.Mca_Valor <= eca.eca_maximo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            END AS EstadoECA
            FROM monitoreo_calidad_agua mca
            INNER JOIN estacion_monitoreo epm ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo
            INNER JOIN variables_estudio par ON mca.Var_IdVariable = par.Var_IdVariable
            LEFT JOIN estandar_calidad_ambiental_agua eca ON par.Var_IdVariable=eca.Var_IdVariable
            LEFT JOIN sub_categoria_eca sce ON  sce.Sue_IdSubcategoriaEca=eca.Sue_IdSubcategoriaEca
            LEFT JOIN categoria_eca cae ON cae.Cae_IdCategoriaEca=sce.Cae_IdCategoriaEca" .
                " $para (epm.Esm_IdEstacionMonitoreo=$estacion)" .
                " group by Var_IdVariable " .
                " ORDER BY par.Var_Nombre,mca.Mca_Fecha ASC");

        return $post->fetchAll();
    }

    public function getIcaMonitoreo($idestacion, $idica, $idcategoriaica) 
    {
        $post = $this->_db->query("select temp.Esm_IdEstacionMonitoreo,(sum(indice*peso)/sum(peso)) ica, Mca_Fecha, fn_obtener_clasificacion_ica((sum(indice*peso)/sum(peso)),$idica,$idcategoriaica) clasificacion 
                    from (SELECT epm.Esm_IdEstacionMonitoreo , mca.Var_IdVariable , par.Var_Nombre , par.Var_Abreviatura,avg(mca.Mca_Valor)Mca_Valor, 
                    par.Var_Medida, 
                    mca.Mca_Fecha,
                    cae.Cae_Nombre,
                    cae.Cae_Fuente,
                    eca.eca_minimo,
                    eca.eca_maximo,
                    eca.eca_signo,
                    CASE eca.eca_signo
                    WHEN '<' THEN  
                    CASE WHEN mca.Mca_Valor < eca.eca_maximo
                                THEN 
                                (SELECT estado_eca.ese_color FROM estado_eca 
                                WHERE ese_refencia=1)
                                ELSE
                                (SELECT estado_eca.ese_color FROM estado_eca 
                                WHERE ese_refencia=0)
                                END
                        WHEN '<=' THEN 
                                CASE WHEN mca.Mca_Valor <= eca.eca_maximo
                                THEN 
                                (SELECT estado_eca.ese_color FROM estado_eca 
                                WHERE ese_refencia=1)
                                ELSE
                                (SELECT estado_eca.ese_color FROM estado_eca 
                                WHERE ese_refencia=0)
                                END
                        WHEN '>' THEN 
                                CASE WHEN mca.Mca_Valor > eca.eca_minimo
                                THEN 
                                (SELECT estado_eca.ese_color FROM estado_eca 
                                WHERE ese_refencia=1)
                                ELSE
                                (SELECT estado_eca.ese_color FROM estado_eca 
                                WHERE ese_refencia=0)
                                END
                        WHEN '>=' THEN 
                                CASE WHEN mca.Mca_Valor >= eca.eca_minimo
                                THEN 
                                (SELECT estado_eca.ese_color FROM estado_eca 
                                WHERE ese_refencia=1)
                                ELSE
                                (SELECT estado_eca.ese_color FROM estado_eca 
                                WHERE ese_refencia=0)
                                END
                        WHEN '[]' THEN 
                                CASE WHEN mca.Mca_Valor >= eca.eca_minimo AND mca.Mca_Valor <= eca.eca_maximo
                                THEN 
                                (SELECT estado_eca.ese_color FROM estado_eca 
                                WHERE ese_refencia=1)
                                ELSE
                                (SELECT estado_eca.ese_color FROM estado_eca 
                                WHERE ese_refencia=0)
                                END
                        END AS EstadoECA
                        ,fn_calcular_indice(mca.Var_IdVariable,Mca_Valor,$idica) indice
                        ,fn_calcular_ponderacion(mca.Var_IdVariable,$idica) peso 
                        FROM monitoreo_calidad_agua mca 
                        INNER JOIN estacion_monitoreo epm ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo 
                        INNER JOIN variables_estudio par ON mca.Var_IdVariable = par.Var_IdVariable 
                        LEFT JOIN estandar_calidad_ambiental_agua eca ON par.Var_IdVariable=eca.Var_IdVariable 
                        LEFT JOIN sub_categoria_eca sce ON  sce.Sue_IdSubcategoriaEca=eca.Sue_IdSubcategoriaEca 
                        LEFT JOIN categoria_eca cae ON cae.Cae_IdCategoriaEca=sce.Cae_IdCategoriaEca 
                        where  (epm.Esm_IdEstacionMonitoreo=$idestacion) 
                        group by Var_IdVariable,Mca_Fecha 
                        ORDER BY mca.Mca_Fecha ASC) as temp 
                        group by Mca_Fecha");

        return $post->fetchAll();
    }

    //Para monitoreo
    public function VariablesPorId($idvariable) 
    {
        $post = $this->_db->query(
                "SELECT par.Var_IdVariable, par.Var_Nombre, eca.eca_minimo, eca.eca_maximo, eca.eca_signo, eca.eca_signo,
                par.Var_Medida FROM variables_estudio par LEFT JOIN estandar_calidad_ambiental_agua eca ON par.Var_IdVariable=eca.Var_IdVariable" 
                ." where par.Var_IdVariable=$idvariable" 
                ." ORDER BY par.Var_Nombre");
        return $post->fetch();
    }

    //Para monitoreo
    public function ListarEstacionCompleto($busqueda = "", $idpais = 0, $idrio = 0, $idcuenca = 0) 
    {
        try 
        {
            $and = "";

            if (!empty($idpais)) 
            {
                $and.=" AND p.Pai_IdPais=$idpais ";
            }

            if (!empty($idrio)) 
            {
                $and.=" AND r.Rio_IdRio=$idrio ";
            }

            if (!empty($idcuenca)) 
            {
                $and.=" AND c.Cue_IdCuenca=$idcuenca ";
            }

            $busqueda = trim($busqueda);
            $sql = "SELECT SQL_SMALL_RESULT DISTINCT(epm.Esm_IdEstacionMonitoreo) AS Esm_IdEstacionMonitoreo, 
                epm.Esm_Nombre AS Esm_Nombre,     
                p.Pai_Nombre ,
                TRIM(epm.Esm_Latitud) AS Esm_Latitud,
                TRIM(epm.Esm_Longitud) AS Esm_Longitud,
                r.Rio_Nombre,
                c.Cue_Nombre AS Cue_Nombre  
                FROM monitoreo_calidad_agua mca
                INNER JOIN pais p ON mca.Pai_IdPais=p.Pai_IdPais
                INNER JOIN estacion_monitoreo epm ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo
                LEFT JOIN rio_cuenca rc ON rc.Ric_IdRioCuenca = epm.Ric_IdRioCuenca
                LEFT JOIN cuenca c ON c.Cue_IdCuenca=rc.Cue_IdCuenca
                LEFT JOIN rio r ON r.Rio_IdRio=rc.Rio_IdRio
                WHERE epm.Esm_Nombre LIKE '%$busqueda%' $and " .
                    " ORDER BY epm.Esm_IdEstacionMonitoreo";

            $result = $this->_db->prepare($sql);
            $result->execute();
            return $result->fetchAll();

        } catch (PDOException $exception) 
        {
            $this->insertarBitacora("Ocurrio un error al momento de Litar las capas: Parametros: " . $busqueda, "MySql", Session::get('usuario'), $exception->getFile(), "listarCapaWms", $exception->getMessage(), 1);
            return $exception->getMessage();
        }
    }

    public function puntosPorVariable($numero, $idIdioma) 
    {
        $para = "";
        $count = count($numero);
        $recurso = $numero[0][1];
        $recurso = explode(",", $recurso);

        $param_r = "Rec_IdRecurso=$recurso[0]";
        for ($i = 1; $i < count($recurso); $i++) 
        {
            $param_r = $param_r . " or Rec_IdRecurso =$recurso[$i]";
        }

        if ($count && $numero) 
        {
            if (is_numeric($numero[0][0])) 
            {
                $para = " " . $numero[0][2] . "  =  " . $numero[0][0];
            } 
            else 
            {
                $para = " " . $numero[0][2] . "  LIKE CONCAT('%','" . $numero[0][0] . "','%')";
            }

            for ($i = 1; $i < $count; $i++) 
            {
                if (is_numeric($numero[0][0])) 
                {
                    $para = $para . " or " . $numero[$i][2] . "  = " . $numero[$i][0];
                } 
                else 
                {
                    $para = $para . " or " . $numero[$i][2] . "  LIKE CONCAT('%','" . $numero[$i][0] . "','%')";
                }
            }
        }

        $para = " where ($para) and ($param_r) AND Mca_Estado=1 AND epm.Esm_Estado='1'";

        $scrip_sql="SELECT SQL_SMALL_RESULT (epm.Esm_IdEstacionMonitoreo) AS Esm_IdEstacionMonitoreo, epm.Esm_Nombre AS Esm_Nombre, TRIM(epm.Esm_Latitud) AS 
            Esm_Latitud, TRIM(epm.Esm_Longitud) AS Esm_Longitud, MAX(mca.Mca_Fecha)
            /*(select max(mca2.Mca_Fecha) from monitoreo_calidad_agua mca2 where mca2.Esm_IdEstacionMonitoreo=mca.Esm_IdEstacionMonitoreo)*/
            FROM monitoreo_calidad_agua mca
            INNER JOIN variables_estudio var ON var.Var_IdVariable=mca.Var_IdVariable            
            INNER JOIN estacion_monitoreo epm ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo
            INNER JOIN rio_cuenca rc ON rc.Ric_IdRioCuenca =epm.Ric_IdRioCuenca "
                . $para .
                " GROUP BY epm.Esm_IdEstacionMonitoreo ORDER BY epm.Esm_IdEstacionMonitoreo";

        $post = $this->_db->query($scrip_sql);

        return $post->fetchAll();
    }

    //Para monitoreo
    public function EstacionPorId($estacion) 
    {
        $post = $this->_db->query(
                "SELECT SQL_SMALL_RESULT DISTINCT(epm.Esm_IdEstacionMonitoreo) Esm_IdEstacionMonitoreo, 
                epm.Esm_Nombre AS Esm_Nombre,
                p.Pai_Nombre AS Pai_Nombre,
                TRIM(epm.Esm_Latitud) AS Esm_Latitud,
                TRIM(epm.Esm_Longitud) AS Esm_Longitud,
                r.Rio_Nombre,
                c.Cue_Nombre AS Cue_Nombre  
                FROM estacion_monitoreo epm
                INNER JOIN  monitoreo_calidad_agua  mca ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo
                INNER JOIN pais p ON mca.Pai_IdPais=p.Pai_IdPais
                LEFT JOIN rio_cuenca rc ON rc.Ric_IdRioCuenca = epm.Ric_IdRioCuenca
                LEFT JOIN cuenca c ON c.Cue_IdCuenca=rc.Cue_IdCuenca
                   LEFT JOIN rio r ON r.Rio_IdRio=rc.Rio_IdRio
                WHERE epm.Esm_IdEstacionMonitoreo=$estacion"
        );

        return $post->fetch();
    }

    //Para monitoreo
    public function EstacionPorVariable($idvariable) 
    {
        $post = $this->_db->query("SELECT epm.Esm_IdEstacionMonitoreo, epm.Esm_Nombre, p.Pai_Nombre,
            TRIM(epm.Esm_Latitud)AS Esm_Latitud,
            TRIM(epm.Esm_Longitud)AS Esm_Longitud, c.Cue_Nombre, mca.Mca_Valor, cae.Cae_Nombre,
            cae.Cae_Fuente, eca.eca_minimo, eca.eca_maximo, eca.eca_signo, 
            CASE eca.eca_signo
            WHEN '<' THEN 
            CASE WHEN mca.Mca_Valor < eca.eca_maximo
            THEN 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '<=' THEN 
            CASE WHEN mca.Mca_Valor <= eca.eca_maximo 
            THEN 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '>' THEN 
            CASE WHEN mca.Mca_Valor > eca.eca_minimo
            THEN 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '>=' THEN 
            CASE WHEN mca.Mca_Valor >= eca.eca_minimo
            THEN 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '[]' THEN 
            CASE WHEN mca.Mca_Valor >= eca.eca_minimo AND mca.Mca_Valor <= eca.eca_maximo
            THEN 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            END AS EstadoECA, mca.Mca_Fecha 
            FROM monitoreo_calidad_agua mca 
            INNER JOIN estacion_monitoreo epm ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo
            INNER JOIN variables_estudio par ON mca.Var_IdVariable = par.Var_IdVariable 
            LEFT JOIN estandar_calidad_ambiental_agua eca ON par.Var_IdVariable=eca.Var_IdVariable
            INNER JOIN pais p ON mca.Pai_IdPais=p.Pai_IdPais
            LEFT JOIN rio_cuenca rc ON rc.Ric_IdRioCuenca = epm.Ric_IdRioCuenca
            LEFT JOIN cuenca c ON c.Cue_IdCuenca=rc.Cue_IdCuenca 
            LEFT JOIN sub_categoria_eca sce ON  sce.Sue_IdSubcategoriaEca=eca.Sue_IdSubcategoriaEca
            LEFT JOIN categoria_eca cae ON cae.Cae_IdCategoriaEca=sce.Cae_IdCategoriaEca" .
                " where mca.Var_IdVariable=$idvariable AND mca.Mca_Estado=1" .
                " ORDER BY epm.Esm_IdEstacionMonitoreo"
        );

        return $post->fetchall();
    }

    public function getFechasMonitoreoE($idvariable) 
    {
        $post = $this->_db->query("SELECT epm.Esm_IdEstacionMonitoreo, epm.Esm_Nombre, p.Pai_Nombre,
            TRIM(epm.Esm_Latitud)AS Esm_Latitud, TRIM(epm.Esm_Longitud)AS Esm_Longitud, c.Cue_Nombre,mca.Mca_Valor, cae.Cae_Nombre, cae.Cae_Fuente, eca.eca_minimo, eca.eca_maximo, eca.eca_signo, CASE eca.eca_signo
            WHEN '<' THEN 
            CASE WHEN mca.Mca_Valor < eca.eca_maximo
            THEN 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '<=' THEN 
            CASE WHEN mca.Mca_Valor <= eca.eca_maximo
            THEN  
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)	
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '>' THEN 
            CASE WHEN mca.Mca_Valor > eca.eca_minimo
            THEN 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '>=' THEN 
            CASE WHEN mca.Mca_Valor >= eca.eca_minimo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '[]' THEN 
            CASE WHEN mca.Mca_Valor >= eca.eca_minimo AND mca.Mca_Valor <= eca.eca_maximo
            THEN 
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            END AS EstadoECA,
            mca.Mca_Fecha 
            FROM monitoreo_calidad_agua mca INNER JOIN estacion_monitoreo epm ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo
            INNER JOIN variables_estudio par ON mca.Var_IdVariable = par.Var_IdVariable
            LEFT JOIN estandar_calidad_ambiental_agua eca ON par.Var_IdVariable=eca.Var_IdVariable
            INNER JOIN pais p ON mca.Pai_IdPais=p.Pai_IdPais
            LEFT JOIN rio_cuenca rc ON rc.Ric_IdRioCuenca = epm.Ric_IdRioCuenca
            LEFT JOIN cuenca c ON c.Cue_IdCuenca=rc.Cue_IdCuenca 
            LEFT JOIN sub_categoria_eca sce ON  sce.Sue_IdSubcategoriaEca=eca.Sue_IdSubcategoriaEca
            LEFT JOIN categoria_eca cae ON cae.Cae_IdCategoriaEca=sce.Cae_IdCategoriaEca" .
                " where mca.Var_IdVariable=$idvariable" .
                " group by Mca_Fecha " .
                " ORDER BY epm.Esm_IdEstacionMonitoreo"
        );

        return $post->fetchall();
    }

    public function getValoresPromediadosPorFechaE($idvariable) 
    {
        $post = $this->_db->query("SELECT epm.Esm_IdEstacionMonitoreo, epm.Esm_Nombre, 
            p.Pai_Nombre, TRIM(epm.Esm_Latitud)AS Esm_Latitud, TRIM(epm.Esm_Longitud)AS Esm_Longitud,
            c.Cue_Nombre, avg(mca.Mca_Valor)Mca_Valor, cae.Cae_Nombre, cae.Cae_Fuente, eca.eca_minimo, eca.eca_maximo, eca.eca_signo, 
            CASE eca.eca_signo 
            WHEN '<' THEN 
            CASE WHEN mca.Mca_Valor < eca.eca_maximo
            THEN
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=1)
            ELSE
            (SELECT estado_eca.ese_color FROM estado_eca WHERE ese_refencia=0)
            END
            WHEN '<=' THEN
            CASE WHEN mca.Mca_Valor <= eca.eca_maximo
	THEN 
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=1)
	ELSE
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=0)
	END
WHEN '>' THEN 
	CASE WHEN mca.Mca_Valor > eca.eca_minimo
	THEN 
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=1)
	ELSE
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=0)
	END
WHEN '>=' THEN 
        CASE WHEN mca.Mca_Valor >= eca.eca_minimo
	THEN 
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=1)
	ELSE
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=0)
	END
WHEN '[]' THEN 
	CASE WHEN mca.Mca_Valor >= eca.eca_minimo AND mca.Mca_Valor <= eca.eca_maximo
	THEN 
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=1)
	ELSE
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=0)
	END

END AS EstadoECA,
mca.Mca_Fecha 
FROM monitoreo_calidad_agua mca 
INNER JOIN estacion_monitoreo epm ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo
INNER JOIN variables_estudio par ON mca.Var_IdVariable = par.Var_IdVariable
LEFT JOIN estandar_calidad_ambiental_agua eca ON par.Var_IdVariable=eca.Var_IdVariable
INNER JOIN pais p ON mca.Pai_IdPais=p.Pai_IdPais
LEFT JOIN rio_cuenca rc ON rc.Ric_IdRioCuenca = epm.Ric_IdRioCuenca
LEFT JOIN cuenca c ON c.Cue_IdCuenca=rc.Cue_IdCuenca 
LEFT JOIN sub_categoria_eca sce ON  sce.Sue_IdSubcategoriaEca=eca.Sue_IdSubcategoriaEca
LEFT JOIN categoria_eca cae ON cae.Cae_IdCategoriaEca=sce.Cae_IdCategoriaEca" .
                " where mca.Var_IdVariable=$idvariable" .
                " group by Esm_IdEstacionMonitoreo,Mca_Fecha " .
                " ORDER BY epm.Esm_IdEstacionMonitoreo"
        );

        return $post->fetchall();
    }

    public function getEstacionesMonitoreoE($idvariable) {


        $post = $this->_db->query(
                "SELECT epm.Esm_IdEstacionMonitoreo,
epm.Esm_Nombre , 
p.Pai_Nombre ,
TRIM(epm.Esm_Latitud)AS Esm_Latitud ,
TRIM(epm.Esm_Longitud)AS Esm_Longitud, 
c.Cue_Nombre, 
mca.Mca_Valor,
cae.Cae_Nombre,
cae.Cae_Fuente,
eca.eca_minimo,
eca.eca_maximo,
eca.eca_signo,
CASE eca.eca_signo
WHEN '<' THEN  
	CASE WHEN mca.Mca_Valor < eca.eca_maximo
	THEN 
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=1)
	ELSE
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=0)
	END
WHEN '<=' THEN 
	CASE WHEN mca.Mca_Valor <= eca.eca_maximo
	THEN 
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=1)
	ELSE
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=0)
	END
WHEN '>' THEN 
	CASE WHEN mca.Mca_Valor > eca.eca_minimo
	THEN 
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=1)
	ELSE
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=0)
	END
WHEN '>=' THEN 
        CASE WHEN mca.Mca_Valor >= eca.eca_minimo
	THEN 
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=1)
	ELSE
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=0)
	END
WHEN '[]' THEN 
	CASE WHEN mca.Mca_Valor >= eca.eca_minimo AND mca.Mca_Valor <= eca.eca_maximo
	THEN 
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=1)
	ELSE
	(SELECT estado_eca.ese_color FROM estado_eca 
	WHERE ese_refencia=0)
	END

END AS EstadoECA,
mca.Mca_Fecha 
FROM monitoreo_calidad_agua mca 
INNER JOIN estacion_monitoreo epm ON mca.Esm_IdEstacionMonitoreo = epm.Esm_IdEstacionMonitoreo
INNER JOIN variables_estudio par ON mca.Var_IdVariable = par.Var_IdVariable
LEFT JOIN estandar_calidad_ambiental_agua eca ON par.Var_IdVariable=eca.Var_IdVariable
INNER JOIN pais p ON mca.Pai_IdPais=p.Pai_IdPais
LEFT JOIN rio_cuenca rc ON rc.Ric_IdRioCuenca = epm.Ric_IdRioCuenca
LEFT JOIN cuenca c ON c.Cue_IdCuenca=rc.Cue_IdCuenca 
LEFT JOIN sub_categoria_eca sce ON  sce.Sue_IdSubcategoriaEca=eca.Sue_IdSubcategoriaEca
LEFT JOIN categoria_eca cae ON cae.Cae_IdCategoriaEca=sce.Cae_IdCategoriaEca" .
                " where mca.Var_IdVariable=$idvariable" .
                " group by Esm_IdEstacionMonitoreo " .
                " ORDER BY epm.Esm_IdEstacionMonitoreo"
        );

        return $post->fetchall();
    }

    //Para monitoreo
    public function tiposParamCompletoPorpais($pais = false) {

        $tipoparm = $this->tipoParamPorPais($pais);
        $parametros = $this->parametrosPorPais($pais);
        for ($i = 0; $i < count($tipoparm); $i++) {
            $temp = array();
            for ($j = 0; $j < count($parametros); $j++) {
                if ($tipoparm[$i]["Tiv_IdTipoVariable"] == $parametros[$j]["Tiv_IdTipoVariable"]) {
                    $temp[$j] = $parametros[$j];
                }
            }
            $tipoparm[$i]["params"] = $temp;
        }
        return $tipoparm;
    }

    //Para monitoreo
    public function parametrosPorPais($pais = false) {

        $para = "";
        if ($pais) {
            $count = count($pais);
            $para = "mca.Pai_IdPais = " . $pais[0];
            for ($i = 1; $i < $count; $i++) {
                $para = $para . " or mca.Pai_IdPais = " . $pais[$i];
            }
            $para = " and ($para)";
        }

        //consultar varibles
        $post = $this->_db->query(
                "SELECT DISTINCT(mca.Var_IdVariable), par.Var_Nombre, tip.Tiv_IdTipoVariable FROM monitoreo_calidad_agua mca
                INNER JOIN variables_estudio par ON mca.Var_IdVariable=par.Var_IdVariable
                INNER JOIN tipo_variable tip ON par.Tiv_IdTipoVariable = tip.Tiv_IdTipoVariable
                WHERE  mca.Mca_Valor>0 
                 $para");

        return $post->fetchAll();
    }

    //Para monitoreo
    public function tipoParamPorPais($pais = false) {

        $para = "";
        if (!empty($pais) && count($pais) > 0) {
            $count = count($pais);
            $para = "mca.Pai_IdPais = " . $pais[0];
            for ($i = 1; $i < $count; $i++) {
                $para = $para . " or mca.Pai_IdPais = " . $pais[$i];
            }
            $para = " WHERE ($para)";
        }


        $post = $this->_db->query(
                "SELECT DISTINCT(tip.Tiv_Nombre), tip.Tiv_IdTipoVariable FROM monitoreo_calidad_agua mca
                INNER JOIN variables_estudio par ON mca.Var_IdVariable=par.Var_IdVariable
                 INNER JOIN tipo_variable tip ON par.Tiv_IdTipoVariable = tip.Tiv_IdTipoVariable   
                 $para
                ");


        return $post->fetchAll();
    }

    //Para monitoreo
    public function tipoCapaPorPais($pais) {

        $para = "WHERE ISNULL(cm.Pai_IdPais)";

        $count = count($pais);
        if ($count) {
            $para = $para . " or cm.Pai_IdPais = " . $pais[0];
            for ($i = 1; $i < $count; $i++) {
                $para = $para . " or cm.Pai_IdPais = " . $pais[$i];
            }
        }
        //consultar varibles
        $post = $this->_db->query(
                "SELECT DISTINCT(jm.jem_IdJerarquiaCapa),jm.Jem_Nombre FROM jerarquia_monitoreo jm 
		INNER JOIN capas_monitoreo cm ON cm.jem_IdJerarquiaCapa=jm.jem_IdJerarquiaCapa		
                  $para ORDER BY jm.Jem_Nombre ");

        return $post->fetchAll();
    }

    //Para monitoreo
    public function CapaPorPais($pais) {

        $para = "WHERE ISNULL(cm.Pai_IdPais)";

        $count = count($pais);
        if ($count) {
            $para = $para . " or cm.Pai_IdPais = " . $pais[0];
            for ($i = 1; $i < $count; $i++) {
                $para = $para . " or cm.Pai_IdPais = " . $pais[$i];
            }
        }
        //consultar varibles
        $post = $this->_db->query(
                "SELECT c.*,cm.jem_IdJerarquiaCapa,cm.pai_IdPais,tc.tic_Nombre FROM capas_monitoreo cm
INNER JOIN  capas c ON c.cap_Idcapa=cm.cap_Idcapa
INNER JOIN tipo_capa tc ON tc.tic_IdTipoCapa=c.tic_IdTipoCapa  $para ");

        return $post->fetchAll();
    }

    //Para monitoreo
    public function tiposCapasCompletoPorPais($pais) {

        $tipocapa = $this->tipoCapaPorPais($pais);
        $capa = $this->CapaPorPais($pais);
        for ($i = 0; $i < count($tipocapa); $i++) {
            $temp = array();
            for ($j = 0; $j < count($capa); $j++) {
                if ($tipocapa[$i]["jem_IdJerarquiaCapa"] == $capa[$j]["jem_IdJerarquiaCapa"]) {
                    $temp[$j] = $capa[$j];
                }
            }
            $tipocapa[$i]["capas"] = $temp;
        }
        return $tipocapa;
    }

    public function getmonitoreoCalidadXidRecurso($idrecurso, $condicion) {

        //consultar varibles
        $post = $this->_db->query(
                "SELECT mca.*,ve.Var_Nombre,ve.Var_Abreviatura,em.Esm_Nombre,em.Esm_Longitud,em.Esm_Latitud FROM monitoreo_calidad_agua mca 
                 INNER JOIN variables_estudio ve ON ve.Var_IdVariable = mca.Var_IdVariable 
                 INNER JOIN estacion_monitoreo em ON em.Esm_IdEstacionMonitoreo= mca.Esm_IdEstacionMonitoreo 
                 WHERE mca.Rec_IdRecurso=$idrecurso $condicion");
        return $post->fetchAll();
    }

    public function getmonitoreoCalidadAguaMetadata($condicion) {

        //consultar varibles
        $post = $this->_db->query(
                "SELECT mca.*,ve.Var_Nombre,ve.Var_Abreviatura,ve.Var_Medida,em.Esm_Nombre,em.Esm_Longitud,em.Esm_Latitud, p.*, ub.* 
                FROM monitoreo_calidad_agua mca 
                INNER JOIN variables_estudio ve ON ve.Var_IdVariable = mca.Var_IdVariable
                INNER JOIN pais p ON p.Pai_IdPais=mca.Pai_IdPais 
                INNER JOIN estacion_monitoreo em ON em.Esm_IdEstacionMonitoreo= mca.Esm_IdEstacionMonitoreo
                LEFT JOIN ubigeo ub ON em.Ubi_IdUbigeo=ub.Ubi_IdUbigeo $condicion");
        return $post->fetchAll();
    }

    public function getmonitoreoCalidadAguaMetadata2($condicion) {

        //consultar varibles
        $post = $this->_db->query(
                "SELECT mca.*,ve.Var_Nombre,ve.Var_Abreviatura,ve.Var_Medida,em.Esm_Nombre,em.Esm_Longitud,em.Esm_Latitud, p.*, ub.* 
                FROM monitoreo_calidad_agua mca 
                INNER JOIN variables_estudio ve ON ve.Var_IdVariable = mca.Var_IdVariable
                INNER JOIN pais p ON p.Pai_IdPais=mca.Pai_IdPais 
                INNER JOIN estacion_monitoreo em ON em.Esm_IdEstacionMonitoreo= mca.Esm_IdEstacionMonitoreo
                LEFT JOIN ubigeo ub ON em.Ubi_IdUbigeo=ub.Ubi_IdUbigeo $condicion");
        return $post->fetch();
    }

    public function getVariableMetadata($id_variable) {

        //consultar varibles
        $post = $this->_db->query(
                "SELECT * FROM variables_estudio ve INNER JOIN tipo_variable tv 
                ON ve.Tiv_IdTipoVariable=tv.Tiv_IdTipoVariable
                WHERE ve.Var_IdVariable = $id_variable");
        //ve.Var_Estado = 1 and
        return $post->fetchAll();
    }

    public function getEstacionMetadata($id_estacion) {
        //consultar estacion
        $post = $this->_db->query(
               "SELECT * FROM estacion_monitoreo WHERE Esm_IdEstacionMonitoreo=$id_estacion");
        //em.Esm_Estado=1
        return $post->fetchAll();
    }

    public function registrarRio($iRio_Nombre,$iPai_IdPais, $iRio_Estado=1, $iTia_IdTipoAgua=null) {
        try {
            $sql = "call s_i_rio(?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iRio_Nombre, PDO::PARAM_INT);
            $result->bindParam(2, $iRio_Estado, PDO::PARAM_INT);
            $result->bindParam(3, $iPai_IdPais, PDO::PARAM_STR);
            $result->bindParam(4, $iTia_IdTipoAgua, PDO::PARAM_STR);


            $result->execute();
            return $result->fetch();
        } catch (PDOException $exception) {
            $this->registrarBitacora("monitoreoModel", "registrarRio", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function _cambiarEstadoCalidadAgua($id_mca, $nuevo_estado)
    {
        $consulta = $this->_db->query(
            "UPDATE monitoreo_calidad_agua SET Mca_Estado = $nuevo_estado WHERE Mca_IdMonitoreoCalidadAgua= $id_mca"
            );        
        
        return $consulta->rowCount(PDO::FETCH_ASSOC);
    }

    public function eliminarCalidadAgua($id_mca) {
        try {
            
            $consulta = $this->_db->query(
                    "DELETE FROM monitoreo_calidad_agua WHERE Mca_IdMonitoreoCalidadAgua = $id_mca"
            );
            return $consulta->rowCount(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            $this->registrarBitacora("calidaddeagua(monitoreoModel)", "eliminarCalidadAgua", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    


}

?>
