<?php

class indexModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTablasBD() 
    {
        try
        {
            $esr = $this->_db->query(
                "SHOW FULL TABLES FROM siigef"
            );
            return $esr->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "getTablasBD", "Error Model", $exception);
            return $exception->getTraceAsString();
        }     
    }

    public function getTablasGeneradas() 
    {
        try
        {
            $esr = $this->_db->query("SELECT est.* FROM estandar_recurso est WHERE EXISTS (SELECT Table_Name FROM information_schema.TABLES WHERE Table_Name=est.Esr_NombreTabla AND TABLE_SCHEMA='siigef')"
            );

            return $esr->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "getTablasGeneradas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }     
    }

    public function consultaEstandar($Esr_NombreTabla) 
    {
        try
        {
            $esr = $this->_db->query(
                "select * from $Esr_NombreTabla limit 5"
            );
            return $esr->fetchAll();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "consultaEstandar", "Error Model", $exception);
            return $exception->getTraceAsString();
        }  
    }

    public function getEstandar_recurso($condicion = '')
    {
        try
        {
            $esr = $this->_db->query("select * from estandar_recurso $condicion");

            return $esr->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "getEstandar_recurso", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    public function getEstandar_recurso2($condicion = '')
    {
        try
        {
            $esr = $this->_db->query("select * from estandar_recurso $condicion");
            return $esr->fetch(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "getEstandar_recurso2", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    
    public function registrarEstandar($Esr_Nombre, $Esr_NombreTabla,$Esr_Estado,$Idi_IdIdioma, $Esr_Descripcion, $Esr_Tipo)
    {
        try
        {
            $sql = "call s_i_estandar_recurso(?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $Esr_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $Esr_NombreTabla, PDO::PARAM_STR);
            $result->bindParam(3, $Esr_Estado, PDO::PARAM_INT);
            $result->bindParam(4, $Idi_IdIdioma, PDO::PARAM_STR);
            $result->bindParam(5, $Esr_Descripcion, PDO::PARAM_STR);
            $result->bindParam(6, $Esr_Tipo, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);            
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "registrarEstandar", "Error Model", $exception);
            return $exception->getTraceAsString();
        }                
    }
    
    public function verificarEstandar($Esr_NombreTabla)
    {
        try
        {
            $esr = $this->_db->query(
                "select Esr_IdEstandarRecurso from estandar_recurso where Esr_NombreTabla = '$Esr_NombreTabla'"
            );
            return $esr->fetch(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "verificarEstandar", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    
    public function getFicha_Estandar($Esr_IdEstandarRecurso, $condicion = '') 
    {
        try
        {
            $esr = $this->_db->query(
                "select * from ficha_estandar where Esr_IdEstandarRecurso = $Esr_IdEstandarRecurso  $condicion"
            );
            return $esr->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "getFicha_Estandar", "Error Model", $exception);
            return $exception->getTraceAsString();
        } 
    }
    
    public function getFicha_Variable($nombre_tabla, $nombre_tabla)
    {
        try
        {
            $esr = $this->_db->query("SELECT * FROM $nombre_tabla");
            return $esr->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $exception)
        {
            $this->registrarBitacora("estandar(indexModel)", "getFicha_Variable", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getFicha_Data($nombre_tabla)
    {
        try
        {
            $esr = $this->_db->query("SELECT * FROM $nombre_tabla");
            return $esr->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $exception)
        {
            $this->registrarBitacora("estandar(indexModel)", "getFicha_Data", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    public function getFicha_Estandar2($Fie_IdFichaEstandar) 
    {
        try
        {
            $esr = $this->_db->query(
                "select * from ficha_estandar where Fie_IdFichaEstandar = $Fie_IdFichaEstandar "
            );
            return $esr->fetch(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "getFicha_Estandar2", "Error Model", $exception);
            return $exception->getTraceAsString();
        } 
    }
    
    public function getFichaTraducida($condicion1 = "",$Idi_IdIdioma) 
    {
        try
        {
            $esr = $this->_db->query(
                "select "
                    . "fie.Fie_IdFichaEstandar,"
                    . "fn_TraducirContenido('ficha_estandar','Fie_CampoFicha',fie.Fie_IdFichaEstandar,'$Idi_IdIdioma',fie.Fie_CampoFicha) Fie_CampoFicha,"
                    . "fie.Esr_IdEstandarRecurso,"
                    . "fie.Fie_TipoDatoCampo,"
                    . "fie.Fie_TamanoColumna,"
                    . "fie.Fie_ColumnaObligatorio,"
                    . "fie.Fie_ColumnaTraduccion,"
                    . "fie.Fie_ColumnaTipo,"
                    . "fn_devolverIdioma('ficha_estandar',fie.Fie_IdFichaEstandar,'$Idi_IdIdioma',fie.Idi_IdIdioma) Idi_IdIdioma"
                    . " from ficha_estandar fie $condicion1 "
            );
            return $esr->fetch(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "getFichaTraducida", "Error Model", $exception);
            return $exception->getTraceAsString();
        } 
    }
    
    public function registrarFicha_Estandar($Fie_CampoFicha, $Esr_IdEstandarRecurso, $Fie_NombreTabla, $Fie_TipoDatoCampo, $Fie_TamanoColumna, $Fie_ColumnaTabla, $Fie_ColumnaObligatorio, $Fie_ColumnaTraduccion, $Fie_ColumnaTipo, $Idi_IdIdioma)
    {
        try
        {
            $sql = "call s_i_ficha_estandar(?,?,?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $Fie_CampoFicha, PDO::PARAM_STR);
            $result->bindParam(2, $Esr_IdEstandarRecurso, PDO::PARAM_INT);
            $result->bindParam(3, $Fie_NombreTabla, PDO::PARAM_STR);
            $result->bindParam(4, $Fie_TipoDatoCampo, PDO::PARAM_STR);
            $result->bindParam(5, $Fie_TamanoColumna, PDO::PARAM_STR);
            $result->bindParam(6, $Fie_ColumnaTabla, PDO::PARAM_STR);
            $result->bindParam(7, $Fie_ColumnaObligatorio, PDO::PARAM_INT);
            $result->bindParam(8, $Fie_ColumnaTraduccion, PDO::PARAM_INT);
            $result->bindParam(9, $Fie_ColumnaTipo, PDO::PARAM_STR);
            $result->bindParam(10, $Idi_IdIdioma , PDO::PARAM_STR);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);            
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "registrarFicha_Estandar", "Error Model", $exception);
            return $exception->getTraceAsString();
        }                
    }
    
    public function actualizarFicha_Estandar($Fie_IdFichaEstandar, $Fie_CampoFicha, $Esr_IdEstandarRecurso, $Fie_NombreTabla, $Fie_TipoDatoCampo, $Fie_TamanoColumna, $Fie_ColumnaTabla, $Fie_ColumnaObligatorio, $Fie_ColumnaTraduccion, $Fie_ColumnaTipo, $Idi_IdIdioma)
    {
        try
        {
            $sql = "call s_u_ficha_estandar(?,?,?,?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $Fie_CampoFicha, PDO::PARAM_STR);
            $result->bindParam(2, $Esr_IdEstandarRecurso, PDO::PARAM_INT);
            $result->bindParam(3, $Fie_NombreTabla, PDO::PARAM_STR);
            $result->bindParam(4, $Fie_TipoDatoCampo, PDO::PARAM_STR);
            $result->bindParam(5, $Fie_TamanoColumna, PDO::PARAM_STR);
            $result->bindParam(6, $Fie_ColumnaTabla, PDO::PARAM_STR);
            $result->bindParam(7, $Fie_ColumnaObligatorio, PDO::PARAM_INT);
            $result->bindParam(8, $Fie_ColumnaTraduccion, PDO::PARAM_INT);
            $result->bindParam(9, $Fie_ColumnaTipo, PDO::PARAM_STR);
            $result->bindParam(10, $Idi_IdIdioma , PDO::PARAM_STR);
            $result->bindParam(11, $Fie_IdFichaEstandar, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount(PDO::FETCH_ASSOC);            
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "actualizarFicha_Estandar", "Error Model", $exception);
            return $exception->getTraceAsString();
        }                
    }
    public function editarTraduccionFicha($Cot_Traduccion, $Cot_IdRegistro, $Idi_IdIdioma) 
    {
        $ContTradNombre = $this->buscarCampoTraducido('ficha_estandar', $Cot_IdRegistro, 'Fie_CampoFicha', $Idi_IdIdioma);
        
        $Cot_IdContenidoTraducido = $ContTradNombre['Cot_IdContenidoTraducido'];        

        if (isset($Cot_IdContenidoTraducido)) 
        {
            $this->_db->query(
                    "UPDATE contenido_traducido SET Cot_Traduccion = '$Cot_Traduccion' WHERE Cot_IdContenidoTraducido = $Cot_IdContenidoTraducido"
            );
        } 
        else 
        {
            $this->_db->prepare(
                            "INSERT INTO contenido_traducido VALUES (null, 'ficha_estandar', :Cot_IdRegistro, 'Fie_CampoFicha' , :Idi_IdIdioma, :Cot_Traduccion)"
                    )
                    ->execute(array(
                        ':Cot_IdRegistro' => $Cot_IdRegistro,
                        ':Idi_IdIdioma' => $Idi_IdIdioma,
                        ':Cot_Traduccion' => $Cot_Traduccion
            ));
        }
    }
    
    public function buscarCampoTraducido($tabla, $Cot_IdRegistro, $Cot_Columna, $Idi_IdIdioma) 
    {
        try
        {
            $post = $this->_db->query(
                    "SELECT * FROM contenido_traducido WHERE Cot_Tabla = '$tabla' AND Cot_IdRegistro =  $Cot_IdRegistro AND  Cot_Columna = '$Cot_Columna' AND Idi_IdIdioma= '$Idi_IdIdioma'");
            return $post->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "buscarCampoTraducido", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }    
    
    public function verificarFichaEstandar($Fie_CampoFicha,$Esr_IdEstandarRecurso)
    {
        try
        {
            $esr = $this->_db->query(
                "SELECT Fie_IdFichaEstandar FROM ficha_estandar WHERE Esr_IdEstandarRecurso = $Esr_IdEstandarRecurso AND Fie_CampoFicha = '$Fie_CampoFicha'"
            );
            return $esr->fetch(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "verificarFichaEstandar", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }

    public function eliminarRegistroFicha($Fie_IdFichaEstandar)
    {
        try
        {
            $esr = $this->_db->query(
                "DELETE FROM ficha_estandar WHERE Fie_IdFichaEstandar = $Fie_IdFichaEstandar  "
            );
            return $esr->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "eliminarRegistroFicha", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    
    public function eliminarRegistroEstandar($Esr_IdEstandarRecurso)
    {
        try
        {
            $esr = $this->_db->query(
                "DELETE FROM ficha_estandar WHERE Esr_IdEstandarRecurso = $Esr_IdEstandarRecurso  "
            );
            return $esr->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "eliminarRegistroEstandar", "Error Model", $exception);
            return $exception->getTraceAsString();
        }        
    }
    
    public function generarTablaEstandar($tabla) 
    {
        try
        {
           //echo $tabla; exit;
            $result = $this->_db->prepare($tabla);
            $result->execute();
            
           // return $result->rowCount(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "generarTablaEstandar", "Error Model", $exception);
            return $exception->getTraceAsString();
        }    
    }    
    
    public function getIdiomas() 
    {
        try
        {
            $idiomas = $this->_db->query(
                    "select * from idioma where Idi_Estado = 1"
            );
            return $idiomas->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $exception) 
        {
            $this->registrarBitacora("estandar(indexModel)", "getIdiomas", "Error Model", $exception);
            return $exception->getTraceAsString();
        }
    }

    
}
