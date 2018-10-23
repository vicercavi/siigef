<?php

class herramientaModel extends Model 
{
    public function __construct() 
    {
        parent::__construct();
    }

    public function getHerramienta($iHer_Nombre = "") 
    {
        try 
        {
            $iHer_Nombre = trim($iHer_Nombre);
            $sql = "call s_s_herramienta_sii(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iHer_Nombre, PDO::PARAM_STR);
            $result->execute();
            return $result->fetchAll();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getHerramientaTraducido($iHer_Nombre, $idIdioma) 
    {
        try 
        {
            $iHer_Nombre = trim($iHer_Nombre);
            $sql = "call s_s_herramienta_sii_traducido(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iHer_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $idIdioma, PDO::PARAM_STR);
            $result->execute();
            return $result->fetchAll();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getHerramientaXidTraducido($Her_IdHerramientaSii, $Idi_IddIdioma) 
    {
        try 
        {
            $sql = "call s_s_herramienta_sii_x_id_Traducido(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $Her_IdHerramientaSii, PDO::PARAM_STR);
            $result->bindParam(2, $Idi_IddIdioma, PDO::PARAM_STR);

            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getHerramientaXid($Her_IdHerramientaSii) 
    {
        try 
        {
            $sql = "call s_s_herramienta_sii_x_id(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $Her_IdHerramientaSii, PDO::PARAM_STR);

            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getHerramientaXAbrev($iHer_Abreviatura) 
    {
        try 
        {
            $sql = "call s_s_herramienta_sii_x_abrev(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iHer_Abreviatura, PDO::PARAM_STR);

            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getHerramientaXAbrevTraducido($iHer_Abreviatura, $idIdioma) 
    {
        try 
        {
            $sql = "call s_s_herramienta_sii_x_abrev_traducido(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iHer_Abreviatura, PDO::PARAM_STR);
            $result->bindParam(2, $idIdioma, PDO::PARAM_STR);
            $result->execute();
            return $result->fetch();
        }
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getEstructuraHXId($iEsh_IdEstructuraHerramienta) 
    {
        try 
        {
            $sql = "call s_s_estructura_h_x_id(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsh_IdEstructuraHerramienta, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getEstructuraHXIdTraducido($iEsh_IdEstructuraHerramienta, $iIdi_IdIdioma) 
    {
        try 
        {
            $sql = "call s_s_estructura_h_x_id_traducido(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsh_IdEstructuraHerramienta, PDO::PARAM_INT);
            $result->bindParam(2, $iIdi_IdIdioma, PDO::PARAM_STR);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getEstructuraHXH($iHer_IdHerramientaSii, $busqueda = "") 
    {
        try 
        {
            $sql = "call s_s_estructura_h_x_h(?,?)";

            $busqueda = trim($busqueda);

            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iHer_IdHerramientaSii, PDO::PARAM_INT);
            $result->bindParam(2, $busqueda, PDO::PARAM_STR);
            $result->execute();
            return $result->fetchAll();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getEstructuraHXHTraducido($iHer_IdHerramientaSii, $busqueda, $idIdioma) 
    {
        try 
        {
            $sql = "call s_s_estructura_h_x_h_traducido(?,?,?)";

            $busqueda = trim($busqueda);

            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iHer_IdHerramientaSii, PDO::PARAM_INT);
            $result->bindParam(2, $busqueda, PDO::PARAM_STR);
            $result->bindParam(3, $idIdioma, PDO::PARAM_STR);
            $result->execute();
            return $result->fetchAll();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getRecursoXEH($iEsh_IdEstructuraHerramienta, $busqueda = "") 
    {
        try 
        {
            $busqueda = trim($busqueda);
            $sql = "call s_s_recurso_x_h(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsh_IdEstructuraHerramienta, PDO::PARAM_INT);
            $result->bindParam(2, $busqueda, PDO::PARAM_STR);
            $result->execute();
            return $result->fetchall();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getRecursoDispobibleXEH($iEsh_IdEstructuraHerramienta, $idEstandarRecurso = null, $busqueda = "") 
    {
        try 
        {
            if (empty($idEstandarRecurso)) 
            {
                $idEstandarRecurso = null;
            }

            $busqueda = trim($busqueda);

            $sql = "call s_s_recurso_disponible_x_h(?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsh_IdEstructuraHerramienta, PDO::PARAM_INT);
            $result->bindParam(2, $idEstandarRecurso, PDO::PARAM_INT | PDO::PARAM_NULL);
            $result->bindParam(3, $busqueda, PDO::PARAM_STR);
            $result->execute();
            return $result->fetchall();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function getBitacoraHerramienta() 
    {
        try 
        {
            $id_registro = "";
            $sql = "Select * from bitacora_herramienta";
            $result = $this->_db->prepare($sql);
           
            $result->execute();
            return $result->fetchAll();
        } 
        catch (PDOException $exception) 
        {
            $this->insertarBitacora("Error al Listar Bitacota Herramienta", "MySql", Session::get('usuario'), $exception->getFile(), "listarCapaWms", $exception->getMessage(), 1);

            return $exception->getMessage();
        }
    }
    
    public function insertarBitacoraHerramienta(
    $iBih_IpUsuario, $iBih_So, $iBih_Navegador, $iHer_Herramienta, $iBih_Metodo, $iBih_Parametros, $iBih_TiempoConsultaSegundos
    ) 
    {
        try 
        {
            $id_registro = "";
            $sql = "call s_i_bitacora_herramienta(?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iBih_IpUsuario, PDO::PARAM_STR);
            $result->bindParam(2, $iBih_So, PDO::PARAM_STR);
            $result->bindParam(3, $iBih_Navegador, PDO::PARAM_STR);
            $result->bindParam(4, $iHer_Herramienta, PDO::PARAM_INT);
            $result->bindParam(5, $iBih_Metodo, PDO::PARAM_STR);
            $result->bindParam(6, $iBih_Parametros, PDO::PARAM_STR);
            $result->bindParam(7, $iBih_TiempoConsultaSegundos, PDO::PARAM_STR);
            $result->execute();
            return $result->fetch();
        } 
        catch (PDOException $exception) 
        {
            $this->insertarBitacora("Ocurrio un error al Insertar Bitacora Herramienta : Parametros: " . json_encode(array($iBih_IpUsuario, $iBih_Navegador, $iHer_Herramienta, $iBih_Metodo, $iBih_Parametros)), "MySql", Session::get('usuario'), $exception->getFile(), "listarCapaWms", $exception->getMessage(), 1);

            return $exception->getMessage();
        }
    }

    public function insertarHerramienta(
    $iHer_Nombre, $iHer_Descripcion, $iHer_Abreviatura, $iHer_Estado, $iIdi_IdIdioma
    ) 
    {
        try 
        {
            $id_registro = "";
            $sql = "call s_i_herramienta_sii(?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iHer_Nombre, PDO::PARAM_STR);
            $result->bindParam(2, $iHer_Descripcion, PDO::PARAM_STR);
            $result->bindParam(3, $iHer_Abreviatura, PDO::PARAM_STR);
            $result->bindParam(4, $iHer_Estado, PDO::PARAM_STR);
            $result->bindParam(5, $iIdi_IdIdioma, PDO::PARAM_STR);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function actualizarHerramienta($iHer_IdHerramientaSii, $iHer_Nombre, $iHer_Descripcion, $iHer_Abreviatura, $iHer_Estado, $iIdi_IdIdioma) 
    {
        try 
        {
            $id_registro = "";
            $sql = "call s_u_herramienta_sii(?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iHer_IdHerramientaSii, PDO::PARAM_STR);
            $result->bindParam(2, $iHer_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iHer_Descripcion, PDO::PARAM_STR);
            $result->bindParam(4, $iHer_Abreviatura, PDO::PARAM_STR);
            $result->bindParam(5, $iHer_Estado, PDO::PARAM_STR);
            $result->bindParam(6, $iIdi_IdIdioma, PDO::PARAM_STR);
            $result->execute();
            return $result->rowCount();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function actualizarHerramientaCompleto($iHer_IdHerramientaSii, $iHer_Nombre, $iHer_Descripcion, $iHer_Abreviatura, $iHer_Estado, $iIdi_IdIdioma) 
    {
        $bdarquitectura = $this->loadModel("index", "arquitectura");

        $herramienta = $this->getHerramientaXid($iHer_IdHerramientaSii);

        if ($herramienta["Idi_IdIdioma"] == $iIdi_IdIdioma) 
        {
            $this->actualizarHerramienta($iHer_IdHerramientaSii, $iHer_Nombre, $iHer_Descripcion, $iHer_Abreviatura, $iHer_Estado, $iIdi_IdIdioma);
        } 
        else 
        {
            $Her_Nombre = $bdarquitectura->buscarCampoTraducido("herramienta_sii", $iHer_IdHerramientaSii, "Her_Nombre", $iIdi_IdIdioma);
            $Her_Descripcion = $bdarquitectura->buscarCampoTraducido("herramienta_sii", $iHer_IdHerramientaSii, "Her_Descripcion", $iIdi_IdIdioma);

            if (isset($Her_Nombre["Idi_IdIdioma"]) && !empty($Her_Nombre["Idi_IdIdioma"])) 
            {
                $bdarquitectura->actualizarTraduccion($Her_Nombre["Cot_IdContenidoTraducido"], $Her_Nombre["Cot_Tabla"], $Her_Nombre["Cot_IdRegistro"], $Her_Nombre["Cot_Columna"], $Her_Nombre["Idi_IdIdioma"], $iHer_Nombre);
            }
            else 
            {
                $Her_Nombre = array();
                $Her_Nombre["Cot_IdContenidoTraducido"] = $bdarquitectura->registrarTraduccion("herramienta_sii", $iHer_IdHerramientaSii, "Her_Nombre", $iIdi_IdIdioma, $iHer_Nombre);
            }

            if (isset($Her_Descripcion["Idi_IdIdioma"]) && !empty($Her_Descripcion["Idi_IdIdioma"])) 
            {
                $bdarquitectura->actualizarTraduccion($Her_Descripcion["Cot_IdContenidoTraducido"], $Her_Descripcion["Cot_Tabla"], $Her_Descripcion["Cot_IdRegistro"], $Her_Descripcion["Cot_Columna"], $Her_Descripcion["Idi_IdIdioma"], $iHer_Descripcion);
            } 
            else 
            {
                $Her_Descripcion = array();
                $Her_Descripcion["Cot_IdContenidoTraducido"] = $bdarquitectura->registrarTraduccion("herramienta_sii", $iHer_IdHerramientaSii, "Her_Descripcion", $iIdi_IdIdioma, $iHer_Descripcion);
            }
        }
    }

    public function actualizarEstadoHerramienta($iHer_IdHerramientaSii, $iHer_Estado) 
    {
        try 
        {
            $id_registro = "";
            $sql = "call s_u_estado_herramienta_sii(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iHer_IdHerramientaSii, PDO::PARAM_INT);
            $result->bindParam(2, $iHer_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function actualizarUrlMenuHerramienta($iHer_IdHerramientaSii, $iHer_UrlMenu) 
    {
        try 
        {
            $id_registro = "";
            $sql = "call s_u_url_menu_herramienta_sii(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iHer_IdHerramientaSii, PDO::PARAM_INT);
            $result->bindParam(2, $iHer_UrlMenu, PDO::PARAM_STMT);
            $result->execute();
            return $result->rowCount();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function insertarEstructuraH($iHer_IdHerramientaSii, $iEsh_IdPadre, $iEsh_Nombre, $iEsh_Titulo, $iEsh_Descripcion, $iEsh_ColumnaConsulta, $iEsh_Orden, $iEsh_Estado, $iEsh_Predeterminado, $iIdi_IdIdioma) 
    {
        try 
        {
            if (empty($iEsh_IdPadre)) 
            {
                $iEsh_IdPadre = null;
            }

            $id_registro = "";
            $sql = "call s_i_estructura_herramienta(?,?,?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iHer_IdHerramientaSii, PDO::PARAM_INT);
            $result->bindParam(2, $iEsh_IdPadre, PDO::PARAM_NULL | PDO::PARAM_INT);
            $result->bindParam(3, $iEsh_Nombre, PDO::PARAM_STR);
            $result->bindParam(4, $iEsh_Titulo, PDO::PARAM_STR);
            $result->bindParam(5, $iEsh_Descripcion, PDO::PARAM_STR);
            $result->bindParam(6, $iEsh_ColumnaConsulta, PDO::PARAM_STR);
            $result->bindParam(7, $iEsh_Orden, PDO::PARAM_INT);
            $result->bindParam(8, $iEsh_Estado, PDO::PARAM_INT);
            $result->bindParam(9, $iEsh_Predeterminado, PDO::PARAM_INT);
            $result->bindParam(10, $iIdi_IdIdioma, PDO::PARAM_STR);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function insertarArbolEstructuraH($iHer_IdHerramientaSii, $iEsh_IdPadre, $arbol, $iEsh_Estado, $iEsh_Predeterminado, $iIdi_IdIdioma
    ) 
    {
        for ($index = 0; $index < count($arbol); $index++) 
        {
            $idregistro = array(0);
            if (isset($arbol[$index]) && isset($arbol[$index][0]) && !empty($arbol[$index][0])) 
            {
                $idregistro = $this->insertarEstructuraH($iHer_IdHerramientaSii, $iEsh_IdPadre, $arbol[$index][0], $arbol[$index][1], $arbol[$index][0], "Esh_ColumnaConsulta", ($index + 1), $iEsh_Estado, $iEsh_Predeterminado, $iIdi_IdIdioma);

                if (isset($idregistro) && $idregistro[0] && isset($arbol[$index]["hijo"]) && count($arbol[$index]["hijo"])) 
                {
                    $this->insertarArbolEstructuraH($iHer_IdHerramientaSii, $idregistro[0], $arbol[$index]["hijo"], $iEsh_Estado, $iEsh_Predeterminado, $iIdi_IdIdioma);
                }
            }
        }
    }

    public function actualizarEstructuraH($iEsh_IdEstructuraHerramienta, $iEsh_Nombre, $iEsh_Titulo, $iEsh_Descripcion, $iEsh_ColumnaConsulta, $iEsh_Orden, $iEsh_Estado, $iEsh_Predeterminado, $iIdi_IdIdioma) 
    {
        try 
        {
            $id_registro = "";
            $sql = "call s_u_estructura_herramienta(?,?,?,?,?,?,?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsh_IdEstructuraHerramienta, PDO::PARAM_INT);
            $result->bindParam(2, $iEsh_Nombre, PDO::PARAM_STR);
            $result->bindParam(3, $iEsh_Titulo, PDO::PARAM_STR);
            $result->bindParam(4, $iEsh_Descripcion, PDO::PARAM_STR);
            $result->bindParam(5, $iEsh_ColumnaConsulta, PDO::PARAM_STR);
            $result->bindParam(6, $iEsh_Orden, PDO::PARAM_INT);
            $result->bindParam(7, $iEsh_Estado, PDO::PARAM_INT);
            $result->bindParam(8, $iEsh_Predeterminado, PDO::PARAM_INT);
            $result->bindParam(9, $iIdi_IdIdioma, PDO::PARAM_STR);
            $result->execute();
            return $result->rowCount();
        } 
        catch (PDOException $exception) 
        {
            $this->insertarBitacora("Ocurrio un error al actualizar estructura : Parametros: " . json_encode(array($iEsh_IdEstructuraHerramienta, $iEsh_Nombre, $iEsh_Titulo, $iEsh_Descripcion, $iEsh_Orden)), "MySql", Session::get('usuario'), $exception->getFile(), "listarCapaWms", $exception->getMessage(), 1);

            return $exception->getMessage();
        }
    }

    public function actualizarEstructuraHCompleto($iEsh_IdEstructuraHerramienta, $iEsh_Nombre, $iEsh_Titulo, $iEsh_Descripcion, $iEsh_ColumnaConsulta, $iEsh_Orden, $iEsh_Estado, $iEsh_Predeterminado, $iIdi_IdIdioma) 
    {
        $bdarquitectura = $this->loadModel("index", "arquitectura");

        $herramienta = $this->getEstructuraHXId($iEsh_IdEstructuraHerramienta);

        if ($herramienta["Idi_IdIdioma"] == $iIdi_IdIdioma) 
        {
            $this->actualizarEstructuraH(
                    $iEsh_IdEstructuraHerramienta, $iEsh_Nombre, $iEsh_Titulo, $iEsh_Descripcion, $iEsh_ColumnaConsulta, $iEsh_Orden, $iEsh_Estado, $iEsh_Predeterminado, $iIdi_IdIdioma
            );
        } 
        else 
        {
            $Esh_Titulo = $bdarquitectura->buscarCampoTraducido("estructura_herramienta", $iEsh_IdEstructuraHerramienta, "Esh_Titulo", $iIdi_IdIdioma);
            $Esh_Nombre = $bdarquitectura->buscarCampoTraducido("estructura_herramienta", $iEsh_IdEstructuraHerramienta, "Esh_Nombre", $iIdi_IdIdioma);
            $Esh_Descripcion = $bdarquitectura->buscarCampoTraducido("estructura_herramienta", $iEsh_IdEstructuraHerramienta, "Esh_Descripcion", $iIdi_IdIdioma);


            if (isset($Esh_Titulo["Idi_IdIdioma"]) && !empty($Esh_Titulo["Idi_IdIdioma"])) {
                $bdarquitectura->actualizarTraduccion($Esh_Titulo["Cot_IdContenidoTraducido"], $Esh_Titulo["Cot_Tabla"], $Esh_Titulo["Cot_IdRegistro"], $Esh_Titulo["Cot_Columna"], $Esh_Titulo["Idi_IdIdioma"], $iEsh_Titulo);
            }
            else 
            {
                $Esh_Titulo = array();
                $Esh_Titulo["Cot_IdContenidoTraducido"] = $bdarquitectura->registrarTraduccion("estructura_herramienta", $iEsh_IdEstructuraHerramienta, "Esh_Titulo", $iIdi_IdIdioma, $iEsh_Titulo);
            }

            if (isset($Esh_Nombre["Idi_IdIdioma"]) && !empty($Esh_Nombre["Idi_IdIdioma"])) 
            {
                $bdarquitectura->actualizarTraduccion($Esh_Nombre["Cot_IdContenidoTraducido"], $Esh_Nombre["Cot_Tabla"], $Esh_Nombre["Cot_IdRegistro"], $Esh_Nombre["Cot_Columna"], $Esh_Nombre["Idi_IdIdioma"], $iEsh_Nombre);
            } 
            else 
            {
                $Esh_Nombre = array();
                $Esh_Nombre["Cot_IdContenidoTraducido"] = $bdarquitectura->registrarTraduccion("estructura_herramienta", $iEsh_IdEstructuraHerramienta, "Esh_Nombre", $iIdi_IdIdioma, $iEsh_Nombre);
            }
            /*   if (isset($Esh_Descripcion["Idi_IdIdioma"]) && !empty($Esh_Descripcion["Idi_IdIdioma"])) {
              $bdarquitectura->actualizarTraduccion($Esh_Descripcion["Cot_IdContenidoTraducido"], $Esh_Descripcion["Cot_Tabla"], $Esh_Descripcion["Cot_IdRegistro"], $Esh_Descripcion["Cot_Columna"], $Esh_Descripcion["Idi_IdIdioma"], $iEsh_Descripcion);
              } else {
              $Esh_Descripcion = array();
              $Esh_Descripcion["Cot_IdContenidoTraducido"] = $bdarquitectura->registrarTraduccion("estructura_herramienta", $iEsh_IdEstructuraHerramienta, "Esh_Descripcion", $iIdi_IdIdioma, $iEsh_Descripcion);
              } */
        }
    }

    public function actualizarEstadoEstructuraH($iEsh_IdEstructuraHerramienta, $iEsh_Estado) 
    {
        try 
        {
            $id_registro = "";
            $sql = "call s_u_estado_estructura_herramienta(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsh_IdEstructuraHerramienta, PDO::PARAM_INT);
            $result->bindParam(2, $iEsh_Estado, PDO::PARAM_INT);
            $result->execute();
            return $result->rowCount();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function listarArbolEstructuraH($idpadre = null) 
    {
        $padre = $this->listarEstructuraHXidpadre($idpadre);

        for ($i = 0; $i < count($padre); $i++) 
        {
            $idjerarqui = $padre[$i]["Esh_IdEstructuraHerramienta"];
            $temp = $this->listarArbolEstructuraH(($idjerarqui));
            $padre[$i]["hijo"] = $temp;
        }

        return $padre;
    }

    public function listarArbolArbolEstructuraHVisor($idherramienta, $idpadre = null) 
    {
        $padre = $this->listarEstructuraHCompletoXidpadre($idherramienta, $idpadre);

        $bdcapa = $this->loadModel("mapa");

        for ($i = 0; $i < count($padre); $i++) 
        {
            $id = $padre[$i]["Esh_IdEstructuraHerramienta"];
            $tempx = $this->getRecursoXEH($id);
            for ($j = 0; $j < count($tempx); $j++) 
            {
                if ($tempx[$j]["Tir_Nombre"] == "Mapa") 
                {
                    $tempx[$j]["capas"] = $bdcapa->CapasCompletoXIdrecurso($tempx[$j]["Rec_IdRecurso"]);
                } 
                else if ($tempx[$j]["Tir_Nombre"] == "Tabular") 
                {
                    if ($tempx[$j]["Esr_NombreTabla"] == "monitoreo_calidad_agua") 
                    {
                        $bdmonitoreo = $this->loadModel("monitoreo","calidaddeagua");
                        //$tempx["menu-ca"] = $bdmonitoreo->tiposParamCompletoPorpais();
                    }
                }

                break;
            }

            $padre[$i]["recurso"] = $tempx;
            $temph = $this->listarArbolArbolEstructuraHVisor($idherramienta, $id);
            $padre[$i]["hijo"] = $temph;
        }

        return $padre;
    }

    public function listarPadreArbolEstructuraHVisor($idherramienta, $idpadre, $ididioma) 
    {
        $padre = $this->listarEstructuraHCompletoXidpadre($idherramienta, $idpadre, $ididioma);

        return $this->armarEstructuraCompleto($padre);
    }

    public function listarEhPredeterminadoCompleto($idherramienta) 
    {
        $padre = $this->listarEhPredeterminado($idherramienta);

        return $this->armarEstructuraCompleto($padre);
    }

    public function armarEstructuraCompleto($padre) 
    {
	$bdcapa = $this->loadModel("mapa");
        for ($i = 0; $i < count($padre); $i++) 
        {
            $id = $padre[$i]["Esh_IdEstructuraHerramienta"];
            $tempx = $this->getRecursoXEH($id);
            for ($j = 0; $j < count($tempx); $j++) 
            {
                if ($tempx[$j]["Tir_Nombre"] == "Mapa") 
                {
                    $tempx[$j]["capas"] = $bdcapa->CapasCompletoXIdrecurso($tempx[$j]["Rec_IdRecurso"]);
                } else if ($tempx[$j]["Tir_Nombre"] == "Tabular") 
                {
                    if ($tempx[$j]["Esr_NombreTabla"] == "monitoreo_calidad_agua") 
                    {
                        $bdmonitoreo = $this->loadModel("monitoreo","calidaddeagua");
                        //$tempx["menu-ca"] = $bdmonitoreo->tiposParamCompletoPorpais();
                    }
                }

                break;
            }
            $padre[$i]["recurso"] = $tempx;
            // $temph = $this->listarArbolArbolEstructuraHVisor($idherramienta, $id);
            // $padre[$i]["hijo"] = $temph;
        }
        return $padre;
    }

    public function buscarEspecieenHE($idherramienta, $nombrecientifico) 
    {
        $padre = $this->buscarEspecie($idherramienta, $nombrecientifico);

        return $this->armarEstructuraCompleto($padre);
    }

    public function listarEstructuraHCompletoXidpadre($idherramienta, $idpadre, $idIdioma) 
    {
        try 
        {
            if (empty($idpadre)) 
            {
                $idpadre = null;
            }

            $sql = "call s_s_estructura_herramienta_completo_idpadre(?,?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $idherramienta, PDO::PARAM_INT);
            $result->bindParam(2, $idpadre, PDO::PARAM_NULL | PDO::PARAM_INT);
            $result->bindParam(3, $idIdioma, PDO::PARAM_STR);
            $result->execute();
            return $result->fetchAll();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function listarEhPredeterminado($idherramienta) 
    {
        try 
        {
            $sql = "call s_s_estructura_herramienta_predeterminado(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $idherramienta, PDO::PARAM_INT);
            $result->execute();
            return $result->fetchAll();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function buscarEspecie($idherramienta, $nc) 
    {
        try 
        {
            if (empty($idpadre)) 
            {
                $idpadre = null;
            }

            $sql = "call s_s_buscar_especie_nh(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $idherramienta, PDO::PARAM_INT);
            $result->bindParam(2, $nc, PDO::PARAM_STR);
            $result->execute();
            return $result->fetchAll();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function listarEstructuraHXidpadre($idpadre = null, $busqueda = "") 
    {
        try 
        {
            if (empty($idpadre)) 
            {
                $idpadre = null;
            }

            $busqueda = trim($busqueda);
            $sql = "call s_s_estructura_herramienta_idpadre(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $idpadre, PDO::PARAM_NULL | PDO::PARAM_INT);
            $result->bindParam(2, $busqueda, PDO::PARAM_STR);
            $result->execute();
            return $result->fetchAll();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function eliminarEstructuraCompleto($iEsh_IdEstructuraHerramienta) 
    {
        $hijos = $this->listarArbolEstructuraH($iEsh_IdEstructuraHerramienta);

        foreach ($hijos as $item) 
        {
            $this->eliminarEstructuraXid($item["Esh_IdEstructuraHerramienta"]);
        }

        $this->eliminarEstructuraXid($iEsh_IdEstructuraHerramienta);
    }

    public function eliminarEstructuraXid($iEsh_IdEstructuraHerramienta) 
    {
        try 
        {
            $sql = "call s_d_estructura_herramienta_x_id(?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsh_IdEstructuraHerramienta, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function insertarEstructurah_Recurso($iEsh_IdEstructuraHerramienta, $iRec_IdRecurso) 
    {
        try 
        {
            $id_registro = "";
            $sql = "call s_i_eh_recurso(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsh_IdEstructuraHerramienta, PDO::PARAM_INT);
            $result->bindParam(2, $iRec_IdRecurso, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function eliminarEstructurah_Recurso($iEsh_IdEstructuraHerramienta, $iRec_IdRecurso)
    {
        try 
        {
            $id_registro = "";
            $sql = "call s_d_eh_recurso(?,?)";
            $result = $this->_db->prepare($sql);
            $result->bindParam(1, $iEsh_IdEstructuraHerramienta, PDO::PARAM_INT);
            $result->bindParam(2, $iRec_IdRecurso, PDO::PARAM_INT);
            $result->execute();
            return $result->fetch();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function RecursoDarwin() 
    {
        try 
        {
            $sql = $this->_db->query(
                    "SELECT Rec_IdRecurso FROM recurso WHERE Esr_IdEstandarRecurso=6");
            return $sql->fetchAll();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function Especies() 
    {
        try 
        {
            $sql = $this->_db->query("SELECT Esh_IdEstructuraHerramienta FROM estructura_herramienta
                WHERE TRIM(Esh_Titulo) = 'N.C.'");
            return $sql->fetchAll();
        } 
        catch (Exception $exc) 
        {
            return $exc->getTraceAsString();
        }
    }

    public function asinacionMultipleRecurso() 
    {

        $especies = $this->Especies();
        $recursoDarwin = $this->RecursoDarwin();

        foreach ($especies as $itemes) 
        {
            foreach ($recursoDarwin as $itemrec) 
            {
                $this->insertarEstructurah_Recurso($itemes["Esh_IdEstructuraHerramienta"], $itemrec["Rec_IdRecurso"]);
            }
        }
    }
}

?>
